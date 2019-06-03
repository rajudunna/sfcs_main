/*#1958 New table New menu*/
USE bai_pro3;
CREATE TABLE bai_pro3.recut_v2_child_issue_track
(
    recut_id INT(11),
    bcd_id INT(11),
    issued_qty INT(11),
    status INT(11)
);

USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list
    (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd)
VALUES
    ('1654', 'SFCS_9010', '8', '8', '1487', '1', '1', '1', '/sfcs_app/app/production/controllers/sewing_job/recut_prints/recut_bundletag_print.php', 'Bundle Prints for Recut', '1', '');

INSERT INTO central_administration_sfcs.rbac_role_menu
    (menu_pid,menu_description,roll_id)
VALUES
    ('1654', 'Bundle Prints
for Recut', 1);