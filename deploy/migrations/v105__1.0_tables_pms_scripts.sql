DROP TABLE IF EXISTS pms.`packing_team_master`;

CREATE TABLE pms.`packing_team_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `packing_team` varchar(20) DEFAULT NULL,
  `team_leader` varchar(20) DEFAULT NULL,
  `status` enum('Active','In-Active') DEFAULT 'Active',
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS pms.`tbl_fg_crt_handover_team_list`;

CREATE TABLE pms.`tbl_fg_crt_handover_team_list` (
  `emp_id` varchar(50) DEFAULT NULL COMMENT 'emp_id',
  `team_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
  `emp_call_name` varchar(200) DEFAULT NULL COMMENT 'call name',
  `selected_user` varchar(200) DEFAULT NULL COMMENT 'current scanning user',
  `emp_status` int(11) DEFAULT NULL COMMENT '0-active, 1-inactive',
  `lastup` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_leader_name` */

DROP TABLE IF EXISTS pms.`tbl_leader_name`;

CREATE TABLE pms.`tbl_leader_name` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(30) NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  `plant_code` varchar(50) DEFAULT NULL,
  `created_user` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_user` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;