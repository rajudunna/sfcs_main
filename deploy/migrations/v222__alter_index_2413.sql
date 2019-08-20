/*#2413 table column missed from  #2132 */


DROP TABLE IF EXISTS `bai_pro3`.`carton_packing_details`;

CREATE TABLE  `bai_pro3`.`carton_packing_details`
(
  `id` INT
(11) NOT NULL AUTO_INCREMENT,
  `carton_id` VARCHAR
(20) DEFAULT NULL,
  `operation_id` VARCHAR
(10) DEFAULT NULL,
  `pack_code` VARCHAR
(20) DEFAULT NULL,
  `pack_desc` VARCHAR
(200) DEFAULT NULL,
  `pack_smv` FLOAT NULL,
  `pack_team` VARCHAR
(20) NULL,
  `scan_time` TIMESTAMP,
  PRIMARY KEY
(`id`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1; 
