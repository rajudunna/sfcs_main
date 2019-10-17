/*#2619 alter table*/

USE brandix_bts;


Alter table brandix_bts.tbl_orders_master
  add  KEY schedule
(product_schedule);