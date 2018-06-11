/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16 : Database - bai_ie_pj2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_ie_pj2` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_ie_pj2`;

/*Table structure for table `neddle` */

DROP TABLE IF EXISTS `neddle`;

CREATE TABLE `neddle` (
  `sno` double NOT NULL AUTO_INCREMENT COMMENT 'Serial No',
  `moduleno` varchar(50) NOT NULL COMMENT 'Module no',
  `machinetype` varchar(50) NOT NULL COMMENT 'Mchine Type',
  `machineserialno` varchar(50) NOT NULL COMMENT 'Machine Serial NO',
  `needlemodel` varchar(50) NOT NULL COMMENT 'Needle Model',
  `needlepointtype` varchar(50) NOT NULL COMMENT 'Needle Point Type',
  `quantity` int(11) NOT NULL COMMENT 'Quntity Issued ',
  `size` int(11) NOT NULL COMMENT 'Needle size',
  `dateofissue` date NOT NULL COMMENT 'Date of issue ',
  `issuedby` varchar(50) NOT NULL COMMENT 'Needle Issued BY',
  `issuedto` varchar(50) NOT NULL COMMENT 'Needle Issued To',
  `returnby` varchar(20) NOT NULL COMMENT 'Needle Return BY',
  `returnquantity` int(11) NOT NULL COMMENT 'Return Quantity',
  `returndate` date NOT NULL COMMENT 'Return Date',
  `coustmer` varchar(50) NOT NULL COMMENT 'Coustmer Name',
  `style` int(11) NOT NULL COMMENT 'Style',
  `stas` varchar(20) NOT NULL COMMENT 'Status',
  PRIMARY KEY (`sno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='this tbale for neddle issueing purpose';

/*Table structure for table `stock` */

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock` (
  `needlemodel` varchar(50) NOT NULL COMMENT 'Needle Model',
  `needlepointtype` varchar(50) NOT NULL COMMENT 'Needle Point Type',
  `quantity` int(11) NOT NULL COMMENT 'Quantity',
  `size` int(11) NOT NULL COMMENT 'size',
  `date` date NOT NULL COMMENT 'Date'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='neddle stock in details we are storing here';

/*Table structure for table `stocks` */

DROP TABLE IF EXISTS `stocks`;

CREATE TABLE `stocks` (
  `needlemodel` varchar(50) NOT NULL COMMENT 'Needle Model ',
  `needlepointtype` varchar(50) NOT NULL COMMENT 'Neddle Point Type',
  `quantity` int(11) NOT NULL COMMENT 'Quantity',
  `size` int(11) NOT NULL COMMENT 'size',
  `date` date NOT NULL COMMENT 'Date'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Neddle present stock details we are storing here';

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
