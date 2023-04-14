-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2023 at 02:42 PM
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
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `aid` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `body` text NOT NULL,
  `photo` varchar(512) NOT NULL,
  `post_date` date NOT NULL DEFAULT current_timestamp(),
  `uid` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `gname` varchar(30) NOT NULL,
  `gid` int(11) NOT NULL,
  `description` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`gname`, `gid`, `description`, `avatar`, `deleted_at`) VALUES
('editor', 1, 'can edit', 'medicine.PNG', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `remember_tokens`
--

CREATE TABLE `remember_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expire` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `uname` varchar(30) NOT NULL,
  `gid` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
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
(8, 'admin', 1, 'r@yahoo.com', '$2y$10$HUCH8KtNUFskOR/iDu', '01281950623', '', NULL, NULL),
(9, 'mira', 1, 'mira@gmail.com', '$2y$10$VIWKEcGQFFkAN34P5dBw9.Rw5hLHfj9cAgMfJ5xypiExZl.TRcBFK', '01281950623', 'medicine.PNG', NULL, NULL),
(10, 'luna', 1, 'luna@gmail.com', '$2y$10$rCMs4ICz6CBBe6tBilQk6evRvhfbpU2Z2RZEnXQ7TY8EtpX51gvGy', '321323', '', NULL, '2023-04-14 11:11:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`aid`),
  ADD KEY `foriegn key` (`uid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `foriegn key` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `foreign key` FOREIGN KEY (`gid`) REFERENCES `groups` (`gid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
