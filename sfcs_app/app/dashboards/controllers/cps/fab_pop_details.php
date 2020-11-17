<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_dashboard.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/server_urls.php');
// include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/user_acl_v1.php');
// include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/group_def.php');

 include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
$dash=0;
if (isset($_GET['dash'])) {
	$dash=1;
}
$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/fab_pps_dashboard_v2.php");
// $has_permission=haspermission($url_r); 
$php_self = explode('/',$_SERVER['PHP_SELF']);
$ctd =array_slice($php_self, 0, -2);
$get_url=implode('/',$ctd)."/Cut_table_dashboard/marker_length_popup.php";

$get_url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."".$get_url;

?>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/common/css 	/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php 
if($dash==1){
 	$php_self = explode('/',$_SERVER['PHP_SELF']);
	$ctd =array_slice($php_self, 0, -2);
	$url_rr=base64_encode(implode('/',$ctd)."/cut_table_dashboard/cut_table_dashboard.php");
	$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index-no-navi.php?r=".$url_rr;
}
else{
	$php_self = explode('/',$_SERVER['PHP_SELF']);
	array_pop($php_self);
	$url_r = base64_encode(implode('/',$php_self)."/fab_priority_dashboard.php");
	$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index-no-navi.php?r=".$url_r;
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
$plant_code=$_GET['plantcode_name'];
$username=$_GET['username'];
$doc_no=$_GET['doc_no'];
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

$check_sql = "SELECT * from $pps.fabric_prorities left join $pps.jm_docket_lines on jm_docket_lines.jm_docket_line_id=fabric_prorities.jm_docket_line_id where fabric_prorities.jm_docket_line_id='$doc_no' and fabric_prorities.plant_code='$plant_code'";
// if($check_sql_res_check >0){
// 	$sql1="SELECT order_style_no,order_del_no,order_col_des,color_code,acutno,order_tid,order_style_no,order_del_no,clubbing from $bai_pro3.cut_tbl_dash_doc_summ where doc_no=$doc_no";
// }else{
// 	$sql1="SELECT order_style_no,order_del_no,order_col_des,color_code,acutno,order_tid,order_style_no,order_del_no,clubbing from $bai_pro3.plan_dash_doc_summ where doc_no=$doc_no";
// }
// $sql1="SELECT bodc.order_style_no,bodc.order_del_no,bodc.order_col_des,bodc.color_code,psl.acutno,bodc.order_tid,csl.clubbing,psl.remarks FROM bai_pro3.plandoc_stat_log AS psl,bai_pro3.bai_orders_db_confirm AS bodc,bai_pro3.cat_stat_log AS csl WHERE psl.order_tid= bodc.order_tid AND csl.order_tid = bodc.order_tid AND csl.order_tid=psl.order_tid AND csl.tid= psl.cat_ref AND psl.doc_no = $doc_no";
// echo $sql1;
$sql_result1=mysqli_query($link, $check_sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result1);
$sizes_table ='';
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	//$docket_remarks=$sql_row1['remarks'];
	// if(strtolower($sql_row1['remarks']) == 'recut')
	// 	$appender = 'R';
    // else	
	$sql11x11="SELECT docket_line_number FROM $pps.jm_docket_lines where plant_code='$plant_code' and jm_docket_line_id='$doc_no'";
	$sql_result11x11=mysqli_query($link, $sql11x11) or die("Error10 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row111x11=mysqli_fetch_array($sql_result11x11))
	{
	  $docket_line_no=$row111x11["docket_line_number"];

	}  
    if($docket_line_no!='' && $plant_code!=''){
		$result_docketinfo=getDocketInformation($docket_line_no,$plant_code);
		$style =$result_docketinfo['style'];
		$colorx =$result_docketinfo['fg_color'];
		$cut_no =$result_docketinfo['cut_no'];
		$cat_refnce =$result_docketinfo['category'];
		$cat_compo =$result_docketinfo['rm_sku'];
		$fabric_required =$result_docketinfo['required_qty'];
		$length =$result_docketinfo['length'];
		$shrinkage =$result_docketinfo['shrinkage'];
		$width =$result_docketinfo['width'];
		$marker_version_id =$result_docketinfo['marker_version_id'];
		
	}
	echo "<tr>";
	echo "<td>".$style."</td>";
	echo "<td>".$sql_row1['order_del_no']."</td>";
	echo "<td>".$colorx."</td>";
	echo "<td>".$cut_no."</td>";
	echo "</tr>";
	
	
	
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
	 $style_ref=$style;
	// // echo $style_ref." is style-ref";
	// $del_ref=$sql_row1['order_del_no'];
	
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
	// $clubbing=$sql_row1['clubbing'];
}

echo "</table>";

//echo $sizes_table;




//NEW Implementation for Docket generation from RMS

echo "<h2>Cut Docket Print</h2>";

echo "<form name=\"ins\" method=\"post\" action=\"fab_pop_allocate_v5.php\">"; //new_Version

	echo "<input type=\"hidden\" value=\"1\" name=\"process_cat\">";

 //this is to identify recut or normal processing of docket (1 for normal 2 for recut)
echo "<input type=\"hidden\" value=\"$style_ref\" name=\"style_ref\">";  
echo "<input type=\"hidden\" value=\"$dash\" name=\"dashboard\">";  
echo "<input type=\"hidden\" value=\"$username\" name=\"username\">"; 
echo "<input type=\"hidden\" value=\"$plant_code\" name=\"plantcode1\">"; 
echo "<input type=\"hidden\" name=\"doc_mer\" value=\"".$fabric_required."\">";
echo "<input type=\"hidden\" name=\"doc_no\" value=\"".$doc_no."\">";

echo "<div class='table-responsive'><table class='table table-bordered'><tr><th>Category</th><th>Item Code</th><th>Color Desc. - Docket No</th><th>Marker Update</th><th>Required<br/>Qty</th><th>Reference</th>
<th>Shrinkage</th><th>Width</th><th>Control</th><th>Print Status</th><th>Roll Details</th></tr>";
//$sql1="SELECT plandoc_stat_log.plan_lot_ref,plandoc_stat_log.cat_ref,plandoc_stat_log.print_status,plandoc_stat_log.doc_no,cat_stat_log.category from plandoc_stat_log left join cat_stat_log on plandoc_stat_log.cat_ref=cat_stat_log.tid  where plandoc_stat_log.order_tid=\"$order_id_ref\" and plandoc_stat_log.acutno=$cut_no_ref";

// if(strtolower($docket_remarks) == 'normal')
// {
//   $sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\" and order_cat_doc_mk_mix.acutno=$cut_no_ref and order_cat_doc_mk_mix.remarks='Normal' and act_cut_status<>'DONE' and org_doc_no <=1 ";
// }
// elseif(strtolower($docket_remarks) == 'pilot')
// {
// 	$sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\"  and order_cat_doc_mk_mix.acutno=$cut_no_ref  and order_cat_doc_mk_mix.remarks='Pilot' and act_cut_status<>'DONE' and org_doc_no <=1 ";
// }
// elseif(strtolower($docket_remarks) == 'recut')
// {
// 	$sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\"  and order_cat_doc_mk_mix.remarks='Recut' and order_cat_doc_mk_mix.acutno=$cut_no_ref and act_cut_status<>'DONE' and org_doc_no <=1 ";
// }
// else
// {
// 	$sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\"  and order_cat_doc_mk_mix.doc_no=$doc_no and order_cat_doc_mk_mix.acutno=$cut_no_ref and act_cut_status<>'DONE' and org_doc_no <=1 ";
// }

// $sql1="SELECT order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\" and order_cat_doc_mk_mix.acutno=$cut_no_ref and order_cat_doc_mk_mix.doc_no=$doc_no";

//Color Clubbing New Code
// if($clubbing>0)
// {
//    if(strtolower($docket_remarks) == 'normal')
//    {
// 	 $sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid in (select distinct order_tid from $bai_pro3.plan_doc_summ where order_style_no=\"$style_ref\" and order_del_no=\"$del_ref\" and clubbing=$clubbing) and order_cat_doc_mk_mix.acutno=$cut_no_ref  and org_doc_no <=1";
//    }
//    elseif(strtolower($docket_remarks) == 'pilot')
//    {
// 	   $sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid in (select distinct order_tid from $bai_pro3.plan_doc_summ where order_style_no=\"$style_ref\" and order_del_no=\"$del_ref\" and clubbing=$clubbing)  and order_cat_doc_mk_mix.acutno=$cut_no_ref  and org_doc_no <=1";
	   
//    }
//    elseif(strtolower($docket_remarks) == 'recut')
//    {
//    	$sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid in (select distinct order_tid from $bai_pro3.plan_doc_summ where order_style_no=\"$style_ref\" and order_del_no=\"$del_ref\" and clubbing=$clubbing) and  order_cat_doc_mk_mix.acutno=$cut_no_ref  and org_doc_no <=1";
//    }
//    else
//    {
//    	$sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid in (select distinct order_tid from $bai_pro3.plan_doc_summ where order_style_no=\"$style_ref\" and order_del_no=\"$del_ref\" and clubbing=$clubbing) and order_cat_doc_mk_mix.doc_no=$doc_no and order_cat_doc_mk_mix.acutno=$cut_no_ref  and org_doc_no <=1";
//    }
// }
$sql1="select * from $pps.fabric_prorities left join $pps.jm_docket_lines on jm_docket_lines.jm_docket_line_id=fabric_prorities.jm_docket_line_id where fabric_prorities.jm_docket_line_id='$doc_no' and fabric_prorities.plant_code='$plant_code'";
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
	
	if($style_flag==0)
	{
        $docno_lot=$sql_row1['jm_docket_line_id'];
        if($docket_line_no!='' && $plant_code!=''){
            $result_docketinfo=getDocketInformation($docket_line_no,$plant_code);
            $style =$result_docketinfo['style'];
            
        }
		// var_dump($docno_lot);
		//$componentno_lot=$sql_row1['compo_no'];
		//$clubbing=$sql_row1['clubbing'];
		//echo $docno_lot."--".$clubbing."<br>";
		// if($clubbing>0)
		// {
		// 	$path="../../../cutting/controllers/lay_plan_preparation/color_club_docket_print.php";
		// }
		// else
		// {
			// $path="../../../cutting/controllers/lay_plan_preparation/Book3_print.php";
			$path=$DOCKET_SERVER_IP."/printDocket/";
		//}
		

		
		// echo "<br>DocNo: ".$docno_lot.'Component No: '.$componentno_lot;
		//getting lot numbers with reference style code and component no
		/*$qry_lotnos="SELECT p.order_tid,p.doc_no,c.compo_no,s.style_no,s.lot_no,s.batch_no FROM bai_pro3.plandoc_stat_log p LEFT JOIN bai_pro3.cat_stat_log c ON 
		c.order_tid=p.order_tid LEFT JOIN bai_rm_pj1.sticker_report s ON s.item=c.compo_no WHERE p.doc_no='$docno_lot' and item='$componentno_lot'";*/
		
		
		// $qry_lotnos="select* from $wms.sticker_report left join $pps.requested_dockets on requested_dockets.plan_lot_ref=sticker_report.lot_no where sticker_report.product_group='Fabric' and sticker_report.plant_code='$plant_code'";

		$qry_lotnos="select* from $wms.sticker_report left join $pps.requested_dockets on requested_dockets.plan_lot_ref=sticker_report.lot_no where sticker_report.product_group='Fabric' and sticker_report.plant_code='$plant_code' and requested_dockets.jm_docket_line_id='$doc_no'";
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
}
// 	$sql2="SELECT (p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as qty FROM plandoc_stat_log WHERE doc_no=".$sql_row1['doc_no']."";
// 	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
// 	while($sql_row2=mysqli_fetch_array($sql_result2))
// 	{
// 		$p_qty=$sql_row2['qty'];
// 	}
// 	$shrinkaage='';
// 	$mwidt='A';
 	$marker_id='';
	$sql007="select reference from $pps.requested_dockets where jm_docket_line_id=\"".$doc_no."\"";
	$sql_result007=mysqli_query($link, $sql007) or die("Error2 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row007=mysqli_fetch_array($sql_result007))
	{
		$reference=$row007["reference"];
}	
// 		// if($row007['mk_ref_id']>0)
// 		// {	 
    if($docket_line_no!='' && $plant_code!=''){
                $result_docketinfo=getDocketInformation($docket_line_no,$plant_code);
                $style =$result_docketinfo['style']; 
                $marker_version_id =$result_docketinfo['marker_version_id'];  
    }
                
            
            $sql11x1321="select shrinkage,width,length,marker_version_id from $pps.lp_markers where marker_version_id='$marker_version_id' and plant_code='$plant_code'";
			$sql_result11x11211=mysqli_query($link, $sql11x1321) or die("Error15 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row111x2112=mysqli_fetch_array($sql_result11x11211)) 
			{
				$shrinkaage=$row111x2112['shrinkage_group'];
				$mwidt=$row111x2112['width'];
				$marker_id=$row111x2112['marker_version_id'];
			}
// 		// }
// 		// else
// 		// {
// 		// 	$shrinkaage='N/A';
// 		// 	$mwidt='N/A';
// 		// 	$marker_id='';
// 		// }
// }
	// echo "</br>Seperated--".$seperate_docket;
	// $sql5="SELECT binding_consumption,seperate_docket,purwidth from $bai_pro3.cat_stat_log where  tid=\"".$sql_row1['cat_ref']."\"";
	// $sql_result5=mysqli_query($link, $sql5) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	// while($sql_row5=mysqli_fetch_array($sql_result5))
	// {
	// 	$binding_consumption=$sql_row5['binding_consumption'];
	// 	$seperate_docket=$sql_row5['seperate_docket'];
	// 	$purwidth=$sql_row5['purwidth'];
	// 	if($mwidt=='N/A'){
	// 		$mwidt= $purwidth;
	// 	}
	// }
	// echo "Quaty=====".$p_qty."<br>";
	// echo "binding_consumption".$binding_consumption."<br>";
	// $binding_consumption_qty = $binding_consumption * $p_qty;
	
	// // echo "</br>material_req--".$sql_row1['material_req'];
	// // echo "</br>binding_consumption_qty--".$binding_consumption_qty;
	// if($seperate_docket=='No'){
	// 	$material_requirement_orig=$sql_row1['material_req'];
	// }else{
	// 	$material_requirement_orig=$sql_row1['material_req']-$binding_consumption_qty;
	// }
    if($docket_line_no!='' && $plant_code!=''){
		$result_docketinfo=getDocketInformation($docket_line_no,$plant_code);
		$style =$result_docketinfo['style'];
		$colorx =$result_docketinfo['fg_color'];
		$cut_no =$result_docketinfo['cut_no'];
        $cat_refnce =$result_docketinfo['category'];
        $length =$result_docketinfo['length'];
		$shrinkage =$result_docketinfo['shrinkage'];
        $width =$result_docketinfo['width'];
        $cat_compo =$result_docketinfo['rm_sku'];
		$fabric_required =$result_docketinfo['required_qty'];
		$docket_line_number =$result_docketinfo['docket_line_number'];
		$ratio_comp_group_id =$result_docketinfo['ratio_comp_group_id'];
		$po_number=$result_docketinfo['sub_po'];
		
	}
	echo "<tr><td>".$cat_refnce."</td>";
	echo "<td>".$cat_compo."</td>";
    echo "<td>".$colorx.'-'.$docket_line_number."</td>";
    // echo "<td>".($marker)."</td>";
    
	$maker_update="select * from $pps.requested_dockets where plant_code='$plant_code' and jm_docket_line_id='".$doc_no."'";
	$maker_update_result=mysqli_query($link, $maker_update) or exit("Sql Error--12".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($maker_update_result)){
		$plan_lot_ref = $row['plan_lot_ref'];
		$print_status=$row['print_status'];
		
		
       
    }
  
	$sql11x11="SELECT marker_version_id FROM $pps.jm_docket_lines where plant_code='$plant_code' and jm_docket_line_id='$doc_no'";
	$sql_result11x11=mysqli_query($link, $sql11x11) or die("Error10 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row111x11=mysqli_fetch_array($sql_result11x11))
	{
		$marker_version1=$row111x11["marker_version_id"];
	}
	$sql11x1="SELECT marker_version_id,marker_version FROM $pps.lp_markers where plant_code='$plant_code' and lp_ratio_cg_id='$ratio_comp_group_id'";
	$sql_result11x1=mysqli_query($link, $sql11x1) or die("Error10 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	   echo "<td><SELECT name='marker_version'  id='marker_version'id='rejections_panel_btn'".$doc_no." style='height: 30px;' onchange=marker_edit()>";
	
	   echo"<option value=\"select_version\" selected>Select Marker Version</option>";
		while($row111x1=mysqli_fetch_array($sql_result11x1))
		{
			$marker_version=$row111x1["marker_version"];
			
			if($row111x1['marker_version_id']==$marker_version1)
			{
				echo "<option value=\"".$row111x1['marker_version_id']."\" selected>".$row111x1['marker_version']."</option>";
			}
			else
			{
				echo "<option value=\"".$row111x1['marker_version_id']."\">".$row111x1['marker_version']."</option>";
			}
			
		 }
    echo "</select>
    <div id ='dynamic_table1' style='width: 350px;'>
</div></td>";
 
echo"</br></br>";


	// if($allocation != '')
	// {
	// 	echo "<td><center><span class='label label-warning'>Can't Edit</span></center></td>";
	// } else {
	// 	// if($marker_id != ''){
	// 	// 	echo "<td><center><input type='button' style='display : block' class='btn btn-sm btn-danger' id='rejections_panel_btn'".$doc_no." onclick=marker_edit(".$doc_no.") value='Edit'></center></td>";
	// 	// } else {
	// 	// 	//for old marker values we cant edit.
	// 	// 	echo "<td><center><input type='button' style='display : block' class='btn btn-sm btn-danger' id='rejections_panel_btn'".$doc_no." onclick=no_marker_edit(".$doc_no.") value='Edit'></center></td>";
	// 	// }
	// }
	$extra=0;
	$percentage_query="select percentage FROM $pps.mp_additional_qty where plant_code='$plant_code' and po_number='$po_number' and order_quantity_type='CUTTING_WASTAGE'";
	$percentage_query_result=mysqli_query($link, $percentage_query) or die("Error10 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row111x111=mysqli_fetch_array($percentage_query_result))
	{
		$percentage=$row111x111["percentage"];

	}
	$value=$fabric_required*($percentage/100);
	$total_required_qty=$value+$fabric_required;
	// { $extra=round(($material_requirement_orig*$sql_row1['savings']),2); }
    echo "<td>".$total_required_qty."</td>";
	echo "<td>".$reference."</td>";
	echo "<td>".$shrinkage."</td>";
    echo "<td>".$width."</td>";
    // echo "<td>".$allocation."</td>";
	$temp_tot=$material_requirement_orig+$extra;
	$total+=$fabric_required;
	$temp_tot=0;
	// $club_id=$sql_row1['clubbing'];
	// //For new implementation
	// $newOrderTid=$sql_row1['order_tid'];
	 $doc_cat=$cat_refnce;
	// $doc_com=$sql_row1['compo_no'];
	// $doc_mer=($material_requirement_orig+$extra);
	// $cat_ref=$sql_row1['cat_ref'];
	
	//To Encode Order tid
	//$main_order_tid=order_tid_encode($newOrderTid);
	//For new implementation
	



	$docket_num[]=$doc_no;
	//echo var_dump($docket_num);
	//echo "</br>Length :".$sql_row1['plan_lot_ref']."</br>";
	//if(strlen($sql_row1['plan_lot_ref'])>0)
	//if(strlen($sql_row1['plan_lot_ref'])>0)

if($print_status=='0000-00-00 00:00:00'){
	$print_status=0;
	$print_status1=0;
}else{
	$print_status=$print_status;
	$print_status1=1;
}
	
	if($plan_lot_ref!='')
	{	

		$plan_lot_ref=$plan_lot_ref;
		
		$allc_doc++;
		//echo $sql_row1['category']."</br>";
		//echo var_dump($comp_printed)."</br>";
		if($clubbing>0)
		{
			if(!in_array($sql_row1['category'],$comp_printed))
			{
				echo "<td><a href='$path$doc_no'  onclick=\"Popup1=window.open('$path$doc_no','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";
				// echo "<td><a href=\"$path?doc_no=".$docket_line_number."&print_status=$print_status&plant_code=$plant_code&username=$username&doc_id=".$docket_line_number."\"  onclick=\"Popup1=window.open('$path?print_status=$print_status&plant_code=$plant_code&username=$username&doc_id=".$docket_line_number."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";
				$comp_printed[]=$sql_row1['category'];
			}
			else
			{
				echo "<td>Clubbed</td>";
			}
		}
		else
		{
			echo "<td><a href='$path$doc_no' onclick=\"Popup1=window.open('$path$doc_no','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";
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
		
		echo "<td><input type=\"hidden\" name=\"doc[]\" value=\"".$doc_no."\">";
		
		//For New Implementation
		echo "<input type=\"hidden\" name=\"doc_cat[]\" value=\"".$doc_cat."\">";
		echo "<input type=\"hidden\" name=\"doc_com[]\" value=\"".$doc_com."\">";
		echo "<input type=\"hidden\" name=\"doc_mer[]\" value=\"".$fabric_required."\">";
		echo "<input type=\"hidden\" name=\"cat_ref[]\" value=\"".$cat_ref."\">";
		//For New Implementation
		
		if($style_flag==0){
			if(sizeof($lotnos_array) ==''){
				// $seperated_lots="No lot Number Found";
				$Disable_allocate=1;
			}
			echo "Please Provide Lot Numbers: <textarea class=\"form-control\" name=\"pms".$doc_no."\" id='address' 
			      onkeyup='return verify_num(this,event)' onchange='return verify_num(this,event)' cols=12 rows=10 placeholder='No Lot Number Found, Please Enter Lot Number'>".$seperated_lots."</textarea><br/>";

		}else{

			echo "Please Provide Lot Numbers: <textarea class=\"form-control\" id='address' onkeyup='return verify_num(this,event)'
			     onchange='return verify_num(this,event)' name=\"pms".$doc_no."\" cols=12 rows=10 ></textarea><br/>";

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
if($print_status>0)
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
		echo "<td><img src=\"wrong.png\"></td>";
	//}
}

	

echo "<td>";	
	getDetails($doc_no,$plant_code);
	echo "</td>";

unset($lotnos_array);
unset($seperated_lots);	
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

$sql1="SELECT fabric_status from $pps.requested_dockets where plant_code='$plant_code' and jm_docket_line_id='$doc_no'";

//mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error567".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result1);
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$fabric_status=$sql_row1['fabric_status'];
}

if($sql_num_check == 0){
	if($doc_no > 0){
		$fab_status_query = "SELECT fabric_status from $pps.requested_dockets where plant_code='$plant_code' and jm_docket_line_id='$doc_no'";
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
// $docket_num1 = "'" . implode ( "', '", $docket_num ) . "'";
$sql111="select ROUND(SUM(allocated_qty),2) AS alloc,count(distinct doc_no) as doc_count from $wms.fabric_cad_allocation where doc_no='$doc_no'  and plant_code='$plant_code'";
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
     $Disable_allocate_flag=1;
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
echo "<input type=\"hidden\" name=\"group_docs\" value=".$doc_no.">";
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
	$marker_version=$_POST['marker_version'];
	$doc_num=explode(",",$group_docs);
	for($i=0;$i<sizeof($doc_num);$i++)
	{	
		$sql2="update $pps.requested_dockets set fabric_status='$issue_status',updated_user='$username',updated_at=NOW() where jm_docket_line_id='".$doc_no."'";
		
		mysqli_query($link, $sql2) or exit("Sql Error----5".mysqli_error($GLOBALS["___mysqli_ston"]));

		// $sql11112="select remarks from $bai_pro3.plandoc_stat_log where doc_no='".$doc_num[$i]."'";
		// //echo $sql111."</br>";
		// $sql_result11112=mysqli_query($link, $sql11112) or exit("Sql Error--12".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($row212=mysqli_fetch_array($sql_result11112))
		// {	
		// 	if($row212['remarks']=='Normal')
		// 	{
		// 		$doc_no_loc="D".$doc_num[$i];	
		// 	}
		// 	else
		// 	{
		// 		$doc_no_loc="R".$doc_num[$i];
		// 	}
			
		// }
		
		$sql111="select roll_id,tran_pin,allocated_qty from $wms.fabric_cad_allocation where doc_no='".$doc_no."' and status=1 and plant_code='$plant_code'";
		//echo $sql111."</br>";
		$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error--12".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result111)>0)
		{
			while($row2=mysqli_fetch_array($sql_result111))
			{
				$code=$row2['roll_id'];
				$tran_pin=$row2['tran_pin'];
				$sql1="select ref1,qty_rec,qty_issued,qty_ret,partial_appr_qty,qty_allocated,status from $wms.store_in where roll_status in (0,2) and tid=\"$code\" and plant_code='$plant_code'";
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
						$sql22="update $wms.store_in set qty_issued=".($qty_issued+$qty_iss).",qty_allocated=qty_allocated-".$qty_iss.", status=$status, allotment_status=$status,updated_user='$username', updated_at=NOW() where tid=\"$code\" and plant_code='$plant_code'";
						mysqli_query($link, $sql22) or exit("Sql Error----3".mysqli_error($GLOBALS["___mysqli_ston"]));

						$sql211="select * from $wms.store_out where tran_tid='".$code."' and qty_issued='".$qty_iss."' and Style='".$style."' and Schedule='".$schedule."' and cutno='".$doc_no_loc."' and date='".date("Y-m-d")."' and updated_by='".$username."' and remarks='".$reason."' and log_stamp='".date("Y-m-d H:i:s")."' and plant_code='$plant_code' ";
						$sql_result211=mysqli_query($link, $sql211) or exit("Sql Error--211: $sql211".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result211);
						if($sql_num_check==0)
						{
							$sql23="insert into $wms.store_out (tran_tid,qty_issued,Style,Schedule,cutno,date,updated_by,remarks,log_stamp) values ('".$code."', '".$qty_iss."','".$style."','".$schedule."','".$doc_no_loc."','".date("Y-m-d")."','".$username."','".$reason."','".date("Y-m-d H:i:s")."')";
							//echo "Sql :".$sql23."</br>"; 
							//Uncheck this
							mysqli_query($link, $sql23) or exit("Sql Error----4".mysqli_error($GLOBALS["___mysqli_ston"]));
						}

						$sql24="update $wms.fabric_cad_allocation set status=2,updated_user='$username',updated_at=NOW() where tran_pin=\"$tran_pin\" and plant_code='$plant_code'";
						mysqli_query($link, $sql24) or exit("Sql Error----3".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					
				}
			
			}
		}	
	
	}
	if($issue_status==5)
	{
		
		$sql1="update $pps.requested_dockets set fabric_status=$issue_status,updated_user='$username',updated_at=NOW() where plant_code='$plant_code' and jm_docket_line_id in ('$doc_no')";
		//Uncheck this
		mysqli_query($link, $sql1) or exit("Sql Error---5".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		$sql1="update $pps.requested_dockets set fabric_status=$issue_status,updated_user='$username',updated_at=NOW() where plant_code='$plant_code' and jm_docket_line_id in ('$doc_no')";
		//Uncheck this
		mysqli_query($link, $sql1) or exit("Sql Error---6".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//if($issue_status==5)
		//{
		$sql3="update $pps.fabric_prorities set issued_time='".date("Y-m-d H:i:s")."',updated_user='$username',updated_at=NOW() where jm_docket_line_id in ('$doc_no') and plant_code='$plant_code'";
		//Uncheck this	
		mysqli_query($link, $sql3) or exit("Sql Error----7".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql1="INSERT INTO `$pps`.`log_rm_ready_in_pool` (`jm_docket_line_id`, `date_n_time`, `username`,created_at,created_user,plant_code) VALUES ('$doc_no', '".date("Y-m-d H:i:s")."','$username',NOW(),'$username','$plant_code')";
		// echo $sql1;
		mysqli_query($link, $sql1) or exit("Sql Error33".mysqli_error($GLOBALS["___mysqli_ston"]));
	}

	if($issue_status==1)
	{
		$sql1="update $pps.requested_dockets set fabric_status=$issue_status,updated_user='$username',updated_at=NOW() where plant_code='$plant_code' and jm_docket_line_id in ('$doc_no')";
		//Uncheck this
		mysqli_query($link, $sql1) or exit("Sql Error---5.1".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	if($dash==1){
		$php_self = explode('/',$_SERVER['PHP_SELF']);
		$ctd =array_slice($php_self, 0, -2);
		$url_rr=base64_encode(implode('/',$ctd)."/cut_table_dashboard/cut_table_dashboard.php");
		$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index-no-navi.php?r=".$url_rr;
	}
	else{
		$php_self = explode('/',$_SERVER['PHP_SELF']);
		array_pop($php_self);
		$url_r = base64_encode(implode('/',$php_self)."/fab_priority_dashboard.php");
		$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index-no-navi.php?r=".$url_r;
	}
	echo"<script>location.href = '".$url1."';</script>"; 
		
}
?>

<?php

if(isset($_POST['allocate']))
{

	// echo "test";
	$doc=$_POST['doc'];
	$marker_version=$_POST['marker_version'];
	
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

<script>
function marker_edit1(){
	$("#marker").hide();
	// $("#marker_version").change(function() {
	var marker_version=document.getElementById('marker_version').value;
	$('#dynamic_table1').html('');
    $('#dynamic_table').html('');
    $('#row1').html('');
	$.ajax({
		    url : '<?= $get_url ?>',
			type:'POST',
			data:{marker_version:marker_version},
			success: function (data) 
			{        
			
				if(data=='null'){
					$("#dynamic_table").hide();
				}else{
					var marker_data=JSON.parse(data);
				var markup = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table' style='width: 30px;'><thead class='cf'><tr><th style='width:20px;'>Marker Length</th><th style='width:20px;'>Shrinkage</th><th style='width:20px;'> Width</th></tr></thead><tbody>";
                $("#dynamic_table1").append(markup);
				var markup1 = "<tr id='row1'><td data-title='length'>"+marker_data.length+"</td><td data-title='shrinkage'>"+marker_data.shrinkage+"</td><td data-title='width'>"+marker_data.width+"</td></tr>";
				$("#dynamic_table").append(markup1);
				
				var markup99 = "</tbody></table></div></div></div>";
				$("#dynamic_table1").append(markup99);
				}
				
			}
			
		});
	
//	});

	//$("#rejections_modal"+doc_no).modal('toggle');	
}
</script>