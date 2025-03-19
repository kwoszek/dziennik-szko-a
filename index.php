<?php
require_once 'core/db_connect.php';
require_once 'core/functions.php';
include 'core/auth.php';

$query = "SELECT * FROM aktualnosci ORDER BY data_dodania DESC LIMIT 5";
$stmt = $conn->prepare($query);
$stmt->execute();
$aktualnosci = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dziennik Szkolny</title>
    <link rel="stylesheet" href="public/style.css">
</head>
<body>
<nav>
    <div class="container">
        <ul>
            <li><a href="index.php">Strona Główna</a></li>
            <li><a href="historia_szkoly.php">Historia Szkoły</a></li>
            <li><a href="kontakt.php">Kontakt</a></li>
            <?php if (is_logged_in()): ?>
                <?php if (get_user_role() == 'uczen'): ?>
                    <li><a href="uczen/uczen.php">Panel Ucznia</a></li>
                <?php elseif (get_user_role() == 'nauczyciel'): ?>
                    <li><a href="nauczyciel/nauczyciel.php">Panel Nauczyciela</a></li>
                <?php elseif (get_user_role() == 'admin'): ?>
                    <li><a href="admin/admin.php">Panel Admina</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Wyloguj</a></li>
            <?php else: ?>
                <li><a href="login.php">Zaloguj</a></li>
                <li><a href="register.php">Zarejestruj</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

    <div class="container main-content">
        <h1>Witaj w Dzienniku Szkolnym!</h1>

        <h2>Najnowsze Aktualności</h2>
        <?php if (empty($aktualnosci)): ?>
            <p>Brak aktualności.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($aktualnosci as $aktualnosc): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($aktualnosc['tytul']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($aktualnosc['tresc'])); ?></p>
                        <small>Dodano: <?php echo date('d.m.Y', strtotime($aktualnosc['data_dodania'])); ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>