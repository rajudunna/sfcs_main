
<?php 
    error_reporting(0);
    ini_set('display_errors', 'On');
    set_time_limit(6000); 

 ?>   

<?php  
    include('imsCalls.php');
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/server_urls.php');
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_dashboard.php');
    include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');

    $php_self = explode('/',$_SERVER['PHP_SELF']);
    array_pop($php_self);
    $url_r = base64_encode(implode('/',$php_self)."/sec_rep.php");
    $has_permission=haspermission($url_r);
    $user_name = $_SESSION['userName'];;
    error_reporting(0);
    $plantCode=$_SESSION['plantCode'];
    $ref_no=time();
    //echo $ref_no;

    if($_GET['module'])
    {
        $module=$_GET['module']; 
    }
    else
    {
        $module=$_POST['module']; 
    }

    /**
     * getting setion name wrt section id
     */
    $qryMoudleName="SELECT workstation_description FROM $pms.`workstation` WHERE workstation_id ='$module'";
    $MoudleName_result=mysqli_query($link_new, $qryMoudleName) or exit("Problem in getting section".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($MoudleName_row=mysqli_fetch_array($MoudleName_result))
    {
        $workstation_description=$MoudleName_row['workstation_description'];
    }

    if($_GET['section_id'])
    {
        $section_id=$_GET['section_id'];
    }
    else
    {
        $section_id=$_POST['section_id']; 
    }
?> 
  
<head>
    <title>Module Transfer Panel</title> 
    <script src="../../../../common/js/jquery1.min.js"></script>
    <script src="/sfcs_app/common/js/jquery-ui.js"></script>
    <script language=\"javascript\" type=\"text/javascript\" src=".getFullURL($_GET['r'],'common/js/dropdowntabs.js',4,'R')."></script>
    <script type="text/javascript" src="../../common/js/tablefilter_1.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
    <script src="../../../../common/js/sweetalert.min.js"></script>
   

    <style type="text/css">
        table, th, td {
            text-align: center;
        }
    </style>
</head> 

<body>   
    <br>
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-heading">Module - <?php echo $workstation_description; ?> Summary</div>
            <div class="panel-body">
                <form name="test" action="mod_rep.php" class="form-inline" method="post">
                    <div style="overflow-x:auto;">
                    <table class="table table-bordered table-striped" id="table1">
                        <tr class="info">
                            <th>Select</th>
                            <th>Barcode</th>
                            <th style="max-width: 80px">Input Date</th>
                            <!-- <th>Exp. to Comp.</th> -->
                            <th>Style</th>
                            <th>Schedule</th>
                            <th style="min-width: 150px">Color</th>
                            <th>Sewing<br>Job No</th>
                            <th style="max-width: 30px">Cut No</th>
                            <th>Size</th>
                            <th>Input</th>
                            <th>Output</th>
                            <th>Rejected</th>
                            <th>Balance</th>
                            <th>Input<br>Remarks</th>
                            <th>Age</th>
                            <th>WIP</th>
                        </tr>
                        <?php
                            $toggle=0; 
                            $bundles_new=array();
                            $input_qty=array();

                            $jobsArray = getJobsForWorkstationIdTypeSewing($plantCode,$module);
                            if(sizeof($jobsArray)>0)
                            {
                                if($toggle==0) 
                                { 
                                    $tr_color="#66DDAA"; 
                                    $toggle=1; 
                                } 
                                else if($toggle==1) 
                                { 
                                    $tr_color="white"; 
                                    $toggle=0; 
                                } 
                                  
                                foreach($jobsArray as $job)     
					            {  
                                    $flag++;
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
                                    while($bundleRow=mysqli_fetch_array($bundlesResult))
                                    {
                                        // echo $bundleRow['bundle_number']."</br>";
                                        // echo $bundleRow['size']."</br>";
                                        // echo $bundleRow['fg_color']."</br>";
                                        // echo $bundleRow['quantity']."</br>";
                                        // Call pts barcode table
                                        $barcodesQry = "select barcode_id,barcode from $pts.barcode where external_ref_id = '".$bundleRow['jm_job_bundle_id']."' and barcode_type='PSLB' and plant_code='$plantCode' AND is_active=1";
                                        $barcodeResult=mysqli_query($link_new, $barcodesQry) or exit("Barcodes not found".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while($barcodeRow=mysqli_fetch_array($barcodeResult))
                                        {   
                                            $Original_barcode=$barcodeRow['barcode'];
                                            $qrygetParentBarcodePPLB="SELECT parent_barcode FROM $pts.parent_barcode WHERE child_barcode='".$barcodeRow['barcode_id']."' AND parent_barcode_type='PPLB' AND plant_code='$plantCode' AND is_active=1";
                                            $barcodePPLBResult=mysqli_query($link_new, $qrygetParentBarcodePPLB) or exit("PPLB Barcodes not found".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            while($PPLBRow=mysqli_fetch_array($barcodePPLBResult))
                                            {
                                                $parent_barcode=$PPLBRow['parent_barcode'];
                                            }

                                            $child_barcode[]=$APLBRow['child_barcode'];
                                            $child_barcode=array();
                                            $qrygetParentBarcodeAPLB="SELECT child_barcode FROM $pts.parent_barcode WHERE parent_barcode='$parent_barcode' AND child_barcode_type='APLB' AND plant_code='$plantCode' AND is_active=1";
                                            $barcodeAPLBResult=mysqli_query($link_new, $qrygetParentBarcodeAPLB) or exit("PPLB Barcodes not found".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            while($APLBRow=mysqli_fetch_array($barcodeAPLBResult))
                                            {
                                                $child_barcode[]=$APLBRow['child_barcode'];
                                            }


                                            $transactionsQry = "select sum(good_quantity) as good_quantity,sum(rejected_quantity) as rejected_quantity,operation,DATE(created_at) as input_date,DATEDIFF(NOW(), created_at) AS days from $pts.transaction_log where barcode_id IN ('".implode("','" , $child_barcode)."') GROUP BY operation";
                                            $transactionsResult=mysqli_query($link_new, $transactionsQry) or exit("Transactions not found".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            while($transactionRow=mysqli_fetch_array($transactionsResult)) {
                                                // echo $transactionRow['good_quantity']."</br>";
                                                // echo $transactionRow['rejected_quantity']."</br>";
                                                // echo "Bundle Ops : ".$transactionRow['operation']."</br>";
                                                
                                                /** getting input and out put based on operations*/
                                                if($minOperation==$transactionRow['operation']){
                                                    $inputQty=$transactionRow['good_quantity'];
                                                    $input_date=$transactionRow['input_date'];
                                                    $aging=$transactionRow['days'];
                                                }
                                                if($maxOperation==$transactionRow['operation']){
                                                    $outputQty=$transactionRow['good_quantity'];
                                                    /**rejected qty for output */
                                                    $outputRejQty=$transactionRow['rejected_quantity'];
                                                } 
                                            }
                                        }

                                        echo "<tr>
                                                <td>"; 
                                                 
                                                    if($inputQty==0)
                                                    {    
                                                        echo "<input type=\"checkbox\" name=\"log_tid[]\"   value=\"".$Original_barcode."\">"; 
                                                    }
                                                    else 
                                                    { 
                                                        echo "N/A"; 
                                                    } 
                                                //echo '<input type="hidden" value="'.$pac_tid.'" name="pac_tid[]">'; 
                                            echo "</td>
                                                <td>".$Original_barcode."</td>
                                                <td>".$input_date."</td>";
                                            echo "<td>".$style."</td>
                                                <td>".$schedule."</td>
                                                <td>".$color."</td>
                                                <td>".$sewingjobno."</td>
                                                <td>".$cutjobno."</td>
                                                <td>".strtoupper($bundleRow['size'])."</td>
                                                <td>".$inputQty."</td>
                                                <td>".$outputQty."</td>
                                                <td>".$outputRejQty."</td>
                                                <td>".($inputQty-($outputQty+$outputRejQty))."</td>
                                                <td>".$remarks."</td>
                                                <td>".$aging."</td>
                                                <td>".($inputQty-($outputQty+$outputRejQty))."</td>
                                        </tr>";
                                        
                                        $inputQty=0;
                                        $outputQty=0;
                                        $outputRejQty=0;
                                    }
 
                                }
                                
                            } 
                                
                        ?>
                    </table>
                    </div>
                    <br>

                    <label>Select Module:</label> 
                    <select class='form-control' name="module_ref"  id='module_ref' required>
                        <option value=''>Please Select</option>
                            <?php
                             $departmentType = DepartmentTypeEnum::SEWING;
                             /**getting workstations based plant and department*/
                             $workstationsResult=getWorkstations($departmentType,$plantCode,$module);
                             $workStations=$workstationsResult['workstation'];
                                // for($x=0;$x<sizeof($work_mod);$x++)
                                foreach($workStations as $key=>$value)
                                {
                                  echo "<option value=\"".$key."\" >".$value."</option>";
                                  //$module=$mods[$x];
                                }
                            ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php
                           
                            // echo "&nbsp;<input  title='click to transfer the input' type='radio' name = 'option' Id='option' value='input_transfer'> Input Transfer";

                            echo '<input type="button" name="submit" id="submit" class="btn btn-primary " value="Input Transfer"> 
                                <input type="hidden" value="'.$module.'" name="module"> 
                                <input type="hidden" value="'.$section_id.'" name="section_id">
                                <input type="hidden" value="'.$plant_code.'" name="plant_code">
                                <input type="hidden" value="'.$user_name.'" name="plant_code">'; 
                    ?>
                </form>
            </div>
        </div>
    </div>

    <br/>

</body>


<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
    
<script>
$(document).ready(function(){
       $('body').on('click','#submit',function(){
        var bundles=[];
            $('input[type=checkbox]').each(function (){
                if(this.checked){
                    //console.log($(this).val());
                    bundles.push($(this).val())

                }
            });
            var module = '<?= $module?>';
                const data={
                                "bundleNumber": bundles,
                                "plantCode": '<?= $plantCode ?>',
                                "resourceId": '<?= $module ?>',
                                "createdUser": '<?= $user_name ?>'
                            }
                $.ajax({
                    type: "POST",
                    url: "<?php echo $PPS_SERVER_IP?>/jobs-generation/transferBundlesToWorkStation",
                    data: data,
                    success: function (res) {
                        if(res.status)
                        {
                            swal('','Sewing Job Transfered Successfully','success')
                            setTimeout(function(){window.location.replace("mod_rep.php?module="+module)} , 3000);
                            
                        }
                        else
                        {
                            swal('',res.internalMessage,'error');
                            setTimeout(function(){window.location.replace("mod_rep.php?module="+module)} , 3000);
                        }                       
                        //$('#loading-image').hide();
                    },
                    error: function(res){
                        swal('Error in getting data');
                        setTimeout(function(){window.location.replace("mod_rep.php?module="+module)} , 3000);
                        //$('#loading-image').hide();
                    }
                });
   });

});
</script>
<script language="javascript" type="text/javascript">
    var table2_Props =  {            
        display_all_text: "All",
        col_0: "none",
        col_1: "none",
        col_2: "none",
        col_3: "select",
        col_4: "select", 
        col_5: "select",
        col_6: "select",
        col_7: "select",
        col_8: "select",
        col_9: "none",
        col_10: "none",
        col_11: "select",
        col_12: "none",
        col_13: "none",
        col_14: "none",
        col_15: "none",
        sort_select: true,
        paging: true,  
        paging_length: 100, 
        rows_counter: true,  
        rows_counter_text: "Displaying Rows:",  
        btn_reset: true,
        btn_reset_text: 'Reset Filter', 
        loader: true,  
        loader_text: "Filtering data..."
    };
    setFilterGrid( "table1", table2_Props);
</script>