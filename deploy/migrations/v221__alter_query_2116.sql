/*#2116 SMV Capturing*/

USE `brandix_bts`;

ALTER TABLE brandix_bts.tbl_style_ops_master ADD COLUMN manual_smv DECIMAL (10,4) NULL AFTER main_operationnumber;

ALTER TABLE brandix_bts.bundle_creation_data_temp CHANGE sfcs_smv sfcs_smv DECIMAL (10,4) NULL;

ALTER TABLE brandix_bts.bundle_creation_data CHANGE sfcs_smv sfcs_smv DECIMAL (10,4) NULL;