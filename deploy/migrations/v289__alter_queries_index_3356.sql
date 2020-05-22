/*#3356 alter query index*/

ALTER TABLE bai_rm_pj1.fabric_cad_allocation ADD  KEY roll_id (roll_id, status), ADD  KEY doc_no_type (doc_no, doc_type);

ALTER TABLE bai_rm_pj1.store_in ADD  KEY allotment_status (allotment_status);