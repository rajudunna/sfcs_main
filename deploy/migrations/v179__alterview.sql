/*#1682 script*/
USE `bai_rm_pj1`;

ALTER VIEW bai_rm_pj1.stock_report AS (
SELECT
  store_in.ref1                AS ref1,
  store_in.lot_no              AS lot_no,
  sticker_report.batch_no      AS batch_no,
  sticker_report.item_desc     AS item_desc,
  sticker_report.item_name     AS item_name,
  sticker_report.item          AS item,
  sticker_report.supplier      AS supplier,
  sticker_report.buyer         AS buyer,
  sticker_report.style_no      AS style_no,
  store_in.ref2                AS ref2,
  store_in.ref3                AS ref3,
  sticker_report.pkg_no        AS pkg_no,
  store_in.status              AS status,
  sticker_report.grn_date      AS grn_date,
  store_in.remarks             AS remarks,
  store_in.tid                 AS tid,
  store_in.qty_rec             AS qty_rec,
  store_in.qty_issued          AS qty_issued,
  store_in.qty_ret             AS qty_ret,
  ROUND(((ROUND(store_in.qty_rec,2) - ROUND(store_in.qty_issued,2)) + ROUND(store_in.qty_ret,2)),2) AS balance,
  sticker_report.product_group AS product_group
FROM (store_in
   JOIN sticker_report)
WHERE ((store_in.lot_no = sticker_report.lot_no)
       AND (((ROUND(store_in.qty_rec,2) - ROUND(store_in.qty_issued,2)) + ROUND(store_in.qty_ret,2)) > 0)));