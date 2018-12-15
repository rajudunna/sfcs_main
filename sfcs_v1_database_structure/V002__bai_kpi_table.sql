/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - bai_kpi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_kpi` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*USE `bai_kpi`;*/

/*Table structure for table `delivery_delays_track` */

DROP TABLE IF EXISTS `bai_kpi`.`delivery_delays_track`;

CREATE TABLE `bai_kpi`.`delivery_delays_track` (
  `tran_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL,
  `style` varchar(30) NOT NULL,
  `schedule` varchar(30) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `rm` int(11) NOT NULL,
  `cut` int(11) NOT NULL,
  `input` int(11) NOT NULL,
  `input_time` datetime NOT NULL,
  `sec1` int(11) NOT NULL,
  `sec2` int(11) NOT NULL,
  `sec3` int(11) NOT NULL,
  `sec4` int(11) NOT NULL,
  `sec5` int(11) NOT NULL,
  `sec6` int(11) NOT NULL,
  `sec7` int(11) NOT NULL,
  `sec8` int(11) NOT NULL,
  `sec9` int(11) NOT NULL,
  `sewing_time` datetime NOT NULL,
  `fg_time` datetime NOT NULL,
  `track_id` int(11) NOT NULL,
  `color` varchar(500) NOT NULL,
  `ex_fact` date NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`tran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `kpi_tracking` */

DROP TABLE IF EXISTS `bai_kpi`.`kpi_tracking`;

CREATE TABLE `bai_kpi`.`kpi_tracking` (
  `tran_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Transaction ID',
  `rep_date` date NOT NULL COMMENT 'Report Date',
  `parameter` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `value` double NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`tran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
