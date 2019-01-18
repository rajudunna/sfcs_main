/*1292*/
CREATE TABLE bai_pro3.ips_job_transfer( id INT(11) NOT NULL AUTO_INCREMENT, job_no INT(20), module INT(20),transfered_module INT(10), user VARCHAR(20), PRIMARY KEY (id) ) ENGINE=INNODB DEFAULT CHARSET=latin1; 

insert into central_administration_sfcs.tbl_menu_list ( `menu_pid`,`page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) values('1622','SFCS_0557','8','1','157','1','1','1','/sfcs_app/app/planning/controllers/ips_transfer_main.php','IPS Job Transfer','','');

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1622', 'IPS Job Transfer', '1');