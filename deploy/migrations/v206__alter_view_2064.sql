USE `bai_rm_pj1`;


ALTER  VIEW `bai_rm_pj1`.`fabric_status_v3` AS (
SELECT
  `store_in`.`ref1`                AS `ref1`,
  GROUP_CONCAT(DISTINCT `store_in`.`lot_no` SEPARATOR ',') AS `lot_no`,
  `sticker_report`.`batch_no`      AS `batch_no`,
  `sticker_report`.`inv_no`        AS `inv_no`,
  `sticker_report`.`item_desc`     AS `item_desc`,
  `sticker_report`.`item_name`     AS `item_name`,
  `sticker_report`.`item`          AS `item`,
  `store_in`.`ref5`                AS `ref5`,
  `store_in`.`ref2`                AS `ref2`,
  `store_in`.`ref3`                AS `ref3`,
  `store_in`.`ref6`                AS `ref6`,
  `sticker_report`.`pkg_no`        AS `pkg_no`,
  `store_in`.`status`              AS `status`,
  `sticker_report`.`grn_date`      AS `grn_date`,
  `store_in`.`remarks`             AS `remarks`,
  `store_in`.`tid`                 AS `tid`,
  `store_in`.`qty_rec`             AS `qty_rec`,
  `store_in`.`qty_issued`          AS `qty_issued`,
  `store_in`.`qty_ret`             AS `qty_ret`,
  `store_in`.`qty_allocated`       AS `qty_allocated`,
  `store_in`.`partial_appr_qty`    AS `partial_appr_qty`,
  `store_in`.`ref4`                AS `shade`,
  `store_in`.`allotment_status`    AS `allotment_status`,
  `store_in`.`roll_status`         AS `roll_status`,
  `store_in`.`shrinkage_length`    AS `shrinkage_length`,
  `store_in`.`shrinkage_width`     AS `shrinkage_width`,
  `store_in`.`shrinkage_group`     AS `shrinkage_group`,
  `store_in`.`roll_remarks`         AS `roll_remarks`,
  `sticker_report`.`product_group` AS `product_group`,
  `sticker_report`.`allocated_qty` AS `allocated_qty`,
  IF(OCTET_LENGTH(`store_in`.`ref3`) > 0 AND `store_in`.`ref3` <> 0,`store_in`.`ref3`,`store_in`.`ref6`) AS `width`,
  ROUND(SUM(`store_in`.`qty_rec`),2) AS `rec_qty`,
  ROUND(SUM(ROUND(ROUND(`store_in`.`qty_rec`,2) - ROUND(`store_in`.`partial_appr_qty`,2) - ROUND(`store_in`.`qty_issued`,2) + ROUND(`store_in`.`qty_ret`,2) - ROUND(`store_in`.`qty_allocated`,2),2)),2) AS `balance`
FROM (`store_in`
   JOIN `sticker_report`)
WHERE ROUND(`store_in`.`qty_rec`,2) - ROUND(`store_in`.`qty_issued`,2) + ROUND(`store_in`.`qty_ret`,2) > 0
    AND `store_in`.`allotment_status` IN(0,1,2)
    AND `store_in`.`lot_no` = `sticker_report`.`lot_no`
    AND `store_in`.`roll_status` IN(0,2)
GROUP BY `store_in`.`tid`);
