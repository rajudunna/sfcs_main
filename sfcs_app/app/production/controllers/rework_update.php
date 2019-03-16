<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
 
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
    $has_permission=haspermission($_GET['r']);
	

	$workstudy_limit="23.59";
	$user_limit="23.59";

?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Rework Update</title>
<style>
	body{ font-family:arial; font-size: 12px;}


a {text-decoration: none;}

.atip
{
	color:black;
}

table
{
	border-collapse:collapse;
	font-size:12px;
}
.new td
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

.new th
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

.bottom
{
	border-bottom: 3px solid white;
	padding-bottom: 5px;
	padding-top: 5px;
	
}

</style>
<script>

function firstbox()
{
	window.location.href ="<?= getFullURLLevel($_GET['r'],'rework_update.php',0,'N'); ?>&section="+document.select_module.select_section.value
}
function second_box(){
	var sdate = document.getElementById('sdate').value;
}

</script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check.js',1,'R'); ?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />

<script>
	
    window.onload = function () 
	{
        noBack();
    }
    window.history.forward();
    function noBack() 
	{
        window.history.forward();
    }
</script>

 <script language="JavaScript">

	var version = navigator.appVersion;

	function showKeyCode(e) 
	{
		var keycode = (window.event) ? event.keyCode : e.keyCode;

		if ((version.indexOf('MSIE') != -1)) {
			if (keycode == 116) {
				event.keyCode = 0;
				event.returnValue = false;
				return false;
			}
		}
		else {
			if (keycode == 116) {
				return false;
			}
		}
	}

    </script>
    
    <script>
    	
    function doesConnectionExist() {
	    var xhr = new XMLHttpRequest();
	    var file = "alert.gif";
	    var randomNum = Math.round(Math.random() * 10000);
	     
	    xhr.open('HEAD', file + "?rand=" + randomNum, false);
	     
	    try {
	        xhr.send();
	         
	        if (xhr.status >= 200 && xhr.status < 304) {
	            return true;
	        } else {
	            return false;
	        }
	    } catch (e) {
	        return false;
	    }
	}
    
    
    function checkandupdate()
    {
		document.getElementById('submitbtn').style.visibility="hidden";
		document.getElementById('process_message').style.visibility="visible";
				
		if(doesConnectionExist(Math.random())==true)
		{
			document.getElementById("test").submit();
		}
		else
		{
			alert("Server is offline... Please try again...");
			document.getElementById('submitbtn').style.visibility="visible";
			document.getElementById('process_message').style.visibility="hidden";
		}
	}
	
	function checkenable()
	{
		document.getElementById('submitbtn').style.visibility="visible";
		document.getElementById('optionnew').style.visibility="hidden";		
	}

	function enableButton() 
	{
		if(document.getElementById('option').checked)
		{
			document.getElementById('update').disabled='';
		} 
		else 
		{
			document.getElementById('update').disabled='true';
		}
	}

	function button_disable()
	{
		document.getElementById('process_message').style.visibility="visible";
		document.getElementById('update').style.disabled='true';
	}

	function validateThisFrom(thisForm) 
	{
		if (thisForm.module.value == "0")
		{
			sweetAlert("Please select MODULE",'','warning');
			return false;
		}

		if (thisForm.zone_base.value == "NIL")
		{
			sweetAlert("Please select TIME",'','warning');
			return false;
		}		
	}

	function check_section(){
		if(document.getElementById('select_section').value == 'NIL')
			sweetAlert('Please select Section','','warning');
	}

	
	function verify_qty(num,t,e){
		if(e.keyCode == 8 || e.keyCode == 9){
			return;
		}
		var chars = /^[0-9]+$/;
		var id = t.id;
		var n = document.getElementById(id);
		if( !(n.value.match(chars)) && n.value!=null){
			sweetAlert('Please Enter Only Numbers','','warning');
			n.value ='';
			return false;
		}

		if(n.value > num ){
			sweetAlert('warning','Rework Quantity Must be Less than or Equal to Balance','warning');
			n.value = '';
			return;
		}
	}

	function check_date()
	{
		var from_date = document.getElementById("sdate").value;
		var today = document.getElementById("today").value;
		if ((Date.parse(from_date) > Date.parse(today)))
		{
			sweetAlert('Please Select Valid Date','','warning');
			document.getElementById("sdate").value = "<?php  echo date("Y-m-d");  ?>";
		}
		window.location.href ="<?= getFullURLLevel($_GET['r'],'rework_update.php',0,'N'); ?>&sdate="+document.getElementById('sdate').value

	}
	</script>
</head>


<body onload="dodisable();" onpageshow="if (event.persisted) noBack();" onkeydown="return showKeyCode(event)">
<div class="panel panel-primary">
<div class="panel-heading">Re-Work Capturing </div>
<div class="panel-body">
	<?php
	    // include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/rework_functions.php',1,'R'));
		$username_list=explode('\\',$_SERVER['REMOTE_USER']);
		$username=strtolower($username_list[1]);
		if($_POST['select_section']){
			$section=$_POST['select_section'];
		}else{
			$section=$_GET['section'];
		}
		// $section=$_GET['section'];
		if($_POST['date'])
		{
			$sdate = $_POST['date'];
		}
		else if($_GET['sdate'])
		{
			$sdate = $_GET['sdate'];
		}
		else
		{
			$sdate = date('Y-m-d');
		}

		$module_ref=$_POST['module']; 
		$shift=$_POST['shift'];
		$zone_base=$_POST['zone_base'];
	?>

	<?php 
		$sql="SELECT DISTINCT bac_date FROM $bai_pro.bai_log_buf WHERE bac_date=\"".date("Y-m-d")."\" ORDER BY bac_date DESC LIMIT 1";
		//echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error7896".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$max_allowed_date=$sql_row['bac_date'];
		}
		$max_allowed_date=date("Y-m-d");

		$sql12="UPDATE $bai_pro3.ims_log SET ims_status=\"DONE\" WHERE ims_qty=ims_pro_qty";
		mysqli_query($link, $sql12) or exit("Sql Error74125".mysqli_error($GLOBALS["___mysqli_ston"]));
	?>
<!--<div id="page_heading"><span style="float"><h3>Rework Update Panel</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>-->
	<form action="#" method="POST" onsubmit="return validateThisFrom (this);" name="select_module" id="select_module">
		 <!-- <input type="hidden" name="today" id="today" value="<?php echo date("Y-m-d"); ?>">
		<div class="col-sm-2"><?php 
			
			if(in_array($authorized,$has_permission))
			{
				echo "Date: <input type='text' data-toggle='datepicker' id='sdate' class='form-control' name='date' value='".$sdate."' onchange='check_date();' autocomplete='off'>"; 
			}
		echo "</div>";
		?>	 -->	
	<div class="col-sm-2">
		Shift:	<select name="shift" class="form-control">
					<?php 
						for ($i=0; $i < sizeof($shifts_array); $i++) {?>
							<option  <?php echo 'value="'.$shifts_array[$i].'"'; if($shift==$shifts_array[$i]){ echo "selected";}   ?>><?php echo $shifts_array[$i] ?></option>
						<?php }
					?>
				</select>
	</div> 
	<?php	
		echo "<div class='col-sm-2'>Select Section: <select name='select_section' class='form-control' id='select_section' onchange=\"firstbox();\" >";
		echo "<option value=\"NIL\" selected>Please Select</option>";
		$sql="SELECT sec_id FROM $bai_pro3.sections_db WHERE sec_id>0";
		// echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Error while getting Sections");
		
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if(str_replace(" ","",$sql_row['sec_id'])==str_replace(" ","",$section))
			{
				echo "<option value=\"".$sql_row['sec_id']."\" selected>".$sql_row['sec_id']."</option>";
			}
			else
			{
				echo "<option value=\"".$sql_row['sec_id']."\">".$sql_row['sec_id']."</option>";
			}

		}
		echo "</select></div>";	

		echo "<div class='col-sm-2'>Module: <select name='module' class='form-control' id='module' onclick='check_section()'>";
		echo "<option value='0' selected>Select Module</option>";
		$sql="select group_concat(sec_mods) as \"sec_mods\" from $bai_pro3.sections_db where sec_id in (\"$section\")";
		// echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$sec_mods=$sql_row['sec_mods'];
		}
		$modules=array();
		$modules=explode(",",$sec_mods);
		for ($i=0; $i < sizeof($modules); $i++) 
		{ 
				if ($modules[$i] != '' || $modules[$i] != null)
			{
			if ($module_ref==$modules[$i])
			{
				$selected = 'selected';
			}
			else
			{
				$selected = '';
			}
			echo "<option value='".$modules[$i]."' ".$selected.">".$modules[$i]."</option>";
			}
		}


		echo "</select></div>";

?></br>
	<div class="col-sm-2">
	<input type="submit" name="submit11" id="submit11" onclick="check_all_details();" class="btn btn-primary" value="Submit">
	</div>

</form>
<br><br>
<?php

	//To avoid Duplicate Entry - 20150511 Kirang
	session_start();
	$secret=md5(uniqid(rand(), true));
	$_SESSION['FORM_SECRET'] = $secret;

if (isset($_POST['submit11']))
{
?>		
	<FORM method="post" name="test" action="<?= getFullURLLevel($_GET['r'],'rework_update_process.php',0,'N');?>" enctype="multipart/form-data" id="test">
		<!--<input type='hidden' name='r' value="<?= base64_encode(getFullURLLevel($_GET['r'],'rework_update_process.php',0,'R')) ?>">-->
		<input type="hidden" name="form_secret" value="<?php echo $_SESSION['form_secret']; ?>" id="form_secret">
		<input type="hidden" name="date" value="<?php echo $_POST['date']; ?>">
		<input type="hidden" name="module" value="<?php echo $_POST['module']; ?>"> 		
		<input type="hidden" name="section" value="<?php echo $_POST['select_section']; ?>"> 		
		
		<input type="hidden" name="zone_base" value="<?php echo $_POST['zone_base']; ?>"> 		
				
	<?php

		
		
		$toggle=0;
		$j=1;
		// for($i=0; $i<sizeof($modules); $i++)
		{
			if($toggle==0)
			{
				$tr_color="#66DDAA";
				$toggle=1;
			}
			else if($toggle==1)
			{
				$tr_color="white";
				$toggle=0;
			}
		
			$rowcount_check=0;
			$for_zero_entries=0;
			$row_count = 0;
			
		   $sql="select distinct rand_track from $bai_pro3.ims_log where ims_mod_no=$module_ref  and ims_status<>\"DONE\" and ims_remarks NOT IN ('EXCESS','SAMPLE','EMB') and ims_shift = '$shift' order by ims_doc_no";
		  // echo $sql;
           $sql_result=mysqli_query($link, $sql) or exit("Sql Error111".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result)>0)
			{
				
				echo '<div class="table-responsive"><table class="table table-bordered"		style="color:black; border: 1px solid red;">';
				echo "<tr class=\"new\">";
				echo "<th>Style</th><th>Schedule</th><th>Color</th><th>Cut#</th><th>Sewing Job#</th><th>Size</th><th>Input</th><th>Output</th><th>Balance</th>";
				// echo "<th>QTY</th><th>SMV</th><th>SMO</th><th>Status</th>";
				echo "<th>Rework Qty</th><th>Remarks</th></tr>";

				$id_count = 0;	
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$row_count++;
					$id_count++;
					$rand_track=$sql_row['rand_track'];
					$sql12="select * from $bai_pro3.ims_log where ims_mod_no=$module_ref and rand_track=$rand_track  and ims_status<>\"DONE\" and ims_remarks NOT IN ('EXCESS','SAMPLE','EMB') and ims_shift = '$shift' order by ims_schedule, ims_size DESC";
					
					$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error556".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row12=mysqli_fetch_array($sql_result12))
					{
						
						$ims_doc_no=$sql_row12['ims_doc_no'];
						$shift=$sql_row12['ims_shift'];
					
						$sql22="select * from $bai_pro3.live_pro_table_ref where doc_no=$ims_doc_no and a_plies>0";
						//echo $sql22;
						$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));

						while($sql_row22=mysqli_fetch_array($sql_result22))
						{
							$color_code=$sql_row22['color_code']; //Color Code
							$cutno=$sql_row22['acutno'];
						}
						
						
						$sql33="select style_id from $bai_pro2.movex_styles where movex_style like \"%".$sql_row12['ims_style']."%\"";
						$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row33=mysqli_fetch_array($sql_result33))
						{
							$user_style=$sql_row33['style_id']; //Color Code
						}
						
						echo '<input type="hidden" name="shift[]" value="'.$sql_row12['ims_shift'].'">';
						echo '<input type="hidden" name="module[]" value="'.$module_ref.'">';
						echo '<input type="hidden" name="style[]" value="'.$user_style.'">';
						echo '<input type="hidden" name="m3_style[]" value="'.$sql_row12['ims_style'].'">'; //M3_Style code for Bulk Operation Reporting
						echo '<input type="hidden" name="schedule[]" value="'.$sql_row12['ims_schedule'].'">';
						echo '<input type="hidden" name="color[]" value="'.$sql_row12['ims_color'].'">';
						echo '<input type="hidden" name="cut[]" value="'.$sql_row12['ims_doc_no'].'">';
						echo '<input type="hidden" name="size[]" value="'.$sql_row12['ims_size'].'">';
						echo '<input type="hidden" name="tid[]" value="'.$sql_row12['tid'].'">';
						//$module_no=$sql_row12['ims_mod_no'];
						//To extract as per the M3 Size
						$size_value=ims_sizes('',$sql_row12['ims_schedule'],$sql_row12['ims_style'],$sql_row12['ims_color'],strtoupper(substr($sql_row12['ims_size'],2)),$link11);
						echo "<tr>";
						if($rowcount_check==1)
						{
							$display_prefix3 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$sql_row12['ims_schedule'],$sql_row12['ims_color'],$sql_row12['input_job_no_ref'],$link);
							echo "<td>".$sql_row12['ims_style']."</td><td>".$sql_row12['ims_schedule']."</td><td>".$sql_row12['ims_color']."</td><td>".chr($color_code).leading_zeros($cutno,3)."</td><td>".$display_prefix3."</td><td>".strtoupper($size_value)."</td><td>".$sql_row12['ims_qty']."</td><td>".$sql_row12['ims_pro_qty']."</td><td>".($sql_row12['ims_qty']-$sql_row12['ims_pro_qty'])."</td>";
							$balance=$sql_row12['ims_qty']-$sql_row12['ims_pro_qty'];
							// echo '<td><input type="text" name="qty[]" autocomplete="off" size="8" onchange="if(check(this.value, '.($sql_row12['ims_qty']-$sql_row12['ims_pro_qty']).')==1010){ this.value=0;}" value="0" tabindex="'.$j.'" style="background-color:green; color=white;"></td>';
							
							$rowcount_check=0;
						}
						else
						{
							$display_prefix4 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$sql_row12['ims_schedule'],$sql_row12['ims_color'],$sql_row12['input_job_no_ref'],$link);
							
							echo "<td>".$sql_row12['ims_style']."</td><td>".$sql_row12['ims_schedule']."</td><td>".$sql_row12['ims_color']."</td><td>".chr($color_code).leading_zeros($cutno,3)."</td><td>".$display_prefix4."</td><td>".strtoupper($size_value)."</td><td>".$sql_row12['ims_qty']."</td><td>".$sql_row12['ims_pro_qty']."</td><td>".($sql_row12['ims_qty']-$sql_row12['ims_pro_qty'])."</td>";
							$balance=$sql_row12['ims_qty']-$sql_row12['ims_pro_qty'];
							// echo '<td><input type="text" name="qty[]" autocomplete="off" size="8" onchange="if(check(this.value, '.($sql_row12['ims_qty']-$sql_row12['ims_pro_qty']).')==1010){ this.value=0;}" value="" tabindex="'.$j.'" style="background-color:green; color=white;"></td>';
						}
						
						
						$mod_stat=="Down";
						$sqlx="select * from $bai_pro.pro_mod_today where mod_date=(select max(mod_date) from $bai_pro.pro_mod_today) and mod_no=\"$module_ref\"";
						// echo $sqlx;
						$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error963 $sqlx".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_rowx=mysqli_fetch_array($sql_resultx))
						{
							$mod_sec=$sql_rowx['mod_sec'];
							$mod_stat=$sql_rowx['mod_stat'];
							$mod_rem=$sql_rowx['mod_remarks'];
							$id_count++;
							echo "<td><input type=\"number\" min=0 max=$balance onkeyup='verify_qty($balance,this,event)' onchange='verify_qty($balance,this,event)' name=\"rework_qty[]\" value=\"\"  id=\"rqty$id_count\"/></td>";
							echo "<td> <input type=\"text\" name=\"remarks[]\" value=\"".$mod_rem."\" /></td><input type=\"hidden\" name=\"csnb_code[]\" value=\"$couple_x^$smv^$nop^$buyer^$section\">";								
						}
						

						//NEW when pro_mod not been updated.
						if(mysqli_num_rows($sql_resultx)==0)
						{							
							echo "<td><input type=\"number\" min=0 max=$balance onkeyup='verify_qty($balance,this,event)' onchange='verify_qty($balance,this,event)' id=\"rqtyy$id_count\" name=\"rework_qty[]\" value=\"\"/></td>";
							echo "<td> <input type=\"text\" name=\"remarks[]\" value=\"".$mod_rem."\" /></td><input type=\"hidden\" name=\"csnb_code[]\" value=\"$couple_x^$smv^$nop^$buyer^$section\">";
						}
						
						// For module status updation
						echo "</tr>";
						$j++;
					}
				}
			}
		}
		
		echo "</table></div>";
		if($row_count == 0){
			echo "<div class='alert alert-danger'>No Data Found</div>";
			echo "<script>$(document).ready(function(){
				      $('#option').css('display','none');
			      });</script>";
		}else{
			if(in_array($authorized,$has_permission))
			{
				echo '<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable';
				echo '<input type="submit" name="update" class="btn btn-primary" id="update" value="Update" onclick="javascript:button_disable();" onclick="">';
			}
		}
	?>

		

		<br/><br/>
			<div id="process_message">
				<div class='col-sm-6'>
				<span class='alert alert-warning'><font color="white">Please wait while updating data!!!</font></span>
				</div>
			</div>
		</FORM>

		<script>
			document.getElementById('process_message').style.visibility="hidden";
			document.getElementById('submitbtn').style.visibility="hidden";			
		</script>

	<?php
		}

			?>		


	
</div></div>
</body>
</div>