<head>
	<style>
		th,td
		{
			white-space: nowrap;
		}
	</style>
</head>
<?php

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)>0)
{
	$ord_tbl_name="$bai_pro3.bai_orders_db_confirm";	
}
else
{
	$ord_tbl_name="$bai_pro3.bai_orders_db";		
}
$tran_order_tid1=$tran_order_tid;



echo "<div>
		<table class=\"table table-bordered\">
	  		<thead>
	  			<tr>
	  				<th class=\"word-wrap\"><center>Ratio Ref</center></th>
		 			<th class=\"column-title\"><center>Category</center></th>";
					// <th class=\"column-title\"><center>TID</center></th>
					// <th class=\"column-title\"><center>Cat_ID</center></th>
					// <th class=\"column-title\"><center>Allocate_REF</center></th>
					// <th class=\"column-title\"><center>Marker Ref</center></th>
					echo "		  
					<th class=\"word-wrap\"><center>Marker Length</center></th><th class=\"word-wrap\"><center>Marker EFF%</center></th>
					<th class=\"column-title\"><center>Version</center></th><th class=\"column-title\"><center>Controls</center></th>
					<th class=\"word-wrap\"><center>Delete Control</center></th>
					<th class=\"word-wrap\"><center>Ratio wise Savings%</center></th>
					<th class=\"word-wrap\"><center>Ratio wise CAD Consumption</center></th>
					<th class=\"word-wrap\"><center>Used $fab_uom</center></th>
					<th class=\"word-wrap\"><center>Used $fab_uom For Binding</center></th>
					<th class=\"word-wrap\"><center>Current Status</center></th><th class=\"column-title\"><center>Remarks</center></th>
				</tr>
			</thead>";
			foreach($cats_ids as $key=>$value)
			{
				$get_cat_ref_query="SELECT cat_ref FROM $bai_pro3.allocate_stat_log WHERE order_tid=\"$tran_order_tid1\" and cat_ref=$value group by cat_ref ORDER BY tid";
				$cat_ref_result=mysqli_query($link, $get_cat_ref_query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($cat_row=mysqli_fetch_array($cat_ref_result))
				{
					$grand_tot_used_fab = 0;
					$grand_tot_used_binding = 0;
					$sql="select * from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid1\" and cat_ref=".$cat_row['cat_ref']." ORDER BY ratio";
					// echo $sql.'<br>';
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						$cat_ref1=$sql_row['cat_ref'];
						$cuttable_ref1=$sql_row['cuttable_ref'];
						$allocate_ref1=$sql_row['tid'];
						$mk_status1=$sql_row['mk_status'];
						$remarks1=$sql_row['remarks'];
							
						$mklength1=0;
						$mkeff1=0;
						$mk_ref1=0;

						$sql2="select * from $bai_pro3.maker_stat_log where allocate_ref=$allocate_ref1 and cuttable_ref > 0";	
						$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row2=mysqli_fetch_array($sql_result2))
						{
							$mklength1=$sql_row2['mklength'];
							$mkeff1=$sql_row2['mkeff'];
							$mk_ref1=$sql_row2['tid'];
							$mk_remarks1=$sql_row2['remarks'];
							$mk_version=$sql_row2['mk_ver'];
						}

						$sql2="select *,COALESCE(binding_consumption,0) AS binding_con from $bai_pro3.cat_stat_log where tid=$cat_ref1 order by lastup";
						$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row2=mysqli_fetch_array($sql_result2))
						{
							$cat_yy1=$sql_row2['catyy'];
							$category1=$sql_row2['category'];
							$binding_consumption=$sql_row2['binding_con'];

						}

						$sql2="select * from $bai_pro3.allocate_stat_log where tid=$allocate_ref1";
						$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row2=mysqli_fetch_array($sql_result2))
						{
							$ratio=$sql_row2['ratio'];
						}
						echo "
						<tr class=\"  \">";
							//echo "<td class=\"  \"><center>".$mk_ref1."</center></td>";
							echo "<td class=\"  \"><center>".$ratio."</center></td>";
							echo "<td class=\"  \"><center>".$category1."</center></td>";
							// echo "<td class=\"  \"><center>".$sql_row['tid']."</center></td>";
							// echo "<td class=\"  \"><center>".$sql_row['cat_ref']."</center></td>";
							// echo "<td class=\"  \"><center>".$cuttable_ref1."</center></td>";
							echo "<td class=\"  \"><center>".$mklength1."</center></td>";
							
							echo "<td class=\"  \"><center>".$mkeff1."</center></td>";
							echo "<td class=\"  \"><center>".$mk_version."</center></td>";

							if($mk_ref1==0)
							{
								echo "<td class=\"  \"><center><a class=\"btn btn-xs btn-primary\" href=\"".getFullURL($_GET['r'], "order_makers_form2.php", "N")."&tran_order_tid=$tran_order_tid1&cat_ref=$cat_ref1&cuttable_ref=$cuttable_ref1&allocate_ref=$allocate_ref1\">Create</a>";
							}
							else
							{
								//Validate for print status of the cut 
								$print_status_query = "SELECT doc_no from $bai_pro3.plandoc_stat_log where mk_ref=$mk_ref1 
									and order_tid='$tran_order_tid1' and print_status is not null ";
								if(mysqli_num_rows(mysqli_query($link,$print_status_query)) > 0 ){
									echo "<td class=\"  \"><center><a id='revise_form' class=\"btn btn-xs btn-warning\" 
									href=\"".getFullURL($_GET['r'], "revise_process.php", "N")."&tran_order_tid=$tran_order_tid1&allocate_ref=$allocate_ref1\">Revise</a></center></td>";
								}else{
									if($mk_status1==9)
									{
										echo "<td class=\"  \"><center>
												<a class=\"btn btn-xs btn-info\" href=\"".getFullURL($_GET['r'], "order_makers_form2_edit.php", "N")."&tran_order_tid=$tran_order_tid1&cat_ref=$cat_ref1&cuttable_ref=$cuttable_ref1&allocate_ref=$allocate_ref1&mk_ref=$mk_ref1&lock_status=1\">Edit</a></center></td>";
									}
									else
									{
										echo "<td class=\"  \"><center><a class=\"btn btn-xs btn-info\" href=\"".getFullURL($_GET['r'], "order_makers_form2_edit.php", "N")."&tran_order_tid=$tran_order_tid1&cat_ref=$cat_ref1&cuttable_ref=$cuttable_ref1&allocate_ref=$allocate_ref1&mk_ref=$mk_ref1\">Edit</a>";
										echo " | <a id='revise_form' class=\"btn btn-xs btn-warning\" href=\"".getFullURL($_GET['r'], "revise_process.php", "N")."&tran_order_tid=$tran_order_tid1&allocate_ref=$allocate_ref1\">Revise</a></center></td>";
									}
								}
							}	
							$sql21="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$tran_order_tid1\" and mk_ref=$mk_ref1 ";
							$sql_result21=mysqli_query($link, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							if(mysqli_num_rows($sql_result21)==0)
							{
								echo "<td class=\"  \"><center><a id='delete_form' class=\"btn btn-xs btn-danger confirm-submit\" href=\"".getFullURL($_GET['r'], "delete_id.php", "N")."&tran_order_tid=$tran_order_tid1&cat_ref=$cat_ref1&cuttable_ref=$cuttable_ref1&allocate_ref=$allocate_ref1&mk_ref=$mk_ref1\">Delete</a>";
							}
							else
							{
								echo "<td class=\"word-wrap\"><center>Lay plan Prepared";		
							}	
							
							$sql2="select * from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid1\" and tid=$allocate_ref1 ";
							$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row2=mysqli_fetch_array($sql_result2))
							{	
								if($sql_row2['pliespercut']>0)
								{			
									$cutcount1=ceil($sql_row2['plies']/$sql_row2['pliespercut']);
								}
										
								// $totalplies1=$sql_row2['allocate_s01']+$sql_row2['allocate_s02']+$sql_row2['allocate_s03']+$sql_row2['allocate_s04']+$sql_row2['allocate_s05']+$sql_row2['allocate_s06']+$sql_row2['allocate_s07']+$sql_row2['allocate_s08']+$sql_row2['allocate_s09']+$sql_row2['allocate_s10']+$sql_row2['allocate_s11']+$sql_row2['allocate_s12']+$sql_row2['allocate_s13']+$sql_row2['allocate_s14']+$sql_row2['allocate_s15']+$sql_row2['allocate_s16']+$sql_row2['allocate_s17']+$sql_row2['allocate_s18']+$sql_row2['allocate_s19']+$sql_row2['allocate_s20']+$sql_row2['allocate_s21']+$sql_row2['allocate_s22']+$sql_row2['allocate_s23']+$sql_row2['allocate_s24']+$sql_row2['allocate_s25']+$sql_row2['allocate_s26']+$sql_row2['allocate_s27']+$sql_row2['allocate_s28']+$sql_row2['allocate_s29']+$sql_row2['allocate_s30']+$sql_row2['allocate_s31']+$sql_row2['allocate_s32']+$sql_row2['allocate_s33']+$sql_row2['allocate_s34']+$sql_row2['allocate_s35']+$sql_row2['allocate_s36']+$sql_row2['allocate_s37']+$sql_row2['allocate_s38']+$sql_row2['allocate_s39']+$sql_row2['allocate_s40']+$sql_row2['allocate_s41']+$sql_row2['allocate_s42']+$sql_row2['allocate_s43']+$sql_row2['allocate_s44']+$sql_row2['allocate_s45']+$sql_row2['allocate_s46']+$sql_row2['allocate_s47']+$sql_row2['allocate_s48']+$sql_row2['allocate_s49']+$sql_row2['allocate_s50'];
								$totalplies1=$sql_row2['plies'];

								$ratiotot=0;
								for($s=0;$s<sizeof($s_tit);$s++)
								{
									$ratiotot+=$sql_row["allocate_s".$sizes_code[$s].""];
								}
							}
							
							$cad_consumption = $mklength1/$ratiotot;
							$realYY = $cat_yy1-$binding_consumption;
							$usedFabric = $mklength1*$totalplies1;
							if($cat_yy1>0 and $totalplies1>0)
							{
								$savings1=round((($realYY-$cad_consumption)/$realYY)*100,0);
							}
							else
							{
								$savings1=0;
							}
							echo "<td class=\"  \"><center>".$savings1."%</center></td>";
							echo "<td class=\"  \"><center>".round($cad_consumption,4)."</center></td>";
							echo "<td class=\"  \"><center>".round($usedFabric,2)."</center></td>";
							echo "<td class=\"  \"><center>".$used_yards[$category1][$ratio]."</center></td>";

							$grand_tot_used_fab = $grand_tot_used_fab + round($usedFabric,2);
							$grand_tot_used_binding = $grand_tot_used_binding + $used_yards[$category1][$ratio];
								
							switch ($mk_status1)
							{
								case 1:
								{
									echo "<td class=\"  \"><center>NEW</center></td>";
									break;
								}
									
								case 2:
								{
									echo "<td class=\"  \"><center>VERIFIED</center></td>";
									break;
								}
									
								case 3:
								{
									echo "<td class=\"  \"><center>REVISE</center></td>";
									break;
								}
								case 9:
								{
									echo "<td class=\"  \"><center>Docket Generated</center></td>";
									break;
								}
								default:
								{
									echo "<td class=\"  \"><center>NEW</center></td>";
									break;
								}
							}

							echo "<td class=\"word-wrap\"><center>".$mk_remarks1."</center></td>";
							echo "
						</tr>";
					}
					echo "<tr style='background-color: yellow;'><td colspan=9><center><b>Total ($category1) </b></center></td><td><center><b>$grand_tot_used_fab</b></center></td><td><center><b>$grand_tot_used_binding</b></center></td><td colspan=2></td></tr>";
				}
			}
	echo "
		</table>
	</div>";
?>

<style>
.word-wrap {
		word-wrap: break-word; 
		white-space: normal !important; 
    }
    .no-wrap {
        white-space: nowrap;
    }
    .fixed {
        table-layout: fixed;
    }
</style>