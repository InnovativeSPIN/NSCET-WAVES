-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2023 at 04:52 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `waves_23`
--

-- --------------------------------------------------------

--
-- Table structure for table `admindb`
--

CREATE TABLE `admindb` (
  `name` varchar(255) NOT NULL,
  `dept` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `reg_no` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `house_name` varchar(255) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventdb`
--

CREATE TABLE `eventdb` (
  `event_name` varchar(255) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_date` varchar(255) NOT NULL,
  `event_time` varchar(255) NOT NULL,
  `event_venue` varchar(255) NOT NULL,
  `max_participants` int(11) NOT NULL,
  `is_group` int(11) NOT NULL,
  `group_counts` int(11) NOT NULL,
  `group_participants` int(11) NOT NULL,
  `allowance` int(11) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `event_rules` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eventdb`
--

INSERT INTO `eventdb` (`event_name`, `event_id`, `event_date`, `event_time`, `event_venue`, `max_participants`, `is_group`, `group_counts`, `group_participants`, `allowance`, `gender`, `image`, `event_type`, `event_rules`) VALUES
('CARBON ART', 1, '26/09/23', '09:45 AM – 10-45 AM', 'Chemistry Lab', 2, 0, 0, 0, 2, 'COMMON', 'public/images/event/carbonart.jpg', 'Off Stage', 'It is solo event. This event is for both boys and girls teams. Participants count : 2 per team. Time limit : 1 hour. The topic will be given on the spot.'),
('CARVO', 2, '27/09/23', '02:00 PM to 03:00 PM', 'Ohm’s Lab', 6, 1, 2, 3, 6, 'COMMON', 'public/images/event/carvo.jpg', 'Off Stage', 'It is team event. This event is for both boys and girls teams. Participants count : 2 groups/ team with 3 members in each group. Time limit : 1 hour. The participants should bring all necessary materials.'),
('ARTY CRAFTY', 3, '26/09/23', '12:00 PM to 01:00 PM', 'Ohm’s Lab', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/ARTYCRAFTY.png', 'Off Stage', 'It is team event This event is for both boys and girls teams. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring necessary materials. Only waste materials should be used'),
('PICASSO ON GLASS', 4, '26/09/23', '11:00 AM to 11:45 AM', 'Chemistry Lab', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/glasspicaso.jpg', 'Off Stage', 'It is team event. This event is for both boys and girls teams. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring all necessary materials.');

-- --------------------------------------------------------

--
-- Table structure for table `housedb`
--

CREATE TABLE `housedb` (
  `name` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `gender` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `housedb`
--

INSERT INTO `housedb` (`name`, `id`, `score`, `gender`) VALUES
('TIGER THRASHERS', 921001, 0, 'BOYS'),
('DRAGON WARRIORS', 921002, 0, 'BOYS'),
('PHOENIX BLASTERS', 921003, 0, 'BOYS'),
('DINO THUNDERS', 921004, 0, 'BOYS'),
('ROSY RIDERS', 921005, 0, 'GIRLS'),
('VIOLET VIPERS', 921006, 0, 'GIRLS'),
('GALACTIC STARS', 921007, 0, 'GIRLS'),
('BLUE BLASTERS', 921008, 0, 'GIRLS');

-- --------------------------------------------------------

--
-- Table structure for table `registerationdb`
--

CREATE TABLE `registerationdb` (
  `reg_no` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `house_id` int(11) NOT NULL,
  `grouped` int(11) NOT NULL DEFAULT 0,
  `student_house` varchar(255) DEFAULT NULL,
  `student_dept` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `studentdb`
--

CREATE TABLE `studentdb` (
  `name` varchar(255) DEFAULT NULL,
  `reg_no` int(11) DEFAULT NULL,
  `house` varchar(255) DEFAULT NULL,
  `dept` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admindb`
--
ALTER TABLE `admindb`
  ADD UNIQUE KEY `reg_no` (`reg_no`);

--
-- Indexes for table `eventdb`
--
ALTER TABLE `eventdb`
  ADD PRIMARY KEY (`event_id`),
  ADD UNIQUE KEY `event_id` (`event_id`);

--
-- Indexes for table `housedb`
--
ALTER TABLE `housedb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `registerationdb`
--
ALTER TABLE `registerationdb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentdb`
--
ALTER TABLE `studentdb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reg_no` (`reg_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `registerationdb`
--
ALTER TABLE `registerationdb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `studentdb`
--
ALTER TABLE `studentdb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
