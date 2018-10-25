
USE `bai_pro3`;

/*Table structure for table `pac_stat` */

CREATE TABLE `pac_stat` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `style` varchar(30) NOT NULL,
  `schedule` varchar(10) NOT NULL,
  `pac_seq_no` int(5) NOT NULL COMMENT 'sequence number',
  `carton_no` int(15) NOT NULL,
  `carton_mode` varchar(5) NOT NULL COMMENT 'Partial / Full',
  `carton_qty` int(15) NOT NULL COMMENT 'total qty in that carton',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `pac_stat_input` */

CREATE TABLE `pac_stat_input` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(255) DEFAULT NULL,
  `schedule` int(11) DEFAULT NULL,
  `no_of_cartons` int(11) DEFAULT NULL COMMENT 'sewing no of cartons',
  `mix_jobs` int(11) DEFAULT NULL COMMENT '1=yes | 2=no',
  `bundle_qty` int(11) DEFAULT NULL COMMENT 'sewing job bundle qty',
  `pac_seq_no` int(11) DEFAULT NULL COMMENT 'pack seq_no',
  `pack_method` int(11) DEFAULT NULL COMMENT 'sewing pack method',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


/*Table structure for table `tbl_carton_ready` */

CREATE TABLE `tbl_carton_ready` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operation_id` int(11) NOT NULL,
  `mo_no` int(11) NOT NULL,
  `remaining_qty` int(11) NOT NULL,
  `cumulative_qty` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_docket_qty` */

CREATE TABLE `tbl_docket_qty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cut_no` int(11) DEFAULT NULL,
  `doc_no` int(11) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `ref_size` int(11) DEFAULT NULL COMMENT 'id of size from brandix_bts.tbl_size master',
  `plan_qty` int(11) DEFAULT NULL,
  `fill_qty` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1=normal | 2=excess | 3=sample',
  `pac_stat_input_id` int(11) DEFAULT NULL COMMENT 'id from pac_stat_input table',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_pack_ref` */

CREATE TABLE `tbl_pack_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(255) DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_pack_size_ref` */

CREATE TABLE `tbl_pack_size_ref` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `parent_id` int(6) DEFAULT NULL,
  `color` varchar(765) DEFAULT NULL,
  `ref_size_name` int(11) DEFAULT NULL,
  `size_title` varchar(30) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `poly_bags_per_carton` int(5) DEFAULT NULL,
  `garments_per_carton` int(5) DEFAULT NULL,
  `seq_no` int(5) DEFAULT NULL,
  `cartons_per_pack_job` int(5) DEFAULT NULL,
  `pack_job_per_pack_method` int(5) DEFAULT NULL,
  `pack_method` int(5) DEFAULT NULL,
  `pack_description` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


ALTER TABLE bai_pro3.pac_stat_log
 ADD COLUMN size_tit VARCHAR(255) NULL COMMENT 'actual size' AFTER color,
 ADD COLUMN pac_stat_id INT(11) NULL COMMENT 'id from pac_stat table' AFTER size_tit;
 

/*Table structure for View `packing_summary` */
ALTER VIEW `packing_summary` AS (
select
  `pac_stat_log`.`doc_no`         AS `doc_no`,
  `pac_stat_log`.`doc_no_ref`     AS `doc_no_ref`,
  `pac_stat_log`.`tid`            AS `tid`,
  `pac_stat`.`carton_no`          AS `carton_no`,
  `pac_stat_log`.`size_code`      AS `size_code`,
  `pac_stat_log`.`remarks`        AS `remarks`,
  `pac_stat_log`.`status`         AS `STATUS`,
  `pac_stat_log`.`lastup`         AS `lastup`,
  `pac_stat_log`.`container`      AS `container`,
  `pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,
  `pac_stat_log`.`disp_id`        AS `disp_id`,
  `pac_stat_log`.`carton_act_qty` AS `carton_act_qty`,
  `pac_stat_log`.`audit_status`   AS `audit_status`,
  `pac_stat`.`style`              AS `order_style_no`,
  `pac_stat`.`schedule`           AS `order_del_no`,
  `pac_stat`.`carton_mode`        AS `carton_mode`,
  `pac_stat_log`.`color`          AS `order_col_des`,
  `pac_stat_log`.`size_tit`       AS `size_tit`,
  `pac_stat`.`pac_seq_no`         AS `seq_no`,
  `pac_stat_log`.`pac_stat_id`    AS `pac_stat_id`
from (((`pac_stat_log`
     left join `pac_stat`
       on (`pac_stat`.`id` = `pac_stat_log`.`pac_stat_id`))
    left join `plandoc_stat_log`
      on (`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`))
   left join `bai_orders_db_confirm`
     on (`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)));

