/*#1448*/
ALTER TABLE brandix_bts.tbl_orders_ops_ref ADD COLUMN m3_operation_type VARCHAR(10) NOT NULL AFTER parent_work_center_id;


ALTER TABLE bai_pro3.schedule_oprations_master ADD COLUMN m3_operation_type VARCHAR(10) NOT NULL AFTER Updated_Time;




ALTER TABLE bai_pro3.mo_details ADD INDEX mo_details_ix4 (ops_master_status);


ALTER TABLE brandix_bts.tbl_orders_ops_ref ADD INDEX tbl_ord_ops_ref_ix4 (m3_operation_type);