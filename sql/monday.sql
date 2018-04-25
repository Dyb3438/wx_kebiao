-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2018-04-24 13:14:12
-- 服务器版本： 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wx_2017kebiao`
--

-- --------------------------------------------------------

--
-- 表的结构 `monday`
--

DROP TABLE IF EXISTS `monday`;
CREATE TABLE IF NOT EXISTS `monday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xh` bigint(20) NOT NULL,
  `class` varchar(25) COLLATE utf8_bin NOT NULL,
  `classname` varchar(25) COLLATE utf8_bin NOT NULL,
  `teacher` varchar(100) COLLATE utf8_bin NOT NULL,
  `classroom` varchar(25) COLLATE utf8_bin NOT NULL,
  `single_week` int(11) NOT NULL,
  `weeklong` varchar(25) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
