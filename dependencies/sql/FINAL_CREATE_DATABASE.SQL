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
  `locationID` int NOT NULL AUTO_INCREMENT,
  `locationname` varchar(64) DEFAULT NULL,
  `locationdescription` varchar(128) DEFAULT NULL,
  `locationadress` varchar(256) DEFAULT NULL,
  `zipcode_numbers` varchar(4) DEFAULT NULL,
  `zipcode_letters` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`locationID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (14,'Almere','<img src=\"dependencies/img/delete.svg\" style=\"width: 100%\" onclick=\"deletelocation(14)\">','Bedrijventerrein 124A-128B','1339','RN'),(15,'Eindhoven','<img src=\"dependencies/img/delete.svg\" style=\"width: 100%\" onclick=\"deletelocation(15)\">','Sushiweg 67','5633','PE'),(16,'Amsterdam','<img src=\"dependencies/img/delete.svg\" style=\"width: 100%\" onclick=\"deletelocation(16)\">','Postjesweg 12','1034','HT');
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
  `locations_locationID` int NOT NULL,
  `products_productID` int NOT NULL,
  `stock` int DEFAULT NULL,
  `min_stock` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_locations_has_products_locations_idx` (`locations_locationID`),
  KEY `fk_locations_has_products_products1_idx` (`products_productID`),
  CONSTRAINT `fk_locations_has_products_locations` FOREIGN KEY (`locations_locationID`) REFERENCES `locations` (`locationID`),
  CONSTRAINT `fk_locations_has_products_products1` FOREIGN KEY (`products_productID`) REFERENCES `products` (`productID`)
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations_has_products`
--

LOCK TABLES `locations_has_products` WRITE;
/*!40000 ALTER TABLE `locations_has_products` DISABLE KEYS */;
INSERT INTO `locations_has_products` VALUES (161,14,25,45,5),(163,14,26,12,10),(164,14,27,54,25),(165,15,28,14,10),(166,15,29,11,10),(167,15,22,10,10),(168,15,30,12,10),(169,16,22,67,8),(172,15,29,10,5),(188,16,28,15,10);
/*!40000 ALTER TABLE `locations_has_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `productID` int NOT NULL AUTO_INCREMENT,
  `productname` varchar(256) DEFAULT NULL,
  `productbrand` varchar(64) DEFAULT NULL,
  `producttype` varchar(64) DEFAULT NULL,
  `buyprice` varchar(16) DEFAULT NULL,
  `sellprice` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`productID`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (5,'Accuboorhamerssd','Worx','WX 382','69.95','111.75'),(6,'Accuboorhamertje','Worx','WX 382','69.95','200.56'),(7,'test','test','test','12','787'),(8,'Accuboorhamer','eerWorx','WX 382er','69.95','111.75'),(9,'zakdropjeste','strontvliegje','ETG3R','50','100'),(10,'Accuboorhamer','Worx','WX 382','12','78'),(11,'Product','merk','type','3','87'),(12,'productje','merk','type','3','87'),(13,'Boormachine','Siemens','PL-TNX','89.99','119.95'),(14,'kak','poep','poep','','2'),(15,'boorhamer','merk','type','56','67'),(16,'hjh','khjkk','kggh','8','9'),(17,'dfdfdfgf','sdsdssfd','asddsdsd','5','6'),(18,'banaan','merk','type','1','2'),(19,'Accuboorhamer 45874958','Worx','WX 382','69,95','111,75'),(20,'telefoon','t','t','24','24'),(21,'houten poppetje','IKEA','1234','49.99','99.99'),(22,'Accuboorhamer','Worx','WX 382','69.95','111.75'),(23,'4-in-1 schuurmachine','Black & Decker','KA 280 K','55.95','67.95'),(24,'Verstekzaag','Einhell','BT-MS 2112','49.95','67.49'),(25,'Alleszuiger','Karcher','WD2.200','29.95','100'),(26,'Accuboormachine','Bosch','PSR 14.4','24.95','68.00'),(27,'33-delige borenset','Sencys','kaas 124','9.95','15.2'),(28,'Workmate','Black and Decker','WM 536','69','63.2'),(29,'Kruislijnlaserset','Bosch','PCL 20','99.95','122.4'),(30,'Accuboormachine','Bosch','PSR 14.4','59.95','68.00'),(31,'4-in-1 schuurmachine','Black and Decker','KA 280 K','49.95','69.95'),(32,'2 test','test34','tesdter','23','34'),(33,NULL,NULL,NULL,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (29,'daanklein75@gmail.com','Daan1241','878886c3d29958bcc1496ef8fd54831c5791860c','employee','EN','a2ef32e953560e3b17040d3aea5b032b5975b411','504054',''),(41,'pdevries@roc-dev.com','P. De Vries','7f1795b14bcd6cab546bae410d968511de00e92b','admin','EN','da9340567f46831b9622affc7c3d6737610aa4cf','911845','');
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

-- Dump completed on 2021-04-12 16:16:30
