<?php
include 'config.php';
include 'navigation.php'; // Pasek nawigacji

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Nie znaleziono wiadomości.";
    exit;
}

$id = (int)$_GET['id'];
$sql = "SELECT title, content, created_at FROM news WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $id]);
$news_item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$news_item) {
    echo "Nie znaleziono wiadomości.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($news_item['title']) ?></title>
</head>
<body>
<h1><?= htmlspecialchars($news_item['title']) ?></h1>
<p><?= htmlspecialchars($news_item['content']) ?></p>
<small>Dodano: <?= $news_item['created_at'] ?></small>
<hr>
<a href="news.php">Powrót do aktualności</a>
</body>
</html>
