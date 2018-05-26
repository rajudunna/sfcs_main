

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php 
include($_SERVER['DOCUMENT_ROOT']."/server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."/server/group_def.php"); 
$view_access=user_acl("SFCS_0092",$username,1,$group_id_sfcs);
?>
<?php
include("header_scripts.php"); 
?>

<script>

function firstbox()
{
	window.location.href ="mix_schedules.php?style="+document.test.style.value
}

function midbox()
{
	window.location.href ="mix_schedules.php?style="+document.test.style.value+"&po="+document.test.po.value
}

function secondbox()
{
	window.location.href ="mix_schedules.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&po="+document.test.po.value
}

function thirdbox()
{
	window.location.href ="mix_schedules.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&po="+document.test.po.value
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
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

<SCRIPT>

function SetAllCheckBoxes(FormName, FieldName, CheckValue)
{
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
}
</SCRIPT>
</head>

<body>

<?php include("dbconf.php"); ?>
<?php include("menu_content.php"); ?>
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

//echo $style.$schedule.$color;
?>
<div id="page_heading"><span style="float: left"><h3>Schedule Mix Panel </h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>



<form name="test" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php

echo "Select Style: <select name=\"style\" onchange=\"firstbox();\" >";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_style_no from bai_orders_db where order_style_no not in ('H18122AA       ','I292550A       ','I292553A       ','I292580A       ','I292653A       ','I296643A       ','I96632AA       ','I96646AA       ','I97183AA','IDUMY929','M04600AA       ','M04600AB       ','M04600AC','M04634AD       ','M04634AE       ','M04634AF','M04634AG','M04641AA       ','M04648AA','M04649AA','M05083AA','M06484AQ       ','M06484AR','M06485AP       ','M07562AA','M09313AE       ','M09313AG       ','M09313AH','M4600GAA       ','M4634LAA','M4634RAA','M7028AAE       ','M7028AAF','N12201AE       ','N19201AD       ','N19801AB       ','N19801AC       ','N7118SAH       ','N7118SAI       ','S16580AA       ','S174815A       ','S174815B       ','S174815C       ','S17761AA       ','S17761AB       ','S17761AC       ','S17764AA       ','S17764AB       ','S17764AC       ','S17767AA       ','S17767AB       ','S17767AC       ','S17775AA       ','S17775AB       ','S17775AC       ','S19876AA       ','S19879AA       ','S19965AA       ','U10098AJ       ','U10217AH       ','U10217AI','U20128AH       ','U20128AI','U30002AH       ','U30002AI','U30148AK       ','U30148AL','U50027AK       ','U50027AL','U60116AK       ','U60117AK       ','U60117AL','U90008AH       ','U90008AI','YCI028AA','YCI278AA','YCI404AA','YCI553AA','YCI931AA','YCL028AA','YCL278AA','YCL404AA','YCL553AA','YCL931AA','YSI028AA','YSI278AA','YSI404AA','YSI553AA','YSI931AA') order by order_style_no";		
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

echo "Select Color: <select name=\"color\" onchange=\"thirdbox();\" >";
$sql="select distinct order_col_des from bai_orders_db where order_style_no=\"$style\"";
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

echo "</select>";

	echo "<input type=\"submit\" value=\"submit\" name=\"submit\">";	
?>


</form>


</body>
</html>
<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	
	$exfact=$_POST['schedule'];
	$style_input=$_POST['style'];
	//$size=array("s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18","s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50"); 
	$size_array=array();
	$orginal_size_array=array();
	for($q=0;$q<sizeof($sizes_array);$q++)
	{
		$sql6="select order_del_no,sum(order_s_".$sizes_array[$q].") as order_qty,title_size_".$sizes_array[$q]." as size from bai_orders_db where order_style_no=\"$style\" and order_col_des=\"$color\" group by order_del_no order by order_style_no,order_del_no";
		$result6=mysql_query($sql6,$link) or die("Error3 = ".$sql6.mysql_error());
		while($row6=mysql_fetch_array($result6))
		{	
			if($row6["size"] <> '')
			{
				if(!in_array($sizes_array[$q],$size_array))
				{
					$size_array[]=$sizes_array[$q];
				}	
				if(!in_array($row6["size"],$orginal_size_array))
				{
					$orginal_size_array[]=$row6["size"];
				}
			}
		}
	}
	sort($orginal_size_array);
	sort($size_array);
	$unique_orginal_sizes=implode(",",array_unique($orginal_size_array));
	$unique_sizes=implode(",",array_unique($size_array));
	$unique_orginal_sizes_explode=explode(",",$unique_orginal_sizes);
	$unique_sizes_explode=explode(",",$unique_sizes);
	$size_type=1;
	echo '<form name="testnew" action="mix_schedules.php" method="post">';
	if(sizeof($size_array)>0)
	{
		echo "<table>";
		echo "<tr>";
		echo "<th>Select</th>";
		echo "<th>Style</th>";
		echo "<th>Schedule</th>";
		echo "<th>Color</th>";
		for($q=0;$q<sizeof($unique_orginal_sizes_explode);$q++)
		{
			echo "<th>".$unique_orginal_sizes_explode[$q]."</th>";
		}	
		echo "<th>Total</th>";
		echo "</tr>";
		$sql="select * from bai_orders_db where order_joins not in (\"1\",\"2\") and order_style_no=\"$style\" and order_col_des=\"$color\" and order_del_no>0 order by order_style_no";
		$test_count=0;
		$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			for($ii=0;$ii<sizeof($sizes_array);$ii++)
			{
				if($sql_row["title_size_".$sizes_array[$ii].""]<>'')
				{
					$o_s[]=$sql_row["order_s_".$sizes_array[$ii].""];
					$o_s_t[]=$sql_row["title_size_".$sizes_array[$ii].""];
				}
			}
			$order_total=array_sum($o_s);
			unset($o_s);
			$schedule=$sql_row['order_del_no'];
			$order_tid=$sql_row['order_tid'];
			$destination_ref=$sql_row["destination"];
			$schedule_array[]=$schedule;
			$sql4="delete FROM `orders_club_schedule` where order_del_no in (".$schedule.") and order_col_des=\"".$sql_row['order_col_des']."\"";
			$result4=mysql_query($sql4,$link) or die("Error3 = ".$sql4.mysql_error());
			$style=$sql_row['order_style_no'];
			$color=$sql_row['order_col_des'];	
			$order_joins=$sql_row['order_joins'];
			echo "<tr>";
			if($order_total>0)
			{
				$sql41="select * FROM `plandoc_stat_log` where order_tid='".$order_tid."'";
				$result41=mysql_query($sql41,$link) or die("Error3 = ".$sql4.mysql_error());
				if(mysql_num_rows($result41)==0)
				{
					if($order_joins=="0")
					{
						echo "<td><input type=\"checkbox\" name=\"sch[]\" value=\"$schedule\" checked></td>";
						$test_count=$test_count+1;
					}
					else
					{
						echo "<td>".substr($order_joins,1)."</td>";
					}
				}
				else
				{
					echo "<td>Already Planned-".substr($order_joins,1)."</td>";
				}
				
			}
			else
			{
				echo "<td></td>";
			}
			echo "<td>$style</td>";
			echo "<td>$schedule</td>";
			echo "<td>$color</td>";
			$row_ref=array();
			for($q1=0;$q1<sizeof($unique_orginal_sizes_explode);$q1++)
			{	
				$falg=0;
				$size_code_or=$unique_orginal_sizes_explode[$q1];
				for($q2=0;$q2<sizeof($unique_sizes_explode);$q2++)
				{
					
					$sql61="select sum(order_s_".$unique_sizes_explode[$q2].") as order_qty,title_size_".$unique_sizes_explode[$q2]." as size,destination from bai_orders_db where order_style_no=\"$style\" and order_col_des=\"$color\" and order_del_no=\"".$schedule."\"";	
					$result61=mysql_query($sql61,$link) or die("Error3 = ".$sql61.mysql_error());
					while($row61=mysql_fetch_array($result61))
					{	
						$size_code=$row61["size"];
						$size_code_ref_val=$unique_sizes_explode[$q2];
						$destination=$row61["destination"];
						if($size_code == $size_code_or)
						{
							echo "<td>".$row61["order_qty"]."</td>";
							$row_ref[]=$row61["order_qty"]."";
							$falg=1;
						}	
					}										
				}
				if($falg==0)
				{
					echo "<td>0</td>";
					$row_ref[]="0";
				}			
				
			}
			$sql3="insert into bai_pro3.orders_club_schedule(order_del_no,order_col_des,destination,size_code,orginal_size_code,order_qty) values(\"".$schedule."\",\"".$color."\",\"".$destination."\",\"".$unique_orginal_sizes."\",\"".$unique_sizes."\",\"".implode(",",$row_ref)."\")";
			//echo $sql3."<br>";
			mysql_query($sql3,$link) or die("Error3 = ".$sql3.mysql_error());
			echo "<td>$order_total</td>";
			echo "</tr>";
		}
		echo "</table>";	
		$sql4="SELECT DISTINCT size_code as size_code FROM `orders_club_schedule` where order_del_no in (".implode(",",$schedule_array).") ORDER BY size_code";
		$result4=mysql_query($sql4,$link) or die("Error3 = ".$sql61.mysql_error());
		while($row4=mysql_fetch_array($result4))
		{
			$size_code_ref=$row4["size_code"];
		}	
		echo '<input type="hidden" name="style" value="'.$style.'">';
		echo '<input type="hidden" name="schedule" value="'.$schedule.'">';
		echo '<input type="hidden" name="color" value="'.$color.'">';
		echo '<input type="hidden" name="exfact" value="'.$exfact.'">';
		echo '<input type="hidden" name="po" value="'.$po.'">';
		if($test_count>=1)
		{
			echo "<input type=\"submit\" value=\"confirm\" name=\"fix\"  id=\"confirm\" onclick=\"document.getElementById('confirm').style.display='none'; document.getElementById('msg1').style.display='';\"/>";
			echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait data is processing...!<h5></span>";
		}
		
		echo '</form>';
		
		echo "<br>";
		echo "<h3>Clubbed Schedule Details</h3>";
		$sql452="select * from bai_pro3.bai_orders_db_confirm where order_style_no='".$style."' and order_col_des=\"".$color."\" and order_joins in (1,2)";
		$sql_result452=mysql_query($sql452,$link) or die("Error".$sql452.mysql_error());
		if(mysql_num_rows($sql_result452)>0)
		{
			while($sql_row452=mysql_fetch_array($sql_result452))
			{
				echo "<table><tr><th>Style </th><th>Schedule No</th><th>Color</th><th> Orginal schedules</th>";
				for($kl=0;$kl<sizeof($size_array);$kl++)
				{
					if($sql_row452["title_size_".$size_array[$kl].""]<>'')
					{
						$sizes_code_tmp[]=$size_array[$kl];
						echo "<th>".$sql_row452["title_size_".$size_array[$kl].""]."</th>";
					}			
				}
				echo "</tr>";
				echo "<tr><td>".$sql_row452["order_style_no"]."</td><td>".$sql_row452["order_del_no"]."</td><td>".$sql_row452["order_col_des"]."</td>";
				$sql453="select group_concat(order_del_no)  as org_sch from bai_pro3.bai_orders_db_confirm where order_joins='J".$sql_row452["order_del_no"]."' and order_col_des=\"".$color."\"";
				$sql_result453=mysql_query($sql453,$link) or die("Error".$sql452.mysql_error());
				while($sql_row453=mysql_fetch_array($sql_result453))
				{		
					echo "<td>".$sql_row453["org_sch"]."</td>";
				}
				for($kll=0;$kll<sizeof($sizes_code_tmp);$kll++)
				{
					echo "<td>".$sql_row452["order_s_".$sizes_code_tmp[$kll].""]."</td>";
				}
				unset($sizes_code_tmp);
				echo "</tr>";
				echo "</table>";
				echo "<br>";
			}
		}
	}
	else
	{
		echo "<h3>Still Order quantity not updated</h3>";
	}
}
?>

<?php

if(isset($_POST['fix']))
{
	$selected=$_POST['sch'];
	$style=$_POST['style'];
	$new_sch=date("ymds").rand(10,99);
	$color=$_POST['color'];
	$exfact=$_POST['exfact'];
	$po=$_POST['po'];
	
	$size_array1=array();
	$orginal_size_array1=array();
	$schedule_array=array();
	
	for($q1=0;$q1<sizeof($sizes_array);$q1++)
	{
		for($x1=0;$x1<sizeof($selected);$x1++)
		{
			$sql62="select order_del_no,sum(order_s_".$sizes_array[$q1].") as order_qty,title_size_".$sizes_array[$q1]." as size from bai_orders_db where order_col_des=\"$color\" and order_del_no='".$selected[$x1]."' group by order_del_no order by order_style_no,order_del_no";
			$result62=mysql_query($sql62,$link) or die("Error3 = ".$sql62.mysql_error());
			while($row62=mysql_fetch_array($result62))
			{	
				$schedule_array[]=$selected[$x1];
				if($row62["size"] <> '')
				{
					if(!in_array($sizes_array[$q1],$size_array1))
					{
						$size_array1[]=$sizes_array[$q1];
					}	
					if(!in_array($row62["size"],$orginal_size_array1))
					{
						$orginal_size_array1[]=$row62["size"];
					}
				}
			}
		}
	}
	sort($orginal_size_array1);
	sort($size_array1);
	
	$unique_orginal_sizes1=implode(",",array_unique($orginal_size_array1));
	$unique_sizes1=implode(",",array_unique($size_array1));
	//echo $unique_orginal_sizes1."---".$unique_sizes1."<br>";
	$unique_orginal_sizes_explode1=explode(",",$unique_orginal_sizes1);
	$unique_sizes_explode1=explode(",",$unique_sizes1);

	$po_code=substr($exfact,-2);
	$sql="select distinct order_del_no from bai_orders_db where order_joins in (1,2) and order_col_des=\"$color\"";
	$sql_result=mysql_query($sql,$link) or exit("Sql Error1".mysql_error());
	$tot_ext_count=mysql_num_rows($sql_result);
	$tot_ext_count++;
	if(sizeof($selected)>=1)
	{
		/*
		$sql="select order_tid,order_style_no,order_del_no,order_col_des from bai_orders_db where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
		$sql_result=mysql_query($sql,$link) or exit("Sql Error2".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			$style=$sql_row['order_style_no'];
			$color=$sql_row['order_col_des'];
			$order_tid=$sql_row['order_tid'];
			$delivery=$sql_row['order_del_no'];
		}												
		*/
		//To find new color code 
		$sql="select max(color_code) as new_color_code from bai_orders_db where order_style_no=\"$style\" and order_col_des=\"$color\"";
		echo $sql."<bR>";
		$sql_result=mysql_query($sql,$link) or exit("Sql Error3".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			$new_color_code=($sql_row['new_color_code']);
		}
		
		$sql1="delete from bai_orders_db_club where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
		//echo $sql1."<br>";
		mysql_query($sql1,$link) or exit("Sql Error4".mysql_error());
		
		$sql1="insert ignore into bai_orders_db_club select * from bai_orders_db where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
		//echo $sql1."<br>";
		mysql_query($sql1,$link) or exit("Sql Error4".mysql_error());
		
		$sql1="insert ignore into bai_orders_db_confirm select * from bai_orders_db where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
		//echo $sql1."<br>";
		mysql_query($sql1,$link) or exit("Sql Error4".mysql_error());
		//New to eliminate issues 2012
		$sql17="SELECT order_tid,order_tid2,COUNT(*) AS cnt FROM cat_stat_log WHERE order_tid IN (SELECT order_tid FROM bai_orders_db WHERE order_del_no IN 
		('".implode("','",$selected)."') AND order_col_des='$color') GROUP BY order_tid ORDER BY cnt DESC LIMIT 1"; 
        //echo $sql17."<br>";
	    $sql_result17=mysql_query($sql17, $link) or exit("Sql Error".mysql_error()); 
        while($sql_row17=mysql_fetch_array($sql_result17)) 
        { 
			$sql="select * from cat_stat_log left join bai_orders_db on bai_orders_db.order_tid=cat_stat_log.order_tid where cat_stat_log.order_tid='".$sql_row17["order_tid"]."'";
			$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			while($sql_row=mysql_fetch_array($sql_result))
			{
				$style=$sql_row['order_style_no'];
				$color=$sql_row['order_col_des'];
				$order_tid=$sql_row['order_tid'];
				$delivery=$sql_row['order_del_no'];
				$tid=str_replace($sql_row['order_del_no'],$new_sch,$sql_row['order_tid']);
				$tid2=str_replace($sql_row['order_del_no'],$new_sch,$sql_row['order_tid2']);
				$com_no=$sql_row['compo_no'];
				$sql1="insert ignore into cat_stat_log (order_tid,order_tid2,catyy,fab_des,col_des,mo_status,compo_no) values (\"".$tid."\",\"".$tid2."\",".$sql_row['catyy'].",\"".$sql_row['fab_des']."\",\"".$sql_row['col_des']."\",\"Y\",\"$com_no\")";
				mysql_query($sql1,$link) or exit("Sql Error5".mysql_error());
			}
		}
/*		
		$sql="select * from cat_stat_log where order_tid in (select order_tid from bai_orders_db where order_style_no=\"$style\" and order_col_des=\"$color\" and order_del_no=$delivery)";
		//echo $sql."<br><br>";
		$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			//echo $tid."<br>";
			$tid=str_replace($delivery,$new_sch,$sql_row['order_tid']);
			$tid2=str_replace($delivery,$new_sch,$sql_row['order_tid2']);
			$com_no=$sql_row['compo_no'];
			$sql1="insert ignore into cat_stat_log (order_tid,order_tid2,catyy,fab_des,col_des,mo_status,compo_no) values (\"".$tid."\",\"".$tid2."\",".$sql_row['catyy'].",\"".$sql_row['fab_des']."\",\"".$sql_row['col_des']."\",\"Y\",\"$com_no\")";
			mysql_query($sql1,$link) or exit("Sql Error5".mysql_error());		
		}
*/		
		if(mysql_num_rows($sql_result)>0)
		{
			//echo $new_sch."<br>";
			$sql1="insert ignore into bai_orders_db(order_tid,order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,order_del_no,order_col_des,order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,color_code,order_joins,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no) select \"".$style.$new_sch.$color."\",order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,$new_sch,order_col_des,order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,$new_color_code,1,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no from bai_orders_db where order_tid=\"$order_tid\"";
			//echo $sql1."<br><br>";
			mysql_query($sql1,$link) or exit("Sql Error6".mysql_error());
			
			$sql1="update bai_orders_db set order_joins=\"J$new_sch\" where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
			mysql_query($sql1,$link) or exit("Sql Error7".mysql_error());
			
			//New to eliminate issues 2012
			$sql1="insert ignore into bai_orders_db_confirm(order_tid,order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,order_del_no,order_col_des,order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,color_code,order_joins,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no) select \"".$style.$new_sch.$color."\",order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,$new_sch,order_col_des,order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,$new_color_code,1,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no from bai_orders_db where order_tid=\"$order_tid\"";
			mysql_query($sql1,$link) or exit("Sql Error8".mysql_error());
			//echo "2=".$sql1."<br><br>";
			$sql1="update bai_orders_db_confirm set order_joins=\"J$new_sch\" where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
			mysql_query($sql1,$link) or exit("Sql Error9".mysql_error());
			
			for($q11=0;$q11<sizeof($unique_orginal_sizes_explode1);$q11++)
			{	
				$falg1=0;
				$size_code_or1=$unique_orginal_sizes_explode1[$q11];
				for($q21=0;$q21<sizeof($unique_sizes_explode1);$q21++)
				{
					$sql611="select sum(order_s_".$unique_sizes_explode1[$q21].") as order_qty,title_size_".$unique_sizes_explode1[$q21]." as size,
					order_del_no from bai_orders_db where order_style_no=\"$style\" and order_col_des=\"$color\" and order_del_no in (".implode(",",$selected).") group by order_del_no";	
					$result611=mysql_query($sql611,$link) or die("Error3 = ".$sql611.mysql_error());
					while($row611=mysql_fetch_array($result611))
					{	
						$size_code1=$row611["size"];
						// $sql123="update bai_orders_db_confirm set title_size_".$sizes_array[$q11]."=\"".$unique_orginal_sizes_explode1[$q11]."\",
						// title_flag=1  where order_del_no=".$row611["order_del_no"]."";
						// mysql_query($sql123,$link) or die("Error123 = ".$sql123.mysql_error());		
						if($size_code1 == $size_code_or1)
						{
							$sql12="update bai_orders_db set order_s_".$sizes_array[$q11]."=order_s_".$sizes_array[$q11]."+".$row611["order_qty"].",old_order_s_".$sizes_array[$q11]."=old_order_s_".$sizes_array[$q11]."+".$row611["order_qty"].",title_size_".$sizes_array[$q11]."=\"".$unique_orginal_sizes_explode1[$q11]."\",title_flag=1  where order_del_no=$new_sch";
							mysql_query($sql12,$link) or die("Error112 = ".$sql12.mysql_error());
							//echo "<br>S-1=".$sql12."<br>";	
							$sql121="update bai_orders_db_confirm set order_s_".$sizes_array[$q11]."=order_s_".$sizes_array[$q11]."+".$row611["order_qty"].",old_order_s_".$sizes_array[$q11]."=old_order_s_".$sizes_array[$q11]."+".$row611["order_qty"].",title_size_".$sizes_array[$q11]."=\"".$unique_orginal_sizes_explode1[$q11]."\",title_flag=1  where order_del_no=$new_sch";
						    mysql_query($sql121,$link) or die("Error112 = ".$sql121.mysql_error());
							//echo "<br>S-2=".$sql121."<br>";								
							// $sql123="update bai_orders_db_confirm set order_s_".$sizes_array[$q11]."=".$row611["order_qty"].",old_order_s_".$sizes_array[$q11]."=".$row611["order_qty"].",title_size_".$sizes_array[$q11]."=\"".$unique_orginal_sizes_explode1[$q11]."\",title_flag=1  where order_del_no=".$row611["order_del_no"]."";
							// mysql_query($sql123,$link) or die("Error123 = ".$sql123.mysql_error());							
							//echo "<br>S-3=".$sql123."<br>";
							//$falg1=1;
						}	
					}										
				}				
			}		
			
			$sql45="select * from bai_pro3.orders_club_schedule where order_del_no in (".implode(",",$selected).") and order_col_des=\"".$color."\"";
			//echo $sql45."<br>";
			$sql_result45=mysql_query($sql45,$link) or die("Error".$sql45.mysql_error());
			while($sql_row45=mysql_fetch_array($sql_result45))
			{
				$order_del_no_ref=$sql_row45["order_del_no"];
				$size_code_ref=$sql_row45["size_code"];
				$original_size_code_ref=$sql_row45["orginal_size_code"];
				$order_col_des_ref=$sql_row45["order_col_des"];
				$destination_ref=$sql_row45["destination"];
				$order_qty_ref=$sql_row45["order_qty"];
				
				$original_size_code_ref_explode=explode(",",$original_size_code_ref);
				$order_qty_ref_explode=explode(",",$order_qty_ref);
				$size_code_ref_explode=explode(",",$size_code_ref);
				
				for($i1=0;$i1<sizeof($original_size_code_ref_explode);$i1++)
				{
					//echo $original_size_code_ref_explode[$i1]."<br>";
					$sql46="update bai_pro3.bai_orders_db set order_s_".$original_size_code_ref_explode[$i1]."=".$order_qty_ref_explode[$i1].",old_order_s_".$original_size_code_ref_explode[$i1]."=".$order_qty_ref_explode[$i1].",title_size_".$original_size_code_ref_explode[$i1]."=\"".$size_code_ref_explode[$i1]."\" where order_del_no=\"".$order_del_no_ref."\" and order_col_des=\"".$order_col_des_ref."\"";
					//echo $sql46."<br>";
					mysql_query($sql46,$link) or die("Error".$sql46.mysql_error());
					
					$sql47="update bai_pro3.bai_orders_db_confirm set order_s_".$original_size_code_ref_explode[$i1]."=".$order_qty_ref_explode[$i1].",old_order_s_".$original_size_code_ref_explode[$i1]."=".$order_qty_ref_explode[$i1].",title_size_".$original_size_code_ref_explode[$i1]."=\"".$size_code_ref_explode[$i1]."\" where order_del_no=\"".$order_del_no_ref."\" and order_col_des=\"".$order_col_des_ref."\"";
					//echo $sql47."<br>";
					mysql_query($sql47,$link) or die("Error".$sql47.mysql_error());
				}
				
			}
			$sql451="insert ignore into bai_pro3.bai_orders_db_club_confirm select * from bai_pro3.bai_orders_db_confirm where order_del_no in (".implode(",",$schedule_array).") and order_col_des=\"".$color."\"";
			$sql451=mysql_query($sql451,$link) or die("Error".$sql451.mysql_error());
					
			
			echo "<h2>New Style: $style</h2>";
			echo "<h2>New Schedule: $new_sch</h2>";
			echo "<h2>New Color: $color</h2>";
			echo "<h2>Successfully Completed.</h2>";	
			
			$sql451="select * from bai_pro3.bai_orders_db_confirm where order_del_no='".$new_sch."' and order_col_des=\"".$color."\" ";
			$sql_result451=mysql_query($sql451,$link) or die("Error".$sql451.mysql_error());
			if(mysql_num_rows($sql_result451)>0)
			{
				while($sql_row451=mysql_fetch_array($sql_result451))
				{
					echo "<table><tr><th>Style </th><th>Schedule No</th><th>Color</th><th> Orginal schedules</th>";
					for($kk=0;$kk<sizeof($sizes_array);$kk++)
					{
						if($sql_row451["title_size_".$sizes_array[$kk].""]<>'')
						{
							$sizes_code_tmp[]=$sizes_array[$kk];
							echo "<th>".$sql_row451["title_size_".$sizes_array[$kk].""]."</th>";
						}			
					}
					echo "</tr>";
					echo "<tr><td>".$sql_row451["order_style_no"]."</td><td>".$sql_row451["order_del_no"]."</td><td>".$sql_row451["order_col_des"]."</td>";
					$sql457="select group_concat(order_del_no)  as org_sch from bai_pro3.bai_orders_db_confirm where order_joins='J".$new_sch."' and order_col_des=\"".$color."\"";
					$sql_result457=mysql_query($sql457,$link) or die("Error".$sql457.mysql_error());
					while($sql_row457=mysql_fetch_array($sql_result457))
					{		
						echo "<td>".$sql_row457["org_sch"]."</td>";
					}
					for($kkk=0;$kkk<sizeof($sizes_code_tmp);$kkk++)
					{
						echo "<td>".$sql_row451["order_s_".$sizes_code_tmp[$kkk].""]."</td>";
					}
					echo "</tr>";
					echo "</table>";
					echo "<br>";
				}
			}
			
		}																								
		else
		{
			echo "<h2>Please upload order status for selected schedules.</h2>";
		}
	}
	else
	{
		echo "Please select more than one schedule for clubbing.";
	}
	
}

?>