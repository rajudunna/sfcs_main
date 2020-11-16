/*Table structure for table `tbl_leader_name` */

DROP TABLE IF EXISTS mdm.`tbl_leader_name`;

CREATE TABLE mdm.`tbl_leader_name` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(30) NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  `plant_code` varchar(50) DEFAULT NULL,
  `created_user` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_user` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_sewing_job_prefix` */

DROP TABLE IF EXISTS mdm.`tbl_sewing_job_prefix`;

CREATE TABLE mdm.`tbl_sewing_job_prefix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prefix_name` varchar(765) DEFAULT NULL,
  `prefix` varchar(765) DEFAULT NULL,
  `type_of_sewing` int(11) DEFAULT NULL,
  `bg_color` varchar(765) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `hcm_module_mapping` */

DROP TABLE IF EXISTS pms.`hcm_module_mapping`;

CREATE TABLE pms.`hcm_module_mapping` (
  `sfcs_module` varchar(50) NOT NULL,
  `hcm_code` tinytext NOT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `hcm_shift_mapping` */

DROP TABLE IF EXISTS pms.`hcm_shift_mapping`;

CREATE TABLE pms.`hcm_shift_mapping` (
  `sfcs_shift` varchar(50) NOT NULL,
  `hcm_code` tinytext NOT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `inspection_supplier_db` */

DROP TABLE IF EXISTS pms.`inspection_supplier_db`;

CREATE TABLE pms.`inspection_supplier_db` (
  `product_code` varchar(90) NOT NULL COMMENT 'Product Code Name',
  `supplier_code` varchar(90) NOT NULL COMMENT 'Supplier Name',
  `complaint_no` double NOT NULL COMMENT 'Comaplint Number',
  `supplier_m3_code` varchar(900) NOT NULL COMMENT 'Supplier M3 Code',
  `color_code` varchar(10) NOT NULL COMMENT 'Color Code',
  `seq_no` int(11) NOT NULL COMMENT 'Sequence Number',
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `NewIndex1` (`supplier_code`,`supplier_m3_code`),
  KEY `unique` (`product_code`,`supplier_code`,`supplier_m3_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pro_atten` */

DROP TABLE IF EXISTS pms.`pro_atten`;

CREATE TABLE pms.`pro_atten` (
  `atten_id` varchar(20) NOT NULL DEFAULT '',
  `date` date NOT NULL,
  `avail_A` tinyint(2) unsigned NOT NULL,
  `avail_B` tinyint(2) unsigned NOT NULL,
  `avail_C` tinyint(2) unsigned NOT NULL,
  `avail_G` tinyint(2) unsigned NOT NULL,
  `jumpers` tinyint(2) unsigned NOT NULL,
  `absent_A` tinyint(2) unsigned NOT NULL,
  `absent_B` tinyint(2) unsigned NOT NULL,
  `absent_C` tinyint(2) unsigned NOT NULL,
  `absent_G` tinyint(2) unsigned NOT NULL,
  `module` varchar(10) NOT NULL,
  `remarks` char(0) NOT NULL,
  `plant_code` varchar(50) DEFAULT NULL,
  `created_user` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`atten_id`),
  UNIQUE KEY `date_module` (`date`,`module`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pro_atten_hours` */

DROP TABLE IF EXISTS pms.`pro_atten_hours`;

CREATE TABLE pms.`pro_atten_hours` (
  `date` date NOT NULL,
  `shift` varchar(40) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `plant_code` varchar(50) DEFAULT NULL,
  `created_user` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pro_attendance` */

DROP TABLE IF EXISTS pms.`pro_attendance`;

CREATE TABLE pms.`pro_attendance` (
  `date` date NOT NULL,
  `module` varchar(40) NOT NULL,
  `shift` varchar(13) NOT NULL,
  `present` int(10) unsigned NOT NULL,
  `absent` int(10) unsigned NOT NULL,
  `jumper` int(10) unsigned NOT NULL DEFAULT '0',
  `plant_code` varchar(50) DEFAULT NULL,
  `created_user` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `attendance` (`date`,`module`,`shift`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pro_attendance_adjustment` */

DROP TABLE IF EXISTS pms.`pro_attendance_adjustment`;

CREATE TABLE pms.`pro_attendance_adjustment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `module` varchar(40) DEFAULT NULL,
  `shift` varchar(40) DEFAULT NULL,
  `smo` int(10) DEFAULT NULL,
  `adjustment_type` enum('Positive','Negative') NOT NULL DEFAULT 'Positive',
  `smo_minutes` int(10) DEFAULT NULL,
  `smo_adjustment_min` int(10) DEFAULT NULL,
  `smo_adjustment_hours` varchar(50) DEFAULT NULL,
  `last_up` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `plant_code` varchar(50) DEFAULT NULL,
  `created_user` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `parent_id` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `week_delivery_plan` */

DROP TABLE IF EXISTS pms.`week_delivery_plan`;

CREATE TABLE pms.`week_delivery_plan` (
  `shipment_plan_id` int(11) NOT NULL,
  `fastreact_plan_id` int(11) NOT NULL,
  `size_code` varchar(50) DEFAULT NULL,
  `plan_start_date` date NOT NULL,
  `plan_comp_date` date NOT NULL,
  `tid` mediumint(9) NOT NULL DEFAULT '0',
  `remarks` text NOT NULL COMMENT 'Planner Remarks^Packing Remarks^Commitments (ABC)',
  `ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `rev_exfactory` date NOT NULL DEFAULT '0000-00-00',
  `act_cut` mediumint(9) NOT NULL,
  `act_in` mediumint(9) NOT NULL,
  `act_fca` mediumint(9) NOT NULL,
  `act_mca` mediumint(9) NOT NULL,
  `act_fg` mediumint(9) NOT NULL,
  `cart_pending` mediumint(9) NOT NULL,
  `priority` mediumint(9) NOT NULL,
  `original_order_qty` mediumint(9) NOT NULL,
  `rev_mode` varchar(30) NOT NULL,
  `act_ship` mediumint(9) NOT NULL,
  `act_exfact` date NOT NULL,
  `act_rej` int(11) NOT NULL COMMENT 'actual rejections',
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`ref_id`),
  KEY `shipment_plan_id` (`shipment_plan_id`,`fastreact_plan_id`,`tid`,`ref_id`),
  KEY `new` (`shipment_plan_id`,`fastreact_plan_id`,`rev_exfactory`),
  KEY `NewIndex1` (`shipment_plan_id`,`fastreact_plan_id`,`size_code`),
  KEY `act_ex` (`act_exfact`),
  KEY `ship` (`rev_exfactory`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `binding_consumption` */

DROP TABLE IF EXISTS pps.`binding_consumption`;

CREATE TABLE pps.`binding_consumption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `style` varchar(100) DEFAULT NULL,
  `schedule` varchar(100) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `tot_req_qty` decimal(10,2) DEFAULT NULL,
  `tot_bindreq_qty` decimal(10,2) DEFAULT NULL,
  `status` enum('Open','Allocated','Close') DEFAULT NULL,
  `status_at` datetime DEFAULT NULL,
  `po_number` varchar(36) NOT NULL,
  `plant_code` varchar(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `binding_consumption_items` */

DROP TABLE IF EXISTS pps.`binding_consumption_items`;

CREATE TABLE pps.`binding_consumption_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `compo_no` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `cutno` varchar(100) DEFAULT NULL,
  `req_qty` decimal(10,2) DEFAULT NULL,
  `bind_category` varchar(100) DEFAULT NULL,
  `bind_req_qty` decimal(10,2) DEFAULT NULL,
  `doc_no` int(50) DEFAULT NULL,
  `plant_code` varchar(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `binding_consumption_items_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `binding_consumption` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `downtime_reason` */

DROP TABLE IF EXISTS pps.`downtime_reason`;

CREATE TABLE pps.`downtime_reason` (
  `id` int(11) DEFAULT NULL,
  `code` varchar(135) DEFAULT NULL,
  `rdept` varchar(195) DEFAULT NULL,
  `reason` text,
  `plant_code` varchar(450) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(360) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(360) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `gatepass_table` */

DROP TABLE IF EXISTS pps.`gatepass_table`;

CREATE TABLE pps.`gatepass_table` (
  `id` int(23) NOT NULL AUTO_INCREMENT,
  `shift` varchar(33) DEFAULT NULL,
  `operation` varchar(675) DEFAULT NULL,
  `vehicle_no` varchar(675) DEFAULT NULL,
  `gatepass_status` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `username` varchar(75) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `gatepass_track` */

DROP TABLE IF EXISTS pps.`gatepass_track`;

CREATE TABLE pps.`gatepass_track` (
  `id` int(23) NOT NULL AUTO_INCREMENT,
  `gate_id` int(23) DEFAULT NULL,
  `bundle_no` varchar(50) DEFAULT NULL,
  `bundle_qty` int(10) DEFAULT NULL,
  `style` varchar(675) DEFAULT NULL,
  `schedule` varchar(675) DEFAULT NULL,
  `color` varchar(675) DEFAULT NULL,
  `size` varchar(33) DEFAULT NULL,
  `operation_id` varchar(33) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `shipment_plan` */

DROP TABLE IF EXISTS pps.`shipment_plan`;

CREATE TABLE pps.`shipment_plan` (
  `order_no` varchar(10) NOT NULL DEFAULT '0',
  `delivery_no` varchar(10) NOT NULL DEFAULT '0',
  `del_status` varchar(2) NOT NULL DEFAULT '0',
  `mpo` varchar(30) NOT NULL DEFAULT '0',
  `cpo` varchar(30) NOT NULL DEFAULT '0',
  `buyer` varchar(36) NOT NULL DEFAULT '0',
  `product` varchar(40) NOT NULL DEFAULT '0',
  `buyer_division` varchar(40) NOT NULL DEFAULT '0',
  `style` varchar(15) NOT NULL DEFAULT '0',
  `schedule_no` varchar(15) NOT NULL DEFAULT '0',
  `color` varchar(50) NOT NULL DEFAULT '0',
  `size` varchar(15) NOT NULL DEFAULT '0',
  `z_feature` varchar(15) NOT NULL DEFAULT '0',
  `ord_qty` bigint(20) NOT NULL DEFAULT '0',
  `ex_factory_date` date NOT NULL DEFAULT '0000-00-00',
  `mode` varchar(5) NOT NULL DEFAULT '0',
  `destination` varchar(10) NOT NULL DEFAULT '0',
  `packing_method` varchar(6) NOT NULL DEFAULT '0',
  `fob_price_per_piece` float NOT NULL,
  `cm_value` float NOT NULL,
  `ssc_code` varchar(150) NOT NULL DEFAULT '0',
  `ship_tid` bigint(50) NOT NULL AUTO_INCREMENT,
  `week_code` tinyint(11) NOT NULL DEFAULT '0',
  `status` tinyint(11) NOT NULL DEFAULT '0',
  `ssc_code_new` varchar(200) NOT NULL DEFAULT '0',
  `ssc_code_week_plan` varchar(250) DEFAULT '0',
  `cw_check` smallint(6) NOT NULL DEFAULT '0',
  `plant_code` varchar(150) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(120) DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT '0',
  `version_flag` int(11) DEFAULT '1',
  PRIMARY KEY (`ship_tid`),
  UNIQUE KEY `ssc_code_week_plan` (`ssc_code_week_plan`),
  KEY `NewIndex1` (`buyer_division`,`style`,`schedule_no`,`color`,`size`),
  KEY `NewIndex2` (`buyer_division`),
  KEY `NewIndex3` (`style`,`schedule_no`,`color`),
  KEY `NewIndex4` (`ssc_code`,`ship_tid`),
  KEY `NewIndex5` (`schedule_no`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Table structure for table `week_delivery_plan` */

DROP TABLE IF EXISTS pps.`week_delivery_plan`;

CREATE TABLE pps.`week_delivery_plan` (
  `shipment_plan_id` int(11) NOT NULL DEFAULT '0',
  `fastreact_plan_id` int(11) NOT NULL DEFAULT '0',
  `size_code` varchar(50) DEFAULT '0',
  `plan_start_date` date NOT NULL DEFAULT '0000-00-00',
  `plan_comp_date` date NOT NULL DEFAULT '0000-00-00',
  `tid` mediumint(9) NOT NULL DEFAULT '0',
  `remarks` text NOT NULL COMMENT 'Planner Remarks^Packing Remarks^Commitments (ABC)',
  `ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `rev_exfactory` date NOT NULL DEFAULT '0000-00-00',
  `act_cut` mediumint(9) NOT NULL DEFAULT '0',
  `act_in` mediumint(9) NOT NULL DEFAULT '0',
  `act_fca` mediumint(9) NOT NULL DEFAULT '0',
  `act_mca` mediumint(9) NOT NULL DEFAULT '0',
  `act_fg` mediumint(9) NOT NULL DEFAULT '0',
  `cart_pending` mediumint(9) NOT NULL DEFAULT '0',
  `priority` mediumint(9) NOT NULL DEFAULT '0',
  `original_order_qty` mediumint(9) NOT NULL DEFAULT '0',
  `rev_mode` varchar(30) NOT NULL DEFAULT '0',
  `act_ship` mediumint(9) NOT NULL DEFAULT '0',
  `act_exfact` date NOT NULL DEFAULT '0000-00-00',
  `act_rej` int(11) NOT NULL DEFAULT '0' COMMENT 'actual rejections',
  `plant_code` varchar(150) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(120) DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT '0',
  `version_flag` int(11) DEFAULT '1',
  PRIMARY KEY (`ref_id`),
  KEY `shipment_plan_id` (`shipment_plan_id`,`fastreact_plan_id`,`tid`,`ref_id`),
  KEY `new` (`shipment_plan_id`,`fastreact_plan_id`,`rev_exfactory`),
  KEY `NewIndex1` (`shipment_plan_id`,`fastreact_plan_id`,`size_code`),
  KEY `act_ex` (`act_exfact`),
  KEY `ship` (`rev_exfactory`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Table structure for table `weekly_delivery_plan_remarks` */

DROP TABLE IF EXISTS pps.`weekly_delivery_plan_remarks`;

CREATE TABLE pps.`weekly_delivery_plan_remarks` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `schedule_no` varchar(25) DEFAULT NULL,
  `color_des` varchar(50) DEFAULT NULL,
  `size_ref` varchar(10) DEFAULT NULL,
  `ref_id` varchar(15) DEFAULT NULL,
  `planning_remarks` int(11) DEFAULT NULL,
  `commitments` varchar(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `ex_factory_date` date DEFAULT NULL,
  `plant_code` varchar(50) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `created_user` varchar(40) DEFAULT NULL,
  `updated_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `updated_user` varchar(40) DEFAULT NULL,
  `version_flag` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`tid`),
  KEY `NewIndex1` (`schedule_no`,`color_des`,`size_ref`),
  KEY `NewIndex2` (`ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `grand_rep` */

DROP TABLE IF EXISTS pts.`grand_rep`;

CREATE TABLE pts.`grand_rep` (
  `date` date NOT NULL DEFAULT '0000-00-00',
  `module` varchar(100) NOT NULL DEFAULT '0',
  `shift` varchar(10) NOT NULL DEFAULT '0' COMMENT 'Shift',
  `section` varchar(100) NOT NULL DEFAULT '0',
  `plan_out` float(11,0) NOT NULL DEFAULT '0',
  `act_out` smallint(4) unsigned NOT NULL DEFAULT '0',
  `plan_clh` float(11,2) NOT NULL DEFAULT '0.00',
  `act_clh` float(11,2) NOT NULL DEFAULT '0.00',
  `plan_sth` float(11,2) NOT NULL DEFAULT '0.00',
  `act_sth` float(11,2) NOT NULL DEFAULT '0.00',
  `tid` varchar(30) NOT NULL DEFAULT '0',
  `styles` varchar(250) NOT NULL DEFAULT '0',
  `buyer` varchar(500) NOT NULL DEFAULT '0',
  `nop` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `smv` float(11,2) NOT NULL DEFAULT '0.00',
  `plant_code` varchar(150) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(120) DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT '0',
  `version_flag` int(11) DEFAULT '1',
  PRIMARY KEY (`tid`),
  KEY `date` (`date`),
  KEY `module_shift` (`date`,`module`,`shift`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `ips_job_transfer` */

DROP TABLE IF EXISTS tms.`ips_job_transfer`;

CREATE TABLE tms.`ips_job_transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_no` varchar(50) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `transfered_module` varchar(50) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

/*Table structure for table `job_deactive_log` */

DROP TABLE IF EXISTS tms.`job_deactive_log`;

CREATE TABLE tms.`job_deactive_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `input_date` datetime DEFAULT NULL,
  `style` varchar(30) DEFAULT NULL,
  `schedule` varchar(30) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `po_number` varchar(50) DEFAULT NULL,
  `module_no` int(50) DEFAULT NULL,
  `input_job_no_random` varchar(100) DEFAULT NULL,
  `input_job_no` varchar(50) DEFAULT NULL,
  `input_qty` int(11) DEFAULT NULL,
  `out_qty` int(11) DEFAULT NULL,
  `rejected_qty` int(11) DEFAULT NULL,
  `wip` int(11) DEFAULT NULL,
  `remarks` varchar(20) DEFAULT NULL,
  `remove_type` varchar(20) DEFAULT NULL,
  `tran_user` varchar(20) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`remove_type`),
  KEY `schedule_job_status` (`schedule`,`input_job_no`,`remove_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `job_transfer_details` */

DROP TABLE IF EXISTS tms.`job_transfer_details`;

CREATE TABLE tms.`job_transfer_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sewing_job_number` varchar(90) DEFAULT NULL,
  `transfered_module` varchar(50) DEFAULT NULL,
  `STATUS` varchar(3) DEFAULT NULL COMMENT 'P-Pending,S-Send',
  `DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

/*Table structure for table `job_trims` */

DROP TABLE IF EXISTS tms.`job_trims`;

CREATE TABLE tms.`job_trims` (
  `trim_id` varchar(36) NOT NULL,
  `trim_status` enum('OPEN','Preparing material','Material ready for Production','Partial Issued','Issued To Module') NOT NULL,
  `plant_code` varchar(8) NOT NULL,
  `created_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `created_user` varchar(40) DEFAULT NULL,
  `updated_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `updated_user` varchar(40) DEFAULT NULL,
  `version_flag` int(11) NOT NULL DEFAULT '1',
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `task_job_id` varchar(36) NOT NULL,
  PRIMARY KEY (`trim_id`),
  KEY `FK_dc9ac85937965d3380e2a192bce` (`task_job_id`),
  CONSTRAINT `FK_dc9ac85937965d3380e2a192bce` FOREIGN KEY (`task_job_id`) REFERENCES `task_jobs` (`task_jobs_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `jobs_movement_track` */

DROP TABLE IF EXISTS tms.`jobs_movement_track`;

CREATE TABLE tms.`jobs_movement_track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_job_id` varchar(90) DEFAULT NULL,
  `from_module` varchar(40) DEFAULT NULL,
  `to_module` varchar(40) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=353 DEFAULT CHARSET=latin1;

