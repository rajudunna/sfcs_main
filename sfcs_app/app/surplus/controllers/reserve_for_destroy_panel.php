<?php
	
	include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
	include('../'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
	
	// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
	// $username=strtolower($username_list[1]);
	// $view_access=user_acl("SFCS_0176",$username,1,$group_id_sfcs);

?>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',3,'R'); ?>"></script>

<style>

input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}

th,td{
	color : #000;
}

#div-1a {
 position:absolute;
 top:50px;
 right:0;
 width:auto;
float:right;
}
</style>


<script>

function enable_button(x)
{
	var checkedStatus = document.getElementById("enable").checked;
	var check;
	var location;
	
	check=true;

	for(i=0;i<x;i++)
	{	
		if(document.getElementById("int_dest_qty["+i+"]").value>0)
		{	
			location=document.getElementById("intdes_location["+i+"]").value;
			rsvlocation=document.getElementById("location["+i+"]").value;	
			if(location.length==0 || rsvlocation.length==0)
			{
				sweetAlert("Please enter valid locations.","","info");
				check=false;
				document.getElementById("add").disabled=true;
				document.getElementById("enable").checked=false;
				break;
			}			
		}
		
		if((parseInt(document.getElementById("int_dest_qty["+i+"]").value)+parseInt(document.getElementById("res_dest_qty["+i+"]").value))>parseInt(document.getElementById("qty["+i+"]").value))
		{
			sweetAlert("Enter Correct Value Line Item "+(i+1));
			check=false;
			document.getElementById("res_dest_qty["+i+"]").value=0;
			document.getElementById("add").disabled=true;
			document.getElementById("enable").checked=false;
		}
	}	
	

	if(checkedStatus===true && check==true)
	{
		document.getElementById("add").disabled=false;
	}
	else
	{
		document.getElementById("add").disabled=true;
		
	}
}

function validate(value,x)
{
	
	if(parseInt(document.getElementById("int_dest_qty["+x+"]").value)+parseInt(value)>parseInt(document.getElementById("qty["+x+"]").value))
	{
		sweetAlert("Enter Correct Value");
		document.getElementById("res_dest_qty["+x+"]").value=0;
		sweetAlert("Enter Correct Value Line Item "+(x+1));
		check=false;
		document.getElementById("res_dest_qty["+i+"]").value=0;
		document.getElementById("add").disabled=true;
		document.getElementById("enable").checked=false;
	}
}

function verify_nums(t){
	var c = /^[0-9]+$/;
	var id = t.id;
	var qty = document.getElementById(id);
	
	if(qty.value.match(c)){
		
	}else{
		if(qty.value == ''){

		}else{
			sweetAlert('Please Enter Only Numbers','','warning');
			qty.value = '';
		}
		return false;
	}
}

</script>


<div class="panel panel-primary">
<div class="panel-heading">Reserve for Audit/Internal Destroy</div>
<div class="panel-body">
<div class="">

<body>

<form name="filter" method="post" action="">

	<div class='col-md-3'>
		<label>Schedules:</label> 
		<input type="text" value="" class="form-control integer" name="schlist">
	</div>
	<div class='col-md-3 '>
		<label></label><br/>
		<input type="submit" name="schsbt" class="btn btn-success" value="Filter">
	</div>
	
</form>

<?php

if(isset($_POST['confirm'])){
		
	$tid=$_POST['tid'];
	$location=$_POST['location'];
	$org_qty=$_POST['qty'];
	$qty=$_POST['res_dest_qty'];
	$int_dest_qty=$_POST['int_dest_qty'];
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$size=$_POST['size'];
	$ref1=$_POST['ref1'];
	$intdes_location=$_POST['intdes_location'];
	// var_dump($qty);
	// die();
	$bool_flag = false;
	// foreach ($qty as $key => $value) {
	// 	if($value >= 0 || $int_dest_qty[$key] >= 0){
	// 		$flag = true;
	// 		break;
	// 	}
	// }
	for($i=0;$i<sizeof($tid);$i++)
	{
		 //Allow entry, if total line wants to do internal destroy.
		// echo "Length=".strlen($location[$i])."/".$location[$i]."//".$intdes_location[$i]."/".strlen($intdes_location[$i])."<br>";
		if(strlen($location[$i])>0 or strlen($intdes_location[$i])>0)
		{			
			//echo "<br>True=".$int_dest_qty[$i]."-".$qty[$i]."-".$intdes_location[$i]."-".strlen($intdes_location[$i])."-".$location[$i]."-".strlen($location[$i])."<br><br>";
			
			//$sql="update bai_qms_db set location_id='RESRV4DES' where qms_tid in (".$tid[$i].")";
			if(($org_qty[$i]-($qty[$i]+$int_dest_qty[$i])) > 0)
			{
				//$sql="update bai_qms_db set qms_qty=qms_qty-(".$qty[$i]."+".$int_dest_qty[$i].") where qms_tid in (".$tid[$i].")";
				//echo "1.".$sql."<br/><br>";
				//mysql_query($sql,$link) or exit("Sql Error:$sql".mysql_error());
			}

			if($int_dest_qty[$i]>0 and $qty[$i]==(($qty[$i]-$int_dest_qty[$i])+$int_dest_qty[$i]) and strlen($intdes_location[$i])>0)
			{
				if($int_dest_qty[$i]<$qty[$i])
				{
					$sql="insert into $bai_pro3.bai_qms_db(qms_style,qms_schedule,qms_color,log_user,log_date,qms_size,qms_qty,qms_tran_type,ref1) values('".$style[$i]."','".$schedule[$i]."','".$color[$i]."','".$username."','".date("Y-m-d")."','".$size[$i]."','".($qty[$i])."',12,'".$tid[$i]."')";
					//echo "2.".$sql."<br/>";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
			
					$sql="update $bai_pro3.bai_qms_db set location_id='".$location[$i]."' where qms_tid=$iLastid";
					//echo "<br>3.".$sql."<br>";
					mysqli_query($link, $sql) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$sql3="select location_id from $bai_pro3.bai_qms_db where qms_tid=".$tid[$i]."";
					//echo "</br>4".$sql3."<br>";
					$result3=mysqli_query($link, $sql3) or exit("Sql Error1".$sql3."-".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row3=mysqli_fetch_array($result3))
					{
						$location_ref_id=$row3["location_id"];
					}
					
					$sql2="UPDATE $bai_pro3.bai_qms_location_db SET qms_cur_qty=qms_cur_qty-".$qty[$i]." WHERE qms_location_id='".$location_ref_id."'";
					//echo "<br>23.".$sql2."<br>";
					mysqli_query($link, $sql2) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					/*$sql2="UPDATE bai_qms_location_db SET qms_cur_qty=qms_cur_qty+".$qty[$i]." WHERE qms_location_id='".$location[$i]."'";
					echo "<br>23.".$sql2."<br>";
					mysql_query($sql2,$link) or exit("Sql Error$sql".mysql_error());*/
				}
				
				//INTDESTROY
				$sql="insert into $bai_pro3.bai_qms_db(qms_style,qms_schedule,qms_color,log_user,log_date,qms_size,qms_qty,qms_tran_type,ref1) values('".$style[$i]."','".$schedule[$i]."','".$color[$i]."','".$username."','".date("Y-m-d")."','".$size[$i]."','".$int_dest_qty[$i]."',13,'".$tid[$i]."')";
				//echo "<br>3.".$sql."<br/>";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$iLastid2=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
				
				$sql="update $bai_pro3.bai_qms_db set location_id='".$intdes_location[$i]."' where qms_tid=$iLastid2";				
				//echo "<br>4.".$sql."<br/>";
				mysqli_query($link, $sql) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql3="select location_id from $bai_pro3.bai_qms_db where qms_tid=".$tid[$i]."";
				$result3=mysqli_query($link, $sql3) or exit("Sql Error1".$sql3."-".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row3=mysqli_fetch_array($result3))
				{
					$location_ref_id=$row3["location_id"];
				}
				
				$sql2="UPDATE $bai_pro3.bai_qms_location_db SET qms_cur_qty=qms_cur_qty-".$int_dest_qty[$i]." WHERE qms_location_id='".$location_ref_id."'";
				//echo "<br>23.".$sql2."<br>";
				mysqli_query($link, $sql2) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				/*$sql="UPDATE bai_qms_location_db SET qms_cur_qty=qms_cur_qty+".$int_dest_qty[$i]." WHERE qms_location_id='".$intdes_location[$i]."'";
				echo "<br>23.".$sql."<br>";
				mysql_query($sql,$link) or exit("Sql Error$sql".mysql_error());*/
				
			}
			else
			{
				if(strlen($location[$i])>0)
				{					
					$sql="insert into $bai_pro3.bai_qms_db(qms_style,qms_schedule,qms_color,log_user,log_date,qms_size,qms_qty,qms_tran_type,ref1) values('".$style[$i]."','".$schedule[$i]."','".$color[$i]."','".$username."','".date("Y-m-d")."','".$size[$i]."','".$qty[$i]."',12,'".$tid[$i]."')";
					//echo "<br>5.".$sql."<br/>";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));								
					
					$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
				
					$sql="update $bai_pro3.bai_qms_db set location_id='".$location[$i]."' where qms_tid=$iLastid";
					//echo "<br>6.".$sql."<br/>";
					mysqli_query($link, $sql) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$sql3="select location_id from $bai_pro3.bai_qms_db where qms_tid=".$tid[$i]."";
					//echo $sql3."<br>";
					$result3=mysqli_query($link, $sql3) or exit("Sql Error1".$sql3."-".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row3=mysqli_fetch_array($result3))
					{
						$location_ref_id=$row3["location_id"];
					}
					
					$sql2="UPDATE $bai_pro3.bai_qms_location_db SET qms_cur_qty=qms_cur_qty-".$qty[$i]." WHERE qms_location_id='".$location_ref_id."'";
					//echo "<br>23.".$sql2."<br>";
					mysqli_query($link, $sql2) or exit("Sql Error$sql2 $i".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					
					/*$sql2="UPDATE bai_qms_location_db SET qms_cur_qty=qms_cur_qty+".$qty[$i]." WHERE qms_location_id='".$location[$i]."'";
					echo "<br>23.".$sql2."<br>";
					mysql_query($sql2,$link) or exit("Sql Error$sql".mysql_error());*/
				}				
			}		
			
		}
		else
		{
			// echo "<br>Qty=".$qty[$i]."<br>";
			if($qty[$i]==0 && $qty[$i]!="")
			{
				$sql="update $bai_pro3.bai_qms_db set location_id='RESRV4DES' where qms_tid in (".$tid[$i].")";
				//echo "<br>Update : .".$sql."<br/>";
				mysqli_query($link, $sql) or exit("Sql Error:$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
		}
	}
	echo "<script>sweetAlert('Successfully','Updated','success')</script>";
}

?>

<?php

if(isset($_POST['schsbt']))
{
	$row_count = 0;
	$schlist=$_POST['schlist'];
	$showall=$_POST['showall'];
	if($schlist!=''){
	$addfilter="qms_schedule in ($schlist) and ";
	if($showall=="1")
	{
		$addfilter="";
	}


	if(strlen($schlist)>0 or $showall=="1")
	{

	echo '<form name="update" method="post" action="'.getURL(getBASE($_GET['r'])['path'])['url'].'">';

	//Serial number and Post variable index key
	$x=0;

	$location_id=array();
	$location_title=array();
	$location_id[]="";
	$location_title[]="";

	$location_id1=array();
	$location_title1=array();
	$location_id1[]="";
	$location_title1[]="";

	//Enabling maximum capacity restriction
	$sql="select * from $bai_pro3.bai_qms_location_db where location_type=1 and active_status=0 
			and qms_cur_qty < qms_location_cap order by qms_cur_qty desc,order_by desc";
	//$sql="select * from bai_qms_location_db where location_type=1 and active_status=0 order by qms_cur_qty desc,order_by desc";
	// echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{	
		$location_id[]=$sql_row['qms_location_id'];
		$location_title[]=$sql_row['qms_location_id']."-".$sql_row['qms_cur_qty'];
	}

	$sql1="select * from $bai_pro3.bai_qms_location_db where location_type=0 and qms_location_id like 'INT%'and active_status=0 and qms_cur_qty<qms_location_cap order by qms_location_id,qms_cur_qty desc,order_by desc";
	// echo "<br><br>".$sql;
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{	
		$location_id1[]=$sql_row1['qms_location_id'];
		$location_title1[]=$sql_row1['qms_location_id']."-".$sql_row1['qms_cur_qty'];
	}

	$sql="
	select * from ((select 
	ref1,
	SUM(IF((qms_tran_type= 1 and location_id<>'RESRV4DES' and location_id<>'PAST_DATA'),qms_qty,0)) as goodpanels,
	(
	SUM(IF((qms_tran_type= 1 and location_id<>'RESRV4DES' and location_id<>'PAST_DATA'),qms_qty,0))
	-SUM(IF((qms_tran_type= 2 and location_id<>'RESRV4DES' and location_id<>'PAST_DATA'),qms_qty,0))
	-SUM(IF((qms_tran_type= 10 and location_id<>'RESRV4DES' and location_id<>'PAST_DATA'),qms_qty,0))
	
	) as qms_qty,qms_style,qms_schedule,qms_color,qms_size,group_concat(qms_tid) as qms_tid,location_id, group_concat(concat(location_id,'-',if(qms_tran_type<>1 and location_id<>'RESRV4DES' and location_id<>'PAST_DATA',qms_qty,'N/A'),' PCS<br/>')) as existing_location, 1 as qms_tran_type from $bai_pro3.bai_qms_db where $addfilter qms_tran_type in (1,2,10) and location_id<>'RESRV4DES' and location_id<>'PAST_DATA' GROUP BY CONCAT(qms_schedule,qms_color,qms_size) )
	
	union
	(select
	ref1,
	IF((qms_tran_type= 1 and location_id<>'RESRV4DES' and location_id<>'PAST_DATA'),qms_qty,0) as goodpanels,

	qms_qty as qms_qty,qms_style,qms_schedule,qms_color,qms_size,qms_tid as qms_tid,location_id, concat(location_id,'-',if(location_id<>'RESRV4DES' and location_id<>'PAST_DATA',qms_qty,'N/A'),' PCS<br/>') as existing_location, qms_tran_type from $bai_pro3.bai_qms_db where $addfilter qms_tran_type in (3,5) and length(location_id)>0 and location_id<>'RESRV4DES' and location_id<>'PAST_DATA')) as t order by qms_schedule,qms_color,qms_size LIMIT 0,10";
	// echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count_res = mysqli_num_rows($sql_result);
	// echo $count_res;
	if($count_res>0){
	$table ="<br/><div class='table-responsive' style='overflow:scroll;max-height:700px' id='table'>";	
	$table.=" <table class='table table-bordered' id='table1'>";
	$table.="<thead>";
	$table.="<tr class='success'>";
	$table.='<th>SNo</th>';
	$table.="<th>Style</th>";
	$table.="<th>Schedule</th>";
	$table.="<th>Color</th>";
	$table.="<th>Size</th>";
	$table.="<th>Available Quantity</th>";
	$table.="<th>Internal Destory Qty</th>";
	$table.="<th>Internal Destory Location</th>";
	$table.="<th>Transaction Type</th>";
	$table.="<th>Existing Locations</th>";
	$table.="<th>Reserved Quantity</th>";
	$table.="<th>Offer for Audit <br/> Location</th>";
	$table.="</tr>";
	$table.="</thead><tbody>";
	echo $table;

	
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		//echo $sql_row['qms_qty']."<br>";
		if($sql_row['qms_qty']>=0)
		{
			$sql2="select COALESCE(SUM(qms_qty),0) as qty from $bai_pro3.bai_qms_db where qms_tran_type in (12,13) and ref1='".$sql_row['qms_tid']."'";
			//echo $sql2."<br>";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$row_count++;
				$resr_qty=$sql_row2["qty"];
			}
			
			if(($sql_row['qms_qty']-$resr_qty) > 0)
			{
				$table="<tr class='foo' id='rowchk$x'>";
				$table.="<td>".($x+1)."</td>";
				$table.="<td>".$sql_row['qms_style']."</td>";
				$table.="<td>".$sql_row['qms_schedule']."</td>";
				$table.="<td>".$sql_row['qms_color']."</td>";
				$table.="<td>".$sql_row['qms_size']."</td>";
				
				$table.="<td>".($sql_row['qms_qty']-$resr_qty)."<input type='hidden' name='qty[$x]' id='qty[$x]'  value='".($sql_row['qms_qty']-$resr_qty)."' onchange='if(this.value<0 || this.value>".($sql_row['qms_qty']-$resr_qty).") { this.value=0; sweetAlert('Please enter correct value','','warning'); }'></td>";
				
				$table.="<td bgcolor='FF7777'><input type='text' class='float' size='10' name='int_dest_qty[$x]' id='int_dest_qty[$x]' 
						  value='0' 
						   onkeyup='if(this.value<0 || this.value>".($sql_row['qms_qty']-$resr_qty).") { this.value=0; sweetAlert('Please enter correct value','','warning');  }'></td>";
				$table.="<td bgcolor='FF7777'><select name=intdes_location[$x] id=intdes_location[$x]>";
				for($i=0;$i<sizeof($location_id1);$i++)
				{
					$table.="<option value='".$location_id1[$i]."'>".$location_title1[$i]."</option>";
				}
				$table.="</select></td>";
				
				$title="";
				switch($sql_row['qms_tran_type'])
				{
					case 1:
					{
						$title="Panel Form - Filtered";
						break;
					}
					case 3:
					{
						$title="Rejections";
						break;
					}
					case 5:
					{
						$title="Surplus Garments-".$sql_row['ref1'];
						break;
					}
				}
				
				$table.="<td>".$sql_row['qms_tran_type']."-".$title."</td>";
				if($sql_row['qms_qty']==0)
				{
					$table.="<td>N/A</td>";
					$table.="<td bgcolor='FF7777'><input type='text' class='float' size='7' name='res_dest_qty[$x]' id='res_dest_qty[$x]' value='0' onchange='validate(this.value,$x)' { this.value=0; sweetAlert('Please enter correct value','','warning'); }'></td>";
					$table.="<td>To Empty Exsting Location<select name=location[$x] id=location[$x] onchange='enable_button(".$x.")' disabled style='visibility: hidden'>";
						for($i=0;$i<sizeof($location_id);$i++)
						{
							$table.="<option value='".$location_id[$i]."'>".$location_title[$i]."</option>";
						}
					$table.="</select><input type='hidden' name='tid[$x]' id='tid[$x]' value='".$sql_row['qms_tid']."'>
						<input type='hidden' name='style[$x]' id='style[$x]' value='".$sql_row['qms_style']."'>
						<input type='hidden' name='schedule[$x]' id='schedule[$x]' value='".$sql_row['qms_schedule']."'>
						<input type='hidden' name='color[$x]' id='color[$x]' value='".$sql_row['qms_color']."'>
						<input type='hidden' name='size[$x]' id='size[$x]' value='".$sql_row['qms_size']."'>
						<input type='hidden' name='ref1[$x]' id='ref1[$x]' value='".$sql_row['ref1']."'>
							</td>";
				}
				else
				{
					$table.="<td>".$sql_row['existing_location']."</td>";
					$table.="<td bgcolor='FF7777'><input type='text' class='float' size='7' name='res_dest_qty[$x]' id='res_dest_qty[$x]' value='0' onkeyup='validate(this.value,$x)' { this.value=0; sweetAlert('Please enter correct value','','warning'); }'></td>";
					$table.="<td bgcolor='#33FF99'><select onchange='enable_button(".$x.")' name='location[$x]' id='location[$x]'>";
					for($i=0;$i<sizeof($location_id);$i++)
					{
						$table.="<option value='".$location_id[$i]."'>".$location_title[$i]."</option>";
					}
				$table.="</select><input type='hidden' name='tid[$x]' id='tid[$x]' value='".$sql_row['qms_tid']."'>
					<input type='hidden' name='style[$x]' id='style[$x]' value='".$sql_row['qms_style']."'>
					<input type='hidden' name='schedule[$x]' id='schedule[$x]' value='".$sql_row['qms_schedule']."'>
					<input type='hidden' name='color[$x]'  id='color[$x]' value='".$sql_row['qms_color']."'>
					<input type='hidden' name='size[$x]' id='size[$x]' value='".$sql_row['qms_size']."'>
					<input type='hidden' name='ref1[$x]' id='ref1[$x]' value='".$sql_row['ref1']."'>
					</td>";
				}
				
				$table.="</tr>";
				echo $table;
				$x++;
			}	
			else
			{
				$sql2="UPDATE $bai_pro3.bai_qms_db SET location_id='RESRV4DES' WHERE qms_tid='".$sql_row['qms_tid']."'";
				echo "<br>22.".$sql2."<br>";
				mysqli_query($link, $sql2) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql2="UPDATE $bai_pro3.bai_qms_location_db SET qms_cur_qty=qms_cur_qty+".$resr_qty." WHERE qms_location_id='".$sql_row['location_id']."'";
				echo "<br>23.".$sql2."<br>";
				mysqli_query($link, $sql2) or exit("Sql Error$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}else{
			echo "<script>$(document).ready(function(){ 
				$('#table').hide(); 
				$('#enable').hide();
			});</script>";

		echo "</br></br><div class='alert alert-danger'>No Data Found</div>";
		}
	}
	// echo "<br>Qry :".$sql."</br>";
	echo '<tr><td colspan=5>Total Quantity:</td><td id="table1Tot1" style="background-color:#FFFFCC; color:red;"></td></tr>';
	$table='</tbody></table></div>';
	echo $table;
	echo '<br/><br/>';
	echo '<input type="checkbox" name="enable" id="enable" onclick="enable_button('.$x.')">Enable<input type="submit" class="btn btn-success" name="confirm" id="add" value="Confirm and Reserve" disabled="true" onclick="enable_button('.$x.')">';
	echo '</form>';
	}else{
		echo "</br></br><div class='alert alert-danger'>No Data Found</div>";
	}
	// echo '<tr><td colspan=5>Total Quantity:</td><td id="table1Tot1" style="background-color:#FFFFCC; color:red;"></td></tr>';
	
	
	// echo '<br/><br/>';
	// if($row_count > 0){
		// echo '<input type="checkbox" name="enable" id="enable" onclick="enable_button('.$x.')">Enable<input type="submit" class="btn btn-success" name="confirm" id="add" value="Confirm and Reserve" disabled="true" onclick="enable_button('.$x.')">';
		// echo '</form>';
	// }	
	}
	
	// if($row_count == 0){
	// 	echo "<script>$(document).ready(function(){ 
	// 						$('#table').hide(); 
	// 						$('#enable').hide();
	// 					});</script>";

	// 	echo "</br></br><div class='alert alert-danger'>No Data Found</div>";
	// }
	}else
	{
			echo "<script>sweetAlert('Error','Please enter the schedule','info');</script>";
	}
	
}


?>


<script language="javascript" type="text/javascript">
//<![CDATA[
	var fnsFilters = {
	
	rows_counter: false,
	sort_select: true,
	btn_reset: true,
	alternate_rows: true,
	btn_reset_text: "Clear",
	col_operation: { 
						id: ["table1Tot1"],
						col: [5],  
						operation: ["sum"],
						decimal_precision: [1],
						write_method: ["innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table1'),"tr").length]	
	};
	 setFilterGrid("table1",fnsFilters);
	 $(document).ready(function(){
		$('#reset_table1').addClass('btn btn-warning btn-xs');
	});
	//]]>
	



</script>

</body>
</div>
</div>
</div>
</div>


<style>
#reset_table1{
	width : 80px;
	color : #fff;
	margin : 10px;
}
</style>