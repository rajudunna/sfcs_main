/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16 : Database - central_administration
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
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
  `employee_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
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
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_name` varchar(45) NOT NULL,
  `user_status` varchar(4) NOT NULL COMMENT 'active - 0 ; inactive - 1',
  `user_location` varchar(10) NOT NULL,
  `acl_id` int(11) NOT NULL DEFAULT '0',
  `fk_matrix_pid` varchar(45) NOT NULL,
  `fk_user_id` varchar(45) NOT NULL,
  `acl_status` varchar(45) NOT NULL COMMENT 'active - 0 ; inactive - 1',
  `matrix_pid` int(11) NOT NULL DEFAULT '0',
  `fk_menu_pid` varchar(5) NOT NULL,
  `fk_fn_id` varchar(5) NOT NULL,
  `matrix_status` varchar(5) NOT NULL COMMENT 'active - 0 ; inactive - 1',
  `matrix_purpose` varchar(100) NOT NULL,
  `matrix_remarks` varchar(100) NOT NULL,
  `fn_id` int(11) NOT NULL DEFAULT '0',
  `fn_name` varchar(45) NOT NULL,
  `fn_purpose` varchar(150) DEFAULT NULL,
  `fn_status` varchar(4) NOT NULL COMMENT 'active - 0 ; inactive - 1',
  `fn_remarks` varchar(45) DEFAULT NULL,
  `menu_pid` int(11) NOT NULL DEFAULT '0',
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
  `group_id` int(11) NOT NULL DEFAULT '0',
  `group_status` varchar(4) NOT NULL,
  `group_purpose` varchar(100) DEFAULT NULL,
  `app_id` int(11) NOT NULL DEFAULT '0',
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

/* Function  structure for function  `fun_emp_mod` */

/*!50003 DROP FUNCTION IF EXISTS `fun_emp_mod` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fun_emp_mod`(`id` VARCHAR(100)) RETURNS varchar(200) CHARSET latin1
    DETERMINISTIC
BEGIN
		DECLARE RET VARCHAR(200);
		SELECT module INTO RET FROM bai_hr_tna_em_1515.Jan WHERE emp_id=id and date='2015-01-01';
		RETURN RET;
	    END */$$
DELIMITER ;

/* Procedure structure for procedure `GetFunctionDetails` */

/*!50003 DROP PROCEDURE IF EXISTS  `GetFunctionDetails` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `GetFunctionDetails`()
BEGIN
 SELECT fn_id,fn_name 
 FROM menu.tbl_function_list where fn_status=1;
 END */$$
DELIMITER ;

/* Procedure structure for procedure `list_function` */

/*!50003 DROP PROCEDURE IF EXISTS  `list_function` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `list_function`()
begin
DECLARE v_fn_id int;
DECLARE v_fn_name varchar(255);
DECLARE done INT DEFAULT FALSE;
declare cur1 cursor for SELECT fn_id,fn_name FROM menu.tbl_function_list where fn_status=1;
declare continue handler for not found set v_fn_id=0;
open cur1;
the_loop: loop
Fetch cur1 into v_fn_id,v_fn_name;
IF done THEN
      LEAVE the_loop;
    END IF;
    IF v_fn_id IS NULL THEN
      SET v_fn_id = "";
    END IF;
 
    IF v_fn_name IS NULL THEN
      SET v_fn_name = "";
    END IF;
end loop the_loop;
close cur1;
end */$$
DELIMITER ;

/* Procedure structure for procedure `test1` */

/*!50003 DROP PROCEDURE IF EXISTS  `test1` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `test1`()
begin
declare done int default false;
declare v_fn_id integer;
declare v_fn_name text;
declare curs1 cursor for SELECT fn_id,fn_name FROM menu.tbl_function_list where fn_status=1;
 DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
 OPEN curs1;
read_loop: LOOP
fetch curs1 into v_fn_id,v_fn_name;
if done then
leave read_loop;
end if;
SELECT menu_pid,parent_id,app_id,app_name,link_description,
if(fn_id=1,group_concat(distinct(user_name)),NULL) as 'view_users',
if(fn_id=2,group_concat(distinct(user_name)),NULL) as 'edit_users',
if(fn_id=3,group_concat(distinct(user_name)),NULL) as 'update_users',
if(fn_id=4,group_concat(distinct(user_name)),NULL) as 'delete_users',
if(fn_id=5,group_concat(distinct(user_name)),NULL) as 'alert_recipients_users'
FROM menu.view_menu 
where menu_pid in (
select distinct(menu_pid) from menu.view_menu where group_id=1) 
group by menu_pid order by app_id;end loop;
close curs1;
end */$$
DELIMITER ;

/*Table structure for table `veiw_menu_matrix` */

DROP TABLE IF EXISTS `veiw_menu_matrix`;

/*!50001 DROP VIEW IF EXISTS `veiw_menu_matrix` */;
/*!50001 DROP TABLE IF EXISTS `veiw_menu_matrix` */;

/*!50001 CREATE TABLE  `veiw_menu_matrix`(
 `matrix_pid` int(11) ,
 `fk_menu_pid` varchar(5) ,
 `fk_fn_id` varchar(5) ,
 `matrix_status` varchar(5) ,
 `matrix_purpose` varchar(100) ,
 `matrix_remarks` varchar(100) ,
 `menu_pid` int(11) ,
 `page_id` varchar(11) ,
 `fk_group_id` varchar(45) ,
 `fk_app_id` varchar(45) ,
 `parent_id` varchar(45) ,
 `link_type` varchar(45) ,
 `link_status` varchar(45) ,
 `link_visibility` varchar(45) ,
 `link_location` varchar(100) ,
 `link_description` varchar(100) ,
 `link_tool_tip` varchar(45) ,
 `link_cmd` varchar(45) ,
 `fn_id` int(11) ,
 `fn_name` varchar(45) ,
 `fn_purpose` varchar(150) ,
 `fn_status` varchar(4) ,
 `fn_remarks` varchar(45) ,
 `app_id` int(11) ,
 `app_name` varchar(45) ,
 `app_description` varchar(45) ,
 `app_purpose` varchar(45) ,
 `app_owner` varchar(45) ,
 `app_point_person` varchar(45) ,
 `app_status` varchar(45) ,
 `app_start_date` varchar(45) ,
 `app_last_revision` varchar(45) ,
 `app_remarks` varchar(45) ,
 `group_id` int(11) ,
 `group_status` varchar(4) ,
 `group_purpose` varchar(100) 
)*/;

/*Table structure for table `view_menu` */

DROP TABLE IF EXISTS `view_menu`;

/*!50001 DROP VIEW IF EXISTS `view_menu` */;
/*!50001 DROP TABLE IF EXISTS `view_menu` */;

/*!50001 CREATE TABLE  `view_menu`(
 `user_id` int(11) ,
 `user_name` varchar(45) ,
 `user_status` varchar(4) ,
 `user_location` varchar(10) ,
 `acl_id` int(11) ,
 `fk_matrix_pid` varchar(45) ,
 `fk_user_id` varchar(45) ,
 `acl_status` varchar(45) ,
 `matrix_pid` int(11) ,
 `fk_menu_pid` varchar(5) ,
 `fk_fn_id` varchar(5) ,
 `matrix_status` varchar(5) ,
 `matrix_purpose` varchar(100) ,
 `matrix_remarks` varchar(100) ,
 `fn_id` int(11) ,
 `fn_name` varchar(45) ,
 `fn_purpose` varchar(150) ,
 `fn_status` varchar(4) ,
 `fn_remarks` varchar(45) ,
 `menu_pid` int(11) ,
 `page_id` varchar(11) ,
 `fk_group_id` varchar(45) ,
 `fk_app_id` varchar(45) ,
 `parent_id` varchar(45) ,
 `link_type` varchar(45) ,
 `link_status` varchar(45) ,
 `link_visibility` varchar(45) ,
 `link_location` varchar(100) ,
 `link_description` varchar(100) ,
 `link_tool_tip` varchar(45) ,
 `link_cmd` varchar(45) ,
 `group_id` int(11) ,
 `group_status` varchar(4) ,
 `group_purpose` varchar(100) ,
 `app_id` int(11) ,
 `app_name` varchar(45) ,
 `app_description` varchar(45) ,
 `app_purpose` varchar(45) ,
 `app_owner` varchar(45) ,
 `app_point_person` varchar(45) ,
 `app_status` varchar(45) ,
 `app_start_date` varchar(45) ,
 `app_last_revision` varchar(45) ,
 `app_remarks` varchar(45) 
)*/;

/*Table structure for table `view_menu_role` */

DROP TABLE IF EXISTS `view_menu_role`;

/*!50001 DROP VIEW IF EXISTS `view_menu_role` */;
/*!50001 DROP TABLE IF EXISTS `view_menu_role` */;

/*!50001 CREATE TABLE  `view_menu_role`(
 `user_id` int(11) ,
 `username` varchar(45) ,
 `user_status` varchar(4) ,
 `user_location` varchar(10) ,
 `acl_id` int(11) ,
 `fk_role_pid` varchar(45) ,
 `fk_user_id` varchar(45) ,
 `acl_status` tinyint(4) ,
 `role_id` int(11) ,
 `role_desc` varchar(200) ,
 `role_status` tinyint(4) ,
 `fk_app_pid` varchar(45) ,
 `role_matrix_id` int(11) ,
 `fk_role_id` varchar(45) ,
 `fk_menu_matrix_id` varchar(45) ,
 `role_matrix_desc` varchar(200) ,
 `role_matrix_status` tinyint(4) ,
 `matrix_pid` int(11) ,
 `fk_menu_pid` varchar(5) ,
 `fk_fn_id` varchar(5) ,
 `matrix_status` varchar(5) ,
 `matrix_purpose` varchar(100) ,
 `matrix_remarks` varchar(100) ,
 `fn_id` int(11) ,
 `fn_name` varchar(45) ,
 `fn_purpose` varchar(150) ,
 `fn_status` varchar(4) ,
 `fn_remarks` varchar(45) ,
 `menu_pid` int(11) ,
 `page_id` varchar(11) ,
 `fk_group_id` varchar(45) ,
 `fk_app_id` varchar(45) ,
 `parent_id` varchar(45) ,
 `link_type` varchar(45) ,
 `link_status` varchar(45) ,
 `link_visibility` varchar(45) ,
 `link_location` varchar(100) ,
 `link_description` varchar(100) ,
 `link_tool_tip` varchar(45) ,
 `link_cmd` varchar(45) ,
 `group_id` int(11) ,
 `group_status` varchar(4) ,
 `group_purpose` varchar(100) ,
 `app_id` int(11) ,
 `app_name` varchar(45) ,
 `app_description` varchar(45) ,
 `app_purpose` varchar(45) ,
 `app_owner` varchar(45) ,
 `app_point_person` varchar(45) ,
 `app_status` varchar(45) ,
 `app_start_date` varchar(45) ,
 `app_last_revision` varchar(45) ,
 `app_remarks` varchar(45) 
)*/;

/*View structure for view veiw_menu_matrix */

/*!50001 DROP TABLE IF EXISTS `veiw_menu_matrix` */;
/*!50001 DROP VIEW IF EXISTS `veiw_menu_matrix` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `veiw_menu_matrix` AS select `a`.`matrix_pid` AS `matrix_pid`,`a`.`fk_menu_pid` AS `fk_menu_pid`,`a`.`fk_fn_id` AS `fk_fn_id`,`a`.`matrix_status` AS `matrix_status`,`a`.`matrix_purpose` AS `matrix_purpose`,`a`.`matrix_remarks` AS `matrix_remarks`,`b`.`menu_pid` AS `menu_pid`,`b`.`page_id` AS `page_id`,`b`.`fk_group_id` AS `fk_group_id`,`b`.`fk_app_id` AS `fk_app_id`,`b`.`parent_id` AS `parent_id`,`b`.`link_type` AS `link_type`,`b`.`link_status` AS `link_status`,`b`.`link_visibility` AS `link_visibility`,`b`.`link_location` AS `link_location`,`b`.`link_description` AS `link_description`,`b`.`link_tool_tip` AS `link_tool_tip`,`b`.`link_cmd` AS `link_cmd`,`c`.`fn_id` AS `fn_id`,`c`.`fn_name` AS `fn_name`,`c`.`fn_purpose` AS `fn_purpose`,`c`.`fn_status` AS `fn_status`,`c`.`fn_remarks` AS `fn_remarks`,`d`.`app_id` AS `app_id`,`d`.`app_name` AS `app_name`,`d`.`app_description` AS `app_description`,`d`.`app_purpose` AS `app_purpose`,`d`.`app_owner` AS `app_owner`,`d`.`app_point_person` AS `app_point_person`,`d`.`app_status` AS `app_status`,`d`.`app_start_date` AS `app_start_date`,`d`.`app_last_revision` AS `app_last_revision`,`d`.`app_remarks` AS `app_remarks`,`e`.`group_id` AS `group_id`,`e`.`group_status` AS `group_status`,`e`.`group_purpose` AS `group_purpose` from ((((`tbl_menu_matrix` `a` join `tbl_menu_list` `b` on((`a`.`fk_menu_pid` = `b`.`menu_pid`))) join `tbl_function_list` `c` on((`a`.`fk_fn_id` = `c`.`fn_id`))) join `tbl_application_list` `d` on((`b`.`fk_app_id` = `d`.`app_id`))) join `tbl_group_list` `e` on((`b`.`fk_group_id` = `e`.`group_id`))) */;

/*View structure for view view_menu */

/*!50001 DROP TABLE IF EXISTS `view_menu` */;
/*!50001 DROP VIEW IF EXISTS `view_menu` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_menu` AS select `a`.`user_id` AS `user_id`,`a`.`username` AS `user_name`,`a`.`user_status` AS `user_status`,`a`.`user_location` AS `user_location`,`b`.`acl_id` AS `acl_id`,`b`.`fk_matrix_pid` AS `fk_matrix_pid`,`b`.`fk_user_id` AS `fk_user_id`,`b`.`acl_status` AS `acl_status`,`c`.`matrix_pid` AS `matrix_pid`,`c`.`fk_menu_pid` AS `fk_menu_pid`,`c`.`fk_fn_id` AS `fk_fn_id`,`c`.`matrix_status` AS `matrix_status`,`c`.`matrix_purpose` AS `matrix_purpose`,`c`.`matrix_remarks` AS `matrix_remarks`,`d`.`fn_id` AS `fn_id`,`d`.`fn_name` AS `fn_name`,`d`.`fn_purpose` AS `fn_purpose`,`d`.`fn_status` AS `fn_status`,`d`.`fn_remarks` AS `fn_remarks`,`e`.`menu_pid` AS `menu_pid`,`e`.`page_id` AS `page_id`,`e`.`fk_group_id` AS `fk_group_id`,`e`.`fk_app_id` AS `fk_app_id`,`e`.`parent_id` AS `parent_id`,`e`.`link_type` AS `link_type`,`e`.`link_status` AS `link_status`,`e`.`link_visibility` AS `link_visibility`,`e`.`link_location` AS `link_location`,`e`.`link_description` AS `link_description`,`e`.`link_tool_tip` AS `link_tool_tip`,`e`.`link_cmd` AS `link_cmd`,`f`.`group_id` AS `group_id`,`f`.`group_status` AS `group_status`,`f`.`group_purpose` AS `group_purpose`,`h`.`app_id` AS `app_id`,`h`.`app_name` AS `app_name`,`h`.`app_description` AS `app_description`,`h`.`app_purpose` AS `app_purpose`,`h`.`app_owner` AS `app_owner`,`h`.`app_point_person` AS `app_point_person`,`h`.`app_status` AS `app_status`,`h`.`app_start_date` AS `app_start_date`,`h`.`app_last_revision` AS `app_last_revision`,`h`.`app_remarks` AS `app_remarks` from ((((((`tbl_user_list` `a` join `tbl_user_acl_list` `b` on(((`a`.`user_id` = `b`.`fk_user_id`) and (`a`.`user_status` = 1) and (`b`.`acl_status` = 1)))) join `tbl_menu_matrix` `c` on(((`b`.`fk_matrix_pid` = `c`.`matrix_pid`) and (`c`.`matrix_status` = 1)))) join `tbl_function_list` `d` on(((`c`.`fk_fn_id` = `d`.`fn_id`) and (`d`.`fn_status` = 1)))) join `tbl_menu_list` `e` on(((`c`.`fk_menu_pid` = `e`.`menu_pid`) and (`e`.`link_status` = 1)))) join `tbl_group_list` `f` on(((`e`.`fk_group_id` = `f`.`group_id`) and (`f`.`group_status` = 1)))) join `tbl_application_list` `h` on(((`e`.`fk_app_id` = `h`.`app_id`) and (`h`.`app_status` = 1)))) order by `a`.`user_id`,`c`.`matrix_pid` */;

/*View structure for view view_menu_role */

/*!50001 DROP TABLE IF EXISTS `view_menu_role` */;
/*!50001 DROP VIEW IF EXISTS `view_menu_role` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_menu_role` AS select `a`.`user_id` AS `user_id`,`a`.`username` AS `username`,`a`.`user_status` AS `user_status`,`a`.`user_location` AS `user_location`,`b`.`acl_id` AS `acl_id`,`b`.`fk_role_pid` AS `fk_role_pid`,`b`.`fk_user_id` AS `fk_user_id`,`b`.`acl_status` AS `acl_status`,`c`.`role_id` AS `role_id`,`c`.`role_desc` AS `role_desc`,`c`.`role_status` AS `role_status`,`c`.`fk_app_pid` AS `fk_app_pid`,`d`.`role_matrix_id` AS `role_matrix_id`,`d`.`fk_role_id` AS `fk_role_id`,`d`.`fk_menu_matrix_id` AS `fk_menu_matrix_id`,`d`.`role_matrix_desc` AS `role_matrix_desc`,`d`.`role_matrix_status` AS `role_matrix_status`,`e`.`matrix_pid` AS `matrix_pid`,`e`.`fk_menu_pid` AS `fk_menu_pid`,`e`.`fk_fn_id` AS `fk_fn_id`,`e`.`matrix_status` AS `matrix_status`,`e`.`matrix_purpose` AS `matrix_purpose`,`e`.`matrix_remarks` AS `matrix_remarks`,`f`.`fn_id` AS `fn_id`,`f`.`fn_name` AS `fn_name`,`f`.`fn_purpose` AS `fn_purpose`,`f`.`fn_status` AS `fn_status`,`f`.`fn_remarks` AS `fn_remarks`,`g`.`menu_pid` AS `menu_pid`,`g`.`page_id` AS `page_id`,`g`.`fk_group_id` AS `fk_group_id`,`g`.`fk_app_id` AS `fk_app_id`,`g`.`parent_id` AS `parent_id`,`g`.`link_type` AS `link_type`,`g`.`link_status` AS `link_status`,`g`.`link_visibility` AS `link_visibility`,`g`.`link_location` AS `link_location`,`g`.`link_description` AS `link_description`,`g`.`link_tool_tip` AS `link_tool_tip`,`g`.`link_cmd` AS `link_cmd`,`h`.`group_id` AS `group_id`,`h`.`group_status` AS `group_status`,`h`.`group_purpose` AS `group_purpose`,`i`.`app_id` AS `app_id`,`i`.`app_name` AS `app_name`,`i`.`app_description` AS `app_description`,`i`.`app_purpose` AS `app_purpose`,`i`.`app_owner` AS `app_owner`,`i`.`app_point_person` AS `app_point_person`,`i`.`app_status` AS `app_status`,`i`.`app_start_date` AS `app_start_date`,`i`.`app_last_revision` AS `app_last_revision`,`i`.`app_remarks` AS `app_remarks` from ((((((((`tbl_user_list` `a` join `tbl_user_acl_list_role` `b` on(((`a`.`user_id` = `b`.`fk_user_id`) and (`a`.`user_status` = 1) and (`b`.`acl_status` = 1)))) join `tbl_role_list` `c` on(((`b`.`fk_role_pid` = `c`.`role_id`) and (`c`.`role_status` = 1)))) join `tbl_role_matrix` `d` on(((`b`.`fk_role_pid` = `d`.`fk_role_id`) and (`d`.`role_matrix_status` = 1)))) join `tbl_menu_matrix` `e` on(((`d`.`fk_menu_matrix_id` = `e`.`matrix_pid`) and (`e`.`matrix_status` = 1)))) join `tbl_function_list` `f` on(((`e`.`fk_fn_id` = `f`.`fn_id`) and (`f`.`fn_status` = 1)))) join `tbl_menu_list` `g` on(((`e`.`fk_menu_pid` = `g`.`menu_pid`) and (`g`.`link_status` = 1)))) join `tbl_group_list` `h` on(((`g`.`fk_group_id` = `h`.`group_id`) and (`h`.`group_status` = 1)))) join `tbl_application_list` `i` on(((`g`.`fk_app_id` = `i`.`app_id`) and (`i`.`app_status` = 1)))) order by `a`.`user_id`,`c`.`role_id` */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
