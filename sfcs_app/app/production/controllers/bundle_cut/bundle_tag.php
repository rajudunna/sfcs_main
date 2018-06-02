<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',4,'R')?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',4,'R')?>"></script>
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/style.css',4,'R')?>">
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/table.css',4,'R')?>">
<!---<style type="text/css">
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
</style>--->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R')?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R')?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/filtergrid.css',4,'R')?>"></script>



<script language="javascript" type="text/javascript">
function firstbox()
{
	//alert("report");
	window.location.href ="../mini_order_report/bundle_tag.php?style="+document.mini_order_report.style.value
}

function secondbox()
{
	//alert('test');
	window.location.href ="../mini_order_report/bundle_tag.php?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
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
<div class="panel panel-primary">
<div class="panel-heading">Bundle Split</div>
<div class="panel-body">
<!---<div id="page_heading"><span style="float: left"><h3>Bundle Split</h3></span><span style="float: right"><b></b>&nbsp;</span></div>--->
<?php 
$authorized=array('bhargavg'); 
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
$view_access=user_acl("SFCS_0270",$username,1,$group_id_sfcs);
// include("dbconf.php");
?>

<?php
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


?>

<form name="mini_order_report" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post" onsubmit=" return check_val();">
<br>
<div class='col-md-3 col-sm-3 col-xs-12'>
	Provide the Docket Number:<input type="text" class="form-control" value="<?php if(isset($_POST['show'])>0){echo $_POST['doc_no'];}?>" name="doc_no" id="doc_no">
</div>
<div class='col-md-3 col-sm-3 col-xs-12' style='margin-top: 18px;'>
	<input type="submit" value="Show" class="btn btn-primary" name="show">
</div>
<form>

<?php
if(isset($_POST['show']))
{
	$doc_no=$_POST['doc_no'];
	$status=echo_title("$brandix_bts.tbl_miniorder_data","count(*)","docket_number",$doc_no,$link);
	$print_status=echo_title("$brandix_bts.tbl_miniorder_data","count(*)","mini_order_status='1' and docket_number",$doc_no,$link);
	//$schedule_code=$_POST['schedule'];
	$check_club_c = echo_title("$bai_pro3.plandoc_stat_log","org_doc_no","doc_no",$doc_no,$link);
	$check_club_p = echo_title("$bai_pro3.plandoc_stat_log","count(*)","org_doc_no",$doc_no,$link);
	//$sch_check="J".$schedule;
	//$check_club = echo_title("bai_pro3.bai_orders_db_confirm","count(*)","order_joins",$sch_check,$link);
	if($check_club_c==0 && $check_club_p==0)
	{
		if($status>0 )
		{
			if($print_status == 0)
			{
				$sql="select * from $brandix_bts.bundle_transactions_20_repeat where bundle_id in (select bundle_number from $brandix_bts.tbl_miniorder_data where docket_number='".$doc_no."')";
				$sql_result=mysql_query($sql,$link) or exit("Sql Error--1".mysql_error());
				$rows=mysql_num_rows($sql_result);	
				if($rows>0)
				{
					echo "<script>swal('Already scanning started','You cant split the bundle size','warning');</script>";
				}
				else
				{
					?>
					<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
					<?php
					echo "<table class='table table-bordered'><tr><th> Docket Number </th> <th>Cut Number</th><th>Bundle Quantity</th><th>Split Values</th><th>Shade Values</th><th>Control</th></tr>";
					$sql="select * from $brandix_bts.tbl_cut_master where doc_num='".$doc_no."'";
					$sql_result=mysql_query($sql,$link) or exit("Sql Error--1".mysql_error());
					while($row2=mysql_fetch_array($sql_result))
					{
						echo "<tr><td>".$doc_no."</td><td>".$row2['cut_num']."</td>";
						echo "<td>".$row2['planned_plies']."</td>";
						echo "<td> * Seperate with comma (,) <input type='text' value='' name='split_qty'><input type='hidden' value=\"$doc_no\" name='doc_no'></td>";
						echo "<td> * Seperate with comma (,) <input type='text' value='' name='split_shade'></td>";
						echo "<td>";
						echo "<input type=\"submit\" value=\"Split\" class=\"btn btn-primary\" name=\"split\" id=\"generate\" onclick=\"document.getElementById('generate').style.display='none'; document.getElementById('msg1').style.display='';\"/>";
						echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait..Mini orders Generating.<h5></span></td>";
						
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
				echo "<script>swal('Bundle tickets already printed','','warning'); </script>";
			}
		}
		else
		{
			echo "<script>swal('Mini order not created','','warning'); </script>";
		}
	}
	else
	{
		echo "<script>swal('Clubbed docket not eligible to split','','warning');</script>";
	}
}
if(isset($_POST['split']))
{
	$doc_no=$_POST['doc_no'];
	$split_qty=$_POST['split_qty'];
	$shades = $_POST['split_shade'];
	$pre_rand=echo_title("$brandix_bts.tbl_miniorder_data","group_concat(distinct split_status)","docket_number",$doc_no,$link);
	//echo $pre_rand."<br>.";
	$rand_no=rand(10,100).date('h').date('i').date('s');
	//echo $doc_no."--".$split_qty."<br>";
	$split_val=explode(",",$split_qty);
	$shade_val=explode(",",$shades);
	//echo sizeof($split_val)."<br>";
	$bundle_size=echo_title("$brandix_bts.tbl_cut_master","planned_plies","doc_num",$doc_no,$link);
	//echo array_sum($split_val)."==".$bundle_size."<br>";
	if(array_sum($split_val)==$bundle_size && sizeof($split_val)==sizeof($shade_val))
	{
		
		$insertMiniOrderdataLog="INSERT INTO $brandix_bts.tbl_miniorder_data_qty_split_log(user_name,quantity,docket_number,shade) VALUES ('".$username."','".$split_qty."','".$doc_no."','".$shades."')";
		$result4 = mysql_query($insertMiniOrderdataLog,$link) or ("Sql error".mysql_error());
		
		$cut_num=echo_title("$brandix_bts.tbl_miniorder_data","cut_num","docket_number",$doc_no,$link);
		$mini_order_ref=echo_title("$brandix_bts.tbl_miniorder_data","mini_order_ref","docket_number",$doc_no,$link);
		$min_order_num=echo_title("$brandix_bts.tbl_miniorder_data","mini_order_num","docket_number",$doc_no,$link);
		$parent_id=echo_title("$brandix_bts.tbl_cut_master","id","doc_num",$doc_no,$link);
		$bundle_number=echo_title("$brandix_bts.tbl_miniorder_data","max(bundle_number)+1","1",1,$link);
		if($bundle_number>0)
		{
			$bundle_number=$bundle_number;
		}
		else
		{
			$bundle_number=1;
		}
		
		$date_time=date('Y-m-d h:i:s'); 
		//$date_time=date("Y-m-d h:i:s");
		$sql="select * from $brandix_bts.tbl_cut_size_master where parent_id='".$parent_id."'";
		//secho $sql."<br>";
		$sql_result=mysql_query($sql,$link) or exit("Sql Error--1".mysql_error());
		while($row2=mysql_fetch_array($sql_result))
		{
			//echo $row2['ref_size_name']."--".$row2['quantity']."<br>";
			for($i=0;$i<$row2['quantity'];$i++)
			{
				for($j=0;$j<sizeof($split_val);$j++)
				{	
					//echo $split_val[$j]."<br>";
					if($split_val[$j]>0)
					{
						$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority,split_status,split_shade) VALUES ('".$date_time."','".$mini_order_ref."','".$min_order_num."','".$cut_num."','".$row2['color']."','".$row2['ref_size_name']."','".$bundle_number."','".$split_val[$j]."','".$doc_no."','".$min_order_num."','".$rand_no."','".$shade_val[$j]."')";
						//echo $insertMiniOrderdata."<bR>";
						$result3=mysql_query($insertMiniOrderdata,$link) or ("Sql error".mysql_error());
						$bundle_number++;
					}
				}
			}
		}
		$sql="delete from $brandix_bts_uat.view_set_1_snap where bundle_transactions_20_repeat_bundle_id in (select bundle_number from brandix_bts.tbl_miniorder_data where docket_number='".$doc_no."' and split_status in (".$pre_rand.")))";
		$result3=mysql_query($sql,$link) or ("Sql error".mysql_error());
		//echo $sql."<bR>";
		$sql="delete from $brandix_bts_uat.view_set_snap_1_tbl where tbl_miniorder_data_bundle_number in (select bundle_number from brandix_bts.tbl_miniorder_data where docket_number='".$doc_no."' and split_status in (".$pre_rand."))";
		$result3=mysql_query($sql,$link) or ("Sql error".mysql_error());
		//echo $sql."<bR>";
		$sql="delete from $brandix_bts_uat.view_set_3_snap where tbl_miniorder_data_bundle_number in (select bundle_number from brandix_bts.tbl_miniorder_data where docket_number='".$doc_no."' and split_status in (".$pre_rand."))";
		$result3=mysql_query($sql,$link) or ("Sql error".mysql_error());
		//echo $sql."<bR>";
		$sql="delete from $brandix_bts_uat.bundle_transactions_20_repeat_virtual_snap_ini_bundles where bundle_id in (select bundle_number from brandix_bts.tbl_miniorder_data where docket_number='".$doc_no."' and split_status in (".$pre_rand."))";
		$result3=mysql_query($sql) or ("Sql error".mysql_error());
		//echo $sql."<bR>";
		$sql="delete from $brandix_bts.tbl_miniorder_data where docket_number='".$doc_no."' and split_status in (".$pre_rand.")";
		$sql_result=mysql_query($sql,$link) or exit("Sql Error--1".mysql_error());
		echo "<h2>Bundle Splitting has been completed.</h2>";
		//header("Location:bundle_tag.php");
	}
	else
	{
		echo "<script>swal('Mentioned Split quantity is not equal to the Actual Bundle Quantity','','warning');</script>";
	}	

}
?>	
</div>
</div>
</body>	
<!---<style>

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
</style>--->