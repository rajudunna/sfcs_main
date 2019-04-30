<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
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
// $authorized=user_acl("SFCS_0199",$username,50,$group_id_sfcs); 
?>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/common/css 	/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
<!--
Ticket #: 252392-Kirang/2014-02-07
This amendement was done based on the confirmation to issue excess (1%) material depending on the savings.
-->
<!--
Core Module:In this interface we can get update lot details against the fabric issuing, print the dockets, get the issued details for fabric.
Description:In this interface we can get update lot details against the fabric issuing, print the dockets, get the issued details for fabric.
Changes Log:

2014-05-29/dharanid/Ticket 854380 : Add "nagendral" user in $authorized array for recut dashboard access.

2014-05-29/dharanid/Service Request #370686: Add sivaramakrishnat in $authorized array For Docket allocation in CPS Dashboard
-->
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

//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=$username_list[1];


// $authorized=array("kirang","rameshk","santhoshbo","bhupalv","vemanas","srinivasaraot","kishorek","rajud","baiadmn","lovakumarig","dharmarajua","eswararaop","bhanul","gowthamis","lovarajub","pavang","rajinig","ramud","revathil","varalakshmik","dharanid","gowthamis","rajinig","revathil","lovarajub","eswarraok","babjim","ramunaidus","nagendral","sivaramakrishnat");
//Added for view purpose
//$authorized=array("kirang");
//echo $username."<br>"; 
//echo $authorized[0]."<br>"; 
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
 
 </script>
 <script>
function dodisable()
{
//enableButton();
document.getElementById('process_message').style.visibility="hidden"; 
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
echo "<input type=\"hidden\" value=\"1\" name=\"process_cat\">"; //this is to identify recut or normal processing of docket (1 for normal 2 for recut)
echo "<input type=\"hidden\" value=\"$style_ref\" name=\"style_ref\">";  
echo "<input type=\"hidden\" value=\"$dash\" name=\"dashboard\">";  

echo "<table class='table table-bordered'><tr><th>Category</th><th>Item Code</th><th>Color Desc. - Docket No</th><th>Required<br/>Qty</th><th>Control</th><th>Print Status</th><th>Roll Details</th></tr>";
//$sql1="SELECT plandoc_stat_log.plan_lot_ref,plandoc_stat_log.cat_ref,plandoc_stat_log.print_status,plandoc_stat_log.doc_no,cat_stat_log.category from plandoc_stat_log left join cat_stat_log on plandoc_stat_log.cat_ref=cat_stat_log.tid  where plandoc_stat_log.order_tid=\"$order_id_ref\" and plandoc_stat_log.acutno=$cut_no_ref";

if(strtolower($docket_remarks) == 'normal')
{
  $sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\" and order_cat_doc_mk_mix.acutno=$cut_no_ref and order_cat_doc_mk_mix.acutno='Normal' and act_cut_status<>'DONE' and org_doc_no <=1 ";
}
else
{
	$sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\" and order_cat_doc_mk_mix.doc_no=$doc_no and order_cat_doc_mk_mix.acutno=$cut_no_ref and act_cut_status<>'DONE' and org_doc_no <=1 ";
}

// $sql1="SELECT order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid=\"$order_id_ref\" and order_cat_doc_mk_mix.acutno=$cut_no_ref and order_cat_doc_mk_mix.doc_no=$doc_no";

//Color Clubbing New Code
if($clubbing>0)
{
   if(strtolower($docket_remarks) == 'normal')
   {
	 $sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid in (select distinct order_tid from $bai_pro3.plan_doc_summ where order_style_no=\"$style_ref\" and order_del_no=\"$del_ref\" and clubbing=$clubbing) and order_cat_doc_mk_mix.acutno=$cut_no_ref  and org_doc_no <=1";
   }
   else
   {
   	$sql1="SELECT order_cat_doc_mk_mix.order_tid,order_cat_doc_mk_mix.col_des,order_cat_doc_mk_mix.clubbing as clubbing,order_cat_doc_mk_mix.material_req,order_cat_doc_mk_mix.compo_no,order_cat_doc_mk_mix.plan_lot_ref,order_cat_doc_mk_mix.cat_ref,order_cat_doc_mk_mix.print_status,order_cat_doc_mk_mix.doc_no,order_cat_doc_mk_mix.category,$bai_pro3.fn_savings_per_cal(date,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix_v2 as order_cat_doc_mk_mix where order_cat_doc_mk_mix.order_tid in (select distinct order_tid from $bai_pro3.plan_doc_summ where order_style_no=\"$style_ref\" and order_del_no=\"$del_ref\" and clubbing=$clubbing) and order_cat_doc_mk_mix.doc_no=$doc_no and order_cat_doc_mk_mix.acutno=$cut_no_ref  and org_doc_no <=1";
   }
}

// echo $sql1;
//echo "getting req qty : ".$sql1."</br>";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result1);
$for_Staus_dis=$sql_num_check;
//echo "Rows:".$sql_num_check;
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
		$docno_lot=$sql_row1['doc_no'];
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
	//$output_trimmed = array_map("trim", explode(',', $input));
	//echo "</br>Seperated".$seperated_lots;
	echo "<tr><td>".$sql_row1['category']."</td>";
	echo "<td>".$sql_row1['compo_no']."</td>";
	echo "<td>".$sql_row1['col_des'].'-'.$sql_row1['doc_no']."</td>";
	$extra=0;
	//echo "<br>1=".$sql_row1['material_req'];
	//if(substr($style_ref,0,1)=="M") { $extra=round(($material_req*0.01),2); }
	{ $extra=round(($sql_row1['material_req']*$sql_row1['savings']),2); }
	echo "<td>".($sql_row1['material_req']+$extra)."</td>";
	$temp_tot=$sql_row1['material_req']+$extra;
	$total+=$temp_tot;
	$temp_tot=0;
	$club_id=$sql_row1['clubbing'];
	//For new implementation
	
	$newOrderTid=$sql_row1['order_tid'];
	$doc_cat=$sql_row1['category'];
	$doc_com=$sql_row1['compo_no'];
	$doc_mer=($sql_row1['material_req']+$extra);
	$cat_ref=$sql_row1['cat_ref'];
	
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
				echo "<td><a href=\"$path?print_status=$print_status&order_tid=$newOrderTid&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&cat_title=".$sql_row1['category']."&clubbing=".$club_id."&cut_no=".$act_cut_no."\" onclick=\"Popup1=window.open('$path?print_status=$print_status&order_tid=$newOrderTid&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&cat_title=".$sql_row1['category']."&clubbing=".$club_id."&cut_no=".$act_cut_no."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";
				$comp_printed[]=$sql_row1['category'];
			}
			else
			{
				echo "<td>Clubbed</td>";
			}
		}
		else
		{
			echo "<td><a href=\"$path?print_status=$print_status&order_tid=$newOrderTid&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&cat_title=".$sql_row1['category']."&clubbing=".$club_id."&cut_no=".$act_cut_no."\" onclick=\"Popup1=window.open('$path?print_status=$print_status&order_tid=$newOrderTid&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&cat_title=".$sql_row1['category']."&clubbing=".$club_id."&cut_no=".$act_cut_no."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";
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
			 $sql1x="select ref1,lot_no from $bai_rm_pj1.fabric_status where item in (select compo_no from $bai_pro3.cat_stat_log where tid=\"".$sql_row1['cat_ref']."\")";
			$sql_result1x=mysqli_query($link, $sql1x) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1x=mysqli_fetch_array($sql_result1x))
			{
				//Disabled because of taking values from PMS040
				//echo "<input type=\"checkbox\" value=\"".$sql_row1x['lot_no'].">".$sql_row1x['ref1']."\" name=\"".$sql_row1['doc_no']."[]\">".$sql_row1x['lot_no']."<br/>";
				
			} 
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
}
echo "<tr><td colspan=3><center>Total Required Material</center></td><td>$total</td><td></td><td></td><td></td></tr>";
echo "</table>";
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

$sql1="SELECT fabric_status from $bai_pro3.plandoc_stat_log where doc_no=$doc_no";
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
$sql111="select ROUND(SUM(allocated_qty),2) AS alloc,count(distinct doc_no) as doc_count from $bai_rm_pj1.fabric_cad_allocation where doc_no in (".implode(",",$docket_num).")";
//echo $sql111."<br>";
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
	//echo "Issue Status : ".$issue_status;exit;
	// echo $reason."<br>";
	// echo $group_docs."<br>";
	// echo sizeof($group_docs)."<br>";
	//echo "Alloc_docketd--".$alloc_docket."--total allocted--".$doc_tot."--issue_status--".$issue_status."--total_docket--".$group_docs."--reasno---".$reason."--style--".$style."--scheudle--".$schedule."<br>";
	$doc_num=explode(",",$group_docs);
	//var_dump($doc_num);
	for($i=0;$i<sizeof($doc_num);$i++)
	{	
		$sql2="update $bai_pro3.plandoc_stat_log set fabric_status=$issue_status where doc_no='".$doc_num[$i]."'";
		mysqli_query($link, $sql2) or exit("Sql Error----5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$doc_no_loc="D".$doc_num[$i];
		$sql111="select * from $bai_rm_pj1.fabric_cad_allocation where doc_no='".$doc_num[$i]."' and status=1";
		//echo $sql111."</br>";
		$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result111)>0)
		{
			while($row2=mysqli_fetch_array($sql_result111))
			{
				$code=$row2['roll_id'];
				$tran_pin=$row2['tran_pin'];
				$sql1="select ref1,qty_rec,qty_issued,qty_ret,partial_appr_qty from $bai_rm_pj1.store_in where roll_status in (0,2) and tid=\"$code\"";
				//echo "Qry :".$sql1."</br>";
				$sql_result=mysqli_query($link, $sql1) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$qty_rec=$sql_row['qty_rec']-$sql_row['partial_appr_qty'];
					$qty_issued=$sql_row['qty_issued'];
					$qty_ret=$sql_row['qty_ret'];
				}
				//echo "</br>Qty Rec from store:".$qty_rec."</br>";
				$qty_iss=$row2['allocated_qty'];
				//echo "Qty Issued :".$qty_iss."</br>";
				$balance=$qty_rec-$qty_issued+$qty_ret;	
				$balance1=$qty_rec+$qty_ret-($qty_issued+$qty_iss);
				if($balance1==0)
				{
					$status=2;
				}
				else
				{
					$status=0;
				}
				//cardid,ename,tzstr,apply,dob,cid,fpimage1,fpimage2,empid,cmpcode,deptid,Flag,AccsMode,WoXsGrp,HoXsGrp
				//insert into tcp_emp(cardid,ename,tzstr,apply,dob,cid,empid,cmpcode,deptid,Flag,AccsMode,WoXsGrp,HoXsGrp) values('5298915','P Lavanya','1000000000000000000000000000000
				//','','0','1','455','BAI3','NA','E',0,'1','1');
				//echo "Test"."<br>";
				//echo $qty_rec."-".$qty_iss."+".$qty_issued."))+".$qty_ret.")>=0 && ".$qty_iss." > 0"."<br>";
				//$sql1="update $bai_rm_pj1.store_in set qty_issued=".($qty_issued+$qty_iss).", status=$status, allotment_status=$status where tid=\"$code\"";
					//echo $sql1."<br>";
				//$sql2="insert into $bai_rm_pj1.store_out (tran_tid,qty_issued,Style,Schedule,cutno,date,updated_by,remarks,log_stamp) values ('".$code."', '".$qty_iss."','".$style."','".$schedule."','".$doc_no_loc."','".date("Y-m-d")."','".$username."','".$reason."','".date("Y-m-d h:i:sa")."')";
					//echo $sql2."<br>";
				$condi1=(($qty_rec+$qty_ret)-($qty_iss+$qty_issued));
				//echo "BAl:".$condi1."</br>";
				if((($qty_rec-($qty_iss+$qty_issued))+$qty_ret)>=0 && $qty_iss > 0)
				{					
					if($issue_status==5)
					{	
						//echo "2";
						//$sql1="update store_in set qty_issued=".(($qty_rec-$qty_issued)+($qty_ret+$qty_issued+$qty_iss)).", status=2, allotment_status=2 where tid=\"$code\"";
						//quantity should be issued after stockout
						$sql22="update $bai_rm_pj1.store_in set qty_issued=".($qty_issued+$qty_iss).",qty_allocated=qty_allocated-".$qty_iss.", status=$status, allotment_status=$status where tid=\"$code\"";
						//echo "</br>".$sql22."</br>";
						//Uncheck this
						mysqli_query($link, $sql22) or exit("Sql Error----3".mysqli_error($GLOBALS["___mysqli_ston"]));

						$sql211="select * from $bai_rm_pj1.store_out where tran_tid='".$code."' and qty_issued='".$qty_iss."' and Style='".$style."' and Schedule='".$schedule."' and cutno='".$doc_no_loc."' and date='".date("Y-m-d")."' and updated_by='".$username."' and remarks='".$reason."' and log_stamp='".date("Y-m-d H:i:s")."' ";
						//echo $sql211."<br>"; 
						$sql_result211=mysqli_query($link, $sql211) or exit("Sql Error--211: $sql211".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result211);
						//echo "No's".$sql_num_check."</br>";
						if($sql_num_check==0)
						{
							$sql23="insert into $bai_rm_pj1.store_out (tran_tid,qty_issued,Style,Schedule,cutno,date,updated_by,remarks,log_stamp) values ('".$code."', '".$qty_iss."','".$style."','".$schedule."','".$doc_no_loc."','".date("Y-m-d")."','".$username."','".$reason."','".date("Y-m-d H:i:s")."')";
							//echo "Sql :".$sql23."</br>"; 
							//Uncheck this
							mysqli_query($link, $sql23) or exit("Sql Error----4".mysqli_error($GLOBALS["___mysqli_ston"]));
						}

						$sql24="update $bai_rm_pj1.fabric_cad_allocation set status=2 where tran_pin=\"$tran_pin\"";
						//Uncheck this
						mysqli_query($link, $sql24) or exit("Sql Error----3".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					

					//echo "<h3>Status: <font color=green>Success!</font> $code</h3>";
					//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"out.php?location=$location\"; }</script>";
					//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = \"out.php?location=$location&code=$code&bal=$balance\"; }</script>";
					
				}
			
			}
		}	
	
	}
	// exit;
	/*	if(in_array($username,$authorized_check_out))
		{
			//echo "Test---11"."<br>";
			if($issue_status==5)
			{
				echo "Test---12"."<br>";
				//$sql1="update plan_dashboard set fabric_status=$issue_status where doc_no='";
				$sql1="update plan_dashboard set fabric_status=$issue_status where doc_no in ($group_docs)";
				echo $sql1."<br>";	
				//mysql_query($sql1,$link) or exit("Sql Error---5".mysql_error());
			
				//$sql1="update plandoc_stat_log set fabric_status=$issue_status where doc_no=$doc_no";
				$sql2="update plandoc_stat_log set fabric_status=$issue_status where doc_no in ($group_docs)";
				echo $sql2."<br>";	
				//mysql_query($sql2,$link) or exit("Sql Error----6".mysql_error());
				//if($issue_status==5)
				//{
				$sql3="update fabric_priorities set issued_time='".date("Y-m-d H:i:s")."' where doc_ref in ($group_docs)";
				echo $sql3."<br>";	
					//mysql_query($sql3,$link) or exit("Sql Error----7".mysql_error());
			}
		}
		else
		{  */
			//echo "Test---22"."<br>";
			if($issue_status==5)
			{
				//echo "Test---21"."<br>";
				//$sql1="update plan_dashboard set fabric_status=$issue_status where doc_no='";
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
		//}
		//this is for after allocating article redirect to cps dashboard.removed sfcsui
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
?>

<!-- <script>
$('#address').on('input', function () {
	
    var hasNumber = this.value.match(/\d/);
    var isAlfa    = this.value.match(/^[0-9/]+$/);
    
    if ( hasNumber && isAlfa ) {
        //$('#valid').removeClass('invalid');
    } else {
        //$('#valid').addClass('invalid');
    }

});
</script> -->
