-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 29, 2023 at 04:27 PM
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
  `rating` int NOT NULL,
  `installs` int NOT NULL,
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `app_detail`
--

INSERT INTO `app_detail` (`id_app`, `app_name`, `genre`, `rating`, `installs`, `price`) VALUES
(2, 'GTA V', 'RPG', 50, 450000, 90000),
(5, 'Arma III', 'Simulation', 40, 2000000, 250000),
(6, 'GTA IV', 'RPG', 45, 1800000, 150000),
(7, 'Gundam Evolution', 'FPS', 25, 800000, 50000),
(9, 'Assassin Creed II', 'Simulation', 45, 5000000, 140000),
(10, 'Stardew Valley', 'Simulation', 44, 3000000, 135000),
(20, 'Medieval IV: Rise of Heroes', 'Strategy', 45, 1250000, 175000),
(21, 'GTA Online', 'RPG', 44, 2650000, 145000),
(22, 'Medieval IV', 'Strategy', 45, 1500000, 150000);

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
(2, 1),
(2, 2),
(5, 1),
(6, 1),
(6, 2),
(7, 1),
(9, 1),
(20, 1),
(21, 1),
(21, 2),
(22, 1);

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
  `role_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_user`, `role_user`) VALUES
(1, 'admin', 'admin', 'admin', 'admin'),
(2, 'bagusws', 'bagus123', 'bagusw', 'user'),
(9, 'abdannf', 'violetjelek', 'abdannf', 'user'),
(10, 'jamalinux', 'jamal', 'Jamal', 'user'),
(11, 'jehianth', '6969', 'Jeh', 'user'),
(12, 'mazuk', '6969', 'Fynn', 'user'),
(13, 'Jono', '6969', 'Jono', 'user'),
(14, 'rafi', '1234', 'rafi', 'user'),
(15, 'bagus', '123', 'bagusws', 'user');

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
(5, 13, '2023-11-28'),
(2, 2, '2023-11-28'),
(6, 2, '2023-11-28'),
(10, 10, '2023-11-28'),
(20, 10, '2023-11-28'),
(5, 10, '2023-11-29'),
(9, 14, '2023-11-29'),
(2, 14, '2023-11-29'),
(22, 10, '2023-11-29');

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
  ADD KEY `id_appTOid_platform` (`id_app`),
  ADD KEY `id_platform` (`id_platform`);

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
  ADD KEY `id_app` (`id_app`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_detail`
--
ALTER TABLE `app_detail`
  MODIFY `id_app` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `platform`
--
ALTER TABLE `platform`
  MODIFY `id_platform` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_platform`
--
ALTER TABLE `app_platform`
  ADD CONSTRAINT `id_appTOid_platform` FOREIGN KEY (`id_app`) REFERENCES `app_detail` (`id_app`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `id_platform` FOREIGN KEY (`id_platform`) REFERENCES `platform` (`id_platform`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `user_favorite`
--
ALTER TABLE `user_favorite`
  ADD CONSTRAINT `id_app` FOREIGN KEY (`id_app`) REFERENCES `app_detail` (`id_app`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
