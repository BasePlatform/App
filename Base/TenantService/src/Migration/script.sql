DROP TABLE IF EXISTS `BaseTenant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BaseTenant` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '',
  `platform` varchar(64) DEFAULT NULL,
  `status` varchar(64) NOT NULL DEFAULT 'disabled',
  `createdAt` int(11) unsigned DEFAULT NULL,
  `updatedAt` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `domain` (`domain`),
  KEY `createdAt` (`createdAt`),
  KEY `domain_platform_status` (`domain`, `platform`, `status`)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;