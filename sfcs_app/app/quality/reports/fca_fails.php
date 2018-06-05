<!--
2014-01-21/DharaniD/Ticket #393026 / To display the section numbers in section column with respective modules in FCA Fail Status

-->
<?php
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
$view_access=user_acl("SFCS_0052",$username,1,$group_id_sfcs); 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>


<script language="javascript" type="text/javascript" src="<?=  getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>

<!--<link rel="stylesheet" href="../styles/ddcolortabs.css" type="text/css" media="all" />-->
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R');?>" type="text/css" media="all" />


<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/

/*====================================================
	- General html elements
=====================================================*/
/* body{ 
	margin:15px; padding:15px; border:1px solid #666;
	 font-family:Arial, Helvetica, sans-serif; font-size:88%; 
 }
 h2{ margin-top: 50px; }
 caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
 pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	 width:100%; font-size:12px;
	 border:1px solid #ccc;
}
 div.tools{ margin:5px; }
 div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
 th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
 td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; } */

</style>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js','3','R'); ?>"></script>
<script type="text/javascript">
	function verify_date()
  {
	var val1 = $('#sdate').val();
	var val2 = $('#edate').val();
	// d1 = new Date(val1);
	// d2 = new Date(val2);
	if(val1 > val2){
		sweetAlert('Start Date Should  be less than End Date','','warning');
		return false;
	}
	else
	{
	    return true;

	}
}
</script>


<?php 
// echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
</head>


<body>
<div class="panel panel-primary">
<div class="panel-heading">FCA Failed Log Status</div>
<div class="panel-body">

<?php
$sdate=date('Y-m-d');
$edate=date('Y-m-d');


// if(isset($_GET['date']))
// {
// 	$date=$_GET['date'];
// 	//echo "<div id='page_heading'><span style='float'><h3>FCA Fail Status - ".date("M-Y",strtotime($_GET['date']))."</h3></span><span style='float: right'><b>?</b>&nbsp;</span></div>";
// 	//echo "<h2>FCA Fail Stats - <font color=blue>".date("M-Y",strtotime($_GET['date']))."</font></h2>";
// 	echo '<a href='.getFullURL($_GET["r"],"fca_fails.php","N").'&date='.$date.'><span class="label label-success"> Last Month</span></a>  |  ';
// 	echo '<a href='.getFullURL($_GET["r"],"fca_fails.php","N").'&date='.date("Y-m-d",strtotime("+1 month", strtotime($date))).'><span class="label label-info"> Next Month</span></a>  |  ';
// }
?>
<form name="test" method="post" action="index.php?r=<?php echo $_GET['r']; ?>">
<div class="row">
<div class="col-md-3">
<label>Start Date:</label> 
<input type="text" data-toggle="datepicker" class="form-control"  name="sdate" id="sdate" value="<?php  if($sdate==""){ echo date("Y-m-d"); } else { echo $sdate; } ?>" size="10">
</div>
<div class="col-md-3">
	<label>End Date:</label>

<input type="text" data-toggle="datepicker" class="form-control"  name="edate" id="edate" value="<?php  if($edate==""){ echo date("Y-m-d"); } else { echo $edate; } ?>" size="10">
</div>
<input type="submit" class="btn btn-primary btn-sm" value="Submit"  name="submit" onclick="return verify_date()" style="margin-top:25px;">
</div>
</form>
<?php

// else
// {
// 	$date=date("Y-m-d");
// 	// echo "<div id='page_heading'><span style='float'><h3>FCA Fail Stats - ".date("M-Y",strtotime($date))."</h3></span><span style='float: right'><b>?</b>&nbsp;</span></div>";
// 	//echo "<h2>FCA Fail Stats - <font color=blue>".date("M-Y",strtotime($date))."</font></h2>";
// 	echo '<a href='.getFullURL($_GET["r"],"fca_fails.php","N").'&date='.date("Y-m-d",strtotime("-1 month")).'> <span class="label label-success"> Last Month</span></a>  |  ';
// }
//echo $date;
if(isset($_POST['submit']))
{
	echo "<hr/>";
$sec_db=array();
$sec_no=array();
$sql="select sec_mods,sec_id from $bai_pro3.sections_db where sec_id>0";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$temp=array();
	$temp=explode(",",$sql_row['sec_mods']);
	for($i=0;$i<sizeof($temp);$i++)
	{
		$sec_db[]=$temp[$i];
		$sec_no[]=$sql_row['sec_id'];
	}
}

$sdate=$_POST['sdate'];
$edate=$_POST['edate'];

$sql=" SELECT style,SCHEDULE,size,pcs,DATE_FORMAT(lastup,'%Y-%m-%d') AS lastup,remarks,reason,done_by FROM $bai_pro3.fca_audit_fail_db LEFT JOIN $bai_pro3.audit_ref ON fca_audit_fail_db.fail_reason=audit_ref.audit_ref 
    WHERE fca_audit_fail_db.pcs>0 AND (DATE(lastup) BETWEEN '".$sdate."' AND '".$edate."')";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// var_dump($sql_result);
if(mysqli_num_rows($sql_result)> 0) {

	echo '<div class="table-responsive"><table id="table_one"  class="table table-bordered" >';
	echo "<tr class='tblheading'><th>Date</th><th>Modules</th><th>Section</th><th>Style</th><th>Schedule</th><th>Size</th><th>Reason</th><th>Updated By</th></tr>";
	while($sql_row=mysqli_fetch_array($sql_result))
	{
			//2012-05-21
			//added explode code for getting section for relevent module of first array element
			//echo strlen($sql_row['remarks'])."<br>";
			if($sql_row['remarks'] > 0)
			{
				$module=explode(",",$sql_row['remarks']);
				$remarks=$sql_row['remarks'];
			}
			else
			{
				$remarks=0;
			}
			$sql2="select  group_concat(distinct bac_sec) as sec,color from $bai_pro.bai_log_buf where bac_no in (".$remarks.") and delivery=".$sql_row['SCHEDULE']."";
			// echo $sql2;
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$sections=$sql_row2["sec"];
				$color=$sql_row2["color"];
			}
			$size_value=ims_sizes('',$sql_row['SCHEDULE'],$sql_row['style'],$color,strtoupper($sql_row['size']),$link);
			//echo "<tr><td>".$sql_row['lastup']."</td><td>".$sql_row['remarks']."</td><td>".$sec_no[array_search($module[0],$sec_db)]."</td><td>".$sql_row['style']."</td><td>".$sql_row['schedule']."</td><td>".$sql_row['size']."</td><td>".$sql_row['reason']."</td><td>".$sql_row['done_by']."</td></tr>";
			echo "<tr><td>".$sql_row['lastup']."</td><td>".$sql_row['remarks']."</td><td>".$sections."</td><td>".$sql_row['style']."</td><td>".$sql_row['SCHEDULE']."</td><td>".$size_value."</td><td>".$sql_row['reason']."</td><td>".$sql_row['done_by']."</td></tr>";
		
	}

	echo "</table></div></div>";
}
	else {
	// echo "<br><div>No Data Found..</div>";
	  echo " <div class='alert alert-info alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<strong>Info!</strong> No Data Found...
					  </div>";
}
}
?>


<script language="javascript" type="text/javascript">
//<![CDATA[	
	var table2_Props = 	{					
					col_1: "select",
					col_2: "select",
					col_3: "select",
					display_all_text: " [ Show all ] ",
					btn_reset: true,
					bnt_reset_text: "Clear all ",
					rows_counter: true,
					rows_counter_text: "Total Rows: ",
					alternate_rows: true,
					sort_select: true,
					loader: true
				};
	setFilterGrid( "table_one",table2_Props );
//]]>		
</script>
</div></div>
</body>
</html>


