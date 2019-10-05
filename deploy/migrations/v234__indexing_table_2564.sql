/*#2564 alter table*/


USE bai_pro3;
Alter table bai_pro3.m3_transactions add  KEY reference_check
(op_code, ref_no);

Alter table bai_pro3.pac_stat_log add  KEY carton_check
(pac_stat_id);

Alter table bai_pro3.tbl_carton_ready add  KEY mo_check
(mo_no, operation_id);
