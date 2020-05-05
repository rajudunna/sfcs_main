/*#3644 Alter view and Create Function queries*/

DELIMITER $$

USE `bai_pro3`$$

DROP FUNCTION IF EXISTS `fn_act_ship_qty`$$

CREATE FUNCTION `fn_act_ship_qty`(in_sch_no BIGINT) RETURNS INT(11)
BEGIN
	DECLARE var_name INT;
	  SET var_name = 0;
	  /*SET var_name=(SELECT COALESCE(SUM(shipped),0) FROM bai_ship_cts_ref WHERE ship_schedule=in_sch_no);*/
	  SET var_name=(SELECT
  COALESCE(SUM(`ship_stat_log`.`ship_s_s01` + `ship_stat_log`.`ship_s_s02` + `ship_stat_log`.`ship_s_s03` + `ship_stat_log`.`ship_s_s04` + `ship_stat_log`.`ship_s_s05` + `ship_stat_log`.`ship_s_s06` + `ship_stat_log`.`ship_s_s07` + `ship_stat_log`.`ship_s_s08` + `ship_stat_log`.`ship_s_s09` + `ship_stat_log`.`ship_s_s10` + `ship_stat_log`.`ship_s_s11` + `ship_stat_log`.`ship_s_s12` + `ship_stat_log`.`ship_s_s13` + `ship_stat_log`.`ship_s_s14` + `ship_stat_log`.`ship_s_s15` + `ship_stat_log`.`ship_s_s16` + `ship_stat_log`.`ship_s_s17` + `ship_stat_log`.`ship_s_s18` + `ship_stat_log`.`ship_s_s19` + `ship_stat_log`.`ship_s_s20` + `ship_stat_log`.`ship_s_s21` + `ship_stat_log`.`ship_s_s22` + `ship_stat_log`.`ship_s_s23` + `ship_stat_log`.`ship_s_s24` + `ship_stat_log`.`ship_s_s25` + `ship_stat_log`.`ship_s_s26` + `ship_stat_log`.`ship_s_s27` + `ship_stat_log`.`ship_s_s28` + `ship_stat_log`.`ship_s_s29` + `ship_stat_log`.`ship_s_s30` + `ship_stat_log`.`ship_s_s31` + `ship_stat_log`.`ship_s_s32` + `ship_stat_log`.`ship_s_s33` + `ship_stat_log`.`ship_s_s34` + `ship_stat_log`.`ship_s_s35` + `ship_stat_log`.`ship_s_s36` + `ship_stat_log`.`ship_s_s37` + `ship_stat_log`.`ship_s_s38` + `ship_stat_log`.`ship_s_s39` + `ship_stat_log`.`ship_s_s40` + `ship_stat_log`.`ship_s_s41` + `ship_stat_log`.`ship_s_s42` + `ship_stat_log`.`ship_s_s43` + `ship_stat_log`.`ship_s_s44` + `ship_stat_log`.`ship_s_s45` + `ship_stat_log`.`ship_s_s46` + `ship_stat_log`.`ship_s_s47` + `ship_stat_log`.`ship_s_s48` + `ship_stat_log`.`ship_s_s49` + `ship_stat_log`.`ship_s_s50`),0) AS `shipped`
FROM `ship_stat_log`
WHERE (ship_schedule=in_sch_no AND `ship_stat_log`.`ship_status` = 2));
	  RETURN var_name;
    END$$

DELIMITER ;

DELIMITER $$

USE `bai_pro3`$$

ALTER VIEW `bai_ship_cts_ref` AS (
SELECT
  SUM(`ship_stat_log`.`ship_s_s01` + `ship_stat_log`.`ship_s_s02` + `ship_stat_log`.`ship_s_s03` + `ship_stat_log`.`ship_s_s04` + `ship_stat_log`.`ship_s_s05` + `ship_stat_log`.`ship_s_s06` + `ship_stat_log`.`ship_s_s07` + `ship_stat_log`.`ship_s_s08` + `ship_stat_log`.`ship_s_s09` + `ship_stat_log`.`ship_s_s10` + `ship_stat_log`.`ship_s_s11` + `ship_stat_log`.`ship_s_s12` + `ship_stat_log`.`ship_s_s13` + `ship_stat_log`.`ship_s_s14` + `ship_stat_log`.`ship_s_s15` + `ship_stat_log`.`ship_s_s16` + `ship_stat_log`.`ship_s_s17` + `ship_stat_log`.`ship_s_s18` + `ship_stat_log`.`ship_s_s19` + `ship_stat_log`.`ship_s_s20` + `ship_stat_log`.`ship_s_s21` + `ship_stat_log`.`ship_s_s22` + `ship_stat_log`.`ship_s_s23` + `ship_stat_log`.`ship_s_s24` + `ship_stat_log`.`ship_s_s25` + `ship_stat_log`.`ship_s_s26` + `ship_stat_log`.`ship_s_s27` + `ship_stat_log`.`ship_s_s28` + `ship_stat_log`.`ship_s_s29` + `ship_stat_log`.`ship_s_s30` + `ship_stat_log`.`ship_s_s31` + `ship_stat_log`.`ship_s_s32` + `ship_stat_log`.`ship_s_s33` + `ship_stat_log`.`ship_s_s34` + `ship_stat_log`.`ship_s_s35` + `ship_stat_log`.`ship_s_s36` + `ship_stat_log`.`ship_s_s37` + `ship_stat_log`.`ship_s_s38` + `ship_stat_log`.`ship_s_s39` + `ship_stat_log`.`ship_s_s40` + `ship_stat_log`.`ship_s_s41` + `ship_stat_log`.`ship_s_s42` + `ship_stat_log`.`ship_s_s43` + `ship_stat_log`.`ship_s_s44` + `ship_stat_log`.`ship_s_s45` + `ship_stat_log`.`ship_s_s46` + `ship_stat_log`.`ship_s_s47` + `ship_stat_log`.`ship_s_s48` + `ship_stat_log`.`ship_s_s49` + `ship_stat_log`.`ship_s_s50`) AS `shipped`,
  `ship_stat_log`.`ship_style`    AS `ship_style`,
  `ship_stat_log`.`ship_schedule` AS `ship_schedule`,
  GROUP_CONCAT(`ship_stat_log`.`disp_note_no` SEPARATOR ',') AS `disp_note_ref`
FROM `ship_stat_log`
WHERE (`ship_stat_log`.`ship_status` = 2)
GROUP BY `ship_stat_log`.`ship_schedule`)$$

DELIMITER ;