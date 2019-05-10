USE `bai_pro3`;

/*#1853 Function  structure for function  `fn_know_binding_con_v2` */

/*!50003 DROP FUNCTION IF EXISTS `bai_pro3`.`fn_know_binding_con_v2` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `bai_pro3`.`fn_know_binding_con_v2`(ord_id VARCHAR(200),category VARCHAR(100),cat_ref INT(10)) RETURNS float(10,4)
BEGIN
DECLARE bin_con FLOAT(10,4);
SET @bin_con = ((SELECT COALESCE(binding_consumption,0) FROM bai_pro3.cat_stat_log WHERE order_tid=ord_id AND tid=cat_ref));
RETURN COALESCE(@bin_con,0);
END */$$
DELIMITER ;