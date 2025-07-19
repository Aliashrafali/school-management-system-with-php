-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 19, 2025 at 10:19 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

DROP TABLE IF EXISTS `registration`;
CREATE TABLE IF NOT EXISTS `registration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `mobile` bigint NOT NULL,
  `altmobile` bigint NOT NULL,
  `email` varchar(100) NOT NULL,
  `bgroup` varchar(2) NOT NULL,
  `adhar` bigint NOT NULL,
  `gender` varchar(20) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `parmanent_address` longtext NOT NULL,
  `present_address` longtext NOT NULL,
  `class` varchar(20) NOT NULL,
  `section` varchar(10) NOT NULL,
  `roll` int NOT NULL,
  `registration_date` timestamp(6) NOT NULL,
  `admission_date` timestamp(6) NOT NULL,
  `registration_fee` int NOT NULL,
  `session` varchar(20) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_adhar_class` (`adhar`,`class`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `reg_no`, `name`, `fname`, `mname`, `dob`, `mobile`, `altmobile`, `email`, `bgroup`, `adhar`, `gender`, `religion`, `category`, `parmanent_address`, `present_address`, `class`, `section`, `roll`, `registration_date`, `admission_date`, `registration_fee`, `session`, `image`, `status`) VALUES
(1, 'ABC2025813739', 'asraf ali', 'shabbir ansari', 'aasma khatoon', '2010-10-10', 9135467672, 7010101010, 'mdashraf9135@gmail.com', 'a', 111111111111, 'male', 'islam', 'ews', 'Muzaffarpur', 'Muzaffarpur', '1', 'A', 15, '2025-07-02 15:15:35.000000', '2025-07-02 15:41:16.000000', 500, '2025-26', '68654d17f0292_sanjib.png', 1),
(2, 'ABC2025802715', 'neha kumari', 'dinesh paswan', 'usha bhitti', '2000-10-10', 7541022111, 9934565385, 'nk@gmail.com', 'b', 222233334444, 'female', 'hindu', 'sc', 'Muzaffarpur', 'Muzaffarpur', '2', 'B', 50, '2025-07-02 17:21:44.000000', '2025-07-02 18:23:32.000000', 400, '2025-26', '68656aa80c22b_WhatsApp Image 2025-04-26 at 20.00.19_0bafe74c.jpg', 1),
(3, 'ABC2025434513', 'pawan kumar', 'rahmat', 'raha', '2001-10-10', 8521101210, 7541022111, 'test@gmail.com', 'a', 410101010101, 'male', 'islam', 'ebc', 'Muzaffarpur', 'Muzaffarpur', '6', 'B', 45, '2025-07-02 18:10:01.000000', '2025-07-02 18:31:48.000000', 400, '2025-26', '686575f9609b2_Prof-Biswajit-Kumar-Mandal.png', 1),
(4, 'ABC2025199280', 'hello', 'hello', 'hello', '1010-10-10', 2010101010, 5040101010, 'test@gmail.com', 'a', 251010101010, 'male', 'hindu', 'ebc', 'Kolkata', 'Kolkata', '1', 'A', 15, '2025-07-03 07:00:30.000000', '2025-07-07 10:40:53.000000', 400, '2025-26', '68662a8ea380c_1_HnCyoDqxrrAqxHKFSDmKbw.png', 1),
(5, 'ABC2025920552', 'umar', 'test', 'test', '2001-10-10', 5010201010, 5040201010, 'umar@gmail.com', 'a', 231020101010, 'male', 'islam', 'obc', 'Kolkata', 'Kolkata', '1', 'A', 20, '2025-07-07 11:47:21.000000', '2025-07-11 15:24:10.000000', 500, '2025-26', '686bb3c9a479e_fast-delivery.png', 1),
(6, 'ABC2025599788', 'Pooja kumari', 'pawan kumar', 'test', '2000-10-10', 9234104510, 8510210101, 'pooja@gmail.com', 'a', 888888888888, 'female', 'hindu', 'sc', 'Kolkata', 'Kolkata', '1', 'A', 25, '2025-07-08 09:20:30.000000', '2025-07-12 04:38:15.000000', 400, '2025-26', '686ce2deac76b_Prof-Biswajit-Kumar-Mandal.png', 1),
(7, 'ABC2025994842', 'Akash Kumar', 'Test', 'test', '0000-00-00', 2025101010, 0, 'akash@gmail.com', 'b', 505050505050, 'male', 'hindu', 'bc-ii', 'Kolkata', 'Kolkata', '1', 'A', 150, '2025-07-12 06:04:11.000000', '2025-07-13 13:03:43.000000', 500, '2025-26', '6871fadb7138e_20249114.jpg', 1),
(8, 'ABC2025199669', 'Pawan Kumar', 'Tes', 'test', '2000-10-10', 9120102010, 0, 'test@gmail.com', 'a', 251411042010, 'male', 'hindu', 'ebc', 'Test', 'Test', '2', '', 0, '2025-07-18 13:11:48.000000', '0000-00-00 00:00:00.000000', 500, '2025-26', '687a4814ea26d_university image.png', 0),
(9, 'ABC2025868613', 'Harsh kumar', 'test', 'test', '2002-10-10', 9135421010, 0, 'harsh@gmail.com', 'a', 808020100111, 'male', 'hindu', 'st', 'Kolkata', 'Kolkata', '1', 'A', 12, '2025-07-18 13:53:11.000000', '2025-07-19 08:23:54.000000', 400, '2025-26', '687a51c790ff6_20249114.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_demand`
--

DROP TABLE IF EXISTS `tbl_demand`;
CREATE TABLE IF NOT EXISTS `tbl_demand` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `reg_no` varchar(20) NOT NULL,
  `tution_fee` bigint NOT NULL,
  `transport_and_other_fee` bigint NOT NULL,
  `other_fee` varchar(500) NOT NULL,
  `total` bigint NOT NULL,
  `paid` bigint NOT NULL,
  `advance_month` int NOT NULL,
  `advance_amount` bigint NOT NULL,
  `discount` bigint NOT NULL,
  `rest_dues` bigint NOT NULL,
  `month_year` varchar(30) NOT NULL,
  `date_and_time` timestamp(6) NOT NULL,
  `status` int NOT NULL,
  `print_status` enum('Not Printed','Printed','Reprinted') DEFAULT 'Not Printed',
  `print_count` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_demand`
--

INSERT INTO `tbl_demand` (`id`, `student_id`, `reg_no`, `tution_fee`, `transport_and_other_fee`, `other_fee`, `total`, `paid`, `advance_month`, `advance_amount`, `discount`, `rest_dues`, `month_year`, `date_and_time`, `status`, `print_status`, `print_count`) VALUES
(1, 1, 'ABC2025813739', 40, 40, 'Exam Fee 500', 580, 0, 0, 0, 0, 0, 'July 2025', '2025-07-13 14:47:30.000000', 0, 'Reprinted', 2),
(2, 4, 'ABC2025199280', 1200, 1500, 'Exam Fee 500', 3200, 0, 0, 0, 0, 0, 'July 2025', '2025-07-13 14:47:30.000000', 0, 'Reprinted', 2),
(3, 5, 'ABC2025920552', 500, 600, 'Exam Fee 500', 1600, 0, 0, 0, 0, 0, 'July 2025', '2025-07-13 14:47:30.000000', 0, 'Reprinted', 2),
(4, 6, 'ABC2025599788', 150, 200, 'Exam Fee 500', 850, 0, 0, 0, 0, 0, 'July 2025', '2025-07-13 14:47:30.000000', 0, 'Reprinted', 2),
(5, 7, 'ABC2025994842', 500, 450, 'Exam Fee 500', 1450, 0, 0, 0, 0, 0, 'July 2025', '2025-07-13 14:47:30.000000', 0, 'Reprinted', 2),
(6, 2, 'ABC2025802715', 450, 450, 'Exam Fees 500, Library Fee 250, Lab Fee 50', 1700, 0, 0, 0, 0, 0, 'July 2025', '2025-07-13 15:14:09.000000', 0, 'Not Printed', 0),
(7, 9, 'ABC2025868613', 450, 500, 'Exam Fee 450, Library Fee 450', 1850, 0, 0, 0, 0, 0, 'July 2025', '2025-07-19 08:24:19.000000', 0, 'Not Printed', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fees`
--

DROP TABLE IF EXISTS `tbl_fees`;
CREATE TABLE IF NOT EXISTS `tbl_fees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `reg_no` varchar(20) NOT NULL,
  `session` varchar(20) NOT NULL,
  `tution_fee` bigint NOT NULL,
  `transport_and_other_fee` bigint NOT NULL,
  `total` bigint NOT NULL,
  `month_year` varchar(20) NOT NULL,
  `date_time` timestamp(6) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_fee_entry` (`reg_no`,`session`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_fees`
--

INSERT INTO `tbl_fees` (`id`, `student_id`, `reg_no`, `session`, `tution_fee`, `transport_and_other_fee`, `total`, `month_year`, `date_time`, `status`) VALUES
(1, 1, 'ABC2025813739', '2025-26', 40, 40, 80, 'July 2025', '2025-07-02 15:37:22.000000', 1),
(2, 2, 'ABC2025802715', '2025-26', 450, 450, 900, 'July 2025', '2025-07-02 18:23:32.000000', 1),
(3, 3, 'ABC2025434513', '2025-26', 250, 350, 600, 'July 2025', '2025-07-02 18:31:48.000000', 1),
(4, 4, 'ABC2025199280', '2025-26', 1200, 1500, 2700, 'July 2025', '2025-07-07 10:40:53.000000', 1),
(5, 5, 'ABC2025920552', '2025-26', 500, 600, 1100, 'July 2025', '2025-07-11 15:24:10.000000', 1),
(6, 6, 'ABC2025599788', '2025-26', 150, 200, 350, 'July 2025', '2025-07-12 04:38:15.000000', 1),
(7, 7, 'ABC2025994842', '2025-26', 500, 450, 950, 'July 2025', '2025-07-13 13:03:43.000000', 1),
(8, 9, 'ABC2025868613', '2025-26', 450, 500, 950, 'July 2025', '2025-07-19 08:23:54.000000', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
