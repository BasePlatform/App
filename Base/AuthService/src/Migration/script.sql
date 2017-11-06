DROP TABLE IF EXISTS `Base_User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Base_User` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tenantId` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `displayName` varchar(128) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `_deleted` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenantId_username` (`tenantId`,`username`),
  UNIQUE KEY `tenantId_unique` (`tenantId`,`email`),
  KEY `_deleted` (`_deleted`)
) ENGINE=InnoDB CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

ALTER TABLE `Base_User` AUTO_INCREMENT=1010;

DROP TABLE IF EXISTS `Base_UserProfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Base_UserProfile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tenantId` varchar(255) NOT NULL DEFAULT '',
  `userId` bigint(20) unsigned NOT NULL,
  `zone` varchar(64) NOT NULL DEFAULT 'default',
  `gender` varchar(64) DEFAULT NULL,
  `firstName` varchar(128) DEFAULT NULL,
  `lastName` varchar(128) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `links` text,
  `bio` text,
  `registeredAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenantId_userId_zone` (`tenantId`,`userId`, `zone`),
  KEY `registeredAt` (`registeredAt`)
) ENGINE=InnoDB CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Base_UserIdentity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Base_UserIdentity` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tenantId` varchar(255) NOT NULL DEFAULT '',
  `userId` bigint(20) unsigned NOT NULL,
  `zone` varchar(64) NOT NULL DEFAULT 'default',
  `authProvider` varchar(255) DEFAULT 'app',
  `authProviderUid` varchar(255) DEFAULT NULL,
  `passwordHash` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `authKey` varchar(255) DEFAULT NULL,
  `accountActivateToken` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `accountActivateStatus` varchar(64) DEFAULT NULL,
  `accountActivateExpiresAt` datetime DEFAULT NULL,
  `passwordResetToken` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `passwordResetStatus` varchar(64) DEFAULT NULL,
  `passwordResetExpiresAt` datetime DEFAULT NULL,
  `recentPasswordChangeAt` datetime NOT NULL,
  `status` varchar(64) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenantId_userId_zone` (`tenantId`,`userId`,`zone`),
  KEY `authProvider_authProviderUid` (`authProvider`,`authProviderUid`),
  KEY `status` (`status`)
) ENGINE=InnoDB CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;