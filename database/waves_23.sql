-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2023 at 07:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
('PICASSO ON GLASS', 4, '26/09/23', '11:00 AM to 11:45 AM', 'Chemistry Lab', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/glasspicaso.jpg', 'Off Stage', 'It is team event. This event is for both boys and girls teams. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring all necessary materials.'),
('BLOSSOM & CRAFTS', 5, '26/09/23', '02:00 PM to 03:00 PM', 'Chemistry Lab', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/several-colorful-gifts-with-bow.jpg', 'Off Stage', 'It is team event. This event is for both boys and girls teams. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring all necessary materials. The art may be floral or any gift and it depends o'),
('SNAPOGRAPHY', 6, '27/09/23', '02:45 PM to 03:45 PM', 'Language Lab', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/photography-camera-learning-feature.JPG', 'Off Stage', 'It is team event. This event is for boys teams only. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring professional camera. Use of mobile phone is prohibited. Theme will be given on the sp'),
('CUISINE MASTER', 7, '26/09/23', '03:15 PM to 04:15 PM', 'Physics Lab', 6, 1, 2, 3, 6, 'COMMON', 'public/images/event/cuisine_master.jpg', 'Off Stage', 'It is team event. This event is for Girls teams only. Participants count : 2 groups/ team with 3 members in each group. Time limit : 1 hour. The participants should bring all necessary materials. Results will be based on taste and creativity. Participants'),
('TALK ON THE SPOT', 8, '26/09/23', '01:00 PM to 02:00 PM', 'Language Lab', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/talk.jpg', 'Off Stage', 'It is solo event. This event is for both boys and girls teams. Participants count : 2 per team. Time limit : 2 minutes for preparation, 3 minutes for performance. The topic will be given on the spot. Judgment will be based on relevance to the title, fluen'),
('TECH QUEST CHALLENGE', 11, '26/09/23', '03:30 PM to 04:30 PM', 'Sir. C. V. Raman Auditorium', 4, 1, 1, 4, 4, 'COMMON', 'public/images/event/treasure-hunt.avif', 'Off Stage', 'It is team event. This event is for both boys and girls teams. Participants count : Maximum 4 members. Time limit : 1 hour. Detailed rules will be announced by organizers.'),
('HANDY HENNA', 12, '27/09/23', '09:45 AM – 10-45 AM', 'Chemistry Lab', 4, 1, 2, 2, 4, 'GIRLS', 'public/images/event/henna.avif', 'Off Stage', 'It is team event. This event is for Girls teams only. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring all necessary materials.'),
('HAIRY DORA', 13, '27/09/23', '11:00 AM to 12:00 noon', 'Physics Lab', 4, 1, 2, 2, 4, 'GIRLS', 'public/images/event/hairy.jpg', 'Off Stage', 'It is team event. This event is for Girls teams only. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring all necessary materials.'),
('WARRIOR\'S SHOWCASE', 15, '27/09/23', '09:45 AM – 10-45 AM', 'PlayGround', 2, 1, 1, 2, 2, 'BOYS', 'public/images/event/martial-arts.webp', 'Off Stage', 'It is team event. This event is for boys teams only. Participants count : 2 members in each Team. Time limit : 5 minutes. The participants should bring all necessary materials. The performance may be Yoga, Karate, silambam, karali, kattas, takewan-do mov'),
('PICASSO ON FACE', 16, '27/09/23', '11:00 AM to 12:00 noon', 'Ohm’s Lab', 4, 1, 2, 2, 4, 'BOYS', 'public/images/event/face-painting.avif', 'Off Stage', 'It is team event. This event is for boys teams only. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring all necessary materials. Theme will be given on the spot.'),
('ANY BODY CAN DANCE', 18, '29/09/23', '12:45 PM to 02:45 PM', 'Kamarajar Open Auditorium', 10, 1, 1, 10, 10, 'COMMON', 'public/images/event/dance.avif', 'On Stage', 'It is team event. This event is for both boys and girls teams. Participants count : Maximum 10. Time limit : 08minutes : 5 minutes own choice, 3 minutes ‘foot loose’. Song selection and dance should be purely westernized. Any deviation in the rules will l'),
('CHOREO BOOM', 19, '30/09/23', '10:00 AM to 12:00 noon', 'Kamarajar Open Auditorium', 10, 1, 1, 10, 10, 'COMMON', 'public/images/event/dance2.jpg', 'On Stage', 'It is team event. This event is for both boys and girls teams. Participants count : Maximum 10. Time limit : 10 minutes : 7 minutes own choice, 3 minutes ‘foot loose’. Song selection and dance should be purely folk. Any deviation in the rules will lead to'),
('MIME ODYSSEY', 20, '29/09/23', '02:45 PM to 03:45 PM', 'Kamarajar Open Auditorium', 10, 1, 1, 10, 10, 'COMMON', 'public/images/event/mime.avif', 'On Stage', 'It is team event. This event is for both boys and girls teams. Participants count : Maximum 10. Time limit : 05 minutes. The theme should be informed to the organizers and event coordinator two days before the conduct of event. The theme of the event shou'),
('MUSICAL RHAPSODY', 21, '29/09/23', '03:45 PM to 04:45 PM', 'Kamarajar Open Auditorium', 1, 0, 1, 1, 1, 'COMMON', 'public/images/event/sing.jpg', 'On Stage', 'It is solo event. This event is for both boys and girls teams. Time limit : 5 minutes. Participants count : 1 per team. The karoke of the performing song should be submitted to the event coordinators and verified on the day before event.');

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
