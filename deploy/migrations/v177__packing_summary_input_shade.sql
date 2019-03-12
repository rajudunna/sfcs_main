/*#1323 script*/
USE `bai_pro3`;
alter table bai_pro3.pac_stat_log_input_job add column shade_group varchar(6) NULL after bundle_print_time;

DROP VIEW IF EXISTS bai_pro3.packing_summary_input;

CREATE VIEW bai_pro3.packing_summary_input AS 
SELECT
  `bai_orders_db_confirm`.`order_joins`          AS `order_joins`,
  `pac_stat_log_input_job`.`doc_no`              AS `doc_no`,
  `pac_stat_log_input_job`.`input_job_no`        AS `input_job_no`,
  `pac_stat_log_input_job`.`input_job_no_random` AS `input_job_no_random`,
  `pac_stat_log_input_job`.`doc_no_ref`          AS `doc_no_ref`,
  `pac_stat_log_input_job`.`tid`                 AS `tid`,
  UCASE(`pac_stat_log_input_job`.`size_code`)    AS `size_code`,
  `pac_stat_log_input_job`.`status`              AS `STATUS`,
  `pac_stat_log_input_job`.`carton_act_qty`      AS `carton_act_qty`,
  `pac_stat_log_input_job`.`packing_mode`        AS `packing_mode`,
  `bai_orders_db_confirm`.`order_style_no`       AS `order_style_no`,
  `bai_orders_db_confirm`.`order_del_no`         AS `order_del_no`,
  `bai_orders_db_confirm`.`order_col_des`        AS `order_col_des`,
  `plandoc_stat_log`.`acutno`                    AS `acutno`,
  `bai_orders_db_confirm`.`destination`          AS `destination`,
  `plandoc_stat_log`.`cat_ref`                   AS `cat_ref`,
  UCASE(`pac_stat_log_input_job`.`size_code`)    AS `m3_size_code`,
  `pac_stat_log_input_job`.`old_size`            AS `old_size`,
  `pac_stat_log_input_job`.`type_of_sewing`      AS `type_of_sewing`,
  `pac_stat_log_input_job`.`doc_type`            AS `doc_type`,
  `pac_stat_log_input_job`.`pac_seq_no`          AS `pac_seq_no`,
  `pac_stat_log_input_job`.`sref_id`             AS `sref_id`,
  `pac_stat_log_input_job`.`barcode_sequence`    AS `barcode_sequence`,
  `pac_stat_log_input_job`.`bundle_print_status` AS `bundle_print_status`,
  `pac_stat_log_input_job`.`mrn_status`          AS `mrn_status`,
  `pac_stat_log_input_job`.`shade_group`         AS `shade_group`
FROM ((`pac_stat_log_input_job`
    LEFT JOIN `plandoc_stat_log`
      ON (`pac_stat_log_input_job`.`doc_no` = `plandoc_stat_log`.`doc_no`))
   LEFT JOIN `bai_orders_db_confirm`
     ON (`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`));