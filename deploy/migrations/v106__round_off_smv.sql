
/*USE bai_pro3;*/
ALTER TABLE bai_pro3.schedule_oprations_master MODIFY SMV DECIMAL(10,4);


/*USE brandix_bts;*/
ALTER TABLE brandix_bts.tbl_style_ops_master MODIFY smv DECIMAL(10,4);


ALTER TABLE brandix_bts.tbl_style_ops_master MODIFY m3_smv DECIMAL(10,4);


/*USE bai_pro;*/

ALTER TABLE bai_pro.bai_log MODIFY smv DECIMAL(10,4);


ALTER TABLE bai_pro.bai_log_buf MODIFY smv DECIMAL(10,4);