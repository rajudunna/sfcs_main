/*#1323 new tables used in code*/

CREATE TABLE `bai_pro3`.`shade_split` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date_time` datetime DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `doc_no` int(10) NOT NULL,
  `schedule` int(10) NOT NULL,
  `shades` varchar(100) NOT NULL,
  `plies` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1;

/*
//this is covered under v181

CREATE TABLE `bai_pro3`.`deleted_sewing_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule` int(10) NOT NULL,
  `input_job_no_random` varchar(20) NOT NULL,
  `size_id` varchar(10) NOT NULL,
  `qty` int(5) DEFAULT NULL,
  `tid` int(10) DEFAULT NULL,
  `type_of_sewing` int(2) DEFAULT NULL
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1;
*/
