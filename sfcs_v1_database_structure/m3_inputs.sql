/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16 : Database - m3_inputs
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`m3_inputs` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `m3_inputs`;

/*Table structure for table `order_details` */

DROP TABLE IF EXISTS `order_details`;

CREATE TABLE `order_details` (
  `sno` bigint(20) NOT NULL AUTO_INCREMENT,
  `Facility` longtext,
  `Customer_Style_No` longtext,
  `CPO_NO` longtext,
  `VPO_NO` longtext,
  `CO_no` longtext,
  `Style` longtext,
  `Schedule` longtext,
  `Manufacturing_Schedule_no` longtext,
  `MO_Split_Method` longtext,
  `MO_Released_Status_Y_N` longtext,
  `GMT_Color` longtext,
  `GMT_Size` longtext,
  `GMT_Z_Feature` longtext,
  `Graphic_Number` longtext,
  `CO_Qty` longtext,
  `MO_Qty` longtext,
  `PCD` longtext,
  `Plan_Delivery_Date` longtext,
  `Destination` longtext,
  `Packing_Method` longtext,
  `Item_Code` longtext,
  `Item_Description` longtext,
  `RM_Color_Description` longtext,
  `Order_YY_WO_Wastage` longtext,
  `Wastage` longtext,
  `Required_Qty` longtext,
  `UOM` longtext,
  `A15NEXT` longtext,
  `A15` longtext,
  `A20` longtext,
  `A30` longtext,
  `A40` longtext,
  `A50` longtext,
  `A60` longtext,
  `A70` longtext,
  `A75` longtext,
  `A80` longtext,
  `A90` longtext,
  `A100` longtext,
  `A110` longtext,
  `A115` longtext,
  `A120` longtext,
  `A125` longtext,
  `A130` longtext,
  `A140` longtext,
  `A143` longtext,
  `A144` longtext,
  `A147` longtext,
  `A148` longtext,
  `A150` longtext,
  `A160` longtext,
  `A170` longtext,
  `A175` longtext,
  `A180` longtext,
  `A190` longtext,
  `A200` longtext,
  `MO_NUMBER` longtext,
  `SEQ_NUMBER` longtext,
  `time_stamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB AUTO_INCREMENT=6975 DEFAULT CHARSET=latin1;

/*Table structure for table `shipment_plan` */

DROP TABLE IF EXISTS `shipment_plan`;

CREATE TABLE `shipment_plan` (
  `sno` bigint(20) NOT NULL AUTO_INCREMENT,
  `Customer_Order_No` longtext,
  `CO_Line_Status` longtext,
  `Ex_Factory` longtext,
  `Order_Qty` longtext,
  `Mode` longtext,
  `Destination` longtext,
  `Packing_Method` longtext,
  `FOB_Price_per_piece` longtext,
  `MPO` longtext,
  `CPO` longtext,
  `DBFDST` longtext,
  `Size` longtext,
  `HMTY15` longtext,
  `ZFeature` longtext,
  `MMBUAR` longtext,
  `Style_No` longtext,
  `Product` longtext,
  `Buyer_Division` longtext,
  `Buyer` longtext,
  `CM_Value` longtext,
  `Schedule_No` longtext,
  `Colour` longtext,
  `EMB_A` longtext,
  `EMB_B` longtext,
  `EMB_C` longtext,
  `EMB_D` longtext,
  `EMB_E` longtext,
  `EMB_F` longtext,
  `EMB_G` longtext,
  `EMB_H` longtext,
  `Alloc_Qty` longtext,
  `Dsptched_Qty` longtext,
  `BTS_vs_Ord_Qty` longtext,
  `BTS_vs_FG_Qty` longtext,
  `time_stamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB AUTO_INCREMENT=2246 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
