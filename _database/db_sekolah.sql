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
-- Table structure for table `tb_cikgu`
--

CREATE TABLE `tb_cikgu` (
  `id` int(11) NOT NULL,
  `nama_cikgu` varchar(50) NOT NULL,
  `umur_cikgu` int(100) NOT NULL,
  `jantina_cikgu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_cikgu`
--

INSERT INTO `tb_cikgu` (`id`, `nama_cikgu`, `umur_cikgu`, `jantina_cikgu`) VALUES
(1, 'Cikgu Kamal', 29, 'Lelaki'),
(2, 'Cikgu Suhaila', 32, 'Perempuan');

-- --------------------------------------------------------

--
-- Table structure for table `tb_darjah`
--

CREATE TABLE `tb_darjah` (
  `id` int(11) NOT NULL,
  `umur_pelajar` int(100) NOT NULL,
  `darjah_pelajar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_darjah`
--

INSERT INTO `tb_darjah` (`id`, `umur_pelajar`, `darjah_pelajar`) VALUES
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
-- Table structure for table `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id` int(11) NOT NULL,
  `nama_kelas` varchar(200) NOT NULL,
  `level_kelas` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kelas`
--

INSERT INTO `tb_kelas` (`id`, `nama_kelas`, `level_kelas`) VALUES
(1, 'Kelas A', ''),
(2, 'Kelas B', ''),
(3, 'Kelas C', ''),
(4, 'Kelas D', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelajar`
--

CREATE TABLE `tb_pelajar` (
  `id` int(11) NOT NULL,
  `nama_pelajar` varchar(50) NOT NULL,
  `umur_pelajar` int(100) NOT NULL,
  `jantina_pelajar` varchar(50) NOT NULL,
  `kelas_id` int(1) NOT NULL,
  `cikgu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pelajar`
--

INSERT INTO `tb_pelajar` (`id`, `nama_pelajar`, `umur_pelajar`, `jantina_pelajar`, `kelas_id`, `cikgu_id`) VALUES
(1, 'Sarah', 15, 'Perempuan', 1, 2),
(2, 'Laila', 18, 'Perempuan', 1, 1),
(3, 'Jack', 17, 'Lelaki', 3, 1),
(4, 'Harry', 18, 'Lelaki', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelajaran`
--

CREATE TABLE `tb_pelajaran` (
  `id` int(11) NOT NULL,
  `mata_pelajaran` varchar(50) NOT NULL,
  `cikgu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pelajaran`
--

INSERT INTO `tb_pelajaran` (`id`, `mata_pelajaran`, `cikgu_id`) VALUES
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
-- Indexes for table `tb_cikgu`
--
ALTER TABLE `tb_cikgu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_darjah`
--
ALTER TABLE `tb_darjah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pelajar`
--
ALTER TABLE `tb_pelajar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pelajaran`
--
ALTER TABLE `tb_pelajaran`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_cikgu`
--
ALTER TABLE `tb_cikgu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_darjah`
--
ALTER TABLE `tb_darjah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_pelajar`
--
ALTER TABLE `tb_pelajar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
