-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2024 at 09:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `requisitionlist`
--

CREATE TABLE `requisitionlist` (
  `id` int(11) NOT NULL,
  `subd` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `byuser` varchar(10) NOT NULL,
  `item` varchar(50) NOT NULL,
  `qty` double NOT NULL,
  `reason` varchar(30) DEFAULT NULL,
  `person` varchar(50) NOT NULL,
  `value` double NOT NULL,
  `slip` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `role` varchar(15) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `poqty` double NOT NULL,
  `pqty` double NOT NULL,
  `purchaser` varchar(10) NOT NULL,
  `stock` double NOT NULL,
  `comments` varchar(50) DEFAULT NULL,
  `fqty` double NOT NULL,
  `fcomments` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requisitionlist`
--

INSERT INTO `requisitionlist` (`id`, `subd`, `byuser`, `item`, `qty`, `reason`, `person`, `value`, `slip`, `date`, `remarks`, `role`, `status`, `poqty`, `pqty`, `purchaser`, `stock`, `comments`, `fqty`, `fcomments`) VALUES
(150, '2024-04-28 17:40:54', 'b', 'Wire Cat 6 Internet Cable Meter', 2, 'erwewe', 'IT dept Kowshique', 0, '023445', '2024-04-28', 'N/Aewerwe', 'store', 2, 0, 0, '', 0, NULL, 0, NULL),
(151, '2024-04-29 17:13:15', 'b', 'Wire Cat 6 Internet Cable Meter', 30, '', 'IT dept Kowshique', 0, '0', '2024-04-28', '', 'store', 3, 0, 0, 'c', 78, NULL, 0, NULL),
(152, '2024-04-29 20:10:52', 'b', 'Wire Cat 6 Internet Cable Meter', 3, '', 'IT dept Kowshique', 1234, '0', '2024-04-28', '', 'store', 3, 19, 3, 'c', 78, NULL, 3, 'N/A'),
(153, '2024-04-29 20:31:51', 'b', 'Wire Cat 6 Internet Cable Meter', 2, '', 'IT dept Kowshique', 200, '0', '2024-04-29', '', 'store', 0, 0, 3, 'c', 78, '.', 2, 'N/A'),
(154, '2024-04-29 20:12:52', 'b', 'Wire Cat 6 Internet Cable Meter', 2, '', 'IT dept Kowshique', 0, '0', '2024-04-29', '.', 'store', 5, 2, 2, 'c', 0, NULL, 0, NULL),
(155, '2024-04-29 20:31:29', 'b', 'New Item Test', 222, '', 'IT dept Kowshique', 0, '02222', '2024-04-29', '', 'store', 0, 0, 0, '', 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `select_boxi`
--

CREATE TABLE `select_boxi` (
  `sbid` int(11) NOT NULL,
  `select_box_name` varchar(50) NOT NULL,
  `role` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `select_boxi`
--

INSERT INTO `select_boxi` (`sbid`, `select_box_name`, `role`) VALUES
(56, 'Wire Cat 6 Internet Cable Meter', 'store'),
(57, 'New Item Test', 'store');

-- --------------------------------------------------------

--
-- Table structure for table `select_boxp`
--

CREATE TABLE `select_boxp` (
  `sbid` int(11) NOT NULL,
  `select_box_name` varchar(50) NOT NULL,
  `role` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `select_boxp`
--

INSERT INTO `select_boxp` (`sbid`, `select_box_name`, `role`) VALUES
(49, 'IT dept Kowshique', 'store');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id` int(11) NOT NULL,
  `subd` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `byuser` varchar(10) NOT NULL,
  `item` varchar(50) NOT NULL,
  `ins` double NOT NULL,
  `outs` double NOT NULL,
  `reason` varchar(30) DEFAULT NULL,
  `person` varchar(50) NOT NULL,
  `value` double NOT NULL,
  `slip` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `mfg` date NOT NULL,
  `exp` date NOT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `role` varchar(15) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `subd`, `byuser`, `item`, `ins`, `outs`, `reason`, `person`, `value`, `slip`, `date`, `mfg`, `exp`, `remarks`, `role`, `status`) VALUES
(143, '2024-04-28 17:27:38', 'b', 'Wire Cat 6 Internet Cable Meter', 50, 0, 'New Line Reason', 'IT dept Kowshique', 1000, '123456', '2024-04-28', '2024-04-28', '2025-04-28', 'Black Outdoor', 'store', 0),
(144, '2024-04-28 17:40:54', 'b', 'Wire Cat 6 Internet Cable Meter', 0, 2, '2', 'IT dept Kowshique', 40, '0', '2024-04-28', '2024-04-28', '2025-04-28', '', 'store', 0),
(145, '2024-04-28 18:35:47', 'b', 'Wire Cat 6 Internet Cable Meter', 30, 0, '', 'IT dept Kowshique', 20, '0', '2024-04-29', '2024-04-29', '2025-04-29', '', 'store', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `role` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `status`, `role`, `password`, `date`) VALUES
(25, 'a', 0, 'admin', '0cc175b9c0f1b6a831c399e269772661', '2024-04-26 15:41:39'),
(27, 'b', 0, 'store', '92eb5ffee6ae2fec3ad71c777531578f', '2024-04-26 15:43:10'),
(28, 'c', 0, 'purchaser', '4a8a08f09d37b73795649038408b5f33', '2024-04-28 16:13:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `requisitionlist`
--
ALTER TABLE `requisitionlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `select_boxi`
--
ALTER TABLE `select_boxi`
  ADD PRIMARY KEY (`sbid`);

--
-- Indexes for table `select_boxp`
--
ALTER TABLE `select_boxp`
  ADD PRIMARY KEY (`sbid`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
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
-- AUTO_INCREMENT for table `requisitionlist`
--
ALTER TABLE `requisitionlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `select_boxi`
--
ALTER TABLE `select_boxi`
  MODIFY `sbid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `select_boxp`
--
ALTER TABLE `select_boxp`
  MODIFY `sbid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
