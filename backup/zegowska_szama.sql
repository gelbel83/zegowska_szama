-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2026 at 04:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zegowska_szama`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategoria`
--

CREATE TABLE `kategoria` (
  `id` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kategoria`
--

INSERT INTO `kategoria` (`id`, `nazwa`) VALUES
(1, 'Kawa'),
(2, 'Napoje'),
(3, 'Bułki'),
(4, 'Na ciepło');

-- --------------------------------------------------------

--
-- Table structure for table `produkt`
--

CREATE TABLE `produkt` (
  `id` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `kategoria_id` int(10) UNSIGNED NOT NULL,
  `cena` float NOT NULL,
  `dostepnosc` tinyint(1) NOT NULL,
  `promocja` float NOT NULL,
  `zdjecie` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `produkt`
--

INSERT INTO `produkt` (`id`, `nazwa`, `kategoria_id`, `cena`, `dostepnosc`, `promocja`, `zdjecie`) VALUES
(1, 'Espresso', 1, 1.52, 1, 0, 'espresso.jpg'),
(2, 'Espresso Macchiato', 1, 2.5, 1, 50, 'espresso_macchiato.jpg'),
(3, 'Kawa czarna', 1, 2, 1, 0, 'czarna.jpg'),
(4, 'Kawa biała', 1, 2.5, 1, 0, 'biala.jpg'),
(5, 'Cappuccino', 1, 3.5, 1, 0, 'cappuccino.png'),
(6, 'Latte macchiato', 1, 3.5, 1, 0, 'latte_macchiato.jpg'),
(8, 'Double shot espresso', 1, 3.5, 1, 100, 'double_shot_espresso.jpg'),
(9, 'Tymbark karton 1L', 2, 4.5, 1, 0, 'tymbark_karton_1l.jpg'),
(10, 'Woda gazowana', 2, 2.5, 1, 0, 'woda_gazowana.jpg'),
(12, 'Tymbark 2L', 2, 5, 1, 0, 'tymbark_2l.jpg'),
(13, 'Tymbark szkło 0.25L', 2, 2.5, 1, 0, 'tymbark_szklo_025l.jpg'),
(14, 'Tymbark plastik 0.5L', 2, 3, 1, 0, 'tymbark_plastik_05l.webp'),
(15, 'Herbata', 2, 2.5, 1, 0, 'herbata.webp'),
(16, 'Bułka Gołosza', 3, 4, 1, 0, 'bulka_golosza.jpg'),
(17, 'Bułka Ser', 3, 3, 1, 0, 'bulka_ser.jpg'),
(18, 'Bułka Szynka', 3, 3, 1, 0, 'bulka_szynka.jpg'),
(19, 'Bułka Szynka Ser', 3, 4, 1, 0, 'bulka_szynka_ser.jpg'),
(21, 'Bułka Masło', 3, 2, 1, 0, 'bulka_maslo.jpg'),
(22, 'Bułka Sucha', 3, 1.5, 1, 0, 'bulka_sucha.png'),
(23, 'Bułka Ciemna', 3, 4, 1, 0, 'bulka_ciemna.jpg'),
(24, 'Hot-dog', 4, 6, 1, 25, 'hot_dog.webp'),
(25, 'Double-dog', 4, 8, 1, 0, 'double_dog.webp'),
(26, 'Tost ser', 4, 2.5, 1, 0, 'tost_ser.jpg'),
(27, 'Tost szynka', 4, 2.5, 1, 0, 'tost_szynka.jpg'),
(28, 'Tost masło', 4, 1.5, 1, 0, 'tost_maslo.jpg'),
(29, 'Tost ser szynka', 4, 4, 1, 0, 'tost_ser_szynka.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `nazwa`) VALUES
(1, 'Oczekujące'),
(2, 'W przygotowaniu'),
(3, 'Gotowe'),
(4, 'Odebrane');

-- --------------------------------------------------------

--
-- Table structure for table `uprawnienia`
--

CREATE TABLE `uprawnienia` (
  `id` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `uprawnienia`
--

INSERT INTO `uprawnienia` (`id`, `nazwa`) VALUES
(1, 'użytkownik'),
(2, 'administrator');

-- --------------------------------------------------------

--
-- Table structure for table `uzytkownik`
--

CREATE TABLE `uzytkownik` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `imie` varchar(40) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `uprawnienia_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `uzytkownik`
--

INSERT INTO `uzytkownik` (`id`, `login`, `email`, `haslo`, `imie`, `nazwisko`, `uprawnienia_id`) VALUES
(1, 'admin', 'admin@zeg.pl', '5f58af6b2290f825c0fc5b04823f8bd18f2e784d', 'Konrad', 'Goliński', 2),
(4, 'gunk', 'gunk@zeg.pl', 'eee440bfbe0801ec3f533f897c1d55e6a5afd5cd', 'Gunk', 'Glubownik', 1),
(5, 'SA', 'dupa@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'persona ', 'Goliński', 2);

-- --------------------------------------------------------

--
-- Table structure for table `zamowienie`
--

CREATE TABLE `zamowienie` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_zamowienia` date NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `uzytkownik_id` int(10) UNSIGNED NOT NULL,
  `cena` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `zamowienie`
--

INSERT INTO `zamowienie` (`id`, `data_zamowienia`, `status_id`, `uzytkownik_id`, `cena`) VALUES
(3, '2026-05-29', 1, 5, 78.5),
(4, '2026-05-29', 1, 5, 9),
(5, '2026-05-29', 1, 5, 45),
(6, '2026-05-29', 1, 1, 26),
(7, '2026-05-29', 1, 1, 5),
(8, '2026-05-29', 1, 1, 34.5),
(9, '2026-05-29', 1, 1, 2.5),
(10, '2026-05-29', 1, 1, 2.5),
(11, '2026-05-29', 1, 1, 15.5),
(12, '2026-05-29', 1, 1, 10.5),
(13, '2026-05-29', 1, 1, 27.5),
(14, '2026-05-29', 1, 1, 2.5),
(15, '2026-05-29', 1, 1, 2.5),
(16, '2026-05-29', 1, 1, 8),
(17, '2026-05-29', 1, 5, 2.4875),
(18, '2026-05-29', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `zawartosc_zamowienia`
--

CREATE TABLE `zawartosc_zamowienia` (
  `id` int(10) UNSIGNED NOT NULL,
  `ilosc` int(10) UNSIGNED NOT NULL,
  `zamowienie_id` int(10) UNSIGNED NOT NULL,
  `produkt_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `zawartosc_zamowienia`
--

INSERT INTO `zawartosc_zamowienia` (`id`, `ilosc`, `zamowienie_id`, `produkt_id`) VALUES
(1, 7, 3, 25),
(2, 1, 3, 26),
(3, 8, 3, 27),
(4, 1, 4, 26),
(5, 2, 4, 27),
(6, 1, 4, 28),
(7, 18, 5, 27),
(8, 1, 6, 21),
(9, 1, 6, 22),
(10, 1, 6, 23),
(11, 1, 6, 26),
(12, 1, 6, 27),
(13, 9, 6, 28),
(14, 1, 7, 26),
(15, 1, 7, 27),
(16, 2, 8, 24),
(17, 2, 8, 25),
(18, 2, 8, 27),
(19, 1, 8, 28),
(20, 1, 9, 27),
(21, 1, 10, 27),
(22, 1, 11, 25),
(23, 1, 11, 26),
(24, 2, 11, 27),
(25, 1, 12, 19),
(26, 1, 12, 26),
(27, 1, 12, 27),
(28, 1, 12, 28),
(29, 1, 13, 26),
(30, 10, 13, 27),
(31, 1, 14, 26),
(32, 1, 15, 27),
(33, 1, 16, 2),
(34, 1, 16, 3),
(35, 1, 16, 8),
(36, 1, 17, 2),
(37, 8, 18, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produkt`
--
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategoria_id` (`kategoria_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uprawnienia`
--
ALTER TABLE `uprawnienia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `uprawnienia_id` (`uprawnienia_id`);

--
-- Indexes for table `zamowienie`
--
ALTER TABLE `zamowienie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `zawartosc_zamowienia`
--
ALTER TABLE `zawartosc_zamowienia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zamowienie_id` (`zamowienie_id`),
  ADD KEY `produkt_id` (`produkt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `produkt`
--
ALTER TABLE `produkt`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `uprawnienia`
--
ALTER TABLE `uprawnienia`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `zamowienie`
--
ALTER TABLE `zamowienie`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `zawartosc_zamowienia`
--
ALTER TABLE `zawartosc_zamowienia`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produkt`
--
ALTER TABLE `produkt`
  ADD CONSTRAINT `produkt_ibfk_1` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria` (`id`);

--
-- Constraints for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD CONSTRAINT `uzytkownik_ibfk_1` FOREIGN KEY (`uprawnienia_id`) REFERENCES `uprawnienia` (`id`);

--
-- Constraints for table `zamowienie`
--
ALTER TABLE `zamowienie`
  ADD CONSTRAINT `zamowienie_ibfk_1` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownik` (`id`),
  ADD CONSTRAINT `zamowienie_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Constraints for table `zawartosc_zamowienia`
--
ALTER TABLE `zawartosc_zamowienia`
  ADD CONSTRAINT `zawartosc_zamowienia_ibfk_1` FOREIGN KEY (`zamowienie_id`) REFERENCES `zamowienie` (`id`),
  ADD CONSTRAINT `zawartosc_zamowienia_ibfk_2` FOREIGN KEY (`produkt_id`) REFERENCES `produkt` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
