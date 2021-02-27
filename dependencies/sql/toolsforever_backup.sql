-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 27 feb 2021 om 18:43
-- Serverversie: 10.4.14-MariaDB
-- PHP-versie: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toolsforever`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `locations`
--

CREATE TABLE `locations` (
  `locationID` int(8) NOT NULL,
  `locationname` varchar(64) NOT NULL,
  `locationdescription` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `locations`
--

INSERT INTO `locations` (`locationID`, `locationname`, `locationdescription`) VALUES
(1, 'Eindhoven', 'Distributiecentrum Eindhoven Noord'),
(2, 'Rotterdam', 'Distributiecentrum Rotterdam'),
(3, 'Alkmaar', 'Distributiecentrum Alkmaar Centrum'),
(4, 'Almere', 'Distributiecentrum Almere Buiten'),
(5, 'Veenendaal', 'Distributiecentrum Veenendaal West');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `locations_has_products`
--

CREATE TABLE `locations_has_products` (
  `ID` int(8) NOT NULL,
  `locations_locationname` varchar(64) NOT NULL,
  `products_productname` varchar(256) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `min_stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `locations_has_products`
--

INSERT INTO `locations_has_products` (`ID`, `locations_locationname`, `products_productname`, `stock`, `min_stock`) VALUES
(4, 'Rotterdam', 'Banaan', 12, 5),
(5, 'Almere', 'Boormachine', 15, 10),
(6, 'Eindhoven', 'Broodje frikandel', 47, 10),
(7, 'Almere', 'USB Joystick', 34, 5),
(8, 'Veenendaal', 'Trust draadloze koptelefoon 850W Bluetooth', 89, 10);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `productname` varchar(256) NOT NULL,
  `productbrand` varchar(64) DEFAULT NULL,
  `producttype` varchar(64) DEFAULT NULL,
  `buyprice` varchar(16) DEFAULT NULL,
  `sellprice` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`productID`, `productname`, `productbrand`, `producttype`, `buyprice`, `sellprice`) VALUES
(12, 'Boormachine', 'Arck', 'Brandnetel-10', '499.99', '589.99'),
(13, 'Broodje frikandel', 'Appie', 'lekker-maar-wel-droog', '0.23', '5.6'),
(14, 'USB Joystick', 'Dbrand', 'EZ-GMR-BRH', '44.99', '59.99'),
(15, 'Trust draadloze koptelefoon 850W Bluetooth', 'Trust', 'Elysium', '79.99', '119.99');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `UUID` int(8) NOT NULL,
  `email` varchar(64) DEFAULT NULL,
  `username` varchar(16) DEFAULT NULL,
  `password` varchar(512) DEFAULT NULL,
  `privileges` varchar(32) DEFAULT NULL,
  `sessionID` varchar(256) DEFAULT NULL,
  `salt` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`UUID`, `email`, `username`, `password`, `privileges`, `sessionID`, `salt`) VALUES
(8, 'daanklein75@gmail.com', 'Daan1241', '592dda5da65cf64cd25da91e2631c7e3737343ca', 'admin', '348355ca9687b9b8fed0587b7215bc484b7b0785', '851050'),
(9, 'petraklein@gmail.com', 'Petra1234', '08f4c922529a20511497fedba6677fea346de6b8', 'admin', NULL, '1306095');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`locationID`,`locationname`);

--
-- Indexen voor tabel `locations_has_products`
--
ALTER TABLE `locations_has_products`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_locations_has_products_locations1_idx` (`locations_locationname`),
  ADD KEY `fk_locations_has_products_products1_idx` (`products_productname`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`,`productname`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UUID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `locations`
--
ALTER TABLE `locations`
  MODIFY `locationID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `locations_has_products`
--
ALTER TABLE `locations_has_products`
  MODIFY `ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `UUID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
