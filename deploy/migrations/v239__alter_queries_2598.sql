/*#2598 alter table*/

USE bai_rm_pj1;

ALTER TABLE bai_rm_pj1.store_in_deleted   
  DROP PRIMARY KEY,
  ADD  KEY tid (tid);
  
  Alter table bai_rm_pj1.stock_report_inventory   
  add  KEY lot_no (lot_no);
  
  ALTER TABLE bai_rm_pj1.stock_report_inventory   
  ADD  KEY label_id (tid);