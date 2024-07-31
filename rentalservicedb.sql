-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2024 at 04:51 PM
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
-- Database: `rentalservicedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `CityID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `ProvinceID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`CityID`, `Name`, `ProvinceID`) VALUES
(1, 'Kalat', 3),
(2, 'Loralai', 3),
(3, 'Makran', 3),
(4, 'Naseerabad', 3),
(5, 'Quetta', 3),
(6, 'Rakhshan', 3),
(7, 'Sibi', 3),
(8, 'Zhob', 3),
(9, 'Bannu', 4),
(10, 'Dera Ismail Khan', 4),
(11, 'Hazara', 4),
(12, 'Kohat', 4),
(13, 'Malakand', 4),
(14, 'Mardan', 4),
(15, 'Peshawar', 4),
(16, 'Bahawalpur', 2),
(17, 'Dera Ghazi Khan', 2),
(18, 'Faisalabad', 2),
(19, 'Gujranwala', 2),
(20, 'Gujrat', 2),
(21, 'Lahore', 2),
(22, 'Mianwali', 2),
(23, 'Multan', 2),
(24, 'Rawalpindi', 2),
(25, 'Sahiwal', 2),
(26, 'Sargodha', 2),
(27, 'Hyderabad', 1),
(28, 'Karachi', 1),
(29, 'Larkana', 1),
(30, 'Mirpur Khas', 1),
(31, 'Shaheed Benazirabad', 1),
(32, 'Sukkur', 1);

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `FavoriteID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `PropertyID` int(11) DEFAULT NULL,
  `AddedDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `ImageID` int(11) NOT NULL,
  `PropertyID` int(11) DEFAULT NULL,
  `ImageURL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `MessageID` int(11) NOT NULL,
  `SenderID` int(11) DEFAULT NULL,
  `ReceiverID` int(11) DEFAULT NULL,
  `PropertyID` int(11) DEFAULT NULL,
  `MessageContent` text NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `PropertyID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `Rent` decimal(10,2) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `PropertyType` enum('House','Apartment','Commercial') NOT NULL,
  `Status` enum('Available','Rented') NOT NULL,
  `PostedDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserID` int(11) DEFAULT NULL,
  `CityID` int(11) DEFAULT NULL,
  `ZipCode` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `propertyfeatures`
--

CREATE TABLE `propertyfeatures` (
  `FeatureID` int(11) NOT NULL,
  `PropertyID` int(11) DEFAULT NULL,
  `FeatureName` varchar(255) NOT NULL,
  `FeatureValue` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `propertyviews`
--

CREATE TABLE `propertyviews` (
  `ViewID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `PropertyID` int(11) DEFAULT NULL,
  `ViewDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `ProvinceID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`ProvinceID`, `Name`) VALUES
(1, 'Sindh'),
(2, 'Punjab'),
(3, 'Balochistan'),
(4, 'Khyber Pakhtunkhwa');

-- --------------------------------------------------------

--
-- Table structure for table `rentalagreements`
--

CREATE TABLE `rentalagreements` (
  `AgreementID` int(11) NOT NULL,
  `PropertyID` int(11) DEFAULT NULL,
  `RenterID` int(11) DEFAULT NULL,
  `OwnerID` int(11) DEFAULT NULL,
  `AgreementDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `RentAmount` decimal(10,2) NOT NULL,
  `DurationMonths` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `PropertyID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL CHECK (`Rating` between 1 and 5),
  `ReviewContent` text DEFAULT NULL,
  `ReviewDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `ProfilePicture` varchar(255) DEFAULT NULL,
  `CNICNumber` varchar(15) NOT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `CNICExpiryDate` date DEFAULT NULL,
  `CNICFrontPicture` varchar(255) DEFAULT NULL,
  `CNICBackPicture` varchar(255) DEFAULT NULL,
  `DateJoined` timestamp NOT NULL DEFAULT current_timestamp(),
  `ProvinceID` int(11) DEFAULT NULL,
  `CityID` int(11) DEFAULT NULL,
  `ZipCode` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userverification`
--

CREATE TABLE `userverification` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Status` varchar(50) DEFAULT 'Not Verified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`CityID`),
  ADD KEY `ProvinceID` (`ProvinceID`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`FavoriteID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `PropertyID` (`PropertyID`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`ImageID`),
  ADD KEY `PropertyID` (`PropertyID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `SenderID` (`SenderID`),
  ADD KEY `ReceiverID` (`ReceiverID`),
  ADD KEY `PropertyID` (`PropertyID`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`PropertyID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `CityID` (`CityID`);

--
-- Indexes for table `propertyfeatures`
--
ALTER TABLE `propertyfeatures`
  ADD PRIMARY KEY (`FeatureID`),
  ADD KEY `PropertyID` (`PropertyID`);

--
-- Indexes for table `propertyviews`
--
ALTER TABLE `propertyviews`
  ADD PRIMARY KEY (`ViewID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `PropertyID` (`PropertyID`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`ProvinceID`);

--
-- Indexes for table `rentalagreements`
--
ALTER TABLE `rentalagreements`
  ADD PRIMARY KEY (`AgreementID`),
  ADD KEY `PropertyID` (`PropertyID`),
  ADD KEY `RenterID` (`RenterID`),
  ADD KEY `OwnerID` (`OwnerID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `PropertyID` (`PropertyID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `CNICNumber` (`CNICNumber`),
  ADD KEY `ProvinceID` (`ProvinceID`),
  ADD KEY `CityID` (`CityID`);

--
-- Indexes for table `userverification`
--
ALTER TABLE `userverification`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `CityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `FavoriteID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `ImageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `PropertyID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `propertyfeatures`
--
ALTER TABLE `propertyfeatures`
  MODIFY `FeatureID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `propertyviews`
--
ALTER TABLE `propertyviews`
  MODIFY `ViewID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `ProvinceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rentalagreements`
--
ALTER TABLE `rentalagreements`
  MODIFY `AgreementID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userverification`
--
ALTER TABLE `userverification`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`ProvinceID`) REFERENCES `provinces` (`ProvinceID`);

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`SenderID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`ReceiverID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`);

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `properties_ibfk_2` FOREIGN KEY (`CityID`) REFERENCES `cities` (`CityID`);

--
-- Constraints for table `propertyfeatures`
--
ALTER TABLE `propertyfeatures`
  ADD CONSTRAINT `propertyfeatures_ibfk_1` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`);

--
-- Constraints for table `propertyviews`
--
ALTER TABLE `propertyviews`
  ADD CONSTRAINT `propertyviews_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `propertyviews_ibfk_2` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`);

--
-- Constraints for table `rentalagreements`
--
ALTER TABLE `rentalagreements`
  ADD CONSTRAINT `rentalagreements_ibfk_1` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`),
  ADD CONSTRAINT `rentalagreements_ibfk_2` FOREIGN KEY (`RenterID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `rentalagreements_ibfk_3` FOREIGN KEY (`OwnerID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`ProvinceID`) REFERENCES `provinces` (`ProvinceID`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`CityID`) REFERENCES `cities` (`CityID`);

--
-- Constraints for table `userverification`
--
ALTER TABLE `userverification`
  ADD CONSTRAINT `userverification_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
