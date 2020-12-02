<!DOCTYPE html>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$has_permission = haspermission($_GET['r']);
$mins=array("00","05","10","15","20","25","30","35","40","45","50","55");
?>
<script>
$(function(){
	today=new Date();
	var month,day,year;
	year=today.getFullYear();
	month=today.getMonth();
	date=today.getDate();
	var backdate = new Date(year,month,date)
	$('.datepicker1').datepicker({
	format: 'yyyy-mm-dd',
	//startDate: backdate,
	endDate: '+0d',
	autoHide: true
    });
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
		startDate: backdate,
        endDate: '+0d',
        autoHide: true
    });
});
</script>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
</head>
<body>
<?php
 if(isset($_REQUEST['rowid']))
 {
	 $c_id=$_REQUEST['rowid'];
	 $date=$_REQUEST['date'];
	 $section=$_REQUEST['section'];
	 $shift=$_REQUEST['shift'];
	 $modno=$_REQUEST['module'];
	 $style=$_REQUEST['style'];
	 $schedule=$_REQUEST['schedule'];
	 $nop=$_REQUEST['nop'];
	 $start_time=$_REQUEST['start_time'];
	 $end_time=$_REQUEST['end_time'];
	 $lost_min=$_REQUEST['lost_min'];
	 $remarks=$_REQUEST['remarks'];
	 $source=$_REQUEST['source'];
	 $department=$_REQUEST['department'];
	 $reason_code=$_REQUEST['reason_code'];
	 $exception_time=$_REQUEST['exception_time'];
	 
 }else
 {
	 $c_id=0;
 }
 if($date==''){
	$date=date("Y-m-d");
 }
$action_url = getFullURL($_GET['r'],'down_time_update_V2.php','N');
	
?>
 <div class='panel panel-primary'>
		<div class='panel-heading'>
			<b>DownTime Update</b>
		</div>

	<div class='panel-body'>
	<form action="<?= $action_url ?>" id="formentry" method="POST" class="form-horizontal" role="form" data-parsley-validate novalidate>
                <input type='hidden' id='c_id' name='c_id' value="<?php echo $c_id; ?>" >
							<div class="container-fluid shadow">
								<div class="row">
									<div id="valErr" class="row viewerror clearfix hidden">
										<div class="alert alert-danger">Oops! Seems there are some errors..</div>
									</div>
									<div id="valOk" class="row viewerror clearfix hidden">
										<div class="alert alert-success">Yay! ..</div>
									</div>
								</div>
							</div>
						<div class="row">
						<div class="col-md-4">
								<div class="form-group">
									<label class="control-label control-label-left col-sm-3" for="date" >Date<span class="req" style='color:red;'> *</span></label>
											<div class="controls col-sm-9">
											
													<?php 



													$sql="SELECT DISTINCT bac_date FROM $bai_pro.bai_log_buf WHERE bac_date<\"".date("Y-m-d")."\" ORDER BY bac_date";

													$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
													while($sql_row=mysqli_fetch_array($sql_result))
													{
														$max_allowed_date=$sql_row['bac_date'];
													}

													// if(in_array($username,$auth_users))
													if(in_array($authorized,$has_permission))
													{
														echo '<input type="text" class="form-control" name="date" value="'.$date.'" size="10" >'; 
													}
													else
													{
														echo '<input type="text" class="form-control" name="date" readonly value="'.date("Y-m-d").'" size="10" onchange="check_date(this.value,\''.$max_allowed_date.'\',\''.date("Y-m-d").'\');" >'; 
													}

													?>

								</div>
								</div>
								</div>
								<div class="col-md-4">
								<div class="form-group">
									<label class="control-label control-label-left col-sm-3" for="sections" >Section<span class='req' style="color:red;">*</span></label>
											<div class="controls col-sm-9">
												<?php 
												include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
												$conn=$link;
												echo "<select id='sections' class='form-control' data-role='select'  name='sections'  data-parsley-errors-container='#errId2' required>";
									
												echo "<option value='Please Select'  disabled selected>Please Select</option><br/>\r\n";
												$query = "select * from $bai_pro3.sections_master order by sec_id";
												$result = $conn->query($query);
												while($row = $result->fetch_assoc()) 
												{ 
													
													$sec_name=$row['sec_name'];
													
													$section_display_name=$row['section_display_name'];
													if($section == $sec_name){
														echo "<option value='".$sec_name."' selected>$section_display_name</option>";

													}else{
														echo "<option value='".$sec_name."'>$section_display_name</option>";

													}
					
												}
												echo "</select>";
											?>      
											</div>
										</div>
									</div>   
                                <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label control-label-left col-sm-3" for="shift" >Shift<span class='req' style="color:red;">*</span></label>
                                       <div class="controls col-sm-9">
                                           <?php 
											$conn=$link;
											echo "<select id='shift' class='form-control' data-role='select'  name='shift'  data-parsley-errors-container='#errId2' required>";
								
											echo "<option value='Please Select'  disabled selected>Please Select</option><br/>\r\n";
											
		
											$shifts = (isset($_GET["shift"]))?$_GET["shift"]:'';
											foreach($shifts_array as $shift){
												if($shifts == $shift){
												echo "<option value=".$shift." selected>".$shift."</option>";
												}else{
												echo "<option value=".$shift.">".$shift."</option>";
												}
											}
										
							               echo "</select>";
						                   ?>      
						              </div>
								</div>
							   </div>   
							   </div></br>
							<div class="row">
							 <div class="col-md-4">
                             <div class="form-group">
                               <label class="control-label control-label-left col-sm-3" for="module" >Module<span class='req' style="color:red;">*</span></label>
                                       <div class="controls col-sm-9">
                                           <?php 
										echo "<select id='module' class='form-control' data-role='select'  name='module'  data-parsley-errors-container='#errId2' required>";
							
										echo "<option value='Please Select'  disabled selected>Please Select</option><br/>\r\n";
										$query = "SELECT GROUP_CONCAT(sec_mods) as mods FROM $bai_pro3.sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
										$result = $conn->query($query);
										while($row = $result->fetch_assoc()) 
							            { 
											
											$sql_mod=$row["mods"];
										}
										$sql_mods=explode(",",$sql_mod);

											for($ia=0;$ia<sizeof($sql_mods);$ia++)
											{
												if($sql_mods[$ia] == $modno){
													echo "<option value=\"".$sql_mods[$ia]."\" selected>".$sql_mods[$ia]."</option>";
	
												}else{
													echo "<option value=\"".$sql_mods[$ia]."\">".$sql_mods[$ia]."</option>";
	
												}
	
												
											}
			
					                    
							            echo "</select>";
						              ?>      
						              </div>
								</div>
							</div>  
							<div class="col-md-4">
                           <div class="form-group">
                               <label class="control-label control-label-left col-sm-3" for="style" >Style<span class='req' style="color:red;">*</span></label>
                                       <div class="controls col-sm-9">
                                           <?php 
										// include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
										// $conn=$link;
										echo "<select id='style' class='form-control' data-role='select'  name='style'  data-parsley-errors-container='#errId2' required>";
							
										echo "<option value='Please Select'  disabled selected>Please Select</option><br/>\r\n";
										$query = "select distinct style_id from $bai_pro2.movex_styles order by style_id";
										$result = $conn->query($query);
										while($row = $result->fetch_assoc()) 
							            { 
											
											$style_id=$row['style_id'];
											
											
											if(trim($style_id) ==trim($style)){
												echo "<option value='".$style_id."' selected>$style_id</option>";

											}else{
												echo "<option value='".$style_id."'>$style_id</option>";

											}
			
					                    }
							            echo "</select>";
						              ?>      
						              </div>
								</div>
							</div>
							<div class="col-md-4">
                           <div class="form-group">
                               <label class="control-label control-label-left col-sm-3" for="schedule" >Schedule<span class='req' style="color:red;">*</span></label>
                                       <div class="controls col-sm-9">
                                           <?php 
										// include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
										// $conn=$link;
										echo "<select id='schedule' class='form-control' data-role='select'  name='schedule'  data-parsley-errors-container='#errId2' required>";
							
										echo "<option value='Please Select'  disabled selected>Please Select</option><br/>\r\n";
										$query = "select distinct order_del_no as schedule_no from $bai_pro3.bai_orders_db where order_del_no > 25000 order by order_del_no+0";
										$result = $conn->query($query);
										while($row = $result->fetch_assoc()) 
							            { 
											
											$schedule_no=$row['schedule_no'];
											
											
											if($schedule_no == $schedule){
												echo "<option value='".$schedule_no."' selected>$schedule_no</option>";

											}else{
												echo "<option value='".$schedule_no."'>$schedule_no</option>";

											}
			
					                    }
							            echo "</select>";
						              ?>      
						              </div>
								</div>
							</div> 
							</div></br>
							<div class="row">  
							<div class="col-md-4">
                           <div class="form-group">
                               <label class="control-label control-label-left col-sm-3" for="nop" >NOP<span class='req' style="color:red;">*</span></label>
                                       <div class="controls col-sm-9">

								<input type="text" class="form-control" onkeypress='return validateQty(event);' oncopy='return false' onpaste='return false' name="nop" size="5" id="nop" value="16" class="form-control" >

							</div>
							</div>
							</div>
							<div class="col-md-4">
                           <div class="form-group">
                               <label class="control-label control-label-left col-sm-3" for="start_time" >Start Time<span class='req' style="color:red;">*</span></label>
                                       <div class="controls col-sm-9">

                                 <?php
								echo"<SELECT name=\"start_time\" id=\"start_time\" onchange=\"calculate()\" class=\"form-control\" required>";

								echo"<option value=\"0\" name=\"start_time\">Select Start Time</option>
								";

								for($l=6;$l<=22;$l++)
								{
									for($k=0;$k<sizeof($mins);$k++)
									{
										if($l<13)
										{
											if($l==12)
											{
												
												$pm='PM';
												$time_pm=$l.":".$mins[$k]." ".$pm;
												if($start_time==$time_pm){
													echo "<option value=\"".$l.":".$mins[$k]." ".$pm."\" name=\"start_time\" selected>".$l.":".$mins[$k]." ".$pm."</option>";
												}else{
												echo "<option value=\"".$l.":".$mins[$k]." ".$pm."\" name=\"start_time\">".$l.":".$mins[$k]." ".$pm."</option>";
												}
											}
											else
											{
												$am='AM';
												$time_pm=$l.":".$mins[$k]." ".$am;
												if($start_time==$time_pm){
												echo "<option value=\"".$l.":".$mins[$k]." ".$am."\" name=\"start_time\" selected>".$l.":".$mins[$k]." ".$am."</option>";
												}else{
													echo "<option value=\"".$l.":".$mins[$k]." ".$am."\" name=\"start_time\">".$l.":".$mins[$k]." ".$am."</option>";
												}
											}	
										}
										else
										{
											$r=$l;
											//$r=$l-12;
											$pm='PM';
											$time_pm=$l.":".$mins[$k]." ".$pm;
												if($start_time==$time_pm){
													echo "<option value=\"".$l.":".$mins[$k]." ".$pm."\" name=\"start_time\" selected>".$r.":".$mins[$k]." ".$pm."</option>";
												}
												else{
											echo "<option value=\"".$l.":".$mins[$k]." ".$pm."\" name=\"start_time\">".$r.":".$mins[$k]." ".$pm."</option>";
												}
										}
									}
									
								}
								echo "</SELECT>";

                                 ?>
						</div>
						</div>
						</div>

						<div class="col-md-4">
                           <div class="form-group">
                               <label class="control-label control-label-left col-sm-3" for="end_time" >End Time<span class='req' style="color:red;">*</span></label>
                                       <div class="controls col-sm-9">
						 <?php 
						 
						 echo"<SELECT name=\"end_time\" id=\"end_time\"  onchange=\"calculate()\" class=\"form-control\" requied>";

						 echo"<option value=\"0\" name=\"end_time\">Select End Time</option>
						 ";
					 
						 for($l=6;$l<=22;$l++)
						 {
							 for($k=0;$k<sizeof($mins);$k++)
							 {
								 if($l<13)
								 {
									 if($l==12)
									 {
										 $pm='PM';
										 $time_pm=$l.":".$mins[$k]." ".$pm;
												if($end_time==$time_pm){
													echo "<option value=\"".$l.":".$mins[$k]." ".$pm."\" name=\"end_time\" selected>".$l.":".$mins[$k]." PM</option>";
												}else{
										        echo "<option value=\"".$l.":".$mins[$k]." ".$pm."\" name=\"end_time\">".$l.":".$mins[$k]." PM</option>";
												}
									 }
									 else
									 {
										 $am='AM';
										 $time_pm=$l.":".$mins[$k]." ".$am;
										 if($end_time==$time_pm){
										 echo "<option value=\"".$l.":".$mins[$k]." ".$am."\" name=\"end_time\" selected>".$l.":".$mins[$k]." AM</option>";
										 }else{
											echo "<option value=\"".$l.":".$mins[$k]." ".$am."\" name=\"end_time\" >".$l.":".$mins[$k]." AM</option>";
										 }
									 }
								 }
								 else
								 {
									 //$r=$l-12;
									 $r=$l;
									 $pm='PM';
									 $time_pm=$l.":".$mins[$k]." ".$pm;
									 if($end_time==$time_pm){
									 echo "<option value=\"".$l.":".$mins[$k]." ".$pm."\" name=\"end_time\" selected>".$r.":".$mins[$k]." PM</option>";
									 }else{
										echo "<option value=\"".$l.":".$mins[$k]." ".$pm."\" name=\"end_time\">".$r.":".$mins[$k]." PM</option>";
									 }
								 }
							 }	
						 }
					 
						 echo "</SELECT>";



						 ?>


						 </div>
						 </div>
						 </div>
						 </div></br>
						 <div class="row">
						 <div class="col-md-4">
                           <div class="form-group">
                               <label class="control-label control-label-left col-sm-3" for="total_lost_mins" >Total
                                Lost Mins</label>
                                       <div class="controls col-sm-9">

                            <input type="text" class="form-control" name="lost_min" size="5" id="lost_min" readonly value="<?php echo $lost_min; ?>" class="form-control"/>


						</div>
						</div>
						</div>
						<div class="col-md-4">
                           <div class="form-group">
                               <label class="control-label control-label-left col-sm-3" for="end_time" >Exception Time (Mins)</label>
                                       <div class="controls col-sm-9">
						
									   <input type="text" class="form-control" name="ex" onkeypress='return validateQty(event);' oncopy='return false' onpaste='return false' size="5" id="ex" onkeyup="calculate()" value="<?php echo $exception_time; ?>" class="form-control"/>


						</div>
						</div>
						</div>
					
						<div class="col-md-4">
                           <div class="form-group">
                               <label class="control-label control-label-left col-sm-3" for="department" >Department<span class='req' style="color:red;">*</span></label>
                                       <div class="controls col-sm-9">
                                           <?php 
										echo "<select id='dep' class='form-control' data-role='select'  name='dep'  data-parsley-errors-container='#errId2' required>";
							
										echo "<option value='Please Select'  disabled selected>Please Select</option><br/>\r\n";
										$query = "select * from $bai_pro.down_deps";
										$result = $conn->query($query);
										while($row = $result->fetch_assoc()) 
							            { 
											
											$dep_id=$row['dep_id'];
											$dep_name=$row['dep_name'];
										
											
											if($dep_id == $department){
												echo "<option value='".$dep_id."' selected>$dep_name</option>";

											}else{
												echo "<option value='".$dep_id."'>$dep_name</option>";

											}
			
					                    }
							            echo "</select>";
						              ?>      
						              </div>
								</div>
							</div>   
							</div></br>
							<div class="row">
							<div class="col-md-4">
                           <div class="form-group">
                               <label class="control-label control-label-left col-sm-3" for="reason" >Reason<span class='req' style="color:red;">*</span></label>
                                       <div class="controls col-sm-9">

								<input type="text" class="form-control" name="reason_code" readonly id="reason_code" size=3 value="<?php echo $reason_code; ?>"><span onclick="box()" class='btn btn-info btn-xs'>Select Reason</sapn>



							</div>
							</div>
							</div>
							<div class="col-md-4">
                           <div class="form-group">
                               <label class="control-label control-label-left col-sm-3" for="department" id="required">Remarks</label>
                                       <div class="controls col-sm-9">

                              <input type="text" class="form-control" name="reason"  size="20" class="form-control" value="<?php echo $remarks; ?>">



						</div>
						</div>
						</div>
						<div class="col-md-4">
                           <div class="form-group">
                               <label class="control-label control-label-left col-sm-3" for="department" >Source<span class='req' style="color:red;">*</span></label>
                                       <div class="controls col-sm-9">
									
										<select id="source" class="form-control" data-role="select" selected="selected" name="source" data-parsley-errors-container="#errId2" required>
										<?php
										if($source==0){
											echo '<option value="0" selected>Internal</option>';
											echo '<option value="1">External</option>';
										}else{
											echo '<option value="0">Internal</option>';
											echo '<option value="1" selected>External</option>';
										}
					                    ?>
										</select>

						</div>
						</div>
						</div>
				</div>
				</br>
				<div class="row">
				<div class="col-md-4">
				<div class="controls col-sm-9">
				<input type="submit" name="submit" value="Submit" onclick = 'return check_reasons()' class="btn btn-primary "/>
				</div>
                 </div>
				</div>



	</form>
	</div>
					



<script>

function box()
{
	var php_url = '<?= getFullURL($_GET['r'],'pop_view3.php','R');?>';
	var url= php_url+"?dep_id="+document.getElementById("dep").value+"";
	newwindow=window.open(url,'Reasons','width=700, height=500, toolbar=0, menubar=0, location=0, status=0, scrollbars=1, resizable=1, left=0, top=0');
	if (window.focus) {newwindow.focus()}
	return false;	
}

function validateQty(event) 
{
	event = (event) ? event : window.event;
	var charCode = (event.which) ? event.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}

function GetValueFromChild(tmp)
{

	var result=tmp.split("$");

    document.getElementById("reason_code" + result[0]).value = result[1];
    document.getElementById("dep" + result[0]).value =result[2];
	var res_code=document.getElementById("reason_code" + result[0]).value = result[1];
	
}
 
function calculate() 
{
   
    
    var nop = document.getElementById("nop").value;
	var stime = document.getElementById("start_time").value;
	var etime = document.getElementById("end_time").value;
	var ltime = document.getElementById("lost_min").value;
	var extime = document.getElementById("ex").value;	
	
	stimesplit=stime.split(":");
	etimesplit=etime.split(":");
	
	stimeval=parseInt(parseInt((stimesplit[0]*60))+parseInt(stimesplit[1]));
	etimeval=parseInt(parseInt((etimesplit[0]*60))+parseInt(etimesplit[1]));
	
	diff=parseInt(etimeval)-parseInt(stimeval);
	//alert(etime);
	if(parseInt(diff)>=0)
	{
		document.getElementById("lost_min").value=parseInt(0);
		document.getElementById("lost_min").value=parseInt(diff*nop)-parseInt(nop*extime);	
	}
	else
	{
		if(etime != 0)
		{
			sweetAlert("Please Enter Correct Time.","","info");
		}	
		document.getElementById("end_time").value="";
		document.getElementById("lost_min").value=parseInt(0);
		document.getElementById("ex").value=parseInt(0);
	}
	
	if(parseInt(diff)<parseInt(extime))
	{
		//alert("Please Enter Correct Time.");
		document.getElementById("lost_min").value=parseInt(0);
		document.getElementById("ex").value=parseInt(0);
	}
	
}
function isPositiveNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n) && parseFloat(n) >= 0;
}
</script> 
	
	
<script>
function GreaterDate(DtVal1, DtVal2)
{
var DtDiff;
Date1 = new Date(DtVal1);
Date2 = new Date(DtVal2);
DaysDiff = Math.floor((Date1.getTime() - Date2.getTime())/(1000*60*60*24));
if(DtDiff > 0)
return true;
else
return false;
}

function Lessdate(DtVal1, DtVal2)
{
var DtDiff;
Date1 = new Date(DtVal1);
Date2 = new Date(DtVal2);
DaysDiff = Math.floor((Date1.getTime() - Date2.getTime())/(1000*60*60*24));
//alert("DaysDiff ="+DaysDiff);
if(DtDiff <= 0)
return true;
else
return false;
}

function EqualDate(DtVal1, DtVal2)
{
var DtDiff;
Date1 = new Date(DtVal1);
Date2 = new Date(DtVal2);
DtDiff = Math.floor((Date1.getTime() - Date2.getTime())/(1000*60*60*24));
if(DtDiff == 0)
return true;
else
return false;
}

function check_date(x,yy,xx) //form date, allowed date, today date
{
	var d = new Date();
	var curr_hour = d.getHours();
	
	if (x< yy)
	{ 
		alert("Pleae enter correct date");
		document.f1.date.value=xx;
	}
	if(x>xx)
	{
		alert("Pleae enter correct date");
		document.f1.date.value=xx;
	}
	
	if (x==yy && curr_hour<=11)
	{
		
	}
	else
	{
		alert("You are not Authorized to Update Backdated Downtime.");
		document.f1.date.value=xx;
	}
	
}
</script>


<?php
if(isset($_POST["submit"]))
{
	
	$section=$_POST["sections"];
	$row_id=$_POST["c_id"];
	$shift=$_POST["shift"];
	$module=$_POST["module"];
	$style=$_POST["style"];
	$schedule=$_POST["schedule"];
	$date=$_POST["date"];
	$exception_time=$_POST["ex"];
	
	$start_time=$_POST["start_time"];
	
	$end_time=$_POST["end_time"];
	$lost_mins=$_POST["lost_min"];
	$exc_time=$_POST["ex"];
	$nop=$_POST["nop"];
	
		
	$department=$_POST["dep"];
	$reason=$_POST["reason_code"];
	$remarks=$_POST["reason"];
	$source=$_POST["source"];

	
	$capture="1";
	// if(empty($section) || empty($shift)|| empty($module)|| empty($style) ||empty($schedule) || empty($date) == '' || empty($date) == '0000-00-00'|| empty($start_time) == '' || empty($end_time) == '' || empty($lost_mins) == '0' || empty($exc_time) || empty($nop)|| empty($department) || empty($reason)|| empty($source)    ){
			
	// }
	if(empty($section) || empty($shift) || empty($module) || empty($style) || empty($schedule) || empty($date)  ||  empty($start_time) || empty($end_time) || empty($nop) || empty($department) || empty($reason) || $date=='0000:00:00'){
	
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",100);
					function Redirect() {
						sweetAlert('Please Fill all Mandatory Fields','','warning');
						location.href = \"".getFullURLLevel($_GET['r'], "down_time_update_V2.php", "0", "N")."\";
						}
					</script>";
	}else{
	//New Addition for reason code tracking
	$reason_code=$_POST['reason_code'];
	
	$lastup=date("Y-m-d H:i:s");


		if($lost_mins>0)
		{
			if($schedule!=0)
			{
				//2016-10-06 / CR 512 / kirang / Changed the logic to capture the Buyer Name
				$order_style_no=0;
				$sql3="select distinct order_style_no as order_style_no from $bai_pro3.bai_orders_db where order_del_no='".$schedule."'";
					//echo "<br/>".$sql3."<br/>";
				$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row3=mysqli_fetch_array($sql_result3))
				{
					$order_style_no=$sql_row3["order_style_no"];
				}
			
			
				//2016-10-06 / CR 512 / kirang / Changed the logic to capture the Buyer Name
				//$sql1="SELECT distinct(buyer) FROM pro_style WHERE style=\"".$style[$i]."\"";	
				
				$sql1="SELECT distinct(buyer_id) as buyer FROM $bai_pro2.movex_styles WHERE movex_style=\"".$order_style_no."\"";	
				//echo "<br/>".$sql1."<br/>";			
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$buyer=$sql_row1["buyer"];
				}
			
			}
			else if($style!='')
			{
				$sql_buyer="SELECT distinct(buyer_id) as buyer  FROM $bai_pro2.movex_styles where style_id='".$style."' and buyer_id!=''";
				
				//echo "<br/>".$sql_buyer;
				
				$sql_result=mysqli_query($link, $sql_buyer) or exit($sql_buyer."Sql Error 3".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$buyer=$sql_row["buyer"];
				}
				
				
			}
			else
			{
				$sql_buyer="SELECT buyer FROM $bai_pro3.buyer_style a join $bai_pro3.plan_modules b on a.buyer_name=b.buyer_div where module_id=".$module;
				$sql_result_buyer=mysqli_query($link, $sql_buyer) or exit($sql_buyer."Sql Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row_buyer=mysqli_fetch_array($sql_result_buyer))
				{
					$buyer=$sql_row_buyer["buyer"];
				}
			}
			if($row_id>0)
			{
				$sql = "update $bai_pro.down_log set mod_no='$module',date='$date',department='$department',remarks='$remarks',style='$style',dtime='$lost_mins',shift='$shift',section='$section',customer='$buyer',schedule='$schedule',source='$source',capture='$capture',lastup='$lastup',nop='$nop',start_time='$start_time',end_time='$end_time',reason_code='$reason_code',updated_by='$username',exception_time='$exception_time' where tid='$row_id'";

				if (mysqli_query($conn, $sql)) {
					$url=getFullURL($_GET['r'],'down_time_update_V2.php','N');
					//echo $url;
					//echo "Record updated successfully";
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
					function Redirect() {
						sweetAlert('Downtime Updated Successfully','','success');
						location.href = \"".getFullURLLevel($_GET['r'], "down_time_update_V2.php", "0", "N")."\";
						}
					</script>";
				} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
				
			}
			else{
			$sql2="insert into $bai_pro.down_log(mod_no,date,department,remarks,style,dtime,shift,section,customer,schedule,source,capture,lastup,nop,start_time,end_time,reason_code,updated_by,exception_time) values (".$module.", \"".$date."\", \"".$department."\",\"".$remarks."\", \"".$style."\", ".$lost_mins.", \"".$shift."\", ".$section.", \"".$buyer."\", \"".$schedule."\", \"".$source."\", \"".$capture."\", \"".$lastup."\",\"".$nop."\",\"".$start_time."\",\"".$end_time."\",".$reason_code.",'$username','$exception_time')";
			//echo "<br/><br/>".$sql2."<br/>";
			$result = mysqli_query($link, $sql2) or exit("Sql Error[$i]".mysqli_error($GLOBALS["___mysqli_ston"]));
			if ($result=='1') {
			
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
					function Redirect() {
						sweetAlert('Downtime Captured Successfully','','success');
						location.href = \"".getFullURLLevel($_GET['r'], "down_time_update_V2.php", "0", "N")."\";
						}
					</script>";
			} else {
				
				echo "<script>sweetAlert('Warning!','Failed to Capture','warning');</script>";
			}

		}
			
		}
	}

}

?>
</div></br></br></br>

<?php 

$sql = "SELECT * FROM $bai_pro.`down_log` order by tid desc";
	$result = $conn->query($sql);
	$sno = 1;
	 $url=getFullURL($_GET['r'],'down_time_update_V2.php','N');
	 $url1=getFullURL($_GET['r'],'delete_downtime_update.php','N');
	if ($result->num_rows > 0) {
		echo "<div style='overflow-x: auto;'><table id='downtime_reason1' class='table'>
		<thead>
		<tr>
		<th>S.No</th>
		<th>Date</th>
		<th>Section</th>
		<th>Shift</th>
		<th>Module</th>
		<th>Style</th>
		<th>Schedule</th>
		<th>NOP</th>
		<th>Start Time</th>
		<th>End Time</th>
		<th>Tota Lost Mins</th>
		<th>Exception Time(Mins)</th>
		<th>Department</th>
		<th>Reason</th>
		<th>Remarks</th>
		<th>Source</th>";
		if(in_array($authorized,$has_permission))
			{
		echo"<th> Edit / Delete </th>";
			}
		echo"</tr>
		</thead>
		<tbody>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$rowid=$row["tid"];
			$date=$row["date"];
			$shift=$row["shift"];
			$section=$row["section"];
			$style=$row["style"];
			$schedule=$row["schedule"];
			$mod_no=$row["mod_no"];
			$nop=$row["nop"];
			$start_time1=$row["start_time"];
			$string = str_replace('PM', '', $start_time);
			$end_time1=$row["end_time"];
			
			
			
			// if($start_time>12){
			// 	$start_time2 = date('h:i', strtotime($string . '- 12 hours'));
			// 	$start_time1 = $start_time2.' PM';
			// }
			// else{
			// 	$start_time1=$start_time;
			// }
			
			// $end_time=$row["end_time"];
			// $string1 = str_replace('PM', '', $end_time);
			// if($end_time>12){
			// 	$end_date2 = date('h:i', strtotime($string1 . '- 12 hours'));
			// 	$end_time1 = $end_date2.' PM';
			// }
			// else{
			// 	$end_time1=$end_time;
			// }
			$lost_min=$row["dtime"];
			$remarks=$row["remarks"];
			$source1=$row["source"];
			$department=$row["department"];
			$reason_code=$row["reason_code"];

			$query1="select dep_name from $bai_pro.down_deps where dep_id=\"$department\"";
			$result2 = mysqli_query($link, $query1) or exit("Sql Error[$i]".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($result2))
				{
					$dep_name=$sql_row2["dep_name"];
				}
			$query3="select down_reason from $bai_pro.down_reason where sno=\"$reason_code\"";
			$result3 = mysqli_query($link, $query3) or exit("Sql Error[$i]".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row3=mysqli_fetch_array($result3))
				{
					$down_reason=$sql_row3["down_reason"];
				}
			
			$exception_time=$row["exception_time"];
			$query="select * from $bai_pro3.sections_master where sec_name=\"$section\"  order by sec_id";
			$result1 = mysqli_query($link, $query) or exit("Sql Error[$i]".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($result1))
				{
					$section_name=$sql_row1["section_display_name"];
				}
			if($source == 0){
				$source = "Internal";
			}else{
				$source = "External";
			}
			$cat_selection=$row["cat_selection"];
			
			echo "<tr><td>".$sno++."</td><td>".$row["date"]."</td><td>".$section_name." </td><td>".$row["shift"]."</td>
			<td>".$row["mod_no"]."</td><td>".$row["style"]."</td><td>".$row["schedule"]."</td><td>".$row["nop"]."</td><td>".$start_time1."</td><td>".$end_time1."</td><td>".$row["dtime"]."</td><td>".$row["exception_time"]."</td><td>".$dep_name."</td><td>".$down_reason."</td><td>".$row["remarks"]."</td><td>".$source."</td>";
			if(in_array($authorized,$has_permission))
			{
			echo"<td><a href='$url&rowid=$rowid&date=$date&section=$section&shift=$shift&module=$mod_no&style=$style&schedule=$schedule&nop=$nop&start_time=$start_time1&end_time=$end_time1&lost_min=$lost_min&remarks=$remarks&source=$source1&department=$department&reason_code=$reason_code&exception_time=$exception_time' class='btn btn-warning btn-xs editor_edit'>Edit</a> / <a href='$url1&rowid1=$rowid' class='btn btn-danger btn-xs editor_remove' onclick='return confirm_delete(event,this);'>Delete</a></td>";
			}
			echo"</tr>";
		}

		echo "</tbody></table></div>";
		} else {
			echo "0 results";
		}
		$conn->close();
		?>
<script>
function check_reasons(count){
		
		var val = document.getElementById('reason_code').value;
		var stime = document.getElementById("start_time").value;
		var etime = document.getElementById("end_time").value;
		var totlostmin = document.getElementById("lost_min").value;
		
		if(totlostmin > 0 && val == '')
		{
			swal('Please select  Reason','','warning');
			return false;
		}

	
	return true;
	
}

</script>
<script>
$(document).ready(function() {
    $('#downtime_reason1').DataTable();
	
} );

function confirm_delete(e,t)
    {
        e.preventDefault();
        var v = sweetAlert({
        title: "Are you sure to Delete the Record?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        buttons: ["No, Cancel It!", "Yes, I am Sure!"],
        }).then(function(isConfirm){
        if (isConfirm) {
        window.location = $(t).attr('href');
        return true;
        } else {
        sweetAlert("Request Cancelled",'','error');
        return false;
        }
        });
    }

</script>
<style>
table th
{
	border: 1px solid grey;
	text-align: center;
    background-color: #003366;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}
table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
	
	
}
table tr
{
	border: 1px solid grey;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid grey;
	text-align: center;
	white-space:nowrap;
	color:black;
}

</style>

