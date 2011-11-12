-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 12, 2011 at 10:24 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `birds_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `birdImages`
--

CREATE TABLE IF NOT EXISTS `birdImages` (
  `imageID` int(11) NOT NULL AUTO_INCREMENT,
  `birdID` int(10) unsigned NOT NULL,
  `fileLocation` varchar(50) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`imageID`),
  KEY `birdID` (`birdID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `birdImages`
--
ALTER TABLE `birdImages`
  ADD CONSTRAINT `birdImages_ibfk_1` FOREIGN KEY (`birdID`) REFERENCES `birds` (`birdID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
