<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
$view_access=user_acl("SFCS_0087",$username,1,$group_id_sfcs); 
?>
<body>
<div class="panel panel-primary">
<div class="panel-heading">Cut Quantity Reporting (Without Roll)</div>
<div class="panel-body">
<form method="post" name="input" action="#">
<div class="row">
<div class="col-sm-3">
Enter Docket Number: <input type="text" name="docket_id" class="form-control integer" size=15>
<span id="error" style="color: Red; display: none"></span>
<script type="text/javascript">
	var specialKeys = new Array();
	specialKeys.push(8); //Backspace
	function IsNumeric(e) {
		var keyCode = e.which ? e.which : e.keyCode
		var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
		document.getElementById("error").style.display = ret ? "none" : sweetAlert({title:"Please Enter only Numerics"});
		return ret;
	}
</script>
</div></br>
<?php echo "<input type=\"submit\" value=\"search\" class=\"btn btn-primary\" name=\"submit\" id=\"submit\" onclick=\"document.getElementById('submit').style.display='none'; document.getElementById('msg1').style.display='';\"/>";
 ?>
 
<a href="<?= getFullURLLevel($_GET['r'],'doc_track_panel.php',0,'N'); ?>"class="btn btn-info pull-right" style="margin-top:22px;">Go to Recut Status Reporting >> </a></h3>

</div>

</form>

<?php

if(isset($_POST['submit']))
{
	
	$docket_id=$_POST['docket_id'];	
	$valnew=0;
	$sql12="select * from $bai_pro3.plandoc_stat_log where doc_no='$docket_id'";
	$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row12=mysqli_fetch_array($sql_result12))
	{
		$valnew=$sql_row12['org_doc_no'];
	}
	if($valnew==0 || $valnew=='1')
	{
		if($docket_id>0)
		{		
		
			$sql="select cat_ref,order_tid,fabric_status,category from $bai_pro3.order_cat_doc_mk_mix where doc_no=$docket_id";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$cat_ref=$sql_row['cat_ref'];
				$order_tid=$sql_row['order_tid'];
				$category=$sql_row['category'];
				// if($sql_row['category']=="Body" or $sql_row['category']=="Front")
				// {
					$fabric_status=$sql_row['fabric_status'];
					if($valnew=='1')
					{	
						$sql1="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_doc_no=$docket_id and m3_op_des='LAY'";				
						$result=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$val_check=mysqli_num_rows($result);
					}
					else
					{
						$sql1="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where m3_op_des='LAY' and sfcs_doc_no in (select doc_no from $bai_pro3.plandoc_stat_log where doc_no='$docket_id')"; 						
						$result=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$val_check=mysqli_num_rows($result);
					}
				// }
				// else
				// {
				// 	$fabric_status=5;
				// }
				//echo $cat_ref."---".$fabric_status."<br>";
			}
			//echo $cat_ref."---".$fabric_status."<br>";
			if($cat_ref>0 and ($fabric_status==5 or $fabric_status==1))	
			{
					
				$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					for($s=0;$s<sizeof($sizes_code);$s++)
					{
						if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
						{
							$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
						}	
					}
						
				}		
					
				$cat_id=$cat_ref;
				$date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));


				echo "<div class=\"table-responsive\"><table class='table table-bordered'>";
				echo "<tr>";
				echo "<th>Doc ID</th><th>Cut No</th>";
				for($s=0;$s<sizeof($s_tit);$s++)
					{
						echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
							
					}
				echo "<th>Cut Status</th><th>Cut Issue Status</th><th>Control</th>";

				echo "<th>Date</th><th>Section</th><th>Shift</th><th>Fab_REC</th><th>Fab_Ret</th><th>Damages</th><th>Shortage</th>";

				//echo "<th>Control</th>";
				echo "<th>Date</th><th>Mod No</th><th>Shift</th>";

				echo "</tr>";

				//$sql="select * from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id order by doc_no";
				$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id and doc_no=$docket_id order by doc_no"; //NEW 2011
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_result);

				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$doc_no=$sql_row['doc_no'];
					$doc_acutno=$sql_row['acutno'];
					$a_plies=$sql_row['p_plies'];
					for($s=0;$s<sizeof($sizes_code);$s++)
					{
						$a_s[$sizes_code[$s]]=$sql_row["a_s".$sizes_code[$s].""]*$a_plies;
					}
					$plies=$sql_row['a_plies'];
				
					$remarks=$sql_row['remarks'];
					$act_cut_status=$sql_row['act_cut_status'];
					$act_cut_issue_status=$sql_row['act_cut_issue_status'];
					
					$sql33="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
					mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row33=mysqli_fetch_array($sql_result33))
					{
					$color_code=$sql_row33['color_code']; //Color Code
						
					}
					
					echo "<tr>";
					
					echo "<td>".leading_zeros($doc_no,9)."</td><td>".chr($color_code).leading_zeros($doc_acutno,3)."</td>";
					for($s=0;$s<sizeof($s_tit);$s++)
					{
						echo "<td>".$a_s[$sizes_code[$s]]."</td>";
							
					}

					echo "<td>$act_cut_status</td>";
					if($fabric_status==5){
						echo "<td>Issued to Cutting</td>";
						$type="true";
						$disabled="";
					}
					else{
					echo "<td>Not Issued to Cutting</td>";
						$type="false";
						$disabled="disabled";
					} 
				//echo "<td>$remarks</td>";

					// if($category=='Body' or $category=="Front")
					// {
						//if($val_check>0)
						// {
							if($act_cut_status=="DONE" and $plies==$a_plies)
							{
								echo "<td>Done</td>";
							}
							else
							{
								$create_url= getFullURLLevel($_GET['r'],'orders_cut_issue_status_form_v2_cut.php',0,'N');
								echo "<td><a oncontextmenu='return false' class='btn btn-sm btn-warning' onclick='return $type' $disabled href=".$create_url."&doc_no=$doc_no>Update</a></td>";
							}
						// }
						// else
						// {
						// 	echo "<td>Lay Reporting Pending.</td>";
						// 	//$create_url_1= getFullURLLevel($_GET['r'],'orders_cut_issue_status_form_v2_cut.php',0,'N');
						// 	//echo "<td><a href=".$create_url_1."&doc_no=$doc_no>Update</a></td>";
						// }
					// }
					// else
					// {
					// 	if($act_cut_status=="DONE" and $plies==$a_plies)
					// 	{
					// 		echo "<td>Done</td>";
					// 	}
					// 	else
					// 	{
					// 		$create_url_11= getFullURLLevel($_GET['r'],'orders_cut_issue_status_form_v2_cut.php',0,'N');
					// 		echo "<td><a class='btn btn-sm btn-warning' href=".$create_url_11."&doc_no=$doc_no>Update</a></td>";
					// 	}
					// }

						$acs_date="";
						$acs_section="";
						$acs_shift="";
						$acs_fab_received="";
						$acs_fab_returned="";
						$acs_damages="";
						$acs_shortages="";
						$acs_remarks="";
						
					$sql2="select * from $bai_pro3.act_cut_status where doc_no=$doc_no";
					mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

					while($sql_row2=mysqli_fetch_array($sql_result2))
					{
						$acs_date=$sql_row2['date'];
						$acs_section=$sql_row2['section'];
						$acs_shift=$sql_row2['shift'];
						$acs_fab_received=$sql_row2['fab_received'];
						$acs_fab_returned=$sql_row2['fab_returned'];
						$acs_damages=$sql_row2['damages'];
						$acs_shortages=$sql_row2['shortages'];
						$acs_remarks=$sql_row2['remarks'];
					}
					echo "<td>$acs_date</td><td>$acs_section</td><td>$acs_shift</td><td>$acs_fab_received</td><td>$acs_fab_returned</td><td>$acs_damages</td><td>$acs_shortages</td>";
					//echo "<td>$acs_remarks</td>";


					if($act_cut_issue_status=="DONE")
					{
						//IMS IMPLEMNT
						//echo "<td>Edit</td>";
					}
					else
					{
						
						if($act_cut_status=="DONE")
						{
							//IMS IMplemet
							//echo "<td><a href=\"orders_cut_issue_status_form2.php?doc_no=$doc_no\">Create</a></td>";
						}
					}


						$acis_date="";
						$acis_modno="";
						$acis_remarks="";

					$sql2="select * from $bai_pro3.act_cut_issue_status where doc_no=$doc_no";
					mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

					while($sql_row2=mysqli_fetch_array($sql_result2))
					{
						$acis_date=$sql_row2['date'];
						$acis_modno=$sql_row2['mod_no'];
						$acis_remarks=$sql_row2['remarks'];
						$acis_shift=$sql_row2['shift'];
					}
					
					echo "<td>$acis_date</td><td>$acis_modno</td><td>$acis_shift</td>";
					//echo "<td>$acis_remarks</td>";

					echo "</tr>";

				}
				echo "</table>";
			}
			else
			{				
			 	echo "Requested Docket doesn't exist or Docket Not printed or Fabric Not issued to this docket. Please contact your planner/RM Team.";
			}
		}
		else
		{
			echo "Please enter valid Docket Reference";
		}
	}
	else
	{
		echo "Entered Docket is Child Docket. Please Enter Parent Docket.";
	}	
}
?>

</div></div>

</body>