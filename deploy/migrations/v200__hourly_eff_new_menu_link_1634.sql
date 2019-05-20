USE central_administration_sfcs;

insert into central_administration_sfcs.tbl_menu_list
    (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd)
values('1653', 'SFCS_9024', '8', '8', '70', '1', '1', '1', '/sfcs_app/app/production/reports/pop_hourly_eff_new.php', 'Hourly Efficiency New Report', '', '');

INSERT INTO central_administration_sfcs.rbac_role_menu
    (menu_pid,menu_description,roll_id)
VALUES
    ('1653', 'Hourly Efficiency NEW Report', 1);