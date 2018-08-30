<!DOCTYPE html>
<?php
//load the database configuration file
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/config.php',3,'R'));	
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/functions.php',3,'R'));  
 
?>
<html lang="en">
<head>

</head>
<body>
<div class="panel panel-primary">
<div class="panel-heading">Hourly Production Output Reporting</div>
<div class="panel-body">

   <?php
   //Starting get process for hourly efficiency report through FR Plan.
   $frdate=date("Y-m-d");
   
 

   $sql="SELECT * FROM $bai_pro3.sections_db WHERE sec_id !='0'";
   $res=mysqli_query($link,$sql); 
	$i=0;
    while($row=mysqli_fetch_array($res)){
	$section=$row['sec_id'];
   ?>
  <div class="col-sm-3"><a href="<?= getFullURLLevel($_GET['r'],'update_output.php',0,'N');?>&secid=<?php  echo $section;  ?>" class="btn btn-info" style="width:90%;height:auto;"><b style="font-size:30px;"><?php echo 'Section '.$section;  ?></b></a></div>
 <!--  onclick="Popup=window.open('update_output.php?secid=<?php // echo $section;  ?>','Popup','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=700, top=23')"-->
  <?php 
	$i++;
	if($i%3==0){
	echo '<br><br><br><br>';
	}

  }  ?>
</div>
</div>

</body>
</html>
