-- Baza danych: `dziennik_szkolny`

-- --------------------------------------------------------

-- Struktura tabeli dla `aktualnosci`
CREATE TABLE `aktualnosci` (
  `id` int(11) NOT NULL,
  `tytul` varchar(255) NOT NULL,
  `tresc` text NOT NULL,
  `data_dodania` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

-- Struktura tabeli dla `frekwencja`
CREATE TABLE `frekwencja` (
  `id` int(11) NOT NULL,
  `uczen_id` int(11) NOT NULL,
  `przedmiot_id` int(11) NOT NULL,
  `data_lekcji` date NOT NULL,
  `status` enum('obecny','nieobecny','spozniony') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

-- Struktura tabeli dla `klasy`
CREATE TABLE `klasy` (
  `id` int(11) NOT NULL,
  `nazwa_klasy` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

-- Struktura tabeli dla `oceny`
CREATE TABLE `oceny` (
  `id` int(11) NOT NULL,
  `uczen_id` int(11) NOT NULL,
  `przedmiot_id` int(11) NOT NULL,
  `ocena` decimal(2,1) NOT NULL,
  `data_wystawienia` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

-- Struktura tabeli dla `plan_lekcji`
CREATE TABLE `plan_lekcji` (
  `id` int(11) NOT NULL,
  `klasa_id` int(11) NOT NULL,
  `przedmiot_id` int(11) NOT NULL,
  `dzien_tygodnia` varchar(10) NOT NULL,
  `godzina_rozpoczecia` time NOT NULL,
  `godzina_zakonczenia` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

-- Struktura tabeli dla `przedmioty`
CREATE TABLE `przedmioty` (
  `id` int(11) NOT NULL,
  `nazwa_przedmiotu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

-- Struktura tabeli dla `uzytkownicy`
CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `data_urodzenia` date NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `haslo` varchar(255) NOT NULL,
  `typ_uzytkownika` enum('admin','nauczyciel','uczen') NOT NULL,
  `klasa_id` int(11) DEFAULT NULL,
  `przedmiot_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

-- Struktura tabeli dla `uwagi`
CREATE TABLE `uwagi` (
  `id` int(11) NOT NULL,
  `uczen_id` int(11) NOT NULL,
  `nauczyciel_id` int(11) NOT NULL,
  `tresc` text NOT NULL,
  `punkty` int(11) DEFAULT 0,
  `data_dodania` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

-- Struktura tabeli dla `zadania_domowe`
CREATE TABLE `zadania_domowe` (
  `id` int(11) NOT NULL,
  `klasa_id` int(11) NOT NULL,
  `przedmiot_id` int(11) NOT NULL,
  `tresc` text NOT NULL,
  `termin_oddania` date NOT NULL,
  `data_dodania` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

-- Indeksy dla tabeli `aktualnosci`
ALTER TABLE `aktualnosci`
  ADD PRIMARY KEY (`id`);

-- Indeksy dla tabeli `frekwencja`
ALTER TABLE `frekwencja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uczen_id` (`uczen_id`),
  ADD KEY `przedmiot_id` (`przedmiot_id`);

-- Indeksy dla tabeli `klasy`
ALTER TABLE `klasy`
  ADD PRIMARY KEY (`id`);

-- Indeksy dla tabeli `oceny`
ALTER TABLE `oceny`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uczen_id` (`uczen_id`),
  ADD KEY `przedmiot_id` (`przedmiot_id`);

-- Indeksy dla tabeli `plan_lekcji`
ALTER TABLE `plan_lekcji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `klasa_id` (`klasa_id`),
  ADD KEY `przedmiot_id` (`przedmiot_id`);

-- Indeksy dla tabeli `przedmioty`
ALTER TABLE `przedmioty`
  ADD PRIMARY KEY (`id`);

-- Indeksy dla tabeli `uzytkownicy`
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY (`email`),
  ADD KEY `klasa_id` (`klasa_id`),
  ADD KEY `przedmiot_id` (`przedmiot_id`);

-- Indeksy dla tabeli `uwagi`
ALTER TABLE `uwagi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uczen_id` (`uczen_id`),
  ADD KEY `nauczyciel_id` (`nauczyciel_id`);

-- Indeksy dla tabeli `zadania_domowe`
ALTER TABLE `zadania_domowe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `klasa_id` (`klasa_id`),
  ADD KEY `przedmiot_id` (`przedmiot_id`);

--
-- AUTO_INCREMENT dla zrzutów tabel
--

-- AUTO_INCREMENT dla tabeli `aktualnosci`
ALTER TABLE `aktualnosci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT dla tabeli `frekwencja`
ALTER TABLE `frekwencja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT dla tabeli `klasy`
ALTER TABLE `klasy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT dla tabeli `oceny`
ALTER TABLE `oceny`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT dla tabeli `plan_lekcji`
ALTER TABLE `plan_lekcji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT dla tabeli `przedmioty`
ALTER TABLE `przedmioty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT dla tabeli `uzytkownicy`
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT dla tabeli `uwagi`
ALTER TABLE `uwagi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT dla tabeli `zadania_domowe`
ALTER TABLE `zadania_domowe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

-- Ograniczenia dla tabeli `frekwencja`
ALTER TABLE `frekwencja`
  ADD CONSTRAINT `frekwencja_ibfk_1` FOREIGN KEY (`uczen_id`) REFERENCES `uzytkownicy` (`id`),
  ADD CONSTRAINT `frekwencja_ibfk_2` FOREIGN KEY (`przedmiot_id`) REFERENCES `przedmioty` (`id`);

-- Ograniczenia dla tabeli `oceny`
ALTER TABLE `oceny`
  ADD CONSTRAINT `oceny_ibfk_1` FOREIGN KEY (`uczen_id`) REFERENCES `uzytkownicy` (`id`),
  ADD CONSTRAINT `oceny_ibfk_2` FOREIGN KEY (`przedmiot_id`) REFERENCES `przedmioty` (`id`);

-- Ograniczenia dla tabeli `plan_lekcji`
ALTER TABLE `plan_lekcji`
  ADD CONSTRAINT `plan_lekcji_ibfk_1` FOREIGN KEY (`klasa_id`) REFERENCES `klasy` (`id`),
  ADD CONSTRAINT `plan_lekcji_ibfk_2` FOREIGN KEY (`przedmiot_id`) REFERENCES `przedmioty` (`id`);

-- Ograniczenia dla tabeli `uzytkownicy`
ALTER TABLE `uzytkownicy`
  ADD CONSTRAINT `uzytkownicy_ibfk_1` FOREIGN KEY (`klasa_id`) REFERENCES `klasy` (`id`),
  ADD CONSTRAINT `uzytkownicy_ibfk_2` FOREIGN KEY (`przedmiot_id`) REFERENCES `przedmioty` (`id`);

-- Ograniczenia dla tabeli `uwagi`
ALTER TABLE `uwagi`
  ADD CONSTRAINT `uwagi_ibfk_1` FOREIGN KEY (`uczen_id`) REFERENCES `uzytkownicy` (`id`),
  ADD CONSTRAINT `uwagi_ibfk_2` FOREIGN KEY (`nauczyciel_id`) REFERENCES `uzytkownicy` (`id`);

-- Ograniczenia dla tabeli `zadania_domowe`
ALTER TABLE `zadania_domowe`
  ADD CONSTRAINT `zadania_domowe_ibfk_1` FOREIGN KEY (`klasa_id`) REFERENCES `klasy` (`id`),
  ADD CONSTRAINT `zadania_domowe_ibfk_2` FOREIGN KEY (`przedmiot_id`) REFERENCES `przedmioty` (`id`);
COMMIT;

-- Inicjalizacja podstawowych danych
INSERT INTO `klasy` (`id`, `nazwa_klasy`) VALUES
(1, '1A'),
(2, '1B'),
(3, '2A'),
(4, '3A');

INSERT INTO `przedmioty` (`id`, `nazwa_przedmiotu`) VALUES
(1, 'Matematyka'),
(2, 'Język polski'),
(3, 'Język angielski'),
(4, 'Fizyka'),
(5, 'Chemia'),
(6, 'Biologia'),
(7, 'Historia');

INSERT INTO `uzytkownicy` (`id`, `imie`, `nazwisko`, `data_urodzenia`, `email`, `haslo`, `typ_uzytkownika`) VALUES
(1, 'Admin', 'Admin', '2000-01-01', 'admin@szkola.pl', '$2y$10$YXi/nLeEJ6zY4Uy9l/Xo6OVkE6G01Jd9Z3t1cQ25sNbxDqQ7J0FhS', 'admin');