<!--
SFCS_PRO_Quality_Rej_Update_Size_wise
-->
<html>
<head>
<?php  
error_reporting(0);
$start_timestamp = microtime(true);
// Start output buffering
ob_start();
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
if($_GET['plantCode']){
    $plant_code = $_GET['plantCode'];
}else{
    $plant_code = $argv[1];
}
$username=$_SESSION['userName'];

set_time_limit(1600000);

?>

<script>
       
</script>
<script type="text/javascript" src="/sfcs_app/common/js/jquery.min.js" ></script>

<script type="text/javascript" src="/sfcs_app/common/js/tablefilter.js" ></script>

<script src="jquery.columnmanager/jquery.columnmanager.js"></script>
<link rel="stylesheet" type="text/css" href="jquery.columnmanager/clickmenu.css" />
<script src="jquery.columnmanager/jquery.clickmenu.pack.js"></script>
<style>
@import "TableFilter_EN/filtergrid.css";    
#page_heading
{
    	width: 100%;
	height: 25px;
    	color: WHITE;
    	background-color: #29759c;
    	z-index: -999;
    	font-family:Arial;
    	font-size:15px;  
    	margin-bottom: 10px;
}

#page_heading h3
{
	vertical-align: middle;
	margin-left: 15px;
	margin-bottom: 0;	
	padding: 0px;
}

#page_heading img
{
	margin-top: 2px;
    	margin-right: 15px;
}

body
{
	background-color: #EEEEEE;
	font-family:arial;
}

.tblheading th
{
	background-color:#29759C;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}


body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
white-space:nowrap; 
height:35px;
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: #29759C;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}






.BG {
background-image:url(Diag.gif);
background-repeat:no-repeat;/*dont know if you want this to repeat, ur choice.
}



</style>
<script type="text/javascript" src="datetimepicker_css.js"></script>

</head>
<body>
	<div class='panel panel-primary'>
	<div class="panel-heading">Critical Rejection Report</div>
	<div class='panel-body'>
<?php
$sdate=time();
while((date("N",$sdate))!=1) {
$sdate=$sdate-(60*60*24); // define monday
}
$edate=$sdate+(60*60*24*5); // define sunday 

//$edate=$sdate+(60*60*24*1);

$sdate=date("Y-m-d",$sdate);
$edate=date("Y-m-d",$edate);

// $sdate='2020-10-01';
// $edate='2020-10-30';


$minrej_per="0.4%"; // FOR ENTER THE REJECTION PERCENTAGE.

 echo "<div><h4><span class='label label-primary'>Rejection Percentage - Above ".$minrej_per." Period From&nbsp;".$sdate."&nbsp;&nbsp;To&nbsp;&nbsp;".$edate."</span></h4>"; 
 echo "<h4><span class='label label-primary'>".date("Y-m-d H:i:s")."</span></h4></div>";
			
	echo "<h4><span class='label label-warning'>Summary of Details</span></h4>";
	echo "<div class='table-responsive'>";
	echo '<table id="tableone" cellspacing="0" class="mytable table table-bordered">';
	echo "<tr class='tblheading' >
	<th  class='filter'>Ex_factory</th>
	<th  class='filter'>Schedule</th>
	<th  class='filter'>Style</th>
	<th  class='filter'>Color</th>
	<th  class='filter'>Size</th>
	<th  class='filter'>Section</th>
	<th  class='filter'>Module</th>
	<th  class='filter'>Order <br/> Qty</th>
	<th  class='filter'>Sewing <br/> Out</th>
	<th  class='filter'>Rejection <br/> Out</th>
	<th  class='filter'>Rej %</th>
	<th  class='filter'>Fabric <br/> Damages</th>
	<th  class='filter'> % </th>
	<th  class='filter'>Cutting <br/> Damages</th>
	<th  class='filter'> % </th>
	<th  class='filter'>Sewing <br/> Damages</th>
	<th  class='filter'> % </th>
	<th  class='filter'>Machine <br/> Damages</th>
	<th  class='filter'> % </th>
	<th  class='filter'>Embl <br/> Damages</th>
	<th  class='filter'> % </th> </tr>";
  
	$sql="select schedule,style,fg_color,ex_factory,size,GROUP_CONCAT(CONCAT('''', rh_id, '''' )) AS \"rh_id\",total_rejection from $pts.rejection_header where plant_code='$plant_code' and ex_factory between \"$sdate\" and \"$edate\" group by style,schedule,fg_color,size order by ex_factory desc ";
	// echo $sql;
	$sql_result=mysqli_query($link_new, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	$grand_output=0;
	$grand_rejections=0;
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$order_qty=0;
			
		$span1='<p style="text-align: left;">';
		$span2='<p style="padding-left:20px; margin-top:-20px; position:relative; ">';
		$span3='</p>';
		$span4='</p></p>';

		$schedule=$sql_row['schedule'];
		$style=$sql_row['style'];
	    $color=$sql_row['fg_color'];
	    // $sub_po=$sql_row['sub_po'];
	    $size=$sql_row['size'];
	    $rh_id=$sql_row['rh_id'];
		$ex_fact_date=$sql_row['ex_factory'];
		$total_rejection=$sql_row['total_rejection'];
		
		
		$sql1="select sum(good_quantity) as \"qty\" from $pts.transaction_log where style='$style' AND SCHEDULE='$schedule' AND color='$color' and size='$size' and operation='130'";
		// echo $sql1."<br/>";

		$sql_result1=mysqli_query($link_new, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$sw_out=$sql_row1['qty'];	
		}
		$sql22="select sum(quantity) as \"qty\" from $pps.mp_mo_qty where SCHEDULE='$schedule' AND color='$color' and size='$size' and mp_qty_type='ORIGINAL_QUANTITY'";
		// echo $sql22."<br/>";
		$sql_result22=mysqli_query($link_new, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result22))
		{
			$order_qty=$sql_row1['qty'];	
		}
		$grand_output=$sw_out;
		$grand_rejections=$total_rejection;
		$cutting_damage=0;
		$cutting_damage_per=0;
		$fabric_damage=0;
		$fabric_damage_per=0;
		$sewing_damage=0;
		$sewing_damage_per=0;
		$machine_damage=0;
		$machine_damage_per=0;
		$embl_damage=0;
		$embl_damage_per=0;
		$rej_trans="select reason_id,sum(rejection_quantity) as rej_qty,workstation_code,workstation_id from $pts.rejection_transaction where rh_id in ($rh_id) group by reason_id";
		// echo $rej_trans."<br/>";
		$sql_res_rej_trans=mysqli_query($link_new, $rej_trans) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sqlrow2=mysqli_fetch_array($sql_res_rej_trans))
		{
			$rej_qty=$sqlrow2['rej_qty'];	
			$reason_id=$sqlrow2['reason_id'];	
			$workstation=$sqlrow2['workstation_code'];	
			$workstation_id=$sqlrow2['workstation_id'];	

			$get_section_ids="select section_id from $pms.workstation where workstation_id='$workstation_id' and plant_code='$plant_code'";
			$sec_qry_res=mysqli_query($link_new, $get_section_ids) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sec_row=mysqli_fetch_array($sec_qry_res))
			{
				$section_id=$sec_row['section_id'];	
			}

			$get_sections="select section_name from $pms.sections where section_id='$section_id' and plant_code='$plant_code'";
			$sec1_qry_res=mysqli_query($link_new, $get_sections) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sec_row1=mysqli_fetch_array($sec1_qry_res))
			{
				$section_name=$sec_row1['section_name'];	
			}

			$section=$section_name;
			
		
			$reason_query="select department_type from $mdm.reasons where reason_id='$reason_id' and is_active=1";
			$reasons_qry_res=mysqli_query($link_new, $reason_query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_row=mysqli_fetch_array($reasons_qry_res))
			{
				$department_type=$res_row['department_type'];	
			}
			if($grand_output > 0){

				if($department_type==='INSPECTION'){
					$fabric_damage=$rej_qty;
					$fabric_damage_per=round(($rej_qty/$grand_output)*100,1);
				}
	
				if($department_type==='CUTTING'){
					$cutting_damage=$rej_qty;
					$cutting_damage_per=round(($rej_qty/$grand_output)*100,1);
				}
	
				if($department_type==='SEWING'){
					$sewing_damage=$rej_qty;
					$sewing_damage_per=round(($rej_qty/$grand_output)*100,1);
				}
	
				if($department_type==='MACHINE'){
					$machine_damage=$rej_qty;
					$machine_damage_per=round(($rej_qty/$grand_output)*100,1);
				}
	
				if($department_type==='EMBELLISHMENT'){
					$embl_damage=$rej_qty;
					$embl_damage_per=round(($rej_qty/$grand_output)*100,1);
				}
			}

			
		}

		if($grand_output>0)
		{
			$rej_per=round(($grand_rejections/$grand_output)*100,1)."%"."</br>";

			if($rej_per >= $minrej_per) 
			{
				// for  total values of rejections
				$array_val=array('exfact'=>$ex_fact_date,'schedule'=>$schedule,'style'=>$style,'colour'=>$color,'orderqty'=>$order_qty,'grandoutput'=>$grand_output,'grdrej'=>$grand_rejections,'rejper'=>$rej_per,'module'=>$workstation,'section'=>$section,'size'=>$size,'fabric_damage'=>$fabric_damage,'fabric_damage_per'=>$fabric_damage_per,'cutting_damage'=>$cutting_damage,'cutting_damage_per'=>$cutting_damage_per,'sewing_damage'=>$sewing_damage,'sewing_damage_per'=>$sewing_damage_per,'machine_damage'=>$machine_damage,'machine_damage_per'=>$machine_damage_per,'embl_damage'=>$embl_damage,'embl_damage_per'=>$embl_damage_per);
			
				echo "<tr bgcolor=white style=align:center;>";
				echo "<td style='text-align: center;' >".$array_val['exfact']."</td>";
				echo "<td style='text-align: center;'>".$array_val['schedule']."</td>";
				echo "<td style='text-align: center;'>".$array_val['style']."</td>";
				echo "<td style='text-align: center;'>".$array_val['colour']."</td>";
				echo "<td style='text-align: center;'>".$array_val['size']."</td>";	
				echo "<td style='text-align: center;'>".$array_val['section']."</td>";
				echo "<td style='text-align: center;'>".$array_val['module']."</td>";	
				echo "<td style='text-align: center;'>".$array_val['orderqty']."</td>";
				echo "<td style='text-align: center;'>".$array_val['grandoutput']."</td>";
				echo "<td style='text-align: center;'>".$array_val['grdrej']."</td>";
				echo "<td style='text-align: center;'>".$array_val['rejper']."</td>";	 
				echo "<td style='text-align: center;'>".$array_val['fabric_damage']."</td>";
				echo "<td style='text-align: center;'>".$array_val['fabric_damage_per']."%</td>";
				echo "<td style='text-align: center;'>".$array_val['cutting_damage']."</td>";
				echo "<td style='text-align: center;'>".$array_val['cutting_damage_per']."%</td>";
				echo "<td style='text-align: center;'>".$array_val['sewing_damage']."</td>";
				echo "<td style='text-align: center;'>".$array_val['sewing_damage_per']."%</td>";
				echo "<td style='text-align: center;'>".$array_val['machine_damage']."</td>";
				echo "<td style='text-align: center;'>".$array_val['machine_damage_per']."%</td>";
				echo "<td style='text-align: center;'>".$array_val['embl_damage']."</td>";
				echo "<td style='text-align: center;'>".$array_val['embl_damage_per']."%</td>";
				
		
				echo "</tr>";
			}																																																												
		}
	
	}
	echo "</table>";	
	echo "</div>";

	?>
	<script language="javascript" type="text/javascript">
//<![CDATA[
var table2Filters = {
		btn: true,
		loader: true,
		loader_text: "Filtering data...",
		sort_select: true,
		exact_match: true,
		rows_counter: true,
		btn_reset: true
		
	}
	setFilterGrid("tableone",0,table2Filters);
	
//]]>
</script>
<?php
$cache_date="critical_rejection_report_new";
$cachefile = $path."/quality/reports/".$cache_date.'.htm';
// saving captured output to file
file_put_contents($cachefile, ob_get_contents());
// end buffering and displaying page
ob_end_flush();


$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
echo "Execution took ".$duration." milliseconds.";
?>
</div></div>
</body>
</html>


