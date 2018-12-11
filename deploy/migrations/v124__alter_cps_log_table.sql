/*USE bai_pro3;*/
alter table bai_pro3.cps_log 
   add column reported_status varchar(15) NULL after remaining_qty;