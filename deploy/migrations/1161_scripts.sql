ALTER TABLE `brandix_bts`.`bundle_creation_data` ADD KEY `bcd_ix4` (`bundle_number`), ADD KEY `bcd_ix5` (`docket_number`, `size_id`, `operation_id`), ADD KEY `bcd_ix6` (`input_job_no_random_ref`, `operation_id`, `assigned_module`);


/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

USE `m3_inputs`;
TRUNCATE TABLE `m3_inputs`.`order_details_temp`;
TRUNCATE TABLE `m3_inputs`.`shipment_plan_temp`;
/* Alter table in target */
ALTER TABLE `order_details` 
 CHANGE `Facility` `Facility` varchar(5)  COLLATE latin1_swedish_ci NULL after `sno` , 
 CHANGE `Customer_Style_No` `Customer_Style_No` varchar(45)  COLLATE latin1_swedish_ci NULL after `Facility` , 
 CHANGE `CPO_NO` `CPO_NO` varchar(45)  COLLATE latin1_swedish_ci NULL after `Customer_Style_No` , 
 CHANGE `VPO_NO` `VPO_NO` varchar(30)  COLLATE latin1_swedish_ci NULL after `CPO_NO` , 
 CHANGE `CO_no` `CO_no` varchar(15)  COLLATE latin1_swedish_ci NULL after `VPO_NO` , 
 CHANGE `Style` `Style` varchar(15)  COLLATE latin1_swedish_ci NULL after `CO_no` , 
 CHANGE `Schedule` `Schedule` varchar(15)  COLLATE latin1_swedish_ci NULL after `Style` , 
 CHANGE `Manufacturing_Schedule_no` `Manufacturing_Schedule_no` varchar(50)  COLLATE latin1_swedish_ci NULL after `Schedule` , 
 CHANGE `MO_Split_Method` `MO_Split_Method` varchar(10)  COLLATE latin1_swedish_ci NULL after `Manufacturing_Schedule_no` , 
 CHANGE `MO_Released_Status_Y_N` `MO_Released_Status_Y_N` varchar(5)  COLLATE latin1_swedish_ci NULL after `MO_Split_Method` , 
 CHANGE `GMT_Color` `GMT_Color` varchar(45)  COLLATE latin1_swedish_ci NULL after `MO_Released_Status_Y_N` , 
 CHANGE `GMT_Size` `GMT_Size` varchar(15)  COLLATE latin1_swedish_ci NULL after `GMT_Color` , 
 CHANGE `GMT_Z_Feature` `GMT_Z_Feature` varchar(15)  COLLATE latin1_swedish_ci NULL after `GMT_Size` , 
 CHANGE `Graphic_Number` `Graphic_Number` varchar(45)  COLLATE latin1_swedish_ci NULL after `GMT_Z_Feature` , 
 CHANGE `CO_Qty` `CO_Qty` int(11)   NULL after `Graphic_Number` , 
 CHANGE `MO_Qty` `MO_Qty` int(11)   NULL after `CO_Qty` , 
 CHANGE `PCD` `PCD` int(8)   NULL after `MO_Qty` , 
 CHANGE `Plan_Delivery_Date` `Plan_Delivery_Date` int(8)   NULL after `PCD` , 
 CHANGE `Destination` `Destination` varchar(10)  COLLATE latin1_swedish_ci NULL after `Plan_Delivery_Date` , 
 CHANGE `Packing_Method` `Packing_Method` varchar(5)  COLLATE latin1_swedish_ci NULL after `Destination` , 
 CHANGE `Item_Code` `Item_Code` varbinary(20)   NULL after `Packing_Method` , 
 CHANGE `Item_Description` `Item_Description` text  COLLATE latin1_swedish_ci NULL after `Item_Code` , 
 CHANGE `RM_Color_Description` `RM_Color_Description` text  COLLATE latin1_swedish_ci NULL after `Item_Description` , 
 CHANGE `Order_YY_WO_Wastage` `Order_YY_WO_Wastage` varchar(16)  COLLATE latin1_swedish_ci NULL after `RM_Color_Description` , 
 CHANGE `Wastage` `Wastage` varchar(10)  COLLATE latin1_swedish_ci NULL after `Order_YY_WO_Wastage` , 
 CHANGE `Required_Qty` `Required_Qty` varchar(15)  COLLATE latin1_swedish_ci NULL after `Wastage` , 
 CHANGE `UOM` `UOM` varchar(10)  COLLATE latin1_swedish_ci NULL after `Required_Qty` , 
 CHANGE `A15NEXT` `A15NEXT` varchar(10)  COLLATE latin1_swedish_ci NULL after `UOM` , 
 CHANGE `A15` `A15` varchar(10)  COLLATE latin1_swedish_ci NULL after `A15NEXT` , 
 CHANGE `A20` `A20` varchar(10)  COLLATE latin1_swedish_ci NULL after `A15` , 
 CHANGE `A30` `A30` varchar(10)  COLLATE latin1_swedish_ci NULL after `A20` , 
 CHANGE `A40` `A40` varchar(10)  COLLATE latin1_swedish_ci NULL after `A30` , 
 CHANGE `A50` `A50` varchar(10)  COLLATE latin1_swedish_ci NULL after `A40` , 
 CHANGE `A60` `A60` varchar(10)  COLLATE latin1_swedish_ci NULL after `A50` , 
 CHANGE `A70` `A70` varchar(10)  COLLATE latin1_swedish_ci NULL after `A60` , 
 CHANGE `A75` `A75` varchar(10)  COLLATE latin1_swedish_ci NULL after `A70` , 
 CHANGE `A80` `A80` varchar(10)  COLLATE latin1_swedish_ci NULL after `A75` , 
 CHANGE `A90` `A90` varchar(10)  COLLATE latin1_swedish_ci NULL after `A80` , 
 CHANGE `A100` `A100` varchar(10)  COLLATE latin1_swedish_ci NULL after `A90` , 
 CHANGE `A110` `A110` varchar(10)  COLLATE latin1_swedish_ci NULL after `A100` , 
 CHANGE `A115` `A115` varchar(10)  COLLATE latin1_swedish_ci NULL after `A110` , 
 CHANGE `A120` `A120` varchar(10)  COLLATE latin1_swedish_ci NULL after `A115` , 
 CHANGE `A125` `A125` varchar(10)  COLLATE latin1_swedish_ci NULL after `A120` , 
 CHANGE `A130` `A130` varchar(10)  COLLATE latin1_swedish_ci NULL after `A125` , 
 CHANGE `A140` `A140` varchar(10)  COLLATE latin1_swedish_ci NULL after `A130` , 
 CHANGE `A143` `A143` varchar(10)  COLLATE latin1_swedish_ci NULL after `A140` , 
 CHANGE `A144` `A144` varchar(10)  COLLATE latin1_swedish_ci NULL after `A143` , 
 CHANGE `A147` `A147` varchar(10)  COLLATE latin1_swedish_ci NULL after `A144` , 
 CHANGE `A148` `A148` varchar(10)  COLLATE latin1_swedish_ci NULL after `A147` , 
 CHANGE `A150` `A150` varchar(10)  COLLATE latin1_swedish_ci NULL after `A148` , 
 CHANGE `A160` `A160` varchar(10)  COLLATE latin1_swedish_ci NULL after `A150` , 
 CHANGE `A170` `A170` varchar(10)  COLLATE latin1_swedish_ci NULL after `A160` , 
 CHANGE `A175` `A175` varchar(10)  COLLATE latin1_swedish_ci NULL after `A170` , 
 CHANGE `A180` `A180` varchar(10)  COLLATE latin1_swedish_ci NULL after `A175` , 
 CHANGE `A190` `A190` varchar(10)  COLLATE latin1_swedish_ci NULL after `A180` , 
 CHANGE `A200` `A200` varchar(10)  COLLATE latin1_swedish_ci NULL after `A190` , 
 CHANGE `MO_NUMBER` `MO_NUMBER` int(11)   NULL after `A200` , 
 CHANGE `SEQ_NUMBER` `SEQ_NUMBER` int(11)   NULL after `MO_NUMBER` , 
 ADD KEY `Order_details_ix1`(`Style`,`Schedule`,`GMT_Color`,`GMT_Size`) ;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

USE `m3_inputs`;

ALTER TABLE `order_details_original` 
 CHANGE `Facility` `Facility` varchar(5)  COLLATE latin1_swedish_ci NULL after `sno` , 
 CHANGE `Customer_Style_No` `Customer_Style_No` varchar(45)  COLLATE latin1_swedish_ci NULL after `Facility` , 
 CHANGE `CPO_NO` `CPO_NO` varchar(45)  COLLATE latin1_swedish_ci NULL after `Customer_Style_No` , 
 CHANGE `VPO_NO` `VPO_NO` varchar(30)  COLLATE latin1_swedish_ci NULL after `CPO_NO` , 
 CHANGE `CO_no` `CO_no` varchar(15)  COLLATE latin1_swedish_ci NULL after `VPO_NO` , 
 CHANGE `Style` `Style` varchar(15)  COLLATE latin1_swedish_ci NULL after `CO_no` , 
 CHANGE `Schedule` `Schedule` varchar(15)  COLLATE latin1_swedish_ci NULL after `Style` , 
 CHANGE `Manufacturing_Schedule_no` `Manufacturing_Schedule_no` varchar(50)  COLLATE latin1_swedish_ci NULL after `Schedule` , 
 CHANGE `MO_Split_Method` `MO_Split_Method` varchar(10)  COLLATE latin1_swedish_ci NULL after `Manufacturing_Schedule_no` , 
 CHANGE `MO_Released_Status_Y_N` `MO_Released_Status_Y_N` varchar(5)  COLLATE latin1_swedish_ci NULL after `MO_Split_Method` , 
 CHANGE `GMT_Color` `GMT_Color` varchar(45)  COLLATE latin1_swedish_ci NULL after `MO_Released_Status_Y_N` , 
 CHANGE `GMT_Size` `GMT_Size` varchar(15)  COLLATE latin1_swedish_ci NULL after `GMT_Color` , 
 CHANGE `GMT_Z_Feature` `GMT_Z_Feature` varchar(15)  COLLATE latin1_swedish_ci NULL after `GMT_Size` , 
 CHANGE `Graphic_Number` `Graphic_Number` varchar(45)  COLLATE latin1_swedish_ci NULL after `GMT_Z_Feature` , 
 CHANGE `CO_Qty` `CO_Qty` int(11)   NULL after `Graphic_Number` , 
 CHANGE `MO_Qty` `MO_Qty` int(11)   NULL after `CO_Qty` , 
 CHANGE `PCD` `PCD` int(8)   NULL after `MO_Qty` , 
 CHANGE `Plan_Delivery_Date` `Plan_Delivery_Date` int(8)   NULL after `PCD` , 
 CHANGE `Destination` `Destination` varchar(10)  COLLATE latin1_swedish_ci NULL after `Plan_Delivery_Date` , 
 CHANGE `Packing_Method` `Packing_Method` varchar(5)  COLLATE latin1_swedish_ci NULL after `Destination` , 
 CHANGE `Item_Code` `Item_Code` varbinary(20)   NULL after `Packing_Method` , 
 CHANGE `Item_Description` `Item_Description` text  COLLATE latin1_swedish_ci NULL after `Item_Code` , 
 CHANGE `RM_Color_Description` `RM_Color_Description` text  COLLATE latin1_swedish_ci NULL after `Item_Description` , 
 CHANGE `Order_YY_WO_Wastage` `Order_YY_WO_Wastage` varchar(16)  COLLATE latin1_swedish_ci NULL after `RM_Color_Description` , 
 CHANGE `Wastage` `Wastage` varchar(10)  COLLATE latin1_swedish_ci NULL after `Order_YY_WO_Wastage` , 
 CHANGE `Required_Qty` `Required_Qty` varchar(15)  COLLATE latin1_swedish_ci NULL after `Wastage` , 
 CHANGE `UOM` `UOM` varchar(10)  COLLATE latin1_swedish_ci NULL after `Required_Qty` , 
 CHANGE `A15NEXT` `A15NEXT` varchar(10)  COLLATE latin1_swedish_ci NULL after `UOM` , 
 CHANGE `A15` `A15` varchar(10)  COLLATE latin1_swedish_ci NULL after `A15NEXT` , 
 CHANGE `A20` `A20` varchar(10)  COLLATE latin1_swedish_ci NULL after `A15` , 
 CHANGE `A30` `A30` varchar(10)  COLLATE latin1_swedish_ci NULL after `A20` , 
 CHANGE `A40` `A40` varchar(10)  COLLATE latin1_swedish_ci NULL after `A30` , 
 CHANGE `A50` `A50` varchar(10)  COLLATE latin1_swedish_ci NULL after `A40` , 
 CHANGE `A60` `A60` varchar(10)  COLLATE latin1_swedish_ci NULL after `A50` , 
 CHANGE `A70` `A70` varchar(10)  COLLATE latin1_swedish_ci NULL after `A60` , 
 CHANGE `A75` `A75` varchar(10)  COLLATE latin1_swedish_ci NULL after `A70` , 
 CHANGE `A80` `A80` varchar(10)  COLLATE latin1_swedish_ci NULL after `A75` , 
 CHANGE `A90` `A90` varchar(10)  COLLATE latin1_swedish_ci NULL after `A80` , 
 CHANGE `A100` `A100` varchar(10)  COLLATE latin1_swedish_ci NULL after `A90` , 
 CHANGE `A110` `A110` varchar(10)  COLLATE latin1_swedish_ci NULL after `A100` , 
 CHANGE `A115` `A115` varchar(10)  COLLATE latin1_swedish_ci NULL after `A110` , 
 CHANGE `A120` `A120` varchar(10)  COLLATE latin1_swedish_ci NULL after `A115` , 
 CHANGE `A125` `A125` varchar(10)  COLLATE latin1_swedish_ci NULL after `A120` , 
 CHANGE `A130` `A130` varchar(10)  COLLATE latin1_swedish_ci NULL after `A125` , 
 CHANGE `A140` `A140` varchar(10)  COLLATE latin1_swedish_ci NULL after `A130` , 
 CHANGE `A143` `A143` varchar(10)  COLLATE latin1_swedish_ci NULL after `A140` , 
 CHANGE `A144` `A144` varchar(10)  COLLATE latin1_swedish_ci NULL after `A143` , 
 CHANGE `A147` `A147` varchar(10)  COLLATE latin1_swedish_ci NULL after `A144` , 
 CHANGE `A148` `A148` varchar(10)  COLLATE latin1_swedish_ci NULL after `A147` , 
 CHANGE `A150` `A150` varchar(10)  COLLATE latin1_swedish_ci NULL after `A148` , 
 CHANGE `A160` `A160` varchar(10)  COLLATE latin1_swedish_ci NULL after `A150` , 
 CHANGE `A170` `A170` varchar(10)  COLLATE latin1_swedish_ci NULL after `A160` , 
 CHANGE `A175` `A175` varchar(10)  COLLATE latin1_swedish_ci NULL after `A170` , 
 CHANGE `A180` `A180` varchar(10)  COLLATE latin1_swedish_ci NULL after `A175` , 
 CHANGE `A190` `A190` varchar(10)  COLLATE latin1_swedish_ci NULL after `A180` , 
 CHANGE `A200` `A200` varchar(10)  COLLATE latin1_swedish_ci NULL after `A190` , 
 CHANGE `MO_NUMBER` `MO_NUMBER` int(11)   NULL after `A200` , 
 CHANGE `SEQ_NUMBER` `SEQ_NUMBER` int(11)   NULL after `MO_NUMBER` , 
 ADD KEY `order_details_original_ix1`(`Style`,`Schedule`,`GMT_Color`,`GMT_Size`) ;


ALTER TABLE `brandix_bts`.`bundle_creation_data_temp`   
  CHANGE `style` `style` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `schedule` `schedule` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `color` `color` VARCHAR(45) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `size_id` `size_id` VARCHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `bundle_status` `bundle_status` VARCHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci DEFAULT 'OPEN' NULL,
  CHANGE `split_status` `split_status` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `scanned_user` `scanned_user` VARCHAR(50) CHARSET latin1 COLLATE latin1_swedish_ci NULL, 
  ADD  KEY `bcdt_ix5` (`schedule`, `input_job_no`);


ALTER TABLE `m3_inputs`.`shipment_plan`   
  CHANGE `Customer_Order_No` `Customer_Order_No` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `CO_Line_Status` `CO_Line_Status` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Ex_Factory` `Ex_Factory` INT(8) NULL,
  CHANGE `Order_Qty` `Order_Qty` INT(11) NULL,
  CHANGE `Mode` `Mode` VARCHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Destination` `Destination` VARCHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Packing_Method` `Packing_Method` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `FOB_Price_per_piece` `FOB_Price_per_piece` VARCHAR(15) NULL,
  CHANGE `MPO` `MPO` VARCHAR(45) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `CPO` `CPO` VARCHAR(45) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `DBFDST` `DBFDST` VARCHAR(15) NULL,
  CHANGE `Size` `Size` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `HMTY15` `HMTY15` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `ZFeature` `ZFeature` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `MMBUAR` `MMBUAR` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Style_No` `Style_No` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Product` `Product` VARCHAR(45) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Buyer_Division` `Buyer_Division` VARCHAR(45) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Buyer` `Buyer` VARCHAR(45) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `CM_Value` `CM_Value` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Schedule_No` `Schedule_No` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Colour` `Colour` VARCHAR(45) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `EMB_A` `EMB_A` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `EMB_B` `EMB_B` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `EMB_C` `EMB_C` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `EMB_D` `EMB_D` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `EMB_E` `EMB_E` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `EMB_F` `EMB_F` varchar(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `EMB_G` `EMB_G` varchar(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `EMB_H` `EMB_H` varchar(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `Alloc_Qty` `Alloc_Qty` varchar(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `Dsptched_Qty` `Dsptched_Qty` varchar(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `BTS_vs_Ord_Qty` `BTS_vs_Ord_Qty` varchar(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `BTS_vs_FG_Qty` `BTS_vs_FG_Qty` varchar(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  add  index `ship_plan_ix1` (`Style_No`, `Schedule_No`, `Size`, `Colour`, `Destination`);

ALTER TABLE `m3_inputs`.`shipment_plan_original`   
  CHANGE `Customer_Order_No` `Customer_Order_No` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `CO_Line_Status` `CO_Line_Status` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Ex_Factory` `Ex_Factory` INT(8) NULL,
  CHANGE `Order_Qty` `Order_Qty` INT(11) NULL,
  CHANGE `Mode` `Mode` VARCHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Destination` `Destination` VARCHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Packing_Method` `Packing_Method` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `FOB_Price_per_piece` `FOB_Price_per_piece` VARCHAR(15) NULL,
  CHANGE `MPO` `MPO` VARCHAR(45) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `CPO` `CPO` VARCHAR(45) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `DBFDST` `DBFDST` VARCHAR(15) NULL,
  CHANGE `Size` `Size` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `HMTY15` `HMTY15` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `ZFeature` `ZFeature` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `MMBUAR` `MMBUAR` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Style_No` `Style_No` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Product` `Product` VARCHAR(45) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Buyer_Division` `Buyer_Division` VARCHAR(45) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Buyer` `Buyer` VARCHAR(45) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `CM_Value` `CM_Value` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Schedule_No` `Schedule_No` VARCHAR(15) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `Colour` `Colour` VARCHAR(45) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `EMB_A` `EMB_A` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `EMB_B` `EMB_B` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `EMB_C` `EMB_C` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `EMB_D` `EMB_D` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  CHANGE `EMB_E` `EMB_E` VARCHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `EMB_F` `EMB_F` varchar(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `EMB_G` `EMB_G` varchar(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `EMB_H` `EMB_H` varchar(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `Alloc_Qty` `Alloc_Qty` varchar(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `Dsptched_Qty` `Dsptched_Qty` varchar(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `BTS_vs_Ord_Qty` `BTS_vs_Ord_Qty` varchar(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `BTS_vs_FG_Qty` `BTS_vs_FG_Qty` varchar(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  add  index `ship_plan_org_ix1` (`Style_No`, `Schedule_No`, `Size`, `Colour`, `Destination`);


ALTER TABLE `brandix_bts`.`bundle_creation_data` ADD INDEX `bcd_ix7` (`operation_id`, `schedule`, `color`);

ALTER TABLE `central_administration_sfcs`.`tbl_view_view_menu` ADD KEY `tbl_vw_vw_menu` (`page_id`, `user_name`, `group_id`);

ALTER TABLE `bai_pro3`.`m3_transactions` ADD KEY `m3_transaction_ix2` (`date_time`); 

/*ALTER TABLE `bai_pro3`.`cat_stat_log` ADD KEY `cat_stat_log_ix5` (`order_tid`); 
ALTER TABLE `bai_pro3`.`pac_stat_log_input_job` ADD INDEX `pac_stat_lg_in_jb_ix1` (`input_job_no_random`);*/



/*#116 Cut table dashboard Queries*/

ALTER TABLE `bai_pro3`.`mo_details` ADD COLUMN `vpo` VARCHAR(20) NULL AFTER `shipment_master_status`, ADD COLUMN `startdate` DATE NULL AFTER `vpo`, ADD COLUMN `coplandeldate` DATE NULL AFTER `startdate`, ADD COLUMN `referenceorder` VARCHAR(40) NULL AFTER `coplandeldate`; 

ALTER TABLE `bai_pro3`.`order_plan` ADD COLUMN `order_status` INT(11) DEFAULT 0 NULL AFTER `material_sequence`; 

ALTER TABLE `bai_pro3`.`shipment_plan` ADD COLUMN `shipment_status` INT(11) DEFAULT 0 NULL AFTER `order_no`; 

ALTER TABLE `bai_pro3`.`order_plan` CHANGE `order_status` `order_status` INT(11) DEFAULT 0 NOT NULL, ADD COLUMN `required_qty` FLOAT(10,4) NOT NULL AFTER `order_status`; 

ALTER TABLE `bai_pro3`.`order_plan` ADD COLUMN `VPO_NO` VARCHAR(200) NOT NULL AFTER `required_qty`; 

ALTER TABLE `bai_pro3`.`shipment_plan` ADD COLUMN `Customer_Order_No` INT(11) NULL AFTER `shipment_status`;




/*
C:\xampp\htdocs\sfcs_main\sfcs_app\app\production\controllers\bundle_cut
C:\xampp\htdocs\sfcs_main\sfcs_app\app\production\controllers\bundle_mul

C:\xampp\htdocs\sfcs_main\sfcs_app\app\production\reports\bundle_cut
C:\xampp\htdocs\sfcs_main\sfcs_app\app\production\reports\bundle_mul
*/
