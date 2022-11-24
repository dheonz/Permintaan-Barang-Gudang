-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Apr 2022 pada 13.47
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gudang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id_jenis` varchar(50) NOT NULL,
  `jenis_brg` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_barang`
--

INSERT INTO `jenis_barang` (`id_jenis`, `jenis_brg`) VALUES
('1', 'Assesories'),
('2', 'Oli/Pelumas'),
('3', 'Sparepart');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `kode_brg` varchar(15) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_keluar` date NOT NULL,
  `sift` enum('Sift 1','Sift 2','Sift 3') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengeluaran`
--

INSERT INTO `pengeluaran` (`id`, `unit`, `kode_brg`, `jumlah`, `tgl_keluar`, `sift`) VALUES
(29, 'naufal', 'BR002', 5, '2022-04-18', 'Sift 1'),
(30, 'naufal', 'BR006', 2, '2022-04-18', 'Sift 1'),
(31, 'adem', 'BR003', 4, '2022-04-22', 'Sift 1'),
(32, 'satu', 'SHARP0015', 1, '2022-04-22', 'Sift 1');

--
-- Trigger `pengeluaran`
--
DELIMITER $$
CREATE TRIGGER `TG_STOK_UPDATE` AFTER INSERT ON `pengeluaran` FOR EACH ROW BEGIN
	update stokbarang SET keluar=keluar + NEW.jumlah, 
	sisa=stok-keluar WHERE 
	kode_brg = NEW.kode_brg;

	update permintaan SET status=1 WHERE kode_brg=NEW.kode_brg AND 
	unit=NEW.unit;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permintaan`
--

CREATE TABLE `permintaan` (
  `id_permintaan` int(100) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `kode_brg` varchar(15) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_permintaan` date NOT NULL,
  `nama_karyawan` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `sift` enum('Sift 1','Sift 2','Sift 3') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `permintaan`
--

INSERT INTO `permintaan` (`id_permintaan`, `unit`, `kode_brg`, `id_jenis`, `jumlah`, `tgl_permintaan`, `nama_karyawan`, `status`, `sift`) VALUES
(40, 'naufal', 'BR002', 1, 5, '2022-04-18', 'Andriansyah', 1, 'Sift 1'),
(41, 'naufal', 'BR006', 2, 2, '2022-04-18', 'Andriansyah', 1, 'Sift 1'),
(42, 'adem', 'BR003', 1, 4, '2022-04-22', 'Rian', 1, 'Sift 1'),
(44, 'satu', 'SHARP0015', 1, 1, '2022-04-22', 'Andriansyah', 1, 'Sift 1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sementara`
--

CREATE TABLE `sementara` (
  `id_sementara` int(100) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `kode_brg` varchar(15) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_permintaan` date NOT NULL,
  `nama_karyawan` varchar(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `sift` enum('Sift 1','Sift 2','Sift 3') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stokbarang`
--

CREATE TABLE `stokbarang` (
  `kode_brg` varchar(15) NOT NULL,
  `id_jenis` int(2) NOT NULL,
  `nama_brg` varchar(30) NOT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `stok` int(11) NOT NULL,
  `keluar` int(11) DEFAULT 0,
  `sisa` int(11) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `suplier` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `stokbarang`
--

INSERT INTO `stokbarang` (`kode_brg`, `id_jenis`, `nama_brg`, `satuan`, `stok`, `keluar`, `sisa`, `tgl_masuk`, `suplier`) VALUES
('BR001', 1, 'Bend PVC RR 2x90', 'Buah', 100, 10, 90, '2022-03-15', ''),
('BR002', 1, 'Grease Draton', 'Kg', 20, 6, 14, '2022-03-15', ''),
('BR003', 1, 'Skun Kabel  50 mm', 'Buah', 100, 4, 96, '2022-03-15', 'Dheonz'),
('BR004', 1, 'Bend PVC RR Ã˜ 6x90', 'Buah', 144, 4, 140, '2022-03-15', ''),
('BR005', 1, 'Faucet Socket PVC Ã˜ 3', 'Buah', 13, 0, 13, '2022-03-15', ''),
('BR007', 2, 'Minyak Compressor SAE 30', 'Liter', 12, 0, 12, '2022-03-15', ''),
('BR008', 2, 'Minyak Hidrolex Ã˜ SAE 10', 'Liter', 68, 0, 68, '2022-03-15', ''),
('BR009', 2, 'Minyak Diala C/B', 'Liter', 180, 7, 173, '2022-03-15', ''),
('BR010', 3, 'Skun Kabel  50 mm', 'Buah', 100, 0, 100, '2022-03-15', ''),
('BR011', 3, 'Terminal KB SPB 60', 'Buah', 50, 5, 45, '2022-03-15', ''),
('BR012', 3, 'Push Button', 'Buah', 5, 3, 2, '2022-03-15', ''),
('BR013', 3, 'Dynamo  Star Yanmar 12V', 'Buah', 25, 1, 24, '2022-03-15', ''),
('BR014', 3, 'Kabel NYY 2x2,5mm', 'Meter', 100, 0, 100, '2022-03-15', ''),
('SHARP0015', 1, 'Skun Kabel  100 mm', 'Buah', 100, 1, 99, '2022-03-23', 'Dheonz');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('produksi','admin_gudang') NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `bagian` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `level`, `jabatan`, `bagian`) VALUES
(13, 'Ade Marta Di Kusuma', 'adem', '827ccb0eea8a706c4c34a16891f84e7b', 'produksi', 'Leader', 'Produksi'),
(14, 'Muhammad Naufal Aristian', 'Admin', '827ccb0eea8a706c4c34a16891f84e7b', 'admin_gudang', 'Admin', 'Gudang'),
(19, 'Muhammad Naufal Aristian', 'naufal', '827ccb0eea8a706c4c34a16891f84e7b', 'produksi', 'Leader', 'Produksi'),
(22, 'M. Azharuddin, S.T', 'satu', '827ccb0eea8a706c4c34a16891f84e7b', 'produksi', 'Leader', 'Produksi');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`id_permintaan`);

--
-- Indeks untuk tabel `sementara`
--
ALTER TABLE `sementara`
  ADD PRIMARY KEY (`id_sementara`);

--
-- Indeks untuk tabel `stokbarang`
--
ALTER TABLE `stokbarang`
  ADD PRIMARY KEY (`kode_brg`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  MODIFY `id_permintaan` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `sementara`
--
ALTER TABLE `sementara`
  MODIFY `id_sementara` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
