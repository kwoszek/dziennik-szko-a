<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_admin();

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $klasa_id = sanitize_input($_POST['klasa_id']);
    $przedmiot_id = sanitize_input($_POST['przedmiot_id']);
    $dzien_tygodnia = sanitize_input($_POST['dzien_tygodnia']);
    $godzina_rozpoczecia = sanitize_input($_POST['godzina_rozpoczecia']);
    $godzina_zakonczenia = sanitize_input($_POST['godzina_zakonczenia']);

    if (empty($klasa_id) || empty($przedmiot_id) || empty($dzien_tygodnia) || empty($godzina_rozpoczecia) || empty($godzina_zakonczenia)) {
        $error_message = 'Proszę wypełnić wszystkie pola planu lekcji.';
    } else {
        $query = "INSERT INTO plan_lekcji (klasa_id, przedmiot_id, dzien_tygodnia, godzina_rozpoczecia, godzina_zakonczenia) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([$klasa_id, $przedmiot_id, $dzien_tygodnia, $godzina_rozpoczecia, $godzina_zakonczenia]);

        if ($result) {
            $success_message = 'Plan lekcji dodany pomyślnie.';
        } else {
            $error_message = 'Błąd dodawania planu lekcji. Spróbuj ponownie później.';
        }
    }
}

$query_klasy = "SELECT * FROM klasy";
$stmt_klasy = $conn->prepare($query_klasy);
$stmt_klasy->execute();
$klasy = $stmt_klasy->fetchAll(PDO::FETCH_ASSOC);

$query_przedmioty = "SELECT * FROM przedmioty";
$stmt_przedmioty = $conn->prepare($query_przedmioty);
$stmt_przedmioty->execute();
$przedmioty = $stmt_przedmioty->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Zarządzaj Planem Lekcji</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <nav>
        <div class="container">
            <ul>
                <li><a href="../index.php">Strona Główna</a></li>
                <li><a href="admin.php">Panel Admina</a></li>
                <li><a href="../logout.php">Wyloguj</a></li>
            </ul>
        </div>
    </nav>

    <div class="container main-content">
        <h1>Zarządzaj Planem Lekcji</h1>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="post" action="zarzadzaj_planem.php">
            <div class="form-group">
                <label for="klasa_id">Klasa:</label>
                <select id="klasa_id" name="klasa_id" required>
                    <option value="">Wybierz klasę</option>
                    <?php foreach ($klasy as $klasa): ?>
                        <option value="<?php echo $klasa['id']; ?>"><?php echo htmlspecialchars($klasa['nazwa_klasy']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="przedmiot_id">Przedmiot:</label>
                <select id="przedmiot_id" name="przedmiot_id" required>
                    <option value="">Wybierz przedmiot</option>
                    <?php foreach ($przedmioty as $przedmiot): ?>
                        <option value="<?php echo $przedmiot['id']; ?>"><?php echo htmlspecialchars($przedmiot['nazwa_przedmiotu']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="dzien_tygodnia">Dzień Tygodnia:</label>
                <select id="dzien_tygodnia" name="dzien_tygodnia" required>
                    <option value="">Wybierz dzień tygodnia</option>
                    <option value="Poniedziałek">Poniedziałek</option>
                    <option value="Wtorek">Wtorek</option>
                    <option value="Środa">Środa</option>
                    <option value="Czwartek">Czwartek</option>
                    <option value="Piątek">Piątek</option>
                </select>
            </div>
            <div class="form-group">
                <label for="godzina_rozpoczecia">Godzina Rozpoczęcia:</label>
                <input type="time" id="godzina_rozpoczecia" name="godzina_rozpoczecia" required>
            </div>
            <div class="form-group">
                <label for="godzina_zakonczenia">Godzina Zakończenia:</label>
                <input type="time" id="godzina_zakonczenia" name="godzina_zakonczenia" required>
            </div>
            <button type="submit">Dodaj do Planu</button>
        </form>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>