-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 14, 2024 at 07:38 PM
-- Server version: 8.0.30
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `backend`
--

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

CREATE TABLE `consultation` (
  `id` int NOT NULL,
  `createTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `speciality_id` int DEFAULT NULL,
  `comments` varchar(1000) DEFAULT NULL,
  `inspection_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`id`, `createTime`, `speciality_id`, `comments`, `inspection_id`) VALUES
(15, '2024-01-11 15:40:55', 1, 'yeeeeeeeehaaaw', 54),
(16, '2024-01-11 15:40:57', 1, 'yeeeeeeeehaaaw', 55),
(17, '2024-01-11 15:41:19', 1, 'yeeeeeeeehaaaw', 56),
(18, '2024-01-11 15:41:20', 1, 'yeeeeeeeehaaaw', 57),
(19, '2024-01-11 15:41:20', 1, 'yeeeeeeeehaaaw', 58),
(20, '2024-01-11 15:41:21', 1, 'yeeeeeeeehaaaw', 59),
(21, '2024-01-11 15:41:21', 1, 'yeeeeeeeehaaaw', 60),
(22, '2024-01-11 15:41:22', 1, 'yeeeeeeeehaaaw', 61),
(23, '2024-01-11 15:41:23', 1, 'yeeeeeeeehaaaw', 62),
(24, '2024-01-11 15:41:23', 1, 'yeeeeeeeehaaaw', 63),
(25, '2024-01-11 15:41:24', 1, 'yeeeeeeeehaaaw', 64);

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE `diagnosis` (
  `id` int NOT NULL,
  `createTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `code` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `type` enum('Main','Concomitant','Complication') NOT NULL,
  `inspection_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `diagnosis`
--

INSERT INTO `diagnosis` (`id`, `createTime`, `code`, `name`, `description`, `type`, `inspection_id`) VALUES
(17, '2024-01-11 15:40:55', 'H53.2', 'Диплопия', 'string', 'Main', 54),
(18, '2024-01-11 15:40:57', 'K44.0', 'Диафрагмальная грыжа с непроходимостью без гангрены', '1234', 'Main', 55),
(19, '2024-01-11 15:41:19', 'H53.2', 'Диплопия', 'string', 'Main', 56),
(20, '2024-01-11 15:41:20', 'H53.2', 'Диплопия', 'string', 'Main', 57),
(21, '2024-01-11 15:41:20', 'H53.2', 'Диплопия', 'string', 'Main', 58),
(22, '2024-01-11 15:41:21', 'H53.2', 'Диплопия', 'string', 'Main', 59),
(23, '2024-01-11 15:41:21', 'H53.2', 'Диплопия', 'string', 'Main', 60),
(24, '2024-01-11 15:41:22', 'H53.2', 'Диплопия', 'string', 'Main', 61),
(25, '2024-01-11 15:41:23', 'H53.2', 'Диплопия', 'string', 'Main', 62),
(26, '2024-01-11 15:41:23', 'H53.2', 'Диплопия', 'string', 'Main', 63),
(27, '2024-01-11 15:41:24', 'H53.2', 'Диплопия', 'string', 'Main', 64);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int NOT NULL,
  `createTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(64) NOT NULL,
  `birthday` datetime NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `email` varchar(64) NOT NULL,
  `phoneNumber` varchar(11) DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `speciality_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `createTime`, `name`, `birthday`, `gender`, `email`, `phoneNumber`, `password`, `speciality_id`) VALUES
(1, '2024-01-04 17:12:26', 'Yusuf Osama Abouelata', '2000-08-12 00:00:00', 'Male', 'yosef@example.com', '9142443225', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 1),
(2, '2024-01-04 17:12:26', 'Osama Abouelata', '2000-08-12 00:00:00', 'Male', 'yosef1@example.com', '9142443225', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 1),
(3, '2024-01-14 19:26:29', 'Akira Ozumaki', '2001-01-14 19:08:41', 'Male', 'mail@mail.com', NULL, 'password1', 3),
(4, '2024-01-14 19:27:26', 'Akira Ozumaki', '2001-01-14 19:08:41', 'Male', 'mail@mail.com', NULL, 'password1', 3),
(5, '2024-01-14 19:29:21', 'John Doe', '1985-07-20 08:15:00', 'Male', 'john.doe@mail.com', '1234567890', 'securepass1', 7),
(6, '2024-01-14 19:29:21', 'Alice Johnson', '1990-04-12 14:30:00', 'Female', 'alice.johnson@mail.com', '9876543210', 'mypassword', 12),
(7, '2024-01-14 19:29:21', 'David Smith', '1988-11-05 10:45:00', 'Male', 'david.smith@mail.com', '5556667777', 'secretpass', 5),
(8, '2024-01-14 19:29:21', 'Emily White', '1993-09-15 18:20:00', 'Female', 'emily.white@mail.com', '1112223333', 'myp@ssword', 15),
(9, '2024-01-14 19:29:21', 'Michael Brown', '1980-02-28 22:00:00', 'Male', 'michael.brown@mail.com', '9998887777', 'secure123', 10),
(10, '2024-01-14 19:29:34', 'Sophia Rodriguez', '1987-06-10 12:45:00', 'Female', 'sophia.rodriguez@mail.com', '7778889999', 'p@ssword123', 8),
(11, '2024-01-14 19:29:34', 'Daniel Chen', '1995-03-25 06:30:00', 'Male', 'daniel.chen@mail.com', '4443332222', 'secret1234', 14),
(12, '2024-01-14 19:29:34', 'Olivia Kim', '1983-08-17 16:10:00', 'Female', 'olivia.kim@mail.com', '6665554444', 'myp@ss', 6),
(13, '2024-01-14 19:29:34', 'Matthew Lee', '1992-01-30 20:00:00', 'Male', 'matthew.lee@mail.com', '1231231234', 'securepass123', 11),
(14, '2024-01-14 19:29:34', 'Ava Johnson', '1989-12-05 14:55:00', 'Female', 'ava.johnson@mail.com', '9876543210', 'mysecurepass', 18);

-- --------------------------------------------------------

--
-- Table structure for table `icd10`
--

CREATE TABLE `icd10` (
  `code` varchar(64) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `id` int NOT NULL,
  `createTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inspection`
--

CREATE TABLE `inspection` (
  `id` int NOT NULL,
  `date` datetime NOT NULL,
  `anamnesis` varchar(5000) NOT NULL,
  `complaints` varchar(5000) NOT NULL,
  `treatment` varchar(5000) NOT NULL,
  `conclusion` enum('Disease','Recovery','Death') NOT NULL,
  `nextVisitDate` datetime DEFAULT NULL,
  `deathDate` datetime DEFAULT NULL,
  `previousInspectionId` int DEFAULT NULL,
  `patient_id` int NOT NULL,
  `doctor_id` int NOT NULL,
  `createTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hasChain` tinyint(1) NOT NULL DEFAULT '0',
  `hasNested` tinyint(1) NOT NULL DEFAULT '0',
  `nextInspectionId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inspection`
--

INSERT INTO `inspection` (`id`, `date`, `anamnesis`, `complaints`, `treatment`, `conclusion`, `nextVisitDate`, `deathDate`, `previousInspectionId`, `patient_id`, `doctor_id`, `createTime`, `hasChain`, `hasNested`, `nextInspectionId`) VALUES
(54, '2024-01-10 06:00:51', 'string', 'string', 'string', 'Disease', '2025-01-10 06:00:51', NULL, NULL, 1, 1, '2024-01-11 15:40:55', 0, 0, NULL),
(55, '2024-01-10 06:00:51', 'string123', 'string123', '1234', 'Disease', '2025-01-10 06:00:51', NULL, NULL, 1, 1, '2024-01-11 15:40:57', 0, 0, NULL),
(56, '2024-01-10 06:00:51', 'string', 'string', 'string', 'Disease', '2025-01-10 06:00:51', NULL, NULL, 1, 1, '2024-01-11 15:41:19', 0, 0, NULL),
(57, '2024-01-10 06:00:51', 'string', 'string', 'string', 'Disease', '2025-01-10 06:00:51', NULL, NULL, 1, 1, '2024-01-11 15:41:20', 0, 0, NULL),
(58, '2024-01-10 06:00:51', 'string', 'string', 'string', 'Disease', '2025-01-10 06:00:51', NULL, NULL, 1, 1, '2024-01-11 15:41:20', 0, 0, NULL),
(59, '2024-01-10 06:00:51', 'string', 'string', 'string', 'Disease', '2025-01-10 06:00:51', NULL, NULL, 1, 1, '2024-01-11 15:41:21', 0, 0, NULL),
(60, '2024-01-10 06:00:51', 'string', 'string', 'string', 'Disease', '2025-01-10 06:00:51', NULL, NULL, 1, 1, '2024-01-11 15:41:21', 0, 0, NULL),
(61, '2024-01-10 06:00:51', 'string', 'string', 'string', 'Disease', '2025-01-10 06:00:51', NULL, NULL, 1, 1, '2024-01-11 15:41:22', 0, 0, NULL),
(62, '2024-01-10 06:00:51', 'string', 'string', 'string', 'Disease', '2025-01-10 06:00:51', NULL, NULL, 1, 1, '2024-01-11 15:41:23', 0, 0, NULL),
(63, '2024-01-10 06:00:51', 'string', 'string', 'string', 'Disease', '2025-01-10 06:00:51', NULL, NULL, 1, 1, '2024-01-11 15:41:23', 0, 0, NULL),
(64, '2024-01-10 06:00:51', 'string', 'string', 'string', 'Disease', '2025-01-10 06:00:51', NULL, NULL, 1, 1, '2024-01-11 15:41:24', 0, 0, NULL),
(65, '2024-01-01 23:33:03', 'unclear', 'unknown', 'none', 'Recovery', NULL, NULL, NULL, 13, 14, '2024-01-14 19:34:06', 0, 0, NULL),
(66, '2024-01-01 23:33:03', 'unclear', 'unknown', 'none', 'Recovery', NULL, NULL, NULL, 13, 14, '2024-01-14 19:37:51', 0, 0, NULL),
(67, '2024-01-02 10:15:30', 'headache', 'migraine', 'rest', 'Recovery', NULL, NULL, NULL, 13, 14, '2024-01-14 19:37:51', 1, 0, NULL),
(68, '2024-01-03 15:45:20', 'fatigue', 'unknown', 'rest and hydration', 'Recovery', NULL, NULL, NULL, 13, 14, '2024-01-14 19:37:51', 0, 1, NULL),
(69, '2024-01-04 08:30:45', 'cough', 'chest pain', 'medication', 'Recovery', '2024-02-01 00:00:00', NULL, NULL, 13, 14, '2024-01-14 19:37:51', 1, 0, NULL),
(70, '2024-01-05 12:10:00', 'fever', 'body aches', 'rest and fluids', 'Recovery', NULL, NULL, NULL, 13, 14, '2024-01-14 19:37:51', 0, 1, NULL),
(71, '2024-01-06 17:20:15', 'nausea', 'abdominal pain', 'diet modification', 'Recovery', NULL, NULL, NULL, 13, 14, '2024-01-14 19:37:51', 1, 0, NULL),
(72, '2024-01-07 09:30:30', 'dizziness', 'unclear', 'rest and hydration', 'Recovery', NULL, NULL, NULL, 13, 14, '2024-01-14 19:37:51', 0, 1, NULL),
(73, '2024-01-08 14:40:45', 'joint pain', 'swelling', 'medication', 'Recovery', NULL, NULL, NULL, 13, 14, '2024-01-14 19:37:51', 1, 0, NULL),
(74, '2024-01-09 18:50:00', 'shortness of breath', 'chest pain', 'rest and medication', 'Recovery', NULL, NULL, NULL, 13, 14, '2024-01-14 19:37:51', 0, 1, NULL),
(75, '2024-01-10 11:00:15', 'fatigue', 'unknown', 'rest and hydration', 'Recovery', NULL, NULL, NULL, 13, 14, '2024-01-14 19:37:51', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int NOT NULL,
  `name` varchar(64) NOT NULL,
  `birthday` datetime DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `createTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `name`, `birthday`, `gender`, `createTime`) VALUES
(1, 'Maryam Om mohammed', '2001-09-11 00:00:00', 'Female', '2024-01-05 18:11:11'),
(2, 'Maryam Om mohammed', '2001-09-11 00:00:00', 'Female', '2024-01-05 18:12:27'),
(3, 'Sara Jay', NULL, 'Female', '2024-01-14 19:30:38'),
(5, 'Alex Smith', '1990-09-14 00:00:00', 'Male', '2024-01-14 19:31:47'),
(6, 'Emily Davis', '1985-05-22 00:00:00', 'Female', '2024-01-14 19:31:47'),
(7, 'Daniel Brown', '1998-12-10 00:00:00', 'Male', '2024-01-14 19:31:47'),
(8, 'Sophia Johnson', '1993-02-28 00:00:00', 'Female', '2024-01-14 19:31:47'),
(9, 'David Lee', '1980-07-15 00:00:00', 'Male', '2024-01-14 19:31:47'),
(10, 'Olivia Kim', '1995-11-05 00:00:00', 'Female', '2024-01-14 19:31:47'),
(11, 'Matthew Chen', '1989-03-20 00:00:00', 'Male', '2024-01-14 19:31:47'),
(12, 'Ava Rodriguez', '1992-08-12 00:00:00', 'Female', '2024-01-14 19:31:47'),
(13, 'Ethan Davis', '1987-01-25 00:00:00', 'Male', '2024-01-14 19:31:47');

-- --------------------------------------------------------

--
-- Table structure for table `speciality`
--

CREATE TABLE `speciality` (
  `id` int NOT NULL,
  `createTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `speciality`
--

INSERT INTO `speciality` (`id`, `createTime`, `name`) VALUES
(1, '2024-01-09 14:53:34', 'Акушер-гинеколог'),
(2, '2024-01-09 14:53:34', 'Анестезиолог-реаниматолог'),
(3, '2024-01-09 14:53:34', 'Дерматовенеролог'),
(4, '2024-01-09 14:53:34', 'Инфекционист'),
(5, '2024-01-09 14:53:34', 'Кардиолог'),
(6, '2024-01-09 14:53:34', 'Невролог'),
(7, '2024-01-09 14:53:34', 'Онколог'),
(8, '2024-01-09 14:53:34', 'Отоларинголог'),
(9, '2024-01-09 14:53:34', 'Офтальмолог'),
(10, '2024-01-09 14:53:34', 'Психиатр'),
(11, '2024-01-09 14:53:34', 'Психолог'),
(12, '2024-01-09 14:53:34', 'Рентгенолог'),
(13, '2024-01-09 14:53:34', 'Стоматолог'),
(14, '2024-01-09 14:53:34', 'Терапевт'),
(15, '2024-01-09 14:53:34', 'УЗИ-специалист'),
(16, '2024-01-09 14:53:34', 'Уролог'),
(17, '2024-01-09 14:53:34', 'Хирург'),
(18, '2024-01-09 14:53:34', 'Эндокринолог');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `user_id` int NOT NULL,
  `tokenValue` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`user_id`, `tokenValue`) VALUES
(1, 'a129f046c7717a447ac09d6c9fa8e188');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `icd10`
--
ALTER TABLE `icd10`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inspection`
--
ALTER TABLE `inspection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `speciality`
--
ALTER TABLE `speciality`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultation`
--
ALTER TABLE `consultation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `diagnosis`
--
ALTER TABLE `diagnosis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `icd10`
--
ALTER TABLE `icd10`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inspection`
--
ALTER TABLE `inspection`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `speciality`
--
ALTER TABLE `speciality`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
