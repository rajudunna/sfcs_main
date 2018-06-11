/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16 : Database - cargo_vehicle
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cargo_vehicle` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `cargo_vehicle`;

/*Table structure for table `vehicle_allocation` */

DROP TABLE IF EXISTS `vehicle_allocation`;

CREATE TABLE `vehicle_allocation` (
  `tid` double NOT NULL AUTO_INCREMENT,
  `vehicle_provider` varchar(200) NOT NULL COMMENT 'vehicle_provider',
  `vehicle_number` varchar(200) NOT NULL COMMENT 'vehicle_number',
  `vehicle_driver` varchar(200) NOT NULL COMMENT 'vehicle_driver',
  `driver_mobile` varchar(110) NOT NULL COMMENT 'Driver Mobile Number',
  `alloc_vehicle_capacity` varchar(100) NOT NULL COMMENT 'alloc_vehicle_capacity',
  `factory` varchar(100) NOT NULL COMMENT 'factory BAI1 or BAI2',
  `vehicle_arrival_time` varchar(200) NOT NULL COMMENT 'vehicle_arrival_time',
  `vehicle_details_updated_by` varchar(300) NOT NULL COMMENT 'vehicle_details_updated_by',
  `fk_tid` varchar(20) NOT NULL COMMENT 'tid (uniquie field of vehicle_request table) ',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `vehicle_details` */

DROP TABLE IF EXISTS `vehicle_details`;

CREATE TABLE `vehicle_details` (
  `vehicle_tid` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_group` varchar(100) NOT NULL,
  `vehicle_name` varchar(100) NOT NULL COMMENT 'vehicle name',
  `driver_name` varchar(100) NOT NULL,
  `driver_mobile` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0-active,1-inactive',
  PRIMARY KEY (`vehicle_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `vehicle_group` */

DROP TABLE IF EXISTS `vehicle_group`;

CREATE TABLE `vehicle_group` (
  `vehicle_group_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'vehicle group id',
  `vehicle_group_desc` varchar(255) NOT NULL COMMENT 'Vehicle group name',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0-active,1-inactive',
  PRIMARY KEY (`vehicle_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `vehicle_request` */

DROP TABLE IF EXISTS `vehicle_request`;

CREATE TABLE `vehicle_request` (
  `tid` double NOT NULL AUTO_INCREMENT,
  `required_date` varchar(50) NOT NULL COMMENT 'Vehicle Required Date',
  `trans_req` varchar(100) DEFAULT NULL COMMENT 'Transport Type (Shipment/Courier)',
  `requested_date` datetime NOT NULL COMMENT 'vehicel Request Applied Date',
  `pickup_point` varchar(200) NOT NULL COMMENT 'Pickup Point',
  `req_dept` varchar(150) NOT NULL COMMENT 'Requested Department',
  `destination` varchar(200) NOT NULL COMMENT 'Destination',
  `cbm` varchar(30) NOT NULL COMMENT 'cbm',
  `goh` varchar(30) NOT NULL COMMENT 'goh',
  `remarks` varchar(150) NOT NULL COMMENT 'Remarks',
  `req_applied_by` varchar(150) NOT NULL COMMENT 'Request Applied by',
  `approved_user_level1` varchar(150) NOT NULL COMMENT 'Level 1 Approved User',
  `approved_user_level2` varchar(150) NOT NULL COMMENT 'Level 2 Approved User',
  `rejected_user` varchar(100) NOT NULL COMMENT 'Rejected User',
  `rejected_reason` varchar(100) NOT NULL COMMENT 'Rejected Reason',
  `status` tinyint(4) NOT NULL COMMENT '0:Requested,1:First Level Approved,2:Second Level Approved,3:Rejected,4:Vehicle Allocated',
  `vehicle_provider` varchar(100) NOT NULL COMMENT 'vehicle_provider',
  `vehicle_number` varchar(100) NOT NULL COMMENT 'vehicle_number',
  `vehicle_driver` varchar(100) NOT NULL COMMENT 'vehicle_driver',
  `driver_mobile` varchar(45) NOT NULL COMMENT 'Driver Mobile Number',
  `alloc_vehicle_capacity` varchar(100) NOT NULL COMMENT 'alloc_vehicle_capacity',
  `factory` varchar(100) NOT NULL COMMENT 'factory BAI1 or BAI2',
  `vehicle_arrival_time` varchar(100) NOT NULL COMMENT 'vehicle_arrival_time',
  `vehicle_details_updated_by` varchar(100) NOT NULL COMMENT 'vehicle_details_updated_by',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
