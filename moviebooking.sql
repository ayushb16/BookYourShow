-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2020 at 05:55 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moviebooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `LogID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `movie` varchar(60) NOT NULL,
  `total` varchar(20) NOT NULL,
  `DateBooked` date NOT NULL,
  `Seats` varchar(255) NOT NULL,
  `ShowDay` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`LogID`, `Username`, `movie`, `total`, `DateBooked`, `Seats`, `ShowDay`) VALUES
(190, 'AyushBo', 'War', 'Rs500', '2020-05-31', 'F3,E3', 'Monday'),
(191, 'AyushBo', 'Toy Story 4', 'Rs750', '2020-05-31', 'E4,E5,E6', 'Monday'),
(193, 'AyushBo', 'Terminator: Dark Fate', 'Rs750', '2020-05-31', 'C4,C5,C6', 'Monday'),
(197, 'Mark Swift', 'Terminator: Dark Fate', 'Rs1000', '2020-05-31', 'F2,F1,E1,E2', 'Monday'),
(198, 'Mark Swift', 'Toy Story 4', 'Rs500', '2020-05-31', 'E8,E9', 'Wednesday'),
(199, 'Mark Swift', 'Fast & Furious Presents: Hobbs & Shaw', 'Rs250', '2020-05-31', 'A5', 'Thursday'),
(200, 'Mark Swift', 'Avengers: Endgame', 'Rs750', '2020-05-31', 'D4,D5,D6', 'Sunday'),
(201, 'Mark Swift', 'Jumanji: The Next Level', 'Rs500', '2020-05-31', 'C5,C4', 'Saturday'),
(202, 'John Doe', 'Terminator: Dark Fate', 'Rs500', '2020-05-31', 'E8,E9', 'Monday'),
(203, 'John Doe', 'Toy Story 4', 'Rs500', '2020-05-31', 'A5,A4', 'Monday'),
(204, 'John Doe', 'Toy Story 4', 'Rs500', '2020-05-31', 'C4,C5', 'Wednesday'),
(205, 'John Doe', 'Joker', 'Rs500', '2020-05-31', 'F8,F9', 'Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `MemberID` int(255) NOT NULL,
  `Username` varchar(45) NOT NULL,
  `Email` varchar(59) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Phoneno` varchar(8) NOT NULL,
  `RegistrationDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`MemberID`, `Username`, `Email`, `Password`, `Phoneno`, `RegistrationDate`) VALUES
(28, 'admin', 'admin@bookyourshow.com', '$2y$10$5JoJ4fD4CyRfqqt2B/UHe.efkO4/wg44ejnbsuI8WtF0yQo2AvTDq', '', '2020-05-28'),
(39, 'AyushBo', 'ayushbojo16@gmail.com', '$2y$10$Uo5/7sbL1ILDboEPdv3Md.r1ZRoh3QU3s3re5h2GhICTk60BV36Yy', '', '2020-05-30'),
(61, 'Mark Swift', 'markswift1403@gmail.com', '$2y$10$NTUZy.bZsguG1QzeKU1OtuvPU2KHIo4xUD/OTHyzDhVcCt3NGNaJ.', '', '2020-05-31'),
(62, 'John Doe', 'johndoe@gmail.com', '$2y$10$htKBwbnaFJenk6b32IE2TeWVVemBl.UMBKC8PKD5lxYRtRojFat2a', '59231098', '2020-05-31');

-- --------------------------------------------------------

--
-- Table structure for table `seatsbooked`
--

CREATE TABLE `seatsbooked` (
  `LogID` int(11) NOT NULL,
  `Movie` varchar(230) NOT NULL,
  `Seats` varchar(255) NOT NULL,
  `DayBooked` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seatsbooked`
--

INSERT INTO `seatsbooked` (`LogID`, `Movie`, `Seats`, `DayBooked`) VALUES
(261, 'War', 'F3', 'Monday'),
(262, 'War', 'E3', 'Monday'),
(263, 'Toy Story 4', 'E4', 'Monday'),
(264, 'Toy Story 4', 'E5', 'Monday'),
(265, 'Toy Story 4', 'E6', 'Monday'),
(267, 'Terminator: Dark Fate', 'C4', 'Monday'),
(268, 'Terminator: Dark Fate', 'C5', 'Monday'),
(269, 'Terminator: Dark Fate', 'C6', 'Monday'),
(279, 'Terminator: Dark Fate', 'F2', 'Monday'),
(280, 'Terminator: Dark Fate', 'F1', 'Monday'),
(281, 'Terminator: Dark Fate', 'E1', 'Monday'),
(282, 'Terminator: Dark Fate', 'E2', 'Monday'),
(283, 'Toy Story 4', 'E8', 'Wednesday'),
(284, 'Toy Story 4', 'E9', 'Wednesday'),
(285, 'Fast & Furious Presents: Hobbs & Shaw', 'A5', 'Thursday'),
(286, 'Avengers: Endgame', 'D4', 'Sunday'),
(287, 'Avengers: Endgame', 'D5', 'Sunday'),
(288, 'Avengers: Endgame', 'D6', 'Sunday'),
(289, 'Jumanji: The Next Level', 'C5', 'Saturday'),
(290, 'Jumanji: The Next Level', 'C4', 'Saturday'),
(291, 'Terminator: Dark Fate', 'E8', 'Monday'),
(292, 'Terminator: Dark Fate', 'E9', 'Monday'),
(293, 'Toy Story 4', 'A5', 'Monday'),
(294, 'Toy Story 4', 'A4', 'Monday'),
(295, 'Toy Story 4', 'C4', 'Wednesday'),
(296, 'Toy Story 4', 'C5', 'Wednesday'),
(297, 'Joker', 'F8', 'Sunday'),
(298, 'Joker', 'F9', 'Sunday');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`LogID`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`MemberID`);

--
-- Indexes for table `seatsbooked`
--
ALTER TABLE `seatsbooked`
  ADD PRIMARY KEY (`LogID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `MemberID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `seatsbooked`
--
ALTER TABLE `seatsbooked`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
