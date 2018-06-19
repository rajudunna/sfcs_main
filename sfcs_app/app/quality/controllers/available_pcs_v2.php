<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
//include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
//$view_access=user_acl("SFCS_0139",$username,1,$group_id_sfcs);
/*
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);

$author_id_db=array("kirang","baiadmn","lakmalka","ramaraop","sarojinig","baiquality","kirang","sumudup","kirang","kirang");
$has_perm=haspermission($_GET['r']);
if(in_array($authorized,$has_perm))
{
	
}
else
{
	$url = getFullURL($_GET['r'],'restricted.php','N');
	header("Location:$url");
}
*/
?>

<html>
<head>
<title>Available Panels</title>


<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
	
</script> 



<script>

function enable_button()
{
	var checkedStatus = document.getElementById("enable").checked;
	
	if(checkedStatus===true)
	{
		document.getElementById("add").disabled=false;
	}
	else
	{
		document.getElementById("add").disabled=true;
		
	}
}

</script>
<script>

	function verify_date(){
		var val1 = $('#sdate').val();
		var val2 = $('#edate').val();
		
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
}
</script>

<style type="text/css" media="screen">

div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; border:1px solid #ccc; white-space: nowrap;}
.mytable td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space: nowrap;}

</style>
</head>

<body>


<?php

if(isset($_POST['confirm'])){
	
	$chk=$_POST['chk'];
	$qty=$_POST['qty'];
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$size=$_POST['size'];
	
	for($i=2;$i<sizeof($qty)+2;$i++){
		if($qty[$i]>0 and $chk[$i]==1){
			$sql="insert into $bai_pro3.bai_qms_db(qms_style,qms_schedule,qms_color,log_user,log_date,qms_size,qms_qty,qms_tran_type) values('".$style[$i]."','".$schedule[$i]."','".$color[$i]."','".$username."','".date("Y-m-d")."','".$size[$i]."','".$qty[$i]."',12)";
			
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
}

?>
<div class="panel panel-primary">
<div class="panel-heading">Available Panels</div>
<div class="panel-body">
	<div class="col-md-12">
<form name="input" method="post" action="index.php?r=<?php echo $_GET['r']; ?>">
<div class="col-md-3">
<label for="sdate">Start Date</label>
 <input type="text" data-toggle="datepicker" name="sdate" id="sdate"  size="10"  class="form-control" value="<?php  if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>">
</div>
<div class="col-md-3">

 <label for="edate">
 End Date</label>
  <input type="text" data-toggle="datepicker" name="edate" id="edate"  size="10"  class="form-control" onchange="return verify_date();" value="<?php  if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>">
</div>
<div class="col-md-3">

  <label for="division">Buyer</label><select class="form-control" name="division">
<option value='All' <?php if($division=="All"){ echo "selected"; } ?> >All</option>
<option value='VS' <?php if($division=="VS"){ echo "selected"; } ?> >VSS/D</option>
<option value='M&' <?php if($division=="M&"){ echo "selected"; } ?> >M&S</option>
<option value='LB' <?php if($division=="LB"){ echo "selected"; } ?> >LBI</option>
</select>
</div>
<div class="col-md-1">

<label for="filter"></label>
<input type="submit" name="filter"  class="form-control btn btn-success" onclick="return verify_date();" value="Filter">
</div>
</div>
</form>

<?php

if(isset($_POST["filter"]))
{
$sdate=$_POST['sdate'];
$edate=$_POST['edate'];
$buyer=$_POST["division"];

$export_excel="";
?>
<br/>
<br/>
<br/>
<form name="update" method="post"  action="index.php?r=<?php echo $_GET['r']; ?>">
	<?php

echo '<br/>&nbsp;&nbsp;<input type="checkbox" name="enable" id="enable" onclick="enable_button()">Enable&nbsp;&nbsp;<input type="submit" name="confirm" value="update reserve to destroy" 
id="add" disabled="true" class="btn btn-success"  onclick="enable_button()">';
$table="<table class=\"table table-bordered mytable\" id=\"table1\">";
$table.="<thead>";
$table.="<tr>";
$table.='<th>SNo<input type="checkbox" name="selectall" id="selectall"/></th>';
$table.="<th>Style</th>";
$table.="<th>Schedule</th>";
$table.="<th>Color</th>";
$table.="<th>Size</th>";
$table.="<th>Available</th>";
$table.="<th>Reserve to Destroy Quantity</th>";
$table.="</tr>";
$table.="</thead><tbody>";
echo $table;


//Export to Excel
$export_table="<table>";
$export_table.="<thead>";
$export_table.="<tr>";
$export_table.='<th>SNo</th>';
$export_table.="<th>Style</th>";
$export_table.="<th>Schedule</th>";
$export_table.="<th>Color</th>";
$export_table.="<th>Size</th>";
$export_table.="<th>Available</th>";
$export_table.="<th>Reserve to Destroy Quantity</th>";
$export_table.="</tr>";
$export_table.="</thead><tbody>";
//Export to Excel

$x=2;

//$sql="select (good_panels-replaced-tran_sent-resrv_dest) as available,qms_schedule,qms_size,qms_style,qms_color from bai_qms_day_report where (good_panels-replaced-tran_sent-resrv_dest)>0 and log_date between \"$sdate\" and \"$edate\" order by qms_schedule,qms_color,qms_size";
//echo $sql;

if($buyer=="All")
{
	//$sql="select * from bai_qms_day_report where log_date between \"$sdate\" and \"$edate\"";
	$sql="select (good_panels-replaced-tran_sent-resrv_dest) as available,qms_schedule,qms_size,qms_style,qms_color from $bai_pro3.bai_qms_day_report where (good_panels-replaced-tran_sent-resrv_dest)>0 and log_date between \"$sdate\" and \"$edate\" order by qms_schedule,qms_color,qms_size";
}
else if($buyer=="VS")
{
	//$sql="select * from bai_qms_day_report where log_date between \"$sdate\" and \"$edate\" and (qms_style like \"L%\" or qms_style like \"O%\" OR qms_style like \"G%\" or qms_style like \"P%\" or qms_style like \"K%\")";
	$sql="select (good_panels-replaced-tran_sent-resrv_dest) as available,qms_schedule,qms_size,qms_style,qms_color from $bai_pro3.bai_qms_day_report where (good_panels-replaced-tran_sent-resrv_dest)>0 and log_date between \"$sdate\" and \"$edate\" and (qms_style like \"L%\" or qms_style like \"O%\" OR qms_style like \"G%\" or qms_style like \"P%\" or qms_style like \"K%\") order by qms_schedule,qms_color,qms_size";
}
else if($buyer=="M&")
{
	//$sql="select * from bai_qms_day_report where log_date between \"$sdate\" and \"$edate\" and qms_style like \"M%\"";
	$sql="select (good_panels-replaced-tran_sent-resrv_dest) as available,qms_schedule,qms_size,qms_style,qms_color from $bai_pro3.bai_qms_day_report where (good_panels-replaced-tran_sent-resrv_dest)>0 and log_date between \"$sdate\" and \"$edate\" and qms_style like \"M%\" order by qms_schedule,qms_color,qms_size";
}
else if($buyer=="LB")
{
	//$sql="select * from bai_qms_day_report where log_date between \"$sdate\" and \"$edate\" and qms_style like \"Y%\"";
	$sql="select (good_panels-replaced-tran_sent-resrv_dest) as available,qms_schedule,qms_size,qms_style,qms_color from $bai_pro3.bai_qms_day_report where (good_panels-replaced-tran_sent-resrv_dest)>0 and log_date between \"$sdate\" and \"$edate\" and qms_style like \"Y%\" order by qms_schedule,qms_color,qms_size";
}
else
{
	//$sql="select * from bai_qms_day_report where log_date between \"$sdate\" and \"$edate\"";
	$sql="select (good_panels-replaced-tran_sent-resrv_dest) as available,qms_schedule,qms_size,qms_style,qms_color from $bai_pro3.bai_qms_day_report where (good_panels-replaced-tran_sent-resrv_dest)>0 and log_date between \"$sdate\" and \"$edate\" order by qms_schedule,qms_color,qms_size";
}

$sql_result=mysqli_query($link, $sql) or exit("Sql Errora".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$table="<tr class=\"foo\" id=\"rowchk$x\">";
	$table.="<td><input type=\"checkbox\" name=\"chk[$x]\" id=\"chk[$x]\" value='1' onclick=\"selectind($x)\"/>".($x-1)."</td>";
	$table.="<td>".$sql_row['qms_style']."</td>";
	$table.="<td>".$sql_row['qms_schedule']."</td>";
	$table.="<td>".$sql_row['qms_color']."</td>";
	$table.="<td>".$sql_row['qms_size']."</td>";
	$table.="<td>".$sql_row['available']."</td>";
	$table.="<td><input type=\"text\" name=\"qty[$x]\" value=\"".$sql_row['available']."\" onchange='if(this.value<0 || this.value>".$sql_row['available'].") { this.value=0; alert(\"Please enter correct value\"); }'>
<input type=\"hidden\" name=\"style[$x]\" value=\"".$sql_row['qms_style']."\">
<input type=\"hidden\" name=\"schedule[$x]\" value=\"".$sql_row['qms_schedule']."\">
<input type=\"hidden\" name=\"color[$x]\" value=\"".$sql_row['qms_color']."\">
<input type=\"hidden\" name=\"size[$x]\" value=\"".$sql_row['qms_size']."\">
</td>";
	$table.="</tr>";
	
	echo $table;
	
	//Export Excel
	
	$export_table.="<tr>";
	$export_table.="<td>".($x-1)."</td>";
	$export_table.="<td>".$sql_row['qms_style']."</td>";
	$export_table.="<td>".$sql_row['qms_schedule']."</td>";
	$export_table.="<td>".$sql_row['qms_color']."</td>";
	$export_table.="<td>".$sql_row['qms_size']."</td>";
	$export_table.="<td>".$sql_row['available']."</td>";
	$export_table.="<td></td>";
	$export_table.="</tr>";
	
	//Export Excel
	
	$x++;
}
$table='</tbody></table>';
$export_table.='</tbody></table>';
echo $table;

echo '</form>';
?>
<div id="div-1a">
<form  name="input" action="<?php echo getFullURL($_GET['r'], "export_excel.php", "R"); ?>" method="post">
<input type="hidden" name="table" value="<?php echo $export_table; ?>">
<input type="hidden" name="file_name" value="Available_Panels">
<input type="submit" name="submit" class="btn btn-success" value="Export to Excel">
</form>
</div>
<?php
}
?>



<script>


	$("#table1 thead tr th:first input:checkbox").click(function() {
	    var checkedStatus = document.getElementById("selectall").checked;
	    td = document.getElementsByTagName('tr');

	    if(checkedStatus==true)
	    {
		    for (var  i = 2; i <= td.length; i++) {
		    	var id = 'chk['+i+']';
		    	console.log(document.getElementById('chk['+i+']').checked = true);
		    }  
	    }else  
	    {

		    for (var  i = 2; i <= td.length; i++) {
		    	var id = 'chk['+i+']';
		    	console.log(document.getElementById('chk['+i+']').checked = false);
		    }  

	    }       
	});


function selectind(x)
{
	var checkedStatus = document.getElementById('chk['+x+']').checked;
	if(checkedStatus==true)
	{
		document.getElementById('rowchk'+x).style.background="#00FF22";
	}
	else
	{
		document.getElementById('rowchk'+x).style.background="white";
	}
}


function autofill()
{
	var val=document.getElementById("autofillval").value;
	var td = document.getElementsByTagName('tr');
	
	for (var  i = 0; i < td.length; i++) {
       if(td[i].className == "foo")
	   {
	   		if(td[i].style.display=="block" || td[i].style.display=="")
			{
				if(document.getElementById('chk['+i+']').checked==true)
				{
					document.getElementById('val['+i+']').value=val;
				}
			}
	   }
           
    }
}

</script>
</div>
</div>
</body>

</html>