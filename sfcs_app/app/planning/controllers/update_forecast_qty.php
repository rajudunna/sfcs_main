<?php  
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	$has_permission=haspermission($_GET['r']);	
?> 
<script type="text/javascript"> 
 
function check_data(i,j) 
{
	var fr_qty=Number(document.getElementById("fr"+j).value);
	var val1=Number(i);
	if(val1>0)
	{
		if(val1<fr_qty)
		{
			document.getElementById("row_val"+j).style.backgroundColor="red";
		}
		else
		{
			document.getElementById("row_val"+j).style.backgroundColor="";
		}
	}
	else
	{
		document.getElementById("row_val"+j).style.backgroundColor="";
	}		
} 
function check_stat(i,j) 
{
	var fr_qty=Number(document.getElementById("fr"+j).value);
	var lfr=Number(document.getElementById("lfr"+j).value);
	var lfr_ori=Number(document.getElementById("lfr_ori"+j).value);
	if (i=='NIL' )
	{
		document.getElementById("lfr"+j).value = lfr_ori;
		document.getElementById("row_val"+j).style.backgroundColor="";
	}
	else
	{
		if(lfr<fr_qty)
		{
			if(i=='NIL')
			{	
				document.getElementById("row_val"+j).style.backgroundColor="red";
			}
			else
			{
				document.getElementById("row_val"+j).style.backgroundColor="";
			}	
		}
	}
}

function check_tot() 
{ 	
	var mod_list=Number(document.getElementById("tot_mod").value);
	var status=0;
	var checkn=1;
	for(var k=0;k<mod_list;k++)
	{		
		var lfr=Number(document.getElementById("lfr"+k).value);
		var fr_qty=Number(document.getElementById("fr"+k).value);
		var ln_reas=document.getElementById("line_reson"+k).value;

		if(lfr>0)
		{
			if(lfr<fr_qty)
			{
				if(ln_reas=='NIL')
				{

					status=1;
				}
			}
			checkn=0;
		}
	}	
	if(checkn==1)
	{
		sweetAlert('Please Fill Any module Forecast!','','warning');
		return false;
	}
	else if(status==1)
	{
		sweetAlert('Please select the reasons if Forecast is less than Plan Qty!!','','warning');
		return false;
	}
	else if(status==0)
	{
		return true;
	}
	
}  

 </script> 


<link href="back_end_style.css" rel="stylesheet" type="text/css" media="all" /> 
</head> 

<body> 
<div class="panel panel-primary"> 
<div class="panel-heading">Module Wise Forecast Qty Details</div> 
<div class="panel-body"> 

<form method="POST" action="#"> 
<table class="table table-bordered"> 
<div class="form-group col-sm-3">
<label for="date">Date: </label>
						<input type="text" id="date" data-toggle="datepicker" name="date" class="form-control" value="<?php  if(isset($_POST['date'])) { echo $_POST['date']; } else { echo date("Y-m-d"); } ?>"  required> 
</div>
<div class='col-sm-3'>
						<br>
						<input type="submit" name="submit" id="submit" value="Show" class="btn btn-primary">
					</div>
				</form>	
<?php
if(isset($_POST['submit']))
{
	$today=$_POST['date'];
?>			
<form method="POST" action="#" onsubmit="return check_tot()"> 
	<div style="width:500px;margin-left:auto;margin-right:auto;"> 
	<div class="row"> 
	<div class="col-md-1"></div> 
	<div class="col-md-8" style='max-height:600px;overflow-y:scroll;'> 
		<table class="table table-bordered"> 
		<tr> 
		<th> Module </th> 
		<th> FR Plan </th> 
		<th> Quantity (Forcast) </th> 
		<th> Reason </th> 
		</tr> 
<?php  
	$frv=array(); 
	$frv_id=array(); 
	$mod_names=array(); 
	$sql="select * from $bai_pro3.plan_modules GROUP BY module_id order by module_id*1 "; 
	//echo $sql;
	$result=mysqli_query($link, $sql) or exit("Sql Error8" . mysqli_error($GLOBALS["___mysqli_ston"])); 
	while($row=mysqli_fetch_array($result)) 
	{     
		$mod_names[]=$row['module_id']; 
		$sql1="SELECT *,SUM(fr_qty) AS qty FROM $bai_pro2.fr_data WHERE frdate='$today' AND team='".$row['module_id']."'"; 
		//echo $sql1;
		$result1=mysqli_query($link, $sql1) or exit("Sql Error" . mysqli_error($GLOBALS["___mysqli_ston"])); 
		if(mysqli_num_rows($result1)) 
		{ 
			while($row1=mysqli_fetch_array($result1))
			{				
				$frv[$row['module_id']]=$row1['qty'];
				$frv_id[$row['module_id']]=$row1['fr_id'];
			}			
		} 
		else 
		{ 
			$frv[$row['module_id']]=0;
			$frv_id[$row['module_id']]=0;			
		} 
		$sql12="SELECT * FROM $BAI_PRO3.line_forecast WHERE date='$today' AND module='".$row['module_id']."'"; 
		$result12=mysqli_query($link, $sql12) or exit("Sql Error" . mysqli_error($GLOBALS["___mysqli_ston"])); 
		if(mysqli_num_rows($result12)) 
		{ 
			while($row12=mysqli_fetch_array($result12))
			{				
				$lfr_qty[$row['module_id']]=$row12['qty'];
				$lfr_reason[$row['module_id']]=$row12['reason'];
			}			
		} 
		else 
		{ 
			$lfr_qty[$row['module_id']]=0;
		}	
	} 
    for($i=0;$i<sizeof($mod_names);$i++) 
    { 

 ?> 
    <tr id="row_val<?php echo $i; ?>"> 
        <td> 
		<?php echo $mod_names[$i]; ?> 
		<input type="hidden" value="<?php echo $mod_names[$i]; ?>" name="module[<?php echo $i; ?>]" id="module<?php echo $i; ?>" value='<?php echo $mod_names[$i];  ?>'>
		<input type="hidden" value="<?php echo $frv_id[$mod_names[$i]];  ?>" name="fr_id[<?php echo $i; ?>]" id="fr_id<?php echo $i; ?>">		
        </td> 
        <td> 
        <input type="hidden" name="fr[<?php echo $i; ?>]" id="fr<?php echo $i; ?>" value='<?php echo $frv[$mod_names[$i]];  ?>'> 
		<?php  echo $frv[$mod_names[$i]];  ?> 
        </td> 
        <td> 
		<input type="text" value="<?php echo $lfr_qty[$mod_names[$i]]; ?>" class="integer form-control" onfocus="if(this.value==0){this.value=''}" onblur="javascript: if(this.value==''){this.value=0;}" name="lfr[<?php echo $i; ?>]" id="lfr<?php echo $i; ?>" onchange="check_data(this.value,<?php echo $i; ?>)"> 
		<input type="hidden" value="<?php echo $lfr_qty[$mod_names[$i]]; ?>" name="lfr_ori[<?php echo $i; ?>]" id="lfr_ori<?php echo $i; ?>">
        </td> 
        <td>         
        <?php 
		echo "<select name='line_reson[".$i."]' class='form-control' id='line_reson".$i."' onchange='check_stat(this.value,$i)'>";
        $sql="select * from $bai_pro3.line_reason order by id*1"; 
		echo "<option value='NIL'>Select Reason</option>";
        $result=mysqli_query($link, $sql) or exit("Sql Error8" . mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($row=mysqli_fetch_array($result)) 
        {
        	if ($lfr_reason[$mod_names[$i]] == $row["reason_name"])
        	{
        		$selected = 'selected';
        	} else {
        		$selected = '';
        	}
			echo "<option value='".$row["reason_name"]."' $selected>".$row["reason_name"]."</option>";	
        } 
		echo "</select>";
        ?> 
        </td>              
	</tr> 
	
<?php 
	}
?>
	</table>
	<input type="hidden" value="<?php echo sizeof($mod_names); ?>" name="tot_mod" id="tot_mod">
	<input type="hidden" value="<?php echo $today; ?>" name="daten" id="daten">
	<?php
	if(array_sum($lfr_qty)==0 || in_array($update,$has_permission))
	{
		?>
		<div class='col-sm-3'><br>
		<input type="submit" name="update" id="update" value="Update" class="btn btn-primary">
		</div>	
		<?php
	}
	?>	
	
	</div>
			
	
	<form> 
<?php
}
if(isset($_POST['update']))
{
	$daten=$_POST['daten'];
	$fr_id=$_POST['fr_id'];
	$fc_qty=$_POST['lfr'];
	$fr_qty=$_POST['fr'];
	$fr_mod=$_POST['module'];
	$fr_reason=$_POST['line_reson'];
	for($i=0;$i<sizeof($fr_mod);$i++)
	{
		if($fr_qty[$i]>0 || $fc_qty[$i]>0)
		{
			$sql1="select * from  $bai_pro3.`line_forecast` where date='$daten' and module='$fr_mod[$i]'";
			$result1=mysqli_query($link, $sql1) or exit("Sql Error8" . mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows=mysqli_num_rows($result1);
			if($rows==0)
			{
				$sql="INSERT IGNORE INTO $bai_pro3.`line_forecast` (`forcast_id`, `module`, `qty`, `date`, `reason`) VALUES ('$fr_id[$i]', '$fr_mod[$i]', '$fc_qty[$i]', '$daten', '$fr_reason[$i]')";
				//echo $sql."<br>";
				$result=mysqli_query($link, $sql) or exit("Sql Error8" . mysqli_error($GLOBALS["___mysqli_ston"]));
				
			}
			else
			{
				$sql="update $bai_pro3.`line_forecast` set qty ='$fc_qty[$i]', reason ='$fr_reason[$i]' where module ='$fr_mod[$i]' and  date ='$daten'";
				//echo $sql."<br>";
				$result=mysqli_query($link, $sql) or exit("Sql Error8" . mysqli_error($GLOBALS["___mysqli_ston"]));	
				
			}
			
		}
	}
	echo "<script>sweetAlert('Successfully Forecast Updated.','','success');</script>";
}
 ?> 
     



</div> 
</div> 
</div> 
<script type="text/javascript">
	$('[data-toggle="datepicker"]').datepicker({
	format: 'yyyy-mm-dd',
	endDate: new Date()
});
</script>