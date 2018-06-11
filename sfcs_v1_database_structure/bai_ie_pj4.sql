/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16 : Database - bai_ie_pj4
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_ie_pj4` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_ie_pj4`;

/*Table structure for table `brnds` */

DROP TABLE IF EXISTS `brnds`;

CREATE TABLE `brnds` (
  `mnam` varchar(25) NOT NULL COMMENT 'Machine Name',
  `type` varchar(25) NOT NULL COMMENT 'Machine Type',
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='storing machie names and  brand names here';

/*Table structure for table `files` */

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `machnm` varchar(50) DEFAULT NULL COMMENT 'Machine Name',
  `machno` varchar(50) DEFAULT NULL COMMENT 'Machine No',
  `refno` varchar(50) DEFAULT NULL COMMENT 'Reference No',
  `tid` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `NewIndex1` (`machnm`,`machno`,`refno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='storing machine files names here';

/*Table structure for table `ie_mac` */

DROP TABLE IF EXISTS `ie_mac`;

CREATE TABLE `ie_mac` (
  `locker` varchar(20) NOT NULL,
  `locat` varchar(20) NOT NULL,
  `box` varchar(20) NOT NULL,
  `brndnm` varchar(50) NOT NULL,
  `machnm` varchar(50) NOT NULL,
  `part` varchar(20) NOT NULL,
  `partno` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `main_locker` */

DROP TABLE IF EXISTS `main_locker`;

CREATE TABLE `main_locker` (
  `brndnm` varchar(50) NOT NULL COMMENT 'Machine Brand Name',
  `machnm` varchar(50) NOT NULL COMMENT 'Machine Name',
  `part` varchar(50) NOT NULL COMMENT 'Machine Part Name',
  `partno` varchar(50) NOT NULL COMMENT 'Machine Part NO',
  `quantity` int(11) NOT NULL COMMENT 'Available Quantity',
  `stat` int(11) NOT NULL COMMENT 'Status',
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='summary of all the spare parts details of machine  ';

/*Table structure for table `main_locker_stock_in` */

DROP TABLE IF EXISTS `main_locker_stock_in`;

CREATE TABLE `main_locker_stock_in` (
  `sno` double NOT NULL AUTO_INCREMENT COMMENT 'Serial No',
  `partynm` varchar(20) NOT NULL COMMENT 'Machine Part Name',
  `invocno` varchar(20) NOT NULL COMMENT 'Order Invoice No',
  `dat` date NOT NULL COMMENT 'Upadeted DATE',
  `brndnm` varchar(50) NOT NULL COMMENT 'Brand Name',
  `machnm` varchar(50) NOT NULL COMMENT 'Machine Name',
  `part` varchar(50) NOT NULL COMMENT 'Part Name',
  `partno` varchar(50) NOT NULL COMMENT 'Part No',
  `quantity` int(11) NOT NULL COMMENT 'Present Available Quantity',
  `percst` double NOT NULL COMMENT 'Cost of Single Item',
  `curfrmt` varchar(20) NOT NULL COMMENT 'Money Format',
  `ttlcst` double NOT NULL COMMENT 'Totatl Cost',
  `stat` int(11) NOT NULL COMMENT 'Status',
  `category` varchar(25) NOT NULL COMMENT 'Category',
  PRIMARY KEY (`sno`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='spare parts stock insertion details';

/*Table structure for table `rqst_qun` */

DROP TABLE IF EXISTS `rqst_qun`;

CREATE TABLE `rqst_qun` (
  `brndnm` varchar(50) NOT NULL COMMENT 'Brand Name',
  `machnm` varchar(50) NOT NULL COMMENT 'Machine Name',
  `part` varchar(50) NOT NULL COMMENT 'Part Name',
  `partno` varchar(50) NOT NULL COMMENT 'Part No',
  `curqun` int(11) NOT NULL COMMENT 'Current Available Quantity',
  `quantity` int(11) NOT NULL COMMENT 'Order Quantity',
  `recv_qty` int(11) NOT NULL DEFAULT '0' COMMENT 'Recived Quantity',
  `mau` int(11) NOT NULL,
  `stat` int(11) NOT NULL COMMENT 'Status',
  `dat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Order Date',
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='details of what are the requests they kept for purchasre ';

/*Table structure for table `stock` */

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock` (
  `brndnm` varchar(50) NOT NULL COMMENT 'Brand Name',
  `machnm` varchar(50) NOT NULL COMMENT 'Machine Name',
  `part` varchar(100) NOT NULL COMMENT 'Part Name',
  `partno` varchar(50) NOT NULL COMMENT 'Part No',
  `curqun` int(11) NOT NULL COMMENT 'Current Quantity',
  `quantity` int(11) NOT NULL COMMENT 'Quantity',
  `recv_qty` int(11) NOT NULL,
  `mau` int(11) NOT NULL,
  `stat` int(11) NOT NULL COMMENT 'Status',
  `dat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Order Date',
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='spare parts stock in details';

/*Table structure for table `stock_out` */

DROP TABLE IF EXISTS `stock_out`;

CREATE TABLE `stock_out` (
  `sno` double NOT NULL AUTO_INCREMENT COMMENT 'Serial No',
  `modno` varchar(20) NOT NULL COMMENT 'Module No',
  `machtype` varchar(20) NOT NULL COMMENT 'Machine Type',
  `machserno` varchar(20) NOT NULL COMMENT 'Machine Serial No',
  `brndnm` varchar(20) NOT NULL COMMENT 'Brand Name',
  `machnm` varchar(20) NOT NULL COMMENT 'Mchine Name',
  `part` varchar(50) NOT NULL COMMENT 'Part Name',
  `partno` varchar(20) NOT NULL COMMENT 'Part No',
  `quantity` int(11) NOT NULL COMMENT 'Quantity issued ',
  `issuedby` varchar(20) NOT NULL COMMENT 'Quantity Issed BY',
  `author` varchar(50) NOT NULL COMMENT 'Authorised person for this quantity',
  `issuedto` varchar(20) NOT NULL COMMENT 'Quantity Taken By',
  `issdat` date NOT NULL COMMENT 'Issued Date',
  `retdat` date NOT NULL COMMENT 'Return Date',
  `retby` varchar(20) NOT NULL COMMENT 'Return By',
  `barcode` varchar(50) NOT NULL COMMENT 'Barcode',
  `stat` varchar(20) NOT NULL COMMENT 'Status',
  `percst` double NOT NULL COMMENT 'Percost',
  `frmt` varchar(20) NOT NULL COMMENT 'Currency Format',
  PRIMARY KEY (`sno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='spare parts stock out details';

/*Table structure for table `sty_mac` */

DROP TABLE IF EXISTS `sty_mac`;

CREATE TABLE `sty_mac` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `sty` varchar(60) DEFAULT NULL,
  `sn` double DEFAULT NULL,
  `522a` double DEFAULT NULL,
  `fs` double DEFAULT NULL,
  `ol` double DEFAULT NULL,
  `3tol` double DEFAULT NULL,
  `4tol` double DEFAULT NULL,
  `fllsc` double DEFAULT NULL,
  `flcs` double DEFAULT NULL,
  `flrsc` double DEFAULT NULL,
  `flbin` double DEFAULT NULL,
  `flflat` double DEFAULT NULL,
  `dn` double DEFAULT NULL,
  `batt` double DEFAULT NULL,
  `bhole` double DEFAULT NULL,
  `btack` double DEFAULT NULL,
  `zz` double DEFAULT NULL,
  `ttl` double DEFAULT NULL,
  `nop` int(11) DEFAULT NULL,
  UNIQUE KEY `sno` (`sno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
