<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_nauczyciel();

$user_id = get_user_id();

$query = "SELECT u.imie, u.nazwisko, p.nazwa_przedmiotu FROM uzytkownicy u LEFT JOIN przedmioty p ON u.przedmiot_id = p.id WHERE u.id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$user_id]);
$nauczyciel_info = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel Nauczyciela</title>
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
        <h1>Witaj, Nauczycielu <?php echo htmlspecialchars($nauczyciel_info['imie'] . ' ' . $nauczyciel_info['nazwisko']); ?>!</h1>
        <p>Przedmiot: <?php echo htmlspecialchars($nauczyciel_info['nazwa_przedmiotu'] ?? 'Nieprzypisany'); ?></p>

        <div class="nauczyciel-actions">
            <ul>
                <li><a href="frekwencja.php">Frekwencja</a></li>
                <li><a href="oceny.php">Oceny</a></li>
                <li><a href="uwagi.php">Uwagi</a></li>
                <li><a href="zadania_domowe.php">Zadania Domowe</a></li>
                <li><a href="profil_nauczyciela.php">Profil Nauczyciela</a></li>
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