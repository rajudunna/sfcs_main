<?php  
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	$has_permission=haspermission($_GET['r']);	
?> 
<script type="text/javascript"> 
 
function check_data(i,j) 
{ 
	var fr_qty=document.getElementById("fr"+j).value;
	if(i<fr_qty)
	{
		document.getElementById(j).style.backgroundColor="red";
	}
} 
function check_stat(i,j) 
{ 
	var fr_qty=document.getElementById("fr"+j).value;
	var lfr=document.getElementById("lfr"+j).value;
	if(lfr<fr_qty)
	{
		if(i==0)
		{	
			document.getElementById(j).style.backgroundColor="red";
		}
		else
		{
			document.getElementById(j).style.backgroundColor="";
		}	
	}
}

function check_tot() 
{ 	
	var mod_list=document.getElementById("tot_mod").value;
	var status=0;
	for(var k=0;k<mod_list.length;k++)
	{		
		var lfr=document.getElementById("lfr"+k).value;
		var fr_qty=document.getElementById("fr"+k).value;
		var ln_reas=document.getElementById("line_reson"+k).value;
		if(lfr>0)
		{
			if(lfr<fr_qty)
			{
				status=1;
			}
		}
	}
	if(status==1)
	{
		sweetAlert('Please select the reasons if Forecast is less than Plan Qty!!','','warning')
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
	$mod_names=array(); 
	$sql="select * from $bai_pro3.plan_modules order by module_id*1"; 
	$result=mysqli_query($link, $sql) or exit("Sql Error8" . mysqli_error($GLOBALS["___mysqli_ston"])); 
	while($row=mysqli_fetch_array($result)) 
	{     
		$mod_names[]=$row['module_id']; 
		$sql1="SELECT * FROM bai_pro2.fr_data WHERE frdate='$today' AND team='".$row['module_id']."'"; 
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
		}     
	} 
    for($i=0;$i<sizeof($mod_names);$i++) 
    { 
 ?> 
    <tr id=<?php echo $i; ?>> 
        <td> 
		<?php echo $mod_names[$i]; ?> 
		<input type="hidden" value="0" name="module<?php echo $i; ?>" id="module<?php echo $i; ?>" value='<?php echo $mod_names[$i];  ?>'>
		<input type="hidden" value="0" name="fr_id<?php echo $i; ?>" id="fr_id<?php echo $i; ?>" value='<?php echo $frv_id[$mod_names[$i]];  ?>'>		
        </td> 
        <td> 
        <input type="hidden"  name="fr<?php echo $i; ?>" id="fr<?php echo $i; ?>" value='<?php echo $frv[$mod_names[$i]];  ?>'> 
		<?php  echo $frv[$mod_names[$i]];  ?> 
        </td> 
        <td> 
		<input type="text" value="0" class="integer" onfocus="if(this.value==0){this.value=''}" onblur="javascript: if(this.value==''){this.value=0;}" name="lfr<?php echo $i; ?>" id="lfr<?php echo $i; ?>" onchange="check_data(this.value,<?php echo $i; ?>)"> 
        </td> 
        <td>         
        <?php 
		echo "<select name='line_reson".$i."' id='line_reson".$i."' onchange='check_stat(this.value,$i)'>";
        $sql="select * from $bai_pro3.line_reason order by id*1"; 
		echo "<option value=0>-------Select Reason-------</option>";
        $result=mysqli_query($link, $sql) or exit("Sql Error8" . mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($row=mysqli_fetch_array($result)) 
        {
			echo "<option value='".$row["reason_name"]."'>".$row["reason_name"]."</option>";	
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
<div class='col-sm-3'><br>
	<input type="submit" name="submit" id="submit" value="Update" class="btn btn-primary">
	</div>	
	</div>
			
	
	<form> 
<?php
}
if(isset($_POST['update']))
{
	$daten=$_POST['daten']
	$fr_id=$_POST['fr_id']
	$fr_qty=$_POST['lfr']
	$fr_mod=$_POST['module']
	$fr_reason=$_POST['line_reson']
	
	
}
 ?> 
     



</div> 
</div> 
</div> 