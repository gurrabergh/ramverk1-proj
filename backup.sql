-- MySQL dump 10.17  Distrib 10.3.14-MariaDB, for CYGWIN (x86_64)
--
-- Host: 127.0.0.1    Database: ramverk1
-- ------------------------------------------------------
-- Server version	8.0.19

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
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `author` varchar(45) NOT NULL,
  `rating` int NOT NULL DEFAULT '0',
  `accepted` int NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `question` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_idx` (`author`),
  KEY `question_idx` (`question`),
  CONSTRAINT `auth` FOREIGN KEY (`author`) REFERENCES `users` (`nick`),
  CONSTRAINT `question` FOREIGN KEY (`question`) REFERENCES `questions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (4,'Testar att svara!','test',0,0,'2021-01-08 15:00:30',8),(5,'Hej?','test',1,0,'2021-01-08 15:00:44',8),(6,'g','test',0,1,'2021-01-08 15:01:28',8),(7,'ds','test',0,1,'2021-01-08 15:03:21',8),(8,'d','test',-1,1,'2021-01-08 15:03:29',8),(9,'Kul!','test2',0,0,'2021-01-08 16:36:39',7);
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `answer` int NOT NULL,
  `author` varchar(45) NOT NULL,
  `content` text NOT NULL,
  `rating` int NOT NULL DEFAULT '0',
  `question` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quest_idx` (`question`),
  CONSTRAINT `quest` FOREIGN KEY (`question`) REFERENCES `questions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,4,'test','Testar att kommentera!',0,8),(2,8,'test','hej',2,8),(3,4,'test','Igen?',1,8),(4,9,'test2','Hehehe',0,7),(5,5,'test','- hej\r\n- vad',0,8),(6,5,'test','hej\r\n===',0,8);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(450) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(45) NOT NULL,
  `rating` varchar(45) NOT NULL DEFAULT '0',
  `tags` text,
  `answers` int NOT NULL DEFAULT '0',
  `solved` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_idx` (`author`),
  CONSTRAINT `user` FOREIGN KEY (`author`) REFERENCES `users` (`nick`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (6,'Cajsa &auml;r b&auml;st','Testar testar!','test','0','cajsa b&auml;st',0,0),(7,'Cajsa &auml;r b&auml;st','Testar testar!','test','2','cajsa b&auml;st',1,0),(8,'En tredje fr&aring;ga','Jadu vi testar igen','test','13','kul skoj test',5,1);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `tag` varchar(45) NOT NULL,
  `question` int NOT NULL,
  KEY `id_idx` (`question`),
  CONSTRAINT `id` FOREIGN KEY (`question`) REFERENCES `questions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES ('cajsa',6),('b&auml;st',6),('cajsa',7),('b&auml;st',7),('kul',8),('skoj',8),('test',8);
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nick` varchar(45) NOT NULL,
  `password` varchar(450) NOT NULL,
  `rep` int NOT NULL DEFAULT '0',
  `votes` int NOT NULL DEFAULT '0',
  `email` varchar(100) NOT NULL,
  `bio` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nick_UNIQUE` (`nick`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'test','$2y$10$0UqeS6WxfrTO4gMyTjPVpO9gXp/IzhtOxyp4Fd5u58IJQ8/m58St.',24,1,'test@test.com','Hej jag &auml;r en testanv&auml;ndare!'),(2,'test2','$2y$10$hl1jvgHadmAa2SIUZlDJTeY4g1uv5Q9RLrsK7ndrMJpeFv6eK21bG',18,16,'test2@test.com','Jag &auml;r testanv&auml;ndare nr2.');
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

-- Dump completed on 2021-01-09 21:52:41
