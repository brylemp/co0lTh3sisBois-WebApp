-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2020 at 06:04 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

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
-- Table structure for table `driverAccountsSyncStatus`
--

CREATE TABLE `driverAccountsSyncStatus` (
  `id` int(255) NOT NULL,
  `Last_Update` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `driverAccountsSyncStatus`
--

INSERT INTO `driverAccountsSyncStatus` (`id`, `Last_Update`) VALUES
(1, '2020-03-08 21:16:35');

-- --------------------------------------------------------

--
-- Table structure for table `DriverInformation`
--

CREATE TABLE `DriverInformation` (
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

INSERT INTO `DriverInformation` (`Driver_ID`, `Date`, `Driver_Name`, `Driver_Status`, `Total_Amount`, `Collectibles`) VALUES
('12', '2020-01-18', 'Jonathan Joestar', 'Disbursed', 1100, 10),
('12', '2020-01-19', 'Jonathan Joestar', 'Disbursed', 1300, 30),
('13', '2020-01-18', 'Joseph Joestar', 'Not Disbursed', 1205, 50),
('13', '2020-01-19', 'Joseph Joestar', 'Not Disbursed', 1400, 20),
('14', '2020-01-18', 'Jotaro Kujo', 'Not Disbursed', 1200, 60),
('14', '2020-01-19', 'Jotaro Kujo', 'Disbursed', 1500, 30),
('15', '2020-01-18', 'Giorno Giovanna', 'Not Disbursed', 1600, 10),
('15', '2020-01-19', 'Giorno Giovanna', 'Not Disbursed', 900, 10),
('16', '2020-01-18', 'Christian', 'Not Disbursed', 1500, 60),
('16', '2020-01-19', 'Christian', 'Disbursed', 1600, 70),
('12', '2020-01-20', 'Jonathan Joestar', 'Disbursed', 1100, 70),
('12', '2020-01-21', 'Jonathan Joestar', 'Disbursed', 1900, 50),
('13', '2020-01-20', 'Joseph Joestar', 'Disbursed', 1900, 20),
('13', '2020-01-21', 'Joseph Joestar', 'Not Disbursed', 1200, 10),
('13', '2020-01-22', 'Joseph Joestar', 'Not Disbursed', 1100, 50),
('13', '2020-01-23', 'Joseph Joestar', 'Not Disbursed', 600, 5),
('13', '2020-01-24', 'Joseph Joestar', 'Not Disbursed', 1900, 0),
('13', '2020-01-25', 'Joseph Joestar', 'Not Disbursed', 1200, 10),
('13', '2020-01-26', 'Joseph Joestar', 'Not Disbursed', 1400, 40),
('13', '2020-01-27', 'Joseph Joestar', 'Not Disbursed', 2000, 10),
('13', '2020-01-28', 'Joseph Joestar', 'Not Disbursed', 1500, 30),
('13', '2020-01-29', 'Joseph Joestar', 'Not Disbursed', 1200, 80),
('13', '2020-01-30', 'Joseph Joestar', 'Disbursed', 1560, 35),
('13', '2020-01-31', 'Joseph Joestar', 'Disbursed', 1770, 90),
('13', '2020-02-01', 'Joseph Joestar', 'Disbursed', 1340, 50),
('13', '2020-02-02', 'Joseph Joestar', 'Disbursed', 1850, 75),
('13', '2020-02-03', 'Joseph Joestar', 'Disbursed', 1250, 80),
('13', '2020-02-04', 'Joseph Joestar', 'Disbursed', 900, 0),
('12', '2020-01-09', 'Jonathan Joestar', 'Not Disbursed', 10, 5);

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
('2020-01-27', '2020-01-19', '03:21:50PM', 283, 'Patalinghug,Bryle', 1600, '16'),
('2020-02-22', '2020-01-19', '04:48:04PM', 284, 'Patalinghug,Bryle', 1500, '14'),
('2020-03-5', '2020-01-30', '10:52:07PM', 285, 'Hofilena,Kenje', 1560, '13'),
('2020-03-5', '2020-01-30', '10:52:12PM', 286, 'Hofilena,Kenje', 1560, '13'),
('2020-03-5', '2020-01-30', '10:52:26PM', 287, 'Hofilena,Kenje', 1560, '13'),
('2020-03-5', '2020-01-30', '10:52:45PM', 288, 'Hofilena,Kenje', 1560, '13'),
('2020-03-5', '2020-01-30', '10:52:53PM', 289, 'Hofilena,Kenje', 1560, '13'),
('2020-03-6', '2020-01-31', '02:08:13PM', 290, 'Admin,Super', 1770, '13');

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
('13', 'Joseph', 'Joestar', '2538106432'),
('12', 'Jonathan', 'Joestar', '2009161532'),
('15', 'Giorno', 'Giovanna', '723944737'),
('16', 'Christian', 'Diez', 'a3211bf3b462ef147d80ae01a574b14b'),
('20', 'Gavin', 'Free', 'cff46687495b57fc31611ffd45777595'),
('14', 'Jotaro', 'Kujo', '2012879419');

-- --------------------------------------------------------

--
-- Table structure for table `PassengerTransactions`
--

CREATE TABLE `PassengerTransactions` (
  `uid` varchar(255) NOT NULL DEFAULT '',
  `Date_Time` datetime NOT NULL,
  `Passenger_ID` varchar(256) NOT NULL,
  `Amount` int(255) NOT NULL DEFAULT '5',
  `Driver_ID` varchar(256) NOT NULL,
  `CollectibleStatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `PassengerTransactions`
--

INSERT INTO `PassengerTransactions` (`uid`, `Date_Time`, `Passenger_ID`, `Amount`, `Driver_ID`, `CollectibleStatus`) VALUES
('1', '2020-01-19 03:33:58', '15102066', 5, '12', 0),
('2', '2020-01-19 03:33:58', '15102061', 5, '12', 0),
('3', '2020-01-19 03:51:36', '15102066', 5, '12', 0),
('4', '2020-01-19 03:54:04', '15102066', 5, '12', 0),
('5', '2020-01-19 04:04:37', '1234512', 5, '13', 0),
('6', '2020-01-19 04:04:41', '1234512', 5, '13', 0),
('7', '2020-01-19 04:04:46', '1234512', 5, '13', 0),
('8', '2020-01-19 04:04:49', '1234512', 5, '13', 0),
('9', '2020-01-19 04:04:55', '1234512', 5, '13', 0),
('10', '2020-01-19 04:04:59', '1234512', 5, '13', 0),
('11', '2020-01-19 04:07:11', '13123', 5, '13', 0),
('12', '2020-01-19 04:07:21', '13123', 5, '13', 0),
('13', '2020-01-19 04:07:25', '13123', 5, '13', 0),
('14', '2020-01-19 04:08:23', '1244', 5, '13', 0),
('15', '2020-01-19 04:08:23', '1242', 5, '13', 0),
('16', '2020-01-19 04:08:52', '1244', 5, '13', 0),
('17', '2020-01-19 04:08:52', '1242', 5, '13', 0),
('18', '2020-01-19 04:08:52', '1244', 5, '13', 0),
('19', '2020-01-19 04:08:52', '1242', 5, '13', 0),
('20', '2020-01-19 04:08:52', '1244', 5, '13', 0),
('21', '2020-01-19 04:08:52', '1242', 5, '13', 0),
('22', '2020-01-19 04:08:52', '1244', 5, '13', 0),
('23', '2020-01-19 04:08:52', '1242', 5, '13', 0),
('24', '2020-01-19 04:08:52', '1244', 5, '13', 0),
('25', '2020-01-19 04:08:52', '1242', 5, '13', 0),
('26', '2020-01-19 04:08:52', '1244', 5, '13', 0),
('27', '2020-01-19 04:08:52', '1242', 5, '13', 0),
('28', '2020-01-19 04:10:34', '1244', 5, '13', 0),
('29', '2020-01-19 04:10:34', '1242', 5, '13', 0),
('30', '2020-01-19 04:10:34', '1244', 5, '13', 0),
('31', '2020-01-19 04:10:34', '1242', 5, '13', 0),
('32', '2020-01-19 04:10:34', '1244', 5, '13', 0),
('33', '2020-01-19 04:10:34', '1242', 5, '13', 0);

-- --------------------------------------------------------

--
-- Table structure for table `User_Accounts`
--

CREATE TABLE `User_Accounts` (
  `FName` varchar(256) NOT NULL,
  `LName` varchar(256) NOT NULL,
  `IDNum` varchar(256) NOT NULL,
  `UName` varchar(255) NOT NULL,
  `Password` varchar(256) NOT NULL,
  `UserType` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User_Accounts`
--

INSERT INTO `User_Accounts` (`FName`, `LName`, `IDNum`, `UName`, `Password`, `UserType`) VALUES
('Super', 'Admin', '1', 'superadmin', '$2y$10$7p7fJwzpc4nXsfPcaDavmucNqF2TSgSmJHtZYH1CYRU41rDXbAP6W', 'Admin'),
('Bryle', 'Patalinghug', '15101869', 'brylemp', '$2y$10$rEtR2fZtC5QC5LOs4u2EA.c6PPUPGCOwAbyO1ipwbPt6Mp3P1EWKO', 'Admin'),
('Kenje', 'Hofilena', '15106042', 'Kenje', '$2y$10$sVtaiYWWzCDQfENYXpjrGedLhF8FItqx9xWgfsWCwr6JQaRy0vVG2', 'Admin'),
('OneTwo', 'Three', '321456', '123', '$2y$10$ggOFXeYCtP/5bhsCjgEdU.4mTyAaKy8rqHM/q4da/CLVuyZD9H47i', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `DriverReceipts`
--
ALTER TABLE `DriverReceipts`
  ADD UNIQUE KEY `Receipt_Num` (`Receipt_Num`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
