<!--

Ticket #: #684040-kirang/2014-05-26 : To raise compalint for rejected RM material

CR# 213 / kirang / 2014-10-21 : Stock out option for Multiple Lots And Locations

-->


<?php 

  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
  // require_once('phplogin/auth.php');
  ob_start();
  // require_once "ajax-autocomplete/config.php";
  $url = getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R');
  include($_SERVER['DOCUMENT_ROOT'].'/'.$url);
  $url = getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R');
  include($_SERVER['DOCUMENT_ROOT'].'/'.$url); 

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<!--<script type="text/javascript" src="ajax-autocomplete/jquery.js"></script>
<script type='text/javascript' src='ajax-autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="ajax-autocomplete/jquery.autocomplete.css" />-->

<script type="text/javascript">
$().ready(function() {
	$("#course").autocomplete("ajax-autocomplete/get_course_list.php", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
});
</script>

<title>Stock Out Form</title>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />
  <script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>
  
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check.js',1,'R'); ?>"></script>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
</head>
<body onload="dodisable();">
<div class="panel panel-primary">
<div class="panel-heading" style="height:35px;">
<span style="float: left"><h3 style="margin-top: -6px;">Update RM Issuing</h3></span><span style="float: right"><b></b>&nbsp;</span></div></div>

<?php include("menu_content.php"); ?>

<div style="float:right;">
<FORM method="post" name="input2" action="?r=<?= $_GET['r'] ?>">
<div id="seract_lot">Search Lot No/Location: <!--<input type="text" id="course" name="lot_no">-->
<textarea id="course" name="lot_no" cols=12 rows=10 style="height: 107px;"></textarea>
<input type="submit" name="submit" value="Search" class="btn btn-success"></div>
</form>

</div>
<?php
if(isset($_POST['submit']))
{
	$lot_nos=$_POST['lot_no'];
	$lot_nos_explode=explode(",",$lot_nos);
	//Added the single quotes for multiple level of stock searching
	$lot_no=implode(",",$lot_nos_explode);
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"insert.php?lot_no=$lot_no_new\"; }</script>";
}
else
{
	$lot_nos=$_GET['lot_no'];
	$lot_nos_explode=explode(",",$lot_nos);
	//Added the single quotes for multiple level of stock searching
	$lot_no=implode(",",$lot_nos_explode);
}


?>

<h3>Stock OUT</h3>

<?php
if(strlen($lot_no)>2)
{

	if($lot_no!=''){
		echo "<a id='back1' class=\"btn btn-xs btn-warning\" href=\"".getFullURL($_GET['r'], "stock_out_v1.php", "N")."\"><<<< Click here to Go Back</a>";

		echo"<style>#seract_lot{display:none;}</style>";
	   }
	   else{
		echo"<style>#back1{display:none;}</style>";
	   }

//$sql="select * from sticker_report where lot_no=\"".trim($lot_no)."\"";
$sql5="select * from $bai_rm_pj1.sticker_report where lot_no in ('".trim($lot_no)."')";
//mysqli_query($sql,$link) or exit("Sql Error2".mysqli_error());
$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check1=mysqli_num_rows($sql_result5);
while($sql_row=mysqli_fetch_array($sql_result5))
{

	$product_group=$sql_row['product_group'];
	$item=$sql_row['item'];
	$item_name=$sql_row['item_name'];
	$item_desc=$sql_row['item_desc'];
	$inv_no=$sql_row['inv_no'];
	$po_no=$sql_row['po_no'];
	$rec_no=$sql_row['rec_no'];
	$rec_qty=$sql_row['rec_qty'];
	$batch_no=$sql_row['batch_no'];
	$buyer=$sql_row['buyer'];
	$pkg_no=$sql_row['pkg_no'];
	$grn_date=$sql_row['grn_date'];
}

$sql="select sum(qty_rec) as \"qty_rec\" from $bai_rm_pj1.store_in where lot_no in ('".trim($lot_no)."')";
//mysqli_query($sql,$link) or exit("Sql Error3".mysqli_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error3".mysqli_error());
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$qty=$sql_row['qty_rec'];
}

$diff=$rec_qty-$qty;

if($sql_num_check1>0)
{
	// echo"<input type='button' name='back' value='Back' class='btn btn-success' style='margin-left:2px;'></div>";

	echo "<div class='table-responsive'>";
	echo "<table class='table table-bordered' style='width:70%'>";
	echo "<tr  style='background-color:white;'><td>Lot No</td><td>:</td><td>$lot_no</td></tr>";
	echo "<tr  style='background-color:white;'><td>Batch</td><td>:</td><td>$batch_no</td></tr>";
	echo "<tr  style='background-color:white;'><td>Item Description</td><td>:</td><td>$item_desc</td></tr>";
	echo "<tr  style='background-color:white;'><td>Item Name</td><td>:</td><td>$item_name</td></tr>";
	echo "<tr  style='background-color:white;'><td>Product</td><td>:</td><td>$product_group</td></tr>";
	echo "<tr  style='background-color:white;'><td>GRN Date</td><td>:</td><td>$grn_date</td></tr>";
	echo "</table>";
	echo "</div>";
	
}

echo "<form id='myForm' name='input' action='?r=".$_GET['r']."' method='post'>";
echo "<div>";
echo "<table class='table table-bordered col-sm-2' style='margin-top: 23px;'>";
echo "<tr  style='background-color:white;'><th>Location</th><th>Lot #</th><th>Label ID</th><th>Box/Roll No</th><th>Available Qty</th><th>Date</th>";

switch (trim($product_group))
{
	case "Elastic":
	{
		echo "<th>Issued Qty (MTR)</th><th>Style</th><th>Schedule</th><th>Job No</th><th>Remarks</th></tr>";
		break;
	}
	case "Lace":
	{
		echo "<th>Issued Qty (Yds)</th><th>Style</th><th>Schedule</th><th>Job No</th><th>Remarks</th></tr>";
		break;
	}
	case "Fabric":
	{
		echo "<th>Issued Qty (MTR)</th><th>Style</th><th>Schedule</th><th>Job No</th><th>Remarks</th></tr>";
		//header("Location: restrict.php");
		break;
	}
	case "Thread":
	{
		echo "<th>Issued Qty (CON) </th><th>Style</th><th>Schedule</th><th>Job No</th><th>Remarks</th></tr>";
		break;
	}
	default:
	{
		echo "<th>Issued Qty (CON) </th><th>Style</th><th>Schedule</th><th>Job No</th><th>Remarks</th></tr>";
		break;
	}
}

//To list details based on the Location / Lot Number
if($sql_num_check1>0)
{
	//$sql="select * from store_in where lot_no=\"".trim($lot_no)."\" and status in (0,1) and roll_status in (0,2) order by lot_no";	
	$sql="select * from $bai_rm_pj1.store_in where lot_no in ('".trim($lot_no)."') and status in (0,1) and roll_status in (0,2) and qty_issued<=0 order by lot_no";	
	//
}
else
{
	//$sql="select * from store_in where ref1=\"".trim($lot_no)."\" and status in (0,1) and roll_status in (0,2) order by lot_no";
	$sql="select * from $bai_rm_pj1.store_in where ref1 in ('".trim($lot_no)."') and status in (0,1) and roll_status in (0,2) and qty_issued<=0 order by lot_no";
//echo $sql;
}

//mysqli_query($sql,$link) or exit("Sql Error1".mysql_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error1".mysqli_error());
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tid=$sql_row['tid'];
	$location=$sql_row['ref1'];
	$box=$sql_row['ref2'];
	$qty_rec=$sql_row['qty_rec'];
	$barcode_number=$sql_row['barcode_number'];
	$status=$sql_row['status'];
	$available=$qty_rec-$sql_row['qty_issued']+$sql_row['qty_ret']-$sql_row['partial_appr_qty'];
	$available2=$sql_row['ref5']-$sql_row['qty_issued']+$sql_row['qty_ret']-$sql_row['partial_appr_qty']; //Ctex Length
	$lot_ref=$sql_row['lot_no'];
	
	echo "<tr>";
	if($status==0)
	{
		if($available > 0)
		{
			echo "<td  style='background-color:white;'>$location</td><td style='background-color:white;'>$lot_ref</td><td style='background-color:white;'>$barcode_number</td><td style='background-color:white;'>$box</td><td style='background-color:white;'>$available</td>";
			echo '<td style="background-color:white;"><input style="width:88px; type="text" name="date[]" value="'.date("Y-m-d").'"></td>';
			echo '<td style="background-color:white;"><input style="width: 72px; type="text" name="qty_issued[]"  value="" onchange="if(check(this.value, '.$available.')==1010){ this.value=0;}"></td>';
			echo '<td style="background-color:white;"><input style="width: 110px; type="text" name="style[]"  value=""></td>';
			echo '<td style="background-color:white;"><input style="width: 110px; type="text" name="schedule[]"  value=""></td>';
			echo '<td style="background-color:white;"><input style="width: 62px; type="text" name="cut[]" value=""></td>';
			echo '<td style="background-color:white;"><input style="width: 125px; type="text" name="remarks[]" value="">';
			echo '<input type="hidden" name="tid[]" value="'.$tid.'"><input type="hidden" name="available[]" value="'.$available.'"><input type="hidden" name="available2[]" value="'.$available2.'"></td>';
		}
		
	}
	else
	{
		if($available > 0)
		{
			echo "<td>$location</td><td>$lot_ref</td>
			<td>$tid</td>
			<td>$box</td>
			<td>$available</td>";
			echo '<td>Locked</td>';
			echo '<td>Locked</td>';
			echo '<td>Locked</td>';
			echo '<td>Locked</td>';
			echo '<td>Locked</td>';
			echo '<td>Locked</td>';
		}		
	}
	echo "</tr>";	
}

echo "</table>";
echo "</div>";
echo '<input type="hidden" name="lot_no" value="'.$lot_no.'">';

//echo '<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable<input type="submit" value="Submit" onclick="return button_disable();" class="btn btn-success"  name="put"/ disabled></form>';
echo'<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();"  style="margin-top:33px;">Enable
<input type="submit" value="Submit" name="put" id="put" class="btn btn-success style="margin-top:33px;"/>';
// onclick="return button_disable();
echo "<h2>Transaction Log:</h2>";

echo "<div class='table-responsive'>";
echo "<table class='table table-bordered'>";
echo "<tr style='background-color:white;'><th>date</th><th>Label Id</th><th>Roll No</th><th>Qty</th><th>Style</th><th>Schedule</th><th>Job No</th><th>Remarks</th><th>User</th></tr>";
if($sql_num_check1>0){
$sql="select * from $bai_rm_pj1.store_out where tran_tid in (select tid from $bai_rm_pj1.store_in where lot_no in ('".trim($lot_no)."')) order by date";
}
else{
	$sql="select * from $bai_rm_pj1.store_out where tran_tid in (select tid from $bai_rm_pj1.store_in where ref1 in ('".trim($lot_no)."')) order by date";
}
//echo $sql;
//mysqli_query($link,$sql) or exit("Sql Error5".mysqli_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error5".mysqli_error());
while($sql_row=mysqli_fetch_array($sql_result))
{
	$date=$sql_row['date'];
	$qty=$sql_row['qty_issued'];
	$style=$sql_row['Style'];
	$schedule=$sql_row['Schedule'];
	$tran_tid=$sql_row['tran_tid'];
	$cutno=$sql_row['cutno'];
	$d=0;
	if(strpos($cutno,"T") !== FALSE)
	{
		$d=1;
	}
	$remarks=$sql_row['remarks'];
	$user=$sql_row['updated_by'];
				$sql3="select lot_no,ref2,barcode_number from $bai_rm_pj1.store_in where tid='$tran_tid'";
				$result3=mysqli_query($link,$sql3) or die("Error = ".mysqli_error());
				while($row3=mysqli_fetch_array($result3))
				{
					//$lot_no1=$row3["lot_no"];
					$ref2=$row3["ref2"];
					$barcode_number=$row3["barcode_number"];
				}
	if($d==1)
	{
		$dockets=explode("T",$cutno);
		$sql1="select acutno,order_tid as orders from $bai_pro3.plandoc_stat_log where doc_no=\"".$dockets[1]."\"";
		//echo $sql1;
		$result1=mysqli_query($link,$sql1) or die("Error = ".mysqli_error());
		while($row1=mysqli_fetch_array($result1))
		{
			$cutnos=$row1["acutno"];
			$order_tid=$row1["orders"];
		}

		
		
		$sql2="select order_style_no AS style,order_del_no AS sch,order_col_des AS color,color_code AS code from $bai_pro3.bai_orders_db where order_tid=\"".$order_tid."\"";
		//echo $sql1;
		$result2=mysqli_query($link,$sql2) or die("Error = ".mysqli_error());
		while($row2=mysqli_fetch_array($result2))
		{
			$style=$row2["style"];
			$schedule=$row2["sch"];
			$color=$row2["color"];
			$code=$row2["code"];
		}
					
		echo "<tr style='background-color:white;'><td>$date</td><td>$barcode_number</td><td>$ref2</td><td>$qty</td><td>$style</td><td>$schedule</td><td>".chr($code)."00".$cutnos."</td><td>$remarks</td><td>$user</td></tr>";
	}
	else
	{
		echo "<tr style='background-color:white;'><td>$date</td><td>$barcode_number</td><td>$ref2</td><td>$qty</td><td>$style</td><td>$schedule</td><td>$cutno</td><td>$remarks</td><td>$user</td></tr>";
	}
	
	/*$remarks=$sql_row['remarks'];
	$user=$sql_row['updated_by'];
	
	echo "<tr><td>$date</td><td>$qty</td><td>$style</td><td>$schedule</td><td>$cutno</td><td>$remarks</td><td>$user</td></tr>";*/
}

echo "</table>";
echo "</div>";


}
?>




</body>
</html>

<?php



if(isset($_POST['put']))
{
	$date=$_POST['date'];
	$qty_issued=$_POST['qty_issued'];
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$cut=$_POST['cut'];
	$remarks=$_POST['remarks'];
	$tid=$_POST['tid'];
	$available=$_POST['available'];
	$available2=$_POST['available2']; //CTEX Length
	$lot_no_new=$_POST['lot_no'];
	$user_name=$_SESSION['SESS_MEMBER_ID'];
	for($i=0; $i<sizeof($qty_issued); $i++)
	{
		if($qty_issued[$i]>0)
		{
			$sql="insert into $bai_rm_pj1.store_out (tran_tid, qty_issued, style, schedule, cutno, date, remarks, updated_by) values (".$tid[$i].",".$qty_issued[$i].",'".$style[$i]."','".$schedule[$i]."','".$cut[$i]."','".$date[$i]."','".$remarks[$i]."','".$username."_rm_issue')";
			$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
			$qty_issued_new=0;
			
			$sql5="select qty_issued from $bai_rm_pj1.store_in where tid=".$tid[$i];
			//mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
			$sql_result=mysqli_query($link,$sql5) or exit("Sql Error".mysqli_error());
			$sql_num_check=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$qty_issued_new=$sql_row['qty_issued'];
			}
			$qty_issued_new=$qty_issued_new+$qty_issued[$i];
			
			$sql12="update $bai_rm_pj1.store_in set qty_issued=".$qty_issued_new.", allotment_status=0 where tid=".$tid[$i];
			$sql_result=mysqli_query($link,$sql12) or exit("Sql Error".mysqli_error());

			if($available[$i]==$qty_issued[$i])
			{
				$sql="update $bai_rm_pj1.store_in set status=2, allotment_status=2 where tid=".$tid[$i];
				$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
			}
			//CTEX Length
			if($qty_issued[$i]>=$available2[$i])
			{
				$sql="update $bai_rm_pj1.store_in set allotment_status=2 where tid=".$tid[$i];
				$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
			}
		}
	}
	// $url2=getFullURL($_GET['r'],'stock_out_v1.php','N');
	// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"index.php?r=$url2&lot_no=$lot_no_new\"; }</script>";
	echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
	echo("<script>location.href = '".getFullURLLevel($_GET['r'],'stock_out_v1.php',0,'N')."&lot_no=$lot_no_new';</script>");
}


?>


