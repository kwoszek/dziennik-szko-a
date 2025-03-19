<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_admin();

$query = "SELECT id, imie, nazwisko, email, typ_uzytkownika FROM uzytkownicy";
$stmt = $conn->prepare($query);
$stmt->execute();
$uzytkownicy = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista Użytkowników</title>
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
        <h1>Lista Użytkowników</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imię i Nazwisko</th>
                    <th>Email</th>
                    <th>Typ Użytkownika</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($uzytkownicy as $uzytkownik): ?>
                    <tr>
                        <td><?php echo $uzytkownik['id']; ?></td>
                        <td><?php echo htmlspecialchars($uzytkownik['imie'] . ' ' . $uzytkownik['nazwisko']); ?></td>
                        <td><?php echo htmlspecialchars($uzytkownik['email']); ?></td>
                        <td><?php echo htmlspecialchars($uzytkownik['typ_uzytkownika']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>