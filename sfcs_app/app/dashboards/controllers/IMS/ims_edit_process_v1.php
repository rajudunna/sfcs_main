<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<?php   
$tid=$_GET['tid']; 
$module=$_GET['module']; 
error_reporting(0);
?> 

<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
?> 


<html> 
<head> 
<title>IMS EDIT PANEL</title> 
<script src='/sfcs_app/common/js/sweetalert.min.js' ></script>
<script src='/sfcs_app/common/css/bootstrap.min.css' ></script>
<script> 
function dodisable() 
{ 
enableButton(); 


} 


function enableButton()  
{ 
    if(document.getElementById('option').checked) 
    { 
        document.getElementById('update').disabled=''; 
    }  
    else  
    { 
        document.getElementById('update').disabled='true'; 
    } 
} 

function check(x,y) 
{ 
    if(x<0) 
    { 
        swal("You cant enter a value less than 0","","warning"); 
        return 1010;  
    } 
    if((x>y)) 
    { 
        swal("Please enter correct Qty","","warning"); 
        return 1010;  
    }     
} 

</script> 


<script language=\"javascript\" type=\"text/javascript\" src='/sfcs_app/common/js/dropdowntabs.js'></script>
<link rel=\"stylesheet\" href='/sfcs_app/common/css/ddcolortabs.css' type=\"text/css\" media=\"all\" />

<script type="text/javascript"> 
    $(function() { 
        $("#date").simpleDatepicker({startdate: '2010-01-01', enddate: '2020' }); 
    }); 
</script> 

<style> 

body{ 
    font-family: arial; 
} 
</style>  

</head> 
<body onload="dodisable();"> 


<div class="panel panel-primary">
<div class="panel-heading">
     Job Transfer Panel
</div>
<div class="panel-body">
<table> 
<form name="test" action="ims_edit_process_v1_process.php" method="post"> 
<!-- <tr><td>TID</td><td>:</td><td> <?php echo $tid; ?><input type="hidden" name="tid" value="<?php // echo $tid; ?>" size="15"></td> </tr> -->
<?php 


$sql="select * from $bai_pro3.ims_log where tid=$tid"; 
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($sql_row=mysqli_fetch_array($sql_result)) 
{ 
    $ims_schedule=$sql_row['ims_schedule'];
	$ims_style=$sql_row['ims_style'];
	$ims_color=$sql_row['ims_color'];
    $ims_size=$sql_row['ims_size'];
	$ims_size2=substr($ims_size,2);

	
    $size_value=ims_sizes($order_tid,$ims_schedule,$ims_style,$ims_color,$ims_size2,$link);
	
    echo "<tr><td>Style</td><td>:</td><td>".$sql_row['ims_style']."</td></tr>"; 
    echo "<tr><td>Schedule</td><td>:</td><td>".$sql_row['ims_schedule']."</td></tr>"; 
    echo "<tr><td>Color</td><td>:</td><td>".$sql_row['ims_color']."</td></tr>"; 
    echo "<tr><td>Current Module</td><td>:</td><td>".$sql_row['ims_mod_no'].'<input type="hidden" name="current_mod" value="'.$sql_row['ims_mod_no'].'"  size="15">'."</td></tr>"; 
    echo "<tr><td>Size</td><td>:</td><td>".strtoupper($size_value)."</td></tr>"; 
    echo "<tr><td>Input Qty</td><td>:</td><td>".$sql_row['ims_qty']."</td></tr>"; 
    echo "<tr><td>Produced Qty</td><td>:</td><td>".$sql_row['ims_pro_qty']."</td></tr>"; 
     
    $allowed_qty=$sql_row['ims_qty']-$sql_row['ims_pro_qty']; 
    echo "<tr><td>Balance Qty</td><td>:</td><td>".$allowed_qty."</td></tr>"; 
} 

?> 
<tr><td>Max Allowed Qty</td><td>:</td><td> <?php echo $allowed_qty; ?> <input type="hidden" name="allow_qty" value="<?php echo $allowed_qty; ?>"  size="15"></td></tr> 
<tr><td>Enter New Qty</td><td>:</td><td> <input type="text" name="qty" value="0"  onchange="if(check(this.value, <?php echo $allowed_qty; ?>)==1010){ this.value=0;}" size="15"></td></tr> 
<tr><td>Enter New Module No</td><td>:</td><td> 
<?php
echo "<select name=\"mod\" class=\" form-control\" >";

$sql="select * from $bai_pro3.plan_modules";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" disabled selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	echo "<option value=\"".$sql_row['module_id']."\" >".$sql_row['module_id']."</option>";
}

echo "</select>";
?>
</td></tr> 
<tr><td>Remarks</td><td>:</td><td> <input type="text" name="remarks" value="nil"></td></tr> 
<?php 
echo "<tr><td><input type=\"checkbox\" name=\"option\"  id=\"option\" onclick=\"javascript:enableButton();\">Enable</td><td></td><td><INPUT TYPE = \"Submit\" Name = \"Update\" VALUE = \"Update\"></td></tr>"; 
 ?> 
</form> 
</table> 
</div> 
</div>


<!-- <div style="float:left; padding:20px;"> 
<h2>Request for New Entry</h2> 
<br/> 
<font color="red">(*)values are Compulsory.</font>  
<br/> 
<form name="test" action="ims_edit_process_v1_process.php" method="post"> 
<table> 
<tr><td>Expected Date of Completion <font color="red">(*)</font></td><td>:</td><td><input type="text" id="date" size="10" name="date" value="<?php echo date("Y-m-d"); ?>"> 

Time:<select name="time"> 
<?php 
$time=date("H"); 
//for($i=6; $i<=23; $i++) 
{ 
   // if($time==$i) 
    { 
        //echo "<option value=$i selected>$i:00</option>"; 
    } 
    //else 
    { 
        //echo "<option value=$i>$i:00</option>"; 
    } 
     
} 

?> 

</select> 


<input type="hidden" value="<?php echo $module; ?>" name="module"><input type="hidden" value="<?php echo $tid; ?>" name="tid"></td></tr> 
<tr><td>Remarks <font color="red">(*)</font></td><td>:</td><td><input type="text" name="rem" size="30"></td></tr> 
<tr><td></td><td></td><td><input type="submit" name="request" value="Request"></td></tr> 

</table> 
</form> 
</div>  -->
</body> 

</html> 