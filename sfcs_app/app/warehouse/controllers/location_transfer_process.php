<?php
	// require_once('phplogin/auth.php');
	
	//0 for 
	//1 for lock
	//2 for completed
?>

<?php $url = getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
	include($_SERVER['DOCUMENT_ROOT'].'/'.$url); ?>



<?php

if($_POST['put'])
{
	$date=date("Y-m-d");
	$qty_issued=$_POST['qty_issued'];
	$n_location=$_POST['n_location'];
	$s_location=$_POST['s_location'];
	$remarks=$_POST['remarks'];
	$tid=$_POST['tid'];
	$available=$_POST['available'];
	$lot_no_new=$_POST['lot_no'];
	$user_name=$_SESSION['SESS_MEMBER_ID'];
	$qty_rec=$_POST['qty_rec'];
	
	//echo sizeof($qty_issued);
	
	for($i=0; $i<sizeof($qty_issued); $i++)
	{
		//echo $qty_issued[$i]."<br/>";
		//echo $n_location[$i]."<br/>";
		//echo $s_location[$i]."<br/>";
		//echo strcasecmp($n_location[$i],$s_location[$i])."<br/>";
		
		if($qty_issued[$i]>0 and (strcasecmp($n_location[$i],$s_location[$i])!=0) and $n_location[$i]!="0")
		{
			//echo "ok";
			if($available[$i]==$qty_issued[$i])
			{
				$sql="update $bai_rm_pj1.store_in set ref1=\"".$n_location[$i]."\" where tid=".$tid[$i];
				//echo $sql;
				$sql_result2=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql="insert into $bai_rm_pj1.location_trnsf (date,source_location,new_location,tid,lot_no,remarks,old_qty,new_qty,log_user) values (\"$date\",\"".$s_location[$i]."\",\"".$n_location[$i]."\",\"".$tid[$i]."\",\"".$lot_no_new."\",\"".$remarks[$i]."\",".$available[$i].",".$qty_issued[$i].",USER())";
//echo $sql;
				$sql_result1=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				$sql="insert into $bai_rm_pj1.store_in (lot_no, ref1, ref2, ref3, qty_rec, date, remarks,log_user) select lot_no,\"".$n_location[$i]."\",ref2,ref3,".$qty_issued[$i].",\"$date\",\"Transfer-".$remarks[$i]."\",\"$user_name\" from $bai_rm_pj1.store_in where tid=".$tid[$i];
//echo $sql;
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql="update $bai_rm_pj1.store_in set qty_rec=".($qty_rec[$i]-$qty_issued[$i])." where tid=".$tid[$i];
				//echo $sql;
				$sql_result2=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql="insert into $bai_rm_pj1.location_trnsf (date,source_location,new_location,tid,lot_no,remarks,old_qty,new_qty,log_user) values (\"$date\",\"".$s_location[$i]."\",\"".$n_location[$i]."\",\"".$tid[$i]."\",\"".$lot_no_new."\",\"".$remarks[$i]."\",".$available[$i].",".$qty_issued[$i].",USER())";
//echo $sql;
				$sql_result1=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				
			}
		}
	}
	if ($sql_result1==1)
	{
		echo '<div class="alert alert-success"> <strong>Success!</strong> Successfully Updated the Location.</div>';
	}
	if ($sql_result1==0)
	{
		echo '<div class="alert alert-danger">  <strong>Warning!</strong> No Location Transfer Done.</div>';
	}
	echo '<br><br><div class="alert alert-warning"> <strong>Please Wait!</strong> You Will be Redirected Back...	</div>';
	$rurl = getFullURL($_GET['r'],'location_transfer.php','N')."&lot_no=".$lot_no_new;
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",3000); function Redirect() {  
		Ajaxify('".$rurl."');
	 }</script>";
	
}

?>


