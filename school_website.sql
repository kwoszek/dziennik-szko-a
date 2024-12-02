-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 10:46 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_website`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `teacher` varchar(255) NOT NULL,
  `grade` varchar(2) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject`, `teacher`, `grade`, `semester`, `date`) VALUES
(13, 1, 'Matematyka', 'Jan Kowalski', '5', 'Semestr 1', '2024-01-15'),
(14, 1, 'Matematyka', 'Jan Kowalski', '4', 'Semestr 2', '2024-06-15'),
(15, 3, 'Fizyka', 'Anna Nowak', '3', 'Semestr 1', '2024-01-20'),
(16, 3, 'Chemia', 'Maria Wiśniewska', '5', 'Semestr 1', '2024-02-10');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `content_short` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `created_at`, `content_short`) VALUES
(1, 'Wycieczka szkolna', 'W piątek odbędzie się wycieczka do muzeum. Więcej informacji znajdziecie w szczegółach.', '2024-11-25 09:57:35', 'W piątek odbędzie się wycieczka do muzeum.'),
(2, 'Zebranie rodziców', 'Zapraszamy rodziców na zebranie, które odbędzie się w sali gimnastycznej. Kliknij, aby dowiedzieć się więcej.', '2024-11-25 09:57:35', 'Zapraszamy rodziców na zebranie w sali gimnastycznej.'),
(3, 'Dzień otwarty', 'Zapraszamy na dzień otwarty naszej szkoły, który odbędzie się w najbliższą sobotę. Będzie to świetna okazja, aby poznać nauczycieli, uczniów i zobaczyć naszą placówkę w akcji!', '2024-11-25 09:57:50', 'Zapraszamy na dzień otwarty naszej szkoły.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','parent','teacher', 'admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Krzysztof Woszek', 'k.w@s.s', '$2y$10$Bvj4zijU3gIjPTAoiPlD6O/XigBr5zgEPvUG9hQOrwFgGFFmQfn.K', 'student'),
(3, 'Krzysztof Woszek', 'woszekkrzys@gmail.com', '$2y$10$d5n366CpFHUKLoQ7uYfxe.jC5rDO4ny/Ze2z/ZJLY/9qhOjamwmIq', 'student');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indeksy dla tabeli `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
