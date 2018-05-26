<?php
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R')); 
include("../".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 

  ?>

<script type="text/javascript">
	function pop_check()
	{
		if($('#course').val() == '' )
		{
			sweetAlert('Please enter Batch Number','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}

</script>


<title>Fabric Inspection : C-Tex Interface Search</title>

<script type="text/javascript">
	function goFurther(){
		if (document.getElementById("option").checked == true)
		{
			document.getElementById("put").disabled = false;
		}else{
			document.getElementById("put").disabled = true;
		}
	}
</script>


<body>
<?php 
?>

<div class="panel panel-primary">
<div class="panel-heading">Inspection Report</div>
<div class="panel-body">

<form method="post" name="input2" action="index.php?r=<?php echo $_GET['r']; ?>">
<div class="row">
<div class="col-md-3">
<label>Enter Batch No: </label>
<input type="text" id="course" name="lot_no" class="form-control textbox alpha" />
</div>
<input type="submit" id="submit" style="margin-top:22px;" name="submit" class="btn btn-success"  onclick='return pop_check();' value="Search">
</div>
</form>

<?php


if(isset($_POST['submit']))
{
	$lot_no=$_POST['lot_no'];
}
else
{
	$lot_no=$_GET['lot_no'];
}

?>


<?php

//Configuration
	if(strlen($lot_no)>0)
	{    
		echo '<form id="myForm" name="input" action='.getURL(getBASE($_GET['r'])['path'])['url'].'  method="post">';
		//echo "<h3>Available Lots:</h3>";
		//R in end of lot indicates rejected logt and escaped listing of the same in report.
		$sql="select distinct lot_no as \"lot_ref_batch\" from $bai_rm_pj1.sticker_report where batch_no=\"".trim($lot_no)."\" and right(trim(both from lot_no),1)<>'R'";
		// echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num_rows=mysqli_num_rows($sql_result);
		if($num_rows >0)
		{	
        echo "<h3>Available Lots:</h3>";
		}
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			
			$lot_ref_batch=$sql_row['lot_ref_batch'];
			echo "<input type=\"checkbox\" name=\"lot_ref[]\" value=\"$lot_ref_batch\">$lot_ref_batch<br/>";
		}

		if($num_rows>0)
		{
			echo '<br/><br/><input type="hidden" name="lot_no" value="'.$lot_no.'">';
			echo '<input type="checkbox" name="option" id="option" onclick="goFurther()">Enable<input type="submit"   class="btn btn-primary" id="put" name="put" value="Submit" disabled>';
			
		}
		else
		{
			echo "<script>sweetAlert('Batch number not found','','warning')</script>";
		}

		 
		echo '</form>';
	}

 
 ?>






<?php

if(isset($_POST['put']))
{
	$lot_no=$_POST['lot_no'];
	if($_POST['lot_ref'])
	{
	$lot_ref=implode(",",$_POST['lot_ref']);
	

	
	//Configuration
	if(strlen($lot_no)>0)
	{
		echo '<form id="myForm" name="input" action='.getURL(getBASE($_GET['r'])['path'])['url'].'  method="post">';
		echo "<h3>Available Lots:</h3>";
		
		//R in end of lot indicates rejected logt and escaped listing of the same in report.
		$sql="select distinct lot_no as \"lot_ref_batch\" from $bai_rm_pj1.sticker_report where batch_no=\"".trim($lot_no)."\" and right(trim(both from lot_no),1)<>'R'";
		// echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num_rows=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$lot_ref_batch=$sql_row['lot_ref_batch'];
			echo "<input type=\"checkbox\" name=\"lot_ref[]\" value=\"$lot_ref_batch\">$lot_ref_batch<br/>";
		}
		
		if($num_rows>0)
		{
			echo '<br/><br/><input type="hidden" name="lot_no" value="'.$lot_no.'">';
			echo '<input type="checkbox" name="option" id="option" onclick="goFurther()">Enable<input type="submit" class="btn btn-primary" id="put" name="put" value="Submit" disabled>';
			
		}
		 
		echo '</form>';
	}
	
	$sql="select * from $bai_rm_pj1.inspection_db where batch_ref=\"".trim($lot_no)."\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
	$inspection_check=mysqli_num_rows($sql_result);
	
	
	$sql="select *, if((length(ref5)=0 or length(ref6)=0 or length(ref3)=0 or length(ref4)=0),1,0) as \"print_check\" from $bai_rm_pj1.store_in where lot_no in ($lot_ref) order by ref2+0";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error3=".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num_rows=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		if($sql_row['print_check']==1)
		{
			$print_check=1;
		}
	}
	
	
	if($num_rows>0 and $print_check==0 and $inspection_check==1)   {echo "<h3><center><a href='".getFullURL($_GET['r'],'C_Tex_Report_Print_v2.php','R')."&lot_no=".urlencode($lot_no)."
	&lot_ref=".urlencode($lot_ref)."' onclick=\"Popup=window.open('".getFullURL($_GET['r'],'C_Tex_Report_Print_v2.php','R')."?lot_no=".urlencode($lot_no)."&lot_ref=".urlencode($lot_ref).""."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><button class='btn btn-success'>Print Report</button></a></center></h3>"; } else { echo '<h3>Please update values to Print.</h3>'; }

	
}
else{
	echo "<div class='alert alert-info'><strong>INFO! </strong>Please Select Atleast One Lot Number</div>";
}
}
?>
</div>
</div>
</body>

