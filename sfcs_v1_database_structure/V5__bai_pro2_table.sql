/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - bai_pro2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_pro2` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_pro2`;

/*Table structure for table `bek_team` */

DROP TABLE IF EXISTS `bek_team`;

CREATE TABLE `bek_team` (
  `team` varchar(45) DEFAULT NULL,
  `team_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `buyer_codes` */

DROP TABLE IF EXISTS `buyer_codes`;

CREATE TABLE `buyer_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `buyer_name` varchar(255) DEFAULT NULL,
  `buyer_code` varchar(50) DEFAULT NULL,
  `status` int(2) DEFAULT 1 COMMENT '0-inactive, 1- active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_key` (`buyer_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `db_update_log` */

DROP TABLE IF EXISTS `db_update_log`;

CREATE TABLE `db_update_log` (
  `date` date NOT NULL,
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(200) NOT NULL,
  `operation` varchar(100) NOT NULL,
  `lupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `deliver_mode` */

DROP TABLE IF EXISTS `deliver_mode`;

CREATE TABLE `deliver_mode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_del` varchar(45) DEFAULT NULL,
  `mode` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `downtime_reason` */

DROP TABLE IF EXISTS `downtime_reason`;

CREATE TABLE `downtime_reason` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) DEFAULT NULL,
  `rdept` varchar(65) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

/*Table structure for table `fca_status` */

DROP TABLE IF EXISTS `fca_status`;

CREATE TABLE `fca_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_del_no` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `fr_data` */

DROP TABLE IF EXISTS `fr_data`;

CREATE TABLE `fr_data` (
  `fr_id` int(45) NOT NULL AUTO_INCREMENT,
  `frdate` varchar(45) DEFAULT NULL,
  `team` varchar(12) DEFAULT NULL,
  `style` varchar(45) DEFAULT NULL,
  `smv` varchar(25) DEFAULT NULL,
  `fr_qty` varchar(45) DEFAULT NULL,
  `hours` varchar(45) DEFAULT NULL,
  `schedule` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`fr_id`),
  KEY `fr_date` (`frdate`),
  KEY `style_schedule` (`style`,`schedule`)
) ENGINE=InnoDB AUTO_INCREMENT=4260 DEFAULT CHARSET=latin1;

/*Table structure for table `fr_data_copy` */

DROP TABLE IF EXISTS `fr_data_copy`;

CREATE TABLE `fr_data_copy` (
  `fr_id` int(45) NOT NULL AUTO_INCREMENT,
  `frdate` varchar(45) DEFAULT NULL,
  `team` varchar(12) DEFAULT NULL,
  `style` varchar(45) DEFAULT NULL,
  `smv` varchar(25) DEFAULT NULL,
  `fr_qty` varchar(45) DEFAULT NULL,
  `hours` varchar(45) DEFAULT NULL,
  `schedule` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`fr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `hourly_downtime` */

DROP TABLE IF EXISTS `hourly_downtime`;

CREATE TABLE `hourly_downtime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(45) DEFAULT NULL,
  `time` varchar(45) DEFAULT NULL,
  `team` varchar(45) DEFAULT NULL,
  `dreason` varchar(45) DEFAULT NULL,
  `output_qty` varchar(45) DEFAULT NULL,
  `dhour` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=3002 DEFAULT CHARSET=latin1;

/*Table structure for table `hout` */

DROP TABLE IF EXISTS `hout`;

CREATE TABLE `hout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `out_date` varchar(45) DEFAULT NULL,
  `out_time` varchar(45) DEFAULT NULL,
  `team` varchar(45) DEFAULT NULL,
  `qty` varchar(25) DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `rep_start_time` time DEFAULT NULL,
  `rep_end_time` time DEFAULT NULL,
  `time_parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4616 DEFAULT CHARSET=latin1;

/*Table structure for table `members` */

DROP TABLE IF EXISTS `members`;

CREATE TABLE `members` (
  `member_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `login` varchar(100) NOT NULL DEFAULT '',
  `passwd` varchar(32) NOT NULL DEFAULT '',
  `level` int(11) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `movex_styles` */

DROP TABLE IF EXISTS `movex_styles`;

CREATE TABLE `movex_styles` (
  `movex_style` varchar(200) NOT NULL COMMENT 'Movex Stlye',
  `style_id` varchar(200) DEFAULT NULL COMMENT 'Style ID',
  `mod_count` int(11) NOT NULL COMMENT 'Module Count',
  `buyer_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`movex_style`),
  KEY `style_id` (`style_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `movex_styles_backup` */

DROP TABLE IF EXISTS `movex_styles_backup`;

CREATE TABLE `movex_styles_backup` (
  `movex_style` varchar(200) NOT NULL,
  `style_id` varchar(200) DEFAULT NULL,
  `mod_count` int(11) NOT NULL,
  `buyer_id` varchar(60) DEFAULT NULL,
  `buyer_ids` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`movex_style`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `movex_styles_copy` */

DROP TABLE IF EXISTS `movex_styles_copy`;

CREATE TABLE `movex_styles_copy` (
  `movex_style` varchar(200) NOT NULL,
  `style_id` varchar(200) DEFAULT NULL,
  `mod_count` int(11) NOT NULL,
  PRIMARY KEY (`movex_style`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `order_status_buffer` */

DROP TABLE IF EXISTS `order_status_buffer`;

CREATE TABLE `order_status_buffer` (
  `cust_order` varchar(100) DEFAULT NULL,
  `CPO` varchar(100) DEFAULT NULL,
  `buyer_div` varchar(200) DEFAULT NULL,
  `style` varchar(100) DEFAULT NULL,
  `style_id` varchar(100) DEFAULT NULL,
  `schedule` varchar(100) DEFAULT NULL,
  `color` varchar(500) DEFAULT NULL,
  `exf_date` date DEFAULT NULL,
  `order_qty` double DEFAULT NULL,
  `cut_qty` double DEFAULT NULL,
  `sewing_in_qty` double DEFAULT NULL,
  `sewing_out_qty` double DEFAULT NULL,
  `pack_qty` double DEFAULT NULL,
  `ship_qty` double DEFAULT NULL,
  `ssc_code` varchar(500) NOT NULL,
  PRIMARY KEY (`ssc_code`),
  KEY `schedule` (`style`,`schedule`,`color`),
  KEY `ssc_code` (`ssc_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `print_track` */

DROP TABLE IF EXISTS `print_track`;

CREATE TABLE `print_track` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `ref_id` int(11) NOT NULL,
  `user` varchar(500) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `pro_review` */

DROP TABLE IF EXISTS `pro_review`;

CREATE TABLE `pro_review` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `style` varchar(100) NOT NULL,
  `dno` varchar(100) NOT NULL,
  `schedule` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `cutid` varchar(100) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `shipment_plan` */

DROP TABLE IF EXISTS `shipment_plan`;

CREATE TABLE `shipment_plan` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `style_no` varchar(200) NOT NULL,
  `schedule_no` varchar(200) NOT NULL,
  `color` varchar(200) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `exfact_date` date NOT NULL,
  `week_code` int(11) NOT NULL,
  `Cust_order` varchar(200) NOT NULL,
  `CPO` varchar(200) NOT NULL,
  `buyer_div` varchar(200) NOT NULL,
  `style_id` varchar(200) DEFAULT NULL,
  `ssc_code` varchar(200) NOT NULL,
  `MPO` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `style_no` (`style_no`),
  KEY `schedule_no` (`schedule_no`),
  KEY `color` (`color`),
  KEY `week_code` (`week_code`),
  KEY `ssc_code` (`ssc_code`)
) ENGINE=MyISAM AUTO_INCREMENT=401766 DEFAULT CHARSET=latin1;

/*Table structure for table `shipment_plan_summ` */

DROP TABLE IF EXISTS `shipment_plan_summ`;

CREATE TABLE `shipment_plan_summ` (
  `ssc_code` varchar(500) NOT NULL,
  `style_no` varchar(200) NOT NULL,
  `schedule_no` varchar(200) NOT NULL,
  `color` varchar(200) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `exfact_date` date NOT NULL,
  `week_code` int(11) NOT NULL,
  `Cust_order` varchar(200) NOT NULL,
  `CPO` varchar(200) NOT NULL,
  `buyer_div` varchar(200) NOT NULL,
  `old_order_qty` int(11) NOT NULL,
  `style_id` varchar(200) DEFAULT NULL,
  `MPO` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ssc_code`),
  KEY `style_no` (`style_no`),
  KEY `schedule_no` (`schedule_no`),
  KEY `color` (`color`),
  KEY `week_code` (`week_code`),
  KEY `ssc_code` (`ssc_code`),
  KEY `style_no_2` (`style_no`),
  KEY `schedule_no_2` (`schedule_no`),
  KEY `color_2` (`color`),
  KEY `week_code_2` (`week_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `ssc_code_filter` */

DROP TABLE IF EXISTS `ssc_code_filter`;

CREATE TABLE `ssc_code_filter` (
  `ssc_code` varchar(200) NOT NULL,
  PRIMARY KEY (`ssc_code`),
  KEY `ssc_code` (`ssc_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `ssc_code_list` */

DROP TABLE IF EXISTS `ssc_code_list`;

CREATE TABLE `ssc_code_list` (
  `ssc_code` varchar(200) NOT NULL,
  PRIMARY KEY (`ssc_code`),
  KEY `ssc_code` (`ssc_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `ssc_code_temp` */

DROP TABLE IF EXISTS `ssc_code_temp`;

CREATE TABLE `ssc_code_temp` (
  `ssc_code` varchar(200) NOT NULL,
  `schedule_no` varchar(100) NOT NULL,
  PRIMARY KEY (`ssc_code`),
  KEY `ssc_code` (`ssc_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `style_smv` */

DROP TABLE IF EXISTS `style_smv`;

CREATE TABLE `style_smv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(45) DEFAULT NULL,
  `smv` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `style_status` */

DROP TABLE IF EXISTS `style_status`;

CREATE TABLE `style_status` (
  `style` varchar(200) NOT NULL,
  `sch_no` varchar(200) NOT NULL,
  `exfact_date` date NOT NULL,
  `color` varchar(200) NOT NULL,
  `cut_qty` int(11) NOT NULL,
  `sewing_in` int(11) NOT NULL,
  `sewing_out` int(11) NOT NULL,
  `pack_qty` int(11) NOT NULL,
  `ship_qty` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `update_date` int(11) NOT NULL,
  `week_code` int(11) NOT NULL,
  `size` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `style_status_summ` */

DROP TABLE IF EXISTS `style_status_summ`;

CREATE TABLE `style_status_summ` (
  `ssc_code` varchar(500) NOT NULL,
  `style` varchar(200) NOT NULL,
  `sch_no` varchar(200) NOT NULL,
  `color` varchar(200) NOT NULL,
  `cut_qty` int(11) NOT NULL,
  `sewing_in` int(11) NOT NULL,
  `sewing_out` int(11) NOT NULL,
  `pack_qty` int(11) NOT NULL,
  `ship_qty` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `update_date` int(11) NOT NULL,
  `week_code` int(11) NOT NULL,
  `old_cut_qty` int(11) NOT NULL,
  `old_sewing_in` int(11) NOT NULL,
  `old_sewing_out` int(11) NOT NULL,
  `old_pack_qty` int(11) NOT NULL,
  `old_ship_qty` int(11) NOT NULL,
  `style_id` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ssc_code`),
  KEY `ssc_code` (`ssc_code`),
  KEY `style` (`style`),
  KEY `sch_no` (`sch_no`),
  KEY `color` (`color`),
  KEY `week_code` (`week_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `style_status_summ_live_temp` */

DROP TABLE IF EXISTS `style_status_summ_live_temp`;

CREATE TABLE `style_status_summ_live_temp` (
  `ssc_code` varchar(250) NOT NULL,
  `cut_qty` int(11) NOT NULL,
  `sewing_in` int(11) NOT NULL,
  `sewing_out` int(11) NOT NULL,
  `pack_qty` int(11) NOT NULL,
  `ship_qty` int(11) NOT NULL,
  PRIMARY KEY (`ssc_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `style_status_summ_today` */

DROP TABLE IF EXISTS `style_status_summ_today`;

CREATE TABLE `style_status_summ_today` (
  `ssc_code` varchar(500) NOT NULL,
  `style` varchar(200) NOT NULL,
  `sch_no` varchar(200) NOT NULL,
  `color` varchar(200) NOT NULL,
  `cut_qty` int(11) NOT NULL,
  `sewing_in` int(11) NOT NULL,
  `sewing_out` int(11) NOT NULL,
  `pack_qty` int(11) NOT NULL,
  `ship_qty` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `update_date` int(11) NOT NULL,
  `week_code` int(11) NOT NULL,
  `old_cut_qty` int(11) NOT NULL,
  `old_sewing_in` int(11) NOT NULL,
  `old_sewing_out` int(11) NOT NULL,
  `old_pack_qty` int(11) NOT NULL,
  `old_ship_qty` int(11) NOT NULL,
  `style_id` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ssc_code`),
  KEY `ssc_code` (`ssc_code`),
  KEY `style` (`style`),
  KEY `sch_no` (`sch_no`),
  KEY `color` (`color`),
  KEY `ssc_code_2` (`ssc_code`),
  KEY `week_code` (`week_code`),
  KEY `ssc_code_3` (`ssc_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_mini_plant_master` */

DROP TABLE IF EXISTS `tbl_mini_plant_master`;

CREATE TABLE `tbl_mini_plant_master` (
  `plant_id` int(11) NOT NULL AUTO_INCREMENT,
  `plant_name` varchar(255) DEFAULT NULL,
  `plant_modules` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`plant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `trim_cards_db` */

DROP TABLE IF EXISTS `trim_cards_db`;

CREATE TABLE `trim_cards_db` (
  `style` varchar(50) DEFAULT NULL,
  `schedule` varchar(50) DEFAULT NULL,
  `color` varchar(200) DEFAULT NULL,
  `ssc_code` varchar(500) DEFAULT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remarks` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `upload_details` */

DROP TABLE IF EXISTS `upload_details`;

CREATE TABLE `upload_details` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `card_no` varchar(45) NOT NULL,
  `upload_date` date NOT NULL,
  `upload_time` varchar(45) NOT NULL,
  `scan_time` varchar(45) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `user_name` varchar(45) NOT NULL,
  `address` text NOT NULL,
  `location` varchar(45) NOT NULL,
  `telephone` varchar(45) NOT NULL,
  `dob` date NOT NULL,
  `designation` varchar(45) NOT NULL,
  `type` varchar(20) NOT NULL,
  `epf` varchar(45) NOT NULL,
  `cardno` varchar(45) NOT NULL,
  `status` int(11) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `user_type` */

DROP TABLE IF EXISTS `user_type`;

CREATE TABLE `user_type` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
