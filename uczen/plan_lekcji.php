<?php
require_once '../core/db_connect.php';
require_once '../core/functions.php';
include '../core/auth.php';
require_uczen();

$uczen_id = get_user_id();


$query_klasa_id = "SELECT klasa_id FROM uzytkownicy WHERE id = ?";
$stmt_klasa_id = $conn->prepare($query_klasa_id);
$stmt_klasa_id->execute([$uczen_id]);
$klasa_id = $stmt_klasa_id->fetchColumn();

$plan_lekcji = [];
if ($klasa_id) {

    $query_plan = "SELECT plan_lekcji.dzien_tygodnia, plan_lekcji.godzina_rozpoczecia, plan_lekcji.godzina_zakonczenia, przedmioty.nazwa_przedmiotu
                   FROM plan_lekcji
                   JOIN przedmioty ON plan_lekcji.przedmiot_id = przedmioty.id
                   WHERE plan_lekcji.klasa_id = ?
                   ORDER BY plan_lekcji.dzien_tygodnia, plan_lekcji.godzina_rozpoczecia";
    $stmt_plan = $conn->prepare($query_plan);
    $stmt_plan->execute([$klasa_id]);
    $plan_lekcji = $stmt_plan->fetchAll(PDO::FETCH_ASSOC);
}

$dni_tygodnia = ['Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Plan Lekcji - Panel Ucznia</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <nav>
        <div class="container">
            <ul>
                <li><a href="../index.php">Strona Główna</a></li>
                <li><a href="uczen.php">Panel Ucznia</a></li>
                <li><a href="../logout.php">Wyloguj</a></li>
            </ul>
        </div>
    </nav>

    <div class="container main-content">
        <h1>Plan Lekcji</h1>

        <?php if (empty($plan_lekcji)): ?>
            <p>Plan lekcji nie jest dostępny.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Dzień Tygodnia</th>
                        <th>Godzina</th>
                        <th>Przedmiot</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dni_tygodnia as $dzien): ?>
                        <?php $zajecia_w_dniu = false; ?>
                        <?php foreach ($plan_lekcji as $lekcja): ?>
                            <?php if ($lekcja['dzien_tygodnia'] == $dzien): ?>
                                <?php if (!$zajecia_w_dniu): ?>
                                    <tr><td colspan="3"><strong><?php echo htmlspecialchars($dzien); ?></strong></td></tr>
                                    <?php $zajecia_w_dniu = true; ?>
                                <?php endif; ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo date('H:i', strtotime($lekcja['godzina_rozpoczecia'])) . ' - ' . date('H:i', strtotime($lekcja['godzina_zakonczenia'])); ?></td>
                                    <td><?php echo htmlspecialchars($lekcja['nazwa_przedmiotu']); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>