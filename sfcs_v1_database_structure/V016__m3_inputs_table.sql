/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - m3_inputs
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`m3_inputs` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `m3_inputs`;

/*Table structure for table `order_details` */

DROP TABLE IF EXISTS `order_details`;

CREATE TABLE `order_details` (
  `sno` bigint(20) NOT NULL AUTO_INCREMENT,
  `Facility` longtext DEFAULT NULL,
  `Customer_Style_No` longtext DEFAULT NULL,
  `CPO_NO` longtext DEFAULT NULL,
  `VPO_NO` longtext DEFAULT NULL,
  `CO_no` longtext DEFAULT NULL,
  `Style` longtext DEFAULT NULL,
  `Schedule` longtext DEFAULT NULL,
  `Manufacturing_Schedule_no` longtext DEFAULT NULL,
  `MO_Split_Method` longtext DEFAULT NULL,
  `MO_Released_Status_Y_N` longtext DEFAULT NULL,
  `GMT_Color` longtext DEFAULT NULL,
  `GMT_Size` longtext DEFAULT NULL,
  `GMT_Z_Feature` longtext DEFAULT NULL,
  `Graphic_Number` longtext DEFAULT NULL,
  `CO_Qty` longtext DEFAULT NULL,
  `MO_Qty` longtext DEFAULT NULL,
  `PCD` longtext DEFAULT NULL,
  `Plan_Delivery_Date` longtext DEFAULT NULL,
  `Destination` longtext DEFAULT NULL,
  `Packing_Method` longtext DEFAULT NULL,
  `Item_Code` longtext DEFAULT NULL,
  `Item_Description` longtext DEFAULT NULL,
  `RM_Color_Description` longtext DEFAULT NULL,
  `Order_YY_WO_Wastage` longtext DEFAULT NULL,
  `Wastage` longtext DEFAULT NULL,
  `Required_Qty` longtext DEFAULT NULL,
  `UOM` longtext DEFAULT NULL,
  `A15NEXT` longtext DEFAULT NULL,
  `A15` longtext DEFAULT NULL,
  `A20` longtext DEFAULT NULL,
  `A30` longtext DEFAULT NULL,
  `A40` longtext DEFAULT NULL,
  `A50` longtext DEFAULT NULL,
  `A60` longtext DEFAULT NULL,
  `A70` longtext DEFAULT NULL,
  `A75` longtext DEFAULT NULL,
  `A80` longtext DEFAULT NULL,
  `A90` longtext DEFAULT NULL,
  `A100` longtext DEFAULT NULL,
  `A110` longtext DEFAULT NULL,
  `A115` longtext DEFAULT NULL,
  `A120` longtext DEFAULT NULL,
  `A125` longtext DEFAULT NULL,
  `A130` longtext DEFAULT NULL,
  `A140` longtext DEFAULT NULL,
  `A143` longtext DEFAULT NULL,
  `A144` longtext DEFAULT NULL,
  `A147` longtext DEFAULT NULL,
  `A148` longtext DEFAULT NULL,
  `A150` longtext DEFAULT NULL,
  `A160` longtext DEFAULT NULL,
  `A170` longtext DEFAULT NULL,
  `A175` longtext DEFAULT NULL,
  `A180` longtext DEFAULT NULL,
  `A190` longtext DEFAULT NULL,
  `A200` longtext DEFAULT NULL,
  `MO_NUMBER` longtext DEFAULT NULL,
  `SEQ_NUMBER` longtext DEFAULT NULL,
  `time_stamp` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB AUTO_INCREMENT=6773 DEFAULT CHARSET=latin1;

/*Table structure for table `shipment_plan` */

DROP TABLE IF EXISTS `shipment_plan`;

CREATE TABLE `shipment_plan` (
  `sno` bigint(20) NOT NULL AUTO_INCREMENT,
  `Customer_Order_No` longtext DEFAULT NULL,
  `CO_Line_Status` longtext DEFAULT NULL,
  `Ex_Factory` longtext DEFAULT NULL,
  `Order_Qty` longtext DEFAULT NULL,
  `Mode` longtext DEFAULT NULL,
  `Destination` longtext DEFAULT NULL,
  `Packing_Method` longtext DEFAULT NULL,
  `FOB_Price_per_piece` longtext DEFAULT NULL,
  `MPO` longtext DEFAULT NULL,
  `CPO` longtext DEFAULT NULL,
  `DBFDST` longtext DEFAULT NULL,
  `Size` longtext DEFAULT NULL,
  `HMTY15` longtext DEFAULT NULL,
  `ZFeature` longtext DEFAULT NULL,
  `MMBUAR` longtext DEFAULT NULL,
  `Style_No` longtext DEFAULT NULL,
  `Product` longtext DEFAULT NULL,
  `Buyer_Division` longtext DEFAULT NULL,
  `Buyer` longtext DEFAULT NULL,
  `CM_Value` longtext DEFAULT NULL,
  `Schedule_No` longtext DEFAULT NULL,
  `Colour` longtext DEFAULT NULL,
  `EMB_A` longtext DEFAULT NULL,
  `EMB_B` longtext DEFAULT NULL,
  `EMB_C` longtext DEFAULT NULL,
  `EMB_D` longtext DEFAULT NULL,
  `EMB_E` longtext DEFAULT NULL,
  `EMB_F` longtext DEFAULT NULL,
  `EMB_G` longtext DEFAULT NULL,
  `EMB_H` longtext DEFAULT NULL,
  `Alloc_Qty` longtext DEFAULT NULL,
  `Dsptched_Qty` longtext DEFAULT NULL,
  `BTS_vs_Ord_Qty` longtext DEFAULT NULL,
  `BTS_vs_FG_Qty` longtext DEFAULT NULL,
  `time_stamp` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB AUTO_INCREMENT=8250 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
