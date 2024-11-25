<?php
include 'config.php';
include 'navigation.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    try {
        $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password, 'role' => $role]);

         echo "Rejestracja zakończona sukcesem! Przekierowanie na stronę logowania...";
        header("Refresh: 2; url=login.php");
        exit;
    } catch (Exception $e) {
        echo "Błąd podczas rejestracji: " . $e->getMessage();
    }
}
?>
<form method="POST">
    <input type="text" name="name" placeholder="Imię i nazwisko" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="password" placeholder="Hasło" required>
    <select name="role">
        <option value="student">Uczeń</option>
        <option value="parent">Rodzic</option>
        <option value="teacher">Nauczyciel</option>
    </select>
    <button type="submit">Zarejestruj</button>
</form>
