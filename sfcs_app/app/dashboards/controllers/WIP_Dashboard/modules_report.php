<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/sections_report.php");
$has_permission=haspermission($url_r);
error_reporting(0);

    if($_GET['module'])
	{
	    $module=$_GET['module']; 
	}
	else
	{
	    $module=$_POST['module']; 
	}

	if($_GET['operation_code'])
	{
       $operation_code=$_GET['operation_code'];
	}
	else
	{
       $operation_code=$_POST['operation_code'];
	}	
	function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
	{
		$datetime1 = date_create($date_1);
		$datetime2 = date_create($date_2);
		$interval = date_diff($datetime1, $datetime2);
		return $interval->format($differenceFormat);
	}
?>

<script language=\"javascript\" type=\"text/javascript\" src=".getFullURL($_GET['r'],'common/js/dropdowntabs.js',4,'R')."></script>
<script type="text/javascript" src="../../common/js/tablefilter_1.js"></script>
<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
<script src="../../../../common/js/jquery.min.js"></script>
<script src="../../../../common/js/sweetalert.min.js"></script>

<style type="text/css">
    table, th, td {
        text-align: center;
    }
</style>

<?php
if(isset($_POST['submit']))
{
    $tid=array();   $selected_sewing_jobs = array();
    $tid=$_POST['log_tid'];
    $operation=$_POST['operation_code'];
     var_dump($tid);
    // echo $operation;
    // die();
    //To get Operation from Operation Routing For IPS
    $application='IPS';
    $scanning_query=" select * from $brandix_bts.tbl_ims_ops where appilication='$application'";
    //echo $scanning_query;
    $scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row=mysqli_fetch_array($scanning_result))
    {
        $ips_ops=$sql_row['operation_code'];
    }
    //To get Operation from Operation Routing For IMS
    $application_out='IMS';
    $scanning_query_ims=" select * from $brandix_bts.tbl_ims_ops where appilication='$application_out'";
    //echo $scanning_query;
    $scanning_result=mysqli_query($link, $scanning_query_ims)or exit("scanning_error123".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row123=mysqli_fetch_array($scanning_result))
    {
        $ims_ops=$sql_row123['operation_code'];
    }

    if (sizeof($tid) > 0)
    {
    	if($ims_ops==$operation || $ips_ops==$operation)
    	{
            $implode_tids = implode(",",$tid);
	        $get_ip_jobs_selected_tids = "SELECT DISTINCT input_job_rand_no_ref FROM $bai_pro3.`ims_log` WHERE pac_tid in ($implode_tids)";
	        // echo $get_ip_jobs_selected_tids;
	        $slected_ij_result = $link->query($get_ip_jobs_selected_tids);
	        while($row1 = $slected_ij_result->fetch_assoc()) 
	        {
	            $selected_sewing_jobs[] = $row1['input_job_rand_no_ref'];
	        }

	        $module= $_POST['module'];
	        $to_module= $_POST['module_ref'];

	        $validating_qry = "SELECT DISTINCT input_job_rand_no_ref FROM $bai_pro3.`ims_log` WHERE ims_mod_no = '$to_module'";
	        // echo $validating_qry;
	        $result_validating_qry = $link->query($validating_qry);
	        while($row = $result_validating_qry->fetch_assoc()) 
	        {
	            $input_job_array[] = $row['input_job_rand_no_ref'];
	        }

	        
	        $block_prio_qry = "SELECT block_priorities FROM $bai_pro3.`module_master` WHERE module_name='$to_module'";
	        $result_block_prio = $link->query($block_prio_qry);
	        while($sql_row = $result_block_prio->fetch_assoc()) 
	        {
	            $block_priorities = $sql_row['block_priorities'];
	        }

	        $allowable_jobs = $block_priorities-sizeof($input_job_array);

	        if(in_array($override_sewing_limitation,$has_permission))
	        { 
	            $flag = 1;
	        }
	        else
	        {
	            if (sizeof($selected_sewing_jobs) > $allowable_jobs)
	            {
	                echo "<script>sweetAlert('You are Not Authorized to report more than Block Priorities','','warning');</script>";
	                echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",2000); function Redirect() {  location.href = \"modules_report.php?module=$module&operation_code=$operation\"; }</script>";
	            }
	            else
	            {
	                $flag=1;
	            }
	        }            

	        if ($flag == 1)
	        {
	            foreach($tid as $selected)
	            {
	                $sql33="update $bai_pro3.ims_log set ims_mod_no = '$to_module' where pac_tid= '$selected'";
	                //echo $sql33;
	                $sql_result=mysqli_query($link, $sql33) or exit("Sql Error5123".mysqli_error($GLOBALS["___mysqli_ston"]));

	                $bund_update="update $brandix_bts.bundle_creation_data set assigned_module ='$to_module' where bundle_number=$selected ";
	                //echo $bund_update;
	                $sql_result1=mysqli_query($link, $bund_update) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"])); 

	                $sql="select send_qty,input_job_no,bundle_number from $brandix_bts.bundle_creation_data where bundle_number=$selected and operation_id=$operation"; 
	                //echo $sql."<br>";
	                $sql_result=mysqli_query($link, $sql) or exit("Sql Error455".mysqli_error($GLOBALS["___mysqli_ston"])); 
	                while($sql_row=mysqli_fetch_array($sql_result)) 
	                { 
	                   $sql331="insert into $brandix_bts.wip_dash_bund_track (bundle_number,input_module,transfer_module,quantity,job_no,operation_id) values (\"".$sql_row['bundle_number']."\",". $module.",". $to_module.",\"".$sql_row['send_qty']."\",\"".$sql_row['input_job_no']."\",".$operation.")";
	                    //echo $sql331;
	                    mysqli_query($link, $sql331) or exit("Sql Error_insert".mysqli_error($GLOBALS["___mysqli_ston"]));
	                } 
	            }
	            echo "<script>sweetAlert('Sewing Job Transfered Successfully','','success');</script>";
	            echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"modules_report.php?module=$module&operation_code=$operation\"; }</script>";
	        }
    	}
    	else
    	{
    		$implode_tids = implode(",",$tid);
            $module= $_POST['module'];
	        $to_module= $_POST['module_ref'];

            foreach($tid as $selected)
            {
               $bund_update="update $brandix_bts.bundle_creation_data set assigned_module ='$to_module' where bundle_number=$selected ";
                $sql_result1=mysqli_query($link, $bund_update) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"])); 

                $sql="select send_qty,input_job_no,bundle_number from $brandix_bts.bundle_creation_data where bundle_number=$selected and operation_id=$operation"; 
                //echo $sql."<br>";
                $sql_result=mysqli_query($link, $sql) or exit("Sql Error455".mysqli_error($GLOBALS["___mysqli_ston"])); 
                while($sql_row=mysqli_fetch_array($sql_result)) 
                { 
                    $sql331="insert into $brandix_bts.wip_dash_bund_track (bundle_number,input_module,transfer_module,quantity,job_no,operation_id) values (\"".$sql_row['bundle_number']."\",". $module.",". $to_module.",\"".$sql_row['send_qty']."\",\"".$sql_row['input_job_no']."\",".$operation.")";
                    //echo $sql331;
                    mysqli_query($link, $sql331) or exit("Sql Error_insert".mysqli_error($GLOBALS["___mysqli_ston"]));
                } 
            }
            echo "<script>sweetAlert('Sewing Job Transfered Successfully','','success');</script>";
            echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"modules_report.php?module=$module&operation_code=$operation\"; }</script>";

    	}	
        
    }
    else
    {
        echo "<script>sweetAlert('Please Select Atleast One Sewing Job','','warning');</script>";
        echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"modules_report.php?module=$module&operation_code=$operation\"; }</script>";
    }   
}    

?>

<div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-heading">Module - <?php echo $module; ?> Summary</div>
            <div class="panel-body">
            	<input id="excel" type="button"  class="btn btn-success" value="Export To Excel" onclick="getCSVData()">
                <form name="test" action="modules_report.php" class="form-inline" method="post">
                    <div style="overflow-x:auto;">
                    <table class="table table-bordered table-striped" id="table1">
                        <tr class="info">
                            <th>Select</th>
                               
	                            <th>Bundle Number</th>
	                            <th style="max-width: 80px">Input Date</th>
	                            <th>Style</th>
	                            <th>Schedule</th>
	                            <th style="min-width: 150px">Color</th>
	                            <th>Sewing<br>Job No</th>
	                            <th style="max-width: 30px">Cut No</th>
	                            <th>Size</th>
	                            <th>Previous Operation Quantity</th>
	                            <th>Current Operation (<?php echo $operation_code; ?>) Quantity</th>
	                            <th>Rejected</th>
	                            <th>Balance</th>
	                            <th>Input<br>Remarks</th>
	                            <th>Age</th>
	                            <th>WIP</th>
                        </container>
                        </tr>
                        <?php
                            $toggle=0;
                            //get styles data for particular operation
                            $get_bcd_data= "select distinct(schedule),style,color,bundle_number From $brandix_bts.bundle_creation_data where operation_id=$operation_code and assigned_module='$module' and bundle_qty_status=0";
					           // echo $get_bcd_data;
					            $result_get_bcd_data = $link->query($get_bcd_data);
					            while($row = $result_get_bcd_data->fetch_assoc())
					            {
					               $style = $row['style'];
					               $schedule = $row['schedule'];
					               $color = $row['color']; 
					               $bundle_number = $row['bundle_number']; 

					               //To get Previous Operation
					               $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$operation_code";
						           $result_ops_seq_check = $link->query($ops_seq_check);
						           while($row2 = $result_ops_seq_check->fetch_assoc()) 
						           {
							            $ops_seq = $row2['ops_sequence'];
							            $seq_id = $row2['id'];
							            $ops_order = $row2['operation_order'];
							       }

						           $pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = $ops_seq  AND CAST(operation_order AS CHAR) < '$ops_order' AND operation_code not in (10,200) ORDER BY LENGTH(operation_order) DESC LIMIT 1";
						            //echo $pre_ops_check;
						           $result_pre_ops_check = $link->query($pre_ops_check);
						           if($result_pre_ops_check->num_rows > 0)
						           {
							            while($row3 = $result_pre_ops_check->fetch_assoc()) 
							            {
							                $pre_ops_code = $row3['operation_code'];
							            }
						           }

						            $checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = '$pre_ops_code'";
							        $result_checking_qry = $link->query($checking_qry);
							        while($row_cat = $result_checking_qry->fetch_assoc()) 
							        {
							            $category_act = $row_cat['category'];
							        }
                                    if($category_act == 'sewing')
                                    {
                                       $get_jobs_data="select size_title,input_job_no,bundle_number,docket_number,remarks,DATE(MIN(date_time)) AS input_date,sum(if(operation_id = $pre_ops_code,recevied_qty,0)) as input,sum(if(operation_id = $operation_code,recevied_qty,0)) as output,SUM(if(operation_id = $operation_code,rejected_qty,0)) as rej_qty From $brandix_bts.bundle_creation_data where style='$style' and color='$color' and bundle_number = $bundle_number  GROUP BY bundle_number HAVING SUM(IF(operation_id = $pre_ops_code,recevied_qty,0)) != SUM(IF(operation_id = $operation_code,recevied_qty+rejected_qty,0))";
							            $result_get_jobs_data = $link->query($get_jobs_data);
							           // echo  $get_jobs_data;
							            while($row3 = $result_get_jobs_data->fetch_assoc()) 
							            {
	                                       $size = $row3['size_title'];
	                                      // $input_date = $row3['input_date'];
	                                       $job_no = $row3['input_job_no'];
	                                       $bundle = $row3['bundle_number'];
	                                       $docket_number = $row3['docket_number'];
	                                       $input_qty = $row3['input'];
	                                       $output_qty = $row3['output'];
	                                       $remarks = $row3['remarks'];

	                                        $display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$job_no,$link);

	                                        $sql22="SELECT plandoc_stat_log.order_tid, plandoc_stat_log.acutno, bai_orders_db_confirm.color_code FROM bai_pro3.plandoc_stat_log LEFT JOIN bai_pro3.bai_orders_db_confirm ON plandoc_stat_log.order_tid=bai_orders_db_confirm.order_tid where doc_no=$docket_number and a_plies>0";
		                                    // echo $sql22.'<br>';
		                                    $sql_result22=mysqli_query($link, $sql22) or exit("Sql Error2.4".mysqli_error($GLOBALS["___mysqli_ston"])); 
		                                    while($sql_row22=mysqli_fetch_array($sql_result22)) 
		                                    { 
		                                        $order_tid=$sql_row22['order_tid']; 
		                                        $cutno=$sql_row22['acutno']; 
		                                        $color_code=$sql_row22['color_code']; 
		                                    }

	                                       
	                                        //Previous operation qty check
	                                        $bundle_check_qty="select original_qty,recevied_qty from $brandix_bts.bundle_creation_data where bundle_number=$bundle and operation_id=$pre_ops_code";
		                                    $sql_result56=mysqli_query($link, $bundle_check_qty) or exit("Sql bundle_check_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
		                                    while($sql_row=mysqli_fetch_array($sql_result56))
		                                    {
		                                        $original_qty=$sql_row['original_qty'];
		                                        $recevied_qty=$sql_row['recevied_qty'];
		                                    }
											//Get date
											$bundle_check_qty1="select min(date(date_time)) as daten from $brandix_bts.bundle_creation_data where bundle_number=$bundle and operation_id=$operation_code";
		                                    $sql_result561=mysqli_query($link, $bundle_check_qty1) or exit("Sql bundle_check_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
		                                    while($sql_row1=mysqli_fetch_array($sql_result561))
		                                    {
		                                        $input_date=$sql_row1['daten'];
		                                    }

		                                    //Current operation qty check
		                                    $bundle_qty="select recevied_qty,rejected_qty from $brandix_bts.bundle_creation_data where bundle_number = $bundle and operation_id=$operation_code";
		                                    // echo $bundle_qty;
		                                    $sql_result561=mysqli_query($link, $bundle_qty) or exit("Sql bundle_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
		                                    while($sql_row1=mysqli_fetch_array($sql_result561))
		                                    {
		                                        $recevied_qty1=$sql_row1['recevied_qty'];
		                                        $rejected=$sql_row1['rejected_qty'];
		                                    }

		                                        echo "<tr>
	                                            <td>"; 
	                                                if($original_qty == $recevied_qty)   
	                                                { 
	                                                    if($recevied_qty1 == 0 && $rejected != $recevied_qty && $rejected == 0)
	                                                    {    
	                                                        echo "<input type=\"checkbox\" name=\"log_tid[]\"   value=\"".$bundle."\">"; 
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
	                                            $aging=dateDifference(date("Y-m-d"), $input_date);    
	                                            echo "</td>
	                                                <td>".$bundle."</td>
	                                                <td>".$input_date."</td>";
	                                            echo "<td>".$style."</td>
	                                                <td>".$schedule."</td>
	                                                <td>".$color."</td>
	                                                <td>".$display_prefix1."</td>
	                                                <td>".chr($color_code).leading_zeros($cutno,3)."</td>
	                                                <td>".$size."</td>
	                                                <td>".$input_qty."</td>
	                                                <td>".$output_qty."</td>
	                                                <td>".$rejected."</td>
	                                                <td>".($input_qty-($output_qty+$rejected))."</td>
	                                                <td>".$remarks."</td>
	                                                <td>".$aging."</td>
	                                                <td>".($input_qty-$output_qty)."</td>
	                                            </tr>"; 
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
                                $sqlx="select * from $bai_pro3.sections_db where sec_id>0 ";
                                $sql_resultx=mysqli_query($link, $sqlx) or exit("NO sections availabel");
                                $break_counter = 0;
                                while($sql_rowx=mysqli_fetch_array($sql_resultx))
                                {
                                    //$section_mods = [] ;
                                    $break_counter++;
                                    $section=$sql_rowx['sec_id'];
                                    $section_head=$sql_rowx['sec_head'];
                                    
									if($sql_rowx['sec_mods']!='')
									{
										 $section_mods[]=$sql_rowx['sec_mods']; 
									}
                                    
                                    $mods1 = implode(',',$section_mods);

                                    $get_operations="SELECT * FROM $brandix_bts.`tbl_orders_ops_ref` WHERE default_operation='yes' AND  (work_center_id IS NULL OR work_center_id='')";
                                    $sql_res=mysqli_query($link, $get_operations) or exit("workstation id error");
                                    while ($row2=mysqli_fetch_array($sql_res)) 
                                    {
                                        $short_key = $row2['short_cut_code'];
                                    }

                                    $work_station_module="select module from $bai_pro3.work_stations_mapping where module IN ($mods1) and operation_code = '$short_key'";
                                    $sql_result1=mysqli_query($link, $work_station_module) or exit("NO Modules availabel");
                                    while ($row1=mysqli_fetch_array($sql_result1))
                                    {
                                        if (!in_array($row1['module'], $work_mod))
                                        {
                                            $work_mod[]=$row1['module'];
                                        }
                                    }
								}
								sort($work_mod);
                                for($x=0;$x<sizeof($work_mod);$x++)
                                {
                                  echo "<option value=\"".$work_mod[$x]."\" >".$work_mod[$x]."</option>";
                                
                                }
                            ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php
                        if(in_array($authorized,$has_permission))
                        {
                            echo '<input type="submit" name="submit" class="btn btn-primary " value="Input Transfer"> 
                                <input type="hidden" value="'.$module.'" name="module"> 
                                <input type="hidden" value="'.$operation_code.'" name="operation_code">'; 
                        }
                    ?>
                </form>
            </div>
        </div>
        <span id='hiddenTable' style="display: none"></span>
    </div>

<script language="javascript" type="text/javascript">
	var copiedTable = document.getElementById('table1').innerHTML;
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


<script language="javascript">

function getCSVData() {

	// var copiedTable = document.getElementById('table1').innerHTML;
	$('#hiddenTable').html(copiedTable);
    // $('#hiddenTable').removeClass('setFilterGrid("table1", table2_Props)');
  	//$("#hiddenTable tbody tr:first-child").remove();
	$("#hiddenTable tbody tr").each(function()	{
		$(this).find("td:first").remove();
	    $(this).find("th:first").remove();
	});
	var printableTable = $('#hiddenTable tbody').html();		  
	console.log(printableTable);
  // $('table').attr('border', '1');
  // $('table').removeClass('table-bordered');
  
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  
    // var table = document.getElementById('table1').innerHTML;
    // console.log(table);
   // $('thead').css({"background-color": "blue"});
    var ctx = {worksheet: name || 'Module Report', table : printableTable}
    //window.location.href = uri + base64(format(template, ctx))
    var link = document.createElement("a");
    link.download = "Module Report.xls";
    link.href = uri + base64(format(template, ctx));
    link.click();

    // $('table').attr('border', '0');
    // $('table').addClass('table-bordered');
    //$('#hiddenTable').addClass('setFilterGrid("table1", table2_Props)');


	// $("table tr").each(function(){
	//    $(this).find("td:first").removeClass("hide");
	//    $(this).find("th:first").removeClass("hide");
	// });
   //  $("table tr").each(function(){
	  //  $(this).find("td:first").add();
	  //  $(this).find("th:first").add();
   // });
}
</script>

