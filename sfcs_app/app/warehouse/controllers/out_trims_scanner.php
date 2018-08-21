
<?php 
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");
list($domain,$username) = explode('[\]',$_SERVER['AUTH_USER'],2);
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);
$url = '/sfcs_app/app/warehouse/controllers/in_trims.php';
$out_trims_scanner = '/sfcs_app/app/warehouse/controllers/out_trims_scanner.php';
?>
<script>

function check_docket(e){
	var d = document.getElementById('carton').value;
	var m = document.getElementById('docket').value;
	if(m=='' && d ==''){
		sweetAlert('Please fill docket or label no ','','warning');
		e.preventDefault();
		return false;
	}
	return true;
}

function focus_box()
{
	document.input.cartonid.focus();
}
function test1()
{
	var avi=document.getElementById("bal").value;
	var qty=document.getElementById("qty").value;
	// alert(avi+"--"+qty);
	if(avi < qty)
	{
		
		sweetAlert('Enter Correct Qty','','warning');	
		document.getElementById("qty").value=avi;
	}
	
}

$(document).ready(function($){
   $('#docket,#cartonid2').keypress(function (e) {
       var regex = new RegExp("^[0-9a-z.!@#$%^&*()-=_+A-Z\]+$");
       var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
       if (regex.test(str)) {
           return true;
       }
       e.preventDefault();
       return false;
   });
});


</script>
<style>
body
{
	font-family:arial;
}

</style>
<body onload="focus_box()">
<div class='panel panel-primary'>
<!--<div class='panel-heading'>Online Barcode Scanning</div>-->
<div class='panel-body'>
<!--<div class=' text-left '><h4><span class="label label-success">T-OUT</span></h4></div>-->

<?php

	echo "<br><div class='pull-right'>
				<div><h3>
					<a href='$url'>
						<button class='equal btn btn-success'>In</button></a><Br/>
					<a href='$out_trims_scanner'>
						<button class='equal btn btn-danger'>T-Out</button></a> </h3>
				</div>
			 </div>";

if(isset($_GET['location']))
{
	$location=$_GET['location'];
	$sql="select doc_no from $bai_pro3.plandoc_stat_log where doc_no=\"".substr($location,1)."\"";
	// echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result)>0)
	{
		echo "<h2>Docket  : <span class='label label-success'>$location</span></h2>";
	}
	else
	{
		echo "<h2>Docket  : <span class='label label-danger'>Scan Valid Docket!</span></h2>";
		$location="";
	}	
}
else
{
	echo "<h2>Docket  : <span class='label label-danger'>Scan Docket!</span></h2>";
	$location="";
}


?>

<?php

if(isset($_POST['cartonid']))
{
	$code=$_POST['cartonid'];
	// echo "Code =".$code;
	$location=$_POST['location'];
	// echo "<br>Location=".$location;
	$qty_iss=$_POST["qty"];	
	// echo "<br>Qty = ".$qty_iss;
	
	if(is_numeric(substr($code,0,1)))
	{
		$sql="select doc_no,order_tid from $bai_pro3.plandoc_stat_log where doc_no=\"".substr($location,1)."\"";
		// echo "<br>".$sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result)>0)
		{
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$order_tid=$sql_row['order_tid'];
			}
			$sql1="SELECT order_style_no,order_del_no from $bai_pro3.bai_orders_db_confirm where order_tid=\"".$order_tid."\"";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$style=$sql_row1['order_style_no'];
				$schedule=$sql_row1['order_del_no'];
			}
			$code=ltrim($code,"0");
			$sql="select qty_rec,qty_issued,qty_ret,partial_appr_qty from $bai_rm_pj1.store_in where roll_status in (0,2) and tid=\"$code\"";
			// echo "<br>".$sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$qty_rec=$sql_row['qty_rec']-$sql_row['partial_appr_qty'];
				$qty_issued=$sql_row['qty_issued'];
				$qty_ret=$sql_row['qty_ret'];
			}
				
			$balance=$qty_rec-$qty_issued+$qty_ret;	
			$balance1=$qty_rec+$qty_ret-($qty_issued+$qty_iss);
			if($balance1==0)
			{
				$status=2;
			}
			else
			{
				$status=0;
			}
			
			// echo "<br>Rec =".$qty_rec."<br>Iss = ".$qty_issued."<br> Ret= ".$qty_ret;
			if((($qty_rec-($qty_iss+$qty_issued))+$qty_ret)>=0 && $qty_iss > 0)
			{
				//$sql1="update store_in set qty_issued=".(($qty_rec-$qty_issued)+($qty_ret+$qty_issued+$qty_iss)).", status=2, allotment_status=2 where tid=\"$code\"";
				$sql1="update $bai_rm_pj1.store_in set qty_issued=".($qty_issued+$qty_iss).", status=$status, allotment_status=$status where tid=\"$code\"";
				// echo "<BR>".$sql1;
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql1="insert into $bai_rm_pj1.store_out (tran_tid,qty_issued,cutno,date,updated_by,log_stamp,Style,Schedule) values (\"$code\", ".($qty_iss).", \"$location\",\"".date("Y-m-d")."\",'".$username."_online','".date("Y-m-d H:i:s")."',\"$style\",\"$schedule\")";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				echo "<h4>Status  : <span class='label label-success'>Success!</span> $code</h4>";
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"out_trims_scanner.php?location=$location\"; }</script>";
				//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"".r=$_GET['r']&."location=$location&code=$code&bal=$balance\"; }</script>";
			}
			else
			{
				echo "<h4>Status  : <span class='label label-danger'>Failed</span> $code</h4>";
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"out_trims_scanner.phplocation=$location&code=$code&bal=$balance\"; }</script>";
			}
		}
		else
		{
			echo "<h4>Status  : <span class='label label-danger'>Scan Docket!</span></h4>";
			
		}
	}
	else
	{
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"out_trims_scanner.php?location=$code\"; }</script>";
	}
}

if(isset($_POST['check2']))
{
	if($_GET["code"] == "")
	{
		$code=$_POST['cartonid2'];
	}
	else
	{
		$code=$_GET["code"];
	}
	
    if($_GET["location"] == "")
	{
		$location=$_POST['location'];
	}
	else
	{
		$location=$_GET['location'];
	}
	
	// echo $code."---".$location;
	
	$qty_iss=$_POST["qty"];	
	// echo "<br>Qty = ".$qty_iss;
	
	if(is_numeric(substr($code,0,1)))
	{
		$sql="select doc_no,order_tid from $bai_pro3.plandoc_stat_log where doc_no=\"".substr($location,1)."\"";
		// echo "<br>".$sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result)>0)
		{
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$order_tid=$sql_row['order_tid'];
			}
			$sql1="SELECT order_style_no,order_del_no from $bai_pro3.bai_orders_db_confirm where order_tid=\"".$order_tid."\"";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$style=$sql_row1['order_style_no'];
				$schedule=$sql_row1['order_del_no'];
			}
			$code=ltrim($code,"0");
			
			$sql="select qty_rec,qty_issued,qty_ret,partial_appr_qty from $bai_rm_pj1.store_in where roll_status in (0,2) and tid=\"$code\"";
			// echo "<br>".$sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$qty_rec=$sql_row['qty_rec']-$sql_row['partial_appr_qty'];
				$qty_issued=$sql_row['qty_issued'];
				$qty_ret=$sql_row['qty_ret'];
			}
				
			$balance=$qty_rec-$qty_issued+$qty_ret;	
			$balance1=$qty_rec+$qty_ret-($qty_issued+$qty_iss);
			if($balance1==0)
			{
				$status=2;
			}
			else
			{
				$status=0;
			}
			
			// echo "<br>Rec =".$qty_rec."<br>Iss = ".$qty_issued."<br> Ret= ".$qty_ret;
			if((($qty_rec-($qty_iss+$qty_issued))+$qty_ret)>=0 && $qty_iss > 0)
			{
				//$sql1="update store_in set qty_issued=".(($qty_rec-$qty_issued)+($qty_ret+$qty_issued+$qty_iss)).", status=2, allotment_status=2 where tid=\"$code\"";
				$sql1="update $bai_rm_pj1.store_in set qty_issued=".($qty_issued+$qty_iss).", status=$status, allotment_status=$status where tid=\"$code\"";
				// echo "<BR>".$sql1;
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql1="insert into $bai_rm_pj1.store_out (tran_tid,qty_issued,cutno,date,updated_by,log_stamp,Style,Schedule) values (\"$code\", ".($qty_iss).", \"$location\",\"".date("Y-m-d")."\",'".$username."_online','".date("Y-m-d H:i:s")."',\"$style\",\"$schedule\")";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				echo "<h4>Status  : <span class='label label-success'>Success!</span> $code</h4>";
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"out_trims_scanner.php?location=$location\"; }</script>";
				//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"out_trims_scanner.php?location=$location&code=$code&bal=$balance\"; }</script>";
			}
			else
			{
				echo "<h4>Status  : <span class='label label-warning'>Failed</span> $code</h4>";
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"out_trims_scanner.php?location=$location&code=$code&bal=$balance\"; }</script>";
			}
			
		}
		else
		{
			echo "<h4>Status  : <span class='label label-danger'>Scan Docket!</span></h4>";
			
		}
	}
	else
	{
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"out_trims_scanner.php?location=$code\";; }</script>";
	}
}

?>

<form name="input" method="post" action="?r=<?= $_GET['r']; ?>" enctype="multipart/form data">
<div class="row">
<!-- <input type="text" value="" name="cartonid">onkeydown="document.input.submit();" -->
<!--<textarea name="cartonid" rows="2" cols="15" onkeydown="document.input.submit();" ></textarea>-->
<div class='form-group col-md-3'>
<input type="text" name="cartonid" class='form-control integer'  onkeyup="document.input.submit();" value="" id='docket'>
<!--<input type="text" size="19" value="" onkeydown="document.input.submit();"  name="cartonid"><br/>-->
</div>
</div>
<div class="row" id='manual'>
<div class='form-group col-md-3'>
</br>Manual Entry:</br>
<input type="text" id='carton2' class='form-control alpha' size="19" value="<?php if($_GET["code"] > 0){echo $_GET["code"];} ?>"  name="cartonid2"><br/>
</div>
<?php 

if($_GET["bal"] > 0)
{
	echo "<div class='form-group col-md-3'><label>Enter Quantity:  </label><input type=\"text\" class='form-control' size=\"19\" value=".$_GET['bal']." onkeypress=\"test1()\" id=\"qty\" name=\"qty\"></div>";
}

?>

<input type="submit" name="check2" id="check_in" value="Check Out" onclick='check_docket(event)' class="btn btn-primary">
<br/><br/><input type="hidden" name="location" value="<?php echo $location; ?>">
<br/><br/><input type="hidden" id="bal" name="bal" value="<?php echo $_GET['bal']; ?>">
<!--<input type="hidden" name="check" value="check">-->
</div>
</form>

<?php


//echo "<div class='pull-right'><h2><font color=\"red\">T-Out</font></h2><br/><h2><a href='".getFullURL($_GET['r'],'index.php','N')."'><button class='btn btn-primary'>In</button></a> <Br/><a href='".getFullURL($_GET['r'],'out.php','N')."'><button class='btn btn-primary'>F-Out</button></a><Br/><a href='$out_trims_scanner'><button class='btn btn-primary'>T-Out</button></a> </h2></div>";

?>
</div></div>
</body>
</html>




