/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16 : Database - bai_fin_pj3
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_fin_pj3` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_fin_pj3`;

/*Table structure for table `aod_cat_db` */

DROP TABLE IF EXISTS `aod_cat_db`;

CREATE TABLE `aod_cat_db` (
  `cat_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `category_title` varchar(100) NOT NULL,
  `authorised` varchar(100) NOT NULL,
  `sign_images` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `aod_db` */

DROP TABLE IF EXISTS `aod_db`;

CREATE TABLE `aod_db` (
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  `party` varchar(200) NOT NULL,
  `address` varchar(300) NOT NULL,
  `aod_type` smallint(6) NOT NULL,
  `sent_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tran_mode` smallint(6) NOT NULL,
  `veh_ref` varchar(50) NOT NULL,
  `con_person` varchar(30) NOT NULL,
  `con_num` varchar(30) NOT NULL,
  `exp_date_return` date NOT NULL,
  `status` smallint(6) NOT NULL COMMENT '0-created, 1-printed, 2-canceled, 3-partial return, 4-full return, 5-ret confirmed by admin\r\n',
  `exit_time` datetime NOT NULL,
  `entry_time` datetime NOT NULL,
  `alert_stat` tinyint(1) NOT NULL,
  `item_category` smallint(6) NOT NULL,
  `item_header` text NOT NULL,
  `item_desc` text NOT NULL,
  `sent_qty` varchar(30) NOT NULL,
  `remarks` text NOT NULL,
  `purpose` varchar(200) NOT NULL,
  `req_user` varchar(100) NOT NULL,
  `aod_date` date NOT NULL COMMENT 'AOD Date',
  PRIMARY KEY (`track_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `aod_db_edit_track` */

DROP TABLE IF EXISTS `aod_db_edit_track`;

CREATE TABLE `aod_db_edit_track` (
  `sno` double NOT NULL AUTO_INCREMENT,
  `track_id` double DEFAULT NULL,
  `party` varchar(1800) DEFAULT NULL,
  `address` varchar(2700) DEFAULT NULL,
  `aod_type` double DEFAULT NULL,
  `sent_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tran_mode` double DEFAULT NULL,
  `veh_ref` varchar(450) DEFAULT NULL,
  `con_person` varchar(270) DEFAULT NULL,
  `con_num` varchar(270) DEFAULT NULL,
  `exp_date_return` date DEFAULT NULL,
  `status` double DEFAULT NULL,
  `item_category` double DEFAULT NULL,
  `item_header` blob,
  `item_desc` blob,
  `sent_qty` varchar(270) DEFAULT NULL,
  `remarks` blob,
  `purpose` varchar(1800) DEFAULT NULL,
  `edit_query` blob,
  `request_edit_user` varchar(150) DEFAULT NULL,
  `request_edit` datetime DEFAULT NULL,
  `approve_edit_user` varchar(150) DEFAULT NULL,
  `approve_edit` datetime NOT NULL,
  `reject_edit_user` varchar(150) DEFAULT NULL,
  `reject_edit` datetime NOT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `aod_db_temp` */

DROP TABLE IF EXISTS `aod_db_temp`;

CREATE TABLE `aod_db_temp` (
  `track_id` double DEFAULT NULL,
  `party` varchar(1800) DEFAULT NULL,
  `address` varchar(2700) DEFAULT NULL,
  `aod_type` double DEFAULT NULL,
  `sent_date` datetime DEFAULT NULL,
  `tran_mode` double DEFAULT NULL,
  `veh_ref` varchar(450) DEFAULT NULL,
  `con_person` varchar(270) DEFAULT NULL,
  `con_num` varchar(270) DEFAULT NULL,
  `exp_date_return` date DEFAULT NULL,
  `status` double DEFAULT NULL,
  `exit_time` datetime DEFAULT NULL,
  `entry_time` datetime DEFAULT NULL,
  `alert_stat` tinyint(1) DEFAULT NULL,
  `item_category` double DEFAULT NULL,
  `item_header` blob,
  `item_desc` blob,
  `sent_qty` varchar(270) DEFAULT NULL,
  `remarks` blob,
  `purpose` varchar(1800) DEFAULT NULL,
  `req_user` varchar(900) DEFAULT NULL,
  `aod_date` date DEFAULT NULL,
  `log_date` datetime DEFAULT NULL,
  `edit_track_id` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `upload` */

DROP TABLE IF EXISTS `upload`;

CREATE TABLE `upload` (
  `name` varchar(270) DEFAULT NULL COMMENT 'empty contianer photo name',
  `type` varchar(270) DEFAULT NULL COMMENT 'image type',
  `size` double DEFAULT NULL COMMENT 'image size',
  `name1` varchar(450) DEFAULT NULL COMMENT 'half loaded container photo name',
  `type1` varchar(450) DEFAULT NULL COMMENT 'image type',
  `size1` double DEFAULT NULL COMMENT 'image size',
  `name2` varchar(450) DEFAULT NULL COMMENT 'fully loaded container photo name',
  `type2` varchar(450) DEFAULT NULL COMMENT 'image type',
  `size2` double DEFAULT NULL COMMENT 'image size',
  `name3` varchar(450) DEFAULT NULL COMMENT 'sealed container photo name',
  `type3` varchar(450) DEFAULT NULL COMMENT 'image type',
  `size3` double DEFAULT NULL COMMENT 'image size',
  `name4` varchar(450) DEFAULT NULL COMMENT 'Closeed seal ',
  `type4` varchar(450) DEFAULT NULL COMMENT 'image type',
  `size4` double DEFAULT NULL COMMENT 'image size',
  `container` varchar(450) DEFAULT NULL COMMENT 'Container',
  `vecno` varchar(450) DEFAULT NULL COMMENT 'Vehical NO',
  `sealno` varchar(450) DEFAULT NULL COMMENT 'Seal NO',
  `dat` date DEFAULT NULL COMMENT 'Photo Upload Date',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Photo Upload Time',
  `carton` double DEFAULT NULL COMMENT 'Carton PCS',
  `user` varchar(75) DEFAULT NULL COMMENT 'Photos Upload By',
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Serial NO',
  `name5` varchar(450) DEFAULT NULL COMMENT 'New Image',
  `type5` varchar(450) DEFAULT NULL COMMENT 'New Image Type',
  `size5` double DEFAULT NULL COMMENT 'New Image Double',
  UNIQUE KEY `tid` (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=2857 DEFAULT CHARSET=latin1;

/*Table structure for table `upload_archive` */

DROP TABLE IF EXISTS `upload_archive`;

CREATE TABLE `upload_archive` (
  `name` varchar(270) DEFAULT NULL COMMENT 'empty contianer photo name',
  `type` varchar(270) DEFAULT NULL COMMENT 'image type',
  `size` double DEFAULT NULL COMMENT 'image size',
  `name1` varchar(450) DEFAULT NULL COMMENT 'half loaded container photo name',
  `type1` varchar(450) DEFAULT NULL COMMENT 'image type',
  `size1` double DEFAULT NULL COMMENT 'image size',
  `name2` varchar(450) DEFAULT NULL COMMENT 'fully loaded container photo name',
  `type2` varchar(450) DEFAULT NULL COMMENT 'image type',
  `size2` double DEFAULT NULL COMMENT 'image size',
  `name3` varchar(450) DEFAULT NULL COMMENT 'sealed container photo name',
  `type3` varchar(450) DEFAULT NULL COMMENT 'image type',
  `size3` double DEFAULT NULL COMMENT 'image size',
  `name4` varchar(450) DEFAULT NULL COMMENT 'Closeed seal ',
  `type4` varchar(450) DEFAULT NULL COMMENT 'image type',
  `size4` double DEFAULT NULL COMMENT 'image size',
  `container` varchar(450) DEFAULT NULL COMMENT 'Container',
  `vecno` varchar(450) DEFAULT NULL COMMENT 'Vehical NO',
  `sealno` varchar(450) DEFAULT NULL COMMENT 'Seal NO',
  `dat` date DEFAULT NULL COMMENT 'Photo Upload Date',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Photo Upload Time',
  `carton` double DEFAULT NULL COMMENT 'Carton PCS',
  `user` varchar(75) DEFAULT NULL COMMENT 'Photos Upload By',
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Serial NO',
  `name5` varchar(450) DEFAULT NULL COMMENT 'New Image',
  `type5` varchar(450) DEFAULT NULL COMMENT 'New Image Type',
  `size5` double DEFAULT NULL COMMENT 'New Image Double',
  UNIQUE KEY `tid` (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=2075 DEFAULT CHARSET=latin1;

/*Table structure for table `upload_dest` */

DROP TABLE IF EXISTS `upload_dest`;

CREATE TABLE `upload_dest` (
  `name` varchar(810) DEFAULT NULL COMMENT 'Stacked Cartons Image Name',
  `type` varchar(810) DEFAULT NULL COMMENT 'Stacked Cartons Image Size',
  `size` double DEFAULT NULL COMMENT 'Stacked Cartons Type',
  `name1` varchar(1350) DEFAULT NULL COMMENT 'While Loading Image Name ',
  `type1` varchar(1350) DEFAULT NULL COMMENT 'While Loading Image Size',
  `size1` double DEFAULT NULL COMMENT 'While Loading Image Type',
  `name2` varchar(1350) DEFAULT NULL COMMENT 'Carton Weighing image name',
  `type2` varchar(1350) DEFAULT NULL COMMENT 'Carton Weighing Image Size',
  `size2` double DEFAULT NULL COMMENT 'Carton Weighing Image Type',
  `name3` varchar(1350) DEFAULT NULL COMMENT 'At Security Image Name',
  `type3` varchar(1350) DEFAULT NULL COMMENT 'At Security Image Size',
  `size3` double DEFAULT NULL COMMENT 'At Security Image Type',
  `name4` varchar(1350) DEFAULT NULL COMMENT 'Opening BOX Image Name',
  `type4` varchar(1350) DEFAULT NULL COMMENT 'Opening BOX Image Size ',
  `size4` double DEFAULT NULL COMMENT 'Opening BOX Image Type',
  `name5` varchar(1350) DEFAULT NULL COMMENT 'On Shredder Image Name',
  `type5` varchar(1350) DEFAULT NULL COMMENT 'On Shredder Image Size ',
  `size5` double DEFAULT NULL COMMENT 'On Shredder Image Type',
  `name6` varchar(1350) DEFAULT NULL COMMENT 'Collecting Dust Image Name',
  `type6` varchar(1350) DEFAULT NULL COMMENT 'Collecting Dust Image Size ',
  `size6` double DEFAULT NULL COMMENT 'Collecting Dust Image Type',
  `dc_cerf` varchar(1350) DEFAULT NULL COMMENT 'Destruction Certificate',
  `dc_cerf_type` varchar(1350) DEFAULT NULL COMMENT 'Destruction Certificate Type',
  `dc_cerf_size` double DEFAULT NULL COMMENT 'Destruction Certificate Size',
  `mail_copy` varchar(100) DEFAULT NULL COMMENT 'Mail Copy',
  `mail_copy_type` varchar(100) DEFAULT NULL COMMENT 'Mail Copy Type',
  `mail_copy_size` double DEFAULT NULL COMMENT 'Mail Copy Size',
  `dest` double NOT NULL COMMENT 'Destruction ID',
  `upload_by` varchar(50) DEFAULT NULL COMMENT 'Uploaded User Name',
  `date` datetime DEFAULT NULL COMMENT 'Uploaded Date',
  PRIMARY KEY (`dest`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `upload_dest_summary` */

DROP TABLE IF EXISTS `upload_dest_summary`;

CREATE TABLE `upload_dest_summary` (
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Transaction ID',
  `name` varchar(2430) DEFAULT NULL COMMENT 'Prior to Destruction Image Name',
  `type` varchar(2430) DEFAULT NULL COMMENT 'Prior to Destruction Image Type',
  `size` double DEFAULT NULL COMMENT 'Prior to Destruction Image Size',
  `name1` varchar(4050) DEFAULT NULL COMMENT 'While Destruction Image Name',
  `type1` varchar(4050) DEFAULT NULL COMMENT 'While Destruction Image Type',
  `size1` double DEFAULT NULL COMMENT 'While Destruction Image Size',
  `name2` varchar(4050) DEFAULT NULL COMMENT 'After Destruction Image Name',
  `type2` varchar(4050) DEFAULT NULL COMMENT 'After Destruction Image Type',
  `size2` double DEFAULT NULL COMMENT 'After Destruction Image Size',
  `dest` double DEFAULT NULL COMMENT 'Destrcution ID',
  `date` datetime DEFAULT NULL COMMENT 'Date',
  `style` varchar(100) DEFAULT NULL COMMENT 'Style Code',
  `upload_by` varchar(50) DEFAULT NULL COMMENT 'Uploaded By',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `uploads` */

DROP TABLE IF EXISTS `uploads`;

CREATE TABLE `uploads` (
  `id` double NOT NULL AUTO_INCREMENT,
  `name` varchar(270) DEFAULT NULL,
  `type` varchar(270) DEFAULT NULL,
  `size` double DEFAULT NULL,
  `content` blob,
  `container` varchar(450) DEFAULT NULL,
  `vecno` varchar(450) DEFAULT NULL,
  `sealno` varchar(450) DEFAULT NULL,
  `dat` date DEFAULT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `carton` double DEFAULT NULL,
  `user` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

/*Table structure for table `user_db` */

DROP TABLE IF EXISTS `user_db`;

CREATE TABLE `user_db` (
  `uid` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hod_uid` bigint(20) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `department` varchar(50) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
