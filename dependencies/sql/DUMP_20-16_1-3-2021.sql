-- MySQL dump 10.13  Distrib 8.0.21, for Win64 (x86_64)
--
-- Host: localhost    Database: toolsforever
-- ------------------------------------------------------
-- Server version	8.0.21

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
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations` (
  `locationID` int DEFAULT NULL,
  `locationname` varchar(64) NOT NULL,
  `locationdescription` varchar(128) DEFAULT NULL,
  `locationadress` varchar(256) NOT NULL,
  `zipcode_numbers` varchar(4) DEFAULT NULL,
  `zipcode_letters` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`locationname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (NULL,'Almere','Hoofdkantoor Forevertools','Noedelpad 78','6352','AB'),(NULL,'Amsterdam','Warenhuis Amsterdam Noord','Bedrijventerrein 124A-128B','1533','TX'),(NULL,'Eindhoven','Klein warenhuis in het centrum van Eindhoven West','Surimiweg 12','6349','TE'),(NULL,'Rotterdam','Gigant op steenworpafstand van Jaarbeurs Utrecht','Jaarbeursweg 7','2385','LD');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations_has_products`
--

DROP TABLE IF EXISTS `locations_has_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations_has_products` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `locations_locationname` varchar(64) NOT NULL,
  `products_productID` int NOT NULL,
  `products_productname` varchar(256) NOT NULL,
  `stock` int DEFAULT NULL,
  `min_stock` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_locations_has_products_locations1_idx` (`locations_locationname`),
  KEY `fk_locations_has_products_products1_idx` (`products_productID`,`products_productname`),
  CONSTRAINT `fk_locations_has_products_products1` FOREIGN KEY (`products_productID`, `products_productname`) REFERENCES `products` (`productID`, `productname`),
  CONSTRAINT `locations_locationname` FOREIGN KEY (`locations_locationname`) REFERENCES `locations` (`locationname`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations_has_products`
--

LOCK TABLES `locations_has_products` WRITE;
/*!40000 ALTER TABLE `locations_has_products` DISABLE KEYS */;
INSERT INTO `locations_has_products` VALUES (121,'Almere',0,'Boormachine',36,10),(122,'Almere',1,'Vuilnisbak',78,20),(123,'Eindhoven',2,'Boormachine',120,50),(124,'Almere',3,'Boormachine',8,5);
/*!40000 ALTER TABLE `locations_has_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `productID` int NOT NULL,
  `productname` varchar(256) NOT NULL,
  `productbrand` varchar(64) DEFAULT NULL,
  `producttype` varchar(64) DEFAULT NULL,
  `buyprice` varchar(16) DEFAULT NULL,
  `sellprice` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`productID`,`productname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (0,'Boormachine','Worx','WX 382','119.95','149.99'),(1,'Vuilnisbak','Siemens','EM-MER','7.95','9.99'),(2,'Boormachine','Pippeloen','TY-PE','109.99','179.99'),(3,'Boormachine','Merkje','Typisch','999.99','239.99'),(4,'product','naam','type','1','2'),(5,'','','','',''),(6,'Test','test','test','2','3');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `UUID` int NOT NULL AUTO_INCREMENT,
  `email` varchar(64) DEFAULT NULL,
  `username` varchar(16) DEFAULT NULL,
  `password` varchar(512) DEFAULT NULL,
  `privileges` varchar(32) DEFAULT NULL,
  `language` varchar(2) DEFAULT 'EN',
  `sessionID` varchar(256) DEFAULT NULL,
  `salt` varchar(128) DEFAULT NULL,
  `activationkey` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`UUID`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (28,'daanklein75@gmail.com','Daan1241','c3f95d7e504894d49c5c24cd79f1a2052cf8894a','client','EN','ef2db27097d3dbad09991e9dfdba4977c10757cd','27902','');
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

-- Dump completed on 2021-03-01 20:16:20
