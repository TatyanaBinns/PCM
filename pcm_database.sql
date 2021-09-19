-- MySQL dump 10.13  Distrib 8.0.26, for Linux (x86_64)
--
-- Host: localhost    Database: pcm
-- ------------------------------------------------------
-- Server version	8.0.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Contacts`
--

DROP TABLE IF EXISTS `Contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Contacts` (
  `ContactsId` int NOT NULL AUTO_INCREMENT,
  `UserId` int NOT NULL,
  `NameFirst` varchar(100) DEFAULT NULL,
  `NameLast` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `PhoneNumber` varchar(25) DEFAULT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ContactsId`),
  KEY `Contacts_FK` (`UserId`),
  CONSTRAINT `Contacts_FK` FOREIGN KEY (`UserId`) REFERENCES `Users` (`UserId`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Contacts`
--

LOCK TABLES `Contacts` WRITE;
/*!40000 ALTER TABLE `Contacts` DISABLE KEYS */;
INSERT INTO `Contacts` VALUES (1,1,'Sam','Smith','samsmith@gmail.com','1234445555','2021-09-01 04:26:41'),(2,2,'Sam','Smith','samsmith@gmail.com','1234445555','2021-09-01 04:26:58'),(3,1,'Tony','Stark','tonystark@gmail.com','1233445555','2021-09-01 04:28:01'),(4,2,'Clark','Kent','clarkkent@gmail.com','1223445555','2021-09-01 04:28:40'),(5,1,'Alex','Smith','johnsmith@gmail.com','1234567','2021-09-09 03:14:46'),(7,1,'Susan','Connor','susanconnor@gmail.com','1234567890','2021-09-09 03:43:45'),(9,2,'Melody','Clark','melodyclark@gmail.com','1233214545','2021-09-11 16:52:04'),(11,1,'Fred','Flinstone','f.flinstone@yahoo.com','124587','2021-09-11 16:58:51'),(20,1,'John','Smith II','jsmith@icloud.com','1234576541','2021-09-11 21:08:16'),(22,1,'James','Smith','jamessmith@gmail.com','1234567890','2021-09-11 21:16:29'),(23,1,'Jack','Jackson','jjackson@icloud.com','1238976541','2021-09-12 01:10:04'),(24,1,'George','Washington','gwashington@gmail.com','1234567890','2021-09-13 03:17:29'),(28,2,'Tim ','Jones','timjones@gmail.com','0','2021-09-15 00:57:31'),(33,1,'Rosanna','Lee','rlee@gmail.com','5246532','2021-09-17 23:44:41'),(34,1,'Deb','Brandon','dbrandon@gmail.com','5469874','2021-09-18 01:08:42'),(35,2,'Adan','Freeman','afreeman@gmail.com','4444444','2021-09-19 00:11:18');
/*!40000 ALTER TABLE `Contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Users` (
  `UserId` int NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `DateCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `PasswordHash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'John','Doe','johndoe@gmail.com','2021-09-01 04:18:25','$2y$10$WrjQVExGtMCZHHmDbUpsEOSwfBiXwAQh3N9AAWtemSdq3eM3oWmMa'),(2,'Jane','Doe','janedoe@gmail.com','2021-09-01 04:22:53','$2y$10$pV7a02hK7BIuKbDAVgNNv.FSw/8MdW5SQbJZMuNpUF3k.Hih.r93q'),(3,'Jeff','Johnson','jeffjohnson@gmail.com','2021-09-11 16:43:15','$2y$10$6zLS8w9dlI6G.Lb4QmXD1.IItWUrSvw0XNwqw2dxeNNeYcg/RV71.'),(4,'Freddie','Harlock','freddieharlock@gmail.com','2021-09-11 16:57:14','$2y$10$q8hvmw.JyyB9xicc9ZSud.waEj//xDddyqafGc390b2acLLc4pTmW'),(5,'Freddie','Montgomery','freddiemontgomery@gmail.com','2021-09-11 17:02:49','$2y$10$7uUkbN8j9xnsMYMzk8u7GO6nW6cY0lSmr6.IQpwcEQTiOe6tTxCy2'),(6,'Toby','Montgomery','tobymontgomery@gmail.com','2021-09-11 17:06:37','$2y$10$lgDEQZI/y1EaBaXaTYZTiOL/4njxiPl8HSprui60UoSy0Grb.7deC'),(7,'Lucy','King','lucyking@gmail.com','2021-09-12 00:59:06','$2y$10$Ns3CGKE55Xgl5helo58f8Oj4Vbp6q9A5QY/3M.ZYNFOYnbtHTD3gi');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-09-19 13:12:04
