-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2023 at 12:59 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin-panel`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `uname` varchar(30) NOT NULL,
  `gid` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `avatar` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `subscription_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `uname`, `gid`, `email`, `password`, `mobile`, `avatar`, `deleted_at`, `subscription_date`) VALUES
(2, 'radwa', 1, 'radwa@gmail.com', '$2y$10$PnBoboVoAsYyepVz2H', '01281950623', 'js.PNG', NULL, NULL),
(3, 'rima', 1, 'rima@gmail.com', '$2y$10$Z4tFqco1pHYFNTq/hQ', '01281950623', 'medicine.PNG', NULL, NULL),
(4, 'jaja', 1, 'radwanabil67@yahoo.com', '$2y$10$tdU9bU0jQv4L9Wogsa', '01289080180', '', NULL, NULL),
(5, 'blabla', 1, 'r@yahoo.com', '$2y$10$IDuKngY9arLhewWhGX', '232123', '', NULL, NULL),
(6, 'holaoao', 1, 'radwanabil67@yahoo.com', '$2y$10$mlXhr5.n3Ig4AJHkEc', '11122324', '', NULL, NULL),
(7, 'hdskjsh', 1, 'radwaismail444@gmail.com', '$2y$10$P19hMiTQNH3WhyRv6J', '123232', '', NULL, NULL),
(8, 'admin', 1, 'r@yahoo.com', '$2y$10$HUCH8KtNUFskOR/iDu', '01281950623', '', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `foreign key` (`gid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `foreign key` FOREIGN KEY (`gid`) REFERENCES `groups` (`gid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
