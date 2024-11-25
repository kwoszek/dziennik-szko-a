<?php
session_start();
?>

<nav style="background-color: #333; color: white; padding: 10px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <a href="news.php" style="color: white; text-decoration: none; margin-right: 15px;">Strona główna</a>
            <a href="grades.php" style="color: white; text-decoration: none; margin-right: 15px;">Dziennik</a>
            <a href="contact.php" style="color: white; text-decoration: none;">Kontakt</a>
        </div>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                Witaj, <?= htmlspecialchars($_SESSION['user_name']) ?>!
                <a href="logout.php" style="color: white; text-decoration: none; margin-left: 15px;">Wyloguj</a>
            <?php else: ?>
                <a href="login.php" style="color: white; text-decoration: none; margin-right: 15px;">Zaloguj</a>
                <a href="register.php" style="color: white; text-decoration: none;">Zarejestruj</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<hr>
