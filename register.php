<?php
require_once 'core/db_connect.php';
require_once 'core/functions.php';

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imie = sanitize_input($_POST['imie']);
    $nazwisko = sanitize_input($_POST['nazwisko']);
    $data_urodzenia = sanitize_input($_POST['data_urodzenia']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];

    if (empty($imie) || empty($nazwisko) || empty($data_urodzenia) || empty($email) || empty($password)) {
        $error_message = 'Proszę wypełnić wszystkie pola.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Nieprawidłowy format email.';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO uzytkownicy (imie, nazwisko, data_urodzenia, email, haslo, typ_uzytkownika) VALUES (?, ?, ?, ?, ?, 'uczen')";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([$imie, $nazwisko, $data_urodzenia, $email, $hashed_password]);

        if ($result) {
            $success_message = 'Rejestracja zakończona pomyślnie. Możesz się teraz zalogować.';
        } else {
            $error_message = 'Błąd rejestracji. Spróbuj ponownie później.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rejestracja - Dziennik Szkolny</title>
    <link rel="stylesheet" href="public/style.css">
</head>
<body>
    <nav>
        <div class="container">
            <ul>
                <li><a href="index.php">Strona Główna</a></li>
                <li><a href="historia_szkoly.php">Historia Szkoły</a></li>
                <li><a href="kontakt.php">Kontakt</a></li>
                <li><a href="login.php">Zaloguj</a></li>
                <li><a href="register.php">Zarejestruj</a></li>
            </ul>
        </div>
    </nav>

    <div class="container main-content">
        <h1>Rejestracja Ucznia</h1>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="post" action="register.php">
            <div class="form-group">
                <label for="imie">Imię:</label>
                <input type="text" id="imie" name="imie" required>
            </div>
            <div class="form-group">
                <label for="nazwisko">Nazwisko:</label>
                <input type="text" id="nazwisko" name="nazwisko" required>
            </div>
            <div class="form-group">
                <label for="data_urodzenia">Data urodzenia:</label>
                <input type="date" id="data_urodzenia" name="data_urodzenia" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Zarejestruj</button>
        </form>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>