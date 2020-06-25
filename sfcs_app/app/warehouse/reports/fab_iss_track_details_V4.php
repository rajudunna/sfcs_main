
<?php
//include"header.php";
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
//$view_access=user_acl("SFCS_0074",$username,1,$group_id_sfcs); 
// $table_filter = getFullURLLevel($_GET['r'],'TableFilter_EN/tablefilter.js',1,'R');

?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<?php 
// set_time_limit(9000);
// echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/master/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>	
<!-- <script type="text/javascript" src="datetimepicker_css.js"></script> -->
<!-- <script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script> -->
<!-- <script language="javascript" type="text/javascript" src="<?php echo $table_filter ?>"></script> -->

<style type="text/css" media="screen">
td{

	text-weight:bold;
}
th{
	text-align:center;
	white-space: nowrap;
}


</style>

<div class="panel panel-primary">

<div class="panel-heading">Fabric issue Track Details</div>
<div class="panel-body">

<form action="index.php?r=<?php echo $_GET['r'] ?>" method="post">
<div class="row">
	<div class="col-md-3">
		<label>Enter Date: </label>
		<input class="form-control" type="text" data-toggle="datepicker" name="sdat"  size=8 value="<?php  if(isset($_POST['sdat'])) { echo $_POST['sdat']; } else { echo date("Y-m-d"); } ?>"/>
	</div>
	<input class="btn btn-sm btn-primary" type="submit" value="Show" name="submit" onclick="document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';" style="margin-top:25px;"/></div>
<!--<td><a style="font-size:15px;" href="FabricIssuedDetails.xls">Export To Excel</a></td>-->
	<?php 
	//   echo "<a href="."\"javascript:NewCssCal('sdat','yyyymmdd','dropdown')\">";
	//   echo "<img src='images/cal.gif' width='16' height='16' alt='Pick a date'></a>";
	?>
</form>
<!-- <span id="msg" style="display:none;"><h4>Please Wait.. While Processing The Data..<h4></span> -->

<?php
if(isset($_POST["submit"]))
{
		$sdate=$_POST["sdat"];
		$edate=$_POST["sdat"];

		
			$sHTML_Content="<br/><hr/><div class=\"table-responsive\"><table class=\"table table-bordered\" id=\"table1\" >
			<thead><tr class='success'>
			<th>Date</th>
			<th>Time</th>
			<th>Style</th>
			<th>Schedule</th>
			<th>Color</th>
			<th>DocketNo</th>
			<th>Mode</th>
			<th>CutNo</th>
			<th>Category</th>
			<th>Workstation Id</th>
			<th>Quantity</th>
			<th>LOT No</th>
			<th>BATCH</th>
			<th>Roll No</th>
			<th>Request Quantity</th>
			<th>Issued Quantity</th>
			<th>Section</th>
			<th>Picking List</th>
			<th>Delivery No</th>
			<th>Issued Person</th>
			<th>System Status</th>
			<th>Movex Status</th>
			</tr></thead>";

			
			$sql="SELECT DISTINCT(UPPER(cutno)) as cut FROM $bai_rm_pj1.store_out WHERE DATE BETWEEN \"".$sdate."\" AND \"".$edate."\" AND (cutno LIKE \"D%\" OR cutno LIKE \"R%\") ORDER BY CUTNO";
			// echo $sql."<br>";
			$result=mysqli_query($link, $sql) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows_num=mysqli_num_rows($result);

			while($row=mysqli_fetch_array($result))
			{
				$cutno=$row["cut"];
				
				
				$sql1="select GROUP_CONCAT(tran_tid) AS tids,GROUP_CONCAT(DISTINCT DATE) AS dat,LEFT(UPPER(cutno),1) AS cutn from $bai_rm_pj1.store_out where cutno=\"".$cutno."\" and DATE BETWEEN \"".$sdate."\" AND \"".$edate."\"";
				$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1=mysqli_fetch_array($result1))
				{
					$tids=$row1["tids"];
					$date=$row1["dat"];
					//$qty_issued=round($row1["qty"],2);
					$cutn=$row1["cutn"];
					//$log_time=
				}
				
				$qty_issued=0;
				$sql1Z="select sum(qty_issued) as qty from $bai_rm_pj1.store_out where cutno=\"".$cutno."\"";
				$result1Z=mysqli_query($link, $sql1Z) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1Z=mysqli_fetch_array($result1Z))
				{
					$qty_issued=round($row1Z["qty"],3);
				}
				
				
				
				$cutno_explode=explode("$cutn",$cutno);
				
				
				$doc_no=$cutno_explode[1];
				//To get style,fg_color,jm_cut_job_id,plies,length,ratio_comp_group_id by from getdata_jm_dockets($doc_no,$plant_code) in function_v2.php 
				$result_to_get_details=getdata_jm_dockets($doc_no,$plant_code);
				$style=$result_to_get_details['style'];
				$color=$result_to_get_details['fg_color'];
				$jm_cut_job_id=$result_to_get_details['jm_cut_job_id'];
				$plies=$result_to_get_details['plies'];
				$length=$result_to_get_details['length'];
				$ratio_comp_group_id=$result_to_get_details['ratio_comp_group_id'];
				
				$tot_qty=$plies*$length;
				$req_qty=$plies*$length;
				//To get fabric_category from getdata_ratio_component_group($ratio_comp_group_id,$plant_code) in function_v2.php 
				$result_to_get_category=getdata_ratio_component_group($ratio_comp_group_id,$plant_code);
				$category=$result_to_get_category['fabric_category'];

                //To get schedules from  getdata_mp_mo_qty($po_number,$plant_code) in function_v2.php
				$result_to_get_schedules=getdata_mp_mo_qty($po_number,$plant_code);
				$schedule=$result_to_get_schedules['schedule'];

				//To get po number and cut number
                $sql212="select cut_number,po_number from $pps.jm_cut_job where jm_cut_job_id='$jm_cut_job_id'";
				$result212=mysqli_query($link, $sql212) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row212=mysqli_fetch_array($result212))
				{
				  $cut_number=$row212['cut_number'];
				  $po_number=$row212['po_number'];
				}
				//To get jm_docket_id from jm_dockets based on docket_number
				$sql213="select cut_number,po_number from $pps.jm_dockets where docket_number=$doc_no";
				$result213=mysqli_query($link, $sql213) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row213=mysqli_fetch_array($result213))
				{
				  $jm_docket_id=$row213['jm_docket_id'];
				}
				//To get resource_id From task_jobs
				$get_refrence_no="SELECT resource_id FROM $tms.task_jobs WHERE task_job_reference='$jm_docket_id' AND task_type='DOCKET' AND plant_code='$plantcode'";
				$get_refrence_no_result=mysqli_query($link_new, $get_refrence_no) or exit("Sql Error at refrence_no".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($refrence_no_row=mysqli_fetch_array($get_refrence_no_result))
				{
					$resource_id = $refrence_no_row['resource_id'];
				}
				
				
				$sql5="SELECT MAX(TIME(log_stamp)) AS maxlog FROM $bai_rm_pj1.store_out WHERE cutno=\"".$cutno."\" and date=\"".$date."\"";
				
				$sql_result5=mysqli_query($link, $sql5) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row5=mysqli_fetch_array($sql_result5))
				{
					$log_time=$row5["maxlog"];
				}
				$schedules=(implode("','" , $schedule));
				$sHTML_Content.="<tr>";
				$sHTML_Content.="<td class=\"  \">".$date."</td>";
				$sHTML_Content.="<td class=\"  \">".$log_time."</td>";
				$sHTML_Content.="<td class=\"  \">".$style."</td>";
				$sHTML_Content.="<td class=\"  \">".$schedules."</td>";
				$sHTML_Content.="<td class=\"  \">".$color."</td>";
				$sHTML_Content.="<td class=\"  \">".$buyer."</td>";
				$sHTML_Content.="<td class=\"  \">".$cutno_explode[1]."</td>";
				if($cutn=="D")
				{
					$sHTML_Content.="<td class=\"  \">Normal</td>";
					//$table="plandoc_stat_log";
				}
				else
				{
					$sHTML_Content.="<td class=\"  \">Recut</td>";
					//$table="recut_v2";
				}
				$sHTML_Content.="<td class=\"  \">".$cut_number."</td>";
				
				$sHTML_Content.="<td class=\"  \">".$category."</td>";
				$sHTML_Content.="<td class=\"  \">".$resource_id."</td>";
				
				$sHTML_Content.="<td class=\"  \">".round($tot_qty,0)."</td>";
				$sql5="SELECT GROUP_CONCAT(DISTINCT lot_no SEPARATOR '/') AS lot_no,GROUP_CONCAT(ref2 SEPARATOR '/') AS roll,SUM(qty_issued) AS qty_issued FROM  $bai_rm_pj1.store_in WHERE tid IN($tids)";
				//echo $sql5."<br>";
				$result5=mysqli_query($link, $sql5) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				$no_rows5=mysqli_num_rows($result5);
				while($row5=mysqli_fetch_array($result5))
				{
					$lot_no=$row5["lot_no"];
					$roll_no=$row5["roll"];
					//$qty_issued=$row5["qty_issued"];	
				}
				$sql6="select GROUP_CONCAT(DISTINCT trim(batch_no) SEPARATOR '/') AS batch_no from $bai_rm_pj1.sticker_report where lot_no=$lot_no";
				$result6=mysqli_query($link, $sql6) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row6=mysqli_fetch_array($result6))
				{
					$batch_no=$row6["batch_no"];
				}	
				
				$sHTML_Content.="<td class=\"  \">".$lot_no."</td>";
				$sHTML_Content.="<td class=\"  \">".$batch_no."</td>";
				$sHTML_Content.="<td class=\"  \">".$roll_no."</td>";
				
				$sHTML_Content.="<td class=\"  \">".$req_qty."</td>";
				$sHTML_Content.="<td class=\"  \">".$qty_issued."</td>";
				
				
				$sql6="select section,picking_list,delivery_no,issued_by,movex_update,issued_by from $bai_rm_pj1.m3_fab_issue_track where doc_ref=\"".$cutno."\"";
				$sql_result=mysqli_query($link, $sql6) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				$no_rowsx=mysqli_num_rows($sql_result);
				if($no_rowsx > 0)
				{
					while($rows=mysqli_fetch_array($sql_result))
					{
						$picking_list=$rows["picking_list"];
						$delivery_no=$rows["delivery_no"];
						$issued_by=$rows["issued_by"];
						$movex_update=$rows["movex_update"];
						$issued_by=$rows["issued_by"];
						$section=$rows["section"];
					}
				}
				else
				{
					$section="N/A";
					$picking_list="N/A";
					$delivery_no="N/A";
					$issued_by="N/A";
					$movex_update="N/A";
					$issued_by="N/A";
				}		
				$sHTML_Content.="<td class=\"  \">".$section."</td>";
				$sHTML_Content.="<td class=\"  \">".$picking_list."</td>";
				$sHTML_Content.="<td class=\"  \">".$delivery_no."</td>";
				$sHTML_Content.="<td class=\"  \">".$issued_by."</td>";
				if($picking_list == "" or $delivery_no == "" or $picking_list == "N/A" or $delivery_no == "N/A")
				{
					$sHTML_Content.="<td class=\"  \">Not Updated</td>";
					$sHTML_Content.="<td class=\"  \">Not Updated</td>";
				}
				else
				{
					$sHTML_Content.="<td class=\"  \">Updated</td>";
					$sHTML_Content.="<td class=\"  \">Updated</td>";
				}
				$sHTML_Content.="</tr>";
				//}	
			}
			$sHTML_Content.="</table></div>";

			if($rows_num >0)
			{
				echo $sHTML_Content;
			}
			else
			{
				echo "<br><div class='alert alert-info' ><strong>Info!</strong> No Data Found</div>";
			}

	
}
?>

<script language="javascript" type="text/javascript">
	var table3Filters = {
	sort_select: true,
	display_all_text: "Display all"
	}
	// setFilterGrid("table1",table3Filters);
</script> 
</div></div>


</html>
