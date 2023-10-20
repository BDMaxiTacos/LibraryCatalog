-- MySQL dump 10.13  Distrib 8.0.34, for Linux (x86_64)
--
-- Host: localhost    Database: GDAlibrary
-- ------------------------------------------------------
-- Server version	8.0.34-0ubuntu0.22.04.1

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
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `author` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `handle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author`
--

LOCK TABLES `author` WRITE;
/*!40000 ALTER TABLE `author` DISABLE KEYS */;
INSERT INTO `author` VALUES (7,'Schinner','Chasity','sed'),(8,'Prosacco','Kenny','corrupti'),(9,'Olson','Andy','et');
/*!40000 ALTER TABLE `author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `author_book`
--

DROP TABLE IF EXISTS `author_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `author_book` (
  `author_id` int NOT NULL,
  `book_id` int NOT NULL,
  PRIMARY KEY (`author_id`,`book_id`),
  KEY `IDX_2F0A2BEEF675F31B` (`author_id`),
  KEY `IDX_2F0A2BEE16A2B381` (`book_id`),
  CONSTRAINT `FK_2F0A2BEE16A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_2F0A2BEEF675F31B` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author_book`
--

LOCK TABLES `author_book` WRITE;
/*!40000 ALTER TABLE `author_book` DISABLE KEYS */;
INSERT INTO `author_book` VALUES (7,19),(7,22),(7,24),(7,28),(7,29),(8,16),(8,18),(8,23),(8,24),(8,25),(8,27),(8,28),(8,29),(9,17),(9,20),(9,21),(9,26),(9,30);
/*!40000 ALTER TABLE `author_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publication_date` datetime NOT NULL,
  `catchphrase` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CBE5A33112469DE2` (`category_id`),
  CONSTRAINT `FK_CBE5A33112469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (16,8,'nam suscipit qui ut','2023-10-20 09:27:22','Innovative systemic knowledgeuser','Where are you?\' She did so, when she squeezed herself \'That\'s very tired of executions I WAS when she hardly room again, so extremely--\' Just then turned to turn or soldiers, or not. \'Oh, there\'s no use in a mouse--to a loud, indignant voice, and.'),(17,8,'quo qui id expedita','2023-10-20 09:27:22','Seamless heuristic functionalities','Alice, who is rather shyly, \'I--I hardly know--No more, thank ye; I\'m afraid, sir\' said these cakes,\' she gained courage as she stopped to Alice, and expecting nothing yet,\' said this, so nicely straightened out, for her life. The Hatter continued.'),(18,8,'ipsa perspiciatis quia excepturi','2023-10-20 09:27:22','Expanded motivating knowledgeuser','Geography. London is another minute or Australia?\' (and she went on in that a tiny hands and a voice of nearly forgotten the look at poor Alice did not mad. You\'re mad.\' \'I haven\'t found this grand words a bottle. They all at the Queen. \'You did,\'.'),(19,7,'temporibus vitae rem officiis','2023-10-20 09:27:22','Synchronised incremental website','Our family always HATED cats: nasty, low, and the time you ever be NO mistake it so far,\' said the Dormouse, after waiting for it, and saying to think,\' Alice dear!\' cried the bones and she repeated in bringing herself in the end of them word I.'),(20,9,'necessitatibus temporibus quidem autem','2023-10-20 09:27:22','Assimilated secondary synergy','As a neck of half down upon pegs. She was not to herself, as well enough; and she, oh! ever see what would feel very much, so long as I\'d hardly worth while plates and being held the use in a pity. I think you\'d only a T!\' said the very carefully.'),(21,9,'omnis alias quisquam voluptatum','2023-10-20 09:27:22','Grass-roots object-oriented ability','Everything is right?\' \'In that it matter with a blow underneath her flamingo: she said the way, and rushed at the hall. After these words \'DRINK ME,\' said Alice; \'only, as I must go THERE again!\' which way into the conversation with the watch to.'),(22,9,'deserunt non aut molestiae','2023-10-20 09:27:22','Vision-oriented mobile hierarchy','Footman continued the game was mouth open, gazing up by the Caterpillar. Alice soon the roof of trials, \"There is of half the twinkling of the Duchess, digging her hands, and both its body to the Footman. \'That\'s quite like changing the cook was.'),(23,7,'dolores voluptatem similique possimus','2023-10-20 09:27:22','Synergized encompassing portal','I think--\' (for, you see, as if you see.\' \'I feared it again!\' said the treacle out to it,\' said to be telling me to the end of meaning of little more puzzled, but at the thing about this, she was too large, or two. \'They must be patted on to the.'),(24,7,'deserunt eos veniam quis','2023-10-20 09:27:22','Cloned stable matrices','Go on!\' \'Everybody says \"come on!\" here,\' said in a regular course.\' \'What IS his fan and she was perfectly sure to listen, the Hatter. \'Stolen!\' the table and said Alice. \'It must have to wash off than THAT. Then came a voice close behind us, with.'),(25,7,'dolores in omnis sed','2023-10-20 09:27:22','Persistent 24/7 opensystem','Alice. One of escape, and she thought she, oh! she looked anxiously among mad things between them, and finding it to work, and it might be ONE.\' \'One, two, looking at this before, and stopped to me! When the Hatter went mad, you know. So she tried.'),(26,8,'quo commodi placeat veniam','2023-10-20 09:27:22','Inverse cohesive middleware','I like\"!\' \'You shan\'t be an old it puffed away without a Cheshire Cat again, for a very busily painting them so many footsteps, and Grief, they both of the whiting,\' said the hedgehog was dreadfully savage!\' exclaimed Alice. \'Now I wonder what it.'),(27,7,'sunt ex reiciendis inventore','2023-10-20 09:27:22','Self-enabling uniform benchmark','Alice. \'Why?\' \'IT DOES THE BOOTS AND WASHING--extra.\"\' \'You did!\' said the pool, \'and in his friends had grown most interesting, and eels, of her shoulders were followed them, and all anxious look at it, you talking at the Hatter instead!\' CHAPTER.'),(28,9,'quis eos mollitia est','2023-10-20 09:27:22','Realigned user-facing neural-net','Who in my adventures--beginning from the little scream, half of every golden key, and repeat lessons!\' thought Alice, \'to pretend to the distance, screaming with a ridge or two or more; They very uncomfortable, and, as she got to get any older than.'),(29,9,'ut quia ad ut','2023-10-20 09:27:22','Open-architected clear-thinking protocol','Alice, in a shrill, loud crash)--\'Now, who always get to be angry about as she began, \'for bringing the way into the list of the Gryphon, \'you see, as he can\'t help of Hearts, carrying the table, but no time there was trickling down upon its right.'),(30,9,'aut sed dolorem voluptatem','2023-10-20 09:27:22','Multi-lateral background emulation','There ought to do.\" Said his toes.\' [later editions continued in a teacup and yawned and peeped into her was a fan and hot day or \'Off with the goose, with another rush at the table. \'Have you mayn\'t believe to Alice herself, \'Now, Dinah, if you.');
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (7,'aliquam'),(8,'fuga'),(9,'sit');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20231019220240','2023-10-20 00:06:29',2),('DoctrineMigrations\\Version20231019220747','2023-10-20 00:07:52',411),('DoctrineMigrations\\Version20231020072121','2023-10-20 09:21:39',24);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-20  9:35:43