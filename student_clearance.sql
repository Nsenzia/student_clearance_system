-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 11:26 PM
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
-- Database: `student_clearance`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(3) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `designation` varchar(25) NOT NULL,
  `fullname` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `status` varchar(10) NOT NULL,
  `photo` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `username`, `password`, `designation`, `fullname`, `email`, `status`, `photo`) VALUES
(4, 'admin', 'admin123', 'Admin', 'EKE, EMMANUEL EFA-EVAL', 'eva_2012@gmail.com', 'Inactive', 'uploads/default.jpg'),
(5, 'ngungu', '12345678', 'Admin', 'Ngungu Sichembe', 'senziasichembe515@gmail.com', 'Active', 'uploads/avatar_nick.png'),
(6, 'assistant_reg_e', 'password123', 'Assistant Registrar (Exam', 'John Doe', 'johndoe@example.com', 'Active', 'uploads/default.jpg'),
(7, 'assistant_reg_s', 'password123', 'Assistant Registrar (Stud', 'Jane Smith', 'janesmith@example.com', 'Active', 'uploads/default.jpg'),
(8, 'director_head', 'password123', 'Director/Head', 'Mark Johnson', 'markjohnson@example.com', 'Active', 'uploads/default.jpg'),
(9, 'librarian', 'password123', 'Librarian', 'Emily Davis', 'emilydavis@example.com', 'Active', 'uploads/default.jpg'),
(10, 'bursar', 'password123', 'Bursar', 'Robert Brown', 'robertbrown@example.com', 'Active', 'uploads/default.jpg'),
(11, 'deputy_reg_stud', 'password123', 'Deputy Registrar (Student', 'Nancy White', 'nancywhite@example.com', 'Active', 'uploads/default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `clearance_documents`
--

CREATE TABLE `clearance_documents` (
  `id` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `document_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clearance_requests`
--

CREATE TABLE `clearance_requests` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `requested_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clearance_requests`
--

INSERT INTO `clearance_requests` (`id`, `student_id`, `department`, `status`, `requested_at`) VALUES
(92, 2028101561, 'Request clearance from all departments', 'Approved', '2024-10-21 16:07:50');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) UNSIGNED NOT NULL,
  `student_id` int(11) UNSIGNED NOT NULL,
  `admin_id` int(11) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `student_id`, `admin_id`, `comment`, `created_at`) VALUES
(24, 20, 9, 'JJJJ', '2024-10-21 14:09:53');

-- --------------------------------------------------------

--
-- Table structure for table `fee`
--

CREATE TABLE `fee` (
  `ID` int(3) NOT NULL,
  `session` varchar(9) NOT NULL,
  `faculty` varchar(40) NOT NULL,
  `dept` varchar(40) NOT NULL,
  `amount` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee`
--

INSERT INTO `fee` (`ID`, `session`, `faculty`, `dept`, `amount`) VALUES
(14, '2020/2021', 'Science', 'Computer Science', '100000'),
(15, '2021/2022', 'Science', 'Computer Science', '9000');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `ID` int(4) NOT NULL,
  `feeID` varchar(25) NOT NULL,
  `studentID` varchar(25) NOT NULL,
  `amount` varchar(25) NOT NULL,
  `datepaid` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`ID`, `feeID`, `studentID`, `amount`, `datepaid`) VALUES
(24, '8FAC46R2579D', '8', '20000', '2024-08-17 13:24:57'),
(25, 'DEAR92C6734B', '8', '80000', '2024-08-17 13:25:09'),
(26, '542BE6DAC3RF', '9', '0', '2024-10-04 15:33:21'),
(27, 'FE76514D8C0R', '8', '500', '2024-10-09 09:36:02'),
(28, '5F7EC03486B1', '17', '0', '2024-10-10 13:21:45');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `ID` int(3) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `matric_no` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `session` varchar(10) NOT NULL,
  `faculty` varchar(30) NOT NULL,
  `dept` varchar(44) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `photo` varchar(400) NOT NULL,
  `is_assistant_registrar_exam_approved` int(3) NOT NULL,
  `is_assistant_registrar_stud_affairs_approved` int(3) NOT NULL,
  `is_director_head_approved` int(3) NOT NULL,
  `is_librarian_approved` int(3) NOT NULL,
  `is_bursar_approved` int(3) NOT NULL,
  `is_deputy_registrar_stud_affairs_approved` int(3) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`ID`, `fullname`, `matric_no`, `password`, `session`, `faculty`, `dept`, `phone`, `photo`, `is_assistant_registrar_exam_approved`, `is_assistant_registrar_stud_affairs_approved`, `is_director_head_approved`, `is_librarian_approved`, `is_bursar_approved`, `is_deputy_registrar_stud_affairs_approved`, `student_id`) VALUES
(8, 'Eke Emmanuel Efa-eval', '18/132010', '11111111', '2021/2022', 'Science', 'Computer Science', '08067361023', 'uploads/eva.jpeg', 0, 0, 0, 0, 0, 0, 0),
(9, 'ngungu', '2022101561', '1234', '2021/2022', 'Engineering', 'Computer Science', '0772363877', 'uploads/avatar_nick.png', 0, 0, 0, 0, 0, 0, 0),
(10, 'seniza', '1234567890', '1234', '2021/2022', 'Social Science', 'Computer Science', '123456', 'uploads/avatar_nick.png', 0, 0, 0, 0, 0, 0, 0),
(11, 'Natasha Sichembe ', '1234567899', '43hjn2', '2020/2021', 'Science', 'Electrical Engineering', '5363654', 'uploads/avatar_nick.png', 0, 0, 0, 0, 0, 0, 0),
(12, 'zin', '0987654321', '0op8jd', '2020/2021', 'Engineering', 'Computer Science', '1234575', 'uploads/avatar_nick.png', 0, 0, 0, 0, 0, 0, 0),
(13, 'sasa', '7637383822', '9judry', '2021/2022', 'Science', 'Computer Science', '33343343434', 'uploads/avatar_nick.png', 0, 0, 0, 0, 0, 0, 0),
(14, 'jojo', '9898989898', 'lobfra', '2020/2021', 'Science', 'Electrical Engineering', '3456765555', 'uploads/avatar_nick.png', 0, 0, 0, 0, 0, 0, 0),
(15, 'jojo', '2024101561', '1btlvr', '2020/2021', 'Select faculty', 'Select Department', '3456765555', 'uploads/avatar_nick.png', 0, 0, 0, 0, 0, 0, 0),
(16, 'lolo', '2023101561', 'njif9l', '2020/2021', 'Science', 'Business Management', '0987654321', 'uploads/avatar_nick.png', 0, 0, 0, 0, 0, 0, 0),
(17, 'di', '20206101561', '4uslny', '2020/2021', 'Science', 'Business Management', '2672836382', 'uploads/avatar_nick.png', 0, 0, 0, 0, 0, 0, 0),
(18, 'zaza', '2025101561', 'n0gjqz', '2020/2021', 'Science', 'Business Management', '1242323', 'uploads/avatar_nick.png', 0, 0, 0, 0, 0, 0, 0),
(19, 'jona', '202222221', 'oexs5g', '2020/2021', 'Science', 'Business Management', '4676543576', 'uploads/avatar_nick.png', 0, 0, 0, 0, 0, 0, 0),
(20, 'ali', '2028101561', '58fci4', '2020/2021', 'Science', 'Information Technology', '2344433', 'uploads/avatar_nick.png', 0, 0, 0, 0, 0, 0, 0),
(21, 'nku', '2022710167', '0c47gs', '2020/2021', 'Science', 'Information Technology', '45654345', 'uploads/avatar_nick.png', 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblsession`
--

CREATE TABLE `tblsession` (
  `ID` int(3) NOT NULL,
  `session` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsession`
--

INSERT INTO `tblsession` (`ID`, `session`) VALUES
(1, '2020/2021'),
(2, '2021/2022');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `clearance_documents`
--
ALTER TABLE `clearance_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `clearance_requests`
--
ALTER TABLE `clearance_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee`
--
ALTER TABLE `fee`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblsession`
--
ALTER TABLE `tblsession`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `clearance_documents`
--
ALTER TABLE `clearance_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `clearance_requests`
--
ALTER TABLE `clearance_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `fee`
--
ALTER TABLE `fee`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblsession`
--
ALTER TABLE `tblsession`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clearance_documents`
--
ALTER TABLE `clearance_documents`
  ADD CONSTRAINT `clearance_documents_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `students` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
