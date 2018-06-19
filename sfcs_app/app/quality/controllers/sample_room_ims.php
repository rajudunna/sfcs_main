<!--

Ticket #356420/Kiran - 20140219
Created this interface to confirm sample received qtys.

kirang / 2014-07-02 / service request #411408:
user names taken from the database level
-->
<?php
//$author_id_db=array("kirang","manojm","sridevik","kirang","kirang","thilinapa","kirang","kirang");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
//include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
 
 //$has_perm=haspermission($_GET['r']);
// $view_access=user_acl("SFCS_0146",$username,1,$group_id_sfcs); 

// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
// $username=strtolower($username_list[1]);
/*
$sql="select * from menu_index where list_id=268";
$result=mysql_query($sql,$link) or mysql_error("Error=".mysql_error());
while($row=mysql_fetch_array($result))
{
	$users=$row["auth_members"];
}

$auth_users=explode(",",$users);
if(in_array($authorized,$has_perm))
{
	
}
else
{
	$url = getFullURL($_GET['r'],'restricted.php','N');
	header("Location:$url");
}
*/
function dateDiffsql($link,$start,$end)
{
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	$sql="select distinct bac_date from $bai_pro.bai_log_buf where bac_date<='$start' and bac_date>='$end'";

	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
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
var url = "<?= getFullURL($_GET['r'],'sample_room.php','N');?>";
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

<style>
/* body
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
	
} */
</style>


<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "../../../common/js/TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
/* body{ 
	margin:15px; padding:15px; border:1px solid #666; 
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
} */
/* h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  } */
/* .mytable{
	font-size:12px;
	border:1px solid #ccc;
} */
/* div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; white-space: nowrap;}
.mytable td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space: nowrap;} */

</style>

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>

<script>


function show(){
	var items=document.getElementsByName('check[]');
	var selectedItems="";
	var count = 0;
	for(var i=0; i<items.length; i++){
		if(items[i].checked == true){
			count++;
		}
	}
	if(count > 0)
		return true;
	else{
		sweetAlert('Please Select Atleast One Garment','','warning');
		return false;
	}
}


</script>

<body onload="dodisable()">

<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/m3_bulk_or_proc.php',3,'R'));
 
?>


<div class='panel panel-primary'>
<div class='panel-heading'>Samples Update(IMS)</div>
<div class='panel-body'>

<form name="test" action="<?php echo '?r='.$_GET['r']; ?>" method="post">
<?php


$mod_ref=array();
$sec_ref=array();
$sql="select * from $bai_pro3.sections_db where sec_id>0";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$temp=explode(",",$sql_row['sec_mods']);
	for($i=0;$i<sizeof($temp);$i++)
	{
		$mod_ref[]=$temp[$i];
		$sec_ref[]=$sql_row['sec_id'];	
	}	
	unset($temp);
}

$i=0;
$sql="select * from $bai_pro3.ims_log where ims_remarks in ('SAMPLE') order by ims_mod_no,ims_schedule,ims_size";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)>0){
	echo "<div class='table-responsive'><table class='table table-bordered' id=\"table1\" >";
	echo "<tr class='danger'>
		<th >Style</th>
		<th>Schedule</th>
		<th>Color</th>
		<th>Size</th>
		<th>Quantity</th>
		<th>Section</th>
		<th>Module</th>
		<th>Team</th>
		<th>Age</th>
		<th>Control</th>
		<th>Input Date</th>
		<th>Ex-factory Date</th>
	</tr>";
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$ex_factory="";
		$sql1="select order_date from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$sql_row['ims_schedule']."\"";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2 =".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			//If Ex-Factory is missing then consider the order date as exfactory
			$ex_factory=$sql_row1['order_date'];
			
		}
		
		//Ex-Factory
		$sql1="select ex_factory_date_new as ex_factory from $bai_pro4.week_delivery_plan_ref where schedule_no=\"".$sql_row['ims_schedule']."\"";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2 =$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$ex_factory=$sql_row1['ex_factory'];
		}
		$title_size = "title_size_".str_replace("a_","",$sql_row['ims_size']);
		$get_actual_size_query = "select $title_size as title_size from $bai_pro3.bai_orders_db_confirm WHERE order_del_no = '".$sql_row['ims_schedule']."' AND order_col_des  = '".$sql_row['ims_color']."'";
		$get_actual_size_query_exec=mysqli_query($link, $get_actual_size_query) or exit("Sql Error2 =$get_actual_size_query".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($get_actual_size_query_exec) > 0){
			while($get_act_size = mysqli_fetch_array($get_actual_size_query_exec)){
				$act_size = $get_act_size['title_size'];
			}
		} else {
			$act_size = str_replace("a_","",$sql_row['ims_size']);
		}
		echo "<tr>";
			echo "<td>".$sql_row['ims_style']."</td>";
			echo "<td>".$sql_row['ims_schedule']."</td>";
			echo "<td>".$sql_row['ims_color']."</td>";
			echo "<td>".$act_size."</td>";
			echo "<td>".$sql_row['ims_qty']."</td>";
			echo "<td>".$sec_ref[array_search($sql_row['ims_mod_no'],$mod_ref)]."</td>";
			echo "<td>".$sql_row['ims_mod_no']."</td>";
			echo "<td>".$sql_row['ims_shift']."</td>";
			echo "<td>".abs(dateDiffsql($link,date("Y-m-d"),$sql_row['ims_date']))."</td>";
			echo "<td><input type=\"checkbox\" value=\"$i\" name=\"check[]\" id=\"check[]\">
				<input type=\"hidden\" value=\"".$sec_ref[array_search($sql_row['ims_mod_no'],$mod_ref)]."\" name=\"section[]\">
				<input type=\"hidden\" value=\"".$sql_row['tid']."\" name=\"tid[]\">			
			</td>";
			echo "<td>".$sql_row['ims_date']."</td>";
			echo "<td>".$ex_factory."</td>";
		echo "</tr>";
		$i++;
	
	}
	echo "</table></div><br/>";
	echo '<span id="msg" style="display:none;">Please Wait...</span>';
	echo "<div class='form-group'><button  class='btn btn-success btn-md' type='submit' name='update'  id='update' onclick='return show()' document.getElementById('msg').style.display='';\">Update</button></div></form>";
}else{
	echo "<script>sweetAlert('There is no input!','','warning')</script>";
}
?>

<script language="javascript" type="text/javascript">
//<![CDATA[
	var table6_Props = 	{
							rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ ALL ] ",
		loader_text: "Filtering data...",  
	loader: true,
	col_0: "select", 
	col_1: "select", 
	col_2: "select",
	col_3: "select", 
	col_4: "select", 
	col_5: "select",
	col_6: "select", 
	col_7: "select", 
	col_8: "select",
	col_9: false,

	col_10: "select",
	col_11: "select",
	loader_text: "Filtering data...",
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear"
						};
	setFilterGrid( "table1",table6_Props );
//]]>
</script>
<?php
if(isset($_POST['update']))
{
	echo "<br/>";
	$check=$_POST['check'];
	$section=$_POST['section'];
	$tid=$_POST['tid'];

	if(sizeof($check) > 0) {
		
		
		for($i=0;$i<sizeof($check);$i++)
		{
			$key=$check[$i];
			
			$sql1="select ims_mod_no,ims_style,ims_schedule,ims_color,REPLACE(ims_size,'a_','') as ims_size,ims_qty from $bai_pro3.ims_log where tid=".$tid[$key];	
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$style=$sql_row1['ims_style'];
				$schedule=$sql_row1['ims_schedule'];
				$color=$sql_row1['ims_color'];
				$size=$sql_row1['ims_size'];
				$qty=$sql_row1['ims_qty'];
				$module=$sql_row1['ims_mod_no'];
			}
			
			$usr_msg="<div class='alert alert-info'>The following entries are failed to update due to M3 system validations:</div><br/><table class='table table-bordered'><tr><th>Module</th><th>Schedule</th><th>Color</th><th>Size</th><th>Quantity</th></tr>";
			if(rejection_validation_m3('SAMPLE',$schedule,$color,$size,$qty,$tid[$key],$username)=='TRUE')
			{
				
				$sql="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,qms_size,qms_qty,qms_tran_type,remarks,log_date) 
				select ims_style,ims_schedule,ims_color,REPLACE(ims_size,'a_',''),ims_qty,4,concat('".$section[$key]."','-',ims_mod_no,'-',ims_shift),'".date("Y-m-d")."' from $bai_pro3.ims_log where tid=".$tid[$key];
				mysqli_query($link, $sql) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));	
				
				if(mysqli_affected_rows($link)>0)
				{
					$sql="insert ignore into $bai_pro3.ims_log_backup select * from ims_log where tid=".$tid[$key];
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					if(mysqli_affected_rows($link)>0)
					{
						$sql="delete from $bai_pro3.ims_log where tid=".$tid[$key];
						mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					// $usr_msg = "Updated Data Successfully...";
					$usr_msg = "<script>sweetAlert('Updated Data Successfully...','','success')</script>";

				}
			}
			else
			{
				$usr_msg.="<tr><td>".$module."</td><td>".$schedule."</td><td>".$color."</td><td>".$size."</td><td>".$qty."</td></tr>";
			}
		}
		
		$usr_msg.="</table>";
		
		
		//Validations
		echo $usr_msg;
	} else {
		echo "<script>sweetAlert('Please select atleast one garment','','info')</script>";
	}
}

?>
</div>
</div>


