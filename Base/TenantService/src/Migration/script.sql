DROP TABLE IF EXISTS `Base_Tenant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Base_Tenant` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL,
  `platform` varchar(64) DEFAULT NULL,
  `status` varchar(64) NOT NULL DEFAULT 'disabled',
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `domain` (`domain`),
  KEY `createdAt` (`createdAt`),
  KEY `domain_platform_status` (`domain`, `platform`, `status`)
) ENGINE=InnoDB CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;