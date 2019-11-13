-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 11, 2019 at 06:29 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `star_platformer`
--

-- --------------------------------------------------------

--
-- Table structure for table `gamers`
--

DROP TABLE IF EXISTS `gamers`;
CREATE TABLE IF NOT EXISTS `gamers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gamingname` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `highestscore` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL,
  `life` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gamingname` (`gamingname`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gamers`
--

INSERT INTO `gamers` (`id`, `gamingname`, `password`, `highestscore`, `score`, `health`, `life`, `created_at`) VALUES
(1, 'Lucifer', '$2y$10$IP71XT0bEivw76pTvvjcheyp6UfMc5ES8iyXC45UUQDm.oy.vp4VW', NULL, 0, 0, 0, '2019-10-06 13:06:37'),
(2, 'YRA', '$2y$10$IZqdmXb5MFyn.jp1Nuoodulx4jiYXzEyU8enkJARgSavq49XkRFz.', NULL, NULL, NULL, NULL, '2019-10-09 08:39:19');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
