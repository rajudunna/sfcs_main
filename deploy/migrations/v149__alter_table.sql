/*1132*/
ALTER TABLE bai_pro3.module_master  DROP COLUMN block_priorities,   ADD COLUMN block_priorities INT(11) DEFAULT 20 NOT NULL AFTER module_name;