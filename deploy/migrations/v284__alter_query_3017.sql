/*#3017 alter query */


USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES('1680','SFCS_0333', '8', '5', '29', '1', '1', '1', '/sfcs_app/app/production/reports/kpi/hourly_production_new.php', 'Hourly Production Report New', '', '');
INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid,menu_description,roll_id) VALUES('1680', "Hourly Production Report New", "1");

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES ("1681", 'SFCS_0334', '8', '5', '29', '1', '1', '1', '/sfcs_app/app/production/reports/kpi/hourly_production_v1_new.php', 'Hourly Production Report - Section Wise New', '', '');
INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid,menu_description,roll_id) VALUES("1681", "Hourly Production Report - Section Wise New", "1");


USE bai_pro2;

CREATE TABLE pps.hout2 (
id int(11) NOT NULL AUTO_INCREMENT,
out_date varchar(45) DEFAULT NULL,
out_time varchar(45) DEFAULT NULL,
team varchar(45) DEFAULT NULL,
qty varchar(25) DEFAULT NULL,
status varchar(25) DEFAULT NULL,
remarks text DEFAULT NULL,
rep_start_time time DEFAULT NULL,
rep_end_time time DEFAULT NULL,
time_parent_id int(11) DEFAULT NULL,
style varchar(20) DEFAULT NULL,
color varchar(225) DEFAULT NULL,
smv decimal(10,4) DEFAULT NULL,
bcd_id int(15) DEFAULT NULL,
PRIMARY KEY(id),
KEY ind_team_out_date(out_date,team),
KEY hout_out_date_team(out_date,team,time_parent_id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;