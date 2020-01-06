/*#2562 alter table*/

USE bai_pro3;

ALTER TABLE `bai_pro3`.`ims_log`
ADD KEY `ims_module`
(`ims_mod_no`);

ALTER TABLE `bai_pro3`.`fabric_priorities`
ADD KEY `module`
(`module`); 