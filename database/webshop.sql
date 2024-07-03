-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 27 dec 2023 om 18:56
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `adres`
--

CREATE TABLE `adres` (
  `adresID` bigint(8) UNSIGNED NOT NULL,
  `persoonID` bigint(8) UNSIGNED DEFAULT NULL,
  `straatnaam` varchar(50) DEFAULT NULL,
  `huisnummer` bigint(20) DEFAULT NULL,
  `postcode` bigint(4) DEFAULT NULL,
  `gemeente` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `adres`
--

INSERT INTO `adres` (`adresID`, `persoonID`, `straatnaam`, `huisnummer`, `postcode`, `gemeente`) VALUES
(3, 20, 'Jan Pieter de Nayerlaan', 5, 2860, 'Sint-Katelijne-Waver'),
(4, 23, 'Jan Pieter de Nayerlaan', 5, 2860, 'Sint-Katelijne-Waver'),
(6, 25, 'Jan Pieter de Nayerlaan', 10, 2860, 'Sint-Katelijne-Waver');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `afrekening`
--

CREATE TABLE `afrekening` (
  `afrekeningID` bigint(8) UNSIGNED NOT NULL,
  `betaling` varchar(20) DEFAULT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `totaalPrijs` float(10,2) DEFAULT NULL,
  `persoonID` bigint(8) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `afrekening`
--

INSERT INTO `afrekening` (`afrekeningID`, `betaling`, `datum`, `totaalPrijs`, `persoonID`) VALUES
(25, 'paypal', '2023-12-23 15:24:48', 148.55, 20),
(26, 'bancontact', '2023-12-23 15:31:03', 34.95, 20),
(27, 'bancontact', '2023-12-23 16:22:14', 56.80, 21),
(28, 'bancontact', '2023-12-26 15:53:29', 100.00, 21),
(29, 'paypal', '2023-12-26 16:00:24', 20.00, 21),
(30, 'paypal', '2023-12-26 16:02:01', 10.00, 21),
(34, 'paypal', '2023-12-26 16:08:40', 38.12, 21),
(35, 'paypal', '2023-12-27 09:51:30', 34.95, 20),
(36, 'paypal', '2023-12-27 13:40:22', 177.79, 21),
(37, 'paypal', '2023-12-27 13:46:59', 44.39, 20),
(38, 'bancontact', '2023-12-27 13:51:40', 44.39, 20),
(39, 'bancontact', '2023-12-27 13:52:14', 24.00, 20),
(40, 'bancontact', '2023-12-27 15:49:16', 24.00, 20);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant`
--

CREATE TABLE `klant` (
  `persoonID` bigint(8) UNSIGNED NOT NULL,
  `voornaam` varchar(50) DEFAULT NULL,
  `achternaam` varchar(50) DEFAULT NULL,
  `email` varchar(75) DEFAULT NULL,
  `telefoonnummer` varchar(17) DEFAULT NULL,
  `paswoord` varchar(100) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `rol` varchar(20) DEFAULT NULL,
  `actief` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `klant`
--

INSERT INTO `klant` (`persoonID`, `voornaam`, `achternaam`, `email`, `telefoonnummer`, `paswoord`, `gender`, `rol`, `actief`) VALUES
(20, 'joren', 'heyvaert', 'joren@joren.com', '0032 123 45 67 89', '$2y$10$QlMLu2PhA47yqcdwQ.anauFnhCs6CC5fCanZ1bhbXashC/V66xSzu', 'M', 'webuser', 1),
(21, 'owner', 'OWNER', 'owner@owner.com', '0032 123 45 67 89', '$2y$10$Xvg4ITqXkFHu8spkOCAvf.RkwqNB16kenWuYZwrXTqtxHBd/4x0cO', 'M', 'owner', 1),
(22, 'test', 'TESTER', 'test@test.be', '0032 987 65 43 21', '$2y$10$EL.kvSw121SZ/2DUjm.tS.X625L7M0OLXFz9oVjrHkuosFNtlDUYC', 'X', 'webuser', 0),
(23, 'OwNer2', 'owenr2', 'owner2@owner2.owner', '0032 123 45 67 89', '$2y$10$cKvJTnR196D4to6IFEQ0ZO.GqrsT107DnXS/VfKT.Zuj9ftc1hTJ6', 'M', 'owner', 1),
(25, 'jana', 'heyvaert', 'jana@jana.com', '0032 123 45 67 89', '$2y$10$cthQYs5IZ/DdU4HnroO2u.NVNt568lJ2cM2rZSl/M8Mje5u/9Jnca', 'X', 'webuser', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten`
--

CREATE TABLE `producten` (
  `productID` bigint(8) UNSIGNED NOT NULL,
  `naam` varchar(50) DEFAULT NULL,
  `prijs` float(6,2) DEFAULT NULL,
  `aantalOpVoorraad` bigint(8) DEFAULT NULL,
  `categorie` varchar(20) DEFAULT NULL,
  `actief` varchar(11) DEFAULT NULL,
  `afbeelding` varchar(100) DEFAULT NULL,
  `subcategorie` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `producten`
--

INSERT INTO `producten` (`productID`, `naam`, `prijs`, `aantalOpVoorraad`, `categorie`, `actief`, `afbeelding`, `subcategorie`) VALUES
(1, 'Aurelia hour', 34.95, 3, 'vazen', '1', './img/vazen/Aurelia_hour.jpg', 'bloemen'),
(2, 'Farasha wings', 10.00, 10, 'vazen', '1', './img/vazen/Farasha_wings.jpg', 'bloemen'),
(3, 'butterflies', 56.80, 4, 'schilderij', '1', './img/schilderijen/vlindertjes.jpg', NULL),
(6, 'lighting drink', 38.12, 48, 'vazen', '1', './img/vazen/lighting_drink.jpg', 'kaarsen'),
(8, 'Botanical Bassist Melvin', 20.39, 65, 'vazen', '1', './img/vazen/Botanical_Bassist_Melvin.jpg', 'bloemen'),
(9, 'Lady Serena', 24.00, 19, 'vazen', '1', './img/vazen/Lady_Serena.jpg', 'bloemen'),
(10, 'Dancing Paint', 46.60, 29, 'schilderij', '1', './img/schilderijen/balerina.jpg', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `productinafrekening`
--

CREATE TABLE `productinafrekening` (
  `productID` bigint(8) UNSIGNED DEFAULT NULL,
  `afrekeningID` bigint(8) UNSIGNED DEFAULT NULL,
  `aantal` bigint(4) DEFAULT NULL,
  `eenheidsPrijs` float(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `productinafrekening`
--

INSERT INTO `productinafrekening` (`productID`, `afrekeningID`, `aantal`, `eenheidsPrijs`) VALUES
(1, 25, 1, 34.95),
(3, 25, 2, 56.80),
(1, 26, 1, 34.95),
(3, 27, 1, 56.80),
(2, 28, 2, 50.00),
(2, 29, 2, 10.00),
(2, 30, 1, 10.00),
(2, NULL, 1, 10.00),
(2, NULL, 1, 10.00),
(6, NULL, 1, 38.12),
(6, 34, 1, 38.12),
(1, 35, 1, 34.95),
(2, 36, 2, 10.00),
(10, 36, 1, 46.60),
(6, 36, 2, 38.12),
(1, 36, 1, 34.95),
(8, 37, 1, 20.39),
(9, 37, 1, 24.00),
(8, 38, 1, 20.39),
(9, 38, 1, 24.00),
(9, 39, 1, 24.00),
(9, 40, 1, 24.00);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `productinwinkelmand`
--

CREATE TABLE `productinwinkelmand` (
  `winkelmandID` bigint(8) UNSIGNED DEFAULT NULL,
  `productID` bigint(8) UNSIGNED DEFAULT NULL,
  `aantal` bigint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `winkelmand`
--

CREATE TABLE `winkelmand` (
  `winkelmandID` bigint(8) UNSIGNED NOT NULL,
  `persoonID` bigint(8) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `winkelmand`
--

INSERT INTO `winkelmand` (`winkelmandID`, `persoonID`) VALUES
(2, 20),
(4, 21),
(5, 22),
(6, 23),
(11, 25);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `adres`
--
ALTER TABLE `adres`
  ADD PRIMARY KEY (`adresID`),
  ADD KEY `persoonID` (`persoonID`);

--
-- Indexen voor tabel `afrekening`
--
ALTER TABLE `afrekening`
  ADD PRIMARY KEY (`afrekeningID`),
  ADD KEY `persoonID` (`persoonID`);

--
-- Indexen voor tabel `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`persoonID`);

--
-- Indexen voor tabel `producten`
--
ALTER TABLE `producten`
  ADD PRIMARY KEY (`productID`);

--
-- Indexen voor tabel `productinafrekening`
--
ALTER TABLE `productinafrekening`
  ADD KEY `afrekeningID` (`afrekeningID`),
  ADD KEY `productID` (`productID`);

--
-- Indexen voor tabel `productinwinkelmand`
--
ALTER TABLE `productinwinkelmand`
  ADD KEY `winkelmandID` (`winkelmandID`),
  ADD KEY `productID` (`productID`);

--
-- Indexen voor tabel `winkelmand`
--
ALTER TABLE `winkelmand`
  ADD PRIMARY KEY (`winkelmandID`),
  ADD KEY `persoonID` (`persoonID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `adres`
--
ALTER TABLE `adres`
  MODIFY `adresID` bigint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `afrekening`
--
ALTER TABLE `afrekening`
  MODIFY `afrekeningID` bigint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT voor een tabel `klant`
--
ALTER TABLE `klant`
  MODIFY `persoonID` bigint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT voor een tabel `producten`
--
ALTER TABLE `producten`
  MODIFY `productID` bigint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `winkelmand`
--
ALTER TABLE `winkelmand`
  MODIFY `winkelmandID` bigint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `adres`
--
ALTER TABLE `adres`
  ADD CONSTRAINT `adres_ibfk_1` FOREIGN KEY (`persoonID`) REFERENCES `klant` (`persoonID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `afrekening`
--
ALTER TABLE `afrekening`
  ADD CONSTRAINT `afrekening_ibfk_1` FOREIGN KEY (`persoonID`) REFERENCES `klant` (`persoonID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `productinafrekening`
--
ALTER TABLE `productinafrekening`
  ADD CONSTRAINT `productinafrekening_ibfk_1` FOREIGN KEY (`afrekeningID`) REFERENCES `afrekening` (`afrekeningID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `productinafrekening_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `producten` (`productID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `productinwinkelmand`
--
ALTER TABLE `productinwinkelmand`
  ADD CONSTRAINT `productinwinkelmand_ibfk_1` FOREIGN KEY (`winkelmandID`) REFERENCES `winkelmand` (`winkelmandID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `productinwinkelmand_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `producten` (`productID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `winkelmand`
--
ALTER TABLE `winkelmand`
  ADD CONSTRAINT `winkelmand_ibfk_1` FOREIGN KEY (`persoonID`) REFERENCES `klant` (`persoonID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
