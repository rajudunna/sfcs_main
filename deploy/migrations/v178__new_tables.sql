/*#1323 new tables used in code*/
create table `bai_pro3`.`shade_split`( 
   `id` int(10) NOT NULL AUTO_INCREMENT , 
   `date_time` datetime , 
   `username` varchar(30) , 
   `doc_no` int(10) NOT NULL , 
   `schedule` int(10) NOT NULL , 
   `shades` varchar(100) NOT NULL , 
   `plies` varchar(100) NOT NULL , 
   PRIMARY KEY (`id`)
 );


 create table `bai_pro3`.`deleted_sewing_jobs`( 
   `id` int NOT NULL , 
   `schedule` int(10) NOT NULL , 
   `input_job_no_random` varchar(20) NOT NULL , 
   `size_id` varchar(10) NOT NULL , 
   `qty` int(5) , 
   `tid` int(10) , 
   `type_of_sewing` int(2) , 
   PRIMARY KEY (`id`)
 );
