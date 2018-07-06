<?php
// Need to show summary of batches and update the log time for fully filled batches. Total Batches || Updated Batches || Pending Batches || Passed Batches || Failed Batches
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/headers.php',1,'R')); 
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
$Page_Id='SFCS_0054';
?>

<?php  


//$sql="select * from $bai_rm_pj1.inspection_supplier_db where product_code=\"Fabric\"";
$sql="SELECT * FROM $bai_rm_pj1.sticker_report WHERE product_group='Fabric' GROUP BY supplier";
$sql_result=mysqli_query($link, $sql) or exit("No Data Avaiable".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$supplier_code[]=$sql_row["supplier"];
}
if(isset($_POST['filter']))
{
	$supplier1=$_POST['supplier'];
	$supplier_list1=array();
	if($supplier1)
	{
		foreach ($supplier1 as $t1)
	    {
			$supplier_list1[]=$t1;
		}
	}
}
else
{	
	$supplier_list1=array();
	$supplier_list1[]="All";
}

?>

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/FusionCharts.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/FusionChartsExportComponent.js',3,'R'); ?>"></script>


<style>
.textbox{
	background-color:#99ff88;
	width:auto;
	border:none;
	color:black;
	height:100%;
}
.listbox{
	background-color:#99ff88;
	width:100%;
	border:none;
	color:black;
	height:100%;
}
.textspace{
	background-color:#99ff88;
	width:100%;
	border:none;
	color:black;
	height:100%;
}
</style>

<script>
function dodisablenew()
{
	document.getElementById('update').disabled='true';
}


function enableButton() 
{
	if(document.getElementById('option').checked)
	{
		document.getElementById('update').disabled='';
	} 
	else 
	{
		document.getElementById('update').disabled='true';
	}
}

function change_body(x,y,z)
{
	
	document.getElementById(y).style.background="#FFCCFF";
}


</script>

<script language="javascript" type="text/javascript">

function popitup(url) {
	newwindow=window.open(url,'name','height=500,width=650,resizable=yes,scrollbars=1,menubar=1');
	if (window.focus) {newwindow.focus()}
	return false;
}


</script>



<div class="panel panel-primary">
<div class="panel-heading">Supplier Performance Report Update</div>
<div class="panel-body">


<body onload="javascript:dodisablenew();">

<form name="input" method="post" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">
<div class="row">
<div class="col-md-2">
<label>
Start Date </label><input type="text" class="form-control" data-toggle="datepicker" id="demo1"  name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"> 
</div>
<div class="col-md-2">
<label>End Date </label><input  type="text" data-toggle='datepicker' class="form-control" size="8" name="edate" id="demo2"  value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>">
</div>
<div class="col-md-2">
<label> Batch Ref </label><input type="text" name="batch_obj" class="form-control alpha" id="batch_obj" size=8 value="<?php if(isset($_POST['batch_obj'])) { echo $_POST['batch_obj']; }?>">
</div>
<div class="col-md-3">
<label>Supplier</label>
<select name="supplier[]" multiple="multiple" class="form-control"> 
<?php
echo implode(",",$supplier_list1);
if(in_array("All",$supplier_list1))
{	
	echo "<option value=\"All\" selected>All</option>";
}
else
{
	echo "<option value=\"All\">All</option>";
}

for($i=0;$i<sizeof($supplier_code);$i++)
{
	if(in_array($supplier_code[$i],$supplier_list1))
	{
		echo "<option value=\"".$supplier_code[$i]."\" selected>".$supplier_code[$i]."</option>";
	}
	else
	{
		echo "<option value=\"".$supplier_code[$i]."\">".$supplier_code[$i]."</option>";
	}
}

?>
</select>
</div>
<div class="col-md-2">
<label></label>
<input type="checkbox" value="1" name="excemptflag" id="excemptflag" >&nbsp;&nbsp;Excempt Inspection/Relaxation Results
</div>
<input type="submit" name="filter" value="Filter" onclick="return pop_check()" class="btn btn-success" style="margin-top: 22px;">
</div>
</form>

<?php

if(isset($_POST['filter']))
{
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$batch_obj=$_POST["batch_obj"];
	//var_dump($_POST['supplier']);
	$supplier_ref_codes=$_POST['supplier'];
	$add_query="";
	
	if($supplier_ref_codes)
	{
		foreach ($supplier_ref_codes as $s)
	    {
			$suppliers_list[]=$s;
		}
	}
	
	for($ix=0;$ix<sizeof($suppliers_list);$ix++)
	{
		if($ix==0)
		{
			$supplier_ref[]="'".$suppliers_list[$ix]."'";
		}
		else
		{
			$supplier_ref[]=",'".$suppliers_list[$ix]."'";
		}
	}
	
	if(strlen(trim($batch_obj)) > 0)
	{
		$add_query=" and batch_no=\"".$batch_obj."\"";
	}
	
	$suppliers_list_ref=implode("",$supplier_ref);
	
	if($suppliers_list_ref=="'All'")
	{
		for($i2=0;$i2<sizeof($supplier_code);$i2++)
		{
			if($i2==0)
			{
				$supplier_ref1[]="'".$supplier_code[$i2]."'";
			}
			else
			{
				$supplier_ref1[]=",'".$supplier_code[$i2]."'";
			}
		}
	
		$suppliers_list_ref_query=" and supplier in (".implode("",$supplier_ref1).") ";		
	}
	else
	{
		$suppliers_list_ref_query=" and supplier in (".$suppliers_list_ref.") ";		
	}
	
	
	$complaint_reason=array();
	$comaplint_sno=array();
	
	$sql2="SELECT sno,complaint_reason FROM $bai_rm_pj1.inspection_complaint_reasons WHERE complaint_category=\"Fabric\" ORDER BY sno";
	//echo "</br>".$sql2."<br>";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$complaint_reason[]=$sql_row2["complaint_reason"];
		$comaplint_sno[]=$sql_row2["sno"];
	}
	
	
	$url=getFullURL($_GET['r'],'supplier_per_charts.php','N');
	$url1=getFullURLLevel($_GET['r'],'reports/supplier_perf_v2_report.php',1,'N');
	echo "<div id='main_div'>";
	echo "<hr/>";
	echo "<a href=\"$url&sdate=$sdate&edate=$edate&suppliers=".str_replace("'","*",$suppliers_list_ref_query)."\" onclick=\"return popitup('$url&sdate=$sdate&edate=$edate&suppliers=".str_replace("'","*",$suppliers_list_ref_query)."')\"><button class='btn btn-info btn-sm'>Click Here For Charts</button></a>&nbsp;&nbsp;&nbsp;&nbsp; || &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$url1\"><button class='btn btn-info btn-sm'>Click Here For Log Report</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class='abc'> </span> Preformance Updated &nbsp;&nbsp;||&nbsp;&nbsp; <span> </span> Performance Not Updated</a>";
	
	include($_SERVER['DOCUMENT_ROOT'].getFullURL($_GET['r'],'supplier_perf_summary.php','R'));
	
	echo "<form action='".getFullURL($_GET['r'],'supplier_perf_v2_update.php','N')."' 
	       method='POST'>";
	echo "<div class='table-responsive'><div style='height:350px; overflow-y: scroll;''><table cellspacing=\"0\" id=\"table1\" class=\"table table-bordered\">";
	echo "<tr><th>RECORD #</th><th>WEEK #</th><th>ENTRY NO</th><th>INVOICE NO & DATE</th><th>SWATCHES RECEIVED DATE FROM STORES</th><th>SWATCHES RECEIVED TIME FROM STORES</th>
	<th>SWATCHES RECEIVED FROM (SUPPLIER/WH)</th><th>INSPECTED DATE</th><th>RELEASED DATE</th><th>REPORT #</th><th>GRN.DATE</th><th>ENT. DATE</th><th>BUYER</th><th>STYLE</th>
	<th>M3 LOT#</th><th>PO</th><th>SUPPLIER</th><th>QUALITY</th><th>RM SPECIALTY</th><th>CONSTRUCTION</th><th>COMPOSITION</th><th>COLOR</th><th>SOLID / YARN DYE / PRINT</th><th>BATCH #</th>
	<th>NO OF ROLLS</th><th>QTY $fab_uom</th><th>C TEX LENGTH</th><th>C TEX L/S</th><th>INSPECTED TAG STY ($fab_uom)</th><th>INSPECTED ACT STY ($fab_uom)</th><th>WIDTH MEASURING UNIT</th>
	<th>PURCHASE WIDTH </th><th>ACTUAL WIDTH </th><th>PURCHASED WEIGHT (GSM)</th><th>ACTUAL WEIGHT (GSM)</th><th>CONSUMPTION</th><th>PTS./100 SQ. $fab_uom OR FAULT RATE</th>
	<th>GMT FALLOUT% (FAB.INS)</th><th>FREQUENTLY SEEN DEFECTS</th><th>SKEW /    BOW / WAVINESS /  DOG-LEG</th><th>SKEW /    BOW / WAVINESS /  DOG-LEG %</th><th>RESIDUAL SHRINKAGE LENGTH</th>
	<th>RESIDUAL SHRINKAGE WIDTH</th><th>SUPPLIER TEST REPORT (PASS/FAIL/NA)</th><th>AT SOURCE INSPECTION 10% REPORT (YES /NO)</th><th>AT SOURCE INSPECTION C.C REPORT (YES /NO)</th>
	<th>COMPLAINT#</th><th>REJECTED QTY ($fab_uom)</th><th>FAIL REASON1</th><th>REASON 1 VALUE</th><th>FAIL REASON 2</th><th>REASON 2 VALUE</th><th>FAB TECH DECISION</th>";
	$n=0;
	for($i=0;$i<sizeof($complaint_reason);$i++)
	{
		echo "<th>".$complaint_reason[$i]."</th>";
	}
	echo "<th>STATUS</th><th>IMPACT (YES/NO)</th></tr>";
	$sql="select distinct supplier as sup from $bai_rm_pj1.sticker_report WHERE DATE(grn_date) BETWEEN \"".$sdate."\" AND \"".$edate."\" ".$add_query." AND product_group=\"Fabric\" ".$suppliers_list_ref_query." group by month(grn_date),batch_no ORDER BY supplier";
	//echo "</br> Supplier Qry :".$sql."<br>";

	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
$flag=false;
if(mysqli_num_rows($sql_result) > 0){
	$flag=true;

	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$supplier_name=$sql_row["sup"];
		
		$sql1="select count(distinct batch_no) as batch_no from $bai_rm_pj1.sticker_report WHERE DATE(grn_date) BETWEEN \"".$sdate."\" AND \"".$edate."\" ".$add_query." AND product_group=\"Fabric\" and supplier=\"".$supplier_name."\" group by month(grn_date),batch_no";
		// echo $sql1."<br>";
		
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$batch_count=$sql_row1["batch_no"];
		}	
		$j=0;
		$t=0;
		$sql1x="select distinct batch_no as batch_no,month(grn_date) as mnt from $bai_rm_pj1.sticker_report WHERE DATE(grn_date) BETWEEN \"".$sdate."\" AND \"".$edate."\" ".$add_query." AND product_group=\"Fabric\" and supplier=\"".$supplier_name."\" group by month(grn_date),batch_no";
		// echo $sql1x."<br>";
		$sql_result1x=mysqli_query($link, $sql1x) or exit("Sql Error".$sql1x.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1x=mysqli_fetch_array($sql_result1x))
		{	
			$n=$n+1;
			$mnt=$sql_row1x["mnt"];
			$batch_ref=$sql_row1x["batch_no"];

			$sql_fet="select * from $bai_rm_pj1.supplier_performance_track where tid=\"".trim($batch_ref)."-".$mnt."\"";
			//echo $sql_fet."<br>";
			$sql_result_fet=mysqli_query($link, $sql_fet) or exit("Sql Error".$sql_fet."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result_fet) > 0)
			{
				while($sql_row_fet=mysqli_fetch_array($sql_result_fet))
				{
					$srdfs=$sql_row_fet["srdfs"];
					if($srdfs=="0000-00-00")
					{
						$srdfs="";
					}
					$srtfs=$sql_row_fet["srtfs"];
					if($srtfs=="0000-00-00")
					{
						$srtfs="";
					}
					$srdfsw=$sql_row_fet["srdfsw"];
					if($srdfsw=="0000-00-00")
					{
						$srdfsw="";
					}
					$reldat=$sql_row_fet["reldat"];
					if($reldat=="0000-00-00")
					{
						$reldat="";
					}
					$quality=$sql_row_fet["quality"];
					$rms=$sql_row_fet["rms"];
					$const=$sql_row_fet["const"];
					$compo=$sql_row_fet["compo"];
					$syp=$sql_row_fet["syp"];
					$qty_insp_act=$sql_row_fet["qty_insp_act"];
					//$pur_gsm=$sql_row_fet["pur_gsm"];
					$consumption=$sql_row_fet["consumption"];
					$defects=$sql_row_fet["defects"];
					$sup_test_rep=$sql_row_fet["sup_test_rep"];
					$inspec_per_rep=$sql_row_fet["inspec_per_rep"];
					$cc_rep=$sql_row_fet["cc_rep"];
					$fab_tech=$sql_row_fet["fab_tech"];
					$log_time=$sql_row_fet["log_time"];
				}
			}
			else
			{
				$srdfs="";
				$srtfs="";
				$srdfsw="";
				$reldat="";
				$quality="";
				$rms="";
				$const="";
				$compo="";
				$syp="";
				$qty_insp_act="";
				//$pur_gsm="";
				$consumption="";
				$defects="";
				$sup_test_rep="";
				$inspec_per_rep="";
				$cc_rep="";
				$fab_tech="";
			}
			//echo $log_time."</br>";
			if($log_time=="0000-00-00 00:00:00"){
				$tr_color="#d00b0b";
			}else{
				$tr_color="#2c7b038a";
			}
			//echo $tr_color."</br>";
			echo "<tr style='background-color:".$tr_color."'>";	
			echo "<td><input type=\"hidden\" name=\"bai1_rec[".$n."]\" id=\"bai1_rec\" value=\"3\"><input type=\"hidden\" name=\"month[".$n."]\" id=\"bai1_rec\" value=\"".$mnt."\">3</td>";
			
			

			//echo $log_time."</br>";			
			$sql1l="select DATE(grn_date) as dat,week(grn_date)+1 as wkno,month(grn_date) as mnt,inv_no,item as item,GROUP_CONCAT(CONCAT(\"'\",lot_no,\"'\")) as lot,po_no as po,item_desc as col,pkg_no,item_name from $bai_rm_pj1.sticker_report WHERE DATE(grn_date) BETWEEN \"".$sdate."\" AND \"".$edate."\" AND product_group=\"Fabric\" and batch_no=\"".$batch_ref."\" and supplier=\"".$supplier_name."\" and month(grn_date)=\"".$mnt."\"";
			// echo $sql1l."<br>";
			$sql_result1l=mysqli_query($link, $sql1l) or exit("Sql Error".$sql1l.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1l=mysqli_fetch_array($sql_result1l))
			{
				$week_no=$sql_row1l["wkno"];
				$inv_no=$sql_row1l["inv_no"];
				$grn_date=$sql_row1l["dat"];
				$item=$sql_row1l["item"];
				$lots_ref=$sql_row1l["lot"];
				$po_ref=$sql_row1l["po"];
				$color_ref=$sql_row1l["col"];
				$pkg_no=$sql_row1l["pkg_no"];
				if($pkg_no="'"){
					$pkg_no="";
				}
				$item_desc_ref=$sql_row1l["item_name"];
			}
			
			$rolls_count=0;
			
			if(strlen($lots_ref) > 0)
			{
				$sql3l="select * from $bai_rm_pj1.store_in WHERE lot_no IN (".$lots_ref.")";
				// echo $sql3l."<br>";
				$sql_result3l=mysqli_query($link, $sql3l) or exit("Sql Error".$sql3l.mysqli_error($GLOBALS["___mysqli_ston"]));
				$rows_count=mysqli_num_rows($sql_result3l);
				if($rows_count > 0)
				{
					$rolls_count=$rows_count;
					$sql4l="select SUM(qty_rec) AS tktlen,SUM(ref5) AS ctexlen from $bai_rm_pj1.store_in WHERE lot_no IN (".$lots_ref.")"; 
					// echo $sql4l."<br>";
					$sql_result4l=mysqli_query($link, $sql4l) or exit("Sql Error".$sql4l.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row4l=mysqli_fetch_array($sql_result4l))
					{
						$tktlen=$sql_row4l["tktlen"];
						$ctexlen=$sql_row4l["ctexlen"];
					}
				}
			}

			$buyer="";
			
			if(substr($item,0,1)=="L" || substr($item,0,1)=="O")
			{
				$buyer="VS Logo";
			}
			
			if(substr($item,0,1)=="P" || substr($item,0,1)=="K")
			{
				$buyer="VS Pink";
			}
			
			if(substr($item,0,1)=="M")
			{
				$buyer="M&S";
			}
			
			if(substr($item,0,1)=="C")
			{
				$buyer="CK";
			}
			
			if(substr($item,0,1)=="I")
			{
				$buyer="VS Logo";
			}

			
			$sql2l="select date(log_date) as dat,consumption,act_gsm,pur_gsm,pur_width,act_width,qty_insp,unique_id,pts,fallout,skew_cat,skew,shrink_l, shrink_w, date(log_date) as entdate,status from $bai_rm_pj1.inspection_db where batch_ref=\"".$batch_ref."\"";
			// echo $sql2l."<br>";
			$sql_result2l=mysqli_query($link, $sql2l) or exit("Sql Error".$sql2l.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2l=mysqli_fetch_array($sql_result2l))
			{
				$insp_date=$sql_row2l["dat"];
				$act_gsm=$sql_row2l["act_gsm"];
				$pur_gsm=$sql_row2l["pur_gsm"];
				$pur_width_ref=$sql_row2l["pur_width"];
				$act_width_ref=$sql_row2l["act_width"];
				$qty_insp=$sql_row2l["qty_insp"];
				$unique_id=$sql_row2l["unique_id"];
				$pts=$sql_row2l["pts"];
				$fallout=$sql_row2l["fallout"];
				$skew_cat=$sql_row2l["skew_cat"];
				$skew=$sql_row2l["skew"];
				$shrink_l=$sql_row2l["shrink_l"];
				$shrink_w=$sql_row2l["shrink_w"];
				$entdate=$sql_row2l["entdate"];
				$batch_status_refx=$sql_row2l["status"];
				$consumption_ref=$sql_row2l["consumption"];
				//echo $batch_ref."-".$batch_status_refx."<br>";
			}
			
			//Exempting inspection results for the below transactions
			if($_POST['excemptflag']==1)
			{
				$batch_status_refx=1;
			}
			
			if($skew_cat==1)
			{
				$skew_cat_ref="Skewness";
			}
			
			if($skew_cat==2)
			{
				$skew_cat_ref="Bowing";
			}
			
			$lot_final=str_replace("'","",$lots_ref);
			
			$lot_final_explode=explode(",",$lot_final);
			
			$string_ref="and (";
			$string_ref1="and (";
			
			for($z=0;$z<sizeof($lot_final_explode);$z++)
			{
				if($z!=sizeof($lot_final_explode)-1)
				{
					$string_ref.="a.reject_lot_no LIKE \"%".$lot_final_explode[$z]."%\" or ";
					$string_ref1.="reject_lot_no LIKE \"%".$lot_final_explode[$z]."%\" or ";
				}
				else
				{
					$string_ref.="a.reject_lot_no LIKE \"%".$lot_final_explode[$z]."%\"";
					$string_ref1.="reject_lot_no LIKE \"%".$lot_final_explode[$z]."%\"";
				}
			}
			
			$string_ref.=")";
			$string_ref1.=")";
			
			echo "<td><input type=\"hidden\" name=\"weekno[".$n."]\" id=\"weekno\" value=\"".$week_no."\">".$week_no."</td>";
			echo "<td><input type=\"hidden\" name=\"pkg_no[".$n."]\" id=\"pkg_no\" value=\"".$pkg_no."\">".$pkg_no."</td>";
			echo "<td><input type=\"hidden\" name=\"invoice[".$n."]\" id=\"invoice\" value=\"".$inv_no."\">".$inv_no."</td>";
			echo "<td><input type=\"text\" id=\"srdfs_".$n."\"  data-toggle='datepicker' name=\"srdfs[".$n."]\" size=8 value=\"".$srdfs."\">
			</td>";
			echo "<td><input type=\"time\" class='textbox' name=\"srtfs[".$n."]\" id=\"srtfs\" size=8 size=8 value=\"".$srtfs."\"></td>";
			/*echo "<td>
			<input id=\"srdfsw_".$n."\" onkeypress=\"javascript:NewCssCal('srdfsw_".$n."','yyyymmdd','dropdown')\" onclick=\"javascript:NewCssCal('srdfsw_".$n."','yyyymmdd','dropdown')\" type=\"text\" class='textbox' name=\"srdfsw[".$n."]\" size=8 value=\"".$srdfsw."\">
			</td>";*/
			echo "<td><select name=\"srdfsw[".$n."]\" id=\"srdfsw\" class='form-control'>";
			for($f1=0;$f1<sizeof($swatch_array);$f1++)
			{
				if($swatch_array[$f1] == $srdfsw)
				{
					echo "<option selected value=\"".$swatch_array[$f1]."\">".$swatch_array[$f1]."</option>";
				}
				else
				{
					echo "<option value=\"".$swatch_array[$f1]."\">".$swatch_array[$f1]."</option>";
				}
			}			
			echo "</select></td>";
			
			echo "<td><input type=\"hidden\" name=\"insp_date[".$n."]\" id=\"insp_date_".$n."\" value=\"".$insp_date."\">".$insp_date."</td>";
			echo "<td>
			<input id=\"reldat_".$n."\" type=\"text\" name=\"reldat[".$n."]\" data-toggle='datepicker' size=8 value=\"".$reldat."\">
			</td>";
			echo "<td><input type=\"hidden\" name=\"unique_id[".$n."]\" id=\"unique_id\" value=\"".$unique_id."\">".$unique_id."</td>";
			echo "<td><input type=\"hidden\" name=\"grn_date[".$n."]\" id=\"grn_date\" value=\"".$grn_date."\">".$grn_date."</td>";
			echo "<td><input type=\"hidden\" name=\"entdate[".$n."]\" id=\"entdate\" value=\"$entdate\">".$entdate."</td>";
			echo "<td><input type=\"hidden\" name=\"buyer[".$n."]\" id=\"buyer\" value=\"$buyer\">".$buyer."</td>";
			echo "<td><input type=\"hidden\" name=\"item[".$n."]\" id=\"item\" value=\"$item\">".$item."</td>";
			echo "<td><input type=\"hidden\" name=\"lots_ref[".$n."]\" id=\"lots_ref\" value=\"".str_replace("'","",$lots_ref)."\">".str_replace("'","",$lots_ref)."</td>";
			echo "<td><input type=\"hidden\" name=\"po_ref[".$n."]\" id=\"po_ref\" value=\"".$po_ref."\">".$po_ref."</td>";
			echo "<td><input type=\"hidden\" name=\"supplier_name[".$n."]\" id=\"supplier_name\" value=\"".$supplier_name."\">".$supplier_name."</td>";
			//echo "<td><input type=\"text\" class='textbox' name=\"quality[".$n."]\" id=\"quality\" size=8 value=\"".$quality."\"></td>";
			//echo "<td><input type=\"text\" class='textbox' name=\"rms[".$n."]\" id=\"rms\" size=8 value=\"".$rms."\"></td>";
			echo "<td><input type=\"text\" class='textbox' name=\"quality[".$n."]\" id=\"quality\" size=8 value=\"".$quality."\" ></td>";
			echo "<td><input type=\"text\" class='textbox' name=\"rms[".$n."]\" id=\"rms\" size=8 value=\"".$rms."\"></td>";
			//echo "<td><input type=\"text\" class='textbox' name=\"const[".$n."]\" id=\"const\" size=8 value=\"".$const."\"></td>";
			echo "<td><select name=\"const[".$n."]\" id=\"const\" class='form-control'>";
			for($f=0;$f<sizeof($construction_array);$f++)
			{
				if($construction_array[$f] == $const)
				{
					echo "<option selected value=\"".$construction_array[$f]."\">".$construction_array[$f]."</option>";
				}
				else
				{
					echo "<option value=\"".$construction_array[$f]."\">".$construction_array[$f]."</option>";
				}
			}			
			echo "</select></td>";
			echo "<td><input type=\"hidden\" name=\"compo[".$n."]\" id=\"compo\" size=8 value=\"".$item_desc_ref."\">".$item_desc_ref."</td>";
			echo "<td><input type=\"hidden\" name=\"color_ref[".$n."]\" id=\"color_ref\" value=\"".$color_ref."\">".$color_ref."</td>";
			//echo "<td><input type=\"text\" class='textbox' name=\"syp[".$n."]\" id=\"syp\" size=8 value=\"".$syp."\"></td>";
			echo "<td><select name=\"syp[".$n."]\" id=\"syp\" class='form-control'>";
			for($f1=0;$f1<sizeof($syp_array);$f1++)
			{
				if($syp_array[$f1] == $syp)
				{
					echo "<option selected value=\"".$syp_array[$f1]."\">".$syp_array[$f1]."</option>";
				}
				else
				{
					echo "<option value=\"".$syp_array[$f1]."\">".$syp_array[$f1]."</option>";
				}
			}			
			echo "</select></td>";
			echo "<td><input type=\"hidden\" name=\"batch_ref[".$n."]\" id=\"batch_ref\" value=\"".$batch_ref."\">".$batch_ref."</td>";
			echo "<td><input type=\"hidden\" name=\"rolls_count[".$n."]\" id=\"rolls_count\" value=\"".$rolls_count."\">".$rolls_count."</td>";
			echo "<td><input type=\"hidden\" name=\"tktlen[".$n."]\" id=\"tktlen\" value=\"".round($tktlen,2)."\">".round($tktlen,2)."</td>";
			echo "<td><input type=\"hidden\" name=\"ctexlen[".$n."]\" id=\"ctexlen\" value=\"".round($ctexlen,2)."\">".round($ctexlen,2)."</td>";
			if($tktlen > 0)
			{
				echo "<td><input type=\"hidden\" name=\"lenper[".$n."]\" id=\"lenper\" value=\"".round(($ctexlen-$tktlen)*100/$tktlen,2)."\">".round(($ctexlen-$tktlen)*100/$tktlen,2)."%</td>";
			}
			else
			{
				echo "<td><input type=\"hidden\" name=\"lenper[".$n."]\" id=\"lenper\" value=\"0\">0%</td>";
			}
			echo "<td><input type=\"hidden\" name=\"qty_insp[".$n."]\" id=\"qty_insp\" value=\"".round($qty_insp,2)."\">".round($qty_insp,2)."</td>";
			echo "<td><input type=\"text\" class='textbox' name=\"qty_insp_act[".$n."]\" id=\"qty_insp_act\" size=8 value=\"".$qty_insp_act."\"></td>";
			//echo "<td><input type=\"text\" class='textbox' name=\"len_qty[".$n."]\" id=\"len_qty\" size=8 value=\"\"></td>";
			echo "<td><input type=\"hidden\" name=\"inches[".$n."]\" id=\"inches\" size=8 value=\"Inches\">Inches</td>";
			echo "<td><input type=\"hidden\" name=\"pur_width_ref[".$n."]\" id=\"pur_width_ref\" value=\"".round($pur_width_ref,2)."\">".round($pur_width_ref,2)."</td>";
			echo "<td><input type=\"hidden\" name=\"act_width_ref[".$n."]\" id=\"act_width_ref\" value=\"".round($act_width_ref,2)."\">".round($act_width_ref,2)."</td>";
			echo "<td><input type=\"hidden\" name=\"pur_gsm[".$n."]\" id=\"pur_gsm\" size=8 value=\"".$pur_gsm."\">".$pur_gsm."</td>";
			echo "<td><input type=\"hidden\" name=\"act_gsm[".$n."]\" id=\"act_gsm\" value=\"".$act_gsm."\">".$act_gsm."</td>";
			echo "<td><input type=\"hidden\" name=\"consumption[".$n."]\" id=\"consumption\" size=8 value=\"".$consumption_ref."\">".$consumption_ref."</td>";
			echo "<td><input type=\"hidden\" name=\"pts[".$n."]\" id=\"pts\" value=\"".$pts."\">".$pts."</td>";
			echo "<td><input type=\"hidden\" name=\"fallout[".$n."]\" id=\"fallout\" value=\"".$fallout."\">".$fallout."</td>";
			//echo "<td><input type=\"text\" class='textbox' name=\"defects[".$n."]\" id=\"defects\" size=8 value=\"".$defects."\"></td>";
			echo "<td><select name=\"defects[".$n."]\" id=\"defects\" class='form-control'>";
			for($f2=0;$f2<sizeof($defects_array);$f2++)
			{
				if($defects_array[$f2] == $defects)
				{
					echo "<option selected value=\"".$defects_array[$f2]."\">".$defects_array[$f2]."</option>";
				}
				else
				{
					echo "<option value=\"".$defects_array[$f2]."\">".$defects_array[$f2]."</option>";
				}
			}	
			echo "</select></td>";			
			echo "<td><input type=\"hidden\" name=\"skew_cat_ref[".$n."]\" id=\"skew_cat_ref\" value=\"".$skew_cat_ref."\">".$skew_cat_ref."</td>";
			echo "<td><input type=\"hidden\" name=\"skew[".$n."]\" id=\"skew\" value=\"".$skew."\">".$skew."</td>";
			echo "<td><input type=\"hidden\" name=\"shrink_l[".$n."]\" id=\"shrink_l\" value=\"".$shrink_l."\">".$shrink_l."</td>";
			echo "<td><input type=\"hidden\" name=\"shrink_w[".$n."]\" id=\"shrink_w\" value=\"".$shrink_w."\">".$shrink_w."</td>";
			//echo "<td><input type=\"text\" class='textbox' name=\"sup_test_rep[".$n."]\" id=\"sup_test_rep\" size=8 value=\"".$sup_test_rep."\"></td>";
			echo "<td><select name=\"sup_test_rep[".$n."]\" id=\"sup_test_rep\" class='form-control'>";
			for($f3=0;$f3<sizeof($test_report_array);$f3++)
			{
				if($test_report_array[$f3] == $sup_test_rep)
				{
					echo "<option selected value=\"".$test_report_array[$f3]."\">".$test_report_array[$f3]."</option>";
				}
				else
				{
					echo "<option value=\"".$test_report_array[$f3]."\">".$test_report_array[$f3]."</option>";
				}
			}	
			echo "</select></td>";		
			//echo "<td><input type=\"text\" class='textbox' name=\"inspec_per_rep[".$n."]\" id=\"inspec_per_rep\" size=8 value=\"".$inspec_per_rep."\"></td>";
			echo "<td><select name=\"inspec_per_rep[".$n."]\" id=\"inspec_per_rep\" class='form-control'>";
			for($f4=0;$f4<sizeof($per_report_array);$f4++)
			{
				if($per_report_array[$f4] == $inspec_per_rep)
				{
					echo "<option selected value=\"".$per_report_array[$f4]."\">".$per_report_array[$f4]."</option>";
				}
				else
				{
					echo "<option value=\"".$per_report_array[$f4]."\">".$per_report_array[$f4]."</option>";
				}
			}	
			echo "</select></td>";		
			//echo "<td><input type=\"text\" class='textbox' name=\"cc_rep[".$n."]\" id=\"cc_rep\" size=8 value=\"".$cc_rep."\"></td>";
			echo "<td><select name=\"cc_rep[".$n."]\" id=\"cc_rep\" class='form-control'>";
			for($f5=0;$f5<sizeof($source_cc_report_array);$f5++)
			{
				if($source_cc_report_array[$f5] == $cc_rep)
				{
					echo "<option selected value=\"".$source_cc_report_array[$f5]."\">".$source_cc_report_array[$f5]."</option>";
				}
				else
				{
					echo "<option value=\"".$source_cc_report_array[$f5]."\">".$source_cc_report_array[$f5]."</option>";
				}
			}	
			echo "</select></td>";	

			$com_ref1=array();
			for($i11=0;$i11<sizeof($complaint_reason);$i11++)
			{					
				$sql51="select * from $bai_rm_pj1.inspection_complaint_db a,$bai_rm_pj1.inspection_complaint_db_log b WHERE a.complaint_no=b.complaint_track_id AND a.supplier_name=\"".$supplier_name."\" AND b.complaint_reason='".$comaplint_sno[$i11]."' AND a.complaint_cat_ref=0 and a.reject_batch_no='".$batch_ref."'";
				//echo $sql51."<br>";
				$sql_result51=mysqli_query($link, $sql51) or exit("Sql Error51".$sql51.mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo mysql_num_rows($sql_result5)."-".$sql5."<br>";
				if(mysqli_num_rows($sql_result51) > 0)
				{
					$sql31="select GROUP_CONCAT(DISTINCT CONCAT(\"'\",a.ref_no,\"'\")) AS com_ref FROM $bai_rm_pj1.inspection_complaint_db a,$bai_rm_pj1.inspection_complaint_db_log b WHERE a.complaint_no=b.complaint_track_id AND a.supplier_name=\"".$supplier_name."\" AND a.complaint_cat_ref=0 and a.reject_batch_no='".$batch_ref."' AND b.complaint_reason='".$comaplint_sno[$i11]."' ".$string_ref." GROUP BY b.complaint_track_id";
					//echo $sql31."</br>";
					$sql_result31=mysqli_query($link, $sql31) or exit("Sql Error".$sql31.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row31=mysqli_fetch_array($sql_result31))
					{
						$com_ref1[]=$sql_row31["com_ref"];	
							
					}
				}
			}
			echo "<td><input type=\"hidden\" name=\"com_ref1[".$n."]\" id=\"com_ref1\" value=\"".str_replace("'","",implode(",",array_unique($com_ref1)))."\">".str_replace("'","",implode(",",array_unique($com_ref1)))."</td>";
			
			if(sizeof($com_ref1) > 0)
			{
				$sql32="select COUNT(complaint_reason) AS ctn,GROUP_CONCAT(complaint_reason,'^',complaint_rej_qty ORDER BY complaint_rej_qty DESC) AS ref FROM $bai_rm_pj1.inspection_complaint_db_log WHERE complaint_track_id IN (select complaint_no FROM $bai_rm_pj1.inspection_complaint_db WHERE complaint_cat_ref=0 and ref_no IN (".implode(",",array_unique($com_ref1)).") ".$string_ref1.")";
				//echo $sql32."</br>";
				$sql_result32=mysqli_query($link, $sql32) or exit("Sql Error32".$sql32.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row32=mysqli_fetch_array($sql_result32))
				{
					$count_ref=$sql_row32["ctn"];
					$reason_ref=$sql_row32["ref"];
				}
				
				$reason_ref_explode=explode(",",$reason_ref);
			
				$reason_qty=0;
				
				for($i3=0;$i3<sizeof($reason_ref_explode);$i3++)
				{					
					$reason_ref_explode_ex1=explode("^",$reason_ref_explode[$i3]);
					$reason_qty=$reason_qty+$reason_ref_explode_ex1[1];
				}
				
				//echo "<td>".$reason_qty."</td>";
				echo "<td><input type=\"hidden\" name=\"reason_qty[".$n."]\" id=\"reason_qty\" value=\"".$reason_qty."\">".$reason_qty."</td>";
				
				for($i3=0;$i3<sizeof($reason_ref_explode);$i3++)
				{					
					if($i3<2)
					{
						$reason_ref_explode_ex=explode("^",$reason_ref_explode[$i3]);
						
						$sql33="select complaint_reason as res from $bai_rm_pj1.inspection_complaint_reasons where complaint_category=\"Fabric\" and sno=\"".$reason_ref_explode_ex[0]."\"";
						//echo $sql33."</br>";
						$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error33".$sql33.mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row33=mysqli_fetch_array($sql_result33))
						{
							$reason_name=$sql_row33["res"];
						}
						echo "<td><input type=\"hidden\" name=\"reason_name[".$n."][".$i3."]\" id=\"reason_name\" value=\"".$reason_name."\">".$reason_name."-".$i3."-".$n."</td>";
						echo "<td><input type=\"hidden\" name=\"reason_ref_explode_ex[".$n."][".$i3."]\" id=\"reason_ref_explode_ex\" value=\"".$reason_ref_explode_ex[1]."\">".$reason_ref_explode_ex[1]."-".$i3."-".$n."</td>";
					}
					if(sizeof($reason_ref_explode)==1)
					{
						echo "<td><input type=\"hidden\" name=\"reason_name[".$n."][".($i3+1)."]\" id=\"reason_name\" value=\"\">".($i3+1)."-".$n."</td>";
						echo "<td><input type=\"hidden\" name=\"reason_ref_explode_ex[".$n."][".($i3+1)."]\" id=\"reason_ref_explode_ex\" value=\"\">".($i3+1)."-".$n."</td>";
					}
				}
			}
			else
			{
				echo "<td><input type=\"hidden\" name=\"reason_qty[".$n."]\" id=\"reason_qty\" value=\"\"></td>";
				for($i31=0;$i31<2;$i31++)
				{
					echo "<td><input type=\"hidden\" name=\"reason_name[".$n."][".$i31."]\" id=\"reason_name\" value=\"\"></td>";
					echo "<td><input type=\"hidden\" name=\"reason_ref_explode_ex[".$n."][".$i31."]\" id=\"reason_ref_explode_ex\" value=\"\"></td>";	
				}
			}

			echo "<td><input type=\"text\" class='textbox' name=\"fab_tech[".$n."]\" id=\"fab_tech\" value=\"".$fab_tech."\" size=\"10\"></td>";			
			
			$x=0;
			
			for($i1=0;$i1<sizeof($complaint_reason);$i1++)
			{
				$rej_lots=array();
				
				$sql5="select * FROM $bai_rm_pj1.inspection_complaint_db a,$bai_rm_pj1.inspection_complaint_db_log b WHERE a.complaint_no=b.complaint_track_id AND a.supplier_name=\"".$supplier_name."\" AND b.complaint_reason='".$comaplint_sno[$i1]."' AND a.complaint_cat_ref=0 and a.reject_batch_no='".$batch_ref."'";
				$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error5".$sql5.mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo mysql_num_rows($sql_result5)."-".$sql5."<br>";
				if(mysqli_num_rows($sql_result5) > 0)
				{
					$sql3="select GROUP_CONCAT(CONCAT(\"'\",a.reject_lot_no,\"'\")) as lots,GROUP_CONCAT(a.ref_no) AS com_ref FROM $bai_rm_pj1.inspection_complaint_db a,$bai_rm_pj1.inspection_complaint_db_log b WHERE a.complaint_no=b.complaint_track_id AND a.supplier_name=\"".$supplier_name."\" AND a.reject_batch_no='".$batch_ref."' and a.complaint_cat_ref=0 AND b.complaint_reason='".$comaplint_sno[$i1]."' GROUP BY b.complaint_track_id";
					//echo $sql3."</br>";
					$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error3".$sql3.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row3=mysqli_fetch_array($sql_result3))
					{
						$rej_lots[]=$sql_row3["lots"];
					}
				}
				else
				{
					$rej_lots[]=0;
				}
				$reason_status="";
				if(strlen(implode(",",$rej_lots)) > 2)
				{				
					$sql4="select count(distinct batch_no) as batch_no from $bai_rm_pj1.sticker_report WHERE DATE(grn_date) BETWEEN \"".$sdate."\" AND \"".$edate."\" AND product_group=\"Fabric\" and supplier=\"".$supplier_name."\" AND batch_no='".$batch_ref."' and lot_no in (".implode(",",$rej_lots).")";
					//echo $sql4."<br>";
					$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error".$sql4.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row4=mysqli_fetch_array($sql_result4))
					{
						if($batch_status_refx==0)
						{
							echo "<td><input type=\"hidden\" name=\"status[".$n."][".$i1."]\" id=\"status\" value=\"Pending\">Pending</td>";	
						}
						else
						{
							echo "<td><input type=\"hidden\" name=\"status[".$n."][".$i1."]\" id=\"status\" value=\"Fail\">Fail</td>";	
						}
						
						$x=$x+1;
					}
				}
				else
				{
					if($batch_status_refx==0)
					{
						echo "<td><input type=\"hidden\" name=\"status[".$n."][".$i1."]\" id=\"status\" value=\"Pending\">Pending</td>";	
					}
					else
					{
						echo "<td><input type=\"hidden\" name=\"status[".$n."][".$i1."]\" id=\"status\" value=\"Pass\">Pass</td>";	
					}
					
				}
			}
			if($x==0)
			{
				if($batch_status_refx==0)
				{
					echo "<td><input type=\"hidden\" name=\"status_f[".$n."]\" id=\"status_f\" value=\"Pending\">Pending</td>";
					echo "<td><input type=\"hidden\" name=\"impact[".$n."]\" id=\"impact\" value=\"Pending\">Pending</td>";
				}
				else
				{
					echo "<td><input type=\"hidden\" name=\"status_f[".$n."]\" id=\"status_f\" value=\"Pass\">Pass</td>";
					echo "<td><input type=\"hidden\" name=\"impact[".$n."]\" id=\"impact\" value=\"No\">No</td>";
				}
				$t=$t+1;
			}	
			else
			{
				if($batch_status_refx==0)
				{
					echo "<td><input type=\"hidden\" name=\"status_f[".$n."]\" id=\"status_f\" value=\"Pending\">Pending</td>";
					echo "<td><input type=\"hidden\" name=\"impact[".$n."]\" id=\"impact\" value=\"Pending\">Pending</td>";
				}
				else
				{
					echo "<td><input type=\"hidden\" name=\"status_f[".$n."]\" id=\"status_f\" value=\"Fail\">Fail</td>";
					echo "<td><input type=\"hidden\" name=\"impact[".$n."]\" id=\"impact\" value=\"Yes\">Yes</td>";
				}
			}	
			echo "</tr>"; 	
		}
		  
		
	}
	echo "</table></div></div><br>";

	echo "<input type=\"checkbox\" name=\"option\"  id=\"option\" height= \"21px\" onclick=\"javascript:enableButton();\">Enable<input type=\"submit\" id=\"update\" name=\"update\" class=\"btn btn-success\" value=\"Update\">";
	echo "</form></div>";
}
	
	if(!$flag){
		echo "<script>sweetAlert('No Data Found','','warning');
		$('#main_div').hide()</script>";
	}
}



?>



<script language="javascript" type="text/javascript">
	var table3Filters = {
	col_65: "select",
	col_64: "select",
	col_63: "select",
	col_62: "select",
	col_61: "select",
	col_60: "select",
	col_59: "select",
	col_58: "select",
	col_57: "select",
	col_56: "select",
	col_55: "select",
	col_54: "select",
	col_53: "select",
	sort_select: true,
	display_all_text: "Display all",
	loader: true,
	loader_text: "Filtering data...",
	sort_select: true,
	exact_match: false,
	rows_counter: true,
	btn_reset: false
	}
	setFilterGrid("table1",table3Filters);
</script>

</body>

</div>
</div>

