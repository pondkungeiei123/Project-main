

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

e structure for table `admin`
--

CREATE TABLE `admin` (
  `ad_id` int(11) NOT NULL,
  `ad_name` varchar(50) NOT NULL,
  `ad_lastname` varchar(50) NOT NULL,
  `ad_email` varchar(60) NOT NULL,
  `ad_password` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `admin` (`ad_id`, `ad_name`, `ad_lastname`, `ad_email`, `ad_password`) VALUES
(1, 'sukanya', 'chinkhum', 'admin@gmail.com', '$2y$10$t0nyZYmlpWc5tdtjRs2N5eM7.30slJtXPQHOYg0/xS2gNHJGdCSFm'),
(3, 'wer', 'wer', 'pond@gmail.com', '123456'),
(7, 'sukanya', 'chinkhum', 'sakanya@gmail.com', '$2y$10$wp.f34yo8vZdslTqSSW.S.vLNKEEI6yuIwat7Zx7lPQYx9h14qnE.'),
(11, 'สมสมสม', 'นา', 'ponnd@gmail.com', '$2y$10$Ah.QZhQVlozGPLCGdH3p8u3LUUhOWVZ/AUHrpLCwoU.J.eofUXAKm');

-- --------------------------------------------------------


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


INSERT INTO `barber` (`ba_id`, `ba_name`, `ba_lastname`, `ba_phone`, `ba_email`, `ba_password`, `ba_idcard`, `ba_namelocation`, `ba_latitude`, `ba_longitude`) VALUES
(3, 'เกียรติยศ', 'เกรียงไกรวรรณ', '0878027981', 'kaittiyos@gmail.com', '$2y$10$tsvphOSbKY9FWEdKU5CO1uPX9cfe.6HYIU1CD7OE7Ky4FFnGDedJq', '14199019461', 'เดอะ เบส ไฮท์ มิตรภาพ - ขอนแก่น', 0, 102.82650925219),
(10, 'สุสัญญา', 'ชินคำ', '0639781398', 'barber@gmail.com', '$2y$10$4ybDmCm7RVp3gAY/lLVv0uo3W8ZLF5NrLncuRUzGvLjZPJHYzkJ2a', '15451', 'มหาวิทยาลัยราชมงคลอีสาน วิทยาเขตขอนแก่น', 16.4282615, 102.8635969),
(12, 'ศุภรักษ์ ', 'นอนน้อย', '06594979590', 'pondkungtot@gmail.com', '123', '1459900925462', 'Rajamangala University of Technology Isan Khon Kaen Campus', 16.4282615, 102.8635969);

-- --------------------------------------------------------


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



INSERT INTO `booking` (`bk_id`, `bk_startdate`, `bk_enddate`, `bk_price`, `ws_id`, `cus_id`, `hair_id`, `lo_id`, `ba_id`, `bk_status`) VALUES
(151, '2024-06-07 12:00:00', '2024-06-07 12:00:00', 4079, 69, 25, 20, 18, 10, 0);

-- --------------------------------------------------------


CREATE TABLE `certificate` (
  `ce_id` int(11) NOT NULL,
  `ce_photo` varchar(200) NOT NULL,
  `ba_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `certificate` (`ce_id`, `ce_photo`, `ba_id`) VALUES
(8, '6693d978ecf9e_IMG_7227.jpg', 10),
(9, '6693d978ef35c_IMG_7228.jpg', 10),
(10, '6693d978f22d2_IMG_7229.jpg', 10);

-- --------------------------------------------------------



CREATE TABLE `customer` (
  `cus_id` int(11) NOT NULL,
  `cus_name` varchar(50) NOT NULL,
  `cus_lastname` varchar(50) NOT NULL,
  `cus_phone` varchar(12) NOT NULL,
  `cus_email` varchar(50) NOT NULL,
  `cus_password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `customer` (`cus_id`, `cus_name`, `cus_lastname`, `cus_phone`, `cus_email`, `cus_password`) VALUES
(25, 'kaittiyos', 'kaittiyos', '0958027929', 'pao@gmail.com', '$2y$10$4ybDmCm7RVp3gAY/lLVv0uo3W8ZLF5NrLncuRUzGvLjZPJHYzkJ2a'),
(50, 'sukanya', 'ชินคำ', '06989888', 'cus@gmail.com', '$2y$10$4ybDmCm7RVp3gAY/lLVv0uo3W8ZLF5NrLncuRUzGvLjZPJHYzkJ2a'),
(51, 'pond', 'kung', '06094949472', 'pond@gmail.com', '123'),
(52, 'asdfasdf', 'กรุงเทพฟห', '0698988', 'cus1@gmail.com', '$2y$10$2VwKkXT9kf1uSDfZxEBFMOAHV.Q.dXXRsDRQH1EJGsOf9BL4Y0StK'),
(53, 'wryuu', 'etyy', '063333', 'ssdd@gggg.com', '$2y$10$yLaOonI8Q987otvI9yQe8u2UjrWyO18gzNOvwvajSDgRZoZNNXmt.'),
(54, 'test', 'test', '0633333333', 'test@gmail.com', '$2y$10$2W36Sub355WYXP1/YU/7UuGbR1o4hDWeQizADe6RUtnoaEYKJn5u.'),
(55, 'test', 'test', '0888888888', 'tes1@gmail.com', '$2y$10$e/SEDpJ6TaMh/dVUbkc8YuzIMPn2nneVQ/Dvg59BeEw.xqHPo4HsO'),
(56, 'สม', 'สม', '0658949790', 'som123@gmail.com', '$2y$10$rZj6K1nj16iCN28ezVTt.OtLKGgab/Lt7Y0ueI9A.y3ccjk.abM8y'),
(57, 'สมสน', 'เกรียง', '0858130881', 'somson@gmail.com', '$2y$10$iR258aGwyntr5utYhb2XxewJei96wEMN/0g39izMWAAh/7xSbCnBy');

-- --------------------------------------------------------


CREATE TABLE `hairstlye` (
  `hair_id` int(11) NOT NULL,
  `hair_name` varchar(50) NOT NULL,
  `hair_price` int(11) NOT NULL,
  `hair_photo` varchar(50) NOT NULL,
  `ba_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `hairstlye` (`hair_id`, `hair_name`, `hair_price`, `hair_photo`, `ba_id`) VALUES
(15, 'วินเทจ', 200, '665c30498c777_hair.jpg', 10),
(16, 'รองทรงสูง', 80, '665c3199e90c4_hair.jpg', 10),
(18, 'นักเรียน2', 100, '6661c90df38b3_hair.jpg', 10),
(19, 'ทรงสกรีนเฮด', 150, '666281646fef8_hair.jpg', 10),
(20, 'ทรงรองทรงตัำ', 100, '666281ac23e1a_hair.jpg', 10);

-- --------------------------------------------------------



CREATE TABLE `location` (
  `lo_id` int(11) NOT NULL,
  `cus_id` int(11) NOT NULL,
  `lo_name` varchar(200) NOT NULL,
  `lo_latitude` double NOT NULL,
  `lo_longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `location` (`lo_id`, `cus_id`, `lo_name`, `lo_latitude`, `lo_longitude`) VALUES
(11, 50, 'Bangkok, ประเทศไทย', 13.7563309, 100.5017651),
(16, 50, 'ขอนแก่น ประเทศไทย', 15.9717357, 102.6216211),
(17, 50, 'Udon Thani, ประเทศไทย', 17.429638492380185, 102.98963818699121),
(18, 57, 'บ้าน', 13.737122558631523, 100.52423145622015),
(19, 50, 'กรุงเทพมหานคร ประเทศไทย', 13.7563309, 100.5017651),
(20, 50, 'Don Mueang International Airport (DMK), ถนน วิภาวดีรังสิต แขวงสนามบิน เขตดอนเมือง กรุงเทพมหานคร ประเทศไทย', 13.9130397, 100.6041859);

-- --------------------------------------------------------



CREATE TABLE `payment` (
  `pm_id` int(11) NOT NULL,
  `pm_amount` int(11) NOT NULL,
  `pm_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pm_status` int(11) NOT NULL,
  `bk_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------



CREATE TABLE `workschedule` (
  `ws_id` int(11) NOT NULL,
  `ba_id` int(11) NOT NULL,
  `ws_startdate` datetime NOT NULL,
  `ws_enddate` datetime NOT NULL,
  `ws_note` varchar(255) NOT NULL,
  `ws_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
(76, 10, '2024-07-18 00:00:00', '2024-07-18 23:00:00', '', 0);


ALTER TABLE `admin`
  ADD PRIMARY KEY (`ad_id`);

ALTER TABLE `barber`
  ADD PRIMARY KEY (`ba_id`);

ALTER TABLE `booking`
  ADD PRIMARY KEY (`bk_id`),
  ADD KEY `booking_ibfk_1` (`lo_id`),
  ADD KEY `cus_id` (`cus_id`),
  ADD KEY `hair_id` (`hair_id`),
  ADD KEY `ws_id` (`ws_id`),
  ADD KEY `ba_id` (`ba_id`);


ALTER TABLE `certificate`
  ADD PRIMARY KEY (`ce_id`),
  ADD KEY `ba_id` (`ba_id`);


ALTER TABLE `customer`
  ADD PRIMARY KEY (`cus_id`);


ALTER TABLE `hairstlye`
  ADD PRIMARY KEY (`hair_id`),
  ADD KEY `ba_id` (`ba_id`);


ALTER TABLE `location`
  ADD PRIMARY KEY (`lo_id`),
  ADD KEY `cus_id` (`cus_id`);

ALTER TABLE `payment`
  ADD PRIMARY KEY (`pm_id`),
  ADD KEY `bk_id` (`bk_id`);


ALTER TABLE `workschedule`
  ADD PRIMARY KEY (`ws_id`),
  ADD KEY `ba_id` (`ba_id`);




ALTER TABLE `admin`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;


ALTER TABLE `barber`
  MODIFY `ba_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;


ALTER TABLE `booking`
  MODIFY `bk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;


ALTER TABLE `certificate`
  MODIFY `ce_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `hairstlye`
--
ALTER TABLE `hairstlye`
  MODIFY `hair_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `lo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `pm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `workschedule`
--
ALTER TABLE `workschedule`
  MODIFY `ws_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

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
-- Constraints for table `certificate`
--
ALTER TABLE `certificate`
  ADD CONSTRAINT `certificate_ibfk_1` FOREIGN KEY (`ba_id`) REFERENCES `barber` (`ba_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

