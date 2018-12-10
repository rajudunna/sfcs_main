/*USE bai_pro3;*/
ALTER TABLE bai_pro3.pac_stat_log_input_job
  CHANGE pac_seq_no pac_seq_no INT(11) DEFAULT 0 NOT NULL;
  
ALTER VIEW bai_pro3.packing_summary AS (
SELECT
  `pac_stat_log`.`doc_no`         AS `doc_no`,
  `pac_stat_log`.`doc_no_ref`     AS `doc_no_ref`,
  `pac_stat_log`.`tid`            AS `tid`,
  `pac_stat`.`carton_no`          AS `carton_no`,
  `pac_stat_log`.`size_code`      AS `size_code`,
  `pac_stat_log`.`remarks`        AS `remarks`,
  `pac_stat_log`.`status`         AS `status`,
  `pac_stat_log`.`lastup`         AS `lastup`,
  `pac_stat_log`.`container`      AS `container`,
  `pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,
  `pac_stat_log`.`disp_id`        AS `disp_id`,
  `pac_stat_log`.`carton_act_qty` AS `carton_act_qty`,
  `pac_stat_log`.`audit_status`   AS `audit_status`,
  `pac_stat`.`style`              AS `order_style_no`,
  `pac_stat`.`schedule`           AS `order_del_no`,
  `pac_stat`.`carton_mode`        AS `carton_mode`,
  `pac_stat_log`.`color`          AS `order_col_des`,
  `pac_stat_log`.`size_tit`       AS `size_tit`,
  `pac_stat`.`pac_seq_no`         AS `seq_no`,
  `pac_stat_log`.`pac_stat_id`    AS `pac_stat_id`
FROM (((`pac_stat_log`
     LEFT JOIN `pac_stat`
       ON (`pac_stat`.`id` = `pac_stat_log`.`pac_stat_id`))
    LEFT JOIN `plandoc_stat_log`
      ON (`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`))
   LEFT JOIN `bai_orders_db_confirm`
     ON (`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)));
