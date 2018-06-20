<?php
include("../../../../common/config/config_ajax.php");
include("../../../../common/config/config.php");

if(isset($_GET['q']))
{
$q=$_GET["q"];
$x=$_GET["x"];
$y=$_GET["y"];
$val=$_GET["val"];

//echo $sq."-".$x."-".$y."-".$val;

switch($q)
{
	case 1:
	{
		$y++;
		$return="$x$y$<select name=\"schedule[$x]\" onchange=\"showUser(2,$x,$y,this.value)\"><option value=\"\"></option>";
		$sql="select distinct order_del_no as \"schedule\" from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$val\" order by order_del_no";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$return.='<option value="'.$sql_row['schedule'].'">'.$sql_row['schedule'].'</option>';
		}
		$return.="</select>";
		echo $return;
		break;
	}
	case 2:
	{
		$y++;
		$temp=array();
		$temp=explode("$",$val);
		$return="$x$y$<select name=\"color[$x]\" onchange=\"showUser(3,$x,$y,this.value)\"><option value=\"0\">Select</option>";
		$sql="select order_col_des as \"color\",order_s_xs,order_s_s,order_s_m,order_s_l,order_s_xl,order_s_xxl,order_s_xxxl,order_s_s01,order_s_s02,order_s_s03,order_s_s04,order_s_s05,order_s_s06,order_s_s07,order_s_s08,order_s_s09,order_s_s10,order_s_s11,order_s_s12,order_s_s13,order_s_s14,order_s_s15,order_s_s16,order_s_s17,order_s_s18,order_s_s19,order_s_s20,order_s_s21,order_s_s22,order_s_s23,order_s_s24,order_s_s25,order_s_s26,order_s_s27,order_s_s28,order_s_s29,order_s_s30,order_s_s31,order_s_s32,order_s_s33,order_s_s34,order_s_s35,order_s_s36,order_s_s37,order_s_s38,order_s_s39,order_s_s40,order_s_s41,order_s_s42,order_s_s43,order_s_s44,order_s_s45,order_s_s46,order_s_s47,order_s_s48,order_s_s49,order_s_s50 from $bai_pro3.bai_orders_db_confirm where order_style_no=\"".$temp[0]."\" and order_del_no=\"".$temp[1]."\"";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$return.='<option value="'.$sql_row['color'].'">'.$sql_row['color'].'</option>';
			

		}
		$return.="</select>";
		echo $return;
		break; 
	}
	
	case 3:
	{
		$y++;
		$temp=array();
		$temp=explode("$",$val);
		$return2="$x$y$<select name=\"size[$x]\"><option value=\"0\">Select</option>";
		$sizes=array();
		$title_sizes=array();
		$sql="select order_col_des as \"color\",order_s_xs,order_s_s,order_s_m,order_s_l,order_s_xl,order_s_xxl,order_s_xxxl,order_s_s01,order_s_s02,order_s_s03,order_s_s04,order_s_s05,order_s_s06,order_s_s07,order_s_s08,order_s_s09,order_s_s10,order_s_s11,order_s_s12,order_s_s13,order_s_s14,order_s_s15,order_s_s16,order_s_s17,order_s_s18,order_s_s19,order_s_s20,order_s_s21,order_s_s22,order_s_s23,order_s_s24,order_s_s25,order_s_s26,order_s_s27,order_s_s28,order_s_s29,order_s_s30,order_s_s31,order_s_s32,order_s_s33,order_s_s34,order_s_s35,order_s_s36,order_s_s37,order_s_s38,order_s_s39,order_s_s40,order_s_s41,order_s_s42,order_s_s43,order_s_s44,order_s_s45,order_s_s46,order_s_s47,order_s_s48,order_s_s49,order_s_s50,title_size_s01,title_size_s02,title_size_s03,title_size_s04,title_size_s05,title_size_s06,title_size_s07,title_size_s08,title_size_s09,title_size_s10,title_size_s11,title_size_s12,title_size_s13,title_size_s14,title_size_s15,title_size_s16,title_size_s17,title_size_s18,title_size_s19,title_size_s20,title_size_s21,title_size_s22,title_size_s23,title_size_s24,title_size_s25,title_size_s26,title_size_s27,title_size_s28,title_size_s29,title_size_s30,title_size_s31,title_size_s32,title_size_s33,title_size_s34,title_size_s35,title_size_s36,title_size_s37,title_size_s38,title_size_s39,title_size_s40,title_size_s41,title_size_s42,title_size_s43,title_size_s44,title_size_s45,title_size_s46,title_size_s47,title_size_s48,title_size_s49,title_size_s50,title_flag from $bai_pro3.bai_orders_db_confirm where order_style_no=\"".$temp[0]."\" and order_del_no=\"".$temp[1]."\" and order_col_des=\"".$temp[2]."\"";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$size01 = $sql_row['title_size_s01'];
			$size02 = $sql_row['title_size_s02'];
			$size03 = $sql_row['title_size_s03'];
			$size04 = $sql_row['title_size_s04'];
			$size05 = $sql_row['title_size_s05'];
			$size06 = $sql_row['title_size_s06'];
			$size07 = $sql_row['title_size_s07'];
			$size08 = $sql_row['title_size_s08'];
			$size09 = $sql_row['title_size_s09'];
			$size10 = $sql_row['title_size_s10'];
			$size11 = $sql_row['title_size_s11'];
			$size12 = $sql_row['title_size_s12'];
			$size13 = $sql_row['title_size_s13'];
			$size14 = $sql_row['title_size_s14'];
			$size15 = $sql_row['title_size_s15'];
			$size16 = $sql_row['title_size_s16'];
			$size17 = $sql_row['title_size_s17'];
			$size18 = $sql_row['title_size_s18'];
			$size19 = $sql_row['title_size_s19'];
			$size20 = $sql_row['title_size_s20'];
			$size21 = $sql_row['title_size_s21'];
			$size22 = $sql_row['title_size_s22'];
			$size23 = $sql_row['title_size_s23'];
			$size24 = $sql_row['title_size_s24'];
			$size25 = $sql_row['title_size_s25'];
			$size26 = $sql_row['title_size_s26'];
			$size27 = $sql_row['title_size_s27'];
			$size28 = $sql_row['title_size_s28'];
			$size29 = $sql_row['title_size_s29'];
			$size30 = $sql_row['title_size_s30'];
			$size31 = $sql_row['title_size_s31'];
			$size32 = $sql_row['title_size_s32'];
			$size33 = $sql_row['title_size_s33'];
			$size34 = $sql_row['title_size_s34'];
			$size35 = $sql_row['title_size_s35'];
			$size36 = $sql_row['title_size_s36'];
			$size37 = $sql_row['title_size_s37'];
			$size38 = $sql_row['title_size_s38'];
			$size39 = $sql_row['title_size_s39'];
			$size40 = $sql_row['title_size_s40'];
			$size41 = $sql_row['title_size_s41'];
			$size42 = $sql_row['title_size_s42'];
			$size43 = $sql_row['title_size_s43'];
			$size44 = $sql_row['title_size_s44'];
			$size45 = $sql_row['title_size_s45'];
			$size46 = $sql_row['title_size_s46'];
			$size47 = $sql_row['title_size_s47'];
			$size48 = $sql_row['title_size_s48'];
			$size49 = $sql_row['title_size_s49'];
			$size50 = $sql_row['title_size_s50'];
			$flag = $sql_row['title_flag'];
			
			if($flag==0)
			{
			$size01 = 's01';
			$size02 = 's02';
			$size03 = 's03';
			$size04 = 's04';
			$size05 = 's05';
			$size06 = 's06';
			$size07 = 's07';
			$size08 = 's08';
			$size09 = 's09';
			$size10 = 's10';
			$size11 = 's11';
			$size12 = 's12';
			$size13 = 's13';
			$size14 = 's14';
			$size15 = 's15';
			$size16 = 's16';
			$size17 = 's17';
			$size18 = 's18';
			$size19 = 's19';
			$size20 = 's20';
			$size21 = 's21';
			$size22 = 's22';
			$size23 = 's23';
			$size24 = 's24';
			$size25 = 's25';
			$size26 = 's26';
			$size27 = 's27';
			$size28 = 's28';
			$size29 = 's29';
			$size30 = 's30';
			$size31 = 's31';
			$size32 = 's32';
			$size33 = 's33';
			$size34 = 's34';
			$size35 = 's35';
			$size36 = 's36';
			$size37 = 's37';
			$size38 = 's38';
			$size39 = 's39';
			$size40 = 's40';
			$size41 = 's41';
			$size42 = 's42';
			$size43 = 's43';
			$size44 = 's44';
			$size45 = 's45';
			$size46 = 's46';
			$size47 = 's47';
			$size48 = 's48';
			$size49 = 's49';
			$size50 = 's50';
			}
			
			$return.='<option value="'.$sql_row['color'].'">'.$sql_row['color'].'</option>';
			if($sql_row['order_s_xs']>0) { $sizes[]=str_replace("order_s_","","order_s_xs");$title_sizes[]='XS';}
			if($sql_row['order_s_s']>0) { $sizes[]=str_replace("order_s_","","order_s_s");$title_sizes[]='S';}	
			if($sql_row['order_s_m']>0) { $sizes[]=str_replace("order_s_","","order_s_m");$title_sizes[]='M';}	
			if($sql_row['order_s_l']>0) { $sizes[]=str_replace("order_s_","","order_s_l");$title_sizes[]='L';}	
			if($sql_row['order_s_xl']>0) { $sizes[]=str_replace("order_s_","","order_s_xl");$title_sizes[]='XL';}	
			if($sql_row['order_s_xxl']>0) { $sizes[]=str_replace("order_s_","","order_s_xxl");$title_sizes[]='XXL';}	
			if($sql_row['order_s_xxxl']>0) { $sizes[]=str_replace("order_s_","","order_s_xxxl");$title_sizes[]='XXXL';}	
			if($sql_row['order_s_s01']>0) { $sizes[]=str_replace("order_s_","","order_s_s01");$title_sizes[]=$size01;}
			if($sql_row['order_s_s02']>0) { $sizes[]=str_replace("order_s_","","order_s_s02");$title_sizes[]=$size02;}
			if($sql_row['order_s_s03']>0) { $sizes[]=str_replace("order_s_","","order_s_s03");$title_sizes[]=$size03;}
			if($sql_row['order_s_s04']>0) { $sizes[]=str_replace("order_s_","","order_s_s04");$title_sizes[]=$size04;}
			if($sql_row['order_s_s05']>0) { $sizes[]=str_replace("order_s_","","order_s_s05");$title_sizes[]=$size05;}
			if($sql_row['order_s_s06']>0) { $sizes[]=str_replace("order_s_","","order_s_s06");$title_sizes[]=$size06;}
			if($sql_row['order_s_s07']>0) { $sizes[]=str_replace("order_s_","","order_s_s07");$title_sizes[]=$size07;}
			if($sql_row['order_s_s08']>0) { $sizes[]=str_replace("order_s_","","order_s_s08");$title_sizes[]=$size08;}
			if($sql_row['order_s_s09']>0) { $sizes[]=str_replace("order_s_","","order_s_s09");$title_sizes[]=$size09;}
			if($sql_row['order_s_s10']>0) { $sizes[]=str_replace("order_s_","","order_s_s10");$title_sizes[]=$size10;}
			if($sql_row['order_s_s11']>0) { $sizes[]=str_replace("order_s_","","order_s_s11");$title_sizes[]=$size11;}
			if($sql_row['order_s_s12']>0) { $sizes[]=str_replace("order_s_","","order_s_s12");$title_sizes[]=$size12;}
			if($sql_row['order_s_s13']>0) { $sizes[]=str_replace("order_s_","","order_s_s13");$title_sizes[]=$size13;}
			if($sql_row['order_s_s14']>0) { $sizes[]=str_replace("order_s_","","order_s_s14");$title_sizes[]=$size14;}
			if($sql_row['order_s_s15']>0) { $sizes[]=str_replace("order_s_","","order_s_s15");$title_sizes[]=$size15;}
			if($sql_row['order_s_s16']>0) { $sizes[]=str_replace("order_s_","","order_s_s16");$title_sizes[]=$size16;}
			if($sql_row['order_s_s17']>0) { $sizes[]=str_replace("order_s_","","order_s_s17");$title_sizes[]=$size17;}
			if($sql_row['order_s_s18']>0) { $sizes[]=str_replace("order_s_","","order_s_s18");$title_sizes[]=$size18;}
			if($sql_row['order_s_s19']>0) { $sizes[]=str_replace("order_s_","","order_s_s19");$title_sizes[]=$size19;}
			if($sql_row['order_s_s20']>0) { $sizes[]=str_replace("order_s_","","order_s_s20");$title_sizes[]=$size20;}
			if($sql_row['order_s_s21']>0) { $sizes[]=str_replace("order_s_","","order_s_s21");$title_sizes[]=$size21;}
			if($sql_row['order_s_s22']>0) { $sizes[]=str_replace("order_s_","","order_s_s22");$title_sizes[]=$size22;}
			if($sql_row['order_s_s23']>0) { $sizes[]=str_replace("order_s_","","order_s_s23");$title_sizes[]=$size23;}
			if($sql_row['order_s_s24']>0) { $sizes[]=str_replace("order_s_","","order_s_s24");$title_sizes[]=$size24;}
			if($sql_row['order_s_s25']>0) { $sizes[]=str_replace("order_s_","","order_s_s25");$title_sizes[]=$size25;}
			if($sql_row['order_s_s26']>0) { $sizes[]=str_replace("order_s_","","order_s_s26");$title_sizes[]=$size26;}
			if($sql_row['order_s_s27']>0) { $sizes[]=str_replace("order_s_","","order_s_s27");$title_sizes[]=$size27;}
			if($sql_row['order_s_s28']>0) { $sizes[]=str_replace("order_s_","","order_s_s28");$title_sizes[]=$size28;}
			if($sql_row['order_s_s29']>0) { $sizes[]=str_replace("order_s_","","order_s_s29");$title_sizes[]=$size29;}
			if($sql_row['order_s_s30']>0) { $sizes[]=str_replace("order_s_","","order_s_s30");$title_sizes[]=$size30;}
			if($sql_row['order_s_s31']>0) { $sizes[]=str_replace("order_s_","","order_s_s31");$title_sizes[]=$size31;}
			if($sql_row['order_s_s32']>0) { $sizes[]=str_replace("order_s_","","order_s_s32");$title_sizes[]=$size32;}
			if($sql_row['order_s_s33']>0) { $sizes[]=str_replace("order_s_","","order_s_s33");$title_sizes[]=$size33;}
			if($sql_row['order_s_s34']>0) { $sizes[]=str_replace("order_s_","","order_s_s34");$title_sizes[]=$size34;}
			if($sql_row['order_s_s35']>0) { $sizes[]=str_replace("order_s_","","order_s_s35");$title_sizes[]=$size35;}
			if($sql_row['order_s_s36']>0) { $sizes[]=str_replace("order_s_","","order_s_s36");$title_sizes[]=$size36;}
			if($sql_row['order_s_s37']>0) { $sizes[]=str_replace("order_s_","","order_s_s37");$title_sizes[]=$size37;}
			if($sql_row['order_s_s38']>0) { $sizes[]=str_replace("order_s_","","order_s_s38");$title_sizes[]=$size38;}
			if($sql_row['order_s_s39']>0) { $sizes[]=str_replace("order_s_","","order_s_s39");$title_sizes[]=$size39;}
			if($sql_row['order_s_s40']>0) { $sizes[]=str_replace("order_s_","","order_s_s40");$title_sizes[]=$size40;}
			if($sql_row['order_s_s41']>0) { $sizes[]=str_replace("order_s_","","order_s_s41");$title_sizes[]=$size41;}
			if($sql_row['order_s_s42']>0) { $sizes[]=str_replace("order_s_","","order_s_s42");$title_sizes[]=$size42;}
			if($sql_row['order_s_s43']>0) { $sizes[]=str_replace("order_s_","","order_s_s43");$title_sizes[]=$size43;}
			if($sql_row['order_s_s44']>0) { $sizes[]=str_replace("order_s_","","order_s_s44");$title_sizes[]=$size44;}
			if($sql_row['order_s_s45']>0) { $sizes[]=str_replace("order_s_","","order_s_s45");$title_sizes[]=$size45;}
			if($sql_row['order_s_s46']>0) { $sizes[]=str_replace("order_s_","","order_s_s46");$title_sizes[]=$size46;}
			if($sql_row['order_s_s47']>0) { $sizes[]=str_replace("order_s_","","order_s_s47");$title_sizes[]=$size47;}
			if($sql_row['order_s_s48']>0) { $sizes[]=str_replace("order_s_","","order_s_s48");$title_sizes[]=$size48;}
			if($sql_row['order_s_s49']>0) { $sizes[]=str_replace("order_s_","","order_s_s49");$title_sizes[]=$size49;}
			if($sql_row['order_s_s50']>0) { $sizes[]=str_replace("order_s_","","order_s_s50");$title_sizes[]=$size50;}		
			

		}
		for($i=0;$i<sizeof($sizes);$i++)
		{
			$return2.='<option value="'.$sizes[$i].'">'.$title_sizes[$i].'</option>';
		}
		$return2.="</select>";
		echo $return2;
		break; 
	}
	
}
}

if(isset($_GET['qq']))
{
$q=$_GET["qq"];
$x=$_GET["x"];
$y=$_GET["y"];
$val=$_GET["val"];


switch($q)
{
	case 1:
	{
		$y++;
		$temp=array();
		$return="$x$y$<select id=\"color[$x]\" name=\"color[$x]\" onchange=\"showUser(3,$x,$y,this.value)\"><option value=\"\"></option>";
		$sql="select order_style_no,order_col_des as \"color\",order_s_xs,order_s_s,order_s_m,order_s_l,order_s_xl,order_s_xxl,order_s_xxxl,order_s_s01,order_s_s02,order_s_s03,order_s_s04,order_s_s05,order_s_s06,order_s_s07,order_s_s08,order_s_s09,order_s_s10,order_s_s11,order_s_s12,order_s_s13,order_s_s14,order_s_s15,order_s_s16,order_s_s17,order_s_s18,order_s_s19,order_s_s20,order_s_s21,order_s_s22,order_s_s23,order_s_s24,order_s_s25,order_s_s26,order_s_s27,order_s_s28,order_s_s29,order_s_s30,order_s_s31,order_s_s32,order_s_s33,order_s_s34,order_s_s35,order_s_s36,order_s_s37,order_s_s38,order_s_s39,order_s_s40,order_s_s41,order_s_s42,order_s_s43,order_s_s44,order_s_s45,order_s_s46,order_s_s47,order_s_s48,order_s_s49,order_s_s50 from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$val."\"";
		// echo $sql."</br>";exit;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$return.='<option value="'.$sql_row['color'].'">'.$sql_row['color'].'</option>';
			$style=$sql_row['order_style_no'];
		}
		$return.="</select>";
		$y=$y-2;
		$return.="$$x$y$<input type=\"text\" size=\"7\" id=\"style[$x]\" name=\"style[$x]\" value=\"$style\">";
		$y+=4;
		$return.="$$x$y$<select id=\"size[$x]\" name=\"size[$x]\"><option value='test'>test</option></select>";
		echo $return;
		break; 
		
		
	}
	case 2:
	{
		$y++;
		$return="$x$y$<select name=\"schedule[$x]\" onchange=\"showUser(2,$x,$y,this.value)\"><option value=\"\"></option>";
		$sql="select distinct order_del_no as \"schedule\" from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$val\" order by order_del_no";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$return.='<option value="'.$sql_row['schedule'].'">'.$sql_row['schedule'].'</option>';
		}
		$return.="</select>";
		echo $return;
		break;
	}
	
	case 3:
	{
		$y++;
		$temp=array();
		$temp=explode("$",$val);
		$return="$x$y$<select id=\"job[$x]\" name=\"job[$x]\" onchange=\"showUser(4,$x,$y,this.value)\"><option value=\"\"></option>";
		$sql="select distinct doc_no,char(color_code) as color_code,acutno from $bai_pro3.order_cat_doc_mix where order_style_no=\"".$temp[0]."\" and order_del_no=\"".$temp[1]."\" and order_col_des=\"".$temp[2]."\" and category in ('Body','Front') order by doc_no";
		// echo $temp[1].'<br>';
		// $sql="SELECT doc_no, input_job_no FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random LIKE '%$temp[1]%' GROUP BY input_job_no*1";
		// echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			// $return.='<option value="'.'D'.$sql_row['doc_no'].'">J'.$sql_row['input_job_no'].'</option>';
			$return.='<option value="'.'D'.$sql_row['doc_no'].'">'.$sql_row['color_code'].$sql_row['acutno'].'</option>';
		}
		
		$sql="select distinct doc_no,char(color_code) as color_code,acutno from $bai_pro3.order_cat_recut_doc_mix where order_style_no=\"".$temp[0]."\" and order_del_no=\"".$temp[1]."\" and order_col_des=\"".$temp[2]."\" and category in ('Body','Front') order by doc_no";
		//echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$return.='<option value="'.'R'.$sql_row['doc_no'].'">'.'RECUT'.$sql_row['acutno'].'</option>';
		}
		$return.="</select>";
		$y++;
		$return.="$$x$y$<select id=\"size[$x]\" name=\"size[$x]\"><option value=\"\"></option></select>";
		echo $return;
		break;
	}
	
	case 4:
	{
		$y++;
		$temp=array();
		$temp=explode("$",$val);
		$return2="$x$y$<select id=\"size[$x]\" name=\"size[$x]\" onchange=\"showUser(5,$x,$y,this.value)\"><option value=\"0\">Select</option>";
		$sizes=array();
		$title_sizes=array();
		if(strlen($temp[3])>0)
		{
			
		
		    $sql1="select title_size_s01,title_size_s02,title_size_s03,title_size_s04,title_size_s05,title_size_s06,title_size_s07,title_size_s08,title_size_s09,title_size_s10,title_size_s11,title_size_s12,title_size_s13,title_size_s14,title_size_s15,title_size_s16,title_size_s17,title_size_s18,title_size_s19,title_size_s20,title_size_s21,title_size_s22,title_size_s23,title_size_s24,title_size_s25,title_size_s26,title_size_s27,title_size_s28,title_size_s29,title_size_s30,title_size_s31,title_size_s32,title_size_s33,title_size_s34,title_size_s35,title_size_s36,title_size_s37,title_size_s38,title_size_s39,title_size_s40,title_size_s41,title_size_s42,title_size_s43,title_size_s44,title_size_s45,title_size_s46,title_size_s47,title_size_s48,title_size_s49,title_size_s50,title_flag from bai_orders_db_confirm where order_tid in (select order_tid from $bai_pro3.plandoc_stat_log where doc_no=\"".substr($temp[3],1,10)."\")";
			//echo $sql1."</br>";exit;
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result1))
			{
				$size01 = $sql_row['title_size_s01'];
				$size02 = $sql_row['title_size_s02'];
				$size03 = $sql_row['title_size_s03'];
				$size04 = $sql_row['title_size_s04'];
				$size05 = $sql_row['title_size_s05'];
				$size06 = $sql_row['title_size_s06'];
				$size07 = $sql_row['title_size_s07'];
				$size08 = $sql_row['title_size_s08'];
				$size09 = $sql_row['title_size_s09'];
				$size10 = $sql_row['title_size_s10'];
				$size11 = $sql_row['title_size_s11'];
				$size12 = $sql_row['title_size_s12'];
				$size13 = $sql_row['title_size_s13'];
				$size14 = $sql_row['title_size_s14'];
				$size15 = $sql_row['title_size_s15'];
				$size16 = $sql_row['title_size_s16'];
				$size17 = $sql_row['title_size_s17'];
				$size18 = $sql_row['title_size_s18'];
				$size19 = $sql_row['title_size_s19'];
				$size20 = $sql_row['title_size_s20'];
				$size21 = $sql_row['title_size_s21'];
				$size22 = $sql_row['title_size_s22'];
				$size23 = $sql_row['title_size_s23'];
				$size24 = $sql_row['title_size_s24'];
				$size25 = $sql_row['title_size_s25'];
				$size26 = $sql_row['title_size_s26'];
				$size27 = $sql_row['title_size_s27'];
				$size28 = $sql_row['title_size_s28'];
				$size29 = $sql_row['title_size_s29'];
				$size30 = $sql_row['title_size_s30'];
				$size31 = $sql_row['title_size_s31'];
				$size32 = $sql_row['title_size_s32'];
				$size33 = $sql_row['title_size_s33'];
				$size34 = $sql_row['title_size_s34'];
				$size35 = $sql_row['title_size_s35'];
				$size36 = $sql_row['title_size_s36'];
				$size37 = $sql_row['title_size_s37'];
				$size38 = $sql_row['title_size_s38'];
				$size39 = $sql_row['title_size_s39'];
				$size40 = $sql_row['title_size_s40'];
				$size41 = $sql_row['title_size_s41'];
				$size42 = $sql_row['title_size_s42'];
				$size43 = $sql_row['title_size_s43'];
				$size44 = $sql_row['title_size_s44'];
				$size45 = $sql_row['title_size_s45'];
				$size46 = $sql_row['title_size_s46'];
				$size47 = $sql_row['title_size_s47'];
				$size48 = $sql_row['title_size_s48'];
				$size49 = $sql_row['title_size_s49'];
				$size50 = $sql_row['title_size_s50'];
				
			}
			$sql="select order_tid,p_xs,p_s,p_m,p_l,p_xl,p_xxl,p_xxxl,p_s01,p_s02,p_s03,p_s04,p_s05,p_s06,p_s07,p_s08,p_s09,p_s10,p_s11,p_s12,p_s13,p_s14,p_s15,p_s16,p_s17,p_s18,p_s19,p_s20,p_s21,p_s22,p_s23,p_s24,p_s25,p_s26,p_s27,p_s28,p_s29,p_s30,p_s31,p_s32,p_s33,p_s34,p_s35,p_s36,p_s37,p_s38,p_s39,p_s40,p_s41,p_s42,p_s43,p_s44,p_s45,p_s46,p_s47,p_s48,p_s49,p_s50 from $bai_pro3.plandoc_stat_log where doc_no=\"".substr($temp[3],1,10)."\"";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				if($sql_row['p_xs']>0) { $sizes[]=str_replace("p_","","p_xs");$title_sizes[]='XS';}
				if($sql_row['p_s']>0) { $sizes[]=str_replace("p_","","p_s");$title_sizes[]='S';}	
				if($sql_row['p_m']>0) { $sizes[]=str_replace("p_","","p_m");$title_sizes[]='M';}	
				if($sql_row['p_l']>0) { $sizes[]=str_replace("p_","","p_l");$title_sizes[]='L';}	
				if($sql_row['p_xl']>0) { $sizes[]=str_replace("p_","","p_xl");$title_sizes[]='XL';}	
				if($sql_row['p_xxl']>0) { $sizes[]=str_replace("p_","","p_xxl");$title_sizes[]='XXL';}	
				if($sql_row['p_xxxl']>0) { $sizes[]=str_replace("p_","","p_xxxl");$title_sizes[]='XXXL';}
				if($sql_row['p_s01']>0) { $sizes[]=str_replace("p_","","p_s01");$title_sizes[]=$size01;}
				if($sql_row['p_s02']>0) { $sizes[]=str_replace("p_","","p_s02");$title_sizes[]=$size02;}
				if($sql_row['p_s03']>0) { $sizes[]=str_replace("p_","","p_s03");$title_sizes[]=$size03;}
				if($sql_row['p_s04']>0) { $sizes[]=str_replace("p_","","p_s04");$title_sizes[]=$size04;}
				if($sql_row['p_s05']>0) { $sizes[]=str_replace("p_","","p_s05");$title_sizes[]=$size05;}
				if($sql_row['p_s06']>0) { $sizes[]=str_replace("p_","","p_s06");$title_sizes[]=$size06;}
				if($sql_row['p_s07']>0) { $sizes[]=str_replace("p_","","p_s07");$title_sizes[]=$size07;}
				if($sql_row['p_s08']>0) { $sizes[]=str_replace("p_","","p_s08");$title_sizes[]=$size08;}
				if($sql_row['p_s09']>0) { $sizes[]=str_replace("p_","","p_s09");$title_sizes[]=$size09;}
				if($sql_row['p_s10']>0) { $sizes[]=str_replace("p_","","p_s10");$title_sizes[]=$size10;}
				if($sql_row['p_s11']>0) { $sizes[]=str_replace("p_","","p_s11");$title_sizes[]=$size11;}
				if($sql_row['p_s12']>0) { $sizes[]=str_replace("p_","","p_s12");$title_sizes[]=$size12;}
				if($sql_row['p_s13']>0) { $sizes[]=str_replace("p_","","p_s13");$title_sizes[]=$size13;}
				if($sql_row['p_s14']>0) { $sizes[]=str_replace("p_","","p_s14");$title_sizes[]=$size14;}
				if($sql_row['p_s15']>0) { $sizes[]=str_replace("p_","","p_s15");$title_sizes[]=$size15;}
				if($sql_row['p_s16']>0) { $sizes[]=str_replace("p_","","p_s16");$title_sizes[]=$size16;}
				if($sql_row['p_s17']>0) { $sizes[]=str_replace("p_","","p_s17");$title_sizes[]=$size17;}
				if($sql_row['p_s18']>0) { $sizes[]=str_replace("p_","","p_s18");$title_sizes[]=$size18;}
				if($sql_row['p_s19']>0) { $sizes[]=str_replace("p_","","p_s19");$title_sizes[]=$size19;}
				if($sql_row['p_s20']>0) { $sizes[]=str_replace("p_","","p_s20");$title_sizes[]=$size20;}
				if($sql_row['p_s21']>0) { $sizes[]=str_replace("p_","","p_s21");$title_sizes[]=$size21;}
				if($sql_row['p_s22']>0) { $sizes[]=str_replace("p_","","p_s22");$title_sizes[]=$size22;}
				if($sql_row['p_s23']>0) { $sizes[]=str_replace("p_","","p_s23");$title_sizes[]=$size23;}
				if($sql_row['p_s24']>0) { $sizes[]=str_replace("p_","","p_s24");$title_sizes[]=$size24;}
				if($sql_row['p_s25']>0) { $sizes[]=str_replace("p_","","p_s25");$title_sizes[]=$size25;}
				if($sql_row['p_s26']>0) { $sizes[]=str_replace("p_","","p_s26");$title_sizes[]=$size26;}
				if($sql_row['p_s27']>0) { $sizes[]=str_replace("p_","","p_s27");$title_sizes[]=$size27;}
				if($sql_row['p_s28']>0) { $sizes[]=str_replace("p_","","p_s28");$title_sizes[]=$size28;}
				if($sql_row['p_s29']>0) { $sizes[]=str_replace("p_","","p_s29");$title_sizes[]=$size29;}
				if($sql_row['p_s30']>0) { $sizes[]=str_replace("p_","","p_s30");$title_sizes[]=$size30;}
				if($sql_row['p_s31']>0) { $sizes[]=str_replace("p_","","p_s31");$title_sizes[]=$size31;}
				if($sql_row['p_s32']>0) { $sizes[]=str_replace("p_","","p_s32");$title_sizes[]=$size32;}
				if($sql_row['p_s33']>0) { $sizes[]=str_replace("p_","","p_s33");$title_sizes[]=$size33;}
				if($sql_row['p_s34']>0) { $sizes[]=str_replace("p_","","p_s34");$title_sizes[]=$size34;}
				if($sql_row['p_s35']>0) { $sizes[]=str_replace("p_","","p_s35");$title_sizes[]=$size35;}
				if($sql_row['p_s36']>0) { $sizes[]=str_replace("p_","","p_s36");$title_sizes[]=$size36;}
				if($sql_row['p_s37']>0) { $sizes[]=str_replace("p_","","p_s37");$title_sizes[]=$size37;}
				if($sql_row['p_s38']>0) { $sizes[]=str_replace("p_","","p_s38");$title_sizes[]=$size38;}
				if($sql_row['p_s39']>0) { $sizes[]=str_replace("p_","","p_s39");$title_sizes[]=$size39;}
				if($sql_row['p_s40']>0) { $sizes[]=str_replace("p_","","p_s40");$title_sizes[]=$size40;}
				if($sql_row['p_s41']>0) { $sizes[]=str_replace("p_","","p_s41");$title_sizes[]=$size41;}
				if($sql_row['p_s42']>0) { $sizes[]=str_replace("p_","","p_s42");$title_sizes[]=$size42;}
				if($sql_row['p_s43']>0) { $sizes[]=str_replace("p_","","p_s43");$title_sizes[]=$size43;}
				if($sql_row['p_s44']>0) { $sizes[]=str_replace("p_","","p_s44");$title_sizes[]=$size44;}
				if($sql_row['p_s45']>0) { $sizes[]=str_replace("p_","","p_s45");$title_sizes[]=$size45;}
				if($sql_row['p_s46']>0) { $sizes[]=str_replace("p_","","p_s46");$title_sizes[]=$size46;}
				if($sql_row['p_s47']>0) { $sizes[]=str_replace("p_","","p_s47");$title_sizes[]=$size47;}
				if($sql_row['p_s48']>0) { $sizes[]=str_replace("p_","","p_s48");$title_sizes[]=$size48;}
				if($sql_row['p_s49']>0) { $sizes[]=str_replace("p_","","p_s49");$title_sizes[]=$size49;}
				if($sql_row['p_s50']>0) { $sizes[]=str_replace("p_","","p_s50");$title_sizes[]=$size50;}
				
			}
			
			for($i=0;$i<sizeof($sizes);$i++)
			{
				$return2.='<option value="'.$sizes[$i].'">'.$title_sizes[$i].'</option>';
			}
		}		
		$return2.="</select>";
		
		echo $return2;
		break; 
	}
	
	//Case 5 added to fetch the module numbers based on job number and size
	case 5:
	{
		$y++;
		$temp=array();
		$temp=explode("$",$val);
	//	$return2="$x$y$<select id=\"mods[$x]\" name=\"mods[$x]\" onchange=\"showUser(6,$x,$y,this.value)\"><option value=\"0\">Select</option>";
		$return2="$x$y$<select id=\"mods[$x]\" name=\"mods[$x]\" ><option value=\"0\">Select</option>";
		$sizes=array();
		if(strlen($temp[3])>0)
		{	
			
			// $modules[]=array();
			//changed code for sizes; changed table name bai_orders_db to bai_orders_db_confirm
			// $sql1="select distinct ims_mod_no as modsno from $bai_pro3.ims_log where ims_style=\"".$temp[0]."\" and ims_schedule=\"".$temp[1]."\" and ims_color=\"".$temp[2]."\" AND ims_doc_no=\"".substr($temp[3],1,10)."\" and ims_size=\"a_".$temp[4]."\" and ims_mod_no>0 order by ims_mod_no";
			// $return2.="<option value=\"\">".$sql1."</option>";
			// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			// if(mysqli_num_rows($sql_result1)>0)
			// {
				// while($sql_row1=mysqli_fetch_array($sql_result1))
				// {
					// $return2.='<option value="'.$sql_row1['modsno'].'">'.$sql_row1['modsno'].'</option>';
				// }
				// $modules[]=$sql_row1['modsno'];
			// }
			
			// $sql12="select distinct ims_mod_no as modsno from $bai_pro3.ims_log_backup where ims_style=\"".$temp[0]."\" and ims_schedule=\"".$temp[1]."\" and ims_color=\"".$temp[2]."\" AND ims_doc_no=\"".substr($temp[3],1,10)."\" and ims_size=\"a_".$temp[4]."\" and ims_mod_no>0 order by ims_mod_no";
			// echo $sql12."<br>";
			// $sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			// if(mysqli_num_rows($sql_result12)>0)
			// {
				// while($sql_row12=mysqli_fetch_array($sql_result12))
				// {
					// if(in_array($sql_row12['modsno'],$modules))
					// {
					
					// }
					// else
					// {
						// $return2.='<option value="'.$sql_row12['modsno'].'">'.$sql_row12['modsno'].'</option>';
					// }
				// }
			// }
			
		}	
		//$return2.='<option value="1">1</option>';
		$return2.='<option value="CUT">CUT</option>';
		//$return2.='<option value="ENP">E/P</option>';
		//$return2.='<option value="Pack">Pack</option>';
		// $return2.='<option value="FG">CPK</option>';
		$return2.="</select>";
		echo $return2;
		break; 
	}
	//Case 5 added to fetch the module numbers based on job number and size
	case 6:
	{
		$y++;
		$temp=array();
		$temp=explode("$",$val);
		
		//$return2="$x$y$<select id=\"mods[$x]\" name=\"mods[$x]\" onchange=\"showUser(6,$x,$y,this.value)\"><option value=\"0\">Select</option>";
		$sizes=array();
		if(strlen($temp[6])>0)
		{	
			$sql="select * from brandix_bts.tbl_orders_size_ref where size_name='".$temp[4]."'";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$ref_size=$sql_row['id'];
			}
			$bundle=array();
			$sql="select * from brandix_bts.tbl_miniorder_data where docket_number='".substr($temp[3],1,10)."' and size='".$ref_size."' and color='".$temp[2]."'";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error--2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$bundle[]=$sql_row['bundle_number'];
			}
			$module_nos=$temp[5]."-";
			$sql1="select sum(qms_qty) as rejects_qty from bai_pro3.bai_qms_db where qms_tran_type='3' and qms_schedule='".$temp[1]."' and qms_color='".$temp[2]."' and doc_no='".$temp[3]."' and qms_size='".$temp[4]."' AND remarks LIKE \"%".$module_nos."%\"";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error--2".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result1)>0)
			{
				while($sql_row11=mysqli_fetch_array($sql_result1))
				{
					$ext_reject=$sql_row11['rejects_qty'];
					//echo $sql_row11['rejects_qty']."-<br>";
				}
			}
			else
			{
				$ext_reject=0;
			}
			//echo $ext_reject."<br>";
			$var1=substr($temp[6],0);
			//echo $var1."<br>";
			if($var1=='P')
			{
				$sql="select sum(bundle_transactions_20_repeat_rejection_quantity) as reject_qty from brandix_bts.view_set_1 where bundle_transactions_module_id='".$temp[5]."' and bundle_transactions_20_repeat_operation_id<>4 and  bundle_transactions_20_repeat_bundle_id in (".implode(",",$bundle).")";
			}
			else
			{
				$sql="select sum(rejection_quantity) as reject_qty from brandix_bts.bundle_transactions_20_repeat where act_module='".$temp[5]."' and operation_id=4 and  bundle_id in (".implode(",",$bundle).")";
			}
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error--3".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result)>0)
			{
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$reject_qty=$sql_row['reject_qty']-$ext_reject;
				}
			}
			else
			{
				$reject_qty=0;
			}
			//echo $reject_qty."<br>";
		}
		else
		{
			$reject_qty=0;
		}
		$code=$x."6";
		$return2="$code$<input type=\"text\" id=\"qty[$x]\" style=\"border-style:none;\" name=\"qty[$x]\" size=\"5\" value=\"$reject_qty\" onchange=\"disp($x)\">";		
		//$return2.='<option value="reject">'.$reject_qty.'</option>';
		//$return2.='<option value="CUT">Cut</option>';
		//$return2.='<option value="ENP">E/P</option>';
		//$return2.='<option value="Pack">Pack</option>';
		//$return2.='<option value="FG">FG</option>';
		//$return2.="</select>";
		echo $return2;
		break; 
	}
}
}

/*
if(isset($_GET['qq']))
{
$q=$_GET["qq"];
$x=$_GET["x"];
$y=$_GET["y"];
$val=$_GET["val"];


switch($q)
{
	case 1:
	{
		$y++;
		$return="$x$y$<select name=schedule[$x] onchange=\"showUser(2,$x,$y,this.value)\"><option value=\"\"></option>";
		$sql="select order_del_no as \"schedule\" from bai_orders_db where order_style_no=\"$val\" order by ";
		$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			$return.='<option value="'.$sql_row['schedule'].'">'.$sql_row['schedule'].'</option>';
		}
		$return.="</select>";
		echo $return;
		break;
	}
	case 2:
	{
		$y++;
		$temp=array();
		$temp=explode("$",$val);
		$return="$x$y$<select name=color[$x] onchange=\"showUser(3,$x,$y,this.value)\"><option value=\"\"></option>";
		$sql="select color,order_s_xs,order_s_s,order_s_m,order_s_l,order_s_xl,order_s_xxl,order_s_xxxl,order_s_s06,order_s_s08,order_s_s10,order_s_s12,order_s_s14,order_s_s16,order_s_s18,order_s_s20,order_s_s22,order_s_s24,order_s_s26,order_s_s28,order_s_s30 from style_db where style=\"".$temp[0]."\" and schedule=\"".$temp[1]."\"";
		$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			$return.='<option value="'.$sql_row['color'].'">'.$sql_row['color'].'</option>';
			

		}
		$return.="</select>";
		echo $return;
		break; 
	}
	
	case 3:
	{
		$y++;
		$temp=array();
		$temp=explode("$",$val);
		$return2="$x$y$<select name=\"size[$x]\"><option value=\"\"></option>";
		$sizes=array();
		$qty=array();
		$sql="select color,order_s_xs,order_s_s,order_s_m,order_s_l,order_s_xl,order_s_xxl,order_s_xxxl,order_s_s06,order_s_s08,order_s_s10,order_s_s12,order_s_s14,order_s_s16,order_s_s18,order_s_s20,order_s_s22,order_s_s24,order_s_s26,order_s_s28,order_s_s30 from style_db where style=\"".$temp[0]."\" and schedule=\"".$temp[1]."\" and color=\"".$temp[2]."\"";
		$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
		{
			$return.='<option value="'.$sql_row['color'].'">'.$sql_row['color'].'</option>';
			if($sql_row['order_s_xs']>0) { $qty[]=$sql_row['order_s_xs']; $sizes[]=str_replace("order_s_","","order_s_xs");}
			if($sql_row['order_s_s']>0) { $qty[]=$sql_row['order_s_s'];  $sizes[]=str_replace("order_s_","","order_s_s");}	
			if($sql_row['order_s_m']>0) {  $qty[]=$sql_row['order_s_m']; $sizes[]=str_replace("order_s_","","order_s_m");}	
			if($sql_row['order_s_l']>0) {  $qty[]=$sql_row['order_s_l']; $sizes[]=str_replace("order_s_","","order_s_l");}	
			if($sql_row['order_s_xl']>0) {  $qty[]=$sql_row['order_s_xl']; $sizes[]=str_replace("order_s_","","order_s_xl");}	
			if($sql_row['order_s_xxl']>0) {  $qty[]=$sql_row['order_s_xxl']; $sizes[]=str_replace("order_s_","","order_s_xxl");}	
			if($sql_row['order_s_xxxl']>0) {  $qty[]=$sql_row['order_s_xxxl']; $sizes[]=str_replace("order_s_","","order_s_xxxl");}	
			if($sql_row['order_s_s06']>0) {  $qty[]=$sql_row['order_s_s06']; $sizes[]=str_replace("order_s_","","order_s_s06");}	
			if($sql_row['order_s_s08']>0) { $qty[]=$sql_row['order_s_s08']; $sizes[]=str_replace("order_s_","","order_s_s08");}	
			if($sql_row['order_s_s10']>0) { $qty[]=$sql_row['order_s_s10']; $sizes[]=str_replace("order_s_","","order_s_s10");}	
			if($sql_row['order_s_s12']>0) { $qty[]=$sql_row['order_s_s12']; $sizes[]=str_replace("order_s_","","order_s_s12");}	
			if($sql_row['order_s_s14']>0) { $qty[]=$sql_row['order_s_s14']; $sizes[]=str_replace("order_s_","","order_s_s14");}	
			if($sql_row['order_s_s16']>0) { $qty[]=$sql_row['order_s_s16']; $sizes[]=str_replace("order_s_","","order_s_s16");}	
			if($sql_row['order_s_s18']>0) { $qty[]=$sql_row['order_s_s18']; $sizes[]=str_replace("order_s_","","order_s_s18");}	
			if($sql_row['order_s_s20']>0) { $qty[]=$sql_row['order_s_s20']; $sizes[]=str_replace("order_s_","","order_s_s20");}	
			if($sql_row['order_s_s22']>0) { $qty[]=$sql_row['order_s_s22']; $sizes[]=str_replace("order_s_","","order_s_s22");}	
			if($sql_row['order_s_s24']>0) { $qty[]=$sql_row['order_s_s24']; $sizes[]=str_replace("order_s_","","order_s_s24");}	
			if($sql_row['order_s_s26']>0) { $qty[]=$sql_row['order_s_s26']; $sizes[]=str_replace("order_s_","","order_s_s26");}	
			if($sql_row['order_s_s28']>0) { $qty[]=$sql_row['order_s_s28']; $sizes[]=str_replace("order_s_","","order_s_s28");}	
			if($sql_row['order_s_s30']>0) { $qty[]=$sql_row['order_s_s30']; $sizes[]=str_replace("order_s_","","order_s_s30");}

		}
		for($i=0;$i<sizeof($sizes);$i++)
		{
			$return2.='<option value="'.$sizes[$i].'">'.$sizes[$i].'</option>';
		}
		$return2.="</select>";
		echo $return2;
		break; 
	}
	
}
}
*/

?> 