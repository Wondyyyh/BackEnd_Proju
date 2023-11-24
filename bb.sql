-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2023 at 02:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bb`
--

-- --------------------------------------------------------

--
-- Table structure for table `msg`
--

CREATE TABLE `msg` (
  `id` int(11) NOT NULL,
  `thread` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `author` int(11) NOT NULL,
  `replyto` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `hidden` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `msg`
--

INSERT INTO `msg` (`id`, `thread`, `title`, `content`, `author`, `replyto`, `created`, `modified`, `hidden`) VALUES
(1, 1, 'Kommentti', 'Se on hyvä siellä', 2, NULL, '2023-10-11 12:09:45', '2023-10-11 12:10:45', 0),
(2, 1, 'Kommentti', 'Oikein AP:lle', 1, NULL, '2023-10-11 12:11:45', '2023-10-11 12:10:45', 0),
(3, 1, 'Kommentti', '#Asiallinen Oikeasti avun tarpeessa', 0, NULL, '2023-10-11 12:12:45', '2023-10-11 12:10:45', 0),
(4, 2, 'Kommentti', 'Miten se sinne on jämähtänyt', 0, NULL, '2023-10-11 12:20:43', '2023-10-11 12:20:43', 0),
(5, 2, 'Kommentti', 'Kysymys kuuluu miten on jouduttu tilanteeseen jossa karhupumppua tarvitaan', 2, NULL, '2023-10-11 12:22:10', '2023-10-11 12:22:10', 0),
(6, 2, 'Kommentti', 'AP syöny runsaasti viljapitoisia tuotteita', 0, NULL, '2023-10-11 12:23:18', '2023-10-11 12:23:18', 0),
(7, 2, 'Kommentti', 'Väärä häly, pumppu irtosi', 1, NULL, '2023-10-11 12:24:28', '2023-10-11 12:24:28', 0),
(8, 2, 'Kommentti', 'Mies tuli hätiin ja kirjaimellisesti nyt hätä kädessä xdd', 1, NULL, '2023-10-11 12:25:28', '2023-10-11 12:25:28', 0),
(9, 1, 'Kommentti', 'testaus reply', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(10, 3, 'Uusi keskustelu', 'Tämä on keskustelun ensimmäinen viesti', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(11, 4, 'Uusin Keskustelu', 'Uusin viesti', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(12, 4, 'Kommentti', 'Hyvä keskustelu meneillään', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(13, 4, 'kommentti', 'tämä on viesti numero 3', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(17, 4, 'Kommentti', 'tämä on viesti numero 4', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(18, 4, 'Kommentti tested', 'No niin todentotta on!!', 0, NULL, '0000-00-00 00:00:00', '2023-11-08 12:42:40', 0),
(19, 2, 'Kommentti', 'Miten se sinne on jämähtänyt', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(20, 3, 'Kommentti', 'No eipä ollukkaan', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(21, 5, 'Tämä on uusi testi', '', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(22, 5, 'Kommentti', 'adawdawd', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(23, 6, 'testikeskustelu', 'eka viesti', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(24, 7, 'Tämä on testi', 'testin ensimmäinen viesti', 12, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(25, 7, 'jaska', 'paska', 12, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(26, 5, 'Kommentti edited', 'No niin todentotta on!! edited', 12, NULL, '0000-00-00 00:00:00', '2023-11-08 15:39:42', 0),
(27, 8, 'otsikko', '', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(28, 9, 'uusi otsikko', '', 0, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE `thread` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `author` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `hidden` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`id`, `title`, `author`, `created`, `hidden`) VALUES
(1, 'Porkkana väärinpäin perseessä', 0, '2023-10-04 14:22:01', 0),
(2, 'Karhupumppu stuck in pönttö', 1, '2023-10-04 14:29:28', 0),
(3, 'Uusi keskustelu', 0, '0000-00-00 00:00:00', 0),
(4, 'Uusin Keskustelu', 0, '0000-00-00 00:00:00', 0),
(5, 'Tämä on uusi testi', 0, '0000-00-00 00:00:00', 0),
(6, 'testikeskustelu', 0, '0000-00-00 00:00:00', 1),
(7, 'Tämä on testi', 12, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `firstname` tinytext DEFAULT NULL,
  `lastname` tinytext DEFAULT NULL,
  `created` datetime NOT NULL,
  `lastseen` datetime NOT NULL,
  `banned` tinyint(1) NOT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `firstname`, `lastname`, `created`, `lastseen`, `banned`, `isadmin`) VALUES
(0, 'jannesi', '1234', 'janne', 'sillinpää', '2023-10-04 14:03:14', '2023-10-04 14:03:14', 0, 1),
(1, 'jasu', '1234', 'jasu', NULL, '2023-10-04 14:32:39', '2023-10-04 14:32:39', 0, 0),
(2, 'janne', '2134', 'jane', 'sili', '2023-10-11 11:55:54', '2023-10-11 11:55:54', 0, 0),
(4, 'erkki', '1234', '', '  ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(10, 'jonne', '1234', 'jonne', ' es ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(11, 'jasi', '1234', 'jasi', ' pasi ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(12, 'harkka', '1234', 'harkka', '  ', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `msg`
--
ALTER TABLE `msg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `msg`
--
ALTER TABLE `msg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
