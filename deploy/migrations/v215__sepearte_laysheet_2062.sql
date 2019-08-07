/*#2062 sepearte_laysheet for binding*/


USE `bai_pro3`;

CREATE TABLE `bai_pro3`.`binding_consumption`
(
 `id` int
(11) NOT NULL AUTO_INCREMENT,
 `date_time` timestamp NULL DEFAULT current_timestamp
(),
 `style` varchar
(100) DEFAULT NULL,
 `schedule` varchar
(100) DEFAULT NULL,
 `color` varchar
(100) DEFAULT NULL,
 `tot_req_qty` decimal
(10,2) DEFAULT NULL,
 `tot_bindreq_qty` decimal
(10,2) DEFAULT NULL,
 `status` enum
('Open','Allocated','Close') DEFAULT NULL,
 `status_at` datetime DEFAULT NULL,
 PRIMARY KEY
(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

CREATE TABLE `bai_pro3`.`binding_consumption_items`
(
 `id` int
(11) NOT NULL AUTO_INCREMENT,
 `parent_id` int
(11) DEFAULT NULL,
 `compo_no` varchar
(100) DEFAULT NULL,
 `category` varchar
(100) DEFAULT NULL,
 `cutno` varchar
(100) DEFAULT NULL,
 `req_qty` decimal
(10,2) DEFAULT NULL,
 `bind_category` varchar
(100) DEFAULT NULL,
 `bind_req_qty` decimal
(10,2) DEFAULT NULL,
 `doc_no` int
(50) DEFAULT NULL,
 PRIMARY KEY
(`id`),
 KEY `parent_id`
(`parent_id`),
 CONSTRAINT `binding_consumption_items_ibfk_1` FOREIGN KEY
(`parent_id`) REFERENCES `binding_consumption`
(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;


ALTER TABLE `bai_pro3`.`cat_stat_log`
ADD COLUMN `seperate_docket` VARCHAR
(10) DEFAULT 'No' NULL AFTER `clubbing`;

USE `bai_rm_pj1`;
ALTER TABLE `bai_rm_pj1`.`fabric_cad_allocation` CHANGE `doc_no` `doc_no` VARCHAR
(30) NULL COMMENT 'Cut Docket No';

USE `central_administration_sfcs`;

INSERT INTO central_administration_sfcs.tbl_menu_list
    ( `menu_pid`,`page_id
`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) VALUES
('1659','SFCS_0189','8','8','179','1','1','1','/sfcs_app/app/cutting/controllers/seperate_docket.php','Binding Allocation Form','8','');

INSERT INTO central_administration_sfcs.rbac_role_menu
    (menu_pid, menu_description, roll_id)
VALUES
    ('1659', 'Binding Allocation Form', '1');

INSERT INTO central_administration_sfcs.tbl_menu_list
    (`menu_pid`,`page_id
`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) VALUES
('1660','SFCS_0190','8','8','109','1','1','1','/sfcs_app/app/cutting/controllers/lay_plan_preparation/binding_report.php','Binding Request Form','9','');

INSERT INTO central_administration_sfcs.rbac_role_menu
    (menu_pid, menu_description, roll_id)
VALUES
    ('1660', 'Binding Request Form', '1');