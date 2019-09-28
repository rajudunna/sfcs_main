/*#2624 alter table store_in_backup*/

USE bai_rm_pj1;

ALTER TABLE bai_rm_pj1.store_in_backup
  ADD COLUMN upload_file VARCHAR
(200) NULL AFTER partial_appr_qty,
ADD COLUMN shrinkage_length FLOAT DEFAULT 0  NOT NULL AFTER upload_file,
ADD COLUMN shrinkage_width FLOAT DEFAULT 0  NOT NULL AFTER shrinkage_length,
ADD COLUMN shrinkage_group VARCHAR
(255) NOT NULL AFTER shrinkage_width,
ADD COLUMN roll_remarks VARCHAR
(255) NOT NULL AFTER shrinkage_group,
ADD COLUMN rejection_reason VARCHAR
(255) NOT NULL AFTER roll_remarks,
ADD COLUMN m3_call_status ENUM
('Y','N') DEFAULT 'N'   NULL AFTER rejection_reason,
ADD COLUMN split_roll VARCHAR
(50) NULL AFTER m3_call_status,
ADD COLUMN barcode_number VARCHAR
(255) NULL AFTER split_roll,
ADD COLUMN ref_tid INT
(11) DEFAULT 0  NULL AFTER barcode_number;


ALTER TABLE `bai_rm_pj1`.`store_in_backup` CHANGE `log_user` `log_user` VARCHAR
(50) NOT NULL; 