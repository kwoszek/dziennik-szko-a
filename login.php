<?php
require_once 'core/db_connect.php';
require_once 'core/functions.php';
include 'core/auth.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error_message = 'Proszę wypełnić wszystkie pola.';
    } else {
        $query = "SELECT id, haslo, typ_uzytkownika FROM uzytkownicy WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['haslo'])) {
            login_user($user['id'], $user['typ_uzytkownika']);
            if ($user['typ_uzytkownika'] == 'admin') {
                redirect('admin/admin.php');
            } elseif ($user['typ_uzytkownika'] == 'nauczyciel') {
                redirect('nauczyciel/nauczyciel.php');
            } else {
                redirect('uczen/uczen.php');
            }
        } else {
            $error_message = 'Nieprawidłowy email lub hasło.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logowanie - Dziennik Szkolny</title>
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
        <h1>Logowanie</h1>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="post" action="login.php">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Zaloguj</button>
        </form>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>