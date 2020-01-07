-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2019 at 03:11 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memeio`
--
CREATE DATABASE IF NOT EXISTS `memeio` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `memeio`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Id` int(11) NOT NULL,
  `ownerId` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `description` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `Id` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `parentId` int(11) DEFAULT NULL,
  `creatorId` int(11) NOT NULL,
  `uploadDate` datetime NOT NULL DEFAULT current_timestamp(),
  `title` varchar(100) NOT NULL,
  `text` varchar(1024) DEFAULT NULL,
  `fileName` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `PostId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `UserId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `passwordHash` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_Category_Owner` (`ownerId`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_Post_Creator` (`creatorId`),
  ADD KEY `FK_Post_Category` (`categoryId`),
  ADD KEY `FK_Post_Comment` (`parentId`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`PostId`,`UserId`),
  ADD KEY `FK_Rating_User` (`UserId`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`UserId`,`CategoryId`),
  ADD KEY `FK_Subscription_Category` (`CategoryId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `FK_Category_Owner` FOREIGN KEY (`ownerId`) REFERENCES `user` (`Id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_Post_Category` FOREIGN KEY (`categoryId`) REFERENCES `category` (`Id`),
  ADD CONSTRAINT `FK_Post_Comment` FOREIGN KEY (`parentId`) REFERENCES `post` (`Id`),
  ADD CONSTRAINT `FK_Post_Creator` FOREIGN KEY (`creatorId`) REFERENCES `user` (`Id`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `FK_Rating_Post` FOREIGN KEY (`PostId`) REFERENCES `post` (`Id`),
  ADD CONSTRAINT `FK_Rating_User` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`);

--
-- Constraints for table `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `FK_Subscription_Category` FOREIGN KEY (`CategoryId`) REFERENCES `category` (`Id`),
  ADD CONSTRAINT `FK_Subscription_User` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
