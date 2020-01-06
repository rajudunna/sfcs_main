USE brandix_bts;

ALTER TABLE brandix_bts.bundle_creation_data ADD KEY sch_oper (schedule, operation_id); 

ALTER TABLE brandix_bts.bundle_creation_data ADD KEY cutno_opetaion (cut_number, operation_id);

ALTER TABLE brandix_bts.bundle_creation_data ADD KEY schedule_color (schedule, color); 

Alter table brandix_bts.tbl_style_ops_master drop index style_color, add  KEY style_color (style, color, default_operration);


USE bai_pro;

ALTER TABLE bai_pro.bai_log ADD KEY bac_no_date (bac_no, bac_date); 


USE bai_pro3;

ALTER TABLE bai_pro3.m3_transactions ADD KEY m3_tran_index_key (mo_no, reason, op_code, workstation_id); 



Alter table bai_pro3.ims_log add  KEY docket (ims_doc_no);

Alter table bai_pro3.plandoc_stat_log add  KEY fabric_status (fabric_status),add  KEY org_doc_no (org_doc_no);



Alter table bai_pro3.maker_details add  KEY parent_id (parent_id);

Alter table bai_pro3.module_master add  KEY status (status);

Alter table bai_pro3.fabric_priorities add  KEY issued_time (issued_time);



USE bai_rm_pj1;

Alter table bai_rm_pj1.sticker_report add  KEY product_group (product_group),add  KEY style_no (style_no);