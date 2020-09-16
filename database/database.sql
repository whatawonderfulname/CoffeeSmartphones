-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 15. Sep 2020 um 14:39
-- Server-Version: 10.4.11-MariaDB
-- PHP-Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `fullstack111`
--
CREATE DATABASE IF NOT EXISTS `fullstack111` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fullstack111`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `billing_details`
--

CREATE TABLE `billing_details` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` varchar(16) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `by_default` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `billing_details`
--

INSERT INTO `billing_details` (`id`, `first_name`, `last_name`, `address`, `phone_number`, `fk_user`, `by_default`) VALUES
(43, 'aaaaaaaaaa', 'bbbbbbb', 'cccccccc', '01111111111', 7, 0),
(44, 'qqqqqqqqqqqqqqqqq', 'tttttttt', 'zzzzzzz', 'iiiiiiiiiii', 7, 1),
(73, 'llllll', 'lllllllll', 'llllllllll', '1111111111111111', 28, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `fk_smartphone` int(11) DEFAULT NULL,
  `fk_cover` int(11) DEFAULT NULL,
  `fk_headphone` int(11) DEFAULT NULL,
  `fk_charger` int(11) DEFAULT NULL,
  `amount` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `cart`
--

INSERT INTO `cart` (`id`, `fk_user`, `fk_smartphone`, `fk_cover`, `fk_headphone`, `fk_charger`, `amount`) VALUES
(139, 28, NULL, NULL, NULL, 2, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `charger`
--

CREATE TABLE `charger` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `img` varchar(255) NOT NULL,
  `brand` enum('Apple','Samsung','HTC') NOT NULL,
  `output_power` enum('12 watt','15 watt','18 watt','19.5 watt','27 watt','30 watt') NOT NULL,
  `price` float NOT NULL,
  `discount` int(3) DEFAULT 0,
  `amount_available` int(11) NOT NULL,
  `adding_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `visible` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `charger`
--

INSERT INTO `charger` (`id`, `name`, `img`, `brand`, `output_power`, `price`, `discount`, `amount_available`, `adding_date`, `visible`) VALUES
(1, 'iPhone Charger', 'http://www.pngmart.com/files/5/Charger-PNG-Image.png', 'Apple', '18 watt', 4.99, 0, 50, '2020-07-30 11:44:42', '1'),
(2, 'For the Car', 'http://www.pngmart.com/files/5/Charger-PNG-HD.png', 'HTC', '12 watt', 30, 0, 24, '2020-08-10 08:42:15', '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cover`
--

CREATE TABLE `cover` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `img` varchar(255) NOT NULL,
  `brand` enum('Apple','Samsung','HTC') NOT NULL,
  `type` enum('flip','back','book') NOT NULL,
  `price` float NOT NULL,
  `discount` tinyint(3) DEFAULT 0,
  `amount_available` int(11) NOT NULL,
  `adding_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `visible` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `cover`
--

INSERT INTO `cover` (`id`, `name`, `img`, `brand`, `type`, `price`, `discount`, `amount_available`, `adding_date`, `visible`) VALUES
(1, 'Red Cover', 'http://www.pngmart.com/files/7/Mobile-Cover-PNG-Image.png', 'HTC', 'book', 9.98, 0, 100, '2020-07-30 11:49:35', '1'),
(2, 'Blue Cover', 'http://www.pngmart.com/files/7/Mobile-Cover-PNG-Free-Download.png', 'HTC', 'back', 15, 0, 17, '2020-08-21 13:58:20', '1'),
(3, 'Pink Cover', 'http://www.pngmart.com/files/7/Mobile-Cover-PNG-Transparent.png', 'Samsung', 'back', 21, 0, 0, '2020-08-17 17:42:00', '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `faq`
--

INSERT INTO `faq` (`id`, `topic`, `text`) VALUES
(1, 'Your Account', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(2, 'Log In', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(3, 'Password', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `headphone`
--

CREATE TABLE `headphone` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `img` varchar(255) NOT NULL,
  `brand` enum('Apple','Samsung','HTC') NOT NULL,
  `type` enum('in-ear','on-ear') NOT NULL,
  `wireless` enum('yes','no','optional') NOT NULL,
  `electrical_impendance` enum('16 ohm','24 ohm','32 ohm','47 ohm') NOT NULL,
  `microphone` enum('yes','no') NOT NULL,
  `price` float NOT NULL,
  `discount` int(3) DEFAULT 0,
  `amount_available` int(11) NOT NULL,
  `adding_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `visible` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `headphone`
--

INSERT INTO `headphone` (`id`, `name`, `img`, `brand`, `type`, `wireless`, `electrical_impendance`, `microphone`, `price`, `discount`, `amount_available`, `adding_date`, `visible`) VALUES
(2, 'Small Headphones', 'https://purepng.com/public/uploads/medium/purepng.com-music-headphonemusicheadphoneearphoneslisteningearssounds-231519334626cxkws.png', 'HTC', 'on-ear', 'yes', '24 ohm', 'no', 100, 20, 200, '2020-05-26 19:21:32', '1'),
(3, 'Big Headphones', 'https://purepng.com/public/uploads/medium/purepng.com-headphoneelectronics-headset-headphone-941524669594nj2m3.png', 'Apple', 'on-ear', 'optional', '24 ohm', 'yes', 150, 0, 100, '2020-07-30 11:43:47', '1'),
(5, 'Earphones', 'https://purepng.com/public/uploads/medium/purepng.com-music-headphonemusicheadphoneearphoneslisteningearssounds-231519334521p4b2l.png', 'Samsung', 'in-ear', 'no', '32 ohm', 'no', 20.02, 5, 48, '2020-08-17 17:54:58', '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `fk_smartphone` int(11) DEFAULT NULL,
  `fk_cover` int(11) DEFAULT NULL,
  `fk_headphone` int(11) DEFAULT NULL,
  `fk_charger` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `text_area` varchar(255) NOT NULL,
  `stars` tinyint(1) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `review`
--

INSERT INTO `review` (`id`, `fk_user`, `fk_smartphone`, `fk_cover`, `fk_headphone`, `fk_charger`, `title`, `text_area`, `stars`, `creation_date`) VALUES
(10, 7, 27, NULL, NULL, NULL, 'Einfach', 'Geeeeil!', 5, '2020-07-24 19:16:49'),
(13, 25, 27, NULL, NULL, NULL, 'Hält nichts aus!', 'Wollte damit ein paar Steine wuchten, aber das Display ist sofort gecrackt!!!elf', 2, '2020-05-24 12:08:32'),
(21, 28, NULL, NULL, 5, NULL, 'Awesome', 'These earphones are so comfortable!', 5, '2020-07-30 13:34:31'),
(25, 28, NULL, NULL, 5, NULL, 'Pure enjoyment', 'What a sound!', 5, '2020-08-12 09:36:53');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `smartphone`
--

CREATE TABLE `smartphone` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `img` varchar(255) NOT NULL,
  `brand` enum('Apple','Samsung','HTC') NOT NULL,
  `processor_frequency` varchar(10) NOT NULL,
  `processor_type` varchar(50) NOT NULL,
  `display_resolution` varchar(100) NOT NULL,
  `display_technology` varchar(50) NOT NULL,
  `camera_main` varchar(20) NOT NULL,
  `camera_front` varchar(20) NOT NULL,
  `ram` varchar(50) NOT NULL,
  `internal_memory` varchar(25) NOT NULL,
  `sim_card` varchar(10) NOT NULL,
  `sim_slot` varchar(20) NOT NULL,
  `price` float NOT NULL,
  `discount` tinyint(3) DEFAULT 0,
  `visible` enum('1','0') NOT NULL DEFAULT '1',
  `adding_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `amount_available` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `smartphone`
--

INSERT INTO `smartphone` (`id`, `name`, `img`, `brand`, `processor_frequency`, `processor_type`, `display_resolution`, `display_technology`, `camera_main`, `camera_front`, `ram`, `internal_memory`, `sim_card`, `sim_slot`, `price`, `discount`, `visible`, `adding_date`, `amount_available`) VALUES
(22, 'Superphone', 'https://via.placeholder.com/320x480.jpg', 'HTC', '2 GHz', 'dualcore', 'amoled', 'dynamic amoled', '16 megapixel', '8 megapixel', '8 gb', '256 gb', '5g', 'sim1 + esim', 500, 0, '0', '2020-08-12 08:41:46', 1),
(23, 'Black iPhone', 'http://www.pngmart.com/files/2/Smartphone-Transparent-Background.png', 'Apple', '2.3 GHz', 'quadcore', '1080 x 2636', 'Dynamic AMOLED', '12 MP', '', '8 GB', '256 GB', 'dual SIM', 'Sim 1 + eSim', 400, 5, '1', '2020-05-26 19:18:29', 80),
(24, 'Silver iPhone', 'http://www.pngmart.com/files/2/Smartphone-PNG-HD.png', 'Apple', '2.4 GHz', 'dualcore', '1080 x 2636', 'tn-panel', '12 MP', '', '8 GB', '256 GB', 'micro SIM', 'Sim 1', 300, 10, '1', '2020-05-26 19:18:57', 70),
(25, 'Lightsaber', 'http://www.pngmart.com/files/7/Mobile-Phone-Transparent-Images-PNG.png', 'Samsung', '2.4 GHz', 'dualcore', '1080 x 2636', 'Dynamic AMOLED', '12 MP', '', '8 GB', '256 GB', 'dual SIM', 'Sim 1 + eSim', 250, 15, '1', '2020-05-26 19:19:24', 90),
(27, 'Small Phone', 'https://purepng.com/public/uploads/medium/purepng.com-mobile-phone-with-touchmobilemobile-phonehandymobile-devicetouchscreenmobile-phone-device-231519332728jhjqr.png', 'Samsung', '2.4 GHz', 'er', 'sdf', 'sdf', 'sdf', 'sdf', '34 gb', '300gb', 'sdf', 'asdf', 200, 34, '1', '2020-05-31 08:36:29', 100);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `statistics`
--

CREATE TABLE `statistics` (
  `id` int(10) NOT NULL,
  `category` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `amount` smallint(3) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `statistics`
--

INSERT INTO `statistics` (`id`, `category`, `name`, `price`, `amount`, `date`) VALUES
(1, 'cover', 'Blue Cover', 15, 1, '2020-08-08 11:18:22'),
(2, 'headphone', 'Earphones', 19.02, 1, '2020-08-08 11:39:34'),
(3, 'headphone', 'Earphones', 19.02, 1, '2020-08-08 11:49:51'),
(4, 'cover', 'Blue Cover', 15, 1, '2020-08-08 11:50:53'),
(5, 'charger', 'For the Car', 30, 1, '2020-08-10 08:42:15'),
(6, 'cover', 'Pink Cover', 21, 1, '2020-08-17 17:42:00'),
(7, 'headphone', 'Earphones', 19.02, 1, '2020-08-17 17:54:58'),
(8, 'cover', 'Blue Cover', 15, 1, '2020-08-21 13:58:20');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `status`, `role`) VALUES
(1, 'test', 'test@test.com', '$2y$10$S6qHs/VVBNUILqGGaXeLIeO5fvs5bZeWyYJnJcEJqV4wPPS0S0qdm', 0, 'user'),
(7, 'testuser', 'testuser@testuser.com', '$2y$10$UY1EmhQBtKloVooRhQVDoeUMjDOipXWxTIcxQDFD6izunxmeNvMKG', 1, 'user'),
(19, 'ASC', 'alexander.schaedlich@gmail.com', '$2y$10$ZzLxsa24FuU3antU9klvZ.xRh.auk4E0KY0mTNJq8xhfcx6G1LzOC', 1, 'admin'),
(25, 'Gimli', 'fripick@gmail.com', '$2y$10$5F.8KssOrqBAUcBhlCFrYeNDSeJiKurnJeWrizU7JOl5RoSw/UcL6', 1, 'user'),
(28, 'myTest', 'alexander.schaedlich@gmail.com', '$2y$10$hYc43A8ZkWR5kEoVOdZk1OQoBBZtMVWbK/aZ800avTRx0itEESPOq', 1, 'user');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `billing_details`
--
ALTER TABLE `billing_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`fk_user`);

--
-- Indizes für die Tabelle `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_ibfk_2` (`fk_user`),
  ADD KEY `fk_smartphone` (`fk_smartphone`),
  ADD KEY `fk_cover` (`fk_cover`),
  ADD KEY `fk_headphone` (`fk_headphone`),
  ADD KEY `fk_charger` (`fk_charger`);

--
-- Indizes für die Tabelle `charger`
--
ALTER TABLE `charger`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cover`
--
ALTER TABLE `cover`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `headphone`
--
ALTER TABLE `headphone`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_ibfk_1` (`fk_user`),
  ADD KEY `fk_smartphone` (`fk_smartphone`),
  ADD KEY `fk_cover` (`fk_cover`),
  ADD KEY `fk_headphone` (`fk_headphone`),
  ADD KEY `fk_charger` (`fk_charger`);

--
-- Indizes für die Tabelle `smartphone`
--
ALTER TABLE `smartphone`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `billing_details`
--
ALTER TABLE `billing_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT für Tabelle `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT für Tabelle `charger`
--
ALTER TABLE `charger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `cover`
--
ALTER TABLE `cover`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `headphone`
--
ALTER TABLE `headphone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT für Tabelle `smartphone`
--
ALTER TABLE `smartphone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT für Tabelle `statistics`
--
ALTER TABLE `statistics`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `billing_details`
--
ALTER TABLE `billing_details`
  ADD CONSTRAINT `billing_details_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`fk_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`fk_smartphone`) REFERENCES `smartphone` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_4` FOREIGN KEY (`fk_cover`) REFERENCES `cover` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_5` FOREIGN KEY (`fk_headphone`) REFERENCES `headphone` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_6` FOREIGN KEY (`fk_charger`) REFERENCES `charger` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`fk_smartphone`) REFERENCES `smartphone` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_3` FOREIGN KEY (`fk_cover`) REFERENCES `cover` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_4` FOREIGN KEY (`fk_headphone`) REFERENCES `headphone` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_5` FOREIGN KEY (`fk_charger`) REFERENCES `charger` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
