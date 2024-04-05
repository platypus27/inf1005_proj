-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: blog2
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.22.04.1

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (4,'its a good day to be a soldier',41,2,1712251873),(7,'!!',42,4,1712252197),(10,'so close...',42,4,1712252260),(11,'so close...',42,3,1712252279),(12,'so close man!',43,3,1712252298),(13,'school is too easy',40,7,1712252370),(14,'yes sir!',41,5,1712252512),(15,'thats cap',41,4,1712252523),(16,'roughly 3 hours',41,9,1712252534),(17,'hello i am zac number 2',43,12,1712252631),(18,'wat story',43,11,1712252643),(19,'GFY',43,10,1712252650),(20,'I like a growing nose ;)',43,13,1712252673),(21,'U ARE THE GOAT',43,7,1712252697),(22,'dont be so mean',43,6,1712252707),(23,'Yummy as well!',43,14,1712252717),(24,'WTH',44,14,1712252738),(25,'gross',44,13,1712252746),(26,'hello',44,12,1712252752),(27,'i never seen one before',44,9,1712252773);
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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friend_requests`
--

LOCK TABLES `friend_requests` WRITE;
/*!40000 ALTER TABLE `friend_requests` DISABLE KEYS */;
INSERT INTO `friend_requests` VALUES (17,3,40),(24,2,40),(26,40,41),(27,39,40),(40,45,41),(41,45,40),(42,45,43);
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
  CONSTRAINT `fk_posts_id` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_usr_id` FOREIGN KEY (`usr_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_likes`
--

LOCK TABLES `post_likes` WRITE;
/*!40000 ALTER TABLE `post_likes` DISABLE KEYS */;
INSERT INTO `post_likes` VALUES (20,1,41,1712251934),(23,12,43,1712252634);
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
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` int unsigned NOT NULL,
  `updated_at` int unsigned NOT NULL,
  `usr_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_usr_id_foreign` (`usr_id`),
  CONSTRAINT `posts_usr_id_foreign` FOREIGN KEY (`usr_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'dylan might be crazy','Dylan\'s mind is a whirlwind of outlandish ideas, impulsive decisions, and a constant stream of barely coherent rants. He embraces chaos with a contagious energy, leaving everyone either utterly perplexed or swept up in his whirlwind of bizarre enthusiasm.',1709727950,1709727950,40),(2,'hormat saf','I&#039;d like to formally request a one-year extension of my current contract. My contributions have been valuable to the team, and I&#039;m eager to continue my work and grow within the company for another year. Please let me know the necessary steps to make this official.',1712251838,1712251838,41),(3,'i was 1 point away from ippt gold','That final push-up, the last few seconds on the run...  I came agonizingly close to IPPT Gold, just one measly point short. Frustrating? Absolutely. But it&#039;s fueling my determination for next time.',1712251996,1712251996,41),(4,'i dont fumble','These hands were made for holding onto success, not fumbling opportunities. My focus is sharp, my grip secure, and every move calculated. Whether it&#039;s a football, a deadline, or a chance to shine, I&#039;ve got this – no fumbles allowed.',1712252188,1712252188,42),(5,'Greetings Gents!','GREETING GENTS, I am here to inform you that your CST is starting in 2 weeks approximately so have fun.',1712252337,1712252337,43),(6,'xiangfan is weird','Xiangfan has a knack for the bizarre – from his obsession with pineapple pizza to his insistence on wearing socks with sandals.',1712252343,1712252343,40),(7,'im the smartest','Ideas? Pfft, those are for other people. I was born with all the answers downloaded into my brain. While the rest of the class struggles to spell &quot;encyclopedia&quot;, I&#039;m contemplating the complexities of quantum physics. Honestly, I should be the one teaching this class.',1712252361,1712252361,40),(8,'Was Jesus a psychedelic mushroom?','This question is related to John Marco Allegro&#039;s work and his book &#039;The Sacred Mushroom and The Cross&#039; (1970) (and the works of others, see References at the bottom) which posits that the true meaning of the Gospels could be pointing to a fertility cult from what we now call the first century CE.\r\n\r\nFirst, let me thank our Anonymous author ( Brian Fey&#039;s answer to Was Jesus a psychedelic mushroom? ) for giving a very good cursory view of the material and while I disagree with the certainty of your conclusion, a fair airing of controversial ideas we disagree with is always laudable. I *highly* recommend viewing the video Anonymous posted in that answer ( Psychedelic Jesus: Interview with the author of ‘The Sacred Mushroom And The Cross’ ) to get a better feel for who Allegro is as a person, if nothing else.',1712252393,1712252393,43),(9,'How long is an average poop?','I am laughing hysterically as I type.\r\n\r\nYou see I take 5 minutes to poop. If I am constipated, it goes up to 20 minutes!!! You should not have to worry about the time you spend in the toilet as long as your poop is normal looking. Just let is slide at its own pace :-D.\r\n\r\n*peace*',1712252458,1712252458,43),(10,'i love ice coffee','The rich aroma, the bold flavor, the jolt of icy caffeine – ice coffee is my elixir. It awakens my senses and fuels my day, a simple pleasure that transforms into pure joy.',1712252495,1712252495,41),(11,'What is the bravest thing a child has done?','A three-year-old girl fell into an abandoned well 20 meters deep. The diameter of the well was only 30 centimeters. Since the well was too small, the firefighters could not go down to save her in any way. If they had used an excavator at that time, it would have taken too long, too much.\r\n\r\nThat day, a volunteer had brought his son with him and said that the boy could try to save the girl.\r\n\r\nThe boy was 14 years old and his name is Min Ran. To not worry everyone, he lied saying that he was 17 years old. The firefighters informed him of the possible dangers. Min Ran and his parents said they were willing to take all possible risks.\r\n\r\nHe tried five times but without success.\r\n\r\nThe first and second time he had to come out to readjust the descent angle.\r\n\r\nThe third time he told the girl not to be afraid, I&#039;m here to save you. The fifth time he heard the girl tell him not to go. He comforted the girl by telling her not to be afraid, I will come back soon to save you. The sixth time, he finally made it.\r\n\r\nLater, a journalist asked him if he had been scared. He said that at that moment he wasn&#039;t thinking about anything, he was just thinking of saving the girl.',1712252561,1712252561,44),(12,'Crazy story','&quot;I am a white woman and although I did not give birth to this man, he is my son. He has been my son for 14 years. I love him like I birthed him.\r\n\r\nMy biological children grew up with him as their brother. He lived in my house. I would trust him with my life and he would trust me with his.\r\n\r\nI have watched him been treated unfairly....because of the color of his skin. I have seen him be falsely accused....because of the color of his skin.\r\n\r\nI will stand for him. I will fight for him. I will protect him to the best of my ability, and if I&#039;m honest....I would want to hurt anyone who tried to hurt him.\r\n\r\nI will never know what it is like to have brown or black skin but I do know what it is like to be a white woman who loves someone fiercely who has brown or black skin. And I know what it is like to pray every day that it will not be his last&quot;\r\n\r\n- Kimberley Brown',1712252611,1712252611,44),(13,'pinnochio','Pinocchio, the wooden boy with a growing nose, longed to be real. His journey was filled with lies, temptations, and lessons learned, reminding us of the importance of honesty and following our hearts.',1712252648,1712252648,45),(14,'i love dogs','Dogs embody pure joy – wagging tails, boundless energy, and those soulful eyes filled with unconditional love. They&#039;re loyal companions, goofy playmates, and the greatest source of furry cuddles, making every day a little brighter.',1712252679,1712252679,45);
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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'testuser1','testuser1','test@gmail.com','test',0,0),(2,'testuser2','testuser2','test@gmail.com','test',0,0),(3,'testuser3','testuser3','test@gmail.com','test',0,0),(4,'testuser4','testuser4','test@gmail.com','test',0,0),(5,'testuser5','testuser5','test@gmail.com','test',0,0),(39,'tom','$2y$10$6ObsbyL14KrP1EegZuk2KO4AvrFRAhY6WkIWAQ9hm4869bOq0kuuW','tom@gmail.com','tom',1,0),(40,'jay','$2y$10$.ZBYcSU41dHxWHShBPYP/umFii4lBiA9Ub8yVl/lWSu/LZINe5oy2','jay@gmail.com','jay',0,0),(41,'dylan','$2y$10$j8eJxMZOIi5u2j3BoVCCLe4vyPJKHIHfW9fNm1YXaBZGOZERojQyy','dylan@gmail.com','dylan',0,0),(42,'xiangfan','$2y$10$tKmdZF/ETLB/tVDvrssk4e537V6Sto1N/d5MoKNew3tg3.gZeqKwG','xf@gmail.com','xf',0,0),(43,'zongen','$2y$10$3jeJKPzDaii12aB6Zh29muTCwgcFX2I5tw9Q24xbvxNekTyw9Uqf2','aowaznhi@unaccusmail.com','Chua Zong En',0,0),(44,'nigel','$2y$10$/zWSnLycOEulaN10WCCksOn8mjxhv5Z8KVjE9oTbNx.Kywgg8h3dC','ggaikyep@metacinnmail.com','nigel choo',0,0),(45,'yurong','$2y$10$fpF0Z8rSqfkSeWFxVyfar.HwxoIcfhLvpkN1bhsOC236JEW5z2leq','yr@gmail.com','yr',0,0),(46,'norm','$2y$10$XrWXKf1oUY11L.2GI2X1y.4ijOf6lCMIXvQipfugycpomcvqoSB26','student@mail.com','norm',0,0);
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

-- Dump completed on 2024-04-05  1:46:38
