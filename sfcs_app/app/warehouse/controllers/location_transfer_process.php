<?php
	// require_once('phplogin/auth.php');
	
	//0 for 
	//1 for lock
	//2 for completed
?>

<?php $url = getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
	include($_SERVER['DOCUMENT_ROOT'].'/'.$url); 
	$plant_code = $_SESSION['plantCode'];
	$username = $_SESSION['userName'];
	?>



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
	$barcode_number=$_POST['barcode_number'];
	$ref_tid=$_POST['ref_tid'];
	$user_name=$_SESSION['SESS_MEMBER_ID'];
	$qty_rec=$_POST['qty_rec'];
	$username=getrbac_user()['uname'];	
	
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
				$sql="update $wms.store_in set ref1=\"".$n_location[$i]."\",updated_user= '".$username."',updated_at=NOW() where barcode_number='$barcode_number[$i]' and plant_code='".$plant_code."'";
				//echo $sql;
				$sql_result2=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql="insert into $wms.location_trnsf (date,source_location,new_location,tid,lot_no,remarks,old_qty,new_qty,plant_code,created_user,updated_user,updated_at,created_at) values (\"$date\",\"".$s_location[$i]."\",\"".$n_location[$i]."\",\"".$barcode_number[$i]."\",\"".$lot_no_new."\",\"".$remarks[$i]."\",".$available[$i].",".$qty_issued[$i].",'".$plant_code."',\"$username\",'".$username."',NOW(),NOW())";
//echo $sql;
				$sql_result1=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				$select_uuid="SELECT UUID() as uuid";
				$uuid_result=mysqli_query($link_new, $select_uuid) or exit("Sql Error at select_uuid".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($uuid_row=mysqli_fetch_array($uuid_result))
				{
					$uuid_main=$uuid_row['uuid'];
				
				}
				//get details from store in
				$getdetails_store_in="SELECT lot_no, ref2, ref3 ,ref4,supplier_no,four_point_status,shade_grp FROM $wms.store_in WHERE barcode_number='$barcode_number[$i]' and plant_code='".$plant_code."'";
				$sql_result_store_in=mysqli_query($link, $getdetails_store_in) or exit("Sql Error_store_in".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($details_row=mysqli_fetch_array($sql_result_store_in))
				{
				  $lot_no=$details_row['lot_no'];
				  $ref2=$details_row['ref2'];
				  $ref3=$details_row['ref3'];
				  $ref4=$details_row['ref4'];
				  $supplier_no=$details_row['supplier_no'];
				  $four_point_status=$details_row['four_point_status'];
                  $shade_grp=$details_row['shade_grp'];
				}


				$sql_main="insert into $wms.store_in (tid, lot_no, ref1, ref2, ref3, qty_rec, date, remarks,log_user,barcode_number,ref_tid,ref4,supplier_no,four_point_status,shade_grp,plant_code,created_user,updated_user,updated_at,created_at) values ('".$uuid_main."',".$lot_no.",'".$n_location[$i]."','".$ref2."','".$ref3."','".$qty_issued[$i]."','".$date."',\"Transfer-".$remarks[$i]."\",'".$username."','".$barcode_number[$i]."','".$ref_tid[$i]."','".$ref4."','".$supplier_no."','".$four_point_status."','".$shade_grp."','".$plant_code."','".$username."','".$username."',NOW(),NOW())";
		
				$sql_result=mysqli_query($link, $sql_main) or exit("Sql Error311".mysqli_error($GLOBALS["___mysqli_ston"]));

				//$new_tid=mysqli_insert_id($link);
				//To check bundle count for plant
				$bundlenumber=0;
				$checkcount="SELECT count(barcode_number) as barcodecount FROM $wms.store_in WHERE plant_code='$plantcode'";
				$sql_result12=mysqli_query($link, $checkcount) or exit("Sql Error at checkcount".mysqli_error($GLOBALS["___mysqli_ston"]));
				$count_num=mysqli_num_rows($sql_result12);
				if($count_num > 0){
					while($count_row=mysqli_fetch_array($sql_result12))
					{
						$barcodecount=$count_row['barcodecount'];
						$bundlenumber=$barcodecount+1;
					}
				} else 
				{
					$bundlenumber++;
				}
				$sql="update $wms.store_in set barcode_number='".$plant_code."-".$bundlenumber."',updated_user= '".$username."',updated_at=NOW() where tid='$uuid_main' and plant_code='".$plant_code."'";
				$sql_result2=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql="update $wms.store_in set qty_rec=".($qty_rec[$i]-$qty_issued[$i]).",updated_user= '".$username."',updated_at=NOW() where barcode_number='$barcode_number[$i]' and plant_code='".$plant_code."'";
				$sql_result2=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql="insert into $wms.location_trnsf (date,source_location,new_location,tid,lot_no,remarks,old_qty,new_qty,log_user,plant_code,created_user,updated_user,updated_at,created_at) values (\"$date\",\"".$s_location[$i]."\",\"".$n_location[$i]."\",\"".$barcode_number[$i]."\",\"".$lot_no_new."\",\"".$remarks[$i]."\",".$available[$i].",".$qty_issued[$i].",\"$username\",'".$plant_code."','".$username."','".$username."',NOW(),NOW())";
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
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",3000); function Redirect() {  location.href = '".getFullURL($_GET['r'],'location_transfer.php','N')."&lot_no=".$lot_no_new."'; }</script>";
	
}

?>


