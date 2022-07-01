-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql110.epizy.com
-- Generation Time: Jun 25, 2022 at 10:45 AM
-- Server version: 10.3.27-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_32030629_exam_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_class`
--

CREATE TABLE `add_class` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `add_class`
--

INSERT INTO `add_class` (`class_id`, `class_name`, `status`) VALUES
(1, 'Class 1', 'Enabled');

-- --------------------------------------------------------

--
-- Table structure for table `add_course`
--

CREATE TABLE `add_course` (
  `course_id` int(100) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `create_time` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `add_course`
--

INSERT INTO `add_course` (`course_id`, `course_name`, `create_time`, `status`) VALUES
(1, 'Software Engineering', '24-06-2022 23:32', 'Enabled');

-- --------------------------------------------------------

--
-- Table structure for table `add_exam`
--

CREATE TABLE `add_exam` (
  `exam_id` int(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `exam_time_limit` varchar(100) NOT NULL,
  `total_question` varchar(100) NOT NULL,
  `correct` varchar(100) NOT NULL,
  `wrong` varchar(100) NOT NULL,
  `exam_title` varchar(100) NOT NULL,
  `exam_date` varchar(100) NOT NULL,
  `exam_time` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `add_exam`
--

INSERT INTO `add_exam` (`exam_id`, `course`, `exam_time_limit`, `total_question`, `correct`, `wrong`, `exam_title`, `exam_date`, `exam_time`, `status`) VALUES
(1, 'Software Engineering', '5', '5', '2', '1', 'Exam of Software Engineering', '2022-06-25', '12:00', 'Ended');

-- --------------------------------------------------------

--
-- Table structure for table `add_question`
--

CREATE TABLE `add_question` (
  `question_id` int(100) NOT NULL,
  `exam_title` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `question` varchar(10000) NOT NULL,
  `ans_1` varchar(100) NOT NULL,
  `ans_2` varchar(100) NOT NULL,
  `ans_3` varchar(100) NOT NULL,
  `ans_4` varchar(100) NOT NULL,
  `correct_answer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `add_question`
--

INSERT INTO `add_question` (`question_id`, `exam_title`, `course`, `question`, `ans_1`, `ans_2`, `ans_3`, `ans_4`, `correct_answer`) VALUES
(1, 'Exam of Software Engineering', 'Software Engineering', 'What is Software Engineering?', 'Designing a software', 'Testing a software', 'Application of engineering principles to the design a software', 'None of the above', 'Application of engineering principles to the design a software'),
(2, 'Exam of Software Engineering', 'Software Engineering', 'Attributes of good software is -', 'Development', 'Maintainability & functionality', 'Functionality', 'Maintainability', 'Maintainability & functionality'),
(3, 'Exam of Software Engineering', 'Software Engineering', 'When can white-box testing be started?', 'After SRS creation', 'After installation', 'After programming', 'After designing', 'After programming'),
(4, 'Exam of Software Engineering', 'Software Engineering', 'A process view in software engineering would consider which of the following', 'Product performance', 'Staffing', 'Functionality', 'Reliability', 'Staffing'),
(5, 'Exam of Software Engineering', 'Software Engineering', 'What does SDLC stands for?', 'System Design Life Cycle', 'Software Design Life Cycle', 'Software Development Life Cycle', 'System Development Life cycle', 'Software Development Life Cycle');

-- --------------------------------------------------------

--
-- Table structure for table `add_student`
--

CREATE TABLE `add_student` (
  `std_id` int(100) NOT NULL,
  `std_name` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `add_student`
--

INSERT INTO `add_student` (`std_id`, `std_name`, `gender`, `dob`, `course`, `year`, `email`, `password`, `image`) VALUES
(1, 'Ram Charan', 'Male', '2001-07-14', 'Software Engineering', '2nd Year', 'ramcharan@gmail.com', '1234', 'uploads/Cgdm7yMewn.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `admin_reg`
--

CREATE TABLE `admin_reg` (
  `adm_id` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `emailid` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `special_token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_reg`
--

INSERT INTO `admin_reg` (`adm_id`, `image`, `full_name`, `contact`, `emailid`, `password`, `special_token`) VALUES
(1, '', 'Nilesh Mukherjee', '8754963235', 'admin@email', '1234', 'MthPNTKv0n');

-- --------------------------------------------------------

--
-- Table structure for table `assign_course`
--

CREATE TABLE `assign_course` (
  `assign_id` int(100) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `create_time` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assign_course`
--

INSERT INTO `assign_course` (`assign_id`, `class_name`, `course_name`, `create_time`) VALUES
(1, 'Class 1', 'Software Engineering', '24-06-2022 23:33');

-- --------------------------------------------------------

--
-- Table structure for table `exam_answers`
--

CREATE TABLE `exam_answers` (
  `id` int(100) NOT NULL,
  `std_id` int(100) NOT NULL,
  `std_name` varchar(100) NOT NULL,
  `std_email` varchar(100) NOT NULL,
  `exam_title` varchar(100) NOT NULL,
  `question` varchar(10000) NOT NULL,
  `answered` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `std_exam_status`
--

CREATE TABLE `std_exam_status` (
  `status_id` int(100) NOT NULL,
  `std_id` int(100) NOT NULL,
  `std_name` varchar(100) NOT NULL,
  `std_email` varchar(100) NOT NULL,
  `exam_name` varchar(100) NOT NULL,
  `attendence_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_class`
--
ALTER TABLE `add_class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `add_course`
--
ALTER TABLE `add_course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `add_exam`
--
ALTER TABLE `add_exam`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `add_question`
--
ALTER TABLE `add_question`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `add_student`
--
ALTER TABLE `add_student`
  ADD PRIMARY KEY (`std_id`);

--
-- Indexes for table `admin_reg`
--
ALTER TABLE `admin_reg`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `assign_course`
--
ALTER TABLE `assign_course`
  ADD PRIMARY KEY (`assign_id`);

--
-- Indexes for table `exam_answers`
--
ALTER TABLE `exam_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `std_exam_status`
--
ALTER TABLE `std_exam_status`
  ADD PRIMARY KEY (`status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_class`
--
ALTER TABLE `add_class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `add_course`
--
ALTER TABLE `add_course`
  MODIFY `course_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `add_exam`
--
ALTER TABLE `add_exam`
  MODIFY `exam_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `add_question`
--
ALTER TABLE `add_question`
  MODIFY `question_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `add_student`
--
ALTER TABLE `add_student`
  MODIFY `std_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_reg`
--
ALTER TABLE `admin_reg`
  MODIFY `adm_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assign_course`
--
ALTER TABLE `assign_course`
  MODIFY `assign_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam_answers`
--
ALTER TABLE `exam_answers`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `std_exam_status`
--
ALTER TABLE `std_exam_status`
  MODIFY `status_id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
