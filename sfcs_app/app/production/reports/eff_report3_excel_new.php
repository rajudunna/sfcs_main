<!--
Date : 2014-01-18;
Task : Added the automatic buyer division efficiency calculation code;
User: kirang;
Ticket #815663.

Date: 2014-04-25;
Task: modify the Actual efficiency % (average) based on running shifts.
User: kirang;
Ticket #516359.

//Change Request#145/kirang/2014-08-13/Round up the values up to 2 decimals in efficiency, SAH and Grand efficiency report 
//service request #466334/ 2014-08-18 / kirang / Actual Eff % taken from Actual Clock hours. 
//service request #474467 /2014-12-24 / kirang / Modification on efficiency report for M&S styles (put MS instead of M&S)
 -->
 <?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$view_access=user_acl("SFCS_0059",$username,1,$group_id_sfcs);
$final_rep9 = getFullURL($_GET["r"],"final_rep9.php","N");

?>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/FileSaver.js',1,'R');?>"></script>
<style id="Daily_Efficiency_Report_26424_Styles">
</style>

<script>
function verify(){
	var from = document.getElementById('demo1').value;
	var to = document.getElementById('demo2').value;
	if( from > to){
		sweetAlert('Start Date should be less than End Date','','warning');
		return false;
	}
}
</script>
<div class="panel panel-primary">
	<div class="panel-heading">Daily Efficiency Report</div>	
		<div class="panel-body">
			<form method="POST" class="form-inline" action=<?php getFullURLLevel($_GET['r'],'eff_report3_excel_new.php',0,'N') ?>>
				<div class="row">
					<div class="col-sm-2">
						<label>Start Date :</label><br>
						<input id="demo1" type="text" data-toggle='datepicker' class="form-control" size="8" name="dat" value=<?php if(isset($_POST['dat'])) { echo $_POST['dat']; } else { echo date("Y-m-d"); } ?>>
					</div>
					<div class="col-sm-2">
							<label for='demo2'>End Date :</label><br>
							<input id="demo2" class="form-control" type="text" data-toggle='datepicker' size="8" name="edat" value=<?php if(isset($_POST['edat'])) { echo $_POST['edat']; } else { echo date("Y-m-d"); } ?>>
					</div>
					<div class="col-sm-2">
						<label>Select Unit:</label><br>
						<input type="hidden" name="section" value="0"/>  
						<select name="section" class="form-control">
							<?php
							$sql2="select * from $bai_pro.unit_db order by sno";
							mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row2=mysqli_fetch_array($sql_result2))
							{
								if($sql_row2['unit_members']==$_POST['section']){ 
							?>
								<option value="<?=$sql_row2['unit_members']?>" selected><?=$sql_row2['unit_id']?></option>
							<?php
								}
								else {
							?>
								<option value="<?=$sql_row2['unit_members']?>" ><?=$sql_row2['unit_id']?></option>
							<?php
							}
							}
							?>
						</select>
					</div>
					<div class="col-md-2">
						<?php
						$buyer_array=array("LIDL","VS","MS","LBI");
						$buyer_names=array("LIDL","VS","M&S","LBI");
						?>
						<label for="select_buyer">Select Buyer: </label><br>
						<select name="buyer" class="form-control">
						<option value="ALL" selected="ALL">ALL</option>

							<?php
								$sql3="select GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
								//echo $sql3;
								mysqli_query($link, $sql3) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
								$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error31".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row3=mysqli_fetch_array($sql_result3))
								{
									if($sql_row3['buyer_name']==$_POST['buyer']){ 
								?>
									<option value="<?=$sql_row3['buyer_name']?>" selected><?=$sql_row3['buyer_div']?></option>
								<?php
									}
								else {
								?>
									<option value="<?=$sql_row3['buyer_name']?>" ><?=$sql_row3['buyer_div']?></option>
								<?php
								}
								}
								?>
						</select> 
					</div>
					<div class='col-sm-1'>
						<br/><input type="submit" name="submit" onclick='return verify()' value="Show" class="btn btn-primary">
					</div>
					<div class='col-sm-1'>
						<br/><input type="button" class="btn btn-success" id='excel1' value="Export to Excel">
					</div>
				</div>	
			</form>

<?php

if(isset($_POST['submit']))
{
	$dat=$_POST['dat'];
	$edat=$_POST['edat'];
	$section=$_POST['section'];
	$buyer=$_POST['buyer'];

	$sql2="select unit_id from $bai_pro.unit_db where unit_members=\"".$_POST['section']."\"";
	//echo $sql2;
	mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$report_heading=$sql_row2['unit_id'];
	}
	$table_temp="";
	$table_temp.='<style id="Daily_Efficiency_Report_26424_Styles">
	<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
	.xl1526424
		{padding:0px;
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
	.xl6526424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl6626424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl6726424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl6826424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid black;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}						
	.xl6926424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl7026424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl7126424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl7226424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl7326424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl7426424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl7526424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl7626424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl7726424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:9.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl7826424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl7926424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl8026424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl8126424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl8226424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl8326424
		{padding:0px;
		mso-ignore:padding;
		color:blue;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:underline;
		text-underline-style:single;
		font-family:Calibri, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border:.5pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl8426424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:9.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:.5pt solid windowtext;
		border-right:.5pt solid windowtext;
		border-bottom:.5pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:wrap;}
	.xl8526424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:.5pt solid windowtext;
		border-right:.5pt solid windowtext;
		border-bottom:.5pt solid windowtext;
		border-left:none;
		background:#E5E0EC;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl8626424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:.5pt solid windowtext;
		border-right:.5pt solid windowtext;
		border-bottom:.5pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl8726424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:.5pt solid windowtext;
		border-right:.5pt solid windowtext;
		border-bottom:.5pt solid windowtext;
		border-left:none;
		background:#E5E0EC;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl8826424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:.5pt solid windowtext;
		border-right:.5pt solid windowtext;
		border-bottom:.5pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl8926424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:.5pt solid windowtext;
		border-right:.5pt solid windowtext;
		border-bottom:.5pt solid windowtext;
		border-left:none;
		background:#E5E0EC;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl9026424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:.5pt solid windowtext;
		border-right:.5pt solid windowtext;
		border-bottom:.5pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl9126424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:.5pt solid windowtext;
		border-right:.5pt solid windowtext;
		border-bottom:.5pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl9226424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"\#\,\#\#0";
		text-align:center;
		vertical-align:bottom;
		border-top:.5pt solid windowtext;
		border-right:.5pt solid windowtext;
		border-bottom:.5pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl9326424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:.5pt solid windowtext;
		border-right:.5pt solid windowtext;
		border-bottom:.5pt solid windowtext;
		border-left:none;
		background:white;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl9426424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:.5pt solid windowtext;
		border-right:.5pt solid windowtext;
		border-bottom:.5pt solid windowtext;
		border-left:none;
		background:#E5E0EC;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl9526424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:.5pt solid windowtext;
		border-right:.5pt solid windowtext;
		border-bottom:.5pt solid windowtext;
		border-left:none;
		background:#DDD9C3;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl9626424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:.5pt solid windowtext;
		border-right:none;
		border-bottom:.5pt solid windowtext;
		border-left:none;
		background:#E5E0EC;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl9726424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid windowtext;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl9826424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl9926424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl10026424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl10126424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl10226424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid windowtext;
		background:#29759C;
		color: WHITE;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl10326424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#CCFFFF;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl10426424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid black;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#CCFFFF;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl10526424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"Medium Date";
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl10626424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"Medium Date";
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		background:#29759C;
		color: WHITE;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl10726424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"Medium Date";
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid black;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl10826424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl10926424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl11026424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid black;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl11126424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:Fixed;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl11226424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:Fixed;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl11326424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:Fixed;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid black;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl11426424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl11526424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl11626424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl11726424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl11826424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl11926424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:none;
		border-bottom:1.0pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl12026424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl12126424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:none;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl12226424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl12326424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:none;
		border-bottom:1.0pt solid black;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl12426424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl12526424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:none;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl12626424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl12726424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:none;
		border-bottom:1.0pt solid black;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl12826424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl12926424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl13026424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid black;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl13126424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:none;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl13226424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid black;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl13326424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:none;
		border-bottom:1.0pt solid black;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl13426424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid black;
		border-bottom:1.0pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl13526424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:none;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl13626424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl13726424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:none;
		border-bottom:1.0pt solid black;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl13826424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl13926424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid black;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl14026424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid black;
		border-bottom:1.0pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl14126424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl14226424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl14326424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl14426424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid black;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl14526424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl14626424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl14726424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid black;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl14826424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid black;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl14926424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid black;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl15026424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:.5pt solid windowtext;
		border-left:.5pt solid windowtext;
		background:#E5E0EC;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl15126424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:.5pt solid windowtext;
		border-bottom:.5pt solid windowtext;
		border-left:none;
		background:#E5E0EC;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl15226424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:.5pt solid windowtext;
		border-right:none;
		border-bottom:.5pt solid windowtext;
		border-left:.5pt solid windowtext;
		background:#E5E0EC;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl15326424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:none;
		border-left:1.0pt solid windowtext;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl15426424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:none;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl15526424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid black;
		border-bottom:none;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl15626424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid windowtext;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl15726424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl15826424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:1.0pt solid black;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl15926424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl16026424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl16126424
		{padding:0px;
		mso-ignore:padding;
		color:#FFC000;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:middle;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:none;
		border-left:1.0pt solid windowtext;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl16226424
		{padding:0px;
		mso-ignore:padding;
		color:#FFC000;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid windowtext;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl16326424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid windowtext;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl16426424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid black;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl16526424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid black;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl16626424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl16726424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid black;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl16826424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid black;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl16926424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl17026424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid black;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl17126424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid black;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl17226424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid windowtext;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl17326424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid windowtext;
		background:#C00000;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl17426424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#C00000;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl17526424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid black;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#C00000;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl17626424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:1.0pt solid black;
		background:#DDD9C3;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl17726424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:none;
		border-bottom:1.0pt solid black;
		border-left:1.0pt solid windowtext;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl17826424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:none;
		border-bottom:1.0pt solid black;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl17926424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:1.0pt solid black;
		border-bottom:1.0pt solid black;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl18026424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid black;
		border-left:none;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl18126424
		{padding:0px;
		mso-ignore:padding;
		color:#FFC000;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid black;
		border-left:1.0pt solid windowtext;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl18226424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl18326424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:none;
		border-bottom:1.0pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl18426424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:1.0pt solid windowtext;
		border-left:none;
		background:#DDD9C3;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl18526424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0%;
		text-align:center;
		vertical-align:bottom;
		border-top:none;
		border-right:1.0pt solid windowtext;
		border-bottom:1.0pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;}
	.xl18626424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"Medium Date";
		text-align:center;
		vertical-align:bottom;
		border-top:1.0pt solid windowtext;
		border-right:none;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl18726424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border:.5pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl18826424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border:.5pt solid windowtext;
		background:#E5E0EC;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl18926424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border:.5pt solid windowtext;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl19026424
		{padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:0;
		text-align:center;
		vertical-align:bottom;
		border:.5pt solid windowtext;
		background:#DDD9C3;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl19126424
		{padding:0px;
		mso-ignore:padding;
		color:white;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Trebuchet MS", sans-serif;
		mso-font-charset:0;
		mso-number-format:"0\.0";
		text-align:center;
		vertical-align:bottom;
		border:.5pt solid windowtext;
		background:#5A5A5A;
		mso-pattern:black none;
		mso-protection:unlocked visible;
		white-space:nowrap;}
	.xl19226424
		{padding:0px;
		mso-ignore:padding;
		color:black;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Calibri, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:bottom;
		border:.5pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:normal;}
	-->
	</style>';
	$table_temp.="<div id=\"Daily_Efficiency_Report_26424\" align=center x:publishsource=\"Excel\">

	<div u1:publishsource=Excel  class='table-responsive' id='print_content'>

	<table border=1 cellpadding=0 cellspacing=0 width=2823 style='border-collapse:collapse;table-layout:fixed;width:2200pt' class='table'>
	<col width=66 style='mso-width-source:userset;mso-width-alt:2413;width:50pt'>
	<col width=64 span=17 style='mso-width-source:userset;mso-width-alt:2340; width:48pt'>
	<col width=72 style='mso-width-source:userset;mso-width-alt:2633;width:54pt'>
	<col width=64 span=9 style='mso-width-source:userset;mso-width-alt:2340; width:48pt'>
	<col width=63 style='mso-width-source:userset;mso-width-alt:2304;width:47pt'>
	<col width=64 span=13 style='mso-width-source:userset;mso-width-alt:2340; width:48pt'>
	<col width=63 span=2 style='mso-width-source:userset;mso-width-alt:2304; width:47pt'>
	<br/>
	<tr height=22 style='mso-height-source:userset;height:16.5pt'>
	<td colspan=25 height=22 class=xl10226424 width=1865 style='border-right:1.0pt solid black;height:16.5pt;width:1399pt'>DAILY EFFICIENCY REPORT ($report_heading)</td>
	<td colspan=13 class=xl10626424 width=958 style='border-right:1.0pt solid black;
	border-left:none;width:718pt'>".$_POST['dat']."-".$_POST['edat']." (".date("l",strtotime($_POST['dat'])).") "."</td>
	</tr>
	<tr background-color='29759C' height=22 style='mso-height-source:userset;height:16.5pt'>
	<td rowspan=3 height=85 class=xl10826424 style='border-bottom:1.0pt solid black;
	height:63.75pt;border-top:none'>MOD</td>
	<td rowspan=3 class=xl10826424 style='border-bottom:1.0pt solid black;
	border-top:none'>Buyer</td>
	<td rowspan=3 class=xl10826424 style='border-bottom:1.0pt solid black;
	border-top:none'>Sty. No</td>
	<td rowspan=3 class=xl11126424 style='border-bottom:1.0pt solid black;
	border-top:none'>SMV</td>
	<td rowspan=3 class=xl6626424 width=64 style='border-bottom:1.0pt solid black;
	border-top:none;width:48pt'>NO Of Days</td>
	<td rowspan=3 class=xl6626424 width=64 style='border-bottom:1.0pt solid black;border-top:none;width:48pt'>Fix Oprs</td>
	<td colspan=2 class=xl11526424 style='border-right:1.0pt solid black;
	border-left:none'>Operators</td>
	<td colspan=2 rowspan=2 class=xl11726424 style='border-right:1.0pt solid black;
	border-bottom:1.0pt solid black'>Rework %</td>
	<td colspan=2 rowspan=2 class=xl12126424 width=128 style='border-right:1.0pt solid black;
	border-bottom:1.0pt solid black;width:96pt'>No Of Audit Fail</td>
	<td colspan=2 rowspan=2 class=xl12526424 width=128 style='border-right:1.0pt solid black;
	border-bottom:1.0pt solid black;width:96pt'>Plan Clock Hrs.</td>
	<td rowspan=2 class=xl12926424 style='border-bottom:1.0pt solid black;
	border-top:none'>Plan</td>
	<td colspan=2 rowspan=2 class=xl13126424 style='border-right:1.0pt solid black;
	border-bottom:1.0pt solid black'>Out Put</td>
	<td class=xl6926424 width=64 style='border-top:none;width:48pt'>Plan</td>
	<td colspan=2 rowspan=2 class=xl13526424 style='border-right:1.0pt solid black;
	border-bottom:1.0pt solid black'>Shift A</td>
	<td colspan=2 rowspan=2 class=xl13526424 style='border-right:1.0pt solid black;
	border-bottom:1.0pt solid black'>Shift B</td>
	<td class=xl7026424 width=64 style='border-top:none;width:48pt'>Plan</td>
	<td colspan=6 class=xl14226424 style='border-right:1.0pt solid black;
	border-left:none'>Efficiency %</td>
	<td colspan=2 rowspan=2 class=xl13126424 style='border-bottom:1.0pt solid black'>Off
	Std Hrs</td>
	<td colspan=2 rowspan=2 class=xl19226424 width=128 style='width:96pt'>SAH
	Loss due to Down time</td>
	<td colspan=2 rowspan=2 class=xl19226424 width=128 style='width:96pt'>SAH
	Loss due to Production</td>
	<td rowspan=3 class=xl7026424 width=64 style='border-bottom:1.0pt solid black;
	border-top:none;width:48pt'>Act. Eff% (A+B)</td>
	<td colspan=2 rowspan=2 class=xl13126424 style='border-right:1.0pt solid black;
	border-bottom:1.0pt solid black'>Remarks</td>
	</tr>
	<tr height=22 style='mso-height-source:userset;height:16.5pt'>
	<td colspan=2 class=xl11526424 style='border-right:1.0pt solid black;
	border-left:none'>Present</td>
	<td class=xl7126424 width=64 style='width:48pt'>Std. Hrs.</td>
	<td class=xl7226424 width=64 style='width:48pt'><span
	style='mso-spacerun:yes'> </span>Eff%</td>
	<td colspan=3 class=xl14226424 style='border-right:1.0pt solid black;
	border-left:none'>Shift A</td>
	<td colspan=3 class=xl14226424 style='border-right:1.0pt solid black;
	border-left:none'>Shift B</td>
	</tr>
	<tr height=41 style='mso-height-source:userset;height:30.75pt'>
	<td class=xl7326424 width=64 style='width:48pt'>Oper (A)</td>
	<td class=xl7326424 width=64 style='width:48pt'>Oper (B)</td>
	<td class=xl7526424 width=64 style='width:48pt'>Shift A</td>
	<td class=xl7526424 width=64 style='width:48pt'>Shift B</td>
	<td class=xl7526424 width=64 style='width:48pt'>Shift A</td>
	<td class=xl7526424 width=64 style='width:48pt'>Shift B</td>
	<td class=xl7626424>Shift A</td>
	<td class=xl7626424>Shift B</td>
	<td class=xl7726424>Prd. (A+B)</td>
	<td class=xl7626424>Shift A</td>
	<td class=xl7626424>Shift B</td>
	<td class=xl7826424 width=64 style='width:48pt'>(A+B)</td>
	<td class=xl7826424 width=64 style='width:48pt'>plan std</td>
	<td class=xl7826424 width=64 style='width:48pt'>Act. std</td>
	<td class=xl7826424 width=64 style='width:48pt'>plan std</td>
	<td class=xl7826424 width=64 style='width:48pt'>Act. std</td>
	<td class=xl7926424 width=64 style='width:48pt'>&nbsp;</td>
	<td class=xl8026424 width=64 style='width:48pt'>Plan Pro</td>
	<td class=xl7926424 width=63 style='width:47pt'>Plan Eff%</td>
	<td class=xl7826424 width=64 style='width:48pt'>Act Eff%</td>
	<td class=xl8026424 width=64 style='width:48pt'>Plan Pro</td>
	<td class=xl7826424 width=64 style='width:48pt'>Plan Eff%</td>
	<td class=xl8126424 width=64 style='width:48pt'>Act Eff%</td>
	<td class=xl7626424>Shift A</td>
	<td class=xl8226424>Shift B</td>
	<td class=xl18726424 style='border-top:none'>Shift A</td>
	<td class=xl18726424 style='border-top:none;border-left:none'>Shift B</td>
	<td class=xl18726424 style='border-top:none;border-left:none'>Shift A</td>
	<td class=xl18726424 style='border-top:none;border-left:none'>Shift B</td>
	<td colspan=2 class=xl14826424 style='border-right:1.0pt solid black;
	border-left:none'>A &amp; B</td>
	</tr>";

	$i2=0;
	$decimal_factor=2;
	echo $table_temp;
	$table.=$table_temp;
	$x_sec=0;
	$sec_temp=$_POST['section'];
	// echo $sec_temp;
	$sec_data=array();
	$sec_data=explode(",",$_POST['section']);
	$sec_check="";
	$date=$_POST['dat'];
	$edate=$_POST['edat'];
	$buyer_name=$_POST['buyer'];

	if($edate < "2012-03-01")
	{
		echo "<script>alert('Error');</script>";
	}
	// NEW BUFFER Table Selection
	$table_name="bai_log_buf";
	$table_name2="bai_quality_log";

	//to fasten system
	if($table_name=="$bai_log_buf")
	{
		$sql="truncate $bai_pro.bai_log_buf_temp";
		mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));

		$sql="insert into $bai_pro.bai_log_buf_temp select * from $bai_pro.bai_log_buf where bac_date 
			  between \"$date\" and \"$edate\"";
			  //echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error45".mysqli_error($GLOBALS["___mysqli_ston"]));

		$table_name="$bai_pro.bai_log_buf_temp";
	}
//to fasten system


// For Grand Eff Calculation
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'grand_Eff_for_daily.php',0,'R'));
//to fasten system

	$sql="truncate $bai_pro.grand_rep_temp";
	mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql="insert into $bai_pro.grand_rep_temp select * from $bai_pro.grand_rep where date between \"".$_POST['dat']."\" and \"".$_POST['edat']."\"";

	mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));

	$grand_rep="$bai_pro.grand_rep_temp";

//to fasten system
	$total_nop=0;
	$act_clock_hrs=0;
	$act_hrsa=0;
	$act_hrsb=0;
	$grand_total_nop=0;
	for($u=0;$u<sizeof($sec_data);$u++)
	{
		$date=$_POST['dat'];
		$edate=$_POST['edat'];
		$sec=$sec_data[$u];
		// echo $sec;
		$h1=array(1,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21);
		$h2=array(6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,24);
		$avail_A=0;
		$avail_B=0;
		$absent_A=0;
		$absent_B=0;
		$totalmodules=0;
		$operatorssum=0;
		$rew_A=0;
		$rew_B=0;
		$auf_A=0;
		$auf_B=0;

		$sah_dtime_a=0;
		$sah_dtime_b=0;
		$sah_prod_a=0;	
		$sah_prod_b=0;
		$sah_dtime_unit_a=0;
		$sah_dtime_unit_b=0;	

		$pclha_total=0;
		$pclhb_total=0;
		$pstha_total=0;
		$psthb_total=0;

		$offsthb_sum=0;
		$offstha_sum=0;

		$peff_a_total=0;
		$peff_b_total=0;
		$peff_g_total=0;
		$ppro_a_total=0;
		$ppro_b_total=0;
		$ppro_g_total=0;
		$clha_total=0;
		$clhb_total=0;
		$clhg_total=0;
		$stha_total=0;
		$sthb_total=0;
		$sthg_total=0;
		$effa_total=0;
		$effb_total=0;
		$effg_total=0;
		$eff_grand=0;
		$i3=0;
		$i2=$i2+1;

		if($buyer_name == "ALL")
		{
			$sql="select distinct module from $bai_pro.grand_rep where section in(".$sec.") and date between \"$date\" and \"$edate\" order by module*1";
			//echo $sql1;
			//echo "Hello";
		}
		else
		{
			$sql="select distinct module from $bai_pro.grand_rep where section in(".$sec.") and date between \"$date\" and \"$edate\" and buyer like \"%".$buyer_name."%\" order by module*1";
			// echo $sql;
		}
		//echo $sql;
		//$sql="select distinct mod_no from pro_mod where mod_sec in(".$sec.") and mod_date between \"$date\" and \"$edate\" and buyer=\"".$buyer_name."\" order by mod_no";
		mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$mod=$sql_row['module'];
			/* GRAND REP INCLUDE */
			$gtotal=0;
			$atotal=0;
			$btotal=0;
			$stha=0;
			$clha=0;
			$effa=0;
			$sthb=0;
			$clhb=0;
			$effb=0;
			$peff_a=0;
			$peff_b=0;
			$ppro_a=0;
			$ppro_b=0;
			$pclha=0;
			$pclhb=0;
			$pstha=0;
			$psthb=0;
			$pstha_mod=0;
			$psthb_mod=0;
			$pstha_mod_total=0;
			$psthb_mod_total=0;
			$section_array=array();

			$sqlx="select * from $bai_pro3.sections_db where sec_id in ($sec_temp)";
			mysqli_query($link, $sqlx) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowx=mysqli_fetch_array($sql_resultx))
			{
				$section_array[]=$sql_rowx['sec_id'];
			}

			if($buyer_name == "ALL")
			{
				$sql2="select sum(act_out) as \"act_out\",ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\", sum(plan_out) as \"plan_out\" from $bai_pro.grand_rep where module=$mod and date between \"$date\" and \"$edate\" and shift=\"A\"";
			}
			else
			{
				$sql2="select sum(act_out) as \"act_out\", ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\", sum(plan_out) as \"plan_out\" from $bai_pro.grand_rep where module=$mod and date between \"$date\" and \"$edate\" and shift=\"A\" and buyer like \"%".$buyer_name."%\"";	
			}
              //echo $sql2;
			mysqli_query($link, $sql2) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$atotal=$sql_row2['act_out'];
				$stha=$sql_row2['act_sth'];
				$clha=$sql_row2['act_clh'];
				//echo $mod."-".$stha."-".$clha."<br>";
				$pclha=$sql_row2['plan_clh'];
				$pstha=$sql_row2['plan_sth'];		
				$peff_a=($pstha/$pclha)*100;
				$ppro_a=$sql_row2['plan_out'];
				$effa=($stha/$pclha)*100;
			}

			if($buyer_name == "ALL")
			{
				$sql2="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\" from $bai_pro.grand_rep where module=$mod and date between \"$date\" and \"$edate\" and shift=\"A\" group by date";
			}
			else
			{
				$sql2="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\" from $bai_pro.grand_rep where module=$mod and date between \"$date\" and \"$edate\" and shift=\"A\" and buyer like \"%".$buyer_name."%\" group by date";	
			}
			mysqli_query($link, $sql2) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$pstha_mod=$pstha_mod+round($sql_row2['plan_sth'],$decimal_factor);	
			}

			if($buyer_name == "ALL")
			{
				$sql2="select sum(act_out) as \"act_out\", ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\",sum(plan_out) as \"plan_out\"  from $bai_pro.grand_rep where module=$mod and date between \"$date\" and \"$edate\" and shift=\"B\"";
			}
			else
			{
				$sql2="select sum(act_out) as \"act_out\", ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\", sum(plan_out) as \"plan_out\"  from $bai_pro.grand_rep where module=$mod and date between \"$date\" and \"$edate\" and shift=\"B\" and buyer like \"%".$buyer_name."%\"";	
			}
			mysqli_query($link, $sql2) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$btotal=$sql_row2['act_out'];
				$sthb=$sql_row2['act_sth'];
				$clhb=$sql_row2['act_clh'];
				//echo $mod."-".$sthb."-".$clhb."<br>";
				$pclhb=$sql_row2['plan_clh'];
				$psthb=$sql_row2['plan_sth'];			
				$peff_b=($psthb/$pclhb)*100;
				$ppro_b=$sql_row2['plan_out'];
				$effb=($sthb/$pclhb)*100;
			}


			if($buyer_name == "ALL")
			{
				$sql2="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\" from $bai_pro.grand_rep where module=$mod and date between \"$date\" and \"$edate\" and shift=\"B\" group by date";
			}
			else
			{
				$sql2="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\" from $bai_pro.grand_rep where module=$mod and date between \"$date\" and \"$edate\" and shift=\"B\" and buyer like \"%".$buyer_name."%\" group by date";	
			}
			mysqli_query($link, $sql2) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$psthb_mod=$psthb_mod+round($sql_row2['plan_sth'],$decimal_factor);	
			}

			$max=0;
			$sql2="select smv,nop,styles, SUBSTRING_INDEX(max_style,'^',-1) as style_no, buyer, days, act_out from $bai_pro.grand_rep where module=$mod and date between \"$date\" and \"$edate\"";
			mysqli_query($link, $sql2) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				if($sql_row2['act_out']>$max)
				{
					$max=$sql_row2['act_out'];
					$smv=$sql_row2['smv'];
					$nop=round($sql_row2['nop'],0);
					//$total_nop=$total_nop+$nop;
				}
				else{
					$smv=$sql_row2['smv'];
					$nop=round($sql_row2['nop'],0);
					//$total_nop=$total_nop+$nop;
				}		
				$styledb=$sql_row2['styles'];

				$styledb_no=$sql_row2['style_no'];
				// echo $styledb_no."<br>";
				$styledb_no_explode=explode(",",$styledb_no);
				$styledb_no=$styledb_no_explode[0];
				// echo $styledb_no."<br>";
				$buyerdb=$sql_row2['buyer'];
				$age=$sql_row2['days'];
			}

			$sql13="select fix_nop as nop,act_hours as hrs from $bai_pro.pro_plan where mod_no=$mod and date between \"$date\" and \"$edate\" ";
			$result13=mysqli_query($link, $sql13) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row13=mysqli_fetch_array($result13))
			{
				$nop=$sql_row13["nop"];
				//$act_hrs=$sql_row13["hrs"];	
			}
						
			//$act_clock_hrs=$act_clock_hrs+$act_hrs*($avail_A+$avail_B-$absent_A-$absent_B));

			$sql2="select avg(plan_eff) as \"plan_eff\" from $bai_pro.pro_plan where mod_no=$mod and date between \"$date\" and \"$edate\" and shift=\"A\"";
			mysqli_query($link, $sql2) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$peff_a_new=$sql_row2['plan_eff'];
			}

			$sql2="select avg(plan_eff) as \"plan_eff\" from $bai_pro.pro_plan where mod_no=$mod and date between \"$date\" and \"$edate\" and shift=\"B\"";
			mysqli_query($link, $sql2) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$peff_b_new=$sql_row2['plan_eff'];
			}


			$chk_date=$edate;
			$age_days=1;

			do
			{
				//echo "Date = ".$chk_date."<br>";
				$chk_date=date("Y-m-d",strtotime("-1 day",strtotime($chk_date)));	
				$sql22="SELECT * FROM $bai_pro.grand_rep WHERE DATE=\"".$chk_date."\"";
				//echo $sql22."<br>";
				$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rows=mysqli_num_rows($sql_result22);
				if($rows == 0)
				{
					//$chk_date=date("Y-m-d",strtotime("-2 day",strtotime($chk_date)));	
					$sql2="SELECT MAX(bac_date) as max_date FROM $bai_pro.bai_log_buf WHERE bac_qty > 0 AND bac_date <= \"".$chk_date."\"";
					// echo $sql2."<br>";
					$sql_result2=mysqli_query($link, $sql2) or die("Sql Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row2=mysqli_fetch_array($sql_result2))
					{
						$chk_date=$sql_row2["max_date"];
					}
				}
			
				$sql21="select * from $bai_pro.bai_log_buf where bac_style=\"".$styledb_no."\" and bac_no=\"".$mod."\" and bac_date=\"$chk_date\"";
				// echo $sql21."<br>";
				mysqli_query($link, $sql21) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result21=mysqli_query($link, $sql21) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rowsx=mysqli_num_rows($sql_result21);
				if($rowsx > 0)
				{
					$age_days=$age_days+1;
				}

				//echo $sql21."-".$styledb_no."-".$style_chk."<br>";

			}while($rowsx !=0);

				$total_nop=$total_nop+$nop;
				$grand_total_nop=$grand_total_nop+$nop;
				$table_temp="<tr height=21 style='mso-height-source:userset;height:15.75pt'>
				<td height=21 class=xl8326424 style='height:15.75pt'>
				<a href='".$final_rep9."&module=".$mod."&date=".$date."'>$mod</a>
				</td>
				<td class=xl8426424 style='width:100px;word-wrap:break-word;'>$buyerdb</td>
				<td class=xl8426424 style='width:100px;word-wrap:break-word;'>$styledb</td>
				<td class=xl8426424 style='width:100px;word-wrap:break-word;'>$smv</td>
				<td class=xl8526424 style='width:100px;word-wrap:break-word;'>$age_days</td>
				<td class=xl8626424 style='width:100px;word-wrap:break-word;'>".$nop."</td>";
				//$total_nop=$total_nop+$nop;
				$age_days=0;
				echo $table_temp;
				$table.=$table_temp;


				$operatorssum=$operatorssum+$nop;

				$date_range=array();
				$sql2="select distinct date from $bai_pro.grand_rep where date between \"$date\" and \"$edate\"";
				mysqli_query($link, $sql2) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$date_range[]=$sql_row2['date'];
				}
				$sqlA="select sum(present+jumper) as \"avail_A\",sum(absent) as \"absent_A\" from $bai_pro.pro_attendance where module=$mod and shift=\"A\" and  date in (\"".implode('","',$date_range)."\")";
				$sql_resultA=mysqli_query($link, $sqlA) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowA=mysqli_fetch_array($sql_resultA))
				{
					$table_temp="<td class=xl8726424>".($sql_rowA['avail_A']-$sql_rowA['absent_A'])."</td>";

					echo $table_temp;
					$table.=$table_temp;

					$avail_A=$avail_A+$sql_rowA['avail_A'];
					$avail_A_fix=$sql_rowA['avail_A'];
					$absent_A=$absent_A+$sql_rowA['absent_A'];
					$absent_A_fix=$sql_rowA['absent_A'];
				}

				$sqlB="select sum(present+jumper) as \"avail_B\",sum(absent) as \"absent_B\" from $bai_pro.pro_attendance where module=$mod and shift=\"B\" and  date in (\"".implode('","',$date_range)."\")";
				$sql_resultB=mysqli_query($link, $sqlB) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowB=mysqli_fetch_array($sql_resultB))
				{
					
					$table_temp="<td class=xl8726424>".($sql_rowB['avail_B']-$sql_rowB['absent_B'])."</td>";

					echo $table_temp;
					$table.=$table_temp;

					$avail_B=$avail_B+$sql_rowB['avail_B'];
					$avail_B_fix=$sql_rowB['avail_B'];
					$absent_B=$absent_B+$sql_rowB['absent_B'];
					$absent_B_fix=$sql_rowB['absent_B'];
				}


				$sql132="select act_hours as hrs from $bai_pro.pro_plan where mod_no=$mod and shift=\"A\" and date between \"$date\" and \"$edate\" ";
				//echo $sql132."<br>";
				$result132=mysqli_query($link, $sql132) or exit("Sql Error145".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row132=mysqli_fetch_array($result132))
				{
					$act_hrsa=$sql_row132["hrs"];
					//echo $act_hrsa."-".($sql_row2['avail_A']-$sql_row2['absent_A'])."<br>";	
				}

				$sql133="select act_hours as hrs from $bai_pro.pro_plan where mod_no=$mod and shift=\"B\" and date between \"$date\" and \"$edate\" ";
				//echo $sql133."<br>";
				$result133=mysqli_query($link, $sql133) or exit("Sql Error146".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row133=mysqli_fetch_array($result133))
				{
					$act_hrsb=$sql_row133["hrs"];	
					//echo $act_hrsb."<br>";
				}
					
				$act_clock_hrs=$act_clock_hrs+($act_hrsa*($avail_A_fix-$absent_A_fix))+($act_hrsb*($avail_B_fix-$avail_B_fix));

				$sql_num_check=mysqli_num_rows($sql_result2);

				if($sql_num_check==0)
				{
					$table_temp="<td class=xl865896>0</td>
					<td class=xl865896>0</td>
					<td class=xl865896>0</td>
					<td class=xl865896>0</td>
					<td class=xl875896>0</td>
					<td class=xl875896>0</td>"; 
					echo $table_temp;
					$table.=$table_temp;
				}

				$sql2="select avg(rew_A) as \"rew_A\", avg(rew_B) as \"rew_B\", sum(auf_A) as \"auf_A\", sum(auf_B) as \"auf_B\" from $bai_pro.pro_quality where module=$mod and date between \"$date\" and \"$edate\"";
				mysqli_query($link, $sql2) or exit("Sql Error147".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$table_temp="<td class=xl8926424>".round($sql_row2['rew_A'],0)."%</td>";
					echo $table_temp;
					$table.=$table_temp;
					$table_temp="<td class=xl8926424>".round($sql_row2['rew_B'],0)."%</td>";
					echo $table_temp;
					$table.=$table_temp;

					$rew_A=$rew_A+$sql_row2['rew_A'];
					$rew_B=$rew_B+$sql_row2['rew_B'];

					$table_temp="<td class=xl8726424>".$sql_row2['auf_A']."</td>";
					echo $table_temp;
					$table.=$table_temp;
					$table_temp="<td class=xl8726424>".$sql_row2['auf_B']."</td>";
					echo $table_temp;
					$table.=$table_temp;

					$auf_A=$auf_A+$sql_row2['auf_A'];
					$auf_B=$auf_B+$sql_row2['auf_B'];
				}

				$sql_num_check=mysqli_num_rows($sql_result2);

				if($sql_num_check==0)
				{
					$table_temp="<td class=xl8926424>0</td>
					<td class=xl8926424>0</td>
					<td class=xl8926424>0</td>
					<td class=xl8926424>0</td>";
					echo $table_temp;
					$table.=$table_temp;
				}



				$offstha=0;
				$offsthb=0;
				$remarks_a="";
				$remarks_b="";

				$sql2="select sum(dtime) as \"offstha\", remarks from $bai_pro.down_log where shift=\"A\" and date between \"$date\" and \"$edate\" and mod_no=$mod and remarks!=\"".strtolower("Open capacity")."\"";
				mysqli_query($link, $sql2) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$offstha=$sql_row2['offstha'];
					$remarks_a=$sql_row2['remarks'];
				}

				if($offstha==NULL)
				{
					$offstha=0;
				}
				$offstha_sum=$offstha_sum+$offstha;

				$sql2="select sum(dtime) as \"offsthb\",remarks from $bai_pro.down_log where shift=\"B\" and date between \"$date\" and \"$edate\" and mod_no=$mod and remarks!=\"".strtolower("Open capacity")."\"";
				mysqli_query($link, $sql2) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error24".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$offsthb=$sql_row2['offsthb'];
					$remarks_b=$sql_row2['remarks'];
				}

				if($offsthb==NULL)
				{
					$offsthb=0;
				}

				$offsthb_sum=$offsthb_sum+$offsthb;

				$osha=round(($offstha/60),2);
				$oshb=round(($offsthb/60),2);


				$table_temp="<td class=xl9026424>".$pclha."</td>";
				echo $table_temp;
				$table.=$table_temp;
				$table_temp="<td class=xl9026424>".$pclhb."</td>";
				echo $table_temp;
				$table.=$table_temp;

				$pclha_total=$pclha_total+$pclha;
				$pclhb_total=$pclhb_total+$pclhb;

				$table_temp="<td class=xl9126424>".round(($ppro_a+$ppro_b),0)."</td>";
				echo $table_temp;
				$table.=$table_temp;
				$table_temp="<td class=xl8526424>".$atotal."</td>";
				echo $table_temp;
				$table.=$table_temp;
				$table_temp="<td class=xl8526424>".$btotal."</td>";
				echo $table_temp;
				$table.=$table_temp;
				$table_temp="<td class=xl9226424>".(round($pstha_mod,$decimal_factor)+round($psthb_mod,$decimal_factor))."</td>";
				echo $table_temp;
				$table.=$table_temp;


				$pstha_total=$pstha_total+round($pstha,$decimal_factor);
				$psthb_total=$psthb_total+round($psthb,$decimal_factor);

				$table_temp="<td class=xl9226424>".round($pstha_mod,$decimal_factor)."</td>";
				echo $table_temp;
				$table.=$table_temp;
				$table_temp="<td class=xl9226424>".round($stha,$decimal_factor)."</td>";
				echo $table_temp;
				$table.=$table_temp;
				$table_temp="<td class=xl9226424>".round($psthb_mod,$decimal_factor)."</td>";
				echo $table_temp;
				$table.=$table_temp;
				$table_temp="<td class=xl9226424>".round($sthb,$decimal_factor)."</td>";
				echo $table_temp;
				$table.=$table_temp;
				// Ticket #516359 /modify the Actual efficiency % (average) based on running shifts.
				if($act_hrsa+$act_hrsb == '' || $act_hrsa+$act_hrsb == 0 )
					$eff_grand=$eff_grand+round(($peff_a_new+$peff_b_new)/(($act_hrsa+$act_hrsb)/7.5),0);
				$i3=$i3+1;
				$table_temp="<td  class=xl8926424>".round((($pstha+$psthb)/($pclha+$pclhb))*100,0)."%</td>";

				echo $table_temp;
				$table.=$table_temp;
				$table_temp="<td class=xl9226424>".round($ppro_a,0)."</td>";
				echo $table_temp;
				$table.=$table_temp;
				$table_temp="<td  class=xl8926424>".round(($pstha/$pclha)*100,0)."%</td>";
				echo $table_temp;
				$table.=$table_temp;

				$plan_eff_a=round($peff_a_new,0);
				$plan_eff_b=round($peff_b_new,0);

				if($pclha-($offstha/60)>0)
				{
					$affa=$stha/($pclha-($offstha/60));
				}
				else
				{
					$affa=0;
				}

				//$table_temp="<td class=xl9326424>".round(($affa*100),0)."%</td>";
				$table_temp="<td class=xl9326424>".round(($stha/$clha)*100,0)."%</td>";
				echo $table_temp;
				$table.=$table_temp;
				/*$table_temp="<td class=xl9326424>".($clha-$osha)."</td>";
				echo $table_temp;
				$table.=$table_temp;*/
				$table_temp="<td class=xl9226424>".round($ppro_b,0)."</td>";
				echo $table_temp;
				$table.=$table_temp;
				$table_temp="<td class=xl8926424>".round(($psthb/$pclhb)*100,0)."%</td>";
				echo $table_temp;
				$table.=$table_temp;


				if(($pclhb-($offsthb/60))>0)
				{
					$affb=$sthb/($pclhb-($offsthb/60));
				}
				else
				{
					$affb=0;
				}

				//$table_temp="<td class=xl9326424>".round(($affb*100),0)."%--aa</td>";
				$table_temp="<td class=xl9326424>".round(($sthb/$clhb)*100,0)."%</td>";
				echo $table_temp;
				$table.=$table_temp;


				$peff_a_total=$peff_a_total+$peff_a;
				$peff_b_total=$peff_b_total+$peff_b;
				$peff_g_total=$peff_a_total+$peff_b_total;

				$ppro_a_total=$ppro_a_total+$ppro_a;
				$ppro_b_total=$ppro_b_total+$ppro_b;
				$ppro_g_total=$ppro_a_total+$ppro_b_total;

				$clha_total=$clha_total+$clha;
				$clhb_total=$clhb_total+$clhb;
				$clhg_total=$clha_total+$clhb_total;

				$stha_total=$stha_total+round($stha,$decimal_factor);
				$sthb_total=$sthb_total+round($sthb,$decimal_factor);
				$sthg_total=$stha_total+$sthb_total;

				$effa_total=$effa_total+round(($effa),2);
				$effb_total=$effb_total+round(($effb),2);
				$effg_total=$effa_total+$effb_total;




				$table_temp="<td class=xl9426424>".round(($offstha/60),2)."</td>";
				echo $table_temp;
				$table.=$table_temp;
				$table_temp="<td class=xl9426424>".round(($offsthb/60),2)."</td>";
				echo $table_temp;
				$table.=$table_temp;

				$table_temp="<td class=xl18826424>".round($osha*$plan_eff_a/100,0)."</td>";
				echo $table_temp;
				$table.=$table_temp;	

				$sah_dtime_a=$sah_dtime_a+round($osha*$plan_eff_a/100,0);

				$table_temp="<td class=xl18826424>".round($oshb*$plan_eff_b/100,0)."</td>";
				echo $table_temp;
				$table.=$table_temp;	

				$sah_dtime_b=$sah_dtime_b+round($oshb*$plan_eff_b/100,0);

				if(round((round($stha,$decimal_factor)+($osha*$plan_eff_a/100))-round($pstha_mod,$decimal_factor),0) < 0)
				{
					$sah_prod_a=$sah_prod_a+round((round($stha,$decimal_factor)+($osha*$plan_eff_a/100))-round($pstha_mod,$decimal_factor),0);
					$table_temp="<td class=xl18826424>".round((round($stha,$decimal_factor)+($osha*$plan_eff_a/100))-round($pstha_mod,$decimal_factor),0)."</td>";
					echo $table_temp;
					$table.=$table_temp;
				}
				else
				{
					$table_temp="<td class=xl18826424>0</td>";
					echo $table_temp;
					$table.=$table_temp;
				}

				if(round((round($sthb,$decimal_factor)+($oshb*$plan_eff_b/100))-round($psthb_mod,$decimal_factor),0) < 0)
				{
					$sah_prod_b=$sah_prod_b+round((round($sthb,$decimal_factor)+($oshb*$plan_eff_b/100))-round($psthb_mod,$decimal_factor),0);
					$table_temp="<td class=xl18826424>".round((round($sthb,$decimal_factor)+($oshb*$plan_eff_b/100))-round($psthb_mod,$decimal_factor),0)."</td>";
					echo $table_temp;
					$table.=$table_temp;
				}
				else
				{
					$table_temp="<td class=xl18826424>0</td>";
					echo $table_temp;
					$table.=$table_temp;
				}
				// Ticket #516359 /modify the Actual efficiency % (average) based on running shifts.
				// Actual Eff % taken from Actual Clock hours.   
				if(($clha+$clhb)>0)
				{
					if($act_hrsa+$act_hrsb != 0 && $avail_A_fix-$absent_A_fix != 0 && $avail_B_fix-$absent_B_fix != 0)
						$table_temp="<td class=xl9526424>".
						round((round(($stha/(($avail_A_fix-$absent_A_fix)*$act_hrsa))*100,0)+
						round(($sthb/(($avail_B_fix-$absent_B_fix)*$act_hrsb))*100,0))/(($act_hrsa+$act_hrsb)/7.5),0)."
						%</td>";
					else
						$table_temp="<td class=xl9526424>0%</td>";

					echo $table_temp;
					$table.=$table_temp;
				}
				else
				{
					$table_temp="<td class=xl9526424>0%</td>";
					echo $table_temp;
					$table.=$table_temp;
				}

				$table_temp="<td colspan=2 class=xl15026424 style='border-right:.5pt solid black;border-left:none'>$remarks_a $remarks_b</td>";
				echo $table_temp;
				$table.=$table_temp;

				$table_temp="</tr>";
				echo $table_temp;
				$table.=$table_temp;

				$totalmodules=$totalmodules+1;

		}
			/*****************************************************************************************************************/

			/* NEW STREAM */

			$total=0;
			$btotal=0;
			$atotal=0;
			$pclha=0;
			$pclhb=0;
			$pstha=0;
			$psthb=0;
			//$phours=7.5;
			$peff_a_total=0;
			$peff_b_total=0;

			if($buyer_name == "ALL")
			{
				$sql2="select sum(act_out) as \"act_out\", ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\", sum(plan_out) as \"plan_out\" from $bai_pro.grand_rep where section in ($sec) and date between \"$date\" and \"$edate\" and shift=\"A\"";
			}
			else
			{
				$sql2="select sum(act_out) as \"act_out\", ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\", sum(plan_out) as \"plan_out\" from $bai_pro.grand_rep where section in ($sec) and date between \"$date\" and \"$edate\" and shift=\"A\" and buyer like \"%".$buyer_name."%\"";	
			}
			mysqli_query($link, $sql2) or exit("Sql Error222".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error222".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$atotal=$sql_row2['act_out'];
				$stha=$sql_row2['act_sth'];
				$clha=$sql_row2['act_clh'];
				$effa=($stha/$clha)*100;
				$pclha=$sql_row2['plan_clh'];
				$pstha=$sql_row2['plan_sth'];		
				$peff_a=($pstha/$pclha)*100;
				$ppro_a=$sql_row2['plan_out'];

			}


			if($buyer_name == "ALL")
			{
				$sql2="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\" from $bai_pro.grand_rep where section in ($sec) and date between \"$date\" and \"$edate\" and shift=\"A\" group by date,module";
			}
			else
			{
				$sql2="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\" from $bai_pro.grand_rep where section in ($sec) and date between \"$date\" and \"$edate\" and shift=\"A\" and buyer like \"%".$buyer_name."%\" group by date,module";	
			}
			mysqli_query($link, $sql2) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$pstha_mod_total=$pstha_mod_total+round($sql_row2['plan_sth'],$decimal_factor);	
			}

			if($buyer_name == "ALL")
			{
				$sql2="select  sum(act_out) as \"act_out\", ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\", sum(plan_out) as \"plan_out\"  from $bai_pro.grand_rep where section in ($sec) and date between \"$date\" and \"$edate\" and shift=\"B\"";
			}
			else
			{
				$sql2="select  sum(act_out) as \"act_out\", ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\", sum(plan_out) as \"plan_out\"  from $bai_pro.grand_rep where section in ($sec) and date between \"$date\" and \"$edate\" and shift=\"B\" and buyer like \"%".$buyer_name."%\"";	
			}
			mysqli_query($link, $sql2) or exit("Sql Error333".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error333".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$btotal=$sql_row2['act_out'];
				$sthb=$sql_row2['act_sth'];
				$clhb=$sql_row2['act_clh'];
				$effb=($sthb/$clhb)*100;
				$pclhb=$sql_row2['plan_clh'];
				$psthb=$sql_row2['plan_sth'];			
				$peff_b=($psthb/$pclhb)*100;
				$ppro_b=$sql_row2['plan_out'];

			}

			if($buyer_name == "ALL")
			{
				$sql2="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\" from $bai_pro.grand_rep where section in ($sec) and date between \"$date\" and \"$edate\" and shift=\"B\" group by date,module";
			}
			else
			{
				$sql2="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\" from $bai_pro.grand_rep where section in ($sec) and date between \"$date\" and \"$edate\" and shift=\"B\" and buyer like \"%".$buyer_name."%\" group by date,module";
			//echo $sql2;	
			}
			mysqli_query($link, $sql2) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$psthb_mod_total=$psthb_mod_total+round($sql_row2['plan_sth'],$decimal_factor);	
			}


			$total=$atotal+$btotal;

			$sql2="select sec_head from $bai_pro.pro_sec_db where sec_no=$sec";
			mysqli_query($link, $sql2) or exit("Sql Error444".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error444".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$head_name=$sql_row2['sec_head'];
			}

			$table_temp="<tr height=22 style='mso-height-source:userset;height:16.5pt;'>";
			echo $table_temp;
			$table.=$table_temp;

			$table_temp="<td colspan=5 rowspan=2 height=44 class=xl15326424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;height:33.0pt;'>".$head_name."</td>";
			echo $table_temp;

			$table.=$table_temp;
			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".$operatorssum."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".($avail_A-$absent_A)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".($avail_B-$absent_B)."</td>";
			echo $table_temp;
			$table.=$table_temp;


			if($totalmodules>0)
			{
				$table_temp="<td class=xl9826424 style='background-color:#5A5A5A'>".round($rew_A/$totalmodules,0)."%</td>";
				echo $table_temp;
				$table.=$table_temp;
				$table_temp="<td class=xl9826424 style='background-color:#5A5A5A'>".round($rew_B/$totalmodules,0)."%</td>";
				echo $table_temp;
				$table.=$table_temp;
			}
			else
			{
				$table_temp="<td class=xl9826424 style='background-color:#5A5A5A'>0%</td>";
				echo $table_temp;
				$table.=$table_temp;
				$table_temp="<td class=xl9826424 style='background-color:#5A5A5A'>0%</td>";
				echo $table_temp;
				$table.=$table_temp;
			}

			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".$auf_A."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".$auf_B."</td>";
			echo $table_temp;
			$table.=$table_temp;

			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".round($pclha_total,$decimal_factor)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".round($pclhb_total,$decimal_factor)."</td>";
			echo $table_temp;
			$table.=$table_temp;

			$table_temp="<td rowspan=2 class=xl15926424 style='background-color:#5A5A5A' style='border-bottom:1.0pt solid black'>".round(($ppro_a_total+$ppro_b_total),0)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".$atotal."</td>";
			echo $table_temp;
			$table.=$table_temp;

			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".$btotal."</td>";
			echo $table_temp;
			$table.=$table_temp;

			$table_temp="<td rowspan=2 class=xl15926424 style='background-color:#5A5A5A' style='border-bottom:1.0pt solid black'>".($pstha_mod_total+$psthb_mod_total)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".($pstha_mod_total)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".round($stha_total,$decimal_factor)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".($psthb_mod_total)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".round($sthb_total,$decimal_factor)."</td>";
			echo $table_temp;
			$table.=$table_temp;


			$peffresulta=0;
			$peffresultb=0;

			if($ppro_a_total>0 && $pclha>0)
			{
				$peffresulta=(round(($pstha/$pclha),2)*100);
			}

			if($ppro_b_total>0 && $pclhb>0)
			{
				$peffresultb=(round(($psthb/$pclhb),2)*100);
			}

			if(($pclha_total+$pclhb_total)>0)
			{
				$table_temp="<td rowspan=2 class=xl16126424 style='background-color:#5A5A5A' style='border-bottom:1.0pt solid black'>".round((($pstha_total+$psthb_total)/($pclha_total+$pclhb_total))*100,0)."%</td>";
				//$table_temp="<td rowspan=2 class=xl16126424 style='background-color:#5A5A5A' style='border-bottom:1.0pt solid black'>".round($eff_grand/$i3,0)."%</td>";
				//$table_temp="<td rowspan=2 class=xl16126424 style='background-color:#5A5A5A' style='border-bottom:1.0pt solid black'>".round($eff_grand/$i3,0)."%xx</td>";
				echo $table_temp;
				$table.=$table_temp;
			}
			else
			{
				$table_temp="<td rowspan=2 class=xl16126424 style='background-color:#5A5A5A' style='border-bottom:1.0pt solid black'>0%</td>";
				echo $table_temp;
				$table.=$table_temp;
			}

			$xa=0;
			$xb=0;
			if($pclha_total>0)
			{
				$xa=round(($stha_total/$pclha_total)*100,2);
			}

			if($clhb_total>0)
			{
				$xb=round(($sthb_total/$pclhb_total)*100,2);
			}


			if(($pclha_total-($offstha_sum/60))>0)
			{
				$xa_actual=round(($stha_total/($pclha_total-($offstha_sum/60)))*100,0);
			}

			if(($clhb_total-($offsthb_sum/60))>0)
			{
				$xb_actual=round(($sthb_total/($pclhb_total-($offsthb_sum/60)))*100,0);
			}

			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".round($ppro_a_total,0)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td  class=xl9826424 style='background-color:#5A5A5A'>".round($peffresulta,0)."%</td>";
			echo $table_temp;
			$table.=$table_temp;
			/*$table_temp="<td class=xl9826424>".round($xa,0)."%</td>";
			echo $table_temp;
			$table.=$table_temp;*/
			//$table_temp="<td class=xl9826424>".$xa_actual."%</td>";
			$table_temp="<td class=xl9826424 style='background-color:#5A5A5A'>".round(($stha_total/(($avail_A-$absent_A)*7.5))*100,0)."%</td>";
			echo $table_temp;
			$table.=$table_temp;
			/*$table_temp="<td class=xl9726424>".($clha-round(($offstha_sum/60),2))."</td>";
			echo $table_temp;
			$table.=$table_temp;*/
			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".round($ppro_b_total,0)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td class=xl9826424 style='background-color:#5A5A5A'>".round($peffresultb,0)."%</td>";
			echo $table_temp;
			$table.=$table_temp;
			/*$table_temp="<td class=xl9826424>".round($xb,0)."%</td>";
			echo $table_temp;
			$table.=$table_temp;*/
			//$table_temp="<td class=xl9826424>".$xb_actual."%</td>";
			$table_temp="<td class=xl9826424 style='background-color:#5A5A5A'>".round(($sthb_total/(($avail_B-$absent_B)*7.5))*100,0)."%</td>";
			echo $table_temp;
			$table.=$table_temp;

			$table_temp="<td class=xl9726424 style='background-color:#5A5A5A'>".round(($offstha_sum/60),2)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td class=xl10026424 style='background-color:#5A5A5A'>".round(($offsthb_sum/60),2)."</td>";
			echo $table_temp;
			$table.=$table_temp;

			$sah_dtime_unit_a=$sah_dtime_unit_a+$sah_dtime_a;
			$sah_dtime_unit_b=$sah_dtime_unit_b+$sah_dtime_b;

			$sah_dtime_unit_a_array[]=$sah_dtime_a;
			//echo "adtime = ".sizeof($sah_dtime_unit_a_array);
			$sah_dtime_unit_b_array[]=$sah_dtime_b;
			//echo "bdtime = ".sizeof($sah_dtime_unit_b_array);

			if(sizeof($sah_dtime_unit_a_array) == 6)
			{
				$total_dtime_a_sum=array_sum($sah_dtime_unit_a_array);
			}
			else
			{
				$total_dtime_a_sum=0;
			}

			$sah_pro_unit_a_array[]=$sah_prod_a;
			$sah_pro_unit_b_array[]=$sah_prod_b;

			$sah_dtime_sec=$sah_dtime_a+$sah_dtime_b;
			$table_temp="<td class=xl18926424 style='background-color:#5A5A5A'>".$sah_dtime_a."</td>";
			echo $table_temp;
			$table.=$table_temp;
			//$sah_dtime_a=0;
			$table_temp="<td class=xl18926424 style='background-color:#5A5A5A'>".$sah_dtime_b."</td>";		
			echo $table_temp;
			$table.=$table_temp;
			//$sah_dtime_b=0;

			$sah_prod_sec=$sah_prod_a+$sah_prod_b;
			$table_temp="<td class=xl18926424 style='background-color:#5A5A5A'>".$sah_prod_a."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$sah_prod_a=0;

			$table_temp="<td class=xl18926424 style='background-color:#5A5A5A'>".$sah_prod_b."</td>";
			echo $table_temp;
			$table.=$table_temp;	
			$sah_prod_b=0;	

			$table_temp="</tr>";
			echo $table_temp;
			$table.=$table_temp;

			$table_temp="<tr height=22 style='mso-height-source:userset;height:16.5pt'>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td height=22 class=xl9926424 style='background-color:#5A5A5A' style='height:16.5pt'>".$operatorssum."</td>";
			echo $table_temp;
			$table.=$table_temp;

			$table_temp="<td colspan=2 class=xl9926424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;border-left:none'>".($avail_A+$avail_B-$absent_A-$absent_B)."</td>";
			echo $table_temp;
			$table.=$table_temp;


			// Ticket #516359 /modify the Actual efficiency % (average) based on running shifts.
			if($totalmodules> 0 && ($act_hrsa+$act_hrsb) > 0) 
			{
				$table_temp="<td colspan=2 class=xl16726424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;border-left:none'>".round((($rew_A/$totalmodules)+($rew_B/$totalmodules)/(($act_hrsa+$act_hrsb)/7.5)),0)."%</td>";
			}
			else
			{
				$table_temp="<td colspan=2 class=xl16726424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;border-left:none'>0%</td>";
			}

			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td colspan=2 class=xl9926424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;border-left:none'>".($auf_A+$auf_B)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td colspan=2 class=xl9926424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;border-left:none'>".round(($pclha_total+$pclhb_total),$decimal_factor)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td colspan=2 class=xl16326424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;border-left:none'>".($atotal+$btotal)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td colspan=3 class=xl16326424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;border-left:none'>Actual std hrs =</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td class=xl9926424 style='background-color:#5A5A5A'>".round(($stha_total+$sthb_total),$decimal_factor)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td colspan=2 class=xl17226424 style='background-color:#5A5A5A' style='border-right:1.0pt solid black;border-left:none'>Act EFF % =</td>";
			echo $table_temp;
			$table.=$table_temp;
			
			if(($clha_total+$clhb_total)>0)
			{

				$table_temp="<td colspan=4 class=xl17326424 style='border-right:1.0pt solid black;background-color:#C00000'>".round((($stha_total+$sthb_total)/($clha_total+$clhb_total))*100,0)."%</td>";
				echo $table_temp;
				$table.=$table_temp;
			}
			else
			{
				$table_temp="<td colspan=4 class=xl17326424 style='border-right:1.0pt solid black;background-color:#C00000'>0%</td>";
				echo $table_temp;
				$table.=$table_temp;
			}


			$table_temp="<td colspan=2 class=xl18926424 style='background-color:#5A5A5A' style='border-left:none'>".round(($offstha_sum+$offsthb_sum)/60,2)."</td>";
			echo $table_temp;
			$table.=$table_temp;
			$table_temp="<td colspan=2 class=xl18926424 style='background-color:#5A5A5A' style='border-left:none'>".$sah_dtime_sec."</td>";
			echo $table_temp;
			$table.=$table_temp;

			$table_temp="<td colspan=2 class=xl18926424 style='background-color:#5A5A5A' style='border-left:none'>".$sah_prod_sec."</td>";
			echo $table_temp;
			$table.=$table_temp;

			$table_temp="</tr>";
			echo $table_temp;
			$table.=$table_temp;
			


			//include("eff_report33_excel_new_ms.php");
			/****************************************************************************************/

			// FOR UNIT LEVEL DISPLAY	
			$sec_check=$sec_check.$sec.",";


			$sec_explode=explode(",",$sec_check);
			$x_sec=$x_sec+1;

			if($x_sec==sizeof($section_array))
			{
				include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'eff_report33_excel_new.php',0,'R'));

				if(sizeof($section_array) > 1)
				{	
					
					include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'Eff_report33_excel_new_buyer.php',0,'R'));
					
				}	
				
			} 
		}
	echo "</table></div></div>";
}
?>
</div>
<style>
td{
 	width=auto;
}
#text_color{
	color=white;
}
td { word-wrap:break-word;}
</style>
<?php
// unlink("Eff_Report.xls");
// $myFile1 = "Eff_Report.xls";
// $fh1 = fopen($myFile1, 'w') or die("can't open file");
// $stringData1=$table;
// fwrite($fh1, $stringData1);
// fclose($fh1);

?>

</div>
</div>


 
<script>
	$('#excel1').click(function(){
        var blob = new Blob([document.getElementById('print_content').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
		});
		console.log('one');
		saveAs(blob,"Eff_Report.xls");
		console.log('hi');
		return;
    })
</script>