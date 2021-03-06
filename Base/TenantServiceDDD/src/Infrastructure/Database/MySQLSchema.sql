DROP TABLE IF EXISTS `Base_Tenant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Base_Tenant` (
  `id` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `isRootMember` boolean NOT NULL DEFAULT false,
  `status` varchar(64) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `domain` (`domain`),
  KEY `createdAt` (`createdAt`),
  KEY `domain_status` (`domain`, `status`)
) ENGINE=InnoDB CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;