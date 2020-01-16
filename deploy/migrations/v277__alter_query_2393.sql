
/*#2393 alter query */

USE `bai_pro3`;

ALTER TABLE `bai_pro3`.`line_forecast` ADD KEY `ind_date_module` (`module`, `date`);

USE `bai_pro2`;

ALTER TABLE `bai_pro2`.`hout` ADD KEY `ind_team_out_date`(`out_date`, `team`);

ALTER TABLE `bai_pro2`.`fr_data` ADD KEY `ind_team_frdate` (`frdate`, `team`);

ALTER TABLE bai_pro2.hout ADD COLUMN style VARCHAR(20) NULL AFTER time_parent_id, ADD COLUMN color VARCHAR (225) NULL AFTER style, ADD COLUMN smv VARCHAR (20) NULL AFTER color, ADD COLUMN bcd_id INT (15) NULL AFTER smv;

ALTER TABLE `bai_pro2`.`hout` CHANGE `smv` `smv` DECIMAL (10,4) NULL;

ALTER TABLE `bai_pro2`.`fr_data` CHANGE `smv` `smv` DECIMAL (10,4) NULL;

ALTER TABLE `bai_pro2`.`hout` ADD KEY `style_smv` (`style`, `smv`);

UPDATE bai_pro2.hout AS h LEFT JOIN bai_pro2.fr_data AS fr ON h.out_date=fr.frdate AND h.team=fr.team SET h.style=fr.style,h.color=fr.color,h.smv=fr.smv;