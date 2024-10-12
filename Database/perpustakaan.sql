-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2024 at 08:25 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `shelf` varchar(50) DEFAULT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `shelf`, `stok`) VALUES
(1, 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Novel', 20),
(2, 'Laskar Pelangi', 'Andrea Hirata', 'Novel', 15),
(3, 'Negeri 5 Menara', 'Ahmad Fuadi', 'Novel', 10),
(5, 'Rantau 1 Muara', 'Ahmad Fuadi', 'Novel', 9),
(6, 'Sang Pemimpi', 'Andrea Hirata', 'Novel', 15),
(7, 'Hujan', 'Tere Liye', 'Novel', 10),
(8, 'The Life of Chairil Anwar', 'Sapardi Djoko Damono', 'Biografi', 15),
(9, 'Kisah Hidup dan Perjuangan Mohammad Hatta', 'Eyang Mardjuki', 'Biografi', 10),
(10, ' Ensiklopedi Nasional Indonesia', 'Departemen Pendidikan dan Kebudayaan RI', 'Ensiklopedia', 10),
(11, 'Ensiklopedi Sejarah Dunia', 'William L. Langer', 'Ensiklopedia', 20),
(12, 'Ensiklopedia Sains & Teknologi', 'Tim Penulis Grolier', 'Ensiklopedia', 15);

-- --------------------------------------------------------

--
-- Table structure for table `peminjam`
--

CREATE TABLE `peminjam` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `return_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjam`
--

INSERT INTO `peminjam` (`id`, `user_id`, `book_id`, `borrow_date`, `return_date`) VALUES
(1, 5, 1, '2024-10-10 12:59:07', '2024-10-10 13:01:16'),
(2, 5, 1, '2024-10-10 13:01:15', '2024-10-10 13:01:16'),
(3, 5, 1, '2024-10-10 13:01:21', '2024-10-10 13:01:34'),
(4, 5, 1, '2024-10-10 13:01:21', '2024-10-10 13:01:34'),
(5, 5, 1, '2024-10-10 13:01:21', '2024-10-10 13:01:34'),
(6, 5, 1, '2024-10-10 13:01:21', '2024-10-10 13:01:34'),
(7, 5, 1, '2024-10-10 13:01:22', '2024-10-10 13:01:34'),
(8, 5, 1, '2024-10-10 13:01:22', '2024-10-10 13:01:34'),
(9, 5, 1, '2024-10-10 13:01:33', '2024-10-10 13:01:34'),
(10, 5, 1, '2024-10-10 13:01:36', '2024-10-10 13:04:46'),
(11, 5, 1, '2024-10-10 13:04:48', '2024-10-10 13:04:50'),
(12, 5, 1, '2024-10-10 13:04:52', '2024-10-10 13:04:53'),
(13, 5, 1, '2024-10-10 13:04:54', '2024-10-10 13:04:59'),
(14, 5, 1, '2024-10-10 13:05:00', '2024-10-10 13:05:02'),
(15, 5, 1, '2024-10-10 13:05:02', '2024-10-10 13:05:04'),
(16, 5, 1, '2024-10-10 13:05:05', '2024-10-10 13:05:05'),
(17, 5, 1, '2024-10-10 13:07:39', '2024-10-10 13:07:41'),
(18, 5, 1, '2024-10-10 13:07:43', '2024-10-10 13:07:46'),
(19, 5, 1, '2024-10-10 13:07:47', '2024-10-10 13:07:52'),
(20, 5, 1, '2024-10-10 17:14:24', '2024-10-10 17:14:25'),
(21, 5, 2, '2024-10-10 17:14:26', '2024-10-10 17:14:39'),
(22, 5, 3, '2024-10-10 17:14:28', '2024-10-10 17:14:40'),
(23, 5, 1, '2024-10-12 06:03:59', '2024-10-12 06:04:08'),
(24, 9, 1, '2024-10-12 06:16:20', '2024-10-12 06:16:23'),
(25, 9, 7, '2024-10-12 06:16:52', '2024-10-12 06:16:54'),
(26, 9, 5, '2024-10-12 06:17:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','peminjam') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@email', 'admin', 'admin', '2024-10-06 16:53:32'),
(5, 'khoir', 'khoir@email', 'khoir', 'peminjam', '2024-10-09 09:44:04'),
(9, 'musa', 'musa@email.com', 'musa', 'peminjam', '2024-10-12 06:10:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjam`
--
ALTER TABLE `peminjam`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `password` (`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `peminjam`
--
ALTER TABLE `peminjam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjam`
--
ALTER TABLE `peminjam`
  ADD CONSTRAINT `peminjam_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
