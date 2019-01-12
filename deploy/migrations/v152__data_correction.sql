/*#1331*/
UPDATE bai_pro3.bai_orders_db AS bod SET order_date=(SELECT md.COPLANDELDATE FROM m3_inputs.mo_details AS md WHERE md.SCHEDULE=bod.order_del_no AND md.COLOURDESC=bod.order_col_des LIMIT 1);