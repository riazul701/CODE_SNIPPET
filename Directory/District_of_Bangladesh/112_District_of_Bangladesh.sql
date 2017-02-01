-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2015 at 05:35 AM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrp`
--

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `district_id` smallint(5) UNSIGNED NOT NULL,
  `district` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`district_id`, `district`) VALUES
(3, 'Dhaka'),
(4, 'Gazipur'),
(5, 'Mymensingh'),
(7, 'Naogaon'),
(8, 'Natore'),
(9, 'Rajshahi'),
(10, 'Chapainawabgonj'),
(11, 'Bogra'),
(12, 'Rangpur'),
(13, 'Gaibandha'),
(14, 'Lalmonirhat'),
(15, 'Kurigram'),
(16, 'Nilphamary'),
(17, 'Dinajpur'),
(18, 'Thakurgaon'),
(19, 'Panchagar'),
(20, 'Sirajgonj'),
(21, 'Pabna'),
(22, 'Kustia'),
(23, 'Jessore'),
(24, 'Magura'),
(25, 'Jhenada'),
(26, 'Meherpur'),
(27, 'Chuadanga'),
(28, 'Narail'),
(29, 'Satkhira'),
(30, 'Khulna'),
(31, 'Bagerhat'),
(32, 'Pirojpur'),
(33, 'Jhalokathi'),
(34, 'Patuakhali'),
(35, 'Barisal'),
(36, 'Bhola'),
(37, 'Madaripur'),
(38, 'Sariatpur'),
(39, 'Faridpur'),
(40, 'Manikgonj'),
(41, 'Tangail'),
(42, 'Kishoregonj'),
(43, 'Netrokona'),
(44, 'Sherpur'),
(46, 'Jamalpur'),
(47, 'Sunamgong'),
(48, 'Sylhet'),
(49, 'Moulvibazar'),
(50, 'Bramonbaria'),
(51, 'Comilla'),
(52, 'Chadpur'),
(53, 'Noakhali'),
(54, 'Laxmipur'),
(55, 'Feni'),
(56, 'Chittagong'),
(57, 'Coxbazar'),
(58, 'Banderbon'),
(59, 'Rangamati'),
(60, 'Khagrachari'),
(61, 'Narayangonj'),
(62, 'Habigonj'),
(63, 'Munsigonj'),
(64, 'Joypurhat'),
(65, 'Rajbari'),
(66, 'Borguna'),
(67, 'Norsingdi'),
(68, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`district_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `district_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
