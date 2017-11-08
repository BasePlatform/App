DROP TABLE IF EXISTS `Base_App`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Base_App` (
  `id` varchar(64) NOT NULL DEFAULT 'default',
  `plans` json DEFAULT NULL,
  `params` json DEFAULT NULL,
  `status` varchar(64) NOT NULL DEFAULT 'active',
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `Base_AppUsage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Base_AppUsage` (
  `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
  `tenantId` varchar(255) NOT NULL,
  `appId` varchar(64) NOT NULL DEFAULT '',
  `selectedPlan` varchar(64) DEFAULT NULL,
  `appParams` json DEFAULT NULL,
  `externalInfo` json DEFAULT NULL,
  `chargeInfo` json DEFAULT NULL,
  `exceededPlanUsage` boolean DEFAULT false,
  `exceededPlanAt` datetime DEFAULT NULL,
  `planUpgradeRequired` boolean DEFAULT false,
  `firstInstallAt` datetime DEFAULT NULL,
  `recentInstallAt` datetime DEFAULT NULL,
  `recentUninstallAt` datetime DEFAULT NULL,
  `trialExpiresAt` datetime DEFAULT NULL,
  `status` varchar(64) NOT NULL DEFAULT 'disabled',
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenantId_appId` (`tenantId`, `appId`),
  KEY `install_trial_uninstall_status` (`recentInstallAt`, `trialExpiresAt`, `recentUninstallAt`, `status`)
) ENGINE=InnoDB CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;