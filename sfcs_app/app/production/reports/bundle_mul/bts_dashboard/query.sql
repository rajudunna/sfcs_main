/*Style wise output Qty*/
SELECT DISTINCT tbl_orders_style_ref_product_style, SUM(output) AS output,SUM(order_qty) AS order_qty,COUNT(DISTINCT tbl_orders_master_product_schedule) AS schedulecount,order_div
,MIN(runningsince) AS runningsince
 FROM (
SELECT tbl_orders_style_ref_product_style, 
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
tbl_orders_master_product_schedule,
MIN(DATE(bundle_transactions_date_time)) AS runningsince,
order_div
FROM view_set_snap_1_tbl WHERE tbl_orders_style_ref_product_style IS NOT NULL GROUP BY order_id
) AS tmp GROUP BY tbl_orders_style_ref_product_style

/*Style Order Qty not requided*/
SELECT SUM(order_qty) AS order_qty FROM (SELECT  DISTINCT order_id,tbl_orders_sizes_master_order_quantity AS order_qty FROM view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='Y74686S5       ') AS tmp

/*mini order_wip */
SELECT * FROM (
SELECT  DISTINCT tbl_miniorder_data_mini_order_num,SUM(IF(tbl_orders_ops_ref_operation_code='INI',tbl_miniorder_data_quantity,0)) AS mini_order_qty,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
ROUND((SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) /SUM(IF(tbl_orders_ops_ref_operation_code='INI',tbl_miniorder_data_quantity,0)))*100,0)  AS achiv,
MIN(DATE(bundle_transactions_date_time)) AS runningsince
FROM view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='Y74686S5       ' GROUP BY tbl_miniorder_data_mini_order_num
) AS tmp WHERE output>0 AND mini_order_qty<>output ORDER BY achiv DESC

/*wip ach% (not required)*/

SELECT 

SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle

FROM view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='Y74686S5       '

/*wip sche*/
SELECT COUNT(*) AS totsch, SUM(IF((output)<(order_qty),1,0)) AS wip, SUM(IF((output)>=(order_qty),1,0)) AS completed, COUNT(*)-(SUM(IF((output)>=(order_qty),1,0))) AS balance
,SUM(order_qty) AS order_qty,SUM(output) AS output,SUM(bundling) AS bundling,SUM(bundleout) AS bundleout,SUM(linein) AS linein,SUM(miniorderbundle) AS miniorderbundle
 FROM
(
SELECT tbl_orders_master_product_schedule,SUM(order_qty) AS order_qty,SUM(output) AS output,SUM(bundling) AS bundling,SUM(bundleout) AS bundleout,SUM(linein) AS linein,SUM(miniorderbundle) AS miniorderbundle

FROM 
(
SELECT 
tbl_orders_master_product_schedule,
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle

FROM view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='Y74686S5       ' 

GROUP BY order_id
) AS tmp GROUP BY tbl_orders_master_product_schedule
) AS tmp2

/*wip miniord*/
SELECT COUNT(*) AS totmini, SUM(IF((output)<(order_qty),1,0)) AS wipmini, SUM(IF((output)>=(order_qty),1,0)) AS completedmini, COUNT(*)-(SUM(IF((output)>=(order_qty),1,0))) AS balancemini FROM
(
SELECT tbl_orders_master_product_schedule,SUM(order_qty) AS order_qty,SUM(output) AS output,SUM(bundling) AS bundling,SUM(bundleout) AS bundleout,SUM(linein) AS linein,SUM(miniorderbundle) AS miniorderbundl

FROM 
(
SELECT 
tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num,
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle

FROM view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='Y74686S5       ' 

GROUP BY order_id
) AS tmp GROUP BY tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num
) AS tmp2


/*wip bundle*/
SELECT COUNT(*) AS totbundles, SUM(IF((output)<(order_qty),1,0)) AS wipbundles, SUM(IF((output)>=(order_qty),1,0)) AS completedbundles, COUNT(*)-(SUM(IF((output)>=(order_qty),1,0))) AS balancebundles FROM
(
SELECT tbl_orders_master_product_schedule,SUM(order_qty) AS order_qty,SUM(output) AS output,SUM(bundling) AS bundling,SUM(bundleout) AS bundleout,SUM(linein) AS linein,SUM(miniorderbundle) AS miniorderbundl

FROM 
(
SELECT 
tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num,tbl_miniorder_data_bundle_number,
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle

FROM view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='Y74686S5       ' 

GROUP BY order_id
) AS tmp GROUP BY tbl_orders_master_product_schedule,tbl_miniorder_data_mini_order_num,tbl_miniorder_data_bundle_number

) AS tmp2

/* Scheudlw wise details */
SELECT * FROM (
SELECT tbl_orders_master_product_schedule,SUM(order_qty) AS order_qty,SUM(output) AS output,SUM(bundling) AS bundling,SUM(bundleout) AS bundleout,SUM(linein) AS linein,SUM(miniorderbundle) AS miniorderbundle
,MIN(first_out_date) AS first_out_date,order_date
FROM 
(
SELECT 
tbl_orders_master_product_schedule,MIN(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_date_time,bundle_transactions_date_time)) AS first_out_date,
AVG(tbl_orders_sizes_master_order_quantity) AS order_qty,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,order_date

FROM view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='Y74686S5       ' 

GROUP BY order_id
) AS tmp GROUP BY tbl_orders_master_product_schedule
)AS tmp2 WHERE output<order_qty


/* dawise performance */
SELECT 
DATE(bundle_transactions_date_time) AS daten,LEFT(bundle_transactions_date_time,7) AS monthn,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output,
SUM(IF(tbl_orders_ops_ref_operation_code='BUN',bundle_transactions_20_repeat_quantity,0)) AS bundling,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='A',bundle_transactions_20_repeat_quantity,0)) AS a_output,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO' AND tbl_shifts_master_shift_name='B',bundle_transactions_20_repeat_quantity,0)) AS b_output,
ROUND(SUM(sah),0) AS sah

FROM view_set_snap_1_tbl WHERE  tbl_orders_style_ref_product_style='Y74686S5       ' 

GROUP BY DATE(bundle_transactions_date_time) ORDER BY DATE(bundle_transactions_date_time) DESC


/* rejections*/

SELECT log_date,qms_style,qms_schedule,rejected_qty,LEFT(log_date,7) AS monthn FROM view_set_5_snap WHERE qms_style='Y74686S5       ' ORDER BY log_date DESC

/*cartonpak*/

SELECT DATE,style,SCHEDULE,cpk_qty,LEFT(DATE,7) AS monthn FROM view_set_4_snap WHERE style='Y74686S5       ' ORDER BY DATE DESC

/* next mini order */
SELECT tbl_miniorder_data_mini_order_num FROM (
SELECT DISTINCT tbl_miniorder_data_mini_order_num,
SUM(IF(tbl_orders_ops_ref_operation_code='INI',bundle_transactions_20_repeat_quantity,0)) AS miniorderbundle,
SUM(IF(tbl_orders_ops_ref_operation_code='LNI',bundle_transactions_20_repeat_quantity,0)) AS linein,
SUM(IF(tbl_orders_ops_ref_operation_code='BUO',bundle_transactions_20_repeat_quantity,0)) AS bundleout,
SUM(IF(tbl_orders_ops_ref_operation_code='LNO',bundle_transactions_20_repeat_quantity,0)) AS output FROM view_set_snap_1_tbl WHERE tbl_orders_master_product_schedule=313888  GROUP BY tbl_miniorder_data_mini_order_num
) AS tmp WHERE linein=0 ORDER BY tbl_miniorder_data_mini_order_num LIMIT 1









/* view creation queries */
CREATE  TABLE brandix_bts_uat.view_set_1_snap ENGINE = MYISAM SELECT * FROM brandix_bts_uat.view_set_1;
/*index bundle_transactions_20_repeat_bundle_id*/

CREATE  TABLE brandix_bts_uat.view_set_2_snap ENGINE = MYISAM SELECT * FROM brandix_bts_uat.view_set_2;
/*inde order id*/

CREATE  TABLE brandix_bts_uat.view_set_3_snap ENGINE = MYISAM SELECT * FROM brandix_bts_uat.view_set_3;
/*tbl_miniorder_data_bundle_number, order_id*/

CREATE  TABLE brandix_bts_uat.view_set_4_snap ENGINE = MYISAM SELECT * FROM brandix_bts_uat.view_set_4;

CREATE  TABLE brandix_bts_uat.view_set_5_snap ENGINE = MYISAM SELECT * FROM brandix_bts_uat.view_set_5;

CREATE  TABLE brandix_bts_uat.view_set_6_snap ENGINE = MYISAM SELECT * FROM brandix_bts_uat.view_set_6;

CREATE  TABLE brandix_bts_uat.view_set_snap_1_tbl ENGINE = MYISAM SELECT * FROM brandix_bts_uat.view_set_snap_1;
/* indie tbl_orders_master_product_schedule, tbl_orders_style_ref_product_style */

