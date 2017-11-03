DROP TABLE IF EXISTS `Base_App`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Base_App` (
  `id` varchar(64) NOT NULL DEFAULT 'default',
  `roles` json DEFAULT NULL,
  `params` json DEFAULT NULL,
  `status` varchar(64) NOT NULL DEFAULT 'active',
  `updatedAt` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `Base_TenantApp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Base_TenantApp` (
  `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
  `tenantId` varchar(255) NOT NULL DEFAULT '',
  `appId` varchar(64) NOT NULL DEFAULT '',
  `apiKey` varchar(255) NOT NULL DEFAULT '',
  `apiSecretKey` varchar(255) NOT NULL DEFAULT '',
  `selectedPlan` varchar(64) DEFAULT NULL,
  `appParams` json DEFAULT NULL,
  `externalInfo` json DEFAULT NULL,
  `chargeInfo` json DEFAULT NULL,
  `exceededPlanUsage` boolean DEFAULT false,
  `exceededPlanAt` int(11) unsigned DEFAULT NULL,
  `planUpgradeRequired` boolean DEFAULT false,
  `firstInstallAt` int(11) unsigned DEFAULT NULL,
  `recentInstallAt` int(11) unsigned DEFAULT NULL,
  `recentUninstallAt` int(11) unsigned DEFAULT NULL,
  `trialExpiresAt` int(11) unsigned DEFAULT NULL,
  `status` varchar(64) NOT NULL DEFAULT 'disabled',
  `updatedAt` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenantId_appId` (`tenantId`, `appId`),
  UNIQUE KEY `apiKey` (`apiKey`),
  KEY `install_trial_uninstall_status` (`recentInstalledAt`, `trialExpiresAt`, `recentUninstalledAt`, `status`)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;