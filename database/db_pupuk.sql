-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Jun 2025 pada 06.53
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pupuk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_distribusi_pupuk`
--

CREATE TABLE `tb_distribusi_pupuk` (
  `id_distribusi_pupuk` int(11) NOT NULL,
  `id_kebutuhan` int(11) NOT NULL,
  `id_lahan` int(11) NOT NULL,
  `id_pupuk` int(11) NOT NULL,
  `id_petani` int(11) NOT NULL,
  `id_tanaman` int(11) NOT NULL,
  `jumlah_distribusi` decimal(10,2) NOT NULL,
  `status_distribusi` enum('Belum Dikirim','Sebagian Dikirim','Terkirim','Ditunda') NOT NULL,
  `tanggal_distribusi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_distribusi_pupuk`
--

INSERT INTO `tb_distribusi_pupuk` (`id_distribusi_pupuk`, `id_kebutuhan`, `id_lahan`, `id_pupuk`, `id_petani`, `id_tanaman`, `jumlah_distribusi`, `status_distribusi`, `tanggal_distribusi`) VALUES
(1, 1, 1, 1, 1, 1, 2.00, 'Terkirim', '2025-05-10'),
(5, 4, 2, 2, 2, 2, 3.00, 'Terkirim', '2025-05-09'),
(7, 1, 1, 1, 1, 1, 9.00, 'Terkirim', '2025-05-23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kebutuhan_pupuk`
--

CREATE TABLE `tb_kebutuhan_pupuk` (
  `id_kebutuhan` int(11) NOT NULL,
  `id_lahan` int(11) NOT NULL,
  `id_pupuk` int(11) NOT NULL,
  `id_petani` int(11) NOT NULL,
  `id_tanaman` int(11) NOT NULL,
  `kebutuhan_pupuk` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kebutuhan_pupuk`
--

INSERT INTO `tb_kebutuhan_pupuk` (`id_kebutuhan`, `id_lahan`, `id_pupuk`, `id_petani`, `id_tanaman`, `kebutuhan_pupuk`) VALUES
(1, 1, 1, 1, 1, 0.20),
(4, 2, 2, 2, 2, 0.60),
(5, 3, 1, 3, 5, 2.50);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lahan`
--

CREATE TABLE `tb_lahan` (
  `id_lahan` int(11) NOT NULL,
  `id_petani` int(11) NOT NULL,
  `luas_lahan` decimal(20,2) NOT NULL,
  `id_tanaman` int(11) NOT NULL,
  `masa_tanam` varchar(50) NOT NULL,
  `id_pupuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_lahan`
--

INSERT INTO `tb_lahan` (`id_lahan`, `id_petani`, `luas_lahan`, `id_tanaman`, `masa_tanam`, `id_pupuk`) VALUES
(1, 1, 200.00, 1, '1 bulan', 1),
(2, 2, 300.00, 2, '1.5 bulan', 2),
(3, 3, 500.00, 5, '6 bulan', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_petani`
--

CREATE TABLE `tb_petani` (
  `id_petani` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nik` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_petani`
--

INSERT INTO `tb_petani` (`id_petani`, `nama`, `nik`, `alamat`, `id_user`) VALUES
(1, 'Monang', '12345678123456', 'Jl. Pane', 3),
(2, 'Surei', '123412341234', 'Jl. Pakis', 3),
(3, 'Mona', '1234567891234567', 'Jl. Sibayak', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pupuk`
--

CREATE TABLE `tb_pupuk` (
  `id_pupuk` int(11) NOT NULL,
  `nama_pupuk` varchar(100) NOT NULL,
  `jenis_pupuk` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pupuk`
--

INSERT INTO `tb_pupuk` (`id_pupuk`, `nama_pupuk`, `jenis_pupuk`) VALUES
(1, 'NPK', 'Anorganika'),
(2, 'Kompos', 'Organika');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tanaman`
--

CREATE TABLE `tb_tanaman` (
  `id_tanaman` int(11) NOT NULL,
  `nama_tanaman` varchar(100) DEFAULT NULL,
  `dosis_per_hektar` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_tanaman`
--

INSERT INTO `tb_tanaman` (`id_tanaman`, `nama_tanaman`, `dosis_per_hektar`) VALUES
(1, 'Padi', 10.00),
(2, 'Jagung', 20.00),
(5, 'Cokelat Tua', 50.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','petugas','petani') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin'),
(2, 'petugas', '670489f94b6997a870b148f74744ee5676304925', 'petugas'),
(3, 'petani', '21a4c8d9d2dca6dffbb1a313de8238df3e838a2d', 'petani');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_distribusi_pupuk`
--
ALTER TABLE `tb_distribusi_pupuk`
  ADD PRIMARY KEY (`id_distribusi_pupuk`);

--
-- Indeks untuk tabel `tb_kebutuhan_pupuk`
--
ALTER TABLE `tb_kebutuhan_pupuk`
  ADD PRIMARY KEY (`id_kebutuhan`);

--
-- Indeks untuk tabel `tb_lahan`
--
ALTER TABLE `tb_lahan`
  ADD PRIMARY KEY (`id_lahan`);

--
-- Indeks untuk tabel `tb_petani`
--
ALTER TABLE `tb_petani`
  ADD PRIMARY KEY (`id_petani`);

--
-- Indeks untuk tabel `tb_pupuk`
--
ALTER TABLE `tb_pupuk`
  ADD PRIMARY KEY (`id_pupuk`);

--
-- Indeks untuk tabel `tb_tanaman`
--
ALTER TABLE `tb_tanaman`
  ADD PRIMARY KEY (`id_tanaman`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_distribusi_pupuk`
--
ALTER TABLE `tb_distribusi_pupuk`
  MODIFY `id_distribusi_pupuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_kebutuhan_pupuk`
--
ALTER TABLE `tb_kebutuhan_pupuk`
  MODIFY `id_kebutuhan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_lahan`
--
ALTER TABLE `tb_lahan`
  MODIFY `id_lahan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_petani`
--
ALTER TABLE `tb_petani`
  MODIFY `id_petani` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_pupuk`
--
ALTER TABLE `tb_pupuk`
  MODIFY `id_pupuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_tanaman`
--
ALTER TABLE `tb_tanaman`
  MODIFY `id_tanaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
