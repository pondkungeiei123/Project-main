-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2024 at 06:54 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ad_id` int(11) NOT NULL,
  `ad_name` varchar(50) NOT NULL,
  `ad_lastname` varchar(50) NOT NULL,
  `ad_email` varchar(60) NOT NULL,
  `ad_password` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ad_id`, `ad_name`, `ad_lastname`, `ad_email`, `ad_password`) VALUES
(1, 'sukanya', 'chinkhum', 'admin@gmail.com', '$2y$10$tjb8cYM1Tpm/8yuwOCBpV.BlMoxaLXyAxx9WSZ8Ept/tSREPcFwAC'),
(3, 'wer', 'wer', 'pond@gmail.com', '$2y$10$2U/gUTrGsGRDHVO7sM3/Te/vYRrsL2ayOG69tAsQ62GueWDKdHiAO'),
(7, 'sukanya', 'chinkhum', 'sakanya@gmail.com', '$2y$10$wp.f34yo8vZdslTqSSW.S.vLNKEEI6yuIwat7Zx7lPQYx9h14qnE.'),
(12, 'สมชาย', 'สองใจ', 'pond1@gmail.com', '$2y$10$KIvM5/.5TR4wpOkFWI0OKuruKRvEFHikvySQlQ3GedvIVjUlQ/Zfe'),
(20, 'Admin', 'admin', 'Admin', '$2y$10$XEyCCcO3HFHSQn2AncPtaeTS05SpcADqZr17ss3yJ0.ibAq94FrLm'),
(27, 'ศุภรักษ์', 'สะเดา', 'admin1@gmail.com', '$2y$10$5fUVhlUj6ED8hNbZ4epRb.mNP3BjX2QZ4S3a8Uq/d7jCoy7xur7pC');

-- --------------------------------------------------------

--
-- Table structure for table `barber`
--

CREATE TABLE `barber` (
  `ba_id` int(11) NOT NULL,
  `ba_name` varchar(50) NOT NULL,
  `ba_lastname` varchar(50) NOT NULL,
  `ba_phone` varchar(12) NOT NULL,
  `ba_email` varchar(50) NOT NULL,
  `ba_password` text NOT NULL,
  `ba_idcard` varchar(13) NOT NULL,
  `ba_certificate` varchar(255) DEFAULT NULL,
  `ba_namelocation` varchar(255) NOT NULL,
  `ba_latitude` double NOT NULL,
  `ba_longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barber`
--

INSERT INTO `barber` (`ba_id`, `ba_name`, `ba_lastname`, `ba_phone`, `ba_email`, `ba_password`, `ba_idcard`, `ba_certificate`, `ba_namelocation`, `ba_latitude`, `ba_longitude`) VALUES
(3, 'เกียรติยศ', 'เกรียงไกรวรรณ', '0878027981', 'kaittiyos@gmail.com', '$2y$10$tsvphOSbKY9FWEdKU5CO1uPX9cfe.6HYIU1CD7OE7Ky4FFnGDedJq', '14199019461', '6606edd71f1c6_cer.jpg', 'เดอะ เบส ไฮท์ มิตรภาพ - ขอนแก่น', 0, 102.82650925219),
(10, 'สุกัญญา', 'ชินคำ', '0639781398', 'barber@gmail.com', '$2y$10$y1fH.k7PSOE7Do4Askt3deCVEP9ESTCUeaviTsVMfl6oYloBrWYtm', '15451', '66098df2e11ca_cer.jpg', 'ขอนแก่น', 0, 102.76636306196),
(12, 'ศุภรักษ์ ', 'สะเดา', '0650949790', 'pond@gmail.com', '123', '1459900924562', '2024-05-27/665496996fe17_069b8c3ff3.png', 'Roi Et', 0, 103.7289167),
(16, 'ศุภรักษ์ ', 'สะเดา', '1234567890', 'kanatakung1123@gmail.com', '123', '1459900924562', '2024-05-30/6657f4361f3a4_069b8c3ff3.png', 'Bangkok', 0, 100.5017651);

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
(13, '2024-04-08 00:00:00', '2024-04-08 00:00:00', 4076, 31, 50, 105, 1, 10, 0),
(14, '2024-04-11 00:00:00', '2024-04-08 00:00:00', 353, 53, 50, 105, 1, 10, 1),
(15, '2024-04-08 18:00:00', '2024-04-08 18:00:00', 353, 54, 50, 106, 1, 10, 0),
(16, '2024-04-09 00:00:00', '2024-04-09 00:00:00', 353, 56, 50, 105, 1, 10, 5),
(17, '2024-04-10 00:00:00', '2024-04-10 00:00:00', 353, 56, 50, 105, 1, 10, 5),
(18, '2024-04-10 00:00:00', '2024-04-10 00:00:00', 353, 56, 50, 106, 1, 10, 5),
(140, '2024-04-24 14:00:00', '2024-04-24 14:00:00', 353, 62, 50, 106, 1, 10, 5),
(141, '2024-04-28 17:08:00', '2024-04-28 17:08:00', 353, 63, 50, 106, 1, 10, 3),
(142, '2024-05-07 21:00:00', '2024-05-07 21:00:00', 353, 66, 50, 106, 1, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cus_id` int(11) NOT NULL,
  `cus_name` varchar(50) NOT NULL,
  `cus_lastname` varchar(50) NOT NULL,
  `cus_phone` varchar(12) NOT NULL,
  `cus_email` varchar(50) NOT NULL,
  `cus_password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cus_id`, `cus_name`, `cus_lastname`, `cus_phone`, `cus_email`, `cus_password`) VALUES
(25, 'kaittiyos', 'kaittiyos', '0958027929', 'pao@gmail.com', '202cb962ac59075b964b07152d234b70'),
(50, 'สุกัญญา', 'ชินคำ', '06989888', 'cus@gmail.com', '$2y$10$4ybDmCm7RVp3gAY/lLVv0uo3W8ZLF5NrLncuRUzGvLjZPJHYzkJ2a'),
(51, 'pond', 'kung', '06094949472', 'pond@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `hairstlye`
--

CREATE TABLE `hairstlye` (
  `hair_id` int(11) NOT NULL,
  `hair_name` varchar(50) NOT NULL,
  `hair_price` int(11) NOT NULL,
  `hair_photo` varchar(255) NOT NULL,
  `ba_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hairstlye`
--

INSERT INTO `hairstlye` (`hair_id`, `hair_name`, `hair_price`, `hair_photo`, `ba_id`) VALUES
(105, 'ทรงรองทรง', 130, '2024-05-29/6657444af3f63_eebfd65eda.jpg', 10),
(106, 'ทรงทูบล็อค', 150, '2024-05-29/66574461b57bd_8-13.jpeg.jpeg', 10),
(107, 'ทรงอันเดอร์คัต', 1223, '2024-05-29/665744760d041_3e8b163b07.jpg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `lo_id` int(11) NOT NULL,
  `cus_id` int(11) NOT NULL,
  `lo_name` varchar(200) NOT NULL,
  `lo_latitude` double NOT NULL,
  `lo_longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`lo_id`, `cus_id`, `lo_name`, `lo_latitude`, `lo_longitude`) VALUES
(1, 50, 'หอพักส.สงมา', 16.4247059, 102.8564783),
(11, 50, 'กรุงเทพ', 13.736717, 100.523186),
(12, 50, 'ขอนแก่น', 15.978131858212084, 102.68649324774742),
(13, 50, 'home', 13.736717, 100.523186),
(14, 50, 'home 1', 37.42204984555153, -122.08394486457111);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pm_id` int(11) NOT NULL,
  `pm_amount` int(11) NOT NULL,
  `pm_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pm_status` int(11) NOT NULL,
  `bk_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`pm_id`, `pm_amount`, `pm_time`, `pm_status`, `bk_id`) VALUES
(1, 353, '2024-04-09 17:38:33', 0, 16),
(2, 353, '2024-04-10 11:44:44', 0, 17),
(3, 353, '2024-04-10 15:59:04', 0, 18),
(4, 353, '2024-04-24 07:11:53', 0, 140),
(5, 353, '2024-04-24 07:12:15', 0, 140);

-- --------------------------------------------------------

--
-- Table structure for table `workings`
--

CREATE TABLE `workings` (
  `wo_id` int(11) NOT NULL,
  `wo_photo` varchar(50) NOT NULL,
  `ba_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workings`
--

INSERT INTO `workings` (`wo_id`, `wo_photo`, `ba_id`) VALUES
(17, '657c0a2aea07e_workings.jpg', 10),
(45, '66100de3d78ed_workings.jpg', 10),
(47, '662e1200a9d35_workings.jpg', 10),
(48, '662e121b74819_workings.jpg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `workschedule`
--

CREATE TABLE `workschedule` (
  `ws_id` int(11) NOT NULL,
  `ba_id` int(11) NOT NULL,
  `ws_startdate` datetime NOT NULL,
  `ws_enddate` datetime NOT NULL,
  `ws_note` varchar(255) NOT NULL,
  `ws_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workschedule`
--

INSERT INTO `workschedule` (`ws_id`, `ba_id`, `ws_startdate`, `ws_enddate`, `ws_note`, `ws_status`) VALUES
(29, 10, '2024-04-07 00:00:00', '2024-04-07 01:00:00', '', 0),
(30, 10, '2024-04-06 00:00:00', '2024-04-06 01:00:00', 'test', 0),
(31, 10, '2024-04-08 00:00:00', '2024-04-08 01:00:00', '123', 1),
(53, 10, '2024-04-11 00:00:00', '2024-04-11 01:00:00', '', 1),
(54, 10, '2024-04-08 18:00:00', '2024-04-08 23:00:00', '', 1),
(56, 10, '2024-04-10 00:00:00', '2024-04-10 23:00:00', '', 0),
(57, 10, '2024-04-21 14:00:00', '2024-04-21 15:00:00', 'test', 0),
(58, 10, '2024-04-21 15:00:00', '2024-04-21 16:00:00', '', 0),
(59, 10, '2024-04-22 13:00:00', '2024-04-22 14:00:00', '', 0),
(60, 3, '2024-04-22 15:00:00', '2024-04-22 16:00:00', '', 0),
(61, 10, '2024-04-23 13:00:00', '2024-04-23 14:00:00', '', 0),
(62, 10, '2024-04-24 14:00:00', '2024-04-24 15:00:00', '', 0),
(63, 10, '2024-04-28 17:08:00', '2024-04-28 17:08:45', '', 1),
(65, 10, '2024-04-28 13:00:00', '2024-04-28 14:00:00', '123', 0),
(66, 10, '2024-05-07 21:00:00', '2024-05-07 22:00:00', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `barber`
--
ALTER TABLE `barber`
  ADD PRIMARY KEY (`ba_id`);

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
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cus_id`);

--
-- Indexes for table `hairstlye`
--
ALTER TABLE `hairstlye`
  ADD PRIMARY KEY (`hair_id`),
  ADD KEY `ba_id` (`ba_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`lo_id`),
  ADD KEY `cus_id` (`cus_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pm_id`),
  ADD KEY `bk_id` (`bk_id`);

--
-- Indexes for table `workings`
--
ALTER TABLE `workings`
  ADD PRIMARY KEY (`wo_id`),
  ADD KEY `ba_id` (`ba_id`);

--
-- Indexes for table `workschedule`
--
ALTER TABLE `workschedule`
  ADD PRIMARY KEY (`ws_id`),
  ADD KEY `ba_id` (`ba_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `barber`
--
ALTER TABLE `barber`
  MODIFY `ba_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `hairstlye`
--
ALTER TABLE `hairstlye`
  MODIFY `hair_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `lo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `pm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `workings`
--
ALTER TABLE `workings`
  MODIFY `wo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `workschedule`
--
ALTER TABLE `workschedule`
  MODIFY `ws_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

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

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`cus_id`) REFERENCES `customer` (`cus_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`bk_id`) REFERENCES `booking` (`bk_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `workings`
--
ALTER TABLE `workings`
  ADD CONSTRAINT `workings_ibfk_1` FOREIGN KEY (`ba_id`) REFERENCES `barber` (`ba_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `workschedule`
--
ALTER TABLE `workschedule`
  ADD CONSTRAINT `workschedule_ibfk_1` FOREIGN KEY (`ba_id`) REFERENCES `barber` (`ba_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
