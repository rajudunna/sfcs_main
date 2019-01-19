/*1000 MRN Interface Integration*/
insert into central_administration_sfcs.tbl_menu_list (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) values('1635','SFCS_9010','8','8','1487','1','0','0','/sfcs_app/app/production/controllers/sewing_job/sewing_job_create_mrn.php','MRN Integration','1','');

insert into central_administration_sfcs.rbac_role_menu ( menu_pid, menu_description, roll_id) values('1635','MRN Integration','1');

ALTER TABLE bai_pro3.pac_stat_log_input_job
ADD COLUMN mrn_status INT(11) NULL COMMENT '0-fail, 1-pass' AFTER barcode_sequence;


ALTER  VIEW bai_pro3.packing_summary_input AS 
SELECT
  bai_pro3.bai_orders_db_confirm.order_joins          AS order_joins,
  bai_pro3.pac_stat_log_input_job.doc_no              AS doc_no,
  bai_pro3.pac_stat_log_input_job.input_job_no        AS input_job_no,
  bai_pro3.pac_stat_log_input_job.input_job_no_random AS input_job_no_random,
  bai_pro3.pac_stat_log_input_job.doc_no_ref          AS doc_no_ref,
  bai_pro3.pac_stat_log_input_job.tid                 AS tid,
  UCASE(bai_pro3.pac_stat_log_input_job.size_code)    AS size_code,
  bai_pro3.pac_stat_log_input_job.status              AS STATUS,
  bai_pro3.pac_stat_log_input_job.carton_act_qty      AS carton_act_qty,
  bai_pro3.pac_stat_log_input_job.packing_mode        AS packing_mode,
  bai_pro3.bai_orders_db_confirm.order_style_no       AS order_style_no,
  bai_pro3.bai_orders_db_confirm.order_del_no         AS order_del_no,
  bai_pro3.bai_orders_db_confirm.order_col_des        AS order_col_des,
  bai_pro3.plandoc_stat_log.acutno                    AS acutno,
  bai_pro3.bai_orders_db_confirm.destination          AS destination,
  bai_pro3.plandoc_stat_log.cat_ref                   AS cat_ref,
  UCASE(bai_pro3.pac_stat_log_input_job.size_code)    AS m3_size_code,
  bai_pro3.pac_stat_log_input_job.old_size            AS old_size,
  bai_pro3.pac_stat_log_input_job.type_of_sewing      AS type_of_sewing,
  bai_pro3.pac_stat_log_input_job.doc_type            AS doc_type,
  bai_pro3.pac_stat_log_input_job.pac_seq_no          AS pac_seq_no,
  bai_pro3.pac_stat_log_input_job.sref_id             AS sref_id,
  bai_pro3.pac_stat_log_input_job.barcode_sequence    AS barcode_sequence,
  bai_pro3.pac_stat_log_input_job.mrn_status          AS mrn_status
FROM ((bai_pro3.pac_stat_log_input_job
    LEFT JOIN bai_pro3.plandoc_stat_log
      ON (bai_pro3.pac_stat_log_input_job.doc_no = bai_pro3.plandoc_stat_log.doc_no))
   LEFT JOIN bai_pro3.bai_orders_db_confirm
     ON (bai_pro3.bai_orders_db_confirm.order_tid = bai_pro3.plandoc_stat_log.order_tid));


