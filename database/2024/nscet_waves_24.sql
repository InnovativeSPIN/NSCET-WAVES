-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2024 at 09:25 PM
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
-- Database: `nscet_waves_24`
--

-- --------------------------------------------------------

--
-- Table structure for table `admindb`
--

CREATE TABLE `admindb` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dept` varchar(255) NOT NULL,
  `reg_no` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `house_name` varchar(255) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allotmentdb`
--

CREATE TABLE `allotmentdb` (
  `house` varchar(255) NOT NULL,
  `event` varchar(255) NOT NULL,
  `isGroup` int(11) NOT NULL DEFAULT 0,
  `group_count` int(11) NOT NULL,
  `grouped` int(11) NOT NULL,
  `slot` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `gender` varchar(255) NOT NULL
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
  `event_rules` varchar(2550) DEFAULT NULL,
  `event_cordinators` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eventdb`
--

INSERT INTO `eventdb` (`event_name`, `event_id`, `event_date`, `event_time`, `event_venue`, `max_participants`, `is_group`, `group_counts`, `group_participants`, `allowance`, `gender`, `image`, `event_type`, `event_rules`, `event_cordinators`) VALUES
('CARBON ART', 1, '-', '-', '-', 2, 1, 2, 1, 1, 'COMMON', 'public/images/event/CARBON ART.jpg', 'Off Stage', ' It is solo event. This event is for both boys and girls teams. Participants count : 2 per team. Time limit : 1 hour. The topic will be given on the spot', '-'),
('CINE SNAP ', 2, '-', '-', '-', 2, 1, 2, 1, 5, 'COMMON', 'public/images/event/CINESNAP.jpg', 'Off Stage', ' This is a team event with a genre choice of Mystery-Thriller/Sci-Fi. It\'s open to both boys and girls teams, with a participant count of five members per team. All film submissions must be original work created by the entrant team. Films should be submitted to the Event Coordinators by the specified deadline, which is on or before 25/09/23\r\n5. It\'s important that films do not contain any copyrighted material or elements without proper authorization\r\n6. Films should be submitted in the specified format (eg, MP4/AVI/MOV/MKV) with high-quality video and audio, and if the primary language is not English, submissions should include English subtitles\r\n7. The time limit for each film is 5 minutes', '-'),
('PICASSO ON GLASS', 3, '-', '-', '-', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/PICASSOONGLASS.jpg', 'Off Stage', 'It is team event. This event is for both boys and girls teams. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring all necessary materials.', '-'),
('ARTY CRAFTY', 4, '-', '-', '-', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/ARTYCRAFTY.jpg', 'Off Stage', 'This is a team event that revolves around executing a project based on a chosen theme. It\'s open to both boys and girls teams, with a participant count of 2 groups per team, each consisting of 2 members. The time limit for completing the project is 1 hour. Participants are required to bring the necessary materials, but only waste materials should be used. Bringing any structure that is partially or fully made is not allowed. In addition to waste materials, participants can use glue, pins, threads, and colors to enhance the finishing of their work. It\'s important to note that the judges reserve the right to disqualify any artwork that is not created primarily with waste materials.', '-'),
('TALK ON THE SPOT', 5, '-', '-', '-', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/TALKONTHESPOT.jpg', 'Off Stage', 'This is a solo event where participants can choose to speak in either Tamil or English but should not mix languages during their speech. It\'s open to both boys and girls teams, with a participant count of 2 per team. The event allows 2 minutes for preparation and 3 minutes for the talk. The topic will be given on the spot, and judgment will be based on relevance to the title, fluency, organized content delivery, and clarity of the presentation.', '-'),
('BLOSSOM & CRAFTS', 6, '-', '-', '-', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/BLOSSOMAND CRAFT.jpg', 'Off Stage', 'This is a team event open to both boys and girls teams. Each team consists of 2 groups, with 2 members in each group, totaling 4 participants per team. The teams have a time limit of 1 hour to create their chosen art, which may be floral or any gift, depending on the participants\' preferences. Participants are required to bring all necessary materials for their project.', '-'),
('TECH QUEST CHALLENGE', 7, '-', '-', '-', 5, 0, 0, 0, 5, 'COMMON', 'public/images/event/TECHQUESTCHALLENGE.png', 'Off Stage', 'It is team event. This event is for both boys and girls teams. Participants count : Maximum 5 members. Time limit : 1 hour. Detailed rules will be announced by organizers.', '-'),
('CARVO', 8, '-', '-', '-', 6, 1, 2, 3, 6, 'COMMON', 'public/images/event/CARVO.jpg', 'Off Stage', 'It is team event. This event is for both boys and girls teams. Participants count : 2 groups/ team with 3 members in each group. Time limit : 1 hour. The participants should bring all necessary materials.', '-'),
('HANDY HENNA', 9, '-', '-', '-', 4, 1, 2, 2, 4, 'GIRLS', 'public/images/event/HANDYHENNA.jpg', 'Off Stage', 'It is team event. This event is for Girls teams only. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring all necessary materials.', '-'),
('HAIRY DORA', 10, '-', '-', '-', 4, 1, 2, 2, 4, 'GIRLS', 'public/images/event/HAIRYDORA.jpg', 'Off Stage', 'It is team event. This event is for Girls teams only. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring all necessary materials.', '-'),
('ONSTAGE ODYSSEY', 11, '-', '-', '-', 7, 0, 0, 0, 7, 'GIRLS', 'public/images/event/ONSTAGEODYSSEY.jpg', 'Off Stage', 'This is a team event exclusively for girls teams, with each team allowed a maximum of 7 participants. The total performance time should not exceed 5 minutes, and teams must inform the organizers and event coordinator of their chosen theme at least two days before the event. The theme should revolve around creating awareness about a specific issue or topic. The complete skit should be in the English language. Safety is a priority, and the use of fire, water, glass, or any materials that could litter the stage is strictly prohibited. Audio tracks should be submitted and verified with the event coordinator on the day before the event. Judging criteria will assess creativity, team coordination, the use of costumes, and properties within the performance.', '-'),
('CUISINE MASTER', 12, '-', '-', '-', 6, 1, 2, 3, 6, 'GIRLS', 'public/images/event/CUISINEMASTER.jpg', 'Off Stage', '\r\nThis is a team event that welcomes both boys and girls teams. Each team is composed of 2 groups, with 3 members in each group, making a total of 6 participants per team. Teams have a time limit of 1 hour to create their culinary masterpiece. Participants are responsible for bringing all the necessary materials for their cooking project. The results of this event will be based on taste and creativity. It\'s important to note that participants are allowed to use an induction stove for their cooking, but the use of open flames or fire is strictly prohibited for safety reasons.', '-'),
('WARRIORS SHOWCASE', 13, '-', '-', '-', 2, 0, 0, 0, 2, 'BOYS', 'public/images/event/WARRIORS SHOWCASE.png', 'Off Stage', 'This is a team event exclusively for boys teams, with each team consisting of 2 members. The allotted time limit for the performance is 5 minutes. Participants are responsible for bringing all the necessary materials. The performance can encompass various activities such as Yoga, Karate, Silambam, Karali, Kattas, or Taekwondo movements. However, it\'s important to note that the use of fire and glass is strictly prohibited for safety reasons.', '-'),
('PICASSO ON FACE', 14, '-', '-', '-', 4, 1, 2, 2, 4, 'BOYS', 'public/images/event/PICASSO ON FACE.jpg', 'Off Stage', 'It is team event. This event is for boys teams only. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring all necessary materials. Theme will be given on the spot.', '-'),
('GAMER\'S GAUNTLET', 15, '-', '-', '-', 5, 0, 0, 0, 5, 'BOYS', 'public/images/event/GAMERS GAUNTLET.jpg', 'Off Stage', 'It is a Team Event with 2 participants/team.\r\nAll participants should be familiar with the rules and gameplay of the selected game.\r\nMatches will be played on LAN (Local Area Network) to ensure fair play.\r\nParticipants are responsible for bringing their own gaming equipment, including Gaming Keyboard and audio accessories(if available).\r\nThe organizers will provide the necessary infrastructure for LAN gaming, including network connections and power outlets.\r\nAll software and game updates will be installed and up to date before the competition begins.\r\nParticipants are expected to exhibit good sportsmanship and fair play at all times.\r\nCheating, hacking, or using unauthorized third-party software is strictly prohibited and will result in immediate disqualification.\r\nThe team has to Report in time with College Identity card.\r\nTeams has to pick up their places in the venue and check their hardware before event starts.\r\nTrail play is not allowed.\r\nWinners are chosen by your win and losses, if in the case of tie kills and deaths are get into account of decision.\r\nNote: Damaging any hardware devices will have made you disqualify your \r\nhouse.', '-'),
('SNAPOGRAPHY', 16, '-', '-', '-', 4, 1, 2, 2, 4, 'BOYS', 'public/images/event/SNAPOGRAPHY.jpg', 'Off Stage', 'This is a team event open to both boys and girls teams. Each team comprises 2 groups, with 2 members in each group, totaling 4 participants per team. Teams have a time limit of 1 hour for the event. Participants are required to bring a professional camera for the competition. It\'s important to note that the use of mobile phones is strictly prohibited during the event. The theme for the photography competition will be provided on the spot, challenging participants to capture creative and compelling images within the given time frame.', '-'),
('MUSICAL RHAPSODY', 17, '-', '-', '-', 1, 0, 0, 0, 1, 'COMMON', 'public/images/event/MUSICAL RHAPSODY.jpg', 'On Stage', 'Solo Event: This event is a solo performance, and each team can have only one\r\nparticipant. Open to All Genders: The event is open to both boys and girls teams. Time Limit: Each participant\'s performance should not exceed 5 minutes. Participants must adhe', '-'),
('ANY BODY CAN DANCE', 18, '-', '-', '-', 10, 0, 0, 0, 10, 'COMMON', 'public/images/event/ANY BODY CAN DANCE.jpg', 'On Stage', 'This event is a team performance open to both boys and girls teams, with each team allowed a maximum of 10 participants. The performance should not exceed 10 minutes in total, comprising 7 minutes for a team\'s chosen folk dance and 3 minutes for a \"foot loose\" segment, all rooted in Indian folk traditions and reflecting the country\'s rich cultural heritage. Safety is a priority as the use of fire, water, glass, or any other materials that could litter the stage is strictly prohibited. Additionally, teams must submit their audio track to the event coordinator and will be judged based on creativity, team coordination, costumes, and properties used in their culturally artistic performance.', '-'),
('CHOREO BOOM', 19, '-', '-', '-', 10, 0, 0, 0, 10, 'COMMON', 'public/images/event/CHOREO BOOM.jpg', 'On Stage', 'This event is a team performance open to both boys and girls teams, with each team allowed a maximum of 10 participants. The performance should not exceed 8 minutes in total, consisting of 5 minutes for the team\'s own choice of western dance and 3 minutes for a \"foot loose\" segment, all adhering to a purely westernized style. The performance should be cultured and a pleasant piece of art, and safety is prioritized by prohibiting the use of fire, water, glass, or any other materials that could litter the stage. Teams are required to submit their chosen audio track to the event coordinator and will be judged based on creativity, team coordination, the use of costumes, and properties in the performance.', '-'),
('NSCET TRENDSETTERS', 20, '-', '-', '-', 2, 0, 0, 0, 2, 'COMMON', 'public/images/event/NSCET TRENDSETTERS.jpg', 'On Stage', 'Theme: The theme for the event is \"Be Bold for Change,\" and all teams must incorporate this theme into their performances.\r\nTeam Event: The fashion show is a team event, and each team can consist of 6 to 8 members.\r\nTime Limit: Each team\'s performance, including setup and the actual show, must not exceed 7 minutes. There will be negative marking if a team exceeds this time limit.\r\nMusic Submission: Teams should carry their performance tracks on a pen drive and submit them in advance to the event organizers for technical coordination.\r\nProhibition of Vulgarity: Vulgarity and any form of obscenity are strictly prohibited. Teams must maintain a high standard of decency in their performances. Any violation will result in the disqualification of the team from the contest.\r\nJudging Criteria: Teams will be judged on the following criteria:\r\n Costumes: The creativity, craftsmanship, originality, confidence \r\nand relevance of the costumes to the theme.\r\n Costume Guidelines: All costumes are permitted, provided they maintain decency. This includes original designs, professionally made costumes, or rented outfits.\r\n The entrant’s personality and willingness to think outside the square should be obvious in their outfit\r\n They should look confident and happy in their outfit and wear something that makes them stand out in a positive manner Attention to detail with accessories:\r\n Ladies appropriate headwear is essential\r\n Men’s accessories should be considered (but not essential)\r\n The overall picture must be considered in the judging – bag, shoes, jewellery and headwear\r\n The entire outfit must be complementary and fit together \r\nWalking Stance: The model’s walking posture, confidence, and style.\r\n Entrants will be judged according to not only their outfit, but also the way they carry themselves on stage.\r\n Hair, makeup and behavior on stage will also be considered by the judges.\r\nAttitude: The overall attitude and stage presence of the team.\r\n The way that you think, feel or behave.\r\n Focus with Your Eyes: As you cannot smile or give any other expressions during a catwalk, the only way to exhibit your confidence on the ramp is through your eyes and eyebrows. Do not look around; keep your eyes fixed on a point in front of you. Just like the focus of the camera\'s lens, keep your eye contact focused.\r\n Tag Line: Each team should have one tagline representing their group and the theme. (Slogan – For Example: Be daring, be different, be you)\r\n7. Judges\' Decision: The decision of the judges will be final and bi', '-'),
('MIME ODYSSEY', 21, '-', '-', '-', 10, 0, 0, 0, 10, 'COMMON', 'public/images/event/MIME ODYSSEY.jpg', 'On Stage', 'This team event is open to both boys and girls teams, with a maximum of 10 participants per team. The total performance time should not exceed 5 minutes, and teams are required to inform the organizers and event coordinator of their chosen theme at least two days before the event. The theme should aim to raise awareness about a specific issue or topic. Performances should consist of silent acts or mimes, with a focus on creativity, expression, and storytelling. Safety is of utmost importance, and the use of fire, water, glass, or any materials that could litter the stage is strictly prohibited. The audio track used should solely be background music without spoken words or lyrics, and it should be submitted and verified with the event coordinator on the day before the event. Judging criteria encompass creativity, team coordination, the use of costumes, and the incorporation of properties within the performance.', '-'),
('NEEYA NANAA', 22, '-', '-', '-', 3, 0, 0, 0, 3, 'GIRLS', 'public/images/event/NEEYA NAANA.png', 'Off Stage', 'It\'s a one-on-one debate consisting of two rounds. From Each Team 3 Student can participate. The topic will be provided on the spot. The judge\'s decision is final.', '-'),
('KAVITHIRAL', 23, '-', '-', '-', 3, 0, 0, 0, 3, 'GIRLS', 'public/images/event/KAVITHIRAL.png', 'Off Stage', 'A maximum of 3 students can participate from each house. Single-round competition. On Spot Theme will be Given. ', '-'),
('RANGOLI', 24, '-', '-', '-', 2, 1, 1, 2, 2, 'GIRLS', 'public/images/event/RANGOLI.jpg', 'Off Stage', 'Topic : BIO-DIVERSITY. Number of Participants per Team: 2. One team can participate per house. Time Duration: 1 hour. Participants need to bring their own materials. Only color powder should be used.', '-'),
('TRANSLATION', 25, '-', '-', '-', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/TRANSLATION.png', 'Off Stage', 'Number of Participants per Team: 2. Up to 2 teams can participate from each house. The decision will be based on timing and spelling mistakes. Total of 3 rounds. Content will be given on the spot.', '-');

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
('TIGER THRASHERS', 921001, NULL, 'BOYS'),
('DRAGON WARRIORS', 921002, NULL, 'BOYS'),
('PHOENIX BLASTERS', 921003, NULL, 'BOYS'),
('DINO THUNDERS', 921004, NULL, 'BOYS'),
('GALACTIC STARS', 921005, NULL, 'GIRLS'),
('VIOLET VIPERS', 921006, NULL, 'GIRLS'),
('BLUE BLASTERS', 921007, NULL, 'GIRLS'),
('ROSY RIDERS', 921008, NULL, 'GIRLS');

-- --------------------------------------------------------

--
-- Table structure for table `registerationdb`
--

CREATE TABLE `registerationdb` (
  `reg_no` varchar(255) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `grouped` int(11) NOT NULL DEFAULT 0,
  `student_house` varchar(255) DEFAULT NULL,
  `student_dept` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `student_name` varchar(200) DEFAULT NULL,
  `student_year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `studentdb`
--

CREATE TABLE `studentdb` (
  `name` varchar(255) DEFAULT NULL,
  `reg_no` varchar(255) DEFAULT NULL,
  `house` varchar(255) DEFAULT NULL,
  `dept` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `viewed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admindb`
--
ALTER TABLE `admindb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allotmentdb`
--
ALTER TABLE `allotmentdb`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `admindb`
--
ALTER TABLE `admindb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allotmentdb`
--
ALTER TABLE `allotmentdb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
