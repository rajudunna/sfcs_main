/*1656 sql script to alter view */
ALTER VIEW bai_rm_pj1.fabric_status_v3 AS (
SELECT
  bai_rm_pj1.store_in.ref1                AS ref1,
  GROUP_CONCAT(DISTINCT bai_rm_pj1.store_in.lot_no SEPARATOR ',') AS lot_no,
  bai_rm_pj1.sticker_report.batch_no      AS batch_no,
  bai_rm_pj1.sticker_report.inv_no        AS inv_no,
  bai_rm_pj1.sticker_report.item_desc     AS item_desc,
  bai_rm_pj1.sticker_report.item_name     AS item_name,
  bai_rm_pj1.sticker_report.item          AS item,
  bai_rm_pj1.store_in.ref5                AS ref5,
  bai_rm_pj1.store_in.ref2                AS ref2,
  bai_rm_pj1.store_in.ref3                AS ref3,
  bai_rm_pj1.store_in.ref6                AS ref6,
  bai_rm_pj1.sticker_report.pkg_no        AS pkg_no,
  bai_rm_pj1.store_in.status              AS status,
  bai_rm_pj1.sticker_report.grn_date      AS grn_date,
  bai_rm_pj1.store_in.remarks             AS remarks,
  bai_rm_pj1.store_in.tid                 AS tid,
  bai_rm_pj1.store_in.qty_rec             AS qty_rec,
  bai_rm_pj1.store_in.qty_issued          AS qty_issued,
  bai_rm_pj1.store_in.qty_ret             AS qty_ret,
  bai_rm_pj1.store_in.qty_allocated       AS qty_allocated,
  bai_rm_pj1.store_in.partial_appr_qty    AS partial_appr_qty,
  bai_rm_pj1.store_in.ref4                AS shade,
  bai_rm_pj1.store_in.allotment_status    AS allotment_status,
  bai_rm_pj1.store_in.roll_status         AS roll_status,
  bai_rm_pj1.store_in.shrinkage_length    AS shrinkage_length,
  bai_rm_pj1.store_in.shrinkage_width     AS shrinkage_width,
  bai_rm_pj1.store_in.shrinkage_group     AS shrinkage_group,
  bai_rm_pj1.store_in.roll_status         AS roll_remarks,
  bai_rm_pj1.sticker_report.product_group AS product_group,
  bai_rm_pj1.sticker_report.allocated_qty AS allocated_qty,
  IF(OCTET_LENGTH(bai_rm_pj1.store_in.ref3) > 0 AND bai_rm_pj1.store_in.ref3 <> 0,bai_rm_pj1.store_in.ref3,bai_rm_pj1.store_in.ref6) AS width,
  ROUND(SUM(bai_rm_pj1.store_in.qty_rec),2) AS rec_qty,
  ROUND(SUM(ROUND(ROUND(bai_rm_pj1.store_in.qty_rec,2) - ROUND(bai_rm_pj1.store_in.partial_appr_qty,2) - ROUND(bai_rm_pj1.store_in.qty_issued,2) + ROUND(bai_rm_pj1.store_in.qty_ret,2) - ROUND(bai_rm_pj1.store_in.qty_allocated,2),2)),2) AS balance
FROM (bai_rm_pj1.store_in
   JOIN bai_rm_pj1.sticker_report on bai_rm_pj1.store_in.lot_no = bai_rm_pj1.sticker_report.lot_no)
WHERE ROUND(bai_rm_pj1.store_in.qty_rec,2) - ROUND(bai_rm_pj1.store_in.qty_issued,2) + ROUND(bai_rm_pj1.store_in.qty_ret,2) > 0
    AND bai_rm_pj1.store_in.allotment_status IN(0,1,2)
    AND bai_rm_pj1.store_in.roll_status IN(0,2));