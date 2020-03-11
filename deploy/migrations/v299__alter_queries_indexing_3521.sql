/*#3521 alter queries*/

ALTER TABLE brandix_bts.bundle_creation_data ADD KEY job_deactivate (style, SCHEDULE, input_job_no, bundle_qty_status);

ALTER TABLE brandix_bts.bundle_creation_data_temp ADD KEY sch_oper (SCHEDULE, operation_id);