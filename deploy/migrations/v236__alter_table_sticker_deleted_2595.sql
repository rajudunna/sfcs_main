/*#2595 alter table*/

USE bai_rm_pj1;
ALTER TABLE bai_rm_pj1.sticker_report_deleted   
  ADD COLUMN po_line INT
(18) NULL AFTER grn_type,
ADD COLUMN po_subline INT
(18) NULL AFTER po_line;