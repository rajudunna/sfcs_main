/*#3521 alter queries*/

ALTER TABLE bai_pro3.pac_stat ADD COLUMN opn_status INT(11) NULL AFTER carton_qty, ADD COLUMN carton_status VARCHAR(5) NULL AFTER opn_status;

ALTER TABLE brandix_bts.tbl_orders_ops_ref ADD COLUMN restriction VARCHAR(50);

INSERT INTO central_administration_sfcs.tbl_menu_list(menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES('1684', 'SFCS_9024', '8', '8', '1487', '1', '1', '1', '/sfcs_app/app/production/controllers/sewing_job/other_operations_scanning/pre_other_ops_scanning.php', 'Other Operations Scanning', '', '');

INSERT INTO central_administration_sfcs.rbac_role_menu(menu_pid, menu_description, roll_id) VALUES('1684', 'Other Operations Scanning', '1');

INSERT INTO central_administration_sfcs.tbl_menu_list(menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES('1684', 'SFCS_9025', '8', '8', '1487', '1', '1', '1', '/sfcs_app/app/production/controllers/sewing_job/other_operations_scanning/pre_other_ops_reversal.php', 'Other Operations Reversal', '', '');

INSERT INTO central_administration_sfcs.rbac_role_menu(menu_pid, menu_description, roll_id) VALUES('1684', 'Other Operations Reversal', '1');
