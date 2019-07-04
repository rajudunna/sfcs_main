<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/group_def.php');

include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
$dash=0;
if (isset($_GET['dash'])) {
	$dash=1;
}

$php_self = explode('/',$_SERVER['HTTP_HOST']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/sfcs_app/app/cutting/controllers/seperate_docket.php");
$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index.php?r=".$url_r;
$has_permission=haspermission($url_r); 
?>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/common/css 	/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php 

?>
<br/>
<div class='row'>
		<div class='col-md-2 pull-left'>
			<a class='btn btn-primary' href = '<?= $url1 ?>'> Back </a>
		</div>
		<div class='col-md-10 pull-right'>
			<p style='color:red'>Note : Please Print "Docket Print" Before Update Fabric Status</p>
		</div>
</div>
<br/>
<script src="../../../../common/js/sweetalert.min.js"></script>
<script type="text/javascript">


function check_validate()
{
	var print_valid=document.getElementById("print_validation").value;
	var num_check=document.getElementById("sql_num_check").value;
	var checkBox = document.getElementById("validate");
	console.log(print_valid);
	console.log(num_check);
	if(Number(print_valid)==Number(num_check)){
		if (checkBox.checked == true){	
		var total_req=parseInt(document.getElementById("tot_req").value);
		var allocation=parseInt(document.getElementById("alloc_qty").value);
		var selection=document.getElementById("issue_status").value;
		var doc_tot=document.getElementById("doc_tot").value;
		var alloc_doc=document.getElementById("alloc_doc").value;
		if(0<allocation)
			{
				document.getElementById("submit").disabled=false;
				if(total_req == allocation)
				{
					document.getElementById("submit").disabled=false;
					document.getElementById('dvremark').style.display = "none";
				}
				else if(total_req < allocation)
				{
					var diff=(allocation-total_req);
					var numb = diff.toFixed(2);
					if(confirm("You are sending morethan required quantity :"+numb+"Yrds. \n Are you Sure,You want to proceed..?"))
					{
						document.getElementById('dvremark').style.display = "block";
					}
					else
					{
						document.getElementById("validate").checked=false;
						document.getElementById("submit").disabled=true;
						document.getElementById("remarks").value="";
						document.getElementById('dvremark').style.display = "none";
					}
					
				}
				else if(allocation < total_req)
				{
					var diff=total_req-allocation;
					numb = diff.toFixed(2);
					if(confirm("You are sending lessthan required quantity :" +numb+ " Yrds. \n Are you Sure,You want to proceed..?"))
					{
						
						document.getElementById('dvremark').style.display = "block";
					}
					else
					{
					
						document.getElementById("validate").checked=false;
						document.getElementById("submit").disabled=true;
						document.getElementById("remarks").value="";
						document.getElementById('dvremark').style.display = "none";
					}
				}
			}
			else if(allocation==0 && doc_tot==alloc_doc)
			{
				
				sweetAlert("You have allocated \"STOCK\" for some of the dockets ","","warning");
				document.getElementById('dvremark').style.display = "block";
				document.getElementById("submit").disabled=false;
			}
			else
			{
				sweetAlert("Please allocate the material to the Docket"," ","warning");
				document.getElementById("validate").checked=false;
				document.getElementById("submit").disabled=true;
				document.getElementById("remarks").value="";
				document.getElementById('dvremark').style.display = "none";
				return false;
			}
		}else{
			document.getElementById("submit").disabled=true;
		}

	}else{

		sweetAlert("You should print docket print Before Update Staus","","warning");
		document.getElementById("validate").checked=false;
		document.getElementById("submit").disabled=true;
		document.getElementById("remarks").value="";
		document.getElementById('dvremark').style.display = "none";
		return false;

	}
	

}

function validate_but()
{
		var total_require=parseInt(document.getElementById("tot_req").value);
		var allocation_require=parseInt(document.getElementById("alloc_qty").value);
		console.log("Total Req : " +total_require);
		console.log(allocation_require);
		var str_text=document.getElementById("remarks").value;
		var ii=str_text.length;
		if(total_require==allocation_require)
		{

		}
		else
		{
			if(ii < 8)
			{
				sweetAlert("Please fill the remark...!","","warning");
				return false;
			}
			else
			{
			
			}
		}
		
}

</script>




<?php
error_reporting(0);
set_time_limit(20000);
$doc_no=$_GET['doc_no'];
$doc_num = substr($doc_no,1);
if (!isset($_GET['pop_restriction'])) {
	$_GET['pop_restriction']=0;
}
if (!isset($_GET['group_docs'])) {
	$_GET['group_docs']=0;
}
$pop_restriction=$_GET['pop_restriction'];
$group_docs=$_GET['group_docs'];
?>


<?php

if(!(in_array($authorized,$has_permission)))
{
	header($_GET['r'],'restrict.php?group_docs=$group_docs','N');

}


?>




<html>
<head>

<link rel="stylesheet" type="text/css" href="../../../../common/css/page_style.css" />
<link rel="stylesheet" href="../../../../common/css/bootstrap.min.css">
<script src="../../../../common/js/jquery.min.js"></script>
<script src="../../../../common/js/bootstrap.min.js"></script>


<style>
body
{
	font-family: Trebuchet MS;
}
</style>

<style>
body
{
	background-color:#ffffff;
	color: #000000;
	font-family: Trebuchet MS;
}
a {text-decoration: none;}

table
{
	border: 1px solid #000000;
	border-collapse:collapse;
	border-color:#000000;
}
td
{
	border: 1px solid #000000;
	white-space:nowrap;
	border-collapse:collapse;
}

th
{
	border: 1px solid #000000;
	white-space:nowrap;
	border-collapse:collapse;
	color:#ffffff;
	background:#29759c;
	font-size:14;
}

.bottom th,td
{
	border-bottom: 1px solid white; 
	padding-bottom: 1px;
	padding-top: 1px;
	font-size:14;
}

.input
{
	background-color:yellow;
}

</style>
<script>
 function button_disable()
{
	document.getElementById('process_message').style.visibility="visible";
	document.getElementById('allocate').style.visibility="hidden";
}
 

function dodisable()
{
document.getElementById('process_message').style.visibility="hidden"; 

}
</script>
</head>
<body onload="dodisable()">
<div class="panel panel-primary">
<div class="panel-heading">Fabric Status</div>
<div class="panel-body">

<?php

echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing data...</font></h1></center></div>";
	
	ob_end_flush();
	flush();
	usleep(10);
	$style='';
	$schedule='';
include("fab_detail_track_include.php");
echo "<table class='table table-bordered'>";
echo "<tr>";
echo "<th>Style</th>";
echo "<th>Schedule</th>";
echo "<th>Color</th>";
// echo "<th>Job No</th>";
echo "</tr>";

// $check_sql = "SELECT * from $bai_pro3.cutting_table_plan where doc_no=$doc_no";
// $check_sql_res=mysqli_query($link, $check_sql) or exit("check_sql".mysqli_error($GLOBALS["___mysqli_ston"]));
// $check_sql_res_check=mysqli_num_rows($check_sql_res);
// if($check_sql_res_check >0){
// 	$sql1="SELECT order_style_no,order_del_no,order_col_des,color_code,acutno,order_tid,order_style_no,order_del_no,clubbing from $bai_pro3.cut_tbl_dash_doc_summ where doc_no=$doc_no";
// }else{
// 	$sql1="SELECT order_style_no,order_del_no,order_col_des,color_code,acutno,order_tid,order_style_no,order_del_no,clubbing from $bai_pro3.plan_dash_doc_summ where doc_no=$doc_no";
// }
// $sql1="SELECT bodc.order_style_no,bodc.order_del_no,bodc.order_col_des,bodc.color_code,psl.acutno,bodc.order_tid,csl.clubbing,psl.remarks FROM bai_pro3.plandoc_stat_log AS psl,bai_pro3.bai_orders_db_confirm AS bodc,bai_pro3.cat_stat_log AS csl WHERE psl.order_tid= bodc.order_tid AND csl.order_tid = bodc.order_tid AND 
// csl.order_tid=psl.order_tid AND csl.tid= psl.cat_ref AND psl.doc_no = $doc_no";

$sql1= "SELECT * from binding_consumption where id=$doc_num";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result1);
$sizes_table ='';
while($sql_row1=mysqli_fetch_array($sql_result1))
{
    $id = $sql_row1['id'];
	$style=$sql_row1['style'];
	$schedule=$sql_row1['schedule'];
	$color=$sql_row1['color'];
	$binding_consumption_qty=$sql_row1['tot_bindreq_qty'];
	echo "<tr>";
	echo "<td>".$sql_row1['style']."</td>";
	echo "<td>".$sql_row1['schedule']."</td>";
	echo "<td>".$sql_row1['color']."</td>";
	// echo "<td>".$appender.leading_zeros($sql_row1['acutno'],3)."</td>";
	echo "</tr>";
	// $act_cut_no=$sql_row1['acutno'];
	// $cut_no_ref=$sql_row1['acutno'];
	// $order_id_ref=$sql_row1['order_tid'];
	
	// $sql1="SELECT binding_consumption,seperate_docket from $bai_pro3.cat_stat_log where order_tid='$order_id_ref'";
	// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	// while($sql_row2=mysqli_fetch_array($sql_result1))
	// {
	// 	$binding_consumption=$sql_row2['binding_consumption'];
	// 	$seperate_docket=$sql_row2['seperate_docket'];
	// }

	// $sql2="SELECT (p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as qty FROM plandoc_stat_log WHERE order_tid='$order_id_ref'";
	// $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	// while($sql_row2=mysqli_fetch_array($sql_result2))
	// {
	// 	$p_qty=$sql_row2['qty'];
	// }

	// 	$binding_consumption_qty = $binding_consumption * $p_qty;

	// $style_ref=$sql_row1['style'];
	// $del_ref=$sql_row1['schedule'];
	
	// $clubbing=$sql_row1['clubbing'];
}

echo "</table>";





//NEW Implementation for Docket generation from RMS

echo "<h2>Cut Docket Print</h2>";

echo "<form name=\"ins\" method=\"post\" action=\"allocation.php\">"; //new_Version
echo "<input type=\"hidden\" value=\"1\" name=\"process_cat\">"; //this is to identify recut or normal processing of docket (1 for normal 2 for recut)
echo "<input type=\"hidden\" value=\"$style\" name=\"style_ref\">";  
echo "<input type=\"hidden\" value=\"$dash\" name=\"dashboard\">";  
echo "<input type=\"hidden\" name=\"row_id\" value=\"".$doc_num."\">";


echo "<table class='table table-bordered'><tr><th>Category</th><th>Item Code</th><th>Color Desc. - Docket No</th><th>Required<br/>Qty</th><th>Control</th><th>Roll Details</th></tr>";


// if(strtolower($docket_remarks) == 'normal')
// {
//   $sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\" and order_cat_doc_mk_mix.acutno=$cut_no_ref and order_cat_doc_mk_mix.remarks='Normal' and act_cut_status<>'DONE' and org_doc_no <=1 ";
// }
// else
// {
// 	$sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\" and order_cat_doc_mk_mix.doc_no=$doc_no and order_cat_doc_mk_mix.acutno=$cut_no_ref and act_cut_status<>'DONE' and org_doc_no <=1 ";
// }



//Color Clubbing New Code
// if($clubbing>0)
// {
//    if(strtolower($docket_remarks) == 'normal')
//    {
// 	 $sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid in (select distinct order_tid from $bai_pro3.plan_doc_summ where order_style_no=\"$style_ref\" and order_del_no=\"$del_ref\" and clubbing=$clubbing) and order_cat_doc_mk_mix.acutno=$cut_no_ref  and org_doc_no <=1";
//    }
//    else
//    {
//    	$sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid in (select distinct order_tid from $bai_pro3.plan_doc_summ where order_style_no=\"$style_ref\" and order_del_no=\"$del_ref\" and clubbing=$clubbing) and order_cat_doc_mk_mix.doc_no=$doc_no and order_cat_doc_mk_mix.acutno=$cut_no_ref  and org_doc_no <=1";
//    }
// }
$sql2 = "SELECT *,GROUP_CONCAT(doc_no) AS dockets_list from $bai_pro3.binding_consumption_items where parent_id=$id group by parent_id";
$sql_result1=mysqli_query($link, $sql2) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
// $sql_num_check=mysqli_num_rows($sql_result1);
// $for_Staus_dis=$sql_num_check;
$enable_allocate_button=0;
$comp_printed=array();
$docket_num=array();
$total=0;$allc_doc=0;


$style_flag=0;
$Disable_allocate_flag=0;
$print_validation=0;
$print_status=1;
// while($sql_row1=mysqli_fetch_array($sql_result1))
// {

// }
while($sql_row1=mysqli_fetch_array($sql_result1))
{	
	// if($style_flag==0)
	{
		$docno_lot=$sql_row1['doc_no'];
		$componentno_lot=$sql_row1['compo_no'];
		
		// $clubbing=$sql_row1['clubbing'];
		
		$qry_lotnos="SELECT p.order_tid,p.doc_no,c.compo_no,s.style_no,s.lot_no,s.batch_no FROM $bai_pro3.plandoc_stat_log p LEFT JOIN bai_pro3.cat_stat_log c ON 
		c.order_tid=p.order_tid LEFT JOIN bai_rm_pj1.sticker_report s ON s.item=c.compo_no WHERE style_no='$style' and item='$componentno_lot' and  p.doc_no='$docno_lot' and s.product_group='Fabric'";
		$sql_lotresult=mysqli_query($link, $qry_lotnos) or exit("lot numbers Sql Error ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_lotrow=mysqli_fetch_array($sql_lotresult))
		{
		
			$lotnos_array[]=$sql_lotrow['lot_no'];
		}
	
		if(sizeof($lotnos_array) =='')
		{
			
		}
		else 
		{
			$seperated_lots= trim(implode(",", $lotnos_array));
		}
	}


	// if($seperate_docket=='No'){
	// 	$material_requirement_orig=$sql_row1['material_req'];
	// }else{
	// 	$material_requirement_orig=$sql_row1['material_req']-$binding_consumption_qty;
	// }
	echo "<tr><td>Binding</td>";
	echo "<td>".$sql_row1['compo_no']."</td>";
	echo "<td>".$color.'-'.$sql_row1['dockets_list']."</td>";
	$extra=0;
	
	// { $extra=round(($material_requirement_orig*$sql_row1['savings']),2); }
	echo "<td>".$binding_consumption_qty."</td>";
	// $temp_tot=$material_requirement_orig+$extra;
	// $total+=$temp_tot;
	// $temp_tot=0;
	// $club_id=$sql_row1['clubbing'];
	
	// $newOrderTid=$sql_row1['order_tid'];
	$doc_cat=$sql_row1['category'];
	$doc_com=$sql_row1['compo_no'];
	$doc_mer=$binding_consumption_qty;
	$cat_ref='B';
	$total = $binding_consumption_qty;
	

	$docket_num[]=$sql_row1['doc_no'];
	
	// if($sql_row1['plan_lot_ref']!='')
	// {	

	// 	$plan_lot_ref=$sql_row1['plan_lot_ref'];
	// 	$allc_doc++;
	
	// 	if($clubbing>0)
	// 	{
	// 		if(!in_array($sql_row1['category'],$comp_printed))
	// 		{
	// 			echo "<td><a href=\"$path?print_status=$print_status&order_tid=$newOrderTid&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&cat_title=".$sql_row1['category']."&clubbing=".$club_id."&cut_no=".$act_cut_no."\" onclick=\"Popup1=window.open('$path?print_status=$print_status&order_tid=$newOrderTid&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&cat_title=".$sql_row1['category']."&clubbing=".$club_id."&cut_no=".$act_cut_no."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";
	// 			$comp_printed[]=$sql_row1['category'];
	// 		}
	// 		else
	// 		{
	// 			echo "<td>Clubbed</td>";
	// 		}
	// 	}
	// 	else
	// 	{
	// 		echo "<td><a href=\"$path?print_status=$print_status&order_tid=$newOrderTid&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&cat_title=".$sql_row1['category']."&clubbing=".$club_id."&cut_no=".$act_cut_no."\" onclick=\"Popup1=window.open('$path?print_status=$print_status&order_tid=$newOrderTid&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&cat_title=".$sql_row1['category']."&clubbing=".$club_id."&cut_no=".$act_cut_no."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";
	// 	}	
	// 	$Disable_allocate_flag=$Disable_allocate_flag+1;
		
	// }
	// else
	{
		
		
		echo "<td><input type=\"hidden\" name=\"doc[]\" value=\"".$sql_row1['doc_no']."\">";
		//For New Implementation
		echo "<input type=\"hidden\" name=\"doc_cat[]\" value=\"".$doc_cat."\">";
		echo "<input type=\"hidden\" name=\"doc_com[]\" value=\"".$doc_com."\">";
		echo "<input type=\"hidden\" name=\"doc_mer[]\" value=\"".$doc_mer."\">";
		echo "<input type=\"hidden\" name=\"cat_ref[]\" value=\"".$cat_ref."\">";
		//For New Implementation
		
		if($style_flag==0){
			if(sizeof($lotnos_array) ==''){
				$Disable_allocate=1;
			}
			echo "Please Provide Lot Numbers: <textarea class=\"form-control\" name=\"pms".$sql_row1['doc_no']."\" id='address' 
			      onkeyup='return verify_num(this,event)' onchange='return verify_num(this,event)' cols=12 rows=10 placeholder='No Lot Number Found, Please Enter Lot Number'>".$seperated_lots."</textarea><br/>";

		}else{

			echo "Please Provide Lot Numbers: <textarea class=\"form-control\" id='address' onkeyup='return verify_num(this,event)'
			     onchange='return verify_num(this,event)' name=\"pms".$sql_row1['doc_no']."\" cols=12 rows=10 ></textarea><br/>";

		}
		

			
		// {
		// 	 $sql1x="select ref1,lot_no from $bai_rm_pj1.fabric_status where item in (select compo_no from $bai_pro3.cat_stat_log where tid=\"".$sql_row1['cat_ref']."\")";
		// 	$sql_result1x=mysqli_query($link, $sql1x) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		// 	while($sql_row1x=mysqli_fetch_array($sql_result1x))
		// 	{
				
				
		// 	} 
		// }
		
		
		echo "</td>";
		
		
		
		
		
		
		$enable_allocate_button=1;
	} 
	
// if($sql_row1['print_status']>0)
// {
// 	echo "<td><img src=\"correct.png\"></td>";
// 	$print_validation=$print_validation+1;
	
// }
// else
// {

// 		echo "<td><img src=\"Wrong.png\"></td>";
// }
echo "<td>";	
	getDetails("D",$sql_row1['doc_no']);
	echo "</td>";

echo "</tr>";
unset($lotnos_array);	
}
echo "<tr><td colspan=3><center>Total Required Material</center></td><td>$total</td><td></td><td></td><td></td></tr>";
echo "</table>";
if($enable_allocate_button==1)
{	
	
		echo "<input type=\"submit\" name=\"allocate\" value=\"Allocate\" class=\"btn btn-success\" onclick=\"button_disable()\">";
	
	
}
echo "</form>";
//NEW Implementation for Docket generation from RMS

// $sql1="SELECT fabric_status from $bai_pro3.plan_dashboard where doc_no=$doc_no";
// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// $sql_num_check=mysqli_num_rows($sql_result1);
// while($sql_row1=mysqli_fetch_array($sql_result1))
// {
// 	$fabric_status=$sql_row1['fabric_status'];
// }

// if($sql_num_check == 0){
// 	if($doc_no > 0){
// 		$fab_status_query = "SELECT fabric_status from $bai_pro3.order_cat_doc_mk_mix where doc_no=$doc_no";
// 		$fab_status_result = mysqli_query($link,$fab_status_query);
// 		while($row = mysqli_fetch_array($fab_status_result)){
// 			$fabric_status=$row['fabric_status'];
// 		}
// 	}
// }
// if($fabric_status=="1")
// {
// 	echo '<div class="alert alert-info"><strong>Fabric Status:</strong><br>Ready For Issuing: <font color="green">Completed</font><br>Issue to Module: <font color="red">Pending</font></div>';
// }
// $sql111="select ROUND(SUM(allocated_qty),2) AS alloc,count(distinct doc_no) as doc_count from $bai_rm_pj1.fabric_cad_allocation where doc_no in (".implode(",",$docket_num).")";
// $sql_result111=mysqli_query($link, $sql111) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
// while($sql_row111=mysqli_fetch_array($sql_result111))
// 	{
// 		if($sql_row111['alloc']!='')
// 		{
// 			$alloc_qty=$sql_row111['alloc'];
// 		}
// 		else
// 		{
// 			$alloc_qty=0;
// 		}		
// 	}
		
?>

<?php

if(isset($_POST['allocate']))
{

	$doc=$_POST['doc'];
	
	for($i=0;$i<sizeof($doc);$i++)
	{
		$temp='lot'.$doc[$i];
		$lot=$_POST[$temp];		
		
	}
	
}


?>

