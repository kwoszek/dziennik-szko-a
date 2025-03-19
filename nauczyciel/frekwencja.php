<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_nauczyciel();

$nauczyciel_id = get_user_id();
$error_message = '';
$success_message = '';


$query_przedmioty = "SELECT p.id, p.nazwa_przedmiotu
                     FROM uzytkownicy u
                     JOIN przedmioty p ON u.przedmiot_id = p.id
                     WHERE u.id = ?";
$stmt_przedmioty = $conn->prepare($query_przedmioty);
$stmt_przedmioty->execute([$nauczyciel_id]);
$przedmioty_nauczyciela = $stmt_przedmioty->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['zapisz_frekwencje'])) {
    $data_lekcji = sanitize_input($_POST['data_lekcji']);
    $przedmiot_id = sanitize_input($_POST['przedmiot_id']);
    $klasa_id = sanitize_input($_POST['klasa_id']);
    $frekwencja_dane = $_POST['frekwencja'];

    try {
        $conn->beginTransaction();
        foreach ($frekwencja_dane as $uczen_id => $status) {
            $status = sanitize_input($status);
            $query_frekwencja = "INSERT INTO frekwencja (uczen_id, przedmiot_id, data_lekcji, status) VALUES (?, ?, ?, ?)
                                  ON DUPLICATE KEY UPDATE status = ?"; 
            $stmt_frekwencja = $conn->prepare($query_frekwencja);
            $stmt_frekwencja->execute([$uczen_id, $przedmiot_id, $data_lekcji, $status, $status]);
        }
        $conn->commit();
        $success_message = 'Frekwencja zapisana pomyślnie.';
    } catch (Exception $e) {
        $conn->rollBack();
        $error_message = 'Błąd zapisu frekwencji: ' . $e->getMessage();
    }
}


$query_plan_lekcji = "SELECT DISTINCT pl.klasa_id, k.nazwa_klasy
                      FROM plan_lekcji pl
                      JOIN klasy k ON pl.klasa_id = k.id
                      JOIN uzytkownicy n ON pl.przedmiot_id = n.przedmiot_id
                      WHERE n.id = ?";
$stmt_plan_lekcji = $conn->prepare($query_plan_lekcji);
$stmt_plan_lekcji->execute([$nauczyciel_id]);
$klasy_nauczyciela = $stmt_plan_lekcji->fetchAll(PDO::FETCH_ASSOC);

$klasa_id_wybrana = isset($_GET['klasa_id']) ? sanitize_input($_GET['klasa_id']) : null;
$przedmiot_id_wybrany = isset($_GET['przedmiot_id']) ? sanitize_input($_GET['przedmiot_id']) : null;
$data_lekcji_wybrana = isset($_GET['data_lekcji']) ? sanitize_input($_GET['data_lekcji']) : date('Y-m-d');


$uczniowie_klasy = [];
if ($klasa_id_wybrana && $przedmiot_id_wybrany && $data_lekcji_wybrana) {

    $query_uczniowie = "SELECT u.id, u.imie, u.nazwisko,
                           (SELECT status FROM frekwencja f WHERE f.uczen_id = u.id AND f.przedmiot_id = ? AND f.data_lekcji = ?) as status_frekwencji
                         FROM uzytkownicy u
                         WHERE u.typ_uzytkownika = 'uczen' AND u.klasa_id = ?";
    $stmt_uczniowie = $conn->prepare($query_uczniowie);
    $stmt_uczniowie->execute([$przedmiot_id_wybrany, $data_lekcji_wybrana, $klasa_id_wybrana]);
    $uczniowie_klasy = $stmt_uczniowie->fetchAll(PDO::FETCH_ASSOC);
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Frekwencja - Panel Nauczyciela</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <nav>
        <div class="container">
            <ul>
                <li><a href="../index.php">Strona Główna</a></li>
                <li><a href="nauczyciel.php">Panel Nauczyciela</a></li>
                <li><a href="../logout.php">Wyloguj</a></li>
            </ul>
        </div>
    </nav>

    <div class="container main-content">
        <h1>Frekwencja</h1>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="GET" action="frekwencja.php">
            <div class="form-group">
                <label for="klasa_id">Klasa:</label>
                <select id="klasa_id" name="klasa_id" required>
                    <option value="">Wybierz klasę</option>
                    <?php foreach ($klasy_nauczyciela as $klasa): ?>
                        <option value="<?php echo $klasa['klasa_id']; ?>" <?php if($klasa_id_wybrana == $klasa['klasa_id']) echo 'selected'; ?>><?php echo htmlspecialchars($klasa['nazwa_klasy']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
             <div class="form-group">
                <label for="przedmiot_id">Przedmiot:</label>
                <select id="przedmiot_id" name="przedmiot_id" required>
                    <option value="">Wybierz przedmiot</option>
                    <?php foreach ($przedmioty_nauczyciela as $przedmiot): ?>
                        <option value="<?php echo $przedmiot['id']; ?>" <?php if($przedmiot_id_wybrany == $przedmiot['id']) echo 'selected'; ?>><?php echo htmlspecialchars($przedmiot['nazwa_przedmiotu']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="data_lekcji">Data Lekcji:</label>
                <input type="date" id="data_lekcji" name="data_lekcji" value="<?php echo $data_lekcji_wybrana; ?>" required>
            </div>
            <button type="submit">Filtruj</button>
        </form>

        <?php if ($uczniowie_klasy): ?>
            <form method="POST" action="frekwencja.php">
                <input type="hidden" name="zapisz_frekwencje">
                <input type="hidden" name="klasa_id" value="<?php echo $klasa_id_wybrana; ?>">
                <input type="hidden" name="przedmiot_id" value="<?php echo $przedmiot_id_wybrany; ?>">
                <input type="hidden" name="data_lekcji" value="<?php echo $data_lekcji_wybrana; ?>">

                <table>
                    <thead>
                        <tr>
                            <th>Uczeń</th>
                            <th>Obecność</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($uczniowie_klasy as $uczen): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($uczen['imie'] . ' ' . $uczen['nazwisko']); ?></td>
                                <td>
                                    <select name="frekwencja[<?php echo $uczen['id']; ?>]">
                                        <option value="obecny" <?php if($uczen['status_frekwencji'] == 'obecny') echo 'selected'; ?>>Obecny</option>
                                        <option value="nieobecny" <?php if($uczen['status_frekwencji'] == 'nieobecny') echo 'selected'; ?>>Nieobecny</option>
                                        <option value="spozniony" <?php if($uczen['status_frekwencji'] == 'spozniony') echo 'selected'; ?>>Spóźniony</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit">Zapisz Frekwencję</button>
            </form>
        <?php elseif ($klasa_id_wybrana && $przedmiot_id_wybrany) : ?>
            <p>Brak uczniów w wybranej klasie.</p>
        <?php endif; ?>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>