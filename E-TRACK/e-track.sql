-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 12:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-track`
--

-- --------------------------------------------------------

--
-- Table structure for table `conversions`
--

CREATE TABLE `conversions` (
  `id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `from_currency` varchar(3) NOT NULL,
  `to_currency` varchar(3) NOT NULL,
  `converted_amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversions`
--

INSERT INTO `conversions` (`id`, `amount`, `from_currency`, `to_currency`, `converted_amount`, `description`, `timestamp`) VALUES
(1, 1.00, 'USD', 'INR', 74.50, 'Converted 1 USD to 74.50 INR', '2024-09-08 11:01:33'),
(2, 1.00, 'INR', 'USD', 0.01, 'Converted 1 INR to 0.01 USD', '2024-09-08 11:02:04'),
(3, 500.00, 'INR', 'USD', 6.50, 'Converted 500 INR to 6.50 USD', '2024-09-08 11:50:28'),
(4, 2.00, 'USD', 'INR', 149.00, 'Converted 2 USD to 149.00 INR', '2024-10-22 13:46:58');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `feedback` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `feedback`, `timestamp`) VALUES
(1, 'test', 'user@gmail.com', 'nice\r\n', '2024-09-08 11:07:11'),
(2, 'user', '1@gmail.com', 'good', '2024-09-08 11:08:51'),
(3, 'user', '1@gmail.com', 'very good', '2024-09-08 11:10:36'),
(4, 'amol', '1@gmail.com', 'amol pawar', '2024-09-08 11:12:08'),
(5, 'amol', 'amol@gmail.com', 'hello frds', '2024-09-08 11:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('male','female','others') NOT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `username`, `email`, `password`, `gender`, `contact`, `address`, `occupation`, `age`, `dob`) VALUES
(1, 'user@gmail.com', 'user@gmail.com', '$2y$10$IIAuaY6AIoSBAr0dORzSyOq8Jd83h6mmqf5a2TBGjAL8qsowp3gnK', 'male', '22', '33', '44', 55, '2024-09-10'),
(2, 'user@gmail.com', 'user@gmail.com', '$2y$10$mwKUAqqNaIs9nmOmKxsc.u8MhQ1DmuHhwrqzajCiaNPZP5WLgGYMq', 'male', '1123', '3456', 'asd', 12, '2024-09-18'),
(3, 'user@gmail.com', 'user@gmail.com', '$2y$10$4Q9nI6B.iK95aaKwobzuPeM9juW9h1PlwjqEPIRSrU3WvOcYxWgNW', 'male', '111', '2', 'a', 2, '2024-09-25'),
(4, 'user@gmail.com', 'user@gmail.com', '$2y$10$gSvyaJKLK61b0XXXMlIhxejF8v2pRpGO.LeLnylMfc4eHQmU6Uphm', 'male', '0', '1', '3', 23, '2024-09-25'),
(6, 'amol', 'amol@gmail.com', '$2y$10$CAMtqMYZ3PhC0zzojYgdSunPCHhMFs.7y9I6okSXrfTbaM7DM6e9W', 'male', '1212', 'sakinaka', 'student', 20, '2024-09-10');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` enum('income','expense') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `description`, `amount`, `type`) VALUES
(16, 'salary', 450.00, 'income'),
(17, 'travel', 90.00, 'expense');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone_number`, `password`) VALUES
(7, 'pradnya', 'pradnya@gmail.com', '3216549870', '$2y$10$CENqjHmmM4QN5N6YFh2BWuW93UkrwPgNrXh0Z0uLMcKOqoF1MI2Ii');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conversions`
--
ALTER TABLE `conversions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conversions`
--
ALTER TABLE `conversions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
