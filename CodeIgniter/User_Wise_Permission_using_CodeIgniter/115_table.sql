-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2015 at 08:49 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shah_makdum`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL,
  `id_number` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` varchar(50) NOT NULL COMMENT '0=Memeber,  1=Admin,  2=User,  3=Report',
  `status` enum('Enable','Disable') NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `id_number`, `password`, `level`, `status`) VALUES
(1, 'admin', 'admin', '', 'Enable'),
(8, 'SMGLT', 'smglSD', '', 'Enable');

-- --------------------------------------------------------

--
-- Table structure for table `member_acl_level`
--

CREATE TABLE IF NOT EXISTS `member_acl_level` (
  `username_id` int(10) NOT NULL,
  `acl_id` int(10) NOT NULL,
  `priority` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member_acl_level`
--

INSERT INTO `member_acl_level` (`username_id`, `acl_id`, `priority`) VALUES
(1, 8, 0),
(1, 7, 9),
(1, 5, 8),
(1, 6, 7),
(1, 3, 6),
(1, 1, 5),
(1, 9, 2),
(1, 4, 4),
(1, 10, 3),
(1, 11, 1),
(1, 2, 10),
(8, 2, 6),
(8, 8, 5),
(8, 7, 4),
(8, 6, 3),
(8, 5, 9),
(8, 3, 2),
(8, 1, 8),
(8, 4, 7),
(8, 9, 1),
(8, 11, 0);

-- --------------------------------------------------------

--
-- Table structure for table `member_acl_list`
--

CREATE TABLE IF NOT EXISTS `member_acl_list` (
  `id` int(10) NOT NULL,
  `acl_name` varchar(100) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member_acl_list`
--

INSERT INTO `member_acl_list` (`id`, `acl_name`, `last_update`) VALUES
(1, 'Employee Information', '2012-05-29 15:09:05'),
(2, 'Setup ', '2012-05-05 15:29:17'),
(3, 'Entry System', '2012-05-05 15:29:34'),
(4, 'Attendance Process', '2012-05-05 05:00:00'),
(5, 'HRM Reports', '2012-05-05 00:00:00'),
(6, 'HRM Others Report', '2012-05-16 00:00:00'),
(7, 'Salary Process', '2012-05-05 00:00:00'),
(8, 'Salary Report', '2012-05-05 00:00:00'),
(9, 'Database Backup', '2012-05-05 00:00:00'),
(10, 'Administrator', '2012-05-05 00:00:00'),
(11, 'User Manage', '2012-05-05 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_number` (`id_number`);

--
-- Indexes for table `member_acl_list`
--
ALTER TABLE `member_acl_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `member_acl_list`
--
ALTER TABLE `member_acl_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
