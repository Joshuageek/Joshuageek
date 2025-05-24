-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 17, 2025 at 12:42 PM
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
-- Database: `swiftdoc`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_submissions`
--

CREATE TABLE `booking_submissions` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `booking_date` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `number_of_people` varchar(20) NOT NULL,
  `booking_time` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_submissions`
--

INSERT INTO `booking_submissions` (`id`, `full_name`, `phone`, `booking_date`, `email`, `number_of_people`, `booking_time`, `created_at`) VALUES
(1, 'Hello', '12345', '2025-05-14', 'hello@gmail.com', '3 People', 'Evening', '2025-05-13 23:01:15');

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_responses`
--

CREATE TABLE `questionnaire_responses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `therapyReasons` text DEFAULT NULL,
  `therapyGoals` text DEFAULT NULL,
  `therapyHistory` varchar(20) DEFAULT NULL,
  `receivedTherapy` text DEFAULT NULL,
  `therapyInterest` text DEFAULT NULL,
  `communicationMethod` text DEFAULT NULL,
  `sessionFrequency` varchar(50) DEFAULT NULL,
  `sessionTime` varchar(50) DEFAULT NULL,
  `therapistQualities` text DEFAULT NULL,
  `therapistGender` text DEFAULT NULL,
  `healthCondition` text DEFAULT NULL,
  `triggers` text DEFAULT NULL,
  `coping` text DEFAULT NULL,
  `source` text DEFAULT NULL,
  `additionalInfo` text DEFAULT NULL,
  `submitted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questionnaire_responses`
--

INSERT INTO `questionnaire_responses` (`id`, `user_id`, `therapyReasons`, `therapyGoals`, `therapyHistory`, `receivedTherapy`, `therapyInterest`, `communicationMethod`, `sessionFrequency`, `sessionTime`, `therapistQualities`, `therapistGender`, `healthCondition`, `triggers`, `coping`, `source`, `additionalInfo`, `submitted_at`) VALUES
(5, 1, 'anxiety, depression, stress', 'reduce-symptoms, improve-relationships', 'past', 'couples', 'individual, couples', 'audio', 'monthly', 'afternoon', 'solution, nurturing, specialized', 'female', 'ddd', 'none reported', 'dddd', 'referral', 'dddd', '2025-05-13 01:20:15'),
(6, 2, 'depression, stress', 'coping-strategies', 'past', 'couples, family', 'couples, family', 'audio', 'biweekly', 'morning', 'solution, nurturing', 'female', 'none reported', 'none reported', 'ffff', 'social-media', 'foood', '2025-05-13 09:14:19'),
(7, 3, 'depression', 'improve-relationships, coping-strategies', 'current', 'individual, couples', 'couples, family', 'text', 'biweekly', 'afternoon', 'empathy, experience, solution, nurturing', 'female', 'ddd', 'none reported', 'jj', 'internet', 'hoo', '2025-05-13 12:00:55'),
(8, 4, 'stress', 'improve-relationships, coping-strategies', 'current', 'individual, couples', 'couples', 'audio', 'monthly', 'afternoon', 'solution, nurturing', 'female', 'none reported', 'none reported', 'ddd', 'internet', 'dddd', '2025-05-14 23:00:17');

-- --------------------------------------------------------

--
-- Table structure for table `therapists`
--

CREATE TABLE `therapists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_upload` varchar(255) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `other_specialization` varchar(255) DEFAULT NULL,
  `license_upload` varchar(255) NOT NULL,
  `licensing_body` varchar(255) DEFAULT NULL,
  `cv_upload` varchar(255) NOT NULL,
  `languages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`languages`)),
  `other_language` varchar(255) DEFAULT NULL,
  `internet_connection` enum('yes','no') NOT NULL,
  `video_conferencing` enum('yes','no') NOT NULL,
  `teletherapy_experience` enum('yes','no') NOT NULL,
  `consent_verification` tinyint(1) NOT NULL DEFAULT 0,
  `consent_data` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(225) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `age` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `age`, `gender`, `location`, `role`, `password`, `created_on`) VALUES
(1, 'Don', 'don@gmail.com', NULL, '18-24', 'male', 'Near You', NULL, '$2y$10$zLAEnG7f.dQBFWbJdtKwC.V/whx1T1xtZVvVcG4DVW2o5yJB3ognO', '2025-05-13 01:20:15'),
(2, 'Don', 'walden@gmail.com', NULL, '25-34', 'male', 'Near You', NULL, '$2y$10$18oGRCkmLg2W8o827KAyYOTqe8/FbZbanMKoTzzgikAlLVCxy4Shy', '2025-05-13 09:14:19'),
(3, 'Don', 'student@gmail.com', NULL, '25-34', 'male', 'Et in tempora ad iru', NULL, NULL, '2025-05-13 12:00:55'),
(4, 'Hello', 'do@gmail.com', NULL, '25-34', 'female', 'Et in tempora ad iru', 'client', NULL, '2025-05-14 23:00:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_submissions`
--
ALTER TABLE `booking_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questionnaire_responses`
--
ALTER TABLE `questionnaire_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `therapists`
--
ALTER TABLE `therapists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_submissions`
--
ALTER TABLE `booking_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `questionnaire_responses`
--
ALTER TABLE `questionnaire_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `therapists`
--
ALTER TABLE `therapists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;