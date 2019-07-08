<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/common/css 	/sfcs_styles.css".'" rel="stylesheet" type="text/css" />';
?>
<?php 

$dash=0;
if(isset($_POST['allocate']))
{
    $dash=$_POST['dashboard'];
    
}
include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');


$php_self = explode('/',$_SERVER['HTTP_HOST']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/sfcs_app/app/cutting/controllers/seperate_docket.php");
$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index.php?r=".$url_r;
?>
<br/>
<div class='row'>
	<div class='col-md-2 pull-left'>
		<a class='btn btn-primary' href = '<?= $url1 ?>'> << Back</a>
	</div>
</div>
<br/>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<?php
    //error_reporting(0);
	// $php_self = explode('/',$_SERVER['PHP_SELF']);
	// array_pop($php_self);
	// $url_r = base64_encode(implode('/',$php_self)."/fab_pop_allocate_v5.php");
	$has_permission=haspermission($url_r);
?>
	


		<style>
		
        .fade{
            width:100%;
        }


		body
		{
			font-family: Trebuchet MS;
		}
		.btnflt{
			width:100%;
		}
		#chk11770{
			width:60%;
		}
		table
		{
		border-collapse:collapse;
		white-space:nowrap;
		font-size:12px;
		}
		tr.total
		{
		font-weight: bold;
		white-space:nowrap; 
		}

		th
		{
			/* font-size:14px; */
			text-align: center;
			width:100%;

			color: WHITE;
		border: 1px solid #660000;
			padding: 10px;
		white-space:nowrap; 

		}

		td
		{
			
			color: BLACK;
		border: 1px solid #660000;
			padding: 1px;
		white-space:nowrap; 
		}

		td.date
		{
			
			color: BLACK;
		border: 1px solid #660000;
			padding: 5px;
		white-space:nowrap;
		text-align:center;
		}


		td.style
		{
			
			color: BLACK;
		border: 1px solid #660000;
			padding: 2px;
		white-space:nowrap; 
		font-weight: bold;
		}
		</style>

<script src="../../../../common/js/jquery-1.12.4.js"></script>

<link rel='stylesheet' href="../../../../common/css/bootstrap.min.css">
<script src="../../../../common/js/sweetalert.min.js"></script>
<script src="../../common/js/tablefilter.js"></script>
<script>

			


 
function filling(doc_no,i,doc_count_no)
{	
	var doc_ref=document.input["doc_ref["+doc_count_no+"]"].value;
	var issued_qty=parseFloat(document.input["val"+doc_no+"["+i+"]"].value);
	var new_value = parseFloat(document.getElementById("issued"+doc_no+"["+i+"]").value);
	var old_value = parseFloat(document.getElementById("issued_new"+doc_no+"["+i+"]").value);
	if(isNaN(new_value))
	{
		new_value = parseFloat(0);
		document.getElementById("issued"+doc_no+"["+i+"]").value = new_value;
	}
	var present_bal = parseFloat(document.getElementById("balal"+doc_no).innerHTML);
	var allocate_bal = parseFloat(document.getElementById("alloc"+doc_no).innerHTML);
	var actual_balance = parseFloat(present_bal)+parseFloat(old_value)-parseFloat(new_value);
	if(old_value - new_value > actual_balance && new_value > old_value || new_value > issued_qty || actual_balance < 0)
	{
		sweetAlert("You are Issuing more than Available Quantity","","warning");
		document.getElementById("issued"+doc_no+"["+i+"]").value = old_value;
	}
	else
	{	
		if(actual_balance==0){
			document.getElementById(doc_ref).style.backgroundColor = "GREEN";
		}else{
			document.getElementById(doc_ref).style.backgroundColor = "RED";
		}
		document.getElementById("issued_new"+doc_no+"["+i+"]").value = new_value;
		var actual_allcoate = parseFloat(allocate_bal)-parseFloat(old_value)+parseFloat(new_value);
		document.getElementById("balal"+doc_no).innerHTML =  actual_balance;
		document.getElementById("alloc"+doc_no).innerHTML =  actual_allcoate;
	}
}

function check_qty(x)
{
	var check=0;
	
	for(i=0;i<x;i++)
	{
		var doc_ref=document.input["doc_ref["+i+"]"].value;
		var mat_req=document.input["mat_req["+i+"]"].value;
		var no_ele=document.input["chk"+doc_ref+"[]"];
		no_ele=(parseInt(no_ele.length));
		alert(no_ele);
		var selc=0;
		for(j=0;j<no_ele;j++)
		{
			
			var tx="chk"+doc_ref+j;
			if(document.getElementById(tx).checked)
			{
				selc=selc+parseFloat((document.input["val"+doc_ref+"["+j+"]"].value));	
			}
		}
		
		if(selc<mat_req)
		{
			check=0;
		}
		else
		{
			check=1;
		}
		
	}
	if(check==1)
	{
		document.getElementById('validate').style.visibility="hidden";
		document.getElementById('allocate_new').style.visibility="";
		
	}
	else
	{
		alert("Please select sufficient qty");
		document.getElementById('validate').checked=false;
	}
}
function none(){
	
}

var initial_count=0
var check_count = 0;
var srgp;
var srgp1;
var doc_count = 0;
var verifier = 0;
var doc_flag=0;
function check_qty23(x,m,n,doc,row_count,doc_count_no)
{	
    //PLEASE DO NOT MODIFY THE ORDER OF ANY OF THE BELOW STATEMENTS OF THIS FUNCTION
	////  code for shrinkage validation
	// alert(row_count+"="+x+"-"+doc);
	if(doc_count==0){
		old_doc = doc;
		doc_count++;
	}
	if(old_doc != doc){
		initial_count = 0;
		doc_count = 0;
		verifier = 0;
		sr_id1 = m.substr(3);
		srgp1 = document.getElementById('srgp'+sr_id1).value; 
		console.log('Not equal '+doc+' new doc'+old_doc);
	}
	
	if(initial_count == 0){
		console.log('entered');
		var chks = document.getElementsByName('chk'+doc+'[]');
		for(var i=0;i<chks.length;i++){
			if(chks[i].checked){
				verifier++;
				var sr_id2 = chks[i].id.substr(3);
				srgp = document.getElementById('srgp'+sr_id2).value;
			}
			console.log('old = '+srgp+' new = '+srgp1);
			if(verifier>1){
				verifier=0;
				if(srgp != srgp1){
					swal('Shrinkage group is not unique','','error');
					document.getElementById(m).checked = false;
					var xx="tr"+m;
					document.getElementById(xx).style.backgroundColor = '#fff';
					return;
				}
			}
		}
	
	}
	////  code for shrinkage validation

	if(document.getElementById(m).checked)
	{
		//////  code for shrinkage validation
		if(Number(initial_count)==1){
			var sr_id1 = m.substr(3);
			srgp1 = document.getElementById('srgp'+sr_id1).value;
			if(srgp.length > 0){
				if(srgp != srgp1){
					swal('Shrinkage group is not unique','','error');
					document.getElementById(m).checked = false;
					return;
				}else{
					srgp = srgp1;
				}
			}else{
				// console.log('lesser');
			}
		}
		check_count++;
		//////  code for shrinkage validation ends
		var xx="tr"+m;
		document.getElementById(xx).style.backgroundColor = "#99CCFF";
	}
	else
	{
		////  code for shrinkage validation
		srgp='';
		check_count--;
		verifier=0;
		////  code for shrinkage validation
		var xx="tr"+m;
		document.getElementById(xx).style.backgroundColor = n;
	}
	////  code for shrinkage validation
	if(initial_count == 0){
		initial_count++;
	}
	var chks = document.getElementsByName('chk'+doc+'[]');
	var coun = 0;
	for(var i=0;i<chks.length;i++){
		if(chks[i].checked){
			var sr_id2 = chks[i].id.substr(3);
			srgp = document.getElementById('srgp'+sr_id2).value;
		}else{
			coun++;
		}
	}
	if(coun == chks.length){
		initial_count = 0;
	}	
	var check=0;
	var alloc_disab=0;
	for(i=0;i<x;i++)
	{
		var doc_ref=document.input["doc_ref["+doc_count_no+"]"].value;
		var mat_req=document.input["mat_req["+doc_count_no+"]"].value;
		var no_ele=document.input["chk"+doc_ref+"[]"];
		no_ele=(parseInt(no_ele.length));
		var selc=0;
		var widt=0;
		var issued_qty=0;
		var round_val=0;
		var alloc_qty=0;
		for(j=0;j<row_count;j++)
		{
			var tx="chk"+doc_ref+j;
			widt=0;
			if(document.getElementById(tx).checked)
			{
				issued_qty=document.input["val"+doc_ref+"["+j+"]"].value;
				if(widt<=parseFloat((document.input["width"+doc_ref+"["+j+"]"].value)))
				{	
					selc=selc+parseFloat((document.input["val"+doc_ref+"["+j+"]"].value));
					widt=parseFloat((document.input["width"+doc_ref+"["+j+"]"].value));
					document.input["min_width["+i+"]"].value=widt;
					console.log("selc"+selc);
					console.log("mat_req"+mat_req);
					if(selc<=mat_req){
						document.getElementById("issued"+doc_ref+"["+j+"]").value=issued_qty;
						document.getElementById("issued_new"+doc_ref+"["+j+"]").value=issued_qty;
						alloc_qty=alloc_qty+parseFloat(issued_qty);
					}else{
						if((mat_req-selc)<0){
							round_val=(parseFloat(mat_req)-parseFloat(selc)+parseFloat(issued_qty));
								if(round_val>0){
									document.getElementById("issued"+doc_ref+"["+j+"]").value=round_val.toFixed(2);
									document.getElementById("issued_new"+doc_ref+"["+j+"]").value=round_val.toFixed(2);
									alloc_qty=alloc_qty+parseFloat(round_val.toFixed(2));
								}else{
									sweetAlert("User...You already completed required Quantity"," ","warning");
									document.getElementById("issued"+doc_ref+"["+j+"]").value="";
									if(document.getElementById("issued_new"+doc_ref+"["+j+"]").value){
										document.getElementById(m).checked = true;
										document.getElementById("chk"+doc_ref+j).checked = false;
									}else{
										document.getElementById(m).checked = false;
									}
								}
						}
						
						
					}
				}else{
					console.log(widt+"<="+parseFloat((document.input["width"+doc_ref+"["+j+"]"].value))+" J = "+j);
				}
			}else{
					document.getElementById("issued"+doc_ref+"["+j+"]").value="0";
				}

		}
		
		if(doc_flag!=doc_ref){
			if(alloc_qty>0){
				check=1;
				alloc_disab=Number(alloc_disab)+Number(check);
				doc_flag=doc_ref;
			}
			
		}
		

		if(selc<mat_req)
		{
			check=0;
			document.getElementById(doc_ref).style.backgroundColor = "RED";
			document.getElementById('alloc'+doc_ref).innerHTML=parseFloat(alloc_qty.toFixed(2));
			document.getElementById('balal'+doc_ref).innerHTML=parseFloat((mat_req-selc).toFixed(2));
		}
		else
		{
			check=1;
            alloc_disab=Number(alloc_disab)+Number(check);
			document.getElementById(doc_ref).style.backgroundColor = "GREEN";
			document.getElementById('alloc'+doc_ref).innerHTML=parseFloat(alloc_qty.toFixed(2));
			if((mat_req-selc)<=0){
				round_val=(parseFloat(mat_req)-parseFloat(selc)+parseFloat(issued_qty));
				document.getElementById('balal'+doc_ref).innerHTML=0;
			}
		}
	}




	
}
function check_qty2(x,m,n,doc,row_count,doc_count_no,act_count)
{	
	var doc_ref=document.input["doc_ref["+doc_count_no+"]"].value;
	var bal = parseFloat(document.getElementById("balal"+doc).innerHTML);
	if(document.getElementById(m).checked)
	{
        console.log(bal+'hiiii');
		if(bal <= 0)
		{
            // if(bal == 0) {
            //     document.getElementById('allocate_new').disabled=false;
            // } else {
            //     document.getElementById('allocate_new').disabled=true;
            // }
			sweetAlert("You Met Required quantity","","warning");
			document.getElementById(m).checked = false;
		}
		else
		{
			// console.log("issued"+doc+"["+act_count+"]");
			// console.log("balal"+doc);
			var issued_qty=parseFloat(document.input["val"+doc+"["+act_count+"]"].value);
			var balance = parseFloat(document.getElementById("balal"+doc).innerHTML);
			var allocate = parseFloat(document.getElementById("alloc"+doc).innerHTML);
			var eligibile = Math.min(issued_qty,balance);
			document.getElementById("issued"+doc+"["+act_count+"]").readOnly = false;
			document.getElementById("issued"+doc+"["+act_count+"]").value = parseFloat(eligibile.toFixed(2));
			document.getElementById("issued_new"+doc+"["+act_count+"]").value = parseFloat(eligibile.toFixed(2));
			document.getElementById("balal"+doc).innerHTML =  parseFloat(balance)-parseFloat(eligibile);
			document.getElementById("alloc"+doc).innerHTML =  parseFloat(allocate)+parseFloat(eligibile);
			var bal_qty_colorchnage=parseFloat(balance)-parseFloat(eligibile);
			if(bal_qty_colorchnage==0){
                // document.getElementById('allocate_new').disabled=false;
                document.getElementById('allocate_new').disabled=false;
				document.getElementById(doc_ref).style.backgroundColor = "GREEN";
			}else{
				document.getElementById(doc_ref).style.backgroundColor = "RED";
			}
		}
		
	}
	else
	{
		document.getElementById("issued"+doc+"["+act_count+"]").readOnly = true;
		document.getElementById("issued"+doc+"["+act_count+"]").value = 0;
		filling(doc,act_count,doc_count_no);
	}
	
}

</script>

<div class="panel panel-primary">
	<div class="panel-heading"><b><font size="4">Fabric Allocation Panel</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
	<font color="red">Note:</font>Please select atleast one roll for allocation in every component</b>
		<div class="panel-body">

<?php

if((in_array($authorized,$has_permission)))
{
	header($_GET['r'],'restrict.php','N');
}

echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing data...</font></h1></center></div>";
	
	ob_end_flush();
	flush();
	usleep(10);

?>

<?php
set_time_limit(2000);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_splitting_function.php');
?>



<?php

if(isset($_POST['allocate_new']))
{
	$doc_ref=$_POST['doc_ref']; //array
	$dash=$_POST['dashboard']; //array
    $row_id_new = $_POST['row_id1'];
	$min_width=$_POST['min_width'];	//array
	$lot_db=$_POST['lot_db']; //array
	$process_cat=$_POST['process_cat'];
	$style=$_POST['style_ref1'];
	$schedule=$_POST['schedule1'];
    
    // var_dump($_POST);
    // die();
    // var_dump($doc_ref.'doc_ref');
    // var_dump($dash.'dash');
    // var_dump($min_width.'min_width');
    // var_dump($lot_db.'lot_db');
    // var_dump($process_cat.'process_cat');
    // die();
	for($i=0;$i<sizeof($doc_ref);$i++)
	{
		$temp="lable".$doc_ref[$i];
		$tid_ref_base=$_POST[$temp];
		$temp="width".$doc_ref[$i];
		$width_ref_base=$_POST[$temp];
		$temp="val".$doc_ref[$i];
		$val_ref_base=$_POST[$temp];
		$temp="issued_new".$doc_ref[$i];
		$issued_ref_base=$_POST[$temp];
		$username=getrbac_user()['uname'];	
		
		$temp="chk".$doc_ref[$i];
		$chk_ref=$_POST[$temp];
		unset($tid_ref);
		unset($width_ref);
		unset($val_ref);
		unset($issued_ref);
		
		$tid_ref=array();
		$width_ref=array();
		$val_ref=array();
		$issued_ref=array();
        
        $sum_of_issued_qty = 0;
		for($j=0;$j<sizeof($chk_ref);$j++)
		{
			$x=$chk_ref[$j];
			$tid_ref[]=$tid_ref_base[$x];
			$width_ref[]=$width_ref_base[$x];
			$val_ref[]=$val_ref_base[$x];
            $issued_ref[]=$issued_ref_base[$x];
            
			$sum_of_issued_qty+=$issued_ref_base[$x];
        }


        
		if(strpos(strtolower($lot_db[$i]),"stock"))
		{
			$tid_ref[]=0;
		}
		
		if(sizeof($tid_ref)>0)
		{
		
			//To extrac required information to find marker length for the docket.
			unset($allo_c);
			$allo_c=array();
		
			$sql="select cat_patt_ver,doc_no,material_req,mk_ref,cat_ref,allocate_ref,style_id,mk_ver,category,p_xs,p_s,p_m,p_l,p_xl,p_xxl,p_xxxl,p_s06,p_s08,p_s10,p_s12,p_s14,p_s16,p_s18,p_s20,p_s22,p_s24,p_s26,p_s28,p_s30,strip_match,gmtway,fn_savings_per_cal(DATE,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix where doc_no=\"".$doc_ref[$i]."\"";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error1 :$sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$extra=0;
				{
					$extra=round(($sql_row['material_req']*$sql_row['savings']),2);
				}
				$material_req1=$sql_row['material_req']+$extra;
				$mk_ref=$sql_row['mk_ref'];
				$cat_ref=$sql_row['cat_ref'];
				$allocate_ref=$sql_row['allocate_ref'];
				$style_code=$sql_row['style_id'];
				$buyer_code=substr($style_ref,0,1);
				$mk_ver=$sql_row['mk_ver'];
				$category=$sql_row['category'];
				$strip_match=$sql_row['strip_match'];
				$gmtway=$sql_row['gmtway'];
				
				$allo_c[]="xs=".$sql_row['p_xs'];
				$allo_c[]="s=".$sql_row['p_s'];
				$allo_c[]="m=".$sql_row['p_m'];
				$allo_c[]="l=".$sql_row['p_l'];
				$allo_c[]="xl=".$sql_row['p_xl'];
				$allo_c[]="xxl=".$sql_row['p_xxl'];
				$allo_c[]="xxxl=".$sql_row['p_xxxl'];
				$allo_c[]="s06=".$sql_row['p_s06'];
				$allo_c[]="s08=".$sql_row['p_s08'];
				$allo_c[]="s10=".$sql_row['p_s10'];
				$allo_c[]="s12=".$sql_row['p_s12'];
				$allo_c[]="s14=".$sql_row['p_s14'];
				$allo_c[]="s16=".$sql_row['p_s16'];
				$allo_c[]="s18=".$sql_row['p_s18'];
				$allo_c[]="s20=".$sql_row['p_s20'];
				$allo_c[]="s22=".$sql_row['p_s22'];
				$allo_c[]="s24=".$sql_row['p_s24'];
				$allo_c[]="s26=".$sql_row['p_s26'];
				$allo_c[]="s28=".$sql_row['p_s28'];
				$allo_c[]="s30=".$sql_row['p_s30'];
			}
			for($j=0;$j<sizeof($tid_ref);$j++)
			{
				if($tid_ref[$j]>0)
				{	
					if(($width_ref[$j]=='') or ($width_ref[$j]==NULL)){
						//getting recieved qty from store_in
						$query3="SELECT qty_rec FROM $bai_rm_pj1.store_in WHERE tid='$tid_ref[$j]'";
						$sql_result3=mysqli_query($link, $query3) or exit("Sql Error4: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row3=mysqli_fetch_array($sql_result3))
						{
							$width_ref[$j]=$sql_row3['qty_rec'];
						}


                    }
                    $row_id_new1 = 'B'.$row_id_new;
					// if($process_cat==1)
					// {
						$sql="insert into $bai_rm_pj1.fabric_cad_allocation(doc_no,roll_id,roll_width,doc_type,allocated_qty,status) values('".$row_id_new1."',".$tid_ref[$j].",".$width_ref[$j].",'binding',".$issued_ref[$j].",'1')";
					// }
					// else
					// {
					// 	$sql="insert into $bai_rm_pj1.fabric_cad_allocation(doc_no,roll_id,roll_width,doc_type,allocated_qty,status) values('".$row_id_new1."',".$tid_ref[$j].",".$width_ref[$j].",'binding',".$issued_ref[$j].",'1')";
					// }
					
					//Uncheck this
					mysqli_query($link, $sql) or exit("Sql Error4: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
					//Removing for #1305 ticket and adding this functionality into a separate function
					if($issued_ref[$j] > 0)
					{
						$roll_splitting = roll_splitting_function($tid_ref[$j],$val_ref[$j],$issued_ref[$j]);
                    }
                    





                    $sql111="select * from $bai_rm_pj1.fabric_cad_allocation where doc_no='".$row_id_new1."'";
                    //echo $sql111."</br>";
                    $sql_result111=mysqli_query($link, $sql111) or exit("Sql Error--12".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if(mysqli_num_rows($sql_result111)>0)
                    {
                        while($row2=mysqli_fetch_array($sql_result111))
                        {
                            $code=$row2['roll_id'];
                            $tran_pin=$row2['tran_pin'];
                            $sql1="select ref1,qty_rec,qty_issued,qty_ret,partial_appr_qty from $bai_rm_pj1.store_in where roll_status in (0,2) and tid=\"$code\"";
                            $sql_result=mysqli_query($link, $sql1) or exit("Sql Error--15".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                $qty_rec=$sql_row['qty_rec']-$sql_row['partial_appr_qty'];
                                $qty_issued=$sql_row['qty_issued'];
                                $qty_ret=$sql_row['qty_ret'];
                            }

                            $qty_iss=$row2['allocated_qty'];
                            //echo "Qty Issued :".$qty_iss."</br>";
                            // $balance=$qty_rec-$qty_issued+$qty_ret;	
                            // $balance1=$qty_rec+$qty_ret-($qty_issued+$qty_iss);
                            $status=2;
                            // $condi1=(($qty_rec+$qty_ret)-($qty_iss+$qty_issued));
                            // if((($qty_rec-($qty_iss+$qty_issued))+$qty_ret)>=0 && $qty_iss > 0)
				            {
                                $sql22="update $bai_rm_pj1.store_in set qty_issued=".($qty_issued+$qty_iss).",qty_allocated=".$qty_iss.", status=$status, allotment_status=$status where tid=\"$code\"";
                                mysqli_query($link, $sql22) or exit("Sql Error----3".mysqli_error($GLOBALS["___mysqli_ston"]));

                                // $sql211="select * from $bai_rm_pj1.store_out where tran_tid='".$code."' and qty_issued='".$qty_iss."' and Style='".$style."' and Schedule='".$schedule."' and date='".date("Y-m-d")."' and updated_by='".$username."' and remarks='".$reason."' and log_stamp='".date("Y-m-d H:i:s")."' ";
                                // $sql_result211=mysqli_query($link, $sql211) or exit("Sql Error--211: $sql211".mysqli_error($GLOBALS["___mysqli_ston"]));
                                // $sql_num_check=mysqli_num_rows($sql_result211);
                                // if($sql_num_check==0)
                                // {
                                    $sql23="insert into $bai_rm_pj1.store_out (tran_tid,qty_issued,Style,Schedule,date,updated_by,log_stamp) values ('".$code."', '".$qty_iss."','".$style."','".$schedule."','".date("Y-m-d")."','".$username."','".date("Y-m-d H:i:s")."')";
                                    mysqli_query($link, $sql23) or exit("Sql Error----4".mysqli_error($GLOBALS["___mysqli_ston"]));
                                // }

                                $sql24="update $bai_rm_pj1.fabric_cad_allocation set status=2 where tran_pin=\"$tran_pin\"";
                                mysqli_query($link, $sql24) or exit("Sql Error----3".mysqli_error($GLOBALS["___mysqli_ston"]));
                            }
                        }
                    }









				}
            }
            //doubt
			//To confirm docket as allocated
			// if($process_cat==1)
			// {
				$sql1="update plandoc_stat_log set plan_lot_ref=\"".$lot_db[$i]."\" where doc_no=\"".$doc_ref[$i]."\"";
			// }
			// else
			// {
			// 	$sql1="update recut_v2 set plan_lot_ref=\"".$lot_db[$i]."\" where doc_no=\"".$doc_ref[$i]."\"";
			// }
			//doubt
			mysqli_query($link, $sql1) or exit("Sql Error5: $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			//TO update Marker Matrix
			if($process_cat==1)
			{
				//Search Valid Marker is available or not
				//New version to verify style/ratio/pattern/width based algorith to identify new marker length
				
				$sql="select marker_length from $bai_pro3.marker_ref_matrix_view where strip_match='$strip_match' and gmtway='$gmtway' and style_code='$style_code' and buyer_code='$buyer_code' and lower(pat_ver)='".strtolower($mk_ver)."' and SUBSTRING_INDEX(marker_width,'.',1)='".$min_width[$i]."' and category='$category' and ".implode(" and ",$allo_c);
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error1x: $sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$mk_length=$sql_row['marker_length'];
				}
				
				if(mysqli_num_rows($sql_result)!=0)
				{
					$sql="insert into $bai_pro3.maker_stat_log(DATE,cat_ref,cuttable_ref,allocate_ref,order_tid,mklength,mkeff,lastup,remarks,mk_ver) select DATE,cat_ref,cuttable_ref,allocate_ref,order_tid,mklength,mkeff,lastup,remarks,mk_ver from $bai_pro3.maker_stat_log where tid='$mk_ref'";
					
					mysqli_query($link, $sql) or exit("Sql Error1x: $sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$ilast_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
					
					$sql="update $bai_pro3.maker_stat_log set mklength=$mk_length where tid='$ilast_id'";
					
					mysqli_query($link, $sql) or exit("Sql Error1x: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$sql="update $bai_pro3.plandoc_stat_log set lastup=\"".date("Y-m-d")."\", mk_ref=$ilast_id where doc_no=".$doc[$i];
					
					mysqli_query($link, $sql) or exit("Sql Error: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				}
			
			//Search Valid Marker is available or not
			}
			
		}
		
    }
    
    $update_parent="update $bai_pro3.binding_consumption set status='Allocated',status_at='".date("Y-m-d H:i:s")."' where id=$row_id_new";
    mysqli_query($link, $update_parent) or exit("Sql Error: $update_parent".mysqli_error($GLOBALS["___mysqli_ston"]));
    
	//Exit Code
	// $dash=$_POST['dashboard'];
	// if($dash==1){
 	// $php_self = explode('/',$_SERVER['PHP_SELF']);
	// $ctd =array_slice($php_self, 0, -2);
	// $url_rr=base64_encode(implode('/',$ctd)."/cut_table_dashboard/cut_table_dashboard.php");
	// $url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index.php?r=".$url_rr;
	// }
	// else{
	// 	$php_self = explode('/',$_SERVER['PHP_SELF']);
	// 	array_pop($php_self);
	// 	$url_r = base64_encode(implode('/',$php_self)."/fab_priority_dashboard.php");
	// 	$url1 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index.php?r=".$url_r;
	// }
	//this is for after allocating article redirect to cps dashboard.removed sfcsui

	echo"<script>swal('Successfully Updated.','','success')</script>";
	echo"<script>location.href =  '".$url1."';</script>"; 


}

?>


<?php

if(isset($_POST['allocate']))
{
    // var_dump($_POST);
    // die();
	echo "<form name='input' method='post' action='allocation.php' onkeypress='return event.keyCode != 13'>";
	$doc=$_POST['doc'];
	$dash=$_POST['dashboard'];
    $row_id = $_POST['row_id'];
	//$lot_db_2 = $_POST["pms$doc[0]"];
	//var_dump($doc);
	// echo "DOC : ".sizeof($doc);exit;
	$doc_cat=$_POST['doc_cat'];
	$doc_com=$_POST['doc_com'];
	$doc_mer=$_POST['doc_mer'];
	$cat_ref=$_POST['cat_ref'];
	
	$process_cat=$_POST['process_cat'];
    $style_ref=$_POST['style_ref'];
	$schedule=$_POST['schedule'];
    
	$size_doc=sizeof($doc);
	$note="";
	echo "<input type='hidden' id='size_doc' value=\"$size_doc\"></>";
	for($i=0;$i<sizeof($doc);$i++)
	{
		$lot=$doc[$i];
		$doc_ref=$doc[$i];
		$mat_req=$doc_mer[$i];
		
		if(isset($_POST["manual".$doc[$i]])){
			$temp=$_POST["manual".$doc[$i]];
			$manual_lot=$temp;
		}
		if(isset($_POST["pms".$doc[$i]])){
			$temp=$_POST["pms".$doc[$i]];
			$pms_lot=array();
		}

		if(strlen($temp)>0)
		{
			$pms_lot=explode(",",$temp);
		}
			
		
		$lot_ref="";
		
		unset($lot_db);
		unset($lot_db_2);
		
		$lot_db=array();
		$lot_db_2=array(); //For extracking Filtered Data
		
		if(sizeof($pms_lot)>0)
		{
			for($x=0;$x<sizeof($pms_lot);$x++)
			{
				if(strlen($pms_lot[$x])>0)
				{
					$lot_db[]="'".trim($pms_lot[$x])."'";
					$lot_db_2[]="'".trim(current(explode(">",trim($pms_lot[$x]))))."'";
					
					if(strpos(strtolower($pms_lot[$x]),"stock"))
					{
						$lot_db_2[]=0;
					}
				}
			}
		}
		
		if(sizeof($manual_lot)>0)
		{
			for($x=0;$x<sizeof($manual_lot);$x++)
			{
				if(strlen($manual_lot[$x])>0)
				{
					$lot_db[]="'".$manual_lot[$x]."'";
					$lot_db_2[]="'".trim(current(explode(">",$manual_lot[$x])))."'";
					
					if(strpos(strtolower($manual_lot[$x]),"stock"))
					{
						$lot_db_2[]=0;
					}
				}
			}
		}
		
		if(sizeof($lot)>0)
		{
			for($x=0;$x<sizeof($lot);$x++)
			{
				if(strlen($lot[$x])>0)
				{
					$lot_db[]="'".$lot[$x]."'";
					$lot_db_2[]="'".trim(current(explode(">",$lot[$x])))."'";
					
					if(strpos(strtolower($lot[$x]),"stock"))
					{
						$lot_db_2[]=0;
					}
				}
			}
		}
		$sql = "SELECT SUM(purwidth) AS pur_width FROM bai_pro3.cat_stat_log WHERE compo_no='".$doc_com[$i]."'";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error 13 :$sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$pur_width =round($sql_row['pur_width'],2);
		}
		//Table to show all list of available items
		if(sizeof($lot_db_2)>0)
		{
		
        echo "<input type=\"hidden\" name=\"row_id1\" value=\"".$row_id."\">";
		echo "<input type=\"hidden\" name=\"style_ref1\" value=\"".$style_ref."\">";
		echo "<input type=\"hidden\" name=\"schedule1\" value=\"".$schedule."\">";
        
		echo "<input type=\"hidden\" name=\"doc_ref[$i]\" value=\"".$doc_ref."\">";
		echo "<input type=\"hidden\" name=\"process_cat\" value=\"".$process_cat."\">";
		echo "<input type=\"hidden\" name=\"mat_req[$i]\" value=\"".$mat_req."\">";
		echo "<input type=\"hidden\" name=\"lot_db[$i]\" value=\"".implode(";",$lot_db)."\">";
		echo "<input type=\"hidden\" name=\"min_width[$i]\" value=\"\">";
		echo "<h3><font color=blue>".$doc_cat[$i]."-".$doc_com[$i]." /width: ".$pur_width."</font></h3>";
		
		//To show stats
		echo "<h4>Required: ".round($mat_req,2)." / Allocated: <span id=\"alloc$doc_ref\">0.00</span> / Balance to Allocate: <span id=\"balal$doc_ref\">".round($mat_req,2)."</span></h4>";
		echo "<div class='table-responsive'><table id='example".$i."' class='table table-bordered' cellspacing='0'>";
		
		echo "<thead><tr id=\"$doc_ref\" bgcolor=\"RED\">";
		echo "<th>Invoice No</th>";	
		echo "<th>GRN Date</th>";	
		echo "<th>Batch No</th>";	
		echo "<th id='col1'>Item Code</th>";	
		echo "<th id='col2'>Lot No</th>";	
		echo "<th>Shade</th>";
		if($shrinkage_inspection == 'yes')
	  {
		echo "<th id='col'>Shrinkage<br/>Group</th>";
		echo "<th id='col'>Shrinkage<br/>Width</th>";	
		echo "<th id='col'>Shrinkage<br/>Length</th>";
	  }
		echo "<th>Roll No</th>";	
		echo "<th id='col'>Location</th>";	
		echo "<th>Remarks</th>";	
		echo "<th>Group</th>";	
		echo "<th>Tkt<br/>Width</th>";	
		echo "<th>Ctx Width</th>";	
		echo "<th>Tkt<br/></th>";	
		echo "<th>Ctx<br/>Length</th>";		
		echo "<th id='col'>Avail Qty</th>";
		echo "<th style='width:45%;'>Issued Quantity</th>";
		echo "<th>Select</th>";
		// echo "<th>Avail Qnty</th>";
		echo "</tr></thead><tbody>";
		
		


		//Current Version
        $sql="select * from $bai_rm_pj1.fabric_status_v3 where lot_no in (".implode(",",$lot_db_2).") AND allotment_status in (0,1) order by shade";
        // var_dump($sql);
        // // die();
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error12: $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
		$row_count=mysqli_num_rows($sql_result);
		$j=0;
		
		$inv_no=0;
		$bg_color="#99CCFF";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if(strcmp($inv_no,trim($sql_row['inv_no'])))
			{
				if($bg_color=="#99CCFF")
				{
					$bg_color="white";
					$inv_no=trim($sql_row['inv_no']);
				}
				else
				{
					$bg_color="#99CCFF";
					$inv_no=trim($sql_row['inv_no']);
				}
			}
			
			
			$temp_var='';
			//if($sql_row['allotment_status']==0 and strlen($sql_row['shade'])>0)
			if(($sql_row['allotment_status']==0) or($sql_row['allotment_status']==1) and (strlen($sql_row['shade'])>0))
			{
				$temp_var.="<td><input type=\"checkbox\" id=\"chk$doc_ref$j\" name=\"chk".$doc_ref."[]\" value=\"".$j."\" onclick=\"check_qty2(".sizeof($doc).",'chk$doc_ref$j','$bg_color','$doc_ref',$row_count,'$i','$j')\">";
				$temp_var.="<input type=\"hidden\" name=\"val".$doc_ref."[$j]\" value=\"".$sql_row['balance']."\">";
				$temp_var.="<input type=\"hidden\" name=\"width".$doc_ref."[$j]\" value=\"".$sql_row['width']."\">";
				$temp_var.="<input type=\"hidden\" name=\"lable".$doc_ref."[$j]\" value=\"".$sql_row['tid']."\">";
				$temp_var.="<input type=\"hidden\" name=\"issued_new1".$doc_ref."[$j]\" id=\"issued_new".$doc_ref."[$j]\">";
				$temp_var.="</td>";
				
			}
			else
			{
				$temp_var.="<td>";
				
				$sql1="select max(log_time),doc_type,doc_no from $bai_rm_pj1.fabric_cad_allocation where roll_id=".$sql_row['tid'];
				$temp_var.="</br>Qry : ".$sql1."</br>";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error13: $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$tag=" ";
					if($sql_row1['doc_type']=="normal")
					{
						$tag="D".$sql_row1['doc_no'];
						
					}
					else
					{
						// $temp_var.='doc r';
						$tag="R".$sql_row1['doc_no'];
					}
					$valid_check="display:none";
				}

				if(strlen($sql_row['shade'])==0)
				{
					$tag="Insp. <br/>Pending";
					$valid_check="display:none";
				}
				// $temp_var.=$tag.'---<br/>';
				//To release for some time
				$temp_var.="<input style='$valid_check' type=\"checkbox\" id=\"chk$doc_ref$j\" name=\"chk".$doc_ref."[]\" value=\"".$j."\" onclick=\"check_qty2(".sizeof($doc).",'chk$doc_ref$j','$bg_color','$doc_ref',$row_count,$i,$j')\">";
				//$temp_var.="<input type=\"hidden\" id=\"chk$doc_ref$j\" name=\"chk".$doc1_ref."[]\" value=\"0\" onclick=\"check_qty2(".sizeof($doc).",'chk$doc_ref$j','$bg_color')\">";
				$temp_var.="<input type=\"hidden\" name=\"val".$doc_ref."[$j]\" value=\"".$sql_row['balance']."\">";
				$temp_var.="<input type=\"hidden\" name=\"width".$doc_ref."[$j]\" value=\"".$sql_row['width']."\">";
				$temp_var.="<input type=\"hidden\" name=\"lable".$doc_ref."[$j]\" value=\"".$sql_row['tid']."\">";
				$temp_var.="<input type=\"hidden\" name=\"issued_new1".$doc_ref."[$j]\" id=\"issued_new".$doc_ref."[$j]\">";
				
				if(strlen($tag)>0)
				{
					$temp_var.="<img src=\"lock.png\"> $tag";
				}
				$temp_var.="</td>";
				
			}
			$result='Insp.';
			// if($result == substr($tag, 0, 5)) 
			{
			echo "<input type='hidden' id='srgp$doc_ref$j' value='".$sql_row['shrinkage_group']."'>";
			echo "<tr bgcolor=\"$bg_color\" id=\"trchk$doc_ref$j\">";
			$sql3="select tid,split_roll from $bai_rm_pj1.store_in where tid=".$sql_row['tid'];
			$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error22 :$sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result3)>0)
			{
				while($sql_row2=mysqli_fetch_array($sql_result3))
				{
					if($sql_row2['split_roll'] != '') {
						echo "<td><center><a data-toggle='modal' id='btn$doc_ref$j' data-target='#modalbtn$doc_ref$j' class='label label-warning label-lg'>".$sql_row['inv_no']."(Splitted Roll)</a></center></td>";
					} else {
						echo "<td>".$sql_row['inv_no']."</td>";
					}
				}
			}
			
			
			/* Added new code to track allocated quantities 20140621*/
			
			$sql1="SELECT GROUP_CONCAT(CONCAT(IF(doc_type='normal','D','R'),doc_no)) AS doc_nos,ROUND(SUM(allocated_qty),2) AS allocated_qty FROM $bai_rm_pj1.fabric_cad_allocation WHERE roll_id=".$sql_row['tid']." AND bai_rm_pj1.fn_roll_id_fab_scan_status(doc_no,doc_type,roll_id)=0";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error13: $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				
					$tag=$sql_row1['doc_nos'];
					$allocated_qty=$sql_row1['allocated_qty'];
			}


			$sql5="SELECT coalesce(sum(allocated_qty),0) as allocated_qty,roll_id,status FROM $bai_rm_pj1.fabric_cad_allocation where roll_id=".$sql_row['tid']." and status='1'";
				$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error13: $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row5=mysqli_fetch_array($sql_result5))
				{
					$fab_cad_allocated_qty=$sql_row5['allocated_qty'];
				}
			echo "<td>".$sql_row['grn_date']."</td>";
			echo "<td>".$sql_row['batch_no']."</td>";
			echo "<td id='col1'>".$sql_row['item']."</td>";
			echo "<td id='col1'>".$sql_row['lot_no']."</td>";
			echo "<td>".$sql_row['shade']."</td>";
			if($shrinkage_inspection == 'yes') 
	        {
			echo "<td>".$sql_row['shrinkage_group']."</td>";
			echo "<td>".$sql_row['shrinkage_width']."</td>";
			echo "<td>".$sql_row['shrinkage_length']."</td>";
			}
			echo "<td>".$sql_row['ref2']."</td>";
			echo "<td>".$sql_row['ref1']."</td>";
			echo "<td>".$sql_row['roll_remarks']."</td>";
			echo "<td>".$sql_row['shade']."</td>";
			echo "<td>".$sql_row['ref6']."</td>";
			echo "<td>".$sql_row['ref3']."</td>";
			echo "<td>".$sql_row['qty_rec']."</td>";
			echo "<td>".$sql_row['ref5']."</td>";
			echo "<td>".($sql_row['qty_rec']-$sql_row['qty_issued']+$sql_row['qty_ret']-$fab_cad_allocated_qty)."</td>";
			echo "<td><input class='form-control float' name=\"issued_new".$doc_ref."[$j]\" type = 'number' min='0' step='any' id=\"issued".$doc_ref."[$j]\" value = '0' onchange='filling($doc_ref,$j,$i);' readonly></input></td>";
			
			//echo "</br>Allotment Status".$sql_row['allotment_status']."</br>";

			echo $temp_var;			
			echo "</tr>";
		}
			$tid = $sql_row['tid'];
			$n = 1; 
			$modaldisplay.="<div id='modalbtn".$doc_ref.$j."' class='modal fade' role='dialog'>
				<div class='modal-dialog'>
			
				<!-- Modal content-->
				<div class='modal-content'>
					<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'>&times;</button>
					<h4 class='modal-title'> Roll Splitted From :</h4>
					</div>
					<div class='modal-body'>
					<div class='table-responsive'>
					<table class='table'>
					<tr style=''background-color:'#337ab7'>
					<th style='color:black;'>Invoice<br/>No</th>
					<th style='color:black;'>GRN Date</th>
					<th style='color:black;'>Batch<br/>No</th>
					<th style='color:black;'>Item Code</th>
					<th style='color:black;'>Lot No</th>
					<th style='color:black;'>Shade</th>
					<th style='color:black;'>Shrinkage<br/>Group</th>
					<th style='color:black;'>Shrinkage<br/>Width</th>
					<th style='color:black;'>Shrinkage<br/>Length</th>
					<th style='color:black;'>Roll<br/>No</th>
					<th style='color:black;'>Location</th>
					<th style='color:black;'>Group</th>
					<th style='color:black;'>Tkt<br/>Width</th>
					<th style='color:black;'>Ctx<br/>Width</th>
					<th style='color:black;'>Tkt<br/>Length</th>
					<th style='color:black;'>Ctx<br/>Length</th>	
					<th style='color:black;'>Issued<br/>Qty</th>
					</tr>";
			for($m=0; $m < $n; $m++) {
				$sql3="select tid,split_roll from $bai_rm_pj1.store_in where tid=".$tid;
				$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error22 :$sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result3)>0)
				{
					while($sql_row2=mysqli_fetch_array($sql_result3))
					{
						$tid =$sql_row2['split_roll'];
						if($sql_row2['split_roll'] != '') {
							$sql_query ="SELECT * FROM bai_rm_pj1.fabric_status_v3 WHERE lot_no IN (SELECT lot_no FROM bai_rm_pj1.store_in WHERE tid IN (".$sql_row2['split_roll'].")) AND tid IN(".$sql_row['tid'].")";
							$sql_result_new=mysqli_query($link, $sql_query) or exit("Sql Error22 :$sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_result_new=mysqli_fetch_array($sql_result_new))
								{
									$tid =$sql_row2['split_roll'];
									$modaldisplay.="<tr>
										<td>".$sql_result_new['inv_no']."</td>
										<td>".$sql_result_new['grn_date']."</td>
										<td>".$sql_result_new['batch_no']."</td>
										<td>".$sql_result_new['item']."</td>
										<td>".$sql_result_new['lot_no']."</td>
										<td>".$sql_result_new['shade']."</td>
										<td>".$sql_result_new['shrinkage_group']."</td>
										<td>".$sql_result_new['shrinkage_width']."</td>
										<td>".$sql_result_new['shrinkage_length']."</td>
										<td>".$sql_result_new['ref2']."</td>
										<td>".$sql_result_new['ref1']."</td>
										<td>".$sql_result_new['shade']."</td>
										<td>".$sql_result_new['ref6']."</td>
										<td>".$sql_result_new['ref3']."</td>
										<td>".$sql_result_new['qty_rec']."</td>
										<td>".$sql_result_new['ref5']."</td>
										<td><span id=\"issued".$doc_ref."[$j]\"></span></td>
										</tr>";
										
								}
						}
					}
				}
				
				}
				$modaldisplay.="</table>
				</div>
					</div>
					<div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
					</div>
				</div>
			
				</div>
				</div>";
			$j++;
		}
		echo "</tbody></table></div>";
		echo $modaldisplay;
		}//Allow only for selected lots/docs
		
		//Table to show all list of available items
		echo "<input type='hidden' value='$doc_ref' id='doc_chk'><br/>";
		echo "<input type='hidden' value='$dash' id='dashboard' name='dashboard'><br/>";

	}

	echo "<input type=\"submit\" id=\"allocate_new\" name=\"allocate_new\" value=\"Issue\" class='btn btn-success'>";
	echo "</form>";
}
?>
</div>
<script>
	document.getElementById("msg").style.display="none";	
    document.getElementById('allocate_new').disabled=true;
</script>
<style>
    th{
        text-align:center;
    }
   
	.btn-primary{
		background-color:#337ab7;
		color:white;
		font-weight:bold;
		padding:4px;
		text-decoration:none;
	}
	.btn-success{
		background-color:#5cb85c;
		color:white;
		font-weight:bold;
		padding:4px;
		text-decoration:none;
		borde: 1 px solid #5cb85c;
	}
	h4{
		background-color:#f4a82e;
		width:36%;
		color:white;
		padding:2pt;
		font-size:14px;
	}
	

	#reset_example{
		width : 80px;
		color : #fff;
		margin : 10px;
	}
	.flt{
		width:100%;
	}
</style>

</body>
</html>
	<script language="javascript" type="text/javascript">
	
	
			var filtersConfig = {
				exact_match: false,
				alternate_rows: true,
				sort_select: true,
				loader_text: "Filtering data...",
				loader: true,
				rows_counter: true,
				rows_counter_text: "Total rows: ",
				btn_reset: true,
			};
			var i;
			var len=document.getElementById('size_doc').value;
			for (i = 0; i <=len; i++) {
				var tf = new TableFilter(document.querySelector('#example'+i), filtersConfig);
				tf.init();
				$('.helpCont').hide();
				$('.helpBtn').hide();
				$('.reset').val('reset');
				$('.reset').addClass('btn btn-warning btn-xs');
				$('#flt17_example'+i).hide();
			}
		
	</script>

<script src="../../../../common/js/bootstrap1.min.js"></script>


