/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16 : Database - bai_quality
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_quality` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_quality`;

/*Table structure for table `comments_db` */

DROP TABLE IF EXISTS `comments_db`;

CREATE TABLE `comments_db` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `plan_db_tid` int(11) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `feedback_db` */

DROP TABLE IF EXISTS `feedback_db`;

CREATE TABLE `feedback_db` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `plan_db_tid` int(11) NOT NULL,
  `sample_id` int(11) NOT NULL,
  `module_title` varchar(50) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plan_db` */

DROP TABLE IF EXISTS `plan_db`;

CREATE TABLE `plan_db` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `plan_date` date NOT NULL,
  `allocated_to` varchar(50) NOT NULL,
  `completion_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
