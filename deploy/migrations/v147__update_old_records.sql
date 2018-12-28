/*#1298*/
UPDATE bai_pro3.m3_transactions SET api_status='opn' WHERE op_code=200;

INSERT INTO bai_pro3.m3_transactions(date_time, mo_no, quantity, reason, remarks, log_user, tran_status_code, module_no, shift, op_code, op_des, ref_no, workstation_id, response_status, m3_ops_code, m3_trail_count, api_type) SELECT date_time, mo_no, quantity, reason, remarks, log_user, tran_status_code, module_no, shift, op_code, op_des, ref_no, workstation_id, 'fail', m3_ops_code, m3_trail_count, 'fg' FROM bai_pro3.m3_transactions WHERE op_code=200;