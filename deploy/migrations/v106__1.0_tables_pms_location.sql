/*Table structure for table `locations` */

DROP TABLE IF EXISTS `locations`;

CREATE TABLE pms.`locations` (
  `loc_id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_name` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `filled_qty` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `catagory` varchar(255) DEFAULT NULL,
  `plant_code` varchar(50) DEFAULT NULL,
  `created_user` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_user` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`loc_id`),
  UNIQUE KEY `location` (`loc_name`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;



/*Table structure for table `packing_method_master` */

DROP TABLE IF EXISTS `packing_method_master`;

CREATE TABLE mdm.`packing_method_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `packing_method_code` varchar(20) DEFAULT NULL,
  `packing_description` varchar(200) DEFAULT NULL,
  `smv` float DEFAULT NULL,
  `status` enum('Active','In-Active') DEFAULT 'Active',
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;