/*#1034 sql script
USE m3_inputs;*/

CREATE TABLE m3_inputs.bom_details (
  id int(11) NOT NULL AUTO_INCREMENT,
  date_time datetime DEFAULT NULL,
  mo_no varchar(255) DEFAULT NULL,
  plant_code varchar(255) DEFAULT NULL,
  item_code varchar(255) DEFAULT NULL COMMENT 'SKU',
  item_description varchar(255) DEFAULT NULL,
  color varchar(255) DEFAULT NULL,
  color_description varchar(255) DEFAULT NULL,
  size varchar(255) DEFAULT NULL,
  z_code varchar(255) DEFAULT NULL,
  per_piece_consumption varchar(255) DEFAULT NULL,
  wastage varchar(255) DEFAULT NULL,
  uom varchar(255) DEFAULT NULL,
  material_sequence varchar(15) DEFAULT NULL,
  product_no varchar(40) DEFAULT NULL,
  operation_code varchar(15) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;