DROP TABLE IF EXISTS `Base_User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Base_User` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tenantId` varchar(255) NOT NULL,
  `zone` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `userName` varchar(128) NOT NULL,
  `displayName` varchar(128) DEFAULT NULL,
  `tagLine` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` varchar(64) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  `deletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenantId_email_zone` (`tenantId`,`email`, `zone`),
  UNIQUE KEY `tenantId_userName_zone` (`tenantId`,`userName`, `zone`),
  KEY `email_status` (`email`, `status`)
) ENGINE=InnoDB CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

ALTER TABLE `Base_User` AUTO_INCREMENT=1010;

DROP TABLE IF EXISTS `Base_UserProfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Base_UserProfile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tenantId` varchar(255) NOT NULL,
  `userId` bigint(20) unsigned NOT NULL,
  `gender` varchar(64) DEFAULT NULL,
  `birthDate` date DEFAULT NULL,
  `firstName` varchar(128) DEFAULT NULL,
  `lastName` varchar(128) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `info` json DEFAULT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenantId_userId` (`tenantId`,`userId`)
) ENGINE=InnoDB CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Base_UserIdentity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Base_UserIdentity` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tenantId` varchar(255) NOT NULL,
  `userId` bigint(20) unsigned NOT NULL,
  `authProvider` varchar(255) NOT NULL,
  `authProviderUid` varchar(255) DEFAULT NULL,
  `authToken` varchar(128) NOT NULL,
  `passwordHash` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `authParams` json DEFAULT NULL,
  `recentPasswordUpdateAt` datetime DEFAULT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenantId_userId` (`tenantId`,`userId`),
  KEY `authProvider_authProviderUid` (`authProvider`,`authProviderUid`),
  KEY `authToken` (`authToken`)
) ENGINE=InnoDB CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Base_Policy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Base_Policy` (
  `id` varchar(255) NOT NULL,
  `appId` varchar(64) NOT NULL,
  `type` varchar(255) NOT NULL,
  `zone` varchar(64) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `params` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_zone_appId` (`type`, `zone`,`appId`)
) ENGINE=InnoDB CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Base_ResourcePolicyAttachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Base_ResourcePolicyAttachment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tenantId` varchar(255) NOT NULL,
  `resourceId` varchar(255) NOT NULL, /* resourceType:id, e.g: user:23231 */
  `policyId` varchar(255) NOT NULL,
  `attachedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenantId_resourceId_policyId` (`tenantId`,`resourceId`,`policyId`)
) ENGINE=InnoDB CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;