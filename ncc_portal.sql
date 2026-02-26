-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2026 at 01:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ncc_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `fullname`, `username`, `password`, `created_at`) VALUES
(1, 'Sunika Duseja', 'admin', '$2y$10$bE7UHh5PA6kHVo0Qkn.rgeB6TNRvLGhdcHZWD0ZIMKSheTPEOAEgu', '2026-02-25 18:52:54'),
(2, 'mohit', 'mohit', '$2y$10$1TZU9ZMDOoz1LJH1nBh/.OrrS7KUjzrOy.bbXZ4aS0UCc2DLBWCHK', '2026-02-25 19:37:46'),
(3, 'Sunika Duseja', 'admin1', '$2y$10$ODNMUTDpw.O3ziEGq1uK2eOgdSjf4fTXfzCHTpokRpVgrY0CPYY5S', '2026-02-26 05:04:59');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `cadet_id` int(11) NOT NULL,
  `training_date` date NOT NULL,
  `status` enum('Present','Absent') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `cadet_id`, `training_date`, `status`, `created_at`) VALUES
(1, 1, '2026-02-25', 'Present', '2026-02-25 19:00:18'),
(2, 3, '2026-02-25', 'Present', '2026-02-25 19:00:18'),
(3, 1, '2026-02-26', 'Present', '2026-02-26 05:05:47'),
(4, 3, '2026-02-26', 'Present', '2026-02-26 05:05:47'),
(5, 4, '2026-02-26', 'Present', '2026-02-26 05:05:47'),
(6, 5, '2026-02-26', 'Absent', '2026-02-26 05:05:47'),
(7, 6, '2026-02-26', 'Absent', '2026-02-26 05:05:47'),
(8, 7, '2026-02-26', 'Absent', '2026-02-26 05:05:47'),
(9, 8, '2026-02-26', 'Absent', '2026-02-26 05:05:47'),
(10, 9, '2026-02-26', 'Present', '2026-02-26 05:05:47'),
(11, 10, '2026-02-26', 'Present', '2026-02-26 05:05:47');

-- --------------------------------------------------------

--
-- Table structure for table `cadets`
--

CREATE TABLE `cadets` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rank` varchar(50) DEFAULT 'Cadet'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cadets`
--

INSERT INTO `cadets` (`id`, `fullname`, `dob`, `gender`, `course`, `phone`, `password`, `created_at`, `rank`) VALUES
(1, 'Sunika Duseja', '2007-02-07', 'Female', 'bscit ty', '1', '$2y$10$Uvs730VVq2UxGNsS/8J8jum4hXe0hgfPanfeXq4V1HgD38I9k53ei', '2026-02-25 17:54:46', 'Cadet'),
(3, 'Rita Duseja', '2008-06-17', 'Female', 'bsc 1st year', '4', '$2y$10$vbBcxg4ijk69Vg7ZGxk9juTgPHO1oHa4a22OAjSqJy3D.d0QooeCa', '2026-02-25 18:36:27', 'Cadet'),
(4, 'Aman Sharma', NULL, NULL, 'BSc IT', '9876543210', '', '2026-02-25 20:00:44', 'Cadet'),
(5, 'Riya Singh', NULL, NULL, 'BCom', '9123456780', '', '2026-02-25 20:00:44', 'Cadet'),
(6, 'Karan Patel', NULL, NULL, 'BA', '9988776655', '', '2026-02-25 20:00:44', 'Cadet'),
(7, 'Sneha Verma', NULL, NULL, 'BSc CS', '9090909090', '', '2026-02-25 20:00:44', 'Cadet'),
(8, 'Rahul Mehta', NULL, NULL, 'BBA', '9871234567', '', '2026-02-25 20:00:44', 'Cadet'),
(9, 'ish', '2005-06-30', 'Male', 'bscit ty', '123456789', '$2y$10$5OdbrLSLX2b4KEfS59bZouMF4jZDd3KEvdo8DYUJn1uF1RjTihIby', '2026-02-26 04:42:37', 'Cadet'),
(10, 'shikha', '2006-06-13', 'Female', 'bsc 1st year', 'MH2023SWA066283', '$2y$10$u692klUUgAKycnGE6Gg4Qe0Q/MRqkGfxWbe28l4FoqtPKYrdJcYYu', '2026-02-26 04:47:55', 'Cadet'),
(11, 'ishita', '2005-06-15', 'Female', 'bsc 1st year', 'MH2023SWA066282', '$2y$10$UVIVsOlwPb.rL4HLCqY7z.afku3ktZZCfXMGzvlDlLLaKmaRQ6nXq', '2026-02-26 05:06:55', 'Cadet');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--
-- Error reading structure for table ncc_portal.events: #1932 - Table &#039;ncc_portal.events&#039; doesn&#039;t exist in engine
-- Error reading data for table ncc_portal.events: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `ncc_portal`.`events`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `training`
--

CREATE TABLE `training` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `training_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training`
--

INSERT INTO `training` (`id`, `title`, `description`, `training_date`, `created_at`) VALUES
(1, 'Drill', '6.50 am', '2026-02-27', '2026-02-25 18:55:01'),
(2, 'Drill', '6.50 am', '2026-02-27', '2026-02-26 05:06:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cadet_id` (`cadet_id`);

--
-- Indexes for table `cadets`
--
ALTER TABLE `cadets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training`
--
ALTER TABLE `training`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cadets`
--
ALTER TABLE `cadets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `training`
--
ALTER TABLE `training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`cadet_id`) REFERENCES `cadets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
