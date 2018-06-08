<?php
// include("dbconf.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));


$view_access=user_acl("SFCS_0142",$username,1,$group_id_sfcs);
$auth_users=user_acl("SFCS_0142",$username,7,$group_id_sfcs);

//$auth_users=array("kirang","mohanr","gayanl","buddhikam");
if(!in_array($username,$auth_users))
{
	header("location: restricted.php");
}


?>


<head>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',3,'R'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/style.css',1,'R'); ?>">
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/jquery.autocomplete.css',1,'R'); ?>" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.autocomplete.js',1,'R'); ?>"></script>

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/filtergrid.css',3,'R'); ?>"></script>

<!---<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0;
 width:auto;
float:right;

</style>



<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px;  padding:5px; background-color:#f4f4f4; solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; solid #ccc; white-space: nowrap;}
td{ padding:2px; white-space: nowrap;}
</style> -->
<script type="text/javascript">
$(document).ready(function(){
 $("#tag").autocomplete("autocomplete.php", {
		selectFirst: true
	});
	$("#fade1").fadeOut(3000);
});
</script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
</head>

<!-- <div id="page_heading"><span style="float"><h3>Quality Rejection Reversal Form</h3></span><span style="float: right">&nbsp;</span></div> -->
<br/>

<div class='panel panel-primary'>
<div class='panel-heading'>Quality Rejection Reversal Form</div>
<div class='panel-body'>
<div class='form-group'>
<div class='table-responsive'>

<form action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="POST">


<div class='col-md-3 col-sm-3 col-xs-12'>
<h5>Schedule:</h5><input name="schedule" type="text" class="form-control col-md-7 col-xs-12 float" value="<?php $_POST['schedule'];?>" id="tag" size="20" required/>
</div>
<div class='col-md-2 col-sm-3 col-xs-12'>
<input type="submit" value="Search" name="search" class="btn btn-success" style="margin-top: 34px;">
<a href="<?= getFullURL($_GET['r'],'qms_3.php','N'); ?>"  class="btn btn-link"><p style="margin-top: -31px;margin-left: 70px;">Deleted Transactions</p></a>
</div>

</form>


<?php 
if(isset($_GET['tid']))
{

	$tid_ref=$_GET['tid'];
	$locationid=$_GET['location'];
	$qms_qty=$_GET['qms_qty1'];
	//Insert selected row into table deleted table
	$sql1="insert ignore into $bai_pro3.bai_qms_db_deleted select * from $bai_pro3.bai_qms_db where qms_tid='".$tid_ref."' ";

	$result1=mysqli_query($link, $sql1) or die("Sql error1".$sql1.mysqli_errno($GLOBALS["___mysqli_ston"]));
	//reduce qty from location table based on location
	if($locationid != null) {
		$sql3="update $bai_pro3.bai_qms_location_db set qms_cur_qty=(qms_cur_qty-$qms_qty) where qms_location_id='".$locationid."'";
		$result3=mysqli_query($link, $sql3) or die("Sql error".$sql3.mysqli_errno($GLOBALS["___mysqli_ston"]));
	}
	//delete selected row from bai_qms_db table
	$sql2="delete from $bai_pro3.bai_qms_db where qms_tid='".$tid_ref."'";
	$result2=mysqli_query($link, $sql2) or die("Sql error".$sql2.mysqli_errno($GLOBALS["___mysqli_ston"]));
	
	//To update M3 Bulk Upload Tool (To pass negative entry)
	$sql2="insert into m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_log_user,sfcs_status,m3_mo_no,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref) select NOW(),sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,(sfcs_qty*-1),sfcs_reason,USER(),0,m3_mo_no,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_reason<>'' and sfcs_tid_ref='".$tid_ref."'";
	mysqli_query($link, $sql2) or die("Sql error".$sql2.mysqli_errno($GLOBALS["___mysqli_ston"]));
	
	echo "<div id=\"fade1\" >";
	echo "<script>sweetAlert('Record Deleted Successfully','','success')</script>";
	echo "</div>";
	
}
if(isset($_POST['search']) || $_GET['schedule_id'])
{

	$schedule=$_POST['schedule'];
	if($_GET['schedule_id'])
	{
		$schedule=$_GET['schedule_id'];
	}
	$sql="select * from $bai_pro3.bai_qms_db where qms_tran_type in (3,5) and qms_schedule='".$schedule."'";
	// echo $sql."<br>";
	$result=mysqli_query($link, $sql) or die("Sql error".$sql.mysqli_errno($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($result)>0)
	{
		$msg="<table border='1px' class=\"table table-bordered\"  id=\"table1\"><tr><th>Style</th><th>Schedule No</th><th>Color</th><th>Date</th><th>Quantity</th><th>Control</th></tr>";
		while($row=mysqli_fetch_array($result))
		{
			$tid=$row["qms_tid"];
			$location_id=$row["location_id"];
			$qms_qty1=$row["qms_qty"];
			
			$url = '?r='.$_GET['r'];
			
			$msg.="<tr><td>".$row["qms_style"]."</td><td>".$row["qms_schedule"]."</td><td>".$row["qms_color"]."</td><td>".$row["log_date"]."</td><td>".$row["qms_qty"]."</td><td><a href=\"$url&tid=$tid&schedule_id=$schedule&location=$location_id&qms_qty1=$qms_qty1\" class=\"btn btn-danger\">Delete</a></td></tr>";		
		}
		$msg.="</table>";
		echo $msg;
	}
	else
	{
		echo "<script>sweetAlert('This Schedule no is not available','','error')</script>";
	}
}


?>
</div>
</div>
</div>
</div>
<script language="javascript" type="text/javascript">
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table1",table6_Props );
</script>
