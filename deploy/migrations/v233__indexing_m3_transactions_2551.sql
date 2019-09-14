/*#2551 alter table*/


USE bai_pro3;

ALTER TABLE bai_pro3.m3_transactions ADD KEY date_response_check
(date_time);

ALTER TABLE bai_pro3.m3_transactions ADD KEY date_resp_check
(date_time, response_status);