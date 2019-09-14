/*#2394 v231__new_menu_wip_dashboard_2394*/



USE central_administration_sfcs;


INSERT INTO central_administration_sfcs.tbl_menu_list
    (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd)
VALUES('1664', 'SFCS_9024', '8', '5', '508', '1', '1', '1', '/sfcs_app/app/dashboards/controllers/WIP_Dashboard/sewing_wip_dashboard.php', 'WIP Dashboard', '3', '');

INSERT INTO central_administration_sfcs.rbac_role_menu
    (menu_pid, menu_description, roll_id)
VALUES
    ('1664', 'WIP Dashboard', '1');

USE brandix_bts;

ALTER TABLE brandix_bts.bundle_creation_data ADD COLUMN `bundle_qty_status` INT
(10) DEFAULT 0 NOT NULL AFTER `replace_in`;

ALTER TABLE brandix_bts.bundle_creation_data_temp ADD COLUMN `bundle_qty_status` INT
(10) DEFAULT 0 NOT NULL AFTER `input_job_no_random_ref`;

ALTER TABLE brandix_bts.bundle_creation_data ADD KEY bcd_ix5
(operation_id, assigned_module, bundle_qty_status);