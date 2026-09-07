CREATE DATABASE  IF NOT EXISTS `nscet_waves_25` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `nscet_waves_25`;
-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: nscet_waves_25
-- ------------------------------------------------------
-- Server version	8.0.46

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admindb`
--

DROP TABLE IF EXISTS `admindb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admindb` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dept` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `reg_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `event_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `house_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '-',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admindb`
--

LOCK TABLES `admindb` WRITE;
/*!40000 ALTER TABLE `admindb` DISABLE KEYS */;
/*!40000 ALTER TABLE `admindb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `allotmentdb`
--

DROP TABLE IF EXISTS `allotmentdb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `allotmentdb` (
  `house` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `event` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `isGroup` int NOT NULL DEFAULT '0',
  `group_count` int NOT NULL,
  `grouped` int NOT NULL,
  `slot` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `reg_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `allotmentdb`
--

LOCK TABLES `allotmentdb` WRITE;
/*!40000 ALTER TABLE `allotmentdb` DISABLE KEYS */;
/*!40000 ALTER TABLE `allotmentdb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_slots`
--

DROP TABLE IF EXISTS `event_slots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_slots` (
  `event_id` int NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `event_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `event_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `event_venue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `max_participants` int NOT NULL,
  `is_group` int NOT NULL,
  `group_counts` int NOT NULL,
  `group_participants` int NOT NULL,
  `allowance` int NOT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `event_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `event_rules` varchar(2550) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `event_cordinators` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_slots`
--

LOCK TABLES `event_slots` WRITE;
/*!40000 ALTER TABLE `event_slots` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_slots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventdb`
--

DROP TABLE IF EXISTS `eventdb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventdb` (
  `event_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `event_id` int NOT NULL,
  `event_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `event_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `event_venue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `max_participants` int NOT NULL,
  `is_group` int NOT NULL,
  `group_counts` int NOT NULL,
  `group_participants` int NOT NULL,
  `allowance` int NOT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `event_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `event_rules` varchar(2550) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `event_cordinators` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  UNIQUE KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventdb`
--

LOCK TABLES `eventdb` WRITE;
/*!40000 ALTER TABLE `eventdb` DISABLE KEYS */;
/*!40000 ALTER TABLE `eventdb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `housedb`
--

DROP TABLE IF EXISTS `housedb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `housedb` (
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id` int NOT NULL,
  `score` int DEFAULT NULL,
  `gender` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `housedb`
--

LOCK TABLES `housedb` WRITE;
/*!40000 ALTER TABLE `housedb` DISABLE KEYS */;
INSERT INTO `housedb` VALUES ('TIGER THRASHERS',921001,95,'BOYS','public/images/house/TIGER_THRASHERS.png'),('DRAGON WARRIORS',921002,80,'BOYS','public/images/house/DRAGON_WARRIORS.png'),('PHOENIX BLASTERS',921003,40,'BOYS','public/images/house/PHOENIX_BLASTERS.png'),('DINO THUNDERS',921004,40,'BOYS','public/images/house/DINO_THUNDERS.png'),('GALACTIC STARS',921005,70,'GIRLS','public/images/house/GALACTIC_STARS.png'),('VIOLET VIPERS',921006,40,'GIRLS','public/images/house/VIOLET_VIPERS.png'),('BLUE BLASTERS',921007,80,'GIRLS','public/images/house/BLUE_BLASTERS.png'),('ROSY RIDERS',921008,70,'GIRLS','public/images/house/ROSY_RIDERS.png'),('EMERALD EAGLES',921009,25,'GIRLS','public/images/house/EMERALD_EAGLES.png'),('SOLARIS QUEENS',921011,0,'GIRLS','public/images/house/SOLARIS_QUEENS_1788765082.png'),('SHARK RIDERS',921012,0,'BOYS','public/images/house/SHARK_RIDERS_1788770448.png');
/*!40000 ALTER TABLE `housedb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registerationdb`
--

DROP TABLE IF EXISTS `registerationdb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registerationdb` (
  `reg_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `event_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `grouped` int NOT NULL DEFAULT '0',
  `student_house` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `student_dept` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `student_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `student_year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registerationdb`
--

LOCK TABLES `registerationdb` WRITE;
/*!40000 ALTER TABLE `registerationdb` DISABLE KEYS */;
/*!40000 ALTER TABLE `registerationdb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studentdb`
--

DROP TABLE IF EXISTS `studentdb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `studentdb` (
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reg_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `house` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dept` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `viewed` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `reg_no` (`reg_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studentdb`
--

LOCK TABLES `studentdb` WRITE;
/*!40000 ALTER TABLE `studentdb` DISABLE KEYS */;
/*!40000 ALTER TABLE `studentdb` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-07 16:04:18
