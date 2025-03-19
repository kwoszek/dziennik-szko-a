<?php
require_once 'core/functions.php';
include 'core/auth.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kontakt - Dziennik Szkolny</title>
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
        <h1>Kontakt</h1>

        <p>Jeśli masz pytania lub wątpliwości, skontaktuj się z nami.</p>

        <h2>Zespół Szkół Techniczno-Informatycznych w Gliwicach</h2>

        <p><b>Adres:</b> ul. Sikorskiego 134, 44-100 Gliwice</p>
        <p><b>Telefon:</b> +48 32 231 98 78</p>
        <p><b>Email:</b> <a href="mailto:sekretariat@zstio.gliwice.pl">sekretariat@zstio.gliwice.pl</a></p>
        <p><b>Strona internetowa:</b> <a href="https://www.zstio.gliwice.pl/" target="_blank">www.zstio.gliwice.pl</a></p>

        <h3>Sekretariat</h3>
        <p>Czynny od poniedziałku do piątku w godzinach 8:00 - 15:00.</p>


    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>