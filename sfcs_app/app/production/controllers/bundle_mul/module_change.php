<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="js/style.css">
<link rel="stylesheet" type="text/css" href="table.css">
<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0;
 width:auto;
float:right;
table {
    float:left;
    width:33%;
}
</style>
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px;  padding:5px; background-color:#f4f4f4; solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; solid #ccc; white-space: nowrap;}
td{ padding:2px; white-space: nowrap;}
</style>
<script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script>



<script language="javascript" type="text/javascript">
function firstbox()
{
	var url1 = '<?= getFullUrl($_GET['r'],'module_change.php','N'); ?>';
	window.location.href =url1+ "&module_id="+document.module_change.module_id.value
}

function secondbox()
{
	//swal('test');
	//window.location.href ="../mini-orders/excel-export?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
}



function check_val_2()
{
	//swal('dfsds');
	
	var count=document.barcode_mapping_2.count_qty.value;
	//swal(count);
	//swal('qty');
	var check_exist=0;
	for(i=0;i<5;i++)
	{
		var qty=document.getElementById("qty["+i+"]").value;
		if(qty!=0)
	    {
			var check_exist=1;
		}
	}
	if(check_exist==0)
	{
		swal('Please fill the values');
		return false;
	}
	//return false;	
}

</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="panel panel-primary">
	<div class="panel-heading">Module Change</div>
	<div class="panel-body">
<?php 
$global_path = getFullURLLevel($_GET['r'],'',4,'R');

include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/user_acl_v1.php");
$view_access=user_acl("SFCS_0274",$username,1,$group_id_sfcs);
?>

<?php
//ALTER TABLE `brandix_bts`.`bundle_transactions` ADD COLUMN `man_update` VARCHAR(455) NULL AFTER `module_id`;

error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$modules=array();
//$mins=array("00","05","10","15","20","25","30","35","40","45","50","55");
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);
$sql="select distinct id as module_id from brandix_bts.tbl_module_ref";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$modules[]=$sql_row['module_id'];
}

//$module=$_GET['module_id'];

$static=array(1,2,3,4,5,6,7);
$dynamic=array(8,9,10,11,12,13,14,15,16,17,18,19,20);
if(isset($_POST['module_id']))
{
    $module=$_POST['module_id'];
  //  $shift=$_POST['shift'];
    //$shift='1';
	//$mini_order_num=$_POST['mini_order_num']; 
	//$color=$_POST['color'];
}
else
{
	$module=$_GET['module_id'];
	//$shift='1';
	//$mini_order_num=$_GET['mini_order_num'];
	//$color=$_GET['color']; 
}

//echo $style.$schedule.$color;
?>

<form name="module_change" action="?r=<?php echo $_GET['r']; ?>" method="post" onsubmit=" return check_val();">
	<div class='form-group col-lg-3'>
	<label>Select Module:</label>
		<?php
		echo '
				
					<select title= "click to select module" id="module_id" name="module_id" onchange="firstbox(this.value);" class="form-control">';
					//echo "<option value=\"NIL\" selected>NIL</option>";
					for($i=0;$i<sizeof($modules);$i++)
					{
						if($modules[$i]==$module)
						{
							echo "<option value=\"".$modules[$i]."\" selected>".$modules[$i]."</option>";
						}
						else
						{
							echo "<option value=\"".$modules[$i]."\">".$modules[$i]."</option>";	
						}					
					}				
					echo '</select> &nbsp;';

		?>	
	</div>
	<div class='form-group col-lg-3'>
	<label>Employee id:</label>
		<?php
			echo "<input type=\"textbox\" class='form-control' value=\"\" name=\"emp_id\" id=\"mp_id\">";

		?>
	</div>
<div class='form-group col-lg-3'>
 	<?php
		echo "<input type=\"submit\" class='btn btn-primary' style='margin-top: 20px' value=\"submit\" name=\"submit\">";	
	?>
</div>


</form>

<?php
if(isset($_POST['submit'])) 
{
	$module=$_POST['module_id'];
	$emp_id=$_POST['emp_id'];
	//$shift=$_POST['shift'];
	//$date_time=$date.$time.":00";
	//$sql="insert into bundle_transactions(employee_id,shift,trans_status,module_id) values('".$username."','".$shift."','Yes',$module)";
	$sql="insert into bundle_transactions(employee_id,trans_status,module_id) values('".$emp_id."','Yes',\"$module\")";
	$result2=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	//echo $sql."<br>";
	$id = ((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
	//echo $id."<br>";
	
	//$bintrack=$_POST['bintrack'];
	//echo "bintrack=".$bintrack;
	//echo $date."--".$time."--".$module."--".$shift."<br>";
	?>
	
	<form name="module_change" action="<?php echo $_GET['r']; ?>" method="post">
	<?php
	echo "<input type=\"hidden\" name=\"pid\" value=\"$id\">";
	//echo "<input type=\"hidden\" name=\"shift\" value=\"$shift\">";
	//echo "<input type=\"hidden\" name=\"stime\" value=\"$time\">";
	//echo "<input type=\"hidden\" name=\"sdate\" value=\"$date\">";
	echo "<input type=\"hidden\" name=\"module_id\" value=\"$module\">";
	?>
	<div class='form-group col-lg-3'>
	<label>Enter Bundle-ID</label>
	<?php
		echo "<textarea id=\"bundle_id\" rows=\"1\" cols=\"50\" name=\"bundle_id\" placeholder=\"Please fill the bundle_id's\"></textarea>";
	?>
	</div>
	<div class='form-group col-lg-3'>
	<label>Operation: </label>
		<select name='operation' id='operation' class='form-control'>
			<option value="1" >Operation-1</option>	
			<option value="2" >Operation-2</option>	
			<option value="3" >Operation-3</option>
		</select>";
	</div>
	<?php
	//echo "<textarea name=\"remark\" id=\"remark\" ></textarea>";	
	echo "<input type=\"submit\" class='btn btn-primary' style='margin-top:20px' value=\"Change\" name=\"show\">";
	?>
	</form>
	<?php
}
if(isset($_POST['show'])) 
{
	$p_id=$_POST['pid'];
	$module=$_POST['module_id'];
	$bundle_ids=$_POST['bundle_id'];
	//$remark=$_POST['remark'];
	$operation_id=$_POST['operation'];
	$ops_pending=array();
	//echo $bundle_ids."<br>";
	$bundle_id=explode(",",$bundle_ids);
	//echo sizeof($bundle_id);
	$next_ops=$operation_id+1;
	for($i=0;$i<sizeof($bundle_id);$i++)
	{
		//echo $bundle_id[$i]."<br>";
		$sql1="select * from bundle_transactions_20_repeat where bundle_id='".$bundle_id[$i]."' and operation_id in ($operation_id) order by bundle_id,operation_id*1";
		//echo $sql1."<br>";
		$result1=mysqli_query($link, $sql1) or die("Error =1 ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num_rows=mysqli_num_rows($result44);
		if($num_rows>0)
		{
			while($row1=mysqli_fetch_array($result1))
			{
				$sql2="select * from bundle_transactions where id='".$row1['parent_id']."'";
				//echo $sql2."<br>";
				$result2=mysqli_query($link, $sql2) or die("Error =2 ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row2=mysqli_fetch_array($result2))
				{
					$sql33="update $brandix_bts.bundle_transactions set date_time='".$row2['date_time']."',operation_time='".$row2['operation_time']."',shift='".$row2['shift']."' where id='".$p_id."'";
					//echo $sql33."<br>";
					$result33=mysqli_query($link, $sql33) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$sql4="update bundle_transactions_20_repeat set parent_id='".$p_id."' where operation_id='".$operation_id."' and bundle_id='".$bundle_id[$i]."'";
					//echo $sql4."<br>";
					$result4=mysqli_query($link, $sql4) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql34="insert into $brandix_bts.bundle_transactions_20_repeat_change select * from bundle_transactions_20_repeat operation_id='".$operation_id."' and bundle_id='".$bundle_id[$i]."'";
					//echo $sql34."<br>";
					$result34=mysqli_query($link, $sql34) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				
					if($operation_id==3)
					{
						$id_ims_3=echo_title("$brandix_bts.bts_to_sfcs_sync","max(sync_rep_id)","operation_id=3 and sync_bundle_id",$bundle_id[$i],$link);
						if($id_ims_3>0)
						{
							$sql33="update $bai_pro3.ims_log set ims_mod_no='".$module."' where id='".$id_ims_3."'";
							//echo $sql33."<br>";
							$result33=mysqli_query($link, $sql33) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));	
							$id_ims_4=echo_title("brnaidx_bts.bts_to_sfcs_sync","max(sync_rep_id)","operation_id=4 and sync_bundle_id",$bundle_id[$i],$link);
							if($id_ims_4>0)
							{
								$sql34="update $bai_pro3.ims_log set ims_mod_no='".$module."' where id='".$id_ims_4."'";
								//echo $sql34."<br>";
								$result34=mysqli_query($link, $sql34) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));	
							}
						}
						
						$sql44="select * from $brandix_bts.bundle_transactions_20_repeat where operation_id=4 and bundle_id='".$bundle_id[$i]."'";
						$result44=mysqli_query($link, $sql44) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
						$row=mysqli_num_rows($result44);
						if($row > 0)
						{
							while($row44=mysqli_fetch_array($result44))
							{
								//$man_stat=$row44['parent_id']."$".$row44['act_nodule']."$".$remark."$".$username;
								$sql5="update $brandix_bts.bundle_transactions_20_repeat set act_module='".$module."',man_status='".$man_stat."' where operation_id=4 and bundle_id='".$bundle_id[$i]."'";
								$result5=mysqli_query($link, $sql5) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
								//echo $sql5."<br>";
							}	
						}
					}			
				}
				
			}
		}
		else
		{
			$ops_pending[]=$bundle_id[$i];	
		}
	}
	$check_status=sizeof($ops_pending);
	if($check_status>0)
	{
		echo "<h2>Scanning Not yet started for these bundle-(".implode(",",$ops_pending).")</h2>";
	}
	
	//echo "<table><tr><th></th><th></th><th></th></tr>";
}	
?>	
</div>
</div>
