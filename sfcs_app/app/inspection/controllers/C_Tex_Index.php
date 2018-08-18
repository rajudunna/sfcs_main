<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R')); 
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
?>

<div class="container" id='main'>
	<div class="panel panel-primary">
		<div class="panel-heading">Roll-Wise Fabric Inspection Update
		</div>
			<div class="panel-body">
				<form class="form-horizontal form-label-left" method="post" name="input2" action="<?= getFullURL($_GET['r'],'C_Tex_Index.php','N'); ?>">
				  	<div class="form-group">
				    	<label class="control-label col-md-3 col-sm-3 col-xs-12" >
				    		Enter Batch No <span class="required"></span>
				    	</label>
		    			<div class="col-md-4 col-sm-4 col-xs-12">
					      	<input type="text" id="course" name="lot_no" class="form-control col-md-3 col-xs-12 input-sm alpha">
					    </div>
					    <input type="submit" class="btn btn-primary" onclick="return check_bat();"  name="submit" value="Search">
					 </div>
				  		<div class='col-sm-12'><b class='text-center col-sm-10'>(OR)</b></div>
			  		<div class="form-group">
				    	<label class="control-label col-md-3" for="last-name">
				    		Enter Lot No<span class="required"></span>
				    	</label>
				    	<div class="col-md-4 col-sm-4 col-xs-12">
				      		<input type="text"  id="course1" name="lot_no1"  class="form-control col-md-3 col-xs-12 input-sm integer">
				    	</div>
				    	<input type="submit" class="btn btn-primary" onclick="return check_lot();" name="submit1" value="Search">
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
?>
		<form id="myForm" name="input" method="post" action="<?= getFullURL($_GET['r'],'C_Tex_Index.php','N'); ?>"
>
<?php


		$sql = "select distinct lot_no AS \"lot_ref_batch\" from $bai_rm_pj1.store_in 
				WHERE lot_no IN(select DISTINCT lot_no from $bai_rm_pj1.sticker_report WHERE batch_no=\"".trim($lot_no)."\" and product_group ='Fabric' ) 
				GROUP BY lot_no";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num_rows=mysqli_num_rows($sql_result);
		if ($num_rows != 0)
		{
			echo "<table class='table table-bordered'><tr><th><h2>Available Lots</h2></th></tr>";
			echo "<tr><th>Select All <input type='checkbox' name='check_all' id='check_all' onClick='check_all1();javascript:enableButton();'><br><br></th></tr>";
			$j=0;
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$lot_ref_batch=$sql_row['lot_ref_batch'];
				echo "<tr><th><input type=\"checkbox\" id='chk[".$j."]' name=\"lot_ref[]\" onclick='javascript:enableButton();' value=\"$lot_ref_batch\">$lot_ref_batch<br/></th></tr>";
				$j++;
			}
			echo "<input type='hidden' id='total1' value=".$j."></table>";
		}
		else
		{
			echo "<script>sweetAlert('There are no lot to update Inspection due to Segregation Not updated','','warning');</script>";
		}

		if($num_rows>0)
		{
		  	echo '<br/><br/><input type="hidden" name="lot_no" value="'.$lot_no.'">';
			echo '<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable  <input id="put" class="btn btn-primary" disabled type="submit" value="Submit" name="put" />';
		}
		 
		echo '</form>';
		}
 
 ?>
 		</div>
	</div>
</div>

<?php
if(isset($_POST['put']))
{
	$lot_no=$_POST['lot_no'];
	$lot_ref=implode(",",$_POST['lot_ref']);
	
	if($lot_ref)
	{
		
		// $url = getURL(getBASE($_GET['r'])['base'].'/C_Tex_Interface_V6.php')['url'];
		$url = getFullURL($_GET['r'],'C_Tex_Interface_V6.php','N');

		echo "<script type='text/javascript'>";
		echo "setTimeout('Redirect()',0);";
		echo "var url='".$url."&batch_no=".urlencode($lot_no)."&lot_ref=".urlencode($lot_ref)."';";
		// echo "function Redirect(){location.href=url;}</script>";
		echo "function Redirect(){ Ajaxify(url);} </script>";

	}
	else
	{
		echo 'Please select Atleast one Lot Number';
	}
}


if(isset($_POST['submit1']))
{
	$lot_no1=$_POST['lot_no1'];
	
	$sql_query = "select count(*) as count from $bai_rm_pj1.store_in where lot_no="."'".$lot_no1."'";
	$res_query = mysqli_query($link, $sql_query);
	while($sql_row=mysqli_fetch_array($res_query))
	{
		$count =$sql_row['count'];
	}
	if($count >0)
	{
		$sql="select distinct batch_no as \"batch_no\" from $bai_rm_pj1.sticker_report where lot_no=\"".trim($lot_no1)."\" and product_group ='Fabric'";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$batch_no=$sql_row['batch_no'];
		}
		$num_rows=mysqli_num_rows($sql_result);
		if ($num_rows == 0)
		{
			$sql1="select * from $bai_rm_pj1.sticker_report where lot_no=\"".trim($lot_no1)."\" and product_group not in ('Fabric')";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_rows1=mysqli_num_rows($sql_result1);
			if($num_rows1 > 0)
			{
				echo "<script>sweetAlert('You Entered Non-Fabric Lot Number','','warning')</script>";
			}
			else
			{
				 echo "<script>sweetAlert('Invalid Lot Number','','warning')</script>";
			}

			
		}else
		{
			$url = getURL(getBASE($_GET['r'])['base'].'/C_Tex_Interface_V6.php')['url'];
			

			echo "<script type='text/javascript'>";
			echo "setTimeout('Redirect()',0);";
			echo "var url='".$url."&batch_no=".urlencode($batch_no)."&lot_ref=".urlencode($lot_no1)."';";

			echo "function Redirect(){location.href=url;}</script>";
		}
	}
	else
	{

		echo "<script>sweetAlert('GRN NOT COMPLETED FOR THIS LOT NUMBER : ".$lot_no1."','','warning');</script>";
	}

}

?>

<script type="text/javascript">
function enableButton() 
{
	if(document.getElementById('option').checked)
	{
		document.getElementById('put').disabled='';
		
	} 
	else 
	{
		document.getElementById('put').disabled='true';
	}
	
	
}
function check_all1()
{
	var val1=document.getElementById("total1").value;
	if(document.getElementById("check_all").checked == true)
	{
		for(j=0;j<val1;j++)
		{
			document.getElementById("chk["+j+"]").checked=true;
		}
	}
	else
	{
		for(j=0;j<val1;j++)
		{
			document.getElementById("chk["+j+"]").checked=false;
		}
	}
}


function check_bat()
{
	var batch=document.getElementById('course').value;
	if(batch.length == 0 )
	{
		sweetAlert('Please enter Batch Number','','warning');

		return false;
	}
	else
	{
		return true;
	}
}


function check_lot()
{
	var lot=document.getElementById('course1').value;
	if(lot=='')
	{
		sweetAlert('Please enter Lot Number','','warning');

		return false;
	}
	else
	{
		return true;
	}
}

</script>