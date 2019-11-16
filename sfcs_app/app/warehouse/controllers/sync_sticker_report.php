<html>
<head>
<title>SYNC STICKER REPORT</title>
</head>

<script type="text/javascript">
function verify_date1(){
	
		var val1 = document.getElementById('dateval').value;
		var d = new Date();
        var month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
		year = d.getFullYear();

		if(day.length == 1)
			day = '0'+day;
		if(month.length == 1)
			month = '0'+month;

		var today=[year,month,day].join('-');
		var mode = document.getElementById('mode').value;
	

		if(val1 > today){
			sweetAlert(' Date Should not greater  than Today','','warning');	
			document.getElementById('dateval').value=today;
			return false;
		}
	
		return true;
}
function check_mode(){
	var mode = document.getElementById('mode').value;
	if(mode==''){
		sweetAlert('Please Select Order Type ','','warning');
		return false;	
	}
	document.getElementById('download').style.display='none';
	document.getElementById('msg').style.display='block';
	return true;
}

</script>
<body>
<?php
if(isset($_POST['mode']))
{
	$mode=$_POST['mode'];
}
else
{
	$mode="";
}
?>
<div class="panel panel-primary">
<div class="panel-heading">Auto Download M3 Sticker Report to SFCS</div>
<div class="panel-body">
<form  action="index.php?r=<?php echo $_GET['r']; ?>" method="POST" name="test">
<br>

<div class="col-md-12">
<div class='row'>
<div class='col-md-3 col-sm-3 col-xs-12'>
<label >Select Date:</label>

<input type="text"  name="dateval"  id="dateval" data-toggle='datepicker' class='form-control' style="width: 150px;  display: inline-block;"  onchange="return verify_date1();"  value="<?php echo isset($_POST['dateval'])?$_POST['dateval']:date("Y-m-d") ?>"> </div>
<div class='col-md-3 col-sm-3 col-xs-12'>
<label >ORDER TYPE:</label>

 <select name="mode" id="mode" class="form-control"  style="width: 120px;  display: inline-block;" >
				 <option value="" <?php if($mode==""){ echo "selected"; } ?>>Select</option>
				 <option value="GRN" <?php if($mode=="GRN"){ echo "selected"; } ?>>GRN</option>
				 <option value="RODO" <?php if($mode=="RODO"){ echo "selected"; } ?>>RODO</option>
				</select></div>
<div class='col-md-2'>
<input type="submit" class="btn btn-success"  value="Download" id="download" name="download" onclick="return check_mode();" /></div>		
<span id="msg" style="display:none;"><h4>Please Wait.. While Downloading The Data..<h4></span>
</div>
</div>
</form>	

<?php
$url = getFullURLLevel($_GET['r'],'common/config/config.php',3,'R');
$url1 = getFullURLLevel($_GET['r'],'common/config/rest_api_calls.php',3,'R');

include($_SERVER['DOCUMENT_ROOT'].'/'.$url);
include($_SERVER['DOCUMENT_ROOT'].'/'.$url1);
$company_num = $company_no;
if(isset($_POST['download'])) 
{	
	set_time_limit(6000000);
	$conn = odbc_connect($conn_string,$user_ms,$password_ms);
	$dateval=$_POST['dateval'];
	$date_val=str_replace('-','',$dateval);
	$mode=$_POST['mode'];

	if($conn)
	{
		$i =0;
		foreach($grn_details as $codes)
		{
			$code=explode("-",$codes);
			$cluster_code=$code[0];
			$central_wh_code=$code[1];
			$plant_wh_code=$code[2];
			$query_text = "CALL $m3_db.RPT_APL_SFCS_M3_INTEGRATION('".$cluster_code."','".$comp_no."','".$central_wh_code."','".$plant_wh_code."','".$date_val."','".$date_val."',0,'%','%','$mode')";
			$result = odbc_exec($conn, $query_text);
			//print_r(odbc_result_all($result));
			while($row = odbc_fetch_array($result))
			{
				$item_no = str_replace('"', '\"', $row['ITEM_NO']);
				$item_name = str_replace('"', '\"', $row['ITEM_NAME']);
				$item_des = str_replace('"', '\"', $row['ITEM_DESCRIPTION']);
				$invoice_no = str_replace('"', '\"', $row['INVOICE_NO']);
				$supp_name = str_replace('"', '\"', $row['SUPPLIER_NAME']);
				$po_ro = str_replace('"', '\"', $row['PO_RO_DO_NUMBER']);
				$po_line = str_replace('"', '\"', $row['PO_LINE_PRICE']);
				$po_tot_val = str_replace('"', '\"', $row['PO_TOTAL_VALUE']);
				$del_no = str_replace('"', '\"', $row['DELIVERY_NO']);
				$rec_qty = str_replace('"', '\"', $row['RECEIVED_QTY']);
				$umo = str_replace('"', '\"', $row['UOM']);
				$lot_num = str_replace('"', '\"', $row['LOT_NUMBER']);
				$batch_num = str_replace('"', '\"', $row['BATCH_NUMBER']);
				$grn_loc = str_replace('"', '\"', $row['GRN_LOCATION']);
				$buyer_buss_area = str_replace('"', '\"', $row['BUYER_BUSINESS_AREA']);
				$proc_grp = str_replace('"', '\"', $row['PROC_GROUP']);
				$grn_date = str_replace('"', '\"', $row['GRN_DATE']);
				$grn_entry_no = str_replace('"', '\"', $row['GRN_ENTRY_NO']);
				$style = str_replace('"', '\"', $row['STYLE']);
				$order_type = str_replace('"', '\"', $row['ORDER_TYPE']);
				$warehouse = str_replace('"', '\"', $row['WAREHOUSE']);
				$po_line = str_replace('"', '\"', $row['PO_LINE_NUMBER']); 
				$po_subline = str_replace('"', '\"', $row['PO_SUB_LINE_NUMBER']);

				$item_number = urlencode($item_no);
				//API call for rm color
				$api_url = $api_hostname.":".$api_port_no."/m3api-rest/execute/MDBREADMI/LstMITMAHX1;returncols=TY15?CONO=$company_num&ITNO=".$item_number;
			    $api_data = $obj->getCurlAuthRequest($api_url);
			    $api_data = json_decode($api_data, true);
			    $rm_color = $api_data['MIRecord'][0]['NameValue'][0]['Value'];
				
				$select_check_one="select lot_no from $bai_rm_pj1.sticker_report where lot_no='$lot_num'";
				$result_insert_one=mysql_query($select_check_one,$link) or ("Sql error".mysql_error());
		
				$check_result_one=mysqli_num_rows($result_insert_one);
				if($check_result_one==0)
				{
					$sql_lot = "INSERT INTO $bai_rm_pj1.sticker_report (lot_no) VALUES (\"".$lot_num."\")";
					//echo $sql_lot."</br>";
					$result_lot = mysqli_query($link, $sql_lot);
				}
				$sql_sticker_det = "UPDATE $bai_rm_pj1.sticker_report SET po_line = \"".$po_line."\" , po_subline = \"".$po_subline."\", item = \"".$item_no."\", item_name = \"".$item_name."\", item_desc = \"".$item_des."\", inv_no = \"".$invoice_no."\", po_no = \"".$po_ro."\", rec_no = \"".$del_no."\", rec_qty = \"".$rec_qty."\", lot_no = \"".$lot_num."\", batch_no = \"".$batch_num ."\", buyer = \"".$buyer_buss_area."\", product_group = \"".$proc_grp."\", pkg_no = \"".$grn_entry_no."\", grn_date = \"".$grn_date."\", supplier = \"".$supp_name."\", uom = \"".$umo."\", grn_location = \"".$grn_loc."\", po_line_price = \"".$po_line."\", po_total_cost = \"".$po_tot_val."\", style_no = \"".$style."\", grn_type = \"".$mode."\" WHERE lot_no = \"".$lot_num."\"";
				//echo $sql_sticker_det."</br>";
				$result_rec_insert = mysqli_query($link, $sql_sticker_det);
				if($result_rec_insert)
				{
					$i++;
				}
			}
		
		}
		if($i >0)
		{
			echo "<script>sweetAlert('Records are Updated Successfully','','info');</script>";
		}
		else
		{
			echo "<script>sweetAlert('No Records Are Updated','','info');</script>";
		}
	}
	else
	{
		echo "<div class='alert alert-info'>Failed ODBC Connection.</div>";
	}
}

?>
</div>
</div>
</body>
</html>


