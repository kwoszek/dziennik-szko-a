<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_uczen();

$uczen_id = get_user_id();
$error_message = '';
$success_message = '';
$uczen_data = [];


$query_profil = "SELECT imie, nazwisko, data_urodzenia, email FROM uzytkownicy WHERE id = ?";
$stmt_profil = $conn->prepare($query_profil);
$stmt_profil->execute([$uczen_id]);
$uczen_data = $stmt_profil->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imie = sanitize_input($_POST['imie']);
    $nazwisko = sanitize_input($_POST['nazwisko']);
    $data_urodzenia = sanitize_input($_POST['data_urodzenia']);
    $email = sanitize_input($_POST['email']);

    if (empty($imie) || empty($nazwisko) || empty($data_urodzenia) || empty($email)) {
        $error_message = 'Proszę wypełnić wszystkie pola.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Nieprawidłowy format email.';
    } else {
        $query_update = "UPDATE uzytkownicy SET imie = ?, nazwisko = ?, data_urodzenia = ?, email = ? WHERE id = ?";
        $stmt_update = $conn->prepare($query_update);
        $result = $stmt_update->execute([$imie, $nazwisko, $data_urodzenia, $email, $uczen_id]);

        if ($result) {
            $success_message = 'Profil zaktualizowany pomyślnie.';

            $stmt_profil->execute([$uczen_id]);
            $uczen_data = $stmt_profil->fetch(PDO::FETCH_ASSOC);
        } else {
            $error_message = 'Błąd aktualizacji profilu. Spróbuj ponownie później.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profil Ucznia</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <nav>
        <div class="container">
            <ul>
                <li><a href="../index.php">Strona Główna</a></li>
                <li><a href="uczen.php">Panel Ucznia</a></li>
                <li><a href="../logout.php">Wyloguj</a></li>
            </ul>
        </div>
    </nav>

    <div class="container main-content">
        <h1>Mój Profil</h1>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="post" action="profil_ucznia.php">
            <div class="form-group">
                <label for="imie">Imię:</label>
                <input type="text" id="imie" name="imie" value="<?php echo htmlspecialchars($uczen_data['imie'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="nazwisko">Nazwisko:</label>
                <input type="text" id="nazwisko" name="nazwisko" value="<?php echo htmlspecialchars($uczen_data['nazwisko'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="data_urodzenia">Data urodzenia:</label>
                <input type="date" id="data_urodzenia" name="data_urodzenia" value="<?php echo htmlspecialchars($uczen_data['data_urodzenia'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($uczen_data['email'] ?? ''); ?>" required>
            </div>
            <button type="submit">Zaktualizuj Profil</button>
        </form>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>