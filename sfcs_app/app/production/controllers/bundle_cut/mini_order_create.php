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
	window.location.href ="index.php?r=<?= $_GET['r'] ?>&style="+document.mini_order_report.style.value
}

function secondbox()
{
	//alert('test');
	window.location.href ="index.php?r=<?= $_GET['r'] ?>&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
}

function tot_sum()
{
	//alert('Test');
	
	
	
	//return false;
}
function check_val()
{
	//alert('dfsds');
	var style=document.getElementById("style").value;
	var schedule=document.getElementById("schedule").value;
	
	if(style == 'NIL' || schedule == 'NIL' || mini_order == 'NIL')
	{
		alert('Please select the values');
		//document.getElementById('msg').style.display='';
		document.getElementById('submit').style.display=''
		document.getElementById('msg').style.display='none';
		return false;
	}
	//return false;	
}
function check_val1()
{
	/*//alert('Test');
	var bundle_size=document.getElementById("bundle_plies").value;
	var bundle_per_size=document.getElementById("bundle_per_size").value;
	var mini_order_qty=document.getElementById("mini_order_qty").value;
	
	if(bundle_size>=1 && mini_order_qty>1)
	{
		//alert('Ok');
	}
	else
	{
		alert('Please Check the values.');
		document.getElementById('generate').style.display='';
		document.getElementById('msg1').style.display='none';
		return false;
	}
	if(confirm("Mini Order Quantity :"+mini_order_qty) == true )
	{
		//alert("ok");
		//return false;	
		
	}
	else
	{
		//alert("No");
		document.getElementById('msg1').style.display='none';
		document.getElementById('generate').style.display='';
		return false;
	}
	*/
	//return false;
}

function openWin() {
    //window.open("http://baidevsrv1:8080/projects/beta/bundle_tracking_system/brandix_bts/mini_order_report/bundle_alloc_save.php");
}
function validate()
{
	//alert("test");
	//var bundle_plies=document.getElementById("bundle_plies").value;
	//var bundle_per_size=document.getElementById("bundle_per_size").value;
	//var carton_qty=document.getElementById("carton_qty").value;
	//mini_order_qty=document.getElementById("mini_order_qty").value=bundle_plies*bundle_per_size*carton_qty;
}
function validateQty(event) {
    //alert("Test2");
	var key = window.event ? event.keyCode : event.which;
if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39) {
    return true;
}
else if ( key < 48 || key > 57 ) {
    return false;
}
else 
{
return true;

}
};
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<!---<div id="page_heading"><span style="float: left"><h3>Mini Order Creation</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>--->
<?php 
// $authorized=array('kirang');
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));

// $view_access=user_acl("SFCS_0271",$username,1,$group_id_sfcs);
?>

<?php
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


if(isset($_POST['style']))
{
    $style=$_POST['style'];
    $schedule=$_POST['schedule'];
}
else
{
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
}
//echo $_GET['ops']."<br>";
//echo $style.$schedule.$color;
?>

<form name="mini_order_report" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post" onsubmit=" return check_val();">
<br>
<?php
echo "<div class='panel panel-primary'>";
echo "<div class='panel-heading'>";echo"Mini Order Creation";echo "</div>";
echo "<div class='panel-body'>";
echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
echo "Select Style: <select id=\"style\" name=\"style\" onchange=\"firstbox();\" class=\"select2_single form-control\">";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select * from $brandix_bts.tbl_orders_style_ref order by product_style";	
//}
//mysql_query($sql,$link) or exit("Sql Error1".mysql_error());
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])."-".mysqli_errno($link));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

	if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$style))
	{
		echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_style']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_style']."</option>";
	}

}

echo "</select>";
echo "</div>";
?>

<?php
echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
echo "Select Schedule: <select id=\"schedule\" name=\"schedule\" class=\"select2_single form-control\">";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select * from $brandix_bts.tbl_orders_master where ref_product_style='".$style."' order by product_Schedule*1";	
//}
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

	if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
	{
		echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_schedule']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_schedule']."</option>";
	}

}

echo "</select>";
echo "</div>";
?>

 <?php
	//echo "<input type=\"hidden\" value=\"$mini_order_ref\" name=\"mini_order_ref\">";	
		echo "<div class='col-md-3 col-sm-3 col-xs-12' style='margin-top: 19px;'>";
		echo "<input type=\"submit\" value=\"submit\" class=\"btn btn-primary\" name=\"submit\" onclick=\"document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';\"/>";
		echo "</div>";
		// echo "<span id=\"msg\" style=\"display:none;\"><h5>Please Wait...<h5></span>";

?>


</form>


<?php
if(isset($_POST['submit']))
{
	$style_id=$_POST['style'];
	$sch_id=$_POST['schedule'];
	//echo $style."<bR>";
	$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
	$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$sch_id,$link);
	$cols=array();
	$mini_order_ref = echo_title("$brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$sch_id,$link);
	//$bundles = echo_title("brandix_bts.tbl_miniorder_data","group_concat(distinct order_col_des order by order_col_des)","mini_order_ref",$mini_order_ref,$link);
	$sql="select color from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."' group by color";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result)>0)
	{
		while($row=mysqli_fetch_array($sql_result))
		{
			$cols[]=$row['color'];
		}
		$bundles=sizeof($cols);
	}
	else
	{
		$bundles=0;	
	}
	$c_ref = echo_title("$brandix_bts.tbl_carton_ref","id","ref_order_num",$sch_id,$link);
	$carton_qty = echo_title("$brandix_bts.tbl_carton_size_ref","sum(quantity)","parent_id",$c_ref,$link);
	//if($carton_qty>0)
	//{
		$sql="select * from $brandix_bts.tbl_min_ord_ref where ref_crt_schedule='".$sch_id."' and ref_product_style='".$style_id."'";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result)>0)
		{
			while($row=mysqli_fetch_array($sql_result))
			{
				$bundle_size=$row['miximum_bundles_per_size'];
				$bundle_plie=$row['max_bundle_qnty'];
				$mini_qty=$row['mini_order_qnty'];
			}
		}
		else
		{
			$bundle_size=1;
			$bundle_plie=1;
			$mini_qty=$bundle_size*$bundle_plie*$carton_qty;
		}
		$o_colors = echo_title("$bai_pro3.bai_orders_db","group_concat(distinct order_col_des order by order_col_des)","order_del_no",$schedule,$link);	
		if($mini_order_ref>0)
		{
			$p_colors = echo_title("$brandix_bts.tbl_miniorder_data","group_concat(distinct color order by color)","mini_order_ref",$mini_order_ref,$link);
			if($p_colors=='')
			{
				$p_colors='';
				$val1=0;
			}
			else
			{
				$planned_colors=explode(",",$p_colors);
				$val1=sizeof($planned_colors);
			}
		}
		else
		{
			$p_colors='';
			$val1=0;
		}
		$order_colors=explode(",",$o_colors);	
		
		$val=sizeof($order_colors);
		
		//echo $val."--".$val1."<br>";
		$ii=0;
		if($val==$val1 )
		{
			$ii=1;
		}
		echo "<form name=\"input\" method=\"post\" action=\"".getURL(getBASE($_GET['r'])['path'])['url']."\" onsubmit=\" return check_val1();\">";
		echo  "<input type=\"hidden\" value=\"$style_id\" id=\"style_id\" name=\"style_id\">";
		echo  "<input type=\"hidden\" value=\"$sch_id\" id=\"sch_id\" name=\"sch_id\">";
		echo "</br></br></br>";
		echo "<h2>Style :<b>$style</b></h2>";
		echo "<div class=\"table-responsive\">";
		echo "<table class=\"table table-bordered\"><tr><th >Schedule</th><th>Total Order Colors</th><th>Miniorder Creation Colors</th><th>Input Method</th>";
		echo "<th>Control</th></tr>";
		//echo $val."--".$val1."---".$status."<br>";
		echo "<tr><td rowspan=$val>$schedule</td>";
		for($i=0;$i<sizeof($order_colors);$i++)
		{
			if($i!=0)
			{
				echo "<tr>";
			}
			echo "<td>".$order_colors[$i]."</td>";
			echo "<td>".$order_colors[$i]."</td>";
			if($i==0)
			{
				echo "<td rowspan=$val>";
				//Carton Method: <select id=\"cart_method\" name=\"cart_method\">";
				//for($j=0;$j<sizeof($operation);$j++)
				//{
				//	echo "<option value=\"".$j."\" >".$operation[$j]."</option>";
				//}
				//echo "</select></td>";
				echo "<input type='hidden' value='1' name='cart_method'>";
				echo "Single Cut As Input</td>";
				//echo "<td rowspan=$val>".$carton_qty."<input type=\"hidden\" value=\"$carton_qty\" id=\"carton_qty\" name=\"carton_qty\" ></td>";
				if($val==$val1)
				{
					echo "<td rowspan=$val>MiniOrder generation Completed.</td>";
				}
				else
				{
					echo "<td rowspan=$val>";
					$sch_check="J".$schedule;
					
					$check_club = echo_title("$bai_pro3.bai_orders_db_confirm","count(*)","order_joins",$sch_check,$link);
					if($check_club>0)
					{
						$doc_no=array();
						$sql9="select * from $bai_pro3.plandoc_stat_log where org_doc_no in (select doc_num from $brandix_bts.tbl_cut_master where product_schedule='".$schedule."')";
						//echo $sql9."<br>";
						$result19=mysqli_query($link, $sql9) or ("Sql error9".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rows9=mysqli_fetch_array($result19))
						{
							$doc_no[] = $rows9['doc_no'];
						}	
						$sql191="select * from $brandix_bts.tbl_miniorder_data where docket_number in (".implode(",",$doc_no).")";
						//echo $sql191."<BR>";
						$result91=mysqli_query($link, $sql191) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$rws=mysqli_num_rows($result91);	
						if($rws>0)
						{
							//echo "MiniOrder generation Completed.</td>";
							if($username=='sfcsproject1')
							{
								echo "<input type=\"submit\" value=\"Generate\" class=\"btn btn-primary\" name=\"generate\" id=\"generate\" onclick=\"document.getElementById('generate').style.display='none'; document.getElementById('msg1').style.display='';\"/>";
								echo "<br>";
								echo "MiniOrder generation Completed.";
								echo "</td>";
							}
							else
							{
								echo "MiniOrder generation Completed.</td>";
							}
							//echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait..Mini orders Generating.<h5></span></td>";
						}
						else
						{
							echo "<input type=\"submit\" value=\"Generate\" class=\"btn btn-primary\" name=\"generate\" id=\"generate\" onclick=\"document.getElementById('generate').style.display='none'; document.getElementById('msg1').style.display='';\"/>";
							echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait..Mini orders Generating.<h5></span></td>";
						}	
					}
					else
					{
						echo "<input type=\"submit\" value=\"Generate\" class=\"btn btn-primary\" name=\"generate\" id=\"generate\" onclick=\"document.getElementById('generate').style.display='none'; document.getElementById('msg1').style.display='';\"/>";
						echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait..Mini orders Generating.<h5></span></td>";
					}
				}			
				echo "</tr>";
					
			}
			else
			{
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		echo "</form>";
echo "</div>";
echo "</div>";
	
	
}
if(isset($_POST['generate']))
{
	$style=$_POST['style_id'];
	$operation=$_POST['cart_method'];
	$scheudle=$_POST['sch_id'];
	$mini_order_ref =echo_title("$brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$scheudle,$link);
	$carton_qty=1;
	$bundle_plies=$_POST['bundle_plies'];
	$bundle_per_size=$_POST['bundle_per_size'];
	$mini_order_qty=$_POST['mini_order_qty'];
	//if($bundle_plies!=0 && $bundle_per_size!=0 && $mini_order_qty!=0)
	//{
		if($mini_order_ref>0)
		{
			$sql="update `$brandix_bts`.`tbl_min_ord_ref` set max_bundle_qnty='".$bundle_plies."',carton_method=".$operation.",miximum_bundles_per_size='".$bundle_per_size."',mini_order_qnty='".$mini_order_qty."' where id='".$mini_order_ref."'";
			//echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$id=$mini_order_ref;
		}
		else
		{
			$sql="insert into `$brandix_bts`.`tbl_min_ord_ref` (`ref_product_style`, `ref_crt_schedule`, `carton_quantity`, `max_bundle_qnty`, `miximum_bundles_per_size`, `mini_order_qnty`,`carton_method`) values ('".$style."', '".$scheudle."', '".$carton_qty."', '".$bundle_plies."', '".$bundle_per_size."', '".$mini_order_qty."',".$operation.")";
			//echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
		}
	//}
	//else
	//{
		//echo "<h2>Please Fill Correct values</h2>";
	//}
	//echo $id."<br>";
	//echo "<a href=\"mini_order_gen.php?id=$id\">Generate Mini Orders</a>";
	//echo "<h2>Mini orders Generation under process Please wait.....<h2>";
	$url=getFullURLLevel($_GET['r'],'mini_order_gen.php',0,'N');
	header("Location:$url&id=$id");
}
?> 
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