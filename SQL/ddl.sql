-- Host: localhost    Database: popflix
-- ------------------------------------------------------
-- Server version       5.5.44-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Movies`
--

DROP TABLE IF EXISTS `Movies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Movies` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `fpath` varchar(255) NOT NULL,
  `extension` varchar(5) NOT NULL,
  `mimetype` varchar(50) DEFAULT NULL,
  `audioCodec` varchar(50) DEFAULT NULL,
  `videoCodec` varchar(50) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `restricted` tinyint(1) NOT NULL DEFAULT '0',
  `imdbid` varchar(42) DEFAULT NULL,
  `plot` text,
  `runtime` int(11) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `released` date DEFAULT NULL,
  `awards` text,
  `country` text,
  `language` text,
  `rated` varchar(10) DEFAULT NULL,
  `genre` text,
  `director` text,
  `writer` text,
  `actors` text,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `fpath` (`fpath`),
  UNIQUE KEY `imdbid` (`imdbid`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `MovieXtras`
--

DROP TABLE IF EXISTS `MovieXtras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MovieXtras` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MovieID` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `fpath` varchar(255) NOT NULL,
  `extension` varchar(5) NOT NULL,
  `mimetype` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MovieID` (`MovieID`),
  CONSTRAINT `MovieIDx-FK` FOREIGN KEY (`MovieID`) REFERENCES `Movies` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `_Tags`
--

DROP TABLE IF EXISTS `_Tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_Tags` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_Tags`
--

LOCK TABLES `_Tags` WRITE;
/*!40000 ALTER TABLE `_Tags` DISABLE KEYS */;
INSERT INTO `_Tags` VALUES (3,'Banned'),(4,'Restricted'),(2,'Starred'),(6,'Unrestricted'),(1,'Watched');
/*!40000 ALTER TABLE `_Tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_Users`
--

DROP TABLE IF EXISTS `_Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_Users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `User` varchar(25) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `Fav` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `User` (`User`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_Users`
--

LOCK TABLES `_Users` WRITE;
/*!40000 ALTER TABLE `_Users` DISABLE KEYS */;
INSERT INTO `_Users` VALUES (1,'public','$2y$10$dL0MFPt1HaJ0DDhi6Hp3MuyTGukQUsijUIqw9.woGma13IUqKkNei',NULL),(2,'root','$2y$10$pcHwCUR9DcM/QLSjHH32R.OUAqYlHihv0osq8xmCluZBlG5x4fk.2','?restricted=on&new=on&unbanned=on'),(3,'family','$2y$10$6K49JWvCP8WkgwrALQ1pYe.nix006lvYnqH8gAX94g26FKJxRYCJi','?new=on');
/*!40000 ALTER TABLE `_Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_Roles`
--

DROP TABLE IF EXISTS `_Roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_Roles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_Roles`
--

LOCK TABLES `_Roles` WRITE;
/*!40000 ALTER TABLE `_Roles` DISABLE KEYS */;
INSERT INTO `_Roles` VALUES (1,'admin'),(2,'unrestricted');
/*!40000 ALTER TABLE `_Roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_UserRoles`
--

DROP TABLE IF EXISTS `_UserRoles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_UserRoles` (
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  PRIMARY KEY (`UserID`,`RoleID`),
  KEY `RoleFK` (`RoleID`),
  CONSTRAINT `RoleFK` FOREIGN KEY (`RoleID`) REFERENCES `_Roles` (`ID`),
  CONSTRAINT `UserFK` FOREIGN KEY (`UserID`) REFERENCES `_Users` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_UserRoles`
--

LOCK TABLES `_UserRoles` WRITE;
/*!40000 ALTER TABLE `_UserRoles` DISABLE KEYS */;
INSERT INTO `_UserRoles` VALUES (2,1),(1,2);
/*!40000 ALTER TABLE `_UserRoles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_UserTags`
--

DROP TABLE IF EXISTS `_UserTags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_UserTags` (
  `UserID` int(11) NOT NULL,
  `TagID` int(11) NOT NULL,
  `MovieID` int(11) NOT NULL,
  PRIMARY KEY (`UserID`,`TagID`,`MovieID`),
  KEY `TagID-FK` (`TagID`),
  KEY `MovieID-FK` (`MovieID`),
  CONSTRAINT `MovieID-FK` FOREIGN KEY (`MovieID`) REFERENCES `Movies` (`ID`),
  CONSTRAINT `TagID-FK` FOREIGN KEY (`TagID`) REFERENCES `_Tags` (`ID`),
  CONSTRAINT `UserID-FK` FOREIGN KEY (`UserID`) REFERENCES `_Users` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `__Access`
--

DROP TABLE IF EXISTS `__Access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `__Access` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(45) NOT NULL,
  `IPproxy` varchar(45) DEFAULT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1149 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `__AccessList`
--

DROP TABLE IF EXISTS `__AccessList`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `__AccessList` (
  `IP` varchar(45) NOT NULL,
  `flag` varchar(45) NOT NULL,
  PRIMARY KEY (`IP`),
  KEY `IP` (`IP`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;