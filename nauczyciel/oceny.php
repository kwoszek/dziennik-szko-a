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


$query_przedmioty = "SELECT p.id, p.nazwa_przedmiotu
                     FROM uzytkownicy u
                     JOIN przedmioty p ON u.przedmiot_id = p.id
                     WHERE u.id = ?";
$stmt_przedmioty = $conn->prepare($query_przedmioty);
$stmt_przedmioty->execute([$nauczyciel_id]);
$przedmioty_nauczyciela = $stmt_przedmioty->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dodaj_ocene'])) {
    $uczen_id = sanitize_input($_POST['uczen_id']);
    $przedmiot_id = sanitize_input($_POST['przedmiot_id']);
    $ocena = sanitize_input($_POST['ocena']);

    if (empty($uczen_id) || empty($przedmiot_id) || empty($ocena)) {
        $error_message = 'Proszę wypełnić wszystkie pola oceny.';
    } elseif (!is_numeric($ocena) || $ocena < 1 || $ocena > 6) {
        $error_message = 'Ocena musi być liczbą z zakresu 1-6.';
    } else {
        $query_dodaj_ocene = "INSERT INTO oceny (uczen_id, przedmiot_id, ocena) VALUES (?, ?, ?)";
        $stmt_dodaj_ocene = $conn->prepare($query_dodaj_ocene);
        $result = $stmt_dodaj_ocene->execute([$uczen_id, $przedmiot_id, $ocena]);

        if ($result) {
            $success_message = 'Ocena dodana pomyślnie.';
        } else {
            $error_message = 'Błąd dodawania oceny. Spróbuj ponownie później.';
        }
    }
}

$klasa_id_wybrana = isset($_GET['klasa_id']) ? sanitize_input($_GET['klasa_id']) : null;
$przedmiot_id_wybrany = isset($_GET['przedmiot_id']) ? sanitize_input($_GET['przedmiot_id']) : null;
$uczniowie_klasy = [];

if ($klasa_id_wybrana && $przedmiot_id_wybrany) {

    $query_uczniowie = "SELECT id, imie, nazwisko FROM uzytkownicy WHERE typ_uzytkownika = 'uczen' AND klasa_id = ?";
    $stmt_uczniowie = $conn->prepare($query_uczniowie);
    $stmt_uczniowie->execute([$klasa_id_wybrana]);
    $uczniowie_klasy = $stmt_uczniowie->fetchAll(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Oceny - Panel Nauczyciela</title>
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
        <h1>Oceny</h1>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="GET" action="oceny.php">
            <div class="form-group">
                <label for="klasa_id">Klasa:</label>
                <select id="klasa_id" name="klasa_id" required>
                    <option value="">Wybierz klasę</option>
                    <?php foreach ($klasy_nauczyciela as $klasa): ?>
                        <option value="<?php echo $klasa['id']; ?>" <?php if($klasa_id_wybrana == $klasa['id']) echo 'selected'; ?>><?php echo htmlspecialchars($klasa['nazwa_klasy']); ?></option>
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
            <button type="submit">Filtruj</button>
        </form>

        <?php if ($uczniowie_klasy): ?>
            <h2>Dodaj ocenę dla klasy <?php echo htmlspecialchars($_GET['klasa_id'] ?? ''); ?> - Przedmiot: <?php echo htmlspecialchars($_GET['przedmiot_id'] ?? ''); ?></h2>
            <form method="POST" action="oceny.php">
                <input type="hidden" name="dodaj_ocene">
                <input type="hidden" name="przedmiot_id" value="<?php echo $przedmiot_id_wybrany; ?>">

                <table>
                    <thead>
                        <tr>
                            <th>Uczeń</th>
                            <th>Ocena</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($uczniowie_klasy as $uczen): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($uczen['imie'] . ' ' . $uczen['nazwisko']); ?>
                                    <input type="hidden" name="uczen_id" value="<?php echo $uczen['id']; ?>">
                                </td>
                                <td>
                                    <select name="ocena">
                                        <option value="1">1</option>
                                        <option value="1.5">1.5</option>
                                        <option value="2">2</option>
                                        <option value="2.5">2.5</option>
                                        <option value="3">3</option>
                                        <option value="3.5">3.5</option>
                                        <option value="4">4</option>
                                        <option value="4.5">4.5</option>
                                        <option value="5">5</option>
                                        <option value="5.5">5.5</option>
                                        <option value="6">6</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit">Dodaj Oceny</button>
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