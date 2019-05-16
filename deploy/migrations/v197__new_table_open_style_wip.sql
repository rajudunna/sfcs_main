/*#1840 Alter table*/

USE brandix_bts;

CREATE TABLE brandix_bts.open_style_wip
(
    sno INT(11) NOT NULL
    AUTO_INCREMENT, style VARCHAR
    (255), schedule VARCHAR
    (255), color VARCHAR
    (255), size VARCHAR
    (11), operation_code INT
    (11), good_qty INT
    (11), rejected_qty INT
    (11), status VARCHAR
    (11), created_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_time DATETIME, PRIMARY KEY
    (sno) ) ENGINE=INNODB CHARSET=latin1 COLLATE=latin1_swedish_ci;

    ALTER TABLE brandix_bts.open_style_wip ADD KEY wip
    (style, schedule, color, operation_code, size);

    ALTER TABLE brandix_bts.bundle_creation_data_temp ADD KEY wip
    ( style, schedule, color, size_title, operation_id);



    INSERT INTO central_administration_sfcs.tbl_menu_list
        (page_id, fk_group_id, fk_app_id, parent_id, link_type, link_visibility, link_location, link_description, link_tool_tip, link_cmd)
    VALUES
        ('SFCS_9023', '8', '1', '49', '1', '1', '/sfcs_app/app/production/reports/open_style_wip_report/index.html', 'Open Style Wip Report', '1', 'Open Style Wip Report');

    INSERT INTO central_administration_sfcs.rbac_role_menu
        (menu_pid, menu_description, roll_id)
    VALUES
        ('1652', 'Open Style Wip Report', '1');