<html>
<head>

<?php
include($_SERVER['DOCUMENT_ROOT']."/server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."/server/group_def.php"); 
$view_access=user_acl("SFCS_0092",$username,1,$group_id_sfcs); 
?>

<?php include("header_scripts.php"); 
include("dbconf.php");

//Add extrac cut quantities to first cut of first schedule
$add_excess_qty_to_first_sch=1; //0-Yes, 1-NO
?>
<?php include("menu_content.php"); ?>


<script>

function firstbox()
{
	window.location.href ="mix_jobs.php?style="+document.test.style.value
}

function secondbox()
{
	window.location.href ="mix_jobs.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value
}

function thirdbox()
{
	window.location.href ="mix_jobs.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}
</script>
</head>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
<body>

<style>
body
{
	font-family:calibri;
	font-size:12px;
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
	text-align: right;
white-space:nowrap; 
}

table td.lef
{
	border: 1px solid black;
	text-align: left;
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
	font-size:12px;
}


}

}
</style>
<script type="text/javascript" src="datetimepicker_css.js"></script>

</head>
<body>
<div id="page_heading"><span style="float: left"><h3>Schedule Segregation Panel </h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>

<form name="test" method="post" action="mix_jobs.php">

<?php

$style=$_GET['style'];
$schedule=$_GET['schedule']; 
$color=$_GET['color'];
$po=$_GET['po'];

if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule']; 
	$color=$_POST['color'];
	$po=$_POST['po'];
}


echo "Select Style: <select name=\"style\" onchange=\"firstbox();\" >";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_style_no from bai_orders_db where order_joins=\"1\" and order_style_no not in ('H18122AA       ','I292550A       ','I292553A       ','I292580A       ','I292653A       ','I296643A       ','I96632AA       ','I96646AA       ','I97183AA','IDUMY929','M04600AA       ','M04600AB       ','M04600AC','M04634AD       ','M04634AE       ','M04634AF','M04634AG','M04641AA       ','M04648AA','M04649AA','M05083AA','M06484AQ       ','M06484AR','M06485AP       ','M07562AA','M09313AE       ','M09313AG       ','M09313AH','M4600GAA       ','M4634LAA','M4634RAA','M7028AAE       ','M7028AAF','N12201AE       ','N19201AD       ','N19801AB       ','N19801AC       ','N7118SAH       ','N7118SAI       ','S16580AA       ','S174815A       ','S174815B       ','S174815C       ','S17761AA       ','S17761AB       ','S17761AC       ','S17764AA       ','S17764AB       ','S17764AC       ','S17767AA       ','S17767AB       ','S17767AC       ','S17775AA       ','S17775AB       ','S17775AC       ','S19876AA       ','S19879AA       ','S19965AA       ','U10098AJ       ','U10217AH       ','U10217AI','U20128AH       ','U20128AI','U30002AH       ','U30002AI','U30148AK       ','U30148AL','U50027AK       ','U50027AL','U60116AK       ','U60117AK       ','U60117AL','U90008AH       ','U90008AI','YCI028AA','YCI278AA','YCI404AA','YCI553AA','YCI931AA','YCL028AA','YCL278AA','YCL404AA','YCL553AA','YCL931AA','YSI028AA','YSI278AA','YSI404AA','YSI553AA','YSI931AA') order by order_style_no";	
//}
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_num_check=mysql_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysql_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
{
	echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
}

}

echo "</select>";
?>


<?php

echo "Select Schedule: <select name=\"schedule\" onchange=\"secondbox();\" >";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_del_no from bai_orders_db where order_style_no=\"$style\" and order_joins=\"1\" order by order_date";	
//}
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_num_check=mysql_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysql_fetch_array($sql_result))
{


if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
{
	echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
}

}
echo "</select>";

echo "Select Color: <select name=\"color\" onchange=\"thirdbox();\" >";
$sql="select distinct order_col_des from bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_joins=\"1\"";
//}
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_num_check=mysql_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
	
while($sql_row=mysql_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
{
	echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
}

}


echo "</select>";
?>

<!-- <input type="text" name="schedule" value=""> -->
<?php 
if(strlen($color)>0 and $color!="NIL"){
	//echo '<input type="submit" name="submit" value="Segregate">';
	echo "<input type=\"submit\" value=\"Segregate\" name=\"submit\"  id=\"Segregate\" onclick=\"document.getElementById('Segregate').style.display='none'; document.getElementById('msg1').style.display='';\"/>";
	echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait data is processing...!<h5></span>";
}

?>
</form>

</body>
</html>

<?php

if(isset($_POST['submit']))
{
	$order_sch=$_POST['schedule'];
	$orders_join="J".$order_sch;	
    $style=$_POST['style']; 
    $color=$_POST['color'];
	$cat_id_ref=array();
	$order_id_ref=array();
	$doc_det=array();
	$pend_order=array();
	$pending_cat_ref=array();
	$pending_cat_order=array();
	$pending_cat_ref_type=array();
	$ready_cat_ref=array();
	$ready_cat_order=array();
	$ready_cat_ref_type=array();
	$o_s=array();	
	$o_s_t=array();
	$table_tag="bai_orders_db_club_confirm";
	$sql4="select * from bai_pro3.cat_stat_log where order_tid like \"%".$order_sch.$color."%\" and category<>''"; 
	$sql_result4=mysql_query($sql4, $link) or exit("Sql Error4".mysql_error());
	while($sql_row4=mysql_fetch_array($sql_result4)) 
	{
		$cat_id_ref[]=$sql_row4["tid"];	
		$order_id_ref[]=$sql_row4["order_tid"];
		$cat_type[]=$sql_row4["category"];
	}
	$sql47="select * from bai_orders_db_confirm where order_del_no='$order_sch' and order_col_des=\"".$color."\""; 
	//echo $sql47."<br>";
	$sql_result47=mysql_query($sql47, $link) or exit("Sql Error4".mysql_error()); 
	while($sql_row47=mysql_fetch_array($sql_result47)) 
	{ 
		for($s=0;$s<sizeof($sizes_array);$s++)
		{
			if($sql_row47["title_size_".$sizes_array[$s].""]<>'')
			{
				$o_s[$sizes_array[$s]]=$sql_row47["order_s_".$sizes_array[$s].""];
				$o_s_t[$sizes_array[$s]]=$sql_row47["title_size_".$sizes_array[$s].""];
				//echo $sql_row47["title_size_".$sizes_array[$s].""]."----".$sql_row47["order_s_".$sizes_array[$s].""]."<br>";
			}
		}	
		
	} 
	for($ii=0;$ii<sizeof($cat_id_ref);$ii++)
	{
		$sql41="select * from plandoc_stat_log where order_tid='".$order_id_ref[$ii]."' and cat_ref='".$cat_id_ref[$ii]."'"; 
		$sql_result41=mysql_query($sql41, $link) or exit("Sql Error4".mysql_error());
		if(mysql_num_rows($sql_result41)>0)
		{
			while($sql_row41=mysql_fetch_array($sql_result41)) 
			{
				for($s=0;$s<sizeof($o_s_t);$s++)
				{
					if($sql_row41["p_".$sizes_array[$s].""]>0)
					{
						$tot_com[$sizes_array[$s]]+=$sql_row41["p_".$sizes_array[$s].""]*$sql_row41["p_plies"];
					}					
				}
				$doc_det[]=$sql_row41["doc_no"];	
			}
			$status=0;
			for($s=0;$s<sizeof($o_s_t);$s++)
			{
				if($o_s[$sizes_array[$s]]>$tot_com[$sizes_array[$s]])
				{
					$status=1;
				}
			}
			//Validate for splitting eligible or not.
			if($status==1)
			{
				$pending_cat_ref[]=$cat_id_ref[$ii];
				$pending_cat_order[]=$order_id_ref[$ii];
				$pending_cat_ref_type[]=$cat_type[$ii];
			}
			else
			{
				$ready_cat_ref[]=$cat_id_ref[$ii];
				$ready_cat_order[]=$order_id_ref[$ii];
				$ready_cat_ref_type[]=$cat_type[$ii];
			}	
		}
		else
		{
			//Lay Plan not Done still.
			$pend_order_ref[]=$cat_id_ref[$ii];				
			$pend_order[]=$order_id_ref[$ii];				
			$pend_order_type[]=$cat_type[$ii];				
		}
	}
	//echo sizeof($ready_cat_ref)."<br>";	
	if(sizeof($ready_cat_ref)>0) 	
	{
	    $sql2="truncate mix_temp_desti"; 
        mysql_query($sql2, $link) or exit("Sql Error".mysql_error()); 

        $sql3="truncate mix_temp_source"; 
        mysql_query($sql3, $link) or exit("Sql Error".mysql_error()); 
		for($l=0;$l<sizeof($ready_cat_ref);$l++)
		{
			$sql416="select * from plandoc_stat_log where order_tid='".$ready_cat_order[$l]."' and cat_ref='".$ready_cat_ref[$l]."' and org_doc_no=0"; 
			//echo $sql416."<br>";
			$sql_result416=mysql_query($sql416, $link) or exit("Sql Error4".mysql_error());
			if(mysql_num_rows($sql_result416)>0)
			{	
				$sql5="select tid,order_tid from cat_stat_log where order_tid='".$ready_cat_order[$l]."' and tid='".$ready_cat_ref[$l]."'";
		
				$sql_result5=mysql_query($sql5, $link) or exit("Sql Error5".mysql_error()); 
				while($sql_row=mysql_fetch_array($sql_result5)) 
				{ 
					$cat_ref=$ready_cat_ref[$l]; 
					$order_tid=$ready_cat_order[$l]; 
					$sql13="select sum(allocate_s01*plies) as cuttable_s_s01,sum(allocate_s02*plies) as cuttable_s_s02,sum(allocate_s03*plies) as cuttable_s_s03,sum(allocate_s04*plies) as cuttable_s_s04,sum(allocate_s05*plies) as cuttable_s_s05,sum(allocate_s06*plies) as cuttable_s_s06,sum(allocate_s07*plies) as cuttable_s_s07,sum(allocate_s08*plies) as cuttable_s_s08,sum(allocate_s09*plies) as cuttable_s_s09,sum(allocate_s10*plies) as cuttable_s_s10,sum(allocate_s11*plies) as cuttable_s_s11,sum(allocate_s12*plies) as cuttable_s_s12,sum(allocate_s13*plies) as cuttable_s_s13,sum(allocate_s14*plies) as cuttable_s_s14,sum(allocate_s15*plies) as cuttable_s_s15,sum(allocate_s16*plies) as cuttable_s_s16,sum(allocate_s17*plies) as cuttable_s_s17,sum(allocate_s18*plies) as cuttable_s_s18,sum(allocate_s19*plies) as cuttable_s_s19,sum(allocate_s20*plies) as cuttable_s_s20,sum(allocate_s21*plies) as cuttable_s_s21,sum(allocate_s22*plies) as cuttable_s_s22,sum(allocate_s23*plies) as cuttable_s_s23,sum(allocate_s24*plies) as cuttable_s_s24,sum(allocate_s25*plies) as cuttable_s_s25,sum(allocate_s26*plies) as cuttable_s_s26,sum(allocate_s27*plies) as cuttable_s_s27,sum(allocate_s28*plies) as cuttable_s_s28,sum(allocate_s29*plies) as cuttable_s_s29,sum(allocate_s30*plies) as cuttable_s_s30,sum(allocate_s31*plies) as cuttable_s_s31,sum(allocate_s32*plies) as cuttable_s_s32,sum(allocate_s33*plies) as cuttable_s_s33,sum(allocate_s34*plies) as cuttable_s_s34,sum(allocate_s35*plies) as cuttable_s_s35,sum(allocate_s36*plies) as cuttable_s_s36,sum(allocate_s37*plies) as cuttable_s_s37,sum(allocate_s38*plies) as cuttable_s_s38,sum(allocate_s39*plies) as cuttable_s_s39,sum(allocate_s40*plies) as cuttable_s_s40,sum(allocate_s41*plies) as cuttable_s_s41,sum(allocate_s42*plies) as cuttable_s_s42,sum(allocate_s43*plies) as cuttable_s_s43,sum(allocate_s44*plies) as cuttable_s_s44,sum(allocate_s45*plies) as cuttable_s_s45,sum(allocate_s46*plies) as cuttable_s_s46,sum(allocate_s47*plies) as cuttable_s_s47,sum(allocate_s48*plies) as cuttable_s_s48,sum(allocate_s49*plies) as cuttable_s_s49,sum(allocate_s50*plies) as cuttable_s_s50 from allocate_stat_log where order_tid=\"$order_tid\" and cat_ref='$cat_ref'";
					$c_s=array(); 			
					$sql_result13=mysql_query($sql13, $link) or exit("Sql Error13".mysql_error()); 
					while($sql_row1=mysql_fetch_array($sql_result13)) 
					{ 
						for($s=0;$s<sizeof($o_s_t);$s++)
						{
							$c_s[$sizes_array[$s]]=$sql_row1["cuttable_s_".$sizes_array[$s].""];
						}	
					}
					$ex_qty=array(); 
					$ex_s=array(); 
					//echo "Test===<br>";
					//echo sizeof($o_s_t)."<br>";
					for($s=0;$s<sizeof($o_s_t);$s++)
					{
						//echo $sizes_array[$s]."====".$ex_s[$sizes_array[$s]]."===".$c_s[$sizes_array[$s]]."==".$o_s[$sizes_array[$s]];
						$ex_s[$sizes_array[$s]]=$c_s[$sizes_array[$s]]-$o_s[$sizes_array[$s]];
					}
					
					$tot_qty=array(); 
					$sql6="select * from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=\"$cat_ref\" and remarks=\"Normal\" order by acutno";
					//echo $sql6."<br>";
					$sql_result16=mysql_query($sql6, $link) or exit("Sql Error6".mysql_error()); 
					while($sql_row1=mysql_fetch_array($sql_result16)) 
					{ 
						$doc_no=$sql_row1['doc_no']; 
						$cut_ref=$sql_row1['cuttable_ref']; 
						$mk_ref=$sql_row1['mk_ref']; 
						$p_plies=$sql_row1["p_plies"]; 
						 
						$qts=array(); 
						$qts_ex=array(); 
						$qts_ex_val=array(); 
						$qts_ex_size=array(); 
						$plies=$sql_row1['p_plies']; 
						$cutno=$sql_row1['pcutno']; 
						//echo "Excess===".$ex_s[$sizes_array[$i]]."<br>";
						for($i=0;$i<sizeof($o_s_t);$i++) 
						{ 
							$size_new_code="p_".$sizes_array[$i]; 
							if(($sql_row1[$size_new_code]*$plies)<$ex_s[$sizes_array[$i]]) 
							{ 
								$qts[$sizes_array[$i]]=0; 
								$ex_s[$sizes_array[$i]]=$ex_s[$sizes_array[$i]]-$sql_row1[$size_new_code]*$plies; 
								$qts_ex_size[$sizes_array[$i]]=$size_new_code; 
								$qts_ex_val[$sizes_array[$i]]=$sql_row1[$size_new_code]*$plies; 
							} 
							else 
							{ 
								if($ex_s[$sizes_array[$i]] > 0) 
								{ 
									$qts[$sizes_array[$i]]=($sql_row1[$size_new_code]*$plies)-$ex_s[$sizes_array[$i]]; 
									$qts_ex_val[$sizes_array[$i]]=$ex_s[$sizes_array[$i]]; 
									$qts_ex_size[$sizes_array[$i]]=$size_new_code; 
									$ex_s[$sizes_array[$i]]=0; 
								} 
								else 
								{ 
									$qts[$sizes_array[$i]]=($sql_row1[$size_new_code]*$plies); 
								} 
							} 
							 
						}
						for($ii=0;$ii<sizeof($o_s_t);$ii++) 
						{ 
							//echo $qts[$sizes_array[$ii]]."<br>";
							if($qts[$sizes_array[$ii]]>0) 
							{ 
								$sql7="insert into mix_temp_source (doc_no,cat_ref,cutt_ref,mk_ref,size,qty,plies,cutno) values ($doc_no,$cat_ref,$cut_ref,$mk_ref,\"".$sizes_array[$ii]."\",".$qts[$sizes_array[$ii]].",\"".$plies."\",\"".$cutno."\")"; 
								 mysql_query($sql7, $link) or exit("Sql Error7".mysql_error()); 
							} 
						} 
						for($kk=0;$kk<sizeof($o_s_t);$kk++) 
						{ 
							if($qts_ex_val[$sizes_array[$kk]]>0) 
							{ 
								$sql71="insert into mix_temp_source (doc_no,cat_ref,cutt_ref,mk_ref,size,qty,plies,cutno) values ($doc_no,$cat_ref,$cut_ref,$mk_ref,\"".$qts_ex_size[$sizes_array[$kk]]."\",".$qts_ex_val[$sizes_array[$kk]].",\"".$plies."\",\"".$cutno."\")"; 
								mysql_query($sql71, $link) or exit("Sql Error71".mysql_error()); 
							} 
						}
					} 
					
					for($i=0;$i<sizeof($o_s_t);$i++) 
					{ 
						$sql92="select order_tid, order_del_no, order_col_des, order_s_".$sizes_array[$i]." as ord_qty,destination,order_style_no from bai_pro3.bai_orders_db_club_confirm where order_joins=\"$orders_join\" and order_s_".$sizes_array[$i].">0 order by order_s_".$sizes_array[$i];
						//echo $sql92."<br>";
						$sql_result192=mysql_query($sql92, $link) or exit("Sql Error9".mysql_error()); 
						while($sql_row192=mysql_fetch_array($sql_result192)) 
						{								
							$order_del_no=$sql_row192['order_del_no'];
							$order_tid=$sql_row192["order_tid"];
							$order_col=$sql_row192["order_col_des"];
							$destination_id_new=$sql_row192["destination"];
							$req_qty=$sql_row192['ord_qty'];
							//$req_qty=$sql_row192['size'];
							$sql14="select * from mix_temp_source where size=\"".$sizes_array[$i]."\" and qty>0 and cat_ref='$cat_ref' group by doc_no order by doc_no*1"; 
							$sql_result114=mysql_query($sql14, $link) or exit("Sql Error".mysql_error()); 
							if(mysql_num_rows($sql_result114)>0)
							{
								while($sql_row11=mysql_fetch_array($sql_result114)) 
								{ 
									$doc_no=$sql_row11['doc_no']; 
									$cut_ref=$sql_row11['cutt_ref']; 
									$mk_ref=$sql_row11['mk_ref']; 
									$cat_ref=$sql_row11['cat_ref']; 
									$plies_ref=$sql_row11['plies']; 
									$available=$sql_row11['qty'];
									$cutno=$sql_row11['cutno'];
									if($req_qty>$available)
									{
										$update_value=0;
										if($req_qty > 0)
										{
											$sqlx3="insert into mix_temp_desti(allo_new_ref,cat_ref,cutt_ref,mk_ref,size,qty,order_tid,order_del_no,order_col_des,destination,plies,doc_no,cutno) values ($doc_no,$cat_ref,$cut_ref,$mk_ref,\"".$sizes_array[$i]."\",\"".$available."\",\"".$order_tid."\",\"".$order_del_no."\",\"".$order_col."\",\"".$destination_id_new."\",\"".$plies_ref."\",\"".$doc_no."\",\"".$cutno."\")"; 
											//echo $sqlx3."<br>";
											mysql_query($sqlx3,$link) or exit("Sql Errorx3".mysql_error());
											
											$sqlx4="update mix_temp_source set qty=$update_value where doc_no='$doc_no' and size='".$sizes_array[$i]."'";
											//echo $sqlx4."<bR>";
											mysql_query($sqlx4,$link) or exit("Sql Errorx4".mysql_error());
											$req_qty=$req_qty-$available;
										}
										
									}
									else
									{
										$update_value=$available-$req_qty;
										if($req_qty > 0)
										{
											$sqlx3="insert into mix_temp_desti(allo_new_ref,cat_ref,cutt_ref,mk_ref,size,qty,order_tid,order_del_no,order_col_des,destination,plies,doc_no,cutno) values ($doc_no,$cat_ref,$cut_ref,$mk_ref,\"".$sizes_array[$i]."\",\"".$req_qty."\",\"".$order_tid."\",\"".$order_del_no."\",\"".$order_col."\",\"".$destination_id_new."\",\"".$plies_ref."\",\"".$doc_no."\",\"".$cutno."\")";
											//echo $sqlx3."<br>";											
											mysql_query($sqlx3,$link) or exit("Sql Errorx3".mysql_error());
											$sqlx7="update mix_temp_source set qty=$update_value where doc_no='$doc_no' and size='".$sizes_array[$i]."'";
											//echo $sqlx7."<br>";
											mysql_query($sqlx7,$link) or exit("Sql Errorx7".mysql_error());
											$req_qty=0;
										}
										
									}			
								}
							}
						}
					}
					
					// Excess Pieces Segregation
					unset($colrs);
					unset($col_tot);
					unset($order_tids);
					unset($destination_id_new);
					unset($val);
					$available=0;
					$cutno=0;
					$pend=0;
					$tot_split=0;
					//$qty_fill=array();
					for($i=0;$i<sizeof($o_s_t);$i++) 
					{ 
						$sql9="select order_tid, order_del_no, order_col_des, order_s_".$sizes_array[$i]." as ord_qty,destination from bai_pro3.bai_orders_db_club_confirm where order_joins=\"$orders_join\" and order_s_".$sizes_array[$i].">0 group by order_del_no order by order_del_no limit 1";
						$sql_result19=mysql_query($sql9, $link) or exit("Sql Error9".mysql_error()); 
						$tot_col=mysql_num_rows($sql_result19);
						// $colrs=array();
						// $order_tids=array();
						// $destination_id_new=array();
						while($sql_row19=mysql_fetch_array($sql_result19)) 
						{
							$del=$sql_row19["order_del_no"];
							$colrsnew=$sql_row19["order_col_des"];
							$order_tids=$sql_row19["order_tid"];
							$destination_id_new=$sql_row19['destination'];
						}
						$sql14="select * from mix_temp_source where size=\"p_".$sizes_array[$i]."\" and qty>0 and cat_ref='$cat_ref' group by doc_no order by doc_no*1";
						//echo $sql14."<br>"; 
						//$qty_fill=array();
						$sql_result114=mysql_query($sql14, $link) or exit("Sql Error".mysql_error()); 
						if(mysql_num_rows($sql_result114)>0)
						{
							while($sql_row11=mysql_fetch_array($sql_result114)) 
							{ 
								$available=$sql_row11['qty'];
								$cutno=$sql_row11['cutno'];
								// if($available<$tot_col)
								// {
									// for($kk=1;$kk<=$available;$kk++)
									// {	
										// $val[$del[$kk]][$sizes_array[$i]]=1;
									// }
								// }
								// else
								// {
									// $pend=$available%$tot_col;
									// $tot_split=($available-$pend)/$tot_col;
									// for($kk=0;$kk<sizeof($del);$kk++)
									// {	
										// if($pend>0)
										// {
											// $val[$del[$kk]][$sizes_array[$i]]=$tot_split+$pend;
											// $pend=0;
										// }
										// else
										// {
											// $val[$del[$kk]][$sizes_array[$i]]=$tot_split;
										// }
									// }
								// }
								//$val[$del[0]][$sizes_array[$i]]=$available;								
								//$p_fill=0;
								$doc_no=$sql_row11['doc_no']; 
								$cut_ref=$sql_row11['cutt_ref']; 
								$mk_ref=$sql_row11['mk_ref']; 
								$cat_ref=$sql_row11['cat_ref']; 
								$plies_ref=$sql_row11['plies'];
								$sqlx3="insert into mix_temp_desti(allo_new_ref,cat_ref,cutt_ref,mk_ref,size,qty,order_tid,order_col_des,order_del_no,destination,plies,doc_no,cutno) values ($doc_no,$cat_ref,$cut_ref,$mk_ref,\"p_".$sizes_array[$i]."\",\"".$available."\",\"".$order_tids."\",\"".$colrsnew."\",\"".$del."\",\"".$destination_id_new."\",\"".$plies_ref."\",\"".$doc_no."\",\"".$cutno."\")"; 
								//echo $sqlx3."<br>";
								mysql_query($sqlx3, $link) or exit("Sql Errorx3".mysql_error());	
								$sqlx71="update mix_temp_source set qty='0' where doc_no='".$doc_no."' and size='p_".$sizes_array[$i]."'";
								//echo $sqlx7."<br>";
								mysql_query($sqlx71,$link) or exit("Sql Errorx7".mysql_error());								
								/*
								for($kk=0;$kk<sizeof($del);$kk++)
								{
									$sqlx3="insert into mix_temp_desti(allo_new_ref,cat_ref,cutt_ref,mk_ref,size,qty,order_tid,order_col_des,order_del_no,destination,plies,doc_no,cutno) values ($doc_no,$cat_ref,$cut_ref,$mk_ref,\"p_".$sizes_array[$i]."\",\"".$available."\",\"".$order_tids."\",\"".$colrsnew[$kk]."\",\"".$del[$kk]."\",\"".$destination_id_new[$kk]."\",\"".$plies_ref."\",\"".$doc_no."\",\"".$cutno."\")"; 
									echo $sqlx3."<br>";
									//mysql_query($sqlx3, $link) or exit("Sql Errorx3".mysql_error());	
									$sqlx71="update mix_temp_source set qty='".$available."' where doc_no='".$doc_no."' and size='p_".$sizes_array[$i]."'";
									//echo $sqlx7."<br>";
									mysql_query($sqlx71,$link) or exit("Sql Errorx7".mysql_error());
								}
								*/								
							}
						}
					}
					
				}
				
				
				$size_p=array();
				$size_q=array();
				//Executing Docket Creation & Updation
				$sql1="SELECT cutno,order_col_des,order_del_no,order_tid,doc_no,GROUP_CONCAT(size ORDER BY size) as size,GROUP_CONCAT(qty ORDER BY size) as  ratio,cat_ref,plies FROM `mix_temp_desti` where size NOT LIKE \"%p_%\" and cat_ref='".$cat_ref."' GROUP BY order_tid,doc_no order by doc_no*1"; 
				//echo $sql1."<br>";
				$sql_result1=mysql_query($sql1, $link) or exit("Sql Error111".mysql_error()); 
				while($sql_row1x=mysql_fetch_array($sql_result1)) 
				{ 
					$size_p=explode(",",$sql_row1x['size']);
					$size_q=explode(",",$sql_row1x['ratio']);
					$sqlx1="select max(doc_no)+1 as doc_n from bai_pro3.plandoc_stat_log"; 
					$sql_resultx1=mysql_query($sqlx1, $link) or exit("Sql Error".mysql_error()); 
					while($sql_rowx1=mysql_fetch_array($sql_resultx1)) 
					{ 
						$docn=$sql_rowx1["doc_n"];
					}
					if(array_sum($size_q)>0)
					{
						$sqlx351="insert into plandoc_stat_log (date,cat_ref,cuttable_ref,allocate_ref,mk_ref,order_tid,pcutno,acutno,p_plies,a_plies,destination,org_doc_no,org_plies,ratio,remarks,pcutdocid,p_s01,p_s02,p_s03,p_s04,p_s05,p_s06,p_s07,p_s08,p_s09,p_s10,p_s11,p_s12,p_s13,p_s14,p_s15,p_s16,p_s17,p_s18,p_s19,p_s20,p_s21,p_s22,p_s23,p_s24,p_s25,p_s26,p_s27,p_s28,p_s29,p_s30,p_s31,p_s32,p_s33,p_s34,p_s35,p_s36,p_s37,p_s38,p_s39,p_s40,p_s41,p_s42,p_s43,p_s44,p_s45,p_s46,p_s47,p_s48,p_s49,p_s50,doc_no) select date,cat_ref,cuttable_ref,allocate_ref,mk_ref,'".$sql_row1x['order_tid']."','".$sql_row1x['cutno']."','".$sql_row1x['cutno']."',1,1,'".$sql_row1x['destination']."','".$sql_row1x['doc_no']."','".$sql_row1x['plies']."',ratio,remarks,pcutdocid,0,0,0,0,0,0,0,0,0,0,0,0, 
						0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,$docn 
						from plandoc_stat_log where cat_ref='$cat_ref' and doc_no='".$sql_row1x['doc_no']."'";
						//echo $sqlx351."<br>";
						$sql_result351=mysql_query($sqlx351, $link) or exit("Sql Error111".mysql_error()); 
						for($j=0;$j<sizeof($size_p);$j++)
						{
							if($size_q[$j]>0)
							{
								$sql471="update bai_pro3.plandoc_stat_log set p_".$size_p[$j]."='".$size_q[$j]."' where doc_no='$docn'"; 
								//echo $sql471."<br>"; 
								$sql_result471=mysql_query($sql471, $link) or exit("Sql Error44471".mysql_error()); 
								 
								$sql4712="update bai_pro3.mix_temp_desti set qty='0' where doc_no='".$sql_row1x['doc_no']."' and size='".$size_p[$j]."' and order_tid='".$sql_row1x['order_tid']."'"; 
								//echo $sql4712."<br>"; 
								$sql_result4712=mysql_query($sql4712, $link) or exit("Sql Error444712".mysql_error()); 
							}	
						}
					}
					unset($size_p);
					unset($size_q);
				}
				
				//echo "Executing Docket Creation & Updation // Extra peices<br>";
				//Executing Docket Creation & Updation // Extra peices
				$sql16="SELECT cutno,order_col_des,order_del_no,order_tid,doc_no,GROUP_CONCAT(size ORDER BY size) as size,GROUP_CONCAT(qty ORDER BY size) as  ratio,cat_ref,plies FROM `mix_temp_desti` where size LIKE \"%p_%\" and cat_ref='".$cat_ref."' GROUP BY order_tid,doc_no order by doc_no*1"; 
				//echo $sql16."<br>";
				$sql_result16=mysql_query($sql16, $link) or exit("Sql Error111".mysql_error()); 
				while($sql_row1=mysql_fetch_array($sql_result16)) 
				{ 
					$size_p=explode(",",$sql_row1['size']);
					$size_q=explode(",",$sql_row1['ratio']);
					$sqlx1="select max(doc_no)+1 as doc_n from bai_pro3.plandoc_stat_log"; 
					$sql_resultx1=mysql_query($sqlx1, $link) or exit("Sql Error".mysql_error()); 
					while($sql_rowx1=mysql_fetch_array($sql_resultx1)) 
					{ 
						$docn=$sql_rowx1["doc_n"];
					}
					//echo $sql_row1['size']."<--->".$sql_row1['ratio']."<br>";
					if(array_sum($size_q)>0)
					{
						$sqlx351="insert into plandoc_stat_log (date,cat_ref,cuttable_ref,allocate_ref,mk_ref,order_tid,pcutno,acutno,p_plies,a_plies,destination,org_doc_no,org_plies,ratio,remarks,pcutdocid,p_s01,p_s02,p_s03,p_s04,p_s05,p_s06,p_s07,p_s08,p_s09,p_s10,p_s11,p_s12,p_s13,p_s14,p_s15,p_s16,p_s17,p_s18,p_s19,p_s20,p_s21,p_s22,p_s23,p_s24,p_s25,p_s26,p_s27,p_s28,p_s29,p_s30,p_s31,p_s32,p_s33,p_s34,p_s35,p_s36,p_s37,p_s38,p_s39,p_s40,p_s41,p_s42,p_s43,p_s44,p_s45,p_s46,p_s47,p_s48,p_s49,p_s50,doc_no) select date,cat_ref,cuttable_ref,allocate_ref,mk_ref,'".$sql_row1['order_tid']."','".$sql_row1['cutno']."','".$sql_row1['cutno']."',1,1,'".$sql_row1['destination']."','".$sql_row1['doc_no']."','".$sql_row1['plies']."',ratio,remarks,pcutdocid,0,0,0,0,0,0,0,0,0,0,0,0, 
						0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,$docn 
						from plandoc_stat_log where cat_ref='$cat_ref' and doc_no='".$sql_row1['doc_no']."'";
						//echo $sqlx351."<br>";
						$sql_result351=mysql_query($sqlx351, $link) or exit("Sql Error111".mysql_error()); 
						
						for($j=0;$j<sizeof($size_p);$j++)
						{
							if($size_q[$j]>0)
							{
								$sql471="update bai_pro3.plandoc_stat_log set ".$size_p[$j]."='".$size_q[$j]."' where doc_no='$docn'"; 
								//echo $sql471."<br>"; 
								$sql_result471=mysql_query($sql471, $link) or exit("Sql Error44471".mysql_error()); 
								 
								$sql4712="update bai_pro3.mix_temp_desti set qty='0' where doc_no='".$sql_row1['doc_no']."' and size='".$size_p[$j]."' and order_tid='".$sql_row1['order_tid']."'"; 
								//echo $sql4712."<br>"; 
								$sql_result4712=mysql_query($sql4712, $link) or exit("Sql Error444712".mysql_error()); 
							}	
						}
					}
					unset($size_p);
					unset($size_q);
				}
				
				$sqly32="update plandoc_stat_log set org_doc_no=1 where doc_no in (select doc_no from bai_pro3.mix_temp_desti where cat_ref='".$cat_ref."')"; 
				//echo $sqly32."<br/>"; 
				mysql_query($sqly32, $link) or exit("Sql Error".mysql_error()); 
				
				//Allocation Stat Log allocation
				$sql12="SELECT cutt_ref,order_del_no,order_col_des,order_tid,GROUP_CONCAT(distinct doc_no) as docs FROM `mix_temp_desti` where cat_ref='".$cat_ref."' GROUP BY order_tid order by order_tid*1"; 
				//echo $sql12."<br>";
				$sql_result1=mysql_query($sql12, $link) or exit("Sql Error111".mysql_error()); 
				while($sql_row1=mysql_fetch_array($sql_result1)) 
				{ 
					$cut_ref=$sql_row1['cutt_ref'];
					$order=$sql_row1['order_tid'];
					$docslist=$sql_row1['docs'];
					$sqla="INSERT INTO `bai_pro3`.`allocate_stat_log` (`date`, `cat_ref`, `cuttable_ref`, `order_tid`, `ratio`, `cut_count`, `pliespercut`, `allocate_xs`, `allocate_s`, `allocate_m`, `allocate_l`, `allocate_xl`, `allocate_xxl`, `allocate_xxxl`, `plies`, `lastup`, `remarks`, `mk_status`, `allocate_s01`, `allocate_s02`, `allocate_s03`, `allocate_s04`, `allocate_s05`, `allocate_s06`, `allocate_s07`, `allocate_s08`, `allocate_s09`, `allocate_s10`, `allocate_s11`, `allocate_s12`, `allocate_s13`, `allocate_s14`, `allocate_s15`, `allocate_s16`, `allocate_s17`, `allocate_s18`, `allocate_s19`, `allocate_s20`, `allocate_s21`, `allocate_s22`, `allocate_s23`, `allocate_s24`, `allocate_s25`, `allocate_s26`, `allocate_s27`, `allocate_s28`, `allocate_s29`, `allocate_s30`, `allocate_s31`, `allocate_s32`, `allocate_s33`, `allocate_s34`, `allocate_s35`, `allocate_s36`, `allocate_s37`, `allocate_s38`, `allocate_s39`, `allocate_s40`, `allocate_s41`, `allocate_s42`, `allocate_s43`, `allocate_s44`, `allocate_s45`, `allocate_s46`, `allocate_s47`, `allocate_s48`, `allocate_s49`, `allocate_s50`) VALUES ('".date("Y-m-d")."', '".$cat_ref."', '".$cut_ref."', '".$order."', '1', '0', '1', '0', '0', '0', '0', '0', '0', '0', '1', '0000-00-00 00:00:00', 'Normal', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')"; 
					//echo $sqla."<br>";	
					$sql_resulta=mysql_query($sqla, $link) or exit("Sql Error111".mysql_error());
					$allo_ref=mysql_insert_id($link);
					$sql32="select sum(p_s01) as s01,sum(p_s02) as s02,sum(p_s03) as s03,sum(p_s04) as s04,sum(p_s05) as s05,sum(p_s06) as s06,sum(p_s07) as s07,sum(p_s08) as s08,sum(p_s09) as s09,sum(p_s10) as s10,sum(p_s11) as s11,sum(p_s12) as s12,sum(p_s13) as s13,sum(p_s14) as s14,sum(p_s15) as s15,sum(p_s16) as s16,sum(p_s17) as s17,sum(p_s18) as s18,sum(p_s19) as s19,sum(p_s20) as s20,sum(p_s21) as s21,sum(p_s22) as s22,sum(p_s23) as s23,sum(p_s24) as s24,sum(p_s25) as s25,sum(p_s26) as s26,sum(p_s27) as s27,sum(p_s28) as s28,sum(p_s29) as s29,sum(p_s30) as s30,sum(p_s31) as s31,sum(p_s32) as s32,sum(p_s33) as s33,sum(p_s34) as s34,sum(p_s35) as s35,sum(p_s36) as s36,sum(p_s37) as s37,sum(p_s38) as s38,sum(p_s39) as s39,sum(p_s40) as s40,sum(p_s41) as s41,sum(p_s42) as s42,sum(p_s43) as s43,sum(p_s44) as s44,sum(p_s45) as s45,sum(p_s46) as s46,sum(p_s47) as s47,sum(p_s48) as s48,sum(p_s49) as s49,sum(p_s50) as s50 from bai_pro3.plandoc_stat_log where org_doc_no in (".$docslist.") and order_tid='".$order."'";
					$sql_resultx32=mysql_query($sql32, $link) or exit("Sql Error".mysql_error()); 
					while($sql_rowx32=mysql_fetch_array($sql_resultx32)) 
					{
						for($ik=0;$ik<sizeof($sizes_array);$ik++)
						{
							if($sql_rowx32[$sizes_array[$ik]]>0)
							{
								$sqly="update allocate_stat_log set allocate_".$sizes_array[$ik]."='".$sql_rowx32[$sizes_array[$ik]]."' where tid='".$allo_ref."'"; 
								//echo $sqly."<br/>"; 
								mysql_query($sqly, $link) or exit("Sql Error".mysql_error());
							}
						}	
					}
					$sqly="update plandoc_stat_log set allocate_ref='".$allo_ref."' where order_tid='".$order."' and org_doc_no in (".$docslist.")"; 
					//echo $sqly."<br/>"; 
					mysql_query($sqly, $link) or exit("Sql Error".mysql_error()); 
				}
				//Cat Stat log allocation	
				$sqlx65="select * from cat_stat_log where tid='$cat_ref'"; 
				//echo $sqlx65."<br>";
				$sql_resultx65=mysql_query($sqlx65, $link) or exit("Sql Error".mysql_error()); 
				while($sql_rowx=mysql_fetch_array($sql_resultx65)) 
				{ 
					$sql1="SELECT order_del_no,order_col_des,order_tid FROM `mix_temp_desti` WHERE cat_ref='".$cat_ref."' GROUP BY order_tid ORDER BY order_tid*1"; 
					$sql_result1=mysql_query($sql1, $link) or exit("Sql Error111".mysql_error()); 
					//echo $sql1."<br>";
					while($sql_row1=mysql_fetch_array($sql_result1)) 
					{ 
						$tid_new_n=str_replace($order_sch,$sql_row1["order_del_no"],$sql_rowx['order_tid2']);
						$sqlz="select * from cat_stat_log where order_tid='".$sql_row1["order_tid"]."' and order_tid2='".$tid_new_n."'";
						//echo $sqlz."<br/>";
						$sql_resultz=mysql_query($sqlz,$link) or exit("Sql Error".mysql_error());
						
						while($sql_rowz=mysql_fetch_array($sql_resultz))
						{
							$tid=$sql_rowz['tid'];
							$order_tid_sub=$sql_rowz['order_tid'];
						}
						$sqly="update allocate_stat_log set cat_ref='".$tid."' where order_tid='".$order_tid_sub."' and cat_ref='".$cat_ref."'"; 
						//echo $sqly."<br>";
						mysql_query($sqly,$link) or exit("Sql Error".mysql_error());
						
						$sqly="update plandoc_stat_log set cat_ref='$tid' where order_tid='$order_tid_sub' and cat_ref='".$cat_ref."'";
						//echo $sqly."<br/>";
						mysql_query($sqly,$link) or exit("Sql Error".mysql_error());
						
						$sqly="update cat_stat_log set category='".$sql_rowx['category']."',purwidth='".$sql_rowx['purwidth']."',gmtway='".$sql_rowx['gmtway']."',date='".$sql_rowx['date']."',lastup='".$sql_rowx['lastup']."',strip_match='".$sql_rowx['strip_match']."',gusset_sep='".$sql_rowx['gusset_sep']."',patt_ver='".$sql_rowx['patt_ver']."' where tid='$tid' and order_tid2='".$tid_new_n."'";
						//echo $sqly."<br/>";
						mysql_query($sqly,$link) or exit("Sql Error".mysql_error()); 
									   
					}
				}
				//echo sizeof($cat_id_ref)."--".(sizeof($ready_cat_ref)+sizeof($pending_cat_ref)+sizeof($pend_order_ref))."<br>";
				if(sizeof($cat_id_ref)==sizeof($ready_cat_ref))
				{				
					$sqlx="update bai_orders_db set order_joins=\"2\" where order_del_no=$order_sch and order_col_des=\"$color\""; 
					//echo $sqlx."<br>";
					mysql_query($sqlx, $link) or exit("Sql Error".mysql_error()); 
					 
					$sqlx="update bai_orders_db_confirm set order_joins=\"2\" where order_del_no=$order_sch and order_col_des=\"$color\""; 
					//echo $sqlx."<br>";
					mysql_query($sqlx, $link) or exit("Sql Error".mysql_error()); 
				}
				
				echo " <div class='alert alert-success alert-dismissible'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<strong>Success!</strong> Successfully Splitting Completed.
				</div>"; 
				//echo "<h3>Try Again Later<h3>";
				if(sizeof($pending_cat_order)>0)
				{	
					echo " <div class='alert alert-info alert-dismissible'>
					<strong>Info!</strong> Please Complete Lay Plan for order Quantity fro below.<br>";
					for($iii=0;$iii<sizeof($pending_cat_order);$iii++)
					{
						echo "Order Id ===> ".$pending_cat_order[$iii]." / Category ===> ".$pending_cat_ref_type[$iii]."<br>";
					}
					echo "</div>";
				}
				
			}
		}
	} 
	else 
	{ 		
		echo " <div class='alert alert-info alert-dismissible'><strong>Info!</strong> Please Prepare Lay Plan for below categories.<br>";
		for($iii=0;$iii<sizeof($pend_order);$iii++)
		{
			echo "Order Id ===> ".$pend_order[$iii]." / Category ===> ".$pend_order_type[$iii]."<br>";
		}
		echo "</div>";		
	} 
}
?>