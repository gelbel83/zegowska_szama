-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 28, 2026 at 06:19 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

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
-- Struktura tabeli dla tabeli `produkt`
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
(1, 'Espresso', 1, 1.5, 1, 0, 'espresso.jpg'),
(2, 'Espresso Macchiato', 1, 2.5, 1, 0, 'espresso_macchiato.jpg'),
(3, 'Kawa czarna', 1, 2, 1, 0, 'czarna.jpg'),
(4, 'Kawa biała', 1, 2.5, 1, 0, 'biala.jpg'),
(5, 'Cappuccino', 1, 3.5, 1, 0, 'cappuccino.jpg'),
(6, 'Latte macchiato', 1, 3.5, 1, 0, 'latte_macchiato.jpg'),
(8, 'Double shot espresso', 1, 3.5, 1, 0, 'double_shot_espresso.jpg'),
(9, 'Tymbark karton 1L', 2, 4.5, 1, 0, 'tymbark_karton_1l.jpg'),
(10, 'Woda gazowana', 2, 2.5, 1, 0, 'woda_gazowana.jpg'),
(12, 'Tymbark 2L', 2, 5, 1, 0, 'tymbark_2l.jpg'),
(13, 'Tymbark szkło 0.25L', 2, 2.5, 1, 0, 'tymbark_szklo_025l.jpg'),
(14, 'Tymbark plastik 0.5L', 2, 3, 1, 0, 'tymbark_plastik_05l.jpg'),
(15, 'Herbata', 2, 2.5, 1, 0, 'herbata.jpg'),
(16, 'Bułka Gołosza', 3, 4, 1, 0, 'bulka_golosza.jpg'),
(17, 'Bułka Ser', 3, 3, 1, 0, 'bulka_ser.jpg'),
(18, 'Bułka Szynka', 3, 3, 1, 0, 'bulka_szynka.jpg'),
(19, 'Bułka Szynka Ser', 3, 4, 1, 0, 'bulka_szynka_ser.jpg'),
(20, 'Bułka Sos', 3, 1, 1, 0, 'bulka_sos.jpg'),
(21, 'Bułka Masło', 3, 2, 1, 0, 'bulka_maslo.jpg'),
(22, 'Bułka Sucha', 3, 1.5, 1, 0, 'bulka_sucha.jpg'),
(23, 'Bułka Ciemna', 3, 4, 1, 0, 'bulka_ciemna.jpg'),
(24, 'Hot-dog', 4, 6, 1, 0, 'hot_dog.jpg'),
(25, 'Double-dog', 4, 8, 1, 0, 'double_dog.jpg'),
(26, 'Tost ser', 4, 2.5, 1, 0, 'tost_ser.jpg'),
(27, 'Tost szynka', 4, 2.5, 1, 0, 'tost_szynka.jpg'),
(28, 'Tost masło', 4, 1.5, 1, 0, 'tost_maslo.jpg'),
(29, 'Tost ser szynka', 4, 4, 1, 0, 'tost_ser_szynka.jpg');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `produkt`
--
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategoria_id` (`kategoria_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produkt`
--
ALTER TABLE `produkt`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produkt`
--
ALTER TABLE `produkt`
  ADD CONSTRAINT `produkt_ibfk_1` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
