/*1372*/
UPDATE bai_pro3.bai_orders_db AS bod SET vpo=(SELECT md.VPO_NO FROM m3_inputs.order_details AS md 
WHERE md.SCHEDULE=bod.order_del_no AND md.GMT_Color=bod.order_col_des LIMIT 1) WHERE bod.vpo='';

UPDATE bai_pro3.bai_orders_db_confirm AS bod SET vpo=(SELECT md.VPO_NO FROM m3_inputs.order_details AS md 
WHERE md.SCHEDULE=bod.order_del_no AND md.GMT_Color=bod.order_col_des LIMIT 1) WHERE bod.vpo='';