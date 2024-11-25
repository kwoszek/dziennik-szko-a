<?php
include 'config.php';
include 'navigation.php'; // Pasek nawigacji

$sql = "SELECT id, title, content_short FROM news ORDER BY created_at DESC";
$stmt = $conn->query($sql);
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktualności</title>
</head>
<body>
<h1>Aktualności</h1>
<?php foreach ($news as $item): ?>
    <div style="margin-bottom: 20px;">
        <h2><?= htmlspecialchars($item['title']) ?></h2>
        <p><?= htmlspecialchars($item['content_short']) ?></p>
        <a href="news_detail.php?id=<?= $item['id'] ?>">Czytaj więcej</a>
    </div>
    <hr>
<?php endforeach; ?>
</body>
</html>
