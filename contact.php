<?php
include 'navigation.php';
include 'config.php';

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz kontaktowy</title>
    <style>
        body {
            height: 100vh;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .contact-form {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            position: absolute; 
            top: 45%;
            left: 80%;
            transform: translate(-50%, -50%); 
        }
        .contact-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .contact-form input[type="text"],
        .contact-form input[type="email"] {
            font-size: 14px;
        }
        .contact-form textarea {
            height: 100px;
            resize: none;
        }
        .contact-form button {
            width: 100%;
            padding: 10px;
            background-color: gray;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .contact-form button:hover {
            background-color: #4cae4c;
        }
        table {
            width: 60%;
            border-collapse: collapse; /* Usunięcie podwójnych linii */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Cień dla tabeli */
            background-color: white;
        }
        th, td {
            border: 1px solid #ccc; /* Obramowanie komórek */
            padding: 12px; /* Odstępy wewnętrzne */
            text-align: center; /* Wyśrodkowanie tekstu */
        }
        th {
            background-color: gray; /* Kolor tła nagłówków */
            color: white; /* Kolor tekstu nagłówków */
        }
        tr:nth-child(even) {
            background-color: #f9f9f9; /* Kolor tła dla parzystych wierszy */
        }
        tr:hover {
            background-color: #f1f1f1; /* Kolor tła przy najechaniu na wiersz */
        }

    </style>
</head>
<body>

<div class="contact-form">
    <h2>Kontakt</h2>
    <form action="#" method="post">
        <input type="text" name="imie" placeholder="Imię" required>
        <input type="text" name="nazwisko" placeholder="Nazwisko" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <textarea name="tresc" placeholder="Treść wiadomości" required></textarea>
        <button type="submit">Wyślij</button>
    </form>
</div>

<table>
    <tr>
        <th>Dzień</th>
        <th>Godziny pracy sekretariatu</th>
    </tr>
    <tr>
        <td>Poniedziałek</td>
        <td>10:00-16:00</td>
    </tr>
    <tr>
        <td>Wtorek</td>
        <td>9:00-15:00</td>
    </tr>
    <tr>
        <td>Środa</td>
        <td>8:00-14:00</td>
    </tr>
    <tr>
        <td>Czwartek</td>
        <td>9:00-16:00</td>
    </tr>
    <tr>
        <td>Piątek</td>
        <td>10:00-14:30</td>
    </tr>
</table>

<section style="background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 5%;
            margin-left: 0%;
            width: 57.5%;
">

    <p>Zespół Szkół Techniczno-Akustycznych w Szczebrzeszynie</p>
    <p>Szczebrzeszyn, ulica Podlaska 7</p>
    <p>+48 324 972 934</p>
    <p>sekretariat@techakustyk.pl</p>
</section>

</body>
</html>