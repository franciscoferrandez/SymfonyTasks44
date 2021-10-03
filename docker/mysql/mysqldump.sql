-- MariaDB dump 10.17  Distrib 10.4.8-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: vr.symfony4.edu
-- ------------------------------------------------------
-- Server version	10.4.8-MariaDB

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
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2D5B023498260155` (`region_id`),
  CONSTRAINT `FK_2D5B023498260155` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `city`
--

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
INSERT INTO `city` VALUES (1,1,'Valencia'),(2,1,'Sueca'),(3,1,'Aldaia'),(4,2,'Elche'),(5,2,'Alicante'),(7,2,'Crevillente');
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `commercial_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `acronym` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `back_color` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#444444',
  `fore_color` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#eeeeee',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_81398E09A76ED395` (`user_id`),
  CONSTRAINT `FK_81398E09A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (2,8,'Nunsys','Nunsys','NUN','#ff0080','#eeeeee','2020-08-26 17:53:34'),(3,7,'Paradigma Tec','Paradigma','PDG','#800000','#ffff00','2020-08-26 19:57:31'),(4,8,'UCI Informática','UCI','UCI','#0000ff','#eeeeee','2020-09-26 13:44:54');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20200822175047','2020-08-22 19:58:38',43),('DoctrineMigrations\\Version20200824020726','2020-08-24 04:07:58',54),('DoctrineMigrations\\Version20200824105342','2020-08-24 12:54:10',383),('DoctrineMigrations\\Version20200824110837','2020-08-24 13:09:30',40),('DoctrineMigrations\\Version20200825194049','2020-08-25 21:41:32',412),('DoctrineMigrations\\Version20200825214156','2020-08-25 23:42:21',38),('DoctrineMigrations\\Version20200827231929','2020-08-28 01:20:09',630),('DoctrineMigrations\\Version20200926213838','2020-09-26 23:40:38',960);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region`
--

LOCK TABLES `region` WRITE;
/*!40000 ALTER TABLE `region` DISABLE KEYS */;
INSERT INTO `region` VALUES (1,'Valencia'),(2,'Alicante'),(3,'Castellón'),(4,'Murcia');
/*!40000 ALTER TABLE `region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(250) NOT NULL,
  `content` text DEFAULT NULL,
  `priority` varchar(50) DEFAULT 'MEDIUM',
  `hours` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_task_user` (`user_id`),
  KEY `IDX_527EDB259395C3F3` (`customer_id`),
  CONSTRAINT `FK_527EDB259395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  CONSTRAINT `fk_task_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task`
--

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` VALUES (1,7,'Tarea 1 modificada','Prueba de tarea 1','HIGH',4,'2020-08-17 20:21:42',0,3),(2,7,'Tarea 2 modificada','modificada 2','MEDIUM',2,'2020-08-17 20:22:11',0,NULL),(6,8,'Problema contadores e incidencias','','MEDIUM',8,'2020-08-20 16:58:24',0,2),(7,7,'tarea modificada por ADMIN','lorem ipsum dolor sit amet','LOW',9,'2020-08-20 17:32:57',0,NULL),(8,7,'Tarea con estado','x','MEDIUM',1,'2020-08-24 13:20:52',20,3),(9,8,'Problema put departamentos y secciones','','MEDIUM',8,'2020-09-26 13:58:41',0,2),(10,8,'Despliegue en QA para PRE','','MEDIUM',4,'2020-09-26 13:59:18',0,2),(11,8,'Despliegue a PRO','','MEDIUM',2,'2020-09-26 13:59:37',0,2),(12,8,'Tipología incidencias al igual que en contadores','','MEDIUM',6,'2020-09-26 14:01:49',0,2),(13,8,'Tarea de Paco','','MEDIUM',0,'2020-09-26 20:36:15',0,4),(14,8,'Tarea para Paco','','MEDIUM',0,'2020-09-26 21:31:54',0,3),(15,7,'Tarea para Paco II','','MEDIUM',0,'2020-09-26 22:11:42',0,3),(16,7,'Tarea de Paco II','','MEDIUM',0,'2020-09-26 22:12:32',0,3);
/*!40000 ALTER TABLE `task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) DEFAULT '',
  `name` varchar(100) DEFAULT '',
  `surname` varchar(250) DEFAULT '',
  `email` varchar(250) DEFAULT '',
  `password` varchar(250) DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (7,'ROLE_USER','Paco','Que mi paco','paco@paco.com','$2y$04$g8YuR7576E/GnUBhtAn32usWDWuhZXeBtoqyi7VCnWdm1CRsWKXE2','2020-08-20 12:07:12','2021-06-04 11:55:34'),(8,'ROLE_ADMIN','Francisco M.','Ferrández Sánchez','francisco.ferrandez@gmail.com','$2y$04$Cc8eW5kJbaUYdWIkxyykmeETmxxnGYBRO76xC7OQgxPuHX.nu4H.a','2020-08-22 19:34:32','2021-09-22 06:49:27'),(14,'ROLE_GUEST','usuario','validado','asdfasda@falso.com','$2y$04$AmVyY9.QFeuwrbi6Ck29o.U25IWi6RYsxa9b3KaWM2vUUn9T6YfTi','2020-08-24 03:53:49',NULL),(15,'ROLE_USER','unique','uno','email@email.com','$2y$04$WJTUiS.kZr6JDk0WVryyEegiO1gC.MuzBNVOxkjVou0s9QamvlU36','2020-08-24 04:01:25',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venue`
--

DROP TABLE IF EXISTS `venue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_91911B0D98260155` (`region_id`),
  KEY `IDX_91911B0D8BAC62AF` (`city_id`),
  CONSTRAINT `FK_91911B0D8BAC62AF` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  CONSTRAINT `FK_91911B0D98260155` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venue`
--

LOCK TABLES `venue` WRITE;
/*!40000 ALTER TABLE `venue` DISABLE KEYS */;
INSERT INTO `venue` VALUES (1,2,4,'Gran Teatro'),(2,1,3,'Teatro de Aldaia'),(3,3,NULL,'Auditorio de Castellón');
/*!40000 ALTER TABLE `venue` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-09-27 16:14:50
