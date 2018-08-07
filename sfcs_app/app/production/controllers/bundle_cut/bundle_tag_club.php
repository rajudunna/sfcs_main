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
	//alert("report");
	var ajax_url="../mini_order_report/bundle_tag.php?style="+document.mini_order_report.style.value;Ajaxify(ajax_url);

}

function secondbox()
{
	//alert('test');
	var ajax_url ="../mini_order_report/bundle_tag.php?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value;
	Ajaxify(ajax_url);

}

function tot_sum()
{
	//alert('Test');
	
	
	
	//return false;
}
function check_val()
{
	//alert('dfsds');
	var doc_no=document.getElementById("doc_no").value;
	
	
	if(doc_no == '')
	{
		alert('Please Fill the values');
		//document.getElementById('msg').style.display='';
		//document.getElementById('submit').style.display=''
		//document.getElementById('msg').style.display='none';
		return false;
	}
	//return false;	
}

function openWin() {
    //window.open("http://baidevsrv1:8080/projects/beta/bundle_tracking_system/brandix_bts/mini_order_report/bundle_alloc_save.php");
}
function validate(id,key)
{
//getting key code of pressed key
//alert('okaeyup');
var keycode = (key.which) ? key.which : key.keyCode;
//alert(id);
//alert(keycode);
//comparing pressed keycodes
if (keycode < '48' || keycode > '57')
{
	if(keycode==8 || keycode==46 || keycode==9 || keycode==16)
	{
		
	}
	else
	{
		document.getElementById(id).value=1;
	}
}

}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="page_heading"><span style="float: left"><h3>Bundle Split</h3></span><span style="float: right"><b></b>&nbsp;</span></div>
<?php 
$authorized=array('bhargavg'); 
include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
$view_access=user_acl("SFCS_0246",$username,1,$group_id_sfcs);
include("dbconf.php");
?>

<?php
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


?>

<form name="mini_order_report" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit=" return check_val();">
<br>
<table><tr>
			<th>Provide the Docket Number:</th><th><input type="text" value="<?php if(isset($_POST['show'])>0){echo $_POST['doc_no'];}?>" name="doc_no" id="doc_no"></th>
			<th><input type="submit" value="Show" name="show"></th>
		</tr></table> 
<form>

<?php
if(isset($_POST['show']))
{
	$doc_no=$_POST['doc_no'];
	$status=echo_title("brandix_bts.tbl_miniorder_data","count(*)","docket_number",$doc_no,$link);
	$print_status=echo_title("brandix_bts.tbl_miniorder_data","mini_order_status","docket_number",$doc_no,$link);
	
	if($status>0 )
	{
		if($print_status=='')
		{
			$sql="select * from brandix_bts.bundle_transactions_20_repeat where bundle_id in (select bundle_number from brandix_bts.tbl_miniorder_data where docket_number='".$doc_no."')";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows=mysqli_num_rows($sql_result);	
			if($rows>0)
			{
				echo "<h2>Already scanning started.. You can't split the bundle size...!</h2>";
			}
			else
			{
				?>
				<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
				<?php
				echo "<table border=1px><tr><th> Docket Number </th> <th>Cut Number</th><th>Bundle Quantity</th><th>Split Values</th><th>Control</th></tr>";
				$sql="select * from brandix_bts.tbl_cut_master where doc_num='".$doc_no."'";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row2=mysqli_fetch_array($sql_result))
				{
					echo "<tr><td>".$doc_no."</td><td>".$row2['cut_num']."</td>";
					echo "<td>".$row2['planned_plies']."</td>";
					echo "<td> * Seperate with comma (,) <input type='text' value='' name='split_qty'><input type='hidden' value=\"$doc_no\" name='doc_no'></td>";
					echo "<td> <input type='submit' value='Split' name='split'></td>";
					echo "</tr>";
				}
				echo "</table>";
				?>
				</form>
				<?php
				
			}
		}
		else
		{
			echo "<h2>Bundle tickets already printed ...!</h2>";
		}
	}
	else
	{
		echo "<h2>Mini order not created...!</h2>";
	}
}
if(isset($_POST['split']))
{
	$doc_no=$_POST['doc_no'];
	$split_qty=$_POST['split_qty'];
	$pre_rand=echo_title("brandix_bts.tbl_miniorder_data","split_status","docket_number",$doc_no,$link);
	$rand_no=rand(10,100).date('h').date('i').date('s');
	//echo $doc_no."--".$split_qty."<br>";
	$split_val=explode(",",$split_qty);
	//echo sizeof($split_val)."<br>";
	$bundle_size=echo_title("brandix_bts.tbl_cut_master","planned_plies","doc_num",$doc_no,$link);
	//echo array_sum($split_val)."==".$bundle_size."<br>";
	if(array_sum($split_val)==$bundle_size)
	{
		$cut_num=echo_title("brandix_bts.tbl_miniorder_data","cut_num","docket_number",$doc_no,$link);
		$mini_order_ref=echo_title("brandix_bts.tbl_miniorder_data","mini_order_ref","docket_number",$doc_no,$link);
		$min_order_num=echo_title("brandix_bts.tbl_miniorder_data","mini_order_num","docket_number",$doc_no,$link);
		$parent_id=echo_title("brandix_bts.tbl_cut_master","id","doc_num",$doc_no,$link);
		$bundle_number=echo_title("brandix_bts.tbl_miniorder_data","max(bundle_number)+1","1",1,$link);
		if($bundle_number>0)
		{
			$bundle_number=$bundle_number;
		}
		else
		{
			$bundle_number=1;
		}
		$date_time=date("Y-m-d h:i:s");
		$sql="select * from brandix_bts.tbl_cut_size_master where parent_id='".$parent_id."'";
		//secho $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row2=mysqli_fetch_array($sql_result))
		{
			//echo $row2['ref_size_name']."--".$row2['quantity']."<br>";
			for($i=0;$i<$row2['quantity'];$i++)
			{
				for($j=0;$j<sizeof($split_val);$j++)
				{	
					//echo $split_val[$j]."<br>";
					if($split_val[$j]>0)
					{
						$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority,split_status) VALUES ('".$date_time."','".$mini_order_ref."','".$min_order_num."','".$cut_num."','".$row2['color']."','".$row2['ref_size_name']."','".$bundle_number."','".$split_val[$j]."','".$doc_no."','".$min_order_num."','".$rand_no."')";
						//echo $insertMiniOrderdata."<bR>";
						$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$bundle_number++;
					}
				}
			}
		}
		$sql="delete from brandix_bts_uat.view_set_1_snap where bundle_transactions_20_repeat_bundle_id in (select bundle_number from brandix_bts.tbl_miniorder_data where docket_number='".$doc_no."')";
		$result3=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql."<bR>";
		$sql="delete from brandix_bts_uat.view_set_snap_1_tbl where tbl_miniorder_data_docket_number='".$doc_no."'";
		$result3=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql."<bR>";
		$sql="delete from brandix_bts_uat.view_set_3_snap where tbl_miniorder_data_docket_number='".$doc_no."'";
		$result3=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql."<bR>";
		$sql="delete from brandix_bts_uat.bundle_transactions_20_repeat_virtual_snap_ini_bundles where bundle_id in (select bundle_number from brandix_bts.tbl_miniorder_data where docket_number='".$doc_no."')";
		$result3=mysqli_query($GLOBALS["___mysqli_ston"], $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql."<bR>";
		$sql="delete from brandix_bts.tbl_miniorder_data where docket_number='".$doc_no."' and split_status='".$pre_rand."'";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
		echo "<h2>Splitting Bundle has been completed.</h2>";
	}
	else
	{
		echo "<h2>Mentioned Split quantity is not equal to the Actual Bundle Quantity..!</h2>";
	}	
}
?>		
<style>

#table1 {
  display: inline-table;
  width: 100%;
}


div#table_div {
    width: 30%;
}
#test{
margin-left:8%;
margin-bottom:2%;
}
</style>