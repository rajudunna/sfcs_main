/*#2046 New table*/

USE `bai_rm_pj1`;

CREATE TABLE `bai_rm_pj1`.`stock_report_inventory` (
  `ref1` varchar(150) DEFAULT NULL,
  `lot_no` varchar(450) DEFAULT NULL,
  `batch_no` varchar(600) DEFAULT NULL,
  `item_desc` varchar(600) DEFAULT NULL,
  `item_name` varchar(600) DEFAULT NULL,
  `item` varchar(600) DEFAULT NULL,
  `supplier` varchar(600) DEFAULT NULL,
  `buyer` varchar(600) DEFAULT NULL,
  `style_no` varchar(105) DEFAULT NULL,
  `ref2` varchar(300) DEFAULT NULL,
  `ref3` varchar(300) DEFAULT NULL,
  `pkg_no` varchar(150) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `grn_date` varchar(150) DEFAULT NULL,
  `remarks` varchar(600) DEFAULT NULL,
  `tid` bigint(20) DEFAULT NULL,
  `qty_rec` double DEFAULT NULL,
  `qty_issued` double DEFAULT NULL,
  `qty_ret` double DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `product_group` varchar(450) DEFAULT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



ALTER  VIEW `bai_rm_pj1`.`stock_report` AS (
SELECT
  `bai_rm_pj1`.`store_in`.`ref1`                AS `ref1`,
  `bai_rm_pj1`.`store_in`.`lot_no`              AS `lot_no`,
  `bai_rm_pj1`.`sticker_report`.`batch_no`      AS `batch_no`,
  `bai_rm_pj1`.`sticker_report`.`item_desc`     AS `item_desc`,
  `bai_rm_pj1`.`sticker_report`.`item_name`     AS `item_name`,
  `bai_rm_pj1`.`sticker_report`.`item`          AS `item`,
  `bai_rm_pj1`.`sticker_report`.`supplier`      AS `supplier`,
  `bai_rm_pj1`.`sticker_report`.`buyer`         AS `buyer`,
  `bai_rm_pj1`.`sticker_report`.`style_no`      AS `style_no`,
  `bai_rm_pj1`.`store_in`.`ref2`                AS `ref2`,
  `bai_rm_pj1`.`store_in`.`ref3`                AS `ref3`,
  `bai_rm_pj1`.`sticker_report`.`pkg_no`        AS `pkg_no`,
  `bai_rm_pj1`.`store_in`.`status`              AS `status`,
  `bai_rm_pj1`.`sticker_report`.`grn_date`      AS `grn_date`,
  `bai_rm_pj1`.`store_in`.`remarks`             AS `remarks`,
  `bai_rm_pj1`.`store_in`.`tid`                 AS `tid`,
  `bai_rm_pj1`.`store_in`.`qty_rec`             AS `qty_rec`,
  `bai_rm_pj1`.`store_in`.`qty_issued`          AS `qty_issued`,
  `bai_rm_pj1`.`store_in`.`qty_ret`             AS `qty_ret`,
  ROUND(ROUND(`bai_rm_pj1`.`store_in`.`qty_rec`,2) - ROUND(`bai_rm_pj1`.`store_in`.`qty_issued`,2) + ROUND(`bai_rm_pj1`.`store_in`.`qty_ret`,2),2) AS `balance`,
  `bai_rm_pj1`.`sticker_report`.`product_group` AS `product_group`,
  `bai_rm_pj1`.`store_in`.`log_stamp` AS `log_time`
FROM (`bai_rm_pj1`.`store_in`
   JOIN `bai_rm_pj1`.`sticker_report`)
WHERE `bai_rm_pj1`.`store_in`.`lot_no` = `bai_rm_pj1`.`sticker_report`.`lot_no`
    AND ROUND(`bai_rm_pj1`.`store_in`.`qty_rec`,2) - ROUND(`bai_rm_pj1`.`store_in`.`qty_issued`,2) + ROUND(`bai_rm_pj1`.`store_in`.`qty_ret`,2) > 0);