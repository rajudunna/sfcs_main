/*#2925 alter query */

USE bai_pro3;


Alter table bai_pro3.cps_log add index doc_no_op_size_code (doc_no, size_code, operation_code);