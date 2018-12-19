/*#824*/
/*USE brandix_bts;*/
CREATE TABLE brandix_bts.reversal_docket_log (
  id int(11) NOT NULL AUTO_INCREMENT,
  docket_number int(11) DEFAULT NULL,
  bundle_number int(11) DEFAULT NULL,
  operation_id int(11) DEFAULT NULL,
  size_title char(5) DEFAULT NULL,
  cutting_reversal int(11) DEFAULT NULL,
  act_cut_status varchar(15) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;