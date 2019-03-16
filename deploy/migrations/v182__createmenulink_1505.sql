
/*1505 new menu*/

INSERT INTO central_administration_sfcs.tbl_menu_list (
  page_id,
  fk_group_id,
  fk_app_id,
  parent_id,
  link_type,
  link_status,
  link_visibility,
  link_location,
  link_description,
  link_tool_tip,
  link_cmd
)
VALUES
  (
    'SFCS_00001',
    '8',
    '8',
    '70',
    '1',
    '1',
    '1',
    '/sfcs_app/app/production/reports/daily_performance/index.html',
    'Daily Performance Report',
    '3',
    '1'
  );

INSERT INTO central_administration_sfcs.rbac_role_menu (
  menu_pid,
  menu_description,
  roll_id
)
VALUES
  (
    (SELECT
      menu_pid
    FROM
      central_administration_sfcs.tbl_menu_list
    WHERE link_description = 'Daily Performance Report'),
    'Daily Performance Report',
    '1'
  );