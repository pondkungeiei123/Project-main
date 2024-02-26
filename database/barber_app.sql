-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2024 at 06:55 AM
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
-- Database: `barber_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `ad_id` int(11) NOT NULL,
  `ad_name` varchar(50) DEFAULT NULL,
  `ad_lastname` varchar(50) DEFAULT NULL,
  `ad_email` varchar(100) DEFAULT NULL,
  `ad_password` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`ad_id`, `ad_name`, `ad_lastname`, `ad_email`, `ad_password`) VALUES
(1, 'admin', 'admin', 'admin1234', '$2y$10$yeMyVmq/WLAWx'),
(2, 'สมชาย', 'สองใจ', 'kanatakung123@gmail.com', '$2y$10$A3h1uPgCy9XSP');

-- --------------------------------------------------------

--
-- Table structure for table `customer_location`
--

CREATE TABLE `customer_location` (
  `cus_locationid` int(11) NOT NULL,
  `cus_id` int(11) NOT NULL,
  `cus_namelocation` varchar(255) NOT NULL,
  `cus_latitude` varchar(255) NOT NULL,
  `cus_longtitude` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_location`
--

INSERT INTO `customer_location` (`cus_locationid`, `cus_id`, `cus_namelocation`, `cus_latitude`, `cus_longtitude`) VALUES
(1, 25, 'หอพักส.สงมา', '16.4247059', '102.8564783');

-- --------------------------------------------------------

--
-- Table structure for table `customer_table`
--

CREATE TABLE `customer_table` (
  `cus_id` int(11) NOT NULL,
  `cus_name` varchar(50) NOT NULL,
  `cus_lastname` varchar(50) NOT NULL,
  `cus_phone` varchar(12) NOT NULL,
  `cus_email` varchar(50) NOT NULL,
  `cus_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_table`
--

INSERT INTO `customer_table` (`cus_id`, `cus_name`, `cus_lastname`, `cus_phone`, `cus_email`, `cus_password`) VALUES
(25, 'kaittiyos', 'kaittiyos', '0958027929', 'pao@gmail.com', '202cb962ac59075b964b07152d234b70'),
(29, 'kaittiyos', 'kriangkraiwan', '042241514', 'paokkw@gmail.com', '202cb962ac59075b964b07152d234b70'),
(30, 'สมจิต', 'นาสิง', '0659977988', 'pond@gmail.com', '$2y$10$2UJLQTmSk7p/OdMZjrXVCO8p2cnTwPuFEg1hjZRz2xUMfs3BIweGK'),
(31, 'สมจิต111111', 'นาสิง', '0659977988', 'kanatakung123@gmail.com', '$2y$10$5G4lbcfU6amJEGd7uJ.o9.KgU8vC3OVrslhwXElNtcM.pEg66TDva');

-- --------------------------------------------------------

--
-- Table structure for table `grouppicture`
--

CREATE TABLE `grouppicture` (
  `gro_id` int(11) NOT NULL,
  `up_picture` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grouppicture`
--

INSERT INTO `grouppicture` (`gro_id`, `up_picture`, `user_id`) VALUES
(1, 'test', 1),
(2, 'uploaded_image.jpg', 1),
(5, '6579f6777eb88_workings.jpg', 1),
(6, '657a053155304_workings.jpg', 1),
(7, '657aa69da990c_workings.jpg', 1),
(8, '657aa7eab6ceb_workings.jpg', 1),
(9, '657aa89b63fec_workings.jpg', 1),
(10, '657af0566a020_workings.jpg', 1),
(11, '657b25d782e8b_workings.jpg', 1),
(12, '657b379bac611_workings.jpg', 1),
(13, '657c00b7c0aac_workings.jpg', 1),
(14, '657c087312a1d_workings.jpg', 1),
(15, '657c09167519f_workings.jpg', 1),
(16, '657c095f327d9_workings.jpg', 1),
(17, '657c0a2aea07e_workings.jpg', 1),
(18, '657c0ab30fb4a_workings.jpg', 1),
(19, '657c0ca802a89_workings.jpg', 1),
(20, '657c33d0944a7_workings.jpg', 1),
(21, '657c33d143e50_workings.jpg', 1),
(22, '657c3868822ac_workings.jpg', 1),
(23, '657c386b8484e_workings.jpg', 1),
(24, '657c386e32246_workings.jpg', 1),
(25, '657c3877dd313_workings.jpg', 1),
(26, '657c3bbfc75ab_workings.jpg', 1),
(27, '6582913623ebb_workings.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hairstlye`
--

CREATE TABLE `hairstlye` (
  `hair_id` int(11) NOT NULL,
  `hair_name` varchar(50) NOT NULL,
  `hair_price` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hairstlye`
--

INSERT INTO `hairstlye` (`hair_id`, `hair_name`, `hair_price`) VALUES
(1, 'ทรงนักเรียน', '100'),
(2, 'ทรงรองทรง', '120'),
(3, 'ทรงทูบล็อค', '150'),
(4, 'ทรงอันเดอร์คัต', '150'),
(5, 'ทรงสกินเฮด', '150'),
(6, 'ทรงวินเทจ', '150'),
(7, 'ทรงอื่นๆ', '150');

-- --------------------------------------------------------

--
-- Table structure for table `jobqueue`
--

CREATE TABLE `jobqueue` (
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_startdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `job_enddate` timestamp NOT NULL DEFAULT current_timestamp(),
  `job_note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobqueue`
--

INSERT INTO `jobqueue` (`job_id`, `user_id`, `job_startdate`, `job_enddate`, `job_note`) VALUES
(10, 1, '2023-12-14 00:00:00', '2023-12-14 01:00:00', '123'),
(11, 1, '2023-12-20 00:00:00', '2023-12-20 01:00:00', 'a'),
(12, 1, '2023-12-21 03:30:00', '2023-12-21 05:00:00', 'ตัดผม'),
(13, 1, '2023-12-15 05:30:00', '2023-12-15 07:00:00', 'ตัดผมจ๊วดๆ'),
(14, 1, '2023-12-15 00:00:00', '2023-12-15 01:00:00', ''),
(15, 1, '2023-12-22 00:00:00', '2023-12-22 01:00:00', ''),
(16, 1, '2023-12-22 00:00:00', '2023-12-22 01:00:00', 'sadf'),
(17, 1, '2023-12-15 01:00:00', '2023-12-15 03:00:00', 'work'),
(18, 1, '2023-12-21 04:00:00', '2023-12-21 05:30:00', 'sadfsadf'),
(19, 1, '2023-12-21 04:00:00', '2023-12-21 05:30:00', 'sadfsadf'),
(20, 1, '2023-12-21 03:00:00', '2023-12-21 05:30:00', 'ว่าง');

-- --------------------------------------------------------

--
-- Table structure for table `jobschedule`
--

CREATE TABLE `jobschedule` (
  `jobsc_id` int(11) NOT NULL,
  `jobsc_startdate` datetime NOT NULL,
  `jobsc_enddate` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `cus_id` int(11) NOT NULL,
  `hair_id` int(11) NOT NULL,
  `cus_locationid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobschedule`
--

INSERT INTO `jobschedule` (`jobsc_id`, `jobsc_startdate`, `jobsc_enddate`, `user_id`, `job_id`, `cus_id`, `hair_id`, `cus_locationid`) VALUES
(4, '2023-12-31 12:00:00', '2023-12-31 14:00:00', 3, 25, 25, 3, 1),
(5, '2023-12-24 16:26:01', '2023-12-24 23:26:01', 3, 25, 29, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_phone` varchar(12) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` text NOT NULL,
  `user_idcard` varchar(13) NOT NULL,
  `user_birthdate` date NOT NULL,
  `user_age` int(11) DEFAULT NULL,
  `user_gender` varchar(10) DEFAULT NULL,
  `user_Certificate` varchar(255) DEFAULT NULL,
  `user_nationality` varchar(100) DEFAULT NULL,
  `user_religion` varchar(100) DEFAULT NULL,
  `user_address` text NOT NULL,
  `namelocation` varchar(255) NOT NULL,
  `user_latitude` varchar(255) NOT NULL,
  `user_longtitude` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `user_name`, `user_lastname`, `user_phone`, `user_email`, `user_password`, `user_idcard`, `user_birthdate`, `user_age`, `user_gender`, `user_Certificate`, `user_nationality`, `user_religion`, `user_address`, `namelocation`, `user_latitude`, `user_longtitude`) VALUES
(1, 'pond', 'sadfsdf', '0958027929', 'pond@gmail.com', '202cb962ac59075b964b07152d234b70', '1231231231231', '0000-00-00', 21, NULL, NULL, NULL, NULL, '', '', '', ''),
(3, 'พิชิตชัย', 'ธรรมชัย', '0650949790', 'tiw@gmail.com', 'tiw@gmail.com', '1459900924562', '2013-12-12', 22, 'ชาย', NULL, 'ไทย', 'พุทธ', '231/2', '', '', ''),
(10, 'นายศุภรักษ์', 'สะเดา', '0659977988', 'kanatakungtot@gmail.com', 'kanatakungtot@gmail.com', '1459900000000', '0000-00-00', 22, 'male', '2023-12-21/65840029186fb_IMG2023112.jpg', 'ไทย', 'พุทธ', 'kanatakungtot@gmail.com', '', '', ''),
(12, 'มาลี', 'ขอน', '0659094979', 'lonkungtot@gmail.com', 'lonkungtot@gmail.com', '1459900924562', '2545-02-02', 22, 'male', '2024-02-13/65cb38b55ccfe_Data Flow .jpg', 'ไทย', 'พุทธ', 'lonkungtot@gmail.com', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`ad_id`),
  ADD UNIQUE KEY `ad_email` (`ad_email`);

--
-- Indexes for table `customer_location`
--
ALTER TABLE `customer_location`
  ADD PRIMARY KEY (`cus_locationid`),
  ADD KEY `cus_id` (`cus_id`);

--
-- Indexes for table `customer_table`
--
ALTER TABLE `customer_table`
  ADD PRIMARY KEY (`cus_id`);

--
-- Indexes for table `grouppicture`
--
ALTER TABLE `grouppicture`
  ADD PRIMARY KEY (`gro_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hairstlye`
--
ALTER TABLE `hairstlye`
  ADD PRIMARY KEY (`hair_id`);

--
-- Indexes for table `jobqueue`
--
ALTER TABLE `jobqueue`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jobschedule`
--
ALTER TABLE `jobschedule`
  ADD PRIMARY KEY (`jobsc_id`),
  ADD KEY `cus_id` (`cus_id`),
  ADD KEY `jobschedule_ibfk_1` (`job_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hair_id` (`hair_id`),
  ADD KEY `cus_locationid` (`cus_locationid`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_location`
--
ALTER TABLE `customer_location`
  MODIFY `cus_locationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_table`
--
ALTER TABLE `customer_table`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `grouppicture`
--
ALTER TABLE `grouppicture`
  MODIFY `gro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `jobqueue`
--
ALTER TABLE `jobqueue`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `jobschedule`
--
ALTER TABLE `jobschedule`
  MODIFY `jobsc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_location`
--
ALTER TABLE `customer_location`
  ADD CONSTRAINT `customer_location_ibfk_1` FOREIGN KEY (`cus_id`) REFERENCES `customer_table` (`cus_id`);

--
-- Constraints for table `grouppicture`
--
ALTER TABLE `grouppicture`
  ADD CONSTRAINT `grouppicture_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`user_id`);

--
-- Constraints for table `jobqueue`
--
ALTER TABLE `jobqueue`
  ADD CONSTRAINT `jobqueue_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`user_id`);

--
-- Constraints for table `jobschedule`
--
ALTER TABLE `jobschedule`
  ADD CONSTRAINT `jobschedule_ibfk_1` FOREIGN KEY (`cus_locationid`) REFERENCES `customer_location` (`cus_locationid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
