/*923*/
/*use bai_pro3;*/
create table bai_pro3.delete_jobs_log( 
   id int(11) NOT NULL AUTO_INCREMENT , 
   input_job_no_random int(15) , 
   username varchar(50) , 
   date_time datetime , 
   PRIMARY KEY (id)
 ); 