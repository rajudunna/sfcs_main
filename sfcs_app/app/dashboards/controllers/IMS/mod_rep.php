
<?php 
    error_reporting(0);
    ini_set('display_errors', 'On');
    set_time_limit(6000); 

    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
    include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
    $php_self = explode('/',$_SERVER['PHP_SELF']);
    array_pop($php_self);
    $url_r = base64_encode(implode('/',$php_self)."/sec_rep.php");
    $has_permission=haspermission($url_r);

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
    <br>
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-heading">Module - <?php echo $module; ?> Summary</div>
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
                            </tr>
                            <?php
                                $toggle=0; 
                                $sql="select distinct rand_track,ims_size,ims_schedule,ims_style,ims_color,ims_remarks,input_job_rand_no_ref,pac_tid,tid from $bai_pro3.ims_log where ims_mod_no='$module' and ims_doc_no in (select doc_no from bai_pro3.plandoc_stat_log) order by tid";
                                $sql_result=mysqli_query($link, $sql) or exit("Sql Error2.1");
                                while($sql_row=mysqli_fetch_array($sql_result)) 
                                { 
                                    $rand_track=$sql_row['rand_track'];
                                    $ims_size=$sql_row['ims_size'];
                                    $ims_size2=substr($ims_size,2);
                                    $title_size='title_size_'.$size_code;
                                    $input_job_rand_no_ref=$sql_row['input_job_rand_no_ref'];
                                    $ims_style=$sql_row['ims_style'];
                                    $ims_schedule=$sql_row['ims_schedule'];
                                    $ims_color=$sql_row['ims_color'];
                                    $ims_remarks=$sql_row['ims_remarks'];
                                    $pac_tid=$sql_row['pac_tid']; 
                                    $tid=$sql_row['tid'];


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
                                     
                                    // $req_date=""; 
                                    // $sql12="select req_date from $bai_pro3.ims_exceptions where ims_rand_track=$rand_track"; 
                                    // $sql_result12=mysqli_query($link, $sql12) or exit("Sql Error2.2".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    // while($sql_row12=mysqli_fetch_array($sql_result12)) 
                                    // { 
                                    //     $req_date=$sql_row12['req_date']; 
                                    // } 
                                     
                                    $sql12="select * from $bai_pro3.ims_log where ims_mod_no='$module' and tid=$tid and ims_status<>\"DONE\" and ims_remarks='$ims_remarks' and ims_size='$ims_size'  order by ims_schedule, ims_size DESC";
                                    $sql_result12=mysqli_query($link, $sql12) or exit("Sql Error2.3".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row12=mysqli_fetch_array($sql_result12)) 
                                    { 
                                        $flag++;
                                        $ims_doc_no=$sql_row12['ims_doc_no']; 
                                        $ims_size=$sql_row12['ims_size'];
                                        $ims_size2=substr($ims_size,2);
                                        $display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$sql_row12['ims_schedule'],$sql_row12['ims_color'],$sql_row12['input_job_no_ref'],$link);
                                        // $inputjobno=$sql_row12['input_job_no_ref'];
                                                        
                                        $sql22="SELECT plandoc_stat_log.order_tid, plandoc_stat_log.acutno, bai_orders_db_confirm.color_code FROM bai_pro3.plandoc_stat_log LEFT JOIN bai_pro3.bai_orders_db_confirm ON plandoc_stat_log.order_tid=bai_orders_db_confirm.order_tid where doc_no=$ims_doc_no and a_plies>0";
                                        // echo $sql22.'<br>';
                                        $sql_result22=mysqli_query($link, $sql22) or exit("Sql Error2.4".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                        while($sql_row22=mysqli_fetch_array($sql_result22)) 
                                        { 
                                            $order_tid=$sql_row22['order_tid']; 
                                            $cutno=$sql_row22['acutno']; 
                                            $color_code=$sql_row22['color_code']; 
                                        } 
                             
                                        $size_value=ims_sizes($order_tid,$ims_schedule,$ims_style,$ims_color,$ims_size2,$link);

                            
                                        $sql33="select COALESCE(SUM(IF(qms_tran_type=3,qms_qty,0)),0) AS rejected from $bai_pro3.bai_qms_db where qms_schedule=".$ims_schedule." and qms_color=\"".$ims_color."\" and input_job_no='$input_job_rand_no_ref' and qms_style=\"".$ims_style."\" and qms_remarks=\"".$sql_row['ims_remarks']."\" and qms_size=\"".strtoupper($size_value)."\" and operation_id=130 and bundle_no=$sql_row12['pac_tid']";  
                                        //echo $sql33;  
                                        $sql_result33=mysqli_query($link, $sql33) or exit("Sql Error888".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while($sql_row33=mysqli_fetch_array($sql_result33))
                                        {
                                            $rejected=0;
                                            $rejected=$sql_row33['rejected']; 
                                        }

                                        //To get Operation from Operation Routing For IPS
                                        $application='IPS';
                                        $scanning_query=" select * from $brandix_bts.tbl_ims_ops where appilication='$application'";
                                        //echo $scanning_query;
                                        $scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while($sql_row=mysqli_fetch_array($scanning_result))
                                        {
                                            $operation_name=$sql_row['operation_name'];
                                            $operation_code=$sql_row['operation_code'];
                                        } 

                                        $bundle_check_qty="select * from $brandix_bts.bundle_creation_data where bundle_number=$pac_tid and operation_id=$operation_code";
                                        $sql_result56=mysqli_query($link, $bundle_check_qty) or exit("Sql bundle_check_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while($sql_row=mysqli_fetch_array($sql_result56))
                                        {
                                            $original_qty=$sql_row['original_qty'];
                                            $recevied_qty=$sql_row['recevied_qty'];
                                        }

                                        //To get Operation from Operation Routing For Line Out
                                        $application_out='IMS';
                                        $scanning_query_ims=" select * from $brandix_bts.tbl_ims_ops where appilication='$application_out'";
                                        //echo $scanning_query;
                                        $scanning_result=mysqli_query($link, $scanning_query_ims)or exit("scanning_error123".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while($sql_row123=mysqli_fetch_array($scanning_result))
                                        {
                                            $operation_name1=$sql_row123['operation_name'];
                                            $operation_code1=$sql_row123['operation_code'];
                                        } 

                                        $bundle_qty="select * from $brandix_bts.bundle_creation_data where bundle_number=$pac_tid and operation_id=$operation_code1";
                                        // echo $bundle_qty;
                                        $sql_result561=mysqli_query($link, $bundle_qty) or exit("Sql bundle_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        while($sql_row1=mysqli_fetch_array($sql_result561))
                                        {
                                            $original_qty1=$sql_row1['original_qty'];
                                            $recevied_qty1=$sql_row1['recevied_qty'];
                                        }
                                        // echo $recevied_qty1;
                                         
                                         
                                        echo "<tr>
                                                <td>"; 
                                                    if($original_qty == $recevied_qty and $sql_row12['ims_pro_qty']==0 )   
                                                    { 
                                                        if($recevied_qty1 == 0)
                                                        {    
                                                            echo "<input type=\"checkbox\" name=\"log_tid[]\"   value=\"".$sql_row12['tid']."\">"; 
                                                        }
                                                        else 
                                                        { 
                                                            echo "N/A"; 
                                                        } 
                                                    } 
                                                    else 
                                                    { 
                                                        echo "N/A"; 
                                                    }
                                                    // echo '<input type="hidden" value="'.$pac_tid.'" name="pac_tid[]">'; 
                                             
                                                echo "</td>
                                                    <td>".$pac_tid."</td>
                                                    <td>".$sql_row12['ims_date']."</td>";
                                                // <td>$req_date</td>
                                                echo "<td>".$sql_row12['ims_style']."</td>
                                                    <td>".$sql_row12['ims_schedule']."</td>
                                                    <td>".$sql_row12['ims_color']."</td>
                                                    <td>".$display_prefix1."</td>
                                                    <td>".chr($color_code).leading_zeros($cutno,3)."</td>
                                                    <td>".strtoupper($size_value)."</td>
                                                    <td>".$sql_row12['ims_qty']."</td>
                                                    <td>".$sql_row12['ims_pro_qty']."</td>
                                                    <td>".$rejected."</td>
                                                    <td>".($sql_row12['ims_qty']-($sql_row12['ims_pro_qty']+$rejected))."</td>
                                                    <td>".$sql_row12['ims_remarks']."</td>
                                            </tr>"; 
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
                                $sqlx="select * from $bai_pro3.sections_db where sec_id>0 ";
                                $sql_resultx=mysqli_query($link, $sqlx) or exit("NO sections availabel");
                                $break_counter = 0;
                                while($sql_rowx=mysqli_fetch_array($sql_resultx))
                                {
                                    $break_counter++;
                                    $section=$sql_rowx['sec_id'];
                                    $section_head=$sql_rowx['sec_head'];
                                    $section_mods=$sql_rowx['sec_mods']; 

                                    $mods=array();
                                    $mods=explode(",",$section_mods);

                                    for($x=0;$x<sizeof($mods);$x++)
                                    {
                                        echo "<option value=\"".$mods[$x]."\" >".$mods[$x]."</option>";
                                        //$module=$mods[$x];
                                    }
                                }
                            ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php
                        if(in_array($authorized,$has_permission))
                        { 
                            // echo "&nbsp;<input  title='click to transfer the input' type='radio' name = 'option' Id='option' value='input_transfer'> Input Transfer";

                            echo '<input type="submit" name="submit" class="btn btn-primary " value="Input Transfer"> 
                                <input type="hidden" value="'.$module.'" name="module"> 
                                <input type="hidden" value="'.$section_id.'" name="section_id">'; 
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>

    <br/>

</body>
<?php
    if(isset($_POST['submit']))
    {
        $tid=array();   $selected_sewing_jobs = array();
        $tid=$_POST['log_tid'];

        if (sizeof($tid) > 0)
        {
            $implode_tids = implode(",",$tid);
            $get_ip_jobs_selected_tids = "SELECT DISTINCT input_job_rand_no_ref FROM $bai_pro3.`ims_log` WHERE tid in ($implode_tids)";
            $slected_ij_result = $link->query($get_ip_jobs_selected_tids);
            while($row1 = $slected_ij_result->fetch_assoc()) 
            {
                $selected_sewing_jobs[] = $row1['input_job_rand_no_ref'];
            }

            $module= $_POST['module'];
            // $tid1=array();
            // $tid1=$_POST['pac_tid'];
            $to_module= $_POST['module_ref'];

            $validating_qry = "SELECT DISTINCT input_job_rand_no_ref FROM $bai_pro3.`ims_log` WHERE ims_mod_no = '$to_module'";
            $result_validating_qry = $link->query($validating_qry);
            while($row = $result_validating_qry->fetch_assoc()) 
            {
                $input_job_array[] = $row['input_job_rand_no_ref'];
            }
            
            $allowable_jobs = $ims_boxes_count-sizeof($input_job_array);

            if(in_array($authorized,$has_permission))
            { 
                $flag++;
                $ims_doc_no=$sql_row12['ims_doc_no']; 
                $ims_size=$sql_row12['ims_size'];
                $ims_size2=substr($ims_size,2);
                $display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$sql_row12['ims_schedule'],$sql_row12['ims_color'],$sql_row12['input_job_no_ref'],$link);
                $sql22="select * from $bai_pro3.plandoc_stat_log where doc_no=$ims_doc_no and a_plies>0"; 
                $sql_result22=mysqli_query($link, $sql22) or exit("Sql Error2.4".mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                while($sql_row22=mysqli_fetch_array($sql_result22)) 
                { 
                    $order_tid=$sql_row22['order_tid']; 
                    $cutno=$sql_row22['acutno']; 
                } 
     
                 $size_value=ims_sizes($order_tid,$ims_schedule,$ims_style,$ims_color,$ims_size2,$link);

    
                 $sql33="select COALESCE(SUM(IF(qms_tran_type=3,qms_qty,0)),0) AS rejected from $bai_pro3.bai_qms_db where qms_schedule=$ims_schedule and qms_color='$ims_color' and input_job_no='$input_job_rand_no_ref' and qms_style='$ims_style' and qms_remarks='".$sql_row['ims_remarks']."' and qms_size='".strtoupper($size_value)."' and operation_id=130 and bundle_no=".$sql_row12['pac_tid'];  
                 //echo $sql33;  
                  $sql_result33=mysqli_query($link, $sql33) or exit("Sql Error888".mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($sql_row33=mysqli_fetch_array($sql_result33))
                  {
                    $rejected=0;
                    $rejected=$sql_row33['rejected']; 
                  }

                  //To get Operation from Operation Routing For IPS
                  $application='IPS';
                  $scanning_query=" select * from $brandix_bts.tbl_ims_ops where appilication='$application'";
                  //echo $scanning_query;
                  $scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($sql_row=mysqli_fetch_array($scanning_result))
                  {
                    $operation_name=$sql_row['operation_name'];
                    $operation_code=$sql_row['operation_code'];
                  } 

                   $bundle_check_qty="select * from $brandix_bts.bundle_creation_data where bundle_number=$pac_tid and operation_id=".$operation_code;
                   $sql_result56=mysqli_query($link, $bundle_check_qty) or exit("Sql bundle_check_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
                      while($sql_row=mysqli_fetch_array($sql_result56))
                      {
                        $original_qty=$sql_row['original_qty'];
                        $recevied_qty=$sql_row['recevied_qty'];
                      }


                      //To get Operation from Operation Routing For Line Out
                      $application_out='IMS';
                      $scanning_query_ims=" select * from $brandix_bts.tbl_ims_ops where appilication='$application_out'";
                      //echo $scanning_query;
                      $scanning_result=mysqli_query($link, $scanning_query_ims)or exit("scanning_error123".mysqli_error($GLOBALS["___mysqli_ston"]));
                      while($sql_row123=mysqli_fetch_array($scanning_result))
                      {
                        $operation_name1=$sql_row123['operation_name'];
                        $operation_code1=$sql_row123['operation_code'];
                      } 

                       $bundle_qty="select * from $brandix_bts.bundle_creation_data where bundle_number=$pac_tid and operation_id=".$operation_code1;
                       // echo $bundle_qty;
                       $sql_result561=mysqli_query($link, $bundle_qty) or exit("Sql bundle_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
                          while($sql_row1=mysqli_fetch_array($sql_result561))
                          {
                            $original_qty1=$sql_row1['original_qty'];
                            $recevied_qty1=$sql_row1['recevied_qty'];
                          }
                         // echo $recevied_qty1;
                 
                 
                echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td>"; 
                 
                if($original_qty == $recevied_qty and $sql_row12['ims_pro_qty']==0 )   
                { 
                    if($recevied_qty1 == 0)
                    {    
                      echo "<input type=\"checkbox\" name=\"log_tid[]\"   value=\"".$sql_row12['tid']."\">"; 
                    }
                    else
                    {
                        $flag=1;
                    }
                }
                else
                {
                    echo "<script>sweetAlert('Module Full','','warning');</script>";
                    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"mod_rep.php?module=$module\"; }</script>";
                }
            }            

            if ($flag == 1)
            {
                $transfer_query="insert into $brandix_bts.input_transfer(user,input_module,transfer_module,bundles) values (USER(),".$module.",".$to_module.",".sizeof($tid).")";
                $sql_result0=mysqli_query($link, $transfer_query) or exit("Sql Error5.0".mysqli_error($GLOBALS["___mysqli_ston"])); 
                $insert_id=mysqli_insert_id($link);
                foreach($tid as $selected)
                {
                    $sql33="update $bai_pro3.ims_log set ims_mod_no = '$to_module' where tid= '$selected'";
                    //echo $sql33;
                    $sql_result=mysqli_query($link, $sql33) or exit("Sql Error5123".mysqli_error($GLOBALS["___mysqli_ston"]));


                    $sql_ims="select pac_tid from bai_pro3.ims_log where tid='$selected'"; 
                    $sql_result123=mysqli_query($link, $sql_ims) or exit("Sql Error_ims".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($sql_rowx=mysqli_fetch_array($sql_result123))  
                    { 
                        $pac_tid=$sql_rowx['pac_tid'];
                    }

                    $bund_update="update $brandix_bts.bundle_creation_data set assigned_module ='$to_module' where bundle_number='$pac_tid'";
                    $sql_result1=mysqli_query($link, $bund_update) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"])); 

                    $bund_update="update $brandix_bts.bundle_creation_data_temp set assigned_module ='$to_module' where bundle_number='$pac_tid'";
                    $sql_result1=mysqli_query($link, $bund_update) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"])); 

                    $sql="select  ims_mod_no, ims_qty,input_job_no_ref,pac_tid from $bai_pro3.ims_log where tid='$selected'"; 
                    //echo $sql."<br>";

                    $sql_result=mysqli_query($link, $sql) or exit("Sql Error455".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    while($sql_row=mysqli_fetch_array($sql_result)) 
                    { 
                        $sql331="insert into $brandix_bts.module_bundle_track (ref_no,bundle_number,module,quantity,job_no) values (".$insert_id.",\"".$sql_row['pac_tid']."\",". $to_module.",  \"".$sql_row['ims_qty']."\",\"".$sql_row['input_job_no_ref']."\" )";
                        //echo $sql331;

                        mysqli_query($link, $sql331) or exit("Sql Error_insert".mysqli_error($GLOBALS["___mysqli_ston"]));
                        //echo $sql33; 
                    } 
                }
                echo "<script>sweetAlert('Sewing Job Transfered Successfully','','success');</script>";
                echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"mod_rep.php?module=$module\"; }</script>";
            }
        }
        else
        {
            echo "<script>sweetAlert('Please Select Atleast One Sewing Job','','warning');</script>";
            echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"mod_rep.php?module=$module\"; }</script>";
        }   
    }
?>

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
        col_11: "none",
        col_12: "none",
        col_13: "none",
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