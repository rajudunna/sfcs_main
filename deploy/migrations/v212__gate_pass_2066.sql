/*#2066 gate pass generation*/

USE `brandix_bts`;

CREATE TABLE `brandix_bts`.`gatepass_table`
(
 `id` INT
(23) NOT NULL AUTO_INCREMENT,
 `shift` VARCHAR
(11) DEFAULT NULL,
 `operation` VARCHAR
(225) DEFAULT NULL,
 `vehicle_no` VARCHAR
(225) DEFAULT NULL,
 `gatepass_status` INT
(11) DEFAULT NULL,
 `date` DATE DEFAULT NULL,
`username` VARCHAR
(25) DEFAULT NULL,
 PRIMARY KEY
(`id`),
 KEY `id`
(`id`)
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


CREATE TABLE `brandix_bts`.`gatepass_track`
(
 `id` INT
(23) NOT NULL AUTO_INCREMENT,
 `gate_id` INT
(23) DEFAULT NULL,
 `bundle_no` INT
(11) DEFAULT NULL,
 `bundle_qty` INT
(10) DEFAULT NULL,
 `style` VARCHAR
(225) DEFAULT NULL,
 `schedule` VARCHAR
(225) DEFAULT NULL,
 `color` VARCHAR
(225) DEFAULT NULL,
 `size` VARCHAR
(11) DEFAULT NULL,
 `operation_id` VARCHAR
(11) DEFAULT NULL,
 KEY `id`
(`id`),
 KEY `gate_id`
(`gate_id`)
) ENGINE=INNODB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

USE `central_administration_sfcs`;


INSERT INTO 
central_administration_sfcs.tbl_menu_list

(menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES
('1656','SFCS_0007','8','8','108','0','1','1','','Gatepass System','16','');


INSERT INTO 
central_administration_sfcs.tbl_menu_list

    (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd)
VALUES
    ('1657', 'SFCS_0008', '8', '8', '1656', '1', '1', '1', '/sfcs_app
/app/production/controllers/gatepass.php', 'Gatepass Generation', '', '');



INSERT INTO central_administration_sfcs.rbac_role_menu
    (menu_pid, menu_description, roll_id)
VALUES
    ('1657','Gatepass Generation', '1');

    INSERT INTO 
central_administration_sfcs.tbl_menu_list

    (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd)
VALUES
    ('1658', 'SFCS_0009', '8', '8', '1656', '1', '1', '1', '/sfcs_app
/app/production/controllers/gatepass_summery_detail.php', 'Day wise Gatepass
Details', '2', '');


INSERT INTO central_administration_sfcs.rbac_role_menu
    (menu_pid, menu_description, roll_id)
VALUES
    ('1658',
        'Day wise Gatepass Details', '1');