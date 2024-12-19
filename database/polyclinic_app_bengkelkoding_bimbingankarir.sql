-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 19, 2024 at 11:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `polyclinic_app_bengkelkoding_bimbingankarir`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(26, 'admin', '$2y$10$yNG6jpWkyhLumnwOlBU6yuEkB/uHBdauw0QsTg9nE6Ms8mLbqxIGq');

-- --------------------------------------------------------

--
-- Table structure for table `checkup`
--

CREATE TABLE `checkup` (
  `id` int NOT NULL,
  `poly_list_id` int NOT NULL,
  `check_date` date NOT NULL,
  `note` text NOT NULL,
  `check_fee` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `check_detail`
--

CREATE TABLE `check_detail` (
  `id` int NOT NULL,
  `check_id` int NOT NULL,
  `medicine_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `check_schedule`
--

CREATE TABLE `check_schedule` (
  `id` int NOT NULL,
  `doctor_id` int NOT NULL,
  `day` varchar(10) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile_phone_number` int UNSIGNED NOT NULL,
  `poly_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `name`, `password`, `address`, `mobile_phone_number`, `poly_id`) VALUES
(1, 'Adi', '$2y$10$pMgo4SofUaDe7/dMlVCsNOoZVChHbvzQ.gM2aGqnzrxUnuHpyUQa2', 'Ungaran', 9871711, 1),
(5, 'Lukas', '$2y$10$A09/EnqZUZ3QpQWKNDW94esbL2a10mowFRrUo/1IcJ1dl/TL0leZO', 'Malang', 565563243, 4);

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `id` int NOT NULL,
  `medicine_name` varchar(50) NOT NULL,
  `packaging` varchar(35) DEFAULT NULL,
  `price` int UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`id`, `medicine_name`, `packaging`, `price`) VALUES
(2, 'Paracetamol', 'Racikan', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `identity_card_number` int UNSIGNED NOT NULL,
  `mobile_phone_number` int UNSIGNED NOT NULL,
  `medical_record_number` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `name`, `password`, `address`, `identity_card_number`, `mobile_phone_number`, `medical_record_number`) VALUES
(4, 'Darren Marcellino Setiawan', '$2y$10$5LILG6g47V/GgLIFh8KV1OQ6GPHttB5cR.3UjYiu/y7zrWBo5Aeb2', 'Tlogosari', 12345678, 817281991, '202412-1'),
(7, 'Darren Marcellino', '$2y$10$cJiklPpnMbOO3Og0IRqjY.Z539kKOo3a9IgBFYsTCOyryTtE.jRE2', 'Banyuwangi', 1234671, 28372191, '202412-2');

-- --------------------------------------------------------

--
-- Table structure for table `poly`
--

CREATE TABLE `poly` (
  `id` int NOT NULL,
  `poly_name` varchar(25) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `poly`
--

INSERT INTO `poly` (`id`, `poly_name`, `description`) VALUES
(1, 'Gigi', 'jisqsq'),
(4, 'Umum', 'sxadedee'),
(5, 'Penyakit Dalam', 'yhjhmhnh');

-- --------------------------------------------------------

--
-- Table structure for table `poly_list`
--

CREATE TABLE `poly_list` (
  `id` int NOT NULL,
  `patient_id` int NOT NULL,
  `schedule_id` int NOT NULL,
  `complaint` text NOT NULL,
  `queue_number` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkup`
--
ALTER TABLE `checkup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poly_list_id` (`poly_list_id`);

--
-- Indexes for table `check_detail`
--
ALTER TABLE `check_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `check_id` (`check_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `check_schedule`
--
ALTER TABLE `check_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poly_id` (`poly_id`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poly`
--
ALTER TABLE `poly`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poly_list`
--
ALTER TABLE `poly_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `checkup`
--
ALTER TABLE `checkup`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `check_detail`
--
ALTER TABLE `check_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `check_schedule`
--
ALTER TABLE `check_schedule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `poly`
--
ALTER TABLE `poly`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `poly_list`
--
ALTER TABLE `poly_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkup`
--
ALTER TABLE `checkup`
  ADD CONSTRAINT `checkup_ibfk_1` FOREIGN KEY (`poly_list_id`) REFERENCES `poly_list` (`id`);

--
-- Constraints for table `check_detail`
--
ALTER TABLE `check_detail`
  ADD CONSTRAINT `check_detail_ibfk_1` FOREIGN KEY (`check_id`) REFERENCES `checkup` (`id`),
  ADD CONSTRAINT `check_detail_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `medicine` (`id`);

--
-- Constraints for table `check_schedule`
--
ALTER TABLE `check_schedule`
  ADD CONSTRAINT `check_schedule_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`);

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`poly_id`) REFERENCES `poly` (`id`);

--
-- Constraints for table `poly_list`
--
ALTER TABLE `poly_list`
  ADD CONSTRAINT `poly_list_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `poly_list_ibfk_2` FOREIGN KEY (`schedule_id`) REFERENCES `check_schedule` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
