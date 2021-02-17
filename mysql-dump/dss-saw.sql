-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2020 at 02:40 PM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dss-saw`
--
CREATE DATABASE IF NOT EXISTS `dss-saw` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dss-saw`;

-- --------------------------------------------------------

--
-- Table structure for table `bobot_preferensi`
--

CREATE TABLE `bobot_preferensi` (
  `id_bobot` int(11) NOT NULL,
  `kriteria` varchar(255) NOT NULL,
  `bobot` int(10) UNSIGNED NOT NULL,
  `sifat` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bobot_preferensi`
--

INSERT INTO `bobot_preferensi` (`id_bobot`, `kriteria`, `bobot`, `sifat`) VALUES
(1, 'Kepadatan Penduduk', 25, 'max'),
(2, 'Jenis Perangkat Mobile', 30, 'max'),
(3, 'Penggunaan Data', 35, 'max'),
(4, 'Kondisi BTS', 10, 'min');

-- --------------------------------------------------------

--
-- Table structure for table `kondisi_bts`
--

CREATE TABLE `kondisi_bts` (
  `id_kondisi_bts` int(11) NOT NULL,
  `kondisi` varchar(255) NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kondisi_bts`
--

INSERT INTO `kondisi_bts` (`id_kondisi_bts`, `kondisi`, `nilai`) VALUES
(1, 'New', 100),
(2, '3 G', 75),
(3, '3.5 G', 50);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `kd_pengguna` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`kd_pengguna`, `username`, `password`, `status`) VALUES
(1, 'petugas', 'afb91ef692fd08c445e8cb1bab2ccf9c', 'petugas'),
(2, 'puket', 'b679a71646e932b7c4647a081ee2a148', 'puket');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alternatif`
--

CREATE TABLE `tbl_alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `kondisi_bts_id` int(11) DEFAULT NULL COMMENT 'Tech Ready dilihat dari Kondisi BTS',
  `kode_random` varchar(11) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `nama_kelurahan` varchar(100) NOT NULL,
  `c1` float NOT NULL,
  `c2` float NOT NULL,
  `c3` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_alternatif`
--

INSERT INTO `tbl_alternatif` (`id_alternatif`, `kondisi_bts_id`, `kode_random`, `site_name`, `nama_kelurahan`, `c1`, `c2`, `c3`) VALUES
(1, 2, 'A201', 'BANJARWIJAYACIPONDOHDMT', 'PORIS PLAWAD INDAH', 11.26, 9, 10),
(2, 3, 'A00A', 'BATUCEPERDAANMOGOTPTEL', 'PORIS PLAWAD', 12.28, 11, 15),
(3, 3, 'C786', 'CEMARAPORISINDAHPTEL', 'KETAPANG', 20.61, 17, 45),
(4, 3, 'BA17', 'CIPONDOH', 'CIPONDOH', 22.6, 20, 60),
(5, 3, 'B101', 'CIPONDOH2', 'CIPONDOH INDAH', 31.86, 25, 75),
(6, 2, 'BA62', 'CIPONDOHINDH', 'KENANGA', 13.6, 10, 15),
(7, 3, 'BA63', 'CIPONDOHMKMR', 'CIPONDOH MAKMUR', 28.18, 26, 82),
(8, 2, 'B794', 'GONDRONGCIPONDOHDMT', 'GONDRONG', 19.49, 15, 20),
(9, 3, 'B842', 'HAJIASYARITGRDMT', 'PORIS PLAWAD UTARA', 19.94, 18, 40),
(10, 2, 'A880', 'HARAPANJAYACIPONDOHDMT', 'PETIR', 28.7, 19, 50);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kkp`
--

CREATE TABLE `tbl_kkp` (
  `id_kkp` int(11) NOT NULL,
  `nm_kelurahan` varchar(100) NOT NULL,
  `jml_non_lansia` int(11) NOT NULL COMMENT 'Usia 15 - 64',
  `jml_lansia` int(11) NOT NULL COMMENT 'Usia 65+',
  `total_1` int(11) NOT NULL,
  `total_2` float NOT NULL COMMENT 'Presisi 2 angka'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_kkp`
--

INSERT INTO `tbl_kkp` (`id_kkp`, `nm_kelurahan`, `jml_non_lansia`, `jml_lansia`, `total_1`, `total_2`) VALUES
(1, 'Poris Plawad I', 21536, 723, 22259, 22.26),
(2, 'Cipondoh', 21822, 774, 22596, 22.6),
(3, 'Kenanga', 13166, 436, 13602, 13.6),
(4, 'Gondrong', 18833, 657, 19490, 19.49),
(5, 'Petir', 27688, 1010, 29, 28.7),
(6, 'Ketapang', 19902, 707, 20609, 20.61),
(7, 'Cipondoh Indah', 30540, 1318, 31858, 31.86),
(8, 'Cipondoh Makmur', 27229, 876, 28175, 28.18),
(9, 'Poris Plawad Utara', 19318, 624, 19942, 19.94),
(10, 'Poris Plawad', 12476, 405, 12881, 12.88);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bobot_preferensi`
--
ALTER TABLE `bobot_preferensi`
  ADD PRIMARY KEY (`id_bobot`);

--
-- Indexes for table `kondisi_bts`
--
ALTER TABLE `kondisi_bts`
  ADD PRIMARY KEY (`id_kondisi_bts`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`kd_pengguna`);

--
-- Indexes for table `tbl_alternatif`
--
ALTER TABLE `tbl_alternatif`
  ADD PRIMARY KEY (`id_alternatif`),
  ADD UNIQUE KEY `kode_random` (`kode_random`),
  ADD KEY `kondisi_bts_id` (`kondisi_bts_id`);

--
-- Indexes for table `tbl_kkp`
--
ALTER TABLE `tbl_kkp`
  ADD PRIMARY KEY (`id_kkp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bobot_preferensi`
--
ALTER TABLE `bobot_preferensi`
  MODIFY `id_bobot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kondisi_bts`
--
ALTER TABLE `kondisi_bts`
  MODIFY `id_kondisi_bts` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `kd_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_alternatif`
--
ALTER TABLE `tbl_alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_kkp`
--
ALTER TABLE `tbl_kkp`
  MODIFY `id_kkp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_alternatif`
--
ALTER TABLE `tbl_alternatif`
  ADD CONSTRAINT `tbl_alternatif_ibfk_1` FOREIGN KEY (`kondisi_bts_id`) REFERENCES `kondisi_bts` (`id_kondisi_bts`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
