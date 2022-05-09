-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 23, 2022 at 03:22 PM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magnum`
--

-- --------------------------------------------------------

--
-- Table structure for table `Administrators`
--

CREATE TABLE `Administrators` (
  `ID` int NOT NULL,
  `firstName` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastName` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Flags`
--

CREATE TABLE `Flags` (
  `ID` int NOT NULL,
  `flaggedID` int DEFAULT NULL,
  `offense` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_general_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `flaggerID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `History`
--

CREATE TABLE `History` (
  `ID` int NOT NULL,
  `userID` int DEFAULT NULL,
  `activity` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Podcasters`
--

CREATE TABLE `Podcasters` (
  `ID` int NOT NULL,
  `firstName` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'This attribute can be used as the name of the podcast and not necessarily that of the account holder.',
  `lastName` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'This attribute can be used as the name of the podcast and not necessarily that of the account holder.',
  `biography` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'A short and sweet paragraph that tells users a little bit about the podcaster.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Tokens`
--

CREATE TABLE `Tokens` (
  `ID` int NOT NULL,
  `userID` int DEFAULT NULL,
  `token` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `consumed` tinyint(1) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `ID` int NOT NULL,
  `username` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(72) COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'The name and extension of the image file that represents the avatar of the user, e.g. "grtcdr.png"',
  `status` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtype` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Administrators`
--
ALTER TABLE `Administrators`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Flags`
--
ALTER TABLE `Flags`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_userID_flags` (`flaggedID`),
  ADD KEY `fk_flaggerID_flags` (`flaggerID`);

--
-- Indexes for table `History`
--
ALTER TABLE `History`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_userID_hist` (`userID`);

--
-- Indexes for table `Podcasters`
--
ALTER TABLE `Podcasters`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Tokens`
--
ALTER TABLE `Tokens`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_userID_tokens` (`userID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UNIQ_D5428AEDF85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_D5428AEDE7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Flags`
--
ALTER TABLE `Flags`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `History`
--
ALTER TABLE `History`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Tokens`
--
ALTER TABLE `Tokens`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Administrators`
--
ALTER TABLE `Administrators`
  ADD CONSTRAINT `FK_CA5E09B711D3633A` FOREIGN KEY (`ID`) REFERENCES `Users` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `Flags`
--
ALTER TABLE `Flags`
  ADD CONSTRAINT `FK_CAC46EBE4E3A9F92` FOREIGN KEY (`flaggedID`) REFERENCES `Users` (`ID`),
  ADD CONSTRAINT `FK_CAC46EBE56914050` FOREIGN KEY (`flaggerID`) REFERENCES `Users` (`ID`);

--
-- Constraints for table `History`
--
ALTER TABLE `History`
  ADD CONSTRAINT `FK_E80749D75FD86D04` FOREIGN KEY (`userID`) REFERENCES `Users` (`ID`);

--
-- Constraints for table `Podcasters`
--
ALTER TABLE `Podcasters`
  ADD CONSTRAINT `FK_34251B6011D3633A` FOREIGN KEY (`ID`) REFERENCES `Users` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `Tokens`
--
ALTER TABLE `Tokens`
  ADD CONSTRAINT `FK_ADF614B85FD86D04` FOREIGN KEY (`userID`) REFERENCES `Users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
