/*#2474 alter query*/

USE brandix_bts;

ALTER TABLE brandix_bts.bundle_creation_data CHANGE size_title size_title VARCHAR
(50) CHARSET latin1 COLLATE latin1_swedish_ci NULL;

ALTER TABLE brandix_bts.bundle_creation_data_temp CHANGE size_title size_title VARCHAR
(50) CHARSET latin1 COLLATE latin1_swedish_ci NULL;