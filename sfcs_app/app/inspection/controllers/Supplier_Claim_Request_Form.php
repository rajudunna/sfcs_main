<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/headers.php',1,'R'));
$Page_Id='SFCS_0053';
$has_permission=haspermission($_GET['r']);

?>
<script>

function firstbox()
{
	window.location.href ="index.php?r=<?= $_GET['r']?>&batch="+document.test.txtbatch.value
}
function hide()
{
document.getElementById("submit").style.visibility = "hidden";
}


function DataCheck()
{
	var chks = document.getElementsByName('txtindrejqty[]');     
	var tot=0; 
	for (var i = 0; i < chks.length; i++) 
	{ 
		if(parseFloat(chks[i].value) > 0)
		{		       
			tot=parseFloat(tot)+parseFloat(chks[i].value);
		}
		else
		{
			chks[i].value=0;
			tot=parseFloat(tot)+0;
		}
	} 		
	var avail=0;
	var avail1=document.getElementById("txtrejtot").value;
	var avail2=document.getElementById("txtlenshrtqty").value;
	
	avail=parseFloat(avail1)+parseFloat(avail2);
	if(parseFloat(tot) > parseFloat(avail))
	{
		for (var i = 0; i < chks.length; i++) 
		{
			chks[i].value=0;
		}
	}
}


function check_batch()
{
	var batch=document.getElementById('txtbatch').value;
	if(batch=='')
	{

		sweetAlert('Please enter Batch Number','','warning');
		return false;
	}
	else
	{
		return true;
	}
}
</script>

<script>


function enableButton() 
{
	var txtrejtot=document.getElementById('txtrejtot').value;
	var txtlenshrtqty=document.getElementById("txtlenshrtqty").value;
	var txtrejtot1=document.getElementById("txtrejtot1").value;
	
	if(Number(txtrejtot) > Number(txtrejtot1))
	{
			sweetAlert('Rejected Total Cannot Enter More Than Actual Rejected Total ','','warning');
			document.getElementById('txtrejtot').value = txtrejtot1; 
			return false;
	}
	else 
	{
		    var x = document.getElementsByName("txtindrejqty[]");
			
		    var i;
		   var y=0;
		    for (i = 0; i < x.length; i++) 
		    {
		      y=Number(y)+Number(x[i].value);
		    console.log(y);
		    console.log(Number(txtrejtot)+Number(txtlenshrtqty));
		    }
		   if(y > (Number(txtrejtot)+Number(txtlenshrtqty)))
		   {
		   	sweetAlert('Effected Quantity Total should Be less or equal to Rejected Total ','','warning');
		   	return false;
		   }
		   else
		   {
		   		document.getElementById('submitx').disabled='';
		   }
	}
	// else
	// {
	// 	sweetAlert('Please enter Rejected Total ','','warning');
	// 	return false;
	// }

}

</script>



<div class="panel panel-primary">
<div class="panel-heading">Supplier Claim Request Form</div>
<div class="panel-body">
<div class="table-responsive">

<body>
<?php
$comcat=$_POST["selcompro"];
$batch_no=$_POST["txtbatch"];
$lot_no_ref_new_test=$_POST["sellotnosrefnew"];


if(isset($_POST['txtbatch']))
{
	$comcat=$_POST['selcompro'];
	$batch_no=$_POST["txtbatch"];
	$lot_no_ref_new_test=$_POST["sellotnosrefnew"];
}
else
{
	$comcat="Select";
	$lot_no_ref_new_test=array("0");
}

?>
<?php

if(in_array($authorized,$has_permission))
{
echo '<a class="btn btn-info btn-xs" href="'.getFullURL($_GET["r"],"Supplier_Claim_Request_Form.php","N").'">Request Form</a> | <a class="btn btn-info btn-xs" href="'.getFullURLLevel($_GET["r"],"reports/Supplier_Claim_Log_Form.php",1,"N").'">Log</a> <hr>';
}

?>
<form id="testx" name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="POST">

Enter Batch No <input type="text" class="form-control"  style="width: 150px;  display: inline-block;" name="txtbatch" id="txtbatch" onblur="firstbox();" 
size="8" value="<?php if(isset($_POST['txtbatch'])) { echo $batch_no; } else { echo $_GET['batch']; } ?>" /> 



<?php
error_reporting(0);
$batch=$_GET["batch"];
$batch_temp = $batch;
if($batch=="")
{
	$batch=-1;
}
$batch_temp1 = $batch;

$sql="SELECT DISTINCT(SUBSTRING_INDEX(product_group,'-',-1)) AS compro FROM $bai_rm_pj1.sticker_report WHERE batch_no=\"".$batch."\"";
$result=mysqli_query($link, $sql) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
$row=mysqli_fetch_array($result);


 $value_comp = $row["compro"];
 if($batch_temp!='' || $_POST['selcompro']!=''){
	echo "Complaint Product ";
	if(isset($_POST['selcompro']))
	{ 
		$value_comp=$comcat;
		$batch = $batch_no;
	}	
	echo "<input type='text' readonly value='$value_comp' name=\"selcompro\" id='selcompro' class='form-control' style='width: 150px;  display: inline-block;'>";
	
	echo "Select Lot Nos";
	echo "<select name=\"sellotnosrefnew[]\"  class='form-control' onclick='return check_batch();' style='width: 150px;  display: inline-block;'>";
	echo "<option value='' selected>Please Select</option>";
	$sql1="SELECT DISTINCT(lot_no) AS lot_no FROM $bai_rm_pj1.sticker_report WHERE batch_no=\"".$batch."\" and length(batch_no) > 0";
	$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{

		if(in_array($row1["lot_no"],$lot_no_ref_new_test))
		{

			echo "<option selected>".$row1["lot_no"]."</option>";
		}
		else
		{
			echo "<option>".$row1["lot_no"]."</option>";
		}	
	}
	echo "</select>&nbsp;&nbsp;&nbsp;";

	if(mysqli_num_rows($result1) < 1 && $batch != '-1'){
		echo "<script>sweetAlert('No lots found for entered batch','','error');</script>";
	}

	echo "<input type=\"submit\" value=\"Show\" name=\"show\" onclick='return check_batch();' class=\"btn btn-success\" />";
 }
 
?>
</form>
<?php
if(isset($_POST['show']))
{
	$comcat_type=$_POST["selcompro"];
	$batch_no=$_POST["txtbatch"];
	$lot_no_ref_new=$_POST["sellotnosrefnew"];
	
	if ($comcat_type=='' or $batch_no=='' or empty($lot_no_ref_new))
	{
		echo "";
	} else 
	{
		include("Supplier_Claim_Log_Form_req.php");
	
		if(sizeof($lot_no_ref_new) > 0)
		{

			$lot_no_ref_new_final=implode("','",$lot_no_ref_new);
		}
		
		
		$sql2="SELECT TRIM(GROUP_CONCAT(DISTINCT lot_no SEPARATOR ',')) AS lot_no FROM $bai_rm_pj1.sticker_report WHERE batch_no='".trim($batch_no)."' and lot_no in ('".$lot_no_ref_new_final."')";
		// echo $sql2."<br>";
		$result2=mysqli_query($link, $sql2) or die("Error3=".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		if(mysqli_num_rows($result2) > 0)
		{
			
			while($row2=mysqli_fetch_array($result2))
			{
				$lot_no_ref=$row2["lot_no"];
				
			}

			$sql3="select TRIM(GROUP_CONCAT(DISTINCT lot_no SEPARATOR \"','\")) as lot_no from $bai_rm_pj1.store_in where lot_no IN ('".$lot_no_ref."') and roll_status in (1,2)";
			$result3=mysqli_query($link, $sql3) or die("Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row3=mysqli_fetch_array($result3))
			{
				$rej_lot_no_ref=$row3["lot_no"];
			}
			
			$sql3="select TRIM(GROUP_CONCAT(DISTINCT lot_no SEPARATOR \"','\")) as lot_no from $bai_rm_pj1.store_in where lot_no IN ('".$lot_no_ref."')";
			$result3=mysqli_query($link, $sql3) or die("Error21=".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row3=mysqli_fetch_array($result3))
			{
				$rej_lot_no_ref=$row3["lot_no"];
			}
		
			$sql2="SELECT SUM(qty_rec) AS rec_qty,COUNT(tid) as rolls,SUM(ref5) AS insp_qty FROM $bai_rm_pj1.store_in WHERE lot_no IN ('".$lot_no_ref."')";	
			$result2=mysqli_query($link, $sql2) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row2=mysqli_fetch_array($result2))
			{
					$rec_qtys=$row2["rec_qty"];
					$rolls_count=$row2["rolls"];
					$inspc_qty=$row2["insp_qty"];
			}
			
			if($rec_qtys > 0)
			{
				$len_shrt=round(($rec_qtys-$inspc_qty)*100/$rec_qtys,2);
			}
			else
			{
				$len_shrt=0;
			}	
		
			$sql1="SELECT GROUP_CONCAT(DISTINCT item) AS item_code,TRIM(GROUP_CONCAT(DISTINCT item_desc)) AS item_color,TRIM(GROUP_CONCAT(DISTINCT item_name)) AS item_name,TRIM(GROUP_CONCAT(DISTINCT lot_no)) AS lot_no,TRIM(GROUP_CONCAT(DISTINCT po_no)) AS po_no,TRIM(GROUP_CONCAT(DISTINCT buyer)) AS buyer,TRIM(GROUP_CONCAT(DISTINCT supplier)) AS supplier,TRIM(GROUP_CONCAT(DISTINCT uom)) AS uom,TRIM(GROUP_CONCAT(DISTINCT inv_no)) AS inv FROM $bai_rm_pj1.sticker_report WHERE batch_no=\"".$batch_no."\" and lot_no in ('".$lot_no_ref."')";
			$result1=mysqli_query($link, $sql1) or die("Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1=mysqli_fetch_array($result1))
			{
				$rej_item_code=$row1["item_code"];
				$rej_item_name=$row1["item_name"];
				$rej_item_color=$row1["item_color"];
				$rej_lots=$row1["lot_no"];
				$rej_pos=$row1["po_no"];
				$buyer=$row1["buyer"];
				$supplier=$row1["supplier"];
				$uom=$row1["uom"];
				$inv=$row1["inv"];
			}
		
			$rej_lot_exp=explode(",",$rej_lots);
			$rej_item_code_exp=explode(",",$rej_item_code);
			$rej_item_color_exp=explode(",",$rej_item_color);
			$supplier_exp=explode(",",$supplier);
			$buyer_exp=explode(",",$buyer);
			$uom_exp=explode(",",$uom);
			$inv_exp=explode(",",$inv);
			$rej_item_name_exp=explode(",",$rej_item_name);
			
			$rejqty=0;
			$sql4="select SUM(qty_rec) AS recv_qty,SUM(partial_appr_qty) AS rejqty,roll_status as sts from $bai_rm_pj1.store_in where roll_status in ('1','2') and lot_no in ('".$lot_no_ref."') group by tid";	
			// echo $sql4."<br>";
			$result4=mysqli_query($link, $sql4) or die("Error4=".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row4=mysqli_fetch_array($result4))
			{
				if ($row4["sts"] == 2)
		        {
		            $rejqty = $rejqty + $row4["rejqty"];
		        }
		        else
		        {
		            $rejqty = $rejqty + $row4["recv_qty"];
		        }
			}
		
			$lenrejqty=0;
			$sql6="select SUM(qty_rec) AS recv_qty,SUM(ref5) AS ctexqty from $bai_rm_pj1.store_in where lot_no in ('".$lot_no_ref."') group by tid";
			// echo $sql6."<br>";
			$result6=mysqli_query($link, $sql6) or die("Error6=".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row6=mysqli_fetch_array($result6))
			{

				  $lenrejqty = $lenrejqty + ($row6["recv_qty"]-$row6["ctexqty"]);
				 
			}

			if($lenrejqty < 0)
			{
				$lenrejqty=0;
			}
			
			echo "<br/><br/>";
			echo "<form name='test1' action=\"?r=".$_GET["r"]."\" method=\"post\">";
			echo "<div class='table-responsive'>";
			
			echo "<table  styel=' border: 1px solid black;' runat=\"server\" class='table jambo_table bulk_action table-bordered'>";
			echo "<tr class='headings'>";
			echo "<th class=\"style1\"><input type=\"hidden\" class=\"form-control\" name=\"txtcomcat\" value=\"".$comcat_type."\" />Complaint Product</th><td>".$comcat_type."</td>";
			echo "<th>Complaint Category</th>";
	
			echo "<td>";
			echo "<select name=\"selcomcat\" id=\"selcomcat\" class=\"form-control\" required>";
			echo "<option value='' selected disabled>Please Select</option>";
			echo "<option value='Rejected'>Rejected</option>";
			echo "<option value='Replacement'>Replacement</option>"; 
			echo "<option value='Rejected & Replacement'>Both</option>"; 
			echo "</td>";	  
			echo "<th>Batch No</th><td><input type=\"hidden\" class=\"form-control\"  name=\"txtbatchref\" value=\"".$batch_no."\" />$batch_no</td>";
			echo "<th>PO No</th><td><input type=\"hidden\" class=\"form-control\" name=\"txtporef\" value=\"".$rej_pos."\" />".$rej_pos."</td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<th class=\"style2\">Rejected Lot Nos</th>";
			echo "<td>";
			for($i=0;$i<sizeof($rej_lot_exp);$i++)
			{
				echo "<input type='text' name=\"selrejlots[]\" class=\"form-control\" value=\"$rej_lot_exp[$i]\" readOnly='true'>";
			}
			echo "</td>";
			echo "<th>Item Desc</th>";
			echo "<td>";
			for($i=0;$i<sizeof($rej_item_name_exp);$i++)
			{
				echo "<input type='text' name=\"selrejitemname[]\" class=\"form-control\" value=\"$rej_item_name_exp[$i]\" readOnly='true'>";
			}
			echo "</td>";
			echo "<th>Rejected Item Codes or SKU</th>";
			echo "<td>";
			for($i=0;$i<sizeof($rej_item_code_exp);$i++)
			{
				echo "<input type='text' name=\"selrejsku[]\" class=\"form-control\" value=\"$rej_item_code_exp[$i]\" readOnly='true'>";
			}
			echo "</td>";
			echo "<th>Rejected Item Colors</th>";
			echo "<td>";
			for($i=0;$i<sizeof($rej_item_color_exp);$i++)
			{
				echo "<input type='text' name=\"selrejcolors[]\" class=\"form-control\" value=\"$rej_item_color_exp[$i]\" readOnly='true'>";
			}
			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<th class=\"style1\">Supplier</th>";
			echo "<td>";
			for($i=0;$i<sizeof($supplier_exp);$i++)
			{
				echo "<input type='text' name=\"selsuppliers[]\" class=\"form-control\" value=\"$supplier_exp[$i]\"readOnly='true'>";
			}
			echo "</td>";
			echo "<th>Invoice No</th>";
			echo "<td>";
			for($i=0;$i<sizeof($inv_exp);$i++)
			{
				echo "<input type='text' name=\"selrejinvs[]\" class=\"form-control\" value=\"$inv_exp[$i]\" readOnly='true'>";
			}
			echo "</td>";
			echo "<th>Buyer</th>";
			echo "<td>";
			for($i=0;$i<sizeof($buyer_exp);$i++)
			{
				echo "<input type='text' name=\"selbuyer[]\" class=\"form-control\" value=\"$buyer_exp[$i]\"  readOnly='true'>";

			}
			echo "</td>";
			echo "<th>Remarks</th>";
			echo "<td><textarea name=\"txtcomremarks\" class=\"form-control\" rows=\"4\" cols=\"20\"></textarea></td>";
			echo "</tr>";
			echo "<tr>";
			echo "<th class=\"style2\">Purchase Width</th>";
			echo "<td><input type=\"text\" class=\"form-control float\"  size=10 name=\"txtpurwid\" value=\"0\" />";
			echo "<th class=\"style2\">Actual Width</th>";
			echo "<td><input type=\"text\" class=\"form-control float\" size=10 name=\"txtactwid\" value=\"0\" />";
			echo "<th class=\"style2\">Purchase GSM</th>";
			echo "<td><input type=\"text\" class=\"form-control float\" size=10 name=\"txtpurgsm\" value=\"0\" />";
			echo "<th class=\"style2\">Actual GSM</th>";
			echo "<td><input type=\"text\" class=\"form-control float\"   size=10 name=\"txtactgsm\" value=\"0\" />";
			echo "</tr>";
			echo "<tr>";
			echo "<th class=\"style2\">Sample Inspected Qty</th><td><input type=\"text\" class=\"form-control float\"  size=10 name=\"txtinspqty\" value=\"0\" /></td>";
			echo "<th class=\"style2\">Rejected Total</th>";
			echo "<td><input type=\"text\" class=\"form-control float\"  size=10 name=\"txtrejtot\" id=\"txtrejtot\"  value=\"".(round($rejqty,2)-$reject_roll_qty_sum)."\" /><input type=\"hidden\" class=\"form-control float\"  size=10 name=\"txtrejtot1\" id=\"txtrejtot1\"  value=\"".(round($rejqty,2)-$reject_roll_qty_sum)."\" />";
			echo "</td>";
			echo "<th>Replacement Qty</th>";
			echo "<td><input type=\"text\" class=\"form-control float\"  size=10  name=\"txtlenshrtqty\" id=\"txtlenshrtqty\" value=\"".(round($lenrejqty,2)-$reject_len_qty_sum)."\" /><input type=\"hidden\" class=\"form-control float\"  size=10 name=\"txtlenshrtqty1\" id=\"txtlenshrtqty1\"  value=\"".(round($lenrejqty,2)-$reject_len_qty_sum)."\" /></td>";
			echo "<th>UOM</th><td><select name=\"seluom\" class=\"form-control\">";
			for($i=0;$i<sizeof($uom_exp);$i++)
			{
				echo "<option>".$uom_exp[$i]."</option>";
			}
			echo "</select></td>";
			echo "</tr>";
			echo "</table>";
			echo "<div class='col-md-6'>";
			echo "<table class='table table-bordered'>";
			echo "<tr ><th class=\"tblheading\">Reason</th><th>Effected Qty</th><th>Ratings</th><th>Remarks</th></tr>";	
			$sql5="select * from $bai_rm_pj1.inspection_complaint_reasons where status=1 and complaint_category=\"$comcat_type\"";
			// echo $sql5."<br>";
			$result5=mysqli_query($link, $sql5) or die("Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row5=mysqli_fetch_array($result5))
			{
				if($row5["complaint_reason"]=="LENGTH")
				{
					echo "<tr>";
					echo "<td><input type=\"hidden\" class=\"form-control\" name=\"txtindrejsno[]\" value=\"".$row5["sno"]."\" />".$row5["complaint_reason"]."</td>";
					echo "<td><input type=\"text\" readonly class=\"form-control float\" name=\"txtindrejqty[]\" id=\"txtindrejqty[]\"  size=\"8\" value=\"".round(($lenrejqty-$reject_len_qty_sum),2)."	\" />";
					echo "<td><input type=\"text\" readonly class=\"form-control integer \" name=\"txtindrejrat[]\" size=\"8\" value=\"".($len_shrt*-1)."\" />";
					echo "<td><input type=\"text\" class=\"form-control\" name=\"txtindrejrem[]\" size=\"15\" value=\"\" />";			
					echo "</tr>";
				}
				else
				{
					echo "<tr>";
					echo "<td><input type=\"hidden\" class=\"form-control\" name=\"txtindrejsno[]\" value=\"".$row5["sno"]."\" />".$row5["complaint_reason"]."</td>";
					echo "<td><input type=\"text\" class=\"form-control float\" name=\"txtindrejqty[]\"  id=\"txtindrejqty[]\"  size=\"8\" value=\"0\" />";
					echo "<td><input type=\"text\" class=\"form-control integer\" name=\"txtindrejrat[]\" size=\"8\" value=\"0\" />";
					echo "<td><input type=\"text\" class=\"form-control\" name=\"txtindrejrem[]\" size=\"15\" value=\"\" />";			
					echo "</tr>";
				}
			}	
			echo "</table>";	
		    echo "</div>";
		    echo "</div>";

			echo "<br><br><div class='col-md-12'><div class='col-md-2'><label>Complaint Category:</label></div><div class='col-md-2'><select name=\"comcatref\" class=\"form-control\">";
			echo "<option value=0>External</option>";
			echo "<option value=1>Internal</option>"; 
			echo "</select></div></div><br></br>";
			echo "<div class='col-md-12'>";
			echo '<div class="col-md-1"><p align=\"center\"><input type="checkbox" name="option" class=\"form-control\"  id="option" onclick="return enableButton();">Enable</div>';
			
			echo "<div class='col-md-2'>";
			echo "<input type=\"submit\" id=\"submitx\"  name=\"submitx\" value=\"Update\" class=\"btn btn-success\" disabled><p></div></div>";
			
		}
		
	}
	echo "<script>
		var rejtot=document.getElementById('txtrejtot').value;
		var repqty=document.getElementById('txtlenshrtqty').value;
		
		if(rejtot>0 && repqty>0)
		{
			document.getElementById('selcomcat').value='Rejected & Replacement';
		}
		else if(repqty>0)
		{
			document.getElementById('selcomcat').value='Replacement';
		}
		else if(rejtot>0)
		{
			document.getElementById('selcomcat').value='Rejected';	

		}
		else
		{
			sweetAlert('You cant claim for this batch','since there is no rejections & replacements','info');
		}
		$('#selcomcat').on('change',function(){
			var selcomcat = document.getElementById('selcomcat').value;
			if(selcomcat == 'Rejected & Replacement') {
				document.getElementById('txtlenshrtqty').value=document.getElementById('txtlenshrtqty1').value;
				document.getElementById('txtrejtot').value=document.getElementById('txtrejtot1').value;
				document.getElementById('txtrejtot').disabled=false;
				document.getElementById('txtlenshrtqty').disabled=false;
			}
			else if(selcomcat == 'Rejected') {
				document.getElementById('txtlenshrtqty').value=0;
				document.getElementById('txtlenshrtqty').disabled=true;
				document.getElementById('txtrejtot').disabled=false;
				document.getElementById('txtrejtot').value=document.getElementById('txtrejtot1').value;
				if(document.getElementById('txtrejtot1').value < document.getElementById('txtrejtot').value){
					document.getElementById('submitx').disabled=true;
					return false;
				}
				
			}
			else if (selcomcat == 'Replacement') {
				document.getElementById('txtrejtot').value=0;
				document.getElementById('txtrejtot').disabled=true;
				document.getElementById('txtlenshrtqty').disabled=false;
				document.getElementById('txtlenshrtqty').value=document.getElementById('txtlenshrtqty1').value;
				
			}
		});
		$(document).on('ready',function(){
			if(document.getElementById('txtlenshrtqty').value < 0 ){
				document.getElementById('txtlenshrtqty').value=0;
			}
		});
		// $('#txtrejtot').on('change',function(){
		// 	if(document.getElementById('txtrejtot1').value < document.getElementById('txtrejtot').value){
		// 		document.getElementById('txtrejtot').value=0;
		// 		document.getElementById('txtlenshrtqty').value=0;
		// 		sweetAlert('You cant claim for this batch','since there is no rejections & replacements','info');
		// 	}
		// });

		// $('#txtlenshrtqty').on('change',function(){
		// 	if(document.getElementById('txtlenshrtqty1').value < document.getElementById('txtlenshrtqty').value){
		// 		document.getElementById('txtrejtot').value=0;
		// 		document.getElementById('txtlenshrtqty').value=0;
		// 		sweetAlert('You cant claim for this batch','since there is no rejections & replacements','info');
		// 	}
		// });
		

	</script>";
	
}

?>

</form>
<?php
if(isset($_POST['submitx']))
{
	$rej_com_sno=$_POST["txtindrejsno"];
	$rej_ind_qty=$_POST["txtindrejqty"];
	$rej_ind_rat=$_POST["txtindrejrat"];
	$rej_ind_remarks=$_POST["txtindrejrem"];
	$lenrejqty_ref=$_POST["txtlenshrtqty"];
	$rejqty_ref=$_POST["txtrejtot"];
	$batch_no_ref=$_POST["txtbatchref"];
	$po_no_ref=$_POST["txtporef"];
	$lot_no_ref=$_POST["selrejlots"];
	$item_codes_ref=$_POST["selrejsku"];
	$item_colors_ref=$_POST["selrejcolors"];
	$buyer_ref=$_POST["selbuyer"];
	$supplier_ref=$_POST["selsuppliers"];
	$invoice_ref=$_POST["selrejinvs"];
	$item_name_ref=$_POST["selrejitemname"];
	$comcat_type_ref=$_POST["txtcomcat"];
	$comcat_mode_ref=$_POST["selcomcat"];
	$uom_ref=$_POST["seluom"];
	$comaplint_remarks=$_POST["txtcomremarks"];
	$purchase_width=$_POST["txtpurwid"];
	$actual_width=$_POST["txtactwid"];
	$purchase_gsm=$_POST["txtpurgsm"];
	$actual_gsm=$_POST["txtactgsm"];
	$comcatref=$_POST["comcatref"];
	$rejected_roll_qty=$_POST["txtrejtot"];
	$rejected_len_qty=$_POST["txtlenshrtqty"];
	$inspqty_lot=$_POST["txtinspqty"];
	
	$totla_rej_qty=$rejected_len_qty+$rejected_roll_qty;
	
	$lot_no_ref_final="";
	$item_codes_ref_final="";
	$item_colors_ref_final="";
	$buyer_ref_final="";
	$supplier_ref_final="";
	
	if(sizeof($lot_no_ref) > 0)
	{
		$lot_no_ref_final=implode(",",$lot_no_ref);
	}
	
	if(sizeof($item_codes_ref)>0)
	{
		$item_codes_ref_final=implode(",",$item_codes_ref);
	}
	
	if(sizeof($item_colors_ref)>0)
	{
		$item_colors_ref_final=implode(",",$item_colors_ref);
	}
	
	if(sizeof($buyer_ref)>0)
	{
		$buyer_ref_final=implode(",",$buyer_ref);
	}
	
	if(sizeof($supplier_ref)>0)
	{
		$supplier_ref_final=implode(",",$supplier_ref);
	}
	
	if(sizeof($invoice_ref)>0)
	{
		$invoice_ref_final=implode(",",$invoice_ref);
	}
	
	if(sizeof($item_name_ref)>0)
	{
		$item_name_ref_final=implode(",",$item_name_ref);
	}
	
	$max_complaint_no=0;
	$sql7="select max(complaint_No) as comno from $bai_rm_pj1.inspection_complaint_db";
	$result7=mysqli_query($link, $sql7) or die("Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row7=mysqli_fetch_array($result7))
	{
		$max_complaint_no=$row7["comno"];
	}
	
	if($max_complaint_no > 0)
	{
		$max_complaint_no=$max_complaint_no+1;
	}
	else
	{
		$max_complaint_no=1;
	}
	
	//Added Year Clause for reset the sequence starting form 1
	if($comcatref==0)
	{
		$sql11="SELECT * FROM $bai_rm_pj1.inspection_complaint_db WHERE TRIM(supplier_name)=\"".trim($supplier_ref_final)."\" and year(req_date)=\"".date("Y")."\" and product_categoy=\"".$comcat_type_ref."\" AND complaint_cat_ref=0";
		$cat_staring="";
	}
	else
	{
		$sql11="select * from $bai_rm_pj1.inspection_complaint_db WHERE TRIM(supplier_name)=\"".trim($supplier_ref_final)."\" and year(req_date)=\"".date("Y")."\" and product_categoy=\"".$comcat_type_ref."\" AND complaint_cat_ref=1";
		$cat_staring="INT";
	}
	$result11=mysqli_query($link, $sql11) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows_count=mysqli_num_rows($result11);
	
	$complaint_no_initial=0;
	
	$max_complaint_nos=0;
	
	$sql12="select * from $bai_rm_pj1.inspection_supplier_db WHERE product_code=\"".$comcat_type_ref."\" AND TRIM(supplier_m3_code)=\"".trim($supplier_ref_final)."\"";
	$result12=mysqli_query($link, $sql12) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row12=mysqli_fetch_array($result12))
	{
		$complaint_no_initial=$row12["complaint_no"];
		$supplier_code=$row12["supplier_code"];
	}
	
	if(date("Y")=="2014")
	{
		$complaint_no_initial=$complaint_no_initial;
	}
	else
	{
		$complaint_no_initial=1;
	}
	
	$max_complaint_nos=$max_complaint_nos+$complaint_no_initial+$rows_count;
	
	
	$add_string="0";	
	
	if($max_complaint_nos > 0 && $max_complaint_nos < 10)
	{
		$add_string="000";
	}
	else if($max_complaint_nos > 9 && $max_complaint_nos < 100)
	{
		$add_string="00";
	}
	else if($max_complaint_nos > 99 && $max_complaint_nos < 999)
	{
		$add_string="0";
	}

	$sql8="insert into $bai_rm_pj1.inspection_complaint_db(product_categoy,complaint_category,complaint_raised_by,supplier_name,buyer_name,reject_item_codes,reject_item_color,reject_batch_no,reject_po_no,reject_lot_no,reject_roll_qty,reject_len_qty,uom,complaint_remarks,reject_inv_no,reject_item_desc,ref_no,complaint_no,req_date,purchase_width,actual_width,purchase_gsm,actual_gsm,inspected_qty,complaint_cat_ref) values(\"".$comcat_type_ref."\",\"".$comcat_mode_ref."\",\"".$username."\",\"".$supplier_ref_final."\",\"".$buyer_ref_final."\",\"".$item_codes_ref_final."\",\"".$item_colors_ref_final."\",\"".$batch_no_ref."\",\"".$po_no_ref."\",\"".$lot_no_ref_final."\",\"".$rejected_roll_qty."\",\"".$rejected_len_qty."\",\"".$uom_ref."\",\"".$comaplint_remarks."\",\"".$invoice_ref_final."\",\"".str_replace('"',"",$item_name_ref_final)."\",\"".$supplier_code."".$cat_staring."".$add_string."".$max_complaint_nos."\",\"".$max_complaint_no."\",\"".date("Y-m-d H:i:s")."\",\"".$purchase_width."\",\"".$actual_width."\",\"".$purchase_gsm."\",\"".$actual_gsm."\",\"".$inspqty_lot."\",\"".$comcatref."\")";

	mysqli_query($link, $sql8) or die("Error8=".mysqli_error($GLOBALS["___mysqli_ston"]));
	for($i=0;$i<sizeof($rej_com_sno);$i++)
	{
		if($rej_ind_qty[$i] > 0)
		{
			$sql9="insert into $bai_rm_pj1.inspection_complaint_db_log(complaint_track_id,complaint_reason,complaint_rej_qty,complaint_rating,complaint_commnets) values(\"".$max_complaint_no."\",\"".$rej_com_sno[$i]."\",\"".$rej_ind_qty[$i]."\",\"".$rej_ind_rat[$i]."\",\"".$rej_ind_remarks[$i]."\")";
			mysqli_query($link, $sql9) or die("Error9=".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
	// echo $sql8."<br>";
	// echo $sql9."<br>";
	// die();

	
	echo "<script>sweetAlert('Successfully','Updated','success')</script>";
	$url = getFullURLLevel($_GET['r'],'Supplier_Claim_Request_Form.php',0,'N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",180); function Redirect() {  location.href = \"$url&batch=$batch_no_ref&sellotnosrefnew=$lot_no_ref_final&selcompro=$comcat_type_ref\"; }</script>";
}
?>
</body>

</div>
</div>
</div>
