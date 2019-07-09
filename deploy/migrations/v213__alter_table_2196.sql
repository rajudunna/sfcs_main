/*#2196 alter sticker_report_deleted */


USE `bai_rm_pj1`;
ALTER TABLE bai_rm_pj1.sticker_report_deleted DROP PRIMARY KEY,
ADD KEY lot_no
(lot_no);