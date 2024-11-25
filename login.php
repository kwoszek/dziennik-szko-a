<?php
include 'config.php';
include 'navigation.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        header("Location: news.php");
        exit;
    } else {
        echo "Nieprawidłowy e-mail lub hasło.";
    }
}
?>
<form method="POST">
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="password" placeholder="Hasło" required>
    <button type="submit">Zaloguj</button>
</form>
