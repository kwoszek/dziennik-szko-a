<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_admin();

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imie = sanitize_input($_POST['imie']);
    $nazwisko = sanitize_input($_POST['nazwisko']);
    $data_urodzenia = sanitize_input($_POST['data_urodzenia']);
    $email = sanitize_input($_POST['email']);
    $przedmiot_id = sanitize_input($_POST['przedmiot_id']);
    $klasa_id = sanitize_input($_POST['klasa_id']);
    $password = $_POST['password'];

    if (empty($imie) || empty($nazwisko) || empty($data_urodzenia) || empty($email) || empty($password) || empty($przedmiot_id) || empty($klasa_id)) {
        $error_message = 'Proszę wypełnić wszystkie pola.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Nieprawidłowy format email.';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO uzytkownicy (imie, nazwisko, data_urodzenia, email, haslo, typ_uzytkownika, przedmiot_id, klasa_id) VALUES (?, ?, ?, ?, ?, 'nauczyciel', ?, ?)";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([$imie, $nazwisko, $data_urodzenia, $email, $hashed_password, $przedmiot_id, $klasa_id]);

        if ($result) {
            $success_message = 'Nauczyciel dodany pomyślnie.';
        } else {
            $error_message = 'Błąd dodawania nauczyciela. Spróbuj ponownie później.';
        }
    }
}

$query_przedmioty = "SELECT * FROM przedmioty";
$stmt_przedmioty = $conn->prepare($query_przedmioty);
$stmt_przedmioty->execute();
$przedmioty = $stmt_przedmioty->fetchAll(PDO::FETCH_ASSOC);

$query_klasy = "SELECT * FROM klasy";
$stmt_klasy = $conn->prepare($query_klasy);
$stmt_klasy->execute();
$klasy = $stmt_klasy->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Dodaj Nauczyciela</title>
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
        <h1>Dodaj Nauczyciela</h1>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="post" action="dodaj_nauczyciela.php">
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
                <label for="przedmiot_id">Przedmiot:</label>
                <select id="przedmiot_id" name="przedmiot_id" required>
                    <option value="">Wybierz przedmiot</option>
                    <?php foreach ($przedmioty as $przedmiot): ?>
                        <option value="<?php echo $przedmiot['id']; ?>"><?php echo htmlspecialchars($przedmiot['nazwa_przedmiotu']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
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
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Dodaj Nauczyciela</button>
        </form>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>
</body>
</html>