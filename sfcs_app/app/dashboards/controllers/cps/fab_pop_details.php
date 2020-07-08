<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_dashboard.php');
// include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/user_acl_v1.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/group_def.php');

include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
$dash=0;
if (isset($_GET['dash'])) {
	$dash=1;
}
$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/fab_pps_dashboard_v2.php");
$has_permission=haspermission($url_r); 
$php_self = explode('/',$_SERVER['PHP_SELF']);
$ctd =array_slice($php_self, 0, -2);
$get_url=implode('/',$ctd)."/cps/marker_length_popup.php";

$get_url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."".$get_url;

?>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/common/css 	/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php 
if($dash==1){
 	$php_self = explode('/',$_SERVER['PHP_SELF']);
	$ctd =array_slice($php_self, 0, -2);
	$url_rr=base64_encode(implode('/',$ctd)."/cut_table_dashboard/cut_table_dashboard.php");
	$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index.php?r=".$url_rr;
}
else{
	$php_self = explode('/',$_SERVER['PHP_SELF']);
	array_pop($php_self);
	$url_r = base64_encode(implode('/',$php_self)."/fab_priority_dashboard.php");
	$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index.php?r=".$url_r;
}
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

// function verify_num(t,e){
	
// 		if(e.keyCode == 8){
// 			return false;
// 		}
// 		var c = /^[0-9, ]+$/;
// 		var id = t.id;
// 		var n = document.getElementById(id);
// 		var lot_length=n.value;
// 		if( !((n.value).match(c)) ){
// 			n.value ="";
// 			//alert('Please enter only numerics');
// 			return false;
// 		}
// 	}

function check_validate()
{
	var print_valid=document.getElementById("print_validation").value;
	var num_check=document.getElementById("sql_num_check").value;
	var checkBox = document.getElementById("validate");
	console.log(print_valid);
	console.log(num_check);
	if(Number(print_valid)==Number(num_check)){
		if (checkBox.checked == true){	
			//var docket=document.getElementById("doc_no").value;
		var total_req=parseInt(document.getElementById("tot_req").value);
		var allocation=parseInt(document.getElementById("alloc_qty").value);
		var selection=document.getElementById("issue_status").value;
		var doc_tot=document.getElementById("doc_tot").value;
		var alloc_doc=document.getElementById("alloc_doc").value;
		// console.log(total_req);
		if(0<allocation)
			{
				document.getElementById("submit").disabled=false;
				if(total_req == allocation)
				{
					document.getElementById("submit").disabled=false;
					document.getElementById('dvremark').style.display = "none";
					//console.log("Total and alloc eq");
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
						//alert("Test3");
						//window.open("update.php?docket="+docket+"&check=check_out&flag=1", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400");
						//documnet.getElementById("dvremark").style.display='block';
						//documnet.getElementById("dvremark").style.display= '';
						document.getElementById('dvremark').style.display = "block";
					}
					else
					{
						//alert("Test4");
						//window.open("update.php?docket="+docket+"check=check_out", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400");
						//return false;
						//documnet.getElementById("dvremark").style.display= '';
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
				//alert(allocation);
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
		//alert('check');
		var total_require=parseInt(document.getElementById("tot_req").value);
		var allocation_require=parseInt(document.getElementById("alloc_qty").value);
		console.log("Total Req : " +total_require);
		console.log(allocation_require);
		var str_text=document.getElementById("remarks").value;
		var ii=str_text.length;
		//alert(str_text.trim());
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
				//alert("Please fill the remark...ok!");
				//return false;
			}
		}
		//alert(document.getElementById("remarks").value);
		//document.getElementById("remarks").value="Testing";
		//return false;
}

</script>




<?php
error_reporting(0);
set_time_limit(20000);
$doc_no=$_GET['doc_no'];
if (!isset($_GET['pop_restriction'])) {
	$_GET['pop_restriction']=0;
}
if (!isset($_GET['group_docs'])) {
	$_GET['group_docs']=0;
}
$pop_restriction=$_GET['pop_restriction'];
$group_docs=$_GET['group_docs'];
//echo $group_docs;
?>


<?php

if(!(in_array($authorized,$has_permission)))
{
	header($_GET['r'],'restrict.php?group_docs=$group_docs','N');

}

	//header("Location:restrict.php?group_docs=$group_docs");

?>




<html>
<head>

<link rel="stylesheet" type="text/css" href="../../../../common/css/page_style.css" />
<link rel="stylesheet" href="../../../../common/css/bootstrap.min.css">
<script src="../../../../common/js/jquery1.min.js"></script>
<script src="../../../../common/js/bootstrap1.min.js"></script>





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
	// document.getElementById('process_message').style.visibility="visible";
	document.getElementById('allocate').style.visibility="hidden";
}
 
 </script>
 <script>
function dodisable()
{
//enableButton();
// document.getElementById('process_message').style.visibility="hidden"; 
//document.ins.allocate.style.visibility="hidden"; 

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
echo "<th>Job No</th>";
echo "</tr>";

$check_sql = "SELECT * from $bai_pro3.cutting_table_plan where doc_no=$doc_no";
$check_sql_res=mysqli_query($link, $check_sql) or exit("check_sql".mysqli_error($GLOBALS["___mysqli_ston"]));
$check_sql_res_check=mysqli_num_rows($check_sql_res);
if($check_sql_res_check >0){
	$sql1="SELECT order_style_no,order_del_no,order_col_des,color_code,acutno,order_tid,order_style_no,order_del_no,clubbing from $bai_pro3.cut_tbl_dash_doc_summ where doc_no=$doc_no";
}else{
	$sql1="SELECT order_style_no,order_del_no,order_col_des,color_code,acutno,order_tid,order_style_no,order_del_no,clubbing from $bai_pro3.plan_dash_doc_summ where doc_no=$doc_no";
}
$sql1="SELECT bodc.order_style_no,bodc.order_del_no,bodc.order_col_des,bodc.color_code,psl.acutno,bodc.order_tid,csl.clubbing,psl.remarks FROM bai_pro3.plandoc_stat_log AS psl,bai_pro3.bai_orders_db_confirm AS bodc,bai_pro3.cat_stat_log AS csl WHERE psl.order_tid= bodc.order_tid AND csl.order_tid = bodc.order_tid AND csl.order_tid=psl.order_tid AND csl.tid= psl.cat_ref AND psl.doc_no = $doc_no";
// echo $sql1;
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result1);
$sizes_table ='';
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$docket_remarks=$sql_row1['remarks'];
	if(strtolower($sql_row1['remarks']) == 'recut')
		$appender = 'R';
	else	
	$appender = chr($sql_row1['color_code']);
	$style=$sql_row1['order_style_no'];
	$schedule=$sql_row1['order_del_no'];
	echo "<tr>";
	echo "<td>".$sql_row1['order_style_no']."</td>";
	echo "<td>".$sql_row1['order_del_no']."</td>";
	echo "<td>".$sql_row1['order_col_des']."</td>";
	echo "<td>".$appender.leading_zeros($sql_row1['acutno'],3)."</td>";
	echo "</tr>";
	$act_cut_no=$sql_row1['acutno'];
	$cut_no_ref=$sql_row1['acutno'];
	$order_id_ref=$sql_row1['order_tid'];
	
	
	// echo "order_tid".$order_id_ref."<br>";

	// $sql2="SELECT (p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as qty FROM plandoc_stat_log WHERE order_tid='$order_id_ref'";
	// $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	// while($sql_row2=mysqli_fetch_array($sql_result2))
	// {
		// $p_qty=$sql_row2['qty'];
	// }
	// echo "p_qty".$p_qty."<br>";
	
	
	/* $order_id_ref1 = explode(" ",$sql_row1['order_tid']);
	echo $order_id_ref1[0];
	echo $order_id_ref1[7]; */
	//var_dump($order_id_ref1);
	$style_ref=$sql_row1['order_style_no'];
	// echo $style_ref." is style-ref";
	$del_ref=$sql_row1['order_del_no'];
	
	// $sizes_table.="<table><tr><th>Size</th><th>Qty</th></tr>";
	// if($sql_row1['xs']>0){ $sizes_table.="<tr><td>XS</td><td>".$sql_row1['xs']."</td></tr>";}
	// if($sql_row1['s']>0){ $sizes_table.="<tr><td>S</td><td>".$sql_row1['s']."</td></tr>";}
	// if($sql_row1['m']>0){ $sizes_table.="<tr><td>M</td><td>".$sql_row1['m']."</td></tr>";}
	// if($sql_row1['l']>0){ $sizes_table.="<tr><td>L</td><td>".$sql_row1['l']."</td></tr>";}
	// if($sql_row1['xl']>0){ $sizes_table.="<tr><td>XL</td><td>".$sql_row1['xl']."</td></tr>";}
	// if($sql_row1['xxl']>0){ $sizes_table.="<tr><td>XXL</td><td>".$sql_row1['xxl']."</td></tr>";}
	// if($sql_row1['xxxl']>0){ $sizes_table.="<tr><td>XXXL</td><td>".$sql_row1['xxxl']."</td></tr>";}
	// if($sql_row1['s06']>0){ $sizes_table.="<tr><td>S06</td><td>".$sql_row1['s06']."</td></tr>";}
	// if($sql_row1['s08']>0){ $sizes_table.="<tr><td>S08</td><td>".$sql_row1['s08']."</td></tr>";}
	// if($sql_row1['s10']>0){ $sizes_table.="<tr><td>S10</td><td>".$sql_row1['s10']."</td></tr>";}
	// if($sql_row1['s12']>0){ $sizes_table.="<tr><td>S12</td><td>".$sql_row1['s12']."</td></tr>";}
	// if($sql_row1['s14']>0){ $sizes_table.="<tr><td>S14</td><td>".$sql_row1['s14']."</td></tr>";}
	// if($sql_row1['s16']>0){ $sizes_table.="<tr><td>S16</td><td>".$sql_row1['s16']."</td></tr>";}
	// if($sql_row1['s18']>0){ $sizes_table.="<tr><td>S18</td><td>".$sql_row1['s18']."</td></tr>";}
	// if($sql_row1['s20']>0){ $sizes_table.="<tr><td>S20</td><td>".$sql_row1['s20']."</td></tr>";}
	// if($sql_row1['s22']>0){ $sizes_table.="<tr><td>S22</td><td>".$sql_row1['s22']."</td></tr>";}
	// if($sql_row1['s24']>0){ $sizes_table.="<tr><td>S24</td><td>".$sql_row1['s24']."</td></tr>";}
	// if($sql_row1['s26']>0){ $sizes_table.="<tr><td>S26</td><td>".$sql_row1['s26']."</td></tr>";}
	// if($sql_row1['s28']>0){ $sizes_table.="<tr><td>S28</td><td>".$sql_row1['s28']."</td></tr>";}
	// if($sql_row1['s30']>0){ $sizes_table.="<tr><td>S30</td><td>".$sql_row1['s30']."</td></tr>";}
	// $sizes_table.="<tr><td>Total QTY</td><td>".$sql_row1['total']."</td>";
	// $sizes_table.="</table>";

	// $mns_status=$sql_row1['xs']+$sql_row1['s']+$sql_row1['m']+$sql_row1['l']+$sql_row1['xl']+$sql_row1['xxl']+$sql_row1['xxxl'];
	
	//To Identify Clubbed Colors/Items
	$clubbing=$sql_row1['clubbing'];
}

echo "</table>";

//echo $sizes_table;




//NEW Implementation for Docket generation from RMS

echo "<h2>Cut Docket Print</h2>";

echo "<form name=\"ins\" method=\"post\" action=\"fab_pop_allocate_v5.php\">"; //new_Version
if(strtolower($docket_remarks) == 'recut')
{
	echo "<input type=\"hidden\" value=\"2\" name=\"process_cat\">";
}else {
	echo "<input type=\"hidden\" value=\"1\" name=\"process_cat\">";
}
 //this is to identify recut or normal processing of docket (1 for normal 2 for recut)
echo "<input type=\"hidden\" value=\"$style_ref\" name=\"style_ref\">";  
echo "<input type=\"hidden\" value=\"$dash\" name=\"dashboard\">";  

echo "<div class='table-responsive'><table class='table table-bordered'><tr><th>Category</th><th>Item Code</th><th>Color Desc. - Docket No</th><th>Marker Update</th><th>Required<br/>Qty</th><th>Reference</th>
<th>Shrinkage</th><th>Width</th><th>Control</th><th>Print Status</th><th>Roll Details</th></tr>";
//$sql1="SELECT plandoc_stat_log.plan_lot_ref,plandoc_stat_log.cat_ref,plandoc_stat_log.print_status,plandoc_stat_log.doc_no,cat_stat_log.category from plandoc_stat_log left join cat_stat_log on plandoc_stat_log.cat_ref=cat_stat_log.tid  where plandoc_stat_log.order_tid=\"$order_id_ref\" and plandoc_stat_log.acutno=$cut_no_ref";

if(strtolower($docket_remarks) == 'normal')
{
  $sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\" and order_cat_doc_mk_mix.acutno=$cut_no_ref and order_cat_doc_mk_mix.remarks='Normal' and act_cut_status<>'DONE' and org_doc_no <=1 ";
}
elseif(strtolower($docket_remarks) == 'pilot')
{
	$sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\"  and order_cat_doc_mk_mix.acutno=$cut_no_ref  and order_cat_doc_mk_mix.remarks='Pilot' and act_cut_status<>'DONE' and org_doc_no <=1 ";
}
elseif(strtolower($docket_remarks) == 'recut')
{
	$sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\"  and order_cat_doc_mk_mix.remarks='Recut' and order_cat_doc_mk_mix.acutno=$cut_no_ref and act_cut_status<>'DONE' and org_doc_no <=1 ";
}
else
{
	$sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\"  and order_cat_doc_mk_mix.doc_no=$doc_no and order_cat_doc_mk_mix.acutno=$cut_no_ref and act_cut_status<>'DONE' and org_doc_no <=1 ";
}

// $sql1="SELECT order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\" and order_cat_doc_mk_mix.acutno=$cut_no_ref and order_cat_doc_mk_mix.doc_no=$doc_no";

//Color Clubbing New Code
if($clubbing>0)
{
   if(strtolower($docket_remarks) == 'normal')
   {
	 $sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid in (select distinct order_tid from $bai_pro3.plan_doc_summ where order_style_no=\"$style_ref\" and order_del_no=\"$del_ref\" and clubbing=$clubbing) and order_cat_doc_mk_mix.acutno=$cut_no_ref  and org_doc_no <=1";
   }
   elseif(strtolower($docket_remarks) == 'pilot')
   {
	   $sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid in (select distinct order_tid from $bai_pro3.plan_doc_summ where order_style_no=\"$style_ref\" and order_del_no=\"$del_ref\" and clubbing=$clubbing)  and order_cat_doc_mk_mix.acutno=$cut_no_ref  and org_doc_no <=1";
	   
   }
   elseif(strtolower($docket_remarks) == 'recut')
   {
   	$sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid in (select distinct order_tid from $bai_pro3.plan_doc_summ where order_style_no=\"$style_ref\" and order_del_no=\"$del_ref\" and clubbing=$clubbing) and  order_cat_doc_mk_mix.acutno=$cut_no_ref  and org_doc_no <=1";
   }
   else
   {
   	$sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid in (select distinct order_tid from $bai_pro3.plan_doc_summ where order_style_no=\"$style_ref\" and order_del_no=\"$del_ref\" and clubbing=$clubbing) and order_cat_doc_mk_mix.doc_no=$doc_no and order_cat_doc_mk_mix.acutno=$cut_no_ref  and org_doc_no <=1";
   }
}

//echo "getting req qty : ".$sql1."</br>";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result1);
$for_Staus_dis=$sql_num_check;
// echo "Rows:".$sql_num_check;
$enable_allocate_button=0;
$comp_printed=array();
$docket_num=array();
$total=0;$allc_doc=0;

//By ram Date:14032018
//this is flag for style automatic/manual 
$style_flag=0;
$Disable_allocate_flag=0;
$print_validation=0;
$print_status=1;
while($sql_row1=mysqli_fetch_array($sql_result1))
{	
	$cat_refnce[$sql_row1["doc_no"]] = $sql_row1["category"];
	if($style_flag==0)
	{
		$docno_lot=$sql_row1['doc_no'];
		// var_dump($docno_lot);
		$componentno_lot=$sql_row1['compo_no'];
		$clubbing=$sql_row1['clubbing'];
		//echo $docno_lot."--".$clubbing."<br>";
		if($clubbing>0)
		{
			$path="../../../cutting/controllers/lay_plan_preparation/color_club_docket_print.php";
		}
		else
		{
			$path="../../../cutting/controllers/lay_plan_preparation/Book3_print.php";
		}
		

		
		// echo "<br>DocNo: ".$docno_lot.'Component No: '.$componentno_lot;
		//getting lot numbers with reference style code and component no
		/*$qry_lotnos="SELECT p.order_tid,p.doc_no,c.compo_no,s.style_no,s.lot_no,s.batch_no FROM bai_pro3.plandoc_stat_log p LEFT JOIN bai_pro3.cat_stat_log c ON 
		c.order_tid=p.order_tid LEFT JOIN bai_rm_pj1.sticker_report s ON s.item=c.compo_no WHERE p.doc_no='$docno_lot' and item='$componentno_lot'";*/
		
		
		$qry_lotnos="SELECT p.order_tid,p.doc_no,c.compo_no,s.style_no,s.lot_no,s.batch_no FROM $bai_pro3.plandoc_stat_log p LEFT JOIN bai_pro3.cat_stat_log c ON 
		c.order_tid=p.order_tid LEFT JOIN bai_rm_pj1.sticker_report s ON s.item=c.compo_no WHERE style_no='$style_ref' and item='$componentno_lot' and  p.doc_no='$docno_lot' and s.product_group='Fabric'";
		// echo "<br>LOt qry : ".$qry_lotnos;
		$sql_lotresult=mysqli_query($link, $qry_lotnos) or exit("lot numbers Sql Error ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_lotrow=mysqli_fetch_array($sql_lotresult))
		{
			//echo "</br>lot numbers :".$sql_lotrow['lot_no'];
			$lotnos_array[]=$sql_lotrow['lot_no'];
		}
		// var_dump($lotnos_array);
		// echo sizeof($lotnos_array);
		if(sizeof($lotnos_array) =='')
		{
			//echo "<h2>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp NO LOT NUMBERS FOR THIS STYLE</h2>";
			//echo '<script>window.location.href = "http://192.168.0.110:8080/master/projects/beta/production_planning/fab_priority_dashboard.php";</script>';
			//echo '<h1><font color="red">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp No lot numbers for this style !!!</font><br/></h1>';
			// die();
		}
		else 
		{
			$seperated_lots= trim(implode(",", $lotnos_array));
		}
	}
	$sql2="SELECT (p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as qty FROM plandoc_stat_log WHERE doc_no=".$sql_row1['doc_no']."";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$p_qty=$sql_row2['qty'];
	}
	$shrinkaage='';
	$mwidt='A';
	$marker_id='';
	$sql007="select reference,mk_ref_id,allocate_ref from $bai_pro3.plandoc_stat_log where doc_no=\"".$docno_lot."\"";
	$sql_result007=mysqli_query($link, $sql007) or die("Error2 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row007=mysqli_fetch_array($sql_result007))
	{
		$reference=$row007["reference"];
		if($row007['mk_ref_id']>0)
		{	
			$sql11x1321="select shrinkage_group,width,marker_length,parent_id from $bai_pro3.maker_details where parent_id=".$row007['allocate_ref']." and id=".$row007['mk_ref_id']."";
			$sql_result11x11211=mysqli_query($link, $sql11x1321) or die("Error15 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row111x2112=mysqli_fetch_array($sql_result11x11211)) 
			{
				$shrinkaage=$row111x2112['shrinkage_group'];
				$mwidt=$row111x2112['width'];
				$marker_id=$row111x2112['parent_id'];
			}
		}
		else
		{
			$shrinkaage='N/A';
			$mwidt='N/A';
			$marker_id='';
		}
}
	// echo "</br>Seperated--".$seperate_docket;
	$sql5="SELECT binding_consumption,seperate_docket,purwidth from $bai_pro3.cat_stat_log where  tid=\"".$sql_row1['cat_ref']."\"";
	$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row5=mysqli_fetch_array($sql_result5))
	{
		$binding_consumption=$sql_row5['binding_consumption'];
		$seperate_docket=$sql_row5['seperate_docket'];
		$purwidth=$sql_row5['purwidth'];
		if($mwidt=='N/A'){
			$mwidt= $purwidth;
		}
	}
	// echo "Quaty=====".$p_qty."<br>";
	// echo "binding_consumption".$binding_consumption."<br>";
	$binding_consumption_qty = $binding_consumption * $p_qty;
	
	// echo "</br>material_req--".$sql_row1['material_req'];
	// echo "</br>binding_consumption_qty--".$binding_consumption_qty;
	if($seperate_docket=='No'){
		$material_requirement_orig=$sql_row1['material_req'];
	}else{
		$material_requirement_orig=$sql_row1['material_req']-$binding_consumption_qty;
	}

	echo "<tr><td>".$sql_row1['category']."</td>";
	echo "<td>".$sql_row1['compo_no']."</td>";
	echo "<td>".$sql_row1['col_des'].'-'.$sql_row1['doc_no']."</td>";
	$maker_update="select * from $bai_pro3.plandoc_stat_log where doc_no='".$sql_row1['doc_no']."'";
	$maker_update_result=mysqli_query($link, $maker_update) or exit("Sql Error--12".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($maker_update_result)){
		$allocation = $row['plan_lot_ref'];	
	}
	if($allocation != '')
	{
		echo "<td><center><span class='label label-warning'>Can't Edit</span></center></td>";
	} else {
		if($marker_id != ''){
			echo "<td><center><input type='button' style='display : block' class='btn btn-sm btn-danger' id='rejections_panel_btn'".$sql_row1['doc_no']." onclick=marker_edit(".$sql_row1['doc_no'].") value='Edit'></center></td>";
		} else {
			//for old marker values we cant edit.
			echo "<td><center><input type='button' style='display : block' class='btn btn-sm btn-danger' id='rejections_panel_btn'".$sql_row1['doc_no']." onclick=no_marker_edit(".$sql_row1['doc_no'].") value='Edit'></center></td>";
		}
	}
	$extra=0;

	{ $extra=round(($material_requirement_orig*$sql_row1['savings']),2); }
	echo "<td>".($material_requirement_orig+$extra)."</td>";
	echo "<td>".$reference."</td>";
	echo "<td>".$shrinkaage."</td>";
	echo "<td>".$mwidt."</td>";
	$temp_tot=$material_requirement_orig+$extra;
	$total+=$temp_tot;
	$temp_tot=0;
	$club_id=$sql_row1['clubbing'];
	//For new implementation
	$newOrderTid=$sql_row1['order_tid'];
	$doc_cat=$sql_row1['category'];
	$doc_com=$sql_row1['compo_no'];
	$doc_mer=($material_requirement_orig+$extra);
	$cat_ref=$sql_row1['cat_ref'];
	
	//To Encode Order tid
	$main_order_tid=order_tid_encode($newOrderTid);
	//For new implementation
	
	//echo "<td><a href=\"$path?order_tid=$order_id_ref&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."\" onclick=\"Popup1=window.open('$path?order_tid=$order_id_ref&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";


	$docket_num[]=$sql_row1['doc_no'];
	//echo var_dump($docket_num);
	//echo "</br>Length :".$sql_row1['plan_lot_ref']."</br>";
	//if(strlen($sql_row1['plan_lot_ref'])>0)
	if($sql_row1['plan_lot_ref']!='')
	{	

		$plan_lot_ref=$sql_row1['plan_lot_ref'];
		$allc_doc++;
		//echo $sql_row1['category']."</br>";
		//echo var_dump($comp_printed)."</br>";
		if($clubbing>0)
		{
			if(!in_array($sql_row1['category'],$comp_printed))
			{
				echo "<td><a href=\"$path?print_status=$print_status&order_tid=$main_order_tid&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&cat_title=".$sql_row1['category']."&clubbing=".$club_id."&cut_no=".$act_cut_no."\" onclick=\"Popup1=window.open('$path?print_status=$print_status&order_tid=$main_order_tid&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&cat_title=".$sql_row1['category']."&clubbing=".$club_id."&cut_no=".$act_cut_no."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";
				$comp_printed[]=$sql_row1['category'];
			}
			else
			{
				echo "<td>Clubbed</td>";
			}
		}
		else
		{
			echo "<td><a href=\"$path?print_status=$print_status&order_tid=$main_order_tid&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&cat_title=".$sql_row1['category']."&clubbing=".$club_id."&cut_no=".$act_cut_no."\" onclick=\"Popup1=window.open('$path?print_status=$print_status&order_tid=$main_order_tid&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&cat_title=".$sql_row1['category']."&clubbing=".$club_id."&cut_no=".$act_cut_no."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";
		}	
		$Disable_allocate_flag=$Disable_allocate_flag+1;
		
	}
	else
	{
		//This was with limitation that we cannt execute for reclassified schedules
		/*echo "<td><input type=\"hidden\" name=\"doc[]\" value=\"".$sql_row1['doc_no']."\">";
		$sql1x="select ref1,lot_no from bai_rm_pj1.fabric_status where item in (select compo_no from cat_stat_log where tid=\"".$sql_row1['cat_ref']."\")";
		$sql_result1x=mysql_query($sql1x,$link) or exit("Sql Error".mysql_error());
		if(mysql_num_rows($sql_result1x)==0)
		{
			echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
			echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
			echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
			echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
			echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
			echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";		
		}
		else
		{
			while($sql_row1x=mysql_fetch_array($sql_result1x))
			{
				echo "<input type=\"checkbox\" value=\"".$sql_row1x['lot_no'].">".$sql_row1x['ref1']."\" name=\"".$sql_row1['doc_no']."[]\">".$sql_row1x['lot_no']."<br/>";
				
			}
		}
		echo "</td>"; */
		
		echo "<td><input type=\"hidden\" name=\"doc[]\" value=\"".$sql_row1['doc_no']."\">";
		//For New Implementation
		echo "<input type=\"hidden\" name=\"doc_cat[]\" value=\"".$doc_cat."\">";
		echo "<input type=\"hidden\" name=\"doc_com[]\" value=\"".$doc_com."\">";
		echo "<input type=\"hidden\" name=\"doc_mer[]\" value=\"".$doc_mer."\">";
		echo "<input type=\"hidden\" name=\"cat_ref[]\" value=\"".$cat_ref."\">";
		//For New Implementation
		
		if($style_flag==0){
			if(sizeof($lotnos_array) ==''){
				// $seperated_lots="No lot Number Found";
				$Disable_allocate=1;
			}
			echo "Please Provide Lot Numbers: <textarea class=\"form-control\" name=\"pms".$sql_row1['doc_no']."\" id='address' 
			      onkeyup='return verify_num(this,event)' onchange='return verify_num(this,event)' cols=12 rows=10 placeholder='No Lot Number Found, Please Enter Lot Number'>".$seperated_lots."</textarea><br/>";

		}else{

			echo "Please Provide Lot Numbers: <textarea class=\"form-control\" id='address' onkeyup='return verify_num(this,event)'
			     onchange='return verify_num(this,event)' name=\"pms".$sql_row1['doc_no']."\" cols=12 rows=10 ></textarea><br/>";

		}
		

			
		//if($clubbing==0) //Disabled auto finding of lots, if color is clubbed
		{
			//Commented due to performance issue 20120319
			// $sql1x="select ref1,lot_no from $bai_rm_pj1.fabric_status where item in (select compo_no from $bai_pro3.cat_stat_log where tid=\"".$sql_row1['cat_ref']."\")";
			//$sql_result1x=mysqli_query($link, $sql1x) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			//while($sql_row1x=mysqli_fetch_array($sql_result1x))
			//{
				//Disabled because of taking values from PMS040
				//echo "<input type=\"checkbox\" value=\"".$sql_row1x['lot_no'].">".$sql_row1x['ref1']."\" name=\"".$sql_row1['doc_no']."[]\">".$sql_row1x['lot_no']."<br/>";
				
			//} 
			//Commented due to performance issue 20120319
		}
		
		/* //Disabled because of taking values from PMS040
		echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
		echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
		echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
		echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
		echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
		echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
		echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
		echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
		echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
		echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
		echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
		echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
		*/
		echo "</td>";
		
		
		/* echo "<td><input type=\"hidden\" name=\"doc[]\" value=\"".$sql_row1['doc_no']."\">";
		$sql1x="select ref1,lot_no from bai_rm_pj1.fabric_status where item in (select compo_no from cat_stat_log where tid=\"".$sql_row1['cat_ref']."\")";
		$sql_result1x=mysql_query($sql1x,$link) or exit("Sql Error".mysql_error());
		if(mysql_num_rows($sql_result1x)==0)
		{
			echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
			echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
			echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
			echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
			echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";
			echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\"><br/>";		
		}
		else
		{
			while($sql_row1x=mysql_fetch_array($sql_result1x))
			{
				echo "<input type=\"checkbox\" value=\"".$sql_row1x['lot_no'].">".$sql_row1x['ref1']."\" name=\"".$sql_row1['doc_no']."[]\">".$sql_row1x['lot_no']."<br/>";
				
			}
		}
		echo "</td>"; */
		
		
		
		$enable_allocate_button=1;
	} 
	
//echo "Print Status==".$sql_row1['print_status']."</br>";	
if($sql_row1['print_status']>0)
{
	echo "<td><img src=\"correct.png\"></td>";
	$print_validation=$print_validation+1;
	
}
else
{
	// echo "Club Status==".$clubbing."</br>";
	// if($clubbing>0)
	// {
		// echo "<td><img src=\"correct.png\"></td>";
		// $print_validation=$print_validation+1;
	// }
	// else
	// {
		echo "<td><img src=\"Wrong.png\"></td>";
	//}
}
echo "<td>";	
	getDetails("D",$sql_row1['doc_no']);
	echo "</td>";

echo "</tr>";
unset($lotnos_array);
unset($seperated_lots);	
}
echo "<tr><td colspan=4><center>Total Required Material</center></td><td>$total</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
echo "</table></div>";
//echo $Disable_allocate_flag;
if($enable_allocate_button==1)
{	
	//disable allocate button
	// if($Disable_allocate_flag==0){
		echo "<input type=\"submit\" name=\"allocate\" value=\"Allocate\" class=\"btn btn-success\" onclick=\"button_disable()\">";
	// echo '<div id="process_message"><h2><font color="red">Please wait while updating data!!!</font><br/><font color="blue">After update, this window will close automatically!</font></h2></div>';
	// }
	
}
echo "</form>";
//NEW Implementation for Docket generation from RMS

$sql1="SELECT fabric_status from $bai_pro3.plan_dashboard where doc_no=$doc_no";
//mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result1);
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$fabric_status=$sql_row1['fabric_status'];
}

if($sql_num_check == 0){
	if($doc_no > 0){
		$fab_status_query = "SELECT fabric_status from $bai_pro3.order_cat_doc_mk_mix where doc_no=$doc_no";
		$fab_status_result = mysqli_query($link,$fab_status_query);
		while($row = mysqli_fetch_array($fab_status_result)){
			$fabric_status=$row['fabric_status'];
		}
	}
}
//echo "TEst"."<br>";
//echo sizeof($docket_num)."<br>";
if($fabric_status=="1")
{
	echo '<div class="alert alert-info"><strong>Fabric Status:</strong><br>Ready For Issuing: <font color="green">Completed</font><br>Issue to Module: <font color="red">Pending</font></div>';
}
$docket_num1 = "'" . implode ( "', '", $docket_num ) . "'";
$sql111="select ROUND(SUM(allocated_qty),2) AS alloc,count(distinct doc_no) as doc_count from $bai_rm_pj1.fabric_cad_allocation where doc_no in (".$docket_num1.")";
// echo $sql111."<br>";
$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row111=mysqli_fetch_array($sql_result111))
	{
		if($sql_row111['alloc']!='')
		{
			$alloc_qty=$sql_row111['alloc'];
		}
		else
		{
			$alloc_qty=0;
		}		
		//$allc_doc=$sql_row111['doc_count'];
	}
		
?>

<?php
// if($Disable_allocate_flag==0){
if($Disable_allocate_flag==$for_Staus_dis){
?>
<form method="post" onsubmit=" return validate_but();">
<table class="table table-bordered"><tr><th>Fabric Issue Status:</th><td> <select name="issue_status" id="issue_status" class="select2_single form-control">
<?php
// if($fabric_status!="5" && $fabric_status!="1")
// {
	// echo '<option value="1" >Ready For Issuing</option>';
	
// }
// if($fabric_status=="1")
// {
// 	echo '<option value="1" disabled>Ready For Issuing</option>';
// }
?>
<option value="1" <?php if($fabric_status=="1") { echo " selected"; }?>>Ready For Issuing</option>
<option value="5" <?php if($fabric_status=="5") { echo " selected"; }?>>Issue to Cutting</option>
</select></td><td>
<input type="checkbox" name="validate" id="validate" onclick="check_validate()"/><td>
<input type="hidden" value="<?php echo round($total,2); ?>" name="tot_req" id="tot_req"/>
<input type="hidden" value="<?php echo $dash; ?>" name="dashboard" id="dashboard"/>
<input type="hidden" value="<?php echo $alloc_qty; ?>" name="alloc_qty" id="alloc_qty"/>
<input type="hidden" value="<?php echo $style; ?>" name="style" id="style"/>
<input type="hidden" value="<?php echo $schedule; ?>" name="schedule" id="schedule"/>
<input type="hidden" value="<?php echo $allc_doc; ?>" name="alloc_doc" id="alloc_doc"/>
<input type="hidden" value="<?php echo sizeof($docket_num); ?>" name="doc_tot" id="doc_tot"/>
<input type="hidden" value="<?php echo $print_validation; ?>" name="print_validation" id="print_validation"/>
<input type="hidden" value="<?php echo $for_Staus_dis; ?>" name="sql_num_check" id="sql_num_check"/>
<td>
<div id="dvremark" style="display: none">
 <center>Remark:</center>
<textarea id="remarks" rows="4" cols="50" name="remarks" placeholder="Please fill the remarks">
  
</textarea>	

</div>
</td><td>
<?php
//echo "Fabric status :".$fabric_status;
if($pop_restriction==0)
{
	echo '<input type="submit" name="submit" id="submit" class="btn btn-success" value="Update" disabled="disabled">';
}
else
{
	echo "<font color=red>It's too early to issue to module.</font>";
}
echo "<input type=\"hidden\" name=\"group_docs\" value=".implode(",",$docket_num).">";
?>
</td></tr></table>
</form>
<?php
	}
// }
?>

<script>
	document.getElementById("msg").style.display="none";		
</script>

</div>
</div>

</body>

</html>

<?php

if(isset($_POST['submit']))
{
	
	$alloc_docket=$_POST['alloc_doc'];
	$doc_tot=$_POST['doc_tot'];
	$issue_status=$_POST['issue_status'];
	$group_docs=$_POST['group_docs'];
	$reason=$_POST['remarks'];
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$doc_num=explode(",",$group_docs);
	for($i=0;$i<sizeof($doc_num);$i++)
	{	
		$sql2="update $bai_pro3.plandoc_stat_log set fabric_status=$issue_status where doc_no='".$doc_num[$i]."'";
		
		mysqli_query($link, $sql2) or exit("Sql Error----5".mysqli_error($GLOBALS["___mysqli_ston"]));

		$sql11112="select remarks from $bai_pro3.plandoc_stat_log where doc_no='".$doc_num[$i]."'";
		//echo $sql111."</br>";
		$sql_result11112=mysqli_query($link, $sql11112) or exit("Sql Error--12".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row212=mysqli_fetch_array($sql_result11112))
		{	
			if($row212['remarks']=='Normal')
			{
				$doc_no_loc="D".$doc_num[$i];	
			}
			else
			{
				$doc_no_loc="R".$doc_num[$i];
			}
			
		}
		
		$sql111="select * from $bai_rm_pj1.fabric_cad_allocation where doc_no='".$doc_num[$i]."' and status=1";
		//echo $sql111."</br>";
		$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error--12".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result111)>0)
		{
			while($row2=mysqli_fetch_array($sql_result111))
			{
				$code=$row2['roll_id'];
				$tran_pin=$row2['tran_pin'];
				$sql1="select ref1,qty_rec,qty_issued,qty_ret,partial_appr_qty,qty_allocated,status from $bai_rm_pj1.store_in where roll_status in (0,2) and tid=\"$code\"";
				//echo "Qry :".$sql1."</br>";
				$sql_result=mysqli_query($link, $sql1) or exit("Sql Error--15".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$qty_rec=$sql_row['qty_rec']-$sql_row['partial_appr_qty'];
					$qty_issued=$sql_row['qty_issued'];
					$qty_ret=$sql_row['qty_ret'];
					$qty_allocate=$sql_row['qty_allocated'];
					$status_exist=$sql_row['status'];
				}
				//echo "</br>Qty Rec from store:".$qty_rec."</br>";
				$qty_iss=$row2['allocated_qty'];
				$validate_qty_status=$qty_allocate-$qty_iss;
				//echo "Qty Issued :".$qty_iss."</br>";
				$balance=$qty_rec-$qty_issued+$qty_ret;	
				$balance1=$qty_rec+$qty_ret-($qty_issued+$qty_iss);
				if($validate_qty_status>0)
				{
					$status=$status_exist;
				}
				else
				{	
					if($balance1==0)
					{
						$status=2;
					}
					else
					{
						$status=0;
					}
				}
				$condi1=(($qty_rec+$qty_ret)-($qty_iss+$qty_issued));
				//echo "BAl:".$condi1."</br>";
				if((($qty_rec-($qty_iss+$qty_issued))+$qty_ret)>=0 && $qty_iss > 0)
				{
					
					if($issue_status==5)
					{	
						$sql22="update $bai_rm_pj1.store_in set qty_issued=".($qty_issued+$qty_iss).",qty_allocated=qty_allocated-".$qty_iss.", status=$status, allotment_status=$status where tid=\"$code\"";
						mysqli_query($link, $sql22) or exit("Sql Error----3".mysqli_error($GLOBALS["___mysqli_ston"]));

						$sql211="select * from $bai_rm_pj1.store_out where tran_tid='".$code."' and qty_issued='".$qty_iss."' and Style='".$style."' and Schedule='".$schedule."' and cutno='".$doc_no_loc."' and date='".date("Y-m-d")."' and updated_by='".$username."' and remarks='".$reason."' and log_stamp='".date("Y-m-d H:i:s")."' ";
						$sql_result211=mysqli_query($link, $sql211) or exit("Sql Error--211: $sql211".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result211);
						if($sql_num_check==0)
						{
							$sql23="insert into $bai_rm_pj1.store_out (tran_tid,qty_issued,Style,Schedule,cutno,date,updated_by,remarks,log_stamp) values ('".$code."', '".$qty_iss."','".$style."','".$schedule."','".$doc_no_loc."','".date("Y-m-d")."','".$username."','".$reason."','".date("Y-m-d H:i:s")."')";
							//echo "Sql :".$sql23."</br>"; 
							//Uncheck this
							mysqli_query($link, $sql23) or exit("Sql Error----4".mysqli_error($GLOBALS["___mysqli_ston"]));
						}

						$sql24="update $bai_rm_pj1.fabric_cad_allocation set status=2 where tran_pin=\"$tran_pin\"";
						mysqli_query($link, $sql24) or exit("Sql Error----3".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					
				}
			
			}
		}	
	
	}
	if($issue_status==5)
	{
		$sql1="update $bai_pro3.plan_dashboard set fabric_status=$issue_status where doc_no in ($group_docs)";
		//Uncheck this
		mysqli_query($link, $sql1) or exit("Sql Error---5".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		$sql1="update $bai_pro3.plandoc_stat_log set fabric_status=$issue_status where doc_no in ($group_docs)";
		//Uncheck this
		mysqli_query($link, $sql1) or exit("Sql Error---6".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//if($issue_status==5)
		//{
		$sql3="update $bai_pro3.fabric_priorities set issued_time='".date("Y-m-d H:i:s")."' where doc_ref in ($group_docs)";
		//Uncheck this	
		mysqli_query($link, $sql3) or exit("Sql Error----7".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql1="INSERT INTO `$bai_pro3`.`log_rm_ready_in_pool` (`doc_no`, `date_n_time`, `username`) VALUES ('$group_docs', '".date("Y-m-d H:i:s")."','$username')";
		// echo $sql1;
		mysqli_query($link, $sql1) or exit("Sql Error33".mysqli_error());
	}

	if($issue_status==1)
	{
		$sql1="update $bai_pro3.plan_dashboard set fabric_status=$issue_status where doc_no in ($group_docs)";
		//Uncheck this
		mysqli_query($link, $sql1) or exit("Sql Error---5.1".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	if($dash==1){
		$php_self = explode('/',$_SERVER['PHP_SELF']);
		$ctd =array_slice($php_self, 0, -2);
		$url_rr=base64_encode(implode('/',$ctd)."/cut_table_dashboard/cut_table_dashboard.php");
		$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index.php?r=".$url_rr;
	}
	else{
		$php_self = explode('/',$_SERVER['PHP_SELF']);
		array_pop($php_self);
		$url_r = base64_encode(implode('/',$php_self)."/fab_priority_dashboard.php");
		$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index.php?r=".$url_r;
	}
	echo"<script>location.href = '".$url1."';</script>"; 
		
}
?>

<?php

if(isset($_POST['allocate']))
{

	// echo "test";
	$doc=$_POST['doc'];
	
	for($i=0;$i<sizeof($doc);$i++)
	{
		$temp='lot'.$doc[$i];
		$lot=$_POST[$temp];		
		// echo $lot[$i].">".$doc[$i].">".sizeof($lot[$i])."<br/>";
	}
	
}


//ALTER TABLE `bai_rm_pj1`.`fabric_cad_allocation` ADD COLUMN `status` INT NULL COMMENT '1- Check_pending, 2-Check_completed' AFTER `allocated_qty`;
// ALTER TABLE `bai_rm_pj1`.`store_out` CHANGE COLUMN `updated_by` `updated_by` VARCHAR(20) NOT NULL ;
// ALTER TABLE `bai_rm_pj1`.`fabric_cad_allocation_deleted` ADD COLUMN `status` INT NULL COMMENT '1- Check_pending, 2-Check_completed' AFTER `allocated_qty`;
foreach($cat_refnce as $docno => $doc_cat){


?>
<div class="modal fade" id="rejections_modal<?= $docno ;?>" role="dialog">
    <div class="modal-dialog" style="width: 90%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Change Marker Length
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
			</div>
			<div class="modal-body">
                <div class='panel panel-primary'>
                    <div class='panel-heading'>
                        Marker Length Details
                    </div>
                    <div class='panel-body'>
					<div class='col-sm-12'>
						<div class='table-responsive'>
                            <table class='table table-bordered rejections_table' max-width="80%" id='mark_len_table<?=$docno; ?>'>
							<thead>
								<tr class='.bg-dark'><th></th><th>Marker Type</th><th>Marker Version</th><th>Shrinkage Group</th><th>Width</th><th>Marker Length</th><th>Marker Name</th><th>Pattern Name</th><th>Marker Eff.</th><th>Perimeters</th><th>Remarks 1</th><th>Remarks 2</th><th>Remarks 3</th><th>Remarks 4</th><th>Control</th></tr>
							</thead>
                                <tbody id='rejections_table_body<?=$docno; ?>'>
								<?php 
									
									$doc_no = $docno;									
									$sql11x132="select allocate_ref,mk_ref_id,mk_ref from $bai_pro3.plandoc_stat_log where doc_no=".$doc_no.";";
									$sql_result11x112=mysqli_query($link, $sql11x132) or die("Error16 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
									$rows=0;
									
									while($row111x2=mysqli_fetch_array($sql_result11x112)) 
									{
										$mk_ref_id=$row111x2['mk_ref_id'];
										$sql_marker_details = "select * from $bai_pro3.maker_details where parent_id='".$row111x2['allocate_ref']."'";
										$sql_marker_details_result=mysqli_query($link, $sql_marker_details) or die("Error17 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
										$values_rows=mysqli_num_rows($sql_marker_details_result);
										echo "<input type='hidden' name='rows_val' id='rows_val' value='$values_rows' >";
										while($sql_marker_details_res=mysqli_fetch_array($sql_marker_details_result))
										{   
											// var_dump($sql_marker_details_res[id]);
											// var_dump($mk_ref_id);
											$rows++;
											if($sql_marker_details_res[id] == $mk_ref_id)
											{
												echo "<input type='hidden' name='first_val' id='first_val".$doc_no."' value='$mk_ref_id' >";
												echo "<input type='hidden' name='all_ref' id='all_ref".$doc_no."' value=".$row111x2['allocate_ref']." >";
												echo "<input type='hidden' name='mk_ref' id='mk_ref".$doc_no."' value=".$row111x2['mk_ref']." >";
												echo "<input type='hidden' name='doc_no' id='doc_no' value='$doc_no' >";
												echo "<tr><td style='display:none;' class='checked_value' id='checked$sql_marker_details_res[0]'>yes</td>
												<td style='display:none;'  id='id'>$sql_marker_details_res[id]</td>
												<td style='display:none;'  id='doc_no'>$doc_no</td>
												<td style='display:none;'  id='all_ref".$doc_no."'>".$row111x2['allocate_ref']."</td>
												<td style='display:none;'  id='mk_ref".$doc_no."'>".$row111x2['mk_ref']."</td>
												<td><input type='radio' name='selected_len$doc_no' value='".$sql_marker_details_res[0]."' onchange = valid_button($sql_marker_details_res[0]) id='check$sql_marker_details_res[0]' CHECKED></td>
												
												<td>$sql_marker_details_res[marker_type]</td><td>$sql_marker_details_res[marker_version]</td><td>$sql_marker_details_res[shrinkage_group]</td><td>$sql_marker_details_res[width]</td><td>$sql_marker_details_res[marker_length]</td><td>$sql_marker_details_res[marker_name]</td><td>$sql_marker_details_res[pattern_name]</td><td>$sql_marker_details_res[marker_eff]</td><td>$sql_marker_details_res[perimeters]</td><td>$sql_marker_details_res[remarks1]</td><td>$sql_marker_details_res[remarks2]</td><td>$sql_marker_details_res[remarks3]</td><td>$sql_marker_details_res[remarks4]</td><td style='display:none;'>1</td>	
												<td>Can't Delete</td>
												</tr>";
											}
											else
											{
												echo "<input type='hidden' name='first_val' id='first_val".$doc_no."' value='$mk_ref_id' >";
												echo "<input type='hidden' name='all_ref' id='all_ref".$doc_no."' value=".$row111x2['allocate_ref']." >";
												echo "<input type='hidden' name='mk_ref' id='mk_ref".$doc_no."' value=".$row111x2['mk_ref']." >";
												echo "<input type='hidden' name='doc_no' id='doc_no' value='$doc_no' >";
												echo "<tr><td style='display:none;' class='checked_value' id='checked$sql_marker_details_res[id]'>no</td>
												<td style='display:none;'  id='id'>$sql_marker_details_res[id]</td>
												<td style='display:none;'  id='doc_no'>$doc_no</td>
												<td style='display:none;'  id='all_ref".$doc_no."'>".$row111x2['allocate_ref']."</td>
												<td style='display:none;'  id='mk_ref".$doc_no."'>".$row111x2['mk_ref']."</td>
												<td><input type='radio' name='selected_len$doc_no' value='".$sql_marker_details_res[0]."' onchange = valid_button($sql_marker_details_res[id]) id='check$sql_marker_details_res[0]'></td>
												
												<td>$sql_marker_details_res[marker_type]</td><td>$sql_marker_details_res[marker_version]</td><td>$sql_marker_details_res[shrinkage_group]</td><td>$sql_marker_details_res[width]</td><td>$sql_marker_details_res[marker_length]</td><td>$sql_marker_details_res[marker_name]</td><td>$sql_marker_details_res[pattern_name]</td><td>$sql_marker_details_res[marker_eff]</td><td>$sql_marker_details_res[perimeters]</td><td>$sql_marker_details_res[remarks1]</td><td>$sql_marker_details_res[remarks2]</td><td>$sql_marker_details_res[remarks3]</td><td>$sql_marker_details_res[remarks4]</td><td style='display:none;'>1</td><td>Can't Delete</td></tr>";
											}												
										}										
									}
									?>
                                </tbody>

                                <tbody id='rejections_table'>
                                                
									<tr>
									<td></td>
									<?php
									echo "<input type='hidden' name='doc_no_new' id='doc_no_new' value='$id' >";
									?>
									<td><input class="form-control alpha"  type="text" name="in_mktype" id="mk_type<?=$doc_no ?>"></td>
									<td><input class="form-control alpha"  type="text" name= "in_mkver" id= "mk_ver<?=$doc_no ?>" onchange="validate_data(<?=$doc_no ?>, this)"></td>
									<td><input class="form-control alpha"  type="text" name= "in_skgrp" id= "sk_grp<?=$doc_no ?>" onchange="validate_data(<?=$doc_no ?>, this)"></td>
									<td><input class="form-control float"  type="text" name= "in_width" id= "width<?=$doc_no ?>" onchange="validate_data(<?=$doc_no ?>, this)"></td>
									<td><input class="form-control float"  type="text" name= "in_mklen" id= "mk_len<?=$doc_no ?>" onchange="validate_data(<?=$doc_no ?>, this)"></td>
									<td><input class="form-control alpha"  type="text" name= "in_mkname" id="mk_name<?=$doc_no ?>" onchange="marker_validation(<?=$doc_no ?>, this)"    ></td>
									<td><input class="form-control alpha"  type="text" name= "in_ptrname" id="ptr_name<?=$doc_no ?>"></td>
									<td><input class="form-control float"  type="text" name= "in_mkeff" id= "mk_eff<?=$doc_no ?>"></td>
									<td><input class="form-control alpha"  type="text" name= "in_permts" id= "permts<?=$doc_no ?>"></td>
									<td><input class="form-control alpha"  type="text" name= "in_rmks1" id= "rmks1<?=$doc_no ?>"></td>
									<td><input class="form-control alpha"  type="text" name= "in_rmks2" id= "rmks2<?=$doc_no ?>"></td>
									<td><input class="form-control alpha"  type="text" name= "in_rmks3" id= "rmks3<?=$doc_no ?>"></td>
									<td><input class="form-control alpha"  type="text" name= "in_rmks4" id= "rmks4<?=$doc_no ?>"></td>
									<td></td>
									</tr>  
								</tbody>
                            </table>
							</div>
								<input type='button' class='btn btn-danger pull-right' value='clear' name='clear_rejection' id='clear_rejection' onclick='clear_row(<?=$doc_no ?>)'>
								<?php 
									echo "<input type='button' class='btn btn-warning pull-right' value='Add' name='add_mklen' onclick = 'add_Newmklen(".$doc_no.")' id='add_marker_length'>";
								?>
					<br>
					<?php
					echo "<input type='button' class='btn btn-success pull-left' value='Submit' name='submit' onclick=submit_mklen(".$doc_no.")  id='submit_length'>";
					?>

                    </div>

                </div>
				</div>
                    
                
            </div>
		</div>
	</div>
</div>
<?php
}
?>		
<script>
// $('#address').on('input', function () {
	
//     var hasNumber = this.value.match(/\d/);
//     var isAlfa    = this.value.match(/^[0-9/]+$/);
    
//     if ( hasNumber && isAlfa ) {
//         //$('#valid').removeClass('invalid');
//     } else {
//         //$('#valid').addClass('invalid');
//     }

// });
function no_marker_edit(doc_no){
	swal('Marker Can\'t edit','','warning');
}
function marker_edit(doc_no){
	$("#rejections_modal"+doc_no).modal('toggle');	
}

function compareArrays(arr1, arr2){
	arr1 = $.trim(arr1);
	arr2 = $.trim(arr2);
	if(arr1.toString() == arr2.toString()){
		return true;
	}else{
		return false;
	}
}
function marker_validation(id_name, cur_element) 
{
	if($("#mk_name"+id_name).val() != ''){
	var array = [];
	var CurData=[];
	$('#mark_len_table'+id_name+' tr').has('td').each(function() {
		var arrayItem = [];
		$('td', $(this)).each(function(index, item) {
			arrayItem[index] = $(item).text();
		});
		array.push(arrayItem);
	});
	CurData = [$("#mk_name"+id_name).val()];
		var table = $('#mark_len_table'+id_name);
		var tr_length= table.find('tr').length;
		for($i=0; $i<tr_length - 1; $i++)
		{
			rowData = [array[$i][11]];
			if(compareArrays(CurData, rowData)){
				swal('Marker Name Already exists','Please Check.','warning');
				$("#"+cur_element.id).val('');
				return true;
			}
		}
	}
}

function validate_data(id_name, cur_element) 
{
	if($("#mk_ver"+id_name).val() != '' && $("#sk_grp"+id_name).val() != '' && $("#width"+id_name).val() != '' && $("#mk_len"+id_name).val()){
	var array = [];
	var CurData=[];
	$('#mark_len_table'+id_name+' tr').has('td').each(function() {
		var arrayItem = [];
		$('td', $(this)).each(function(index, item) {
			arrayItem[index] = $(item).text();
		});
		array.push(arrayItem);
	});
	CurData = [$("#mk_ver"+id_name).val(), $("#sk_grp"+id_name).val(), $("#width"+id_name).val(), Math.round($("#mk_len"+id_name).val())];
		var table = $('#mark_len_table'+id_name);
		var tr_length= table.find('tr').length;
	

		for($i=0; $i<tr_length - 1; $i++)
		{
			rowData = [array[$i][7], array[$i][8], array[$i][9], Math.round(array[$i][10])];
			// if(compareArrays(CurData, rowData)){
			// 	swal('Marker Name Must be Unique','','error');
			// 	$("#"+cur_element.id).val('');
			// 	return true;
			// }
			if(compareArrays(CurData, rowData)){
				swal('Using Same combinations...','Please Check.','warning');
				$("#"+cur_element.id).val('');
				return true;
			}
		}
	}
	
}
function add_Newmklen(doc_no)
{	
	var mk_type = $('#mk_type'+doc_no).val();
	var mk_ver = $('#mk_ver'+doc_no).val();
	var sk_grp = $('#sk_grp'+doc_no).val();
	var width = $('#width'+doc_no).val();
	var mk_len = $('#mk_len'+doc_no).val();
	var mk_name = $('#mk_name'+doc_no).val();
	var ptr_name = $('#ptr_name'+doc_no).val();
	var mk_eff = $('#mk_eff'+doc_no).val();
	var permts = $('#permts'+doc_no).val();
	var rmks1 = $('#rmks1'+doc_no).val();
	var rmks2 = $('#rmks2'+doc_no).val();
	var rmks3 = $('#rmks3'+doc_no).val();
	var rmks4 = $('#rmks4'+doc_no).val();
	var values_rows1 = $('#first_val').val();
	var all_refs = $('#all_ref'+doc_no).val();
	var doc_nos = doc_no;
	var doc_no_new = doc_no;
	var mk_refs = $('#mk_ref'+doc_no).val();
	var rows_valu = parseInt($('#rows_val').val())+1;
	$('.checked_value').text('no');

	if(mk_ver == ''){
		sweetAlert('Please enter valid Marker Version','','warning');
		return false;
	}
	
	if(mk_len <=0)
	{
		sweetAlert('Please enter valid Marker Length','','warning');
		return false;
	}
	if(width <=0){
		sweetAlert('Please enter valid Marker Width','','warning');
		return false;
	}
	if(mk_len == ''|| mk_len <=0){
		sweetAlert('Please enter valid Marker Length','','warning');
		return false;
	}
	if(mk_eff == '')
	{
		mk_eff = 0;
	}
	if(mk_eff>100){
		sweetAlert('Please enter valid Marker Efficiency','','warning');
		return false;
	}
	if(mk_ver <=0 || mk_ver ==''){
		sweetAlert('Please enter valid Marker Version','','warning');
		return false;
	}
	var table_body = $("#rejections_table_body"+doc_no);
	var new_row = "<tr id='unique_d_"+doc_no+"_r_"+rows_valu+"'><td style='display:none;' class='checked_value' id='checked"+values_rows1+"'>yes</td><td style='display:none;' id='id'>"+rows_valu+"</td><td style='display:none;' id='doc_no' >"+doc_no_new+"</td><td style='display:none;'  id='all_ref'>"+all_refs+"</td><td style='display:none;'  id='mk_ref'>"+mk_refs+"</td><td><input type='radio' name='selected_len"+doc_no+"' value="+rows_valu+" id='check"+rows_valu+"' onchange = valid_button("+rows_valu+") CHECKED></td><td>"+mk_type+"</td><td>"+mk_ver+"</td><td>"+sk_grp+"</td><td>"+width+"</td><td>"+mk_len+"</td><td>"+mk_name+"</td><td>"+ptr_name+"</td><td>"+mk_eff+"</td><td>"+permts+"</td><td>"+rmks1+"</td><td>"+rmks2+"</td><td>"+rmks3+"</td><td>"+rmks4+"</td><td style='display:none;'>0</td><td><input type='button' style='display : block' class='btn btn-sm btn-danger' id=delete_row"+rows_valu+" onclick=delete_row("+rows_valu+","+doc_no+") value='Delete'></td></tr>";
	
	$("#rejections_table_body"+doc_no).append(new_row);
	$('#mk_type'+doc_no).val(' ');
	$('#mk_ver'+doc_no).val(' ');
	$('#sk_grp'+doc_no).val(' ');
	$('#width'+doc_no).val(' ');
	$('#mk_len'+doc_no).val(' ');
	$('#mk_name'+doc_no).val(' ');
	$('#ptr_name'+doc_no).val(' ');
	$('#mk_eff'+doc_no).val(' ');
	$('#permts'+doc_no).val(' ');
	$('#rmks1'+doc_no).val(' ');
	$('#rmks2'+doc_no).val(' ');
	$('#rmks3'+doc_no).val(' ');
	$('#rmks4'+doc_no).val(' ');
}
function delete_row(rows_valu,doc_no){
	
	$("#rejections_table_body"+doc_no+" tr#unique_d_"+doc_no+"_r_"+rows_valu).remove();
	var values_rows1 = $("#first_val"+doc_no+"").val();
	$('.checked_value').text('no');
	$('#checked'+values_rows1).text('yes');
	$('#check'+values_rows1).prop('checked', true);
}
function clear_row(doc_no)
{
	$('#mk_type'+doc_no).val(' ');
	$('#mk_ver'+doc_no).val(' ');
	$('#sk_grp'+doc_no).val(' ');
	$('#width'+doc_no).val(' ');
	$('#mk_len'+doc_no).val(' ');
	$('#mk_name'+doc_no).val(' ');
	$('#ptr_name'+doc_no).val(' ');
	$('#mk_eff'+doc_no).val(' ');
	$('#permts'+doc_no).val(' ');
	$('#rmks1'+doc_no).val(' ');
	$('#rmks2'+doc_no).val(' ');
	$('#rmks3'+doc_no).val(' ');
	$('#rmks4'+doc_no).val(' ');
}
function valid_button(row_num)
{
	$('.checked_value').text('no');
	$('#checked'+row_num).text('yes');
}
function submit_mklen(doc_no)
{
	var tabledata = [];
	$('#mark_len_table'+doc_no+' tr').has('td').each(function() {
		var tabledataItem = [];
		$('td', $(this)).each(function(index, item) {
			tabledataItem[index] = $(item).text();
		});
		tabledata.push(tabledataItem);
	});
	var jsonString = JSON.stringify(tabledata);
	$.ajax({
	type : "POST",
	url : '<?= $get_url1 ?>',
	data: {data : jsonString,doc_no:doc_no}, 
	success : function(response){
		var data = jQuery.parseJSON(response);
		var p1 = data.status_no;
		
		if(p1 == 1)
		{
			swal('Success',data.status,'success');
		}
		else if(p1 == 2)
		{
			swal('Success',data.status_new,'success');
		}
		else
		{
			swal('error','Something Went Wrong Please try again..!','error');	
		}	
		// location.reload();
		window.setTimeout(function(){location.reload()},2000);
	}
	});
}
</script>

