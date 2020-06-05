-- MySQL dump 10.13  Distrib 5.7.17, for osx10.12 (x86_64)
--
-- Host: localhost    Database: weixin
-- ------------------------------------------------------
-- Server version	5.7.17

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
-- Table structure for table `wx_admin_user`
--

DROP TABLE IF EXISTS `wx_admin_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wx_admin_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(100) NOT NULL COMMENT 'login user name',
  `passd` varchar(100) NOT NULL DEFAULT '123456' COMMENT 'login user password.Default password is 123456',
  `role` int(11) DEFAULT '0' COMMENT 'user role: 0=master,1=admin,2=guester,4=forbidden',
  `phone` varchar(20) DEFAULT NULL,
  `weixinNum` varchar(60) DEFAULT NULL COMMENT 'user weixin number',
  `remark` varchar(200) DEFAULT 'master user' COMMENT 'remark infomations',
  PRIMARY KEY (`uid`,`uname`),
  UNIQUE KEY `uname` (`uname`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_admin_user`
--

LOCK TABLES `wx_admin_user` WRITE;
/*!40000 ALTER TABLE `wx_admin_user` DISABLE KEYS */;
INSERT INTO `wx_admin_user` VALUES (1,'admin','123456',0,'13012345678','kunyintang','just a test data');
/*!40000 ALTER TABLE `wx_admin_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wx_analysis_info`
--

DROP TABLE IF EXISTS `wx_analysis_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wx_analysis_info` (
  `analyzeId` int(11) NOT NULL AUTO_INCREMENT,
  `wxId` int(11) NOT NULL COMMENT 'the wxId in wx_data_info table',
  `clientIp` varchar(100) NOT NULL COMMENT 'the remote client ip address',
  `viewCount` int(11) DEFAULT 0 COMMENT 'weixin view count number',
  `lastViewDate` varchar(30) DEFAULT NULL COMMENT 'the last viewed time',
  `refUrl` varchar(400) NOT NULL COMMENT 'the referer of visite url',
  PRIMARY KEY (`analyzeId`,`wxId`,`clientIp`,`refUrl`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_analysis_info`
--

LOCK TABLES `wx_analysis_info` WRITE;
/*!40000 ALTER TABLE `wx_analysis_info` DISABLE KEYS */;
INSERT INTO `wx_analysis_info` VALUES (1,1,'127.0.0.1',18,'2017-02-26 09:29:06pm','localhost:9090/?wid=1'),(9,2,'127.0.0.1',12,'2017-02-26 09:18:59pm','localhost:9090/?wid=2'),(10,3,'127.0.0.1',12,'2017-02-25 08:44:24pm','localhost:9090/?wid=3'),(11,1,'127.0.0.1',5,'2017-02-26 02:25:55pm','https://www.baidu.com'),(12,1,'127.0.0.1',5,'2017-02-26 02:25:55pm','https://www.google.com'),(13,9,'127.0.0.1',24,'2017-02-26 09:45:43pm','localhost:9090/?wid=9'),(14,1,'127.0.0.1',0,'2017-02-27 09:23:44pm','localhost:9090/get.php?wid=1'),(15,2,'127.0.0.1',3,'2017-02-27 09:32:52pm','localhost:9090/get.php?wid=2'),(16,1,'127.0.0.1',11,'2017-02-28 09:58:05am','http://localhost:9090/');
/*!40000 ALTER TABLE `wx_analysis_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wx_data_info`
--

DROP TABLE IF EXISTS `wx_data_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wx_data_info` (
  `wxId` int(11) NOT NULL AUTO_INCREMENT,
  `wxNum` varchar(60) NOT NULL COMMENT 'weixin number',
  `wxQRCodeUrl` varchar(200) DEFAULT NULL COMMENT 'weixin qrcode image url',
  `state` int(11) DEFAULT '0' COMMENT '0:enable,1:disable',
  PRIMARY KEY (`wxId`,`wxNum`),
  UNIQUE KEY `wxNum` (`wxNum`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_data_info`
--

LOCK TABLES `wx_data_info` WRITE;
/*!40000 ALTER TABLE `wx_data_info` DISABLE KEYS */;
INSERT INTO `wx_data_info` VALUES (1,'test1','https://shuoit.net/images/weixin_donate.png',0),(2,'test2','https://shuoit.net/images/weixin_donate.png',0),(3,'test3','https://shuoit.net/images/weixin_donate.png',0),(5,'test5','https://shuoit.net/images/weixin_donate.png',0),(6,'test6','https://shuoit.net/images/weixin_donate.png',1),(7,'test7','https://shuoit.net/images/weixin_donate.png',0),(9,'test9','https://shuoit.net/images/weixin_donate.png',1),(10,'test10','https://shuoit.net/images/weixin_donate.png',0),(11,'lishu666','http://lishu66.com/weixintest.png',0),(12,'jaychou888','http://www.zhoujielun.com/xxx.jpg',1),(14,'hujiangkang888','000',0);
/*!40000 ALTER TABLE `wx_data_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-28  9:59:45
