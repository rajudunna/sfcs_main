
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));

$view_access=user_acl("SFCS_0170",$username,1,$group_id_sfcs); 
$auth_users=user_acl("SFCS_0170",$username,7,$group_id_sfcs);
$super_user=user_acl("SFCS_0170",$username,33,$group_id_sfcs); 
$has_permission = haspermission($_GET['r']);
?>
<style>
body{
	font-family: Trebuchet MS;
}

td.leftfloat
{
	text-align:left;
}

input
{
	border: none;
	background-color:none;
}
.hidet{
	//display:none;
}
</style>
<script>
var option = document.getElementById('option');
var update_val = document.getElementById('update');
option.onchange = function() {
  update_val.disabled = !!this.checked;
};
// function dodisablenew()
// {
// 	document.getElementById('update').disabled='true';
// }


function enableButton(x) 
{
	auto_cal_clh(x);
	
	if(document.getElementById('option').checked)
	{
		document.getElementById('update').disabled='';
	} 
	else 
	{
		document.getElementById('update').disabled='true';
	}
}

function auto_cal_clh(maxval)
{
	
	var check=input.elements["check[]"];
	var eff_a=input.elements["eff_a[]"];
	var eff_b=input.elements["eff_b[]"];
	var clh_a=input.elements["clh_a[]"];
	var sah_a=input.elements["sah_a[]"];
	var clh_b=input.elements["clh_b[]"];
	var sah_b=input.elements["sah_b[]"];
	var plan_eff_ex=input.elements["plan_eff_ex[]"];
	for(i=0;i<maxval;i++)
	{
		if(sah_a[i].value>0 && eff_a[i].value>0)
		{
			//clh_a[i].value=Math.round((sah_a[i].value/(parseFloat(eff_a[i].value)+parseFloat(plan_eff_ex[i].value)))*100,2);

			clh_a[i].value=Math.round((sah_a[i].value/(parseFloat(eff_a[i].value)))*100,2);
		}
		else
		{
			clh_a[i].value=0;
		}
		if(sah_b[i].value>0 && eff_b[i].value>0)
		{
			//clh_b[i].value=Math.round((sah_b[i].value/(parseFloat(eff_b[i].value)+parseFloat(plan_eff_ex[i].value)))*100,2);
			clh_b[i].value=Math.round((sah_b[i].value/(parseFloat(eff_b[i].value)))*100,2);
		}
		else
		{
			clh_b[i].value=0;
		}
		check[i].value=1;	
	}
	
	// alert("Plan clock is calculated successfully.");
}

function markchange(x)
{
	var check=input.elements["check[]"];
	
	var pro_a=input.elements["pro_a[]"];
	var eff_a=input.elements["eff_a[]"];
	var hrs_a=input.elements["hrs_a[]"];
	
	var pro_b=input.elements["pro_b[]"];
	var eff_b=input.elements["eff_b[]"];
	var hrs_b=input.elements["hrs_b[]"];
	
	var couple_a=input.elements["couple_a[]"];
	var couple_b=input.elements["couple_b[]"];
	var nop=input.elements["nop[]"];
	var fix_nop_a=input.elements["fix_nop_a[]"];
	var smv=input.elements["smv[]"];
	
	var nop1=input.elements["nop1[]"];
	var fix_nop_b=input.elements["fix_nop_b[]"];
	var smv1=input.elements["smv1[]"];
	
	//Added Validation for updating couple number between 1 to 6
	if(couple_a[x].value < 1 || couple_a[x].value > 6)
	{
		swal("Enter Correct Value Between 1 To 6","","warning");
		couple_a[x].value=1;
	}
	
	//Added Validation for updating couple number between 1 to 6
	if(couple_b[x].value < 1 || couple_b[x].value > 6)
	{
		swal("Enter Correct Value Between 1 To 6","","warning");
		couple_b[x].value=1;
	}
	
	check[x].value=1;
	
	//CR: 131
	//pro_a[x].value=Math.round((eff_a[x].value*hrs_a[x].value*60*fix_nop_a[x].value)/(smv[x].value*100));
	//pro_b[x].value=Math.round((eff_b[x].value*hrs_b[x].value*60*fix_nop_b[x].value)/(smv1[x].value*100));
	
	//alert(smv[x].value);
	pro_a[x].style.backgroundColor="white";
	pro_b[x].style.backgroundColor="white";
}

function check_date(x,yy,xx) //form date, allowed date, today date
{
	var d = new Date();
	var curr_hour = d.getHours();
	//alert(curr_hour);
	if (x<yy)
	{ 
		alert("Pleae enter correct date");
		document.input.date_change.value=xx;
	}
	if(x>xx)
	{
		alert("Pleae enter correct date");
		document.input.date_change.value=xx;
	}
	
	if (x==yy && curr_hour<=23)
	{
		
	}
	else
	{
		alert("You are not Authorized to Update Backdated Plan.");
		document.input.date_change.value=xx;
	}
	
}
// function chk(code)
// {
// 	var cd = code;
// 	alert(cd);
// 	var chk = [96,97,98,99,100,101,102,103,104,105,48,49,50,51,52,53,54,55,56,57,110,190];
// 	for(var i = 0; i < 22; i++)
// 	{
// 		if(cd == chk[i])
// 		{
// 			alert(chk[i]);
// 			return true;
// 			break;
// 		}
// 	}
// 	alert();
// 	return false;
// }
// function isNum(evt)
// {
//     // evt = (evt) ? evt : window.event;
//     var charCode = evt.which;	
// 	return chk(charCode);
// }
function only_num(e)
{
	if(e.keyCode == 189 || e.keyCode== 187 || e.keyCode== 45 || e.keyCode== 69 || e.keyCode== 107 || e.keyCode== 109  || e.keyCode== 187 || e.keyCode == 110 || e.keyCode == 190 )
	{
		return false;
	}
	else
	{
		return true;
	}
}
function pop_test(e, nm)
{
	var name = nm;
	var count = 0;
	var items = document.getElementsByName(name);
	for(var i=0;i<items.length;i++)
	{
		if( isNaN(items[i].value) )
		{
			if(nm=='nop[]' || nm=='nop1[]') {
				items[i].value = '';
				sweetAlert('Please enter the number of NOP','','warning');
			}
			
			else {
				if (nm=='eff_a[]' || nm=='eff_b[]'){
					items[i].value = '';
					sweetAlert('Please enter valid Plan Eff','','warning');
				}
				else {
					if (nm=='pro_a[]' || nm=='pro_b[]'){
						items[i].value = '';
						sweetAlert('Please enter valid Plan Pro','','warning');
					}
					else {
						items[i].value = '';
						sweetAlert('Please Enter only Numbers','','warning');
					}
				}
			}
		}
	}
	return only_num(e);
}
function pop_test_alpha_numeric(e, nm)
{
	var name = nm;
	var count = 0;
	var items = document.getElementsByName(name);
	for(var i=0;i<items.length;i++)
	{
		if(e.shiftKey || e.ctrlKey || e.altKey || (e.keyCode > 0 && e.keyCode < 8) || (e.keyCode > 9 && e.keyCode < 48) || (e.keyCode > 57 && e.keyCode < 65) || (e.keyCode > 90 && e.keyCode < 97) || (e.keyCode > 122 && e.keyCode < 300))
		{
			items[i].value = '';
			sweetAlert('Please enter valid style','','warning');
		}
	}
	return only_alphanum(e);
}
function only_alphanum(e)
{
	if(e.shiftKey || e.ctrlKey || e.altKey || (e.keyCode > 0 && e.keyCode < 8) || (e.keyCode > 9 && e.keyCode < 48) || (e.keyCode > 57 && e.keyCode < 65) || (e.keyCode > 90 && e.keyCode < 97) || (e.keyCode > 122 && e.keyCode < 300))
	{
		return false;
	}
	else
	{
		return true;
	}
}
function pop_test_alpha(e, nm)
{
	var name = nm;
	var count = 0;
	var items = document.getElementsByName(name);
	for(var i=0;i<items.length;i++)
	{
		if(e.shiftKey || e.ctrlKey || e.altKey || (e.keyCode > 0 && e.keyCode < 8) || (e.keyCode > 9 && e.keyCode < 48) || (e.keyCode > 57 && e.keyCode < 65) || (e.keyCode > 90 && e.keyCode < 97) || (e.keyCode > 122 && e.keyCode < 190) || (e.keyCode > 191 && e.keyCode < 300))
		{
			items[i].value = '';
			sweetAlert('Enter Remarks','','warning');
		}
	}
	return only_alphanum(e);
}
function only_alphanum(e)
{
	if(e.shiftKey || e.ctrlKey || e.altKey || (e.keyCode > 0 && e.keyCode < 8) || (e.keyCode > 9 && e.keyCode < 48) || (e.keyCode > 57 && e.keyCode < 65) || (e.keyCode > 90 && e.keyCode < 97) || (e.keyCode > 122 && e.keyCode < 190) || (e.keyCode > 191 && e.keyCode < 300))
	{
		return false;
	}
	else
	{
		return true;
	}
}

function pop_test_float(e, nm)
{
	var name = nm;
	var count = 0;
	var items = document.getElementsByName(name);
	for(var i=0;i<items.length;i++)
	{
		if(e.shiftKey || e.ctrlKey || e.altKey || (e.keyCode > 0 && e.keyCode < 8) || (e.keyCode > 9 && e.keyCode < 48) || (e.keyCode > 57 && e.keyCode < 65) || (e.keyCode > 90 && e.keyCode < 97) || (e.keyCode > 122 && e.keyCode < 190) || (e.keyCode > 191 && e.keyCode < 300))
		{
			items[i].value = '';
			sweetAlert('Please enter valid SMV','','warning');
		}
	}
	return only_float(e);
}
function only_alphanum(e)
{
	if(e.shiftKey || e.ctrlKey || e.altKey || (e.keyCode > 0 && e.keyCode < 8) || (e.keyCode > 9 && e.keyCode < 48) || (e.keyCode > 57 && e.keyCode < 65) || (e.keyCode > 90 && e.keyCode < 97) || (e.keyCode > 122 && e.keyCode < 190) || (e.keyCode > 191 && e.keyCode < 300))
	{
		return false;
	}
	else
	{
		return true;
	}
}



</script>

<div class="panel panel-primary">
<div class="panel-heading">Update Plan Efficiency</div>
<div class="panel-body">

<?php   

$date=date("Y-m-d");


if(mysqli_num_rows(mysqli_query($link, "select * from $bai_ict.report_alert_track where date(date)=\"".date("Y-m-d")."\" and report='PRO_NEW_DB'"))==0)
{
	//header("Location: Error_Codes.php?ecode=1");
}

?>

<?php 
$sql="SELECT DISTINCT bac_date FROM $bai_pro.bai_log_buf WHERE bac_date< \"".date("Y-m-d")."\" ORDER BY bac_date DESC LIMIT 1";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$max_allowed_date=$sql_row['bac_date'];
}

//Request #136480
$max_allowed_date=date("Y-m-d");
//$max_allowed_date='2014-10-01';
?>

	<form action="<?php echo getFullURL($_GET['r'], "plan_update_v2.php", "N"); ?>" method="post" name="input">
	
	<?php
	
	
	// if(in_array($username,$auth_users)) 
	if(in_array($authorized,$has_permission)) 
	{

	echo '<p align=right><strong><a class="btn btn-primary btn-xs" href="'.getFullURL($_GET['r'], "plan_update_view.php", "N").'">Plan Review >><strong></a></p>';
	
	//if($username=="kirang" or $username=="kirang")
	//{
		echo '<div class="table-responsive"><table class="table table-bordered">
	<tr><td colspan=6><b>Date</b></td><td colspan=3><div class="col-md-10"><input type="text" data-toggle="datepicker" name="date_change" value="'.date("Y-m-d").'" class="form-control" size=15';
	
	//Date:12-10-2015/kirang/Task: added user validation to avoid warning message on selection of back date
	// if(!(in_array($username,$super_user)) )
	if(!(in_array($authorized,$has_permission)) )
	{
		echo ' onchange="check_date(this.value,\''.$max_allowed_date.'\',\''.date("Y-m-d").'\');"';
	}
	
	echo '></div><br/></td><td colspan=14><strong>Plan Update Panel</strong></td></tr>
	
	<tr><th>Module</th>	<th class="hidet">Section</th><th class="hidet">Style</th><th class="hidet">SMV</th><th class="hidet">NOP</th><th>Team A <br/>Plan Eff</th><th>Team A <br/>Plan Pro</th>
	<th>Team A <br/>Plan Clock Hours</th>
	<th>Team A <br/>Plan SAH</th>
	<th>Team A <br/>Plan Hours</th><th>Team A <br/>Plan Couple</th><th>Fixed <br/>NOP</th><th>SMV</th><th>NOP</th><th>Team B <br/>Plan Eff</th>	<th>Team B <br/>Plan Pro</th>
	<th>Team B <br/>Plan Clock Hours</th>
	<th>Team B <br/>Plan SAH</th>
	<th>Team B <br/>Plan Hours</th><th>Team B <br/>Plan Couple</th><th>Fixed <br/>NOP</th><th>Remarks</th>
</tr>';
	
	
	$sql="select max(date) as date from $bai_pro.pro_plan";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$max_date=$sql_row['date'];
	}

	$x=0;
	$sql="select * from $bai_pro.pro_plan where date='$max_date' order by mod_no*1, shift";
	//echo $sql;
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$module=$sql_row['mod_no'];
		$shift=$sql_row['shift'];
		$plan_eff=$sql_row['plan_eff'];
		$plan_pro=$sql_row['plan_pro'];
		$remarks=$sql_row['remarks'];
		$sec_no=$sql_row['sec_no'];
		$act_hours=$sql_row['act_hours'];
		$couple=$sql_row['couple'];
		$fix_nop=$sql_row['fix_nop'];
		$plan_clh=$sql_row['plan_clh'];
		$plan_sah=$sql_row['plan_sah'];
		$plan_eff_ex=$sql_row['plan_eff_ex'];
		
		$sql1="select distinct bac_style as bac_style,smv,nop from $bai_pro.bai_log_buf where bac_date='$max_date' and bac_no=$module and smv>0 and nop>0 and bac_shift='$shift' order by bac_no";
		//$sql1="select distinct bac_style as bac_style,smv,nop from bai_log_buf where bac_date=\"2012-11-06\" and bac_no=$module and smv>0 and nop>0 order by bac_no";
		
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{	if($shift=='A'){
				$smv=$sql_row1['smv'];
				$nop=$sql_row1['nop'];
				$bac_style=$sql_row1['bac_style'];
			}elseif($shift=='B'){
				$smv1=$sql_row1['smv'];
				$nop1=$sql_row1['nop'];
				$bac_style=$sql_row1['bac_style'];
			}
			
		}
		
		$bgcolor_tag=" style=\"background-color: white\"";
		if($smv>0)
		{
			if(round(($plan_eff*$act_hours*60*$nop)/($smv*100),0)!=round($plan_pro,0))
			{
				$bgcolor_tag=" style=\"background-color: #FFFF66;\"";
			}
		}
		else
		{
			$bgcolor_tag=" style=\"background-color: #FFFF66;\"";
		}
		
		if($shift=="A")
		{
			//Taking default Couple Number as 1 incase couple is 0
			if($couple == 0)
			{
				$couple=1;
			}
			echo "<tr>";
			echo '<td bgcolor=\"#99FFDD\" style="color: #FFFFFF">'.$module.'<input type="hidden" name="module[]" value="'.$module.'"></td>';
			echo '<td bgcolor=\"#99FFDD\" class="hidet"><input type="text" onkeyup="return pop_test(event, this.name)" name="section[]" value="'.$sec_no.'" size="3" onChange="markchange('.$x.')" /readonly></td>';
			//echo '<td bgcolor=\"#99FFDD\" class="hidet"><input type="text" onkeyup="return pop_test_alpha_numeric(event, this.name)" name="style[]" value="'.$bac_style.'" size="" onChange="markchange('.$x.')" id="alpha_style" /readonly></td>';
			echo '<td bgcolor=\"#99FFDD\" class="hidet"><input type="text" name="style[]" value="'.$bac_style.'" size="" onChange="markchange('.$x.')" id="alpha_style" /readonly></td>';
			//echo '<td bgcolor=\"#99FFDD\" class="hidet"><input type="text" onkeyup="return pop_test_float(event, this.name)" name="smv[]" value="'.$smv.'" size="3" onChange="markchange('.$x.')" /readonly></td>';
			echo '<td bgcolor=\"#99FFDD\" class="hidet"><input type="text" name="smv[]" value="'.$smv.'" size="3" onChange="markchange('.$x.')" /readonly></td>';
			echo '<td bgcolor=\"#99FFDD\" class="hidet"><input type="text" onkeyup="return pop_test(event, this.name)" name="nop[]" class="integer" value="'.$nop.'" size="3" onChange="markchange('.$x.')" /readonly></td>';
			echo '<td bgcolor=\"#FFEEFF\"><input type="text" onkeyup="return pop_test(event, this.name)" name="eff_a[]" class="integer" value="'.($plan_eff-$plan_eff_ex).'" size="4" onChange="markchange('.$x.')"></td>';
			echo '<td bgcolor=\"#FFEEFF\"><input type="text" onkeyup="return pop_test(event, this.name)" '.$bgcolor_tag.' name="pro_a[]" class="integer" value="'.round($plan_pro,0).'" size="4" onChange="markchange('.$x.')"></td>';
			
			echo '<td bgcolor=\"#fa1212\"><input type="text" onkeyup="return pop_test(event, this.name)" name="clh_a[]" value="'.$plan_clh.'" size="4" onChange="markchange('.$x.')"></td>';
			
			echo '<td bgcolor=\"#fa1212\"><input type="text" onkeyup="return pop_test(event, this.name)" name="sah_a[]" value="'.$plan_sah.'" size="4" onChange="markchange('.$x.')"></td>';
			
			
			echo '<td bgcolor=\"#FFEEFF\"><input type="text" onkeyup="return pop_test(event, this.name)" name="hrs_a[]" value="'.$act_hours.'" size="4" onChange="markchange('.$x.')"></td>';
			echo '<td bgcolor=\"#FFEEFF\"><input type="text" onkeyup="return pop_test(event, this.name)" name="couple_a[]" class="integer" value="'.$couple.'" size="4" onChange="markchange('.$x.')"></td>';
			echo '<td bgcolor="#FFAA00"><input type="text" onkeyup="return pop_test(event, this.name)" name="fix_nop_a[]" class="integer" value="'.$fix_nop.'" size="4" onChange="markchange('.$x.')"></td>';

			$nop="";
			$smv="";
			$bac_style="";
		}
		
		if($shift=="B")
		{
			//Taking default Couple Number as 1 incase couple is 0
			if($couple == 0)
			{
				$couple=1;
			}

			//echo '<td bgcolor=\"#99FFDD\"><input type="text" onkeyup="return pop_test_float(event, this.name)" name="smv1[]" value="'.$smv1.'" size="3" onChange="markchange('.$x.')" /readonly></td>';
			//echo '<td bgcolor=\"#99FFDD\"><input type="text" class="integer" onkeyup="return pop_test(event, this.name)" name="nop1[]" class="integer" value="'.$nop1.'" size="3" onChange="markchange('.$x.')" /readonly></td>';
			echo '<td bgcolor=\"#99FFDD\"><input type="text" name="smv1[]" value="'.$smv1.'" size="3" onChange="markchange('.$x.')" /readonly></td>';
			echo '<td bgcolor=\"#99FFDD\"><input type="text" class="integer" name="nop1[]" class="integer" value="'.$nop1.'" size="3" onChange="markchange('.$x.')" /readonly></td>';
			echo '<td bgcolor=\"#99FF88\"><input type="text" onkeyup="return pop_test(event, this.name)" name="eff_b[]" class="integer" value="'.($plan_eff-$plan_eff_ex).'" size="4" onChange="markchange('.$x.')"></td>';
			echo '<td bgcolor=\"#99FF88\"><input type="text" '.$bgcolor_tag.' onkeyup="return pop_test(event, this.name)" name="pro_b[]" class="integer" value="'.round($plan_pro,0).'" size="4" onChange="markchange('.$x.')"></td>';
			
			echo '<td bgcolor=\"#fa1212\"><input type="text" onkeyup="return pop_test(event, this.name)" name="clh_b[]" value="'.$plan_clh.'" size="4" onChange="markchange('.$x.')"></td>';
			
			echo '<td bgcolor=\"#fa1212\"><input type="text" onkeyup="return pop_test(event, this.name)" name="sah_b[]" value="'.$plan_sah.'" size="4" onChange="markchange('.$x.')"></td>';
			
			
			echo '<td bgcolor=\"#99FF88\"><input type="text" onkeyup="return pop_test(event, this.name)" name="hrs_b[]" value="'.$act_hours.'" size="4" onChange="markchange('.$x.')"></td>';
			echo '<td bgcolor=\"#99FF88\"><input type="text" onkeyup="return pop_test(event, this.name)" name="couple_b[]" class="integer" value="'.$couple.'" size="4" onChange="markchange('.$x.')"></td>';
			echo '<td bgcolor="#CC66CC"><input type="text" onkeyup="return pop_test(event, this.name)" name="fix_nop_b[]" class="integer" value="'.$fix_nop.'" size="4" onChange="markchange('.$x.')"></td>';
			echo '<td bgcolor=\"#99FF88\"><input type="text"  name="remarks[]" value="'.$remarks.'" size="15" onChange="markchange('.$x.')"><input type="hidden" name="check[]" value=""></td>';
			echo "</tr>";
			$x++;

			$nop1="";
			$smv1="";
			$bac_style="";
		}			
	}
	echo '
	</table>
	
	<br/><br/><div style="position: absolute;margin-top:-50px;margin-left:400px;"><b><font color="red"><a href="javascript:auto_cal_clh('.$x.')" >Click here >>> Auto Calculate Plan Clock<<< </a></font></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton('.$x.');">&nbsp;Enable&nbsp;&nbsp;&nbsp;<INPUT TYPE = "Submit" class="btn btn-primary btn-xs" Name = "update" id="update" VALUE = "Update" disabled></div></div>';
	}
	else
	{
		echo "<h2><font color=red>You are not authorised to use this interface.</font></h2>";
	}
	?>
	
	</form>



<?php

if(isset($_POST['update']))
{
	$date=$_POST['date_change'];
	$remarks=$_POST['remarks'];
	$module=$_POST['module'];
	$section=$_POST['section'];
	$check=$_POST['check'];
	$plan_eff_ex=$_POST['plan_eff_ex'];
	
	$eff_a=$_POST['eff_a'];
	$pro_a=$_POST['pro_a'];
	$hrs_a=$_POST['hrs_a'];
	$couple_a=$_POST['couple_a'];
	$clh_a=$_POST['clh_a'];
	$sah_a=$_POST['sah_a'];
	
	$eff_b=$_POST['eff_b'];
	$pro_b=$_POST['pro_b'];
	$hrs_b=$_POST['hrs_b'];
	$couple_b=$_POST['couple_b'];
	$clh_b=$_POST['clh_b'];
	$sah_b=$_POST['sah_b'];
	
	$fix_nop_a=$_POST['fix_nop_a'];
	$fix_nop_b=$_POST['fix_nop_b'];
	
	$host_name=str_replace(".brandixlk.org","",gethostbyaddr($_SERVER['REMOTE_ADDR']));
	
	$note=date("Y-m-d H:i:s")."_".$username."_".$host_name."<br/>";
	
	for($i=0;$i<sizeof($module);$i++)
	{
		if($check[$i]==1)
		{
						
			$plan_tag=$date."-".$module[$i]."-"."A";
			
			$sql1="insert ignore into $bai_pro.pro_plan (plan_tag) values (\"$plan_tag\")";
			mysqli_query($link, $sql1) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
						
			$sql1="update $bai_pro.pro_plan set sec_no=".$section[$i].", date=\"$date\", mod_no=".$module[$i].", shift=\"A\", plan_eff=".($eff_a[$i]+$plan_eff_ex[$i]).",  plan_pro=".$pro_a[$i].", remarks=\"".$remarks[$i]."\", act_hours=".$hrs_a[$i].", couple=".$couple_a[$i].", fix_nop=".$fix_nop_a[$i].", plan_clh=".$clh_a[$i].",plan_sah=".$sah_a[$i].",plan_eff_ex=".$plan_eff_ex[$i]." where plan_tag=\"".$plan_tag."\"";
			$note.=$sql1."<br/>";
			mysqli_query($link, $sql1) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql1="insert ignore into $bai_pro.pro_plan_today (plan_tag) values (\"$plan_tag\")";
			mysqli_query($link, $sql1) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql1="update $bai_pro.pro_plan_today set sec_no=".$section[$i].", date=\"$date\", mod_no=".$module[$i].", shift=\"A\", plan_eff=".($eff_a[$i]+$plan_eff_ex[$i]).",  plan_pro=".$pro_a[$i].", remarks=\"".$remarks[$i]."\", act_hours=".$hrs_a[$i].", couple=".$couple_a[$i].", fix_nop=".$fix_nop_a[$i].", plan_clh=".$clh_a[$i].",plan_sah=".$sah_a[$i].",plan_eff_ex=".$plan_eff_ex[$i]." where plan_tag=\"".$plan_tag."\"";
			$note.=$sql1."<br/>";
			mysqli_query($link, $sql1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$plan_tag=$date."-".$module[$i]."-"."B";
			$sql1="insert ignore into $bai_pro.pro_plan (plan_tag) values (\"$plan_tag\")";
			mysqli_query($link, $sql1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			$sql1="update $bai_pro.pro_plan set sec_no=".$section[$i].", date=\"$date\", mod_no=".$module[$i].", shift=\"B\", plan_eff=".($eff_b[$i]+$plan_eff_ex[$i]).",  plan_pro=".$pro_b[$i].", remarks=\"".$remarks[$i]."\", act_hours=".$hrs_b[$i].", couple=".$couple_b[$i].", fix_nop=".$fix_nop_b[$i].", plan_clh=".$clh_b[$i].",plan_sah=".$sah_b[$i].",plan_eff_ex=".$plan_eff_ex[$i]." where plan_tag=\"".$plan_tag."\"";
			$note.=$sql1."<br/>";
			mysqli_query($link, $sql1) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql1="insert ignore into $bai_pro.pro_plan_today (plan_tag) values (\"$plan_tag\")";
			mysqli_query($link, $sql1) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
						
			$sql1="update $bai_pro.pro_plan_today set sec_no=".$section[$i].", date=\"$date\", mod_no=".$module[$i].", shift=\"B\", plan_eff=".($eff_b[$i]+$plan_eff_ex[$i]).",  plan_pro=".$pro_b[$i].", remarks=\"".$remarks[$i]."\", act_hours=".$hrs_b[$i].", couple=".$couple_b[$i].", fix_nop=".$fix_nop_b[$i].", plan_clh=".$clh_b[$i].",plan_sah=".$sah_b[$i].",plan_eff_ex=".$plan_eff_ex[$i]." where plan_tag=\"".$plan_tag."\"";
			$note.=$sql1."<br/>";
			mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		}
	}
	
	$myFile = date("Y_m_d")."update_track.html";
	echo $myFile;
	$fh = fopen($myFile, 'a') or die("<span style='color:red;'><center>can't open file</center></span>");
	$stringData = $note;
	fwrite($fh, $stringData);
	//Writing file
	
	// echo "<h2><font color=\"green\">Successfully Updated.</font></h2>";
	echo "<script>swal('Successfully Updated','','success');</script>";
	$url=getFullURL($_GET['r'],'plan_update_v2.php','N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"$url\"; }</script>";
}

?>

</div>
</div>
