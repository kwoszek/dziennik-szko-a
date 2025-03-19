<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_admin();

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tytul = sanitize_input($_POST['tytul']);
    $tresc = sanitize_input($_POST['tresc']);

    if (empty($tytul) || empty($tresc)) {
        $error_message = 'Proszę wypełnić tytuł i treść aktualności.';
    } else {
        $query = "INSERT INTO aktualnosci (tytul, tresc) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([$tytul, $tresc]);

        if ($result) {
            $success_message = 'Aktualność dodana pomyślnie.';
        } else {
            $error_message = 'Błąd dodawania aktualności. Spróbuj ponownie później.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Aktualizuj Aktualności</title>
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
        <h1>Dodaj Aktualność</h1>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="post" action="aktualizuj_aktualnosci.php">
            <div class="form-group">
                <label for="tytul">Tytuł Aktualności:</label>
                <input type="text" id="tytul" name="tytul" required>
            </div>
            <div class="form-group">
                <label for="tresc">Treść Aktualności:</label>
                <textarea id="tresc" name="tresc" rows="5" required></textarea>
            </div>
            <button type="submit">Dodaj Aktualność</button>
        </form>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>