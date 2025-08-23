-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 23, 2025 at 02:07 PM
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
-- Table structure for table `jwt_blacklist`
--

DROP TABLE IF EXISTS `jwt_blacklist`;
CREATE TABLE IF NOT EXISTS `jwt_blacklist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `token` text NOT NULL,
  `logout_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jwt_blacklist`
--

INSERT INTO `jwt_blacklist` (`id`, `token`, `logout_time`) VALUES
(1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY2hvb2wtZXJwIiwiaWF0IjoxNzU1OTQzNzYyLCJleHAiOjE3NTU5NTA5NjIsInN1YiI6MSwidXNlcm5hbWUiOiJtZGFzaHJhZjkxMzVAZ21haWwuY29tIiwibmFtZSI6IkFzcmFmIEFsaSBCYWx5YXZpIn0.djjK99HHF5_LwjgS2eh89DAo39WGlAtTqT-peB9AJfw', '2025-08-23 10:10:47'),
(2, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY2hvb2wtZXJwIiwiaWF0IjoxNzU1OTQzODYyLCJleHAiOjE3NTU5NTEwNjIsInN1YiI6MiwidXNlcm5hbWUiOiJzYW1pbUBnbWFpbC5jb20iLCJuYW1lIjoiU2FtaW0gQWtodGFyIn0.kY8B4EMD1HSLMKeAWoAJed_vNwBUU1nVqLIQG0eUbtI', '2025-08-23 10:11:08'),
(3, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY2hvb2wtZXJwIiwiaWF0IjoxNzU1OTQzOTMwLCJleHAiOjE3NTU5NTExMzAsInN1YiI6MSwidXNlcm5hbWUiOiJtZGFzaHJhZjkxMzVAZ21haWwuY29tIiwibmFtZSI6IkFzcmFmIEFsaSBCYWx5YXZpIn0.SZnXWg6RmQkwtkThUwowWzbmikj5wCAwBZQsbjEr7iI', '2025-08-23 10:12:13'),
(4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY2hvb2wtZXJwIiwiaWF0IjoxNzU1OTQ0MTQxLCJleHAiOjE3NTU5NTEzNDEsInN1YiI6MSwidXNlcm5hbWUiOiJtZGFzaHJhZjkxMzVAZ21haWwuY29tIiwibmFtZSI6IkFzcmFmIEFsaSBCYWx5YXZpIn0.E7aYQhz58xHCjBUB6LcEPO-NMDo1kDEkgWDYoepTrlE', '2025-08-23 10:15:46'),
(5, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY2hvb2wtZXJwIiwiaWF0IjoxNzU1OTQ0NDU2LCJleHAiOjE3NTU5NTE2NTYsInN1YiI6MSwidXNlcm5hbWUiOiJtZGFzaHJhZjkxMzVAZ21haWwuY29tIiwibmFtZSI6IkFzcmFmIEFsaSBCYWx5YXZpIn0.INZkaCHHZhqKzKlqwmgXzJrG5LW0R0yAsqy02mh-cPM', '2025-08-23 10:21:01'),
(6, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY2hvb2wtZXJwIiwiaWF0IjoxNzU1OTQ1Mjg1LCJleHAiOjE3NTU5NTI0ODUsInN1YiI6MSwidXNlcm5hbWUiOiJtZGFzaHJhZjkxMzVAZ21haWwuY29tIiwibmFtZSI6IkFzcmFmIEFsaSBCYWx5YXZpIn0.OppECxKLht_wv7GGIUVvUa-kgb_66l98xB1ryA9b0J4', '2025-08-23 10:37:33'),
(7, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY2hvb2wtZXJwIiwiaWF0IjoxNzU1OTQ1NTAzLCJleHAiOjE3NTU5NTI3MDMsInN1YiI6MiwidXNlcm5hbWUiOiJzYW1pbUBnbWFpbC5jb20iLCJuYW1lIjoiU2FtaW0gQWtodGFyIn0.t1Q7mWptkYXbAC9nBSElnXcrA3K1NZbf76u6JJtLbDk', '2025-08-23 12:22:12'),
(8, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY2hvb2wtZXJwIiwiaWF0IjoxNzU1OTUyMjAwLCJleHAiOjE3NTU5NTk0MDAsInN1YiI6MSwidXNlcm5hbWUiOiJtZGFzaHJhZjkxMzVAZ21haWwuY29tIiwibmFtZSI6IkFzcmFmIEFsaSBCYWx5YXZpIn0.d1PVhEfIV1-RJb7qbChaBXLk2GzqB86YGM5RnYU_9xs', '2025-08-23 12:30:05'),
(9, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY2hvb2wtZXJwIiwiaWF0IjoxNzU1OTUyMjYwLCJleHAiOjE3NTU5NTk0NjAsInN1YiI6MSwidXNlcm5hbWUiOiJtZGFzaHJhZjkxMzVAZ21haWwuY29tIiwibmFtZSI6IkFzcmFmIEFsaSBCYWx5YXZpIn0.k5UCwaL6YFXy_sJ4fGHoNvKiJ19M1zUlIjOU0udrlhA', '2025-08-23 12:31:04'),
(10, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY2hvb2wtZXJwIiwiaWF0IjoxNzU1OTUzMzY2LCJleHAiOjE3NTU5NjA1NjYsInN1YiI6MSwidXNlcm5hbWUiOiJtZGFzaHJhZjkxMzVAZ21haWwuY29tIiwibmFtZSI6IkFzcmFmIEFsaSBCYWx5YXZpIn0.2oZFwmbBj2O83nzVgcZIl7l2dTsCsVbHAZptsBjwcW0', '2025-08-23 12:50:07'),
(11, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY2hvb2wtZXJwIiwiaWF0IjoxNzU1OTUzNjA3LCJleHAiOjE3NTU5NjA4MDcsInN1YiI6MSwidXNlcm5hbWUiOiJtZGFzaHJhZjkxMzVAZ21haWwuY29tIiwibmFtZSI6IkFzcmFmIEFsaSBCYWx5YXZpIn0.YiiRX5WfMuhs2sKgV8fe8VPH5Shhd2BraZSbffE7ykQ', '2025-08-23 12:56:45'),
(12, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY2hvb2wtZXJwIiwiaWF0IjoxNzU1OTUzODI3LCJleHAiOjE3NTU5NjEwMjcsInN1YiI6MSwidXNlcm5hbWUiOiJtZGFzaHJhZjkxMzVAZ21haWwuY29tIiwibmFtZSI6IkFzcmFmIEFsaSBCYWx5YXZpIn0.1hUZLt_munBYiDOM45wr56TS4CdW8CWk_Dxzs6sIAH4', '2025-08-23 13:43:59'),
(13, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY2hvb2wtZXJwIiwiaWF0IjoxNzU1OTU2Njk1LCJleHAiOjE3NTU5NjM4OTUsInN1YiI6MSwidXNlcm5hbWUiOiJtZGFzaHJhZjkxMzVAZ21haWwuY29tIiwibmFtZSI6IkFzcmFmIEFsaSBCYWx5YXZpIn0.AcUDlDpx4Z2d9IymBX9rVCphz27Lm4KjJ5JHm3_GpQ8', '2025-08-23 13:53:15'),
(14, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY2hvb2wtZXJwIiwiaWF0IjoxNzU1OTU3MjIwLCJleHAiOjE3NTU5NjQ0MjAsInN1YiI6MywidXNlcm5hbWUiOiJuazk5MzQ1NjUzODVAZ21haWwuY29tIiwibmFtZSI6Ik5laGEgS3VtYXJpIn0.0uOxtthLpPYgxFKa6k9KBoPbZlYfMA6883Y4F4zdXZY', '2025-08-23 13:53:49');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `reg_no`, `name`, `fname`, `mname`, `dob`, `mobile`, `altmobile`, `email`, `bgroup`, `adhar`, `gender`, `religion`, `category`, `parmanent_address`, `present_address`, `class`, `section`, `roll`, `registration_date`, `admission_date`, `registration_fee`, `session`, `image`, `status`, `parents_id`) VALUES
(1, 'KBWS20257851', 'asraf ali', 'shabbir ansari', 'aasma khatoon', '1997-08-04', 9135467672, 0, 'mdashraf9135@gmail.com', 'a+', 999999999999, 'male', 'islam', 'obc', 'Deoria West Baliya', 'Deoria West Baliya', '1', 'A', 1, '2025-08-23 13:45:59.000000', '2025-08-23 13:48:15.000000', 200, '2025-26', '68a9c6171e2ac_photo-removebg-preview (1).png', 1, 0),
(2, 'KBWS20256235', 'samim alam', 'smaim', 'samina', '2000-10-10', 9234104573, 0, 'samim@gmail.com', 'a+', 222222222222, 'male', 'islam', 'ews', 'Baradaoud', 'Baradaoud', '1', 'A', 200, '2025-08-23 13:47:39.000000', '2025-08-23 13:49:04.000000', 250, '2025-26', '68a9c67b98b7e_WhatsApp Image 2025-04-26 at 11.50.47_e26929c0.jpg', 1, 0);

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
  `back_dues` bigint NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_demand`
--

INSERT INTO `tbl_demand` (`id`, `student_id`, `reg_no`, `session`, `tution_fee`, `transport_and_other_fee`, `back_dues`, `other_fee`, `total`, `paid`, `advance_month`, `advance_amount`, `discount`, `rest_dues`, `month_year`, `date_and_time`, `status`, `print_status`, `print_count`) VALUES
(1, 1, 'KBWS20257851', '2025-26', 200, 250, 200, 'Exam Fee 200', 850, 800, 0, 0, 50, 0, 'August 2025', '2025-08-23 13:49:53.000000', 0, 'Not Printed', 0),
(2, 2, 'KBWS20256235', '2025-26', 200, 400, 200, 'Exam Fee 200', 1000, 500, 0, 0, 0, 500, 'August 2025', '2025-08-23 13:49:53.000000', 0, 'Not Printed', 0);

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
  `back_dues` bigint NOT NULL,
  `total` bigint NOT NULL,
  `month_year` varchar(20) NOT NULL,
  `date_time` timestamp(6) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_fee_entry` (`reg_no`,`session`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_fees`
--

INSERT INTO `tbl_fees` (`id`, `student_id`, `reg_no`, `session`, `tution_fee`, `transport_and_other_fee`, `back_dues`, `total`, `month_year`, `date_time`, `status`) VALUES
(1, 1, 'KBWS20257851', '2025-26', 200, 250, 200, 650, 'August 2025', '2025-08-23 13:48:15.000000', 1),
(2, 2, 'KBWS20256235', '2025-26', 200, 400, 200, 800, 'August 2025', '2025-08-23 13:49:04.000000', 1);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `transaction_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `payment_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `check_no` varchar(40) NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `date_and_time` timestamp(6) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_payments`
--

INSERT INTO `tbl_payments` (`id`, `demand_id`, `reg_no`, `student_id`, `invoice_no`, `session`, `total_amount`, `month_year`, `no_of_advance_month`, `advance_amount`, `discount_amount`, `grant_total`, `paid_amount`, `rest_dues`, `paid_by`, `transaction_id`, `payment_by`, `check_no`, `payment_status`, `date_and_time`, `status`) VALUES
(1, 1, 'KBWS20257851', 1, 'INV230825962', '2025-26', 850, 'August 2025', 0, 0, 50, 800, 800, 0, 'online', '9135467672@ybl', '', '', '', '2025-08-23 13:50:43.000000', 0),
(2, 2, 'KBWS20256235', 2, 'INV23082581', '2025-26', 1000, 'August 2025', 0, 0, 0, 1000, 500, 500, 'cash', '', 'Asraf Ali', '', '', '2025-08-23 13:51:08.000000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pass` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `type` varchar(50) NOT NULL,
  `created_at` datetime(6) NOT NULL,
  `updated_at` datetime(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `pass`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Asraf Ali Balyavi', 'mdashraf9135@gmail.com', '$2y$10$5T2NEVbIKUBwPgLM3UplueJDDCi/qcn3hOE.c0zpoXO0yj6YBNzi.', '', '2025-08-22 05:09:45.000000', '0000-00-00 00:00:00.000000'),
(2, 'Samim Akhtar', 'samim@gmail.com', '$2y$10$yN3as3FItfhRhW7kL/MhpOren.FJTT4DUNYnlKH3q6H4AzCSYiUL.', '', '2025-08-23 10:10:05.000000', '0000-00-00 00:00:00.000000'),
(3, 'Neha Kumari', 'nk9934565385@gmail.com', '$2y$10$iBlUBuT8AWs20USNED95OOZnQljInRTSEll93Rc7QeTZFY5df6FAe', '', '2025-08-23 13:53:05.000000', '0000-00-00 00:00:00.000000');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
