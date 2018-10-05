create table brandix_bts.transactions_log( 
   sno int(11) NOT NULL AUTO_INCREMENT , 
   transaction_id int(11) , 
   response_message varchar(300) , 
   created_by varchar;(100) , 
   created_at datetime , 
   updated_at datetime , 
   PRIMARY KEY (sno)
 );