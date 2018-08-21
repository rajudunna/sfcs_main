<?php

//CR# 198/ kirang / 2014-11-26/ Included the new rejection details and form details in report level
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$view_access=user_acl("SFCS_0049",$username,1,$group_id_sfcs);
?>

<?php   

$reasons=array("Miss Yarn","Fabric Holes","Slub","Foreign Yarn","Stain Mark","Color Shade","Panel Un-Even","Stain Mark","Strip Match","Cut Dmg","Stain Mark","Heat Seal","M ment Out","Shape Out","Emb Defects");

//Rejection Reasons
$reasons=array("Miss Yarn","Fabric Holes","Slub","F.Yarn","Stain Mark","Color Shade","Panel Un-Even","Stain Mark","Strip Match","Cut Damage","Stain Mark","Heat Seal","M' ment Out","Shape Out","Others EMB","Heat Seal","Trim","Un Even","Shape Out Leg","Shape Out waist","With out Label","Trim shortage","Sewing Excess","Cut Holes","Slip Stitch’s","Oil Marks","Foil Defects","Embroidery","Print","Sequence","Bead","Dye","wash");

$categories=array("Fabric","Fabric","Fabric","Fabric","Fabric","Fabric","Cutting","Cutting","Cutting","Sewing","Sewing","Sewing","Sewing","Sewing","Embellishment","Fabric","Fabric","Sewing","Sewing","Sewing","Sewing","Sewing","Sewing","Machine Damages","Machine Damages","Machine Damages","Embellishment","Embellishment","Embellishment","Embellishment","Embellishment","Embellishment","Embellishment");
	
?>

<script type="text/javascript" src="<?php echo getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R') ?>" ></script>


<div class="panel panel-primary"><div class="panel-heading">Daily Rejection Analysis</div><div class="panel-body">

<form name="input" method="post" action="?r=<?php echo $_GET['r']; ?>">
<div class="row">
	<div class='col-md-2'><label>Start Date</label><input id="demo1" class="form-control" type="text" data-toggle='datepicker' name="sdate" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"></div>
	<div class='col-md-2'><label>End Date </label><input id="demo2" type="text" data-toggle='datepicker' name="edate" class="form-control" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>"></div>
	<div class='col-md-2'>
		Team: <select name="team" class="form-control">
				<?php 
				for ($i=0; $i < sizeof($shifts_array); $i++) {?>
				<option <?php echo 'value="'.$shifts_array[$i].'"'; if($shift==$shifts_array[$i]){ echo "selected";} ?>><?php echo $shifts_array[$i] ?></option>
				<?php }
				?>
				</select>
	</div><br/>
	<div class='col-md-1'>
	<input type="submit" name="filter" value="Filter" onclick ="return verify_date()" class="btn btn-primary">
	</div>
</div>
</form>


<?php

if(isset($_POST['filter']))
{
	echo "<hr>";
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$team=$_POST['team'];
	
	$module_db=array();
	$section_db=array();
	$sql="select * from $bai_pro3.sections_db where sec_id>0";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));


	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$temp=array();
		$temp=explode(",",$sql_row['sec_mods']);
		for($i=0;$i<sizeof($temp);$i++)
		{
			$module_db[]=$temp[$i];
			$section_db[]=$sql_row['sec_id'];
		}
	}

	//Revised the Query for get the form details in query level
	$sql="select qms_tid,qms_style,qms_schedule,qms_color,substring_index(remarks,\"-\",1) as \"module\",substring_index(substring_index(remarks,\"-\",2),\"-\",-1) as \"shift\",substring_index(remarks,\"-\",-1) as \"form\",qms_size,log_date,ref1,SUBSTRING_INDEX(doc_no,'D',-1) as doc_no from $bai_pro3.bai_qms_db where qms_tran_type=3 and log_date between \"$sdate\" and \"$edate\" order by log_date,substring_index(remarks,\"-\",1)+0,substring_index(remarks,\"-\",-1),qms_style,qms_schedule,qms_color,qms_size";
	// echo $sql;

	if($team!="ALL"){
		$sql="select qms_tid,qms_style,qms_schedule,qms_color,substring_index(remarks,\"-\",1) as \"module\",substring_index(substring_index(remarks,\"-\",2),\"-\",-1) as \"shift\",substring_index(remarks,\"-\",-1) as \"form\",qms_size,log_date,ref1,SUBSTRING_INDEX(doc_no,'D',-1) as doc_no from $bai_pro3.bai_qms_db where qms_tran_type=3 and log_date between \"$sdate\" and \"$edate\" and substring_index(substring_index(remarks,\"-\",2),\"-\",-1)=\"$team\" order by log_date,substring_index(remarks,\"-\",1)+0,substring_index(remarks,\"-\",-1),qms_style,qms_schedule,qms_color,qms_size";
	}
	//echo "<br>".$sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));

	if(mysqli_num_rows($sql_result) > 0) {
		$export_excel = getFullURLLevel($_GET['r'],'export_excel.php',0,'R');
		echo '<form action="'.$export_excel.'" method ="post" >
				<input type="hidden" name="csv_text" id="csv_text">
				<div class="row">
				<input type="submit" class="btn btn-success btn-xs pull-right" id="export" style="background-color:#57b756;" value="Export to Excel" onclick="getCSVData()">
				</div>
				</form><br/>';
		echo "<div class='row'>";
		echo "<div class='table-responsive' style='max-height:600px;overflow:scroll;'><table id=\"example1\" class='table table-bordered table-striped'>";
		echo "<tr class='info'>
			<th>Date</th>
			<th>Module</th>
			<th>Section</th>
			<th>Shift</th>
			<th>Rejection Form</th>
			<th>Style</th>
			<th>Schedule</th>
			<th>Color</th>
			<th>Docket</th>
			<th>Supplier</th>
			<th>Batch</th>
			<th>Composition</th>
			<th>Size</th>
			<th>Defect<br/>Category</th>
			<th>Defect<br/>Description</th>
			<th>Qty</th>
			<th>Replaced</th>
		</tr>";
		
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$temp=array();
			$temp=explode("$",$sql_row['ref1']);
			
			$qms_tid=$sql_row['qms_tid'];
		
			$rep_qty=0;
			$sqlxx="select qms_qty from $bai_pro3.bai_qms_db where qms_tran_type=2 and ref1=\"TID-$qms_tid\"";
			// echo $sqlxx;
			$sql_resultxx=mysqli_query($link, $sqlxx) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowxx=mysqli_fetch_array($sql_resultxx))
			{
				$rep_qty=$sql_rowxx['qms_qty'];
			}		
			// echo $rep_qty;
			for($i=0;$i<sizeof($temp);$i++)
			{
				$temp2=array();
				$temp2=explode("-",$temp[$i]);
				
				//Define the rejection form a garment or panel
				//*P=Panel; *G=Garment
				$form="Panel";
				if($sql_row['form']=="G")
				{
					$form="Garment";
				}
				
				echo "<tr>";
				echo "<td>".$sql_row['log_date']."</td>";
				echo "<td>".$sql_row['module']."</td>";
				echo "<td>".$section_db[array_search($sql_row['module'],$module_db)]."</td>";
				echo "<td>".$sql_row['shift']."</td>";
				echo "<td>".$form."</td>";
				echo "<td>".$sql_row['qms_style']."</td>";
				echo "<td>".$sql_row['qms_schedule']."</td>";
				echo "<td class=\"lef\">".$sql_row['qms_color']."</td>";
				echo "<td>".$sql_row['doc_no']."</td>";
				
				$sql_doc_ref_club="SELECT DISTINCT doc_ref_club AS doc_ref FROM $bai_pro3.fabric_priorities WHERE DOC_ref=\"".$sql_row['doc_no']."\"";
				// echo $sql_doc_ref_club;
				$sql_result_doc_ref_club=mysqli_query($link, $sql_doc_ref_club) or exit("Sql Error41".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row_doc_ref_club=mysqli_fetch_array($sql_result_doc_ref_club))
				{
					$doc_ref_club=$sql_row_doc_ref_club["doc_ref"];
				}
				
				$sql_doc_ref="SELECT group_concat(doc_ref) AS doc_ref FROM $bai_pro3.fabric_priorities WHERE DOC_ref_club=\"".$doc_ref_club."\"";
				// echo $sql_doc_ref;
				$sql_result_doc_ref=mysqli_query($link, $sql_doc_ref) or exit("Sql Error42".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row_doc_ref=mysqli_fetch_array($sql_result_doc_ref))
				{
					$doc_ref=$sql_row_doc_ref["doc_ref"];
				}
				
				if($doc_ref==$sql_row['doc_no'])
				{
					$doc_ref=$sql_row['doc_no'];
				}
			
				
				$roll_ids=array();
				$roll_ids[]=-1;
				
				$sql_roll_ids="SELECT * FROM $bai_rm_pj1.fabric_cad_allocation WHERE DOC_NO in ('".$doc_ref."') ORDER BY DOC_NO";
				 //echo "<br>".$sql_roll_ids."<br>";
				$sql_result_roll_ids=mysqli_query($link, $sql_roll_ids) or exit("Sql Error43".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row_roll_ids=mysqli_fetch_array($sql_result_roll_ids))
				{
					$roll_ids[]=$sql_row_roll_ids["roll_id"];
				}			
				//echo "<BR>Size Of=".sizeof($roll_ids)."<br>";
				/*
				$sql_tid="select order_tid from bai_orders_db where order_del_no=\"".$sql_row['qms_schedule']."\" and order_col_des=\"".$sql_row['qms_color']."\"";
				$sql_result_tid=mysql_query($sql_tid,$link) or exit("Sql Error5".mysql_error());
				while($sql_row_tid=mysql_fetch_array($sql_result_tid))
				{
					$order_tid=$sql_row_tid["order_tid"];
				}
				
				$sql_col="select compo_no,fab_des from cat_stat_log where order_tid=\"".$order_tid."\" and category in (\"Body\",\"Front\") and purwidth > 0";
				$sql_result_col=mysql_query($sql_col,$link) or exit("Sql Error6".mysql_error());
				while($sql_row_col=mysql_fetch_array($sql_result_col))
				{
					$compo_no=$sql_row_col["compo_no"];
					$fab_des=$sql_row_col["fab_des"];
				}
				*/
				
				$lot_nos=array();
				$lot_nos[]=-1;
				if(sizeof($roll_ids) > 1)
				{
					$sql_lots="select distinct lot_no as lot_no from $bai_rm_pj1.store_in where tid in (".implode(",",$roll_ids).")";
					// echo "<br>".$sql_lots."<br>";
					$sql_result_lots=mysqli_query($link, $sql_lots) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row_lots=mysqli_fetch_array($sql_result_lots))
					{
						$lot_nos[]=$sql_row_lots["lot_no"];
					}
					
					$sql_lots1="select distinct lot_no as lot_no from $bai_rm_pj1.store_in_backup where tid in (".implode(",",$roll_ids).")";
					 //echo "<br>".$sql_lots."<br>";
					$sql_result_lots1=mysqli_query($link, $sql_lots1) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row_lots1=mysqli_fetch_array($sql_result_lots1))
					{
						$lot_nos[]=$sql_row_lots1["lot_no"];
					}
				}
				
				$supplier="";
				$batch="";
				$fab_des="";
				//$sql_sup="select group_concat(distinct supplier) as sup,group_concat(distinct batch_no) as batch_no from bai_rm_pj1.sticker_report where item=\"".$compo_no."\"";
				if(sizeof($lot_nos) > 1)
				{
					$sql_sup="select group_concat(distinct item_name) as item_name,group_concat(distinct supplier) as sup,group_concat(distinct batch_no) as batch_no from $bai_rm_pj1.sticker_report where lot_no in ('".implode("','",$lot_nos)."')";
					 //echo "<br>".$sql_sup."<br>";
					$sql_result_sup=mysqli_query($link, $sql_sup) or exit("$sql_sup Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row_sup=mysqli_fetch_array($sql_result_sup))
					{
						$supplier=$sql_row_sup["sup"];
						$batch=$sql_row_sup["batch_no"];
						$fab_des=$sql_row_sup["item_name"];
					}
				}
				
				//echo "<td>".$compo_no."</td>";
				echo "<td>".$supplier."</td>";
				echo "<td>".$batch."</td>";
				echo "<td>".$fab_des."</td>";
				$size_value = strtoupper($sql_row['qms_size']);
				// Due to ims_sizes function issue commented and getting size value directly from bai_qms_db table
				// $size_value=ims_sizes('',$sql_row['qms_schedule'],$sql_row['qms_style'],$sql_row['qms_color'],strtoupper($sql_row['qms_size']),$link);
				
				echo "<td>".$size_value."</td>";
				/*if($temp2[0]>=0 and $temp2[0]<=5)
				{
					$cat="Fabric";
				}
				
				if($temp2[0]>=6 and $temp2[0]<=8)
				{
					$cat="Cutting";
				}
				
				if($temp2[0]>=9 and $temp2[0]<=13)
				{
					$cat="Sewing";
				}
				
				if($temp2[0]==14)
				{
					$cat="Embellishment";
				}*/
				
				$x=$temp2[0];
				//Based on array, fetch the rejection and department category names
				echo "<td class=\"lef\">".$categories[$x]."</td>";
				echo "<td class=\"lef\">".$reasons[$x]."</td>";
				echo "<td>".$temp2[1]."</td>";
				
				//Replace Qty.
				if($rep_qty>=$temp2[1]){
					echo "<td>".$temp2[1]."</td>";
					$rep_qty-=$temp2[1];
				}else{
					if($rep_qty>0){
						echo "<td>$rep_qty</td>";
						$rep_qty=0;
					}else{
						echo "<td></td>";
					}
				}
				
				echo "</tr>";
			}
		}
		echo "</table>"; 
	}else {
		echo "<div style='color:Red' font-size:12px;><center><b><h3>! No data Found</h3></b></center></div>";
	}
	echo "</div></div>";
}

?>

<script>
function getCSVData(){
	var csv_value=$('#example1').table2CSV({delivery:'value'});
		$("#csv_text").val(csv_value);	
	}
</script>

<style>
/* #filter {
    width: 5em;  height: 3em;
}
#export {
    width: 20em;  height: 3em;
	margin-left:520px;
	
} */
</style>
</div></div>
</div>
</div>

<script >
function verify_date()
{
	var val1 = $('#demo1').val();
	var val2 = $('#demo2').val();
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
