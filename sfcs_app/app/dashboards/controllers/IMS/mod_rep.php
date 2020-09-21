
<?php 
    error_reporting(0);
    ini_set('display_errors', 'On');
    set_time_limit(6000); 

 ?>   

<?php  

    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_dashboard.php');
    include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
    include('imsCalls.php');
    $php_self = explode('/',$_SERVER['PHP_SELF']);
    array_pop($php_self);
    $url_r = base64_encode(implode('/',$php_self)."/sec_rep.php");
    $has_permission=haspermission($url_r);
    $user_name = getrbac_user()['uname'];
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
    <?php
        // if(isset($_POST['submit']))
        // {
        //     $tid=array();   $selected_sewing_jobs = array();
        //     $tid=$_POST['log_tid'];

        //     if (sizeof($tid) > 0)
        //     {
        //         $implode_tids = implode(",",$tid);
        //         $get_ip_jobs_selected_tids = "SELECT DISTINCT input_job_rand_no_ref FROM $bai_pro3.`ims_log` WHERE tid in ($implode_tids)";
        //         // echo $get_ip_jobs_selected_tids;
        //         $slected_ij_result = $link->query($get_ip_jobs_selected_tids);
        //         while($row1 = $slected_ij_result->fetch_assoc()) 
        //         {
        //             $selected_sewing_jobs[] = $row1['input_job_rand_no_ref'];
        //         }

        //         $module= $_POST['module'];
        //         // $tid1=array();
        //         // $tid1=$_POST['pac_tid'];
        //         $to_module= $_POST['module_ref'];

        //         $validating_qry = "SELECT DISTINCT input_job_rand_no_ref FROM $bai_pro3.`ims_log` WHERE ims_mod_no = '$to_module'";
        //         // echo $validating_qry;
        //         $result_validating_qry = $link->query($validating_qry);
        //         while($row = $result_validating_qry->fetch_assoc()) 
        //         {
        //             $input_job_array[] = $row['input_job_rand_no_ref'];
        //         }

                
        //         $block_prio_qry = "SELECT block_priorities FROM $bai_pro3.`module_master` WHERE module_name='$to_module'";
        //         $result_block_prio = $link->query($block_prio_qry);
        //         while($sql_row = $result_block_prio->fetch_assoc()) 
        //         {
        //             $block_priorities = $sql_row['block_priorities'];
        //         }

        //         $allowable_jobs = $block_priorities-sizeof($input_job_array);
        //         // echo 'selected size = '.sizeof($selected_sewing_jobs).' allowable = '.$allowable_jobs.' block Priorities = '.$block_priorities.' already inputs in module = '.sizeof($input_job_array) ;
        //         if(in_array($override_sewing_limitation,$has_permission))
        //         { 
        //             $flag = 1;
        //         }
        //         else
        //         {
        //             if (sizeof($selected_sewing_jobs) > $allowable_jobs)
        //             {
        //                 echo "<script>sweetAlert('You are Not Authorized to report more than Block Priorities','','warning');</script>";
        //                 echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",2000); function Redirect() {  location.href = \"mod_rep.php?module=$module\"; }</script>";
        //             }
        //             else
        //             {
        //                 $flag=1;
        //             }
        //         }            

        //         if ($flag == 1)
        //         {
        //             $transfer_query="insert into $brandix_bts.input_transfer(user,input_module,transfer_module,bundles) values ('$user_name',".$module.",".$to_module.",".sizeof($tid).")";
        //             $sql_result0=mysqli_query($link, $transfer_query) or exit("Sql Error5.0".mysqli_error($GLOBALS["___mysqli_ston"])); 
        //             $insert_id=mysqli_insert_id($link);
        //             foreach($tid as $selected)
        //             {
        //                 $sql33="update $bai_pro3.ims_log set ims_mod_no = '$to_module' where tid= '$selected'";
        //                 //echo $sql33;
        //                 $sql_result=mysqli_query($link, $sql33) or exit("Sql Error5123".mysqli_error($GLOBALS["___mysqli_ston"]));


        //                 $sql_ims="select pac_tid from bai_pro3.ims_log where tid='$selected'"; 
        //                 $sql_result123=mysqli_query($link, $sql_ims) or exit("Sql Error_ims".mysqli_error($GLOBALS["___mysqli_ston"]));
        //                 while($sql_rowx=mysqli_fetch_array($sql_result123))  
        //                 { 
        //                     $pac_tid=$sql_rowx['pac_tid'];
        //                 }

        //                 $bund_update="update $brandix_bts.bundle_creation_data set assigned_module ='$to_module' where bundle_number='$pac_tid'";
        //                 $sql_result1=mysqli_query($link, $bund_update) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"])); 
                        
		// 				//commented in #2391
        //                 //$bund_update="update $brandix_bts.bundle_creation_data_temp set assigned_module ='$to_module' where bundle_number='$pac_tid'";
        //                 //$sql_result1=mysqli_query($link, $bund_update) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"])); 

        //                 $sql="select  ims_mod_no, ims_qty,input_job_no_ref,pac_tid from $bai_pro3.ims_log where tid='$selected'"; 
        //                 //echo $sql."<br>";
        //                 $sql_result=mysqli_query($link, $sql) or exit("Sql Error455".mysqli_error($GLOBALS["___mysqli_ston"])); 
        //                 while($sql_row=mysqli_fetch_array($sql_result)) 
        //                 { 
        //                     $sql331="insert into $brandix_bts.module_bundle_track (ref_no,bundle_number,module,quantity,job_no) values (".$insert_id.",\"".$sql_row['pac_tid']."\",". $to_module.",  \"".$sql_row['ims_qty']."\",\"".$sql_row['input_job_no_ref']."\" )";
        //                     //echo $sql331;
        //                     mysqli_query($link, $sql331) or exit("Sql Error_insert".mysqli_error($GLOBALS["___mysqli_ston"]));
        //                 } 
        //             }
        //             echo "<script>sweetAlert('Sewing Job Transfered Successfully','','success');</script>";
        //             echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"mod_rep.php?module=$module\"; }</script>";
        //         }
        //     }
        //     else
        //     {
        //         echo "<script>sweetAlert('Please Select Atleast One Sewing Job','','warning');</script>";
        //         echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"mod_rep.php?module=$module\"; }</script>";
        //     }   
        // }
    ?>    
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
                                        $barcodesQry = "select barcode_id from $pts.barcode where external_ref_id = '".$bundleRow['jm_job_bundle_id']."' and barcode_type='PSLB' and plant_code='$plantCode' AND is_active=1";
                                        $barcodeResult=mysqli_query($link_new, $barcodesQry) or exit("Barcodes not found".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while($barcodeRow=mysqli_fetch_array($barcodeResult))
                                        {   
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
                                                        echo "<input type=\"checkbox\" name=\"log_tid[]\"   value=\"".$sql_row12['tid']."\">"; 
                                                    }
                                                    else 
                                                    { 
                                                        echo "N/A"; 
                                                    } 
                                                //echo '<input type="hidden" value="'.$pac_tid.'" name="pac_tid[]">'; 
                                            echo "</td>
                                                <td>".$bundleRow['bundle_number']."</td>
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
                             $workstationsResult=getWorkstations($departmentType,$plantCode);
                             $workStations=$workstationsResult['workstation'];
                             var_dump($workStations);
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

                            echo '<input type="submit" name="submit" class="btn btn-primary " value="Input Transfer"> 
                                <input type="hidden" value="'.$module.'" name="module"> 
                                <input type="hidden" value="'.$section_id.'" name="section_id">'; 
                    ?>
                </form>
            </div>
        </div>
    </div>

    <br/>

</body>

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