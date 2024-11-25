<?php
include 'config.php';
include 'navigation.php'; // Pasek nawigacji

if (!isset($_SESSION['user_id'])) {
    echo "Musisz być zalogowany, aby zobaczyć swoje oceny.";
    exit;
}

$student_id = $_SESSION['user_id'];

// Pobieranie danych filtrów
$subject = $_GET['subject'] ?? '';
$teacher = $_GET['teacher'] ?? '';
$semester = $_GET['semester'] ?? '';

// Przygotowanie zapytania SQL z filtrami
$sql = "SELECT * FROM grades WHERE student_id = :student_id";
$params = ['student_id' => $student_id];

if (!empty($subject)) {
    $sql .= " AND subject = :subject";
    $params['subject'] = $subject;
}

if (!empty($teacher)) {
    $sql .= " AND teacher = :teacher";
    $params['teacher'] = $teacher;
}

if (!empty($semester)) {
    $sql .= " AND semester = :semester";
    $params['semester'] = $semester;
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Pobieranie unikalnych wartości do filtrów
$subjects = $conn->query("SELECT DISTINCT subject FROM grades")->fetchAll(PDO::FETCH_COLUMN);
$teachers = $conn->query("SELECT DISTINCT teacher FROM grades")->fetchAll(PDO::FETCH_COLUMN);
$semesters = $conn->query("SELECT DISTINCT semester FROM grades")->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oceny</title>
</head>
<body>
<h1>Oceny</h1>
<form method="GET" style="margin-bottom: 20px;">
    <label for="subject">Przedmiot:</label>
    <select name="subject" id="subject">
        <option value="">Wszystkie</option>
        <?php foreach ($subjects as $subj): ?>
            <option value="<?= htmlspecialchars($subj) ?>" <?= $subj === $subject ? 'selected' : '' ?>>
                <?= htmlspecialchars($subj) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="teacher">Nauczyciel:</label>
    <select name="teacher" id="teacher">
        <option value="">Wszyscy</option>
        <?php foreach ($teachers as $teach): ?>
            <option value="<?= htmlspecialchars($teach) ?>" <?= $teach === $teacher ? 'selected' : '' ?>>
                <?= htmlspecialchars($teach) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="semester">Semestr:</label>
    <select name="semester" id="semester">
        <option value="">Wszystkie</option>
        <?php foreach ($semesters as $sem): ?>
            <option value="<?= htmlspecialchars($sem) ?>" <?= $sem === $semester ? 'selected' : '' ?>>
                <?= htmlspecialchars($sem) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Filtruj</button>
</form>

<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; text-align: left;">
    <thead>
    <tr>
        <th>Przedmiot</th>
        <th>Nauczyciel</th>
        <th>Ocena</th>
        <th>Semestr</th>
        <th>Data</th>
    </tr>
    </thead>
    <tbody>
    <?php if (count($grades) > 0): ?>
        <?php foreach ($grades as $grade): ?>
            <tr>
                <td><?= htmlspecialchars($grade['subject']) ?></td>
                <td><?= htmlspecialchars($grade['teacher']) ?></td>
                <td><?= htmlspecialchars($grade['grade']) ?></td>
                <td><?= htmlspecialchars($grade['semester']) ?></td>
                <td><?= htmlspecialchars($grade['date']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">Brak ocen spełniających kryteria.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>
