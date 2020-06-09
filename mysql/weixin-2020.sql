-- MySQL dump 10.13  Distrib 8.0.19, for osx10.15 (x86_64)
--
-- Host: localhost    Database: weixin
-- ------------------------------------------------------
-- Server version	8.0.19

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
-- Current Database: `weixin`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `weixin` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `weixin`;

--
-- Table structure for table `wx_analysis_info`
--

DROP TABLE IF EXISTS `wx_analysis_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wx_analysis_info` (
  `analyzeId` int NOT NULL AUTO_INCREMENT,
  `wxId` int NOT NULL COMMENT 'the wxId in wx_data_info table',
  `clientIp` varchar(60) NOT NULL DEFAULT '0.0.0.0' COMMENT 'the remote client ip address',
  `viewCount` int DEFAULT '1' COMMENT 'weixin view count number',
  `lastViewDate` varchar(30) DEFAULT NULL COMMENT 'the last viewed time',
  `refUrl` varchar(200) DEFAULT NULL COMMENT 'the referer of visite url',
  PRIMARY KEY (`analyzeId`,`wxId`,`clientIp`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_analysis_info`
--

LOCK TABLES `wx_analysis_info` WRITE;
/*!40000 ALTER TABLE `wx_analysis_info` DISABLE KEYS */;
INSERT INTO `wx_analysis_info` VALUES (1,1,'0.0.0.0',1,NULL,NULL),(2,1,'127.0.0.1',8,'2020-06-09 02:14:43pm','http://demo.php.com/');
/*!40000 ALTER TABLE `wx_analysis_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wx_data_info`
--

DROP TABLE IF EXISTS `wx_data_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wx_data_info` (
  `wxId` int NOT NULL AUTO_INCREMENT,
  `groupId` int NOT NULL,
  `wxNum` varchar(60) NOT NULL COMMENT 'weixin number',
  `wxQRCodeUrl` varchar(200) DEFAULT NULL COMMENT 'weixin qrcode image url',
  `state` int DEFAULT '0' COMMENT '0:enable,1:disable',
  PRIMARY KEY (`wxId`,`wxNum`),
  UNIQUE KEY `wxNum` (`wxNum`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_data_info`
--

LOCK TABLES `wx_data_info` WRITE;
/*!40000 ALTER TABLE `wx_data_info` DISABLE KEYS */;
INSERT INTO `wx_data_info` VALUES (1,1,'test1','http://www.faxingw.cn/upload/image/20160314/1457948139747182.jpg',0),(2,1,'test2','http://www.faxingw.cn/upload/image/20160314/1457948139747182.jpg',0),(3,1,'test3','http://www.faxingw.cn/upload/image/20160314/1457948139747182.jpg',0),(4,1,'test4','http://www.faxingw.cn/upload/image/20160314/1457948139747182.jpg',0),(5,1,'test5','http://www.faxingw.cn/upload/image/20160314/1457948139747182.jpg',0),(6,2,'kunyintang','http://demo.php.com/manager.php?id=2',0),(7,4,'sdfasdfsdf','http://demo.php.com/manager.php?id=4',0);
/*!40000 ALTER TABLE `wx_data_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wx_group`
--

DROP TABLE IF EXISTS `wx_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wx_group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL COMMENT 'login user name',
  `name` varchar(300) NOT NULL COMMENT 'wx group name',
  `status` int DEFAULT '0' COMMENT 'group status: 0=normal,1=forbidden|deleted',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_group`
--

LOCK TABLES `wx_group` WRITE;
/*!40000 ALTER TABLE `wx_group` DISABLE KEYS */;
INSERT INTO `wx_group` VALUES (1,1,'你自己',0),(2,1,'大佬王',0),(3,1,'李尼美',0),(4,1,'张尼玛',0),(5,1,'隔壁老王',0),(6,1,'隔壁老张',0),(7,1,'老李啊',0);
/*!40000 ALTER TABLE `wx_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wx_user`
--

DROP TABLE IF EXISTS `wx_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wx_user` (
  `uid` int NOT NULL AUTO_INCREMENT,
  `uname` varchar(100) NOT NULL COMMENT 'login user name',
  `passd` varchar(100) NOT NULL DEFAULT '123456' COMMENT 'login user password.Default password is 123456',
  `role` int DEFAULT '0' COMMENT 'user role: 0=master,1=admin,2=guester,4=forbidden',
  `phone` varchar(20) DEFAULT NULL COMMENT 'user contact phone',
  `remark` varchar(200) DEFAULT 'master user' COMMENT 'remark infomations',
  PRIMARY KEY (`uid`,`uname`),
  UNIQUE KEY `uname` (`uname`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_user`
--

LOCK TABLES `wx_user` WRITE;
/*!40000 ALTER TABLE `wx_user` DISABLE KEYS */;
INSERT INTO `wx_user` VALUES (1,'admin','123456',0,'13012345678','just a test data');
/*!40000 ALTER TABLE `wx_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-06-09 14:25:26
