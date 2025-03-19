<?php
require_once 'core/functions.php';
include 'core/auth.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Historia Szkoły - Dziennik Szkolny</title>
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
        <h1>Historia Szkoły</h1>

        <h2>Zespół Szkół Techniczno-Informatycznych w Gliwicach</h2>

        <p>Zespół Szkół Techniczno-Informatycznych w Gliwicach ma bogatą tradycję edukacyjną, sięgającą początków XX wieku. Początkowo jako szkoła zawodowa, z biegiem lat ewoluowała, dostosowując się do dynamicznie zmieniających się potrzeb rynku pracy i rozwoju technologicznego.</p>

        <p><b>Początki i Rozwój:</b> Początkowo koncentrowała się na kształceniu w tradycyjnych zawodach rzemieślniczych,  odpowiadając na zapotrzebowanie rozwijającego się przemysłu w regionie Gliwic.</p>

        <p>W okresie międzywojennym i powojennym, szkoła stopniowo rozszerzała swoją ofertę edukacyjną, włączając nowe specjalności techniczne. Szczególny nacisk zaczęto kłaść na nauki ścisłe i techniczne, przygotowując absolwentów do pracy w coraz bardziej zaawansowanych technologicznie sektorach.</p>

        <p><b>Profil Techniczno-Informatyczny:</b> Przełomowym momentem było przekształcenie profilu szkoły w kierunku techniczno-informatycznym. Wraz z rozwojem informatyki i technologii cyfrowych, szkoła szybko dostrzegła potrzebę kształcenia specjalistów w tych dziedzinach. Inwestycje w nowoczesne laboratoria komputerowe i specjalistyczne pracownie stały się priorytetem, co pozwoliło na utworzenie nowoczesnych kierunków związanych z informatyką i nowymi technologiami.</p>

        <p><b>Współczesność:</b> Dziś Zespół Szkół Techniczno-Informatycznych w Gliwicach jest cenioną placówką edukacyjną, kształcącą w zawodach przyszłości. Szkoła aktywnie współpracuje z firmami z branży IT,  co umożliwia staże i praktyki dla uczniów oraz dostosowanie programów nauczania do aktualnych wymagań rynku pracy. Absolwenci szkoły są wysoko cenieni przez pracodawców, a wielu z nich kontynuuje edukację na renomowanych uczelniach technicznych.</p>

        <p><b>Przyszłość:</b> Szkoła nieustannie się rozwija,  monitorując trendy technologiczne i dostosowując swoją ofertę edukacyjną.  Kładzie nacisk na innowacyjność, przedsiębiorczość oraz rozwijanie umiejętności praktycznych i kompetencji cyfrowych u swoich uczniów, aby byli oni jak najlepiej przygotowani do wyzwań przyszłości.</p>


    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dziennik Szkolny</p>
        </div>
    </footer>
</body>
</html>