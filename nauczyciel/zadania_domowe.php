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


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dodaj_zadanie'])) {
    $klasa_id = sanitize_input($_POST['klasa_id']);
    $przedmiot_id = sanitize_input($_POST['przedmiot_id']);
    $tresc_zadania = sanitize_input($_POST['tresc_zadania']);
    $termin_oddania = sanitize_input($_POST['termin_oddania']);

    if (empty($klasa_id) || empty($przedmiot_id) || empty($tresc_zadania) || empty($termin_oddania)) {
        $error_message = 'Proszę wypełnić wszystkie pola zadania domowego.';
    } else {
        $query_dodaj_zadanie = "INSERT INTO zadania_domowe (klasa_id, przedmiot_id, tresc, termin_oddania) VALUES (?, ?, ?, ?)";
        $stmt_dodaj_zadanie = $conn->prepare($query_dodaj_zadanie);
        $result = $stmt_dodaj_zadanie->execute([$klasa_id, $przedmiot_id, $tresc_zadania, $termin_oddania]);

        if ($result) {
            $success_message = 'Zadanie domowe dodane pomyślnie.';
        } else {
            $error_message = 'Błąd dodawania zadania domowego. Spróbuj ponownie później.';
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Zadania Domowe - Panel Nauczyciela</title>
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
        <h1>Zadania Domowe</h1>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="zadania_domowe.php">
            <input type="hidden" name="dodaj_zadanie">
            <div class="form-group">
                <label for="klasa_id">Klasa:</label>
                <select id="klasa_id" name="klasa_id" required>
                    <option value="">Wybierz klasę</option>
                    <?php foreach ($klasy_nauczyciela as $klasa): ?>
                        <option value="<?php echo $klasa['id']; ?>"><?php echo htmlspecialchars($klasa['nazwa_klasy']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="przedmiot_id">Przedmiot:</label>
                <select id="przedmiot_id" name="przedmiot_id" required>
                    <option value="">Wybierz przedmiot</option>
                    <?php foreach ($przedmioty_nauczyciela as $przedmiot): ?>
                        <option value="<?php echo $przedmiot['id']; ?>"><?php echo htmlspecialchars($przedmiot['nazwa_przedmiotu']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tresc_zadania">Treść Zadania Domowego:</label>
                <textarea id="tresc_zadania" name="tresc_zadania" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="termin_oddania">Termin Oddania:</label>
                <input type="date" id="termin_oddania" name="termin_oddania" required>
            </div>
            <button type="submit">Dodaj Zadanie Domowe</button>
        </form>

    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>