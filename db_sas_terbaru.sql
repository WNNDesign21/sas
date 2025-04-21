-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 05:04 PM
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
  `id_mk` varchar(10) NOT NULL,
  `npm` bigint(20) NOT NULL,
  `tanggal` date NOT NULL,
  `pertemuan` int(2) NOT NULL,
  `status` enum('HADIR','TIDAK HADIR','IZIN') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_mk`, `npm`, `tanggal`, `pertemuan`, `status`) VALUES
(1, '', 4337855201230085, '2025-02-22', 1, 'HADIR'),
(2, '', 4337855201230085, '2025-02-22', 1, 'HADIR'),
(9, '', 4337855201230085, '2025-02-22', 2, 'TIDAK HADIR'),
(12, '', 4337855201230085, '2025-02-22', 1, 'HADIR'),
(13, 'FICT1234', 4337855201230085, '2025-04-17', 101, 'HADIR'),
(15, 'FICT1234', 4337855201230085, '2025-04-17', 90, 'HADIR'),
(16, 'FICT1234', 4337855201230078, '2025-04-17', 90, 'HADIR'),
(17, 'INFC115', 4337855201230085, '2025-04-21', 1, 'HADIR');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `course` varchar(255) NOT NULL,
  `session` varchar(50) NOT NULL,
  `qr_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_jadwal`
--

CREATE TABLE `detail_jadwal` (
  `id_jadwal` int(10) UNSIGNED NOT NULL,
  `id_mk` varchar(255) NOT NULL,
  `nidn` bigint(20) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `total_pertemuan` int(2) NOT NULL,
  `ruangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_jadwal`
--

INSERT INTO `detail_jadwal` (`id_jadwal`, `id_mk`, `nidn`, `hari`, `jam_mulai`, `jam_selesai`, `total_pertemuan`, `ruangan`) VALUES
(1, 'INFC115', 123456782, 'Selasa', '18:30:00', '22:10:00', 16, 'C1-3'),
(3, 'INFC116', 123456781, 'Rabu', '18:30:00', '22:10:00', 16, 'LAB-A'),
(4, 'INFC117', 123456780, 'Senin', '18:30:00', '22:10:00', 16, 'LAB-A'),
(5, 'INFC119', 123456785, 'Jumat', '19:00:00', '22:10:00', 16, 'LAB-B'),
(6, 'INFC120', 123456782, 'Kamis', '19:00:00', '22:10:00', 16, ''),
(7, 'INFC120', 123456785, 'Jumat', '19:00:00', '22:10:00', 16, 'LAB-B'),
(8, 'INFC121', 123456783, 'Sabtu', '18:30:00', '22:10:00', 16, 'LAB-A'),
(9, 'MKDU305A', 123456784, 'Sabtu', '14:00:00', '16:30:00', 16, 'B1-1');

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
(123456780, 'ANWAR HILMAN', 'FICT'),
(123456781, 'AHMAD MUBAROK', 'FICT'),
(123456782, 'DEDIH', 'FICT'),
(123456783, 'WAFIQA', 'FICT'),
(123456784, 'RAHMA JUWITA', 'FICT'),
(123456785, 'OMAN', 'FICT'),
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
(4337855201230078, 'CHRISTOPAN TANGGUH SANTOSA', 'INFORMATIKA', 'FICT'),
(4337855201230085, 'Wendi Nugraha Nurrahmansyah', 'INFORMATIKA', 'FICT'),
(4337855201230105, 'FAJAR NUR FARRIJAL', 'MANAJEMEN', 'FMB');

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
-- Table structure for table `qr_codes`
--

CREATE TABLE `qr_codes` (
  `id` int(11) NOT NULL,
  `id_mk` varchar(255) NOT NULL,
  `pertemuan` int(11) NOT NULL,
  `qr_text` text NOT NULL,
  `qr_image` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qr_codes`
--

INSERT INTO `qr_codes` (`id`, `id_mk`, `pertemuan`, `qr_text`, `qr_image`, `created_at`) VALUES
(1, 'INFC115', 4, 'INFC115 | Mata Kuliah: Mobile Programming 2 | Pertemuan: 4', 'uploads/qrcodes/qr_1742009680.png', '2025-03-15 03:34:40'),
(2, 'INFC116', 3, 'Mata Kuliah:  | Pertemuan: 3', 'uploads/qrcodes/qr_1742009821.png', '2025-03-15 03:37:02'),
(3, 'INFC119', 5, 'Mata Kuliah: Office Application | Pertemuan: 5', 'uploads/qrcodes/qr_1742009923.png', '2025-03-15 03:38:43'),
(4, 'INFC117', 6, 'Mata Kuliah: Web Programming 2 | Pertemuan: 6', 'uploads/qrcodes/qr_1742010570.png', '2025-03-15 03:49:30'),
(5, 'MKDU305A', 1, 'Mata Kuliah: GWEP 4 | Pertemuan: 1', 'uploads/qrcodes/qr_1742010719.png', '2025-03-15 03:51:59'),
(6, 'INFC121', 1, 'Mata Kuliah: OOP Java 2 | Pertemuan: 1', 'uploads/qrcodes/qr_1742010767.png', '2025-03-15 03:52:47'),
(7, 'INFC116', 1, 'Mata Kuliah: ISAD 2 | Pertemuan: 1', 'uploads/qrcodes/qr_1742010853.png', '2025-03-15 03:54:13'),
(8, 'INFC116', 2, 'Mata Kuliah: ISAD 2 | Pertemuan: 2', 'uploads/qrcodes/qr_1742010927.png', '2025-03-15 03:55:27'),
(9, 'INFC115', 1, 'Mata Kuliah: Mobile Programming 2 | Pertemuan: 1', 'uploads/qrcodes/qr_1742010948.png', '2025-03-15 03:55:48'),
(10, 'INFC116', 1, 'Mata Kuliah: ISAD 2 | Pertemuan: 1', 'uploads/qrcodes/qr_1742011360.png', '2025-03-15 04:02:40'),
(11, 'INFC119', 3, 'Mata Kuliah: Office Application | Pertemuan: 3', 'uploads/qrcodes/qr_1742013111.png', '2025-03-15 04:31:51'),
(12, 'INFC119', 5, 'Mata Kuliah: Office Application | Pertemuan: 5', 'uploads/qrcodes/qr_1742018923.png', '2025-03-15 06:08:43'),
(13, 'INFC120', 2, 'Mata Kuliah: Mobile Apps Project | Pertemuan: 2', 'uploads/qrcodes/qr_1742024018.png', '2025-03-15 07:33:38'),
(14, 'INFC116', 1, 'Mata Kuliah: ISAD 2 | Pertemuan: 1', 'uploads/qrcodes/qr_1742027658.png', '2025-03-15 08:34:18'),
(15, 'INFC115', 4, 'INFC115 | Mata Kuliah: Mobile Programming 2 | Pertemuan: 4', 'uploads/qrcodes/qr_1742040622.png', '2025-03-15 12:10:22'),
(16, 'INFC117', 7, 'Mata Kuliah: Web Programming 2 | Pertemuan: 7', 'uploads/qrcodes/qr_1742041429.png', '2025-03-15 12:23:49'),
(17, 'INFC117', 7, 'Mata Kuliah: Web Programming 2 | Pertemuan: 7', 'uploads/qrcodes/qr_1742041448.png', '2025-03-15 12:24:08'),
(18, 'INFC117', 3, 'Mata Kuliah: Web Programming 2 | Pertemuan: 3', 'uploads/qrcodes/qr_1742041723.png', '2025-03-15 12:28:43'),
(19, 'INFC117', 1, 'Mata Kuliah: Web Programming 2 | Pertemuan: 1', 'uploads/qrcodes/qr_1742046931.png', '2025-03-15 13:55:32'),
(20, 'INFC117', 2, 'Mata Kuliah: Web Programming 2 | Pertemuan: 2', 'uploads/qrcodes/qr_1744555183.png', '2025-04-13 14:39:43'),
(21, 'INFC117', 4, 'Web Programming 24', 'uploads/qrcodes/qr_1744895143.png', '2025-04-17 13:05:44'),
(22, 'INFC117', 5, 'Web Programming 2 | 5', 'uploads/qrcodes/qr_1744895231.png', '2025-04-17 13:07:11'),
(23, 'INFC117', 100, 'INFC117 | Web Programming 2 | 100', 'uploads/qrcodes/qr_1744895643.png', '2025-04-17 13:14:03'),
(24, 'INFC115', 2, 'INFC115 | Mobile Programming 2 | 2', 'uploads/qrcodes/qr_1745038907.png', '2025-04-19 05:01:48'),
(25, 'INFC115', 3, 'INFC115 | Mobile Programming 2 | 3', 'uploads/qrcodes/qr_1745240569.png', '2025-04-21 13:02:50'),
(26, 'INFC115', 5, 'INFC115 | Mobile Programming 2 | 5', 'uploads/qrcodes/qr_1745240599.png', '2025-04-21 13:03:19');

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
(123456782, '123456', 'DEDIH', 'DOSEN', NULL),
(123456789, '12345', 'Adhi Nur Fajar', 'DOSEN', NULL),
(4337855201230078, '123456', 'CHRISTOPAN TANGGUH SANTOSA', 'MHS', NULL),
(4337855201230084, '12345', 'ADHI NUR FAJAR', 'MHS', NULL),
(4337855201230085, 'WNNDesign21', 'WENDI NUGRAHA NURRAHMANSYAH', 'MHS', 'assets/foto_profil/profil_4337855201230085.png'),
(4337855201230105, '12345', 'FAJAR NUR FARRIJAL', 'MHS', 'assets/foto_profil/profil_4337855201230105.png');

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
-- Stand-in structure for view `v_absensi`
-- (See below for the actual view)
--
CREATE TABLE `v_absensi` (
`id_absensi` int(10) unsigned
,`id_mk` varchar(10)
,`nama_mk` varchar(255)
,`sks` int(11)
,`id_jadwal` int(10) unsigned
,`nidn` bigint(20)
,`hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')
,`jam_mulai` time
,`jam_selesai` time
,`total_pertemuan` int(2)
,`ruangan` varchar(255)
,`npm` bigint(20)
,`tanggal` date
,`pertemuan` int(2)
,`status` enum('HADIR','TIDAK HADIR','IZIN')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_d_absensi`
-- (See below for the actual view)
--
CREATE TABLE `v_d_absensi` (
);

-- --------------------------------------------------------

--
-- Structure for view `user_view`
--
DROP TABLE IF EXISTS `user_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_view`  AS SELECT `mhs`.`npm` AS `id_user`, `mhs`.`nama` AS `nama_user`, 'Mahasiswa' AS `status` FROM `mhs`union all select `dosen`.`nidn` AS `id_user`,`dosen`.`nama_dosen` AS `nama_user`,'Dosen' AS `status` from `dosen`  ;

-- --------------------------------------------------------

--
-- Structure for view `v_absensi`
--
DROP TABLE IF EXISTS `v_absensi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_absensi`  AS SELECT `a`.`id_absensi` AS `id_absensi`, `a`.`id_mk` AS `id_mk`, `mk`.`nama_mk` AS `nama_mk`, `mk`.`sks` AS `sks`, `dj`.`id_jadwal` AS `id_jadwal`, `dj`.`nidn` AS `nidn`, `dj`.`hari` AS `hari`, `dj`.`jam_mulai` AS `jam_mulai`, `dj`.`jam_selesai` AS `jam_selesai`, `dj`.`total_pertemuan` AS `total_pertemuan`, `dj`.`ruangan` AS `ruangan`, `a`.`npm` AS `npm`, `a`.`tanggal` AS `tanggal`, `a`.`pertemuan` AS `pertemuan`, `a`.`status` AS `status` FROM ((`absensi` `a` join `detail_jadwal` `dj` on(`a`.`id_mk` = `dj`.`id_mk`)) join `mata_kuliah` `mk` on(`a`.`id_mk` = `mk`.`id_mk`)) ;

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
  ADD KEY `FK_absensi_mhs` (`npm`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_jadwal`
--
ALTER TABLE `detail_jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `jadwal_id_mk_index` (`id_mk`),
  ADD KEY `jadwal_nidn_index` (`nidn`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_mhs_mk_mata_kuliah` (`id_mk`);

--
-- Indexes for table `qr_codes`
--
ALTER TABLE `qr_codes`
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
  MODIFY `id_absensi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `detail_jadwal`
--
ALTER TABLE `detail_jadwal`
  MODIFY `id_jadwal` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `npm` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4337855201230106;

--
-- AUTO_INCREMENT for table `mhs_mk`
--
ALTER TABLE `mhs_mk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `qr_codes`
--
ALTER TABLE `qr_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4337855201230106;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `FK_absensi_mhs` FOREIGN KEY (`npm`) REFERENCES `mhs` (`npm`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `FK_jadwal_dosen` FOREIGN KEY (`nidn`) REFERENCES `dosen` (`nidn`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_jadwal_dosen_2` FOREIGN KEY (`nidn`) REFERENCES `dosen` (`nidn`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_jadwal_mata_kuliah` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id_mk`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `mhs_mk`
--
ALTER TABLE `mhs_mk`
  ADD CONSTRAINT `FK_mhs_mk_mata_kuliah` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id_mk`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
