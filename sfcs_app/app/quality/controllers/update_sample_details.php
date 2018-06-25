<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
//include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions2.php',3,'R'));

//$View_access=user_acl("SFCS_0144",$username,1,$group_id_sfcs);
/*
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);

$sql="select * from menu_index where list_id=269";
$result=mysql_query($sql,$link) or mysql_error("Error=".mysql_error());
while($row=mysql_fetch_array($result))
{
	$users=$row["auth_members"];
}

$auth_users=explode(",",$users);
if(in_array($username,$auth_users))
{
	
}
else
{
	header("Location: Restricted.php");
}
*/
?>



<html>
<head>
<meta http-equiv="refresh" content="60"> 
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/css/dropdowntabs.js',3,'R'); ?>"></script>


<link href="style.css" rel="stylesheet" type="text/css" />

<meta http-equiv="cache-control" content="no-cache">
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/


/*====================================================
	- General html elements
=====================================================*/
body{
	margin:15px; padding:15px; border:1px solid #666;
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
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; }

</style>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script>

<Link rel='alternate' media='print' href=null>
<Script Language=JavaScript>

function setPrintPage(prnThis){

prnDoc = document.getElementsByTagName('link');
prnDoc[0].setAttribute('href', prnThis);
window.print();
}

</Script>

</head>


<body>
<?php //include("../menu_content.php"); ?>



<form name="input" method="post" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">
<div class='panel panel-primary'>
<div class='panel-heading'><h5>Sample Room - Sample Schedules Confirmation Form</h5></div>
	<div class='panel-body'>
		<div class='form-group'>
			<div class='col-md-6 col-sm-3 col-xs-12'>
				<textarea cols=80 rows=10 name="input" class="form-control"></textarea>
			</div>
			<div class='col-md-3 col-sm-3 col-xs-12'>
				
				<input type="submit" value="Submit" class="btn btn-success" name="submit"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?= getFullURL($_GET['r'],'Sample_SCH_Confirmation.xls','R'); ?>" class="btn btn-link">Download Tool</a>
			</div>
		</div>
	</div>
</div>
</form>


<?php

if(isset($_POST["process"]))
{
		$elm1=$_POST['elm1'];
		$elm2=$_POST['elm2'];
		$elm3=$_POST['elm3'];
		
		for($i=0;$i<sizeof($elm1);$i++)
		{
			if($elm1[$i]>0 and $elm3[$i]=="1")
			{
				$sql="INSERT IGNORE INTO $bai_pro3.bai_orders_db_remarks(order_tid,remarks) SELECT order_tid,'SAMPLES:(".$elm2[$i].")' FROM $bai_pro3.bai_orders_db WHERE order_del_no=".$elm1[$i];
				mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
		echo"<script>sweetAlert('Successfully Updated','', 'success')</script>";
}

if(isset($_POST["submit"]))
{
	$textarea=explode("$",$_POST['input']); 
	
	echo "<form name=\"process\" method=\"post\" action=\"".getURL(getBASE($_GET['r'])['path'])['url']."\">";
	echo "<input type=\"submit\" name=\"process\" class=\"btn btn-success\" value=\"Update\">";
	echo "<br/>";
	echo "<table class='table table-bordered'>";
	echo "<tr>
	<th>Schedule</th>
	<th>Remarks</th>
	<th>SFCS Layplan Status</th>
	</tr>";
	for($i=0;$i<sizeof($textarea);$i++)
	{
		$temp=explode("*",$textarea[$i]);
		
		echo "<tr>";
			echo "<td><input type=\"text\" name=\"elm1[]\" value=\"".$temp[0]."\" class=\"form-control col-md-7 col-xs-12\"></td>";
			echo "<td><input type=\"text\" name=\"elm2[]\" value=\"".$temp[1]."\" class=\"form-control col-md-7 col-xs-12\"></td>";
			//echo "<td><input type=\"text\" name=\"elm3[]\" value=\"".$temp[2]."\"></td>";
			
			$sql="SELECT order_tid from $bai_pro3.bai_orders_db_confirm where order_del_no=".$temp[0];
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
						
			if(mysqli_num_rows($sql_result)>0)
			{
				echo "<td><font color=\"red\">Done</font><input type=\"hidden\" name=\"elm3[]\" value=\"0\"></td>";
			}
			else
			{
				echo "<td>Pending<input type=\"hidden\" name=\"elm3[]\" value=\"1\"></td>";
			}
			
		echo "</tr>";
		
		unset($temp);
	}
	echo "</table>";
	echo "</form>";
}
?>

</body>
</html>