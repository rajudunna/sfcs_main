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

$order_tids = ['CA4921J8       579346452 BLX SPRING BLUE           ','CA4921J8       580839020 020 GREY HEATHER          ',
            'CD490SI8       573907731 RSW ROSEWATER             ','CD513MI8       572777101 101IVORY                  ',
            'CD5152I8       572758001 001BLACK                  ','CF5179I8       573911427 TSZ STELLAR               ',
            'CO1049I8       578460939 ZNYMINI CK - DEEP MAROON  ','CO1049I8       578460939 ZNYOZONE                  ',
            'CO1800G8       563241916 GYY HEATHER GREY          ','CO1800G8       563241916 GYY SUBTLE STRS SHRELINE  ',
            'CO1800G8       563241916 GYY WHITE                 ','CO1800I8       582817900 MP1 BLACK                 ',
            'CO1800I8       582817900 MP1 GREY HEATHER          ','CO1800I8       582817900 MP1 WHITE                 ',
            'CS5153F9       604727001 001BLACK                  ','CS5153F9       604728680 2NTNYMPH THIGH            ',
            'CS5180F9       604724001 001BLACK                  ','CS5180F9       604725427 TSZ STELLAR               ',
            'CS5180F9       604726429 VP8 PROVENCE              '];
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

