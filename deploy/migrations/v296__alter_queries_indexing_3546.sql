/*#3546 alter queries indexing*/

Alter table brandix_bts.tbl_style_ops_master add  KEY recplace_index (style, color, ops_sequence, operation_order, operation_code);

Alter table bai_pro3.cat_stat_log add  KEY replace_index (order_tid, category);