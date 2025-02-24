-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 01:19 PM
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
  `id_jadwal` int(10) UNSIGNED NOT NULL,
  `npm` bigint(20) NOT NULL,
  `tanggal` date NOT NULL,
  `pertemuan` int(2) NOT NULL,
  `status` enum('HADIR','TIDAK HADIR','IZIN') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_jadwal`, `npm`, `tanggal`, `pertemuan`, `status`) VALUES
(1, 1, 4337855201230085, '2025-02-22', 1, 'HADIR'),
(2, 17, 4337855201230085, '2025-02-22', 1, 'HADIR'),
(9, 2, 4337855201230085, '2025-02-22', 2, 'TIDAK HADIR'),
(12, 33, 4337855201230085, '2025-02-22', 1, 'HADIR');

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
(123456789, 'Adhi Nur Fajar', 'FICT'),
(123456790, 'Christopan Tangguh', 'FICT'),
(123456791, 'Safla Alfarisyi', 'FICT');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(10) UNSIGNED NOT NULL,
  `id_mk` varchar(255) NOT NULL,
  `nidn` bigint(20) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `pertemuan` int(2) NOT NULL,
  `ruangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_mk`, `nidn`, `hari`, `tanggal`, `jam_mulai`, `jam_selesai`, `pertemuan`, `ruangan`) VALUES
(1, 'INFC117', 123456789, 'Senin', '2025-02-03', '18:00:00', '22:10:00', 1, 'B2-1'),
(2, 'INFC117', 123456789, 'Senin', '2025-02-10', '18:00:00', '22:10:00', 2, 'B2-1'),
(3, 'INFC117', 123456789, 'Senin', '2025-02-17', '18:00:00', '22:10:00', 3, 'B2-1'),
(4, 'INFC117', 123456789, 'Senin', '2025-02-24', '18:00:00', '22:10:00', 4, 'B2-1'),
(5, 'INFC117', 123456789, 'Senin', '2025-03-03', '18:00:00', '22:10:00', 5, 'B2-1'),
(6, 'INFC117', 123456789, 'Senin', '2025-03-10', '18:00:00', '22:10:00', 6, 'B2-1'),
(7, 'INFC117', 123456789, 'Senin', '2025-03-17', '18:00:00', '22:10:00', 7, 'B2-1'),
(8, 'INFC117', 123456789, 'Senin', '2025-03-24', '18:00:00', '22:10:00', 8, 'B2-1'),
(9, 'INFC117', 123456789, 'Senin', '2025-03-31', '18:00:00', '22:10:00', 9, 'B2-1'),
(10, 'INFC117', 123456789, 'Senin', '2025-04-07', '18:00:00', '22:10:00', 10, 'B2-1'),
(11, 'INFC117', 123456789, 'Senin', '2025-04-14', '18:00:00', '22:10:00', 11, 'B2-1'),
(12, 'INFC117', 123456789, 'Senin', '2025-04-21', '18:00:00', '22:10:00', 12, 'B2-1'),
(13, 'INFC117', 123456789, 'Senin', '2025-04-28', '18:00:00', '22:10:00', 13, 'B2-1'),
(14, 'INFC117', 123456789, 'Senin', '2025-05-05', '18:00:00', '22:10:00', 14, 'B2-1'),
(15, 'INFC117', 123456789, 'Senin', '2025-05-12', '18:00:00', '22:10:00', 15, 'B2-1'),
(16, 'INFC117', 123456789, 'Senin', '2025-05-19', '18:00:00', '22:10:00', 16, 'B2-1'),
(17, 'INFC115', 123456790, 'Selasa', '2025-02-04', '18:00:00', '22:10:00', 1, 'LAB-A'),
(18, 'INFC115', 123456790, 'Selasa', '2025-02-11', '18:00:00', '22:10:00', 2, 'LAB-A'),
(19, 'INFC115', 123456790, 'Selasa', '2025-02-18', '18:00:00', '22:10:00', 3, 'LAB-A'),
(20, 'INFC115', 123456790, 'Selasa', '2025-02-25', '18:00:00', '22:10:00', 4, 'LAB-A'),
(21, 'INFC115', 123456790, 'Selasa', '2025-03-04', '18:00:00', '22:10:00', 5, 'LAB-A'),
(22, 'INFC115', 123456790, 'Selasa', '2025-03-11', '18:00:00', '22:10:00', 6, 'LAB-A'),
(23, 'INFC115', 123456790, 'Selasa', '2025-03-18', '18:00:00', '22:10:00', 7, 'LAB-A'),
(24, 'INFC115', 123456790, 'Selasa', '2025-03-25', '18:00:00', '22:10:00', 8, 'LAB-A'),
(25, 'INFC115', 123456790, 'Selasa', '2025-04-01', '18:00:00', '22:10:00', 9, 'LAB-A'),
(26, 'INFC115', 123456790, 'Selasa', '2025-04-08', '18:00:00', '22:10:00', 10, 'LAB-A'),
(27, 'INFC115', 123456790, 'Selasa', '2025-04-15', '18:00:00', '22:10:00', 11, 'LAB-A'),
(28, 'INFC115', 123456790, 'Selasa', '2025-04-22', '18:00:00', '22:10:00', 12, 'LAB-A'),
(29, 'INFC115', 123456790, 'Selasa', '2025-04-29', '18:00:00', '22:10:00', 13, 'LAB-A'),
(30, 'INFC115', 123456790, 'Selasa', '2025-05-06', '18:00:00', '22:10:00', 14, 'LAB-A'),
(31, 'INFC115', 123456790, 'Selasa', '2025-05-13', '18:00:00', '22:10:00', 15, 'LAB-A'),
(32, 'INFC115', 123456790, 'Selasa', '2025-05-20', '18:00:00', '22:10:00', 16, 'LAB-A'),
(33, 'INFC116', 123456791, 'Rabu', '2025-02-05', '18:00:00', '22:10:00', 1, 'LAB-A'),
(34, 'INFC116', 123456791, 'Rabu', '2025-02-12', '18:00:00', '22:10:00', 2, 'LAB-A'),
(35, 'INFC116', 123456791, 'Rabu', '2025-02-19', '18:00:00', '22:10:00', 3, 'LAB-A'),
(36, 'INFC116', 123456791, 'Rabu', '2025-02-26', '18:00:00', '22:10:00', 4, 'LAB-A'),
(37, 'INFC116', 123456791, 'Rabu', '2025-03-05', '18:00:00', '22:10:00', 5, 'LAB-A'),
(38, 'INFC116', 123456791, 'Rabu', '2025-03-12', '18:00:00', '22:10:00', 6, 'LAB-A'),
(39, 'INFC116', 123456791, 'Rabu', '2025-03-19', '18:00:00', '22:10:00', 7, 'LAB-A'),
(40, 'INFC116', 123456791, 'Rabu', '2025-03-26', '18:00:00', '22:10:00', 8, 'LAB-A'),
(41, 'INFC116', 123456791, 'Rabu', '2025-04-02', '18:00:00', '22:10:00', 9, 'LAB-A'),
(42, 'INFC116', 123456791, 'Rabu', '2025-04-09', '18:00:00', '22:10:00', 10, 'LAB-A'),
(43, 'INFC116', 123456791, 'Rabu', '2025-04-16', '18:00:00', '22:10:00', 11, 'LAB-A'),
(44, 'INFC116', 123456791, 'Rabu', '2025-04-23', '18:00:00', '22:10:00', 12, 'LAB-A'),
(45, 'INFC116', 123456791, 'Rabu', '2025-04-30', '18:00:00', '22:10:00', 13, 'LAB-A'),
(46, 'INFC116', 123456791, 'Rabu', '2025-05-07', '18:00:00', '22:10:00', 14, 'LAB-A'),
(47, 'INFC116', 123456791, 'Rabu', '2025-05-14', '18:00:00', '22:10:00', 15, 'LAB-A'),
(48, 'INFC116', 123456791, 'Rabu', '2025-05-21', '18:00:00', '22:10:00', 16, 'LAB-A');

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
('INFC115', 'Mobile Programming 2', 4),
('INFC116', 'ISAD 2', 4),
('INFC117', 'Web Programming 2', 4),
('INFC119', 'Office Application', 4),
('INFC120', 'Mobile Apps Project', 4),
('INFC121', 'OOP Java 2', 4),
('MKDU305A', 'GWEP 4', 4);

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
(2, 4337855201230085, 'INFC115');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` bigint(20) NOT NULL,
  `password` varchar(16) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `akses` enum('ADMIN','DOSEN','MHS') NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `password`, `nama_user`, `akses`, `foto_profil`) VALUES
(4337855201230084, '12345', 'ADHI NUR FAJAR', 'MHS', NULL),
(4337855201230085, 'WNNDesign21', 'WENDI NUGRAHA NURRAHMANSYAH', 'MHS', 'assets/foto_profil/profil_4337855201230085.png');

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
-- Stand-in structure for view `v_d_absensi`
-- (See below for the actual view)
--
CREATE TABLE `v_d_absensi` (
`id_absensi` int(10) unsigned
,`id_jadwal` int(10) unsigned
,`id_mk` varchar(255)
,`mata_kuliah` varchar(255)
,`dosen` varchar(255)
,`hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')
,`jam_mulai` time
,`jam_selesai` time
,`ruangan` varchar(255)
,`npm` bigint(20)
,`mahasiswa` varchar(255)
,`tanggal` date
,`pertemuan` int(2)
,`status` enum('HADIR','TIDAK HADIR','IZIN')
);

-- --------------------------------------------------------

--
-- Structure for view `user_view`
--
DROP TABLE IF EXISTS `user_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_view`  AS SELECT `mhs`.`npm` AS `id_user`, `mhs`.`nama` AS `nama_user`, 'Mahasiswa' AS `status` FROM `mhs`union all select `dosen`.`nidn` AS `id_user`,`dosen`.`nama_dosen` AS `nama_user`,'Dosen' AS `status` from `dosen`  ;

-- --------------------------------------------------------

--
-- Structure for view `v_d_absensi`
--
DROP TABLE IF EXISTS `v_d_absensi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_d_absensi`  AS SELECT `a`.`id_absensi` AS `id_absensi`, `a`.`id_jadwal` AS `id_jadwal`, `j`.`id_mk` AS `id_mk`, `mk`.`nama_mk` AS `mata_kuliah`, `d`.`nama_dosen` AS `dosen`, `j`.`hari` AS `hari`, `j`.`jam_mulai` AS `jam_mulai`, `j`.`jam_selesai` AS `jam_selesai`, `j`.`ruangan` AS `ruangan`, `a`.`npm` AS `npm`, `m`.`nama` AS `mahasiswa`, `a`.`tanggal` AS `tanggal`, `a`.`pertemuan` AS `pertemuan`, `a`.`status` AS `status` FROM ((((`absensi` `a` join `jadwal` `j` on(`a`.`id_jadwal` = `j`.`id_jadwal`)) join `mata_kuliah` `mk` on(`j`.`id_mk` = `mk`.`id_mk`)) join `mhs` `m` on(`a`.`npm` = `m`.`npm`)) join `dosen` `d` on(`j`.`nidn` = `d`.`nidn`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `absensi_id_jadwal_index` (`id_jadwal`),
  ADD KEY `FK_absensi_mhs` (`npm`);

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
  MODIFY `id_absensi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `nidn` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123456792;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `mhs`
--
ALTER TABLE `mhs`
  MODIFY `npm` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4337855201230086;

--
-- AUTO_INCREMENT for table `mhs_mk`
--
ALTER TABLE `mhs_mk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4337855201230086;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `FK_absensi_jadwal` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_absensi_mhs` FOREIGN KEY (`npm`) REFERENCES `mhs` (`npm`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `FK_jadwal_dosen` FOREIGN KEY (`nidn`) REFERENCES `dosen` (`nidn`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_jadwal_mata_kuliah` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id_mk`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
