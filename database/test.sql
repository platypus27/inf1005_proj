-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: blog
-- ------------------------------------------------------
-- Server version	8.0.31

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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `comment` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `usr_id` int unsigned NOT NULL,
  `posts_id` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_posts_id_foreign` (`posts_id`),
  KEY `comments_usr_id_foreign` (`usr_id`),
  CONSTRAINT `comments_posts_id_foreign` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_usr_id_foreign` FOREIGN KEY (`usr_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_us` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_us`
--

LOCK TABLES `contact_us` WRITE;
/*!40000 ALTER TABLE `contact_us` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_us` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friend_requests`
--

DROP TABLE IF EXISTS `friend_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friend_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userID` int unsigned NOT NULL,
  `friendID` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_idx` (`userID`),
  KEY `friend_idx` (`friendID`),
  CONSTRAINT `friend` FOREIGN KEY (`friendID`) REFERENCES `users` (`id`),
  CONSTRAINT `user` FOREIGN KEY (`userID`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friend_requests`
--

LOCK TABLES `friend_requests` WRITE;
/*!40000 ALTER TABLE `friend_requests` DISABLE KEYS */;
INSERT INTO `friend_requests` VALUES (17,3,40),(24,2,40),(26,40,41),(27,39,40);
/*!40000 ALTER TABLE `friend_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friends_list`
--

DROP TABLE IF EXISTS `friends_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friends_list` (
  `friendA` int unsigned NOT NULL,
  `friendB` int unsigned NOT NULL,
  PRIMARY KEY (`friendA`,`friendB`),
  KEY `frnB_idx` (`friendB`),
  CONSTRAINT `frnA` FOREIGN KEY (`friendA`) REFERENCES `users` (`id`),
  CONSTRAINT `frnB` FOREIGN KEY (`friendB`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends_list`
--

LOCK TABLES `friends_list` WRITE;
/*!40000 ALTER TABLE `friends_list` DISABLE KEYS */;
INSERT INTO `friends_list` VALUES (40,1),(40,4),(4,40),(5,40);
/*!40000 ALTER TABLE `friends_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_likes`
--

DROP TABLE IF EXISTS `post_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `posts_id` int unsigned NOT NULL,
  `usr_id` int unsigned NOT NULL,
  `liked_at` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id_idx` (`posts_id`),
  KEY `usr_id_idx` (`usr_id`),
  CONSTRAINT `fk_posts_id` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `fk_usr_id` FOREIGN KEY (`usr_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_likes`
--

LOCK TABLES `post_likes` WRITE;
/*!40000 ALTER TABLE `post_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` int unsigned NOT NULL,
  `updated_at` int unsigned NOT NULL,
  `usr_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_usr_id_foreign` (`usr_id`),
  CONSTRAINT `posts_usr_id_foreign` FOREIGN KEY (`usr_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'test','test first post',1709727950,1709727950,40),(2,'test2','test2',1709797463,1709797463,40),(3,'test3','test',1709799072,1709799072,40),(4,'test4','test',1709799079,1709799079,40),(5,'test5','test',1709799085,1709799085,40),(6,'test5','test',1709799150,1709799150,40),(7,'test6','test',1709799155,1709799155,40);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `loginid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `isadmin` tinyint NOT NULL DEFAULT '0',
  `suspended` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_loginid_unique` (`loginid`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'testuser1','testuser1','test@gmail.com','test',0,0),(2,'testuser2','testuser2','test@gmail.com','test',0,0),(3,'testuser3','testuser3','test@gmail.com','test',0,0),(4,'testuser4','testuser4','test@gmail.com','test',0,0),(5,'testuser5','testuser5','test@gmail.com','test',0,0),(39,'tom','$2y$10$6ObsbyL14KrP1EegZuk2KO4AvrFRAhY6WkIWAQ9hm4869bOq0kuuW','tom@gmail.com','tom',1,0),(40,'jay','$2y$10$.ZBYcSU41dHxWHShBPYP/umFii4lBiA9Ub8yVl/lWSu/LZINe5oy2','jay@gmail.com','jay',0,0),(41,'dylan','$2y$10$j8eJxMZOIi5u2j3BoVCCLe4vyPJKHIHfW9fNm1YXaBZGOZERojQyy','dylan@gmail.com','dylan',0,0);
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

-- Dump completed on 2024-03-13  0:48:43
