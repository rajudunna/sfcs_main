/*#1746 Alter table*/

ALTER TABLE brandix_bts.tbl_orders_ops_ref CHANGE operation_type display_operations VARCHAR(10);
UPDATE brandix_bts.tbl_orders_ops_ref SET display_operations = 'yes';