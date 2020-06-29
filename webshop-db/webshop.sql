-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 29. Jun 2020 um 18:34
-- Server-Version: 10.4.11-MariaDB
-- PHP-Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `webshop`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ws_items`
--

CREATE TABLE `ws_items` (
  `itemID` int(11) NOT NULL,
  `itemName` varchar(50) COLLATE utf8_german2_ci NOT NULL,
  `description` varchar(300) COLLATE utf8_german2_ci NOT NULL,
  `price` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Daten für Tabelle `ws_items`
--

INSERT INTO `ws_items` (`itemID`, `itemName`, `description`, `price`) VALUES
(1, 'Titan Uhr - Modell 1', 'Hübsche Uhr mit Zeigern.', '4.99'),
(2, 'Titan Uhr - Modell 2', 'Hübsche Uhr mit noch schöneren Zeigern.', '9.99'),
(3, 'Titan Uhr - Modell 3', 'Hübsche Uhr mit hochwertigen Zeigern.', '14.99'),
(4, 'Titan Uhr - Modell 4', 'Hübsche Uhr mit luxuriösen Zeigern.', '199.99'),
(5, 'Titan Uhr - Modell 5', 'Hübsche Uhr mit Zeigern.', '4.99'),
(6, 'Titan Uhr - Modell 6', 'Hübsche Uhr mit noch schöneren Zeigern.', '9.99'),
(7, 'Titan Uhr - Modell 7', 'Hübsche Uhr mit hochwertigen Zeigern', '14.99'),
(8, 'Titan Uhr - Modell 8', 'Hübsche Uhr mit luxuriösen Zeigern.', '199.99');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ws_ordered_items`
--

CREATE TABLE `ws_ordered_items` (
  `orderedItemsID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ws_orders`
--

CREATE TABLE `ws_orders` (
  `orderID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `orderPrice` decimal(11,2) NOT NULL COMMENT 'Price of all items\r\n\r\nexcluding shipping\r\n\r\nshipping has to be added to get Total',
  `shippingCosts` decimal(4,2) NOT NULL,
  `orderDate` bigint(20) NOT NULL DEFAULT current_timestamp() COMMENT 'Zeitpunkt der Bestellung als Timestamp',
  `shippingType` text COLLATE utf8_german2_ci NOT NULL COMMENT 'Normale Lieferung \r\noder \r\nExpress Lieferung',
  `itemIDs` text CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'Item IDs als String getrennt mit komma ","',
  `shippingAdress` text COLLATE utf8_german2_ci NOT NULL COMMENT 'zip,city,street,houseNumber,Firstname,lastname\r\n\r\ncreated bug, because in these values(street city could be a comma)\r\nbut nevermind',
  `shippingStatus` text COLLATE utf8_german2_ci NOT NULL DEFAULT '\'bestellt\'' COMMENT 'mögliche stati (ist das der richttige Plural von Status?):\r\nbestellt\r\nan Liefer-dienst übergeben\r\nunterwegs\r\nangekommen'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Daten für Tabelle `ws_orders`
--

INSERT INTO `ws_orders` (`orderID`, `userID`, `orderPrice`, `shippingCosts`, `orderDate`, `shippingType`, `itemIDs`, `shippingAdress`, `shippingStatus`) VALUES
(5, 7, '19.98', '5.00', 1593421928, 'Normale Lieferung', ',1,2,', '71088,Holzgerlingen,Aichtalstraße,17,Dustin,Walker', '\'bestellt\''),
(6, 7, '19.98', '5.00', 1593425250, 'Normale Lieferung', ',1,2,', '71088,Holzgerlingen,Aichtalstraße,17,Dustin,Walker', '\'bestellt\''),
(7, 7, '29.98', '5.00', 1593425379, 'Normale Lieferung', ',1,2,', '71088,Holzgerlingen,Aichtalstraße,17,Dustin,Walker', '\'bestellt\''),
(8, 7, '29.98', '15.00', 1593425787, 'Express Lieferung', ',1,2,', '71088,Holzgerlingen,Aichtalstraße,17,Dustin,Walker', '\'bestellt\''),
(9, 7, '29.98', '15.00', 1593425912, 'Express Lieferung', ',1,2,', '71088,Holzgerlingen,Aichtalstraße,17,Dustin,Walker', '\'bestellt\''),
(10, 7, '99.99', '15.00', 1593426883, 'Express Lieferung', ',1,2,3,4,', '71088,Holzgerlingen,Aichtalstraße,17,Dustin,Walker', '\'bestellt\''),
(11, 7, '99.99', '15.00', 1593426906, 'Express Lieferung', ',1,2,3,4,', '71088,Holzgerlingen,Aichtalstraße,17,Dustin,Walker', '\'bestellt\''),
(12, 7, '244.96', '15.00', 1593427285, 'Express Lieferung', ',1,2,3,4,', '71088,Holzgerlingen,Aichtalstraße,17,Dustin,Walker', '\'bestellt\''),
(13, 7, '29.98', '15.00', 1593444276, 'Express Lieferung', ',1,2,', '71088,Holzgerlingen,Aichtalstraße,17,Dustin,Walker', '\'bestellt\'');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ws_shopping_cart`
--

CREATE TABLE `ws_shopping_cart` (
  `shoppingcartID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Zeitstempel für Warenkorb'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ws_users`
--

CREATE TABLE `ws_users` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(50) COLLATE utf8_german2_ci NOT NULL,
  `lastName` varchar(50) COLLATE utf8_german2_ci NOT NULL,
  `street` varchar(50) COLLATE utf8_german2_ci NOT NULL,
  `zip` varchar(10) COLLATE utf8_german2_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_german2_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_german2_ci NOT NULL,
  `password` char(255) COLLATE utf8_german2_ci NOT NULL COMMENT 'SHA-256',
  `created` bigint(20) UNSIGNED NOT NULL DEFAULT current_timestamp() COMMENT 'Timestamp of Account creation',
  `lastLoginTime` bigint(20) UNSIGNED NOT NULL DEFAULT current_timestamp() COMMENT 'Timestamp of last logout',
  `active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Daten für Tabelle `ws_users`
--

INSERT INTO `ws_users` (`userID`, `firstName`, `lastName`, `street`, `zip`, `city`, `email`, `password`, `created`, `lastLoginTime`, `active`) VALUES
(7, 'Dustin', 'Walker', 'Aichtalstraße', '71088', 'Holzgerlingen', 'du-wal@web.de', 'f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b', 1593015914, 1593440131, 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `ws_items`
--
ALTER TABLE `ws_items`
  ADD PRIMARY KEY (`itemID`);

--
-- Indizes für die Tabelle `ws_ordered_items`
--
ALTER TABLE `ws_ordered_items`
  ADD PRIMARY KEY (`orderedItemsID`),
  ADD KEY `itemID_FK` (`itemID`),
  ADD KEY `orderID_FK` (`orderID`) USING BTREE;

--
-- Indizes für die Tabelle `ws_orders`
--
ALTER TABLE `ws_orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `userID_FK` (`userID`);

--
-- Indizes für die Tabelle `ws_shopping_cart`
--
ALTER TABLE `ws_shopping_cart`
  ADD PRIMARY KEY (`shoppingcartID`),
  ADD KEY `userID_FK` (`userID`) USING BTREE,
  ADD KEY `itemID_FK` (`itemID`) USING BTREE;

--
-- Indizes für die Tabelle `ws_users`
--
ALTER TABLE `ws_users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `ws_items`
--
ALTER TABLE `ws_items`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `ws_ordered_items`
--
ALTER TABLE `ws_ordered_items`
  MODIFY `orderedItemsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `ws_orders`
--
ALTER TABLE `ws_orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT für Tabelle `ws_shopping_cart`
--
ALTER TABLE `ws_shopping_cart`
  MODIFY `shoppingcartID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `ws_users`
--
ALTER TABLE `ws_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `ws_ordered_items`
--
ALTER TABLE `ws_ordered_items`
  ADD CONSTRAINT `itemIDOrderedItems_FK` FOREIGN KEY (`itemID`) REFERENCES `ws_items` (`itemID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `orderID_FK` FOREIGN KEY (`orderID`) REFERENCES `ws_orders` (`orderID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints der Tabelle `ws_orders`
--
ALTER TABLE `ws_orders`
  ADD CONSTRAINT `userIDOrders_FK` FOREIGN KEY (`userID`) REFERENCES `ws_users` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `ws_shopping_cart`
--
ALTER TABLE `ws_shopping_cart`
  ADD CONSTRAINT `itemID_FK` FOREIGN KEY (`itemID`) REFERENCES `ws_items` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userID_FK` FOREIGN KEY (`userID`) REFERENCES `ws_users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
