<!--
Kirang/20150418 added validation to avoid additional rejections.
kirang/kirang: 589:  To avoid the sfcs_tid_ref=0 issue. 

-->
<html>
<head>
<?php

//CR# 375 / kirang - 2014-12-22 / To add supplier names against to the schedule
// Service Request #440767 / kirang / Clear the issue of replace quantity , display module no and shift for replace quantity in remarks column.
?>
<script>
 function button_disable()
{
	document.getElementById('process_message').style.visibility="visible";
	document.getElementById('update1').style.visibility="hidden";
}

function dodisable()
{
//enableButton();
document.getElementById('process_message').style.visibility="hidden"; 
}

function check1(x,y) 
{
	if(x<0)
	{
		alert("Enter Correct Value");
		return 1010;
	} 
	if(x>y)
	{
		alert("You cant replace more than the available quantity.");
		return 1010;
	}
}
</script>

<style>
body
{
	font-family: arial;
}
table
{
	border-collapse:collapse;
	font-size:12px;
}
td
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

th
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}
</style>

<script type="text/javascript" language="javascript">
    window.onload = function () {
        noBack();
    }
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>

 <script language="JavaScript">

        var version = navigator.appVersion;

        function showKeyCode(e) {
            var keycode = (window.event) ? event.keyCode : e.keyCode;

            if ((version.indexOf('MSIE') != -1)) {
                if (keycode == 116) {
                    event.keyCode = 0;
                    event.returnValue = false;
                    return false;
                }
            }
            else {
                if (keycode == 116) {
                    return false;
                }
            }
        }

    </script>

</head>
<body onload="dodisable()" onpageshow="if (event.persisted) noBack();" onkeydown="return showKeyCode(event)">

<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/m3_bulk_or_proc.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/ims_size.php"',4,'R'));


if(isset($_POST['Update']))
{
	$module=$_POST['mods'];
	$team=$_POST['shift']; //array
	$date=$_POST['date']; //array
	$ref=$_POST['ref']; //multi array (rejection codes)
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$size=$_POST['size'];
	$qty=$_POST['qty'];
	//$test=$_POST['test'];
	$job=$_POST['job'];
	$form=$_POST['form'];
	
	$replace_ref=array();
	
	$minilastid=0;
	$maxilastid=0;
	
	$ilast_codes=array();
	
	//Added by KiranG 20150418
	$usr_msg="<br/><br/><table><tr><th>Module</th><th>Schedule</th><th>Color</th><th>Size</th><th>Quantity</th></tr>";
	
	for($x=0;$x<sizeof($qty);$x++)
	{
		$iLastid=0;
		if($qty[$x]>=0 and $qty[$x]!="")
		{
			
			$check_proceed=0; //0-OK, 1- NOK
			$m3_op_qty_chk_ary=array();
			//echo "<br>".$qty[$x].">0and".$qty[$x]."!= and ".$test[$x]."==1 and ".strlen($style[$x]).">0 and ".strlen($schedule[$x]).">0 and ".strlen($color[$x]).">0 and ".strlen($size[$x]).">0<br>";
			//Validation Check Start
			//if($qty[$x]>0 and $qty[$x]!="" and $test[$x]==1 and strlen($style[$x])>0 and strlen($schedule[$x])>0 and strlen($color[$x])>0 and strlen($size[$x])>0)
			if($qty[$x]>0 and $qty[$x]!="" and strlen($style[$x])>0 and strlen($schedule[$x])>0 and strlen($color[$x])>0 and strlen($size[$x])>0)
			{
				
				//Added rejection transaction type based on reason wise (surplus reason is 5 and all others are 3)
				$qms_tran_type="3";
				$ref_code=array();
				for($j=0;$j<sizeof($ref[$x]);$j++)
				{
					if($ref[$x][$j]>0)
					{
						$ref_code[]=$j."-".$ref[$x][$j];
						
						//M3 Bulk Operation Reporting
							//Extract Operation Code and Reason Code
							//ref1=form factor (G/P), ref2=Source, ref3=reason refe
							$m3_reason_code='';
							$m3_operation_code='';
							
							$sql_sup="select m3_reason_code,m3_operation_code from $m3_bulk_ops_rep_db.rejection_report_matrix where interface='REJREP' and ref1='".$form[$x]."' and ref2='".(is_numeric($module[$x])?'0':$module[$x])."' and ref3=$j";
							$sql_result_sup=mysqli_query($link, $sql_sup) or exit("Sql Error1 $sql_sup".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row_sup=mysqli_fetch_array($sql_result_sup))
							{
								$m3_reason_code=$sql_row_sup['m3_reason_code'];
								$m3_operation_code=$sql_row_sup['m3_operation_code'];
							}
							//echo $sql_sup."-".$m3_reason_code."-".$m3_operation_code."<br>";
							$m3_op_qty_chk_ary[$m3_operation_code]=$m3_op_qty_chk_ary[$m3_operation_code]+$ref[$x][$j];
							
							if($check_proceed==0)
							{
								$check_proceed=1;
							}
						//M3 Bulk Operation Reporting
						
						if($j==33)
						{
							$qms_tran_type="5";
						}
					}
				}
			}
			else
			{
				
				$check_proceed=1;
			}
			
			//Additional Validation
			if(sizeof($m3_op_qty_chk_ary)>0)
			{
				foreach ($m3_op_qty_chk_ary as $key => $value)
				{
					if($check_proceed==0 and rejection_validation_m3($key,$schedule[$x],$color[$x],$size[$x],$value,0,$username)=="FALSE")
					{
						$check_proceed=1;
					}
				}
				
			}
			else
			{
				$check_proceed=1;
			}
			unset($m3_op_qty_chk_ary);
			
			//Validation Check End
			unset($sql_m3_insert);
			$sql_m3_insert=array();
			//validation
			if($check_proceed==0)
			{
				//if($qty[$x]>0 and $qty[$x]!="" and $test[$x]==1 and strlen($style[$x])>0 and strlen($schedule[$x])>0 and strlen($color[$x])>0 and strlen($size[$x])>0)
				if($qty[$x]>0 and $qty[$x]!="" and strlen($style[$x])>0 and strlen($schedule[$x])>0 and strlen($color[$x])>0 and strlen($size[$x])>0)
				{
					//Added rejection transaction type based on reason wise (surplus reason is 5 and all others are 3)
					$qms_tran_type="3";
					$ref_code=array();
					for($j=0;$j<sizeof($ref[$x]);$j++)
					{
						if($ref[$x][$j]>0)
						{
							$ref_code[]=$j."-".$ref[$x][$j];
							
							//M3 Bulk Operation Reporting
								//Extract Operation Code and Reason Code
								//ref1=form factor (G/P), ref2=Source, ref3=reason refe
								$m3_reason_code='';
								$m3_operation_code='';
								
								$sql_sup="select m3_reason_code,m3_operation_code from $m3_bulk_ops_rep_db.rejection_report_matrix where interface='REJREP' and ref1='".$form[$x]."' and ref2='".(is_numeric($module[$x])?'0':$module[$x])."' and ref3=$j";
								$sql_result_sup=mysqli_query($link, $sql_sup) or exit("Sql Error2 $sql_sup".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row_sup=mysqli_fetch_array($sql_result_sup))
								{
									$m3_reason_code=$sql_row_sup['m3_reason_code'];
									$m3_operation_code=$sql_row_sup['m3_operation_code'];
								}
								
							if($j==33)
							{
								$qms_tran_type="5";
							}
						}
					}
					
					$sql="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,qms_size,qms_qty,qms_tran_type,ref1,remarks,log_date,doc_no,log_user) values (\"".$style[$x]."\",\"".$schedule[$x]."\",\"".$color[$x]."\",\"".$size[$x]."\",".$qty[$x].",\"".$qms_tran_type."\",\"".implode("$",$ref_code)."\",\"".$module[$x]."-".$team[$x]."-".$form[$x]."\",\"".date("Y-m-d")."\",\"".$job[$x]."\",'$username')";
	                //echo $sql."<br>";
					mysqli_query($link, $sql) or exit("Sql Error4 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
					$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
					// start To avoid the sfcs_tid_ref=0 issue. 
					if(mysqli_affected_rows($GLOBALS["___mysqli_ston"]))
					{
						for($v=0;$v<sizeof($sql_m3_insert);$v++)
						{
							//echo $sql_m3_insert[$v]."<br/>";
							mysqli_query($link, $sql_m3_insert[$v]) or exit("Sql Error3".$sql_m3_insert[$v] .mysqli_error($GLOBALS["___mysqli_ston"]));
							$ilast_codes[]=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
						}
					
					}					
					for($j=0;$j<sizeof($ref[$x]);$j++)
					{
						if($ref[$x][$j]>0)
						{
							//To add supplier names against to the schedule
							$sql_tid="select order_tid from $bai_pro3.bai_orders_db where order_del_no=\"".$schedule[$x]."\" and order_col_des=\"".$color[$x]."\"";
							$sql_result_tid=mysqli_query($link, $sql_tid) or exit("Sql Error6 $sql_tid".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row_tid=mysqli_fetch_array($sql_result_tid))
							{
								$order_tid=$sql_row_tid["order_tid"];
							}
							
							$sql_col="select * from $bai_pro3.cat_stat_log where order_tid=\"".$order_tid."\" and category in (\"Body\",\"Front\") and purwidth > 0";
							$sql_result_col=mysqli_query($link, $sql_col) or exit("Sql Error7 $sql_col".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row_col=mysqli_fetch_array($sql_result_col))
							{
								$compo_no=$sql_row_col["compo_no"];
							}
							
							//To add supplier names against to the schedule
							$supplier="";
							$sql_sup="select group_concat(distinct supplier) as sup from $bai_rm_pj1.sticker_report where item=\"".$compo_no."\"";
							$sql_result_sup=mysqli_query($link, $sql_sup) or exit("Sql Error8 $sql_sup".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row_sup=mysqli_fetch_array($sql_result_sup))
							{
								$supplier=$sql_row_sup["sup"];
							}
							
							$sql1="insert into $bai_pro3.bai_qms_db_reason_track(qms_tid,qms_reason,qms_qty,supplier,log_date) values(\"".$iLastid."\",\"".$j."\",\"".$ref[$x][$j]."\",\"".$supplier."\",\"".date("Y-m-d")."\")";
							//echo $sql1."<br>";
							mysqli_query($link, $sql1) or exit("Sql Error9 $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							
							
							
						}
					}
					//$replace_ref[]=$style[$x]."$".$schedule[$x]."$".$color[$x]."$".$size[$x]."$".$module;	
				}
						
				$replace_ref[]=$style[$x]."$".$schedule[$x]."$".$color[$x]."$".$size[$x]."$".$module[$x]."$".$team[$x]."$".$iLastid;	
				//to track min and max insert ids
				$maxilastid=$iLastid;
				if($minilastid==0)
				{
					$minilastid=$iLastid;
				}
			}
			else
			{
				$usr_msg.="<tr><td>".$module[$x]."</td><td>".$schedule[$x]."</td><td>".$color[$x]."</td><td>".$size[$x]."</td><td>".$qty[$x]."</td></tr>";
			}	
		}
	}
	$usr_msg.="</table>";
	
	
	//Validations
	echo $usr_msg;
	
	$replace_ref=array_unique($replace_ref);
	
	echo "<form name=\"input\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
	echo "<h2>Rejection Replacement Update Panel</h2>";
	echo "<input type=\"hidden\" name=\"replace_ref\" value=\"".implode("#",$replace_ref)."\">";
	echo "<table>";
	echo "<tr><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Available to Replace</th><th>Qty Replaced</th></tr>";
	
	for($i=0;$i<sizeof($replace_ref);$i++)
	{
		$temp=array();
		$temp=explode("$",$replace_ref[$i]);
		
		//$sql="select sum(if((qms_tran_type=1 or qms_tran_type=5),qms_qty,0)) as \"good\", sum(if(qms_tran_type=2,qms_qty,0)) as \"replaced\", sum(if(qms_tran_type=3,qms_qty,0)) as \"rejected\", sum(if(qms_tran_type=10,qms_qty,0)) as \"tran_sent\", sum(if(qms_tran_type=12,qms_qty,0)) as \"res_panel_destroy\" from bai_qms_db where qms_style=\"".$temp[0]."\" and  qms_schedule=\"".$temp[1]."\" and qms_color=\"".$temp[2]."\" and qms_size=\"".$temp[3]."\"";
		//$sql="select sum(if((qms_tran_type=1),qms_qty,0)) as \"good\", sum(if(qms_tran_type=2,qms_qty,0)) as \"replaced\", sum(if(qms_tran_type=3,qms_qty,0)) as \"rejected\", sum(if(qms_tran_type=10,qms_qty,0)) as \"tran_sent\", sum(if(qms_tran_type=12,qms_qty,0)) as \"res_panel_destroy\" from bai_qms_db where qms_style=\"".$temp[0]."\" and  qms_schedule=\"".$temp[1]."\" and qms_color=\"".$temp[2]."\" and qms_size=\"".$temp[3]."\"";
		
		$sql="select sum(if((qms_tran_type=1),qms_qty,0)) as \"good\", sum(if(qms_tran_type=2,qms_qty,0)) as \"replaced\", sum(if(qms_tran_type=3,qms_qty,0)) as \"rejected\",sum(if(qms_tran_type=3 and qms_tid=".$temp[6].",qms_qty,0)) as \"line_rejected\",
		sum(if(qms_tran_type=3 and qms_tid>=$minilastid and qms_tid<".$temp[6].",qms_qty,0)) as \"prev_cumm_rejected\",
		sum(if(qms_tran_type=3 and qms_tid>=$minilastid and qms_tid<=".$temp[6].",qms_qty,0)) as \"cumm_rejected\",
		 sum(if(qms_tran_type=10,qms_qty,0)) as \"tran_sent\", sum(if(qms_tran_type=12,qms_qty,0)) as \"res_panel_destroy\" from $bai_pro3.bai_qms_db where qms_style=\"".$temp[0]."\" and  qms_schedule=\"".$temp[1]."\" and qms_color=\"".$temp[2]."\" and qms_size=\"".$temp[3]."\"";
		//echo $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error10 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			//Added Sent and reserve for destroy $available=$sql_row['good']-$sql_row['replaced']
			$available=$sql_row['good']-$sql_row['replaced']-$sql_row['tran_sent']-$sql_row['res_panel_destroy'];
			$allowed=0;
			
			/*if($sql_row['rejected']>$sql_row['replaced'] and $available>0)
			{
				if($available>($sql_row['rejected']-$sql_row['replaced']))
				{
					$allowed=$sql_row['rejected']-$sql_row['replaced'];
				}
				else
				{
					$allowed=$sql_row['good']-$sql_row['replaced'];
				}
			}*/
			
			//Logic: if prev cumm<available and available>coumm then rejec else prev cumm<available then available-prev cumm else 0
			if($sql_row['prev_cumm_rejected']<$available and $available>$sql_row['cumm_rejected'])
			{
				$allowed=$sql_row['line_rejected'];
			}
			else
			{
				if($sql_row['prev_cumm_rejected']<$available)
				{
					$allowed=$available-$sql_row['prev_cumm_rejected'];
				}
				else
				{
					$allowed=0;
				}
			}
			
			$size_value=ims_sizes($order_tid,$ims_schedule,$ims_style,$ims_color,$temp[3],$link);
			
			echo "<tr><td>".$temp[0]."</td><td>".$temp[1]."</td><td>".$temp[2]."</td><td>".$size_value."</td><td>".$allowed."</td><td><input type=\"text\" name=\"replace[]\" value=\"\" onchange=\"if(check1(this.value,$allowed)==1010) { this.value=0; }\"></td></tr>";
			
		}
	}
	echo "</table>";
	echo '<input type="submit" name="update1" id="update1" value="update" onclick="javascript:button_disable();">';
	echo '<div id="process_message"><h2><font color="red">Please wait while updating data!!!</font><br/><font color="blue">After update, this window will close automatically!</font></h2></div>';
	echo "</form>";
	
}


?>

</body>
</html>

<?php

if(isset($_POST['update1']))
{
	$replace=$_POST['replace'];
	$replace_ref=array();
	$replace_ref=explode("#",$_POST['replace_ref']);
	
	for($i=0;$i<sizeof($replace);$i++)
	{
		if($replace[$i]>0)
		{
			$temp=array();
			//echo "temp=".$replace_ref[$i];
			$temp=explode("$",$replace_ref[$i]);
			
			$sql="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,qms_size,qms_qty,qms_tran_type,remarks,log_date,ref1,log_user) values (\"".$temp[0]."\",\"".$temp[1]."\",\"".$temp[2]."\",\"".$temp[3]."\",".$replace[$i].",2,\"".$temp[4]."-".$temp[5]."\",\"".date("Y-m-d")."\",\"TID-".$temp[6]."\",'$username')";
			//echo "<br/> query= ".$sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error11 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		}
	}
	echo "<h2>Successfully Updated.</h2>";
}

?>
