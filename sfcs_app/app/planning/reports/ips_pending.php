<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php  
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
$view_access=user_acl("SFCS_0235",$username,1,$group_id_sfcs); 
?>

<html>
<head>
<title>IPS Allocation status</title>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R')?>"></script>

<!--<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script>-->

<script type="text/javascript">


	function check_date()
	{
		var from_date = document.getElementById("sdate").value;
		var to_date   = document.getElementById("edate").value;
		var today     = document.getElementById("today").value;
		console.log(from_date);


		if ( to_date < from_date ){
			sweetAlert("End date should be greater than Start date",'','warning');
			document.getElementById("edate").value = "<?php  echo date("Y-m-d");  ?>";
			document.getElementById("sdate").value = "<?php  echo date("Y-m-d");  ?>";
		}if(to_date > today){
			sweetAlert("End date should not be greater than Today",'','warning');
			document.getElementById("edate").value = "<?php  echo date("Y-m-d");  ?>";
		}
	}
</script>

<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',4,'R'); ?>" rel="stylesheet" type="text/css" />

</head>
<body>

<div class="panel panel-primary">
<div class="panel-heading">IPS Allocation Report</div>
<div class="panel-body">
<div class="form-group">
<form name="input" method="post" action="index.php?r=<?php echo $_GET['r']; ?>">
<div class="row">
<div class="col-sm-3">
	<input type="hidden" name="today" id="today" value="<?php echo date("Y-m-d"); ?>">
Lay Plan Create Start Date: <input type="text"  class="form-control" id="sdate" data-toggle='datepicker' onchange="check_date();" name="sdate" size="8" value="<?php  if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>" />
</div>
<div class="col-sm-3">
Lay Plan Create End Date: <input type="text"  class="form-control" id="edate" data-toggle='datepicker' onchange="check_date();" name="edate" size="8" value="<?php  if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>" />
</div><br/>
 <span id="error" style="color: Red; display: none"></span>
<div class="col-sm-3">
<input height="21 px"  type="submit" name="show"   class="btn btn-primary" value="Show" id="show" />
</div>
</div><hr>
</form>
</div>


<?php
if(isset($_POST['show']))
{
	$row_count = 0;
	$s_date=$_POST['sdate'];
	$e_date=$_POST['edate'];
	$order_tid=array();
	$tot_doc=array();
	$pending_ips='';
	$pending_com='';
	$cut_com='';
	$j=0;
	//$sql1="select DISTINCT LEFT(order_tid, 8) as style, MID(order_tid, 16,6) as schedule , Mid(order_tid,22) as color, group_concat(doc_no) as doc_no from plandoc_stat_log group by style,schedule,color order by style,schedule,color";;
	echo "<div class='table table-responsive'>
		    <table border='1px' id='table1' class='table table-bordered' >
			<tr class='success'><th>Style</th><th>Schedule</th><th>Color</th><th>Total Jobs</th><th>Planned Jobs(Completed)</th><th>Planned Jobs(Pending)</th><th>Cuts Completed</th></tr>";
	$sql1="select distinct order_tid,count(doc_no) as cuts from $bai_pro3.order_cat_doc_mk_mix where date between '".$s_date."' and '".$e_date."' group by order_tid";
	// echo $sql1."<br>";
	$result1=mysqli_query($link, $sql1) or exit("Sql Error1--1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$order_tid[]=$row1['order_tid'];
		$tot_doc[]=$row1['cuts'];
	}
	for($i=0;$i<sizeof($order_tid);$i++)
	{
		$sql11="select * from $bai_pro3.bai_orders_db where order_tid='$order_tid[$i]'";
		$result11=mysqli_query($link, $sql11) or exit("Sql Error--11".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row11=mysqli_fetch_array($result11))
		{
			$color_code=$row11['color_code'];
			$style=$row11['order_style_no'];
			$schedule=$row11['order_del_no'];
			$color=$row11['order_col_des'];
		}
		$sql2="select doc_no,pcutno from $bai_pro3.order_cat_doc_mk_mix where order_tid='$order_tid[$i]' and plan_module is not null and act_cut_status='' order by doc_no";
		$result2=mysqli_query($link, $sql2) or exit("Sql Error--2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$count=mysqli_num_rows($result2);
		$jj=0;
		while($row2=mysqli_fetch_array($result2))
		{
			//echo $j."<br>";
			$jj++;
			if($count==$jj)
			{
				$pending_ips.=chr($color_code).leading_zeros($row2["pcutno"],3)."";
			}
			else
			{
				if($j==10)
				{
					$pending_ips.=chr($color_code).leading_zeros($row2["pcutno"],3)."<br>";
					$j=0;
				}
				else
				{
					$pending_ips.=chr($color_code).leading_zeros($row2["pcutno"],3).",";
					$j++;
				}
			}
		}
		$j=0;
		$sql3="select doc_no,pcutno from $bai_pro3.order_cat_doc_mk_mix where order_tid='$order_tid[$i]' and (plan_module is null or plan_module='') order by doc_no";
		$result3=mysqli_query($link, $sql3) or exit("Sql Error--3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$count=mysqli_num_rows($result3);
		$jj=0;
		while($row3=mysqli_fetch_array($result3))
		{
			$jj++;
			if($count==$jj)
			{
				$pending_com.=chr($color_code).leading_zeros($row3["pcutno"],3)."";
			}
			else
			{
				if($j==10)
				{
					$pending_com.=chr($color_code).leading_zeros($row3["pcutno"],3).",<br>";
					$j=0;
				}
				else
				{
					$pending_com.=chr($color_code).leading_zeros($row3["pcutno"],3).",";
					$j++;
				}
			}
			
		}
		$sql4="select doc_no,pcutno from $bai_pro3.order_cat_doc_mk_mix where order_tid='$order_tid[$i]' and act_cut_status='DONE' order by doc_no";
		$j=0;
		$result4=mysqli_query($link, $sql4) or exit("Sql Error--4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$count=mysqli_num_rows($result4);
		$jj=0;
		while($row4=mysqli_fetch_array($result4))
		{
			$jj++;
			if($count==$jj)
			{
				$cut_com.=chr($color_code).leading_zeros($row4["pcutno"],3)."";
			}
			else
			{
				if($j==10)
				{
					$cut_com.=chr($color_code).leading_zeros($row4["pcutno"],3).",<br>";
					$j=0;
				}
				else
				{
					$cut_com.=chr($color_code).leading_zeros($row4["pcutno"],3).",";
					$j++;
				}
			}
		}
		
		echo "<tr><td>$style</td><td>$schedule</td><td>$color</td><td>$tot_doc[$i]</td><td>$pending_ips</td><td>$pending_com</td><td>$cut_com</td></tr>";
		//echo "<br>";
		$pending_ips='';
		$pending_com='';
		$cut_com='';
		$row_count++;
	}
	echo "</table></div>";
	if($row_count == 0){
		echo "<div class='alert alert-danger'><p>No Data Found</p></div>";
	}			
}

?>
</div>
<script language="javascript" type="text/javascript">
//<![CDATA[
var MyTableFilter = {  exact_match: false,
display_all_text: "Show All",
col_0: "select",
col_1: "select" }
	setFilterGrid( "table1", MyTableFilter );
//]]>
</script>


</body>
</div>
</div>
</html>