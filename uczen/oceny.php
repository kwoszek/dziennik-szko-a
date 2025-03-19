<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_uczen();

$uczen_id = get_user_id();

$oceny_data = [];


$query_oceny = "SELECT o.ocena, p.nazwa_przedmiotu, o.data_wystawienia
                 FROM oceny o
                 JOIN przedmioty p ON o.przedmiot_id = p.id
                 WHERE o.uczen_id = ?
                 ORDER BY o.data_wystawienia DESC";
$stmt_oceny = $conn->prepare($query_oceny);
$stmt_oceny->execute([$uczen_id]);
$oceny_data = $stmt_oceny->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Oceny - Panel Ucznia</title>
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
        <h1>Moje Oceny</h1>

        <?php if (empty($oceny_data)): ?>
            <p>Brak ocen.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Przedmiot</th>
                        <th>Ocena</th>
                        <th>Data Wystawienia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($oceny_data as $ocena): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ocena['nazwa_przedmiotu']); ?></td>
                            <td><?php echo htmlspecialchars($ocena['ocena']); ?></td>
                            <td><?php echo date('d.m.Y', strtotime($ocena['data_wystawienia'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>