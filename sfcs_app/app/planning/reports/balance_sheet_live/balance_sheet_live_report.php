<!DOCTYPE html>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/config.php', 4, 'R');
include $_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/user_acl_v1.php', 4, 'R');
include $_SERVER['DOCUMENT_ROOT'] . "/sfcs_app/common/config/config_ajax.php";
$plantcode = $_SESSION['plantCode'];
$username = $_SESSION['userName'];
// $has_perm = haspermission($_GET['r']);
?>
<html>

<head>
	<title>Balance Sheet</title>
    <style type="text/css" media="screen">
		th {
			background-color: #337ab7;
			color: #FFF;
		}
	</style>
	<script>
    /**validates is start date is less then end date and endDate is less then current Date*/
		function check_date() {
			var from_date = document.getElementById("sdate").value;
			var to_date = document.getElementById("edate").value;
			var today = document.getElementById("today").value;
			if ((Date.parse(to_date) <= Date.parse(from_date))) {
				sweetAlert('Start date should be less than End date', '', 'warning');
				document.getElementById("edate").value = "<?php echo date("Y-m-d"); ?>";
                document.getElementById("sdate").value = "<?php echo date("Y-m-d"); ?>";
                return false;
			}
			if ((Date.parse(to_date) > Date.parse(today))) {
				sweetAlert('End date should not be greater than Today', '', 'warning');
                document.getElementById("edate").value = "<?php echo date("Y-m-d"); ?>";
                return false;
            }
            if((Date.parse(to_date) > Date.parse(from_date))&&(Date.parse(to_date) < Date.parse(today))){
                loadPageWithaddingDateParams()
            }
        }
        function loadPageWithaddingDateParams(){
            y=document.balanceSheetForm.buyer_div.value;
	        window.location.href ="<?=getFullURL($_GET['r'], 'balance_sheet_live_report.php', 'N')?>&sdate="+document.balanceSheetForm.sdate.value+"&edate="+document.balanceSheetForm.edate.value
        }
        function loadPageWithBuyerDivAndDates(){
            y=document.balanceSheetForm.buyer_div.value;
	        window.location.href ="<?=getFullURL($_GET['r'], 'balance_sheet_live_report.php', 'N') . '&buyer_div='?>"+encodeURIComponent(y)+"&sdate="+document.balanceSheetForm.sdate.value+"&edate="+document.balanceSheetForm.edate.value
        }
        function check_style(){
            if(document.getElementById('buyer_div').value == 'Select'){
                sweetAlert('Please select Buyer First ','','warning')
                return false;
            }
            else if(document.getElementById('style_name').value == ''){
                sweetAlert('Please select style ','','warning')
                return false;
            }else{
                return true;
            }
        }
        /**validates on style selection */
        function check_buyer(){
            if(document.getElementById('buyer_div').value == 'Select'){
                sweetAlert('Please select Buyer First ','','warning')
                return false;
            }else{
                return true;

            }
        }
        function toggle(source) {
		checkboxes = document.getElementsByClassName('report_row_filter');
		for(var i=0, n=checkboxes.length;i<n;i++) {
			checkboxes[i].checked = source.checked;
		}
	}
	</script>
</head>
<?php
if (isset($_GET['buyer_div'])) {
    $buyer_div = urldecode($_GET["buyer_div"]);
}

if (isset($_GET['sdate'])) {
    $sdate = $_GET['sdate'];
} else {
    $sdate = date("Y-m-d");
}

if (isset($_GET['edate'])) {
    $edate = $_GET['edate'];
} else {
    $edate = date("Y-m-d");
}

if (isset($_POST['buyer_div'])) {
    $buyer_div = $_POST['buyer_div'];
}

if (isset($_POST['sdate'])) {
    $sdate = $_POST['sdate'];
}

if (isset($_POST['edate'])) {
    $edate = $_POST['edate'];
}

if (isset($_POST['style_name'])) {
    $style_name = $_POST['style_name'];
}

//To Convert week to date
function weeknumber_v2($y, $w)
{
    include $_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/config.php', 4, 'R');
    $sql = "select STR_TO_DATE('$y$w Friday', '%X%V %W') as week";
    //echo $sql;
    $sql_result = mysqli_query($link, $sql) or exit("Sql Error1" . mysqli_error($GLOBALS["___mysqli_ston"]));
    while ($sql_row = mysqli_fetch_array($sql_result)) {
        return ($sql_row['week']);
    }
}

# get_week_date( week_number, year, day_offset, format )
function get_week_date($wk_num, $yr, $first = 5, $format = 'F d, Y')
{
    $wk_ts = strtotime('+' . (($wk_num) - 1) . ' weeks', strtotime($yr . '0101'));
    $mon_ts = strtotime('-' . date('w', $wk_ts) + $first . ' days', $wk_ts);
    //echo $wk_ts."-".$mon_ts."<br>";
    return date($format, $mon_ts);
}

function daysDifference($endDate, $beginDate)
{
    //explode the date by "-" and storing to array
    $date_parts1 = explode("-", $beginDate);
    $date_parts2 = explode("-", $endDate);

    //gregoriantojd() Converts a Gregorian date to Julian Day Count
    $start_date = gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
    $end_date = gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
    return $end_date - $start_date;
}

# get start and end date of a week
function getStartAndEndDate($week, $year)
{
    $dto = new DateTime();
    $dto->setISODate($year, $week);
    $ret['week_start'] = $dto->format('Y-m-d');
    $dto->modify('+4 days');
    $ret['friday'] = $dto->format('Y-m-d');
    $dto->modify('+2 days');
    $ret['week_end'] = $dto->format('Y-m-d');
    return $ret;
}

function getMonthsInRange($startDate, $endDate) {
    $months = array();
    while (strtotime($startDate) <= strtotime($endDate)) {
        $months[] = array('year' => date('Y', strtotime($startDate)), 'month' => date('m', strtotime($startDate)), );
        $startDate = date('01 M Y', strtotime($startDate.
            '+ 1 month')); // Set date to 1 so that new month is returned as the month changes.
    }
    
    return $months;
}


//data base queries
function getBuyersBetweenGivenExfactoryDate($fromDate, $toDate, $plantCode, $dbName, $dbLink)
{
    $fromDate = str_replace("-", "", $fromDate);
    $toDate = str_replace("-", "", $toDate);
    $sql = "SELECT DISTINCT(buyer_desc) AS buyer_div FROM $dbName.`oms_mo_details` WHERE plant_code='" . $plantCode . "' AND planned_delivery_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "' ";
    $sql_result = mysqli_query($dbLink, $sql) or exit("Sql Error in getBuyersBetweenGivenExfactoryDate" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $buyer_code = [];
    while ($sql_row = mysqli_fetch_array($sql_result)) {
        $buyer_code[] = $sql_row["buyer_div"];
    }
    return $buyer_code;
}

function getStylePonumbersDropDownData($fromDate, $toDate, $plantCode, $buyer_div, $dbName1, $dbName2, $dbLink)
{
    $fromDate = str_replace("-", "", $fromDate);
    $toDate = str_replace("-", "", $toDate);
    $sql_modetails = "SELECT DISTINCT(po_number) AS po_number FROM $dbName1.`oms_mo_details` WHERE plant_code='" . $plantCode . "' AND planned_delivery_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "' AND buyer_desc='" . $buyer_div . "' ";
    $sql_result = mysqli_query($dbLink, $sql_modetails) or exit("Sql Error1 in getStylePonumbersDropDownData" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $po_number_array = [];
    while ($sql_row = mysqli_fetch_array($sql_result)) {
        $po_number_array[] = $sql_row["po_number"];
    }
    if (sizeof($po_number_array)) {
        $single_quate_added = "'" . implode("', '", $po_number_array) . "'";
        $sql = "SELECT DISTINCT(style),master_po_number  FROM $dbName2.`mp_color_detail` WHERE master_po_number IN ($single_quate_added)";
        $sql_result = mysqli_query($dbLink, $sql) or exit("Sql Error2 in getStylePonumbersDropDownData" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $po_number_associate_array = [];
        while ($sql_row = mysqli_fetch_array($sql_result)) {
            $po_number_associate_array[$sql_row["style"]] = $sql_row["master_po_number"];
        }
        return $po_number_associate_array;
    }
}

?>
<body>
	<div class='panel panel-primary'>
		<div class='panel-heading'>Balance Sheet (Live) - Week: <?php echo date("W") + 1; ?></div>
		<div class='panel-body'>
			<form name="balanceSheetForm" id="balanceSheetForm" action="index-no-navi.php?r=<?php echo $_GET['r']; ?>" method="post">
				<div class="row">
					<input type="hidden" name="today" id="today" value="<?php echo date("Y-m-d"); ?>">
					<div class="col-md-2">
						<label>Start Date</label>
						<input type="text" id="sdate" data-toggle="datepicker" onchange="check_date()" name="sdate" size="8" class="form-control" value="<?php if (isset($_POST['sdate'])) {echo $_POST['sdate'];} else {echo $sdate;}?>" required>
				   </div>
				   <div class="col-md-2">
					<label>End Date</label>
					<input type="text" id="edate" data-toggle="datepicker" onchange="check_date()" name="edate" size="8" class="form-control" value="<?php if (isset($_POST['edate'])) {echo $_POST['edate'];} else {echo $edate;}?>" required>
                  </div>
                  <div class="col-md-2">
                    <label>Buyer Division: </label>
                    <select name="buyer_div" id="buyer_div"  onchange="loadPageWithBuyerDivAndDates();" class="form-control">
                        <option value="Select" <?php if ($buyer_div == "Select") {echo "selected";}?> >Select</option>
                            <?php
if ((isset($_GET['sdate']) && isset($_GET['edate']))||(isset($_POST['sdate'])&& isset($_POST['edate']))) {
    $buyer_name = getBuyersBetweenGivenExfactoryDate($sdate, $edate, $plantcode, $oms, $link);
    for ($i = 0; $i < sizeof($buyer_name); $i++) {
        if ($buyer_name[$i] == $buyer_div) {
            echo "<option value=\"" . ($buyer_name[$i]) . "\" selected>" . $buyer_name[$i] . "</option>";
        } else {
            echo "<option value=\"" . ($buyer_name[$i]) . "\"  >" . $buyer_name[$i] . "</option>";
        }
    }
}
?>
                    </select>
                  </div>
                <div class="col-md-2">
                <label>Style Filter: </label>
                <select name="style_name" id="style_name"  class="form-control" onclick="return check_buyer()" required>

                <option value="" <?php if ($style_name == "") {echo "selected";}?> >Select</option>
                <option value="ALL" <?php if ($style_name == "ALL") {echo "selected";}?> >All</option>
                    <?php
                    if (strlen($buyer_div) > 0) {
                        $style_Po_number_array=getStylePonumbersDropDownData($sdate, $edate, $plantcode,$buyer_div ,$oms,$pps, $link);
                        foreach ($style_Po_number_array as $style => $po_number) {
                            if ($po_number.'$@'.$style == $style_name) {
                                echo "<option value=\"" . $po_number.'$@'.$style . "\" selected>" . $style. "</option>";
                            } else {
                                echo "<option value=\"" . $po_number.'$@'.$style. "\" >" . $style . "</option>";
                            }
                         }
                    }
                    ?>
                </select>
                </div>
                <div class="col-md-2">
				<label>Row Filter:</label>
				<div style="overflow:auto;width:auto;height:75px;border:0px solid #336699;padding-left:0px">
				<input type="checkbox"  name="All" onClick="toggle(this)" value="1" <?php if ($_POST['All'] == 1) {echo "checked";}?>>Show All<br>
				<input type="checkbox" class='report_row_filter' name="Plan_Qty" value="1" <?php if ($_POST['Plan_Qty'] == 1) {echo "checked";}?>>Plan Qty<br>
				<input type="checkbox" class='report_row_filter' name="Cut_Qty" value="1" <?php if ($_POST['Cut_Qty'] == 1) {echo "checked";}?>>Cut Qty<br>
				<input type="checkbox" class='report_row_filter' name="Sewing_IN" value="1" <?php if ($_POST['Sewing_IN'] == 1) {echo "checked";}?>>Sewing IN<br>
				<input type="checkbox" class='report_row_filter' name="Sewing_OUT" value="1" <?php if ($_POST['Sewing_OUT'] == 1) {echo "checked";}?>>Sewing OUT<br>
				<input type="checkbox" class='report_row_filter' name="Packing_Out" value="1" <?php if ($_POST['Packing_Out'] == 1) {echo "checked";}?>>Packing Out<br>
				<input type="checkbox" class='report_row_filter' name="Sewing_Balance" value="1" <?php if ($_POST['Sewing_Balance'] == 1) {echo "checked";}?>>Sewing Balance<br>
				<input type="checkbox" class='report_row_filter' name="No_of_Days" value="1" <?php if ($_POST['No_of_Days'] == 1) {echo "checked";}?>>No of Days<br>
				<input type="checkbox" class='report_row_filter' name="Current_Modules" value="1" <?php if ($_POST['Current_Modules'] == 1) {echo "checked";}?>>Current Modules<br>
				<input type="checkbox" class='report_row_filter' name="Required_Target" value="1" <?php if ($_POST['Required_Target'] == 1) {echo "checked";}?>>Required Target<br>
				<input type="checkbox" class='report_row_filter' name="Actual_Reached" value="1" <?php if ($_POST['Actual_Reached'] == 1) {echo "checked";}?>>Actual Reached<br>
				<input type="checkbox" class='report_row_filter' name="Days_Required" value="1" <?php if ($_POST['Days_Required'] == 1) {echo "checked";}?>>Days Required<br>
				<input type="checkbox" class='report_row_filter' name="Expected_Comp_Date" value="1" <?php if ($_POST['Expected_Comp_Date'] == 1) {echo "checked";}?>>Expected Comp.Date<br>
				<input type="checkbox" class='report_row_filter' name="Shiping_Out" value="1" <?php if ($_POST['Shiping_Out'] == 1) {echo "checked";}?>>Shipping Out<br>
				</div>
			</div>

            <?php
// if (in_array($authorized, $has_perm)) {
    //echo '<span id="msg" style="display:none;"><b><font color=\"blue\">Please Wait...</font></b></span>';
    echo "<input class='btn btn-success' type=submit name=\"submit\" value=\"submit\" id=\"submit\" onClick='return check_style()' style='margin-top:22px;'>";
// }
?>
				</div>
            </form>
            <?php
            if (isset($_POST["submit"])) {
                $start_date = $_POST["sdate"];
                $end_date = $_POST["edate"];
                $buyer = urldecode($_POST["buyer_div"]);
                $style_id = $_POST["style_name"];
                $All = $_POST['All'];
                $Plan_Qty = $_POST['Plan_Qty'];
                $Cut_Qty = $_POST['Cut_Qty'];
                $Sewing_IN = $_POST['Sewing_IN'];
                $Sewing_OUT = $_POST['Sewing_OUT'];
                $Packing_Out = $_POST['Packing_Out'];
                $Shiping_Out = $_POST['Shiping_Out'];
                $Sewing_Balance = $_POST['Sewing_Balance'];
                $No_of_Days = $_POST['No_of_Days'];
                $Current_Modules = $_POST['Current_Modules'];
                $Required_Target = $_POST['Required_Target'];
                $Actual_Reached = $_POST['Actual_Reached'];
                $Days_Required = $_POST['Days_Required'];
                $Expected_Comp_Date = $_POST['Expected_Comp_Date'];
                $i = 0;
                $t = 0;
                $j = 1;
                $r = $t;
                $fromDate=str_replace("-", "", $start_date);
                $toDate=str_replace("-", "", $end_date);
                $sql = "SELECT DISTINCT WEEK(planned_delivery_date) AS week_code,YEAR(planned_delivery_date) AS YEAR,
                GROUP_CONCAT(DISTINCT planned_delivery_date ORDER BY planned_delivery_date)AS dates FROM $oms.`oms_mo_details` WHERE  plant_code='".$plantcode."' AND
                 planned_delivery_date BETWEEN '".$fromDate."' AND '".$toDate."' AND buyer_desc='".$buyer."' 
                 GROUP BY WEEK(planned_delivery_date) ORDER BY planned_delivery_date,WEEK(planned_delivery_date) ";
                //echo $sql."<br>";
                $sql_result = mysqli_query($link, $sql) or exit("Sql Error3" . mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($sql_row = mysqli_fetch_array($sql_result)) {
                    $week_code_ref = $sql_row['week_code'];
                    $week_code_ref1 = $sql_row['week_code'] + $r;
                    $year_ref = $sql_row['YEAR'];
                    if ($sql_row['week_code'] == 53) {
                        $week_code_ref1 = 1;
                        $r = 1;
                    }
            
                    $week_code_ref_val[$i] = $week_code_ref;
                    $exfact_year[$i] = $year_ref;
            
                    $i = $i + $j;
                }
                $week_code = array();
                for ($i = 0; $i < (sizeof($week_code_ref_val)); $i++) {
                    $week_code[$i] = $week_code_ref_val[$i];
                }                
                $table='';
                $table.='<table class="table table-bordered" border=1  id="tablecol" >';

                //week numbers
                $table.='<tr>';
                $table.='<th>Week</th>';
                for ($i = 0; $i < (sizeof($week_code_ref_val)); $i++) {
                    $table.='<th>' . ($week_code_ref_val[$i] + $t) . '</th>';
                }
                $table.='</tr>';

                //Friday of the week date
                $table.='<tr>';
                $table.='<th>Date</th>';
                for ($i = 0; $i < sizeof($week_code); $i++) {
                    $friday[$i] = weeknumber_v2($exfact_year[$i], $week_code[$i]);
                    $week_array = getStartAndEndDate($week_code[$i], $exfact_year[$i]);
                    $monday = date("Y-m-d", strtotime(get_week_date($week_code[$i], $exfact_year[$i])));
                    $monday_split = explode("-", $monday);
                    
                    $table.='<td class=date>' . $week_array["friday"] . '</td>';
                }
                $table.='</tr>';

                if($style_id=='ALL'){
                    $style_Po_number_array=getStylePonumbersDropDownData($start_date, $end_date, $plantcode,$buyer,$oms,$pps,$link);
                }else{
                     $style_id_arry= explode('$@',$style_id);
                    $style_Po_number_array=array($style_id_arry[1]=>$style_id_arry[0]);
                }
                $url=getFullURL($_GET['r'],'tabular_rep_pop.php','N');
                foreach ($style_Po_number_array as $style_code => $po_number) {
                    $table.='<tr>';
                    $table.='<th>' . $style_code . '</th>';
                    for ($i = 0; $i < sizeof($week_code); $i++) {
                        for ($i = 0; $i < sizeof($week_code); $i++) {
                            $week_array = getStartAndEndDate($week_code[$i], $exfact_year[$i]);
                            $table.="<td class=style>
                            
                            </td>";
                            // <a href=\"$url&week_start=" . $week_array["week_start"] . "&week_end=" . $week_array["week_end"] . "&style_id=$style_code\" onclick=\"Popup=window.open(\"$url&week_start=" . $week_array["week_start"] . "&week_end=" . $week_array["week_end"] . "&style_id=$style_code','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><center><strong>POP</strong></center></a>
                        }
                    }
                    $table.='</tr>';

                    //planned qty 
                    if ($Plan_Qty == 1 || $All == 1) {
                        $table.='<tr><td>Plan Qty</td>';
                        for ($i = 0; $i < sizeof($week_code); $i++) {
                        $week_array1 = getStartAndEndDate($week_code[$i], $exfact_year[$i]);
                        $months_arra=getMonthsInRange($week_array1["week_start"],$week_array1["week_end"]);
                        $months_where_condition='';
                        foreach ($months_arra as $index => $monthyeararra) {
                            $months_where_condition.="'".$monthyeararra['month']."',";
                        }
                        $plannedQtyQuery="SELECT SUM(planned_qty) as planned_qty FROM $pps.`monthly_production_plan` WHERE product_code='".$style_code."' AND 
                        monthly_pp_up_log_id IN (SELECT monthly_pp_up_log_id FROM $pps.`monthly_production_plan_upload_log` WHERE month IN (".rtrim($months_where_condition, ',').") AND plant_code='".$plantcode."') 
                        AND planned_date BETWEEN '".$week_array1["week_start"]."' AND '".$week_array1["week_end"]."'";
                        $sql_result2 = mysqli_query($link, $plannedQtyQuery) or exit("Sql Error in planned Qty" . mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($sql_row2 = mysqli_fetch_array($sql_result2)) {
                            $plannedQty=$sql_row2['planned_qty'];
                        }
                        if ($plannedQty) {
                            $table.='<td>'.$plannedQty.'</td>';
                        } else {
                            $table.='<td>0</td>';
                        }
                      }
                      $table.='</tr>';
                    }
                    //cut quantity
                    if ($Cut_Qty == 1 || $All == 1) {
                        $table.='<tr><td>Cut Qty</td>';
                        for ($i = 0; $i < sizeof($week_code); $i++) {
                            $week_array2 = getStartAndEndDate($week_code[$i], $exfact_year[$i]);
                            $cutQty=0;
                            $lay_jm_docket_lines="SELECT `mp_sub_order`.`master_po_number`,`lp_lay`.`po_number`,`lp_lay`.`jm_docket_line_id`,`lp_lay`.`plies` FROM $pps.`lp_lay` JOIN $pps.`mp_sub_order` ON 
                            `lp_lay`.`po_number`= mp_sub_order.`po_number` WHERE `mp_sub_order`.`master_po_number` IN ('".$po_number."')";
                            $sql_result1 = mysqli_query($link, $lay_jm_docket_lines) or exit("Sql Error1 in cut Qty" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            while ($sql_row1 = mysqli_fetch_array($sql_result1)) {
                                $sql_jm_docket="SELECT plies,jm_docket_id FROM $pps.jm_docket_lines WHERE jm_docket_line_id = '".$sql_row1['jm_docket_line_id']."'";
                                $sql_result2 = mysqli_query($link, $sql_jm_docket) or exit("Sql Error2 in cut Qty" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                while ($sql_row2 = mysqli_fetch_array($sql_result2)) {
                                    $sql_cg="SELECT component_group_id, ratio_id FROM $pps.lp_ratio_component_group 
                                    JOIN $pps.jm_dockets ON lp_ratio_component_group.`lp_ratio_cg_id`=jm_dockets.`ratio_comp_group_id`
                                    WHERE jm_dockets.`jm_docket_id`='".$sql_row2['jm_docket_id']."'";
                                     $sql_result3 = mysqli_query($link, $sql_cg) or exit("Sql Error3 in cut Qty" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                     while ($sql_row3 = mysqli_fetch_array($sql_result3)) {
                                        $sql_isMainCg="SELECT is_main_component_group FROM $pps.`lp_component_group` WHERE lp_cg_id = '".$sql_row3['component_group_id']."' AND is_main_component_group='1'";
                                        $sql_result4 = mysqli_query($link, $sql_isMainCg) or exit("Sql Error4 in cut Qty" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                        if(mysqli_num_rows($sql_result4)){
                                           $sql_ratio_sum="SELECT SUM(size_ratio) as ratio_qty FROM $pps.lp_ratio_size WHERE ratio_id = '".$sql_row3['ratio_id']."'";
                                         $sql_result5 = mysqli_query($link, $sql_ratio_sum) or exit("Sql Error5 in cut Qty" . mysqli_error($GLOBALS["___mysqli_ston"]));
                                         $sql_row5 = mysqli_fetch_array($sql_result5);
                                           $cutQty += $sql_row2['plies'] * $sql_row5['ratio_qty'];
                                        }
                                     }
                                }
                            }
                            if ($cutQty) {
                                $table.='<td>'.$cutQty.'</td>';
                            } else {
                                $table.='<td>0</td>';
                            }
                        }
                        $table.='</tr>';
                    }

                    $sewingOutArray=array();
                    $sewingInArray=array();
                
                    //sewing In
                    if ($Sewing_IN == 1 || $All == 1) {
                        $table.='<tr><td>Sewing IN</td>';
                        for ($i = 0; $i < sizeof($week_code); $i++) {
                            $week_array2 = getStartAndEndDate($week_code[$i], $exfact_year[$i]);
                           $pms_ops_code="SELECT operation_code FROM $pms.`operation_mapping` WHERE operation_category = 'SEWING' ORDER BY sequence ASC LIMIT 1"; 
                           $sql_result2 = mysqli_query($link, $pms_ops_code) or exit("Sql Error1 in sewing Qty" . mysqli_error($GLOBALS["___mysqli_ston"]));
                           $sql_row2= mysqli_fetch_array($sql_result2);

                           $sql_sewing_In="SELECT SUM(good_quantity) as sewingInQty FROM $pts.`transaction_log` WHERE created_at BETWEEN '".$week_array2['week_start']."' AND '".$week_array2['week_end']."' AND operation IN ('".$sql_row2['operation_code']."')";

                            $sql_result3 = mysqli_query($link, $sql_sewing_In) or exit("Sql Error2 in sewing Qty" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            $sql_row3 = mysqli_fetch_array($sql_result3);
                            $sewIngInQty=$sql_row3['sewingInQty'];
                            $sewingInArray[$week_code[$i]]=$sewIngInQty;
                            if ($sewIngInQty) {
                                $table.='<td>'.$sewIngInQty.'</td>';
                            } else {
                                $table.='<td>0</td>';
                            }
                        }
                        $table.='</tr>';
                    }


                    //Sewing Out
                    if ($Sewing_OUT == 1 || $All == 1) {
                        $table.='<tr><td>Sewing OUT</td>';
                        for ($i = 0; $i < sizeof($week_code); $i++) {
                            $week_array2 = getStartAndEndDate($week_code[$i], $exfact_year[$i]);
                            $pms_ops_code="SELECT operation_code FROM $pms.`operation_mapping` WHERE operation_category = 'SEWING' ORDER BY sequence DESC LIMIT 1"; 
                            $sql_result2 = mysqli_query($link, $pms_ops_code) or exit("Sql Error1 in sewing Qty" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            $sql_row2= mysqli_fetch_array($sql_result2);
 
                            $sql_sewing_In="SELECT SUM(good_quantity) as sewingOutQty FROM $pts.`transaction_log` WHERE created_at BETWEEN '".$week_array2['week_start']."' AND '".$week_array2['week_end']."' AND operation IN ('".$sql_row2['operation_code']."')";
 
                             $sql_result3 = mysqli_query($link, $sql_sewing_In) or exit("Sql Error2 in sewing Qty" . mysqli_error($GLOBALS["___mysqli_ston"]));
                             $sql_row3 = mysqli_fetch_array($sql_result3);
                             $sewIngOutQty=$sql_row3['sewingOutQty'];
                             $sewingOutArray[$week_code[$i]]=$sewIngOutQty;
                            if ($sewIngOutQty) {
                                $table.='<td>'.$sewIngOutQty.'</td>';
                            } else {
                                $table.='<td>0</td>';
                            }
                        }
                        $table.='</tr>';
                    }

                    //Packing Out
                    if ($Packing_Out == 1 || $All == 1)  {
                        $table.='<tr><td>Packing Out</td>';
                        for ($i = 0; $i < sizeof($week_code); $i++) {
                            $week_array2 = getStartAndEndDate($week_code[$i], $exfact_year[$i]);
                            $pms_ops_code="SELECT operation_code FROM $pms.`operation_mapping` WHERE operation_category = 'PACKING' ORDER BY sequence DESC LIMIT 1"; 
                            $sql_result2 = mysqli_query($link, $pms_ops_code) or exit("Sql Error1 in packIngOutQty" . mysqli_error($GLOBALS["___mysqli_ston"]));
                            $sql_row2= mysqli_fetch_array($sql_result2);
 
                            $sql_sewing_In="SELECT SUM(good_quantity) as packIngOutQty FROM $pts.`transaction_log` WHERE created_at BETWEEN '".$week_array2['week_start']."' AND '".$week_array2['week_end']."' AND operation IN ('".$sql_row2['operation_code']."')";
 
                             $sql_result3 = mysqli_query($link, $sql_sewing_In) or exit("Sql Error2 in packIngOutQty" . mysqli_error($GLOBALS["___mysqli_ston"]));
                             $sql_row3 = mysqli_fetch_array($sql_result3);
                             $packIngOutQty=$sql_row3['packIngOutQty'];

                            if ($packIngOutQty) {
                                $table.='<td>'.$packIngOutQty.'</td>';
                            } else {
                                $table.='<td>0</td>';
                            }
                        }
                        $table.='</tr>';
                    }


                    //Shiping Out
                    if ($Shiping_Out == 1 || $All == 1)  {
                        $table.='<tr><td>Shipping Out</td>';
                        for ($i = 0; $i < sizeof($week_code); $i++) {

                            
                            if ($shippIngOutQty) {
                                $table.='<td>'.$shippIngOutQty.'</td>';
                            } else {
                                $table.='<td>0</td>';
                            }
                        }
                        $table.='</tr>';
                    }


                     //Sewing Balance
                    if ($Sewing_Balance == 1 || $All == 1)  {
                        $table.='<tr><td>Sewing Balance</td>';
                        for ($i = 0; $i < sizeof($week_code); $i++) {
                            $sewingBalanceQty=$sewingOutArray[$week_code[$i]]-$sewingInArray[$week_code[$i]];
                            $sew_bal[$i]=$sewingBalanceQty;
                            if ($sewingBalanceQty) {
                                $table.='<td>'.$sewingBalanceQty.'</td>';
                            } else {
                                $table.='<td>0</td>';
                            }
                        }
                        $table.='</tr>';
                    }

                    //No of days
                    if ($No_of_Days == 1 || $All == 1) {
                        $table.="<tr><td>No of Days</td>";
                        for ($i = 0; $i < sizeof($week_code); $i++) {
                            $today = date("Y-m-d");
                            $nodays[$i] = daysDifference($friday[$i], $today);
                            $table.="<td>" . ($nodays[$i]) . "</td>";
                        }
                        $table.="</tr>";
                    }

                    //Current Modules
                    if ($No_of_Days == 1 || $All == 1) {
                        $table.="<tr><td>Current Modules</td>";
                        for ($i = 0; $i < sizeof($week_code); $i++) {
                        $week_array1 = getStartAndEndDate($week_code[$i], $exfact_year[$i]);
                        $months_arra=getMonthsInRange($week_array1["week_start"],$week_array1["week_end"]);
                        $months_where_condition='';
                        foreach ($months_arra as $index => $monthyeararra) {
                            $months_where_condition.="'".$monthyeararra['month']."',";
                        }
                        $plannedQtyQuery="SELECT count(row_name) as module_count FROM $pps.`monthly_production_plan` WHERE product_code='".$style_code."' AND 
                        monthly_pp_up_log_id IN (SELECT monthly_pp_up_log_id FROM $pps.`monthly_production_plan_upload_log` WHERE month IN (".rtrim($months_where_condition, ',').") AND plant_code='".$plantcode."') 
                        AND planned_date BETWEEN '".$week_array1["week_start"]."' AND '".$week_array1["week_end"]."'";
                        $sql_result2 = mysqli_query($link, $plannedQtyQuery) or exit("Sql Error in planned Qty" . mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($sql_row2 = mysqli_fetch_array($sql_result2)) {
                            $modcount[$i]=$sql_row2['module_count'];
                        }
                        if ($modcount[$i]) {
                            $table.='<td>'.$modcount[$i].'</td>';
                        } else {
                            $table.='<td>0</td>';
                        }
                        }
                        $table.="</tr>";
                    }

                    //Required Target
                    if ($Required_Target == 1 || $All == 1) {
                        $table.="<tr><td>Required Target</td>";
                        for ($i = 0; $i < sizeof($week_code); $i++) {
                            if ($nodays[$i] > 0 && $modcount[$i] > 0) {
                                $req_tgt[$i] = round($sew_bal[$i] / (15 * $nodays[$i] * $modcount[$i]), 0);
                            } else {
                                $req_tgt[$i] = round($sew_bal[$i] / (15), 0);
                            }
                            if ($req_tgt[$i]) {
                                $table.='<td>'.$req_tgt[$i].'</td>';
                            } else {
                                $table.='<td>0</td>';
                            }
                        }
                        $table.="</tr>";
                    }

                    //Actual Reached
                    if ($Actual_Reached == 1 || $All == 1) {
                        $table.="<tr><td>Actual Reached</td>";
                        for ($i = 0; $i < sizeof($week_code); $i++) {

                            
                            if ($actualReachedQty) {
                                $table.='<td>'.$actualReachedQty.'</td>';
                            } else {
                                $table.='<td>0</td>';
                            }
                        }
                        $table.="</tr>";
                    }

                    //Days Required
                    if ($Days_Required == 1 || $All == 1) {
                        $table.="<tr><td>Days Required</td>";
                        for ($i = 0; $i < sizeof($week_code); $i++) {
                            if ($nodays[$i] == 0 || $req_tgt[$i] == 0) {
                                $days_req[$i] = 0;
                            } else {
                                $days_req[$i] = round($sew_bal[$i] / (15 * $nodays[$i] * $req_tgt[$i]), 0);
                            }  
                            if ($days_req[$i]) {
                                $table.='<td>'.$days_req[$i].'</td>';
                            } else {
                                $table.='<td>0</td>';
                            }
                        }
                        $table.="</tr>";
                    }

                    //Expected Comp. Date
                    if ($Expected_Comp_Date == 1 || $All == 1) {
                        $table.="<tr><td>Expected Comp. Date</td>";
                        for ($i = 0; $i < sizeof($week_code); $i++) {
                            $exp_comp[$i] = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + $days_req[$i], date("Y")));
                            if ($exp_comp[$i]) {
                                $table.='<td>'.$exp_comp[$i].'</td>';
                            } else {
                                $table.='<td>0</td>';
                            }
                        }
                        $table.="</tr>";
                    }

                }
                $table.='</table>';
                echo $table;
            }
            ?> 
		</div>
	</div>
</body>
</html>