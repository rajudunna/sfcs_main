/*#3374 alter queries indexing*/

ALTER TABLE bai_pro3.tbl_carton_ready ADD UNIQUE INDEX mo_operation_id (operation_id, mo_no) COMMENT "to avoid mo duplication";

ALTER TABLE m3_inputs.deleted_mos CHANGE mo_number mo_number VARCHAR (20) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL, ADD KEY mo_no (mo_number);

ALTER TABLE bai_pro3.tbl_carton_ready_archive CHANGE id id INT ( 11 ) NOT NULL AUTO_INCREMENT;