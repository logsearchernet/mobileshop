-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2015 at 04:02 AM
-- Server version: 5.6.26
-- PHP Version: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mobileshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `ms_category`
--
DROP TABLE IF EXISTS `ms_category`;
CREATE TABLE IF NOT EXISTS `ms_category` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_category` bigint(20) NOT NULL,
  `description` tinytext NOT NULL,
  `displayed` tinyint(1) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `position` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

INSERT INTO `ms_category` (`id`, `name`, `parent_category`, `description`, `displayed`, `created_date`, `modified_date`, `position`) VALUES
(67, 'aaa', 0, 'dddd', 0, '2015-12-11 03:32:13', '2015-12-11 04:52:13', 2),
(70, 'Lim Mew Sang', 0, 'sdsdsd', 1, '2015-12-11 03:36:01', '2015-12-11 04:51:35', 3),
(71, 'Pre Order Surface Pro 4', 0, 'ssasdsad', 1, '2015-12-11 03:45:26', '2015-12-11 04:51:33', 4),
(72, 'sample 11', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(73, 'sample 22', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(74, 'sample 33', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(75, 'sample 44', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(76, 'sample 55', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(77, 'sample 66', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(78, 'sample 77', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(79, 'sample 88', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(80, 'sample 99', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(81, 'sample 100', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(82, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(83, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(84, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(85, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(86, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(87, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(88, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(89, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(90, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(91, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(92, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(93, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(94, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(95, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(96, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(97, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5),
(98, 'sample', 0, 'asdasd', 1, '2015-12-11 03:45:41', '2015-12-11 04:44:27', 5);

--
-- Indexes for table `ms_category`
--
ALTER TABLE `ms_category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ms_category`
--
ALTER TABLE `ms_category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=66;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
