-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Nov 29, 2023 at 04:38 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `profile_image` text NOT NULL,
  `comment_text` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `username`, `profile_image`, `comment_text`, `date`) VALUES
(19, 45, 10, 'ruru', 'https://res.cloudinary.com/dh4r0lwag/image/upload/v1701275383/uploads/d0tinunhhhdauiutcrxy.png', 'This is beautiful.', '2023-11-24 10:10:02'),
(20, 48, 11, 'lala', 'logo.png', 'This is beautiful.', '2023-11-24 10:30:44');

-- --------------------------------------------------------

--
-- Table structure for table `followings`
--

CREATE TABLE `followings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `other_user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `likes` int NOT NULL,
  `image` text NOT NULL,
  `caption` varchar(250) NOT NULL,
  `hashtags` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(50) NOT NULL,
  `profile_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `likes`, `image`, `caption`, `hashtags`, `date`, `username`, `profile_image`) VALUES
(50, 10, 0, 'https://res.cloudinary.com/dh4r0lwag/image/upload/v1701271394/uploads/eqbhtkmsdhust8rlmzlj.png', 'a', 'a', '2023-11-29 15:23:11', 'ruru', 'https://res.cloudinary.com/dh4r0lwag/image/upload/v1701275383/uploads/d0tinunhhhdauiutcrxy.png'),
(51, 10, 0, 'https://res.cloudinary.com/dh4r0lwag/image/upload/v1701273325/uploads/apednoh0bpzavm6gcjbm.png', 'b', 'b', '2023-11-29 15:55:22', 'ruru', 'https://res.cloudinary.com/dh4r0lwag/image/upload/v1701275383/uploads/d0tinunhhhdauiutcrxy.png'),
(52, 10, 0, 'https://res.cloudinary.com/dh4r0lwag/image/upload/v1701273529/uploads/vuaqn9xvs8on8dgy4yj5.png', 'c', 'c', '2023-11-29 15:58:46', 'ruru', 'https://res.cloudinary.com/dh4r0lwag/image/upload/v1701275383/uploads/d0tinunhhhdauiutcrxy.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) NOT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `followers` int DEFAULT '0',
  `following` int DEFAULT '0',
  `post` int DEFAULT '0',
  `bio` text,
  `notification` tinyint(1) NOT NULL DEFAULT '1',
  `email_confirm_token` varchar(32) NOT NULL,
  `email_confirmed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `image`, `followers`, `following`, `post`, `bio`, `notification`, `email_confirm_token`, `email_confirmed`) VALUES
(10, 'ruru', 'aed64604da40b52ea0edf963840fc53d', 'ruruover1105@gmail.com', 'https://res.cloudinary.com/dh4r0lwag/image/upload/v1701275383/uploads/d0tinunhhhdauiutcrxy.png', 0, 0, 8, 'not set yet', 1, 'a82b7ef3d096908202be3f333354e5dc', 1),
(12, 'lala', 'aed64604da40b52ea0edf963840fc53d', 'ruruover1105@gmail.com', 'https://res.cloudinary.com/dh4r0lwag/image/upload/v1701272255/uploads/a30qhsalpfrquzrvyknj.jpg', 0, 0, 0, 'not set yet', 1, '43d1232bc6d34e760be685f99fce4e26', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followings`
--
ALTER TABLE `followings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `followings`
--
ALTER TABLE `followings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
