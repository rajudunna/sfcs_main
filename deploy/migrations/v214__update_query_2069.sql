/*#2069 update  tbl_orders_ops_ref */

USE `brandix_bts`;

UPDATE brandix_bts.tbl_orders_ops_ref SET work_center_id = '' WHERE operation_code  in ('100','101','129','130');