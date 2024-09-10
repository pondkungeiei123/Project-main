-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 03:07 PM
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
(1, 'sukanya', 'chinkhum', 'admin@gmail.com', '$2y$10$jI/0b0.ldRK6uBj6tah.R.jWoKpo3W8g7XkCK5DJpRbMPILh4/0oG'),
(3, 'wer', 'wer', 'pond@gmail.com', '123456'),
(7, 'sukanya', 'chinkhum', 'sakanya@gmail.com', '$2y$10$wp.f34yo8vZdslTqSSW.S.vLNKEEI6yuIwat7Zx7lPQYx9h14qnE.'),
(11, 'สมสมสม', 'นา', 'ponnd@gmail.com', '$2y$10$bYGtMoUy7DvE8ITfquu0Ke5REy004lGCSEm2Pa5ipi.U2Pd3ZT43O'),
(13, 'ศุภรักษ์ ', 'สะเดา', 'pondkungtot@gmail.com', '$2y$10$ujRJIAYQF0i2lsyc/wr0U.QBpYBmpBy.cARqzTVdI6.4GT/kM1xjW'),
(17, 'Admin1', 'สองใจ', 'pond123@gmail.com', '$2y$10$oITgoUpTGw2B.4pwBRVRCua115AcvdBMrFVAJ73X4vS4FaHlDPDoi');

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
  `ba_namelocation` varchar(255) NOT NULL,
  `ba_latitude` double NOT NULL,
  `ba_longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barber`
--

INSERT INTO `barber` (`ba_id`, `ba_name`, `ba_lastname`, `ba_phone`, `ba_email`, `ba_password`, `ba_idcard`, `ba_namelocation`, `ba_latitude`, `ba_longitude`) VALUES
(3, 'เกียรติยศ', 'เกรียงไกรวรรณ', '0878027981', 'kaittiyos@gmail.com', '$2y$10$tsvphOSbKY9FWEdKU5CO1uPX9cfe.6HYIU1CD7OE7Ky4FFnGDedJq', '1419901946112', 'เดอะ เบส ไฮท์ มิตรภาพ - ขอนแก่น', 0, 102.82650925219),
(10, 'สุสัญญา', 'ชินคำ', '0639781398', 'barber@gmail.com', '$2y$10$yHmKVqnuMAUjCtMeIqN4gu2.MJ11mSazU4AqVPgp1fNzg..QV2gK2', '1459900032548', 'เซ็นทรัล ขอนแก่น ถนน มิตรภาพ ตำบล ในเมือง อำเภอเมืองขอนแก่น ขอนแก่น ประเทศไทย', 16.4329489, 102.8257675),
(12, 'ศุภรักษ์ ', 'นอนน้อย', '0659497955', 'pondkungtot@gmail.com', '123', '1459900925462', 'Rajamangala University of Technology Isan Khon Kaen Campus', 16.4282615, 102.8635969),
(13, 'pop', 'opo', '0848787897', 'pllp@gmail.com', '$2y$10$xTMOodeJLnvPsN.1sQZN2u1cCGGmi21mxKOIv6KTIXYtHAR3UyR.S', '1459988999888', 'Roi Et พาซ่า', 15.9032933, 103.7289167),
(16, 'popmank', 'opo', '0848787897', 'nana@gmail.com', '$2y$10$qFsHK/8HOLGP2YCQWyL21uzrHoQQv/V.k9iDl4eviHV.N5pfEL95W', '1459988999888', 'ร้านตัดผมนายนา', 13.7563309, 100.5017651),
(19, 'วัน', 'ทรู', '1234567890', 'onetwo54@gmail.com', '$2y$10$kaJuj9ztuUDAAgGh.RhNjeJBRUxW6D/fr5WT0QRCJ0CQ5TVvyRwTa', '1459900588458', 'ร้านตัดผมของเรา', 15.9032933, 103.7289167),
(20, 'สมชัย', 'กลายเเก้ว', '0659897875', 'onetwo31151@gmail.com', '$2y$10$grkr213Tc5gE5UVxTB15gOr1dez3IjETqAWvg5bj/0VS9/2aYC51e', '1459900875878', 'ร้านตัดผมซอยข้าง', 16.0565411, 103.656711),
(21, 'ดำ', 'ด้าน', '0985685858', 'black@gmail.com', '$2y$10$3PNV5iZ2tl2xKf92I/0fTu7afspju0bOUSw.r62zcZr3w5e7ck0Ve', '1458788759658', 'ร้านตัดผมพลาซ่า', 16.0565411, 103.6567209);

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
(151, '2024-06-07 12:00:00', '2024-06-07 12:00:00', 4079, 69, 25, 20, 18, 10, 0),
(152, '2024-07-03 12:02:42', '2024-07-03 13:02:42', 200, 63, 51, 20, 17, 13, 0),
(153, '2024-07-04 12:02:42', '2024-07-04 13:02:42', 300, 53, 57, 18, 11, 3, 0),
(154, '2024-08-02 12:16:29', '2024-08-02 15:16:29', 500, 73, 25, 20, 11, 3, 0),
(155, '2024-08-03 07:16:29', '2024-08-03 14:16:29', 250, 73, 25, 20, 17, 3, 0),
(159, '2024-08-13 13:00:00', '2024-08-13 13:00:00', 398, 103, 50, 22, 16, 10, 1),
(161, '2024-08-12 12:00:00', '2024-08-12 12:00:00', 398, 105, 50, 22, 16, 10, 5);

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

CREATE TABLE `certificate` (
  `ce_id` int(11) NOT NULL,
  `ce_photo` varchar(200) NOT NULL,
  `ba_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificate`
--

INSERT INTO `certificate` (`ce_id`, `ce_photo`, `ba_id`) VALUES
(11, '66a9155455e8b_business F.png', 13),
(12, '66a9165e30fb4_แบบ?.png', 14),
(13, '66a916902b08d_business F.png', 15),
(14, '66a9d13cd350f_dfd 1.png.png', 16),
(15, '66a9d13cd350f_dfd 1.png.png', 16),
(16, '66a9f65e6e1de_dfd 1.png.png', 17),
(17, '66b7001f7eb1a_qf1r0gq5l8.jpg', 18),
(18, '66b703eea688e_qf1r0gq5l8.jpg', 19),
(20, '66b976ca992ff_86661827_2874996002523122_6811318862982676480_n.jpg', 10),
(21, '66d5bf16e8b12_login_cus .png', 20),
(22, '66d5bfa0c1c0a_42576603_1.jpg', 21),
(23, '66d5c7cbb7e14_42576603_1.jpg', 22);

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
(25, 'kaittiyos', 'kaittiyos', '0958027929', 'pao@gmail.com', '$2y$10$4ybDmCm7RVp3gAY/lLVv0uo3W8ZLF5NrLncuRUzGvLjZPJHYzkJ2a'),
(50, 'sukanya', 'ชินคำ', '06989888', 'cus@gmail.com', '$2y$10$4ybDmCm7RVp3gAY/lLVv0uo3W8ZLF5NrLncuRUzGvLjZPJHYzkJ2a'),
(51, 'pond', 'kung', '06094949472', 'pond@gmail.com', '123'),
(57, 'สมสน', 'เกรียง', '0858130881', 'somson@gmail.com', '$2y$10$iR258aGwyntr5utYhb2XxewJei96wEMN/0g39izMWAAh/7xSbCnBy'),
(58, 'ศุภรักษ์', 'สะเดา', '0650949790', 'pondkungtot@gmail.com', '$2y$10$YC6UFDMdbNz7R3hsdWs6G.s12BdOspNaZfTOJp0FSZWpT1MZFilhC');

-- --------------------------------------------------------

--
-- Table structure for table `hairstlye`
--

CREATE TABLE `hairstlye` (
  `hair_id` int(11) NOT NULL,
  `hair_name` varchar(50) NOT NULL,
  `hair_price` int(11) NOT NULL,
  `hair_photo` varchar(50) NOT NULL,
  `ba_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hairstlye`
--

INSERT INTO `hairstlye` (`hair_id`, `hair_name`, `hair_price`, `hair_photo`, `ba_id`) VALUES
(15, 'วินเทจ', 200, '665c30498c777_hair.jpg', 10),
(16, 'รองทรงสูง', 80, '665c3199e90c4_hair.jpg', 10),
(18, 'นักเรียน2', 100, '6661c90df38b3_hair.jpg', 10),
(19, 'ทรงสกรีนเฮด', 150, '666281646fef8_hair.jpg', 10),
(20, 'ทรงรองทรงตัำ', 100, '666281ac23e1a_hair.jpg', 10),
(22, 'รองทรงสั้น', 120, '66b973ab651b1_hair.jpg', 10);

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
(11, 50, 'Bangkok, ประเทศไทย', 13.7563309, 100.5017651),
(16, 50, 'ขอนแก่น ประเทศไทย', 15.9717357, 102.6216211),
(17, 50, 'Udon Thani, ประเทศไทย', 17.429638492380185, 102.98963818699121),
(18, 57, 'บ้าน', 13.737122558631523, 100.52423145622015),
(19, 50, 'กรุงเทพมหานคร ประเทศไทย', 13.7563309, 100.5017651),
(20, 50, 'Don Mueang International Airport (DMK), ถนน วิภาวดีรังสิต แขวงสนามบิน เขตดอนเมือง กรุงเทพมหานคร ประเทศไทย', 13.9130397, 100.6041859),
(21, 58, 'ร้อยเอ็ด ประเทศไทย', 15.9032933, 103.7289167),
(22, 58, 'ขอนแก่น ประเทศไทย', 15.9717357, 102.6216211);

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
(1, 120, '2024-07-31 05:01:07', 0, 151),
(2, 200, '2024-07-31 05:01:13', 0, 151),
(3, 120, '2024-08-08 05:40:33', 1, 152),
(4, 500, '2024-08-06 05:40:33', 1, 152),
(6, 120, '2024-08-08 05:40:33', 1, 152),
(7, 500, '2024-08-06 05:45:33', 1, 152),
(8, 120, '2024-08-07 05:40:33', 1, 153),
(9, 120, '2024-07-08 05:40:33', 1, 153),
(10, 120, '2024-08-08 05:40:33', 1, 153),
(11, 120, '2024-08-03 05:40:33', 1, 154),
(12, 120, '2024-08-08 05:40:33', 1, 152),
(13, 500, '2024-08-06 05:45:33', 1, 152),
(14, 120, '2024-08-07 05:40:33', 1, 153),
(15, 120, '2024-07-08 05:40:33', 1, 153),
(16, 120, '2024-08-08 05:40:33', 1, 153),
(17, 120, '2024-08-03 05:40:33', 1, 155),
(18, 398, '2024-08-12 04:28:41', 0, 161),
(19, 200, '2024-08-28 15:26:40', 1, 161),
(20, 500, '2024-08-28 15:26:40', 1, 154),
(22, 240, '2024-08-30 15:28:01', 1, 154),
(26, 200, '2024-09-03 15:29:24', 1, 152),
(27, 200, '2024-09-02 15:29:24', 1, 152),
(28, 700, '2024-09-02 15:29:24', 1, 153),
(29, 500, '2024-09-04 15:29:24', 1, 153),
(30, 500, '2024-09-06 15:29:24', 1, 153),
(31, 500, '2024-09-05 15:29:24', 1, 153),
(32, 500, '2024-09-07 15:29:24', 1, 153),
(50, 8000, '2025-08-30 05:35:09', 1, 152),
(400, 8000, '2025-08-07 05:36:26', 1, 161),
(600, 4550, '2026-08-18 05:36:26', 1, 153);

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
(0, 10, '2024-08-12 10:00:00', '2024-08-12 14:00:00', '', 1),
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
(64, 3, '2024-05-29 12:00:00', '2024-05-29 13:30:00', 'ตคัดปม', 0),
(66, 10, '2024-06-02 00:00:00', '2024-06-02 01:00:00', '', 0),
(67, 10, '2024-06-02 17:00:00', '2024-06-02 23:00:00', '', 1),
(68, 10, '2024-06-06 21:40:00', '2024-06-06 22:40:00', '55', 1),
(69, 10, '2024-06-07 12:00:00', '2024-06-07 13:30:00', 'ตัดผม', 1),
(70, 10, '2024-06-07 13:40:00', '2024-06-07 15:40:00', '', 0),
(71, 10, '2024-06-06 23:00:00', '2024-06-07 00:00:00', '', 0),
(72, 10, '2024-07-14 00:00:00', '2024-07-14 23:55:00', '', 0),
(73, 10, '2024-07-15 00:00:00', '2024-07-15 23:00:00', '', 0),
(74, 10, '2024-07-16 00:00:00', '2024-07-16 23:00:00', '', 0),
(75, 10, '2024-07-17 00:00:00', '2024-07-17 23:00:00', '', 0),
(76, 10, '2024-07-18 00:00:00', '2024-07-18 23:00:00', '', 0),
(103, 10, '2024-08-13 13:00:00', '2024-08-13 14:00:00', '', 1),
(104, 10, '2024-08-14 15:00:00', '2024-08-14 16:00:00', '', 0),
(105, 10, '2024-08-12 12:00:00', '2024-08-12 13:00:00', '', 0);

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
-- Indexes for table `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`ce_id`),
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
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `barber`
--
ALTER TABLE `barber`
  MODIFY `ba_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `certificate`
--
ALTER TABLE `certificate`
  MODIFY `ce_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `hairstlye`
--
ALTER TABLE `hairstlye`
  MODIFY `hair_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `lo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `pm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=601;

--
-- AUTO_INCREMENT for table `workschedule`
--
ALTER TABLE `workschedule`
  MODIFY `ws_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

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
-- Constraints for table `hairstlye`
--
ALTER TABLE `hairstlye`
  ADD CONSTRAINT `hairstlye_ibfk_1` FOREIGN KEY (`ba_id`) REFERENCES `barber` (`ba_id`);

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
-- Constraints for table `workschedule`
--
ALTER TABLE `workschedule`
  ADD CONSTRAINT `workschedule_ibfk_1` FOREIGN KEY (`ba_id`) REFERENCES `barber` (`ba_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
