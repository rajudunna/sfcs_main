
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$view_access=user_acl("SFCS_0165",$username,1,$group_id_sfcs);
$auth_users=user_acl("SFCS_0165",$username,7,$group_id_sfcs);
?>
	<?php


?>

	
	<script>
		function check_date(x,yy,xx) //form date, allowed date, today date
		{
			var d = new Date();
			var curr_hour = d.getHours();
			
			if (x< yy)
			{ 
				alert("Pleae enter correct date");
				document.input.date.value=xx;
			}
			if(x>xx)
			{
				alert("Pleae enter correct date");
				document.input.date.value=xx;
			}
			
			if (x==yy && curr_hour<=23)
			{
				
			}
			else
			{
				alert("You are not Authorized to Update Backdated Changes.");
				document.input.date.value=xx;
			}
			
		}
		
		function check_date1(x,yy,xx) //form date, allowed date, today date
		{
			var d = new Date();
			var curr_hour = d.getHours();
			
			if (x< yy)
			{ 
				alert("Pleae enter correct date");
				document.input.edate.value=xx;
			}
			if(x>xx)
			{
				alert("Pleae enter correct date");
				document.input.edate.value=xx;
			}
			
			if (x==yy && curr_hour<=23)
			{
				
			}
			else
			{
				alert("You are not Authorized to Update Backdated Changes.");
				document.input.edate.value=xx;
			}
			
		}


		function check_mod()
		{

			var mod=document.getElementById('module').value;
			if(mod=='')
			{
				sweetAlert('Please Enter Module','','warning');
				return false;
			}
			else
			{
				return true;
			}

		}
		function check_fields()
		{

			var mod=document.getElementById('module').value;
			var shift=document.getElementById('shift').value;

			var style=document.getElementById('style').value;
			var new_smv=document.getElementById('new_smv').value;
			var new_nop=document.getElementById('new_nop').value;
			var reason=document.getElementById('reason').value;


			if(mod=='')
			{
				sweetAlert('Please select Module First','','warning');
				return false;
			}
			else if(shift=='')
			{
				sweetAlert('Please select shift ','','warning');

				return false;
			}
			else if(style=='')
			{
				sweetAlert('Please enter style ','','warning');

				return false;
			}
			else if(new_smv=='')
			{
				sweetAlert('Please enter Smv ','','warning');

				return false;
			}
			else if(new_nop=='')
			{
				sweetAlert('Please enter Nop ','','warning');

				return false;
			}
			else if(reason=='')
			{
				sweetAlert('Please enter Reason ','','warning');

				return false;
			}
			else
			{
				return true;
			}

		}


		jQuery(document).ready(function($){
		    $('#style').keypress(function (e) {
		        var regex = new RegExp("^[0-9a-zA-Z\]+$");
		        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		        if (regex.test(str)) {
		            return true;
		        }
		        e.preventDefault();
		        return false;
		    });
		});
			jQuery(document).ready(function($){
		    $('#new_smv').keypress(function (e) {
		        var regex = new RegExp("^[0-9.\]+$");
		        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		        if (regex.test(str)) {
		            return true;
		        }
		        e.preventDefault();
		        return false;
		    });
		});
				jQuery(document).ready(function($){
		    $('#new_nop').keypress(function (e) {
		        var regex = new RegExp("^[0-9\]+$");
		        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		        if (regex.test(str)) {
		            return true;
		        }
		        e.preventDefault();
		        return false;
		    });
		});





		function pop_check(){
		var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";

		for (var i = 0; i < document.input.style.value.length; i++) 
		{
		    if (iChars.indexOf(document.input.style.value.charAt(i)) != -1) 
		    {
		       sweetAlert('Please Enter Valid Style ','','warning');
		       document.input.style.value='';
		        return false;
		    }
		    else {
		    	return true;
		    }

		}
		}


	</script>
	
	<div class="panel panel-primary">
		<div class="panel-heading"><b>Modify SMV NOP OF <?php echo date("Y-m-d") ?></b> </div>
		<div class="panel-body">
			<div class="alert alert-success" style="display:none;">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Info! </strong><span class="sql_message"></span>
			</div>
		<?php 		
		
		$sql="SELECT DISTINCT bac_date FROM $bai_pro.bai_log_buf WHERE bac_date<\"".date("Y-m-d")."\" ORDER BY bac_date DESC";
		// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$max_allowed_date=$sql_row['bac_date'];
		}
		
		//#136480 Time based restrictions
		$max_allowed_date=date("Y-m-d");
		
		if(in_array($username,$auth_users))
		{
			echo '<div class="x_content">';
			if($username=="kiran")
			{
				echo '<form name="input" id="demo-form2" method="post" action="?r='.$_GET['r'].'" data-parsley-validate class="form-horizontal form-label-left">
				<div class="form-group">
					<div class="col-md-4 col-sm-6 col-xs-12">
						<input type="text" value="'.date("Y-m-d").'" name="date" onchange="check_date(this.value,\''.$max_allowed_date.'\',\''.date("Y-m-d").'\');" id="start-date" required="required" class="form-control col-md-7 col-xs-12" readonly="true">
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-4 col-sm-6 col-xs-12">
						<input type="text" readonly="true" value="'.date("Y-m-d").'" name="edate" onchange="check_date1(this.value,\''.$max_allowed_date.'\',\''.date("Y-m-d").'\');" id="end-date" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				</div>';
			}
			else
			{
				echo '<form name="input" id="demo-form2" method="post" data-parsley-validate action="?r='.$_GET['r'].'" class="form-horizontal form-label-left">
				<div class="form-group">
					<div class="col-md-4 col-sm-6 col-xs-12">
						<input type="hidden" readonly="true" value="'.date("Y-m-d").'" name="date" onchange="check_date(this.value,\''.$max_allowed_date.'\',\''.date("Y-m-d").'\');" id="start-date" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-4 col-sm-6 col-xs-12">
						<input type="hidden" readonly="true" value="'.date("Y-m-d").'" name="edate" onchange="check_date1(this.value,\''.$max_allowed_date.'\',\''.date("Y-m-d").'\');" id="end-date" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				</div>';
			}
			
			echo '<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="module">Module <span class="">*</span></label>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<select name="module" id="module" class="form-control col-md-7 col-xs-12" >';
					echo '<option value="" selected	>Please Select</option>';
				$sql="SELECT GROUP_CONCAT(sec_mods) as mods FROM $bai_pro3.sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
				//echo $sql;
				$result7=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($result7))
				{
					$sql_mod=$sql_row["mods"];
				}
				// $module=1;
				$sql_mods=explode(",",$sql_mod);
				for($i=0;$i<sizeof($sql_mods);$i++)
				{
					if($sql_mods[$i]==$module)
					{
						echo "<option value=\"".$sql_mods[$i]."\" selected>".$sql_mods[$i]."</option>";
					}
					else
					{
						echo "<option value=\"".$sql_mods[$i]."\">".$sql_mods[$i]."</option>";
					}	
				}
				echo "</select>";
			echo '</div>
			</div>';
			echo '<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="shift">Shift <span class="required">*</span></label>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<select name="shift" id="shift" class="form-control col-md-7 col-xs-12" onclick="return check_mod()">';
					echo '<option value="">Please Select</option>';
				foreach ($shifts_array as $key1 => $shift) {
					echo '<option value="'.$shift.'">'.$shift.'</option>';
				}
			echo '</select>';
			echo '</div>';
			echo '</div>';
			echo '<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="style">Style <span class="required">*</span>
				</label>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<input type="text" name="style"  id="style" onchange="return pop_check()"  class="form-control col-md-7 col-xs-12">
				</div>
			</div>';
			echo '<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="new_smv">New SMV <span class="required">*</span>
				</label>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<input type="text" name="smv" id="new_smv" oncopy="return false" onpaste="return false"  class="form-control col-md-7 col-xs-12">
				</div>
			</div>';
			echo '<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="new_nop">New NOP <span class="required">*</span>
				</label>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<input type="text" name="nop" id="new_nop" oncopy="return false" onpaste="return false"  class="form-control col-md-7 col-xs-12">
				</div>
			</div>';
			echo '<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="reason">Reason<span class="required">*</span>
				</label>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<input type="text" name="reason" id="reason" class="form-control col-md-7 col-xs-12">
				</div>
			</div>';
			echo '<div class="form-group">
				<div class="col-md-2 col-md-offset-5">

					<input type="submit" name="submit" id="submit" class="btn btn-primary" value="Save" onclick="return check_fields()">
				</div>
			</div>';
			echo '</form></div>';
		}
		else
		{
			echo "<h2><font color=red>You are not authorised to use this interface.</font></h2>";
		}

	?>
	</div>
	<!-- </div> -->
	<?php
		if(isset($_POST['submit']))
		{
			
			$date=$_POST['date'];
			$edate=$_POST['edate'];
			$module=$_POST['module'];
			$shift=$_POST['shift'];
			$style=$_POST['style'];
			$smv=$_POST['smv'];
			$nop=$_POST['nop'];
			$reason=$_POST['reason'];
			
			if($date!="" and $module!="" and $shift!="" and $style!="" and $smv!="" and $nop!="" and strlen($reason)>0)
			{
				$link->autocommit(FALSE);
				$flag = true;
				$sql2="update $bai_pro.bai_log set smv=$smv, nop=$nop where bac_no in ($module) and bac_shift in ('".$shift."') and bac_style=\"$style\" and bac_date between \"$date\" and \"$edate\"";
				// echo $sql2;
				$run_sql2 = mysqli_query($link, $sql2);

				if(mysqli_affected_rows($link) != NULL) {
					$sql2="update $bai_pro.bai_log_buf set smv=$smv, nop=$nop where bac_no in ($module) and bac_shift in ('".$shift."') and bac_style=\"$style\" and bac_date between \"$date\" and \"$edate\"";
					// echo $sql2;
					$run_sql3 = mysqli_query($link, $sql2);

					if(mysqli_affected_rows($link) == NULL) {
						$flag = false;
					}
				}else {
					$flag = false;
				}
				if($flag) {
					mysqli_commit($link);
					$sql_message = "Data Updated Succesfully...";
					$message2="<table class='table table-bordered'>
					<tr><td>Style</td><td>:</td><td>$style</td></tr>
					<tr><td>New SMV</td><td>:</td><td>$smv</td></tr>
					<tr><td>New NOP</td><td>:</td><td>$nop</td></tr>
					<tr><td>Period</td><td>:</td><td>$date to $edate</td></tr>";
					if(strlen($module)>4)
					{
						$message2.="<tr><td>Modules</td><td>:</td><td>All</td></tr>";
					}
					else
					{
						$message2.="<tr><td>Modules</td><td>:</td><td>$module</td></tr>";
					}
					$message2.="<tr><td>Reason</td><td>:</td><td>$reason</td></tr>";
					$message2.="</table>";
					
					
					
					//MAIL Communication	
					$message= '<html><head><style type="text/css">
					
					body
					{
						font-family: arial;
						font-size:12px;
						color:black;
					}
					table
					{
					border-collapse:collapse;
					white-space:nowrap; 
					}
					th
					{
						color: black;
					border: 1px solid #660000; 
					white-space:nowrap; 
					padding-left: 10px;
					padding-right: 10px;
					}
					
					td
					{
						background-color: WHITE;
						color: BLACK;
					border: 1px solid #660000; 
						padding: 1px;
					white-space:nowrap; 
					}
					
					</style></head><body> Dear All, <br/><br/> Please find below changes in SMV/NOP for given style. <br/><br/>Note: This will effect to SAH and Incentive calculation too.<table>';
					
					
					$message.=$message2;
						
					//echo $message;
					// $message.="</table>";
					// $message .='<br/>Message Sent Via: '.$dns_adr1.'';
					// $message.="</body></html>";
					
					// $to  = 'BAI2ProductionTeam@brandix.com';
					
					//$to  = 'brandixalerts@schemaxtech.com';
					// $subject = 'Style SMV/NOP Amendments';
					
					//To send HTML mail, the Content-type header must be set
					// $headers  = 'MIME-Version: 1.0' . "\r\n";
					// $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
					// Additional headers
					// $headers .= 'To: <BAI2ProductionTeam@brandix.com>;'. "\r\n";
					//$headers .= 'To: <brandixalerts@schemaxtech.com>'. "\r\n";
					// $headers .= 'From: Shop Floor System Alert <ictsysalert@brandix.com>'. "\r\n";
					
					//Mail Communication
					echo "<h2><font color=Green>Please run daily efficiency report to apply changes!</font></h2>";
				}else {
					mysqli_rollback($link);
					$sql_message = "Style, you entered is not in records. Please try again with new style.";
					
					// $sql_message = "Error in updating data, Please try after some time or contact IT team";
				}
			} else {
			
			}
			echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
		}
		echo "</div>";
		echo "</div>";
		?>
		