/*Table structure for table `log_rm_ready_in_pool` */

DROP TABLE IF EXISTS pps.`log_rm_ready_in_pool`;

CREATE TABLE pps.`log_rm_ready_in_pool` (
  `d_id` double DEFAULT NULL,
  `doc_no` varchar(36) DEFAULT NULL,
  `date_n_time` datetime DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `pps`.`log_rm_ready_in_pool` CHANGE `d_id` `d_id` INT(50) NOT NULL AUTO_INCREMENT, ADD KEY(`d_id`); 
