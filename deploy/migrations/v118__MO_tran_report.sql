USE brandix_bts;
ALTER TABLE bundle_creation_data ADD COLUMN cancel_qty INT(10);

USE central_administration_sfcs;
INSERT INTO tbl_menu_list(page_id, fk_group_id, fk_app_id, parent_id, link_type, link_visibility, link_location, link_description)
  VALUES ('SFCS_0555', '8', '8', '70', '1', '1', '/sfcs_app/app/production/reports/mo_transaction.php', 'Mo Transaction report');

INSERT INTO rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1609', 'Mo Transaction report', '1');