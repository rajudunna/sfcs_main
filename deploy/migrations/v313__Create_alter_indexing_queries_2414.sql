/*#2414 Create, Alter and indexing queries*/

USE bai_pro3;

CREATE TABLE bai_pro3.cuttable_stat_log_recut (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `order_tid` varchar(200) NOT NULL COMMENT 'Order TID Reference',
  `date` date NOT NULL COMMENT 'Date',
  `cat_id` int(11) NOT NULL COMMENT 'Category ID Reference',
  `cuttable_s_xs` int(11) NOT NULL COMMENT 'XS \n\nCuttable Qty',
  `cuttable_s_s` int(11) NOT NULL COMMENT 'S Cuttable Qty',
  `cuttable_s_m` int(11) NOT NULL COMMENT 'M Cuttable Qty',
  `cuttable_s_l` int(11) NOT NULL COMMENT 'L Cuttable Qty',
  `cuttable_s_xl` int(11) NOT NULL COMMENT 'XL Cuttable Qty',
  `cuttable_s_xxl` int(11) NOT NULL COMMENT 'XXL Cuttable Qty',
  `cuttable_s_xxxl` int(11) NOT NULL COMMENT 'XXXL Cuttable Qty',
  `lastup` datetime NOT NULL COMMENT 'Last \n\nupdated time',
  `remarks` varchar(500) NOT NULL COMMENT 'Remarks',
  `cuttable_percent` float NOT NULL COMMENT 'Cutting Excess Percentage',
  `cuttable_s_s01` int(11) NOT NULL COMMENT 's01 Cuttable Qty',
  `cuttable_s_s02` int(11) NOT NULL COMMENT 's02 Cuttable Qty',
  `cuttable_s_s03` int(11) NOT NULL COMMENT 's03 Cuttable Qty',
  `cuttable_s_s04` int(11) NOT NULL COMMENT 's04 Cuttable Qty',
  `cuttable_s_s05` int(11) NOT NULL COMMENT 's05 \n\nCuttable Qty',
  `cuttable_s_s06` int(11) NOT NULL COMMENT 's06 Cuttable Qty',
  `cuttable_s_s07` int(11) NOT NULL COMMENT 's07 Cuttable Qty',
  `cuttable_s_s08` int(11) NOT NULL COMMENT 's08 Cuttable Qty',
  `cuttable_s_s09` int(11) NOT NULL COMMENT 's09 Cuttable Qty',
  `cuttable_s_s10` int(11) NOT NULL COMMENT 's10 Cuttable Qty',
  `cuttable_s_s11` int(11) NOT NULL COMMENT 's11 Cuttable Qty',
  `cuttable_s_s12` int(11) NOT NULL COMMENT 's12 \n\nCuttable Qty',
  `cuttable_s_s13` int(11) NOT NULL COMMENT 's13 Cuttable Qty',
  `cuttable_s_s14` int(11) NOT NULL COMMENT 's14 Cuttable Qty',
  `cuttable_s_s15` int(11) NOT NULL COMMENT 's15 Cuttable Qty',
  `cuttable_s_s16` int(11) NOT NULL COMMENT 's16 Cuttable Qty',
  `cuttable_s_s17` int(11) NOT NULL COMMENT 's17 Cuttable Qty',
  `cuttable_s_s18` int(11) NOT NULL COMMENT 's18 Cuttable Qty',
  `cuttable_s_s19` int(11) NOT NULL COMMENT 's19 \n\nCuttable Qty',
  `cuttable_s_s20` int(11) NOT NULL COMMENT 's20 Cuttable Qty',
  `cuttable_s_s21` int(11) NOT NULL COMMENT 's21 Cuttable Qty',
  `cuttable_s_s22` int(11) NOT NULL COMMENT 's22 Cuttable Qty',
  `cuttable_s_s23` int(11) NOT NULL COMMENT 's23 Cuttable Qty',
  `cuttable_s_s24` int(11) NOT NULL COMMENT 's24 Cuttable Qty',
  `cuttable_s_s25` int(11) NOT NULL COMMENT 's25 Cuttable Qty',
  `cuttable_s_s26` int(11) NOT NULL COMMENT 's26 \n\nCuttable Qty',
  `cuttable_s_s27` int(11) NOT NULL COMMENT 's27 Cuttable Qty',
  `cuttable_s_s28` int(11) NOT NULL COMMENT 's28 Cuttable Qty',
  `cuttable_s_s29` int(11) NOT NULL COMMENT 's29 Cuttable Qty',
  `cuttable_s_s30` int(11) NOT NULL COMMENT 's30 Cuttable Qty',
  `cuttable_s_s31` int(11) NOT NULL COMMENT 's31 Cuttable Qty',
  `cuttable_s_s32` int(11) NOT NULL COMMENT 's32 Cuttable Qty',
  `cuttable_s_s33` int(11) NOT NULL COMMENT 's33 \n\nCuttable Qty',
  `cuttable_s_s34` int(11) NOT NULL COMMENT 's34 Cuttable Qty',
  `cuttable_s_s35` int(11) NOT NULL COMMENT 's35 Cuttable Qty',
  `cuttable_s_s36` int(11) NOT NULL COMMENT 's36 Cuttable Qty',
  `cuttable_s_s37` int(11) NOT NULL COMMENT 's37 Cuttable Qty',
  `cuttable_s_s38` int(11) NOT NULL COMMENT 's38 Cuttable Qty',
  `cuttable_s_s39` int(11) NOT NULL COMMENT 's39 Cuttable Qty',
  `cuttable_s_s40` int(11) NOT NULL COMMENT 's40 \n\nCuttable Qty',
  `cuttable_s_s41` int(11) NOT NULL COMMENT 's41 Cuttable Qty',
  `cuttable_s_s42` int(11) NOT NULL COMMENT 's42 Cuttable Qty',
  `cuttable_s_s43` int(11) NOT NULL COMMENT 's43 Cuttable Qty',
  `cuttable_s_s44` int(11) NOT NULL COMMENT 's44 Cuttable Qty',
  `cuttable_s_s45` int(11) NOT NULL COMMENT 's45 Cuttable Qty',
  `cuttable_s_s46` int(11) NOT NULL COMMENT 's46 Cuttable Qty',
  `cuttable_s_s47` int(11) NOT NULL COMMENT 's47 \n\nCuttable Qty',
  `cuttable_s_s48` int(11) NOT NULL COMMENT 's48 Cuttable Qty',
  `cuttable_s_s49` int(11) NOT NULL COMMENT 's49 Cuttable Qty',
  `cuttable_s_s50` int(11) NOT NULL COMMENT 's50 Cuttable Qty',
  `cuttable_wastage` varchar(11) NOT NULL COMMENT 'cuttable wastage',
  `serial_no` int(30) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `cuttable_stat_order_tid` (`order_tid`),
  KEY `cuttable_stat_log_ix3` (`cat_id`,`order_tid`,`serial_no`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='To track actual cuttable % on order quantities';

ALTER TABLE `bai_pro3`.`allocate_stat_log` ADD COLUMN `recut_lay_plan` VARCHAR(10) DEFAULT 'no' NOT NULL COMMENT 'layplan for recut raised' AFTER `extra_plies`, ADD COLUMN `serial_no` INT(11) NULL COMMENT 'sequence for copy to other logic in logic' AFTER `recut_lay_plan`; 

ALTER TABLE `bai_pro3`.`allocate_stat_log_archive` ADD COLUMN `recut_lay_plan` VARCHAR(10) DEFAULT 'no' NOT NULL COMMENT 'layplan for recut raised' AFTER `extra_plies`, ADD COLUMN `serial_no` INT(11) NULL COMMENT 'sequence for copy to other logic in logic' AFTER `recut_lay_plan`; 

ALTER TABLE `bai_pro3`.`maker_stat_log` ADD COLUMN `recut_lay_plan` VARCHAR(5) DEFAULT 'no' NOT NULL AFTER `marker_details_id`;

ALTER TABLE `bai_pro3`.`maker_stat_log_archive` ADD COLUMN `rev_mk_length` FLOAT NULL COMMENT 'after revision previous length' AFTER `remark4`, ADD COLUMN `marker_details_id` INT(11) NULL AFTER `rev_mk_length`, ADD COLUMN `recut_lay_plan` VARCHAR(30) DEFAULT 'no' NULL AFTER `marker_details_id`;

CREATE TABLE bai_pro3.lay_plan_recut_track (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `allocated_id` int(11) DEFAULT NULL,
  `tran_id` int(11) DEFAULT NULL,
  `cat_ref` varchar(30) DEFAULT NULL,
  `size_id` varchar(20) DEFAULT NULL,
  `bcd_id` int(11) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  `recut_raised_qty` int(6) NOT NULL DEFAULT 0,
  `recut_allocated_qty` int(6) DEFAULT 0,
  `remaining_qty` int(6) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `bcd_cat_ref` (`cat_ref`,`bcd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=416 DEFAULT CHARSET=latin1;

ALTER TABLE `bai_pro3`.`allocate_stat_log` ADD KEY `recut_status` (`order_tid`, `recut_lay_plan`, `serial_no`);

ALTER TABLE `bai_pro3`.`maker_stat_log` ADD KEY `recut_status` (`order_tid`, `recut_lay_plan`);
