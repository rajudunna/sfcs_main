<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<?php
$global_path = getFullURLLevel($_GET['r'],'',4,'R');
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'bundle_tag_code.php',0,'R'));

// include("dbconf.php");
// include("bundle_tag_code.php");
$style=$style;
$schedule=$schedule;
$color=$color;
$date=date('Y-m-d');
//echo "Test"."<br>";

if(isset($_GET['doc_no']))
{
	$col_code=$_GET['col_code'];
	$doc_no=$_GET['doc_no'];
	?>
	<div class="panel panel-primary">
	<div class="panel-heading"></div>
	<div class="panel-body">
	<form action="?r=<?php echo $_GET['r']; ?>" method="post">
	<div class='form-group col-lg-3'>
		<label>Graphic No</label>
		<Input class='form-control' type="text" name="graphic" value="">
	</div>
	<!-- Graphic No -->
	<Input type="hidden" name="doc_no" value="<?php echo $doc_no;?>">
	<Input type="hidden" name="col_code" value="<?php echo $col_code;?>">
	<div class='form-group col-lg-3'>
		<Input class='btn btn-primary' style='margin-top: 20px' type="submit" name="print" value="Print">
	</div>
	<?php


	?>
	</form>
	</div>
	</div>
	<?php
}
$sizes=array('06','08','10','12','14','16','18','20','22','24','26','28','30');
$ii=3;$total_tic=0;$sizes_tit=array();$sizes_rat=array();
if(isset($_POST['print']))
{
	$doc_no=$_POST['doc_no'];
	$col_code=$_POST['col_code'];
	$graphic=$_POST['graphic'];
	
	
	$sql="select * from $bai_pro3.plandoc_stat_log where doc_no=\"$doc_no\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$cutno=$sql_row['acutno'];
		$order_tid=$sql_row['order_tid'];
		$cut_code=chr($col_code).leading_zeros($cutno,3);
		$cut_pcs=$sql_row['a_plies'];
		$cnt=1;
		$next=$cut_pcs;
		for($i=0;$i<sizeof($sizes);$i++)
		{
			if($sql_row['a_s'.$sizes[$i]]>0)
			{
				$sizes_rat[$sizes[$i]]=$sql_row['a_s'.$sizes[$i]];
			}
		}
		$total_tic=round(round($sql_row['a_s06']+$sql_row['a_s08']+$sql_row['a_s10']+$sql_row['a_s12']+$sql_row['a_s14']+$sql_row['a_s16']+$sql_row['a_s18']+$sql_row['a_s20']+$sql_row['a_s22']+$sql_row['a_s24']+$sql_row['a_s26']+$sql_row['a_s28']+$sql_row['a_s30']/$cut_pcs))/$ii;
		//echo $total_tic."<br>";
	}
	$sql1="select * from bai_pro3.bai_orders_db where order_tid =\"$order_tid\"";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		for($i=0;$i<sizeof($sizes);$i++)
		{
			if($sql_row1['title_size_s'.$sizes[$i]]!='')
			{
				$sizes_tit[$sizes[$i]]=$sql_row1['title_size_s'.$sizes[$i]];
			}
						
		}
	}
	$kk=1;$size_code=array();
	for($i=0;$i<sizeof($sizes_tit);$i++)
	{
		
		for($k=0;$k<$sizes_rat[$sizes[$i]];$k++)
		{
			$size_code[$kk]=$sizes_tit[$sizes[$i]]."-".$kk;
			//echo $size_code[$ii]."<br>";
			$kk++;
		}
	}	
	//echo sizeof($sizes_rat)."<br>";
	//echo sizeof($sizes_tit)."<br>";
	$date=date('Y-m-d');
	$shade=echo_title("bai_rm_pj1.docket_ref","group_concat(distinct ref4)","doc_no",$doc_no,$link);
 
?>
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 15">
<link rel=File-List href="bundle_tags_files/filelist.xml">
<style id="mini_23964_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl1523964
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6323964
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6423964
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6523964
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6623964
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6723964
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#8EA9DB;
	mso-pattern:black none;
	white-space:nowrap;}
.xl6823964
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#8EA9DB;
	mso-pattern:black none;
	white-space:nowrap;}
.xl6923964
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#8EA9DB;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7023964
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7123964
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7223964
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
-->
body{
	zoom:100%;
}

</style>

<style type="text/css">
@page
{
	size: landscape;
	margin: 0cm;
}
</style>

<style>

@media print {
@page narrow {size: 9in 11in}
@page rotated {size: landscape}
DIV {page: narrow}
TABLE {page: rotated}
#non-printable { display: none; }
#printable { display: block; }
#logo { display: block; }
body { zoom:100%;}
#ad{ display:none;}
#leftbar{ display:none;}
#CUT_PLAN_NEW_13019{ width:57%; margin-left:20px;}
}
</style>

<script>
function printpr()
{
var OLECMDID = 7;
/* OLECMDID values:
* 6 - print
* 7 - print preview
* 1 - open window
* 4 - Save As
*/
var PROMPT = 1; // 2 DONTPROMPTUSER
var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
WebBrowser1.ExecWB(OLECMDID, PROMPT);
WebBrowser1.outerHTML = "";
}
</script>
</head>
</head>

<body onload="printpr();">
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="mini_23964" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=869 style='border-collapse:
 collapse;table-layout:fixed;width:653pt'>
 <col width=25 style='mso-width-source:userset;mso-width-alt:914;width:19pt'>
 <col width=64 span=2 style='width:48pt'>
 <col width=77 style='mso-width-source:userset;mso-width-alt:2816;width:58pt'>
 <col width=64 style='width:48pt'>
 <col width=6 style='mso-width-source:userset;mso-width-alt:219;width:5pt'>
 <col width=64 span=2 style='width:48pt'>
 <col width=79 style='mso-width-source:userset;mso-width-alt:2889;width:59pt'>
 <col width=64 style='width:48pt'>
 <col width=5 style='mso-width-source:userset;mso-width-alt:182;width:4pt'>
 <col width=64 span=2 style='width:48pt'>
 <col width=75 style='mso-width-source:userset;mso-width-alt:2742;width:56pt'>
 <col width=64 style='width:48pt'>
 <col width=26 style='mso-width-source:userset;mso-width-alt:950;width:20pt'>
 <tr height=25 style='mso-height-source:userset;height:18.75pt'>
  <td height=25 class=xl6323964 width=25 style='height:18.75pt;width:19pt'></td>
  <td class=xl6323964 width=64 style='width:48pt'></td>
  <td class=xl6323964 width=64 style='width:48pt'></td>
  <td class=xl6323964 width=77 style='width:58pt'></td>
  <td class=xl6323964 width=64 style='width:48pt'></td>
  <td class=xl6323964 width=6 style='width:5pt'></td>
  <td class=xl6323964 width=64 style='width:48pt'></td>
  <td class=xl6323964 width=64 style='width:48pt'></td>
  <td class=xl6323964 width=79 style='width:59pt'></td>
  <td class=xl6323964 width=64 style='width:48pt'></td>
  <td class=xl6323964 width=5 style='width:4pt'></td>
  <td class=xl6323964 width=64 style='width:48pt'></td>
  <td class=xl6323964 width=64 style='width:48pt'></td>
  <td class=xl6323964 width=75 style='width:56pt'></td>
  <td class=xl6323964 width=64 style='width:48pt'></td>
  <td class=xl1523964 width=26 style='width:20pt'></td>
 </tr>
 <?php
 $tit=1;
 for($j=0;$j<$total_tic;$j++)
 {
	 echo "<tr height=20 style='mso-height-source:userset;height:15.0pt'><td height=20 class=xl6323964 style='height:15.0pt'></td>";
	 for($i=0;$i<$ii;$i++)
	 {
		echo "<td colspan=4 class=xl6723964 style='border-right:.5pt solid black'>BUNDLE
	  TAG BAI- III-$date</td>
	  <td class=xl6323964></td>";
	  }
	  echo "</tr>";

	 echo "<tr height=20 style='mso-height-source:userset;height:15.0pt'><td height=20 class=xl6323964 style='height:15.0pt'></td>";
	 for($i=0;$i<$ii;$i++)
	 {
		echo "<td class=xl6423964 style='border-top-color:currentColor'>Style</td>
	  <td class=xl6523964 align=right style='border-top-color:currentColor;
	  border-left-color:currentColor'>$style</td>
	  <td class=xl6523964 style='border-top-color:currentColor;border-left-color:
	  currentColor'>Schedule</td>
	  <td class=xl6623964 style='border-top-color:currentColor;border-left-color:
	  currentColor'> $schedule</td>
	  <td class=xl6323964></td>";
	  }
	  echo "</tr>";

	echo " <tr height=20 style='height:15.0pt'><td height=20 class=xl6323964 style='height:15.0pt'></td>";
	 for($i=0;$i<$ii;$i++)
	 {
		echo " <td class=xl6423964 style='border-top-color:currentColor'>Cut No</td>
	  <td class=xl6523964 style='border-top-color:currentColor;border-left-color:
	  currentColor'>$cut_code</td>
	  <td class=xl6523964 style='border-top-color:currentColor;border-left-color:
	  currentColor'>Bundle Pcs</td>
	  <td class=xl6623964 style='border-top-color:currentColor;border-left-color:
	  currentColor'>60</td>
	  <td class=xl6323964></td>";
	  }
	  echo "</tr>";
	  
	  echo " <tr height=20 style='height:15.0pt'>
	  <td height=20 class=xl6323964 style='height:15.0pt'></td>";
	 for($i=0;$i<$ii;$i++)
	 {
		echo "<td class=xl6423964 style='border-top-color:currentColor'>Color</td>
	  <td colspan=3 class=xl7123964 style='border-right:.5pt solid black;
	  border-left:none;border-left-color:currentColor'>$color</td>
	  <td class=xl6323964></td>";
	  }
	  echo "</tr>";
	   echo "<tr height=20 style='height:15.0pt'>
	  <td height=20 class=xl6323964 style='height:15.0pt'></td>";
	 for($i=0;$i<$ii;$i++)
	 {
		echo " <td class=xl6423964 style='border-top-color:currentColor'>Shade</td>
	  <td class=xl6623964 style='border-top-color:currentColor;border-left-color:
	  currentColor'>$shade</td>
	  <td class=xl6523964 style='border-top-color:currentColor;border-left-color:
	  currentColor'>Graphic No</td>
	  <td class=xl6623964 style='border-top-color:currentColor;border-left-color:
	  currentColor'>$graphic</td>
	  <td class=xl6323964></td>";
	  }
	  echo "</tr>";
	  
	   echo "<tr height=20 style='height:15.0pt'>
	  <td height=20 class=xl6323964 style='height:15.0pt'></td>";
	 for($i=0;$i<$ii;$i++)
	 {
		
		echo "<td class=xl6423964 style='border-top-color:currentColor'>Size</td>
	  <td class=xl6623964 style='border-top-color:currentColor;border-left-color:
	  currentColor'>$size_code[$tit]</td>
	  <td colspan=2 class=xl7123964 style='border-right:.5pt solid black;
	  border-left:none;border-left-color:currentColor'>Range</td>
	  <td class=xl6323964></td>";
	  $tit++;
	  }
	  echo "</tr>";
	  
	   echo "<tr height=20 style='height:15.0pt'>
	  <td height=20 class=xl6323964 style='height:15.0pt'></td>";
	 for($i=0;$i<$ii;$i++)
	 {
		
		echo " <td class=xl6423964 style='border-top-color:currentColor'>&nbsp;</td>
	  <td class=xl6623964 style='border-top-color:currentColor;border-left-color:
	  currentColor'>&nbsp;</td>
	  <td class=xl6623964 style='border-top-color:currentColor;border-left-color:
	  currentColor'>$cnt</td>
	  <td class=xl6623964 style='border-top-color:currentColor;border-left-color:
	  currentColor'>$next</td>
	  <td class=xl6323964></td>";
	  $cnt+=$cut_pcs;
	  $next+=$cut_pcs;
	  }
	  echo "</tr>";
	  
	  echo "<tr height=20 style='height:15.0pt'>
	  <td height=20 class=xl6323964 style='height:15.0pt'></td>
	  <td class=xl6323964></td>
	  <td class=xl6323964></td>
	  <td class=xl6323964></td>
	  <td class=xl6323964></td>
	  <td class=xl6323964></td>
	  <td class=xl6323964></td>
	  <td class=xl6323964></td>
	  <td class=xl6323964></td>
	  <td class=xl6323964></td>
	  <td class=xl6323964></td>
	  <td class=xl6323964></td>
	  <td class=xl6323964></td>
	  <td class=xl6323964></td>
	  <td class=xl6323964></td>
	  <td class=xl1523964></td>
	 </tr>";
	}
}
 ?>

</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
