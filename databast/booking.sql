-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2024 at 05:51 AM
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
-- Database: `bb_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bk_id` int(11) NOT NULL,
  `bk_startdate` datetime NOT NULL,
  `bk_enddate` datetime DEFAULT NULL,
  `bk_price` int(11) NOT NULL,
  `ws_id` int(11) NOT NULL,
  `cus_id` int(11) NOT NULL,
  `hair_id` int(11) NOT NULL,
  `lo_id` int(11) NOT NULL,
  `ba_id` int(11) NOT NULL,
  `bk_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bk_id`, `bk_startdate`, `bk_enddate`, `bk_price`, `ws_id`, `cus_id`, `hair_id`, `lo_id`, `ba_id`, `bk_status`) VALUES
(13, '2024-04-08 00:00:00', '2024-04-08 00:00:00', 4076, 31, 50, 6, 1, 10, 0),
(14, '2024-04-11 00:00:00', '2024-04-08 00:00:00', 353, 53, 50, 4, 1, 10, 1),
(15, '2024-04-08 18:00:00', '2024-04-08 18:00:00', 353, 54, 50, 6, 1, 10, 0),
(16, '2024-04-09 00:00:00', '2024-04-09 00:00:00', 353, 56, 50, 4, 1, 10, 5),
(17, '2024-04-10 00:00:00', '2024-04-10 00:00:00', 353, 56, 50, 4, 1, 10, 5),
(18, '2024-04-10 00:00:00', '2024-04-10 00:00:00', 353, 56, 50, 6, 1, 10, 5),
(140, '2024-04-24 14:00:00', '2024-04-24 14:00:00', 353, 62, 50, 6, 1, 10, 5),
(141, '2024-04-28 17:08:00', '2024-04-28 17:08:00', 353, 63, 50, 6, 1, 10, 3),
(142, '2024-05-07 21:00:00', '2024-05-07 21:00:00', 353, 66, 50, 6, 1, 10, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bk_id`),
  ADD KEY `booking_ibfk_1` (`lo_id`),
  ADD KEY `cus_id` (`cus_id`),
  ADD KEY `hair_id` (`hair_id`),
  ADD KEY `ws_id` (`ws_id`),
  ADD KEY `ba_id` (`ba_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`lo_id`) REFERENCES `location` (`lo_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`cus_id`) REFERENCES `customer` (`cus_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`hair_id`) REFERENCES `hairstlye` (`hair_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_4` FOREIGN KEY (`ws_id`) REFERENCES `workschedule` (`ws_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_5` FOREIGN KEY (`ba_id`) REFERENCES `barber` (`ba_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
