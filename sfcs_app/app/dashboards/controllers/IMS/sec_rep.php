<head>
    <link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
    <title></title>
</head>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_dashboard.php');
include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/sec_rep.php");
$has_permission=haspermission($url_r);
?>
<?php
//To find time days difference between two dates

function dateDiff($start, $end) {

$start_ts = strtotime($start);

$end_ts = strtotime($end);

$diff = $end_ts - $start_ts;

return round($diff / 86400);

}

// function dateDiffsql($link,$start,$end)
// {
//     $plantcode=$_SESSION['plantCode'];
//     include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
//     $sql="select distinct bac_date from $pts.bai_log_buf where plant_code='$plantcode' and bac_date<='$start' and bac_date>='$end'";
//     $sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
    
//     return mysqli_num_rows($sql_result);
// }

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Section IMS Report</title>
<style>
    body{ font-family:calibri; }
</style>

<style>

a {text-decoration: none;}

.atip
{
    color:black;
}

table
{
    border-collapse:collapse;
}
.new td
{
    border: 1px solid #337ab7;
    white-space:nowrap;
    border-collapse:collapse;
}

.new th
{
    border: 1px solid #337ab7;
    white-space:nowrap;
    border-collapse:collapse;
}

.bottom
{
    border-bottom: 3px solid white;
    padding-bottom: 5px;
    padding-top: 5px;
}

.panel-heading
{
    text-align:center;
    border-bottom: 3px solid black;
}


select{
    margin-top: 16px;
    margin-right: 5px;
}

.panel-primary{
    margin-right: -50px;
}

</style>

<script type="text/javascript" src="../../../../common/js/jquery.js"></script> 

<script>

function update_comm(x)
{
    var valu=document.getElementById("M"+x).innerHTML;
    document.getElementById("M"+x).style.display="none";
    document.getElementById("I"+x).style.display="";
    document.getElementById("I"+x).innerHTML="<input type='text' value='"+valu+"' id='"+x+"' onblur='update_fin("+x+");' style='border:none; background-color: yellow; width:100%'>";
    document.getElementById(x).focus();
}

function update_fin(x)
{
    var val=document.getElementById(x).value;
    document.getElementById("I"+x).style.display="none";
    document.getElementById("M"+x).style.display="";
    document.getElementById("M"+x).innerHTML="<img src='saving.gif'>";
    
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var result=xmlhttp.responseText;
            if(result!=0)
            {
                document.getElementById("M"+x).innerHTML="<font color='red'>Failed</font>";             
            }
        }
    }

    xmlhttp.open("GET","ajax_save.php?tid="+x+"&val="+val+"&rand="+Math.random(),true);
    xmlhttp.send();
    document.getElementById("M"+x).innerHTML=val;
    if(val != 'Update Comments')
    {
        document.getElementById("M"+x).removeAttribute("style");
    }
}

</script>

</head>

<body>


<?php

//To update onscreen comments update
if(isset($_GET['val']))
{
    $tid=$_GET['tid'];
    $val=$_GET['val'];
    return 0;
}

?>

<?php 
        include('imsCalls.php');
        if(isset($_POST['submit']))
        {
            $input_selection=$_POST['input_selection'];
            if($input_selection=='bundle_wise'){
                $bundlenum_header="<th rowspan=2>Bundle No</th>";
                $report_header="BundleWise";
            }else{
                $bundlenum_header="";
                $report_header="Sewing Job Wise";
            }
            
        }
        else
        {
            $bundlenum_header="<th rowspan=2>Bundle No</th>";
            $report_header="BundleWise";
        }

        $section=$_GET['section'];
        $plantCode=$_GET['plantCode'];
        /**
         * getting setion name wrt section id
         */
        $qrySectionName="SELECT section_name FROM $pms.`sections` WHERE section_id='$section'";
        $qrySectionName_result=mysqli_query($link_new, $qrySectionName) or exit("Problem in getting section".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($SectionName_row=mysqli_fetch_array($qrySectionName_result))
        {
            $section_name=$SectionName_row['section_name'];
        }
        echo "<div class='panel panel-primary'>
                <div class='panel-heading'>Summary of <b>" .$section_name." ( ".$report_header." )</b>
                </div>
                </br>
                <table>
                    <tr>
                        <th>Select Your Choice : </th>
                        <td>
                            <div class='form-inline'>
                                <form method='post'>
                                    <select name='input_selection' id='input_selection' class=\"form-control\">
                                        <option value='bundle_wise' selected>Bundle Wise</option>
                                        <option value='input_wise'>Sewing Job Wise</option>
                                    </select>
                            </div></div>
                        </td>";
                        echo '
                        <td>.
                            <input type="submit" id="submit" class="btn btn-primary" name="submit" value="Submit" />
                        </td>
                    </tr>
                </table>';
        echo "</form>";

        echo "<div class='panel-body'>";
            /**
             * getting Operations plant wise
             */
            $SwingOperationsArray=getOperationsTypeSewing($plantCode);
            
            $col_span = count($SwingOperationsArray);
			$modules=array();
			$modules=explode(",",$sec_mods);
			echo "<div class='table-responsive'>
				<table class=\"table table-bordered\">
					<tr>
						<th rowspan=2>Module</th>";
						echo $bundlenum_header;
						echo "<th rowspan=2>Style</th>
						<th rowspan=2>Schedule</th>
						<th rowspan=2>Color</th>
						<th rowspan=2>Input Job No</th>
						<th rowspan=2>Cut No</th>
						<th rowspan=2>Size</th>
						<th rowspan=2>Input</th>
						<th rowspan=2>Output</th>
						<th colspan=$col_span style=text-align:center>Rejected Qty</th>
						<th rowspan=2>Balance</th>
						<th rowspan=2>Input Remarks</th>
						<th rowspan=2>Ex-Factory</th>
						<th width='150'  rowspan=2>Remarks</th>
						<th rowspan=2>Age</th>
						<th rowspan=2>WIP</th>
					</tr>
					<tr>";             
						foreach ($SwingOperationsArray as $op_code) 
						{
							if(strlen($op_code['operation_name']) > 0)
							{
								echo "<th>".$op_code['operation_name']."</th>";
							}
						}
			echo "</tr>";
			/**
			 * get workstations for plant code and section id
			*/
            $workstationsArray=getWorkstationsForSectionId($plantCode, $section);
			foreach($workstationsArray as $workStation)
			{   
                $module_ref=$workStation['workstationCode'];
				$jobsArray = getJobsForWorkstationIdTypeSewing($plantCode,$workStation['workstationId']);
				if(sizeof($jobsArray)>0)
				{
					$taskRefArray = [];
					foreach($jobsArray as $job)     
					{ 
                        //array_push($taskRefArray, $job['taskJobRef']);
                        //$taskRefArray = implode("','", $taskRefArray);
                        /**
                         * getting min and max operations
                         */
                        $qrytoGetMinOperation="SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id='".$job['taskJobId']."' AND plant_code='$plantCode' AND is_active=1 ORDER BY operation_seq ASC LIMIT 0,1";
                        $minOperationResult = mysqli_query($link_new,$qrytoGetMinOperation) or exit('Problem in getting operations data for job');
                        if(mysqli_num_rows($minOperationResult)>0){
                            while($minOperationResultRow = mysqli_fetch_array($minOperationResult)){
                                $minOperation=$minOperationResultRow['operation_code'];
                            }
                        }
                        
                        /**
                         * getting min and max operations
                         */
                        $qrytoGetMaxOperation="SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id='".$job['taskJobId']."' AND plant_code='$plantCode' AND is_active=1 ORDER BY operation_seq DESC LIMIT 0,1";
                        $maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting operations data for job');
                        if(mysqli_num_rows($maxOperationResult)>0){
                            while($maxOperationResultRow = mysqli_fetch_array($maxOperationResult)){
                                $maxOperation=$maxOperationResultRow['operation_code'];
                            }
                        }

                        
                        /**getting style,colr attributes using taskjob id */
                        $job_detail_attributes = [];
                        $qry_toget_style_sch = "SELECT * FROM $tms.task_attributes where task_jobs_id='".$job['taskJobId']."' and plant_code='$plantCode'";
                        $qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
                            $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
                        }
                            $style = $job_detail_attributes[$sewing_job_attributes['style']];
                            $schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
                            $color = $job_detail_attributes[$sewing_job_attributes['color']];
                            $sewingjobno = $job_detail_attributes[$sewing_job_attributes['sewingjobno']];
                            $cutjobno = $job_detail_attributes[$sewing_job_attributes['cutjobno']];
                            $remarks = $job_detail_attributes[$sewing_job_attributes['remarks']];

                        $bundlesQry = "select jm_job_bundle_id,bundle_number,size,fg_color,quantity from $pps.jm_job_bundles where jm_jg_header_id ='".$job['taskJobRef']."'";
                        $bundlesResult=mysqli_query($link_new, $bundlesQry) or exit("Bundles not found".mysqli_error($GLOBALS["___mysqli_ston"]));

                        if(isset($_POST['submit']))
                        {
                            $input_selection=$_POST['input_selection'];
                            if($input_selection=='input_wise'){
                            $bundlesQry.=" GROUP BY jm_jg_header_id";
                            }
                            if($input_selection=='bundle_wise'){
                                $bundlesQry.=" GROUP BY jm_job_bundle_id";
                            }
                        }
                        else
                        {
                            $bundlesQry.=" GROUP BY jm_job_bundle_id";
                        }

                        while($bundleRow=mysqli_fetch_array($bundlesResult))
                        {
                            // echo $bundleRow['bundle_number']."</br>";
                            // echo $bundleRow['size']."</br>";
                            // echo $bundleRow['fg_color']."</br>";
                            // echo $bundleRow['quantity']."</br>";
                            // Call pts barcode table
                            $barcodesQry = "select barcode_id from $pts.barcode where external_ref_id = '".$bundleRow['jm_job_bundle_id']."' and barcode_type='APLB'";
                            $barcodeResult=mysqli_query($link_new, $barcodesQry) or exit("Barcodes not found".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($barcodeRow=mysqli_fetch_array($barcodeResult))
                            {
                                $transactionsQry = "select sum(good_quantity) as good_quantity,sum(rejected_quantity) as rejected_quantity,operation from $pts.transaction_log where barcode_id ='".$barcodeRow['barcode_id']."'";
                                $transactionsResult=mysqli_query($link_new, $transactionsQry) or exit("Transactions not found".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $rejQtyOps=array();
                                while($transactionRow=mysqli_fetch_array($transactionsResult)) {
                                    // echo $transactionRow['good_quantity']."</br>";
                                    // echo $transactionRow['rejected_quantity']."</br>";
                                    // echo "Bundle Ops : ".$transactionRow['operation']."</br>";
                                    
                                    /** getting input and out put based on operations*/
                                    if($minOperation==$transactionRow['operation']){
                                        $inputQty=$transactionRow['good_quantity'];
                                    }
                                    if($maxOperation==$transactionRow['operation']){
                                        $outputQty=$transactionRow['good_quantity'];
                                        /**rejected qty for output */
                                        $outputRejQty=$transactionRow['rejected_quantity'];
                                    }
                                    $rejQtyOps[$transactionRow['operation']] = $transactionRow['rejected_quantity'];   
                                }
                            }

                            $quality_log_row="";
                            $quality_log_row="<td>Exfactorydate</td>";
                            if($rowcount_check==1)
                            {
                                if($row_counter == 0)
                                        echo "<tr bgcolor=\"$tr_color\" class=\"new\">
                                        <td style='border-top:1.5pt solid #fff;'>$module_ref</td>";
                                    else 
                                        echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td style='border-top:0px'></td>";

                                        if(isset($_POST['submit']))
                                        {
                                            $input_selection=$_POST['input_selection'];
                                            if($input_selection=='bundle_wise'){
                                                echo "<td>".$bundleRow['bundle_number']."</td>";
                                            }
                                        }else{
                                            echo "<td>".$bundleRow['bundle_number']."</td>";
                                        }
                                        echo "<td>$style</td>
                                        <td>$schedule</td>
                                        <td>$color</td>
                                        <td>".$sewingjobno."</td>
                                        <td>".$cutjobno."</td>
                                        <td>".$bundleRow['size']."</td>
                                        <td>".$inputQty."</td>
                                        <td>".$outputQty."</td>";
                                        echo "<td>ops1</td><td>ops2</td><td>ops3</td><td>ops4</td>";
                                        foreach ($SwingOperationsArray as $operations) 
						                {
                                            if(strlen($operations) > 0){
                                                if($rejQtyOps[$operations['operation_code']] == '')
                                                    echo "<td>0</td>";
                                                else    
                                                    echo"<td>".$rejQtyOps[$operations['operation_code']]."</td>";
                                            }
                                        }
                                        echo "<td>".($inputQty-($outputQty+$outputRejQty))."</td>";
                                        echo "<td>".$remarks."</td>";
                                        echo $quality_log_row;
                                        // if(in_array($edit,$has_permission))
                                        // {
                                        //     if(strlen($team_comm)>0)
                                        //     {
                                        //         echo '<td><span id="I'.$tid.'"></span><span id="M'.$tid.'" onclick="update_comm('.$tid.')">'.$team_comm.'</span></td><td>'.dateDiffsql($link,date("Y-m-d"),$ims_date).'</td>';
                                        //     }
                                        //     else
                                        //     {
                                        //         echo '<td><span id="I'.$tid.'"></span><span style="color:'.$tr_color.'" id="M'.$tid.'" onclick="update_comm('.$tid.')">Update Comments</span></td><td>'.dateDiffsql($link,date("Y-m-d"),$ims_date).'</td>';
                                        //     }
                                        // }
                                        // else
                                        {
                                            echo "<td>".$remarks."</td><td>Age for bundle</td>";
                                        }
                                        if($rowcount_check==1)
                                        {
                                            echo "<td style='border-top:1.5pt solid #fff;'>$balance</td>";
                                        }
                                        $rowcount_check=0;
                                        $row_counter++;
                                        echo "</tr>";
                                        
                            }else{
                                if($row_counter == 0)
                                    echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td>$module_ref</td>";
                                else 
                                    echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td style='border-top:1px solid $tr_color;border-bottom:1px solid $tr_color;'></td>";
                                    
                                    if(isset($_POST['submit']))
                                    {
                                        $input_selection=$_POST['input_selection'];
                                        if($input_selection=='bundle_wise'){
                                            echo "<td>".$bundleRow['bundle_number']."</td>";
                                        }
                                    }else{
                                        echo "<td>".$bundleRow['bundle_number']."</td>";
                                    }
                                    echo "<td>$style</td>
                                    <td>$schedule</td>
                                    <td>$color</td>
                                    <td>".$sewingjobno."</td>
                                    <td>".chr($color_code).leading_zeros($cut_number,3)."</td>
                                    <td>".$bundleRow['size']."</td>
                                    <td>".$inputQty."</td>
                                    <td>".$outputQty."</td>";
                                    echo "<td>ops1</td><td>ops2</td><td>ops3</td><td>ops4</td>";
                                    foreach ($SwingOperationsArray as $operations) 
                                    {
                                        if(strlen($operations) > 0){
                                            if($rejQtyOps[$operations['operation_code']] == '')
                                                echo "<td>0</td>";
                                            else    
                                                echo"<td>".$rejQtyOps[$operations['operation_code']]."</td>";
                                        }
                                    }
                                    echo "<td>".($inputQty-($outputQty+$outputRejQty))."</td>";
                                    echo "<td>".$remarks."</td>";
                                    echo $quality_log_row;
                                    // if(in_array($edit,$has_permission))
                                    // {
                                    //     if(strlen($team_comm)>0)
                                    //     {
                                    //         echo '<td><span id="I'.$tid.'"></span><span id="M'.$tid.'" onclick="update_comm('.$tid.')">'.$team_comm.'</span></td><td>'.dateDiffsql($link,date("Y-m-d"),$ims_date).'</td>';
                                    //     }
                                    //     else
                                    //     {
                                    //         echo '<td><span id="I'.$tid.'"></span><span style="color:'.$tr_color.'" id="M'.$tid.'" onclick="update_comm('.$tid.')">Update Comments</span></td><td>'.dateDiffsql($link,date("Y-m-d"),$ims_date).'</td>';
                                    //     }						
                                    // }
                                    // else
                                    {
                                        echo "<td>".$remarks."</td><td>Age for bundle</td>";
                                    }
                                    //if($row_counter > 0)
                                    echo "<td bgcolor='$tr_color' style='border-top:1px solid $tr_color;border-bottom:1px solid $tr_color;'></td>";
                                    echo "</tr>";
                            }
                        }
					}
					
				}  
			}
			echo "</table></div></div>";
?>


</body>
</html>