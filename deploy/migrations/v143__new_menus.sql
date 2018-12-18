/*1145*/
INSERT INTO `central_administration_sfcs`.`tbl_menu_list` (`menu_pid`,`page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) VALUES ('1621', 'SFCS_0355', '8', '4', '109', '0', '1', '', 'Schedule Clubbing(Color Level)', '2', ''); 
UPDATE `central_administration_sfcs`.`tbl_menu_list` SET `parent_id` = '1621' WHERE `menu_pid` = '1462'; 
UPDATE `central_administration_sfcs`.`tbl_menu_list` SET `parent_id` = '1621' WHERE `menu_pid` = '1463'; 
UPDATE `central_administration_sfcs`.`tbl_menu_list` SET `parent_id` = '1621' WHERE `menu_pid` = '1520'; 


UPDATE `central_administration_sfcs`.`tbl_menu_list` SET `link_description` = 'Schedule Clubbing(Schedule Level)' WHERE `menu_pid` = '1558';
UPDATE `central_administration_sfcs`.`tbl_menu_list` SET `link_description` = 'Schedules Clubbing' WHERE `menu_pid` = '1559'; 
UPDATE `central_administration_sfcs`.`tbl_menu_list` SET `link_status` = '0' WHERE `menu_pid` = '1560'; 
UPDATE `central_administration_sfcs`.`tbl_menu_list` SET `link_description` = 'Schedules Clubbing Split' WHERE `menu_pid` = '1561';
UPDATE `central_administration_sfcs`.`tbl_menu_list` SET `link_description` = 'Schedules Clubbing Delete' WHERE `menu_pid` = '1562'; 