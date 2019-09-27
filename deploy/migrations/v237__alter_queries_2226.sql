/*#2226 alter table*/


USE bai_pro3;


ALTER TABLE `bai_pro3`.`ips_job_transfer`   
  CHANGE `job_no` `job_no` VARCHAR
(20) NULL,
  CHANGE `module` `module` VARCHAR
(20) NULL,
  CHANGE `transfered_module` `transfered_module` VARCHAR
(20) NULL;

USE brandix_bts;


ALTER TABLE `brandix_bts`.`input_transfer`   
  CHANGE `input_module` `input_module` VARCHAR
(20) NULL,
  CHANGE `transfer_module` `transfer_module` VARCHAR
(20) NULL;

ALTER TABLE `brandix_bts`.`module_bundle_track`   
  CHANGE `module` `module` VARCHAR
(11) NULL,
  CHANGE `job_no` `job_no` VARCHAR
(20) NULL;