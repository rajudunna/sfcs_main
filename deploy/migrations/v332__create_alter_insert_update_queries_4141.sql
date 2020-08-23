/*#4141 Create, Alter, Insert, Update Queries*/

-- INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_visibility,link_location,link_description) VALUES ('1685', 'SFCS_1684', '8', '8', '70', '1', '1','/sfcs_app/app/production/reports/efficiency_report.php','Efficiency Report'); 

-- INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1685', 'Efficiency Report', '1');

ALTER TABLE bai_pro.pro_attendance  ADD COLUMN break_hours INT(10) NULL AFTER jumper;

ALTER TABLE bai_pro.pro_attendance ADD COLUMN last_up TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER break_hours;

CREATE TABLE bai_pro.pro_attendance_adjustment(
  DATE DATE,
  module VARCHAR(10),
  shift VARCHAR(13),
  smo INT(10),
  adjustment_type ENUM('Positive','Negative') NOT NULL DEFAULT 'Positive',
  smo_minutes INT(10),
  smo_adjustment_min INT(10),
  smo_adjustment_hours VARCHAR(50)
);

ALTER TABLE bai_pro.pro_attendance_adjustment ADD COLUMN id INT(11) NULL AUTO_INCREMENT FIRST, ADD KEY(id);

ALTER TABLE bai_pro.pro_attendance_adjustment ADD COLUMN last_up TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER smo_adjustment_hours;

UPDATE central_administration_sfcs.tbl_menu_list SET link_status = '0' WHERE link_description="Update Jumper Details";

UPDATE central_administration_sfcs.tbl_menu_list SET link_status = '0' WHERE link_description="Update Employee Attendance";