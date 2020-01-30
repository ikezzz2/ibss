-- MariaDB dump 10.17  Distrib 10.4.11-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: ibss
-- ------------------------------------------------------
-- Server version	10.4.11-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `menutable`
--

DROP TABLE IF EXISTS `menutable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menutable` (
  `productname` varchar(200) NOT NULL,
  `category` varchar(200) NOT NULL,
  `value` int(7) NOT NULL,
  `comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`productname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menutable`
--

LOCK TABLES `menutable` WRITE;
/*!40000 ALTER TABLE `menutable` DISABLE KEYS */;
INSERT INTO `menutable` VALUES ('おにぎり','ご飯',400,'梅、おかか、鮭、昆布、海苔'),('お茶漬け','ご飯',400,'うめ、昆布、おかか、海苔、ワサビが選べます'),('きゅうりの一本漬け','一品',400,NULL),('だし巻き卵','一品',400,NULL),('とりもも','焼き鳥',500,'たれか塩が選べます'),('ねぎま','焼き鳥',440,'たれか塩が選べます'),('ほうれん草','一品',300,NULL),('イカリング','揚げ物',700,'塩のみ'),('オレンジジュース','飲み物',300,NULL),('カクテル','飲み物',700,'スタッフが作ります'),('コーラ','飲み物',300,NULL),('スクリュードライバー','飲み物',500,NULL),('タコの揚げ物','揚げ物',600,'塩とつゆが選べます'),('ビール','飲み物',500,'キリンとアサヒが選べます'),('ワイン','飲み物',700,'白のみ'),('僕の考える最強の豚カツ','揚げ物',7800,NULL),('冷奴','一品',300,NULL),('唐揚げ','揚げ物',500,'揚げたて'),('天津飯','ご飯',700,'出来立て熱々です'),('季節の山菜天ぷら','揚げ物',800,'塩かつゆかを選べます'),('手巻き寿司','ご飯',600,'具が選べます'),('揚げ出し豆腐','揚げ物',400,''),('日本酒','飲み物',1000,'高級地酒'),('春巻き','揚げ物',600,''),('枝豆','一品',300,NULL),('水餃子','一品',500,NULL),('烏龍茶','飲み物',300,NULL),('焼きめし','ご飯',550,'エビが入っています'),('焼酎','飲み物',900,NULL),('白米','ご飯',400,'＋100円でふりかけが付きます'),('砂ぎも','焼き鳥',500,'たれか塩が選べます'),('豚バラ','焼き鳥',500,'たれか塩が選べます'),('鬼殺し','飲み物',900,NULL);
/*!40000 ALTER TABLE `menutable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nomimanagement`
--

DROP TABLE IF EXISTS `nomimanagement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nomimanagement` (
  `couseid` varchar(100) NOT NULL,
  `nomitime` int(2) NOT NULL,
  `value` int(7) NOT NULL,
  PRIMARY KEY (`couseid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nomimanagement`
--

LOCK TABLES `nomimanagement` WRITE;
/*!40000 ALTER TABLE `nomimanagement` DISABLE KEYS */;
INSERT INTO `nomimanagement` VALUES ('Aコース',2,2500),('Bコース',3,3000);
/*!40000 ALTER TABLE `nomimanagement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderaccept`
--

DROP TABLE IF EXISTS `orderaccept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderaccept` (
  `orderid` int(11) NOT NULL AUTO_INCREMENT,
  `productname` varchar(200) NOT NULL,
  `seatnum` int(3) NOT NULL,
  `servingflag` tinyint(1) NOT NULL,
  `value` int(100) NOT NULL,
  PRIMARY KEY (`orderid`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderaccept`
--

LOCK TABLES `orderaccept` WRITE;
/*!40000 ALTER TABLE `orderaccept` DISABLE KEYS */;
INSERT INTO `orderaccept` VALUES (246,'砂ぎも',7,1,500),(247,'砂ぎも',7,0,500),(248,'砂ぎも',7,0,500);
/*!40000 ALTER TABLE `orderaccept` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordermanagement`
--

DROP TABLE IF EXISTS `ordermanagement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordermanagement` (
  `seatnum` int(3) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(200) NOT NULL,
  `phonenum` bigint(11) NOT NULL,
  `numofpeople` int(3) NOT NULL,
  `starthour` datetime NOT NULL,
  `finhour` datetime NOT NULL,
  `couseid` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`seatnum`,`starthour`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordermanagement`
--

LOCK TABLES `ordermanagement` WRITE;
/*!40000 ALTER TABLE `ordermanagement` DISABLE KEYS */;
INSERT INTO `ordermanagement` VALUES (1,'2020-01-30','test',1234,12,'2020-01-30 13:20:00','2020-01-30 15:20:00','Aコース');
/*!40000 ALTER TABLE `ordermanagement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ownerinfo`
--

DROP TABLE IF EXISTS `ownerinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ownerinfo` (
  `id` int(250) NOT NULL,
  `password` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ownerinfo`
--

LOCK TABLES `ownerinfo` WRITE;
/*!40000 ALTER TABLE `ownerinfo` DISABLE KEYS */;
INSERT INTO `ownerinfo` VALUES (0,'root00');
/*!40000 ALTER TABLE `ownerinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seatinfo`
--

DROP TABLE IF EXISTS `seatinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seatinfo` (
  `seatnum` int(3) NOT NULL,
  `couseid` varchar(100) NOT NULL,
  `numofpeople` int(3) NOT NULL,
  PRIMARY KEY (`seatnum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seatinfo`
--

LOCK TABLES `seatinfo` WRITE;
/*!40000 ALTER TABLE `seatinfo` DISABLE KEYS */;
INSERT INTO `seatinfo` VALUES (1,'',0),(2,'',0),(3,'',0),(4,'',0),(5,'',0),(6,'',0),(7,'',0),(8,'',0),(9,'',0),(10,'',0);
/*!40000 ALTER TABLE `seatinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userinfo`
--

DROP TABLE IF EXISTS `userinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userinfo` (
  `id` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userinfo`
--

LOCK TABLES `userinfo` WRITE;
/*!40000 ALTER TABLE `userinfo` DISABLE KEYS */;
INSERT INTO `userinfo` VALUES ('1234','$2y$10$FMw68A3oGYwUMQEDEKURn.S3BQt3jOOxg4T4m21zwzqlgDFQnj8Q2'),('amimoto','$2y$10$o/Xk1oNq0JnEUzMgixTIj.jEPykoML06.ngn7dBWKouyALo5X8jYa'),('hakozaki','$2y$10$Aba.WzvKtcY/BkihPcGeieI1BTvTlZ/ZfNYfZ4jnq3yckKk3dwLh.'),('ikegami','$2y$10$DqQbe5kL64EtkTRl0ngDkOtHZxQLnZgxPXBz21H7jxukDDfUJm7tS'),('mimoto','$2y$10$uhiCVvdepRuQvzSjxouRlOLgotGpUa7daRiCdY2yT7K4IWoB5HZsK'),('nabeshima','$2y$10$A.fwVWRX4iYn4oxPFZ3u5uICQY4La3ENBegC2/PYqylGIYWxeimzi'),('shogo','$2y$10$x206tm/2oolXBoqJ1SrjU.ZIvRJjTR3VVusz/eUnMxlOv6hOoZnWu'),('test','$2y$10$oQqX2Ece2pa2LMFAWnEdi.2q2z3vNxddjOVKcKg/DWTYY3anvrxK6'),('user','$2y$10$rvQanOsocjHawX1XjbSrqeDAv/dp9f7wET/wfTWqwnr/y8qUne7Ee'),('yasuoka','$2y$10$cGbMA4M5B7Go1k43xGb59OCdYvuGuLmElCv8JaTF07fShR8UnISpa'),('箱崎','$2y$10$CZZOIcFnRC9v7xL0Hgz6tuHeX2vwSNRavHxv/Xw4gARP62cZktepa');
/*!40000 ALTER TABLE `userinfo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-30 12:24:08
