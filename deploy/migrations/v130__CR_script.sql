/* #1136 USE central_administration_sfcs;*/

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_visibility, link_location, link_description) VALUES ('1617','SFCS_0007', '8', '8', '193', '1', '1', '/sfcs_app/app/production/controllers/update_emp_details_v2.php','Update Employee Details');

INSERT INTO central_administration_sfcs.rbac_role_menu (`menu_pid`,`menu_description`, `roll_id`) VALUES ('1617','Update Employee Details','1');


INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_visibility, link_location, link_description) VALUES ('1618','SFCS_0008', '8', '8', '193', '1', '1', '/sfcs_app/app/production/controllers/update_jump_details_v2.php', 'Update Jumper Details');

INSERT INTO central_administration_sfcs.rbac_role_menu (`menu_pid`,`menu_description`, `roll_id`) VALUES ('1618','Update Jumper Details','1');

/* #1136 USE bai_pro;*/

CREATE TABLE bai_pro.pro_atten_hours( date DATE NOT NULL, shift VARCHAR(40) NOT NULL, start_time INT(11) NOT NULL, end_time INT(11) NOT NULL ); 


CREATE TABLE bai_pro.pro_attendance (
  date date NOT NULL,
  module varchar(10) NOT NULL,
  shift varchar(13) NOT NULL,
  present int(10) unsigned NOT NULL,s
  absent int(10) unsigned NOT NULL,
  jumper int(10) unsigned NOT NULL
)

/* #1136 USE bai_pro3;*/

INSERT INTO bai_pro3.tbl_plant_timings (time_value, time_display, day_part, start_time, end_time) VALUES('22','10-11','PM','22:15:00','22:14:59');

