/*#2132 Packing method update*/

USE `bai_pro3`;

CREATE TABLE  `bai_pro3`.`carton_packing_details`
(
  `id` INT
(11) NOT NULL AUTO_INCREMENT,
  `carton_id` VARCHAR
(20) DEFAULT NULL,
  `pack_code` VARCHAR
(20) DEFAULT NULL,
  `pack_desc` VARCHAR
(200) DEFAULT NULL,
  `pack_smv` FLOAT NULL,
  `pack_team` VARCHAR
(20) NULL,
  `scan_time` TIMESTAMP,
  PRIMARY KEY
(`id`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

USE `brandix_bts`;

CREATE TABLE `mdm`.`packing_method_master`
(
  `id` INT
(11) NOT NULL AUTO_INCREMENT,
  `packing_method_code` VARCHAR
(20) DEFAULT NULL,
  `packing_description` VARCHAR
(200) DEFAULT NULL,
  `smv` FLOAT DEFAULT NULL,
  `status` ENUM
('Active','In-Active') DEFAULT 'Active',
  PRIMARY KEY
(`id`)
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


CREATE TABLE  `brandix_bts`.`packing_team_master`
(
  `id` INT
(11) NOT NULL AUTO_INCREMENT,
  `packing_team` VARCHAR
(20) DEFAULT NULL,
  `team_leader` VARCHAR
(20) DEFAULT NULL,
  `status` ENUM
('Active','In-Active') DEFAULT 'Active',
  PRIMARY KEY
(`id`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1; 

USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list
    (menu_pid,page_id,fk_group_id,fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description,link_tool_tip, link_cmd)
VALUES('1661','SFCS_0189','8','8', '1548', '1', '1', '1', '/sfcs_app/app/masters/packing_method/create_packing.php', 'Packing Methods Master', '8', '');

INSERT INTO central_administration_sfcs.rbac_role_menu
    (menu_pid, menu_description, roll_id)
VALUES
    ('1661', 'Packing Methods Master', '1');


INSERT INTO central_administration_sfcs.tbl_menu_list
    (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description,link_tool_tip, link_cmd)
VALUES('1662', 'SFCS_0189', '8', '8', '1548', '1', '1', '1', '/sfcs_app/app/masters/packing_team/create_team.php', 'Packing Team Master', '8', '');

INSERT INTO central_administration_sfcs.rbac_role_menu
    (menu_pid, menu_description, roll_id)
VALUES
    ('1662', 'Packing Team Master', '1');
