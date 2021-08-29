-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 03, 2021 at 09:22 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_teacher`
--

CREATE TABLE `tb_teacher` (
  `id` int(11) NOT NULL,
  `teacher_name` varchar(50) NOT NULL,
  `teacher_age` int(100) NOT NULL,
  `teacher_gender` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_teacher`
--

INSERT INTO `tb_teacher` (`id`, `teacher_name`, `teacher_age`, `teacher_gender`) VALUES
(1, 'Cikgu Kamal', 29, 'Lelaki'),
(2, 'Cikgu Suhaila', 32, 'Perempuan');

-- --------------------------------------------------------

--
-- Table structure for table `tb_stages`
--

CREATE TABLE `tb_stages` (
  `id` int(11) NOT NULL,
  `student_age` int(100) NOT NULL,
  `stages_age` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_stages`
--

INSERT INTO `tb_stages` (`id`, `student_age`, `stages_age`) VALUES
(1, 7, 'Darjah 1'),
(2, 8, 'Darjah 2'),
(3, 9, 'Darjah 3'),
(4, 10, 'Darjah 4'),
(5, 11, 'Darjah 5'),
(6, 12, 'Darjah 6'),
(7, 13, 'Tingkatan 1'),
(8, 14, 'Tingkatan 2'),
(9, 15, 'Tingkatan 3'),
(10, 16, 'Tingkatan 4'),
(11, 17, 'Tingkatan 5'),
(12, 18, 'Tingkatan 6');

-- --------------------------------------------------------

--
-- Table structure for table `tb_class`
--

CREATE TABLE `tb_class` (
  `id` int(11) NOT NULL,
  `class_name` varchar(200) NOT NULL,
  `level_kelas` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_class`
--

INSERT INTO `tb_class` (`id`, `class_name`, `level_kelas`) VALUES
(1, 'Class A', ''),
(2, 'Class B', ''),
(3, 'Class C', ''),
(4, 'Class D', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student`
--

CREATE TABLE `tb_student` (
  `id` int(11) NOT NULL,
  `student_name` varchar(50) NOT NULL,
  `student_age` int(100) NOT NULL,
  `student_gender` varchar(50) NOT NULL,
  `class_id` int(1) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_student`
--

INSERT INTO `tb_student` (`id`, `student_name`, `student_age`, `student_gender`, `class_id`, `teacher_id`) VALUES
(1, 'Sarah', 15, 'Perempuan', 1, 2),
(2, 'Laila', 18, 'Perempuan', 1, 1),
(3, 'Jack', 17, 'Lelaki', 3, 1),
(4, 'Harry', 18, 'Lelaki', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_subjects`
--

CREATE TABLE `tb_subjects` (
  `id` int(11) NOT NULL,
  `subjects_name` varchar(50) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_subjects`
--

INSERT INTO `tb_subjects` (`id`, `subjects_name`, `teacher_id`) VALUES
(1, 'Dunia Musik', 1),
(2, 'Bahasa Melayu', 1),
(3, 'Matematik', 1),
(4, 'Bahasa Inggeris', 1),
(5, 'Pendidikan Islam', 1),
(6, 'Pendidikan Moral', 1),
(7, 'Pendidikan Seni Visual', 1),
(8, 'Pendidikan Kesihantan', 1),
(9, 'Pendidikan Jasmani', 2),
(10, 'Bahasa Arab', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_teacher`
--
ALTER TABLE `tb_teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_stages`
--
ALTER TABLE `tb_stages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_class`
--
ALTER TABLE `tb_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_student`
--
ALTER TABLE `tb_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_subjects`
--
ALTER TABLE `tb_subjects`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_teacher`
--
ALTER TABLE `tb_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_stages`
--
ALTER TABLE `tb_stages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_student`
--
ALTER TABLE `tb_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
