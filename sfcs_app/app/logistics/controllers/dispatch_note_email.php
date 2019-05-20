<?php 
// Service Request #99034864/ 2016-07-06 /  Need to replace the bharatk user name instead of the vasudevav user, 
// naiduy instead of pradeepse. 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
?>

<html>
<head>
<script type="text/javascript" language="javascript">
    window.onload = function () {
        noBack();
    }
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>

 <script language="JavaScript">

        var version = navigator.appVersion;

        function showKeyCode(e) {
            var keycode = (window.event) ? event.keyCode : e.keyCode;

            if ((version.indexOf('MSIE') != -1)) {
                if (keycode == 116) {
                    event.keyCode = 0;
                    event.returnValue = false;
                    return false;
                }
            }
            else {
                if (keycode == 116) {
                    return false;
                }
            }
        }

    </script>
</head>
<body>
<?php  
//$disp_id=$note_no;
$disp_id=$_REQUEST['note_no'];
$note_no=$_REQUEST['note_no'];

$sql="select * from $bai_pro3.disp_db left join party_db on disp_db.party=party_db.pid where disp_db.disp_note_no='$disp_id'";

mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($sql_result) == 0){
        $url = getFullURL($_GET['r'],'security_check.php','N');
        echo "<script>swal('Docket do not exist','please try another','warning')
                    window.location.href='$url';</script>";
    
    }
$party_details=array();
while($sql_row=mysqli_fetch_array($sql_result))
{
	$disp_date=$sql_row['create_date'];
	$party_name=$sql_row['party_name'];
	$party_details=explode("^",$sql_row['party_details']);
	$vehicle=$sql_row['vehicle_no'];
	$seal=$sql_row['seal_no'];
	$remarks=$sql_row['remarks'];
	switch($sql_row['mode'])
	{
		case 1:
		{
			$mode="Air";
			break;
		}
		case 2:
		{
			$mode="Sea";
			break;
		}
		case 3:
		{
			$mode="Road";
			break;
		}
		case 4:
		{
			$mode="Courier";
			break;
		}
		default:
		{
			$mode="";
			break;
		}
	}
	$department="Finishing";
}
$message1 = "
Dear User,
<br/><br/>
<strong><font color=\"green\">Security Checkout / Vehicle Exit Time: ".date("Y-m-d H:i")."</font></strong>
<br/><br/>
<table border=1 cellpadding=0 cellspacing=0 width=768 style='border-collapse:collapse; table-layout:fixed; width:578pt'>
	<thead>
		<tr>
			<td colspan=\"4\"><center>Advice of Dispatch (Non - Returnable)</center></td>
		</tr>
		<tr>
			<td rowspan=\"6\"><center>To:</center></td>
		</tr>
		<tr>
			<td>$party_name</td>
			<td>Date:</td>
			<td>$disp_date</td>
		</tr>
		<tr>
			<td>".$party_details['0']."</td>
			<td>Vehicle No:</td>
			<td>$vehicle</td>
		</tr>
		<tr>
			<td>".$party_details['1']."</td>
			<td>Mode:</td>
			<td>$mode</td>
		</tr>
		<tr>
			<td>".$party_details['2']."</td>
			<td>Dept:</td>
			<td>$department</td>
		</tr>
		<tr>
			<td>".$party_details['3']."</td>
			<td>Seal No:</td>
			<td>$seal</td>
		</tr>
	</thead>
</table>
<br>
<table border=1 style='border-collapse:collapse; table-layout:fixed; width:578pt'>
	<tr>
		<td>Sl No.</td>
		<td>Style</td>
		<td>Schedule</td>
		<td>Cartons</td>
		<td>Qty Dispatched</td>
		<td>UOM</td>
		<td>Remarks</td>
	</tr>
";


?>

<?php
$message='<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<title>Dispatch Note</title>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="'.'index.php?r='.getFullURL($_GET['r'],'../common/filelist.xml','N').'">
<style id="Book1_2606_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	 mso-displayed-thousand-separator:"\,";}
.xl652606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl662606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;
	text-align:center;
	}
	
.xl672606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl682606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl692606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;
	text-align:center;
	}
.xl702606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7026062
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl712606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl722606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl732606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl742606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl752606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl762606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl772606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl782606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl792606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl802606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl812606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:14.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl822606
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Century Gothic", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
-->

body
{
	font-family:Century Gothic;
}
</style>



</head>

<body>';
$message.="<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excels Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<br/><br/><strong><font color=\"green\">Security Checkout / Vehicle Exit Time: ".date("Y-m-d H:i")."</font></strong><br/><br/>

<div id=\"Book1_2606\" align=center x:publishsource=\"Excel\">

<table border=0 cellpadding=0 cellspacing=0 width=768 class=xl662606
 style='border-collapse:collapse;table-layout:fixed;width:578pt'>
 <col class=xl662606 width=14 style='mso-width-source:userset;mso-width-alt:
 512;width:11pt'>
 <col class=xl662606 width=37 span=2 style='mso-width-source:userset;
 mso-width-alt:1353;width:28pt'>
 <col class=xl662606 width=113 style='mso-width-source:userset;mso-width-alt:
 4132;width:85pt'>
 <col class=xl662606 width=122 style='mso-width-source:userset;mso-width-alt:
 4461;width:92pt'>
 <col class=xl662606 width=62 style='mso-width-source:userset;mso-width-alt:
 2267;width:47pt'>
 <col class=xl662606 width=104 style='mso-width-source:userset;mso-width-alt:
 3803;width:78pt'>
 <col class=xl662606 width=64 style='mso-width-source:userset;mso-width-alt:
 2340;width:48pt'>
 <col class=xl662606 width=199 style='mso-width-source:userset;mso-width-alt:
 7277;width:149pt'>
 <col class=xl662606 width=16 style='mso-width-source:userset;mso-width-alt:
 585;width:12pt'>
 <tr height=14 style='mso-height-source:userset;height:10.5pt'>
  <td height=14 class=xl662606 width=14 style='height:10.5pt;width:11pt'><a
  name=\"RANGE!A1:J39\"></a></td>
  <td class=xl662606 width=37 style='width:28pt'></td>
  <td class=xl662606 width=37 style='width:28pt'></td>
  <td class=xl662606 width=113 style='width:85pt'></td>
  <td class=xl662606 width=122 style='width:92pt'></td>
  <td class=xl662606 width=62 style='width:47pt'></td>
  <td class=xl662606 width=104 style='width:78pt'></td>
  <td class=xl662606 width=64 style='width:48pt'></td>
  <td class=xl662606 width=199 style='width:149pt'></td>
  <td class=xl662606 width=16 style='width:12pt'></td>
 </tr>

 <tr height=25 style='height:18.75pt'>
  <td height=25 class=xl662606 style='height:18.75pt'></td>
  <td colspan=8 class=xl812606>Advice of Dispatch (Non - Returnable)</td>
  <td class=xl662606></td>
 </tr>
 <tr height=13 style='mso-height-source:userset;height:9.75pt'>
  <td height=13 class=xl662606 style='height:9.75pt'></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl652606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl662606 style='height:16.5pt'></td>
  <td class=xl662606>To:</td>
  <td colspan=4 class=xl752606>$party_name</td>
  <td colspan=2 class=xl682606>Date:</td>
  <td class=xl662606>$disp_date</td>
  <td class=xl662606></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl662606 style='height:16.5pt'></td>
  <td class=xl662606></td>
  <td colspan=4 class=xl762606>".$party_details[0]."</td>
  <td colspan=2 class=xl682606>Vehicle No.:</td>
  <td class=xl692606>$vehicle</td>
  <td class=xl662606></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl662606 style='height:16.5pt'></td>
  <td class=xl662606></td>
  <td colspan=4 class=xl762606>".$party_details[1]."</td>
  <td colspan=2 class=xl682606>Mode:</td>
  <td class=xl692606 style='border-top:none'>$mode</td>
  <td class=xl662606></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl662606 style='height:16.5pt'></td>
  <td class=xl662606></td>
  <td colspan=4 class=xl762606>".$party_details[2]."</td>
  <td colspan=2 class=xl682606>Dept.:</td>
  <td class=xl692606 style='border-top:none'>$department</td>
  <td class=xl662606></td>
 </tr>
  <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl662606 style='height:16.5pt'></td>
  <td class=xl662606></td>
  <td colspan=4 class=xl762606>".$party_details[2]."</td>
  <td colspan=2 class=xl682606>Seal No:</td>
  <td class=xl692606 style='border-top:none'>$seal</td>
  <td class=xl662606></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl662606 style='height:16.5pt'></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl662606 style='height:16.5pt'></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
  <td class=xl662606></td>
 </tr>
 <tr height=38 style='height:28.5pt'>
  <td height=38 class=xl662606 style='height:28.5pt'></td>
  <td class=xl782606>Sno.</td>
  <td colspan=2 class=xl782606 style='border-left:none'>Style</td>
  <td class=xl782606 style='border-left:none'>Schedule</td>
  <td class=xl782606 style='border-left:none'>$remarks</td>
  <td class=xl792606 width=104 style='border-left:none;width:78pt'>Qty <br>
    Dispatched</td>
  <td class=xl782606 style='border-left:none'>UOM</td>
  <td class=xl782606 style='border-left:none'>Remarks</td>
  <td class=xl662606></td>
 </tr>";

 		$grand_pcs=0;
		$grand_carts=0;
		$x=1;
		$iu_check=0;
		
		 $sql="select ship_style,ship_schedule,coalesce(sum(ship_cartons),0) as \"ship_cartons\", coalesce(sum(ship_s_xs),0) as \"ship_s_xs\",coalesce(sum(ship_s_s),0) as \"ship_s_s\",coalesce(sum(ship_s_m),0) as \"ship_s_m\",coalesce(sum(ship_s_l),0) as \"ship_s_l\",coalesce(sum(ship_s_xl),0) as \"ship_s_xl\",coalesce(sum(ship_s_xxl),0) as \"ship_s_xxl\",coalesce(sum(ship_s_xxxl),0) as \"ship_s_xxxl\"
		,coalesce(sum(ship_s_s01),0) as \"ship_s_s01\",coalesce(sum(ship_s_s02),0) as \"ship_s_s02\",coalesce(sum(ship_s_s03),0) as \"ship_s_s03\",coalesce(sum(ship_s_s04),0) as \"ship_s_s04\",coalesce(sum(ship_s_s05),0) as \"ship_s_s05\",coalesce(sum(ship_s_s06),0) as \"ship_s_s06\",coalesce(sum(ship_s_s07),0) as \"ship_s_s07\",coalesce(sum(ship_s_s08),0) as \"ship_s_s08\",coalesce(sum(ship_s_s09),0) as \"ship_s_s09\",coalesce(sum(ship_s_s10),0) as \"ship_s_s10\",coalesce(sum(ship_s_s11),0) as \"ship_s_s11\",coalesce(sum(ship_s_s12),0) as \"ship_s_s12\",coalesce(sum(ship_s_s13),0) as \"ship_s_s13\",coalesce(sum(ship_s_s14),0) as \"ship_s_s14\",coalesce(sum(ship_s_s15),0) as \"ship_s_s15\",coalesce(sum(ship_s_s16),0) as \"ship_s_s16\",coalesce(sum(ship_s_s17),0) as \"ship_s_s17\",coalesce(sum(ship_s_s18),0) as \"ship_s_s18\",coalesce(sum(ship_s_s19),0) as \"ship_s_s19\",coalesce(sum(ship_s_s20),0) as \"ship_s_s20\",coalesce(sum(ship_s_s21),0) as \"ship_s_s21\",coalesce(sum(ship_s_s22),0) as \"ship_s_s22\",coalesce(sum(ship_s_s23),0) as \"ship_s_s23\",coalesce(sum(ship_s_s24),0) as \"ship_s_s24\",coalesce(sum(ship_s_s25),0) as \"ship_s_s25\",coalesce(sum(ship_s_s26),0) as \"ship_s_s26\",coalesce(sum(ship_s_s27),0) as \"ship_s_s27\",coalesce(sum(ship_s_s28),0) as \"ship_s_s28\",coalesce(sum(ship_s_s29),0) as \"ship_s_s29\",coalesce(sum(ship_s_s30),0) as \"ship_s_s30\",coalesce(sum(ship_s_s31),0) as \"ship_s_s31\",coalesce(sum(ship_s_s32),0) as \"ship_s_s32\",coalesce(sum(ship_s_s33),0) as \"ship_s_s33\",coalesce(sum(ship_s_s34),0) as \"ship_s_s34\",coalesce(sum(ship_s_s35),0) as \"ship_s_s35\",coalesce(sum(ship_s_s36),0) as \"ship_s_s36\",coalesce(sum(ship_s_s37),0) as \"ship_s_s37\",coalesce(sum(ship_s_s38),0) as \"ship_s_s38\",coalesce(sum(ship_s_s39),0) as \"ship_s_s39\",coalesce(sum(ship_s_s40),0) as \"ship_s_s40\",coalesce(sum(ship_s_s41),0) as \"ship_s_s41\",coalesce(sum(ship_s_s42),0) as \"ship_s_s42\",coalesce(sum(ship_s_s43),0) as \"ship_s_s43\",coalesce(sum(ship_s_s44),0) as \"ship_s_s44\",coalesce(sum(ship_s_s45),0) as \"ship_s_s45\",coalesce(sum(ship_s_s46),0) as \"ship_s_s46\",coalesce(sum(ship_s_s47),0) as \"ship_s_s47\",coalesce(sum(ship_s_s48),0) as \"ship_s_s48\",coalesce(sum(ship_s_s49),0) as \"ship_s_s49\",coalesce(sum(ship_s_s50),0) as \"ship_s_s50\",ship_remarks from $bai_pro3.ship_stat_log where ship_status='2' and disp_note_no='$disp_id' group by ship_schedule,ship_remarks order by ship_schedule";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num_sch=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$ship_xs=$sql_row['ship_s_xs'];
			$ship_s=$sql_row['ship_s_s'];
			$ship_m=$sql_row['ship_s_m'];
			$ship_l=$sql_row['ship_s_l'];
			$ship_xl=$sql_row['ship_s_xl'];
			$ship_xxl=$sql_row['ship_s_xxl'];
			$ship_xxxl=$sql_row['ship_s_xxxl'];
			
			$ship_s01=$sql_row['ship_s_s01'];
			$ship_s02=$sql_row['ship_s_s02'];
			$ship_s03=$sql_row['ship_s_s03'];
			$ship_s04=$sql_row['ship_s_s04'];
			$ship_s05=$sql_row['ship_s_s05'];
			$ship_s06=$sql_row['ship_s_s06'];
			$ship_s07=$sql_row['ship_s_s07'];
			$ship_s08=$sql_row['ship_s_s08'];
			$ship_s09=$sql_row['ship_s_s09'];
			$ship_s10=$sql_row['ship_s_s10'];
			$ship_s11=$sql_row['ship_s_s11'];
			$ship_s12=$sql_row['ship_s_s12'];
			$ship_s13=$sql_row['ship_s_s13'];
			$ship_s14=$sql_row['ship_s_s14'];
			$ship_s15=$sql_row['ship_s_s15'];
			$ship_s16=$sql_row['ship_s_s16'];
			$ship_s17=$sql_row['ship_s_s17'];
			$ship_s18=$sql_row['ship_s_s18'];
			$ship_s19=$sql_row['ship_s_s19'];
			$ship_s20=$sql_row['ship_s_s20'];
			$ship_s21=$sql_row['ship_s_s21'];
			$ship_s22=$sql_row['ship_s_s22'];
			$ship_s23=$sql_row['ship_s_s23'];
			$ship_s24=$sql_row['ship_s_s24'];
			$ship_s25=$sql_row['ship_s_s25'];
			$ship_s26=$sql_row['ship_s_s26'];
			$ship_s27=$sql_row['ship_s_s27'];
			$ship_s28=$sql_row['ship_s_s28'];
			$ship_s29=$sql_row['ship_s_s29'];
			$ship_s30=$sql_row['ship_s_s30'];
			$ship_s31=$sql_row['ship_s_s31'];
			$ship_s32=$sql_row['ship_s_s32'];
			$ship_s33=$sql_row['ship_s_s33'];
			$ship_s34=$sql_row['ship_s_s34'];
			$ship_s35=$sql_row['ship_s_s35'];
			$ship_s36=$sql_row['ship_s_s36'];
			$ship_s37=$sql_row['ship_s_s37'];
			$ship_s38=$sql_row['ship_s_s38'];
			$ship_s39=$sql_row['ship_s_s39'];
			$ship_s40=$sql_row['ship_s_s40'];
			$ship_s41=$sql_row['ship_s_s41'];
			$ship_s42=$sql_row['ship_s_s42'];
			$ship_s43=$sql_row['ship_s_s43'];
			$ship_s44=$sql_row['ship_s_s44'];
			$ship_s45=$sql_row['ship_s_s45'];
			$ship_s46=$sql_row['ship_s_s46'];
			$ship_s47=$sql_row['ship_s_s47'];
			$ship_s48=$sql_row['ship_s_s48'];
			$ship_s49=$sql_row['ship_s_s49'];
			$ship_s50=$sql_row['ship_s_s50'];
			
			$ship_style=$sql_row['ship_style'];
			$ship_schedule=$sql_row['ship_schedule'];
			$ship_cartons=$sql_row['ship_cartons'];
			
			//Additional Validity to avoid other schedule info
			$sql1="select * from $bai_pro3.speed_del_dashboard where speed_schedule='$ship_schedule'";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if(mysqli_num_rows($sql_result1)>0)
			{
				//To identify IU schedules styles
				if(strpos($ship_style,"QS") or strpos($ship_style,"ES") or strpos($ship_style,"Y2") or strpos($ship_style,"Z2") or strpos($ship_style,"H2") or strpos($ship_style,"P2") or strpos($ship_style,"S2") or strpos($ship_style,"T2") or strpos($ship_style,"Y3") or strpos($ship_style,"Z3") or strpos($ship_style,"H3") or strpos($ship_style,"P3") or strpos($ship_style,"S3") or strpos($ship_style,"T3"))
				{
					$iu_check=1;
				}
			}
			
			
			$rmks=$sql_row['ship_remarks'];
			
			$grand_carts+=$ship_cartons;
			
			$total_pcs=$ship_xs+$ship_s+$ship_m+$ship_l+$ship_xl+$ship_xxl+$ship_xxxl+$ship_s01+$ship_s02+$ship_s03+$ship_s04+$ship_s05+$ship_s06+$ship_s07+$ship_s08+$ship_s09+$ship_s10+$ship_s11+$ship_s12+$ship_s13+$ship_s14+$ship_s15+$ship_s16+$ship_s17+$ship_s18+$ship_s19+$ship_s20+$ship_s21+$ship_s22+$ship_s23+$ship_s24+$ship_s25+$ship_s26+$ship_s27+$ship_s28+$ship_s29+$ship_s30+$ship_s31+$ship_s32+$ship_s33+$ship_s34+$ship_s35+$ship_s36+$ship_s37+$ship_s38+$ship_s39+$ship_s40+$ship_s41+$ship_s42+$ship_s43+$ship_s44+$ship_s45+$ship_s46+$ship_s47+$ship_s48+$ship_s49+$ship_s50;

			$grand_pcs+=$total_pcs;

			/*
			echo "<td>$ship_style</td>";
			echo "<td>$ship_schedule</td>";
			echo "<td>$total_pcs</td>";
			echo "<td>$ship_cartons</td>"; */
			
			$message.= "<tr height=22 style='height:16.5pt'>
		  <td height=22 class=xl662606 style='height:16.5pt'></td>
		  <td class=xl722606 style='border-top:none'>$x</td>
		  <td colspan=2 class=xl712606 style='border-left:none'>$ship_style</td>
		  <td class=xl722606 style='border-top:none;border-left:none'>$ship_schedule</td>
		  <td class=xl722606 style='border-top:none;border-left:none'>$ship_cartons</td>
		  <td class=xl722606 style='border-top:none;border-left:none'>$total_pcs</td>
		  <td class=xl722606 style='border-top:none;border-left:none'>PCS</td>
		  <td class=xl722606 style='border-top:none;border-left:none'>$rmks</td>
		  <td class=xl662606></td>
		 </tr>";
			$message1.= "
			<tr height=22 style='height:16.5pt'>
				<td>$x</td>
				<td>$ship_style</td>
				<td>$ship_schedule</td>
				<td>$ship_cartons</td>
				<td>$total_pcs</td>
				<td>PCS</td>
				<td>$rmks</td>
			</tr>";
		 
		 $x++;
			
		}

			$message.= "<tr height=22 style='height:16.5pt'>
		  <td height=22 class=xl662606 style='height:16.5pt; border:none;'></td>
		  <td class=xl722606 style='border:none'></td>
		  <td colspan=2 class=xl712606 style='border-bottom:none;border-left:none'></td>
		  <td class=xl722606 style='border-top:none;border-left:none'><strong>Total</strong></td>
		  <td class=xl722606 style='border-top:none;border-left:none'><strong>$grand_carts</strong></td>
		  <td class=xl722606 style='border-top:none;border-left:none'><strong>$grand_pcs</strong></td>
		  <td class=xl722606 style='border-top:none;border-left:none'><strong>PCS</strong></td>
		  <td class=xl722606 style='border-top:none;border:none'>&nbsp;</td>
		  <td class=xl662606></td>
		 </tr>";

		$message1.= "
		<tr height=22 style='height:16.5pt'>
		  <td colspan=3><center><strong>Total</strong></center></td>
		  <td><strong>$grand_carts</strong></td>
		  <td><strong>$grand_pcs</strong></td>
		  <td><strong>PCS</strong></td>
		  <td></td>
		 </tr>
		 </table><br/><br/>Message Sent Via:".$plant_name."";
 
 

 
 $message.="<![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=14 style='width:11pt'></td>
  <td width=37 style='width:28pt'></td>
  <td width=37 style='width:28pt'></td>
  <td width=113 style='width:85pt'></td>
  <td width=122 style='width:92pt'></td>
  <td width=62 style='width:47pt'></td>
  <td width=104 style='width:78pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=199 style='width:149pt'></td>
  <td width=16 style='width:12pt'></td>
 </tr>
 <![endif]>
</table>

</div>


</body>

</html>";

	$subject = 'Dispatch Update AOD Ref# '.$note_no;
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	//$headers .= 'To: <'.$to.'>'. "\r\n";
	// if($iu_check==1)
	// {
	// 	$headers .= 'To: <saiyateesh@gmail.com>'. "\r\n";
	// }
	// else
	// {
	// 	$headers .= 'To: '.$to. "\r\n";
	// }
	
	$to = $dispatch_mail;
	$headers .= "From: ".$header_name." <".$header_mail.">". "\r\n";

	//$headers .= 'Cc: YasanthiN@brandix.com' . "\r\n";
	
	//KiranG 20160112 Added validation to track duplicate mail track. SR# 83957742
		$myFile = "mail_tran_log.txt";
	$fh = fopen($myFile, 'a') or die("can't open file");
	
	$sql="select * from $bai_pro3.disp_db where disp_note_no='$note_no' and (exit_date IS NULL OR exit_date = '') and status=2";

	$sql_result=mysqli_query($link, $sql) or exit($sql."<br/>Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	//var_dump($sql_result);
	//die();
	fwrite($fh, "Note: $note_no".date("Y-m-d H:i:s").$username."Select Query<br>\r\n");

	if(mysqli_num_rows($sql_result)==1)
	{

		fwrite($fh, date("Y-m-d H:i:s").$username."Mail Start<br>\r\n");
		if(mail($to, $subject, $message1, $headers))
		{
			fwrite($fh, date("Y-m-d H:i:s").$username."Mail Successful<br>\r\n");
			
			$sql="update $bai_pro3.disp_db set exit_date=\"".date("Y-m-d H:i:s")."\", status=3, dispatched_by=USER() where disp_note_no=$note_no and status=2";
			mysqli_query($link, $sql) or exit($sql."<br/>Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			fwrite($fh, date("Y-m-d H:i:s").$username."Mail Query Success<br>\r\n");
			
			if(mysqli_affected_rows($link)>0)
			{
				fwrite($fh, date("Y-m-d H:i:s").$username."Success Redirect<br>\r\n");
				$url = getFullURL($_GET['r'],"security_check.php",'N');
				// echo "<script>sweetAlert('','Successfully Updated.','success')</script>";
				// header("location: $url");
		        echo "<script>sweetAlert('Mail Sent Successfully',' ','success')</script>";
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url\"; }</script>";
				
				
			}
			else
			{
				echo "<br/><h2><font color=\"red\">Already Updated.</font></h2>";
				
				fwrite($fh, date("Y-m-d H:i:s").$username."Already Updated<br>\r\n");
				
			}
				
		}
		else
		{
			echo "<h2><font color=\"red\">Mail Failed to sent.</font></h2>";
			fwrite($fh, date("Y-m-d H:i:s").$username."Mail failed to sent<br>\r\n");
		}
	}
	else
	{
		echo "<h2><font color=\"blue\">Mail was already sent.</font></h2>";
		fwrite($fh, date("Y-m-d H:i:s").$username."Mail was already sent<br>\r\n");
	}
	
	fclose($fh);
?>
</body>

</html>