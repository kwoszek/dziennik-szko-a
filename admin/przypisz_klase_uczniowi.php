<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_admin();

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uczen_id = sanitize_input($_POST['uczen_id']);
    $klasa_id = sanitize_input($_POST['klasa_id']);

    if (empty($uczen_id) || empty($klasa_id)) {
        $error_message = 'Proszę wybrać ucznia i klasę.';
    } else {
        $query = "UPDATE uzytkownicy SET klasa_id = ? WHERE id = ? AND typ_uzytkownika = 'uczen'";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([$klasa_id, $uczen_id]);

        if ($result) {
            $success_message = 'Klasa przypisana uczniowi pomyślnie.';
        } else {
            $error_message = 'Błąd przypisywania klasy uczniowi. Spróbuj ponownie później.';
        }
    }
}

$query_uczniowie = "SELECT id, imie, nazwisko FROM uzytkownicy WHERE typ_uzytkownika = 'uczen'";
$stmt_uczniowie = $conn->prepare($query_uczniowie);
$stmt_uczniowie->execute();
$uczniowie = $stmt_uczniowie->fetchAll(PDO::FETCH_ASSOC);

$query_klasy = "SELECT * FROM klasy";
$stmt_klasy = $conn->prepare($query_klasy);
$stmt_klasy->execute();
$klasy = $stmt_klasy->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Przypisz Klasę Uczniowi</title>
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
        <h1>Przypisz Klasę Uczniowi</h1>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="post" action="przypisz_klase_uczniowi.php">
            <div class="form-group">
                <label for="uczen_id">Uczeń:</label>
                <select id="uczen_id" name="uczen_id" required>
                    <option value="">Wybierz ucznia</option>
                    <?php foreach ($uczniowie as $uczen): ?>
                        <option value="<?php echo $uczen['id']; ?>"><?php echo htmlspecialchars($uczen['imie'] . ' ' . $uczen['nazwisko']); ?></option>
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
            <button type="submit">Przypisz Klasę</button>
        </form>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>