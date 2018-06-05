<?php

//This interface is used to confirm destory quantity.
//CR #198 / 2014-12-18 / kirang / Taken the usernames from databse level
include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
$view_access=user_acl("SFCS_0172",$username,1,$group_id_sfcs);


include("../dbconf.php");
/*
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);

$sql="select * from menu_index where list_id=288";
$result=mysql_query($sql,$link) or mysql_error("Error=".mysql_error());
while($row=mysql_fetch_array($result))
{
	$users=$row["auth_members"];
}

$author_id_db=explode(",",$users);

if(in_array($username,$author_id_db))
{
	
}
else
{
	header("Location:restricted.php");
}
*/
?>

<html>
<head>
<title>Confirm Destroy</title>
<style>
body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: BLUE;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table td.new
{
	background-color: BLUE;
	color: WHITE;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

}
</style>

<style rel="stylesheet" type="text/css">
#div-1a {
 position:absolute;
 top:50px;
 right:0;
 width:auto;
float:right;
}
</style>

<script type="text/javascript" src="../jquery.min.js"></script>

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<style type="text/css" media="screen">
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
	width:100%; font-size:12px;
	border:1px solid #ccc;
}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; white-space: nowrap;}
.mytable td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space: nowrap;}

</style>
<script language="javascript" type="text/javascript" src="../TableFilter_EN/actb.js"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="../TableFilter_EN/tablefilter.js"></script>

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


</head>

<body>


<div id="page_heading"><span style="float: left"><h3>Confirm Destroy (Internal)</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>

<form name="filter" method="post" action="">
<table><tr><td>Schedules: <input type="text" value="" size="90" name="schlist"></td><td><input type="checkbox" name="showall" value="1">(Y/N)Show all schedules.</td><td><input type="submit" name="schsbt" value="Filter"></td></tr></table>
	
</form>

<?php

if(isset($_POST['confirm'])){
	

	$schedule=array_unique($_POST['sch_list']);

	for($i=0;$i<sizeof($schedule);$i++){
		
			//To store the reserve locations cartons in remarks column in bai_qms_db details before destory not confirmation
			$sql="update bai_qms_db set remarks=location_id where qms_schedule='".$schedule[$i]."' and location_id<>'INTDESTROY' and qms_tran_type=13";
			//echo $sql;
			mysql_query($sql,$link) or exit("Sql Error:$sql".mysql_error());
			
			$sql="update bai_qms_db set location_id='INTDESTROY' where qms_schedule='".$schedule[$i]."' and location_id<>'INTDESTROY' and qms_tran_type=13";
			//echo $sql;
			mysql_query($sql,$link) or exit("Sql Error:$sql".mysql_error());
			
	}
	
	
	
	echo "Successfully Updated.";
}

?>

<?php


if(isset($_POST['schsbt']))
{
	
$schlist=$_POST['schlist'];
$showall=$_POST['showall'];

$addfilter="qms_schedule in ($schlist) and ";
if($showall=="1")
{
	$addfilter="";
}


if(strlen($schlist)>0 or $showall=="1")
{


//Serial number and Post variable index key
$x=0;



echo '<form name="update" method="post" action="'.$_SERVER['PHP_SELF'].'">';
echo '<input type="checkbox" name="enable" id="enable" onclick="enable_button()">Enable<input type="submit" name="confirm" value="Confirm Destroy" id="add" disabled="true" onclick="enable_button()">';

$table="<table class=\"mytable\" id=\"table1\">";
$table.="<thead>";
$table.="<tr>";
$table.='<th>SNo</th>';
$table.="<th>Style</th>";
$table.="<th>Schedule</th>";
$table.="<th>Color</th>";
$table.="<th>Size</th>";
$table.="<th>Available Quantity</th>";
$table.="<th>Existing Locations</th>";
$table.="</tr>";
$table.="</thead><tbody>";
echo $table;

$sql="
select 

SUM(IF((qms_tran_type= 13 and location_id<>'INTDESTROY'),qms_qty,0))
   
    as qms_qty,qms_style,qms_schedule,qms_color,qms_size,group_concat(qms_tid) as qms_tid, group_concat(concat(location_id,'-',qms_qty,' PCS<br/>')) as existing_location from bai_qms_db where $addfilter location_id<>'INTDESTROY' and location_id<>'PAST_DATA' and qms_tran_type in (13) GROUP BY qms_tid order by qms_schedule,qms_color,qms_size
";
//echo $sql;
$sql_result=mysql_query($sql,$link) or exit("Sql Error2".mysql_error());
while($sql_row=mysql_fetch_array($sql_result))
{
	if($sql_row['qms_qty']>0)
	{
		$table="<tr class=\"foo\" id=\"rowchk$x\">";
		$table.="<td>".($x+1)."</td>";
		$table.="<td>".$sql_row['qms_style']."</td>";
		$table.="<td>".$sql_row['qms_schedule']."<input type=\"hidden\" name=\"sch_list[$x]\" value=\"".$sql_row['qms_schedule']."\"></td>";
		$table.="<td>".$sql_row['qms_color']."</td>";
		$table.="<td>".$sql_row['qms_size']."</td>";
		
		$table.="<td>".$sql_row['qms_qty']."</td>";
		
		
		$table.="<td>".$sql_row['existing_location']."</td>";
		
		
		$table.="</tr>";
		
		echo $table;
		
			
		$x++;
	}
	
}
echo '<tr><td colspan=5>Total Quantity:</td><td id="table1Tot1" style="background-color:#FFFFCC; color:red;"></td></tr>';
$table='</tbody></table>';
echo $table;

echo '</form>';
}
else
{
		echo "Please enter correct details";
}
}
?>


<script language="javascript" type="text/javascript">
//<![CDATA[
	var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: { 
						id: ["table1Tot1"],
						 col: [5],  
						operation: ["sum"],
						 decimal_precision: [1],
						write_method: ["innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table1'),"tr").length]
							
	
		
	};
	
	 setFilterGrid("table1",fnsFilters);
	//]]>
</script>




</body>

</html>