/*#2419 adding menus*/
/*this is commented after added these queries in v251__new_tables_2483*/


/*
USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list
    (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd)
VALUES('1667', 'SFCS_9023', '8', '8', '1487', '1', '1','1', '/sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/bundle_transfer.php', 'Bundle Transfer Barcode Scanning', '16', '');

INSERT INTO central_administration_sfcs.rbac_role_menu
    (menu_pid, menu_description, roll_id)
VALUES
    ('1667',
'Bundle Transfer Barcode Scanning', '1');


USE bai_pro3;

ALTER TABLE `bai_pro3`.`ims_log`
ADD KEY `pac_tid`
(`pac_tid`, `operation_id`);


USE brandix_bts;

CREATE TABLE brandix_bts.`module_transfer_track`
(
 `id` INT
(10) NOT NULL AUTO_INCREMENT,
 `username` VARCHAR
(150) DEFAULT NULL,
 `bundle_number` INT
(50) DEFAULT NULL,
 `operation_code` INT
(20) DEFAULT NULL,
 `from_module` VARCHAR
(90) DEFAULT NULL,
 `to_module` VARCHAR
(90) DEFAULT NULL,
 `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
() ON
UPDATE CURRENT_TIMESTAMP(),
 PRIMARY KEY
(`id`)
);


DROP INDEX IF EXISTS barcode_number
ON `brandix_bts`.`bundle_creation_data`;

ALTER TABLE `brandix_bts`.`bundle_creation_data`
ADD KEY `barcode`
(`barcode_number`);
*/