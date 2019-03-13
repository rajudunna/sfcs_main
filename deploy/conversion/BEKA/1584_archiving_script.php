<script type="text/javascript" src="/sfcs_app/common/js/jquery.min.js" ></script>
<script type="text/javascript" src="/sfcs_app/common/js/table2CSV.js" ></script>
<a id="download_me" href="" download="report.txt" class='btn btn-warning btn-lg'>Download Report</a>

<style>
    .warning{
        color : blue;
        background:black;
    }
    .danger{
        background : black;
        color  :red;
    }
    .btn{
        background : orange;
        color : white;
        padding : 5px;
        text-decoration : none;
    }
</style>

<script>
    $("#download_me").click(function(){
        var data = $('#data').val;
        this.href = "data:text/plain;charset=UTF-8,"  + encodeURIComponent(now);
    });
</script>


<?php
ini_set('max_execution_time',0);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

echo "<br/><br/>Started Running <br/>";

/*$order_tids = ['P19980C9       586365TROPNC C001 4ATL(G)           ','A0737SS9       569437STONEWASH                     ','A0737SS9       586317STONEWASH                     ',
                'A0737SS9        586319Quail                         ',
				'A0737SS9       586322Quail                         ','JJE069S9       59141209 - Black                    ','JJE069S9       59141269 - Navy                     ',
				'JJE069S9       59141409 - Black                    ','JJE069S9       59141469 - Navy                     ','JJE069S9       59141503 - Grey Marl                ',
				'JJE069S9       59141603 - Grey Marl                ','JJE069S9       59141903 - Grey Marl                ','JJE069S9       59141909 - Black                    ',
				'JJE069S9       59141969 - Navy                     ','JJE069S9       59143109 - Black                    ','JJE069S9       59143209 - Black                    ',
				'JJE069S9       59144569 - Navy                     ','JJE069S9       59144669 - Navy                     ','JJE080S9       59215003 - Gray                     ',
				'JJE080S9       59215203 - Gray                     ','JJE080S9       59215403 - Gray                     ','JJE080S9       59215603 - Gray                     ',
				'JJE080S9       59215803 - Gray                     ','JJE080S9       59216003 - Gray                     ','JJE080S9       59216009 - Black                    ',
				'JJE080S9       59216203 - Gray                     ','JJE080S9       59216303 - Gray                     ','JJE080S9       59216309 - Black                    ',
				'JJE080S9       59216503 - Gray                     ','JJE080S9       59216703 - Gray                     ','JJE080S9       59216709 - Black                    ',
				'JJE080S9       59216903 - Gray                     ','JJE080S9       59217003 - Gray                     ','JJE080S9       59217009 - Black                    ',
				'JJE080S9       59217203 - Gray                     ','JJE080S9       59217409 - Black                    ','JJE080S9       59217609 - Black                    ',
				'JJE080S9       59217809 - Black                    ','JJE080S9       59217909 - Black                    ','JJE080S9       59218109 - Black                    ',
				'JJE080S9       59218309 - Black                    ','JJE080S9       59218409 - Black                    ','JJE080S9       59218609 - Black                    ',
				'JJE080S9       59218809 - Black                    ','JJE080S9       59219009 - Black                    ','JJE080S9       59219903 - Gray                     ',
				'JJE080S9       59220109 - Black                    ','JJE080S9       59511009 - Black                    ','JJE080S9       59511103 - Gray                     ',
				'JJE080S9       59511209 - Black                    ','JJE080S9       59511509 - Black                    ','JJE080S9       59596303 - Gray                     ',
				'JJE080S9       59597309 - Black                    ','JJE080S9       59598709 - Black                    ','JJE080S9       59599209 - Black                    ',
				'JJE080S9       59600409 - Black                    ','JJE080S9       59600509 - Black                    ','JJE080S9       59600609 - Black                    ',
				'JJE080S9       59600809 - Black                    ','JJF069S9       59889603 - Grey Marl                ','JJF069S9       59889609 - Black                    ',
				'JJF069S9       59889669 - Navy                     ','JJF069S9       59889803 - Grey Marl                ','JJF069S9       59889809 - Black                    ',
				'JJF069S9       59889869 - Navy                     ','JJF069S9       59890209 - Black                    ','JJF069S9       59891009 - Black                    ',
				'JJF069S9       59891209 - Black                    ','JJF069S9       59891409 - Black                    ','JJF069S9       59891509 - Black                    ',
				'JJF069S9       59892009 - Black                    ','JJF069S9       59892209 - Black                    ','JJF069S9       59893009 - Black                    ',
				'JJF069S9       59893409 - Black                    ','JJF069S9       59893609 - Black                    ','JJF069S9       59893909 - Black                    ',
				'JJF069S9       59894509 - Black                    ','JJF069S9       59894809 - Black                    ','JJF069S9       59895109 - Black                    ',
				'JJF069S9       59896109 - Black                    ','JJF069S9       59896309 - Black                    ','JJF069S9       59896709 - Black                    ',
				'JJF069S9       59896909 - Black                    ','JJF072S9       59839070 - Light Purple             ','JJF072S9       59839150 - Light Green              ',
				'JJF072S9       59839270 - Light Purple             ','JJF072S9       59839350 - Light Green              ','JJF072S9       60153150 - Light Green              ',
				'JJF072S9       60153250 - Light Green              ','JJF073S9       60712860 - Light Blue               ','JJF073S9       60713560 - Light Blue               ',
				'JJF073S9       60715060 - Light Blue               ','JJF073S9       60717260 - Light Blue               ','JJF073S9       60717860 - Light Blue               ',
				'JJF267S9       60319401 - OFF WHITE BOTTOM         ','JJF267S9       60319401 - OFF WHITE TOP            ','JJF267S9       60319601 - OFF WHITE BOTTOM         ',
				'JJF267S9       60319601 - OFF WHITE TOP            ','JJF267S9       60374201 - OFF WHITE BOTTOM         ','JJF267S9       60374201 - OFF WHITE TOP            ',
				'JJF267S9       60375501 - OFF WHITE BOTTOM         ','JJF267S9       60375501 - OFF WHITE TOP            ','JJF267S9       60375601 - OFF WHITE BOTTOM         ',
				'JJF267S9       60375601 - OFF WHITE TOP            ','JOE080S9       59257203 - Gray                     ','JOE080S9       59257309 - Black                    ',
				'JOE080S9       59257409 - Black                    ','JOE080S9       59257503 - Gray                     ','JOE080S9       59257509 - Black                    ',
				'JOE080S9       59257603 - Gray                     ','JOE080S9       59257703 - Gray                     ','JOE080S9       59257709 - Black                    ',
				'JOE080S9       59324503 - Gray                     ','JOE080S9       59324509 - Black                    ','JOE080S9       59324609 - Black                    ',
				'JOE080S9       59324703 - Gray                     ','JOE080S9       59324803 - Gray                     ','JOE080S9       59324809 - Black                    ',
				'JOE080S9       59324909 - Black                    ','JOE080S9       59325003 - Gray                     ','JOE080S9       59602109 - Black                    ',
				'JOE080S9       59602209 - Black                    ','JOF069S9       60659903 - Grey Marl                ','JOF069S9       60660103 - Grey Marl                ',
				'JOF069S9       60660269 - Navy                     ','JOF069S9       60661203 - Grey Marl                ','JOF069S9       60661369 - Navy                     ',
				'JOF069S9       60661703 - Grey Marl                ','TKU02AA9       584600DARK NAVY-410000              ','TKU02AA9       584601MAHOGANY-608000               ',
				'TKU02AA9       584604DARK NAVY-410000              ','TKU02AA9       584605MAHOGANY-608000               ','TKU02AA9       584607DARK NAVY-410000              ',
				'TWU21AA9       584616SAILOR NAVY-587-UTHW3028R     ','TWU21AA9       584621SAILOR NAVY-587-UTHW3028R     ','JJE069S9       59141203 - Grey Marl                ',
				'JJE069S9       59141403 - Grey Marl                ',
				'A0547SS9       586917MAPLE SUGAR                   ','A0548SS9       587782white                         ','A0548SS9       587785BLACK                         ',
				'CN1919J8       584909100100-White                  ','CN1919J8       584917001001-Black                  ','CN1919J8       58492103674C-Medium Grey            ',
				'CN1919J8       584923100100-White                  ','CN2188J8       585135997WXQ-DEEP MAROON            ','CN2188J8       585135997WXQ-GREY HEATHER           ',
				'CN2188J8       585135997WXQ-MINERAL YELLOW         ','CN2188J8       585137995GSZ-GREY HEATHER           ','CN2188J8       585137995GSZ-PROVENCE               ',
				'CN2188J8       585137995GSZ-SCOOTER                ','CN2188J8       585148993DVC-DELFT                  ','CN2188J8       585148993DVC-PEACOAT                ',
				'CN2188J8       585148993DVC-SILVER LAKE            ','CN2188J8       585154100100-White                  ','CN2188J8       585164993DVC-DELFT                  ',
				'CN2188J8       585164993DVC-PEACOAT                ','CN2188J8       585164993DVC-SILVER LAKE            ','JJA160S9       59619791_62 Blue-Tahitian 3         ',
				'JJA160S9       59619791_69 Navy                    ','JJA160S9       59619791_69 Navy-Blue dot           ','JJE069S9       59143417 - Red                      ',
				'JJE069S9       59143421 - Light Orange             ','JJE230S9       59253903 - Grey                     ','JJE230S9       59254021 - Light Orange             ',
				'JJE230S9       59254269 - Navy                     ','JJF069S9       59897121 - Light Orange             ','JJF069S9       60708903 - Grey Marl                ',
				'JJF069S9       60712369 - Navy                     ','JJF069S9       60715400 - White                    ','JOE080S9       59601841 - Yellow                   ',
				'T155AA9S       582642WHITE-100000                  ','T173AF94       581779AZURE-467000                  ','T173AF94       581779DARK NAVY-410000              ',
				'T173AF94       581779PEPPERMINT-336000             ','T173AF94       581779SPEARMINT-323000              ','T173AF94       581882DARK NAVY-410000              ',
				'T173AF94       581882LEAD-998000                   ','T173AF94       581882MORROCAN BLUE-975000          ','T173AF94       581882SEA CALM-970000               ',
				'T174CR21       605809HAZE HEATHER-486000           ','T174CR21       605809ULTRA BLUE-425000             ','T174CR21       605810GRAYHEATHER-004000            ',
				'T174CR21       605810MAHOGANY-608000               ','T195AF9I       580316CARROT-827000                 ','T195AF9I       580316DARK NAVY-410000              ',
				'T195AF9I       580316HAMPTON BLUE-964000           ','TK194AA9       589757BLACK-001000                  ','TKU02AA9       584602WHITE-100000                  ',
				'TKU02AA9       584606GRAYHEATHER-004000            ','TKU02AA9       584608FRENCH BLUE-432000            ','TKU02AA9       584610DARK NAVY-410000-B            ',
				'TKU02AA9       584611MAHOGANY-608000-B             ','TKU02AA9       584612FRENCH BLUE-432000-B          ','TWU21AA9       584620INDIGO-435-UTHW7621           ',
				'TWU21AA9       584622ICE-469-UTHW5513R             ','TWU21AA9       585245SAILOR NAVY-587-UTHW3028R-B   ','TWU21AF9       580949RED-600-UTHW8207              ',
				'TWU21AF9       580962RED-600-UTHW8207              ','TWU21AF9       580963RED-600-UTHW8207              ','TWU21AF9       580977RED-600-UTHW8207              ',
				'T195AF9S       579749BLACK-001000  				','T195AF9I       580312BLACK-001000                  ','T195AF9S       579749BLUE FROST -420000            ',
				'T195AF9I       580312LICHEN-370000   '
];*/

$order_tids = ['TWU21AF9       580951QUARTZ-681-UTHW8060           ','TWU21AF9       580952GARDEN-356-UTHW8059           ',
			'TWU21AF9       580953PERIWINKLE-436-UTHW8057       ','TWU21AF9       580964RED-600-UTHW8207              '];

$docs = [];
$input_jobs = [];
$schedules = [];
$cat_ref = [];
$mos = [];

/* -------------------- */
$carton_size_ref = [];
$cut_size_master = [];
$orders_sizes_master = [];

/*------------------*/
$archive_query = [];
$delete_query  = [];

foreach($order_tids as $order_tid){
	$docs_query = "SELECT doc_no,cat_ref from $bai_pro3.plandoc_stat_log where order_tid = '$order_tid' ";
	$docs_result = mysqli_query($link,$docs_query);
	while($row = mysqli_fetch_array($docs_result)){
		$docs[] = $row['doc_no'];
		$cat_ref[] = $row['cat_ref'];
	}

	$schedules_query = "SELECT order_del_no from $bai_pro3.bai_orders_db where order_tid = '$order_tid' ";
	$schedules_result = mysqli_query($link,$schedules_query);
	while($row = mysqli_fetch_array($schedules_result)){
		$schedules[] = $row['order_del_no'];
	}
}

foreach($docs as $doc){
	$ijs_query = "SELECT distinct input_job_no_random from $bai_pro3.pac_stat_log_input_job where doc_no = $doc ";
	$ijs_result = mysqli_query($link,$ijs_query);
	while($row = mysqli_fetch_array($ijs_result)){
		$input_jobs[] = $row['input_job_no_random'];
	}
}
array_unique($schedules);
// tbl_carton_ref_archive;	carton_barcode
// tbl_carton_size_ref_archive;	parent_id
// tbl_cut_master_archive;	product_schedule
// tbl_cut_size_master_archive;	parent_id
// tbl_orders_master_archive;	product_schedule
// tbl_orders_sizes_master_archive;	parent_id
foreach($schedules as $schedule){
	$mos_query = "SELECT mo_no from $bai_pro3.mo_details where schedule = '$schedule' ";
	$mos_result = mysqli_query($link,$mos_query);
	while($row = mysqli_fetch_array($mos_result)){
		$mos[] = $row['mo_no'];
	}
	$cat_ref_query = "SELECT id from $brandix_bts.tbl_carton_ref where carton_barcode = '$schedule' ";
	$cat_ref_result = mysqli_query($link,$cat_ref_query);
	while($row = mysqli_fetch_array($cat_ref_result)){
		$carton_size_ref[] = $row['id'];
	}

	$cut_master_query = "SELECT id from $brandix_bts.tbl_cut_master where product_schedule = '$schedule' ";
	$cut_master_result = mysqli_query($link,$cut_master_query);
	while($row = mysqli_fetch_array($cut_master_result)){
		$cut_size_master[] = $row['id'];
	}

	$orders_master_query = "SELECT id from $brandix_bts.tbl_orders_master where product_schedule = '$schedule' ";
	$orders_master_result = mysqli_query($link,$orders_master_query);
	while($row = mysqli_fetch_array($orders_master_result)){
		$orders_sizes_master[] = $row['id'];
	}
}

//TAKING A BACKUP OF SCHEDULES AND DOCS

$docs_string = implode(',',$docs);
$schedules_string = implode(',',$schedules);
$mos_string = implode(',',$mos);
$input_jobs_string = implode(',',$input_jobs);
echo "<div id='data' style='word-wrap: break-word;'>";
echo "-----------------------DOCKETS----------------------------<br/><br/><br/><br/><br/>";
echo "$docs_string<br/><br/>";
echo "---------------------SCHEDULES----------------------------<br/><br/><br/><br/><br/>";
echo "$schedules_string<br/><br/>";
echo "-----------------------MOS----------------------------------------<br/><br/><br/><br/><br/><br/>";
echo "$mos_string<br/><br/>";
echo "---------------------INPUT JOBS----------------------------------------<br/><br/><br/><br/><br/>";
echo "$input_jobs_string<br/><br/><br/>";
echo "-------------------------------------------------------------------------------------------<br/><br/><br/>";

//1.
//BASED ON  - ORDER TID
// allocate_stat_log_archive;
// bai_orders_db_archive;
// bai_orders_db_club_archive;
// bai_orders_db_club_confirm_archive;
// bai_orders_db_confirm_archive;
// cat_stat_log_archive;
// cuttable_stat_log_archive;
// maker_stat_log_archive;
foreach($order_tids as $order_tid){
	$archive_query[] = "INSERT INTO $bai_pro3.allocate_stat_log_archive(select * from $bai_pro3.allocate_stat_log where order_tid = '$order_tid')";
	$archive_query[] = "INSERT INTO $bai_pro3.bai_orders_db_archive(select * from $bai_pro3.bai_orders_db where order_tid = '$order_tid')";
	$archive_query[] = "INSERT INTO $bai_pro3.bai_orders_db_club_archive(select * from $bai_pro3.bai_orders_db_club where order_tid = '$order_tid')";
	$archive_query[] = "INSERT INTO $bai_pro3.bai_orders_db_club_confirm_archive(select * from $bai_pro3.bai_orders_db_club_confirm where order_tid = '$order_tid')";
	$archive_query[] = "INSERT INTO $bai_pro3.bai_orders_db_confirm_archive(select * from $bai_pro3.bai_orders_db_confirm where order_tid = '$order_tid')";
	$archive_query[] = "INSERT INTO $bai_pro3.cat_stat_log_archive(select * from $bai_pro3.cat_stat_log where order_tid = '$order_tid')";
	$archive_query[] = "INSERT INTO $bai_pro3.cuttable_stat_log_archive(select * from $bai_pro3.cuttable_stat_log where order_tid = '$order_tid')";
	$archive_query[] = "INSERT INTO $bai_pro3.maker_stat_log_archive(select * from $bai_pro3.maker_stat_log where order_tid = '$order_tid')";

	$delete_query[] = "DELETE FROM $bai_pro3.allocate_stat_log where order_tid = '$order_tid' ";
	$delete_query[] = "DELETE from $bai_pro3.bai_orders_db where order_tid = '$order_tid' ";
	$delete_query[] = "DELETE from $bai_pro3.bai_orders_db_club where order_tid = '$order_tid'";
	$delete_query[] = "DELETE from $bai_pro3.bai_orders_db_club_confirm where order_tid = '$order_tid'";
	$delete_query[] = "DELETE from $bai_pro3.bai_orders_db_confirm where order_tid = '$order_tid'";
	$delete_query[] = "DELETE from $bai_pro3.cat_stat_log where order_tid = '$order_tid'";
	$delete_query[] = "DELETE from $bai_pro3.cuttable_stat_log where order_tid = '$order_tid'";
	$delete_query[] = "DELETE from $bai_pro3.maker_stat_log where order_tid = '$order_tid'";
}

//2.
$cat_refs_string = implode(",",$cat_ref);
if($cat_refs_string == '')
    $cat_refs_string = "''";
$archive_query[] = "INSERT INTO $bai_pro3.marker_ref_matrix_archive(select * from $bai_pro3.marker_ref_matrix where cat_ref IN ($cat_refs_string) )";
$delete_query[] = "DELETE from $bai_pro3.marker_ref_matrix where cat_ref IN ($cat_refs_string)";

//3.
//BASED ON - doc_no
// act_cut_status_archive;
// bai_qms_db_archive;
// cps_log_archive;
// cutting_table_plan_archive;
// pac_stat_log_input_job_archive;
// plan_dashboard_archive;
// plandoc_stat_log_archive;
// bundle_creation_data_archive;
// bundle_creation_data_temp_archive;
// tbl_miniorder_data_archive;


foreach($docs as $doc_no){
	$archive_query[] = "INSERT INTO $bai_pro3.act_cut_status_archive(select * from $bai_pro3.act_cut_status where doc_no = '$doc_no')";
	$archive_query[] = "INSERT INTO $bai_pro3.bai_qms_db_archive(select * from $bai_pro3.bai_qms_db where doc_no = '$doc_no')";
	$archive_query[] = "INSERT INTO $bai_pro3.cps_log_archive(select * from $bai_pro3.cps_log where doc_no = '$doc_no')";
	$archive_query[] = "INSERT INTO $bai_pro3.cutting_table_plan_archive(select * from $bai_pro3.cutting_table_plan where doc_no = '$doc_no')";
	$archive_query[] = "INSERT INTO $bai_pro3.pac_stat_log_input_job_archive(select * from $bai_pro3.pac_stat_log_input_job where doc_no = '$doc_no')";
	$archive_query[] = "INSERT INTO $bai_pro3.plan_dashboard_archive(select * from $bai_pro3.plan_dashboard where doc_no = '$doc_no')";
	$archive_query[] = "INSERT INTO $bai_pro3.plandoc_stat_log_archive(select * from $bai_pro3.plandoc_stat_log where doc_no = '$doc_no')";
	/**/$archive_query[] = "INSERT INTO $bai_pro3.fabric_priorities_archive(select * from $bai_pro3.fabric_priorities where doc_ref = '$doc_no')";
	/**/$archive_query[] = "INSERT INTO $brandix_bts.bundle_creation_data_archive(select * from $brandix_bts.bundle_creation_data where docket_number = '$doc_no')";
	/**/$archive_query[] = "INSERT INTO $brandix_bts.bundle_creation_data_temp_archive(select * from $brandix_bts.bundle_creation_data_temp where docket_number = '$doc_no')";
	/**/$archive_query[] = "INSERT INTO $brandix_bts.tbl_miniorder_data_archive(select * from $brandix_bts.tbl_miniorder_data where docket_number = '$doc_no')";

	$delete_query[] = "DELETE FROM $bai_pro3.act_cut_status where doc_no = '$doc_no' ";
	$delete_query[] = "DELETE from $bai_pro3.bai_qms_db where doc_no = '$doc_no' ";
	$delete_query[] = "DELETE from $bai_pro3.cps_log where doc_no = '$doc_no'";
	$delete_query[] = "DELETE from $bai_pro3.cutting_table_plan where doc_no = '$doc_no'";
	$delete_query[] = "DELETE from $bai_pro3.pac_stat_log_input_job where doc_no = '$doc_no'";
	$delete_query[] = "DELETE from $bai_pro3.plan_dashboard where doc_no = '$doc_no'";
	$delete_query[] = "DELETE from $bai_pro3.plandoc_stat_log where doc_no = '$doc_no'";
	/**/$delete_query[] = "DELETE from $bai_pro3.fabric_priorities where doc_ref = '$doc_no'";
	/**/$delete_query[] = "DELETE from $brandix_bts.bundle_creation_data where docket_number = '$doc_no'";
	/**/$delete_query[] = "DELETE from $brandix_bts.bundle_creation_data_temp where docket_number = '$doc_no'";
	/**/$delete_query[] = "DELETE from $brandix_bts.tbl_miniorder_data where docket_number = '$doc_no'";
}


//4.
// ims_log_archive;
// ims_log_backup_archive;
// plan_dashboard_input_archive;
foreach($input_jobs as $inpout_job){
	$archive_query[] = "INSERT INTO $bai_pro3.ims_log_archive(select * from $bai_pro3.ims_log where input_job_rand_no_ref = '$inpout_job')";
	$archive_query[] = "INSERT INTO $bai_pro3.ims_log_backup_archive(select * from $bai_pro3.ims_log_backup where input_job_rand_no_ref = '$inpout_job')";
	/**/$archive_query[] = "INSERT INTO $bai_pro3.plan_dashboard_input_archive(select * from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = '$inpout_job')";

	$delete_query[] = "DELETE FROM $bai_pro3.ims_log where input_job_rand_no_ref = '$inpout_job' ";
	$delete_query[] = "DELETE from $bai_pro3.ims_log_backup where input_job_rand_no_ref = '$inpout_job' ";
	/**/$delete_query[] = "DELETE from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = '$inpout_job'";
}

//5.
// m3_transactions_archive;
// mo_details_archive;
// mo_operation_quantites_archive;

foreach($mos as $mo_no){
	$archive_query[] = "INSERT INTO $bai_pro3.m3_transactions_archive(select * from $bai_pro3.m3_transactions where mo_no = '$mo_no')";
	$archive_query[] = "INSERT INTO $bai_pro3.mo_details_archive(select * from $bai_pro3.mo_details where mo_no = '$mo_no')";
	$archive_query[] = "INSERT INTO $bai_pro3.mo_operation_quantites_archive(select * from $bai_pro3.mo_operation_quantites where mo_no = '$mo_no')";

	$delete_query[] = "DELETE from $bai_pro3.m3_transactions where mo_no = '$mo_no'";
	$delete_query[] = "DELETE from $bai_pro3.mo_details where mo_no = '$mo_no'";
	$delete_query[] = "DELETE from $bai_pro3.mo_operation_quantites where mo_no = '$mo_no'";
}

//6.
// pac_stat_archive;
// pac_stat_input_archive;
// pac_stat_log_archive;
//bai_log_archive;
//bai_log_buf_archive;

foreach($schedules as $schedule){
	$archive_query[] = "INSERT INTO $bai_pro3.pac_stat_archive(select * from $bai_pro3.pac_stat where schedule = '$schedule')";
	$archive_query[] = "INSERT INTO $bai_pro3.pac_stat_input_archive(select * from $bai_pro3.pac_stat_input where schedule = '$schedule')";
	$archive_query[] = "INSERT INTO $bai_pro3.pac_stat_log_archive(select * from $bai_pro3.pac_stat_log where schedule = '$schedule')";
	$archive_query[] = "INSERT INTO $bai_pro.bai_log_archive(select * from $bai_pro.bai_log where delivery = '$schedule')";
	$archive_query[] = "INSERT INTO $bai_pro.bai_log_buf_archive(select * from $bai_pro.bai_log_buf where delivery = '$schedule')";
	$archive_query[] = "INSERT INTO $brandix_bts.tbl_carton_ref_archive(select * from $brandix_bts.tbl_carton_ref where carton_barcode = '$schedule')";
	$archive_query[] = "INSERT INTO $brandix_bts.tbl_cut_master_archive(select * from $brandix_bts.tbl_cut_master where product_schedule = '$schedule')";
	$archive_query[] = "INSERT INTO $brandix_bts.tbl_orders_master_archive(select * from $brandix_bts.tbl_orders_master where product_schedule = '$schedule')";

	$delete_query[] = "DELETE from $bai_pro3.pac_stat where schedule = '$schedule'";
	$delete_query[] = "DELETE from $bai_pro3.pac_stat_input where schedule = '$schedule'";
	$delete_query[] = "DELETE from $bai_pro3.pac_stat_log where schedule = '$schedule'";
	$delete_query[] = "DELETE from $bai_pro.bai_log where delivery = '$schedule'";
	$delete_query[] = "DELETE from $bai_pro.bai_log_buf where delivery = '$schedule'";
	$delete_query[] = "DELETE from $brandix_bts.tbl_carton_ref where carton_barcode = '$schedule'";
	$delete_query[] = "DELETE from $brandix_bts.tbl_cut_master where product_schedule = '$schedule'";
	$delete_query[] = "DELETE from $brandix_bts.tbl_orders_master where product_schedule = '$schedule'";
}

//7.
// transactions_log_archive;	transaction_id
// tbl_carton_ref_archive;	carton_barcode
// tbl_carton_size_ref_archive;	parent_id
// tbl_cut_master_archive;	product_schedule
// tbl_cut_size_master_archive;	parent_id
// tbl_orders_master_archive;	product_schedule
// tbl_orders_sizes_master_archive;	parent_id

foreach($carton_size_ref as $id){
	$archive_query[] = "INSERT INTO $brandix_bts.tbl_carton_size_ref_archive(select * from $brandix_bts.tbl_carton_size_ref where parent_id = '$id')";
	$delete_query[] = "DELETE from $brandix_bts.tbl_carton_size_ref where parent_id = '$id'";
}
foreach($cut_size_master as $id){
	$archive_query[] = "INSERT INTO $brandix_bts.tbl_cut_size_master_archive(select * from $brandix_bts.tbl_cut_size_master where parent_id = '$id')";
	$delete_query[] = "DELETE from $brandix_bts.tbl_cut_size_master where parent_id = '$id'";
}
foreach($orders_sizes_master as $id){
	$archive_query[] = "INSERT INTO $brandix_bts.tbl_orders_sizes_master_archive(select * from $brandix_bts.tbl_orders_sizes_master where parent_id = '$id')";
	$delete_query[] = "DELETE from $brandix_bts.tbl_orders_sizes_master where parent_id = '$id'";
}

echo "All set to Go<br/>";
//Finally Executing all Archiving queries
echo "<p class='warning'>";
foreach($archive_query as $arch){
    $res = 1;
    echo $arch.';<br/>';
    $res = mysqli_query($link,$arch) or call_me($arch);
    // if($res == 0)
    //     exit();
}
echo "</p>";
//Finally Executing all Deleting queries
echo "<p class='danger'>";
foreach($delete_query as $arch){
    $del = 1;
    echo $arch.';<br/>';
    $del = mysqli_query($link,$arch) or call_me($arch);
    // if($del == 0)
    //     exit();
}
echo "</p>";
echo "DONE";

function call_me($query){
    echo $query.' - falied <br/>';
    return 0;
}
echo "</div>";
?>

