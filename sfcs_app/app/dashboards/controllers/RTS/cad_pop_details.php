
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));

$view_access=user_acl("SFCS_0197",$username,1,$group_id_sfcs);//1
$authorized_rm=user_acl("SFCS_0197",$username,49,$group_id_sfcs);  // RM access//2
$authorized_emb=user_acl("SFCS_0197",$username,50,$group_id_sfcs); // Emb access //3
$authorized_cad=user_acl("SFCS_0197",$username,74,$group_id_sfcs); // CAD Access//4
$authorized_sour=user_acl("SFCS_0197",$username,75,$group_id_sfcs); // Sourcing//5
$authorized_cut_iss=user_acl("SFCS_0197",$username,76,$group_id_sfcs); // issued to module update access to cutting team //6
$authorized_samp_iss=user_acl("SFCS_0197",$username,77,$group_id_sfcs); // issued to module update access to Sample room //7
?>

<?php

//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=$username_list[1];



?>

<?php
set_time_limit(2000);

 
$doc_no=$_GET['doc_no'];
$code=$_GET['code'];
$emb_stat=$_GET['emb_stat'];
$act_cut_issue_status=$_GET['act_cut_issue_status'];
//1 -cad
//2 -sourcing
//3 -issued to module update
//$authorized_rm=array("kirang","herambaj","kishorek","sarojiniv","kirang","ravipu","ramanav","sekhark","lovakumarig","ganeshb","kirang","pithanic","srinivasaraot","demiank","santhoshbo","vemanas","kirang","buddhikaga","lokeshk","varalakshmik","eswarraok","babjim","ramunaidus","nagendral","kirang","herambaj","kishorek","sarojiniv","kirang","ravipu","ramanav","sekhark","lovakumarig","ganeshb","pithanic","srinivasaraot","demiank","santhoshbo","vemanas","kirang","buddhikaga","gowthamis","rajinig","revathil","lovarajub","ramud","sivark","rajinig");

//$authorized_emb=array("kirang","kirang","malleswararaog","swatikumariv","varalakshmik"); //Embellishment Authorized users
$path12 = getFullURL($_GET['r'],'restrict.php','N');
switch($code)
{
	case 1:
	{
		//$authorized_cad=array("kirang","chandrasekhard","kalyanb","sanyasiraop","tharangam","dineshin","kirang","kirang","lokeshk","kirang","kirang","kirang","srinub","kirang","golukondar","pylas","chandanasis","athulas","bandaruk","kirang");
		if(!(in_array(strtolower($username),$authorized_cad)))
		{
			header("Location:".$path12."&doc_no=$doc_no&code=$code");
		}
		break;
	}
	case 2:
	{
		//$authorized_sour=array("kirang","herambaj","srikanthb","kasinac","kirang","demiank","kishorek","srinivasaraot","santhoshbo","buddhikaga","sithayyababup","rambabub","chaitanyavarmag","varalakshmik","eswarraok","babjim","ramunaidus","nagendral","veerabalajiv","kirang","gowthamis","rajinig","revathil","lovarajub","ramud","sreenivasg","sivark","rajinig","kirang","kirang","mukeshk","chinnib","mohammadr","ajithi","kirang");
		if(!(in_array(strtolower($username),$authorized_sour)))
		{
			header("Location:".$path12."&doc_no=$doc_no&code=$code");
		}
		break;
	}
	case 3:
	{
		//$authorized_cut_iss=array("kirang","kirang","kirang","kirang","bheemunaidug","bhaskarraok","varalaxmik","malithad","rajanaa","kollin","boddedan","nagamanip","lakshmik"); // Issue to module reporting operation access for cutting recorders
		
		//$authorized_samp_iss=array("kirang","kirang","kirang","kirang","kirang","anusharanim","srinivasaraos");  // Issue to module reporting operation access for sample room
		
		$check_user=array_merge($authorized_cut_iss,$authorized_samp_iss);
		
		if(!(in_array(strtolower($username),$check_user)))
		{
			header("Location:".$path12."&doc_no=$doc_no&code=$code");
			
		}
		break;
	}

}
?>





<style>
body
{
	font-family:arial;
	font-size:14px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align:left;
	vertical-align:top;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: BLUE;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:14px;
} 


</style>

<script>
function dodisable()
{
enableButton();

}


function enableButton(x) 
{
	var val=x;
	status=0;
	for(var i=0;i<val;i++)
	{
		var mklen=document.getElementById('mklen'+i).value;
		var plies=document.getElementById('plies'+i).value;
		if(mklen==0 || plies==0)
		{
			status=1;
		}		
	}
	if(status==0)
	{
		if(document.test1.option1.checked)
		{
			document.test1.update1.disabled='';
		} 
		else 
		{			
			document.test1.update1.disabled='true';
		}
	}
	else
	{		
		sweetAlert("Please update Marker Length or Plies then try.","","warning");
		document.test1.option1.checked=false;
	}
}
</script>

<div class="panel panel-primary"  onload="dodisable();">
	<div class="panel-heading">
		POP Recut Control Panel
	</div>
	<div class="panel-body">
    
<?php

echo "<div class='col-md-5'>";
echo "<table class='table table-bordered'>";
echo "<tr class='tblheading' style='color:white;'>";
echo "<th>Style</th>";
echo "<th>Schedule</th>";
echo "<th>Color</th>";
echo "<th>Job No</th>";
echo "</tr>";


$sql1="SELECT * from $bai_pro3.recut_v2 where doc_no=$doc_no";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	
	$order_tid=$sql_row1['order_tid'];
	$module=$sql_row1['plan_module'];
	
	
	$sql11="SELECT * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
	//echo $sql11."<br>";
	$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row11=mysqli_fetch_array($sql_result11))
	{
		$o_s_xs=$sql_row11['order_s_xs'];
		$o_s_s=$sql_row11['order_s_s'];
		$o_s_m=$sql_row11['order_s_m'];
		$o_s_l=$sql_row11['order_s_l'];
		$o_s_xl=$sql_row11['order_s_xl'];
		$o_s_xxl=$sql_row11['order_s_xxl'];
		$o_s_xxxl=$sql_row11['order_s_xxxl'];
		//size values not automated
		/*$o_s_s01=$sql_row['order_s_s01'];
		$o_s_s02=$sql_row['order_s_s02'];
		$o_s_s03=$sql_row['order_s_s03'];
		$o_s_s04=$sql_row['order_s_s04'];
		$o_s_s05=$sql_row['order_s_s05'];
		$o_s_s06=$sql_row['order_s_s06'];
		$o_s_s07=$sql_row['order_s_s07'];
		$o_s_s08=$sql_row['order_s_s08'];
		$o_s_s09=$sql_row['order_s_s09'];
		$o_s_s10=$sql_row['order_s_s10'];
		$o_s_s11=$sql_row['order_s_s11'];
		$o_s_s12=$sql_row['order_s_s12'];
		$o_s_s13=$sql_row['order_s_s13'];
		$o_s_s14=$sql_row['order_s_s14'];
		$o_s_s15=$sql_row['order_s_s15'];
		$o_s_s16=$sql_row['order_s_s16'];
		$o_s_s17=$sql_row['order_s_s17'];
		$o_s_s18=$sql_row['order_s_s18'];
		$o_s_s19=$sql_row['order_s_s19'];
		$o_s_s20=$sql_row['order_s_s20'];
		$o_s_s21=$sql_row['order_s_s21'];
		$o_s_s22=$sql_row['order_s_s22'];
		$o_s_s23=$sql_row['order_s_s23'];
		$o_s_s24=$sql_row['order_s_s24'];
		$o_s_s25=$sql_row['order_s_s25'];
		$o_s_s26=$sql_row['order_s_s26'];
		$o_s_s27=$sql_row['order_s_s27'];
		$o_s_s28=$sql_row['order_s_s28'];
		$o_s_s29=$sql_row['order_s_s29'];
		$o_s_s30=$sql_row['order_s_s30'];
		$o_s_s31=$sql_row['order_s_s31'];
		$o_s_s32=$sql_row['order_s_s32'];
		$o_s_s33=$sql_row['order_s_s33'];
		$o_s_s34=$sql_row['order_s_s34'];
		$o_s_s35=$sql_row['order_s_s35'];
		$o_s_s36=$sql_row['order_s_s36'];
		$o_s_s37=$sql_row['order_s_s37'];
		$o_s_s38=$sql_row['order_s_s38'];
		$o_s_s39=$sql_row['order_s_s39'];
		$o_s_s40=$sql_row['order_s_s40'];
		$o_s_s41=$sql_row['order_s_s41'];
		$o_s_s42=$sql_row['order_s_s42'];
		$o_s_s43=$sql_row['order_s_s43'];
		$o_s_s44=$sql_row['order_s_s44'];
		$o_s_s45=$sql_row['order_s_s45'];
		$o_s_s46=$sql_row['order_s_s46'];
		$o_s_s47=$sql_row['order_s_s47'];
		$o_s_s48=$sql_row['order_s_s48'];
		$o_s_s49=$sql_row['order_s_s49'];
		$o_s_s50=$sql_row['order_s_s50'];
		
		*/
		for($s=0;$s<sizeof($sizes_code);$s++)
		{
			$o_s[$sizes_code[$s]]=$sql_row11["order_s_s".$sizes_code[$s].""];
		}
		for($s=0;$s<sizeof($sizes_code);$s++)
		{
			if($sql_row11["title_size_s".$sizes_code[$s].""]<>'')
			{
				$s_tit[$s]=$sql_row11["title_size_s".$sizes_code[$s].""];
				//echo $sql_row["title_size_s".$sizes_code[$s].""]."<br>";
			}	
		}
		//echo $sql_row11["title_size_s01"]."<br>";
		$flag = $sql_row11['title_flag'];
		$order_status=$sql_row11['order_stat'];
    	$o_total=array_sum($o_s);
		//$o_total=($o_s_xs+$o_s_s+$o_s_m+$o_s_l+$o_s_xl+$o_s_xxl+$o_s_xxxl);
		
		echo "<tr>";
		echo "<td>".$sql_row11['order_style_no']."</td>";
		echo "<td>".$sql_row11['order_del_no']."</td>";
		echo "<td>".$sql_row11['order_col_des']."</td>";
		echo "<td>"."R".leading_zeros($sql_row1['acutno'],3)."</td>";
		echo "</tr>";
		
			
		$style=$sql_row11['order_style_no'];
		$schedule=$sql_row11['order_del_no'];
		$color=$sql_row11['order_col_des'];
	}
	
	$cut_no_ref=$sql_row1['acutno'];
	$order_id_ref=$sql_row1['order_tid'];
	$style_ref=$sql_row1['order_tid'];
	$fab_status=$sql_row1['fabric_status'];
	
	
	
	
}


echo "</table>";

//DOCKET PRINT

// if($code==0 and in_array($username,$authorized_rm))//1
// {
	
	echo "<br><h2>Cut Docket Print</h2>";
	
	$path2 = getFullURLLevel($_GET['r'],'Book3_print_recut.php',0,'N');
	$path3 = getFullURLLevel($_GET['r'],'Book3_print_recut1.php',0,'N');
	$path4 = getFullURLLevel($_GET['r'],'cad_pop_details_process.php',0,'N');
	$path="..";
	if(substr($style_ref,0,1)!="P" || substr($style_ref,0,1)!="K" || substr($style_ref,0,1)!="L" || substr($style_ref,0,1)!="O")
	{
		
		if($o_total>0)
		{
			$path=$path2;  // For M&S Men Briefs
		}
		else
		{
			$path=$path3; // FOR M&S Ladies Briefs
		}
		
	}
	
	echo "<table class='table table-bordered'><tr class='tblheading' style='color:white;'><th>Category</th><th>Control</th><th>Print Status</th></tr>";
$sql1="SELECT recut_v2.plan_lot_ref,recut_v2.cat_ref,recut_v2.print_status,recut_v2.doc_no,cat_stat_log.category from $bai_pro3.recut_v2 left join $bai_pro3.cat_stat_log on recut_v2.cat_ref=cat_stat_log.tid  where recut_v2.order_tid=\"$order_id_ref\" and recut_v2.acutno=$cut_no_ref";
//echo $sql1;
//mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result1);
$enable_allocate_button=0;
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	//echo $sql_row1['cat_ref']."<br/>";
	//echo $sql_row1['doc_no']."<br/>";
	//echo $sql_row1['category']."<br/>";
	echo "<tr><td>".$sql_row1['category']."</td>";
	
	
	//echo "<td><a href=\"$path?order_tid=$order_id_ref&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."\" onclick=\"Popup1=window.open('$path?order_tid=$order_id_ref&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";

	if(strlen($sql_row1['plan_lot_ref'])>0)
	{
	
		echo "<td><a href=\"$path&order_tid=$order_id_ref&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."\" onclick=\"Popup1=window.open('$path&order_tid=$order_id_ref&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";
	}
	if($sql_row1['print_status']>0)
{
	echo "<td><img src='".getFullURLLevel($_GET['r'],'common/images/Correct.png',2,'R')."'></td>";
}
else
{
	echo "<td></td>";
}
echo "</tr>";
}
echo "</table>";
//}//2


if($code==1)
{
	if($order_status=="")
	{	

		echo "<form method=\"post\" id=\"test1\" name=\"test1\" action=\""."$path4"."\">";
		echo "<input type=\"hidden\" name=\"order_tid\" value=\"$order_tid\">";
		echo "<input type=\"hidden\" name=\"style\" value=\"$style\">";
		echo "<input type=\"hidden\" name=\"schedule\" value=\"$schedule\">";
		echo "<input type=\"hidden\" name=\"color\" value=\"$color\">";
		echo "<input type=\"hidden\" name=\"module\" value=\"$module\">";
		echo "<input type=\"hidden\" name=\"doc_no_ref\" value=\"$doc_no\">";
		echo "<input type=\"hidden\" name=\"code_no_ref\" value=\"$code\">";


		$sql1="SELECT recut_v2.*, cat_stat_log.category,cat_stat_log.tid from $bai_pro3.recut_v2 left join cat_stat_log on recut_v2.cat_ref=cat_stat_log.tid  where recut_v2.order_tid=\"$order_id_ref\" and recut_v2.acutno=$cut_no_ref and recut_v2.mk_ref=0";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result1);
		$enable_allocate_button=0;$jj=0;
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			for($s=0;$s<sizeof($sizes_code);$s++)
			{
				$a_s[$sizes_code[$s]]=$sql_row1["a_s".$sizes_code[$s].""];
			
			}
			$tid=$sql_row1['tid'];
			$sizes_table.="<input type=\"hidden\" name=\"cat[]\" value=\"".$sql_row1['tid']."\"><input type=\"hidden\" name=\"cat_name[]\" value=\"".$sql_row1['category']."\">";
			$sizes_table.="<input type=\"hidden\" name=\"docno[]\" value=\"".$sql_row1['doc_no']."\">";
			$sizes_table.="<h2>".$sql_row1['category']."</h2>";
			$sizes_table.="<table class='table table-bordered'><tr class='tblheading' style='color:white;'><th>Size</th><th>Qty</th><th>Ratio</th></tr>";
			//echo sizeof($s_tit)."<br>";
			for($i=0;$i<sizeof($s_tit);$i++)
			{
				$sizes_table.="<tr><td>".$s_tit[$i]."</td><td>".$sql_row1["a_s".$sizes_code[$i].""]."</td><td><input type=\"hidden\" name=\"size_".$tid."[]\" value=\"a_s".$sizes_code[$i]."\"><input type=\"text\" name=\"qty_".$tid."[]\" value=\"".$sql_row1["a_s".$sizes_code[$i].""]."\"></td></tr>";
			
			}
			$sizes_table.="<tr><td>Total QTY</td><td>".array_sum($a_s)."</td>";
			$sizes_table.="<tr><td>MK Length</td><td><input type=\"text\" id='mklen".$jj."' name=\"mklen[]\" value=\"0\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\"></td></tr>";
			$sizes_table.="<tr><td>Plies</td><td><input type=\"text\" id='plies".$jj."' name=\"plies[]\" value=\"0\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\"></td></tr>";
			$sizes_table.="</table>";
			$jj++;

		}
		echo $sizes_table;
		if($sql_num_check>0)
		{
			echo "<input type=\"checkbox\" name=\"option\"  id=\"option1\" onclick=\"javascript:enableButton($jj);\">Enable<input id=\"update1\" type=\"submit\" name=\"submit\" value=\"Update\" disabled>";
		}

		echo "</form>";
	}
	else
	{
		echo "<h2 style='color:red;'> Order Status has closed for this schedule: <h2/>".$schedule."<br/>";
		echo "<h2> Please check with the Planning Team <h2/>";
	}
}
else
{
	if($code==2)
	{
		if($order_status=="")
		{
				echo "<h2>Required Materials:</h2>";
				$sql1="SELECT recut_v2.mk_ref,recut_v2.a_plies,recut_v2.remarks,maker_stat_log.mklength from $bai_pro3.recut_v2 left join maker_stat_log on recut_v2.mk_ref=maker_stat_log.tid where recut_v2.order_tid=\"$order_id_ref\" and recut_v2.acutno=$cut_no_ref";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					echo "<h2>".$sql_row1['remarks']."- ".($sql_row1['a_plies']*$sql_row1['mklength'])."</h2>";
				}
				
				
				echo "<form method=\"post\" name=\"test\" action=\""."$path4"."\">";
				echo "<input type=\"hidden\" name=\"order_tid\" value=\"$order_tid\">";
				echo "<input type=\"hidden\" name=\"cut_no_ref\" value=\"$cut_no_ref\">";
				echo "<input type=\"hidden\" name=\"doc_no_ref\" value=\"$doc_no\">";
				echo "<input type=\"hidden\" name=\"code_no_ref\" value=\"$code\">";
				
				echo "RM Fabric Status:<select name=\"status\">";
				$status=array("","Available","Not Available");
				for($i=1;$i<=2;$i++)
				{
					if($fab_status==$i)
					{
						echo "<option value=\"$i\" selected>".$status[$i]."</option>";
					}
					else
					{
						echo "<option value=\"$i\">".$status[$i]."</option>";
					}
				}
				echo "</select>";
				
				echo "<input type=\"submit\" name=\"update\" value=\"Update\">";
				echo "</form>";
				
		}
		else
		{
			echo "<h2 style='color:red;'> Order Status has closed for this schedule: <h2/>".$schedule."<br/>";
			echo "<h2> Please check with the Planning Team <h2/>";
		}	
	}
	else
	{
		if($code==3)
		{
			if($order_status=="")
			{
			
					echo "<form method=\"post\" name=\"test\" action=\""."$path4"."\">";
					echo "<input type=\"hidden\" name=\"order_tid\" value=\"$order_tid\">";
					echo "<input type=\"hidden\" name=\"cut_no_ref\" value=\"$cut_no_ref\">";
					echo "<input type=\"hidden\" name=\"doc_no_ref\" value=\"$doc_no\">";
					echo "<input type=\"hidden\" name=\"code_no_ref\" value=\"$code\">";
					
					echo "Cut Issue Status:<select name=\"status\">";
					echo "<option value=\"0\"></option>";
					if($module == 'TOP' and in_array($username,$authorized_samp_iss))
					{
						if($emb_stat==0)
						{
							echo "<option value=\"1\">Issued to Module</option>";	
						}
					}	
					else if($module != 'TOP' and in_array($username,$authorized_cut_iss))
					{
						if($emb_stat==0)
						{
							echo "<option value=\"1\">Issued to Module</option>";	
						}
					}
					if(in_array($username,$authorized_emb) and $emb_stat>0 and $act_cut_issue_status!='EPC')
					{
							switch($act_cut_issue_status)
							{
								case "EPS":
								{
									echo "<option value=\"EPR\">Received from Cutting</option>";
									break;
								}
								case "EPR":
								{
									echo "<option value=\"EPC\">Embellishment Completed</option>";
									break;
								}
								
								default:
								{
									echo "<option value=\"EPS\">Send to Embellishment</option>";
								}
							}
					}
					if(in_array($username,$check_user) and $act_cut_issue_status=='EPC')
					{			
							switch($act_cut_issue_status)
							{	
								case "EPC":
								{
									if(($module=='TOP' and in_array($username,$authorized_samp_iss)) or ($module!='TOP' and in_array($username,$authorized_cut_iss)))
									{
										echo "<option value=\"1\">Issued to Module</option>";	
										break;
									}
									else
									{
										echo "<option value=\"0\"></option>";
										break;
									}
									
								}
							}	
					}
					else
					{
							echo "<option value=\"0\"></option>";
					}
					
					
					echo "</select>";
					
					echo "<input type=\"submit\" name=\"issue\" value=\"Update\">";
					echo "</form>";
					
			}
			else
			{
			    echo "<h2 style='color:red;'> Order Status has closed for this schedule: <h2/>".$schedule."<br/>";
				echo "<h2> Please check with the Planning Team <h2/>";
			}		
		}
	}
	
}
?>

  </div>
</div>