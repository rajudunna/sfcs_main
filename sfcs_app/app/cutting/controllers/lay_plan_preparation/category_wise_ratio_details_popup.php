<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/php/functions.php',4,'R'));
      include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));


if(isset($_GET['order_tid']))
{
$order_tid=order_tid_decode($_GET['order_tid']);
$cat_ref=$_GET['cat_ref'];
$cat_desc=$_GET['cat_desc'];
$mk_status=$_GET['mk_status'];
$sizes_reference=$_GET['sizes_reference'];
$sizes_reference_array=explode(",",$sizes_reference);
$sql_data='select * from '.$bai_pro3.'.allocate_stat_log where order_tid="'.$order_tid.'" and cat_ref="'.$cat_ref.'" and recut_lay_plan="no"';//echo $sql_data;
$sql_result_data=mysqli_query($link, $sql_data) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
 $table_details = "<div class=\"table-responsive\"><table class=\"table table-bordered\"><thead><tr><th class=\"column-title\"><center>Ratio</center></th><th class=\"column-title\"><center>Category</center></th><th class=\"column-title\"><center>Total Plies</center></th><th class=\"column-title\"><center>Max Plies/Cut</center></th>";
foreach ($sizes_reference_array as $key => $value) {
	$table_details .="<th class=\"column-title\"><center>".$value."</center></th>";
}
$table_details .="<th class=\"column-title\"><center>Ratio Total</center></th><th class=\"column-title\"><center>Current Status</center></th><th class=\"column-title\"><center>Remarks</center></th></tr></thead><tbody>";
while($sql_row=mysqli_fetch_array($sql_result_data))
{
   $table_details .="<tr>
   					<td class=\"  \"><center>".$sql_row['ratio']."</center></td>
   					<td class=\"  \"><center>".$cat_desc."</center></td>
   					<td class=\"  \"><center>".$sql_row['plies']."</td><td class=\"  \"><center>".$sql_row['pliespercut']."</center></td>";
   					$tot=0;
   					for($i=0;$i<sizeof($sizes_reference_array);$i++) {
                      $value = str_pad($i,2,"0",STR_PAD_LEFT);
                      $query_alloc="allocate_s".$value;
                      //echo $query_alloc;
	                  $table_details .="<th class=\"column-title\"><center>".$sql_row[$query_alloc]."</center></th>";
	                  $tot+=$sql_row["allocate_s".$sizes_code[$s].""];
                    }
   					$table_details .="<td class=\"  \"><center>".$tot."</center></td>";
				   		switch ($mk_status)
						{
							case 1:
							{
								$table_details .= "<td class=\"  \"><center>NEW</center></td>";
								break;
							}
								
							case 2:
							{
								$table_details .="<td class=\"  \"><center>VERIFIED</center></td>";
								break;
							}
								
							case 3:
							{
								$table_details .="<td class=\"  \"><center>REVISE</center></td>";
								break;
							}
							case 9:
							{
								$table_details .="<td class=\"  \"><center>Docket Generated</center></td>";
								break;
							}
							default:
							{
								$table_details .="<td class=\"  \"><center>NEW</center></td>";
								break;
							}
								
						}
						$table_details .="<td class=\"  \"><center>".$sql_row['remarks']."</center></td>
   					 </tr>";
}

$table_details .="</tbody></table>";

}



 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Ratio Details Popup</title>
	<link href="style.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div class="panel panel-primary">
<div class="panel-heading">Ratio Details of <?php  echo $cat_desc;?></div>
<div class="panel-body">
<?php echo  $table_details;?>
</div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/header_scripts.php',4,'R')); ?>
</body>
</html>