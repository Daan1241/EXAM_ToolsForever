CREATE DATABASE  IF NOT EXISTS `toolsforever` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `toolsforever`;
-- MariaDB dump 10.17  Distrib 10.4.14-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: toolsforever
-- ------------------------------------------------------
-- Server version	10.4.14-MariaDB

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
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `locationID` int(8) DEFAULT NULL,
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
INSERT INTO `locations` VALUES (NULL,'','','',NULL,NULL),(NULL,'Alkmaar','Hoofdkantoor Forevertools','Vondellaan 45',NULL,NULL),(0,'Almere','Warenhuis Almere Buiten','',NULL,NULL),(3,'Bussum','Centrale fabriek Bussum','',NULL,NULL),(2,'Hilversum','Gigafactory Hilversum','',NULL,NULL),(NULL,'Utrecht','Machinehaard op steenworpafstand van de Jaarbeurs Utrecht','',NULL,NULL),(NULL,'Veenendaal','Klein warenhuis in het centrum van Veenendaal West','',NULL,NULL),(1,'Zaandam','Waremhuis ECOM Zaandam','',NULL,NULL);
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations_has_products`
--

DROP TABLE IF EXISTS `locations_has_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations_has_products` (
  `ID` int(8) NOT NULL AUTO_INCREMENT,
  `locations_locationname` varchar(64) NOT NULL,
  `products_productname` varchar(256) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `min_stock` int(11) DEFAULT NULL,
  `products_productID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_locations_has_products_locations1_idx` (`locations_locationname`),
  KEY `fk_locations_has_products_products1_idx1` (`products_productID`,`products_productname`),
  CONSTRAINT `fk_locations_has_products_products1` FOREIGN KEY (`products_productID`, `products_productname`) REFERENCES `products` (`productID`, `productname`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `locations_locationname` FOREIGN KEY (`locations_locationname`) REFERENCES `locations` (`locationname`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations_has_products`
--

LOCK TABLES `locations_has_products` WRITE;
/*!40000 ALTER TABLE `locations_has_products` DISABLE KEYS */;
INSERT INTO `locations_has_products` VALUES (18,'Hilversum','Banaan2',34,34,NULL),(19,'Bussum','Banaan_bussun',6453,54,NULL),(20,'Almere','Almereproducten',12,10,NULL);
/*!40000 ALTER TABLE `locations_has_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `productID` int(11) NOT NULL AUTO_INCREMENT,
  `productname` varchar(256) NOT NULL,
  `productbrand` varchar(64) DEFAULT NULL,
  `producttype` varchar(64) DEFAULT NULL,
  `buyprice` varchar(16) DEFAULT NULL,
  `sellprice` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`productID`,`productname`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (16,'Banaan','Merk','EZ-MNY','24.99','59.99'),(17,'Banaan','Merk','EZ-MNY','24.99','59.99'),(18,'Banaan','Merk','EZ-MNY','24.99','59.99'),(19,'Banaan','Merk','EZ-MNY','24.99','59.99'),(20,'Broodje frikandel','Merkje','kakhiel','29.39','19.99'),(21,'kak','poep','P-OE-P-2000E','420','69.99'),(22,'kak','poep','P-OE-P-2000E','420','69.99'),(23,'kak','poep','P-OE-P-2000E','420','69.99'),(24,'kak','test','younink','34','45'),(25,'Banaan2','test2','typetest','34','34'),(26,'Banaan_bussun','t6est','tewt','45','23'),(27,'Almereproducten','Tester','types','49.99','1248.99');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `UUID` int(8) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) DEFAULT NULL,
  `username` varchar(16) DEFAULT NULL,
  `password` varchar(512) DEFAULT NULL,
  `privileges` varchar(32) DEFAULT NULL,
  `sessionID` varchar(256) DEFAULT NULL,
  `salt` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`UUID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'toolsforever'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-02-27 21:45:51
