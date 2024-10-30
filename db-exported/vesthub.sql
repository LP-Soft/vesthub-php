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
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorites` (
  `userID` int NOT NULL,
  `houseID` int DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `houses`
--

DROP TABLE IF EXISTS `houses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `houses` (
  `houseID` int NOT NULL,
  `ownerID` int NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
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
INSERT INTO `houses` VALUES (1,2,'BAHÇELİ LÜKS VİLLA','\nBahçeli lüks doğayla iç içe\n\nKaçmaz fırsat','İstanbul','Beykoz','Kirazlı Yayla Caddesi','dummy',12500000,3,4,'5+1',250,41.12577998769162,29.11613381429442,1,2,3,0,0,1,1,1,1,0,1,0,1,'Available','Villa'),(2,3,'ŞEHİR MERKEZİNE YAKIN LÜKS APARTMAN','Modern tasarımlı, merkezi konumda, her türlü ihtiyacı karşılayacak bir daire.','İstanbul','Beşiktaş','Karaoğlan Sokak','dummy',8000000,2,3,'3+1',120,41.0455,29.006,1,5,10,1,1,0,0,1,1,0,1,1,0,'Available','Apartment'),(3,4,'DENİZ MANZARALI YAZLIK','Muhteşem deniz manzarası ve geniş bahçesi ile yazlık hayaliniz burada!','Muğla','Bodrum','Gümüşlük','dummy',3000000,2,2,'2+1',90,37.064451,27.311444,1,1,2,1,1,0,1,0,0,1,0,1,1,'Available','Villa'),(4,5,'GÜVENLİ SİTE İÇİNDE YENİ DAİRE','Yeni yapım, güvenlikli site içinde, sosyal alanları olan daire.','Ankara','Çankaya','Akköprü','dummy',5000000,1,2,'2+1',85,39.9334,32.8597,1,3,8,1,1,1,0,1,0,1,1,1,1,'Available','Apartment'),(5,6,'ŞEHİR DIŞINDA DOĞAYLA İÇ İÇE','Doğal güzellikleri ile dolu, şehir gürültüsünden uzakta bir villa.','İzmir','Urla','Zeytinler','dummy',4000000,3,4,'5+1',220,38.318013,26.856645,1,1,2,0,0,0,1,1,0,0,1,1,0,'Available','Villa'),(6,7,'KÖY YAŞAMI İÇİN GÜZEL BİR EV','Kendi bahçesi olan, köy yaşamının huzurunu sunan bir ev.','Bursa','Mudanya','Teyzeler','dummy',2000000,1,3,'4+1',150,40.4089,28.8443,1,0,1,0,0,0,0,0,1,0,1,0,0,'Available','Villa'),(7,2,'ÜNİVERSİTE YANI ÖĞRENCİYE UYGUN','Öğrenciye uygun\n\nÜniversiteye yürüme mesafesinde ','Antalya','Kepez','3718. Sokak','dummy',12500,1,1,'1+0',45,36.90301754166873,30.646146867077626,0,3,8,1,0,0,0,0,1,0,1,1,0,'Available','Studio'),(8,2,'ELÇİ EMLAK\'TAN SATILIK AYRI MUTFAKLI İSKANLI ARA KAT 2+1 DAİRE','SATILIK\n\n“HEM YATIRIMLIK HEM OTURUMLUK”','Antalya','Finike','619. Sokak','dummy',3150000,2,2,'3+2',150,36.29200263719032,30.140458005249016,1,1,6,0,0,0,0,0,1,1,1,0,1,'Available','Apartment'),(9,2,'Memur evlerinde 3+1 kiralık daire','3.kat,140 m,güney batı cephe,3+1,pazara,okula,hastaneye,çarşıya,otobüs ve tramvay duraklarına yakın','Antalya','Muratpaşa','210. Sokak','dummy',15000,1,1,'3+1',14,36.8963747,30.6897242,0,3,5,1,1,0,0,0,1,1,1,0,0,'Available','Apartment'),(10,7,'İSTİNYEPARK TA KİRALIK 6+1 BAHÇE DUBLEKSİ','İstinye Park\n\n   residence\n\n\n\nİSTİNYE PARK EVLERİNDE SATILIK 1.FAZDA 6+1 BAHÇE DUBLEKS DAİRE\n\n','İstanbul','Sarıyer','Budak Sokak','dummy',400000,4,5,'6+1',355,41.11465483422137,29.030290707409677,0,0,5,1,1,1,1,1,1,1,1,0,1,'Available','Villa');
/*!40000 ALTER TABLE `houses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `district` varchar(45) DEFAULT NULL,
  `neighborhood` varchar(45) DEFAULT NULL,
  `street` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userID_UNIQUE` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Ali','Safak','alibabaciftligi@safakbaba44.com','','123','',0,NULL,NULL,NULL),(2,'Mahmut','Tuncer','mamo@gmail.com','5444399578','123','Istanbul',0,NULL,NULL,NULL),(3,'safak','gun','sa@c.com','54789878798798798','12','fa',1,NULL,NULL,NULL),(4,'Safak','Gun','safak@safak.com','p','123','Istanbul',1,NULL,NULL,NULL),(5,'abi','abi','abi@abi.com','1234567896','123','as',1,NULL,NULL,NULL),(6,'s','sa','sa@c.om','5855988620','123','s',1,NULL,NULL,NULL),(7,'safak','safak','safak@safak2.com','5444878940','123','IStanbul',1,NULL,NULL,NULL),(8,'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa','a','a@aa.com','5234567895','a','a',1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-30 16:27:29
