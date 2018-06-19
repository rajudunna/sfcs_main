
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
//include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/m3_bulk_or_proc.php',4,'R'));
//$view_access=user_acl("SFCS_0218",$username,1,$group_id_sfcs); 
//$auth_users=user_acl("SFCS_0218",$username,7,$group_id_sfcs); 
//$has_perm=haspermission($_GET['r']);
?>
<?php
//$auth_users=array("kirang","kirang","malleswararaog","varalaxmib","swatikumariv");

// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
// $username=strtolower($username_list[1]);


// if(in_array($authorized,$has_perm))
// {
	
// }
// else
// {
// 	$url = getFullURL($_GET['r'],'restricted.php','N');
// 	header("Location:$url");
// }

function dateDiffsql($link,$start,$end)
{
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	$sql="select distinct bac_date from $bai_pro.bai_log_buf where bac_date<='$start' and bac_date>='$end'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	return mysqli_num_rows($sql_result);
}
?>


<script>
function dodisable()
{
//enableButton();
 
document.input.update.style.visibility="hidden"; 

}


function check1(x) 
{
	if(x==" " || document.input.source.value==" " || document.input.team.value==" " || document.input.module.value==" ")
	{
		document.input.update.style.visibility="hidden"; 
	} 
	else 
	{
		
		document.input.update.style.visibility=""; 
	}
}
</script>

<script>
var url = '<?php getFullURL($_GET['r'],'sample_room.php','N')?>';
function firstbox()
{
	window.location.href = url+"&style="+document.test.style.value
}

function secondbox()
{
	window.location.href = url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value
}

function thirdbox()
{
	window.location.href = url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}
</script>

<!-- <style>
body
{
	font-family: arial;
}
table
{
	border-collapse:collapse;
	font-size:12px;
}
td
{
	border: 1px solid #29759c;
	white-space:nowrap;
	border-collapse:collapse;
}

th
{
	border: 1px solid #29759c;
	white-space:nowrap;
	border-collapse:collapse;
	
}
</style>


<!-- <style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "../TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	font-size:12px;
	border:1px solid #ccc;
}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; white-space: nowrap;}
.mytable td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space: nowrap;}

</style> -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R')?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R')?>"></script>


<body onload="dodisable()">

<div class="panel panel-primary">
<div class="panel-heading">Embellishment Room - Garments Received Confirmation Form</div>
<div class="panel-body">
<?php
if(isset($_POST['update']))
{
	$check=$_POST['check'];
	$tid=$_POST['tid'];
	
	
	$usr_msg="<div class='alert alert-danger' role='alert'>The following entries are failed to update due to M3 system validations:</div><br/><table class='table table-bordered'><tr><th>Module</th><th>Schedule</th><th>Color</th><th>Size</th><th>Quantity</th></tr>";
	
	
	for($i=0;$i<sizeof($check);$i++)
	{
		$key=$check[$i];
		
		$sql1="select * from $bai_pro3.bai_emb_excess_db where qms_tran_type='0' and qms_tid='".$tid[$key]."'";	
	
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$style=$sql_row1['qms_style'];
			$schedule=$sql_row1['qms_schedule'];
			$color=$sql_row1['qms_color'];
			$size=$sql_row1['qms_size'];
			$qty=$sql_row1['qms_qty'];
			$module=$sql_row1['remarks'];
		}
		 
		if(m3_cpk_validation('ASPS','SOT',$schedule,$color,$size,$qty)=='TRUE')
		{
		
			$sql="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_remarks) SELECT NOW(),qms_style,qms_schedule,qms_color,qms_size,doc_no,qms_qty,USER(),'ASPS',qms_tid,'EXCESS' FROM $bai_pro3.bai_emb_excess_db WHERE qms_tid=".$tid[$key]." AND qms_tid NOT IN (SELECT sfcs_tid_ref FROM m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_schedule=$schedule and  m3_op_des='ASPS' and sfcs_remarks='EXCESS')";
			
			mysqli_query($link, $sql) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));	
			
		
			$sql="update $bai_pro3.bai_emb_excess_db set qms_tran_type=1 where qms_tid=".$tid[$key];
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				
			
		}
		else
		{
			
			$usr_msg.="<tr><td>".$module."</td><td>".$schedule."</td><td>".$color."</td><td>".$size."</td><td>".$qty."</td></tr>";
		  }
	}
	
	$usr_msg.="</table><hr/>";
	
	
	//Validations
	echo $usr_msg;
}

?>
<form name="test" action="<?php echo '?r='.$_GET['r']; ?>" method="post">
<?php



echo "<table class=\"table table-bordered\" cellspacing=\"0\" id=\"table1\">";
echo "<tr>
	<th>Style</th>
	<th>Schedule</th>
	<th>Color</th>
	<th>Size</th>
	<th>Quantity</th>	
	<th>Control</th>
	<th>Input Date</th>

</tr>";
$i=0;
$sql="select * from $bai_pro3.bai_emb_excess_db where qms_tran_type=0";	
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
		
	
	echo "<tr>";
		echo "<td>".$sql_row['qms_style']."</td>";
		echo "<td>".$sql_row['qms_schedule']."</td>";
		echo "<td>".$sql_row['qms_color']."</td>";
		echo "<td>".$sql_row['qms_size']."</td>";
		echo "<td>".$sql_row['qms_qty']."</td>";
		echo "<td><input type=\"checkbox\" value=\"$i\" name=\"check[]\">
			<input type=\"hidden\" value=\"".$sql_row['qms_tid']."\" name=\"tid[]\">			
		</td>";
		echo "<td>".$sql_row['log_date']."</td>";
	echo "</tr>";
	$i++;
}
echo "</table><br/>";
echo '<div class="alert alert-info" role="alert" id="msg" style="display:none;">Please Wait...</div>';
echo "<input type=\"submit\" name=\"update\" class='btn btn-primary' value=\"Update\" id=\"update\" onclick=\"document.getElementById('update').style.display='none'; document.getElementById('msg').style.display='';\"></form>";

?>

<script language="javascript" type="text/javascript">
//<![CDATA[
	var table6_Props = 	{
		rows_counter: true,
		sort_select: true,
		on_change: true,
		display_all_text: " [ ALL ] ",
		// loader_text: "Filtering data...",  
	loader: true,
	col_0: "select", 
	col_1: "select", 
	col_2: "select",
	col_3: "select", 
	col_4: "select", 
	// col_5: "",
	col_6: "select", 

	// loader_text: "Filtering data...",
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear"
						};
	setFilterGrid( "table1",table6_Props );
//]]>
</script>
</div>
</div>
</body>
