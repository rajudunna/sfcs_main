/*#1838 alter queries*/

USE `bai_pro3`;

ALTER TABLE bai_pro3.bai_orders_db ADD COLUMN customer_style_no VARCHAR(50) NULL COMMENT 'customer style number';

ALTER TABLE bai_pro3.bai_orders_db_confirm ADD COLUMN customer_style_no VARCHAR(50) NULL COMMENT 'customer style number';

ALTER TABLE bai_pro3.bai_orders_db_club_confirm ADD COLUMN customer_style_no VARCHAR(50) NULL COMMENT 'customer style number';

ALTER TABLE bai_pro3.bai_orders_db_club ADD COLUMN customer_style_no VARCHAR(50) NULL COMMENT 'customer style number';