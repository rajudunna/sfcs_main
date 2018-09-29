<?php 
include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
    $vpo=$_GET["vpo"]; 
    $style=$_GET["style"]; 
?> 
<html> 
<head> 
<style type="text/css"> 
	table.gridtable { 
	    font-family:arial; 
	    font-size:12px; 
	    color:#333333; 
	    border-width: 1px; 
	    border-color: #666666; 
	    border-collapse: collapse; 
	     
	    /*height: 100%;  
	    width: 100%;*/ 
	} 
	table.gridtable th { 
	    border-width: 1px; 
	    padding: 3.5px; 
	    border-style: solid; 
	    border-color: #666666; 
	    background-color: #ffffff; 
	} 
	table.gridtable td { 
	    border-width: 1px; 
	    padding: 3.5px; 
	    border-style: solid; 
	    border-color: #666666; 
	    background-color: #ffffff; 
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
        <div class="panel-heading">Central Packing Detailed Report</div>
        <div class="panel-body">
			<div class='col-md-9'>
				<form name="test" action="<?php $_GET['r'] ?>" method="POST" class='form-inline'> 
					<?php 
						echo "VPO: <select name=\"vpo\" onchange=\"firstbox();\" class='form-control'>"; 
						$sql="select vpo from bai_pro3.bai_orders_db_confirm where order_style_no like 'Y%' group by vpo order by vpo";     
						$sql_result=mysqli_query($link, $sql) or exit("Error while getting vpo"); 
						$sql_num_check=mysqli_num_rows($sql_result); 

						echo "<option value=\"NIL\" selected>--Select--</option>"; 
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
						
						echo "Style: <select name=\"style\" onchange=\"secondbox();\" class='form-control'>"; 
						$sql="select order_style_no from bai_pro3.bai_orders_db_confirm where vpo like \"%$vpo%\" GROUP BY order_style_no order by order_style_no";     
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						echo "<option value=\"NIL\" selected>--Select--</option>"; 
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
				$getschedule="select order_del_no,packing_method,group_concat(order_col_des SEPARATOR '\n') as cols,group_concat(order_col_des) as cols_new from $bai_pro3.bai_orders_db_confirm where vpo='".$vpo."' and order_style_no='".$style."' group by order_del_no,packing_method"; 
				$sql_result=mysqli_query($link, $getschedule) or exit("Error while getting schedules for the vpo"); 
				while($sql_row=mysqli_fetch_array($sql_result)) 
			    { 
			        $schedule[]=$sql_row['order_del_no']; 
			        $pack_method[]=$sql_row['packing_method']; 
			        $cols[]=$sql_row['cols']; 
			        $cols_new[]=$sql_row['cols_new']; 
			    }
			    echo "<h3><span class=\"label label-info\"><b>Style: ".$style.", Schedules: ".substr(implode(",",$schedule),0,-1)."</b></span></h3><br/>"; 
			    // Cut Level
				$cutnos=0;
				$cutno="select max(acutno) as cutno FROM bai_pro3.packing_summary_input WHERE order_del_no IN(".implode(",",$schedule).")"; 
			    $cut_result=mysqli_query($link, $cutno) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			    while($cut_result_row=mysqli_fetch_array($cut_result)) 
			    { 
			        $cutnos=$cut_result_row['cutno']; 
			    } 
			    for ($ii=1; $ii <=$cutnos; $ii++) 
				{				
					for($iii=0;$iii<sizeof($schedule);$iii++)
					{				
						//echo $cols_new[$iii]."<br>";
						//echo str_replae(",","','",$cols_new[$iii])."<br>";
						$size_array=array();
						$sizeqry="select input_job_no,input_job_no_random,m3_size_code,sum(carton_act_qty) as qty FROM bai_pro3.packing_summary_input WHERE order_del_no='".$schedule[$iii]."' and order_col_des in ('".str_replace(",","','",$cols_new[$iii])."') and acutno='$ii' group by input_job_no order by input_job_no*1";
						$sizerslt=mysqli_query($link, $sizeqry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($sizerow=mysqli_fetch_array($sizerslt)) 
						{ 
							$size_array[]=$sizerow['m3_size_code'];
							$job_qty[$sizerow['input_job_no_random']]=$sizerow['qty'];
							$sew_job_rand[]=$sizerow['input_job_no_random'];
							$sew_job_no[]=$sizerow['input_job_no'];
						}
						echo "<div class='table-responsive'>";
						if(sizeof($sew_job_rand)>0)
						{							
							echo "<table id=\"example1\" class='table table-bordered'>"; 
							echo "<tr style='background-color:#1184AD;color:white;'>"; 
							echo "<th >Style</th>"; 
							echo "<th >VPO#</th>"; 
							echo "<th >Schedule</th>"; 
							echo "<th >Color Way</th>"; 
							echo "<th colspan=2 >Color Description</th>"; 
							echo "<th >Cut Job#</th>"; 
							for ($i=0; $i < sizeof($size_array); $i++) 
							{  
								echo "<th >".$size_array[$i]."</th>"; 
							} 
							echo "</tr>"; 
							echo "</div>";
							echo "<tr height=20 style='height:15.0pt;'>"; 
				            echo "<td height=20 style='height:15.0pt;align:centre;'>".$style."</td>"; 
				            echo "<td height=20 style='height:15.0pt'>".$vpo."</td>"; 
				            echo "<td height=20 style='height:15.0pt;align:centre;'>".$schedule[$iii]."</td>"; 
				            echo "<td height=20 style='height:15.0pt;align:centre;'>".$pack_method[$iii]."</td>"; 
				            echo "<td width=300 height=20  colspan=2 style='height:15.0pt'>".str_replace(",","</br>",$cols_new[$iii])."</td>"; 
				            echo "<td height=20 style='height:15.0pt'>".$ii."</td>";
							$sql13="SELECT input_job_no_random_ref,
							if(operation_id='129',SUM(recevied_qty),0) AS in_qty, 
							if(operation_id='130',SUM(recevied_qty),0) AS out_qty, 
							if(operation_id='950',SUM(recevied_qty),0) AS pac_qty
							FROM $brandix_bts.bundle_creation_data WHERE cut_number='".$ii."' and input_job_no_random_ref in ('".implode("','",$sew_job_rand)."') GROUP BY input_job_no order by input_job_no*1"; 
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
								elseif($imsquantity>0)
								{
									$bac_col='#15a5f2';
								}
								else
								{
									$bac_col='#ff3333';
								}
								echo "<td height=20 style='height:15.0pt;background-color:$bac_col;color:white;'>Job#-".$sew_job_no[$j]." </br> Qty#-".$job_qty[$sew_job_rand[$j]]."</td>";
							}
							echo "</tr>";
							echo "</table>";
							unset($sew_job_pac);
							unset($sew_job_out);
							unset($sew_job_in);
							unset($size_array);
							unset($sew_job_no);
						}
						echo "</div>";	
					}
				}
			}	
			?>
		</div>
	</div>
</div>
</body> 
</html> 