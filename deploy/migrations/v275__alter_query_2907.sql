/*#2907 alter query */
USE bai_pro3;

Alter table bai_pro3.bai_qms_db change input_job_no input_job_no varchar (90) CHARSET latin1 COLLATE latin1_swedish_ci NULL;

Alter table bai_pro3.bai_qms_rejection_reason add  KEY form_type (form_type);

Alter table bai_pro3.recut_v2_child_issue_track add  KEY recut_id (recut_id);

Alter table bai_pro3.ims_log_backup add  KEY scanning (ims_mod_no, ims_remarks, ims_style, ims_schedule, ims_color, pac_tid, operation_id, input_job_rand_no_ref);

USE brandix_bts;

Alter table brandix_bts.tbl_ims_ops add  KEY application (appilication);


Alter table brandix_bts.tbl_style_ops_master add  KEY scanning (operation_order, ops_sequence, ops_dependency);

