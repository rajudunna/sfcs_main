<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$has_permission = haspermission($_GET['r']);

?>

<script>

function box(x)
{
	var php_url = '<?= getFullURL($_GET['r'],'pop_view3.php','R');?>';
	var url= php_url+"?dep_id="+document.getElementById("dep_" + x).value+"&row_id="+x;
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
    document.getElementById("reason_code_" + result[0]).value = result[1];
    document.getElementById("dep_" + result[0]).value =result[2];
	var res_code=document.getElementById("reason_code_" + result[0]).value = result[1];
}
 
function calculate(j) 
{
    var i=j; 
    
    var nop = document.getElementById("nop_" + i).value;
	var stime = document.getElementById("s_" + i).value;
	var etime = document.getElementById("r_" + i).value;
	var ltime = document.getElementById("l_" + i).value;
	var extime = document.getElementById("ex_" + i).value;	
	
	stimesplit=stime.split(":");
	etimesplit=etime.split(":");
	
	stimeval=parseInt(parseInt((stimesplit[0]*60))+parseInt(stimesplit[1]));
	etimeval=parseInt(parseInt((etimesplit[0]*60))+parseInt(etimesplit[1]));
	
	diff=parseInt(etimeval)-parseInt(stimeval);
	if(parseInt(diff)>=0)
	{
		document.getElementById("l_" + i).value=parseInt(0);
		document.getElementById("l_" + i).value=parseInt(diff*nop)-parseInt(nop*extime);	
	}
	else
	{
		if(etime != 0)
		{
			sweetAlert("Please Enter Correct Time.","","info");
		}	
		document.getElementById("r_" + i).value="";
		document.getElementById("l_" + i).value=parseInt(0);
		document.getElementById("ex_" + i).value=parseInt(0);
	}
	
	if(parseInt(diff)<parseInt(extime))
	{
		document.getElementById("l_" + i).value=parseInt(0);
		document.getElementById("ex_" + i).value=parseInt(0);
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
<div class="panel panel-primary">
<div class="panel-heading">DownTime Update</div>
<div class="panel-body">
<form name="f1" action="<?php echo '?r='.$_GET['r']; ?>" method="post" class="form-inline">


<label>Date</label>
<div class="form-group">
<div class="col-md-3">
<?php 



$sql="SELECT DISTINCT bac_date FROM $bai_pro.bai_log_buf WHERE bac_date<\"".date("Y-m-d")."\" ORDER BY bac_date";

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$max_allowed_date=$sql_row['bac_date'];
}

if(in_array($authorized,$has_permission))
{
	echo '<input type="text" class="form-control" name="date" value="'.date("Y-m-d").'" size="10" >'; 
}
else
{
	echo '<input type="text" class="form-control" name="date" readonly value="'.date("Y-m-d").'" size="10" onchange="check_date(this.value,\''.$max_allowed_date.'\',\''.date("Y-m-d").'\');" >'; 
}

?>
</div>
</div>
<hr/>
<div class="table-responsive"><table align="left" class="table table-bordered">
<tr><th><center>Section<center></th><th><center>Shift<center></th><th><center>Module<center></th><th><center>Style<center></th><th><center>Schedule<center></th><th><center>NOP<center></th><th><center>Start time<center></th><th><center>End time<center></th><th><center>Total <br> Lost Mins<center></th><th><center>Exception <br> Time (Mins)<center></th><th><center>Department<center></th><th><center>Reason<center></th><th><center>Remarks<center></th><th><center>Source</th></tr>
<?php 




$date=date("Y-m-d");

for($i=0;$i<=10;$i++)
{
	
	$mins=array("00","05","10","15","20","25","30","35","40","45","50","55");

	echo"<tr>

	<td>

	<select name=\"sec[$i]\" id=\"sec_$i\" name=\"sec_$i\" class=\"form-control\">";
	$sql="SELECT sec_id FROM $bai_pro3.sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
	//echo $sql;
	$result7=mysqli_query($link, $sql) or exit("Sql Erro1r".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($result7))
	{
		echo "<option value=\"".$sql_row["sec_id"]."\">".$sql_row["sec_id"]."</option>";
	}

	echo "</select>
	</td>	
	<td align='center'>
	<select name=\"shift[$i]\" class=\"form-control\">
	<option value=\"A\">A</option>
	<option value=\"B\">B</option>
	</select>
	</td>

	<td><select name=\"module[$i]\" id=\"module_$i\" class=\"form-control\">";

	$sql="SELECT GROUP_CONCAT(sec_mods) as mods FROM $bai_pro3.sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
	$result7=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($result7))
	{
		$sql_mod=$sql_row["mods"];
	}

	$sql_mods=explode(",",$sql_mod);

	for($ia=0;$ia<sizeof($sql_mods);$ia++)
	{
		echo "<option value=\"".$sql_mods[$ia]."\">".$sql_mods[$ia]."</option>";
	}


	echo "</select>
	</td>
	<td><select name=\"sty[$i]\" id=\"style_$i\" class=\"form-control\">";

	$sql22="select distinct style_id from $bai_pro2.movex_styles order by style_id";
	$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row22=mysqli_fetch_array($sql_result22))
	{
		echo '<option value="'.$sql_row22['style_id'].'">'.$sql_row22['style_id'].'</option>';
	}


	echo "</select></td><td>
	<div>
	<p>

	<select name=\"sch[$i]\" id=\"sch_$i\" class=\"form-control\">";

	
	$sql22="select distinct order_del_no as schedule_no from $bai_pro3.bai_orders_db where order_del_no > 25000 order by order_del_no+0";
	$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row22=mysqli_fetch_array($sql_result22))
	{
		echo "<option value=".$sql_row22['schedule_no'].">".$sql_row22['schedule_no']."</option>";
	}


	echo "</select></p>
	</div>
	</td>";



	echo "
	<td><input type=\"text\" class=\"form-control\" onkeypress='return validateQty(event);' oncopy='return false' onpaste='return false' name=\"nop[$i]\" size=\"5\" id=\"nop_$i\" value=\"16\" class=\"form-control\"></td>
	<td>
	<div>
	<p>


	<SELECT name=\"s[$i]\" id=\"s_$i\" onchange=\"calculate($i)\" class=\"form-control\">

	<option value=\"0\" name=\"s".$i."\">Select Start Time</option>
	";


	for($l=6;$l<=22;$l++)
	{
		for($k=0;$k<sizeof($mins);$k++)
		{
			if($l<13)
			{
				if($l==12)
				{
					echo "<option value=\"".$l.":".$mins[$k]."\" name=\"s".$i."\">".$l.":".$mins[$k]." PM</option>";
				}
				else
				{
					echo "<option value=\"".$l.":".$mins[$k]."\" name=\"s".$i."\">".$l.":".$mins[$k]." AM</option>";
				}	
			}
			else
			{
				$r=$l-12;
				echo "<option value=\"".$l.":".$mins[$k]."\" name=\"s".$i."\">".$r.":".$mins[$k]." PM</option>";
			}
		}
		
	}
	echo "</SELECT>

	</p>

	</div>

	</td><td>

	<div>

	<p>


	<SELECT name=\"r[$i]\" id=\"r_$i\" value=\"r_$i\" onchange=\"calculate($i)\" class=\"form-control\">

	<option value=\"0\" name=\"r".$i."\">Select End Time</option>
	";

	for($l=6;$l<=22;$l++)
	{
		for($k=0;$k<sizeof($mins);$k++)
		{
			if($l<13)
			{
				if($l==12)
				{
					echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$i."\">".$l.":".$mins[$k]." PM</option>";
				}
				else
				{
					echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$i."\">".$l.":".$mins[$k]." AM</option>";
				}
			}
			else
			{
				$r=$l-12;
				echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$i."\">".$r.":".$mins[$k]." PM</option>";
			}
		}	
	}

	echo "</SELECT>

	</p>

	</div>

	</td>

	<td><input type=\"text\" class=\"form-control\" name=\"l[$i]\" size=\"5\" id=\"l_$i\" readonly value=\"0\" class=\"form-control\"/></td>

	<td><input type=\"text\" class=\"form-control\" name=\"ex[$i]\" onkeypress='return validateQty(event);' oncopy='return false' onpaste='return false' size=\"5\" id=\"ex_$i\" onkeyup=\"calculate($i)\" value=\"0\" class=\"form-control\"/></td>

	<td><div><p><select name=\"dep[$i]\" id=\"dep_$i\" class=\"form-control\">";

	$sqll1="select * from $bai_pro.down_deps";
	$sql_resultl1=mysqli_query($link, $sqll1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_rowl1=mysqli_fetch_array($sql_resultl1))
	{
		$dep_id=$sql_rowl1['dep_id'];
		echo "<option value=".$sql_rowl1['dep_id'].">".$sql_rowl1['dep_name']."</option>";
	}

	echo "</select></p></div></td>";
	echo "<td><input type=\"text\" class=\"form-control\" name=\"reason_code[$i]\" readonly id=\"reason_code_$i\" size=3><span onclick=\"box($i)\" class='btn btn-info btn-xs'>Select Reason</sapn></td>"; 
		
	echo '<td><input type="text" class="form-control" name="reason['.$i.']" value="" size="20" class="form-control"></td>';

	echo "<td><select name=\"source[$i]\" class=\"form-control\">
	<option value=0>Internal</option>
	<option value=1>External</option>
	</select>
	</td>";
	echo "</tr>";
}
?>
</table></div>
<br>
<input type="submit" name="submit" value="Submit" onclick = 'return check_reasons(<?= $i ?>)' class="btn btn-primary pull-right"/>

<span id="msg" style="display:none;">Please Wait..</span>
</form>

<?php
if(isset($_POST["submit"]))
{
	$section=$_POST["sec"];
	$shift=$_POST["shift"];
	$module=$_POST["module"];
	$style=$_POST["sty"];
	$schedule=$_POST["sch"];
	$date=$_POST["date"];
	
	
	$start_time=$_POST["s"];
	$end_time=$_POST["r"];
	$lost_mins=$_POST["l"];
	$exc_time=$_POST["ex"];
	$nop=$_POST["nop"];
	
		
	$department=$_POST["dep"];
	$reason=$_POST["reason"];
	$source=$_POST["source"];

	
	$capture="1";
	if(empty($section) || empty($shift)|| empty($module)|| empty($style) ||empty($schedule) || empty($date) == '' || empty($start_time) == '' || empty($end_time) == '' || empty($lost_mins) == '0' || empty($exc_time) || empty($nop)|| empty($department) || empty($reason)|| empty($source)    ){
			
	}
	$reason_code=$_POST['reason_code'];
	
	$lastup=date("Y-m-d H:i:s");

	for($i=0;$i<sizeof($module);$i++)
	{
		if($lost_mins[$i]>0)
		{
			if($schedule[$i]!=0)
			{
				$order_style_no=0;
				$sql3="select distinct order_style_no as order_style_no from $bai_pro3.bai_orders_db where order_del_no='".$schedule[$i]."'";
				$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row3=mysqli_fetch_array($sql_result3))
				{
					$order_style_no=$sql_row3["order_style_no"];
				}
			
			
			
				$sql1="SELECT distinct(buyer_id) as buyer FROM $bai_pro2.movex_styles WHERE movex_style=\"".$order_style_no."\"";	
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$buyer[$i]=$sql_row1["buyer"];
				}
			
			}
			else if($style[$i]!='')
			{
				$sql_buyer="SELECT distinct(buyer_id) as buyer  FROM $bai_pro2.movex_styles where style_id='".$style[$i]."' and buyer_id!=''";
				
				$sql_result=mysqli_query($link, $sql_buyer) or exit($sql_buyer."Sql Error 3".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$buyer[$i]=$sql_row["buyer"];
				}
				
				
			}
			else
			{
				$sql_buyer="SELECT buyer FROM $bai_pro3.buyer_style a join $bai_pro3.plan_modules b on a.buyer_name=b.buyer_div where module_id=".$module[$i];
				$sql_result_buyer=mysqli_query($link, $sql_buyer) or exit($sql_buyer."Sql Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row_buyer=mysqli_fetch_array($sql_result_buyer))
				{
					$buyer[$i]=$sql_row_buyer["buyer"];
				}
			}
			
			
			$sql2="insert into $bai_pro.down_log(mod_no,date,department,remarks,style,dtime,shift,section,customer,schedule,source,capture,lastup,nop,start_time,end_time,reason_code,updated_by) values (".$module[$i].", \"".$date."\", \"".$department[$i]."\",\"".$reason[$i]."\", \"".$style[$i]."\", ".$lost_mins[$i].", \"".$shift[$i]."\", \"".$section[$i]."\", \"".$buyer[$i]."\", \"".$schedule[$i]."\", \"".$source[$i]."\", \"".$capture."\", \"".$lastup."\",\"".$nop[$i]."\",\"".$start_time[$i]."\",\"".$end_time[$i]."\",".$reason_code[$i].",'$username')";
			$result = mysqli_query($link, $sql2) or exit("Sql Error[$i]".mysqli_error($GLOBALS["___mysqli_ston"]));
			if ($result=='1') {
					echo "<script>sweetAlert('Success!','Downtime Captured Successfully','success');</script>";
			} else {
				echo "<script>sweetAlert('Warning!','Failed to Capture','warning');</script>";
			}
			
		}
	}

}
?>

</div>
</div>

<script>
function check_reasons(count){
		for(var i = 0;i<Number(count);i++){
		var val = document.getElementById('reason_code_'+i).value;
		var stime = document.getElementById("s_" + i).value;
		var etime = document.getElementById("r_" + i).value;
		var totlostmin = document.getElementById("l_" + i).value;

		if(totlostmin > 0 && val == '')
		{
			swal('Please select atleast one Reason','','warning');
			return false;
		}
		
	}
	
	return true;
	
}

</script>