
/*USE brandix_bts;*/

CREATE TABLE brandix_bts.delete_log(`sno` INT(10) NOT NULL AUTO_INCREMENT, `date_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP, `user` VARCHAR(255) NOT NULL, `style` VARCHAR(255), `schedule` VARCHAR(255), `color` VARCHAR(255), PRIMARY KEY (`sno`) ) ENGINE=INNODB CHARSET=latin1 COLLATE=latin1_swedish_ci; 

/*USE central_administration_sfcs;*/

/* INSERT INTO central_administration_sfcs.tbl_menu_list (`menu_pid`, `page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) VALUES ('1608','SFCS_0555', '8', '4', '109', '1', '1', '/sfcs_app/app/cutting/controllers/wrong_order_details.php', 'Delete Order Details', '', ''); 

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1608', 'Delete Order Details', '1'); */