-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 03:55 PM
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
-- Database: `fakedata`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courseID` int(11) NOT NULL,
  `courseName` varchar(100) NOT NULL,
  `courseDescription` text DEFAULT NULL,
  `courseDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `userID` int(11) DEFAULT NULL,
  `coursePrice` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`courseID`, `courseName`, `courseDescription`, `courseDate`, `userID`, `coursePrice`) VALUES
(1, 'Descriptive Analysis', 'Learn methods for summarizing and visualizing data.', '2025-04-29 15:25:56', NULL, 1499.99),
(2, 'Inferential Statistics', 'Learn methods for summarizing and visualizing data.', '2025-04-29 15:25:56', NULL, 999.00),
(3, 'Machine Learning', 'Learn methods for summarizing and visualizing data.', '2025-04-29 15:25:56', NULL, 1999.50),
(4, 'Big Data Analytics', 'Learn how to process and analyze massive datasets using modern tools.', '2025-04-29 15:30:56', NULL, 1499.99),
(5, 'Natural Language Processing', 'Learn techniques for processing and analyzing text data using NLP frameworks.', '2025-04-29 15:30:56', NULL, 999.00),
(6, 'Cloud Computing for Data', 'Explore cloud platforms for scalable data storage and processing.', '2025-04-29 15:30:56', NULL, 1999.50),
(7, 'Data Cleaning', 'Master techniques for handling missing, inconsistent, or inaccurate data.', '2025-04-29 15:30:56', NULL, 1499.99),
(8, 'Data Visualization', 'Use tools to create compelling visual representations of data.', '2025-04-29 15:30:56', NULL, 999.00),
(9, 'Regression Analysis', 'Understand and apply linear and logistic regression models.', '2025-04-29 15:30:56', NULL, 1999.50),
(10, 'Python for Data Science', 'Learn Python programming tailored for data analysis and machine learning.', '2025-04-29 15:30:56', NULL, 1499.99),
(11, 'Time Series Analysis', 'Explore techniques for analyzing data that changes over time.', '2025-04-29 15:30:56', NULL, 999.00),
(12, 'Neural Networks', 'Understand the basics of deep learning and how neural networks work.', '2025-04-29 15:30:56', NULL, 1999.50);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollmentID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `courseID` int(11) DEFAULT NULL,
  `enrollmentDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollmentID`, `userID`, `courseID`, `enrollmentDate`) VALUES
(9, 1, 11, '2025-05-10 20:25:51'),
(10, 1, 2, '2025-05-10 20:32:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `keyName` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `keyPass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `keyName`, `email`, `keyPass`) VALUES
(1, 'Jefferson', 'Samson', 'jefferson', 'jeffersonsamson@gmail.com', '$2y$10$MFyqW0kzSC5nEie9gC9sa.Ek8AsRlH3FGTJS0PLTr15MVrkzFPlwC'),
(2, 'Gil', 'Tuazon', 'gil12345', 'giltuazon@gmail.com', '$2y$10$7si32u1fTmo0sqD7Os5Y4e8e5ovcMPRldb3q.cLrCh.w9n/Bmjrfu'),
(3, 'karl', 'palomo', 'karlito', 'karlpalomo@gmail.com', '$2y$10$J3ZcFFQR0TanrmVaAFS8deHgmcR.igvCiAxKX24raVF7eBRdfZZDa'),
(4, 'juan', 'dot com', 'juandotcom', 'abcdefg@gmail.com', '$2y$10$H9LxMMCmrmdrec8Fg.LfNuUzYGDCRdAt7QHqqnIwrN1Qr7zvfxNJK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`courseID`),
  ADD KEY `forUsers` (`userID`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollmentID`),
  ADD UNIQUE KEY `uq_user_course` (`userID`,`courseID`),
  ADD KEY `fk_enroll_course` (`courseID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `forUsers` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `fk_enroll_course` FOREIGN KEY (`courseID`) REFERENCES `courses` (`courseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enroll_user` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
