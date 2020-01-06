/*#1626 alter table*/

USE bai_pro3;

CREATE TABLE bai_pro3.short_shipment_job_track
(
  id int
(11) NOT NULL AUTO_INCREMENT,
  date_time timestamp NOT NULL DEFAULT current_timestamp
(),
  style varchar
(30) NOT NULL,
  schedule varchar
(30) NOT NULL,
  remove_type enum
('0','1','2') NOT NULL DEFAULT '0' COMMENT '''0'' default, ''1'' temporary, ''2'' permanent',
  remove_reason longtext DEFAULT NULL,
  removed_by varchar
(30) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  updated_by varchar
(30) DEFAULT NULL,
  remarks varchar
(50) DEFAULT NULL,
  PRIMARY KEY
(id),
  KEY style_sch
(style,schedule)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;


ALTER TABLE bai_pro3.cutting_table_plan
ADD COLUMN short_shipment_status INT DEFAULT 0 NOT NULL AFTER log_time;


ALTER TABLE bai_pro3.rejections_log
ADD COLUMN short_shipment_status INT DEFAULT 0 NOT NULL AFTER status;

ALTER TABLE bai_pro3.recut_v2
ADD COLUMN short_shipment_status INT DEFAULT 0 NOT NULL AFTER log_update;

ALTER TABLE bai_pro3.embellishment_plan_dashboard CHANGE track_id track_id INT
(11) NOT NULL AUTO_INCREMENT COMMENT 'Tracing Id\r\n',
ADD COLUMN short_shipment_status INT DEFAULT 0 NOT NULL AFTER receive_qty;



CREATE TABLE bai_pro3.deleted_shipment_jobs
( id INT
(11) NOT NULL, style VARCHAR
(50), schedule VARCHAR
(50), removing_type VARCHAR
(50), reason TEXT
(150), PRIMARY KEY
(id) );

ALTER TABLE bai_pro3.plan_dashboard_input
ADD COLUMN shipment_remove_status INT DEFAULT 0 NULL AFTER input_trims_request_time;

ALTER TABLE bai_pro3.plan_dashboard_input_backup
ADD COLUMN shipment_remove_status INT DEFAULT 0 NULL AFTER input_trims_request_time;

ALTER TABLE bai_pro3.ims_log
ADD COLUMN shipment_remove_status INT DEFAULT 0 NULL AFTER operation_id;

ALTER TABLE bai_pro3.ims_log_backup
ADD COLUMN shipment_remove_status INT DEFAULT 0 NULL AFTER operation_id;

ALTER TABLE bai_pro3.ims_log CHANGE shipment_remove_status short_shipment_status INT
(11) DEFAULT 0 NULL;

ALTER TABLE bai_pro3.ims_log_backup CHANGE shipment_remove_status short_shipment_status INT
(11) DEFAULT 0 NULL;

ALTER TABLE bai_pro3.plan_dashboard_input CHANGE shipment_remove_status short_shipment_status INT
(11) DEFAULT 0 NULL;

ALTER TABLE bai_pro3.plan_dashboard_input_backup CHANGE shipment_remove_status short_shipment_status INT
(11) DEFAULT 0 NULL;


ALTER TABLE bai_pro3.ims_log_backup
ADD KEY job_rand_ims_status
(ims_status, input_job_rand_no_ref);


ALTER TABLE bai_pro3.plan_dashboard_input_backup
ADD KEY short_shipment
(input_job_no_random_ref, short_shipment_status);

ALTER TABLE bai_pro3.plan_dashboard_input
ADD KEY short_shipment
(input_job_no_random_ref, short_shipment_status);

ALTER TABLE bai_pro3.ims_log_backup
ADD KEY short_shipment
(input_job_rand_no_ref, short_shipment_status);

ALTER TABLE bai_pro3.ims_log
ADD KEY short_shipment
(input_job_rand_no_ref, short_shipment_status);

ALTER TABLE bai_pro3.cutting_table_plan
ADD KEY short_shipment
(doc_no, short_shipment_status);

ALTER TABLE bai_pro3.recut_v2
ADD KEY short_shipment
(doc_no, short_shipment_status);

ALTER TABLE bai_pro3.rejections_log
ADD KEY short_shipment
(style, schedule, short_shipment_status);

USE brandix_bts;

ALTER TABLE brandix_bts.bundle_creation_data
ADD KEY style_sch_qty_status
(style, schedule, bundle_qty_status);

USE central_administration_sfcs;

INSERT INTO 
central_administration_sfcs.tbl_menu_list

(menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES
('1665','SFCS_0559', '8', '1', '157', '1', '1', '1', '/sfcs_app/app/planning/controllers/remove_shortshipment_jobs/remove_jobs.php', 'Remove Short Shipment Jobs', '', '');



INSERT INTO 
central_administration_sfcs.rbac_role_menu

(menu_pid, menu_description, roll_id) VALUES
('1665', 'Remove Short Shipment Jobs', '1');

INSERT INTO 
central_administration_sfcs.tbl_menu_list

(menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES
('1666','SFCS_0039', '8', '1', '49', '1', '1', '1', '/sfcs_app/app/planning/reports/shortshipment_report.php', 'Short Shipment Job Report', '', '');


INSERT INTO 
central_administration_sfcs.rbac_role_menu

(menu_pid, menu_description, roll_id) VALUES
('1666', 'Short Shipment Job Report', '1');