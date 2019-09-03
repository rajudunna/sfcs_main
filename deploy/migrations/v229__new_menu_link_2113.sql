/*#2113 new_menu_link*/


USE bai_pro3;

ALTER TABLE bai_pro3.m3_transactions ADD KEY response_trail_count
(response_status, m3_trail_count);

USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list
    (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd)
VALUES('1663','SFCS_0002', '8', '4', '1592', '1', '1', '1', '/sfcs_app/app/production/reports/m3_transcations_reconfirm_report.php', 'M3 Transactions Reconfirm Report', '', '');

INSERT INTO central_administration_sfcs.rbac_role_menu
    (menu_pid, menu_description, roll_id)
VALUES
    ('1663','M3 Transactions Reconfirm Report', '1');