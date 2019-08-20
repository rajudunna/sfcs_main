/*#2339 alter queries for indexing*/


USE `m3_inputs`;

ALTER TABLE `m3_inputs`.`bom_details`
ADD KEY `mo_no`
(`mo_no`);

ALTER TABLE `m3_inputs`.`shipment_plan` CHANGE `Style_No` `Style_No` VARCHAR
(40)  NULL, CHANGE `Schedule_No` `Schedule_No` VARCHAR
(40)  NULL, CHANGE `Colour` `Colour` VARCHAR
(40)  NULL,
ADD KEY `style_sch_color`
(`Style_No`, `Schedule_No`, `Colour`);
ALTER TABLE `m3_inputs`.`shipment_plan_original` CHANGE `Style_No` `Style_No` VARCHAR
(40) CHARSET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `Schedule_No` `Schedule_No` VARCHAR
(40) CHARSET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `Colour` `Colour` VARCHAR
(40) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
ADD KEY `style_sch_color`
(`Style_No`, `Schedule_No`, `Colour`);

ALTER TABLE `m3_inputs`.`mo_details`
ADD KEY `check_mo_status`
(`COLOURDESC`, `SIZEDESC`, `SCHEDULE`, `STYLE`, `REFORDLINE`);

ALTER TABLE `m3_inputs`.`order_details` CHANGE `Style` `Style` VARCHAR
(40) CHARSET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `Schedule` `Schedule` VARCHAR
(40) CHARSET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `GMT_Color` `GMT_Color` VARCHAR
(40) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
ADD KEY `style_sch_color`
(`Style`, `Schedule`, `GMT_Color`);

ALTER TABLE `m3_inputs`.`order_details_original` CHANGE `Style` `Style` VARCHAR
(40) CHARSET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `Schedule` `Schedule` VARCHAR
(40) CHARSET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `GMT_Color` `GMT_Color` VARCHAR
(40) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
ADD KEY `style_sch_color`
(`Style`, `Schedule`, `GMT_Color`);

USE `bai_pro3`;

ALTER TABLE `bai_pro3`.`schedule_oprations_master`
ADD KEY `schedule_opr_master_ix5`
(`Style`, `Description`, `OperationNumber`);

ALTER TABLE `bai_pro3`.`bai_orders_db`
ADD KEY `color_code`
(`color_code`);

ALTER TABLE `bai_pro3`.`order_plan`
ADD KEY `style_no`
(`style_no`),
ADD KEY `schedule`
(`schedule_no`),
ADD KEY `color`
(`col_des`);

USE `bai_pro2`;

ALTER TABLE `bai_pro2`.`shipment_plan`
ADD KEY `style_id`
(`style_id`);

ALTER TABLE `bai_pro2`.`shipment_plan_summ`
ADD KEY `style_id`
(`style_id`);

USE `brandix_bts`;

ALTER TABLE `brandix_bts`.`tbl_orders_ops_ref`
ADD KEY `category`
(`category`); 




