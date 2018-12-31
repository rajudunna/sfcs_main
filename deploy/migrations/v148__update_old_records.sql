/*#1298  update existing non 200 records as "opn" */

UPDATE bai_pro3.m3_transactions SET api_type='opn' WHERE op_code!=200;