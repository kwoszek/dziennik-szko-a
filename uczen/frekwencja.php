<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_uczen();

$uczen_id = get_user_id();

$frekwencja_data = [];


$query_frekwencja = "SELECT f.data_lekcji, p.nazwa_przedmiotu, f.status
                      FROM frekwencja f
                      JOIN przedmioty p ON f.przedmiot_id = p.id
                      WHERE f.uczen_id = ?
                      ORDER BY f.data_lekcji DESC";
$stmt_frekwencja = $conn->prepare($query_frekwencja);
$stmt_frekwencja->execute([$uczen_id]);
$frekwencja_data = $stmt_frekwencja->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Frekwencja - Panel Ucznia</title>
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
        <h1>Moja Frekwencja</h1>

        <?php if (empty($frekwencja_data)): ?>
            <p>Brak danych frekwencji.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Data Lekcji</th>
                        <th>Przedmiot</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($frekwencja_data as $frekwencja): ?>
                        <tr>
                            <td><?php echo date('d.m.Y', strtotime($frekwencja['data_lekcji'])); ?></td>
                            <td><?php echo htmlspecialchars($frekwencja['nazwa_przedmiotu']); ?></td>
                            <td><?php echo htmlspecialchars($frekwencja['status']); ?></td>
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