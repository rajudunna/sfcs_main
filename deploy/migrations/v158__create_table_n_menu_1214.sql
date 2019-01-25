/*1214 Alter queries*/
DROP TABLE `bai_pro2`.`tbl_mini_plant_master`; 
CREATE TABLE `bai_pro3`.`mini_plant_master`( `id` INT(11) NOT NULL AUTO_INCREMENT, `mini_plant_name` VARCHAR(255), PRIMARY KEY (`id`) ); 
ALTER TABLE `bai_pro3`.`module_master` ADD COLUMN `mini_plant_id` INT(11) NULL AFTER `label`;

INSERT INTO `central_administration_sfcs`.`tbl_menu_list` (`menu_pid`,`page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`) VALUES ('1636','SFCS_0553', '8', '8', '1548', '1', '1', '/sfcs_app/app/masters/mini_plant/mini_plant_master.php', 'Mini Plant Master', '12'); 
INSERT INTO `central_administration_sfcs`.`rbac_role_menu` (`menu_pid`, `menu_description`, `roll_id`) VALUES ('1636', 'Mini Plant Master', '1'); 
