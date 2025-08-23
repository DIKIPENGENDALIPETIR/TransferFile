-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 23 Agu 2025 pada 08.56
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `transferfile`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `time` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transferfile`
--

CREATE TABLE `transferfile` (
  `id` int NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `key_hash` varchar(255) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `transferfile`
--

INSERT INTO `transferfile` (`id`, `sender_id`, `receiver_id`, `original_name`, `file_path`, `key_hash`, `uploaded_at`) VALUES
(1, 1, 2, 'Slide1.jpg', 'assets/uploads/683b013ed9495.jpg', '04aa2447db1ee8a4bf8000b89161972d99ed6dfb68240bc5ec31af9a23387958', '2025-05-31 13:16:46'),
(2, 4, 3, 'WhatsAppImage2025-04-17at20.56.17_617b630c.jpg', 'assets/uploads/6851d9cfdd0d9.jpg', '68273730ffea9331f843b3bec853f04d183ab4e765f06a8fd4a69d5cce18e4bf', '2025-06-17 21:10:39'),
(3, 3, 4, 'WhatsAppImage2025-04-17at23.58.53_78928c7a.jpg', 'assets/uploads/6852418b061e8.jpg', '661eae7d4bcd6af592a3a329f89f90af7cd98f5df7238305950eafd4186501b1', '2025-06-18 04:33:15'),
(4, 6, 5, 'ChatGPTImage5Mei202520.13.29.png', 'assets/uploads/6864beabd324c.png', 'a40a61e62dcdca674dcccb35cae449f411e6e29749dd0d006233db3065374a5a', '2025-07-02 05:07:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'mochdtp@gmail.com', '$2y$10$dka5aVXsRO85uV1h8lG/uuKdNYJdgU7pN2WZqcZ6rJ6.P9kkvwzCe', '2025-05-31 13:10:04'),
(2, 'diki@gmail.com', '$2y$10$69/KtFqJQYyag6UGPnDfhOUsBkVADl8yb96/Ff65Q4E3S0xDUjlny', '2025-05-31 13:10:11'),
(3, 'pranata@gmail.com', '$2y$10$ysp/bxinfDfI9aesvnpzT.8z4PFyItLWo8Q1.KkVNt0R8OvXY2c1W', '2025-06-17 21:09:50'),
(4, 'tri@gmail.com', '$2y$10$olyH.AjlOJ3Lfl9MVRSsw.d1LJID2qOJn4xRHraS7PbIY9H7VExBu', '2025-06-17 21:10:04'),
(5, 'amanda12@gmail.com', '$2y$10$HzAD/nhgviNs4V01pk2ZTOF15mqdaPaLY4C9xpvy/DD74VXZsjbM2', '2025-07-02 05:03:50'),
(6, 'adelia@gmail.com', '$2y$10$GL3FuxZgo0L.B1x5GIF9P.iiPV/HhDSLXieX3/sRIaXzAwWuqCgte', '2025-07-02 05:05:19'),
(7, 'admin@gmail.com', '$2y$10$TAZ7h6ZPtlysqmxHHaKW1uKX0xDVI/r5V3hqS75M9Zya87x/lNp3u', '2025-08-23 08:55:20'),
(8, 'admin2@gmail.com', '$2y$10$min9bPRtJMtcNHHZZ6cJEOI4KbtnNV1Xkvbe32WbD4PvMZQ4kveYu', '2025-08-23 08:55:31');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indeks untuk tabel `transferfile`
--
ALTER TABLE `transferfile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transferfile`
--
ALTER TABLE `transferfile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `transferfile`
--
ALTER TABLE `transferfile`
  ADD CONSTRAINT `transferfile_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transferfile_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
