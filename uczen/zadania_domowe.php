<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_uczen();

$uczen_id = get_user_id();


$query_klasa_id = "SELECT klasa_id FROM uzytkownicy WHERE id = ?";
$stmt_klasa_id = $conn->prepare($query_klasa_id);
$stmt_klasa_id->execute([$uczen_id]);
$klasa_id = $stmt_klasa_id->fetchColumn();

$zadania_data = [];

if ($klasa_id) {

    $query_zadania = "SELECT zd.tresc, zd.termin_oddania, p.nazwa_przedmiotu, zd.data_dodania
                      FROM zadania_domowe zd
                      JOIN przedmioty p ON zd.przedmiot_id = p.id
                      WHERE zd.klasa_id = ?
                      ORDER BY zd.termin_oddania";
    $stmt_zadania = $conn->prepare($query_zadania);
    $stmt_zadania->execute([$klasa_id]);
    $zadania_data = $stmt_zadania->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Zadania Domowe - Panel Ucznia</title>
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
        <h1>Zadania Domowe</h1>

        <?php if (empty($zadania_data)): ?>
            <p>Brak zadań domowych.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Przedmiot</th>
                        <th>Treść Zadania</th>
                        <th>Termin Oddania</th>
                        <th>Data Dodania</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($zadania_data as $zadanie): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($zadanie['nazwa_przedmiotu']); ?></td>
                            <td><?php echo htmlspecialchars($zadanie['tresc']); ?></td>
                            <td><?php echo date('d.m.Y', strtotime($zadanie['termin_oddania'])); ?></td>
                            <td><?php echo date('d.m.Y', strtotime($zadanie['data_dodania'])); ?></td>
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