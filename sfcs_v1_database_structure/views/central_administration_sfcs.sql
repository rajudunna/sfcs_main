/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16 : Database - central_administration_sfcs
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`central_administration_sfcs` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `central_administration_sfcs`;

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
 `link_location` varchar(150) ,
 `link_description` varchar(150) ,
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
 `user_status` varchar(5) ,
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
 `link_location` varchar(150) ,
 `link_description` varchar(150) ,
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

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`baiall`@`%` SQL SECURITY DEFINER VIEW `veiw_menu_matrix` AS select `a`.`matrix_pid` AS `matrix_pid`,`a`.`fk_menu_pid` AS `fk_menu_pid`,`a`.`fk_fn_id` AS `fk_fn_id`,`a`.`matrix_status` AS `matrix_status`,`a`.`matrix_purpose` AS `matrix_purpose`,`a`.`matrix_remarks` AS `matrix_remarks`,`b`.`menu_pid` AS `menu_pid`,`b`.`page_id` AS `page_id`,`b`.`fk_group_id` AS `fk_group_id`,`b`.`fk_app_id` AS `fk_app_id`,`b`.`parent_id` AS `parent_id`,`b`.`link_type` AS `link_type`,`b`.`link_status` AS `link_status`,`b`.`link_visibility` AS `link_visibility`,`b`.`link_location` AS `link_location`,`b`.`link_description` AS `link_description`,`b`.`link_tool_tip` AS `link_tool_tip`,`b`.`link_cmd` AS `link_cmd`,`c`.`fn_id` AS `fn_id`,`c`.`fn_name` AS `fn_name`,`c`.`fn_purpose` AS `fn_purpose`,`c`.`fn_status` AS `fn_status`,`c`.`fn_remarks` AS `fn_remarks`,`d`.`app_id` AS `app_id`,`d`.`app_name` AS `app_name`,`d`.`app_description` AS `app_description`,`d`.`app_purpose` AS `app_purpose`,`d`.`app_owner` AS `app_owner`,`d`.`app_point_person` AS `app_point_person`,`d`.`app_status` AS `app_status`,`d`.`app_start_date` AS `app_start_date`,`d`.`app_last_revision` AS `app_last_revision`,`d`.`app_remarks` AS `app_remarks`,`e`.`group_id` AS `group_id`,`e`.`group_status` AS `group_status`,`e`.`group_purpose` AS `group_purpose` from ((((`tbl_menu_matrix` `a` join `tbl_menu_list` `b` on((`a`.`fk_menu_pid` = `b`.`menu_pid`))) join `tbl_function_list` `c` on((`a`.`fk_fn_id` = `c`.`fn_id`))) join `tbl_application_list` `d` on((`b`.`fk_app_id` = `d`.`app_id`))) join `tbl_group_list` `e` on((`b`.`fk_group_id` = `e`.`group_id`))) */;

/*View structure for view view_menu */

/*!50001 DROP TABLE IF EXISTS `view_menu` */;
/*!50001 DROP VIEW IF EXISTS `view_menu` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`baiall`@`%` SQL SECURITY DEFINER VIEW `view_menu` AS select `a`.`user_id` AS `user_id`,`a`.`username` AS `user_name`,`a`.`user_status` AS `user_status`,`a`.`user_location` AS `user_location`,`b`.`acl_id` AS `acl_id`,`b`.`fk_matrix_pid` AS `fk_matrix_pid`,`b`.`fk_user_id` AS `fk_user_id`,`b`.`acl_status` AS `acl_status`,`c`.`matrix_pid` AS `matrix_pid`,`c`.`fk_menu_pid` AS `fk_menu_pid`,`c`.`fk_fn_id` AS `fk_fn_id`,`c`.`matrix_status` AS `matrix_status`,`c`.`matrix_purpose` AS `matrix_purpose`,`c`.`matrix_remarks` AS `matrix_remarks`,`d`.`fn_id` AS `fn_id`,`d`.`fn_name` AS `fn_name`,`d`.`fn_purpose` AS `fn_purpose`,`d`.`fn_status` AS `fn_status`,`d`.`fn_remarks` AS `fn_remarks`,`e`.`menu_pid` AS `menu_pid`,`e`.`page_id` AS `page_id`,`e`.`fk_group_id` AS `fk_group_id`,`e`.`fk_app_id` AS `fk_app_id`,`e`.`parent_id` AS `parent_id`,`e`.`link_type` AS `link_type`,`e`.`link_status` AS `link_status`,`e`.`link_visibility` AS `link_visibility`,`e`.`link_location` AS `link_location`,`e`.`link_description` AS `link_description`,`e`.`link_tool_tip` AS `link_tool_tip`,`e`.`link_cmd` AS `link_cmd`,`f`.`group_id` AS `group_id`,`f`.`group_status` AS `group_status`,`f`.`group_purpose` AS `group_purpose`,`h`.`app_id` AS `app_id`,`h`.`app_name` AS `app_name`,`h`.`app_description` AS `app_description`,`h`.`app_purpose` AS `app_purpose`,`h`.`app_owner` AS `app_owner`,`h`.`app_point_person` AS `app_point_person`,`h`.`app_status` AS `app_status`,`h`.`app_start_date` AS `app_start_date`,`h`.`app_last_revision` AS `app_last_revision`,`h`.`app_remarks` AS `app_remarks` from ((((((`tbl_user_list` `a` join `tbl_user_acl_list` `b` on(((`a`.`user_id` = `b`.`fk_user_id`) and (`a`.`user_status` = 1) and (`b`.`acl_status` = 1)))) join `tbl_menu_matrix` `c` on(((`b`.`fk_matrix_pid` = `c`.`matrix_pid`) and (`c`.`matrix_status` = 1)))) join `tbl_function_list` `d` on(((`c`.`fk_fn_id` = `d`.`fn_id`) and (`d`.`fn_status` = 1)))) join `tbl_menu_list` `e` on(((`c`.`fk_menu_pid` = `e`.`menu_pid`) and (`e`.`link_status` = 1)))) join `tbl_group_list` `f` on(((`e`.`fk_group_id` = `f`.`group_id`) and (`f`.`group_status` = 1)))) join `tbl_application_list` `h` on(((`e`.`fk_app_id` = `h`.`app_id`) and (`h`.`app_status` = 1)))) order by `a`.`user_id`,`c`.`matrix_pid` */;

/*View structure for view view_menu_role */

/*!50001 DROP TABLE IF EXISTS `view_menu_role` */;
/*!50001 DROP VIEW IF EXISTS `view_menu_role` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`baiall`@`%` SQL SECURITY DEFINER VIEW `view_menu_role` AS select `a`.`user_id` AS `user_id`,`a`.`username` AS `username`,`a`.`user_status` AS `user_status`,`a`.`user_location` AS `user_location`,`b`.`acl_id` AS `acl_id`,`b`.`fk_role_pid` AS `fk_role_pid`,`b`.`fk_user_id` AS `fk_user_id`,`b`.`acl_status` AS `acl_status`,`c`.`role_id` AS `role_id`,`c`.`role_desc` AS `role_desc`,`c`.`role_status` AS `role_status`,`c`.`fk_app_pid` AS `fk_app_pid`,`d`.`role_matrix_id` AS `role_matrix_id`,`d`.`fk_role_id` AS `fk_role_id`,`d`.`fk_menu_matrix_id` AS `fk_menu_matrix_id`,`d`.`role_matrix_desc` AS `role_matrix_desc`,`d`.`role_matrix_status` AS `role_matrix_status`,`e`.`matrix_pid` AS `matrix_pid`,`e`.`fk_menu_pid` AS `fk_menu_pid`,`e`.`fk_fn_id` AS `fk_fn_id`,`e`.`matrix_status` AS `matrix_status`,`e`.`matrix_purpose` AS `matrix_purpose`,`e`.`matrix_remarks` AS `matrix_remarks`,`f`.`fn_id` AS `fn_id`,`f`.`fn_name` AS `fn_name`,`f`.`fn_purpose` AS `fn_purpose`,`f`.`fn_status` AS `fn_status`,`f`.`fn_remarks` AS `fn_remarks`,`g`.`menu_pid` AS `menu_pid`,`g`.`page_id` AS `page_id`,`g`.`fk_group_id` AS `fk_group_id`,`g`.`fk_app_id` AS `fk_app_id`,`g`.`parent_id` AS `parent_id`,`g`.`link_type` AS `link_type`,`g`.`link_status` AS `link_status`,`g`.`link_visibility` AS `link_visibility`,`g`.`link_location` AS `link_location`,`g`.`link_description` AS `link_description`,`g`.`link_tool_tip` AS `link_tool_tip`,`g`.`link_cmd` AS `link_cmd`,`h`.`group_id` AS `group_id`,`h`.`group_status` AS `group_status`,`h`.`group_purpose` AS `group_purpose`,`i`.`app_id` AS `app_id`,`i`.`app_name` AS `app_name`,`i`.`app_description` AS `app_description`,`i`.`app_purpose` AS `app_purpose`,`i`.`app_owner` AS `app_owner`,`i`.`app_point_person` AS `app_point_person`,`i`.`app_status` AS `app_status`,`i`.`app_start_date` AS `app_start_date`,`i`.`app_last_revision` AS `app_last_revision`,`i`.`app_remarks` AS `app_remarks` from ((((((((`central_administration`.`tbl_user_list` `a` join `central_administration`.`tbl_user_acl_list_role` `b` on(((`a`.`user_id` = `b`.`fk_user_id`) and (`a`.`user_status` = 1) and (`b`.`acl_status` = 1)))) join `central_administration`.`tbl_role_list` `c` on(((`b`.`fk_role_pid` = `c`.`role_id`) and (`c`.`role_status` = 1)))) join `central_administration`.`tbl_role_matrix` `d` on(((`b`.`fk_role_pid` = `d`.`fk_role_id`) and (`d`.`role_matrix_status` = 1)))) join `central_administration`.`tbl_menu_matrix` `e` on(((`d`.`fk_menu_matrix_id` = `e`.`matrix_pid`) and (`e`.`matrix_status` = 1)))) join `central_administration`.`tbl_function_list` `f` on(((`e`.`fk_fn_id` = `f`.`fn_id`) and (`f`.`fn_status` = 1)))) join `central_administration`.`tbl_menu_list` `g` on(((`e`.`fk_menu_pid` = `g`.`menu_pid`) and (`g`.`link_status` = 1)))) join `central_administration`.`tbl_group_list` `h` on(((`g`.`fk_group_id` = `h`.`group_id`) and (`h`.`group_status` = 1)))) join `central_administration`.`tbl_application_list` `i` on(((`g`.`fk_app_id` = `i`.`app_id`) and (`i`.`app_status` = 1)))) order by `a`.`user_id`,`c`.`role_id` */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
