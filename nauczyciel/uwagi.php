<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_nauczyciel();

$nauczyciel_id = get_user_id();
$error_message = '';
$success_message = '';


$query_klasy = "SELECT DISTINCT k.id, k.nazwa_klasy
                      FROM klasy k
                      JOIN plan_lekcji pl ON k.id = pl.klasa_id
                      JOIN uzytkownicy n ON pl.przedmiot_id = n.przedmiot_id
                      WHERE n.id = ?";
$stmt_klasy = $conn->prepare($query_klasy);
$stmt_klasy->execute([$nauczyciel_id]);
$klasy_nauczyciela = $stmt_klasy->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dodaj_uwage'])) {
    $uczen_id = sanitize_input($_POST['uczen_id']);
    $tresc_uwagi = sanitize_input($_POST['tresc_uwagi']);
    $punkty = sanitize_input($_POST['punkty']);

    if (empty($uczen_id) || empty($tresc_uwagi)) {
        $error_message = 'Proszę wypełnić treść uwagi.';
    } else {
        $query_dodaj_uwage = "INSERT INTO uwagi (uczen_id, nauczyciel_id, tresc, punkty) VALUES (?, ?, ?, ?)";
        $stmt_dodaj_uwage = $conn->prepare($query_dodaj_uwage);
        $punkty = $punkty ? intval($punkty) : 0;
        $result = $stmt_dodaj_uwage->execute([$uczen_id, $nauczyciel_id, $tresc_uwagi, $punkty]);

        if ($result) {
            $success_message = 'Uwaga dodana pomyślnie.';
        } else {
            $error_message = 'Błąd dodawania uwagi. Spróbuj ponownie później.';
        }
    }
}

$klasa_id_wybrana = isset($_GET['klasa_id']) ? sanitize_input($_GET['klasa_id']) : null;
$uczniowie_klasy = [];

if ($klasa_id_wybrana) {

    $query_uczniowie = "SELECT id, imie, nazwisko FROM uzytkownicy WHERE typ_uzytkownika = 'uczen' AND klasa_id = ?";
    $stmt_uczniowie = $conn->prepare($query_uczniowie);
    $stmt_uczniowie->execute([$klasa_id_wybrana]);
    $uczniowie_klasy = $stmt_uczniowie->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Uwagi - Panel Nauczyciela</title>
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
        <h1>Uwagi</h1>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="GET" action="uwagi.php">
            <div class="form-group">
                <label for="klasa_id">Klasa:</label>
                <select id="klasa_id" name="klasa_id" required>
                    <option value="">Wybierz klasę</option>
                    <?php foreach ($klasy_nauczyciela as $klasa): ?>
                        <option value="<?php echo $klasa['id']; ?>" <?php if($klasa_id_wybrana == $klasa['id']) echo 'selected'; ?>><?php echo htmlspecialchars($klasa['nazwa_klasy']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit">Filtruj</button>
        </form>

        <?php if ($uczniowie_klasy): ?>
            <h2>Dodaj uwagę dla klasy <?php echo htmlspecialchars($_GET['klasa_id'] ?? ''); ?></h2>
            <form method="POST" action="uwagi.php">
                <input type="hidden" name="dodaj_uwage">

                <table>
                    <thead>
                        <tr>
                            <th>Uczeń</th>
                            <th>Treść Uwagi</th>
                            <th>Punkty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($uczniowie_klasy as $uczen): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($uczen['imie'] . ' ' . $uczen['nazwisko']); ?>
                                    <input type="hidden" name="uczen_id" value="<?php echo $uczen['id']; ?>">
                                </td>
                                <td>
                                    <textarea name="tresc_uwagi" rows="2" required></textarea>
                                </td>
                                <td>
                                    <input type="number" name="punkty" value="0">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit">Dodaj Uwagi</button>
            </form>
        <?php elseif ($klasa_id_wybrana) : ?>
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