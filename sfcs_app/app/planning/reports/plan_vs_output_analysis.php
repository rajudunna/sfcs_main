<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R')); 
$plant_code = $_SESSION['plantCode'];
if(isset($_POST['submit'])) {
    $edate=$_POST['dat2'];
    $sdate=$_POST['dat1'];
    $section=$_POST['section'];
}

?>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
    function verify_date() {
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
	
	<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R')?>"></script>
   	<link href="<?= getFullURLLevel($_GET['r'],'common/css/jsDatePick_ltr.min.css',1,'R') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= getFullURL($_GET['r'],'common/css/ddcolortabs.css',3,'R') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />


<div class="panel panel-primary">
    <div class="panel-heading">Plan Achievement Report</div>
    <div class="panel-body">
        <div class="form-group">
            <form method="POST" action="index-no-navi.php?r=<?php echo $_GET['r']; ?>">
            <?php
                $sdate = $_POST['dat1'];
                $edate = $_POST['dat2'];
                $section = $_POST['section'];
            ?>
            <div clas="row">
                <div class="col-sm-3">
                    Start Date: <input type="text" id="demo1" data-toggle="datepicker" class="form-control"  name="dat1" value=<?php if($sdate!="") { echo $sdate; } else { echo date("Y-m-d"); } ?> >
                </div>
                <div class="col-sm-3">
                    End Date: <input type="text" id="demo2" data-toggle="datepicker" class="form-control"  name="dat2" value=<?php if($edate!="") { echo $edate; } else { echo date("Y-m-d"); } ?> >
                </div>
                <div class="col-sm-3">
                    Section:
                    <?php
                        $sections = getSections($plant_code)['section_data'];
                        echo "<select name=\"section\" class=\"form-control\" placeholder='Please select'>";
                        foreach($sections as $section_info) {
                            $section_code = $section_info['section_code']."-".$section_info['section_name'];
                            $section_id = $section_info['section_id'];
                            if ($section_id == $section) {
                                echo "<option value='$section_id' selected>$section_code</option>";
                            } else {
                                echo "<option value='$section_id'>$section_code</option>";
                            }
                        }
                        echo "</select>";   
                    ?>
                    </div></br>
                    <div class="col-sm-3">
                        &nbsp;&nbsp;&nbsp;<input type="submit" name="submit" class="btn btn-info" value="submit" onclick="return verify_date()">
                    </div>
                </div>
            </form>
        </div>
<?php

if(isset($_POST['submit']))
{
	$records_count=0;
	$IMS_OP = '130';
	// Table print
	$criteria="";
	if($section!=0)
	{
		$criteria=" and section=".$section;
	}
	$modules = getWorkstationsForSectionId($plant_code, $section);

	echo "<br/><h4 style='color:#286090'><center><span class='label label-success'>Daily Plan Achievement Report</span></center></h4>";
	echo "<div  class ='table-responsive'>";
	echo "<div class='pull-right' id='export_excel'></div>";
	echo "<table  border=1 class='table table-bordered' >";
	$table.="<h2>Daily Plan Achievement Report</h2><table border=1>";

	echo "<tr>";
	$table.="<tr>";
	echo "<th colspan=2>Section</th>";
	$table.="<th colspan=2></th>";

	
	foreach($modules as $workstation) {
		echo "<th colspan=4>".$workstation['workstationCode']."</th>";
		$table.="<th colspan=4>".$workstation['workstationCode']."</th>";
	}

	echo "</tr>";
	$table.="</tr>";

	echo "<tr>";
	$table.="<tr>";
	echo "<th>Date</th><th>Day</th>";
	$table.="<th>Date</th><th>Day</th>";

	foreach($modules as $workstation) {
		$records_count++;
		echo "<th>Style</th>";
		$table.="<th>Style</th>";
		echo "<th>Plan</th>";
		$table.="<th>Plan</th>";
		echo "<th>Actual</th>";
		$table.="<th>Actual</th>";
		echo "<th>Diff.</th>";
		$table.="<th>Diff.</th>";
	}
	echo "</tr>";

	$table.="</tr>";

	$dates_query = "SELECT DISTINCT planned_date FROM $pps.monthly_production_plan pml 
	LEFT JOIN $pps.monthly_production_plan_upload_log pul ON pul.monthly_pp_up_log_id = pml.monthly_pp_up_log_id 
	WHERE pml.planned_date BETWEEN '$sdate' AND '$edate' AND pul.plant_code = '$plant_code' ORDER BY planned_date DESC";
	$dates_result = mysqli_query($link, $dates_query) or exit("Problem in retrieving dates ". $dates_query );

	while($row = mysqli_fetch_array($dates_result)) {
		$curr_date = $row['planned_date'];

		echo "<tr class='tblheading'>";
		$table.="<tr>";
		echo "<td class='new'>$curr_date</td>";
		$table.="<td>$curr_date</td>";
		echo "<td class='new'>".date('l',strtotime($curr_date))."</td>";
		$table.='<td>'.date('l',strtotime($curr_date))."</td>";

		// get the planned qty against each workstation and each data
		$check=0;
		foreach($modules as $workstation) {
			if($check==0) {
				$bgcolor="#ffffaa";	
				$check=1;
			} else {
				$bgcolor="#99ffee";
				$check=0;
			}
			$workstatin_code = $workstation['workstationCode'];
			$workstation_id = $workstation['workstationId'];
			$planned_qty = 0;
			$actual_qty = 0;
			$styles = [];
			$section = '';
			// get the styles of the current workstation
			$plan_qty_query = "SELECT row_name, `group`, planned_date, SUM(planned_qty) as planned_qty,colour, product_code FROM $pps.monthly_production_plan pml
				WHERE pml.planned_date = '$curr_date' AND pml.plant_code = '$plant_code' AND row_name = '$workstatin_code'
				GROUP BY product_code, planned_date ";
			$plant_qty_result = mysqli_query($link, $plan_qty_query) or exit("Plan qty query error". $plan_qty_query);
			while($plan_row = mysqli_fetch_array($plant_qty_result)) {
				$planned_qty += $plan_row['planned_qty'];
				$section = $plan_row['group'];
				$style = $plan_row['product_code'];
				array_push($styles, $style);
				$actual_output = 0;
				if ($styles) {
					// get the total actual qty against to the style
					$actual_output_query = "SELECT SUM(good_quantity) AS `output` FROM $pts.transaction_log WHERE plant_code='$plant_code' and style='$style' and DATE(created_at) = '$curr_date' 
					AND operation = '$IMS_OP' and resource_id='$workstation_id' ";
					$actual_output_result = mysqli_query($link, $actual_output_query) or exit("Actual output qty query error");
					while($act_output_row = mysqli_fetch_array($actual_output_result)) {
						$actual_qty += $act_output_row['output'];
					}
				}
			}
			$styles_string = implode(",", $styles);
			echo "<td bgcolor=$bgcolor>$styles_string</td>";
			$table.="<td bgcolor=$bgcolor>$styles_string</td>";
			echo "<td bgcolor=$bgcolor>$planned_qty</td>";
			$table.="<td bgcolor=$bgcolor>$planned_qty</td>";
			echo "<td bgcolor=$bgcolor>$actual_qty</td>";
			$table.="<td bgcolor=$bgcolor>$actual_qty</td>";
			echo "<td bgcolor=$bgcolor>".($planned_qty-$actual_qty)."</td>";
			$table.="<td bgcolor=$bgcolor>".($planned_qty-$actual_qty)."</td>";
		}
		echo "</tr>";
		$table.="</tr>";
	}

	if($records_count == 0){
		echo"<tr><td colspan=2 style='color:red'><b><center>No Data Found</center></b></td></tr>";
	}
	echo "</table>";
	$table.="</table>";
 	echo "</div>";
 
    echo "
    <div id='div-1a'> 
        <form  name='input' action= ".getFullURL($_GET['r'],'plan_vs_output_analysis_excel.php','R')." method='post'>
            <input type='hidden' name='table' value='$table'>
            <input type='submit' name='submit1' value='Export to Excel' class='btn btn-info'>
        </form>
    </div>";
}
?>
    </div>
</div>

<?php ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); ?>
<style>
    th{
        text-align:center;
    }
</style>
<script>
	$('#export_excel').html($('#div-1a'));
</script>


	


