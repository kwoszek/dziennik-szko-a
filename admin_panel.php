<?php
include 'config.php';
include 'navigation.php'; // Pasek nawigacji
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php'); // Przekierowanie do logowania, jeśli nie jest admin
    exit();
}

// Dodawanie nowego wpisu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_news'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $content_short = $_POST['content_short'];

    $stmt = $conn->prepare("INSERT INTO news (title, content, content_short) VALUES (:title, :content, :content_short)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':content_short', $content_short);

    $stmt->execute();
}

// Usuwanie wpisu
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("DELETE FROM news WHERE id = :id");
    $stmt->bindParam(':id', $id);

    $stmt->execute();
}

// Pobieranie istniejących wpisów
$result = $conn->query("SELECT * FROM news");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel Administracyjny</title>
</head>
<body>
<h1>Panel Administracyjny</h1>

<h2>Dodaj nowy wpis</h2>
<form method="POST">
    <input type="text" name="title" placeholder="Tytuł" required>
    <input type="text" name="content" placeholder="Treść" required>
    <input type="text" name="content_short" placeholder="Skrócona treść" required>
    <button type="submit" name="add_news">Dodaj</button>
</form>

<h2>Istniejące wpisy</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Tytuł</th>
        <th>Treść</th>
        <th>Akcje</th>
    </tr>
    <?php foreach ($result as $item): ?>
    <tr style="margin-bottom: 20px;">
        <td><?= htmlspecialchars($item['title']) ?></td>
        <td><?= htmlspecialchars($item['content_short']) ?></td>
            <td>
                <a href="admin_panel.php?delete=<?php echo $item['id']; ?>">Usuń</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>


</body>
</html>