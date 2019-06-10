/*#2001 alter queries*/

USE `brandix_bts`;

ALTER TABLE brandix_bts.default_operation_workflow ADD COLUMN previous_operation INT(11) NOT NULL AFTER ops_sequence;  

ALTER TABLE brandix_bts.tbl_style_ops_master ADD COLUMN previous_operation INT(11) NOT NULL AFTER ops_sequence;