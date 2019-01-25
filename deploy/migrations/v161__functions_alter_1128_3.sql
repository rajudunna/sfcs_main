/*#1128 Alter Function*/
USE `bai_pro3`;

DROP FUNCTION IF EXISTS `bai_pro3`.`input_job_input_status`;

CREATE FUNCTION `bai_pro3`.`input_job_input_status`(in_job_rand_no_ref VARCHAR(30),operation_code INT(11)) RETURNS VARCHAR(10) CHARSET latin1
    DETERMINISTIC
BEGIN
	DECLARE input_qty BIGINT;
	DECLARE job_qty BIGINT;
	DECLARE rec_qty BIGINT;
	DECLARE s_qty BIGINT;
	DECLARE rc_qty BIGINT;
	DECLARE rp_qty BIGINT;
	DECLARE rej_qty BIGINT;
	
	-- SET @input_qty = (SELECT COALESCE(SUM(in_qty),0) FROM ((SELECT SUM(ims_qty) AS in_qty FROM ims_log_backup WHERE input_job_rand_no_ref=in_job_rand_no_ref) UNION (SELECT SUM(ims_qty) AS in_qty FROM ims_log WHERE input_job_rand_no_ref=in_job_rand_no_ref)) AS tmp);
	
	-- SET @input_qty = (SELECT COALESCE(SUM(ims_qty),0) FROM ((SELECT * FROM ims_log_backup WHERE input_job_rand_no_ref=in_job_rand_no_ref) UNION (SELECT * FROM ims_log WHERE input_job_rand_no_ref=in_job_rand_no_ref)) AS tmp);
	
	SET @rec_qty = (SELECT SUM(recevied_qty) FROM brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = in_job_rand_no_ref AND operation_id = operation_code);
	
	SET @s_qty = (SELECT SUM(send_qty) FROM brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = in_job_rand_no_ref AND operation_id = operation_code);
	
	SET @rc_qty = (SELECT SUM(recut_in) FROM brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = in_job_rand_no_ref AND operation_id = operation_code);
	
	SET @rp_qty = (SELECT SUM(replace_in) FROM brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = in_job_rand_no_ref AND operation_id = operation_code);
	
	SET @rej_qty = (SELECT SUM(rejected_qty) FROM brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = in_job_rand_no_ref AND operation_id = operation_code);
	
	SET @job_qty = (SELECT SUM(carton_act_qty) FROM pac_stat_log_input_job WHERE input_job_no_random=in_job_rand_no_ref);
	
	
	IF((@rec_qty >= @job_qty) AND (@s_qty+@rc_qty+@rp_qty=@rec_qty+@rej_qty)) THEN
		RETURN 'DONE';
	ELSE
		RETURN '';
	END IF;
    END;
