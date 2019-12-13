/*#1077 alter index query */

USE central_administration_sfcs;

ALTER TABLE `central_administration_sfcs`.`rbac_role_menu_per` ADD KEY `permission_id` (`permission_id`);

ALTER TABLE `central_administration_sfcs`.`rbac_permission` ADD KEY `permission_name` (`permission_name`);

ALTER TABLE `central_administration_sfcs`.`rbac_roles` ADD KEY `rolename` (`role_name`);

ALTER TABLE `central_administration_sfcs`.`rbac_role_menu` ADD INDEX `role_menu_pid` (`menu_pid`, `roll_id`);


ALTER TABLE `central_administration_sfcs`.`rbac_role_menu_per` ADD KEY `role_menu_id` (`role_menu_id`);

ALTER TABLE `central_administration_sfcs`.`rbac_role_menu` ADD KEY `roll_id` (`roll_id`);

ALTER TABLE `central_administration_sfcs`.`rbac_users` ADD KEY `user_name` (`user_name`);