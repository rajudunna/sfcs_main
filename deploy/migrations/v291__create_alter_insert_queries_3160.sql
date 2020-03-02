/*#3160 create, alter, insert queries*/

CREATE TABLE `bai_pro3`.`job_deactive_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `input_date` datetime DEFAULT NULL,
  `style` varchar(30) DEFAULT NULL,
  `schedule` varchar(30) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `module_no` int(11) DEFAULT NULL,
  `input_job_no_random` varchar(100) DEFAULT NULL,
  `input_job_no` varchar(11) DEFAULT NULL,
  `input_qty` int(11) DEFAULT NULL,
  `out_qty` int(11) DEFAULT NULL,
  `rejected_qty` int(11) DEFAULT NULL,
  `wip` int(11) DEFAULT NULL,
  `remarks` varchar(20) DEFAULT NULL,
  `remove_type` varchar(20) DEFAULT NULL,
  `tran_user` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

ALTER TABLE `bai_pro3`.`job_deactive_log` ADD KEY `status` (`remove_type`); 
ALTER TABLE `bai_pro3`.`job_deactive_log` ADD KEY `schedule_job_status` (`schedule`, `input_job_no`, `remove_type`);
ALTER TABLE `bai_pro3`.`ims_log` ADD KEY `mod_stat_remarks` (`ims_mod_no`, `ims_status`, `ims_remarks`);

INSERT INTO central_administration_sfcs.tbl_menu_list(menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES('1683', 'SFCS_0559', '8', '1', '157', '1', '1', '1', '/sfcs_app/app/planning/controllers/deactivate_sewing_job/sewing_job_deactive.php', 'Deactivate Sewing Jobs', '', '');
INSERT INTO central_administration_sfcs.rbac_role_menu(menu_pid, menu_description, roll_id) VALUES('1683', 'Deactivate Sewing Jobs', '1');
