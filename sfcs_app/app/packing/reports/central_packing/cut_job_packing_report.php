<?php 
include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
    $vpo=$_GET["vpo"]; 
    $style=$_GET["style"];

    if ($_POST['style'])
    {
    	$vpo=$_POST["vpo"]; 
    	$style=$_POST["style"]; 
    }	
?> 
<html> 
<head> 
<style type="text/css"> 
	table {
		border-collapse: collapse;
		border-spacing: 0;
		width: 100%;
		border: 1px solid #ddd;
		display: block;
        overflow-x: auto;
        white-space: nowrap;
	}

	th, td {
		text-align: left;
		padding: 8px;
	}

	tr:nth-child(even){
		background-color: #f2f2f2
	}
	.red_box 
	{ 
	    width:20px;height:20px;float:left;margin-right:5px;background-color:'#ff3333';line-height:0px;font-size:0px; 
	    margin-bottom:5px; 
	} 
	.blue_box 
	{ 
	    width:20px;height:20px;float:left;margin-right:5px;background-color:'#15a5f2';line-height:0px;font-size:0px; 
	    margin-bottom:5px; 
	} 
	.pink_box 
	{ 
	    width:20px;height:20px;float:left;margin-right:5px;background-color:'#ff4da6';line-height:0px;font-size:0px; 
	    margin-bottom:5px; 
	} 
	.green_box 
	{ 
	    width:20px;height:20px;float:left;margin-right:5px;background-color:'#1aff1a';line-height:0px;font-size:0px; 
	    margin-bottom:5px; 
	}

	.btn-red{ 
		color: #FF3333; 
		background-color: #FF3333; 
		border-color: #FF3333; 
	} 
	.btn-pink { 
		color: #FF4DA6; 
		background-color: #FF4DA6; 
		border-color: #FF4DA6; 
	}
	.btn-light_green { 
		color: #1AFF1A; 
		background-color: #1AFF1A; 
		border-color: #1AFF1A; 
	} 
</style> 

<script>
	var url1 = '<?= getFullURL($_GET['r'],'cut_job_packing_report.php','N'); ?>';

	function firstbox() 
	{ 
	    window.location.href =url1+"&vpo="+document.test.vpo.value; 
	}
</script> 
</head>
<body>
<div class="container-fluid">
    <div class="panel panel-primary">
        <div class="panel-heading">Central Packing Summary Report</div>
        <div class="panel-body">
			<div class='col-md-9'>
				<form name="test" action="<?php $_GET['r'] ?>" method="POST" class='form-inline'> 
					<?php 
						echo "VPO: <select name=\"vpo\" required onchange=\"firstbox();\" class='form-control'>"; 
						$sql="select vpo from $bai_pro3.bai_orders_db_confirm where vpo<>'' group by vpo order by vpo";     
						$sql_result=mysqli_query($link, $sql) or exit("Error while getting vpo"); 
						$sql_num_check=mysqli_num_rows($sql_result); 

						echo "<option value='' selected>--Select--</option>"; 
						while($sql_row=mysqli_fetch_array($sql_result)) 
						{
							if(str_replace(" ","",$sql_row['vpo'])==str_replace(" ","",$vpo)) 
							{ 
								echo "<option value=\"".$sql_row['vpo']."\" selected>".$sql_row['vpo']."</option>"; 
							} 
							else 
							{ 
								echo "<option value=\"".$sql_row['vpo']."\">".$sql_row['vpo']."</option>"; 
							}
						} 
						echo "</select>"; 
						
						echo "Style: <select name=\"style\" required onchange=\"secondbox();\" class='form-control'>"; 
						$sql="select order_style_no from $bai_pro3.bai_orders_db_confirm where vpo='".$vpo."' GROUP BY order_style_no order by order_style_no";     
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						echo "<option value='' selected>--Select--</option>"; 
						while($sql_row=mysqli_fetch_array($sql_result)) 
						{ 
							if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style)) 
							{ 
								echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>"; 
							} 
							else 
							{ 
								echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>"; 
							} 
						}
						echo "</select>"; 
					?> 
					<input type="submit" class="btn btn-success" name="submit" id="submit" value="Show">
				</form>
			</div>
			<div class='col-md-3'>
				<label>Legend:</label>
				<table class="table table-bordered"> 
					<tr> 
						<td>Sewing Input not given </td> 
						<td><a class='btn btn-red'>
							<!-- <div class="red_box" style="margin-left:15px;"></div> -->
						</td> 
					</tr> 
					<tr> 
						<td>Sewing Input given to the module </td> 
						<td><a class='btn btn-info'>
							<!-- <div class="blue_box" style="margin-left:15px;"></div> -->
						</td> 
					</tr> 
					<tr> 
						<td>Sewing Output completed </td> 
						<td><a class='btn btn-pink'>
							<!-- <div class="pink_box" style="margin-left:15px;"></div> -->
						</td> 
					</tr> 
					<tr> 
						<td>Central Packing In Area </td> 
						<td><div class='btn btn-light_green'></div>
							<!-- <div class="green_box" style="margin-left:15px;width:20px;padding-top:0px;"></div> -->
						</td> 
					</tr> 
				</table>
			</div>
			<?php 
			if(isset($_POST['submit'])) 
			{
			    $vpo=$_POST['vpo'];
			    $style=$_POST['style'];
				$getschedule="select order_del_no,packing_method,group_concat(trim(order_col_des)) as cols,group_concat(order_col_des) as cols_new from $bai_pro3.bai_orders_db_confirm where vpo='".$vpo."' and order_style_no='".$style."' group by order_del_no,packing_method"; 
				$sql_result=mysqli_query($link, $getschedule) or exit("Error while getting schedules for the vpo1"); 
				while($sql_row=mysqli_fetch_array($sql_result)) 
			    { 
			        $schedule[]=$sql_row['order_del_no']; 
			        $pack_method[]=$sql_row['packing_method']; 
			        $cols[]=$sql_row['cols']; 
			        $cols_new[]=$sql_row['cols_new']; 
			    }
				$query_val='';
				$ops="select * from $brandix_bts.tbl_ims_ops where appilication in ('IPS','IMS','Carton_Ready')";
				$ops_result=mysqli_query($link, $ops) or exit("Error while getting schedules for the vpo"); 
				while($row_result=mysqli_fetch_array($ops_result)) 
			    { 
			        if($row_result['appilication']=='IPS')
					{
						$query_val .= "sum(if(operation_id='".$row_result['operation_code']."',recevied_qty,0)) AS in_qty,"; 
					}
					else if($row_result['appilication']=='IMS')
					{
						$query_val .= "sum(if(operation_id='".$row_result['operation_code']."',recevied_qty,0)) AS out_qty,";
					}
					else if($row_result['appilication']=='Carton_Ready')
					{
						$query_val .= "sum(if(operation_id='".$row_result['operation_code']."',recevied_qty,0)) AS pac_qty,";
					}
				}
				
			    //echo "<h3><span class=\"label label-info\"><b>Style: ".$style." &nbsp&nbsp&nbsp&nbsp Schedules: ".substr(implode(",",$schedule),0,-1)."</b></span></h3><br/>"; 
			    echo "<h3><span class=\"label label-info\"><b>Style: ".$style." &nbsp&nbsp&nbsp&nbsp Schedules: ".implode(",",array_unique($schedule))."</b></span></h3><br/>"; 
			    // Cut Level
				$cutnos=0;
				$cutno="select max(acutno) as cutno FROM bai_pro3.packing_summary_input WHERE order_del_no IN(".implode(",",$schedule).")"; 
			    $cut_result=mysqli_query($link, $cutno) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			    while($cut_result_row=mysqli_fetch_array($cut_result)) 
			    { 
			        $cutnos=$cut_result_row['cutno']; 
			    }
				$cutno1="SELECT COUNT(DISTINCT input_job_no) AS cnt FROM bai_pro3.packing_summary_input WHERE order_del_no IN(".implode(",",$schedule).") GROUP BY order_del_no,acutno ORDER BY cnt DESC LIMIT 1";				
			    $cut_result1=mysqli_query($link, $cutno1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			    while($cut_result_row1=mysqli_fetch_array($cut_result1)) 
			    { 
			        $rows=$cut_result_row1['cnt']; 
			    } 	
			    for ($ii=1; $ii <=$cutnos; $ii++) 
				{				
					for($iii=0;$iii<sizeof($schedule);$iii++)
					{				
						//echo $cols_new[$iii]."<br>";
						//echo str_replae(",","','",$cols_new[$iii])."<br>";
						$size_array=array();
						$sizeqry="select input_job_no,input_job_no_random,m3_size_code,sum(carton_act_qty) as qty FROM bai_pro3.packing_summary_input WHERE order_del_no='".$schedule[$iii]."' and order_col_des in ('".str_replace(",","','",$cols_new[$iii])."') and acutno='$ii' group by input_job_no order by input_job_no*1";
						//echo $sizeqry."<br>";
						$sizerslt=mysqli_query($link, $sizeqry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($sizerow=mysqli_fetch_array($sizerslt)) 
						{ 
							$size_array[]=$sizerow['m3_size_code'];
							$job_qty[$sizerow['input_job_no_random']]=$sizerow['qty'];
							$sew_job_rand[]=$sizerow['input_job_no_random'];
							$sew_job_no[]=$sizerow['input_job_no'];
						}
						
						if(sizeof($sew_job_rand)>0)
						{
							echo "<div style='overflow-x:auto;'>";
							echo "<table border='1px'>"; 
							echo "<tr style='background-color:#1184AD;color:white;'>"; 
							echo "<th width=\"5%\" >Style</th>"; 
							echo "<th width=\"10%\">VPO#</th>"; 
							echo "<th width=\"5%\">Schedule</th>"; 
							echo "<th width=\"3%\">Color Way</th>"; 
							echo "<th width=\"15%\" >Color Description</th>"; 
							echo "<th width=\"3%\">Cut Job#</th>"; 
							for ($i=0; $i < sizeof($size_array); $i++) 
							{  
								echo "<th width=\"5%\">".$size_array[$i]."</th>"; 
							}
							if($rows-sizeof($size_array)>0)
							{
								for ($i=0; $i < ($rows-sizeof($size_array)); $i++) 
								{  
									echo "<th width=\"5%\">  </th>"; 
								}
							}	
							echo "</tr>"; 
							echo "</div>";
							echo "<tr height=20 style='height:15.0pt;'>"; 
				            echo "<td height=20 style='height:15.0pt;align:centre;'>".$style."</td>"; 
				            echo "<td height=20 style='height:15.0pt'>".$vpo."</td>"; 
				            echo "<td height=20 style='height:15.0pt;align:centre;'>".$schedule[$iii]."</td>"; 
				            echo "<td height=20 style='height:15.0pt;align:centre;'>".$pack_method[$iii]."</td>"; 
				            echo "<td width=\"15%\" height=20  style='height:15.0pt'>".str_replace(",","</br>",$cols[$iii])."</td>"; 
				            echo "<td height=20 style='height:15.0pt'>".$ii."</td>";
							// echo "<div style=\"overflow:scroll; width:100%\">";
							$sql13="SELECT $query_val input_job_no_random_ref
							FROM $brandix_bts.bundle_creation_data WHERE cut_number='".$ii."' and input_job_no_random_ref in ('".implode("','",$sew_job_rand)."') GROUP BY input_job_no order by input_job_no*1"; 
							//echo $sql13."<br>";
							$result13=mysqli_query($link, $sql13) or die("Error-".$sql13."-".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row13=mysqli_fetch_array($result13)) 
							{						
								$sew_job_pac[$sql_row13['input_job_no_random_ref']]=$sql_row13['pac_qty'];
								$sew_job_out[$sql_row13['input_job_no_random_ref']]=$sql_row13['out_qty'];
								$sew_job_in[$sql_row13['input_job_no_random_ref']]=$sql_row13['in_qty'];
							}
							for ($j=0; $j < sizeof($size_array); $j++) 
							{  
								$pack_qty=$sew_job_pac[$sew_job_rand[$j]];
								$in_qty=$sew_job_in[$sew_job_rand[$j]];
								$out_qty=$sew_job_out[$sew_job_rand[$j]];
								//echo $sew_job_no[$j]."--".$job_qty[$sew_job_rand[$j]]."--".$in_qty."--".$out_qty."--".$pack_qty."<br>";
								if($pack_qty=="")
								{
									$pack_qty=0;
								}
								
								if($in_qty=="")
								{
									$in_qty=0;
								}
								
								if($out_qty=="")
								{
									$out_qty=0;
								}
								//echo $pack_qty."--".$in_qty."---".$out_qty."<br>";
								$bac_col="#ff3333";
								
								if($pack_qty>0 && ($pack_qty==$job_qty[$sew_job_rand[$j]]))
								{
									$bac_col='#1aff1a';
								}
								elseif($out_qty>0 && ($out_qty==$job_qty[$sew_job_rand[$j]]))
								{
									$bac_col='#ff4da6';
								}
								elseif($in_qty>0 && ($in_qty==$job_qty[$sew_job_rand[$j]]))
								{
									$bac_col='#15a5f2';
								}
								else
								{
									$bac_col='#ff3333';
								}
								echo "<td width=\"7%\" height=20 style='height:15.0pt;background-color:$bac_col;color:white;'>Job# ".$sew_job_no[$j]." </br> Qty# ".$job_qty[$sew_job_rand[$j]]." </br> Cut# ".$ii." </br> Col# ".$pack_method[$iii]."</td>";
							}
							if($rows-sizeof($size_array)>0)
							{
								for ($i=0; $i < ($rows-sizeof($size_array)); $i++) 
								{  
									echo "<td width=\"7%\" height=20 style='height:15.0pt;background-color:white;color:white;'> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</br>  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</br>   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</br>  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>";	
								}
							}
							echo "</tr>";
							echo "</table>";
							echo "</div>";
							echo "<br>";
							echo "<br>";
						}
						unset($sew_job_pac);
						unset($sew_job_out);
						unset($sew_job_in);
						unset($size_array);
						unset($sew_job_rand);
						unset($sew_job_no);
						unset($job_qty);
							
					}
				}
			}	
			?>
		</div>
	</div>
</div>
</body> 
</html> 