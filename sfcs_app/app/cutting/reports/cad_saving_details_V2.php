<?php
include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include('../'.getFullURLLevel($_GET['r'],'/common/config/user_acl_v1.php',3,'R'));
//$group_id_sfcs=$group_id_sfcs_sfcs; 
// $view_access=user_acl("SFCS_0002",$username,1,$group_id_sfcs);
?>

<title>CAD Saving Details</title>

<script>

function firstbox()
{
	window.location.href ="cad_saving_details.php?schedule="+document.test.schedule.value
}

function secondbox()
{
	window.location.href ="cad_saving_details.php?schedule="+document.test.schedule.value+"&color="+document.test.color.value
}

function thirdbox()
{
	window.location.href ="cad_saving_details.php?schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&category="+document.test.category.value
	document.testx.submit();
}
function verify_date(){
	var from_date = $('#sdate').val();
	var to_date =  $('#edate').val();
	if(to_date < from_date){
		//sweetAlert('End Date must not be less than Start Date','','warning');
	}
}

</script>

<script language="javascript" type="text/javascript" src="<?php echo getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R') ?>"></script>
<style type="text/css" media="screen">

//@import "TableFilter_EN/filtergrid.css";

//th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
//td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
  td{ color : #000; }
  th{ color : #000; }
  label{color : #000;}
  #reset_table1{ color : red;font-weight:bold;width : 60px;}

</style>
<link href="style_new.css" rel="stylesheet" type="text/css" />
<SCRIPT LANGUAGE="Javascript" SRC="../../fusion_charts/FusionCharts/FusionCharts.js"></SCRIPT>
<script type="text/javascript" src="datetimepicker_css.js"></script>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/master/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>


<script>

	function verify_date(){
		var val1 = $('#sdate').val();
		var val2 = $('#edate').val();
	
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


<div class="panel panel-primary">
	<div class="panel-heading">
		<span style="float"><b>CAD Saving Details - Exfactory Date</b></span>
	</div>
	<div class="panel-body">
		<form id="testx" name="test" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
			<div class="col-sm-3 form-group">
				<label for="sdat"><b>Start Date</b></label>
				<input  class="form-control " type="text" id="sdate" name="sdat" data-toggle="datepicker" size=8  value="<?php  if(isset($_POST['sdat'])) { echo $_POST['sdat']; } else { echo date("Y-m-d"); } ?>"/></td>
			</div>
			<div  class="col-sm-3 form-group">
				<label for="edat">End Date</label>
				<input  class="form-control " type="text" id="edate" name="edat" data-toggle="datepicker" size=8 onchange="return verify_date();" value="<?php  if(isset($_POST['edat'])) { echo $_POST['edat']; } else { echo date("Y-m-d"); } ?>"/></td>
			</div>
			  <?php
			$sql="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";

			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$buyer_code[]=$sql_row["buyer_div"];
				$buyer_name[]=$sql_row["buyer_name"];
			}

			  
			  ?>
			<div class="col-sm-3 form-group">
			<label>Buyer Division: </label>
		<select name="division" class="form-control">

			<option value='All' <?php if($_POST['division']=="All"){ echo "selected"; } ?> >All</option>
		<?php
			for($i=0;$i<sizeof($buyer_name);$i++)
			{
				if($buyer_name[$i]==$_POST['division']) 
				{ 
					echo "<option value=\"".($buyer_name[$i])."\" selected>".$buyer_code[$i]."</option>";	
				}
				else
				{
					echo "<option value=\"".($buyer_name[$i])."\"  >".$buyer_code[$i]."</option>";			
				}
			}
		?>
		</select>
		</div>
		<div class="col-sm-1">
			<br>
			<input class="btn btn-success" type="submit" name="submit" value="Filter" onclick="return verify_date();"/>
		</div>
		</form>
		<hr>



<?php
if(isset($_POST["submit"]))
{
	
	echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing report...</font></h1></center></div>";
	
	ob_end_flush();
	flush();
	usleep(10);
	
	
	$division=$_POST['division'];
	$sdat=$_POST["sdat"];
	$edat=$_POST["edat"];
	$aod_nos=array();
	$sql_dat="select disp_note_no as disp from $bai_pro3.disp_db where create_date between \"$sdat\" and \"$edat\"";
	$result_dat=mysqli_query($link, $sql_dat) or exit("Sql Error1".$sql_dat.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row_dat=mysqli_fetch_array($result_dat))
	{
		$aod_nos[]=$row_dat["disp"];
	}

	$query="where schedule_no > 0 and ex_factory_date_new between \"".trim($sdat)."\" and  \"".trim($edat)."\" order by left(style,1)";
	if($division!="All")
	{
		$buyer_division=urldecode($_POST["division"]);
		$buyer_division_ref='"'.str_replace(",",'","',$buyer_division).'"';
		$query="where schedule_no > 0 and buyer_division in (".$buyer_division_ref.") and ex_factory_date_new between \"".trim($sdat)."\" and  \"".trim($edat)."\" order by left(style,1)";
	}

	$sch_nos=array();
	//$sql_sch="select distinct ship_schedule as sch from bai_pro3.ship_stat_log where disp_note_no in (".implode(",",$aod_nos).")";
	//$sql_sch="select distinct schedule_no as sch from bai_pro4.shipment_plan_ref where ex_factory_date between \"$sdat\" and \"$edat\"";
	$sql_sch="select distinct schedule_no as sch from $bai_pro4.week_delivery_plan_ref $query";
	// echo $sql_sch."<br>";
	$result_sch=mysqli_query($link, $sql_sch) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row_sch=mysqli_fetch_array($result_sch))
	{
		$sch_nos[]=$row_sch["sch"];
	}

	if(sizeof($sch_nos) > 0)
	{
		echo "
		<div class='col-sm-12' style='overflow-x:scroll;max-height:600px;overflow-y:scroll'>
		<table id='table1' class='table table-bordered table-responsive'>
			<tr class='danger'>
				<th>Buyer</th>
				<th>Style</th>
				<th>Schedule</th>
				<th>LID</th>
				<th>Category</th>
				<th>Purchase Width</th>
				<th>Garment Way</th>
				<th>Item Code</th>
				<th>Color</th>
				<th>PSD Date</th>
				<th>Ex-Factory</th>
				<th>Order Qty</th>
				<th>Cut Qty</th>
				<th>Cut Completed Qty</th>
				<th>Total Cut No</th>
				<th>Completed Cut No</th>
				<th>Order YY</th>
				<th>CAD YY</th>
				<th>CAD Saving</th>
				<th>CAD Saving Yards</th>
				<th>Utilization(CAD YY)</th>
				<th>Fabric Allocated</th>
				<th>Fabric Issued Docket</th>
				<th>Fabric Issued MRN</th>
				<th>Fabric Issued Total</th>
				<th>Difference</th>
				<th>Deaviation%</th>
				<th>Damages</th>
				<th>Shortages</th>
				<th>Fabric Balance to Issue</th>
				<th>Fabric Balance Requirement</th>
				<th>AOD Status</th>
			</tr>";
		$sql3="select order_del_no as sch,order_col_des as col from $bai_pro3.bai_orders_db where order_del_no in (".implode(",",$sch_nos).")";
		// echo $sql3."<br>";
		$result3=mysqli_query($link, $sql3) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row3=mysqli_fetch_array($result3))
		{
			$schedule=$row3["sch"];
			$color=$row3["col"];
			$sql4="select category from $bai_pro3.cat_stat_log where order_tid like \"%$schedule$color%\" and category!=\"\"";
			// echo $sql4."<br>";
			$result4=mysqli_query($link, $sql4) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row4=mysqli_fetch_array($result4))
			{
				$category=$row4["category"];
				$cut_comp_iss_qty=0;
				$cut_comp_qty=0;
				$order_total_qty=0;
				$old_order_total=0;
				$cut_total_qty=0;
				$issued_qty=0;
				$recut_issued_qty=0;
				$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
				// echo $sql."<br>";
				$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result))
				{
					$style=$row["order_style_no"];
					$order_total_qty=$row["order_s_xs"]+$row["order_s_s"]+$row["order_s_m"]+$row["order_s_l"]+$row["order_s_xl"]+$row["order_s_xxl"]+$row["order_s_xxxl"]+$row["order_s_s01"]+$row["order_s_s02"]+$row["order_s_s03"]+$row["order_s_s04"]+$row["order_s_s05"]+$row["order_s_s06"]+$row["order_s_s07"]+$row["order_s_s08"]+$row["order_s_s09"]+$row["order_s_s10"]+$row["order_s_s11"]+$row["order_s_s12"]+$row["order_s_s13"]+$row["order_s_s14"]+$row["order_s_s15"]+$row["order_s_s16"]+$row["order_s_s17"]+$row["order_s_s18"]+$row["order_s_s19"]+$row["order_s_s20"]+$row["order_s_s21"]+$row["order_s_s22"]+$row["order_s_s23"]+$row["order_s_s24"]+$row["order_s_s25"]+$row["order_s_s26"]+$row["order_s_s27"]+$row["order_s_s28"]+$row["order_s_s29"]+$row["order_s_s30"]+$row["order_s_s31"]+$row["order_s_s32"]+$row["order_s_s33"]+$row["order_s_s34"]+$row["order_s_s35"]+$row["order_s_s36"]+$row["order_s_s37"]+$row["order_s_s38"]+$row["order_s_s39"]+$row["order_s_s40"]+$row["order_s_s41"]+$row["order_s_s42"]+$row["order_s_s43"]+$row["order_s_s44"]+$row["order_s_s45"]+$row["order_s_s46"]+$row["order_s_s47"]+$row["order_s_s48"]+$row["order_s_s49"]+$row["order_s_s50"];
						$old_order_total=$row["old_order_s_xs"]+$row["old_order_s_s"]+$row["old_order_s_m"]+$row["old_order_s_l"]+$row["old_order_s_xl"]+$row["old_order_s_xxl"]+$row["old_order_s_xxxl"]+$row["old_order_s_s01"]+$row["old_order_s_s02"]+$row["old_order_s_s03"]+$row["old_order_s_s04"]+$row["old_order_s_s05"]+$row["old_order_s_s06"]+$row["old_order_s_s07"]+$row["old_order_s_s08"]+$row["old_order_s_s09"]+$row["old_order_s_s10"]+$row["old_order_s_s11"]+$row["old_order_s_s12"]+$row["old_order_s_s13"]+$row["old_order_s_s14"]+$row["old_order_s_s15"]+$row["old_order_s_s16"]+$row["old_order_s_s17"]+$row["old_order_s_s18"]+$row["old_order_s_s19"]+$row["old_order_s_s20"]+$row["old_order_s_s21"]+$row["old_order_s_s22"]+$row["old_order_s_s23"]+$row["old_order_s_s24"]+$row["old_order_s_s25"]+$row["old_order_s_s26"]+$row["old_order_s_s27"]+$row["old_order_s_s28"]+$row["old_order_s_s29"]+$row["old_order_s_s30"]+$row["old_order_s_s31"]+$row["old_order_s_s32"]+$row["old_order_s_s33"]+$row["old_order_s_s34"]+$row["old_order_s_s35"]+$row["old_order_s_s36"]+$row["old_order_s_s37"]+$row["old_order_s_s38"]+$row["old_order_s_s39"]+$row["old_order_s_s40"]+$row["old_order_s_s41"]+$row["old_order_s_s42"]+$row["old_order_s_s43"]+$row["old_order_s_s44"]+$row["old_order_s_s45"]+$row["old_order_s_s46"]+$row["old_order_s_s47"]+$row["old_order_s_s48"]+$row["old_order_s_s49"]+$row["old_order_s_s50"];
					$order_tid=$row["order_tid"];
					$order_no=$row["order_no"];
					$buyer=$row["order_div"];
				}
				$docketnos = array();
				$docketno = array();
				$recut_docketnos=array();
				$recut_docketno=array();
				if($old_order_total == 0)
				{
					$old_order_total=$order_total_qty;
				}
				$sql="select * from $bai_pro3.cat_stat_log where order_tid like \"% $schedule$color%\" and category=\"$category\"";
				$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result))
				{
					$compo_no=$row["compo_no"];
					$cat_ref=$row["tid"];
					$order_yy=$row["catyy"];
					$gmtway=$row["gmtway"];
					$purchase_width=$row["purwidth"];
				}

				if($gmtway=="Y")
				{
					$gmt_type="OGO";
				}
				else
				{
					$gmt_type="AGO";
				}

				/*$sql="select * from bai_pro3.cuttable_stat_log where order_tid like \"% $schedule$color%\" and cat_id=\"$cat_ref\"";
				//echo $sql;
				$result=mysql_query($sql,$link) or exit("Sql Error1".mysql_error());
				while($row=mysql_fetch_array($result))
				{
					$cut_total_qty=$row["cuttable_s_xs"]+$row["cuttable_s_s"]+$row["cuttable_s_m"]+$row["cuttable_s_l"]+$row["cuttable_s_xl"]+$row["cuttable_s_xxl"]+$row["cuttable_s_xxxl"]+$row["cuttable_s_s06"]+$row["cuttable_s_s08"]+$row["cuttable_s_s10"]+$row["cuttable_s_s12"]+$row["cuttable_s_s14"]+$row["cuttable_s_s16"]+$row["cuttable_s_s18"]+$row["cuttable_s_s20"]+$row["cuttable_s_s22"]+$row["cuttable_s_s24"]+$row["cuttable_s_s26"]+$row["cuttable_s_s28"]+$row["cuttable_s_s30"];
				}*/

				$sql="SELECT SUM(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies AS doc_qty,doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid like \"% $schedule$color%\" and cat_ref=\"$cat_ref\" GROUP BY doc_no";
				////echo $sql."<br>";
				$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result))
				{
					$cut_total_qty=$cut_total_qty+$row["doc_qty"];
				}


				$sql="SELECT SUM(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies AS doc_qty,doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid like \"% $schedule$color%\" and cat_ref=\"$cat_ref\" and fabric_status=\"5\" GROUP BY doc_no";
				////echo $sql."<br>";
				$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result))
				{
					$cut_comp_qty=$cut_comp_qty+$row["doc_qty"];
				}


				$sql="SELECT SUM(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies AS doc_qty,doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid like \"% $schedule$color%\" and cat_ref=\"$cat_ref\" and act_cut_status=\"DONE\" GROUP BY doc_no";
				$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result))
				{
					$cut_comp_iss_qty=$cut_comp_iss_qty+$row["doc_qty"];
				}

				$sql="select * from $bai_pro3.plandoc_stat_log where order_tid like \"% $schedule$color%\" and cat_ref=\"$cat_ref\"";
				$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$ratios_no_count=mysqli_num_rows($result);
				$docketnos[]=-1;
				$docketno[]=-1;
				$sql="select * from $bai_pro3.plandoc_stat_log where order_tid like \"% $schedule$color%\" and cat_ref=\"$cat_ref\" and fabric_status=\"5\"";
				$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$cut_no_count=mysqli_num_rows($result);
				while($row=mysqli_fetch_array($result))
				{
					$docketnos[]="\"D".$row["doc_no"]."\"";
					$docketno[]=$row["doc_no"];
				}

				$recut_docketnos[]=-1;
				$recut_docketno[]=-1;
				$sql="select * from $bai_pro3.recut_v2 where order_tid like \"% $schedule$color%\" and cat_ref=\"$cat_ref\"";
				$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				//$cut_no_count=mysql_num_rows($result);
				while($row=mysqli_fetch_array($result))
				{
					$recut_docketnos[]="\"R".$row["doc_no"]."\"";
					$recut_docketno[]=$row["doc_no"];
				}
				//echo implode(",",$docketnos);
				$sql="select max(ex_factory_date_new) as dat,max(ship_tid) as tid from $bai_pro4.week_delivery_plan_ref where schedule_no=$schedule and color=\"".$color."\" and ex_factory_date_new between \"".trim($sdat)."\" and  \"".trim($edat)."\"";
				//echo $sql."<br>";
				//$sql="select ex_factory_date,ship_tid from bai_pro4.shipment_plan where schedule_no=$schedule and color=\"".$color."\"";
				$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result))
				{
					$ship_tid=$row["tid"];
					$ex_factory_date_new=$row["dat"];
				}

				$newyy=0;
				$new_order_qty=0;
				$sql2="select mk_ref,p_plies,cat_ref,allocate_ref from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=\"$cat_ref\" and allocate_ref>0"; 
				// mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{	
					$new_plies=$sql_row2['p_plies'];
					$mk_ref=$sql_row2['mk_ref'];
					$sql22="select mklength from $bai_pro3.maker_stat_log where tid=$mk_ref";
					// mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row22=mysqli_fetch_array($sql_result22))
					{
						$mk_new_length=$sql_row22['mklength'];
					}
					$newyy=$newyy+($mk_new_length*$new_plies);
				}

				$cad_yy=0;

				if($order_no==1)
				{
					if($old_order_total > 0)
					{
						$cad_yy=$newyy/$old_order_total;
					}	
				}
				else
				{
					if($order_total_qty > 0)
					{
						$cad_yy=$newyy/$order_total_qty;
					}	
				}

				$sql="SELECT plan_start_date FROM $bai_pro4.week_delivery_plan WHERE shipment_plan_id='$ship_tid'";
				$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result))
				{
					$plan_start_date=$row["plan_start_date"];
				}

				$savings_new=0;
				if($order_yy > 0)
				{
					$savings_new=round((($order_yy-$cad_yy)/$order_yy)*100,1);
				}

				//echo "<td>".."</td>";

				$sql="select sum(qty_issued) as qty from $bai_rm_pj1.store_out where cutno in (".implode(",",$docketnos).")";
				////echo $sql."<br>";
				$result=mysqli_query($link, $sql) or exit("Sql Error178".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result))
				{
					$issued_qty=$row["qty"];
				}

				$sql="select sum(qty_issued) as qty from $bai_rm_pj1.store_out where cutno in (".implode(",",$recut_docketnos).")";
				////echo $sql."<br>";
				$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result))
				{
					$recut_issued_qty=$row["qty"];
				}

				$sql="select sum(issued_qty) as qty from $bai_rm_pj2.mrn_track where schedule=$schedule and color like \"%".$color."%\" and product=\"FAB\"";
				////echo $sql;
				$result=mysqli_query($link, $sql) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result))
				{
					$mrn_issued_qty=$row["qty"];
				}

				$damages_qty=0;
				$shortages_qty=0;
				$sql="select sum(damages) as dam,sum(shortages) as shrt from $bai_pro3.act_cut_status where doc_no in (".implode(",",$docketno).")";
				$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result))
				{
					$damages_qty=$row["dam"];
					$shortages_qty=$row["shrt"];
				}
				$recut_damages_qty=0;
				$recut_shortages_qty=0;
				$sql="select sum(damages) as dam,sum(shortages) as shrt from $bai_pro3.act_cut_status_recut_v2 where doc_no in (".implode(",",$recut_docketno).")";
				$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result))
				{
					$recut_damages_qty=$row["dam"];
					$recut_shortages_qty=$row["shrt"];
				}

				$sql4="SELECT SUM(ship_s_xs)+SUM(ship_s_s)+SUM(ship_s_m)+SUM(ship_s_l)+SUM(ship_s_xl)+SUM(ship_s_xxxl)+SUM(ship_s_s01)+SUM(ship_s_s02)+SUM(ship_s_s03)+SUM(ship_s_s04)+SUM(ship_s_s05)+SUM(ship_s_s06)+SUM(ship_s_s07)+SUM(ship_s_s08)+SUM(ship_s_s09)+SUM(ship_s_s10)+SUM(ship_s_s11)+SUM(ship_s_s12)+SUM(ship_s_s13)+SUM(ship_s_s14)+SUM(ship_s_s15)+SUM(ship_s_s16)+SUM(ship_s_s17)+SUM(ship_s_s18)+SUM(ship_s_s19)+SUM(ship_s_s20)+SUM(ship_s_s21)+SUM(ship_s_s22)+SUM(ship_s_s23)+SUM(ship_s_s24)+SUM(ship_s_s25)+SUM(ship_s_s26)+SUM(ship_s_s27)+SUM(ship_s_s28)+SUM(ship_s_s29)+SUM(ship_s_s30)+SUM(ship_s_s31)+SUM(ship_s_s32)+SUM(ship_s_s33)+SUM(ship_s_s34)+SUM(ship_s_s35)+SUM(ship_s_s36)+SUM(ship_s_s37)+SUM(ship_s_s38)+SUM(ship_s_s39)+SUM(ship_s_s40)+SUM(ship_s_s41)+SUM(ship_s_s42)+SUM(ship_s_s43)+SUM(ship_s_s44)+SUM(ship_s_s45)+SUM(ship_s_s46)+SUM(ship_s_s47)+SUM(ship_s_s48)+SUM(ship_s_s49)+SUM(ship_s_s50) as ship_qty FROM $bai_pro3.ship_stat_log WHERE ship_schedule=\"$schedule\" and ship_status=\"2\"";
				////echo $sql4;
				$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$total_rows=mysqli_num_rows($sql_result4);
				while($sql_row4=mysqli_fetch_array($sql_result4))
				{
					$shiped_total_qty=$sql_row4["ship_qty"];
				}
				$ship_status="";
				if($total_rows > 0)
				{
					if($old_order_total < $shiped_total_qty)
					{
						$ship_status="Extra Ship";
					}
					else if($old_order_total == $shiped_total_qty)
					{
						$ship_status="Order Ship";
					}
					else if($shiped_total_qty == 0)
					{
						$ship_status="Yet to Ship";
					}
					else
					{
						$ship_status="Short Ship";
					}
				}	
				echo "<tr>";
				echo "<td>".$buyer."</td>";
				echo "<td>".$style."</td>";
				echo "<td>".$schedule."</td>";
				echo "<td>".$cat_ref."</td>";
				echo "<td>".$category."</td>";
				echo "<td>".$purchase_width."</td>";
				echo "<td>".$gmt_type."</td>";
				echo "<td>".$compo_no."</td>";
				echo "<td>".$color."</td>";
				echo "<td>".$plan_start_date."</td>";
				echo "<td>".$ex_factory_date_new."</td>";
				echo "<td>".$old_order_total."</td>";
				echo "<td>".$cut_total_qty."</td>";
				echo "<td>".$cut_comp_iss_qty."</td>";
				echo "<td>".$ratios_no_count."</td>";
				echo "<td>".$cut_no_count."</td>";
				echo "<td>".$order_yy."</td>";
				echo "<td>".round($cad_yy,4)."</td>";
				echo "<td>".$savings_new."%</td>";
				//echo "<td>".ROUND((($order_yy-$cad_yy)*$old_order_total*99),0)."</td>";
				echo "<td>".round((($old_order_total*$order_yy)-(round($cad_yy,4)*$old_order_total)),2)."</td>";
				$cayy_utilization=round(round($cad_yy,4)*$cut_comp_iss_qty,2);
				echo "<td>".round(round($cad_yy,4)*$cut_comp_iss_qty,2)."</td>";
				echo "<td>".round(($order_yy*$old_order_total),2)."</td>";
				echo "<td>".round($issued_qty,2)."</td>";
				echo "<td>".round($recut_issued_qty+$mrn_issued_qty,2)."</td>";
				//$issued_qty=round($issued_qty+$recut_issued_qty+$mrn_issued_qty,2);
				echo "<td>".round($issued_qty+$recut_issued_qty+$mrn_issued_qty,2)."</td>";
				$difference=round((round($issued_qty+$recut_issued_qty+$mrn_issued_qty,2)-round(round($cad_yy,4)*$cut_comp_iss_qty,2)),2);
				echo "<td>".round((round($issued_qty+$recut_issued_qty+$mrn_issued_qty,2)-round(round($cad_yy,4)*$cut_comp_iss_qty,2)),2)."</td>"; 
				if(round($issued_qty+$recut_issued_qty+$mrn_issued_qty,2) > 0)
				{
					echo "<td>".round(((round($issued_qty+$recut_issued_qty+$mrn_issued_qty,2)-round(round($cad_yy,4)*$cut_comp_iss_qty,2))*100/round($issued_qty+$recut_issued_qty+$mrn_issued_qty,2)),0)."%</td>"; 
				}else{
					echo "<td>0%</td>";
				}
				echo "<td>".round($damages_qty+$recut_damages_qty,0)."</td>";
				echo "<td>".round($shortages_qty+$recut_shortages_qty,0)."</td>";
				echo "<td>".(round(($order_yy*$old_order_total),0)-round($issued_qty+$recut_issued_qty+$mrn_issued_qty,0))."</td>";
				echo "<td>".round((($cut_total_qty-$cut_comp_qty)*round($cad_yy,4)),0)."</td>";
				echo "<td>".$ship_status."</td>";
				echo "</tr>";
				$mrn_issued_qty=0;
				$recut_docketno="";
				$recut_docketnos="";
				$docketno="";
				$docketnos="";
			}
		}
	}else{
		echo "<div class='alert alert-danger'><b>No Data Found</b></div>";
	}

	echo "</table>
	</div>";
}
?>
</div><!-- panel body -->
</div><!-- panel -->
</div>
<script language="javascript" type="text/javascript">
	var table3Filters = {
	col_0: "select",
	col_7: "select",
	sort_select: true,
	display_all_text: "Display all",
	loader: true,
	loader_text: "Filtering data...",
	sort_select: true,
	exact_match: true,
	rows_counter: true,
	btn_reset: true
	}
	setFilterGrid("table1",table3Filters);
</script>

<script>
	document.getElementById("msg").style.display="none";		
</script>
