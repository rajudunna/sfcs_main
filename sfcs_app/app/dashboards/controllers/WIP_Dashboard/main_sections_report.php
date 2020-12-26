<head>
	<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
	<title></title>
</head>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
error_reporting(0);

function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
	$datetime1 = date_create($date_1);
	$datetime2 = date_create($date_2);
	$interval = date_diff($datetime1, $datetime2);
	return $interval->format($differenceFormat);
}
?>

<html>

<head>
<title>Section Report</title>
<style>
	body{ font-family:calibri; }
</style>

<style>

a {text-decoration: none;}

.blue {
	background: #66DDAA;
}

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
<script src="../../../../common/js/jquery.min.js"></script>


</head>

<body>

<?php
$operation=$_GET['operations'];

?>

<?php
		
            echo "<div class='panel-body'>";
				$sql="SELECT GROUP_CONCAT(quote(`module_name`) ORDER BY module_name+0 ASC ) AS sec_mods, GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC ) AS sec_mod_val,section AS se_cid FROM $bai_pro3.`module_master` GROUP BY section ORDER BY section + 0";
				//echo  $sql;
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$sec_mods1[]=$sql_row['sec_mods'];
					$sec_mods[]=$sql_row['sec_mod_val'];
				}


				// $modules=array();
				//$modules=explode(",",$sec_mods);
				$modules=implode(",",$sec_mods);
				
				// die();
				echo "<div class='table-responsive'>";
				echo "<input id='excel' type='button'  class='btn btn-success' value='Export To Excel' onclick='getCSVData()'>";
						echo "<table class=\"table table-bordered\" id=\"table1\"> 
							<tr>
								<th>Module</th>
								<th>Bundle No</th>
								<th>Style</th>
								<th>Schedule</th>
								<th>Color</th>
								<th>Input Job No</th>
								<th>Cut No</th>
								<th>Size</th>
								<th>Previous Operation Quantity</th>
								<th>Current Operation ($operation) Quantity</th>
								<th>Rejected Qty</th>
								<th>Balance</th>
								<th>Remarks</th>
								<th>Age</th>
								<th>WIP</th>
							</tr>";
		$toggle=0;
		$j=1;

		$modules = explode(',', $modules);

		for($i=0; $i<sizeof($modules); $i++)
		{
			$module = $modules[$i];
			$rowcount_check=0;

			$get_bcd_data= "select distinct input_job_no_random_ref,schedule,style,color,GROUP_CONCAT(bundle_number) as bundle_number From $brandix_bts.bundle_creation_data where operation_id=$operation and assigned_module='$module'  and bundle_qty_status = 0 GROUP BY input_job_no_random_ref";
           // echo $get_bcd_data;
            $result_get_bcd_data = $link->query($get_bcd_data);
            while($row = $result_get_bcd_data->fetch_assoc())
            {	
			   $style = $row['style'];
               $schedule = $row['schedule'];
               $color = $row['color'];
               $job_no = $row['input_job_no_random_ref'];
               $bundles= $row['bundle_number'];

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

	            $checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = '$pre_ops_code'";
		        $result_checking_qry = $link->query($checking_qry);
		        while($row_cat = $result_checking_qry->fetch_assoc()) 
		        {
		            $category_act = $row_cat['category'];
		        }
		        if($category_act == 'sewing')
		        {
                   	$sql12="select sum(if(operation_id = $pre_ops_code,recevied_qty,0)) as input,sum(if(operation_id = $operation,recevied_qty,0)) as output, count(*) as count from $brandix_bts.bundle_creation_data where input_job_no_random_ref = '$job_no' and assigned_module='$module' GROUP BY bundle_number,operation_id";
					//echo $sql12;
					$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=0;
					$balance=0;
					while($sql_row12=mysqli_fetch_array($sql_result12))
					{
					  $balance=$balance+$sql_row12['input']-$sql_row12['output'];
					  $sql_num_check=$sql_num_check+1;
					}
					
					$rowcount_check=1;
	                $row_counter = 0;
	                $get_details="select docket_number,size_title,bundle_number,input_job_no,cut_number,remarks,sum(if(operation_id = $pre_ops_code,recevied_qty,0)) as input,DATE(MIN(date_time)) AS input_date,sum(if(operation_id = $operation,recevied_qty,0)) as output,SUM(if(operation_id = $operation,rejected_qty,0)) as rej_qty From $brandix_bts.bundle_creation_data where input_job_no_random_ref = '$job_no' and assigned_module='$module' GROUP BY bundle_number HAVING SUM(IF(operation_id = $pre_ops_code,recevied_qty,0)) != SUM(IF(operation_id = $operation,recevied_qty+rejected_qty,0))  order by schedule, size_id DESC";	
					//echo $get_details;
					$sql_result12=mysqli_query($link, $get_details) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
	                if(mysqli_num_rows($sql_result12) > 0){
						if($toggle==0)
						{
							// $tr_color="#66DDAA";
							$tr_color="blue";
							$toggle=1;
						} else if($toggle==1){
							$tr_color="white";
							$toggle=0;
						}
					}
					//echo  $get_details;
					while($row12=mysqli_fetch_array($sql_result12))
				    {
	                    $docket = $row12['docket_number'];
	                    $bundle_number=$row12['bundle_number'];
	                    $previous_ops_qty=$row12['input'];
	                    $current_ops_qty=$row12['output'];
	                    $sizes=$row12['size_title'];
	                    $job_no1 = $row12['input_job_no'];
	                    $cut_number = $row12['cut_number'];
	                    $remarks = $row12['remarks'];
						//$input_date = $row12['input_date'];
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

		                $get_rejected_qty="select sum(rejected_qty) as rejected,operation_id,size_title from $brandix_bts.bundle_creation_data where assigned_module='$module' and input_job_no_random_ref = '$job_no' and operation_id=$operation and size_title='$sizes' and bundle_number= $bundle_number group by operation_id,size_title";
		                //getting selection and apend result to query
						//echo  $get_rejected_qty;
						$sql_result33=mysqli_query($link, $get_rejected_qty) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row33=mysqli_fetch_array($sql_result33))
						{
							$rejected = $sql_row33['rejected'];
						}
						
						//Get date
						$bundle_check_qty1="select  min(date(date_time)) as daten from $brandix_bts.bundle_creation_data_temp where bundle_number=$bundle_number and operation_id=$pre_ops_code";
						$sql_result561=mysqli_query($link, $bundle_check_qty1) or exit("Sql bundle_check_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row1=mysqli_fetch_array($sql_result561))
						{
							$input_date=$sql_row1['daten'];
						}
					  $aging=dateDifference(date("Y-m-d"), $input_date); 
						if($rowcount_check==1)
						{	
							if($row_counter == 0)
								echo "<tr class=\"$tr_color\" class=\"new\">
								<td style='border-top:1.5pt solid #fff;'>$module</td>";
							else 
								echo "<tr class=\"$tr_color\"  class=\"new\"><td></td>";
							
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
							echo "<td>$rejected</td>";
		                          			
							echo "<td>".($previous_ops_qty-($current_ops_qty+$rejected))."</td>
							<td>$remarks</td><td>$aging</td>";
							//echo "<td>".($sql_row12['ims_qty']-($sql_row12['ims_pro_qty']))."</td>";
							
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
								echo "<tr class=\"$tr_color\"  class=\"new\"><td>$module</td>";
							else 
								echo "<tr class=\"$tr_color\"  class=\"new\"><td></td>";
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
							echo "<td>$rejected</td>";	                          			
							echo "<td>".($previous_ops_qty-($current_ops_qty+$rejected))."</td>
							<td>$remarks</td>";
							echo "<td>$aging</td>";
							//echo "<td>".($sql_row12['ims_qty']-($sql_row12['ims_pro_qty']))."</td>";
							//if($row_counter > 0)
								echo "<td class=\"$tr_color\" ></td>";
							
							echo "</tr>";
						}
							
							$j++;				
					}
		        }
			}
		}
	    echo "</table></div></div>";
	    // echo '<script type="text/javascript">getCSVData();</script>';
	    // echo"<script>alert(143);</script>";

	    

?>
<script language="javascript">

function getCSVData() {
	$('.blue').css("background-color", "#fff");	
	$('tr').css("border", "0.5pt solid black");	
  $('table').attr('border', '1');
  $('table').removeClass('table-bordered');
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  
    var table = document.getElementById('table1').innerHTML;
    // $('thead').css({"background-color": "blue"});
    var ctx = {worksheet: name || 'Sections Report', table : table}
    //window.location.href = uri + base64(format(template, ctx))
    var link = document.createElement("a");
    link.download = "Sections Report.xls";
    link.href = uri + base64(format(template, ctx));
    link.click();
    $('table').attr('border', '0');
    $('table').addClass('table-bordered');
    $('.blue').css("background-color", "#66DDAA");
    $('.blue').css("border", "0px solid black");
    // window.close ();	
}
</script>
</body>
</html>