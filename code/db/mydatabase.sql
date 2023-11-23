-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Nov 23, 2023 at 08:14 PM
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
(1, 8, 3, 'lalachan', '.jpg', 'This is beautiful.', '2023-11-22 10:04:45'),
(2, 8, 3, 'lalachan', '.jpg', 'Nice view.', '2023-11-22 10:06:46'),
(3, 8, 3, 'lalachan', '.jpg', 'This would be great.', '2023-11-22 10:26:26'),
(4, 44, 3, 'lalachan', '.jpg', 'comment', '2023-11-23 14:37:52'),
(5, 44, 3, 'lalachan', '.jpg', 'This is beautiful.', '2023-11-23 14:39:03'),
(6, 44, 3, 'lalachan', '.jpg', 'Nice view.', '2023-11-23 14:40:04'),
(7, 44, 3, 'lalachan', '.jpg', 'This would be great.', '2023-11-23 14:43:02'),
(8, 44, 3, 'lalachan', '.jpg', 'Nice view.', '2023-11-23 14:43:28'),
(9, 44, 3, 'lalachan', '.jpg', 'comment', '2023-11-23 14:58:25'),
(10, 44, 3, 'lalachan', '.jpg', 'This is beautiful.', '2023-11-23 14:59:07'),
(11, 44, 3, 'lalachan', '.jpg', 'This would be great.', '2023-11-23 15:25:42'),
(12, 44, 3, 'lalachan', '.jpg', 'This would be great.', '2023-11-23 15:34:48'),
(13, 44, 3, 'lalachan', '.jpg', 'comment', '2023-11-23 15:39:19'),
(14, 44, 3, 'lalachan', '.jpg', 'Nice view.', '2023-11-23 15:40:32'),
(15, 44, 3, 'lalachan', '.jpg', 'Nice view.', '2023-11-23 19:53:28');

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

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(3, 3, 8);

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
(43, 3, 0, 'captured_image_1700746985.png', 'stamp test1', '#camp', '2023-11-23 13:43:05', 'lalachan', '.jpg'),
(44, 3, 0, 'uploaded_image_1700747409.jpg', 'akita', '#beautiful', '2023-11-23 13:50:09', 'lalachan', '.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `followers` int DEFAULT '0',
  `following` int DEFAULT '0',
  `post` int DEFAULT '0',
  `bio` text,
  `notification` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `image`, `followers`, `following`, `post`, `bio`, `notification`) VALUES
(3, 'lalachan', '27eeed98161b93ae1e3e185b2f143744', 'ruruover1105@gmail.com', '.jpg', 0, 0, 42, 'Hello :0                                          ', 1),
(4, 'moko', '27eeed98161b93ae1e3e185b2f143744', 'moko0226@gmail.com', 'moko.jpg', 0, 0, 0, 'This is moko :0                                          ', 1);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `followings`
--
ALTER TABLE `followings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
