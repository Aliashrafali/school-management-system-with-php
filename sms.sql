-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 15, 2025 at 05:30 AM
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
  `parents_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_adhar_class` (`adhar`,`class`)
) ENGINE=MyISAM;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `reg_no`, `name`, `fname`, `mname`, `dob`, `mobile`, `altmobile`, `email`, `bgroup`, `adhar`, `gender`, `religion`, `category`, `parmanent_address`, `present_address`, `class`, `section`, `roll`, `registration_date`, `admission_date`, `registration_fee`, `session`, `image`, `status`, `parents_id`) VALUES
(1, 'ABC2025813739', 'asraf ali', 'shabbir ansari', 'aasma khatoon', '2010-10-10', 9135467672, 7010101010, 'mdashraf9135@gmail.com', 'a', 111111111111, 'male', 'islam', 'ews', 'Muzaffarpur', 'Muzaffarpur', '1', 'A', 15, '2025-07-02 15:15:35.000000', '2025-07-02 15:41:16.000000', 500, '2025-26', '68654d17f0292_sanjib.png', 1, 0),
(2, 'ABC2025802715', 'neha kumari', 'dinesh paswan', 'usha bhitti', '2000-10-10', 7541022111, 9934565385, 'nk@gmail.com', 'b', 222233334444, 'female', 'hindu', 'sc', 'Muzaffarpur', 'Muzaffarpur', '2', 'B', 50, '2025-07-02 17:21:44.000000', '2025-07-02 18:23:32.000000', 400, '2025-26', '68656aa80c22b_WhatsApp Image 2025-04-26 at 20.00.19_0bafe74c.jpg', 1, 0),
(3, 'ABC2025434513', 'pawan kumar', 'rahmat', 'raha', '2001-10-10', 8521101210, 7541022111, 'test@gmail.com', 'a', 410101010101, 'male', 'islam', 'ebc', 'Muzaffarpur', 'Muzaffarpur', '6', 'B', 45, '2025-07-02 18:10:01.000000', '2025-07-02 18:31:48.000000', 400, '2025-26', '686575f9609b2_Prof-Biswajit-Kumar-Mandal.png', 1, 0),
(4, 'ABC2025199280', 'hello', 'hello', 'hello', '1010-10-10', 2010101010, 5040101010, 'test@gmail.com', 'a', 251010101010, 'male', 'hindu', 'ebc', 'Kolkata', 'Kolkata', '1', 'A', 15, '2025-07-03 07:00:30.000000', '2025-07-07 10:40:53.000000', 400, '2025-26', '68662a8ea380c_1_HnCyoDqxrrAqxHKFSDmKbw.png', 1, 0),
(5, 'ABC2025920552', 'umar', 'test', 'test', '2001-10-10', 5010201010, 5040201010, 'umar@gmail.com', 'a', 231020101010, 'male', 'islam', 'obc', 'Kolkata', 'Kolkata', '1', 'A', 20, '2025-07-07 11:47:21.000000', '2025-07-11 15:24:10.000000', 500, '2025-26', '686bb3c9a479e_fast-delivery.png', 1, 0),
(6, 'ABC2025599788', 'Pooja kumari', 'pawan kumar', 'test', '2000-10-10', 9234104510, 8510210101, 'pooja@gmail.com', 'a', 888888888888, 'female', 'hindu', 'sc', 'Kolkata', 'Kolkata', '1', 'A', 25, '2025-07-08 09:20:30.000000', '2025-07-12 04:38:15.000000', 400, '2025-26', '686ce2deac76b_Prof-Biswajit-Kumar-Mandal.png', 1, 0),
(7, 'ABC2025994842', 'Akash Kumar', 'Test', 'test', '0000-00-00', 2025101010, 0, 'akash@gmail.com', 'b', 505050505050, 'male', 'hindu', 'bc-ii', 'Kolkata', 'Kolkata', '1', 'A', 150, '2025-07-12 06:04:11.000000', '2025-07-13 13:03:43.000000', 500, '2025-26', '6871fadb7138e_20249114.jpg', 1, 0),
(8, 'ABC2025199669', 'Pawan Kumar', 'Tes', 'test', '2000-10-10', 9120102010, 0, 'test@gmail.com', 'a', 251411042010, 'male', 'hindu', 'ebc', 'Test', 'Test', '2', 'A', 12, '2025-07-18 13:11:48.000000', '2025-08-01 08:13:21.000000', 500, '2025-26', '687a4814ea26d_university image.png', 1, 0),
(9, 'ABC2025868613', 'Harsh kumar', 'test', 'test', '2002-10-10', 9135421010, 0, 'harsh@gmail.com', 'a', 808020100111, 'male', 'hindu', 'st', 'Kolkata', 'Kolkata', '1', 'A', 12, '2025-07-18 13:53:11.000000', '2025-07-19 08:23:54.000000', 400, '2025-26', '687a51c790ff6_20249114.jpg', 1, 0),
(10, 'ABC2025340557', 'ankit nijli', 'subhendu bijli', 'abcd', '2000-10-10', 5020101010, 0, 'bijli@gmail.com', 'b+', 656565656565, 'male', 'hindu', 'obc', 'Kolkata', 'Kolkata', '2', 'A', 125, '2025-07-20 06:37:39.000000', '2025-08-04 08:15:03.000000', 500, '2025-26', '687c8eb3034ea_ashraf.png', 1, 0),
(11, 'ABC2025801414', 'abcd', 'abcd', 'abcd', '2000-10-10', 8520101010, 0, 'abcd@gmail.com', 'a', 800000000000, 'male', 'hindu', 'st', 'Kolkata', 'Kolkata', '2', 'A', 120, '2025-07-21 05:08:39.000000', '2025-08-04 08:16:10.000000', 400, '2025-26', '687dcb57b77cd_images.jpeg', 1, 0),
(12, 'ABC2025855458', 'chandan kumar', 'chanchal', 'test', '2020-10-10', 3020101010, 0, 'chandan@gmail.com', 'a', 802010101020, 'male', 'hindu', 'ews', 'Kolkata', 'Kolkata', '1', 'A', 255, '2025-07-23 13:40:32.000000', '2025-08-04 08:18:27.000000', 400, '2025-26', '6880e65062c3d_download.jpg', 1, 0),
(13, 'ABC2025332824', 'Kisahn Yadav', 'test', 'test', '2020-10-10', 5050201010, 8510201010, 'kishan123@gmail.com', 'a', 152010120101, 'male', 'hindu', 'sc', 'Bihar', 'Bihar', '1', 'A', 100, '2025-07-30 10:16:21.000000', '2025-07-30 10:17:13.000000', 400, '2025-26', '6889f0f5b8749_download (1).jpg', 1, 0),
(14, 'ABC2025261039', 'Prof V Venkata Basava Rao', 'Asraf ', 'Test', '2025-07-31', 7510201015, 0, 'rajmohan@ardentcollaborations.com', 'b', 111111111115, 'male', 'hindu', 'ebc', 'Kolkata', 'Kolkata', '2', 'A', 152, '2025-07-31 06:22:51.000000', '2025-08-04 08:19:05.000000', 400, '2025-26', '688b0bbb4a810_download.jpg', 1, 0),
(15, 'ABC2025576003', 'ratan', 'ratan', 'test', '2000-10-10', 8510201010, 0, 'ratan@gmail.com', 'a', 502010101020, 'male', 'shinto', 'st', 'Test', 'Test', '1', 'A', 1250, '2025-08-04 08:22:01.000000', '2025-08-04 08:23:13.000000', 50, '2025-26', '68906da960b53_download.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_demand`
--

DROP TABLE IF EXISTS `tbl_demand`;
CREATE TABLE IF NOT EXISTS `tbl_demand` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `reg_no` varchar(20) NOT NULL,
  `session` varchar(20) NOT NULL,
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
) ENGINE=MyISAM;

--
-- Dumping data for table `tbl_demand`
--

INSERT INTO `tbl_demand` (`id`, `student_id`, `reg_no`, `session`, `tution_fee`, `transport_and_other_fee`, `other_fee`, `total`, `paid`, `advance_month`, `advance_amount`, `discount`, `rest_dues`, `month_year`, `date_and_time`, `status`, `print_status`, `print_count`) VALUES
(1, 1, 'ABC2025813739', '2025-26', 40, 40, 'Exam Fee 250', 330, 350, 1, 80, 60, -80, 'July 2025', '2025-08-04 15:33:48.000000', 0, 'Not Printed', 0),
(2, 4, 'ABC2025199280', '2025-26', 1200, 1500, 'Exam Fee 250', 2950, 2900, 0, 0, 50, 0, 'July 2025', '2025-08-04 15:33:48.000000', 0, 'Not Printed', 0),
(3, 5, 'ABC2025920552', '2025-26', 500, 600, 'Exam Fee 250', 1350, 1300, 0, 0, 50, 0, 'July 2025', '2025-08-04 15:33:48.000000', 0, 'Not Printed', 0),
(4, 6, 'ABC2025599788', '2025-26', 150, 200, 'Exam Fee 250', 600, 1200, 2, 700, 150, -750, 'July 2025', '2025-08-04 15:33:48.000000', 0, 'Not Printed', 0),
(5, 7, 'ABC2025994842', '2025-26', 500, 450, 'Exam Fee 250', 1200, 1200, 0, 0, 0, 0, 'July 2025', '2025-08-04 15:33:48.000000', 0, 'Not Printed', 0),
(6, 9, 'ABC2025868613', '2025-26', 450, 500, 'Exam Fee 250', 1200, 0, 0, 0, 0, 0, 'July 2025', '2025-08-04 15:33:48.000000', 0, 'Not Printed', 0),
(7, 12, 'ABC2025855458', '2025-26', 500, 400, 'Exam Fee 250', 1150, 1150, 0, 0, 0, 0, 'July 2025', '2025-08-04 15:33:48.000000', 0, 'Not Printed', 0),
(8, 13, 'ABC2025332824', '2025-26', 450, 500, 'Exam Fee 250', 1200, 1100, 0, 0, 0, 100, 'July 2025', '2025-08-04 15:33:48.000000', 0, 'Not Printed', 0),
(9, 15, 'ABC2025576003', '2025-26', 450, 200, 'Exam Fee 250', 900, 0, 0, 0, 0, 0, 'July 2025', '2025-08-04 15:33:48.000000', 0, 'Not Printed', 0),
(10, 10, 'ABC2025340557', '2025-26', 400, 500, '', 900, 0, 0, 0, 0, 0, 'July 2025', '2025-08-04 15:34:00.000000', 0, 'Not Printed', 0),
(11, 11, 'ABC2025801414', '2025-26', 500, 300, '', 800, 0, 0, 0, 0, 0, 'July 2025', '2025-08-04 15:34:00.000000', 0, 'Not Printed', 0),
(12, 14, 'ABC2025261039', '2025-26', 400, 350, '', 750, 0, 0, 0, 0, 0, 'July 2025', '2025-08-04 15:34:00.000000', 0, 'Not Printed', 0),
(13, 2, 'ABC2025802715', '2025-26', 450, 450, 'Library Fee 500, Exam Fee 200', 1600, 0, 0, 0, 0, 0, 'July 2025', '2025-08-04 15:36:38.000000', 0, 'Not Printed', 0),
(14, 3, 'ABC2025434513', '2025-26', 250, 350, '', 600, 0, 0, 0, 0, 0, 'July 2025', '2025-08-04 15:37:03.000000', 0, 'Not Printed', 0);

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
) ENGINE=MyISAM;

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
(8, 9, 'ABC2025868613', '2025-26', 450, 500, 950, 'July 2025', '2025-07-19 08:23:54.000000', 1),
(9, 13, 'ABC2025332824', '2025-26', 450, 500, 950, 'July 2025', '2025-07-30 10:17:13.000000', 1),
(10, 8, 'ABC2025199669', '2025-26', 450, 200, 650, 'August 2025', '2025-08-01 08:13:21.000000', 1),
(11, 10, 'ABC2025340557', '2025-26', 400, 500, 900, 'July 2025', '2025-08-04 08:15:03.000000', 1),
(12, 11, 'ABC2025801414', '2025-26', 500, 300, 800, 'July 2025', '2025-08-04 08:16:10.000000', 1),
(13, 12, 'ABC2025855458', '2025-26', 500, 400, 900, 'July 2025', '2025-08-04 08:18:27.000000', 1),
(14, 14, 'ABC2025261039', '2025-26', 400, 350, 750, 'July 2025', '2025-08-04 08:19:05.000000', 1),
(15, 15, 'ABC2025576003', '2025-26', 450, 200, 650, 'July 2025', '2025-08-04 08:23:13.000000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_parents`
--

DROP TABLE IF EXISTS `tbl_parents`;
CREATE TABLE IF NOT EXISTS `tbl_parents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(20) NOT NULL,
  `fphone` bigint NOT NULL,
  `femail` varchar(30) NOT NULL,
  `fadhar` varchar(30) NOT NULL,
  `foccupation` varchar(30) NOT NULL,
  `fdesignation` varchar(20) NOT NULL,
  `department` varchar(30) NOT NULL,
  `monthly_income` varchar(20) NOT NULL,
  `fimage` varchar(300) NOT NULL,
  `mname` varchar(20) NOT NULL,
  `mphone` bigint NOT NULL,
  `madhar` varchar(10) NOT NULL,
  `moocupation` varchar(20) NOT NULL,
  `mdesignation` varchar(30) NOT NULL,
  `mdepartment` varchar(20) NOT NULL,
  `m_monthly_income` varchar(20) NOT NULL,
  `mimgage` varchar(300) NOT NULL,
  `present_address` longtext NOT NULL,
  `parmanent_adress` longtext NOT NULL,
  `no_of_student` int NOT NULL,
  `student_reg_no` int NOT NULL,
  `emergency_contact_person` bigint NOT NULL,
  `mobile` bigint NOT NULL,
  `relation` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email` (`femail`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payments`
--

DROP TABLE IF EXISTS `tbl_payments`;
CREATE TABLE IF NOT EXISTS `tbl_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `demand_id` bigint NOT NULL,
  `reg_no` varchar(20) NOT NULL,
  `student_id` bigint NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `session` varchar(20) NOT NULL,
  `total_amount` bigint NOT NULL,
  `month_year` varchar(30) NOT NULL,
  `no_of_advance_month` int NOT NULL,
  `advance_amount` bigint NOT NULL,
  `discount_amount` bigint NOT NULL,
  `grant_total` bigint NOT NULL,
  `paid_amount` bigint NOT NULL,
  `rest_dues` bigint NOT NULL,
  `paid_by` varchar(50) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `payment_by` varchar(50) NOT NULL,
  `check_no` varchar(40) NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `date_and_time` timestamp(6) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

--
-- Dumping data for table `tbl_payments`
--

INSERT INTO `tbl_payments` (`id`, `demand_id`, `reg_no`, `student_id`, `invoice_no`, `session`, `total_amount`, `month_year`, `no_of_advance_month`, `advance_amount`, `discount_amount`, `grant_total`, `paid_amount`, `rest_dues`, `paid_by`, `transaction_id`, `payment_by`, `check_no`, `payment_status`, `date_and_time`, `status`) VALUES
(1, 1, 'ABC2025813739', 1, 'INV040825997', '2025-26', 330, 'July 2025', 0, 0, 30, 300, 300, 0, 'online', '9135467672@ybl', '', '', '', '2025-08-04 15:38:30.000000', 0),
(2, 1, 'ABC2025813739', 1, 'INV040825383', '2025-26', 0, 'July 2025', 1, 80, 30, 50, 50, -80, 'cash', '', 'Shamim Alam', '', '', '2025-08-04 15:39:05.000000', 0),
(3, 3, 'ABC2025920552', 5, 'INV050825965', '2025-26', 1350, 'July 2025', 0, 0, 50, 1300, 1200, 100, 'online', '9135467672@ybl', '', '', '', '2025-08-05 14:24:26.000000', 0),
(4, 3, 'ABC2025920552', 5, 'INV050825762', '2025-26', 100, 'July 2025', 0, 0, 0, 100, 100, 0, 'cash', '', 'pawan kumar', '', '', '2025-08-05 14:24:45.000000', 0),
(5, 7, 'ABC2025855458', 12, 'INV050825316', '2025-26', 1150, 'July 2025', 0, 0, 0, 1150, 1150, 0, 'check', '', '', '1234560', '', '2025-08-05 14:25:48.000000', 0),
(6, 4, 'ABC2025599788', 6, 'INV050825487', '2025-26', 600, 'July 2025', 1, 350, 100, 850, 900, -400, 'cash', '', 'Pawan Kumar', '', '', '2025-08-05 14:31:03.000000', 0),
(7, 4, 'ABC2025599788', 6, 'INV060825995', '2025-26', -400, 'July 2025', 1, 350, 50, 300, 300, -750, 'online', '4521010', '', '', '', '2025-08-06 04:15:43.000000', 0),
(8, 2, 'ABC2025199280', 4, 'INV060825123', '2025-26', 2950, 'July 2025', 0, 0, 50, 2900, 2900, 0, 'cash', '', 'Samim Rizwi', '', '', '2025-08-06 04:16:17.000000', 0),
(9, 5, 'ABC2025994842', 7, 'INV060825994', '2025-26', 1200, 'July 2025', 0, 0, 0, 1200, 1200, 0, 'check', '', '', '12345check', '', '2025-08-06 04:26:34.000000', 0),
(10, 8, 'ABC2025332824', 13, 'INV06082562', '2025-26', 1200, 'July 2025', 0, 0, 0, 1200, 1100, 100, 'cash', '', 'Sohan Kumar', '', '', '2025-08-06 04:29:56.000000', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
