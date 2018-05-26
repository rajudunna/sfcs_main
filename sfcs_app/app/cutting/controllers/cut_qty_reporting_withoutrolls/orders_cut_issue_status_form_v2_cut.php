<!--
Changes Log: 
kirang/2014-07-28/ Service Request #974044: Add code for time based shift from HRMS
KiranG/201506-16 Service Request # 186661 : Added form submit button validation to show a message while processing form.
-->
<?php 
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
 ?>


<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->
<!-- <head> -->
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check.js',2,'R'); ?>"></script>

<script>
	function validate(x,y)
	{
		if(x<0 || x>y) { alert("Please enter correct plies <="+y); return 1010;  }
	}

</script>
<!-- </head> -->

	<body onload="javascript:dodisable();">
	<div class="panel panel-primary">
	<div class="panel-heading">Cut Status Reporting</div>
	<div class="panel-body">
		<?php
			$doc_no=$_GET['doc_no'];
			echo "<div class=\"table-responsive\"><table class='table table-bordered'>";
			echo "<tr>";
			echo "<th>Doc ID</th><th>Cut No</th>";
			$sql="select * from $bai_pro3.plandoc_stat_log where doc_no=$doc_no";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);

			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$doc_no=$sql_row['doc_no'];
				$doc_acutno=$sql_row['acutno'];
				$a_plies=$sql_row['p_plies'];
				$sql34="SELECT material_req FROM $bai_pro3.order_cat_doc_mk_mix WHERE doc_no='".$doc_no."'";
				//mysql_query($sql33,$link) or exit("Sql Error".mysql_error());
				$sql_result34=mysqli_query($link, $sql34) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row34=mysqli_fetch_array($sql_result34))
				{
					$material=$sql_row34['material_req']; //Material Req
				}
				$remarks=$sql_row['remarks'];
				$act_cut_status=$sql_row['act_cut_status'];
				$act_cut_issue_status=$sql_row['act_cut_issue_status'];
				$maker_ref=$sql_row['mk_ref'];
				$act_plies=$sql_row['p_plies'];
				$tran_order_tid=$sql_row['order_tid'];
				$print_status=$sql_row['print_status'];
				$plies=$sql_row['a_plies'];
				
				$sql33="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
				mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row33=mysqli_fetch_array($sql_result33))
				{
					$color_code=$sql_row33['color_code']; //Color Code
				}
				$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result))
				{
					for($s=0;$s<sizeof($sizes_code);$s++)
					{
						if($sql_row1["title_size_s".$sizes_code[$s].""]<>'')
						{
							$s_tit[$s]=$sql_row1["title_size_s".$sizes_code[$s].""];
						}	
					}
						
				}
				
				for($s=0;$s<sizeof($s_tit);$s++)
				{
					echo "<th>".$s_tit[$s]."</th>";
						
				}
				
				echo "<th>Total</th><th>CUT STATUS</th><th>CUT ISSUE STATUS</th><th>Remarks</th>";
				echo "</tr>";
				
				for($s=0;$s<sizeof($sizes_code);$s++)
				{
					//echo $sizes_code[$s]."--".$sql_row["p_s01"]."<br>";
					$a_s[$s]=$sql_row["p_s".$sizes_code[$s].""]*$act_plies;
				}
					
				echo "<tr>";
				
				echo "<td>".leading_zeros($doc_no,9)."</td><td>".chr($color_code).leading_zeros($doc_acutno,3)."</td>";

				for($s=0;$s<sizeof($s_tit);$s++)
				{
					echo "<td>".$a_s[$s]."</td>";
						
				}
				echo "<td>".array_sum($a_s)."</td>";
				echo "<td>$act_cut_status</td><td>$act_cut_issue_status</td><td>$remarks</td>";

				echo "</tr>";
			}
			echo "</table></div>";

			$sql="select mklength from $bai_pro3.maker_stat_log where tid=$maker_ref";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);

			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$mklength=$sql_row['mklength'];
			}


			$fab_received=0;
			$fab_returned=0;
			$fab_damages=0;
			$fab_shortages=0;
			$fab_remarks="";
				
			$sql="select * from $bai_pro3.act_cut_status where doc_no=$doc_no";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$fab_received=$sql_row['fab_received'];
				$fab_returned=$sql_row['fab_returned'];
				$fab_damages=$sql_row['damages'];
				$fab_shortages=$sql_row['shortages'];
				$fab_remarks=$sql_row['remarks'];
			}


			$plies_check=0;
			if($act_cut_status=="DONE" and $plies<=$act_plies)
			{
				$plies_check=($act_plies-$plies);
			}
			else
			{
				$plies_check=$act_plies;
			}

			if($act_cut_status=="DONE")
			{
				$old_plies=$plies;
			}
			else
			{
				$old_plies=0;
			}

			//Adding to verify schedule club or not
			$sql2123="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"".$tran_order_tid."\" and order_joins='1'";
			$sql_result123=mysqli_query($link, $sql2123) or exit("Sql Error0".mysqli_error($GLOBALS["___mysqli_ston"]));
			$check_stat=mysqli_num_rows($sql_result123);
			$statusn=0;
			if($check_stat==0)
			{
				$club_status=0; $order_tids=array();
				$sql1="select * from $bai_pro3.plandoc_stat_log where org_doc_no='$doc_no'"; 
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				$count=mysqli_num_rows($sql_result1); 
				if($count>0) 
				{ 
					while($rows2=mysqli_fetch_array($sql_result1)) 
					{ 
						$order_tids[]=$rows2['order_tid']; 
					} 
					$sql12="select * from $bai_pro3.bai_orders_db_confirm where order_tid in ('".implode("','",$order_tids)."') limit 1";
					$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($rows=mysqli_fetch_array($sql_result12)) 
					{ 
						if(strlen($rows['order_joins'])<5)
						{
							$club_status=1;	
						}
						else
						{
							$club_status=2;	
						}	
							
					} 
					$sql12="select * from $bai_pro3.plandoc_stat_log where doc_no=$doc_no"; 
					$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($rows=mysqli_fetch_array($sql_result12)) 
					{ 
						$a_plies_qty=$rows['a_plies']; 
					}
					$statusn=0;		
				} 
				else 
				{ 
					$club_status=0; 
					$sql12="select * from $bai_pro3.plandoc_stat_log where doc_no=$doc_no"; 
					$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($rows=mysqli_fetch_array($sql_result12)) 
					{ 
						$a_plies_qty=$rows['a_plies']; 
					} 
					$statusn=0;
				}
				$statusn=0;
			}
			else
			{
				$statusn=1;
			}
			?>


<h2>Input Entry Form</h2>  
<FORM method="post" name="input" action="<?= getFullURLLevel($_GET['r'],'orders_cut_issue_status_form1_process_cut.php',0,'N');?>">
	<input type="hidden" name="doc_no" value="<?php echo $doc_no; ?>">
	<?php
		if($print_status==NULL)
		{
			echo "Docket is yet to generate. Please contact your cutting head.";
		}
		else
		{
			$special_users=array("kirang","prabathsa","kirang");
			echo "<input type=\"hidden\" name=\"tran_order_tid\" value=\"".$tran_order_tid."\">";
			echo "<input type=\"hidden\" name=\"club_status\" value=\"".$club_status."\">";
			echo "<input type=\"hidden\" name=\"a_plies_qty\" value=\"".$a_plies_qty."\">";
			echo "<div class='table-responsive'><table class='table table-bordered'>";
			echo "<tr><td>Date</td><td>:</td><td align='center'><div class='col-sm-3'><input type=\"hidden\" name=\"date\" value=".date("Y-m-d").">".date("Y-m-d")."</div></td></tr>";
			//echo "<tr><td>Section</td><td>:</td><td><input type=\"text\" name=\"section\" value=\"0\"></td></tr>";
			$table_q="SELECT * FROM $bai_pro3.`tbl_cutting_table` WHERE STATUS='active'";
			$table_result=mysqli_query($link, $table_q) or exit("Error getting Table Details");
			while($tables=mysqli_fetch_array($table_result))
			{
				$table_name[]=$tables['tbl_name'];
				$table_id[]=$tables['tbl_id'];
			}
			// var_dump($table_name);
			echo "<tr><td>Cutting Table</td><td>:</td><td><div class='col-sm-4'><select name=\"section\" class='form-control' required><option value=\"0\">Select Table</option>";
			for($i = 0; $i < sizeof($table_name); $i++)
			{
				echo "<option value='".$table_id[$i]."' style='background-color:#FFFFAA;'>".$table_name[$i]."</option>";
			}
			echo "</select></div></td></tr>";
	
			if(in_array($username,$special_users))
			{
				echo "<tr><td>Shift</td><td>:</td><td><div class='col-sm-4'><select name=\"shift\" class='form-control'>
					<option value=\"A\">A</option>
					<option value=\"B\">B</option>
					</select></div></td></tr>";
			}
			else
			{
				echo "<tr><td>Shift</td><td>:</td><td><div class='col-sm-4'><select name=\"shift\" class='form-control'>
					<option value=\"A\">A</option>
					<option value=\"B\">B</option>
					</select></div></td></tr>";
			}
			//echo "<tr><td>Doc Req</td><td>:</td><td>".($act_plies*$mklength)."</td></tr>";
			echo "<tr><td>Docket Fabric Required</td><td>:</td><td align='center'><div class='col-sm-3'>".round($material,2)."</div></td></tr>";
			// echo "<tr><td>Planned Plies</td><td>:</td><td>".$plies_check."</td></tr>";
			echo "<tr><td>Cut Plies</td><td>:</td><td><div class='col-sm-4'><input type=\"hidden\" name=\"old_plies\"  value=\"$old_plies\"><input type=\"number\" class='form-control' name=\"plies\"  min=0 value=\"$plies_check\" id=\"plies\" onchange=\"if(validate(this.value,$plies_check)==1010) { this.value=0; }\" pattern='^\d+(?:\.\d{1,2})?$'></div></td></tr>";
			echo "<tr>
					<td>Fabric Received</td>
					<td>:</td>
					<td><div class='col-sm-4'>
						<input type=\"hidden\" name=\"old_fab_rec\" value=\"$fab_received\">
						<input type=\"number\" class='form-control'  min=0 name=\"fab_rec\" value=".round($material,2)." step=any>
					</div></td>
				</tr>";
			echo "<tr><td>Fabric Returned</td><td>:</td><td><div class='col-sm-4'><input type=\"hidden\" name=\"old_fab_ret\" value=\"$fab_returned\"><input type=\"number\" class='form-control'  min=0 pattern='^\d+(?:\.\d{1,2})?$'  name=\"fab_ret\" value=\"0\"></div>&nbsp;<div class='col-sm-2'> <b>To</b></div><div class='col-sm-4'> <select name=\"ret_to\" class='form-control'><option value=\"0\">Cutting</option><option value=\"1\">RM</option></select></div></td></tr>";
			echo "<tr><td>Damages</td><td>:</td><td><div class='col-sm-4'><input type=\"hidden\" name=\"old_damages\" value=\"$fab_damages\"><input type=\"number\" class='form-control' name=\"damages\"  min=0 pattern='^\d+(?:\.\d{1,2})?$'  value=\"0\"></div></td></tr>";
			echo "<tr><td>Shortages</td><td>:</td><td><div class='col-sm-4'><input type=\"hidden\" name=\"old_shortages\" value=\"$fab_shortages\"><input type=\"number\" class='form-control' pattern='^\d+(?:\.\d{1,2})?$' name=\"shortages\"  min=0 value=\"0\"></div></td></tr>";

			echo "<tr><td>Bundle Location</td><td>:</td><td><div class='col-sm-4'><select name=\"bun_loc\" class='form-control'>";
			echo "<option value='' style='background-color:#FF5500;'>Select Location</option>";
			$location_Query="SELECT * FROM $bai_pro3.`locations`";
			$Location_result=mysqli_query($link, $location_Query) or exit("Error getting Location Details");
			while($locations=mysqli_fetch_array($Location_result))
			{
				$location[]=$locations['loc_name'];
			}
			// var_dump($location);
			for($i = 0; $i < sizeof($location); $i++)
			{
				echo "<option value='".$location[$i]."' style='background-color:#FFFFAA;'>".$location[$i]."</option>";
			}
			echo "</select></div>
			</td></tr>";
			//echo "<tr><td>remarks</td><td>:</td><td><input type=\"text\" name=\"remarks\" value=\"NIL\"></td></tr>";

			echo "<tr style='display:none;'><td><input type=\"hidden\" name=\"remarks\" value=\"$fab_remarks\"></td></tr>";

			echo "</table></div>";
		}
		if($statusn==0)
		{	
	?>
	<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable<input type = "submit" name = "update" value = "Update" class="btn btn-primary" id="update" onclick="document.getElementById('update').style.display='none'; document.getElementById('msg').style.display='';">
	<?php
	}
	else
	{
		echo "<h2>Please split the Colour and try Again..!</h2>";
		
	}
	?>
</form>
<span id="msg" style="display:none;"><h1><font color="red">Please wait while updating database...</font></h1></span>
</div></div>
</body>

