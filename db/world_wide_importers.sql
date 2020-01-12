-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 12 jan 2020 om 15:28
-- Serverversie: 10.4.8-MariaDB
-- PHP-versie: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `world_wide_importers`
--
CREATE DATABASE IF NOT EXISTS `world_wide_importers` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `world_wide_importers`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `afbeeldingen`
--

CREATE TABLE `afbeeldingen` (
  `afbeelding_id` int(11) NOT NULL,
  `bestandslocatie` varchar(255) DEFAULT NULL,
  `publicatiestatus` smallint(6) DEFAULT NULL,
  `omschrijving` text DEFAULT NULL,
  `afbeeldingscategorie` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `afbeeldingen`
--

INSERT INTO `afbeeldingen` (`afbeelding_id`, `bestandslocatie`, `publicatiestatus`, `omschrijving`, `afbeeldingscategorie`) VALUES
(1, 'img/prd/art1.jpg', 1, 'USB Raketwerper', NULL),
(2, 'img/prd/art1.jpg', 2, 'USB Raketwerper', NULL),
(3, 'img/prd/Milka_alpine_melk.jpg', 1, 'Milka alpine melk', NULL),
(4, 'img/prd/milka_caramel.jpg', 1, 'Milka karamel', NULL),
(5, 'img/prd/milka_daim.jpg', 1, 'Milka daim', NULL),
(6, 'img/prd/milka_oreo.jpg', 1, 'Milka oreo', NULL),
(7, 'img/prd/tonychocolonely.jpg', 1, 'Tony chocolonely', NULL),
(8, 'img/prd/usb_enter_button.jpg', 1, 'USB Enter button', NULL),
(9, 'img/prd/usb_fan.jpg', 1, 'USB fan', NULL),
(10, 'img/prd/usb_light_bulb.jpg', 1, 'USB light bulb', NULL),
(11, 'img/prd/christmas_power_bank.jpg', 1, 'Kerstmis power bank', NULL),
(12, 'img/prd/christmas_phone_charger.jpg', 1, 'Kerstmis telefoon oplader', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikel`
--

CREATE TABLE `artikel` (
  `artikel_id` int(11) NOT NULL,
  `naam` varchar(50) NOT NULL,
  `herkomst` varchar(255) NOT NULL,
  `productieproces` text DEFAULT NULL,
  `ingredienten` text NOT NULL,
  `afmetingen` text NOT NULL,
  `gewicht` int(11) NOT NULL,
  `omschrijving` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `artikel`
--

INSERT INTO `artikel` (`artikel_id`, `naam`, `herkomst`, `productieproces`, `ingredienten`, `afmetingen`, `gewicht`, `omschrijving`) VALUES
(1, 'USB Raketwerper (Groen)', '', NULL, '', '', 0, 'USB 4 the win. Met deze USB raketwerper ben je de baas op de kantoorvloer. Geweldig om je raketwerper via USB te besturen.'),
(2, 'USB Raketwerper (Grijs)', '', NULL, '', '', 0, NULL),
(3, 'Kantoor periscoop (Zwart)', '', NULL, '', '', 0, 'Hou je vervelende collega\'s in de gaten met dit geweldige product.'),
(4, 'Kerstmis telefoon oplader', 'Duitsland', NULL, '', '', 0, 'Telefoon oplader met kerstverlichting.'),
(5, 'Kerstmis power bank', '', NULL, '', '', 0, 'Kerstmis power bank. Altijd en overal extra stroom bij je.'),
(6, 'Milka apline melk', 'Nederland', NULL, '', '', 0, 'Milka alpine, gemaakt van melk uit de Alpine'),
(7, 'Mika karamel', 'Nederland', NULL, '', '', 0, 'Milka met karamelsmaak'),
(8, 'Milka daim', 'Nederland', NULL, '', '', 0, 'Milka met een daim smaak'),
(9, 'Milka oreo', 'Nederland', NULL, '', '', 0, 'Milka met oreo smaak'),
(10, 'Tonychocolonely Puur', 'Duitsland', NULL, '', '', 0, 'Tony chocolonely pure chocolade'),
(11, 'USB enter knop', 'Duitsland', NULL, '', '', 0, 'USB enter knop, Voor de streskippen onder ons.'),
(12, 'USB fan', 'Duitsland', NULL, '', '', 0, 'USB fan, Voor een lekker briesje.'),
(13, 'USB light bulb', 'Duitsland', NULL, '', '', 0, 'Leuk hebbeding voor een beetje extra licht.');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikel_afbeelding`
--

CREATE TABLE `artikel_afbeelding` (
  `artikel_afbeelding_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `afbeelding_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `artikel_afbeelding`
--

INSERT INTO `artikel_afbeelding` (`artikel_afbeelding_id`, `artikel_id`, `afbeelding_id`) VALUES
(1, 1, 1),
(2, 4, 12),
(3, 5, 11),
(4, 6, 3),
(5, 7, 4),
(6, 8, 5),
(7, 9, 6),
(8, 10, 7),
(9, 11, 8),
(10, 12, 9),
(11, 13, 10),
(12, 1, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikel_categorie`
--

CREATE TABLE `artikel_categorie` (
  `artikel_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `artikel_categorie`
--

INSERT INTO `artikel_categorie` (`artikel_id`, `categorie_id`) VALUES
(5, 1),
(9, 2),
(4, 1),
(3, 1),
(1, 1),
(3, 1),
(2, 1),
(8, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikel_video`
--

CREATE TABLE `artikel_video` (
  `video_artikel_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `artikel_video`
--

INSERT INTO `artikel_video` (`video_artikel_id`, `video_id`, `artikel_id`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `betaling`
--

CREATE TABLE `betaling` (
  `betaling_id` int(11) NOT NULL,
  `betaalmethode` varchar(20) NOT NULL,
  `afrekenlink` varchar(255) NOT NULL,
  `betaalstatus` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `betaling`
--

INSERT INTO `betaling` (`betaling_id`, `betaalmethode`, `afrekenlink`, `betaalstatus`) VALUES
(1, 'ideal', 'http://demolink/bladiebla', '0'),
(2, 'ideal', 'http://ideal.nl/user/$UID', '0'),
(3, 'ideal', 'http://ideal.nl/user/72', '0'),
(4, 'ideal', 'http://ideal.nl/user/user', '0'),
(5, 'ideal', 'http://ideal.nl/user/74', '0'),
(6, 'ideal', 'http://ideal.nl/user/76', '0'),
(7, 'ideal', 'http://ideal.nl/user/77', '0'),
(8, 'ideal', 'http://ideal.nl/user/78', '0'),
(9, 'ideal', 'http://ideal.nl/user/79', '0'),
(10, 'ideal', 'http://ideal.nl/user/80', '0');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorie`
--

CREATE TABLE `categorie` (
  `categorie_id` int(11) NOT NULL,
  `categorienaam` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `categorie`
--

INSERT INTO `categorie` (`categorie_id`, `categorienaam`) VALUES
(1, 'Gadgets'),
(2, 'Chocolade');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `chat`
--

CREATE TABLE `chat` (
  `chat_id` int(11) NOT NULL,
  `starttijd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `chat`
--

INSERT INTO `chat` (`chat_id`, `starttijd`) VALUES
(6, '2020-01-08 11:29:44'),
(7, '2019-12-24 14:47:21'),
(8, '2020-01-04 20:20:36'),
(84, '2020-01-11 22:26:53'),
(832, '2020-01-07 15:12:23'),
(977, '2020-01-10 13:43:11');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `chatregel`
--

CREATE TABLE `chatregel` (
  `chatregel_id` int(11) NOT NULL,
  `chat_id` int(11) DEFAULT NULL,
  `gebruiker_id` int(11) DEFAULT NULL,
  `berichtinhoud` varchar(255) DEFAULT NULL,
  `tijd` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `chatregel`
--

INSERT INTO `chatregel` (`chatregel_id`, `chat_id`, `gebruiker_id`, `berichtinhoud`, `tijd`) VALUES
(1, 832, 0, '', '2020-01-07 14:12:25'),
(2, 832, 0, 'test', '2020-01-07 14:12:29'),
(3, 832, 68, 'test', '2020-01-07 14:15:40'),
(4, 832, 68, 'werkt?', '2020-01-07 14:15:49'),
(5, 832, 0, 'Testing', '2020-01-07 14:28:56'),
(6, 832, 0, 'testing', '2020-01-07 14:29:02'),
(7, 832, 0, 'testing', '2020-01-07 14:30:03'),
(8, 832, 0, 'testing', '2020-01-07 14:31:51'),
(9, 832, 1, 'chat aan computer gelocked?', '2020-01-07 14:36:15'),
(10, 832, 1, 'YES!', '2020-01-07 14:36:23'),
(11, 832, 68, 'kijk hij doet', '2020-01-07 19:34:16'),
(12, 6, 68, 'test\r\n', '2020-01-08 10:29:53'),
(13, 6, 68, 'test\r\n', '2020-01-08 10:30:07'),
(14, 6, 0, 'test', '2020-01-08 10:30:28'),
(15, 977, 68, 'Ik heb een vraag over een product', '2020-01-10 12:43:27'),
(16, 977, 68, 'Nu weer', '2020-01-10 12:44:08'),
(17, 977, 68, 'Nog steeds', '2020-01-10 12:47:26'),
(18, 84, 68, 'test', '2020-01-11 21:27:02'),
(19, 84, 68, 'test', '2020-01-11 21:28:12');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruiker`
--

CREATE TABLE `gebruiker` (
  `gebruiker_id` int(11) NOT NULL,
  `emailadres` varchar(50) NOT NULL,
  `voornaam` varchar(30) NOT NULL,
  `achternaam` varchar(30) NOT NULL,
  `geslacht` varchar(10) NOT NULL,
  `adres` varchar(30) NOT NULL,
  `postcode` varchar(7) NOT NULL,
  `woonplaats` varchar(50) NOT NULL,
  `geboortedatum` date NOT NULL,
  `is_medewerker` smallint(1) NOT NULL,
  `wachtwoord` varchar(100) NOT NULL,
  `foutieve_aanmeldpogingen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `gebruiker`
--

INSERT INTO `gebruiker` (`gebruiker_id`, `emailadres`, `voornaam`, `achternaam`, `geslacht`, `adres`, `postcode`, `woonplaats`, `geboortedatum`, `is_medewerker`, `wachtwoord`, `foutieve_aanmeldpogingen`) VALUES
(0, '', 'WWI Gast', '', '', '', '', '', '0000-00-00', 1, '', NULL),
(1, 'Administrator@wwi.nl', 'Wide World Importers', '', '', '', '', '', '0000-00-00', 1, '1b60d0fe7f09acfbf2353b11a5bf4f72', NULL),
(68, 'email@email.com', 'Sander', 'B', 'Man', 'tukkerstraat 12', '7777AA', 'Tukkerstad', '0000-00-00', 0, '1b60d0fe7f09acfbf2353b11a5bf4f72', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikersessie`
--

CREATE TABLE `gebruikersessie` (
  `sessie_id` int(11) NOT NULL,
  `gebruiker_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `korting`
--

CREATE TABLE `korting` (
  `korting_id` int(11) NOT NULL,
  `kortingscode` varchar(50) NOT NULL,
  `kortingnaam` varchar(100) NOT NULL,
  `kortingomschrijving` varchar(255) DEFAULT NULL,
  `percentage` int(11) NOT NULL,
  `periode_van` date DEFAULT NULL,
  `periode_tot` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `korting`
--

INSERT INTO `korting` (`korting_id`, `kortingscode`, `kortingnaam`, `kortingomschrijving`, `percentage`, `periode_van`, `periode_tot`) VALUES
(0, 'appel', 'alle USB stuff voor niks! (Nouja bij dan)', NULL, 78, '2020-01-11', '2020-01-18');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orderregel`
--

CREATE TABLE `orderregel` (
  `order_id` int(11) NOT NULL,
  `artikel_id` int(11) DEFAULT NULL,
  `aantal` int(11) DEFAULT NULL,
  `korting_id` int(11) DEFAULT NULL,
  `voorraadstatu` varchar(20) DEFAULT NULL,
  `winkelmand_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `orderregel`
--

INSERT INTO `orderregel` (`order_id`, `artikel_id`, `aantal`, `korting_id`, `voorraadstatu`, `winkelmand_id`) VALUES
(39, 1, 4, NULL, NULL, 2),
(40, 9, 3, NULL, NULL, 2),
(57, 5, 1, NULL, NULL, 3),
(59, 1, 1, NULL, NULL, 6),
(60, 4, 1, NULL, NULL, 6);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `productreview`
--

CREATE TABLE `productreview` (
  `review_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `reviewdatum` datetime NOT NULL,
  `review` text NOT NULL,
  `gebruiker_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `review_score`
--

CREATE TABLE `review_score` (
  `reviewscore_id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `video`
--

CREATE TABLE `video` (
  `video_id` int(11) NOT NULL,
  `bestandslocatie` varchar(255) DEFAULT NULL,
  `publicicatiestatus` smallint(255) DEFAULT NULL,
  `omschrijving` text DEFAULT NULL,
  `videocategorie` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `video`
--

INSERT INTO `video` (`video_id`, `bestandslocatie`, `publicicatiestatus`, `omschrijving`, `videocategorie`) VALUES
(1, 'https://www.youtube.com/embed/q1luOxnSbcY', 1, 'bblaat', NULL),
(2, 'https://www.youtube.com/embed/nXBWfuIQCtg', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `voorraad`
--

CREATE TABLE `voorraad` (
  `voorraad_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `aantal` int(11) NOT NULL,
  `besteldatum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `winkelmand`
--

CREATE TABLE `winkelmand` (
  `winkelmand_id` int(11) NOT NULL,
  `betaling_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `totaalprijs` int(11) NOT NULL,
  `kortingscode` varchar(50) DEFAULT NULL,
  `waardebon` varchar(50) DEFAULT NULL,
  `verwachte_leverdatum` date DEFAULT NULL,
  `gebruiker_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `winkelmand`
--

INSERT INTO `winkelmand` (`winkelmand_id`, `betaling_id`, `order_id`, `totaalprijs`, `kortingscode`, `waardebon`, `verwachte_leverdatum`, `gebruiker_id`) VALUES
(2, 1, 5, 0, 'appel', NULL, NULL, 68),
(3, 1, 6, 0, NULL, NULL, NULL, 0),
(4, 8, 0, 0, NULL, NULL, NULL, 0),
(5, 9, 0, 0, NULL, NULL, NULL, 0),
(6, 10, 0, 0, 'appel', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `zoekwoorden_artikel`
--

CREATE TABLE `zoekwoorden_artikel` (
  `zoekwoord_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `zoekwoord` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `afbeeldingen`
--
ALTER TABLE `afbeeldingen`
  ADD PRIMARY KEY (`afbeelding_id`);

--
-- Indexen voor tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`artikel_id`);

--
-- Indexen voor tabel `artikel_afbeelding`
--
ALTER TABLE `artikel_afbeelding`
  ADD PRIMARY KEY (`artikel_afbeelding_id`),
  ADD KEY `artikel_id` (`artikel_id`),
  ADD KEY `afbeelding_id` (`afbeelding_id`);

--
-- Indexen voor tabel `artikel_categorie`
--
ALTER TABLE `artikel_categorie`
  ADD KEY `artikel_id` (`artikel_id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Indexen voor tabel `artikel_video`
--
ALTER TABLE `artikel_video`
  ADD PRIMARY KEY (`video_artikel_id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `artikel_id` (`artikel_id`);

--
-- Indexen voor tabel `betaling`
--
ALTER TABLE `betaling`
  ADD PRIMARY KEY (`betaling_id`);

--
-- Indexen voor tabel `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`categorie_id`);

--
-- Indexen voor tabel `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexen voor tabel `chatregel`
--
ALTER TABLE `chatregel`
  ADD PRIMARY KEY (`chatregel_id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `gebruiker_id` (`gebruiker_id`);

--
-- Indexen voor tabel `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD PRIMARY KEY (`gebruiker_id`);

--
-- Indexen voor tabel `gebruikersessie`
--
ALTER TABLE `gebruikersessie`
  ADD PRIMARY KEY (`sessie_id`),
  ADD KEY `gebruiker_id` (`gebruiker_id`);

--
-- Indexen voor tabel `korting`
--
ALTER TABLE `korting`
  ADD UNIQUE KEY `kortingscode` (`kortingscode`);

--
-- Indexen voor tabel `orderregel`
--
ALTER TABLE `orderregel`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `winkelmand_id` (`winkelmand_id`);

--
-- Indexen voor tabel `productreview`
--
ALTER TABLE `productreview`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `art_id` (`artikel_id`),
  ADD UNIQUE KEY `UID` (`gebruiker_id`),
  ADD UNIQUE KEY `review_id` (`review_id`);

--
-- Indexen voor tabel `review_score`
--
ALTER TABLE `review_score`
  ADD PRIMARY KEY (`reviewscore_id`),
  ADD KEY `review_id` (`review_id`);

--
-- Indexen voor tabel `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`video_id`);

--
-- Indexen voor tabel `voorraad`
--
ALTER TABLE `voorraad`
  ADD PRIMARY KEY (`voorraad_id`),
  ADD KEY `artikel_id` (`artikel_id`);

--
-- Indexen voor tabel `winkelmand`
--
ALTER TABLE `winkelmand`
  ADD PRIMARY KEY (`winkelmand_id`),
  ADD KEY `betaling_id` (`betaling_id`),
  ADD KEY `kortingscode` (`kortingscode`),
  ADD KEY `gebruiker_id` (`gebruiker_id`);

--
-- Indexen voor tabel `zoekwoorden_artikel`
--
ALTER TABLE `zoekwoorden_artikel`
  ADD PRIMARY KEY (`zoekwoord_id`),
  ADD KEY `artikel_id` (`artikel_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `afbeeldingen`
--
ALTER TABLE `afbeeldingen`
  MODIFY `afbeelding_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `artikel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT voor een tabel `artikel_afbeelding`
--
ALTER TABLE `artikel_afbeelding`
  MODIFY `artikel_afbeelding_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `artikel_video`
--
ALTER TABLE `artikel_video`
  MODIFY `video_artikel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `betaling`
--
ALTER TABLE `betaling`
  MODIFY `betaling_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `categorie`
--
ALTER TABLE `categorie`
  MODIFY `categorie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=978;

--
-- AUTO_INCREMENT voor een tabel `chatregel`
--
ALTER TABLE `chatregel`
  MODIFY `chatregel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT voor een tabel `gebruiker`
--
ALTER TABLE `gebruiker`
  MODIFY `gebruiker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT voor een tabel `gebruikersessie`
--
ALTER TABLE `gebruikersessie`
  MODIFY `sessie_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `orderregel`
--
ALTER TABLE `orderregel`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT voor een tabel `productreview`
--
ALTER TABLE `productreview`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `review_score`
--
ALTER TABLE `review_score`
  MODIFY `reviewscore_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `video`
--
ALTER TABLE `video`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `voorraad`
--
ALTER TABLE `voorraad`
  MODIFY `voorraad_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `winkelmand`
--
ALTER TABLE `winkelmand`
  MODIFY `winkelmand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `zoekwoorden_artikel`
--
ALTER TABLE `zoekwoorden_artikel`
  MODIFY `zoekwoord_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `artikel_afbeelding`
--
ALTER TABLE `artikel_afbeelding`
  ADD CONSTRAINT `artikel_afbeelding_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`artikel_id`),
  ADD CONSTRAINT `artikel_afbeelding_ibfk_2` FOREIGN KEY (`afbeelding_id`) REFERENCES `afbeeldingen` (`afbeelding_id`);

--
-- Beperkingen voor tabel `artikel_categorie`
--
ALTER TABLE `artikel_categorie`
  ADD CONSTRAINT `artikel_categorie_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`artikel_id`),
  ADD CONSTRAINT `artikel_categorie_ibfk_2` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`categorie_id`);

--
-- Beperkingen voor tabel `artikel_video`
--
ALTER TABLE `artikel_video`
  ADD CONSTRAINT `artikel_video_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `video` (`video_id`),
  ADD CONSTRAINT `artikel_video_ibfk_2` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`artikel_id`);

--
-- Beperkingen voor tabel `gebruikersessie`
--
ALTER TABLE `gebruikersessie`
  ADD CONSTRAINT `gebruikersessie_ibfk_1` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruiker` (`gebruiker_id`);

--
-- Beperkingen voor tabel `orderregel`
--
ALTER TABLE `orderregel`
  ADD CONSTRAINT `orderregel_ibfk_1` FOREIGN KEY (`winkelmand_id`) REFERENCES `winkelmand` (`winkelmand_id`);

--
-- Beperkingen voor tabel `productreview`
--
ALTER TABLE `productreview`
  ADD CONSTRAINT `productreview_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`artikel_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `productreview_ibfk_2` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruiker` (`gebruiker_id`);

--
-- Beperkingen voor tabel `review_score`
--
ALTER TABLE `review_score`
  ADD CONSTRAINT `review_score_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `productreview` (`review_id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `voorraad`
--
ALTER TABLE `voorraad`
  ADD CONSTRAINT `voorraad_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`artikel_id`);

--
-- Beperkingen voor tabel `winkelmand`
--
ALTER TABLE `winkelmand`
  ADD CONSTRAINT `winkelmand_ibfk_1` FOREIGN KEY (`betaling_id`) REFERENCES `betaling` (`betaling_id`),
  ADD CONSTRAINT `winkelmand_ibfk_2` FOREIGN KEY (`kortingscode`) REFERENCES `korting` (`kortingscode`),
  ADD CONSTRAINT `winkelmand_ibfk_3` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruiker` (`gebruiker_id`);

--
-- Beperkingen voor tabel `zoekwoorden_artikel`
--
ALTER TABLE `zoekwoorden_artikel`
  ADD CONSTRAINT `zoekwoorden_artikel_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`artikel_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
