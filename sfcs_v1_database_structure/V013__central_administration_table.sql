/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - central_administration
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`central_administration` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `central_administration`;

/*Table structure for table `employees` */

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `department` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hire_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `login_info` */

DROP TABLE IF EXISTS `login_info`;

CREATE TABLE `login_info` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` mediumint(8) unsigned NOT NULL DEFAULT 0,
  `login` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `account_type` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'User',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `mate_columns` */

DROP TABLE IF EXISTS `mate_columns`;

CREATE TABLE `mate_columns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mate_user_id` varchar(225) NOT NULL,
  `mate_var_prefix` varchar(300) NOT NULL,
  `mate_column` varchar(225) NOT NULL,
  `hidden` varchar(9) NOT NULL,
  `order_num` int(11) unsigned NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_application_list` */

DROP TABLE IF EXISTS `tbl_application_list`;

CREATE TABLE `tbl_application_list` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_name` varchar(45) NOT NULL,
  `app_description` varchar(45) NOT NULL,
  `app_purpose` varchar(45) DEFAULT NULL,
  `app_owner` varchar(45) NOT NULL,
  `app_point_person` varchar(45) NOT NULL,
  `app_status` varchar(45) NOT NULL COMMENT 'active - 0 ; inactive - 1',
  `app_start_date` varchar(45) NOT NULL,
  `app_last_revision` varchar(45) NOT NULL,
  `app_remarks` varchar(45) NOT NULL,
  PRIMARY KEY (`app_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_function_list` */

DROP TABLE IF EXISTS `tbl_function_list`;

CREATE TABLE `tbl_function_list` (
  `fn_id` int(11) NOT NULL AUTO_INCREMENT,
  `fn_name` varchar(45) NOT NULL,
  `fn_purpose` varchar(150) DEFAULT NULL,
  `fn_status` varchar(4) NOT NULL COMMENT 'active - 0 ; inactive - 1',
  `fn_remarks` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`fn_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_group_list` */

DROP TABLE IF EXISTS `tbl_group_list`;

CREATE TABLE `tbl_group_list` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_status` varchar(4) NOT NULL,
  `group_purpose` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_menu_list` */

DROP TABLE IF EXISTS `tbl_menu_list`;

CREATE TABLE `tbl_menu_list` (
  `menu_pid` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` varchar(11) NOT NULL,
  `fk_group_id` varchar(45) NOT NULL,
  `fk_app_id` varchar(45) NOT NULL,
  `parent_id` varchar(45) NOT NULL,
  `link_type` varchar(45) NOT NULL COMMENT 'link type 0-heading/1-link',
  `link_status` varchar(45) NOT NULL COMMENT 'link_status 1-active / 0-inactive',
  `link_visibility` varchar(45) NOT NULL COMMENT 'link_visibility 0-appear in menu as a link/heading; 1- should not appear in menu (it will use for alerts)',
  `link_location` varchar(100) NOT NULL,
  `link_description` varchar(100) NOT NULL,
  `link_tool_tip` varchar(45) NOT NULL,
  `link_cmd` varchar(45) NOT NULL,
  PRIMARY KEY (`menu_pid`)
) ENGINE=MyISAM AUTO_INCREMENT=849 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_menu_matrix` */

DROP TABLE IF EXISTS `tbl_menu_matrix`;

CREATE TABLE `tbl_menu_matrix` (
  `matrix_pid` int(11) NOT NULL AUTO_INCREMENT,
  `fk_menu_pid` varchar(5) NOT NULL,
  `fk_fn_id` varchar(5) NOT NULL,
  `matrix_status` varchar(5) NOT NULL COMMENT 'active - 0 ; inactive - 1',
  `matrix_purpose` varchar(100) NOT NULL,
  `matrix_remarks` varchar(100) NOT NULL,
  PRIMARY KEY (`matrix_pid`)
) ENGINE=MyISAM AUTO_INCREMENT=974 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_role_list` */

DROP TABLE IF EXISTS `tbl_role_list`;

CREATE TABLE `tbl_role_list` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_desc` varchar(200) NOT NULL,
  `role_status` tinyint(4) NOT NULL,
  `fk_app_pid` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='to create roles';

/*Table structure for table `tbl_role_matrix` */

DROP TABLE IF EXISTS `tbl_role_matrix`;

CREATE TABLE `tbl_role_matrix` (
  `role_matrix_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_role_id` varchar(45) NOT NULL,
  `fk_menu_matrix_id` varchar(45) NOT NULL,
  `role_matrix_desc` varchar(200) NOT NULL,
  `role_matrix_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`role_matrix_id`),
  KEY `fk_role_id` (`fk_role_id`,`fk_menu_matrix_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='table to map menu matrix id with role id';

/*Table structure for table `tbl_user_acl_list` */

DROP TABLE IF EXISTS `tbl_user_acl_list`;

CREATE TABLE `tbl_user_acl_list` (
  `acl_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_matrix_pid` varchar(45) NOT NULL,
  `fk_user_id` varchar(45) NOT NULL,
  `acl_status` varchar(45) NOT NULL COMMENT 'active - 0 ; inactive - 1',
  PRIMARY KEY (`acl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10765 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_user_acl_list_role` */

DROP TABLE IF EXISTS `tbl_user_acl_list_role`;

CREATE TABLE `tbl_user_acl_list_role` (
  `acl_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_role_pid` varchar(45) NOT NULL,
  `fk_user_id` varchar(45) NOT NULL,
  `acl_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`acl_id`),
  UNIQUE KEY `fk_role_pid` (`fk_role_pid`,`fk_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='table for user access based on role';

/*Table structure for table `tbl_user_list` */

DROP TABLE IF EXISTS `tbl_user_list`;

CREATE TABLE `tbl_user_list` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `user_status` varchar(4) NOT NULL COMMENT 'active - 0 ; inactive - 1',
  `user_location` varchar(10) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=508 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_view_view_menu` */

DROP TABLE IF EXISTS `tbl_view_view_menu`;

CREATE TABLE `tbl_view_view_menu` (
  `user_id` int(11) NOT NULL DEFAULT 0,
  `user_name` varchar(45) NOT NULL,
  `user_status` varchar(4) NOT NULL COMMENT 'active - 0 ; inactive - 1',
  `user_location` varchar(10) NOT NULL,
  `acl_id` int(11) NOT NULL DEFAULT 0,
  `fk_matrix_pid` varchar(45) NOT NULL,
  `fk_user_id` varchar(45) NOT NULL,
  `acl_status` varchar(45) NOT NULL COMMENT 'active - 0 ; inactive - 1',
  `matrix_pid` int(11) NOT NULL DEFAULT 0,
  `fk_menu_pid` varchar(5) NOT NULL,
  `fk_fn_id` varchar(5) NOT NULL,
  `matrix_status` varchar(5) NOT NULL COMMENT 'active - 0 ; inactive - 1',
  `matrix_purpose` varchar(100) NOT NULL,
  `matrix_remarks` varchar(100) NOT NULL,
  `fn_id` int(11) NOT NULL DEFAULT 0,
  `fn_name` varchar(45) NOT NULL,
  `fn_purpose` varchar(150) DEFAULT NULL,
  `fn_status` varchar(4) NOT NULL COMMENT 'active - 0 ; inactive - 1',
  `fn_remarks` varchar(45) DEFAULT NULL,
  `menu_pid` int(11) NOT NULL DEFAULT 0,
  `page_id` varchar(11) NOT NULL,
  `fk_group_id` varchar(45) NOT NULL,
  `fk_app_id` varchar(45) NOT NULL,
  `parent_id` varchar(45) NOT NULL,
  `link_type` varchar(45) NOT NULL COMMENT 'link type 0-heading/1-link',
  `link_status` varchar(45) NOT NULL COMMENT 'link_status 1-active / 0-inactive',
  `link_visibility` varchar(45) NOT NULL COMMENT 'link_visibility 0-appear in menu as a link/heading; 1- should not appear in menu (it will use for alerts)',
  `link_location` varchar(100) NOT NULL,
  `link_description` varchar(100) NOT NULL,
  `link_tool_tip` varchar(45) NOT NULL,
  `link_cmd` varchar(45) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0,
  `group_status` varchar(4) NOT NULL,
  `group_purpose` varchar(100) DEFAULT NULL,
  `app_id` int(11) NOT NULL DEFAULT 0,
  `app_name` varchar(45) NOT NULL,
  `app_description` varchar(45) NOT NULL,
  `app_purpose` varchar(45) DEFAULT NULL,
  `app_owner` varchar(45) NOT NULL,
  `app_point_person` varchar(45) NOT NULL,
  `app_status` varchar(45) NOT NULL COMMENT 'active - 0 ; inactive - 1',
  `app_start_date` varchar(45) NOT NULL,
  `app_last_revision` varchar(45) NOT NULL,
  `app_remarks` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
