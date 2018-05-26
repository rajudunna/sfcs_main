
<?php
//include"header.php";
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include("../".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
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

		// $filename = "FabricIssuedDetails_".$sdate.".html";

		// if(file_exists($filename)) 
		// {
		// 	echo  file_get_contents("FabricIssuedDetails_".$sdate.".html");
		// }
		// else
		// {
			$sHTML_Content="<br/><hr/><div class=\"table-responsive\"><table class=\"table table-bordered\" id=\"table1\" >
			<thead><tr class='success'>
			<th>Date</th>
			<th>Time</th>
			<th>Style</th>
			<th>Schedule</th>
			<th>Color</th>
			<th>Buyer</th>
			<th>DocketNo</th>
			<th>Mode</th>
			<th>CutNo</th>
			<th>Body/Gusset</th>
			<th>Mod No</th>
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

			//old query: $sql="SELECT DISTINCT(UPPER(cutno)) as cut FROM store_out WHERE DATE BETWEEN \"".$sdate."\" AND \"".$edate."\" AND (cutno LIKE \"D%\" OR cutno LIKE \"R%\") AND LENGTH(style)=0 ORDER BY CUTNO";
			//07-09-2016/SR#31461598 removed condition 'LENGTH(style)=0' in where clause to get the total fabric issued to details on selected dates.
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
				
				/*$sql2Z="select sum(qty_issued) as qty from store_out_backup where cutno=\"".$cutno."\"";
				$result2Z=mysql_query($sql2Z,$link) or die("Error=".mysql_error());
				while($row2Z=mysql_fetch_array($result2Z))
				{
					$qty_issued+=round($row2Z["qty"],2);
				}*/
				
				$cutno_explode=explode("$cutn",$cutno);
				
				if($cutn=="D")
				{
					//$sHTML_Content.="<td>Normal</td>";
					$table="$bai_pro3.plandoc_stat_log";
					$table1="$bai_pro3.order_cat_doc_mk_mix";
				}
				else
				{
					//$sHTML_Content.="<td>Recut</td>";
					$table=" $bai_pro3.recut_v2";
					$table1="$bai_pro3.order_cat_recut_doc_mk_mix";
				}
				
				$sql2="select order_tid,acutno,cat_ref,plan_module,plan_lot_ref from $table where doc_no=\"".$cutno_explode[1]."\"";
				//echo $sql2."<br>";
				$result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rows_count=mysqli_num_rows($result2);
				if($rows_count > 0)
				{
				while($row2=mysqli_fetch_array($result2))
				{
					$order_tid=$row2["order_tid"];
					$cut_nos=$row2["acutno"];
					$cat_id=$row2["cat_ref"];
					$module=$row2["plan_module"];
					$lot_no=$row2["plan_lot_ref"];
				}
				
				$sql2="select order_style_no,order_del_no,order_col_des,order_div,color_code from $bai_pro3.bai_orders_db_confirm where order_tid=\"".$order_tid."\"";
				$sql_result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row2=mysqli_fetch_array($sql_result2))
				{
					$style=$row2["order_style_no"];
					$schedule=$row2["order_del_no"];
					$color=$row2["order_col_des"];
					$buyer=$row2["order_div"];
					$color_code=$row2["color_code"];
				}
				
				$sql2="select * from $bai_pro3.cat_stat_log where tid=\"".$cat_id."\"";
				$sql_result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row2=mysqli_fetch_array($sql_result2))
				{
					$category=$row2["category"];
				}
				
				//old query
				//$sql5="SELECT MAX(TIME(log_stamp)) AS maxlog FROM store_out WHERE cutno=\"".$cutno_explode[1]."\"";
				
				$sql5="SELECT MAX(TIME(log_stamp)) AS maxlog FROM $bai_rm_pj1.store_out WHERE cutno=\"".$cutno."\" and date=\"".$date."\"";
				
				$sql_result5=mysqli_query($link, $sql5) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row5=mysqli_fetch_array($sql_result5))
				{
					$log_time=$row5["maxlog"];
				}
				$sHTML_Content.="<tr>";
				$sHTML_Content.="<td class=\"  \">".$date."</td>";
				$sHTML_Content.="<td class=\"  \">".$log_time."</td>";
				$sHTML_Content.="<td class=\"  \">".$style."</td>";
				$sHTML_Content.="<td class=\"  \">".$schedule."</td>";
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
				if($cut_nos >9)
				{
					$sHTML_Content.="<td class=\"  \">".chr($color_code)."0".$cut_nos."</td>";
				}
				else
				{
					$sHTML_Content.="<td class=\"  \">".chr($color_code)."00".$cut_nos."</td>";
				}
				
				$sHTML_Content.="<td class=\"  \">".$category."</td>";
				$sHTML_Content.="<td class=\"  \">".round($module,0)."</td>";
				$sqlr="select * from $table where doc_no=\"".$cutno_explode[1]."\"";
				$resultr=mysqli_query($link, $sqlr) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rowr=mysqli_fetch_array($resultr))
				{
					$total_cut_qty=($rowr["a_xs"]+$rowr["a_s"]+$rowr["a_m"]+$rowr["a_l"]+$rowr["a_xl"]+$rowr["a_xxl"]+$rowr["a_xxxl"]+$rowr["a_s01"]+$rowr["a_s02"]+$rowr["a_s03"]+$rowr["a_s04"]+$rowr["a_s05"]+$rowr["a_s06"]+$rowr["a_s07"]+$rowr["a_s08"]+$rowr["a_s09"]+$rowr["a_s10"]+$rowr["a_s11"]+$rowr["a_s12"]+$rowr["a_s13"]+$rowr["a_s14"]+$rowr["a_s15"]+$rowr["a_s16"]+$rowr["a_s17"]+$rowr["a_s18"]+$rowr["a_s19"]+$rowr["a_s20"]+$rowr["a_s21"]+$rowr["a_s22"]+$rowr["a_s23"]+$rowr["a_s24"]+$rowr["a_s25"]+$rowr["a_s26"]+$rowr["a_s27"]+$rowr["a_s28"]+$rowr["a_s29"]+$rowr["a_s30"]+$rowr["a_s31"]+$rowr["a_s32"]+$rowr["a_s33"]+$rowr["a_s34"]+$rowr["a_s35"]+$rowr["a_s36"]+$rowr["a_s37"]+$rowr["a_s38"]+$rowr["a_s39"]+$rowr["a_s40"]+$rowr["a_s41"]+$rowr["a_s42"]+$rowr["a_s43"]+$rowr["a_s44"]+$rowr["a_s45"]+$rowr["a_s46"]+$rowr["a_s47"]+$rowr["a_s48"]+$rowr["a_s49"]+$rowr["a_s50"])*($rowr["p_plies"]);
				}
				$sHTML_Content.="<td class=\"  \">".round($total_cut_qty,0)."</td>";
				$sql5="SELECT GROUP_CONCAT(DISTINCT lot_no SEPARATOR '/') AS lot_no,GROUP_CONCAT(DISTINCT trim(batch_no) SEPARATOR '/') AS batch_no,GROUP_CONCAT(ref2 SEPARATOR '/') AS roll,SUM(qty_issued) AS qty_issued FROM $bai_rm_pj1.sticker_ref WHERE tid IN($tids)";
				//echo $sql5."<br>";
				$result5=mysqli_query($link, $sql5) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				$no_rows5=mysqli_num_rows($result5);
				while($row5=mysqli_fetch_array($result5))
				{
					$lot_no=$row5["lot_no"];
					$batch_no=$row5["batch_no"];
					$roll_no=$row5["roll"];
					//$qty_issued=$row5["qty_issued"];	
				}
				
				$sHTML_Content.="<td class=\"  \">".$lot_no."</td>";
				$sHTML_Content.="<td class=\"  \">".$batch_no."</td>";
				$sHTML_Content.="<td class=\"  \">".$roll_no."</td>";
				$sql6="SELECT material_req as req FROM $table1 WHERE doc_no=\"".$cutno_explode[1]."\" and acutno=$cut_nos";
				$result6=mysqli_query($link, $sql6) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				$no_rows6=mysqli_num_rows($result6);
				while($row6=mysqli_fetch_array($result6))
				{
					$req_qty=round($row6["req"],3);
				}	
				$sHTML_Content.="<td class=\"  \">".$req_qty."</td>";
				$sHTML_Content.="<td class=\"  \">".$qty_issued."</td>";
				//old query
				//$sql6="select section,picking_list,delivery_no,issued_by,movex_update,issued_by from $database.m3_fab_issue_track where doc_ref=\"".$cutno_explode[1]."\"";
				
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
				}	
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
