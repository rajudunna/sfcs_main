<?php
ini_set('max_execution_time',0);
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

// $view_access=user_acl("SFCS_0040",$username,1,$group_id_sfcs);
// var_dump($sizes_array);
$has_perm=haspermission($_GET['r']);
?>

<?php
$start_date_w=time();

while((date("N",$start_date_w))!=1) {
$start_date_w=$start_date_w-(60*60*24); // define monday
}
$end_date_w=$start_date_w+(60*60*24*6); // define sunday 

$start_date_w=date("Y-m-d",$start_date_w);
$end_date_w=date("Y-m-d",$end_date_w);
?>
<style>
.toggleview li
{
	float:left;
	padding: 10px;
	margin:2px;
}
#tableone thead.Fixed
{
	position: absolute; 
}
thead 
{
	background: #337ab7 !important;
	color: white !important;
}
</style>

<style>
th
{
	color:black;
}
table
{
	margin:0px;
}
div.target
{
	margin: 0px 0 0 0px;
	width: auto;
}
div.target ul
{
	border: 0px solid gray;
}
</style>
<?php
if(isset($_GET['division']))
{
	$division=$_GET['division'];
}
else
{
	$division=$_POST['division'];
}
$pending=$_POST['pending'];
?>
<div class='panel panel-primary'><div class='panel-heading'>Delivery Failure Report</div><div class='panel-body'>

<form method="post" name="input" action="?r=<?php echo $_GET['r']; ?>">
	<?php
	$sql="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$buyer_code[]=$sql_row["buyer_div"];
		$buyer_name[]=$sql_row["buyer_name"];
	}
	?>
	<div class="row">			
		<div class="col-md-3">			
			<label>Buyer Division: </label>
				<select name="division" class="form-control">
					<option value='All' <?php if($division=="All"){ echo "selected"; } ?> >All</option>
					<?php
						for($i=0;$i<sizeof($buyer_name);$i++)
						{
							if($buyer_name[$i]==$division) 
							{ 
								echo "<option value=\"".($buyer_name[$i])."\" selected>".$buyer_code[$i]."</option>";	
							}
							else
							{
								echo "<option value=\"".($buyer_name[$i])."\"  >".$buyer_code[$i]."</option>";			
							}
						}
					?>
				</select>
		</div>
		<input type="submit" class='btn btn-primary disable-btn' value="Show" name="submit" style="margin-top:22px;">
	</div>
</form>

<?php 
// $sizes_array=array('xs','s','m','l','xl','xxl','xxl','s06','s08','s10','s12','s14','s16','s18','s20','s22','s24','s26','s28','s30');
if(isset($_POST['submit']) or isset($_GET['division']))
{
    echo "<hr/>";
	if(isset($_GET['division']))
	{
		$division=$_GET['division'];
	}
	else
	{
		$division=$_POST['division'];
	}

	if($division!='ALL' && $division!='')
	{
		$buyer_division=$division;
		$buyer_division_ref='"'.str_replace(",",'","',$buyer_division).'"';
		$order_div_ref="buyer_division in (".$buyer_division_ref.") and ";
	}
	else {
		 $order_div_ref='';
	}	

	$pending=$_POST['pending'];
	$query="where ex_factory_date_new >=\"2018-04-01\" and priority<>-1";
	if($division!="All")
	{
		$query="where $order_div_ref ex_factory_date_new >=\"2018-04-01\" and priority<>-1";
	}
	echo '<div class="table-responsive col-sm-12" style="max-height:600px;overflow:scroll"><table id="tableone" name="tableone" class="table table-bordered"><thead>';
	
	
	echo '<tr>		<th>S. No</th>	<th class="filter">Buyer Division</th>	<th class="filter">MPO</th>	<th class="filter">CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th class="filter">Style No.</th>	<th class="filter">Schedule No.</th>	<th>Colour</th><th>Sizes</th>	<th>Order Total</th><th class="filter">Current Status</th><th>Total</th>	<th>Quantity</th><th class="filter">Ex Factory</th><th class="filter">Rev. Ex-Factory</th>	<th class="filter">Mode</th><th class="filter">Rev. Mode</th>	<th class="filter">Packing Method</th>	<th>Plan End Date</th>	<th class="filter">Exe. Sections</th><th>Embellishment</th><th>Planning Remarks</th><th>Production Remarks</th><th>Commitments</th></tr>';
	echo '</thead><tbody>';

	$x=1;
	$sql="select * from $bai_pro4.week_delivery_plan where ref_id in (select ref_id from $bai_pro4.week_delivery_plan_ref $query)";
	// echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$edit_ref=$sql_row['ref_id'];
		//$x=$edit_ref;
		$shipment_plan_id=$sql_row['shipment_plan_id'];
		$fastreact_plan_id=$sql_row['fastreact_plan_id'];
		$plan_start_date=$sql_row['plan_start_date'];
		$plan_comp_date=$sql_row['plan_comp_date'];		
		$tid=$sql_row['tid'];
		$r_tid=$sql_row['ref_id'];
		$remarks=array();
		$remarks=explode("^",$sql_row['remarks']);
		
		$embl_tag=$sql_row['rev_emb_status'];
		$rev_ex_factory_date=$sql_row['rev_exfactory']; 
		$rev_mode=$sql_row['rev_mode']; 
		if($rev_ex_factory_date=="0000-00-00")
		{
			$rev_ex_factory_date="";
		}
		$sql1="select * from $bai_pro4.shipment_plan_ref where ship_tid=$shipment_plan_id";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$order_no=$sql_row1['order_no'];
			$delivery_no=$sql_row1['delivery_no'];
			$del_status=$sql_row1['del_status'];
			$mpo=trim($sql_row1['mpo']);
			$cpo=trim($sql_row1['cpo']);
			$buyer=trim($sql_row1['buyer']);
			$product=$sql_row1['product'];
			$buyer_division=trim($sql_row1['buyer_division']);
			$style=trim($sql_row1['style']);
			$schedule_no=$sql_row1['schedule_no'];
			$color=$sql_row1['color'];
			$size=$sql_row1['size'];
			$z_feature=$sql_row1['z_feature'];
			$ord_qty=$sql_row1['ord_qty'];		
			$mode=$sql_row1['mode'];
			$destination=$sql_row1['destination'];
			$packing_method=$sql_row1['packing_method'];
			$fob_price_per_piece=$sql_row1['fob_price_per_piece'];
			$cm_value=$sql_row1['cm_value'];
			$ssc_code=$sql_row1['ssc_code'];
			$ship_tid=$sql_row1['ship_tid'];
			$week_code=$sql_row1['week_code'];
			$status=$sql_row1['status'];
		}
//EMB stat 20111201

		if(date("Y-m-d")>"2011-12-11")
		{
			$embl_tag="";
			$sql1="select order_embl_a,order_embl_e from $bai_pro3.bai_orders_db where order_del_no=\"$schedule_no\"";
			mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				if($sql_row1['order_embl_a']==1)
				{
				$embl_tag="Panle Form*";
				}
				if($sql_row1['order_embl_e']==1)
				{
				$embl_tag="Garment Form*";
				}
			}
		}

//DISPATCH

	$sql1="select ship_qty from $bai_pro2.style_status_summ where sch_no=\"$schedule_no\"";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$ship_qty=$sql_row1['ship_qty'];
	}
	
	if($status=="FG" and $fgqty>=$ship_qty and $ship_qty>=$order)
	{
		$status="Dispatched";
	}
	
//DISPATCH


		$sql1="select * from $bai_pro4.week_delivery_plan_ref  where ship_tid=$shipment_plan_id";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$priority=$sql_row1['priority'];
			$cut=$sql_row1['act_cut'];
			$in=$sql_row1['act_in'];
			$out=$sql_row1['output'];
			$pendingcarts=$sql_row1['cart_pending'];
			$order=$sql_row1['ord_qty_new'];
			$fcamca=$sql_row1['act_mca'];
			$fgqty=$sql_row1['act_fg'];
			$internal_audited=$sql_row1['act_fca'];
			$ex_factory_date=$sql_row1['ex_factory_date'];
		}

		$status="NIL";
		if($cut==0)
		{
			$status="RM";
		}
		else
		{
			if($cut>0 and $in==0)
			{
				$status="Cutting";
			}
			else
			{
				if($in>0)
				{
					$status="Sewing";
				}
			}
		}
		if($out>=$fgqty and $out>0 and $fgqty>=$order)  //due to excess percentage of shipment over order qty
		{
			$status="FG";
		}
		if($out>=$order and $out>0 and $fgqty<$order)
		{
			$status="Packing";		}

		if($status=="FG" and $internal_audited>=$fgqty)
		{
			$status="FCA";
		}

		$sql1="select ship_qty from $bai_pro2.style_status_summ where sch_no=\"$schedule_no\"";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$ship_qty=$sql_row1['ship_qty'];
		}

		if($status=="FG" and $fgqty>=$ship_qty and $ship_qty>=$order)
		{
			$status="Dispatched";
		}

		$username_list=explode('\\',$_SERVER['REMOTE_USER']);
		$username=$username_list[1];
		$username="kirang";
		$authorized=array("muralim","kirang","sureshn","sasidharch","edwinr","lilanku"); //For Packing
		$authorized2=array("muralim","kirang","baiuser");

		if(strtolower($remarks[0])=="hold")
		{
			$highlight=" bgcolor=\"red\" ";
		}
		else
		{
			if(strtolower($remarks[0])=="$")
			{
				$highlight=" bgcolor=\"green\" ";
			}
			else
			{
				if(strtolower($remarks[0])=="short")
				{
					$highlight=" bgcolor=\"yellow\" ";
				}
				else
				{
					$highlight="";
				}
			}
		}

		//Allowed only Packing team and timings to update between 8-10 and 4-6
		if(in_array(strtolower($username),$authorized) and ((date("H")<=10 and date("H")>=8) or (date("H")<=18 and date("H")>=16)))
		{
			$edit_rem="<td class=\"editable\" rel=\"B$edit_ref\">".$remarks[1]."</td>";
		}
		else
		{
			//$edit_rem="<td $highlight>".$remarks[1]."</td>";
			$edit_rem="<td $highlight>".$remarks[1]."</td>";
		}

		if(!(in_array(strtolower($username),$authorized2)))
		{
			$edit_rem2="<td $highlight>".$remarks[2]."</td>";
		}
		else
		{
			//$edit_rem="<td $highlight>".$remarks[1]."</td>";
			$edit_rem2="<td class=\"editable\" rel=\"C$edit_ref\">".$remarks[2]."</td>";
		}
		//Restricted Editing for Packing Team
		
		echo "<tr ><td $highlight>$x </td>	<td $highlight>$buyer_division</td>	<td $highlight>$mpo</td>	<td $highlight>$cpo</td>	<td $highlight>$order_no</td>	<td $highlight>$z_feature</td><td $highlight>$style</td>	<td $highlight>$schedule_no</td>	<td $highlight>$color</td><td>".strtoupper($size)."</td>	<td $highlight>$ord_qty</td><td $highlight>$status</td><td $highlight>$actu_total</td>	<td>$fin_qty</td>	<td $highlight>$ex_factory_date</td><td $highlight>$rev_ex_factory_date</td>	<td $highlight>$mode</td><td $highlight>$rev_mode</td>	<td $highlight>$packing_method</td>	<td $highlight>$plan_comp_date</td><td $highlight>".implode(",",$executed_sec)."</td><td $highlight>$embl_tag</td><td $highlight>".$remarks[0]."</td>".$edit_rem.$edit_rem2."</tr>";
		$x+=1;			
		
	}
	echo '</tbody>';
	echo '</table></div></div></div>';
}
?>
</div >
</div></div>


