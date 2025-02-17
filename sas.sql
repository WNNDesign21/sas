-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2025 at 02:37 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sas`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(10) UNSIGNED NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `nim` bigint(20) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('HADIR','TIDAK HADIR','IZIN') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_jadwal`, `nim`, `tanggal`, `status`) VALUES
(1, 1, 4337855201230085, '2025-02-15', 'HADIR');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `nidn` bigint(20) NOT NULL,
  `nama_dosen` varchar(255) NOT NULL,
  `fakultas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`nidn`, `nama_dosen`, `fakultas`) VALUES
(123456789, 'Adhi Nur Fajar', 'FICT');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(10) UNSIGNED NOT NULL,
  `id_mk` varchar(255) NOT NULL,
  `nidn` bigint(20) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_mk`, `nidn`, `hari`, `jam_mulai`, `jam_selesai`, `ruangan`) VALUES
(1, 'INF4001', 123456789, 'Senin', '18:00:00', '18:00:00', 'B2-1');

-- --------------------------------------------------------

--
-- Table structure for table `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `id_mk` varchar(255) NOT NULL,
  `nama_mk` varchar(255) NOT NULL,
  `sks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`id_mk`, `nama_mk`, `sks`) VALUES
('INF4001', 'Web Programming 2', 4),
('INF4002', 'ISAD 2', 4);

-- --------------------------------------------------------

--
-- Table structure for table `mhs`
--

CREATE TABLE `mhs` (
  `npm` bigint(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `fakultas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mhs`
--

INSERT INTO `mhs` (`npm`, `nama`, `prodi`, `fakultas`) VALUES
(4337855201230085, 'Wendi Nugraha Nurrahmansyah', 'INFORMATIKA', 'FICT');

-- --------------------------------------------------------

--
-- Table structure for table `mhs_mk`
--

CREATE TABLE `mhs_mk` (
  `id` int(10) UNSIGNED NOT NULL,
  `npm` bigint(20) NOT NULL,
  `id_mk` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mhs_mk`
--

INSERT INTO `mhs_mk` (`id`, `npm`, `id_mk`) VALUES
(1, 4337855201230085, 'INF4001');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` bigint(20) NOT NULL,
  `password` varchar(8) NOT NULL,
  `akses` enum('ADMIN','DOSEN','MHS') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `password`, `akses`) VALUES
(4337855201230085, 'WNNDesig', 'MHS');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_view`
-- (See below for the actual view)
--
CREATE TABLE `user_view` (
`id_user` bigint(20)
,`nama_user` varchar(255)
,`status` varchar(9)
);

-- --------------------------------------------------------

--
-- Structure for view `user_view`
--
DROP TABLE IF EXISTS `user_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_view`  AS SELECT `mhs`.`npm` AS `id_user`, `mhs`.`nama` AS `nama_user`, 'Mahasiswa' AS `status` FROM `mhs`union all select `dosen`.`nidn` AS `id_user`,`dosen`.`nama_dosen` AS `nama_user`,'Dosen' AS `status` from `dosen`  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `absensi_id_jadwal_index` (`id_jadwal`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`nidn`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `jadwal_id_mk_index` (`id_mk`),
  ADD KEY `jadwal_nidn_index` (`nidn`);

--
-- Indexes for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`id_mk`);

--
-- Indexes for table `mhs`
--
ALTER TABLE `mhs`
  ADD PRIMARY KEY (`npm`);

--
-- Indexes for table `mhs_mk`
--
ALTER TABLE `mhs_mk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `nidn` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123456790;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mhs`
--
ALTER TABLE `mhs`
  MODIFY `npm` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4337855201230086;

--
-- AUTO_INCREMENT for table `mhs_mk`
--
ALTER TABLE `mhs_mk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4337855201230086;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
