<?php
//2014-09-12/ber_databasesvc/261957: Added floor set deliveries identification for s=4
//CR # 174 - ber_databasesvc/2014-0924 Added pupup based window.
?>

<?php
// include("dbconf.php"); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=strtolower($username_list[1]);
//echo $username;
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
$view_access=user_acl("SFCS_0131",$username,1,$group_id_sfcs);
$authorized=user_acl("SFCS_0131",$username,7,$group_id_sfcs);
$super_user=user_acl("SFCS_0131",$username,49,$group_id_sfcs);

//$authorized=array("baiict","muralim","duminduw","rajanaa","sfcsproject1","nalakasb","ambhigapathyc","kiranm","ber_databasesvc","baiuser","bainet","srikanthb","ber_databasesvc","rajithago");// for RMS Dashboard allocation
//$super_user=array("muralim","duminduw","ber_databasesvc","bainet","ber_databasesvc","rajanaa","baiict","nalakasb","kirang");
if(!(in_array(strtolower($username),$authorized)))
{
	//header("Location:restrict.php");
}
else
{
	if(!(in_array(strtolower($username),$super_user)) or !(in_array(strtolower($username),$super_user)))
	{
		//New Implementation to restrict as per time lines to update Planning Board 20111211
		$hour=date("H.i");
		
		//if(($hour>=7.45 and $hour<=10.00) or ($hour>=15.15 and $hour<=16.45)) //OLD
		if(($hour>=7.45 and $hour<=10.45) or ($hour>=12.30 and $hour<=14.00) or ($hour>=16.00 and $hour<=17.30))
		//if(($hour>=7.15 and $hour<=9.45) or ($hour>=15.15 and $hour<=17.15))
		{
			
		}
		else
		{
			//header("Location:time_out.php?msg=1");
		}
	}
	
}

$criteria="where left(order_style_no,1) in (".$global_style_codes.")";
// if(!(in_array(strtolower($username),$super_user)) or !(in_array(strtolower($username),$super_user)))
// {
	//exploding the users list into buyer level
	// include("style_allocation.php");
	
	// for($i=0;$i<sizeof($styles_names);$i++)
	// {
		// $style_users=$style_auth[$i];
		// $style_users_ex=explode(",",$style_users);
		// if(in_array($username,$style_users_ex))
		// {
			// $criteria_styles[]=$styles_list[$i];
		// }
	// }
	// $criteria=" where left(order_style_no,1) in (".$global_style_codes.") and  left(order_style_no,1) in (".implode(",",$criteria_styles).")";
// }

?>


<META HTTP-EQUIV="refresh" content="900; URL=<?=getFullURLLevel($_GET['r'],'pps_dashboard.php',0,'R');?>">
<style>
body
{
	font-family: Trebuchet MS;
}
</style>
<script>

function firstbox()
{
	window.location.href ="index.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value
}

function secondbox()
{
	window.location.href ="index.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value
}

function thirdbox()
{
	window.location.href ="index.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}
</script>

<div class="panel panel-primary">
<div class="panel-heading">Cutting Table Planning</div>
<div class="panel-body">
<div class="row">
<body>

<?php 
// include("functions.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 

?>
<?php
$style=$_GET['style'];
$schedule=$_GET['schedule']; 
$color=$_GET['color'];
//echo $style.$schedule.$color;
?>
<!---<div id="page_heading"><span style="float"><h3>Cutting Table Planning</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>--->

<form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">
<?php

echo "<div class='col-md-3'>";
echo "<label>Select Style: </label><select name=\"style\" onchange=\"firstbox();\" class=\"select2_single form-control\">";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_style_no from plan_doc_summ $criteria";	
	echo $sql;
//}
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
{
	echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
}

}

echo "</select>";
echo "</div>";
?>

<?php



//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_del_no from plan_doc_summ where order_style_no=\"$style\"";	
//}
echo "<div class='col-md-3'>";
echo "<label>Select Schedule: </label><select name=\"schedule\" onchange=\"secondbox();\" class=\"select2_single form-control\">";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
{
	echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
}
//For color Clubbing

}


echo "</select>";
echo "</div>";
//Color Clubbing
$sql="select distinct order_del_no,clubbing from plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\"";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$clubbing=$sql_row['clubbing'];
}
?>

<?php

/* $sql="select GROUP_CONCAT(DISTINCT trim(order_col_des)) AS disp,max(plan_module),order_col_des from order_cat_doc_mix where order_style_no=\"$style\" and order_del_no=\"$schedule\" and clubbing>0 group by clubbing union select DISTINCT order_col_des,plan_module,order_col_des AS disp from order_cat_doc_mix where order_style_no=\"$style\" and order_del_no=\"$schedule\" and clubbing=0 group by clubbing,order_col_des";
echo $sql; */
echo "<div class='col-md-3'>";
echo "<label>Select Color: </label><select name=\"color\" onchange=\"thirdbox();\" class=\"select2_single form-control\">";


//$sql="select GROUP_CONCAT(DISTINCT order_col_des) AS disp,max(plan_module),order_col_des from plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" and clubbing>0 group by clubbing union select DISTINCT order_col_des,plan_module,order_col_des AS disp from plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" and clubbing=0 group by clubbing,order_col_des";	

$sql="select GROUP_CONCAT(DISTINCT trim(order_col_des)) AS disp,max(plan_module),order_col_des from order_cat_doc_mix where order_style_no=\"$style\" and order_del_no=\"$schedule\" and clubbing>0 group by clubbing union select DISTINCT order_col_des,plan_module,order_col_des AS disp from order_cat_doc_mix where order_style_no=\"$style\" and order_del_no=\"$schedule\" and clubbing=0 group by clubbing,order_col_des";
//echo $sql;


//For Color Clubbing
/*
if($clubbing>0)
{
	$sql="select distinct order_col_des from plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" group by clubbing,order_col_des";		
}
*/
//echo $sql;

//}
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
	
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
{
	echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['disp']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['disp']."</option>";
}

}


echo "</select>";
echo "</div>";
$code="";
//$sql="select doc_no,color_code,acutno,act_cut_status,cat_ref from plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\" and plan_module is NULL order by doc_no";
//$sql="select doc_no,color_code,acutno,act_cut_status,cat_ref from plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\" and (plan_module is NULL or a_plies<>p_plies or act_cut_issue_status='') order by doc_no";
$sql="select doc_no,color_code,acutno,act_cut_status,cat_ref from plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\" and doc_no not in (select doc_no from plan_dashboard) and (a_plies<>p_plies or act_cut_issue_status='') order by doc_no";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]).$sql);
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
//docketno-colorcode cutno-cut_status
while($sql_row=mysqli_fetch_array($sql_result))
{
	$code.=$sql_row['doc_no']."-".chr($sql_row['color_code']).leading_zeros($sql_row['acutno'],3)."-".$sql_row['act_cut_status']."*";
	$cat_ref=$sql_row['cat_ref'];
}

$sql="select cat_ref from plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\" order by doc_no";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
//docketno-colorcode cutno-cut_status
while($sql_row=mysqli_fetch_array($sql_result))
{
	$cat_ref=$sql_row['cat_ref'];
}




if($sql_num_check>0)
{
	echo "<div class='col-md-2'>";
	echo "<label>Jobs Available </label><br/><span class='label label-success' style='font-size : 150%'>Yes</span>";
	echo "</div>";
	echo "<input type=\"hidden\" name=\"code\" value=\"$code\">";
	echo "<input type=\"hidden\" name=\"cat_ref\" value=\"$cat_ref\">";
	echo "<div class='col-md-1'> <input type=\"submit\" value=\"submit\" name=\"submit\" class=\"btn btn-success\" style=\"margin-top: 19px;\">";	
	echo "</div>";
}
else
{
	echo "<div class='col-md-2'>";
	echo "<label>Jobs Available  </label><br/><span class='label label-danger' style='font-size : 150%'>No</span>";
	echo "</div>";
}

?>


</form>

<?php

$floor_set_schedule=array();
$floor_set_order_tid=array();
//$sql="select group_concat(order_del_no) as order_del_no from bai_orders_db where left(order_style_no,1)=\"".substr($style,0,1)."\" and order_col_des=\"$color\"  AND (order_s_xs=9 OR order_s_s=10)";
//$sql="select group_concat(order_del_no) as order_del_no, group_concat(order_tid SEPARATOR \"','\") as order_tid from bai_orders_db where order_style_no=\"".$style."\" and order_col_des=\"$color\"  AND (order_s_xs=9 OR order_s_s=10) and order_del_no>0";

/*$sql="select order_del_no, order_tid from bai_orders_db where order_style_no=\"".$style."\" and order_col_des=\"$color\"  AND (order_s_xs=9 OR order_s_s=10 OR order_s_s=4 OR order_s_s=17 OR order_s_s14=3 OR order_s_s18=3) and order_del_no>0";
//echo $sql;
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$floor_set_count=mysql_num_rows($sql_result);
while($sql_row=mysql_fetch_array($sql_result))
{
	$floor_set_schedule[]=$sql_row['order_del_no'];
	$floor_set_order_tid[]=$sql_row['order_tid'];
}


if($floor_set_count>0)
{
	$display="";
	
	for($i=0;$i<sizeof($floor_set_schedule);$i++)
	{
		if($floor_set_schedule[$i]!=NULL)
		{
			$highlight="red";
			//$sql="select doc_no from plandoc_stat_log where order_tid like \"%$floor_set_schedule%\" and plan_module>0";
			$sql="select doc_no from plandoc_stat_log where order_tid='".$floor_set_order_tid[$i]."' and plan_module>0";
			$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			if(mysql_num_rows($sql_result)>0)
			{
				$highlight="green";
			}
			$display.="<font color=$highlight>".$floor_set_schedule[$i]."</font>";
			
		}
	}
	
	echo "<h2>The following $display are Floor Sets, Please do plan accordingly.</h2>";
}*/

?>

</body>
</div>
</div>
</div>
</div>


<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	//echo  $color;
	$schedule=$_POST['schedule'];
	$code=$_POST['code'];
	$cat_ref=$_POST['cat_ref'];
	
	//echo $code;
	$url=getFullURL($_GET['r'],'drag_drop.php','R');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url?color=$color&style=$style&schedule=$schedule&code=$code&cat_ref=$cat_ref\";}</script>";
}
?>  