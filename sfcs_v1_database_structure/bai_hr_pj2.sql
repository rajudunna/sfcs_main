/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16 : Database - bai_hr_pj2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_hr_pj2` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_hr_pj2`;

/*Table structure for table `locations_db` */

DROP TABLE IF EXISTS `locations_db`;

CREATE TABLE `locations_db` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

/*Table structure for table `v_card` */

DROP TABLE IF EXISTS `v_card`;

CREATE TABLE `v_card` (
  `v_card` varchar(30) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `visit_act_log` */

DROP TABLE IF EXISTS `visit_act_log`;

CREATE TABLE `visit_act_log` (
  `sno` double NOT NULL AUTO_INCREMENT,
  `v_tid` varchar(30) NOT NULL,
  `name` varchar(150) NOT NULL,
  `origin` varchar(300) NOT NULL,
  `in_time` varchar(90) NOT NULL,
  `out_time` varchar(90) NOT NULL,
  `v_card` varchar(30) NOT NULL,
  `status` int(11) NOT NULL,
  `remarks` varchar(450) NOT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `visit_app_log` */

DROP TABLE IF EXISTS `visit_app_log`;

CREATE TABLE `visit_app_log` (
  `slip_tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `reference` text NOT NULL,
  `purpose` text NOT NULL,
  `app_date` date NOT NULL,
  `req_date` date NOT NULL,
  `in_time` time NOT NULL,
  `out_time` time NOT NULL,
  `app_user` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `VIP` int(11) NOT NULL,
  `origin` varchar(500) NOT NULL,
  `vehicle_no` varchar(200) NOT NULL,
  `reject_comment` text NOT NULL,
  `locations` varchar(50) NOT NULL,
  `refreshments` text NOT NULL,
  `duration` smallint(6) NOT NULL,
  `track` varchar(45) NOT NULL,
  PRIMARY KEY (`slip_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
