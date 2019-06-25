/*#1963 New menu*/
USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list
    (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location,
    link_description, link_tool_tip, link_cmd)
VALUES
    ('1655', 'SFCS_9010', '8', '8', '70', '1', '1', '1',
        '/sfcs_app/app/production/controllers/open_bundle_report.php', 'Open Bundle Report', '1', '');

INSERT INTO central_administration_sfcs.rbac_role_menu
    (menu_pid, menu_description, roll_id)
VALUES
    ( '1655','Open Bundle Report', '1');