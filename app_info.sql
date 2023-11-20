-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 19, 2023 at 03:54 PM
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
-- Database: `app_info`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_detail`
--

CREATE TABLE `app_detail` (
  `id_app` int NOT NULL,
  `app_name` varchar(225) NOT NULL,
  `genre` varchar(225) NOT NULL,
  `rating` float NOT NULL,
  `installs` int NOT NULL,
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `app_detail`
--

INSERT INTO `app_detail` (`id_app`, `app_name`, `genre`, `rating`, `installs`, `price`) VALUES
(1, 'Counter Strike Global Offensive', 'FPS', 4.7, 145, 145);

-- --------------------------------------------------------

--
-- Table structure for table `app_platform`
--

CREATE TABLE `app_platform` (
  `id_app` int NOT NULL,
  `id_platform` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `app_platform`
--

INSERT INTO `app_platform` (`id_app`, `id_platform`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `platform`
--

CREATE TABLE `platform` (
  `id_platform` int NOT NULL,
  `platform_name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `platform`
--

INSERT INTO `platform` (`id_platform`, `platform_name`) VALUES
(1, 'Steam'),
(2, 'Epic');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `join_date` date NOT NULL,
  `role_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_user`, `join_date`, `role_user`) VALUES
(1, 'admin', 'admin', 'admin', '2023-11-18', 'admin'),
(2, 'bagusws', 'bagus123', 'bagusw', '2023-11-18', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_favorite`
--

CREATE TABLE `user_favorite` (
  `id_app` int NOT NULL,
  `id_user` int NOT NULL,
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_favorite`
--

INSERT INTO `user_favorite` (`id_app`, `id_user`, `date_added`) VALUES
(1, 2, '2023-11-18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_detail`
--
ALTER TABLE `app_detail`
  ADD PRIMARY KEY (`id_app`);

--
-- Indexes for table `app_platform`
--
ALTER TABLE `app_platform`
  ADD KEY `id_platform` (`id_platform`),
  ADD KEY `id_appTOid_platform` (`id_app`);

--
-- Indexes for table `platform`
--
ALTER TABLE `platform`
  ADD PRIMARY KEY (`id_platform`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_favorite`
--
ALTER TABLE `user_favorite`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_app` (`id_app`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_detail`
--
ALTER TABLE `app_detail`
  MODIFY `id_app` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `platform`
--
ALTER TABLE `platform`
  MODIFY `id_platform` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_platform`
--
ALTER TABLE `app_platform`
  ADD CONSTRAINT `id_appTOid_platform` FOREIGN KEY (`id_app`) REFERENCES `app_detail` (`id_app`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `id_platform` FOREIGN KEY (`id_platform`) REFERENCES `platform` (`id_platform`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_favorite`
--
ALTER TABLE `user_favorite`
  ADD CONSTRAINT `id_app` FOREIGN KEY (`id_app`) REFERENCES `app_detail` (`id_app`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
