-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: localhost    Database: adrasteia
-- ------------------------------------------------------
-- Server version	9.4.0

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
-- Table structure for table `администраторы`
--

DROP TABLE IF EXISTS `администраторы`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `администраторы` (
  `id_администратора` int NOT NULL AUTO_INCREMENT,
  `Логин` varchar(100) NOT NULL,
  `Пароль` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Имя` varchar(100) DEFAULT NULL,
  `Фамилия` varchar(100) DEFAULT NULL,
  `Уровень_доступа` enum('админ','модератор') DEFAULT 'модератор',
  `Дата_создания` datetime DEFAULT CURRENT_TIMESTAMP,
  `Статус` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id_администратора`),
  UNIQUE KEY `Логин` (`Логин`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `администраторы`
--

LOCK TABLES `администраторы` WRITE;
/*!40000 ALTER TABLE `администраторы` DISABLE KEYS */;
INSERT INTO `администраторы` VALUES (1,'admin','$2y$12$07VZ1003bKwvv4RlWNoTwe04feLb/lanUuIExWmF7beP7lvC.9Io2','admin@adrasteia.ru','Администратор','Системный','модератор','2026-02-05 14:35:30','active'),(5,'admin3000','$2y$12$sXircaFlgrnPaExh4a9VWupm3yEyjIAEAIf3ZWS//gSWRBF.Zpw4W','admin3000@adrasteia.local','Админ3000','Главный','админ','2026-02-07 11:56:05','active');
/*!40000 ALTER TABLE `администраторы` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `договор`
--

DROP TABLE IF EXISTS `договор`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `договор` (
  `id_договора` int NOT NULL AUTO_INCREMENT,
  `id_услуги` int DEFAULT NULL,
  `описание` text,
  `сумма` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_договора`),
  KEY `id_услуги` (`id_услуги`),
  CONSTRAINT `договор_ibfk_1` FOREIGN KEY (`id_услуги`) REFERENCES `услуги` (`id_услуги`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `договор`
--

LOCK TABLES `договор` WRITE;
/*!40000 ALTER TABLE `договор` DISABLE KEYS */;
/*!40000 ALTER TABLE `договор` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `заказ`
--

DROP TABLE IF EXISTS `заказ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `заказ` (
  `id_заказа` int NOT NULL AUTO_INCREMENT,
  `Итоговая_сумма` decimal(10,2) NOT NULL,
  `Статус` varchar(50) DEFAULT 'новый',
  `Дата_заказа` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_клиента` int DEFAULT NULL,
  `Комментарий` text,
  `Адрес_исполнения` text,
  `Дата_исполнения` date DEFAULT NULL,
  PRIMARY KEY (`id_заказа`),
  KEY `id_клиента` (`id_клиента`),
  CONSTRAINT `заказ_ibfk_2` FOREIGN KEY (`id_клиента`) REFERENCES `клиент` (`id_клиента`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `заказ`
--

LOCK TABLES `заказ` WRITE;
/*!40000 ALTER TABLE `заказ` DISABLE KEYS */;
INSERT INTO `заказ` VALUES (1,53000.00,'выполнен','2026-02-07 00:10:01',1,NULL,NULL,'2026-02-07'),(2,71000.00,'выполнен','2026-02-07 00:10:30',1,NULL,NULL,'2026-02-20'),(3,63000.00,'выполнен','2026-02-07 00:24:52',1,NULL,NULL,'2026-02-14'),(4,89000.00,'в обработке','2026-02-10 21:25:28',1,NULL,NULL,NULL),(5,63499.99,'в обработке','2026-02-11 13:09:22',1,NULL,NULL,NULL),(6,20499.99,'в обработке','2026-02-11 13:10:10',1,NULL,NULL,NULL),(7,58000.00,'в обработке','2026-02-12 17:10:24',1,NULL,NULL,NULL),(8,120000.00,'в обработке','2026-02-13 16:11:50',1,NULL,NULL,NULL),(9,73000.00,'в обработке','2026-02-18 12:28:47',1,NULL,NULL,NULL),(10,15000.00,'в обработке','2026-02-24 21:17:12',1,NULL,NULL,NULL),(11,60000.00,'выполнен','2026-02-25 20:43:48',5,NULL,NULL,'2026-03-02'),(12,20000.00,'выполнен','2026-03-03 11:07:18',6,NULL,NULL,'2026-03-03'),(13,1800.00,'новый','2026-03-03 22:54:39',6,NULL,NULL,NULL),(14,1800.00,'новый','2026-03-04 10:10:40',6,NULL,NULL,NULL),(15,5800.00,'выполнен','2026-03-04 10:11:22',6,NULL,NULL,NULL);
/*!40000 ALTER TABLE `заказ` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `исполнитель`
--

DROP TABLE IF EXISTS `исполнитель`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `исполнитель` (
  `id_исполнителя` int NOT NULL AUTO_INCREMENT,
  `Фамилия` varchar(100) NOT NULL,
  `Имя` varchar(100) NOT NULL,
  `Отчество` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `Телефон` varchar(20) DEFAULT NULL,
  `Адрес` text,
  `Специализация` varchar(200) DEFAULT NULL,
  `Статус` enum('active','inactive') DEFAULT 'active',
  `Фото` varchar(500) DEFAULT NULL,
  `Дата_добавления` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_исполнителя`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `исполнитель`
--

LOCK TABLES `исполнитель` WRITE;
/*!40000 ALTER TABLE `исполнитель` DISABLE KEYS */;
INSERT INTO `исполнитель` VALUES (1,'Петров','Алексей','Иванович','petrov@adrasteia.ru','+375 (79) 123-45-67',NULL,'Наблюдение и слежка','active','https://images.unsplash.com/photo-1472099645785-5658abf4ff4e','2026-02-06 10:28:04'),(2,'Смирнова','Ольга','Владимировна','smirnova@adrasteia.ru','+375 (79) 123-45-67',NULL,'Кибер-расследования','active','https://images.unsplash.com/photo-1494790108755-2616b612b786','2026-02-06 10:28:04'),(3,'Козлов','Дмитрий','Сергеевич','kozlov@adrasteia.ru','+375 (79) 123-45-67',NULL,'Семейные дела','active','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d','2026-02-06 10:28:04'),(4,'Волкова','Екатерина','Александровна','volkova@adrasteia.ru','+375 (79) 123-45-67',NULL,'Проверка персонала','active','https://images.unsplash.com/photo-1487412720507-e7ab37603c6f','2026-02-06 10:28:04');
/*!40000 ALTER TABLE `исполнитель` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `клиент`
--

DROP TABLE IF EXISTS `клиент`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `клиент` (
  `id_клиента` int NOT NULL AUTO_INCREMENT,
  `Фамилия` varchar(100) NOT NULL,
  `Имя` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Телефон` varchar(20) DEFAULT NULL,
  `Адрес` text,
  `Пароль` varchar(255) NOT NULL,
  `Дата_регистрации` datetime DEFAULT CURRENT_TIMESTAMP,
  `Статус` enum('active','blocked') DEFAULT 'active',
  PRIMARY KEY (`id_клиента`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `клиент`
--

LOCK TABLES `клиент` WRITE;
/*!40000 ALTER TABLE `клиент` DISABLE KEYS */;
INSERT INTO `клиент` VALUES (1,'Кот','Ангелина','angelina.kot495@gmail.com','+375(33)372-19-23','Гродно, улица Новооктябрьская','$2y$12$DdbpnXXyiD.QD6.1dGhExeb6acKqxYzJMbl0vvpngJgIT9Ym1yp.W','2026-02-06 16:30:18','active'),(2,'Кот','Ангелина','gelya@mail.ru','+375(33)369-25-87',NULL,'$2y$12$KkspUMIUBe6sOz8XF8/7vuYQWVhU3k0xdK2qT6qgWPuUmRbPSZUlu','2026-02-06 16:32:37','blocked'),(3,'Крагель','Даша','dasha@mail.ru','+375(33)322-21-11',NULL,'$2y$12$SIEbeiFn4IsUm/k/BXMBbuzNWYh0BnV5HYgqmoDtiFM2EAZIsQQuy','2026-02-06 21:37:52','blocked'),(4,'Шандроха','Полина','polya@mail.ru','+375(33)322-22-22',NULL,'$2y$12$Kinz0aEZSGzP6iETv3paM.YtPPgM34hnfkFRAZ4Q6mT7OpbNLzQvm','2026-02-06 22:08:39','active'),(5,'Домась','Екатерина','katekorbut4@gmail.com','+375 (33) 333-33-33','г. Барановичи','$2y$12$cVWPvIFAIznFm4JFk0EYqeLkYtJhaQCvrX/YlpUSdiBCsRNNfdJbC','2026-02-25 20:24:36','active'),(6,'Крагель','Дарья','dasha12300227@gmail.com','+375 (44) 444-44-44','г. Минск','$2y$12$sv8obTQpCF0lIWPgjKEyJesInfOzmsNFNg9QtszYLH.rSM6/qG7Wq','2026-03-03 11:06:45','blocked');
/*!40000 ALTER TABLE `клиент` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `отзывы`
--

DROP TABLE IF EXISTS `отзывы`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `отзывы` (
  `id_отзыва` int NOT NULL AUTO_INCREMENT,
  `id_клиента` int NOT NULL,
  `id_заказа` int NOT NULL,
  `Текст` text,
  `Оценка` int DEFAULT NULL,
  `Дата_создания` datetime DEFAULT CURRENT_TIMESTAMP,
  `Статус` enum('одобрено','в обработке','отклонено') DEFAULT 'в обработке',
  PRIMARY KEY (`id_отзыва`),
  KEY `id_клиента` (`id_клиента`),
  KEY `id_заказа` (`id_заказа`),
  CONSTRAINT `отзывы_ibfk_1` FOREIGN KEY (`id_клиента`) REFERENCES `клиент` (`id_клиента`),
  CONSTRAINT `отзывы_ibfk_2` FOREIGN KEY (`id_заказа`) REFERENCES `заказ` (`id_заказа`),
  CONSTRAINT `отзывы_chk_1` CHECK ((`Оценка` between 1 and 5))
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `отзывы`
--

LOCK TABLES `отзывы` WRITE;
/*!40000 ALTER TABLE `отзывы` DISABLE KEYS */;
INSERT INTO `отзывы` VALUES (1,1,1,'фыфывфы',5,'2026-03-02 21:51:43','отклонено'),(2,1,2,'Всё на высшем уровне',5,'2026-03-02 22:05:18','одобрено'),(3,5,11,'Специалисты выполнили всё как нужно и учли мои пожелания. ставлю 5 звёзд',5,'2026-03-02 22:06:43','одобрено'),(4,1,3,'Выполнили в срок, в целом свою задачу выполнили',4,'2026-03-02 22:09:56','одобрено'),(5,6,12,'Всё было супер',5,'2026-03-04 10:12:10','одобрено');
/*!40000 ALTER TABLE `отзывы` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `позиции_заказа`
--

DROP TABLE IF EXISTS `позиции_заказа`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `позиции_заказа` (
  `id_позиции` int NOT NULL AUTO_INCREMENT,
  `id_заказа` int NOT NULL,
  `id_услуги` int DEFAULT NULL,
  `Название_услуги` varchar(200) NOT NULL,
  `Количество` int NOT NULL DEFAULT '1',
  `Цена_единицы` decimal(10,2) NOT NULL,
  `Сумма` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_позиции`),
  KEY `idx_order` (`id_заказа`),
  KEY `idx_service` (`id_услуги`),
  CONSTRAINT `позиции_заказа_ibfk_1` FOREIGN KEY (`id_заказа`) REFERENCES `заказ` (`id_заказа`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `позиции_заказа_ibfk_2` FOREIGN KEY (`id_услуги`) REFERENCES `услуги` (`id_услуги`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `позиции_заказа`
--

LOCK TABLES `позиции_заказа` WRITE;
/*!40000 ALTER TABLE `позиции_заказа` DISABLE KEYS */;
INSERT INTO `позиции_заказа` VALUES (1,1,7,'Защита от шпионажа',1,28000.00,28000.00),(2,1,1,'Наблюдение и слежка',1,25000.00,25000.00),(4,2,8,'Детектор лжи',1,15000.00,15000.00),(5,2,7,'Защита от шпионажа',2,28000.00,56000.00),(6,3,3,'Кибер-расследования',1,35000.00,35000.00),(7,3,7,'Защита от шпионажа',1,28000.00,28000.00),(8,4,5,'Бизнес-разведка',1,45000.00,45000.00),(9,4,4,'Семейные дела',2,22000.00,44000.00),(10,5,NULL,'что-то где-то как-то',1,20499.99,20499.99),(11,5,8,'Детектор лжи',1,15000.00,15000.00),(12,5,7,'Защита от шпионажа',1,28000.00,28000.00),(13,6,NULL,'что-то где-то как-то',3,20499.99,20499.99),(14,7,7,'Защита от шпионажа',1,28000.00,28000.00),(15,7,6,'Поиск пропавших лиц',1,30000.00,30000.00),(16,8,6,'Поиск пропавших лиц',2,30000.00,30000.00),(17,8,5,'Бизнес-разведка',2,45000.00,90000.00),(18,9,6,'Поиск пропавших лиц',1,30000.00,30000.00),(19,9,8,'Детектор лжи',1,15000.00,15000.00),(20,9,7,'Защита от шпионажа',1,28000.00,28000.00),(21,10,8,'Детектор лжи',1,15000.00,15000.00),(22,11,8,'Детектор лжи',1,15000.00,15000.00),(23,11,5,'Бизнес-разведка',1,45000.00,45000.00),(24,12,10,'Проверка окружения',1,20000.00,20000.00),(25,13,2,'Проверка персонала',1,1800.00,1800.00),(26,14,2,'Проверка персонала',1,1800.00,1800.00),(27,15,6,'Поиск пропавших лиц',1,3000.00,3000.00),(28,15,7,'Защита от шпионажа',1,2800.00,2800.00);
/*!40000 ALTER TABLE `позиции_заказа` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `услуги`
--

DROP TABLE IF EXISTS `услуги`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `услуги` (
  `id_услуги` int NOT NULL AUTO_INCREMENT,
  `Название` varchar(200) NOT NULL,
  `Описание` text,
  `Цена` decimal(10,2) NOT NULL,
  `Фото_услуги` varchar(500) DEFAULT NULL,
  `id_исполнителя` int DEFAULT NULL,
  `Категория` varchar(100) DEFAULT NULL,
  `Статус` enum('active','inactive') DEFAULT 'active',
  `Дата_добавления` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_услуги`),
  KEY `id_исполнителя` (`id_исполнителя`),
  CONSTRAINT `услуги_ibfk_1` FOREIGN KEY (`id_исполнителя`) REFERENCES `исполнитель` (`id_исполнителя`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `услуги`
--

LOCK TABLES `услуги` WRITE;
/*!40000 ALTER TABLE `услуги` DISABLE KEYS */;
INSERT INTO `услуги` VALUES (1,'Наблюдение и слежка','Дискретное наблюдение за объектами, фиксация действий и перемещений. Используем современное оборудование для скрытого наблюдения.',2500.00,'https://images.unsplash.com/photo-1558618666-fcd25c85cd64',1,'surveillance','active','2026-02-06 10:28:04'),(2,'Проверка персонала','Комплексная проверка биографии, репутации и благонадежности сотрудников и деловых партнеров, консультационные вопросы.',1800.00,'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0',4,'check','active','2026-02-06 10:28:04'),(3,'Кибер-расследования','Расследование киберпреступлений, поиск цифровых следов, восстановление удаленной информации, консультации.',3500.00,'https://images.unsplash.com/photo-1558494949-ef010cbdcc31',2,'cyber','active','2026-02-06 10:28:04'),(4,'Семейные дела','Установление фактов супружеской неверности, поиск пропавших родственников, дела о наследстве, поиск биологических родителей.',2200.00,'https://images.unsplash.com/photo-1589829545856-d10d557cf95f',3,'family','active','2026-02-06 10:28:04'),(5,'Бизнес-разведка','Сбор информации о конкурентах, анализ рынка, проверка деловых партнеров и инвестиционных проектов.',4500.00,'https://images.unsplash.com/photo-1553877522-43269d4ea984',1,'check','active','2026-02-06 10:28:04'),(6,'Поиск пропавших лиц','Профессиональный поиск пропавших без вести людей с использованием современных методов и технологий.',3000.00,'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0',4,'family','active','2026-02-06 10:28:04'),(7,'Защита от шпионажа','Обнаружение и нейтрализация устройств прослушки, проверка помещений на наличие скрытых камер.',2800.00,'https://images.unsplash.com/photo-1516035069371-29a1b244cc32',2,'surveillance','active','2026-02-06 10:28:04'),(8,'Детектор лжи','Проведение полиграфных проверок для установления достоверности информации в различных ситуациях.',1500.00,'https://images.unsplash.com/photo-1581094794329-c8112a89af12',3,'check','active','2026-02-06 10:28:04'),(10,'Проверка окружения','Расследование киберпреступлений, поиск цифровых следов, восстановление удаленной информации ну и что-то где-то как-то.',2000.00,'https://images.unsplash.com/photo-1581094794329-c8112a89af12',1,'check','active','2026-02-19 14:17:19');
/*!40000 ALTER TABLE `услуги` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'adrasteia'
--

--
-- Dumping routines for database 'adrasteia'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-16 17:49:44
