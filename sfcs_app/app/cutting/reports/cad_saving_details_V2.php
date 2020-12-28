<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R'));
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];
?>

<title>CAD Saving Details</title>

<script>

function firstbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value;
}

function secondbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value;
	
}
function thirdbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value;
}

function fourthbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value;
}

function fifthbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value;
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
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',3,'R') ?>"></script>
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

$('#sub').on('click',function(e){
        style = $('#style').val();
        schedule = $('#schedule').val();
        color = $('#color').val();
        mpo = $('#mpo').val();
        if(style === 'NIL' && schedule === 'NIL' && color === 'NIL' && mpo === 'NIL'){
            sweetAlert('Please Select Style, Schedule, Color and mpo','','warning');
        }
        else if(style === 'NIL' && schedule === 'NIL'){
            sweetAlert('Please Select Style and Schedule','','warning');
        }
        else if(schedule === 'NIL' && mpo === 'NIL'){
            sweetAlert('Please Select Schedule and mpo','','warning');
        }
        else if(style === 'NIL' && mpo === 'NIL'){
            sweetAlert('Please Select Style and mpo','','warning');
        }
        else if(style === 'NIL'){
            sweetAlert('Please Select Style','','warning');
        }
        else if(schedule === 'NIL'){
            sweetAlert('Please Select Schedule','','warning');
        }
        else if(color === 'NIL'){
            e.preventDefault();
            sweetAlert('Please Select Color','','warning');
        }
        else if(mpo === 'NIL'){
            e.preventDefault();
            sweetAlert('Please Select mpo','','warning');
        }
    });
});
</script>
<?php
$get_style=$_GET['style']; 
$get_schedule=$_GET['schedule'];  
$get_color=$_GET['color']; 
$get_mpo=$_GET['mpo']; 
$get_sub_po=$_GET['sub_po']; 

?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<span style="float"><b>CAD Saving Details - Exfactory Date</b></span>
	</div>
	<div class="panel-body">
		<form name="test" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
		<?php
               /*function to get style from getdata_mp_color_detail
                @params : $plantcode
                @returns: $style
                */

                if($plant_code!=''){
                    $result_mp_color_details=getMpColorDetail($plant_code);
                    $style=$result_mp_color_details['style'];
                }
                echo "<div class='col-sm-2'><label>Select Style: </label><select style='min-width:100%' name=\"style\" onchange=\"firstbox();\" class='form-control' required>"; 
                echo "<option value=\"\" selected>NIL</option>";
                foreach ($style as $style_value) {
                    if(str_replace(" ","",$style_value)==str_replace(" ","",$get_style)) 
                    { 
                        echo '<option value=\''.$style_value.'\' selected>'.$style_value.'</option>'; 
                    } 
                    else 
                    { 
                        echo '<option value=\''.$style_value.'\'>'.$style_value.'</option>'; 
                    }
                } 
                echo "</select></div>";

            ?>
            <?php
                /*function to get schedule from getdata_bulk_schedules
                @params : plantcode,style
                @returns: schedule
                */
                    if($get_style!=''&& $plant_code!=''){
                        $result_bulk_schedules=getBulkSchedules($get_style,$plant_code);
                        $bulk_schedule=$result_bulk_schedules['bulk_schedule'];
                    }  
                    echo "<div class='col-sm-2'><label>Select Schedule: </label><select style='min-width:100%' name=\"schedule\" onchange=\"secondbox();\" class='form-control' required>";  
                    echo "<option value=\"\" selected>NIL</option>";
                    foreach ($bulk_schedule as $bulk_schedule_value) {
                        if(str_replace(" ","",$bulk_schedule_value)==str_replace(" ","",$get_schedule)) 
                        { 
                            echo '<option value=\''.$bulk_schedule_value.'\' selected>'.$bulk_schedule_value.'</option>'; 
                        } 
                        else 
                        { 
                            echo '<option value=\''.$bulk_schedule_value.'\'>'.$bulk_schedule_value.'</option>'; 
                        }
                    } 
                    echo "</select></div>";
            ?>

            <?php
                /*function to get color from get_bulk_colors
                @params : plantcode,schedule
                @returns: color
                */
                if($get_schedule!='' && $plant_code!=''){
                        $result_bulk_colors=getBulkColors($get_schedule,$plant_code);
                        $bulk_color=$result_bulk_colors['color_bulk'];
                    }
                    echo "<div class='col-sm-2'><label>Select Color: </label>";  
                    echo "<select style='min-width:100%' name=\"color\" onchange=\"thirdbox();\" class='form-control' >
                            <option value=\"NIL\" selected>NIL</option>";
                                foreach ($bulk_color as $bulk_color_value) {
                                    if(str_replace(" ","",$bulk_color_value)==str_replace(" ","",$get_color)) 
                                    { 
                                        echo '<option value=\''.$bulk_color_value.'\' selected>'.$bulk_color_value.'</option>'; 
                                    } 
                                    else 
                                    { 
                                        echo '<option value=\''.$bulk_color_value.'\'>'.$bulk_color_value.'</option>'; 
                                    }
                                } 
					echo "</select></div>";
			?>

            <?php
                /*function to get mpo from getdata_MPOs
                @params : plantcode,schedule,color
                @returns: mpo
                */
                if($get_schedule!='' && $get_color!='' && $plant_code!=''){
                    $result_bulk_MPO=getMpos($get_schedule,$get_color,$plant_code);
                    $master_po_description=$result_bulk_MPO['master_po_description'];
                }
                echo "<div class='col-sm-2'><label>Select Master PO: </label>";  
                echo "<select style='min-width:100%' name=\"mpo\" onchange=\"fourthbox();\" class='form-control' >
                        <option value=\"NIL\" selected>NIL</option>";
                            foreach ($master_po_description as $key=>$master_po_description_val) {
                                if(str_replace(" ","",$master_po_description_val)==str_replace(" ","",$get_mpo)) 
                                { 
                                    echo '<option value=\''.$master_po_description_val.'\' selected>'.$key.'</option>'; 
                                } 
                                else 
                                { 
                                    echo '<option value=\''.$master_po_description_val.'\'>'.$key.'</option>'; 
                                }
                            } 
                echo "</select></div>";
            ?>
			<?php
				/*function to get subpo from getdata_bulk_subPO
				@params : plantcode,mpo
				@returns: subpo
				*/
				if($get_mpo!='' && $plant_code!=''){
					$result_bulk_subPO=getBulkSubPo($get_mpo,$plant_code);
					$sub_po_description=$result_bulk_subPO['sub_po_description'];
				}
				echo "<div class='col-sm-2'><label>Select Sub PO: </label>";  
				echo "<select style='min-width:100%' name=\"sub_po\" onchange=\"fifthbox();\" class='form-control' >
						<option value=\"NIL\" selected>NIL</option>";
							foreach ($sub_po_description as $key=>$sub_po_description_val) {
								if(str_replace(" ","",$sub_po_description_val)==str_replace(" ","",$get_sub_po)) 
								{ 
									echo '<option value=\''.$sub_po_description_val.'\' selected>'.$key.'</option>'; 
								} 
								else 
								{ 
									echo '<option value=\''.$sub_po_description_val.'\'>'.$key.'</option>'; 
								}
							} 
				echo "</select></div>";
			?>
			<div class="col-sm-2 form-group">
				<label for="sdat"><b>Start Date</b></label>
				<input  class="form-control " type="text" id="sdate" name="sdat" data-toggle="datepicker" size=8  value="<?php  if(isset($_POST['sdat'])) { echo $_POST['sdat']; } else { echo date("Y-m-d"); } ?>"/></td>
			</div>
			<div  class="col-sm-2 form-group">
				<label for="edat">End Date</label>
				<input  class="form-control " type="text" id="edate" name="edat" data-toggle="datepicker" size=8 onchange="return verify_date();" value="<?php  if(isset($_POST['edat'])) { echo $_POST['edat']; } else { echo date("Y-m-d"); } ?>"/></td>
			</div>
			  <?php
			$sql="SELECT buyer_desc FROM $oms.oms_mo_details WHERE schedule='$get_schedule' AND plant_code='$plant_code'";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$buyer_desc[]=$sql_row["buyer_desc"];
			}

			  
			  ?>
			<div class="col-sm-2 form-group">
			<label>Buyer Division: </label>
		<select name="division" class="form-control">

			<option value='All' <?php if($_POST['division']=="All"){ echo "selected"; } ?> >All</option>
		<?php
			for($i=0;$i<sizeof($buyer_desc);$i++)
			{
				if($buyer_desc[$i]==$_POST['division']) 
				{ 
					echo "<option value=\"".($buyer_desc[$i])."\" selected>".$buyer_desc[$i]."</option>";	
				}
				else
				{
					echo "<option value=\"".($buyer_desc[$i])."\"  >".$buyer_desc[$i]."</option>";			
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
	
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$mpo=$_POST['mpo'];
	$sub_po=$_POST['sub_po'];
	$division=$_POST['division'];
	$sdat=$_POST["sdat"];
	$edat=$_POST["edat"];
	$aod_nos=array();

	if($division!="All")
	{
		$buyer_division=urldecode($_POST["division"]);
		$buyer_division_ref='"'.str_replace(",",'","',$buyer_division).'"';
		$sql_sch="SELECT * FROM $pps.shipment_plan WHERE style='$style' AND schedule='$schedule' AND color='$color' AND buyer_division in (".$buyer_division_ref.") AND ex_factory_date_new between \"".trim($sdat)."\" and  \"".trim($edat)."\" AND plant_code='$plant_code'";
	} else 
	{
		$sql_sch="SELECT * FROM $pps.shipment_plan WHERE style='$style' AND schedule_no='$schedule' AND color='$color' AND ex_factory_date between \"".trim($sdat)."\" and  \"".trim($edat)."\" AND plant_code='$plant_code'";
	}
	$result_sch=mysqli_query($link, $sql_sch) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
	$result_num=mysqli_num_rows($result_sch);

	if($result_num > 0)
	{
		echo "
		<div class='col-sm-12' style='overflow-x:scroll;max-height:600px;overflow-y:scroll'>
		<table id='table1' class='table table-bordered table-responsive'>
			<tr class='danger'>
				<th>Buyer</th>
				<th>Style</th>
				<th>Schedule</th>
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
				<th>CAD Saving  <?php $fab_uom ?></th>
				<th>Utilization(CAD YY)</th>
				<th>Fabric Allocated</th>
				<th>Fabric Issued Docket</th>
				<th>Fabric Issued MRN</th>
				<th>Fabric Issued Total</th>
				<th>Difference</th>
				<th>Deaviation%</th>
				<th>Damages</th>
				<th>Shortages</th>
				<th>Joints</th>
				<th>Endbits</th>
				<th>Fabric Balance to Issue</th>
				<th>Fabric Balance Requirement</th>
				<th>AOD Status</th>
			</tr>";
			
			//To get Category
			$sql="SELECT fabric_category,purchase_width,rm_sku FROM $pps.`mp_color_detail` LEFT JOIN $pps.`mp_fabric` ON mp_fabric.master_po_details_id=mp_color_detail.master_po_details_id WHERE style='$style' AND color='$color' AND mp_fabric.master_po_number='$mpo' AND mp_fabric.plant_code='$plant_code'";
            $sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($sql_result))
			{
				$category=$row['fabric_category'];
				$purchase_width=$row['purchase_width'];
				$rm_sku=$row['rm_sku'];
				
				//To get plan date
				$get_plan_date="SELECT planned_cut_date FROM $oms.oms_mo_details WHERE schedule='$schedule' AND plant_code='$plant_code'";
                $sql_result1=mysqli_query($link, $get_plan_date) or die("Error".$get_plan_date.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1=mysqli_fetch_array($sql_result1))
				{
                   $plan_start_date = $row1['planned_cut_date'];
				}
				
				//To get exfactory date
				$get_exfactory_date="select max(ex_factory_date) as dat,ship_tid from $pps.shipment_plan where schedule_no='$schedule' and color='$color' AND plant_code='$plant_code'";
				$result=mysqli_query($link, $get_exfactory_date) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row2=mysqli_fetch_array($result))
			    {
					$ship_tid=$row2["tid"];
					$ex_factory_date_new=$row2["dat"];
				}

				//To get Total order qty
				$get_order_qty="SELECT SUM(quantity) AS quantity FROM $pps.`mp_mo_qty` WHERE SCHEDULE='$schedule' AND color='$color' AND plant_code='$plant_code'";
				$sql_result3=mysqli_query($link, $get_order_qty) or die("Error".$get_order_qty.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row3=mysqli_fetch_array($sql_result3))
				{
					$total_order_qty=$row3['quantity'];
				}
                

				echo "<tr>";
				echo "<td>".$style."</td>";
				echo "<td>".$schedule."</td>";
				echo "<td>".$category."</td>";
				echo "<td>".$purchase_width."</td>";
				echo "<td></td>";
				echo "<td>".$rm_sku."</td>";
				echo "<td>".$color."</td>";
				echo "<td>".$plan_start_date."</td>";
				echo "<td>".$ex_factory_date_new."</td>";
				echo "<td>".$total_order_qty."</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "</tr>";	
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
