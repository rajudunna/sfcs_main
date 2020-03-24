<head>
	<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
	<title></title>
</head>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');

?>
<head>
<title>Section Report</title>
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

</head>

<body>

<?php
	$section=$_GET['section'];
	$section_name=$_GET['section_name'];
	$operation=$_GET['operations'];
	// echo $operation;
	// die();
 
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
        //To get modules
		$sql="SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE module_master.status='active' and section=$section GROUP BY section ORDER BY section + 0";
		 //echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$sec_mods=$sql_row['sec_mods'];
		}


        $modules=array();
		$modules=explode(",",$sec_mods);
		//var_dump($modules);
		echo "<div class='table-responsive'>
				<table class=\"table table-bordered\">
					<tr>
						<th>Module</th>";
						echo $bundlenum_header;
						echo "<th>Style</th>
						<th>Schedule</th>
						<th>Color</th>
						<th>Input Job No</th>
						<th>Cut No</th>
						<th>Size</th>
						<th>Previous operation</th>
						<th>Current operation</th>
						<th>Rejected Qty</th>
						<th>Balance</th>
						<th>WIP</th>
					</tr>"; 
        $toggle=0;
		$j=1;
        //echo "byee";
		for($i=0; $i<sizeof($modules); $i++)
		{
			$module = $modules[$i];
            $rowcount_check=0;
            //echo $module."</br>";
            $get_bcd_data= "select distinct(schedule),style,color,input_job_no_random_ref From $brandix_bts.bundle_creation_data where operation_id=$operation and assigned_module='$module'";
            //echo $get_bcd_data;
            $result_get_bcd_data = $link->query($get_bcd_data);
            while($row = $result_get_bcd_data->fetch_assoc())
            {
               $style = $row['style'];
               $schedule = $row['schedule'];
               $color = $row['color'];
               $job_no = $row['input_job_no_random_ref'];

               //To get Previous Operation
               $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$operation";
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

	           $row_counter = 0;
               $total_previous_ops_qty = 0;
               $total_current_ops_qty = 0;
                $get_details="select docket_number,size_title,bundle_number,input_job_no,sum(if(operation_id = $pre_ops_code,recevied_qty,0)) as input,sum(if(operation_id = $operation,recevied_qty,0)) as output From $brandix_bts.bundle_creation_data where input_job_no_random_ref = '$job_no'";	

				if(isset($_POST['submit']))
				{
					$input_selection=$_POST['input_selection'];
					if($input_selection=='input_wise'){
						$get_details.=" GROUP BY input_job_no_random_ref,size_title HAVING SUM(IF(operation_id = $pre_ops_code,original_qty,0)) != SUM(IF(operation_id = $operation,recevied_qty,0))";
					}

					if($input_selection=='bundle_wise'){
						$get_details.=" GROUP BY bundle_number HAVING SUM(IF(operation_id = $pre_ops_code,original_qty,0)) != SUM(IF(operation_id = $operation,recevied_qty,0))";
					}
				}else{
					$get_details.=" GROUP BY bundle_number HAVING SUM(IF(operation_id = $pre_ops_code,original_qty,0)) != SUM(IF(operation_id = $operation,recevied_qty,0))";
				}  
				$get_details.="  order by schedule, size_id DESC";
				//echo $get_details;
				$sql_result12=mysqli_query($link, $get_details) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row12=mysqli_fetch_array($sql_result12))
			    {
                    $docket = $row12['docket_number'];
                    $bundle_number=$row12['bundle_number'];
                    $previous_ops_qty=$row12['input'];
                    $current_ops_qty=$row12['output'];
                    $sizes=$row12['size_title'];
                    $job_no1 = $row12['input_job_no'];
                    $total_previous_ops_qty = $total_previous_ops_qty+$row12['input'];
                    $total_current_ops_qty =  $total_current_ops_qty+$row12['output'];

                     $display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$job_no1,$link);


					$sql22="select * from $bai_pro3.plandoc_stat_log where doc_no=$docket and a_plies>0";
					//echo $sql22;
					$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					while($sql_row22=mysqli_fetch_array($sql_result22))
					{
						$order_tid=$sql_row22['order_tid'];
						
						$sql33="select color_code,order_date from $bai_pro3.bai_orders_db_confirm where order_tid='$order_tid'";
						$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row33=mysqli_fetch_array($sql_result33))
						{
							$color_code=$sql_row33['color_code']; //Color Code
							$ex_factory=$sql_row33['order_date'];
						}
					}

					$rejected1=array();
					$rejected=array();
	                $get_rejected_qty="select sum(rejected_qty) as rejected,operation_id,size_title from $brandix_bts.bundle_creation_data where assigned_module='$module' and input_job_no_random_ref = '$job_no' and operation_id=$operation";
	                //getting selection and apend result to query
					if(isset($_POST['submit']))
					{
						$input_selection=$_POST['input_selection'];
						if($input_selection=='input_wise'){
							$get_rejected_qty.=" GROUP BY input_job_no_random_ref,size_title,operation_id ";
						}

						if($input_selection=='bundle_wise'){
							$get_rejected_qty.=" and bundle_number= $bundle_number group by operation_id,size_title";
						}
					}else{
						$get_rejected_qty.=" and bundle_number= $bundle_number group by operation_id,size_title";
					}
					//echo  $get_rejected_qty;
					$sql_result33=mysqli_query($link, $get_rejected_qty) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row33=mysqli_fetch_array($sql_result33))
					{
						$size_title[] = $sql_row33['size_title'];
						$rejected1[$sql_row33['size_title']][$sql_row33['operation_id']] = $sql_row33['rejected'];
						// if($sql_row33['operation_id'] == $output_code)
						// {
						//  $rejected = $sql_row33['rejected'];
					 //    }
					}

					if($rowcount_check==1)
					{	
						if($row_counter == 0)
							echo "<tr bgcolor=\"$tr_color\" class=\"new\">
							<td style='border-top:1.5pt solid #fff;'>$module</td>";
						else 
							echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td style='border-top:0px'></td>";
						
						// if($new_module == $old_module)
						//     echo "<td></td>";
						
						if(isset($_POST['submit']))
						{
							$input_selection=$_POST['input_selection'];
							if($input_selection=='bundle_wise'){
								echo "<td>$bundle_number</td>";
							}
						}else{
							echo "<td>$bundle_number</td>";
						}
						
						echo "<td>$style</td>
						<td>$schedule</td>
						<td>$color</td>
						<td>".$display_prefix1."</td>
						<td>".chr($color_code).leading_zeros($cut_number,3)."</td>
						<td>$sizes</td>
						<td>$previous_ops_qty</td>
						<td>$current_ops_qty</td>";
					
						foreach ($size_title as $key => $value) 
						{
							if($rejected1[$size_title][$value] == '')
								echo "<td>0</td>";
							else    
								echo"<td>".$rejected1[$size_title][$value]."</td>";
						}  
	                          			
						echo "<td>".($previous_ops_qty-($current_ops_qty))."</td>";
						// $total_previous_ops_qty = $total_previous_ops_qty+$row12['input'];
	     //                $total_current_ops_qty =  $total_current_ops_qty+$row12['output'];
	                    $balance=$total_previous_ops_qty -  $total_current_ops_qty;
						if($rowcount_check==1)
						{
							echo "<td style='border-top:1.5pt solid #fff;'>$balance</td>";
						}
						$rowcount_check=0;
						$row_counter++;
						echo "</tr>";
					}
					else
					{	
						if($row_counter == 0)
							echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td>$module</td>";
						else 
							echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td style='border-top:1px solid $tr_color;border-bottom:1px solid $tr_color;'></td>";
						$row_counter++;
					
						if(isset($_POST['submit']))
						{
							$input_selection=$_POST['input_selection'];
							if($input_selection=='bundle_wise'){
								echo "<td>$bundle_number</td>";
								echo "<td>$style</td>";
							}
							if($input_selection=='input_wise'){
								echo "<td>$style</td>";
							}
						}else{
							echo "<td>$bundle_number</td>";
							echo "<td>$style</td>";
						}
						echo"<td>$schedule</td>
						<td>$color</td>
						<td>".$display_prefix1."</td>
						<td>".chr($color_code).leading_zeros($cut_number,3)."</td>
						<td>$sizes</td>
						<td>$previous_ops_qty</td>
						<td>$current_ops_qty</td>";
						foreach ($size_title as $key => $value) 
						{
							if($rejected1[$size_title][$value] == '')
								echo "<td>0</td>";
							else    
								echo"<td>".$rejected1[$size_title][$value]."</td>";
						}  
						echo "<td>".($previous_ops_qty-($current_ops_qty))."</td>";
						// echo "<td bgcolor='$tr_color' style='border-top:1px solid $tr_color;border-bottom:1px solid $tr_color;'></td>";
						
						echo "</tr>";
					}
					
					$j++;
                } 
            }	
		}	
		
	    echo "</table></div></div>";

?>
</body>

