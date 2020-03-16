/*#3368 alter view queries*/

USE bai_pro3;

ALTER VIEW `plan_doc_summ_in_ref` AS (
SELECT
  `plandoc_stat_log`.`order_tid`            AS `order_tid`,
  `plandoc_stat_log`.`doc_no`               AS `doc_no`,
  `plandoc_stat_log`.`acutno`               AS `acutno`,
  `plandoc_stat_log`.`act_cut_status`       AS `act_cut_status`,
  `plandoc_stat_log`.`a_plies`              AS `a_plies`,
  `plandoc_stat_log`.`p_plies`              AS `p_plies`,
  `plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,
  `bai_orders_db_confirm`.`color_code`      AS `color_code`,
  `bai_orders_db_confirm`.`order_style_no`  AS `order_style_no`,
  `bai_orders_db_confirm`.`order_del_no`    AS `order_del_no`,
  `bai_orders_db_confirm`.`order_col_des`   AS `order_col_des`,
  `bai_orders_db_confirm`.`order_div`       AS `order_div`,
  `bai_orders_db_confirm`.`ft_status`       AS `ft_status`,
  `bai_orders_db_confirm`.`st_status`       AS `st_status`,
  `bai_orders_db_confirm`.`pt_status`       AS `pt_status`,
  `bai_orders_db_confirm`.`trim_status`     AS `trim_status`,
  `cat_stat_log`.`category`                 AS `category`,
  `cat_stat_log`.`clubbing`                 AS `clubbing`,
  `plandoc_stat_log`.`plan_module`          AS `plan_module`,
  `plandoc_stat_log`.`cat_ref`              AS `cat_ref`,
 `plandoc_stat_log`.`short_shipment_status` AS `short_shipment_status`,
  (IF(((`bai_orders_db_confirm`.`order_embl_a` + `bai_orders_db_confirm`.`order_embl_b`) > 0),1,0) + IF(((`bai_orders_db_confirm`.`order_embl_e` + `bai_orders_db_confirm`.`order_embl_f`) > 0),2,0)) AS `emb_stat1`
FROM ((`plandoc_stat_log`
    JOIN `bai_orders_db_confirm`)
   JOIN `cat_stat_log`)
WHERE ((`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)
       AND (`cat_stat_log`.`tid` = `plandoc_stat_log`.`cat_ref`)
       AND (`cat_stat_log`.`category` IN('Body','Front'))
       AND (`plandoc_stat_log`.`date` > '2017-02-01'))
ORDER BY `bai_orders_db_confirm`.`order_style_no`);

USE bai_pro3;

ALTER VIEW `plan_doc_summ_input` AS (
SELECT
  `pac_stat_log_input_job`.`input_job_no`        AS `input_job_no`,
  `pac_stat_log_input_job`.`tid`                 AS `tid`,
  `pac_stat_log_input_job`.`input_job_no_random` AS `input_job_no_random`,
  `pac_stat_log_input_job`.`size_code`           AS `size_code`,
  `pac_stat_log_input_job`.`type_of_sewing`      AS `type_of_sewing`,
  `plan_doc_summ_in_ref`.`order_tid`             AS `order_tid`,
  `plan_doc_summ_in_ref`.`doc_no`                AS `doc_no`,
  `plan_doc_summ_in_ref`.`acutno`                AS `acutno`,
  IF((LENGTH(`plan_doc_summ_in_ref`.`act_cut_status`) = 0),'',`plan_doc_summ_in_ref`.`act_cut_status`) AS `act_cut_status`,
  IF((LENGTH(`plan_doc_summ_in_ref`.`act_cut_issue_status`) = 0),'',`plan_doc_summ_in_ref`.`act_cut_issue_status`) AS `act_cut_issue_status`,
  `plan_doc_summ_in_ref`.`a_plies`               AS `a_plies`,
  `plan_doc_summ_in_ref`.`p_plies`               AS `p_plies`,
  `plan_doc_summ_in_ref`.`color_code`            AS `color_code`,
  `plan_doc_summ_in_ref`.`order_style_no`        AS `order_style_no`,
  `plan_doc_summ_in_ref`.`order_del_no`          AS `order_del_no`,
  `plan_doc_summ_in_ref`.`order_col_des`         AS `order_col_des`,
  `plan_doc_summ_in_ref`.`order_div`             AS `order_div`,
  `plan_doc_summ_in_ref`.`ft_status`             AS `ft_status`,
  `plan_doc_summ_in_ref`.`st_status`             AS `st_status`,
  `plan_doc_summ_in_ref`.`pt_status`             AS `pt_status`,
  `plan_doc_summ_in_ref`.`trim_status`           AS `trim_status`,
  `plan_doc_summ_in_ref`.`category`              AS `category`,
  `plan_doc_summ_in_ref`.`clubbing`              AS `clubbing`,
  `plan_doc_summ_in_ref`.`plan_module`           AS `plan_module`,
  `plan_doc_summ_in_ref`.`cat_ref`               AS `cat_ref`,
  `plan_doc_summ_in_ref`.`emb_stat1`             AS `emb_stat1`,
  `plan_doc_summ_in_ref`.`short_shipment_status` AS `short_shipment_status`,
  SUM(`pac_stat_log_input_job`.`carton_act_qty`) AS `carton_act_qty`
FROM (`pac_stat_log_input_job`
   LEFT JOIN `plan_doc_summ_in_ref`
     ON ((`pac_stat_log_input_job`.`doc_no` = `plan_doc_summ_in_ref`.`doc_no`)))
WHERE ((`plan_doc_summ_in_ref`.`order_tid` IS NOT NULL)
       AND (`pac_stat_log_input_job`.`input_job_no` IS NOT NULL)
       AND (LENGTH(`pac_stat_log_input_job`.`input_job_no_random`) > 0))
GROUP BY `plan_doc_summ_in_ref`.`order_del_no`,`pac_stat_log_input_job`.`doc_no`,`pac_stat_log_input_job`.`input_job_no`,`pac_stat_log_input_job`.`input_job_no_random`);

USE bai_pro3;

ALTER VIEW `plan_dash_doc_summ_input` AS (
SELECT
  `plan_dashboard_input`.`input_job_no_random_ref` AS `input_job_no_random_ref`,
  `plan_dashboard_input`.`input_module`            AS `input_module`,
  `plan_dashboard_input`.`input_priority`          AS `input_priority`,
  `plan_dashboard_input`.`input_trims_status`      AS `input_trims_status`,
  `plan_dashboard_input`.`input_panel_status`      AS `input_panel_status`,
  `plan_dashboard_input`.`log_time`                AS `log_time`,
  `plan_dashboard_input`.`track_id`                AS `track_id`,
  `plan_doc_summ_input`.`input_job_no`             AS `input_job_no`,
  `plan_doc_summ_input`.`tid`                      AS `tid`,
  `plan_doc_summ_input`.`input_job_no_random`      AS `input_job_no_random`,
  `plan_doc_summ_input`.`order_tid`                AS `order_tid`,
  `plan_doc_summ_input`.`doc_no`                   AS `doc_no`,
  `plan_doc_summ_input`.`acutno`                   AS `acutno`,
  `plan_doc_summ_input`.`act_cut_status`           AS `act_cut_status`,
  `plan_doc_summ_input`.`a_plies`                  AS `a_plies`,
  `plan_doc_summ_input`.`p_plies`                  AS `p_plies`,
  `plan_doc_summ_input`.`color_code`               AS `color_code`,
  `plan_doc_summ_input`.`order_style_no`           AS `order_style_no`,
  `plan_doc_summ_input`.`order_del_no`             AS `order_del_no`,
  `plan_doc_summ_input`.`order_col_des`            AS `order_col_des`,
  `plan_doc_summ_input`.`order_div`                AS `order_div`,
  `plan_doc_summ_input`.`ft_status`                AS `ft_status`,
  `plan_doc_summ_input`.`st_status`                AS `st_status`,
  `plan_doc_summ_input`.`pt_status`                AS `pt_status`,
  `plan_doc_summ_input`.`trim_status`              AS `trim_status`,
  `plan_doc_summ_input`.`category`                 AS `category`,
  `plan_doc_summ_input`.`clubbing`                 AS `clubbing`,
  `plan_doc_summ_input`.`plan_module`              AS `plan_module`,
  `plan_doc_summ_input`.`cat_ref`                  AS `cat_ref`,
  `plan_doc_summ_input`.`emb_stat1`                AS `emb_stat1`,
  `plan_doc_summ_input`.`carton_act_qty`           AS `carton_act_qty`,
  `plan_doc_summ_input`.`short_shipment_status`    AS `short_shipment_status`,
  `plan_doc_summ_input`.`type_of_sewing`           AS `type_of_sewing`
FROM (`plan_dashboard_input`
   LEFT JOIN `plan_doc_summ_input`
     ON ((`plan_dashboard_input`.`input_job_no_random_ref` = `plan_doc_summ_input`.`input_job_no_random`))));