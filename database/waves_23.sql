-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2023 at 09:48 PM
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
  `event_rules` varchar(2550) DEFAULT NULL,
  `event_cordinators` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eventdb`
--

INSERT INTO `eventdb` (`event_name`, `event_id`, `event_date`, `event_time`, `event_venue`, `max_participants`, `is_group`, `group_counts`, `group_participants`, `allowance`, `gender`, `image`, `event_type`, `event_rules`, `event_cordinators`) VALUES
('CARBON ART', 1, '26/09/23', '09:45 AM – 10-45 AM', 'Chemistry Lab', 2, 0, 0, 0, 2, 'COMMON', 'public/images/event/carbonart.jpg', 'Off Stage', 'It is solo event. This event is for both boys and girls teams. Participants count : 2 per team. Time limit : 1 hour. The topic will be given on the spot.', 'Mr.B.NAGARAJAN|Mr.N.VIGNESAN'),
('CINE SNAP', 2, '26/09/23', '09:45 AM – 10:45 AM', 'Sir. C. V. Raman Auditorium', 10, 0, 0, 0, 10, 'COMMON', 'public/images/event/cine.jpg', 'Off Stage', 'This is a team event with a genre choice of Mystery-Thriller/Sci-Fi. It\'s open to both boys and girls teams, with a participant count of five members per team. All film submissions must be original work created by the entrant team. Films should be submitted to the Event Coordinators by the specified deadline, which is on or before 25/09/23. It\'s important that films do not contain any copyrighted material or elements without proper authorization. Films should be submitted in the specified format (e.g., MP4/AVI/MOV/MKV) with high-quality video and audio, and if the primary language is not English, submissions should include English subtitles. The time limit for each film is 5 minutes.', 'Dr.T.VENISH KUMAR|Mr.S.MANIMARAN'),
('PICASSO ON GLASS', 3, '26/09/23', '11:00 AM to 11:45 AM', 'Chemistry Lab', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/glasspicaso.jpg', 'Off Stage', 'It is team event. This event is for both boys and girls teams. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring all necessary materials.', 'Mr.A.KARTHIKRAJA|Mr.K.RAJAGURU'),
('INSTAREEL RIVALS', 4, '26/09/23', '11:15 AM', ' ', 1, 0, 0, 0, 1, 'COMMON', 'public/images/event/reels.png', 'Off Stage', 'This is a solo event where submissions will be accepted between 22/09/23 and 26/09/23, as specified in the event announcement. Participants are encouraged to create Instagram Reels that align with the cultural theme of the program, which is \"Laugh out Loud.\" Reels must be original creations and should not include copyrighted material without proper authorization. Content must adhere to guidelines and must not contain explicit, offensive, or harmful material. This event is open to both boys and girls teams, with a participant count of 1 per team. The time limit for a Reel is 60 seconds.', 'Mr.R.SANTHASEELAN|Ms.B.ABINAYA\r\n'),
('ARTY CRAFTY', 5, '26/09/23', '12:00 PM to 01:00 PM', 'Ohm’s Lab', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/ARTYCRAFTY.png', 'Off Stage', 'This is a team event that revolves around executing a project based on a chosen theme. It\'s open to both boys and girls teams, with a participant count of 2 groups per team, each consisting of 2 members. The time limit for completing the project is 1 hour. Participants are required to bring the necessary materials, but only waste materials should be used. Bringing any structure that is partially or fully made is not allowed. In addition to waste materials, participants can use glue, pins, threads, and colors to enhance the finishing of their work. It\'s important to note that the judges reserve the right to disqualify any artwork that is not created primarily with waste materials.', 'Dr.A.SOLAIRAJ|Mr.G.ARUNKUMAR'),
('TALK ON THE SPOT', 6, '26/09/23', '01:00 PM to 02:00 PM', 'Language Lab', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/talk.jpg', 'Off Stage', 'This is a solo event where participants can choose to speak in either Tamil or English but should not mix languages during their speech. It\'s open to both boys and girls teams, with a participant count of 2 per team. The event allows 2 minutes for preparation and 3 minutes for the talk. The topic will be given on the spot, and judgment will be based on relevance to the title, fluency, organized content delivery, and clarity of the presentation.', 'Mr.R.C.RICHARD BRITTO|Mr.V.SIVAGANESAN'),
('BLOSSOM & CRAFTS', 7, '26/09/23', '02:00 PM to 03:00 PM', 'Chemistry Lab', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/several-colorful-gifts-with-bow.jpg', 'Off Stage', 'This is a team event open to both boys and girls teams. Each team consists of 2 groups, with 2 members in each group, totaling 4 participants per team. The teams have a time limit of 1 hour to create their chosen art, which may be floral or any gift, depending on the participants\' preferences. Participants are required to bring all necessary materials for their project.', 'Dr.C.SIVAKANDHAN|Mr.C.SURULIMANI'),
('CUISINE MASTER', 8, '26/09/23', '03:15 PM to 04:15 PM', 'Physics Lab', 6, 1, 2, 3, 6, 'COMMON', 'public/images/event/cuisine_master.jpg', 'Off Stage', '\r\nThis is a team event that welcomes both boys and girls teams. Each team is composed of 2 groups, with 3 members in each group, making a total of 6 participants per team. Teams have a time limit of 1 hour to create their culinary masterpiece. Participants are responsible for bringing all the necessary materials for their cooking project. The results of this event will be based on taste and creativity. It\'s important to note that participants are allowed to use an induction stove for their cooking, but the use of open flames or fire is strictly prohibited for safety reasons.', 'Mr.M.IDHAYACHANDRAN|Mr.R.RAJAKARTHICK'),
('TECH QUEST CHALLENGE', 9, '26/09/23', '03:30 PM to 04:30 PM', 'Sir. C. V. Raman Auditorium', 4, 0, 1, 0, 4, 'COMMON', 'public/images/event/treasure-hunt.avif', 'Off Stage', 'It is team event. This event is for both boys and girls teams. Participants count : Maximum 4 members. Time limit : 1 hour. Detailed rules will be announced by organizers.', 'Mr. K.KIRUBAKARAN|Mr.A.VENNIMALAIRAJAN'),
('HANDY HENNA', 10, '27/09/23', '09:45 AM – 10-45 AM', 'Chemistry Lab', 4, 1, 2, 2, 4, 'GIRLS', 'public/images/event/henna.avif', 'Off Stage', 'It is team event. This event is for Girls teams only. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring all necessary materials.', 'Mrs.R.ARCHANA|Ms.R.VINITHA\r\n'),
('HAIRY DORA', 11, '27/09/23', '11:00 AM to 12:00 noon', 'Physics Lab', 4, 1, 2, 2, 4, 'GIRLS', 'public/images/event/hairy.jpg', 'Off Stage', 'It is team event. This event is for Girls teams only. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring all necessary materials.', 'Mrs.P.NALINI|Mrs.A.RAJAPRIYADHARSHINI\r\n'),
('ODYSSEY ENGLISH', 12, '27/09/23', '12:15 PM to 01:15 PM', 'Ohm’s Lab', 7, 0, 0, 0, 7, 'GIRLS', 'public/images/event/webpage 3.jpg', 'Off Stage', 'This is a team event exclusively for girls teams, with each team allowed a maximum of 7 participants. The total performance time should not exceed 5 minutes, and teams must inform the organizers and event coordinator of their chosen theme at least two days before the event. The theme should revolve around creating awareness about a specific issue or topic. The complete skit should be in the English language. Safety is a priority, and the use of fire, water, glass, or any materials that could litter the stage is strictly prohibited. Audio tracks should be submitted and verified with the event coordinator on the day before the event. Judging criteria will assess creativity, team coordination, the use of costumes, and properties within the performance.', 'Mrs.M.FATHIMA BEEVI|Mrs.J.PREETHA'),
('WARRIOR\'S SHOWCASE', 13, '27/09/23', '09:45 AM – 10-45 AM', 'PlayGround', 2, 0, 1, 0, 2, 'BOYS', 'public/images/event/martial-arts.webp', 'Off Stage', 'This is a team event exclusively for boys teams, with each team consisting of 2 members. The allotted time limit for the performance is 5 minutes. Participants are responsible for bringing all the necessary materials. The performance can encompass various activities such as Yoga, Karate, Silambam, Karali, Kattas, or Taekwondo movements. However, it\'s important to note that the use of fire and glass is strictly prohibited for safety reasons.', 'Mr.K.SUNDARARAJAN|Mr.P.SELVAKUMAR'),
('PICASSO ON FACE', 14, '27/09/23', '11:00 AM to 12:00 noon', 'Ohm’s Lab', 4, 1, 2, 2, 4, 'BOYS', 'public/images/event/face-painting.avif', 'Off Stage', 'It is team event. This event is for boys teams only. Participants count : 2 groups/ team with 2 members in each group. Time limit : 1 hour. The participants should bring all necessary materials. Theme will be given on the spot.', 'Dr.R.ATHILINGAM|Mrs.M.KANIMOZHI\r\n'),
('GAMER\'S GAUNTLET', 15, '27/09/23', '12:15 PM to 01:15 PM', 'Dennis Lab', 5, 0, 0, 0, 5, 'BOYS', 'public/images/event/cod.jpg', 'Off Stage', 'This is a team event where all participants should be well-versed in the rules and gameplay of the selected game. Matches will be conducted on a LAN (Local Area Network) to ensure a fair gaming environment. Participants are responsible for bringing their own gaming equipment, including computers, monitors, keyboards, mice, headphones, and any necessary cables. The organizers will supply the necessary infrastructure for LAN gaming, including network connections and power outlets. All required software and game updates will be installed and up to date before the competition commences. It is crucial that participants exhibit good sportsmanship and fair play at all times. Cheating, hacking, or using unauthorized third-party software is strictly prohibited and will result in immediate disqualification.', 'Mr.R.SHANMUGAPRIYAN|Mr.R.RADHAKRISHNAN'),
('CARVO', 16, '27/09/23', '02:00 PM to 03:00 PM', 'Ohm’s Lab', 6, 1, 2, 3, 6, 'COMMON', 'public/images/event/carvo.jpg', 'Off Stage', 'It is team event. This event is for both boys and girls teams. Participants count : 2 groups/ team with 3 members in each group. Time limit : 1 hour. The participants should bring all necessary materials.', 'Mr.V.RAJAPRASANNA|Mrs.J.PRIYA\r\n'),
('SNAPOGRAPHY', 17, '27/09/23', '02:45 PM to 03:45 PM', 'Language Lab', 4, 1, 2, 2, 4, 'COMMON', 'public/images/event/photography-camera-learning-feature.JPG', 'Off Stage', 'This is a team event open to both boys and girls teams. Each team comprises 2 groups, with 2 members in each group, totaling 4 participants per team. Teams have a time limit of 1 hour for the event. Participants are required to bring a professional camera for the competition. It\'s important to note that the use of mobile phones is strictly prohibited during the event. The theme for the photography competition will be provided on the spot, challenging participants to capture creative and compelling images within the given time frame.', 'Dr.N.DAVID MATHAN|Ms.M.SANGAVI'),
('ANY BODY CAN DANCE', 18, '29/09/23', '12:45 PM to 02:45 PM', 'Kamarajar Open Auditorium', 10, 0, 1, 0, 10, 'COMMON', 'public/images/event/dance.avif', 'On Stage', 'This event is a team performance open to both boys and girls teams, with each team allowed a maximum of 10 participants. The performance should not exceed 10 minutes in total, comprising 7 minutes for a team\'s chosen folk dance and 3 minutes for a \"foot loose\" segment, all rooted in Indian folk traditions and reflecting the country\'s rich cultural heritage. Safety is a priority as the use of fire, water, glass, or any other materials that could litter the stage is strictly prohibited. Additionally, teams must submit their audio track to the event coordinator and will be judged based on creativity, team coordination, costumes, and properties used in their culturally artistic performance.', 'Mr.R.PRADEEP KUMAR|Ms.M.DIVYABHARATHI'),
('MIME ODYSSEY', 19, '29/09/23', '02:45 PM to 03:45 PM', 'Kamarajar Open Auditorium', 10, 0, 1, 0, 10, 'COMMON', 'public/images/event/mime.avif', 'On Stage', 'This team event is open to both boys and girls teams, with a maximum of 10 participants per team. The total performance time should not exceed 5 minutes, and teams are required to inform the organizers and event coordinator of their chosen theme at least two days before the event. The theme should aim to raise awareness about a specific issue or topic. Performances should consist of silent acts or mimes, with a focus on creativity, expression, and storytelling. Safety is of utmost importance, and the use of fire, water, glass, or any materials that could litter the stage is strictly prohibited. The audio track used should solely be background music without spoken words or lyrics, and it should be submitted and verified with the event coordinator on the day before the event. Judging criteria encompass creativity, team coordination, the use of costumes, and the incorporation of properties within the performance.', 'Ms.I.LIMSHA DEBORAH|Mrs.M.SINDHU'),
('MUSICAL RHAPSODY', 20, '29/09/23', '03:45 PM to 04:45 PM', 'Kamarajar Open Auditorium', 1, 0, 1, 0, 1, 'COMMON', 'public/images/event/sing.jpg', 'On Stage', 'Solo Event: This event is a solo performance, and each team can have only one\r\nparticipant. Open to All Genders: The event is open to both boys and girls teams. Time Limit: Each participant\'s performance should not exceed 5 minutes. Participants must adhe', 'Dr.T.VENISHKUMAR|Mr.V.SIVAGANESAN'),
('CHOREO BOOM', 21, '30/09/23', '10:00 AM to 12:00 noon', 'Kamarajar Open Auditorium', 10, 0, 1, 0, 10, 'COMMON', 'public/images/event/dance2.jpg', 'On Stage', 'This event is a team performance open to both boys and girls teams, with each team allowed a maximum of 10 participants. The performance should not exceed 8 minutes in total, consisting of 5 minutes for the team\'s own choice of western dance and 3 minutes for a \"foot loose\" segment, all adhering to a purely westernized style. The performance should be cultured and a pleasant piece of art, and safety is prioritized by prohibiting the use of fire, water, glass, or any other materials that could litter the stage. Teams are required to submit their chosen audio track to the event coordinator and will be judged based on creativity, team coordination, the use of costumes, and properties in the performance.', 'Mr.R.RADHAKRISHNAN|Mr.J.CHAKRAVARTHY SAMYDURAI'),
('NSCET TRENDSETTERS', 22, '30/09/23', '12:00 PM to 01:00 PM', 'Kamarajar Open Auditorium', 2, 0, 0, 0, 2, 'COMMON', 'public/images/event/fasion.jpg', 'On Stage', 'The theme for this fashion show event is \"Be Bold for Change,\" which all participating teams must incorporate into their performances. It\'s a team event, with teams consisting of 6 to 12 members. Each team\'s performance, including setup and the actual show, should not exceed 7 minutes, with possible negative marking for exceeding this time limit. Teams are required to submit their performance tracks in advance on a pen drive to the event organizers for technical coordination. Maintaining a high standard of decency is crucial as vulgarity and obscenity are strictly prohibited, and violations will lead to disqualification. Judging criteria include evaluating costumes for creativity, originality, and relevance to the theme, as well as assessing how effectively the theme is incorporated into the performance, models\' walking posture and confidence, overall team attitude and stage presence, and the presence of a tagline representing the group and theme. Costume guidelines allow for various costume types as long as they maintain decency, including original designs, professionally made costumes, or rented outfits. The judges\' decisions will be final and binding, with no room for appeals or challenges.', 'Mr.R.UDHAYAKUMAR|Mrs.S.GAYATHRI');

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
  `reg_no` varchar(255) NOT NULL,
  `event_name` varchar(255) NOT NULL,
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
  `reg_no` varchar(255) DEFAULT NULL,
  `house` varchar(255) DEFAULT NULL,
  `dept` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `studentdb`
--
ALTER TABLE `studentdb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
