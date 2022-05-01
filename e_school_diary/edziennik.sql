-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 25 Maj 2019, 22:21
-- Wersja serwera: 10.1.38-MariaDB
-- Wersja PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `edziennik`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admini`
--

CREATE TABLE `admini` (
  `id_admina` int(11) NOT NULL,
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `haslo` text COLLATE utf8_polish_ci NOT NULL,
  `haslo_deweloperskie` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `admini`
--

INSERT INTO `admini` (`id_admina`, `login`, `haslo`, `haslo_deweloperskie`) VALUES
(1, 'admin', '$2y$10$vLdhtG4jdd6Qn1W86gr7ruBcCFtHNPJgFwfaRmlphdbFKapAkpeuS', 'admin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `godz_lekcyjne`
--

CREATE TABLE `godz_lekcyjne` (
  `nr_lekcji` int(11) NOT NULL,
  `godz_roz` time NOT NULL,
  `godz_zak` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `godz_lekcyjne`
--

INSERT INTO `godz_lekcyjne` (`nr_lekcji`, `godz_roz`, `godz_zak`) VALUES
(1, '08:00:00', '08:45:00'),
(2, '08:50:00', '09:35:00'),
(3, '09:40:00', '10:25:00'),
(4, '10:35:00', '11:20:00'),
(5, '11:25:00', '12:10:00'),
(6, '12:15:00', '13:00:00'),
(7, '13:15:00', '14:00:00'),
(8, '14:05:00', '14:50:00'),
(9, '14:55:00', '15:40:00'),
(10, '15:45:00', '16:30:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `hasla`
--

CREATE TABLE `hasla` (
  `id_hasla` int(11) NOT NULL,
  `id_usera` int(11) NOT NULL,
  `haslo` text COLLATE utf8_polish_ci NOT NULL,
  `haslo_test` text COLLATE utf8_polish_ci NOT NULL,
  `typ_usera` set('n','u','r') COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `hasla`
--

INSERT INTO `hasla` (`id_hasla`, `id_usera`, `haslo`, `haslo_test`, `typ_usera`) VALUES
(1, 1, '$2y$10$0gxpacYmYQ1feEtKcISLF.9ADWzBsRtiLM6Qn0BTakoA5PvQxvzfW', 'Adam1234', 'n'),
(2, 1, '$2y$10$V.ajrG1rUZtKbOuPMQGJzufRHf6pZ1ZaY6SDyAYcMKHSnqG6OqW/2', 'Stefan123', 'r'),
(3, 1, '$2y$10$HWn28CH35AEw13Z1y0YeFeL2NXWL0btylGfc1UMwaQJZPUTMt8//i', 'Grzesiek123', 'u'),
(4, 2, '$2y$10$FgQrC9xBkRT345ooKR5qV.mnaDk2x8kVHvSG7CQSoeFD7ewvIlBVG', '5cbb9970ade02', 'u'),
(5, 3, '$2y$10$HXX77CSD0izDT61WFGx8POBRIOSoRncvz5v3Kh.7Y5z2DSEf8tRMG', '5ccf3a3840eb2', 'u'),
(6, 4, '$2y$10$gqID8u9x4ACzsfF6oD3rD.8HBCrkO1AEhw7jwUSMLh3H8xiptbCo.', '5cd5f3adf2e52', 'u'),
(7, 2, '$2y$10$Zr2ysK7jLoR1pBvPq9kwkexFvQcKYDmQJ85OLF/m4CkbOJv4fUc9y', '5cdd912f3fd3a', 'r'),
(8, 14, '$2y$10$19ggsWYNoOheODT7iYqQ0OdNVmbw76XNj5kBHzreLIs3UW4Zk.Kyy', '5cdda858e5041', 'r');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klasy`
--

CREATE TABLE `klasy` (
  `id_klasy` int(11) NOT NULL,
  `nazwa_klasy` text COLLATE utf8_polish_ci NOT NULL,
  `rok` int(11) NOT NULL,
  `id_wychowawcy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `klasy`
--

INSERT INTO `klasy` (`id_klasy`, `nazwa_klasy`, `rok`, `id_wychowawcy`) VALUES
(1, '1a', 1, 3),
(2, '1b', 1, 1),
(3, '2a', 2, 5),
(4, '2c', 2, 2),
(5, '3b', 3, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nauczyciele`
--

CREATE TABLE `nauczyciele` (
  `id_nauczyciela` int(11) NOT NULL,
  `imie` text COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` text COLLATE utf8_polish_ci NOT NULL,
  `PESEL` text COLLATE utf8_polish_ci NOT NULL,
  `data_ur` date NOT NULL,
  `miejsce_ur` text COLLATE utf8_polish_ci NOT NULL,
  `miejsce_zam` text COLLATE utf8_polish_ci NOT NULL,
  `telefon` int(11) NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `id_przedmiotu` int(11) NOT NULL,
  `plec` set('k','m') COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `nauczyciele`
--

INSERT INTO `nauczyciele` (`id_nauczyciela`, `imie`, `nazwisko`, `PESEL`, `data_ur`, `miejsce_ur`, `miejsce_zam`, `telefon`, `email`, `id_przedmiotu`, `plec`) VALUES
(1, 'Adam', 'Holmes', '70122597692', '1970-12-25', 'Oleśnica', 'Oleśnica', 734865238, 'adam_n@gmail.com', 2, 'm'),
(2, 'Dariusz', 'Kmicic', '88040288435', '1988-04-02', 'Lublin', 'Bydgoszcz', 467880346, 'dariusz_n@gmail.com', 4, 'm'),
(3, 'Marzena', 'Kowalska', '75082073947', '1975-08-20', 'Warszawa', 'Świdnica', 346789034, 'marzena_n@gmail.com', 5, 'k'),
(4, 'Jan', 'Chrust', '72101524592', '1972-10-15', 'Leszno', 'Lublin', 788530226, 'jan_n@gmail.com', 1, 'm'),
(5, 'Maryla', 'Zysk', '68041193741', '1968-04-11', 'Szczecin', 'Jelenia Góra', 457523356, 'maryla_n@gmail.com', 3, 'k'),
(6, 'Zenon', 'Gagatek', '72120318653', '1972-12-03', 'Bydgoszcz', 'Kraków', 890376702, 'zenon_n@gmail.com', 6, 'm'),
(7, 'Barbara', 'Adaszyńska', '78030125369', '1978-03-01', 'Oława', 'Lublin', 448976387, 'barbara_n@gmail.com', 12, 'k'),
(8, 'Tomek', 'Boruta', '70122553399', '1970-12-25', 'Olsztyn', 'Leszno', 212988760, 'tomek_n@gmail.com', 7, 'm'),
(9, 'Karolina', 'Abak', '62061094646', '1962-06-10', 'Wrocław', 'Poznań', 211897633, 'karolina_n@gmail.com', 8, 'k'),
(11, 'Iza', 'Janasik', '83022444281', '1983-02-24', 'Olsztyn', 'Lublin', 123456789, 'iza_n@gmail.com', 9, 'k'),
(12, 'Michał', 'Boruta', '79020994118', '1979-02-09', 'Gdynia', 'Lublin', 987654321, 'michal_n@gmail.com', 11, 'm');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nazwy_dni`
--

CREATE TABLE `nazwy_dni` (
  `nr_dnia` int(11) NOT NULL,
  `dzien` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `nazwy_dni`
--

INSERT INTO `nazwy_dni` (`nr_dnia`, `dzien`) VALUES
(1, 'poniedziałek'),
(2, 'wtorek'),
(3, 'środa'),
(4, 'czwartek'),
(5, 'piątek');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `obecnosci`
--

CREATE TABLE `obecnosci` (
  `id_obecnosci` int(11) NOT NULL,
  `id_lekcji` int(11) NOT NULL,
  `id_ucznia` int(11) NOT NULL,
  `data` date NOT NULL,
  `typ` set('ob','nob','u','ns','s','su') COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `obecnosci`
--

INSERT INTO `obecnosci` (`id_obecnosci`, `id_lekcji`, `id_ucznia`, `data`, `typ`) VALUES
(1, 1, 3, '2019-04-15', 'ob'),
(2, 1, 1, '2019-05-06', 'nob'),
(3, 8, 1, '2019-05-07', 'u'),
(4, 32, 9, '2019-05-13', 'ns'),
(5, 33, 10, '2019-05-13', 's');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `obecnosc_nazwa`
--

CREATE TABLE `obecnosc_nazwa` (
  `id_rodzaju` int(11) NOT NULL,
  `typ` set('ob','nob','u','ns','s','su') COLLATE utf8_polish_ci NOT NULL,
  `skrot` text COLLATE utf8_polish_ci NOT NULL,
  `nazwa_cala` text COLLATE utf8_polish_ci NOT NULL,
  `kolor` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `obecnosc_nazwa`
--

INSERT INTO `obecnosc_nazwa` (`id_rodzaju`, `typ`, `skrot`, `nazwa_cala`, `kolor`) VALUES
(1, 'ob', '[ob]', 'Obecność', '#FFF'),
(2, 'nob', '[-]', 'Nieobecność', '#ffa687'),
(3, 'u', '[u]', 'Nieobecność usprawiedliwiona', '#fcc150'),
(4, 'ns', '[ns]', 'Nieobecność z przyczyn szkolnych', '#a9c9fd'),
(5, 's', '[s]', 'Spóźnienie', '#ede049'),
(6, 'su', '[su]', 'Spóźnienie usprawiedliwione', '#87a7ff');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oceny`
--

CREATE TABLE `oceny` (
  `id_oceny` int(11) NOT NULL,
  `ocena_int` int(11) NOT NULL,
  `id_ucznia` int(11) NOT NULL,
  `id_nauczyciela` int(11) NOT NULL,
  `id_przedmiotu` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `oceny`
--

INSERT INTO `oceny` (`id_oceny`, `ocena_int`, `id_ucznia`, `id_nauczyciela`, `id_przedmiotu`, `data`) VALUES
(1, 3, 2, 5, 3, '2019-04-15'),
(2, 3, 1, 4, 1, '2019-05-02'),
(3, 4, 6, 5, 3, '2019-03-14'),
(4, 5, 1, 5, 3, '2019-04-24'),
(5, 4, 4, 7, 12, '2019-04-22'),
(6, 1, 6, 7, 12, '2019-04-12'),
(7, 2, 1, 4, 1, '2019-05-06'),
(8, 3, 2, 5, 3, '2019-04-18'),
(9, 6, 3, 11, 9, '2019-04-02'),
(10, 4, 1, 4, 1, '2019-03-15'),
(11, 2, 1, 1, 2, '2019-04-22'),
(12, 4, 1, 5, 3, '2019-03-07'),
(13, 1, 1, 2, 4, '2019-03-07'),
(14, 5, 1, 3, 5, '2019-02-05'),
(15, 3, 1, 6, 6, '2019-03-08'),
(16, 4, 1, 8, 7, '2019-01-09'),
(17, 2, 1, 9, 8, '2019-02-20'),
(18, 5, 1, 11, 9, '2019-01-17'),
(19, 2, 1, 12, 11, '2019-01-08'),
(20, 2, 4, 4, 1, '2019-02-18'),
(21, 4, 4, 7, 12, '2019-01-25'),
(22, 2, 4, 4, 10, '2019-03-12'),
(23, 4, 9, 3, 5, '2019-05-07'),
(24, 2, 10, 7, 1, '2019-05-09');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oceny_nazwy`
--

CREATE TABLE `oceny_nazwy` (
  `ocena_int` int(11) NOT NULL,
  `ocena_str` text COLLATE utf32_polish_ci NOT NULL,
  `ocena_pelna` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_polish_ci;

--
-- Zrzut danych tabeli `oceny_nazwy`
--

INSERT INTO `oceny_nazwy` (`ocena_int`, `ocena_str`, `ocena_pelna`) VALUES
(1, 'ndst', 'niedostateczny'),
(2, 'dop', 'dopuszczający'),
(3, 'dst', 'dostateczny'),
(4, 'db', 'dobry'),
(5, 'bdb', 'bardzo dobry'),
(6, 'cel', 'celujący');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opisy_ocen`
--

CREATE TABLE `opisy_ocen` (
  `id_opisu` int(11) NOT NULL,
  `id_oceny` int(11) NOT NULL,
  `opis` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `opisy_ocen`
--

INSERT INTO `opisy_ocen` (`id_opisu`, `id_oceny`, `opis`) VALUES
(1, 1, 'Sprawdzian - czasy przeszłe'),
(2, 4, 'Sprawdzian');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opisy_spr`
--

CREATE TABLE `opisy_spr` (
  `id_opisu` int(11) NOT NULL,
  `id_spr` int(11) NOT NULL,
  `opis` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `opisy_spr`
--

INSERT INTO `opisy_spr` (`id_opisu`, `id_spr`, `opis`) VALUES
(3, 2, 'Dział 3 - gęstość i natężenie; pierwiastki');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plan_lekcji`
--

CREATE TABLE `plan_lekcji` (
  `id_lekcji` int(11) NOT NULL,
  `nr_dnia` int(11) NOT NULL,
  `nr_lekcji` int(11) NOT NULL,
  `id_klasy` int(11) NOT NULL,
  `id_nauczyciela` int(11) NOT NULL,
  `id_sali` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `plan_lekcji`
--

INSERT INTO `plan_lekcji` (`id_lekcji`, `nr_dnia`, `nr_lekcji`, `id_klasy`, `id_nauczyciela`, `id_sali`) VALUES
(1, 1, 1, 1, 1, 2),
(2, 1, 2, 1, 1, 2),
(3, 1, 3, 1, 6, 6),
(4, 1, 4, 1, 4, 1),
(5, 1, 5, 1, 3, 5),
(6, 1, 6, 1, 3, 5),
(7, 1, 7, 1, 12, 11),
(8, 2, 3, 1, 4, 1),
(9, 2, 4, 1, 5, 3),
(10, 2, 5, 1, 1, 2),
(11, 2, 6, 1, 8, 7),
(12, 2, 7, 1, 11, 9),
(13, 2, 8, 1, 11, 9),
(14, 3, 2, 1, 5, 3),
(15, 3, 3, 1, 12, 11),
(16, 3, 4, 1, 2, 4),
(17, 3, 5, 1, 4, 1),
(18, 3, 6, 1, 6, 6),
(19, 3, 7, 1, 9, 8),
(20, 4, 2, 1, 3, 5),
(21, 4, 3, 1, 7, 12),
(22, 4, 4, 1, 1, 2),
(23, 4, 5, 1, 9, 8),
(24, 4, 6, 1, 8, 7),
(25, 5, 1, 1, 11, 9),
(26, 5, 2, 1, 11, 9),
(27, 5, 3, 1, 4, 1),
(28, 5, 4, 1, 2, 4),
(29, 5, 5, 1, 1, 2),
(30, 5, 6, 1, 12, 11),
(31, 5, 7, 1, 5, 3),
(32, 1, 2, 2, 8, 7),
(33, 1, 3, 2, 1, 2),
(34, 1, 4, 2, 3, 5),
(35, 1, 5, 2, 4, 1),
(36, 1, 6, 2, 12, 11),
(37, 1, 7, 2, 5, 3),
(38, 2, 1, 2, 6, 6),
(39, 2, 2, 2, 4, 1),
(40, 2, 3, 2, 5, 3),
(41, 2, 4, 2, 1, 2),
(42, 2, 5, 2, 11, 9),
(43, 2, 6, 2, 11, 9),
(44, 3, 2, 2, 12, 11),
(45, 3, 3, 2, 2, 4),
(46, 3, 4, 2, 1, 2),
(47, 3, 5, 2, 6, 6),
(48, 3, 6, 2, 9, 8),
(49, 4, 1, 2, 4, 1),
(50, 4, 2, 2, 7, 12),
(51, 4, 3, 2, 1, 2),
(52, 4, 4, 2, 9, 8),
(53, 4, 5, 2, 1, 2),
(54, 4, 6, 2, 5, 3),
(55, 4, 7, 2, 8, 7),
(56, 5, 2, 2, 3, 5),
(57, 5, 3, 2, 11, 9),
(58, 5, 4, 2, 11, 9),
(59, 5, 5, 2, 4, 1),
(60, 5, 6, 2, 2, 4),
(61, 5, 7, 2, 1, 2),
(62, 5, 8, 2, 12, 11);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przedmioty`
--

CREATE TABLE `przedmioty` (
  `id_przedmiotu` int(11) NOT NULL,
  `nazwa` text COLLATE utf8_polish_ci NOT NULL,
  `nazwa_cala` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `przedmioty`
--

INSERT INTO `przedmioty` (`id_przedmiotu`, `nazwa`, `nazwa_cala`) VALUES
(1, 'matematyka', 'Matematyka'),
(2, 'j.polski', 'Język polski'),
(3, 'j.angielski', 'Język angielski'),
(4, 'j.niemiecki', 'Język niemiecki'),
(5, 'chemia', 'Chemia'),
(6, 'geografia', 'Geografia'),
(7, 'fizyka', 'Fizyka'),
(8, 'religia', 'Religia'),
(9, 'wf', 'Wychowanie fizyczne'),
(10, 'l.wychowawcza', 'Zachowanie'),
(11, 'historia', 'Historia'),
(12, 'wos', 'Wiedza o społeczeństwie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rodzice`
--

CREATE TABLE `rodzice` (
  `id_rodzica` int(11) NOT NULL,
  `imie` text COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` text COLLATE utf8_polish_ci NOT NULL,
  `PESEL` text COLLATE utf8_polish_ci NOT NULL,
  `data_ur` date NOT NULL,
  `miejsce_ur` text COLLATE utf8_polish_ci NOT NULL,
  `miejsce_zam` text COLLATE utf8_polish_ci NOT NULL,
  `telefon` int(11) NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `plec` set('k','m') COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `rodzice`
--

INSERT INTO `rodzice` (`id_rodzica`, `imie`, `nazwisko`, `PESEL`, `data_ur`, `miejsce_ur`, `miejsce_zam`, `telefon`, `email`, `plec`) VALUES
(1, 'Stefan', 'Inny', '68072064915', '1968-07-20', 'Szczecin', 'Wrocław', 632458991, 'stefan_r@gmail.com', 'm'),
(2, 'Stanisław', 'Potocki', '81090181833', '1981-09-01', 'Poznań', 'Gdynia', 933067521, 'stanislaw_r@gmail.com', 'm'),
(3, 'Zenon', 'Sasim', '80122583915', '1980-12-25', 'Czernica', 'Lublin', 266784307, 'zenon_r@gmail.com', 'm'),
(4, 'Krzysztof', 'Mater', '75070963696', '1975-07-09', 'Oleśnica', 'Lublin', 888525674, 'krzysztof_r@gmail.com', 'm'),
(5, 'Anna', 'Kazimierz', '83110922763', '1983-11-09', 'Kraków', 'Jelenia Góra', 338829045, 'anna_r@gmail.com', 'k'),
(6, 'Anna', 'Babiarz', '83040775361', '1983-04-07', 'Warszawa', 'Leszno', 377248894, 'anna2_r@gmail.com', 'k'),
(7, 'Karol', 'Golanczyk', '74032782595', '1974-03-27', 'Wrocław', 'Oleśnica', 278856924, 'karol_r@gmail.com', 'm'),
(8, 'Jan', 'Smith', '86012298477', '1986-01-22', 'Wrocław', 'Kraków', 873686239, 'jan_r@gmail.com', 'm'),
(9, 'Ewa', 'Kaczan', '79091172882', '1979-09-11', 'Kraków', 'Poznań', 582662491, 'ewa_r@gmail.com', 'k'),
(10, 'Helena', 'Lysiak', '85051039467', '1985-05-10', 'Ziebice', 'Szczecin', 642224989, 'helena_r@gmail.com', 'k'),
(11, 'Karol', 'Gates', '82051819534', '1982-05-18', 'Wachock', 'Poznań', 788365923, 'karol2_r@gmail.com', 'm'),
(12, 'Jacek', 'Soplica', '80061925216', '1980-06-19', 'Leszno', 'Bydgoszcz', 278896537, 'jacek_r@gmail.com', 'm'),
(13, 'Roman', 'Mieta', '78031798135', '1978-03-17', 'Świdnica', 'Olsztyn', 777456629, 'roman_r@gmail.com', 'm'),
(14, 'Monika', 'Jasiak', '83030818225', '1983-03-08', 'Gdańsk', 'Oleśnica', 566538939, 'monika_r@gmail.com', 'k'),
(15, 'Igor', 'Mazurowski', '82061083671', '1982-06-10', 'Kłodzko', 'Poznań', 766289461, 'igor_r@gmail.com', 'm'),
(16, 'Barbara', 'Kilarska', '83071523386', '1983-07-15', 'Wrocław', 'Wrocław', 288918762, 'barbara_r@gmail.com', 'k'),
(17, 'Kamil', 'Wanik', '75032758476', '1975-03-27', 'Lublin', 'Gdynia', 293847560, 'kamil_r@gmail.com', 'm'),
(18, 'Julian', 'Lisowski', '79122879975', '1979-12-28', 'Walbrzych', 'Szczecin', 122290047, 'julian_r@gmail.com', 'm');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sale`
--

CREATE TABLE `sale` (
  `id_sali` int(11) NOT NULL,
  `nazwa` text COLLATE utf8_polish_ci NOT NULL,
  `id_przedmiotu` int(11) NOT NULL,
  `id_opiekuna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `sale`
--

INSERT INTO `sale` (`id_sali`, `nazwa`, `id_przedmiotu`, `id_opiekuna`) VALUES
(1, 's5', 1, 4),
(2, 's6', 2, 1),
(3, 's7', 3, 5),
(4, 's8', 4, 2),
(5, 's9', 5, 3),
(6, 's12', 6, 6),
(7, 's13', 7, 8),
(8, 's14', 8, 9),
(9, 'sg', 9, 11),
(11, 's16', 11, 12),
(12, 's17', 12, 7);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sprawdziany`
--

CREATE TABLE `sprawdziany` (
  `id_spr` int(11) NOT NULL,
  `id_klasy` int(11) NOT NULL,
  `id_przedmiotu` int(11) NOT NULL,
  `rodzaj` text COLLATE utf8_polish_ci NOT NULL,
  `id_nauczyciela` int(11) NOT NULL,
  `data_spr` date NOT NULL,
  `data_wpisu` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `sprawdziany`
--

INSERT INTO `sprawdziany` (`id_spr`, `id_klasy`, `id_przedmiotu`, `rodzaj`, `id_nauczyciela`, `data_spr`, `data_wpisu`) VALUES
(1, 1, 1, 'kartkówka', 4, '2019-05-01', '2019-04-15'),
(2, 1, 5, 'sprawdzian', 3, '2019-06-06', '2019-05-23');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szkola`
--

CREATE TABLE `szkola` (
  `nazwa` text COLLATE utf8_polish_ci NOT NULL,
  `adres` text COLLATE utf8_polish_ci NOT NULL,
  `telefon` int(11) NOT NULL,
  `imie_dyr` text COLLATE utf8_polish_ci NOT NULL,
  `nazwisko_dyr` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `szkola`
--

INSERT INTO `szkola` (`nazwa`, `adres`, `telefon`, `imie_dyr`, `nazwisko_dyr`) VALUES
('Przykładowa Szkoła Podstawowa (Gimnazjum)', 'ul. Długa 56, 34-100 Wadowice, Polska', 335901289, 'Włodzimierz', 'Dyrski');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uczniowie`
--

CREATE TABLE `uczniowie` (
  `id_ucznia` int(11) NOT NULL,
  `imie` text COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` text COLLATE utf8_polish_ci NOT NULL,
  `PESEL` text COLLATE utf8_polish_ci NOT NULL,
  `data_ur` date NOT NULL,
  `miejsce_ur` text COLLATE utf8_polish_ci NOT NULL,
  `miejsce_zam` text COLLATE utf8_polish_ci NOT NULL,
  `telefon` int(11) NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `id_klasy` int(11) NOT NULL,
  `id_rodzica` int(11) NOT NULL,
  `plec` set('k','m') COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uczniowie`
--

INSERT INTO `uczniowie` (`id_ucznia`, `imie`, `nazwisko`, `PESEL`, `data_ur`, `miejsce_ur`, `miejsce_zam`, `telefon`, `email`, `id_klasy`, `id_rodzica`, `plec`) VALUES
(1, 'Grzegorz', 'Inny', '05241686211', '2005-04-16', 'Wrocław', 'Wrocław', 989937278, 'grzegorz_u@gmail.com', 1, 1, 'm'),
(2, 'Katarzyna', 'Sasim', '05310681781', '2005-11-06', 'Lublin', 'Lublin', 983678002, 'kasia_u@gmail.com', 2, 3, 'k'),
(3, 'Jakub', 'Kazimierz', '05252243997', '2005-05-22', 'Kraków', 'Jelenia Góra', 678829651, 'jakub_u@gmail.com', 2, 5, 'm'),
(4, 'Julia', 'Golanczyk', '05291186846', '2005-09-11', 'Oleśnica', 'Oleśnica', 444678882, 'julia_u@gmail.com', 1, 7, 'k'),
(5, 'Aleksandra', 'Jasiak', '05220541728', '2005-02-05', 'Oleśnica', 'Oleśnica', 892776190, 'aleksandra_u@gmail.com', 2, 14, 'k'),
(6, 'Mateusz', 'Soplica', '05262463837', '2005-06-24', 'Bydgoszcz', 'Bydgoszcz', 988727337, 'mateusz_u@gmail.com', 1, 12, 'm'),
(7, 'Wiktoria', 'Lysiak', '05301631128', '2005-10-16', 'Szczecin', 'Szczecin', 980026234, 'wiktoria_u@gmail.com', 2, 10, 'k'),
(8, 'Zuzanna', 'Smith', '05221321628', '2005-02-13', 'Wrocław', 'Kraków', 555819233, 'zuzia_u@gmail.com', 2, 8, 'k'),
(9, 'Bartek', 'Potocki', '05300982935', '2005-10-09', 'Gdynia', 'Gdynia', 233789179, 'bartek_u@gmail.com', 2, 2, 'm'),
(10, 'Jan', 'Potocki', '05242577273', '2005-04-25', 'Gdynia', 'Gdynia', 899932221, 'jan_u@gmail.com', 2, 2, 'm'),
(11, 'Michał', 'Mater', '05320182757', '2005-12-01', 'Lublin', 'Lublin', 227888946, 'michal_u@gmail.com', 1, 4, 'm'),
(12, 'Natalia', 'Babiarz', '05293076363', '2005-09-30', 'Leszno', 'Leszno', 287900123, 'natalia_u@gmail.com', 1, 6, 'k'),
(13, 'Maja', 'Mazurowska', '05230325686', '2005-03-03', 'Poznań', 'Poznań', 222900987, 'maja_u@gmail.com', 1, 15, 'k'),
(14, 'Maciej', 'Mieta', '05241936897', '2005-04-19', 'Olsztyn', 'Olsztyn', 992100289, 'maciej_u@gmail.com', 2, 13, 'm'),
(15, 'Piotr', 'Gates', '05303151394', '2005-10-31', 'Kraków', 'Poznań', 121189873, 'piotr_u@gmail.com', 1, 11, 'm'),
(16, 'Oliwia', 'Kaczan', '05221589284', '2005-02-15', 'Poznań', 'Poznań', 122988789, 'oliwia_u@gmail.com', 2, 9, 'k'),
(17, 'Szymon', 'Lysiak', '03233089833', '2003-03-30', 'Szczecin', 'Szczecin', 333789871, 'szymon_u@gmail.com', 5, 10, 'm'),
(18, 'Anna', 'Jasiak', '03300945727', '2003-11-09', 'Oleśnica', 'Oleśnica', 122345432, 'anna_u@gmail.com', 5, 14, 'k'),
(19, 'Filip', 'Wanik', '03242141597', '2003-04-21', 'Gdynia', 'Gdynia', 938109206, 'filip_u@gmail.com', 5, 17, 'm'),
(20, 'Zofia', 'Lisowska', '03211985542', '2003-01-19', 'Szczecin', 'Szczecin', 228178471, 'zosia_u@gmail.com', 5, 18, 'k'),
(21, 'Magdalena', 'Kilarska', '03292079165', '2003-09-20', 'Kraków', 'Wrocław', 192948701, 'magda_u@gmail.com', 5, 16, 'k');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uwagi`
--

CREATE TABLE `uwagi` (
  `id_uwagi` int(11) NOT NULL,
  `id_ucznia` int(11) NOT NULL,
  `id_nauczyciela` int(11) NOT NULL,
  `rodzaj` set('Pozytywna','Negatywna') COLLATE utf8_polish_ci NOT NULL,
  `tresc` text COLLATE utf8_polish_ci NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uwagi`
--

INSERT INTO `uwagi` (`id_uwagi`, `id_ucznia`, `id_nauczyciela`, `rodzaj`, `tresc`, `data`) VALUES
(1, 10, 1, 'Pozytywna', 'Brał udział w dniach otwartych szkoły', '2019-04-15'),
(2, 1, 3, 'Negatywna', 'Przeszkadzał na lekcji', '2019-04-09'),
(3, 1, 6, 'Pozytywna', 'Pomógł posprzątać salę gimnastyczną po zakończeniu przedstawienia', '2019-04-22');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `admini`
--
ALTER TABLE `admini`
  ADD PRIMARY KEY (`id_admina`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `godz_lekcyjne`
--
ALTER TABLE `godz_lekcyjne`
  ADD PRIMARY KEY (`nr_lekcji`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `hasla`
--
ALTER TABLE `hasla`
  ADD PRIMARY KEY (`id_hasla`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `klasy`
--
ALTER TABLE `klasy`
  ADD PRIMARY KEY (`id_klasy`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `nauczyciele`
--
ALTER TABLE `nauczyciele`
  ADD PRIMARY KEY (`id_nauczyciela`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `nazwy_dni`
--
ALTER TABLE `nazwy_dni`
  ADD PRIMARY KEY (`nr_dnia`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `obecnosci`
--
ALTER TABLE `obecnosci`
  ADD PRIMARY KEY (`id_obecnosci`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `obecnosc_nazwa`
--
ALTER TABLE `obecnosc_nazwa`
  ADD PRIMARY KEY (`id_rodzaju`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `oceny`
--
ALTER TABLE `oceny`
  ADD PRIMARY KEY (`id_oceny`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `oceny_nazwy`
--
ALTER TABLE `oceny_nazwy`
  ADD PRIMARY KEY (`ocena_int`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `opisy_ocen`
--
ALTER TABLE `opisy_ocen`
  ADD PRIMARY KEY (`id_opisu`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `opisy_spr`
--
ALTER TABLE `opisy_spr`
  ADD PRIMARY KEY (`id_opisu`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `plan_lekcji`
--
ALTER TABLE `plan_lekcji`
  ADD PRIMARY KEY (`id_lekcji`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  ADD PRIMARY KEY (`id_przedmiotu`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `rodzice`
--
ALTER TABLE `rodzice`
  ADD PRIMARY KEY (`id_rodzica`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id_sali`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `sprawdziany`
--
ALTER TABLE `sprawdziany`
  ADD PRIMARY KEY (`id_spr`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `uczniowie`
--
ALTER TABLE `uczniowie`
  ADD PRIMARY KEY (`id_ucznia`) KEY_BLOCK_SIZE=11;

--
-- Indeksy dla tabeli `uwagi`
--
ALTER TABLE `uwagi`
  ADD PRIMARY KEY (`id_uwagi`) KEY_BLOCK_SIZE=11;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `admini`
--
ALTER TABLE `admini`
  MODIFY `id_admina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `godz_lekcyjne`
--
ALTER TABLE `godz_lekcyjne`
  MODIFY `nr_lekcji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `hasla`
--
ALTER TABLE `hasla`
  MODIFY `id_hasla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `klasy`
--
ALTER TABLE `klasy`
  MODIFY `id_klasy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `nauczyciele`
--
ALTER TABLE `nauczyciele`
  MODIFY `id_nauczyciela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `nazwy_dni`
--
ALTER TABLE `nazwy_dni`
  MODIFY `nr_dnia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `obecnosci`
--
ALTER TABLE `obecnosci`
  MODIFY `id_obecnosci` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `obecnosc_nazwa`
--
ALTER TABLE `obecnosc_nazwa`
  MODIFY `id_rodzaju` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `oceny`
--
ALTER TABLE `oceny`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT dla tabeli `oceny_nazwy`
--
ALTER TABLE `oceny_nazwy`
  MODIFY `ocena_int` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `opisy_ocen`
--
ALTER TABLE `opisy_ocen`
  MODIFY `id_opisu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `opisy_spr`
--
ALTER TABLE `opisy_spr`
  MODIFY `id_opisu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `plan_lekcji`
--
ALTER TABLE `plan_lekcji`
  MODIFY `id_lekcji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  MODIFY `id_przedmiotu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `rodzice`
--
ALTER TABLE `rodzice`
  MODIFY `id_rodzica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `sale`
--
ALTER TABLE `sale`
  MODIFY `id_sali` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `sprawdziany`
--
ALTER TABLE `sprawdziany`
  MODIFY `id_spr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `uczniowie`
--
ALTER TABLE `uczniowie`
  MODIFY `id_ucznia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `uwagi`
--
ALTER TABLE `uwagi`
  MODIFY `id_uwagi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
