<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_uczen();

$uczen_id = get_user_id();

$uwagi_data = [];


$query_uwagi = "SELECT u.tresc, u.punkty, n.imie, n.nazwisko, u.data_dodania
                FROM uwagi u
                JOIN uzytkownicy n ON u.nauczyciel_id = n.id
                WHERE u.uczen_id = ?
                ORDER BY u.data_dodania DESC";
$stmt_uwagi = $conn->prepare($query_uwagi);
$stmt_uwagi->execute([$uczen_id]);
$uwagi_data = $stmt_uwagi->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Uwagi - Panel Ucznia</title>
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
        <h1>Moje Uwagi</h1>

        <?php if (empty($uwagi_data)): ?>
            <p>Brak uwag.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Data Dodania</th>
                        <th>Nauczyciel</th>
                        <th>Treść Uwagi</th>
                        <th>Punkty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($uwagi_data as $uwaga): ?>
                        <tr>
                            <td><?php echo date('d.m.Y', strtotime($uwaga['data_dodania'])); ?></td>
                            <td><?php echo htmlspecialchars($uwaga['imie'] . ' ' . $uwaga['nazwisko']); ?></td>
                            <td><?php echo htmlspecialchars($uwaga['tresc']); ?></td>
                            <td><?php echo htmlspecialchars($uwaga['punkty']); ?></td>
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