-- MySQL dump 10.13  Distrib 5.7.26, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: qframe
-- ------------------------------------------------------
-- Server version	5.7.26-log

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `account` varchar(128) NOT NULL COMMENT '账号',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `name` varchar(64) NOT NULL COMMENT '名称',
  `is_disable` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '是否禁用',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建日期',
  `update_time` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accountUnique` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','$2y$10$FmG0bF8Y.ViOrVL/uuXQKeHQSszdleKtpxfm4FKvfcKybVyQxvHly','Shadow',2,1550059258,1565168448),(2,'客服','$2y$10$VsC9MW3JQBfdU.PtJCl7yePzvdx.T08EfILY12YqyfMWoYzS7KbdO','客服',2,1550059258,NULL);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_login_log`
--

DROP TABLE IF EXISTS `admin_login_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user` varchar(255) DEFAULT NULL COMMENT '登录用户',
  `ip` varchar(255) DEFAULT NULL COMMENT '登录ip',
  `port` varchar(255) DEFAULT NULL COMMENT '端口',
  `browser` varchar(255) DEFAULT NULL COMMENT '浏览器',
  `note` varchar(255) DEFAULT NULL COMMENT '注释',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '是否成功登录  0-未成功 1-成功登录',
  `create_time` datetime DEFAULT NULL COMMENT '登录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_login_log`
--

LOCK TABLES `admin_login_log` WRITE;
/*!40000 ALTER TABLE `admin_login_log` DISABLE KEYS */;
INSERT INTO `admin_login_log` VALUES (1,'admin','127.0.0.1','80','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36','登录成功！',1,'2019-08-07 17:12:40'),(2,'admin','127.0.0.1','80','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36','登录成功！',1,'2019-08-07 17:12:53'),(3,'admin','127.0.0.1','80','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36','登录成功！',1,'2019-08-07 17:12:58');
/*!40000 ALTER TABLE `admin_login_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_group`
--

DROP TABLE IF EXISTS `auth_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(2048) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_group`
--

LOCK TABLES `auth_group` WRITE;
/*!40000 ALTER TABLE `auth_group` DISABLE KEYS */;
INSERT INTO `auth_group` VALUES (1,'管理员',1,'1,2,19,18,17,16,5,3,22,21,20,4,25,24,23'),(5,'行政',1,'6,10,13'),(6,'客服',1,'1,3,6,10'),(8,'财务',1,'1,4,6,13'),(9,'aaa',1,'1,2,5,16,17,18,19,3,20,21,22,4,23,24,25');
/*!40000 ALTER TABLE `auth_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_group_access`
--

DROP TABLE IF EXISTS `auth_group_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_group_access` (
  `uid` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_group_access`
--

LOCK TABLES `auth_group_access` WRITE;
/*!40000 ALTER TABLE `auth_group_access` DISABLE KEYS */;
INSERT INTO `auth_group_access` VALUES (1,1),(1,5),(2,6);
/*!40000 ALTER TABLE `auth_group_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '父级id',
  `name` varchar(80) DEFAULT NULL COMMENT '节点',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `pid` int(10) unsigned DEFAULT NULL,
  `condition` char(100) NOT NULL DEFAULT '',
  `faicon` varchar(255) DEFAULT '' COMMENT '图标',
  `sort` int(10) unsigned DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
INSERT INTO `auth_rule` VALUES (1,NULL,'权限管理',1,1,0,'','glyphicon glyphicon-lock',100),(2,'admin/index','管理员管理',1,1,1,'','glyphicon glyphicon-home',NULL),(3,'auth/group','角色组',1,1,1,'','fa fa-user-friends',NULL),(4,'auth/rule','权限规则',1,1,1,'','fa fa-bars',NULL),(5,'admin/add','管理员添加',1,1,2,'','fa fa-list',NULL),(16,'admin/edit','编辑',1,1,2,'','glyphicon glyphicon-edit',NULL),(17,'admin/delete','删除',1,1,2,'','glyphicon glyphicon-trash',NULL),(18,'admin/enable','启用',1,1,2,'','glyphicon glyphicon-check',NULL),(19,'admin/disable','禁用',1,1,2,'','glyphicon glyphicon-remove',NULL),(20,'auth/add','添加',1,1,3,'','glyphicon glyphicon-plus',NULL),(21,'auth/edit','编辑',1,1,3,'','glyphicon glyphicon-edit',NULL),(22,'auth/del','删除',1,1,3,'','glyphicon glyphicon-trash',NULL),(23,'auth/addrule','添加',1,1,4,'','glyphicon glyphicon-plus',NULL),(24,'auth/editrule','编辑',1,1,4,'','glyphicon glyphicon-edit',NULL),(25,'auth/delrule','删除',1,1,4,'','glyphicon glyphicon-trash',NULL),(26,NULL,'会员管理',1,1,0,'','glyphicon glyphicon-user',300),(31,NULL,'系统设置',1,1,0,'','glyphicon glyphicon-cog',200),(32,'user/index','会员列表',1,1,26,'','glyphicon glyphicon-menu-hamburger',0),(33,'setting/index','系统配置列表',1,1,31,'','glyphicon glyphicon-align-justify',NULL);
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `module` varchar(50) DEFAULT NULL COMMENT '模块',
  `code` varchar(30) DEFAULT NULL COMMENT '值',
  `val` longtext COMMENT '名称',
  `name` varchar(100) DEFAULT NULL COMMENT '名称',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni` (`module`,`code`),
  KEY `module` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` VALUES (1,'site','siteName','桥通天下','系统名称'),(2,'version','version','1.0.1','版本'),(3,'sms','key','','短信接口code'),(4,'sms','tplId','','短信模板ID'),(5,'sms','url','http://v.juhe.cn/sms/send','短信url');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'hxc','$2y$10$H.kbD.glAyW6q5U2K2guzOpJvpd.Bnj/gD2an.Rw9Nqwh3K9BcwJC',1557970689,1557970699),(5,'hxc3','$2y$10$b08xd3umUto0QtPbDXF9YO/ZoBKr2oVCJAFVCaNiyHPSFX9jEm1ay',1557970499,1557970699);
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

-- Dump completed on 2019-08-07 17:53:10
