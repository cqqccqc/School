-- MySQL dump 10.13  Distrib 5.6.16, for Win64 (x86_64)
--
-- Host: localhost    Database: doucoin
-- ------------------------------------------------------
-- Server version	5.6.16

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
-- Table structure for table `ecoin`
--

DROP TABLE IF EXISTS `ecoin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ecoin` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cename` varchar(5) NOT NULL COMMENT 'coin id',
  `cname` varchar(20) NOT NULL COMMENT 'coin name',
  `address` varchar(32) NOT NULL COMMENT '网站钱包地址',
  `cprice` double NOT NULL,
  PRIMARY KEY (`cid`),
  UNIQUE KEY `cname` (`cname`),
  KEY `cid` (`cename`),
  KEY `cid_2` (`cename`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ecoin`
--


/*!40000 ALTER TABLE `ecoin` DISABLE KEYS */;
INSERT INTO `ecoin` VALUES (1,'doc','逗币','',2222),(2,'btc','比特币','',3000),(3,'ltc','莱特币','',70),(4,'cmc','宇宙币','',4.6),(5,'mec','美卡币','',3.1),(6,'ppc','点点币','',9.023),(7,'bqc','烧烤币','',12.45),(8,'dog','狗狗币','',12.56),(9,'nxt','未来币','',45.1),(10,'xcp','合约币','',12.5),(11,'pts','原型股','',2.6),(12,'wdc','世界币','',0.1),(13,'net','网络币','',4.98),(14,'red','红币','',7.45),(15,'yac','雅币','',12.43),(16,'dtc','数据币','',2.1),(17,'rmb','人民币','',1);
/*!40000 ALTER TABLE `ecoin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eprice`
--

DROP TABLE IF EXISTS `eprice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eprice` (
  `cid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eprice`
--


/*!40000 ALTER TABLE `eprice` DISABLE KEYS */;
INSERT INTO `eprice` VALUES (1,1,1.2),(1,2,1.4),(1,3,1.5),(1,4,1.7),(1,1398155804,2124),(1,1398158188,2333),(1,1398158335,2333),(1,1398159578,1234),(1,1398160002,2222),(1,1398160217,1112),(1,1398160401,2222);
/*!40000 ALTER TABLE `eprice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `odetail`
--

DROP TABLE IF EXISTS `odetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `odetail` (
  `oid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `price` double NOT NULL,
  `num` double NOT NULL,
  `bos` enum('b','s') NOT NULL,
  `state` enum('c','o','d') NOT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `odetail`
--


/*!40000 ALTER TABLE `odetail` DISABLE KEYS */;
INSERT INTO `odetail` VALUES (1,0,1000,11,'b','c'),(2,0,3000,1,'s','c'),(3,0,1111,3,'b','c'),(4,0,1112,2,'b','c'),(5,0,1113,3,'b','c'),(6,0,1114,1,'b','c'),(7,0,1115,4,'b','c'),(8,0,1126,5,'b','c'),(9,1398070046,1117,2.1,'b','o'),(10,1398070340,3500,15,'s','o'),(11,1398148602,2333,11,'s','d'),(12,1398149912,1000,12,'b','o'),(13,1398150069,1111,12,'b','o'),(14,1398150102,2124,12,'s','d'),(15,1398150448,22221,13,'s','o'),(16,1398150511,22221,13,'s','o'),(17,1398155804,2124,12,'b','d'),(18,1398157797,2333,11,'b','d'),(19,1398157814,2333,11,'b','d'),(20,1398157985,2333,11,'s','d'),(21,1398158007,2333,11,'s','d'),(22,1398158096,2333,11,'b','d'),(23,1398158108,2333,11,'b','d'),(24,1398158188,2333,11,'s','d'),(25,1398158291,2333,11,'s','d'),(26,1398158334,2333,11,'b','d'),(27,1398159402,2333,11,'s','d'),(28,1398159422,2333,11,'b','d'),(29,1398159496,1234,11,'s','d'),(30,1398159508,1234,11,'b','d'),(31,1398159566,1234,11,'s','d'),(32,1398159578,1234,11,'b','d'),(33,1398159953,2222,2,'s','d'),(34,1398160002,2222,2,'b','d'),(35,1398160188,1112,1,'s','d'),(36,1398160216,1112,1,'b','d'),(37,1398160360,2222,2,'s','d'),(38,1398160400,2222,2,'b','d'),(39,1398167446,3214,1,'s','o');
/*!40000 ALTER TABLE `odetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL COMMENT 'cid',
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`oid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--


/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,1),(1,1,2),(1,1,3),(1,1,4),(1,1,5),(1,1,6),(1,1,7),(1,2,8),(1,2,9),(1,2,10),(1,1,11),(1,1,12),(1,1,13),(1,1,14),(1,1,15),(1,1,16),(1,1,17),(1,1,18),(1,1,19),(1,1,20),(1,1,21),(1,1,22),(1,1,23),(1,1,24),(1,1,25),(1,1,26),(1,1,27),(1,1,28),(1,1,29),(1,1,30),(1,1,31),(1,1,32),(2,1,33),(1,1,34),(1,1,35),(1,1,36),(2,1,37),(1,1,38),(1,1,39);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property`
--

DROP TABLE IF EXISTS `property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property` (
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `num` double NOT NULL,
  KEY `uid_idx` (`uid`),
  KEY `cid_idx` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property`
--


/*!40000 ALTER TABLE `property` DISABLE KEYS */;
INSERT INTO `property` VALUES (1,1,71),(1,2,112),(1,3,112),(1,4,112),(1,5,112),(1,6,112),(1,7,112),(1,8,112),(1,9,112),(1,10,112),(1,11,112),(1,12,112),(1,13,112),(1,14,112),(1,15,112),(1,16,112),(1,17,11111),(2,1,1230),(2,2,0),(2,3,0),(2,4,0),(2,5,0),(2,6,0),(2,7,0),(2,8,0),(2,9,0),(2,10,0),(2,11,0),(2,12,0),(2,13,0),(2,14,0),(2,15,0),(2,16,0),(2,17,26666);
/*!40000 ALTER TABLE `property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'uid',
  `email` varchar(50) NOT NULL COMMENT 'email address',
  `spwd` varchar(32) NOT NULL COMMENT 'sign in password',
  `tpwd` varchar(32) NOT NULL COMMENT 'transaction password',
  `phone` varchar(11) NOT NULL COMMENT 'cell phone number',
  `rtime` int(11) NOT NULL COMMENT 'register time stamp',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`,`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--


/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'1@1.com','c4ca4238a0b923820dcc509a6f75849b','6512bd43d9caa6e02c990b0a82652dca','1',1397531641),(2,'2@2.com','c81e728d9d4c2f636f067f89cc14862c','b6d767d2f8ed5d21a44b0e5886680cb9','2',1398159607);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-22 21:04:43
