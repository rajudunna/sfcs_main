/*Table structure for table `flyway_schema` */

DROP TABLE IF EXISTS pms.`flyway_schema`;

CREATE TABLE pms.`flyway_schema` (
  `version_rank` int(11) NOT NULL,
  `installed_rank` int(11) NOT NULL,
  `version` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `type` varchar(20) NOT NULL,
  `script` varchar(1000) NOT NULL,
  `info` varchar(1000) NOT NULL,
  `success` tinyint(1) NOT NULL,
  `log_time` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`version`),
  KEY `schema_version_vr_idx` (`version_rank`),
  KEY `schema_version_ir_idx` (`installed_rank`),
  KEY `schema_version_s_idx` (`success`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
