<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_admin();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel Administratora</title>
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
        <h1>Panel Administratora</h1>

        <div class="admin-actions">
            <ul>
                <li><a href="dodaj_nauczyciela.php">Dodaj Nauczyciela</a></li>
                <li><a href="przypisz_klase_nauczycielowi.php">Przypisz Klasę Nauczycielowi</a></li>
                <li><a href="przypisz_klase_uczniowi.php">Przypisz Klasę Uczniowi</a></li>
                <li><a href="aktualizuj_aktualnosci.php">Aktualizuj Aktualności</a></li>
                <li><a href="zarzadzaj_planem.php">Zarządzaj Planem Lekcji</a></li>
                <li><a href="uzytkownicy.php">Lista użytkowników</a></li>
            </ul>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>© <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>