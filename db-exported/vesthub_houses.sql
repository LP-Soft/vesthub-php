CREATE DATABASE  IF NOT EXISTS `vesthub` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `vesthub`;
-- MySQL dump 10.13  Distrib 8.0.38, for macos14 (arm64)
--
-- Host: localhost    Database: vesthub
-- ------------------------------------------------------
-- Server version	9.0.1

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
-- Table structure for table `houses`
--

DROP TABLE IF EXISTS `houses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `houses` (
  `houseID` int NOT NULL,
  `ownerID` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `city` varchar(45) NOT NULL,
  `district` varchar(45) DEFAULT NULL,
  `neighborhood` varchar(45) DEFAULT NULL,
  `street` varchar(45) NOT NULL,
  `price` int NOT NULL,
  `numOfBathroom` int NOT NULL,
  `numOfBedroom` int NOT NULL,
  `numOfRooms` varchar(45) NOT NULL,
  `area` int NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `isSale` tinyint(1) DEFAULT NULL,
  `floor` int NOT NULL,
  `totalFloor` int NOT NULL,
  `fiberInternet` tinyint NOT NULL,
  `airConditioner` tinyint NOT NULL,
  `floorHeating` tinyint NOT NULL,
  `fireplace` tinyint NOT NULL,
  `terrace` tinyint NOT NULL,
  `satellite` tinyint NOT NULL,
  `parquet` tinyint NOT NULL,
  `steelDoor` tinyint NOT NULL,
  `furnished` tinyint NOT NULL,
  `insulation` tinyint NOT NULL,
  `status` varchar(45) NOT NULL,
  `houseType` varchar(45) NOT NULL,
  PRIMARY KEY (`houseID`),
  UNIQUE KEY `id_UNIQUE` (`houseID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `houses`
--

LOCK TABLES `houses` WRITE;
/*!40000 ALTER TABLE `houses` DISABLE KEYS */;
INSERT INTO `houses` VALUES (1,2,'kasnnlsa','lsknsal','aas','asas','assa','dd',12,12,2,'3',122,12.1,221.1,1,2,4,1,1,1,1,1,1,1,1,1,1,'1','1');
/*!40000 ALTER TABLE `houses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-29  0:36:22
