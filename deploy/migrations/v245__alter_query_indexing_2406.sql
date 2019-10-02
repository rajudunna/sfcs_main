/*#2406 indexing rejection log  tables*/
USE bai_pro3;

ALTER TABLE `bai_pro3`.`rejections_log`
ADD KEY `rejection_log_sc`
(`schedule`, `color`);

ALTER TABLE `bai_pro3`.`rejection_log_child`
ADD KEY `rejection_log_child_key1`
(`parent_id`, `size_id`, `assigned_module`); 