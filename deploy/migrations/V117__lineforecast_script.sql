/*Table structure for table `line_forecast` */

DROP TABLE IF EXISTS pps.`line_forecast`;

CREATE TABLE pps.`line_forecast` (
  `forcast_id` varchar(55) NOT NULL,
  `module` varchar(45) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`forcast_id`),
  KEY `ind_date_module` (`module`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `wms`.`manual_form` CHANGE `buyer` `buyer` VARCHAR(100) CHARSET latin1 COLLATE latin1_swedish_ci NULL; 
ALTER TABLE `wms`.`manual_form` CHANGE `app_by` `app_by` VARCHAR(30) CHARSET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE `wms`.`manual_form` CHANGE `app_date` `app_date` DATETIME NULL, CHANGE `issue_closed` `issue_closed` DATETIME NULL; 
ALTER TABLE `wms`.`manual_form` CHANGE `comm_status` `comm_status` INT(11) NULL;
ALTER TABLE `wms`.`manual_form` CHANGE `remarks` `remarks` VARCHAR(100) CHARSET latin1 COLLATE latin1_swedish_ci NULL;