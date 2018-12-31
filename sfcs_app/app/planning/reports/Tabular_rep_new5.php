<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'order_status_buffer.php',0,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
?>
<?php
error_reporting(0);
set_time_limit(6000000);
?>
<html>
<head>
<!--<link rel="stylesheet" type="text/css" media="all" href="<?= getFullURLLevel($_GET['r'],'common/js/jsdatepick-calendar/jsDatePick_ltr.min.css',1,'R'); ?>" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'reports/jsdatepick-calendar/jsDatePick.min.1.3.js',0,'R'); ?>"></script>-->
<script>

//<form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">

function firstbox()
{
	var cpo_value=document.test.cpo.value;
	if(cpo_value!='all'){
		window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&cpo="+cpo_value;
		
	}else{
		window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&cpo="+'all';
	}
	
}

function secondbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&cpo="+document.test.cpo.value+"&buyer_div="+document.test.buyer_div.value;
	window.location.href = uriVal;
}

function thirdbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&cpo="+document.test.cpo.value+"&buyer_div="+document.test.buyer_div.value+"&style="+document.test.style.value;
	window.location.href = uriVal;
}
function fourthbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&cpo="+document.test.cpo.value+"&buyer_div="+document.test.buyer_div.value+"&style="+document.test.style.value+"&style_id="+document.test.style_id.value;
	window.location.href = uriVal;
}
function fifthbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&cpo="+document.test.cpo.value+"&buyer_div="+document.test.buyer_div.value+"&style="+document.test.style.value+"&style_id="+document.test.style_id.value+"&schedule="+document.test.schedule.value;
	window.location.href = uriVal;
}
function sixthbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&cpo="+document.test.cpo.value+"&buyer_div="+document.test.buyer_div.value+"&style="+document.test.style.value+"&style_id="+document.test.style_id.value+"&schedule="+document.test.schedule.value+"&color="+encodeURIComponent(document.test.color.value);
	window.location.href = uriVal;
}
$(document).ready(function() {
	$('#buyer_div').on('click',function(e){
		var style = $('#cpo').val();
		if(style == null){
			sweetAlert('Please Select CPO','','warning');
		}
		
	});
	$('#style').on('click',function(e){
		var cpo = $('#cpo').val();
		var buyer_div = $('#buyer_div').val();
		if(cpo == null && buyer_div == null){
			sweetAlert('Please Select CPO and Buyer Division','','warning');
		}
		else if(buyer_div == null){
			sweetAlert('Please Select Buyer Division','','warning');
			document.getElementById("submit").disabled = true;
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});

	$('#style_id').on('click',function(e){
		var cpo = $('#cpo').val();
		var buyer_div = $('#buyer_div').val();
		var style = $('#style').val();
		if(cpo == null && buyer_div == null && style == null){
			sweetAlert('Please Select CPO,Buyer Division and Style','','warning');
		}
	});
	$('#schedule').on('click',function(e){
		var cpo = $('#cpo').val();
		var buyer_div = $('#buyer_div').val();
		var style = $('#style').val();
		var style_id = $('#style_id').val();
		if(cpo == null && buyer_div == null && style == null && style_id == null){
			sweetAlert('Please Select CPO,Buyer Division Style and User Style ID','','warning');
		}
	});
	$('#color').on('click',function(e){
		var cpo = $('#cpo').val();
		var buyer_div = $('#buyer_div').val();
		var style = $('#style').val();
		var style_id = $('#style_id').val();
		var schedule = $('#schedule').val();
		if(cpo == null && buyer_div == null && style == null && style_id == null && schedule == null){
			sweetAlert('Please Select CPO,Buyer Division Style,User Style ID and Schedule','','warning');
		}
	});
});
</script>
<script type="text/javascript">
	window.onload = function()
	{
		
		new JsDatePick({
			useMode:2,
			target:"demo1",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"demo2",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<script language="javascript" type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R') ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<link rel="stylesheet" href="<?= '../'.getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R') ?>" type="text/css" media="all" />
<!--<link href="<?= '../'.getFullURLLevel($_GET['r'],'common/css/table_style.css',3,'R') ?>" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?= '../'.getFullURL($_GET['r'],'jquery-1.3.2.js','R') ?>" ></script>
<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R') ?>" ></script>


</head>

<div class='panel panel-primary'><div class='panel-heading'>Order Status Report</div><div class='panel-body'>
<form method="POST" name="test" action="?r=<?php echo $_GET['r'];?>">

<?php
if(isset($_POST['submit1']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$cpo=$_POST['cpo'];
	$buyer_div=$_POST['buyer_div'];
	$style_id=$_POST['style_id'];
	$date_filter=$_POST['date_filter'];
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
	
}else{
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
	$color=$_GET['color'];
	$cpo=$_GET['cpo'];
	$buyer_div=$_GET['buyer_div'];
	$buyer_div1=$_POST['buyer_div'];
	$style_id=$_GET['style_id'];
	$from_date=$_GET['from_date'];
	$to_date=$_GET['to_date'];
}
?>
<form name="test" action="<?php echo getFullURLLevel($_GET['r'],'Tabular_rep_new5.php','0','N'); ?>" method="post">
<?php
$sql="select distinct CPO from $bai_pro2.order_status_buffer order by CPO";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
echo "<div class=\"row\"><div class=\"col-sm-2\"><label>Select CPO:</label><select class='form-control' name=\"cpo\"  id=\"cpo\" onchange=\"firstbox();\">";
echo "<option value='' disabled selected>Please Select</option>";
if($cpo=="all") {
	echo "<option value='all' selected>All</option>";
}else{
echo "<option value='all'>All</option>";
}
while($sql_row=mysqli_fetch_array($sql_result))
{
	
	if(str_replace(" ","",$sql_row['CPO'])==str_replace(" ","",$cpo))
    {
		echo "<option value=\"".$sql_row['CPO']."\" selected>".$sql_row['CPO']."</option>";	
	}
	else{
		echo "<option value=\"".$sql_row['CPO']."\" >".$sql_row['CPO']."</option>";
	}

}

    echo "  </select>
	</div>";

	$sql_buyer="select distinct buyer_div from $bai_pro2.order_status_buffer where replace(cpo,\"'\",\"\")='".str_replace("'","",$cpo)."' order by buyer_div";
	$sql_result1=mysqli_query($link, $sql_buyer) or exit("Sql Error1a".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check1=mysqli_num_rows($sql_result1);
	echo "<div class=\"col-sm-3\"><label>Select Buyer Division:</label><select class='form-control' name=\"buyer_div\"  id=\"buyer_div\" onchange=\"secondbox();\">";
	
	echo "<option value='' disabled selected>Please Select</option>";
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		
		if(str_replace(" ","",$sql_row1['buyer_div'])==str_replace(" ","",$buyer_div))
		 {
			echo "<option value=\"".$sql_row1['buyer_div']."\" selected>".$sql_row1['buyer_div']."</option>";
		}
	
		elseif(str_replace(" ","",$sql_row1['buyer_div'])==str_replace(" ","",$buyer_div1)){
			echo "<option value=\"".$sql_row1['buyer_div']."\" selected>".$sql_row1['buyer_div']."</option>";
		}
		else{
			echo "<option value=\"".$sql_row1['buyer_div']."\">".$sql_row1['buyer_div']."</option>";
		}
	}
	echo "  </select>
	</div>";
	
	$sql_style="select distinct style from $bai_pro2.order_status_buffer where replace(cpo,\"'\",\"\")='".str_replace("'","",$cpo)."' and  buyer_div='$buyer_div' order by style";
	$sql_result2=mysqli_query($link, $sql_style) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	echo "<div class=\"col-sm-2\"><label>Select Style:</label><select class='form-control' name=\"style\"  id=\"style\" onchange=\"thirdbox();\">";
	echo "<option value='' disabled selected>Please Select</option>";
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		
		if(str_replace(" ","",$sql_row2['style'])==str_replace(" ","",$style)){
			echo "<option value=\"".$sql_row2['style']."\" selected>".$sql_row2['style']."</option>";

		}else{
			echo "<option value=\"".$sql_row2['style']."\">".$sql_row2['style']."</option>";

		}
			
	
	}
	echo "  </select>
    </div>";
    $sql_query="select distinct style_id from $bai_pro2.order_status_buffer where replace(cpo,\"'\",\"\")='".str_replace("'","",$cpo)."' and  buyer_div='$buyer_div' and style='$style' order by style_id";
	$sql_result3=mysqli_query($link, $sql_query) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check3=mysqli_num_rows($sql_result3);
	echo "<div class=\"col-sm-2\"><label>Select User Style ID:</label><select class='form-control' name=\"style_id\"  id=\"style_id\" onchange=\"fourthbox();\">";
	
	echo "<option value='' disabled selected>Please Select</option>";
	while($sql_row3=mysqli_fetch_array($sql_result3))
	{
		
		if(str_replace(" ","",$sql_row3['style_id'])==str_replace(" ","",$style_id))
		{
		echo "<option value=\"".$sql_row3['style_id']."\" selected>".$sql_row3['style_id']."</option>";
		}
		else
		{
	    echo "<option value=\"".$sql_row3['style_id']."\">".$sql_row3['style_id']."</option>";
		}
	
	
	}
	echo "  </select>
	</div>";
	$sql_schedule="select distinct schedule from $bai_pro2.order_status_buffer where replace(cpo,\"'\",\"\")='".str_replace("'","",$cpo)."' and  buyer_div='$buyer_div' and style='$style' and style_id='$style_id' order by schedule";
	$sql_result4=mysqli_query($link, $sql_schedule) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check4=mysqli_num_rows($sql_result4);
	echo "<div class=\"col-sm-2\"><label>Select Schedule:</label><select class='form-control' name=\"schedule\"  id=\"schedule\" onchange=\"fifthbox();\">";
	
	echo "<option value='' disabled selected>Please Select</option>";
	while($sql_row4=mysqli_fetch_array($sql_result4))
	{
		$schedule1=$sql_row4['schedule'];
		//if(($_GET["schedule"])=="$schedule1")
		if(str_replace(" ","",$sql_row4['schedule'])==str_replace(" ","",$schedule))
		{
			echo "<option value=\"".$sql_row4['schedule']."\" selected>".$sql_row4['schedule']."</option>";

		}
	    else{
			echo "<option value=\"".$sql_row4['schedule']."\">".$sql_row4['schedule']."</option>";
		}
	
	}
	echo "  </select>
	</div>";
	
    $sql2="select distinct color from $bai_pro2.order_status_buffer where replace(cpo,\"'\",\"\")='".str_replace("'","",$cpo)."' and  buyer_div='$buyer_div' and style='$style' and style_id='$style_id' and schedule='$schedule' order by color";
	$sql_result5=mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check5=mysqli_num_rows($sql_result5);
	echo "<div class=\"col-sm-3\"><label>Select Color:</label><select class='form-control' name=\"color\"  id=\"color\" onchange=\"sixthbox();\">";
	
	echo "<option value='' disabled selected>Please Select</option>";
	while($sql_row5=mysqli_fetch_array($sql_result5))
	{
		$color1=$sql_row5['color'];
		//if(($_GET["color"])=="$color1")
		if(str_replace(" ","",$sql_row5['color'])==str_replace(" ","",$color))
		{
			echo "<option value=\"".$sql_row5['color']."\" selected>".$sql_row5['color']."</option>";
	
		}else{
			echo "<option value=\"".$sql_row5['color']."\">".$sql_row5['color']."</option>";
		}
	
	}
	echo "  </select>
	</div>";

	
	echo "<div class=\"col-sm-3\"><label> Exfactory From:</label>";
	
	echo'<input type="text" data-toggle="datepicker" class="form-control"  name="from_date" value="';if($from_date==""){ echo date("Y-m-d"); } else { echo $from_date; } echo '">';
	echo"</div>";
	echo "<div class=\"col-sm-3\"><label> Exfactory To:</label>";
	
	echo'<input type="text" data-toggle="datepicker" class="form-control"  name="to_date" value="';if($to_date==""){ echo date("Y-m-d"); } else { echo $to_date; }  echo '">';
	echo"</div>";

	echo"</div>";



       
?>
<input type="submit" name="submit1" value="Submit" class="btn btn-success" style="margin-top: 22px;">
</form>

<?php


if(isset($_POST['submit1']))
{
	

	$order_status_buffer="temp_pool_db.".$username.date("YmdHis")."_"."order_status_buffer";
	
	$sql="create TEMPORARY table $order_status_buffer ENGINE = MyISAM select * from $bai_pro2.order_status_buffer";
	$newwww = $sql;
	mysqli_query($link, $sql) or exit("Sql Error1z".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql1="delete from $bai_pro2.order_status_buffer";
	mysqli_query($link, $sql1) or exit("Sql Error2z".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql1="insert into $bai_pro2.order_status_buffer (cust_order,CPO,buyer_div,style,style_id,schedule,color,exf_date,ssc_code,order_qty) select Cust_order,CPO,buyer_div,style_no,style_id,schedule_no,color,exfact_date,ssc_code,order_qty from $bai_pro2.shipment_plan_summ";
	mysqli_query($link, $sql1) or exit("Sql Error3z".mysqli_error($GLOBALS["___mysqli_ston"]));

	
	$ssc_code_filter="temp_pool_db.".$username.date("YmdHis")."_"."ssc_code_filter";
	
	$sql="create TEMPORARY table $ssc_code_filter ENGINE = MyISAM select * from $bai_pro2.ssc_code_filter";
	mysqli_query($link, $sql) or exit("Sql Error4z".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="delete from  $bai_pro2.ssc_code_filter";
	mysqli_query($link, $sql) or exit("Sql Error5z".mysqli_error($GLOBALS["___mysqli_ston"]));
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$cpo=$_POST['cpo'];
	$buyer_div=$_POST['buyer_div'];
	$style_id=$_POST['style_id'];
	$date_filter=$_POST['date_filter'];
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
	if($cpo=='all'){
		$sql11="select * from  $bai_pro2.order_status_buffer where exf_date between \"$from_date\" and \"$to_date\"";
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else{
		$sql11="select * from  $bai_pro2.order_status_buffer where exf_date between \"$from_date\" and \"$to_date\"";
		if($cpo!=''){
			$sql11.="and replace(cpo,\"'\",\"\")='".str_replace("'","",$cpo)."'";
		}
		if($buyer_div!=''){
			$sql11.="and buyer_div='$buyer_div'";
		}
		if($style!=''){
			$sql11.="and style='$style'";
		}
		if($style_id!=''){
			$sql11.="and style_id='$style_id'";
		}
		if($schedule!=''){
			$sql11.="and schedule='$schedule'";
		}
		if($color!=''){
			$sql11.="and color='$color'";
		}
	}
	//echo $sql11."<br>";
	$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result11_count=mysqli_num_rows($sql_result11);

	echo '<form action="'."../".getFullURL($_GET['r'],"export_excel1.php",'R').'" method ="post" > 
	<input type="hidden" name="csv_123" id="csv_123">
	<input class="pull-right btn btn-info" type="submit" id="excel" value="Export to Excel" onclick="getCSVData()">
	</form>';
			
			

	echo "<div class='table-responsive'><table id=\"table1\"  class=\" table table-bordered\"><thead>";
	echo "<tr class='info'>";
	echo "<th>Customer Order</th>";
	echo "<th>MPO</th>";	
	echo "<th>CPO</th>";
	echo "<th>Buyer Division</th>";
	echo "<th>Style</th>";
	echo "<th>User Def. Style</th>";
	echo "<th>Schedule</th>";
	echo "<th>Color</th>";
	echo "<th>Ex-Factory Date</th>";
	echo "<th>Order Qty</th>";
	echo "<th>Cut Qty</th>";
	echo "<th>%</th>";
	echo "<th>Sewing In Qty</th>";
	echo "<th>%</th>";
	echo "<th>Sewing Out Qty</th>";
	echo "<th>%</th>";
	echo "<th>Pack Qty</th>";
	echo "<th>%</th>";
	echo "<th>Ship Qty</th>";
	echo "<th>%</th>";
	echo "</tr></thead><tbody>";
	$count=0;
	while($sql_row11=mysqli_fetch_array($sql_result11))
	{
	
		$cut_qty=0;
		$sewing_in=0;
		$sewing_out=0;
		$pack_qty=0;
		$ship_qty=0;
		$ssc_code=$sql_row11['ssc_code'];
		$cut_qty_today=0;
		$sewing_in_today=0;
		$sewing_out_today=0;
		$pack_qty_today=0;
		$ship_qty_today=0;
		$cust_order="";
		$cpo="";
		$mpo="";
		$buyer_div="";
		$style_no="";
		$schedule_no="";
		$color="";
		$exfact_date="";
		$order_qty=0;
		$style_id="";
        $sql1="select act_cut,act_in,output,act_fg,act_ship from $bai_pro3.bai_orders_db_confirm where order_tid=\"$ssc_code\"";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$cut_qty=$sql_row1['act_cut'];
			$sewing_in=$sql_row1['act_in'];
			$sewing_out=$sql_row1['output'];
			$pack_qty=$sql_row1['act_fg'];
			$ship_qty=$sql_row1['act_ship'];
			$sql1="select Cust_order,CPO,buyer_div,style,schedule,color,exf_date,order_qty,style_id from $bai_pro2.order_status_buffer  where ssc_code=\"$ssc_code\"";
			// echo $sql1;
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result1_count=mysqli_num_rows($sql_result1);
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				
				
				
				$cust_order=$sql_row1['Cust_order'];
				$cpo=$sql_row1['CPO'];
				$mpo=$sql_row1['MPO'];
				$buyer_div=$sql_row1['buyer_div'];
				$style_no=$sql_row1['style'];
				$schedule_no=$sql_row1['schedule'];
				$color=$sql_row1['color'];
				$exfact_date=$sql_row1['exf_date'];
				$order_qty=$sql_row1['order_qty'];
				
				$style_id=$sql_row1['style_id'];
			
			
			}
			echo "<tr>";
			echo "<td>$cust_order</td>";
			echo "<td>$mpo</td>";
			echo "<td>$cpo</td>";
			echo "<td>$buyer_div</td>";
			echo "<td>$style_no</td>";
			echo "<td>$style_id</td>";
			echo "<td>$schedule_no</td>";
			echo "<td>$color</td>";
			echo "<td>$exfact_date</td>";
			echo "<td>$order_qty</td>";
			echo "<td>$cut_qty</td>";
			if($order_qty>0)
			{
				echo "<td>".round(($cut_qty/$order_qty)*100,0)."%</td>";
			}
			else
			{
				echo "<td>0%</td>";
			}

			echo  "<td>$sewing_in</td>";

			if($order_qty>0)
			{
				echo "<td>".round(($sewing_in/$order_qty)*100,0)."%</td>";
			}
			else
			{
				echo "<td>0%</td>";
			}

			echo  "<td>$sewing_out</td>";

			if($order_qty>0)
			{
				echo "<td>".round(($sewing_out/$order_qty)*100,0)."%</td>";
			}
			else
			{
				echo "<td>0%</td>";
			}

			echo  "<td>$pack_qty</td>";

			if($order_qty>0)
			{
				echo "<td>".round(($pack_qty/$order_qty)*100,0)."%</td>";
			}
			else
			{
				echo "<td>0%</td>";
			}

			echo  "<td>$ship_qty</td>";

			if($order_qty>0)
			{
				echo "<td>".round(($ship_qty/$order_qty)*100,0)."%</td>";
			}
			else
			{
				echo "<td>0%</td>";
			}

			echo "</tr>";
			$count++;	
		}
	}
	echo "</tbody></table></div>"; 
	if($sql_result1_count==0){
		echo"<style>#table1{display:none;}</style>";
		echo"<style>#excel{display:none;}</style>";
	}
	if($count==0 or $sql_result11_count == 0){
		echo "<div class=' col-sm-12'><p class='alert alert-danger'>No Data Found</p></div><script>$('#main_content').hide();</script>";
	}
	
}

?>	

<script language="javascript">
function getCSVData(){
 var csv_value=$('#table1').table2CSV({delivery:'value'});
 $("#csv_123").val(csv_value);	
}
//<![CDATA[
	$('#reset_table1').addClass('btn btn-warning');
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							// btn_reset_text: "Clear",
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table1",table6_Props );
	$(document).ready(function(){
		$('#reset_table1').addClass('btn btn-warning btn-xs');
	});
	//]]>
</script>

</div></div>
</html>


	













