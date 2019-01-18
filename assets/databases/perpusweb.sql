-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 18, 2019 at 09:27 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpusweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `IdBuku` varchar(6) NOT NULL,
  `idPetugas` varchar(6) DEFAULT NULL,
  `NamaBuku` varchar(50) NOT NULL,
  `Stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`IdBuku`, `idPetugas`, `NamaBuku`, `Stock`) VALUES
('BK0001', 'PT0001', 'Naruto', 10),
('BK0002', 'PT0001', 'Buku 2', 9),
('BK0003', 'PT0001', 'Buku 3', 9),
('BK0004', NULL, 'Black Clover', 9),
('BK0005', NULL, 'Naruti', 10);

-- --------------------------------------------------------

--
-- Stand-in structure for view `kembali`
-- (See below for the actual view)
--
CREATE TABLE `kembali` (
`NamaBuku` varchar(50)
,`NamaMember` varchar(50)
,`NamaPetugas` varchar(50)
,`JumlahPinjam` int(11)
,`tglkembali` date
);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `IdMember` varchar(6) NOT NULL,
  `idPetugas` varchar(6) DEFAULT NULL,
  `NamaMember` varchar(50) NOT NULL,
  `JenisKelamin` char(1) DEFAULT NULL,
  `Alamat` varchar(100) NOT NULL,
  `Tlp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`IdMember`, `idPetugas`, `NamaMember`, `JenisKelamin`, `Alamat`, `Tlp`) VALUES
('MB0001', 'PT0002', 'Wahyu', 'L', 'Nganjuk', '081xxxx'),
('MB0002', 'PT0001', 'Handika', 'L', 'Nganjuk', '081xxx'),
('MB0003', 'PT0002', 'Aldy', 'L', 'Magelang', '081xxxx'),
('MB0004', 'PT0002', 'Rose', 'L', 'Singosari', '090');

-- --------------------------------------------------------

--
-- Stand-in structure for view `peminjaman`
-- (See below for the actual view)
--
CREATE TABLE `peminjaman` (
`idPinjam` int(100)
,`NamaBuku` varchar(50)
,`NamaMember` varchar(50)
,`NamaPetugas` varchar(50)
,`JumlahPinjam` int(11)
,`tglpinjam` date
,`hrskembali` date
);

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `IdPetugas` varchar(6) NOT NULL,
  `password` varchar(16) NOT NULL,
  `NamaPetugas` varchar(50) NOT NULL,
  `jk` char(1) DEFAULT NULL,
  `Alamat` varchar(100) DEFAULT NULL,
  `Tlp` varchar(15) NOT NULL,
  `hakAkses` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`IdPetugas`, `password`, `NamaPetugas`, `jk`, `Alamat`, `Tlp`, `hakAkses`) VALUES
('PT0001', '1', 'Elfain', 'L', 'Malang', '909', 'Book'),
('PT0002', '1', 'Abifian', 'L', 'Malang', '081xxxx', 'Admin'),
('PT0003', '1', 'Elrie', 'L', 'Singosari', '212', 'Desk'),
('PT0004', '1', 'Rikka', 'P', 'Berau', '121', 'Book');

-- --------------------------------------------------------

--
-- Table structure for table `pinjam`
--

CREATE TABLE `pinjam` (
  `idPinjam` int(100) NOT NULL,
  `IdPetugas` varchar(6) NOT NULL,
  `IdMember` varchar(6) NOT NULL,
  `IdBuku` varchar(6) NOT NULL,
  `JumlahPinjam` int(11) NOT NULL,
  `TglPinjam` date NOT NULL,
  `TglKembali` date DEFAULT NULL,
  `Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pinjam`
--

INSERT INTO `pinjam` (`idPinjam`, `IdPetugas`, `IdMember`, `IdBuku`, `JumlahPinjam`, `TglPinjam`, `TglKembali`, `Status`) VALUES
(7, 'PT0001', 'MB0001', 'BK0001', 1, '2018-07-09', '2019-01-17', 'Kembali'),
(22, 'pt0001', 'MB0001', 'BK0001', 1, '2018-07-09', '2018-07-10', 'Kembali'),
(23, 'pt0001', 'MB0001', 'BK0002', 1, '2018-07-09', NULL, 'Pinjam'),
(24, 'pt0001', 'MB0001', 'BK0003', 1, '2018-07-09', NULL, 'Pinjam'),
(25, 'PT0002', 'MB0001', 'BK0004', 1, '2019-01-17', NULL, 'Pinjam');

--
-- Triggers `pinjam`
--
DELIMITER $$
CREATE TRIGGER `hapus` AFTER DELETE ON `pinjam` FOR EACH ROW UPDATE buku
SET Stock = Stock + old.JumlahPinjam
WHERE idbuku = old.idbuku
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `kembali` AFTER UPDATE ON `pinjam` FOR EACH ROW UPDATE buku
SET Stock = Stock + new.JumlahPinjam
WHERE idbuku = NEW.idbuku
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pinjam` AFTER INSERT ON `pinjam` FOR EACH ROW UPDATE buku
SET Stock = Stock - new.JumlahPinjam
WHERE idbuku = NEW.idbuku
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure for view `kembali`
--
DROP TABLE IF EXISTS `kembali`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `kembali`  AS  select `buku`.`NamaBuku` AS `NamaBuku`,`member`.`NamaMember` AS `NamaMember`,`petugas`.`NamaPetugas` AS `NamaPetugas`,`pinjam`.`JumlahPinjam` AS `JumlahPinjam`,`pinjam`.`TglKembali` AS `tglkembali` from (((`buku` join `member`) join `pinjam`) join `petugas`) where ((`buku`.`IdBuku` = `pinjam`.`IdBuku`) and (`member`.`IdMember` = `pinjam`.`IdMember`) and (`petugas`.`IdPetugas` = `pinjam`.`IdPetugas`) and (`pinjam`.`Status` = 'Kembali')) ;

-- --------------------------------------------------------

--
-- Structure for view `peminjaman`
--
DROP TABLE IF EXISTS `peminjaman`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `peminjaman`  AS  select `pinjam`.`idPinjam` AS `idPinjam`,`buku`.`NamaBuku` AS `NamaBuku`,`member`.`NamaMember` AS `NamaMember`,`petugas`.`NamaPetugas` AS `NamaPetugas`,`pinjam`.`JumlahPinjam` AS `JumlahPinjam`,`pinjam`.`TglPinjam` AS `tglpinjam`,(`pinjam`.`TglPinjam` + interval 7 day) AS `hrskembali` from (((`buku` join `member`) join `pinjam`) join `petugas`) where ((`buku`.`IdBuku` = `pinjam`.`IdBuku`) and (`member`.`IdMember` = `pinjam`.`IdMember`) and (`petugas`.`IdPetugas` = `pinjam`.`IdPetugas`) and (`pinjam`.`Status` = 'Pinjam')) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`IdBuku`),
  ADD KEY `fk_idpetugas_buku` (`idPetugas`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`IdMember`),
  ADD KEY `fk_idpetugas_member` (`idPetugas`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`IdPetugas`);

--
-- Indexes for table `pinjam`
--
ALTER TABLE `pinjam`
  ADD PRIMARY KEY (`idPinjam`),
  ADD KEY `IdMember` (`IdMember`),
  ADD KEY `IdBuku` (`IdBuku`),
  ADD KEY `fk_IdPetugas` (`IdPetugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pinjam`
--
ALTER TABLE `pinjam`
  MODIFY `idPinjam` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `fk_idpetugas_buku` FOREIGN KEY (`idPetugas`) REFERENCES `petugas` (`IdPetugas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `fk_idpetugas_member` FOREIGN KEY (`idPetugas`) REFERENCES `petugas` (`IdPetugas`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
