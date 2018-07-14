<?php
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
	$view_access=user_acl("SFCS_0087",$username,1,$group_id_sfcs); 
?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',2,'R')); ?>

<div class="panel panel-primary">
<div class="panel-heading">Cut Quantity Reporting</div>
<div class="panel-body">
<?php //include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'menu_content.php',1,'R')); ?>
<!-- <div id="page_heading"><span style="float"><h3>Production Input Planning Dashboard</h3></span><span style= "float: right; margin-top: -20px"></span></div> -->

<!--<div id="page_heading"><span style="float"><h3>Cut Status Reporting</h3></span><span style="float: right; margin-top:-20px"><b>?</b>&nbsp;</span></div>-->
<!--<h1><font color=red>Cut Status Reporting</font></h1>-->
<form method="post" name="input" action="index.php?r=<?php echo $_GET['r']; ?>">

<div class="row">
<div class="col-md-3">
<label>Enter Docket Number:</label>
<input type="text" name="docket_id" size=15 class="form-control integer">
</div>
<span id="error" style="color: Red; display: none"></span>

						
<input type="submit" class="btn btn-primary" value="search" name="submit" style="margin-top:22px;"><a href="<?= getFullURLLevel($_GET['r'],'doc_track_panel_recut.php',0,'N'); ?>" class="btn btn-info pull-right" style="margin-top:22px;">Go to Recut Status Reporting >> </a>


<!--
Enter CID Number: <input type="text" name="cid" size=15>
<input type="submit" value="search" name="submit2"> -->
</div>
</form>

<!--<div style="float:right;"><h3><a href="../recut_v2/doc_track_panel.php">Go to Recut Status Reporting >> </a></h3></div>-->

<?php

if(isset($_POST['submit']))
{
echo "<hr/>";
$docket_id=$_POST['docket_id'];
$sql12="select * from $bai_pro3.plandoc_stat_log where doc_no='$docket_id'";
$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row12=mysqli_fetch_array($sql_result12))
{
	$valnew=$sql_row12['org_doc_no'];
	//$status_doc=$sql_row12['org_doc_no'];
}
//echo $valnew."<br>";
if($valnew==0)
{	
	if($docket_id>0)
	{
		$sql="select cat_ref,order_tid,fabric_status,category from $bai_pro3.order_cat_doc_mk_mix where doc_no=$docket_id";
		//echo $sql."<br>";
		//mysql_query($sql,$link) or exit("Sql Error".mysql_error());
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$cat_ref=$sql_row['cat_ref'];
			$order_tid=$sql_row['order_tid'];
			$category=$sql_row['category'];
			if($sql_row['category']=="Body" or $sql_row['category']=="Front")
			{
				$fabric_status=$sql_row['fabric_status'];
				$sql1="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_doc_no=$docket_id and m3_op_des='LAY'"; 
				$result=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$val_check=mysqli_num_rows($result);
			}
			else
			{
				$fabric_status=5;
			}
			//echo $cat_ref."---".$fabric_status."<br>";
		}
		//echo $cat_ref."---".$fabric_status."<br>";
		//if($cat_ref>0 and $fabric_status==5)	
		//if($cat_ref>0)	
		//{				
		$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			for($s=0;$s<sizeof($sizes_code);$s++)
			{
				if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
				{
					$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
				}	
			}
				
		}		
			
		$cat_id=$cat_ref;
		$date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));


		echo "<div class=\"table-responsive\" ><table class='table table-bordered'>";
		echo "<tr class='tblheading'>";
		echo "<th>Doc ID</th><th>Cut No</th>";
		for($s=0;$s<sizeof($s_tit);$s++)
			{
				echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
					
			}
		echo "<th>Cut Status</th><th>Cut Issue Status</th><th>Control</th>";

		echo "<th>Date</th><th>Section</th><th>Shift</th><th>Fab_REC</th><th>Fab_Ret</th><th>Damages</th><th>Shortage</th>";

		//echo "<th>Control</th>";
		echo "<th>Date</th><th>ModNo</th><th>Shift</th>";

		echo "</tr>";

		//$sql="select * from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id order by doc_no";
		$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id and doc_no=$docket_id order by doc_no"; //NEW 2011
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);

		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$doc_no=$sql_row['doc_no'];
			$doc_acutno=$sql_row['acutno'];
			$a_plies=$sql_row['p_plies'];
			for($s=0;$s<sizeof($sizes_code);$s++)
			{
				$a_s[$sizes_code[$s]]=$sql_row["a_s".$sizes_code[$s].""]*$a_plies;
			}
			$plies=$sql_row['a_plies'];

			
			
			$remarks=$sql_row['remarks'];
			$act_cut_status=$sql_row['act_cut_status'];
			$act_cut_issue_status=$sql_row['act_cut_issue_status'];
			
			$sql33="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
			mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row33=mysqli_fetch_array($sql_result33))
			{
			$color_code=$sql_row33['color_code']; //Color Code
				
			}
			
			echo "<tr>";
			
			echo "<td>".leading_zeros($doc_no,9)."</td><td>".chr($color_code).leading_zeros($doc_acutno,3)."</td>";
			for($s=0;$s<sizeof($s_tit);$s++)
			{
				echo "<td>".$a_s[$sizes_code[$s]]."</td>";
					
			}
			echo "<td>$act_cut_status</td><td>$act_cut_issue_status</td>";
		//echo "<td>$remarks</td>";

			if($category=='Body' or $category=="Front")
			{
				if($val_check>0)
				{
					if($act_cut_status=="DONE" and $plies==$a_plies)
					{
						echo "<td> - </td>";
					}
					else
					{
						$create_url_1 = getFullURLLevel($_GET['r'],'orders_cut_issue_status_form_v2.php',0,'N');
						echo "<td><a class='btn btn-primary btn-sm' href=".$create_url_1."&doc_no=$doc_no>Create</a></td>";
					}
				}
				else
				{
					//echo "<td>Lay report Pending.</td>";
					$create_url_11 = getFullURLLevel($_GET['r'],'orders_cut_issue_status_form_v2.php',0,'N');
					echo "<td><a  class='btn btn-primary btn-sm' href=".$create_url_11."&doc_no=$doc_no>Create</a></td>";
				}
			}
			else
			{
				if($act_cut_status=="DONE" and $plies==$a_plies)
				{
					echo "<td> - </td>";
				}
				else
				{
					$create_url_12=getFullURLLevel($_GET['r'],'orders_cut_issue_status_form_v2.php',0,'N');
					echo "<td><a class='btn btn-primary btn-sm' href=".$create_url_12."&doc_no=$doc_no>Create</a></td>";
				}
			}

				$acs_date="";
				$acs_section="";
				$acs_shift="";
				$acs_fab_received="";
				$acs_fab_returned="";
				$acs_damages="";
				$acs_shortages="";
				$acs_remarks="";
				
			$sql2="select * from $bai_pro3.act_cut_status where doc_no=$doc_no";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$acs_date=$sql_row2['date'];
				$acs_section=$sql_row2['section'];
				$acs_shift=$sql_row2['shift'];
				$acs_fab_received=$sql_row2['fab_received'];
				$acs_fab_returned=$sql_row2['fab_returned'];
				$acs_damages=$sql_row2['damages'];
				$acs_shortages=$sql_row2['shortages'];
				$acs_remarks=$sql_row2['remarks'];
			}
			


			
			echo "<td>$acs_date</td><td>$acs_section</td><td>$acs_shift</td><td>$acs_fab_received</td><td>$acs_fab_returned</td><td>$acs_damages</td><td>$acs_shortages</td>";
			if($act_cut_issue_status=="DONE")
			{
				//IMS IMPLEMNT
				//echo "<td>Edit</td>";
			}
			else
			{
				
				if($act_cut_status=="DONE")
				{
					//IMS IMplemet
					//echo "<td><a href=\"orders_cut_issue_status_form2.php?doc_no=$doc_no\">Create</a></td>";
				}
			}
			$acis_date="";
			$acis_modno="";
			$acis_remarks="";
			$sql2="select * from $bai_pro3.act_cut_issue_status where doc_no=$doc_no";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$acis_date=$sql_row2['date'];
				$acis_modno=$sql_row2['mod_no'];
				$acis_remarks=$sql_row2['remarks'];
				$acis_shift=$sql_row2['shift'];
			}
			
			echo "<td>$acis_date</td><td>$acis_modno</td><td>$acis_shift</td>";
			//echo "<td>$acis_remarks</td>";

			echo "</tr>";

			}
			echo "</table>";
		// }
		// else
		// {
			
		// 	echo "<div class='alert alert-danger' role='alert' style='text-align:center;'>Requested Docket doesnot exist or Fabric Not issued to this docket. Please contact your planner/RM Team.</div>";
		// }
	}
	else
	{
		echo "<div class='alert alert-danger' role='alert' style='text-align:center;'>Please enter valid Docket Reference</div>";
	}
}	
else
{
	echo "<div class='alert alert-danger' role='alert' style='text-align:center;'>Clubbed Docket not eligible to report in this interface, Please try in Without Rolls interface</div>";
}
}
?>

<?php

if(isset($_POST['submit2']))
{
	
	echo "<hr/>";
	$cid=$_POST['cid'];
	
	
	if($cid>0)
	{
		
	
	$sql="select cat_ref,order_tid,fabric_status,category from $bai_pro3.order_cat_doc_mk_mix where cat_ref=$cid";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$cat_ref=$sql_row['cat_ref'];
		$order_tid=$sql_row['order_tid'];
		if($sql_row['category']=="Body" or $sql_row['category']=="Front")
		{
			$fabric_status=$sql_row['fabric_status'];
		}
		else
		{
			$fabric_status=5;
		}
	}
	echo $cat_ref;
	
	if($cat_ref>0)
	
	//if($cat_ref>0 and $fab_status==5)
	{
		
	
	
$cat_id=$cat_ref;
$date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));


echo "<div class='table-responsive'><table class='table table-bordered'>";
echo "<tr class='tblheading'>";
echo "<th>Doc ID</th><th>Cut No</th><th>XS</th><th>S</th><th>M</th><th>L</th><th>XL</th><th>XXL</th><th>XXXL</th><th>s01</th><th>s02</th><th>s03</th><th>s04</th><th>s05</th><th>s06</th><th>s07</th><th>s08</th><th>s09</th><th>s10</th><th>s11</th><th>s12</th><th>s13</th><th>s14</th><th>s15</th><th>s16</th><th>s17</th><th>s18</th><th>s19</th><th>s20</th><th>s21</th><th>s22</th><th>s23</th><th>s24</th><th>s25</th><th>s26</th><th>s27</th><th>s28</th><th>s29</th><th>s30</th><th>s31</th><th>s32</th><th>s33</th><th>s34</th><th>s35</th><th>s36</th><th>s37</th><th>s38</th><th>s39</th><th>s40</th><th>s41</th><th>s42</th><th>s43</th><th>s44</th><th>s45</th><th>s46</th><th>s47</th><th>s48</th><th>s49</th><th>s50</th><th>CUT STAT</th><th>CUT ISSUE STAT</th><th>Control</th>";

echo "<th>Date</th><th>Section</th><th>Shift</th><th>Fab_REC</th><th>Fab_Ret</th><th>Damages</th><th>Shortage</th>";

echo "<th>Control</th><th>Date</th><th>ModNo</th><th>Shift</th>";

echo "</tr>";

$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$doc_no=$sql_row['doc_no'];
	$doc_acutno=$sql_row['acutno'];
	$a_plies=$sql_row['p_plies'];
	$a_xs=$sql_row['a_xs']*$a_plies;
	$a_s=$sql_row['a_s']*$a_plies;
	$a_m=$sql_row['a_m']*$a_plies;
	$a_l=$sql_row['a_l']*$a_plies;
	$a_xl=$sql_row['a_xl']*$a_plies;
	$a_xxl=$sql_row['a_xxl']*$a_plies;
	$a_xxxl=$sql_row['a_xxxl']*$a_plies;
	

$a_s01=$sql_row['a_s01']*$a_plies;
$a_s02=$sql_row['a_s02']*$a_plies;
$a_s03=$sql_row['a_s03']*$a_plies;
$a_s04=$sql_row['a_s04']*$a_plies;
$a_s05=$sql_row['a_s05']*$a_plies;
$a_s06=$sql_row['a_s06']*$a_plies;
$a_s07=$sql_row['a_s07']*$a_plies;
$a_s08=$sql_row['a_s08']*$a_plies;
$a_s09=$sql_row['a_s09']*$a_plies;
$a_s10=$sql_row['a_s10']*$a_plies;
$a_s11=$sql_row['a_s11']*$a_plies;
$a_s12=$sql_row['a_s12']*$a_plies;
$a_s13=$sql_row['a_s13']*$a_plies;
$a_s14=$sql_row['a_s14']*$a_plies;
$a_s15=$sql_row['a_s15']*$a_plies;
$a_s16=$sql_row['a_s16']*$a_plies;
$a_s17=$sql_row['a_s17']*$a_plies;
$a_s18=$sql_row['a_s18']*$a_plies;
$a_s19=$sql_row['a_s19']*$a_plies;
$a_s20=$sql_row['a_s20']*$a_plies;
$a_s21=$sql_row['a_s21']*$a_plies;
$a_s22=$sql_row['a_s22']*$a_plies;
$a_s23=$sql_row['a_s23']*$a_plies;
$a_s24=$sql_row['a_s24']*$a_plies;
$a_s25=$sql_row['a_s25']*$a_plies;
$a_s26=$sql_row['a_s26']*$a_plies;
$a_s27=$sql_row['a_s27']*$a_plies;
$a_s28=$sql_row['a_s28']*$a_plies;
$a_s29=$sql_row['a_s29']*$a_plies;
$a_s30=$sql_row['a_s30']*$a_plies;
$a_s31=$sql_row['a_s31']*$a_plies;
$a_s32=$sql_row['a_s32']*$a_plies;
$a_s33=$sql_row['a_s33']*$a_plies;
$a_s34=$sql_row['a_s34']*$a_plies;
$a_s35=$sql_row['a_s35']*$a_plies;
$a_s36=$sql_row['a_s36']*$a_plies;
$a_s37=$sql_row['a_s37']*$a_plies;
$a_s38=$sql_row['a_s38']*$a_plies;
$a_s39=$sql_row['a_s39']*$a_plies;
$a_s40=$sql_row['a_s40']*$a_plies;
$a_s41=$sql_row['a_s41']*$a_plies;
$a_s42=$sql_row['a_s42']*$a_plies;
$a_s43=$sql_row['a_s43']*$a_plies;
$a_s44=$sql_row['a_s44']*$a_plies;
$a_s45=$sql_row['a_s45']*$a_plies;
$a_s46=$sql_row['a_s46']*$a_plies;
$a_s47=$sql_row['a_s47']*$a_plies;
$a_s48=$sql_row['a_s48']*$a_plies;
$a_s49=$sql_row['a_s49']*$a_plies;
$a_s50=$sql_row['a_s50']*$a_plies;
$plies=$sql_row['a_plies'];

	$remarks=$sql_row['remarks'];
	$act_cut_status=$sql_row['act_cut_status'];
	$act_cut_issue_status=$sql_row['act_cut_issue_status'];
	
$sql33="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row33=mysqli_fetch_array($sql_result33))
{
$color_code=$sql_row33['color_code']; //Color Code
	
}
	
	echo "<tr>";
	
	echo "<td>".leading_zeros($doc_no,9)."</td><td>".chr($color_code).leading_zeros($doc_acutno,3)."</td><td>$a_xs</td><td>$a_s</td><td>$a_m</td><td>$a_l</td><td>$a_xl</td><td>$a_xxl</td><td>$a_xxxl</td><td>$s01</td><td>$s02</td><td>$s03</td><td>$s04</td><td>$s05</td><td>$s06</td><td>$s07</td><td>$s08</td><td>$s09</td><td>$s10</td><td>$s11</td><td>$s12</td><td>$s13</td><td>$s14</td><td>$s15</td><td>$s16</td><td>$s17</td><td>$s18</td><td>$s19</td><td>$s20</td><td>$s21</td><td>$s22</td><td>$s23</td><td>$s24</td><td>$s25</td><td>$s26</td><td>$s27</td><td>$s28</td><td>$s29</td><td>$s30</td><td>$s31</td><td>$s32</td><td>$s33</td><td>$s34</td><td>$s35</td><td>$s36</td><td>$s37</td><td>$s38</td><td>$s39</td><td>$s40</td><td>$s41</td><td>$s42</td><td>$s43</td><td>$s44</td><td>$s45</td><td>$s46</td><td>$s47</td><td>$s48</td><td>$s49</td><td>$s50</td><td>$act_cut_status</td><td>$act_cut_issue_status</td>";
//echo "<td>$remarks</td>";

	if($act_cut_status=="DONE" and $plies==$a_plies)
	{
		echo "<td>NA</td>";
	}
	else
	{
		$create_url = getFullURLLevel($_GET['r'],'orders_cut_issue_status_form1.php',0,'N');
		echo "<td><a  class='btn btn-primary btn-sm' href=".$create_url."&doc_no=$doc_no>Create</a></td>";
	}


		$acs_date="";
		$acs_section="";
		$acs_shift="";
		$acs_fab_received="";
		$acs_fab_returned="";
		$acs_damages="";
		$acs_shortages="";
		$acs_remarks="";
		
	$sql2="select * from $bai_pro3.act_cut_status where doc_no=$doc_no";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$acs_date=$sql_row2['date'];
		$acs_section=$sql_row2['section'];
		$acs_shift=$sql_row2['shift'];
		$acs_fab_received=$sql_row2['fab_received'];
		$acs_fab_returned=$sql_row2['fab_returned'];
		$acs_damages=$sql_row2['damages'];
		$acs_shortages=$sql_row2['shortages'];
		$acs_remarks=$sql_row2['remarks'];
	}
	


	
	echo "<td>$acs_date</td><td>$acs_section</td><td>$acs_shift</td><td>$acs_fab_received</td><td>$acs_fab_returned</td><td>$acs_damages</td><td>$acs_shortages</td>";
//echo "<td>$acs_remarks</td>";


	if($act_cut_issue_status=="DONE")
	{
		//ims implementations
		//echo "<td>Edit</td>";
	}
	else
	{
		if($act_cut_status=="DONE")
		{
			//IMS Implementation
			//echo "<td><a href=\"orders_cut_issue_status_form2.php?doc_no=$doc_no\">Create</a></td>";
		}
	}


		$acis_date="";
		$acis_modno="";
		$acis_remarks="";

	$sql2="select * from $bai_pro3.act_cut_issue_status where doc_no=$doc_no";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$acis_date=$sql_row2['date'];
		$acis_modno=$sql_row2['mod_no'];
		$acis_remarks=$sql_row2['remarks'];
		$acis_shift=$sql_row2['shift'];
	}
	
	echo "<td>$acis_date</td><td>$acis_modno</td><td>$acis_shift</td>";
	//echo "<td>$acis_remarks</td>";

	echo "</tr>";

}
echo "</table></div>";
}
else
{
	echo "<script>sweetAlert('Requested Docket doesnot exist or Fabric Not issued to this docket','Please contact your Planner/RM Team','error');</script>";
	//echo "<div class='alert alert-danger' role='alert' style='text-align:center;'>Requested Docket doesnot exist or Fabric Not issued to this docket. Please contact your planner/RM Team.</div>";
}
}
else
{
	echo "<script>sweetAlert('Please enter valid docket','','error')</script>";
	//echo "<div class='alert alert-danger' role='alert' style='text-align:center;'>Please enter valid Docket Reference</div>";
}
}

?>
</div>
</div>
</div>