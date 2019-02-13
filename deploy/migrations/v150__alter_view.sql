/* #1319 sql alter view script note: please don't comment or remove use bai_rm_pj1 */
USE `bai_rm_pj1`;
DROP VIEW IF EXISTS `bai_rm_pj1`.`sticker_ref`;

CREATE SQL SECURITY DEFINER VIEW `bai_rm_pj1`.`sticker_ref` AS (
SELECT
  `store_in`.`ref1`            AS `ref1`,
  `store_in`.`lot_no`          AS `lot_no`,
  `sticker_report`.`batch_no`  AS `batch_no`,
  `sticker_report`.`item_desc` AS `item_desc`,
  `sticker_report`.`item_name` AS `item_name`,
  `sticker_report`.`item`      AS `item`,
  `sticker_report`.`inv_no`    AS `inv_no`,
  `store_in`.`ref2`            AS `ref2`,
  `store_in`.`ref3`            AS `ref3`,
  `store_in`.`ref4`            AS `ref4`,
  `store_in`.`ref5`            AS `ref5`,
  `store_in`.`ref6`            AS `ref6`,
  `sticker_report`.`pkg_no`    AS `pkg_no`,
  `store_in`.`status`          AS `status`,
  `sticker_report`.`grn_date`  AS `grn_date`,
  `store_in`.`remarks`         AS `remarks`,
  `store_in`.`tid`             AS `tid`,
  `store_in`.`qty_rec`         AS `qty_rec`,
  `store_in`.`qty_issued`      AS `qty_issued`,
  `store_in`.`qty_ret`         AS `qty_ret`,
  `store_in`.`barcode_number`         AS `barcode_number`
FROM (`store_in`
   JOIN `sticker_report`)
WHERE (`store_in`.`lot_no` = `sticker_report`.`lot_no`));


DROP VIEW IF EXISTS `bai_rm_pj1`.`docket_ref`;

CREATE SQL SECURITY DEFINER VIEW `bai_rm_pj1`.`docket_ref` AS (
SELECT
  `fabric_cad_allocation`.`tran_pin`      AS `tran_pin`,
  `fabric_cad_allocation`.`doc_no`        AS `doc_no`,
  `fabric_cad_allocation`.`roll_id`       AS `roll_id`,
  `fabric_cad_allocation`.`roll_width`    AS `roll_width`,
  `fabric_cad_allocation`.`plies`         AS `plies`,
  `fabric_cad_allocation`.`mk_len`        AS `mk_len`,
  `fabric_cad_allocation`.`doc_type`      AS `doc_type`,
  `fabric_cad_allocation`.`log_time`      AS `log_time`,
  `fabric_cad_allocation`.`allocated_qty` AS `allocated_qty`,
  `sticker_ref`.`ref1`                    AS `ref1`,
  `sticker_ref`.`lot_no`                  AS `lot_no`,
  `sticker_ref`.`batch_no`                AS `batch_no`,
  `sticker_ref`.`item_desc`               AS `item_desc`,
  `sticker_ref`.`item_name`               AS `item_name`,
  `sticker_ref`.`item`                    AS `item`,
  `sticker_ref`.`ref2`                    AS `ref2`,
  `sticker_ref`.`ref3`                    AS `ref3`,
  `sticker_ref`.`ref4`                    AS `ref4`,
  `sticker_ref`.`ref5`                    AS `ref5`,
  `sticker_ref`.`ref6`                    AS `ref6`,
  `sticker_ref`.`pkg_no`                  AS `pkg_no`,
  `sticker_ref`.`status`                  AS `status`,
  `sticker_ref`.`grn_date`                AS `grn_date`,
  `sticker_ref`.`remarks`                 AS `remarks`,
  `sticker_ref`.`tid`                     AS `tid`,
  `sticker_ref`.`qty_rec`                 AS `qty_rec`,
  `sticker_ref`.`qty_issued`              AS `qty_issued`,
  `sticker_ref`.`qty_ret`                 AS `qty_ret`,
  `sticker_ref`.`inv_no`                  AS `inv_no`,
  `sticker_ref`.`barcode_number`                  AS `barcode_number`
FROM (`fabric_cad_allocation`
   LEFT JOIN `sticker_ref`
     ON ((`fabric_cad_allocation`.`roll_id` = `sticker_ref`.`tid`))));

