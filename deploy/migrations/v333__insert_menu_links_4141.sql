DELETE FROM central_administration_sfcs.rbac_role_menu WHERE menu_description = "Efficiency Report";

DELETE FROM central_administration_sfcs.tbl_menu_list WHERE link_description = "Efficiency Report";

DELETE FROM central_administration_sfcs.rbac_role_menu WHERE menu_description = "Other Operations Reversal";

DELETE FROM central_administration_sfcs.tbl_menu_list WHERE link_description = "Other Operations Reversal";

DELETE FROM central_administration_sfcs.rbac_role_menu WHERE menu_description = "Other Operations Scanning";

DELETE FROM central_administration_sfcs.tbl_menu_list WHERE link_description = "Other Operations Scanning";

INSERT INTO central_administration_sfcs.tbl_menu_list(menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES('1684', 'SFCS_9024', '8', '8', '1487', '1', '1', '1', '/sfcs_app/app/production/controllers/sewing_job/other_operations_scanning/pre_other_ops_scanning.php', 'Other Operations Scanning', '', '');

INSERT INTO central_administration_sfcs.rbac_role_menu(menu_pid, menu_description, roll_id) VALUES('1684', 'Other Operations Scanning', '1');

INSERT INTO central_administration_sfcs.tbl_menu_list(menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES('1685', 'SFCS_9025', '8', '8', '1487', '1', '1', '1', '/sfcs_app/app/production/controllers/sewing_job/other_operations_scanning/pre_other_ops_reversal.php', 'Other Operations Reversal', '', '');

INSERT INTO central_administration_sfcs.rbac_role_menu(menu_pid, menu_description, roll_id) VALUES('1685', 'Other Operations Reversal', '1');

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES ('1686', 'SFCS_1684', '8', '8', '70', '1', '1', '1', '/sfcs_app/app/production/reports/efficiency_report.php','Efficiency Report', '', '');

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1686', 'Efficiency Report', '1');