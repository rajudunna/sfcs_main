<?php

// include($_SERVER['DOCUMENT_ROOT']."bai1/server/user_acl_v1.php");
// include($_SERVER['DOCUMENT_ROOT']."bai1/server/group_def.php");
// $view_access=user_acl("SFCS_0217",$username,1,$group_id_sfcs);
// $auth_users=user_acl("SFCS_0217",$username,7,$group_id_sfcs);
//$auth_users=array("kirang","srinivasaraog","sureshg","srinub","tharangam","lokeshk","sandhyaranik","sanyasiraog","dineshin","kirang","srinivasaraog","sureshg","srinub","tharangam","kirang","srinivasaraog","sureshg","srinub","tharangam","lokeshk","sandhyaranik","sanyasiraog","dineshin");
?>

<?php
//if(!in_array($username,$auth_users))
{
	//header("Location: restricted.php");
}
include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
?>

<?php include("../".getFullURLLevel($_GET['r'],'common/config/header_scripts.php',4,'R'));?>

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

	function subview()
	{
		var sub_style = document.getElementById('sub').style.display;

		if(sub_style == 'none'){
			document.getElementById('sub').style.display='block';
		}else{
			document.getElementById('sub').style.display='none';
		}
		
	}

</script>
<div class="panel panel-primary">
<div class="panel-heading"><b>M3 Lay Quantity Reporting</b></div>
<div class="panel-body">
<?php //include("menu_content.php"); ?>

<?php
$style=$_GET['style'];
$schedule=$_GET['schedule']; 
$color=$_GET['color'];

//echo $style.$schedule.$color;
?>

<form name="test" action="?r=<?php echo $_GET['r']; ?>" method="post">
<?php

echo "<div class='row'>";
echo "<div class='col-md-2'>";
echo "<label>Select Style: </label>
<select name=\"style\" onchange=\"firstbox();\" class='form-control'>";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_style_no from $bai_pro3.bai_orders_db_confirm order by order_style_no";	
//}
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

echo "</select></div>";
?>

<?php
echo "<div class='col-md-2'>";
echo "<label>Select Schedule: </label><select name=\"schedule\" onchange=\"secondbox();\" class='form-control'>";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_del_no from bai_orders_db_confirm where order_style_no=\"$style\"";	
//}
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

}


echo "</select></div>";
?>

<?php

echo "<div class='col-md-2'>";
echo "<label>Select Color: </label><select name=\"color\" onchange=\"thirdbox();\" class='form-control'>";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="SELECT DISTINCT order_col_des FROM $bai_pro3.bai_orders_db_confirm WHERE order_style_no='$style' AND order_del_no='$schedule' AND order_joins<4";
//}
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
	
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
{
	echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
}

}


echo "</select></div>";


$sql="select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$order_tid=$sql_row['order_tid'];
}

//echo $order_tid;
echo "<input type=\"hidden\" name=\"order_tid\" value=\"$order_tid\">";



$sql="select distinct category,tid from $bai_pro3.cat_stat_log where order_tid='$order_tid' and category in ('Body','Front')";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "<div class='col-md-2'>";
echo "<label>Select Category: </label><select name=\"category\" class='form-control' onchange=\"subview();\">";
echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

	echo "<option value=\"".$sql_row['tid']."\">".$sql_row['category']."</option>";

}


echo "</select></div>";


echo "<div class='col-md-2'>";
$sql="select mo_status from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\"";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$mo_status=$sql_row['mo_status'];
}




if($mo_status=="Y")
{

	echo "<br/><label>MO Status  :</label>&nbsp;&nbsp;"."<label class='label label-success'>".$mo_status."es</label>";
		
}
else
{
	echo "<br/><label>MO Status  :</label>&nbsp;&nbsp;"."<label class='label label-danger'>No</label>";
	// echo "<input type=\"submit\" value=\"submit\" name=\"submit\" class='btn btn-success'>";
}
?>
</div>
<div class="col-md-2">
<input type="submit" value="submit" id="sub" name="submit" class='btn btn-success' style="margin-top:22px; display:none;" />
</div>
</div>
</form>
<!--
<br/>
<br/>
<table style="background-color: #EEEEEE;">
<tr><td><form method="post" name="input" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<strong>Enter Docket Reference: </strong><input type="text" name="docket_id" size=15>
<input type="submit" value="search" name="submit2">
</form></td>

<td><form method="post" name="input" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<strong>Enter CID:</strong> <input type="text" name="cid_id" size=15>
<input type="submit" value="search" name="submit3">
</form></td></tr>
</table>
-->

<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	$order_tid=$_POST['order_tid'];
	$category=$_POST['category'];
	
	$sql="select order_div from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$customer=$sql_row['order_div'];
		$customer_div=$sql_row['order_div'];
	}
	
	$customer=substr($customer,0,((strlen($customer)-2)*-1));

	$path = getFullURL($_GET['r'],'m3_lay_reporting_v2.php','N');

	// var_dump($path);
	// $path+&color=$color&style=$style&schedule=$schedule&order_tid=$order_tid&cat_ref=$category
	// die();
	
	switch ($customer)
	{
		
		case "VS":
		{
			if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			{
				
				echo "<script type=\"text/javascript\"> 
						setTimeout(\"Redirect()\",0); 
						function Redirect() {  
							location.href = '$path&color=$color&style=$style&schedule=$schedule&order_tid=$order_tid&cat_ref=$category'; 
						}
					</script>";
			}
			else
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"'$path'&color=$color&style=$style&schedule=$schedule&order_tid=$order_tid&cat_ref=$category\"; }</script>";
			}
			break;
		}
		
		case "LB":
		{
			if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"'$path'&color=$color&style=$style&schedule=$schedule&order_tid=$order_tid&cat_ref=$category\"; }</script>";
			}
			else
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$path&color=$color&style=$style&schedule=$schedule&order_tid=$order_tid&cat_ref=$category\"; }</script>";
			}
			break;
		}
		
		case "DB":
		{
			if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$path&color=$color&style=$style&schedule=$schedule&order_tid=$order_tid&cat_ref=$category\"; }</script>";
			}
			else
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$path&color=$color&style=$style&schedule=$schedule&order_tid=$order_tid&cat_ref=$category\"; }</script>";
			}
			break;
		}
		
		case "M&":
		{
			if(strpos($customer_div,"- Men")) //NEW Implementation for M&S as Men Wear having size codes different. 20110428
			{
				if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				{
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$path&color=$color&style=$style&schedule=$schedule&order_tid=$order_tid&cat_ref=$category\"; }</script>";
				}
				else
				{
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$path&color=$color&style=$style&schedule=$schedule&order_tid=$order_tid&cat_ref=$category\"; }</script>";
				}
			}
			else
			{
				if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				{
					//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/new_doc_gen/m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$path&color=$color&style=$style&schedule=$schedule&order_tid=$order_tid&cat_ref=$category\"; }</script>";
				}
				else
				{
					//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../cut_plan_new_ms/new_doc_gen/m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$path&color=$color&style=$style&schedule=$schedule&order_tid=$order_tid&cat_ref=$category\"; }</script>";
				}
			}
			break;
		}
		
		default:
		{
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$path&color=$color&style=$style&schedule=$schedule&order_tid=$order_tid&cat_ref=$category\"; }</script>";
		}
		
	}
}


if(isset($_POST['submit2']))
{
	
	$docket_id=$_POST['docket_id'];
	//echo $docket_id;
	
	if($docket_id>0)
	{
		
	
	$sql="select * from $bai_pro3.plandoc_stat_log where doc_no=$docket_id";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$cat_ref=$sql_row['cat_ref'];
		$order_tid=$sql_row['order_tid'];
	}
	
	if($cat_ref>0)
	{
		$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
		
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$style=$sql_row['order_style_no'];
			$color=$sql_row['order_col_des'];
			$schedule=$sql_row['order_del_no'];
			$customer=$sql_row['order_div'];
			$customer_div=$sql_row['order_div'];
		}
		
		$customer=substr($customer,0,((strlen($customer)-2)*-1));
	
	switch ($customer)
	{
		case "VS":
		{
			if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			}
			else
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			}
			break;
		}
		
		case "LB":
		{
			if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			}
			else
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			}
			break;
		}
		
		case "DB":
		{
			if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			}
			else
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			}
			break;
		}
		
		case "M&":
		{
			if(strpos($customer_div,"- Men")) //NEW Implementation for M&S as Men Wear having size codes different. 20110428
			{
				if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				{
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				}
				else
				{
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				}
			}
			else
			{
				if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				{
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				}
				else
				{
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				}
			}
			break;
		}
		default:
		{
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
		}
		
	}
		
	}
  else
    {
    	
    	echo "Requested Docket doesnot exist. Please contact your planner.";
    }
    }
    else
    {
    	echo "Please enter valid Docket Reference";
    }
   }
   
   
if(isset($_POST['submit3']))
{
	
	$cid_id=$_POST['cid_id'];
	//echo $docket_id;
	
	if($cid_id>0)
	{
	
	$sql="select * from $bai_pro3.plandoc_stat_log where cat_ref=$cid_id";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$order_tid=$sql_row['order_tid'];
	}
	
	$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style=$sql_row['order_style_no'];
		$color=$sql_row['order_col_des'];
		$schedule=$sql_row['order_del_no'];
		$customer=$sql_row['order_div'];
		$customer_div=$sql_row['order_div']; //NEW Implementation for M&S as Men Wear having size codes different. 20110428
	}
		if($schedule>0)
{
		$customer=substr($customer,0,((strlen($customer)-2)*-1));
	
	switch ($customer)
	{
		case "VS":
		{
			if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			}
			else
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			}
			break;
		}
		
		case "LB":
		{
			if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			}
			else
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			}
			break;
		}
		
		case "DB":
		{
			if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			}
			else
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
			}
			break;
		}
		
		case "M&":
		{
			
			if(strpos($customer_div,"- Men")) //NEW Implementation for M&S as Men Wear having size codes different. 20110428
			{
				if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				{
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				}
				else
				{
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				}
			}
			else
			{
				if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
				{
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				}
				else
				{
					echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
				}
			}
			
			
			break;
		}
		default:
		{
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"m3_lay_reporting_v2.php?color=$color&style=$style&schedule=$schedule\"; }</script>";
		}
		
	}
}
else
{
	echo "Please enter valid Docket Reference";
}
		
	}
  else
    {
    	
    	echo "Requested Docket doesnot exist. Please contact your planner.";
    }
}
   ?> 
   </div>
</div>