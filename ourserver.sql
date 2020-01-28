-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 28, 2020 at 05:26 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ourserver`
--

-- --------------------------------------------------------

--
-- Table structure for table `DriverInformation`
--

CREATE TABLE `DriverInformation` (
  `uid` int(10) NOT NULL,
  `Driver_ID` varchar(256) NOT NULL,
  `Date` date NOT NULL,
  `Driver_Name` varchar(256) NOT NULL,
  `Driver_Status` varchar(256) NOT NULL DEFAULT 'Not Disbursed',
  `Total_Amount` int(10) NOT NULL,
  `Collectibles` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `DriverInformation`
--

INSERT INTO `DriverInformation` (`uid`, `Driver_ID`, `Date`, `Driver_Name`, `Driver_Status`, `Total_Amount`, `Collectibles`) VALUES
(1, '12', '2020-01-18', 'Kenje', 'Disbursed', 1100, 10),
(2, '12', '2020-01-19', 'Kenje', 'Disbursed', 1300, 30),
(3, '13', '2020-01-18', 'Gian', 'Not Disbursed', 1205, 50),
(4, '13', '2020-01-19', 'Gian', 'Not Disbursed', 1400, 20),
(5, '14', '2020-01-18', 'Jon', 'Not Disbursed', 1200, 60),
(6, '14', '2020-01-19', 'Jon', 'Not Disbursed', 1500, 30),
(7, '15', '2020-01-18', 'Francis', 'Not Disbursed', 1600, 10),
(8, '15', '2020-01-19', 'Francis', 'Not Disbursed', 900, 10),
(9, '16', '2020-01-18', 'Christian', 'Not Disbursed', 1500, 60),
(10, '16', '2020-01-19', 'Christian', 'Disbursed', 1600, 70),
(11, '12', '2020-01-20', 'Kenje', 'Disbursed', 1100, 70),
(12, '12', '2020-01-21', 'Kenje', 'Disbursed', 1900, 50),
(13, '13', '2020-01-20', 'Gian', 'Disbursed', 1900, 20),
(14, '13', '2020-01-21', 'Gian', 'Not Disbursed', 1200, 10),
(15, '13', '2020-01-22', 'Gian', 'Not Disbursed', 1100, 50),
(16, '13', '2020-01-23', 'Gian', 'Not Disbursed', 600, 5),
(17, '13', '2020-01-24', 'Gian', 'Not Disbursed', 1900, 0),
(18, '13', '2020-01-25', 'Gian', 'Not Disbursed', 1200, 10),
(19, '13', '2020-01-26', 'Gian', 'Not Disbursed', 1400, 40),
(20, '13', '2020-01-27', 'Gian', 'Not Disbursed', 2000, 10),
(21, '13', '2020-01-28', 'Gian', 'Not Disbursed', 1500, 30),
(22, '13', '2020-01-29', 'Gian', 'Not Disbursed', 1200, 80),
(23, '13', '2020-01-30', 'Gian', 'Not Disbursed', 1560, 35),
(24, '13', '2020-01-31', 'Gian', 'Not Disbursed', 1770, 90),
(25, '13', '2020-02-01', 'Gian', 'Disbursed', 1340, 50),
(26, '13', '2020-02-02', 'Gian', 'Disbursed', 1850, 75),
(27, '13', '2020-02-03', 'Gian', 'Disbursed', 1250, 80),
(28, '13', '2020-02-04', 'Gian', 'Disbursed', 900, 0);

-- --------------------------------------------------------

--
-- Table structure for table `DriverReceipts`
--

CREATE TABLE `DriverReceipts` (
  `Disburse_Date` varchar(256) NOT NULL,
  `Date` varchar(256) NOT NULL,
  `Time` varchar(256) NOT NULL,
  `Receipt_Num` int(255) NOT NULL,
  `Bursar_Officer` varchar(256) NOT NULL,
  `Shuttle_Disbursement` int(255) NOT NULL,
  `Driver_ID` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `DriverReceipts`
--

INSERT INTO `DriverReceipts` (`Disburse_Date`, `Date`, `Time`, `Receipt_Num`, `Bursar_Officer`, `Shuttle_Disbursement`, `Driver_ID`) VALUES
('2020-01-26', '2020-01-18', '11:31:38PM', 274, 'Patalinghug,Bryle', 1100, '12'),
('2020-01-26', '2020-01-20', '11:31:50PM', 275, 'Patalinghug,Bryle', 1900, '13'),
('2020-01-26', '2020-01-19', '11:54:28PM', 276, 'Patalinghug,Bryle', 1300, '12'),
('2020-01-27', '2020-01-20', '12:20:19AM', 277, 'Patalinghug,Bryle', 1100, '12'),
('2020-01-27', '2020-01-21', '12:22:08AM', 278, 'Sabuero,Daisy', 1900, '12'),
('2020-01-27', '2020-02-04', '12:25:30AM', 279, 'Sabuero,Daisy', 900, '13'),
('2020-01-27', '2020-02-02', '12:25:50AM', 280, 'Sabuero,Daisy', 1850, '13'),
('2020-01-27', '2020-02-03', '12:36:24AM', 281, 'Sabuero,Daisy', 1250, '13'),
('2020-01-27', '2020-02-01', '12:37:40AM', 282, 'Patalinghug,Bryle', 1340, '13'),
('2020-01-27', '2020-01-19', '03:21:50PM', 283, 'Patalinghug,Bryle', 1600, '16');

-- --------------------------------------------------------

--
-- Table structure for table `Driver_Accounts`
--

CREATE TABLE `Driver_Accounts` (
  `Driver_ID` varchar(255) NOT NULL,
  `Fname` varchar(255) NOT NULL,
  `Lname` varchar(255) NOT NULL,
  `RFID_UID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Driver_Accounts`
--

INSERT INTO `Driver_Accounts` (`Driver_ID`, `Fname`, `Lname`, `RFID_UID`) VALUES
('13', 'Gian', 'Lim', '00087a4d90f580e38a71dbda7a8d0717'),
('12', 'Kenje', 'Hofilena', '6bb8182979cc4fd85cb4329786259d60'),
('15', 'Francis', 'Manubag', '74e74bb6fffb97140ad83d4f11356f33'),
('16', 'Christian', 'Diez', 'a3211bf3b462ef147d80ae01a574b14b'),
('20', 'Gavin', 'Free', 'cff46687495b57fc31611ffd45777595'),
('14', 'Jon', 'Tillo', 'e8df4757fa4cb5f47a390c3ffae18370');

-- --------------------------------------------------------

--
-- Table structure for table `PassengerTransactions`
--

CREATE TABLE `PassengerTransactions` (
  `uid` int(255) NOT NULL,
  `Date_Time` datetime NOT NULL DEFAULT current_timestamp(),
  `Passenger_ID` varchar(256) NOT NULL,
  `Amount` int(10) NOT NULL DEFAULT 5,
  `Driver_ID` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `PassengerTransactions`
--

INSERT INTO `PassengerTransactions` (`uid`, `Date_Time`, `Passenger_ID`, `Amount`, `Driver_ID`) VALUES
(1, '2020-01-19 03:33:58', '15102066', 5, '12'),
(2, '2020-01-19 03:33:58', '15102061', 5, '12'),
(3, '2020-01-19 03:51:36', '15102066', 5, '12'),
(4, '2020-01-19 03:54:04', '15102066', 5, '12'),
(5, '2020-01-19 04:04:37', '1234512', 5, '13'),
(6, '2020-01-19 04:04:41', '1234512', 5, '13'),
(7, '2020-01-19 04:04:46', '1234512', 5, '13'),
(8, '2020-01-19 04:04:49', '1234512', 5, '13'),
(9, '2020-01-19 04:04:55', '1234512', 5, '13'),
(10, '2020-01-19 04:04:59', '1234512', 5, '13'),
(11, '2020-01-19 04:07:11', '13123', 5, '13'),
(12, '2020-01-19 04:07:21', '13123', 5, '13'),
(13, '2020-01-19 04:07:25', '13123', 5, '13'),
(14, '2020-01-19 04:08:23', '1244', 5, '13'),
(15, '2020-01-19 04:08:23', '1242', 5, '13'),
(16, '2020-01-19 04:08:52', '1244', 5, '13'),
(17, '2020-01-19 04:08:52', '1242', 5, '13'),
(18, '2020-01-19 04:08:52', '1244', 5, '13'),
(19, '2020-01-19 04:08:52', '1242', 5, '13'),
(20, '2020-01-19 04:08:52', '1244', 5, '13'),
(21, '2020-01-19 04:08:52', '1242', 5, '13'),
(22, '2020-01-19 04:08:52', '1244', 5, '13'),
(23, '2020-01-19 04:08:52', '1242', 5, '13'),
(24, '2020-01-19 04:08:52', '1244', 5, '13'),
(25, '2020-01-19 04:08:52', '1242', 5, '13'),
(26, '2020-01-19 04:08:52', '1244', 5, '13'),
(27, '2020-01-19 04:08:52', '1242', 5, '13'),
(28, '2020-01-19 04:10:34', '1244', 5, '13'),
(29, '2020-01-19 04:10:34', '1242', 5, '13'),
(30, '2020-01-19 04:10:34', '1244', 5, '13'),
(31, '2020-01-19 04:10:34', '1242', 5, '13'),
(32, '2020-01-19 04:10:34', '1244', 5, '13'),
(33, '2020-01-19 04:10:34', '1242', 5, '13');

-- --------------------------------------------------------

--
-- Table structure for table `User_Accounts`
--

CREATE TABLE `User_Accounts` (
  `FName` varchar(256) NOT NULL,
  `LName` varchar(256) NOT NULL,
  `IDNum` varchar(256) NOT NULL,
  `Password` varchar(256) NOT NULL,
  `UserType` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User_Accounts`
--

INSERT INTO `User_Accounts` (`FName`, `LName`, `IDNum`, `Password`, `UserType`) VALUES
('Super', 'Admin', '1', '$2y$10$7p7fJwzpc4nXsfPcaDavmucNqF2TSgSmJHtZYH1CYRU41rDXbAP6W', 'Admin'),
('Daisy', 'Sabuero', '15101819', '$2y$10$XGZwzGYS3MJCkmU8OTQRFuIEeeXpq2XQI0MCU3h5ks2jfGj646.zm', 'User'),
('Bryle', 'Patalinghug', '15101869', '$2y$10$lL9H2zVsLszomHBQJ30xHuhAPQMLsmdhTGvVquTUdiIcuK5c.Sg62', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `DriverInformation`
--
ALTER TABLE `DriverInformation`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `DriverReceipts`
--
ALTER TABLE `DriverReceipts`
  ADD UNIQUE KEY `Receipt_Num` (`Receipt_Num`);

--
-- Indexes for table `Driver_Accounts`
--
ALTER TABLE `Driver_Accounts`
  ADD PRIMARY KEY (`RFID_UID`),
  ADD UNIQUE KEY `Driver_ID` (`Driver_ID`);

--
-- Indexes for table `PassengerTransactions`
--
ALTER TABLE `PassengerTransactions`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `User_Accounts`
--
ALTER TABLE `User_Accounts`
  ADD PRIMARY KEY (`IDNum`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `DriverInformation`
--
ALTER TABLE `DriverInformation`
  MODIFY `uid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `DriverReceipts`
--
ALTER TABLE `DriverReceipts`
  MODIFY `Receipt_Num` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT for table `PassengerTransactions`
--
ALTER TABLE `PassengerTransactions`
  MODIFY `uid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
