<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_uczen();

$user_id = get_user_id();

$query = "SELECT imie, nazwisko, klasa_id FROM uzytkownicy WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$user_id]);
$uczen_info = $stmt->fetch(PDO::FETCH_ASSOC);

$query_klasa = "SELECT nazwa_klasy FROM klasy WHERE id = ?";
$stmt_klasa = $conn->prepare($query_klasa);
$stmt_klasa->execute([$uczen_info['klasa_id']]);
$klasa_nazwa = $stmt_klasa->fetchColumn();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel Ucznia</title>
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
        <h1>Witaj, Uczniu <?php echo htmlspecialchars($uczen_info['imie'] . ' ' . $uczen_info['nazwisko']); ?>!</h1>
        <p>Klasa: <?php echo htmlspecialchars($klasa_nazwa ?? 'Nieprzypisana'); ?></p>

        <div class="uczen-actions">
            <ul>
                <li><a href="plan_lekcji.php">Plan Lekcji</a></li>
                <li><a href="frekwencja.php">Frekwencja</a></li>
                <li><a href="oceny.php">Oceny</a></li>
                <li><a href="zadania_domowe.php">Zadania Domowe</a></li>
                <li><a href="uwagi.php">Uwagi</a></li>
                <li><a href="profil_ucznia.php">Profil Ucznia</a></li>
            </ul>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>