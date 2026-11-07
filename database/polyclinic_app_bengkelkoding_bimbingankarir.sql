-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2025 at 09:41 AM
-- Server version: 10.4.25-MariaDB
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
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(28, 'admin', '$2y$10$2oR9iRUMheP2h3MAw1vrDONBRE72xq17qQKjKePZCEmz2JGVcqRHi');

-- --------------------------------------------------------

--
-- Table structure for table `checkup`
--

CREATE TABLE `checkup` (
  `id` int(11) NOT NULL,
  `poly_list_id` int(11) NOT NULL,
  `check_date` date NOT NULL,
  `medicine_name` varchar(50) NOT NULL,
  `note` text NOT NULL,
  `check_fee` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checkup`
--

INSERT INTO `checkup` (`id`, `poly_list_id`, `check_date`, `medicine_name`, `note`, `check_fee`) VALUES
(28, 31, '2025-01-17', 'Paramex, Vitamin', '1x sehari setelah makan, 3x sehari setelah makan', 200000);

-- --------------------------------------------------------

--
-- Table structure for table `check_detail`
--

CREATE TABLE `check_detail` (
  `id` int(11) NOT NULL,
  `check_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `medicine_name` varchar(50) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `check_schedule`
--

CREATE TABLE `check_schedule` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `day` varchar(10) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `check_schedule`
--

INSERT INTO `check_schedule` (`id`, `doctor_id`, `day`, `start_time`, `end_time`) VALUES
(11, 37, 'Tuesday', '10:00:00', '12:30:00'),
(12, 37, 'Friday', '18:00:00', '21:00:00'),
(13, 38, 'Wednesday', '12:00:00', '15:40:00'),
(14, 44, 'Monday', '08:05:00', '12:07:00'),
(15, 44, 'Saturday', '16:00:00', '19:05:00'),
(16, 43, 'Sunday', '12:03:00', '15:05:00'),
(17, 43, 'Tuesday', '12:10:00', '17:05:00'),
(18, 43, 'Friday', '20:08:00', '12:04:00'),
(19, 43, 'Thursday', '05:04:00', '07:07:00'),
(20, 43, 'Saturday', '11:56:00', '12:56:00');

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

CREATE TABLE `consultation` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `consultation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `question` text NOT NULL,
  `answer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`id`, `patient_id`, `doctor_id`, `consultation_date`, `question`, `answer`) VALUES
(1, 56, 43, '2025-01-23 15:12:40', 'Obat kepala pusing apa dok?', 'Obatnya namanya Paramex'),
(2, 56, 43, '2025-01-23 15:28:01', 'Perut saya kembung kenapa ya dok?', 'Mungkin masuk angin kak'),
(3, 55, 37, '2025-01-23 15:28:47', 'Gigi saya sering bau kenapa ya dok dan sering berlubang juga dok', 'Mungkin jarang sikat gigi kakaknya'),
(5, 55, 44, '2025-01-23 15:30:34', 'Saya sering bengong kenapa ya dok?', 'Mungkin mental anda terganggu');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile_phone_number` bigint(20) UNSIGNED NOT NULL,
  `poly_id` int(11) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `name`, `password`, `address`, `mobile_phone_number`, `poly_id`, `status`) VALUES
(37, 'Radit', '$2y$10$Nakv48qKQFaMEcfFkftZWOZxvltYPWhGDS6B8pY0JpuLIyHIaW/p2', 'Ngaliyan', 628198291001, 1, 'inactive'),
(38, 'Darren', '$2y$10$fI18P5BYCfhTxrPxCsfYoujRVcLl.NW3xV5WjLPAdS32noT.lYBcG', 'Tlogosari', 6281890102012, 1, 'inactive'),
(43, 'Rizal', '$2y$10$HmLO2bd9lDwboWu00ipdGOO.p55RfwjFTnZO6TdenV9H372hDbFza', 'Bandungan', 628129911282871, 11, 'active'),
(44, 'Brahim', '$2y$10$UBoNRRoYnlXEgbKcutRY0OTPXuimUhC29PCyta3gEqSHBh0QVlvOK', 'Pandanaran', 6291715168021, 13, 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `id` int(11) NOT NULL,
  `medicine_name` varchar(50) NOT NULL,
  `packaging` varchar(35) NOT NULL,
  `price` int(10) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`id`, `medicine_name`, `packaging`, `price`) VALUES
(13, 'Paracetamol', 'Plastik', 10000),
(14, 'Paramex', 'Kardus', 5000),
(15, 'Konidin', 'Kertas', 15000),
(16, 'Vitamin', 'Kapsul', 45000);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `identity_card_number` bigint(20) UNSIGNED NOT NULL,
  `mobile_phone_number` bigint(20) UNSIGNED NOT NULL,
  `medical_record_number` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `name`, `password`, `address`, `identity_card_number`, `mobile_phone_number`, `medical_record_number`) VALUES
(55, 'Darren Marcellino Setiawan', '$2y$10$APdZeWNiOX1Akw7eNkk4euSRJ.IC1Our.9tATtyLL2TH8deRPR656', 'Tlogosari', 339188881211, 6291992198267, '202501-1'),
(56, 'Yohanes Diyan Hariawan', '$2y$10$RkjjBM/gAvlet.GF.wnAne63oeGhbJrXRbTERwH/h.ubwbAxBPe.e', 'Ngaliyan', 3918812992938, 621892200111, '202501-2'),
(57, 'Ardennata Winarto', '$2y$10$UgT0dmNRd1vNceoBZWVPFedGeBOwTiDkweqTlHfwH.RZGMTiwDqRm', 'Tanah Putih', 31882912021012, 629891881289912, '202501-3'),
(58, 'Steven Felisiano', '$2y$10$ezMM2d4hVRFU90preB7YFuO86ZkDyKflX2qAVtlJlqdUTnoWD.Nz6', 'Karangwulan', 71881818223823, 628199199929, '202501-4'),
(59, 'Aditya Putra', '$2y$10$sdlCkIWWSSuSeusWPODgo.zl1oQoEGE9oivT1ki9IdZE4nMuHBvQS', 'Genuk', 338182891921912, 628182219212, '202501-5');

-- --------------------------------------------------------

--
-- Table structure for table `poly`
--

CREATE TABLE `poly` (
  `id` int(11) NOT NULL,
  `poly_name` varchar(25) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `poly`
--

INSERT INTO `poly` (`id`, `poly_name`, `description`) VALUES
(1, 'Gigi', 'Poli Gigi'),
(11, 'Umum', 'Poli Umum'),
(12, 'Saraf', 'Poli Saraf'),
(13, 'Psikologi', 'Poli Psikologi');

-- --------------------------------------------------------

--
-- Table structure for table `poly_list`
--

CREATE TABLE `poly_list` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `complaint` text NOT NULL,
  `queue_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `poly_list`
--

INSERT INTO `poly_list` (`id`, `patient_id`, `schedule_id`, `complaint`, `queue_number`) VALUES
(31, 56, 16, 'Kepala saya sakit', 1),
(32, 56, 19, 'Perut saya kembung', 1),
(33, 56, 13, 'Gigi saya berlubang', 1),
(34, 59, 16, 'Kaki saya gatal-gatal', 2);

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
-- Indexes for table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `checkup`
--
ALTER TABLE `checkup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `check_detail`
--
ALTER TABLE `check_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `check_schedule`
--
ALTER TABLE `check_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `consultation`
--
ALTER TABLE `consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `poly`
--
ALTER TABLE `poly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `poly_list`
--
ALTER TABLE `poly_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
-- Constraints for table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `consultation_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`);

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
