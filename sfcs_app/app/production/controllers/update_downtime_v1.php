<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/config.php',3,'R'));	
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/functions.php',3,'R')); 

$sout=$_POST['sout'];
$pph=$_POST['pph'];
$team=$_POST['team'];
$section=$_POST['section'];
$dreason1=$_POST['dreason1'];
$dreason2=$_POST['dreason2'];
$dreason3=$_POST['dreason3'];

$dout1=$_POST['dout1'];
$dout2=$_POST['dout2'];
$dout3=$_POST['dout3'];

if($dout1==""){
$dout=0;
}
if($dout2==""){
$dout2=0;
}
if($dout3==""){
$dout3=0;
}



if($sout != (integer)$sout){
    echo 'not a integer';

}else{
$rest=$pph-$sout;

$dout=$dout1+$dout2+$dout3;


	$odate=date('Y-m-d');
	$otime=date('H:i');
	$ohour=date('H');
	$otime1=$time;
	//$remarks='NA';
//echo $rest.'  '.$dout;
if($rest<=$dout && $dreason1 != ""){
	//echo $dreason.' :ssss';
	
	
	$sql1="insert into $bai_pro2.hout(out_date,out_time,team,qty,status,remarks) VALUES ('$odate','$otime','$team','$sout','2','$dreason')";
	mysqli_query($link,$sql1);
	
	
	$sql2="INSERT into $bai_pro2.hourly_downtime(date,time,team,dreason,output_qty,dhour) VALUES ('$odate','$otime','$team','$dreason1','$dout1','$ohour')";
	mysqli_query($link,$sql2);
	
	
		if($dreason2 != ""){
		$sql3="INSERT into $bai_pro2.hourly_downtime(date,time,team,dreason,output_qty,dhour) VALUES ('$odate','$otime','$team','$dreason2','$dout2','$ohour')";
		mysqli_query($link,$sql3);
		}
		if($dreason3 != ""){
		$sql4="INSERT into $bai_pro2.hourly_downtime(date,time,team,dreason,output_qty,dhour) VALUES ('$odate','$otime','$team','$dreason3','$dout3','$ohour')";
		mysqli_query($link,$sql4);
		}
		
		if($dreason1=="N" || $dreason2=="N" || $dreason3=="N"){
		$sql5="UPDATE $bai_pro2.hout SET status='f' where out_date='$odate' AND out_time='$otime'";
		mysqli_query($link,$sql5);
		}
		
		
		
	
			echo "<script>swal('Successfuly Updated','Hourly Output','success');</script>"; 
?>
			
<a href="<?= getFullURLLevel($_GET['r'],'update_output.php',0,'N'); ?>&secid=<?php  echo $section;  ?>" class="btn btn-primary" style="width:30%;height:auto;">Click Here to Go Back</a>
<?php
}else{
echo "<h3 style='color:#5cb85c;'><b>Down time qty not matching with rest of pcs. Please update downtime reason</h3></b>";?>
<a href="<?= getFullURLLevel($_GET['r'],'update_output.php',0,'N'); ?>&secid=<?php  echo $section;  ?>" class="btn btn-primary" style="width:30%;height:auto;">Click Here to Go Back</a>

<?php }} ?>
	
