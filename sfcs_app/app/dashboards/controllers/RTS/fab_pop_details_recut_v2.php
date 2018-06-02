<!--
changes log:

2014-02-14/kirang/Ticket 684035 : Add "varalakshmik","eswarraok","babjim","ramunaidus" users in $authorized array for recut dashboard green colour box access.

2014-05-29/kirang/Ticket 854380 : Add "nagendral" user in $authorized array for recut dashboard green colour box access.
2014-05-29/kirang/Service Request #370686: Add sivaramakrishnat in $authorized array For recut dashboard green colour box access
-->

<script type="text/javascript">

	function check_validate()
	{
		//var docket=document.getElementById("doc_no").value;
		var total_req=parseInt(document.getElementById("tot_req").value);
		var allocation=parseInt(document.getElementById("alloc_qty").value);
		var selection=document.getElementById("issue_status").value;
		var doc_tot=document.getElementById("doc_tot").value;
		var alloc_doc=document.getElementById("alloc_doc").value;
		//alert(docket); 	 	
		//alert(total_req);
		//var total_req=1082.4;	
		//var allocation=1082.4;
		//alert(allocation); 	 	
		//alert("test");
		//if(selection==)
		//{
			if(0<allocation)
			{
				document.getElementById("submit").disabled=false;
				if(total_req == allocation)
				{
				
				}
				else if(total_req < allocation)
				{
					//alert('test');
					var diff=allocation-total_req;
					numb = diff.toFixed(2);
					if(confirm("You are sending morethan required quantity :" +numb+ " Yrds."))
					{
						//window.open("update.php?docket="+docket+"&req_qty="+total_req+"&alloc_qty="+allocation+"&check=check_out", "_blank", "resizable=yes,top=100,left=100,width=750,height=400");
						//alert("Test");
						//documnet.getElementById("dvremark").display.show;
						document.getElementById('dvremark').style.display = "block";
					}
					else
					{
						//alert("Test1");
						//window.open("update.php?docket="+docket+"check=check_out", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400");
						//return false;
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
					if(confirm("You are sending lessthan required quantity :" +numb+ " Yrds."))
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
			else if (allocation==0 && doc_tot==alloc_doc)
			{
				sweetAlert("You have allocated \"STOCK\" for some of the dockets ");
				document.getElementById('dvremark').style.display = "block";
				document.getElementById("submit").disabled=false;
			}
			else
			{
				//alert(allocation);
				sweetAlert("Please allocate the material to the Docket");
				document.getElementById("validate").checked=false;
				document.getElementById("submit").disabled=true;
				document.getElementById("remarks").value="";
				document.getElementById('dvremark').style.display = "none";
				return false;
			}
		//}
		//else
	/*	{
			alert("Please Select the issue to module.");
			document.getElementById("validate").checked=false;
			document.getElementById("submit").disabled=true;
			document.getElementById("remarks").value="";
			document.getElementById('dvremark').style.display = "none";
			return false;
		}	
	*/
	}
	function validate_but()
	{
			//alert('check');
			var total_require=parseInt(document.getElementById("tot_req").value);
			var allocation_require=parseInt(document.getElementById("alloc_qty").value);
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
					sweetAlert("Please fill the remark...! \nPlease enter minimum 8 characters..");
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


<script>

	function numbersOnly()
	{
	var charCode = event.keyCode;

				if ((charCode > 47 && charCode < 58) || charCode == 8 || charCode == 127 || charCode == 11)
					{
						return true;
					}
					else
					{
						return false;
					}
	}

</script>

<?php
     include("../".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include("../".getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    include("../".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
	//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
	$username_list=explode('\\',$_SERVER['REMOTE_USER']);
	$username=$username_list[1];
	$view_access=user_acl("SFCS_0197",$username,1,$group_id_sfcs);
	$authorized=user_acl("SFCS_0197",$username,7,$group_id_sfcs);
	//$authorized=array("kirang","harikrishnar","fazlulr","himapriyag","sfcsproject1","chandrasekharko","herambaj","kishorek","kirang","sarojiniv","kirang","ravipu","ramanav","sekhark","lovakumarig","ganeshb","pithanic","srinivasaraot","santhoshbo","vemanas","dharmarajua","bhupalv","varalakshmik","eswarraok","babjim","ramunaidus","nagendral","sivaramakrishnat","gowthamis","rajinig","revathil","lovarajub","ramud","sivark","kirang","kirang");
	//$authorized=array("kirang");
	if(!(in_array(strtolower($username),$authorized)))
	{
		// header("Location:restrict.php");
	}

?>

<?php
	set_time_limit(2000);
	$doc_no=$_GET['doc_no'];
	$pop_restriction=$_GET['pop_restriction'];
	$group_docs=$_GET['group_docs'];
?>

<link rel="stylesheet" type="text/css" href="page_style.css" />

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

<div class="panel panel-primary" onload="dodisable()">
<div class="panel-heading"><b>Fabric Status:</b></div>
<div class="panel-body">

	<div class="row">

		<?php

		echo "<div class='col-md-5'><h2>Fabric Status</h2>
		<div id=\"msg\">
		<center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing data...</font></h1></center>
		</div>";
			
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

		$sql1="SELECT * from $bai_pro3.recut_v2 where doc_no=$doc_no";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error:$sql1 ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			
			$order_tid=$sql_row1['order_tid'];
			$sql11="SELECT * from bai_orders_db where order_tid=\"$order_tid\"";
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error: $sql11".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{
				$style=$sql_row11['order_style_no'];
				$schedule=$sql_row11['order_del_no'];
				echo "<tr>";
				echo "<td>".$sql_row11['order_style_no']."</td>";
				echo "<td>".$sql_row11['order_del_no']."</td>";
				echo "<td>".$sql_row11['order_col_des']."</td>";
				echo "<td>"."R".leading_zeros($sql_row1['acutno'],3)."</td>";
				echo "</tr>";
			}
			
			$cut_no_ref=$sql_row1['acutno'];
			$order_id_ref=$sql_row1['order_tid'];
			$style_ref=$sql_row1['order_tid'];
			
			$sizes_table.="<table class='table table-bordered'><tr><th>Size</th><th>Qty</th></tr>";
			if($sql_row1['a_xs']>0){ $sizes_table.="<tr><td>XS</td><td>".$sql_row1['a_xs']."</td></tr>";}
			if($sql_row1['a_s']>0){ $sizes_table.="<tr><td>S</td><td>".$sql_row1['a_s']."</td></tr>";}
			if($sql_row1['a_m']>0){ $sizes_table.="<tr><td>M</td><td>".$sql_row1['a_m']."</td></tr>";}
			if($sql_row1['a_l']>0){ $sizes_table.="<tr><td>L</td><td>".$sql_row1['a_l']."</td></tr>";}
			if($sql_row1['a_xl']>0){ $sizes_table.="<tr><td>XL</td><td>".$sql_row1['a_xl']."</td></tr>";}
			if($sql_row1['a_xxl']>0){ $sizes_table.="<tr><td>XXL</td><td>".$sql_row1['a_xxl']."</td></tr>";}
			if($sql_row1['a_xxxl']>0){ $sizes_table.="<tr><td>XXXL</td><td>".$sql_row1['a_xxxl']."</td></tr>";}
			if($sql_row1['a_s01']>0){ $sizes_table.="<tr><td>S01</td><td>".$sql_row1['a_s01']."</td></tr>";}
			if($sql_row1['a_s02']>0){ $sizes_table.="<tr><td>S02</td><td>".$sql_row1['a_s02']."</td></tr>";}
			if($sql_row1['a_s03']>0){ $sizes_table.="<tr><td>S03</td><td>".$sql_row1['a_s03']."</td></tr>";}
			if($sql_row1['a_s04']>0){ $sizes_table.="<tr><td>S04</td><td>".$sql_row1['a_s04']."</td></tr>";}
			if($sql_row1['a_s05']>0){ $sizes_table.="<tr><td>S05</td><td>".$sql_row1['a_s05']."</td></tr>";}
			if($sql_row1['a_s06']>0){ $sizes_table.="<tr><td>S06</td><td>".$sql_row1['a_s06']."</td></tr>";}
			if($sql_row1['a_s07']>0){ $sizes_table.="<tr><td>S07</td><td>".$sql_row1['a_s07']."</td></tr>";}
			if($sql_row1['a_s08']>0){ $sizes_table.="<tr><td>S08</td><td>".$sql_row1['a_s08']."</td></tr>";}
			if($sql_row1['a_s09']>0){ $sizes_table.="<tr><td>S09</td><td>".$sql_row1['a_s09']."</td></tr>";}
			if($sql_row1['a_s10']>0){ $sizes_table.="<tr><td>S10</td><td>".$sql_row1['a_s10']."</td></tr>";}
			if($sql_row1['a_s11']>0){ $sizes_table.="<tr><td>S11</td><td>".$sql_row1['a_s11']."</td></tr>";}
			if($sql_row1['a_s12']>0){ $sizes_table.="<tr><td>S12</td><td>".$sql_row1['a_s12']."</td></tr>";}
			if($sql_row1['a_s13']>0){ $sizes_table.="<tr><td>S13</td><td>".$sql_row1['a_s13']."</td></tr>";}
			if($sql_row1['a_s14']>0){ $sizes_table.="<tr><td>S14</td><td>".$sql_row1['a_s14']."</td></tr>";}
			if($sql_row1['a_s15']>0){ $sizes_table.="<tr><td>S15</td><td>".$sql_row1['a_s15']."</td></tr>";}
			if($sql_row1['a_s16']>0){ $sizes_table.="<tr><td>S16</td><td>".$sql_row1['a_s16']."</td></tr>";}
			if($sql_row1['a_s17']>0){ $sizes_table.="<tr><td>S17</td><td>".$sql_row1['a_s17']."</td></tr>";}
			if($sql_row1['a_s18']>0){ $sizes_table.="<tr><td>S18</td><td>".$sql_row1['a_s18']."</td></tr>";}
			if($sql_row1['a_s19']>0){ $sizes_table.="<tr><td>S19</td><td>".$sql_row1['a_s19']."</td></tr>";}
			if($sql_row1['a_s20']>0){ $sizes_table.="<tr><td>S20</td><td>".$sql_row1['a_s20']."</td></tr>";}
			if($sql_row1['a_s21']>0){ $sizes_table.="<tr><td>S21</td><td>".$sql_row1['a_s21']."</td></tr>";}
			if($sql_row1['a_s22']>0){ $sizes_table.="<tr><td>S22</td><td>".$sql_row1['a_s22']."</td></tr>";}
			if($sql_row1['a_s23']>0){ $sizes_table.="<tr><td>S23</td><td>".$sql_row1['a_s23']."</td></tr>";}
			if($sql_row1['a_s24']>0){ $sizes_table.="<tr><td>S24</td><td>".$sql_row1['a_s24']."</td></tr>";}
			if($sql_row1['a_s25']>0){ $sizes_table.="<tr><td>S25</td><td>".$sql_row1['a_s25']."</td></tr>";}
			if($sql_row1['a_s26']>0){ $sizes_table.="<tr><td>S26</td><td>".$sql_row1['a_s26']."</td></tr>";}
			if($sql_row1['a_s27']>0){ $sizes_table.="<tr><td>S27</td><td>".$sql_row1['a_s27']."</td></tr>";}
			if($sql_row1['a_s28']>0){ $sizes_table.="<tr><td>S28</td><td>".$sql_row1['a_s28']."</td></tr>";}
			if($sql_row1['a_s29']>0){ $sizes_table.="<tr><td>S29</td><td>".$sql_row1['a_s29']."</td></tr>";}
			if($sql_row1['a_s30']>0){ $sizes_table.="<tr><td>S30</td><td>".$sql_row1['a_s30']."</td></tr>";}
			if($sql_row1['a_s31']>0){ $sizes_table.="<tr><td>S31</td><td>".$sql_row1['a_s31']."</td></tr>";}
			if($sql_row1['a_s32']>0){ $sizes_table.="<tr><td>S32</td><td>".$sql_row1['a_s32']."</td></tr>";}
			if($sql_row1['a_s33']>0){ $sizes_table.="<tr><td>S33</td><td>".$sql_row1['a_s33']."</td></tr>";}
			if($sql_row1['a_s34']>0){ $sizes_table.="<tr><td>S34</td><td>".$sql_row1['a_s34']."</td></tr>";}
			if($sql_row1['a_s35']>0){ $sizes_table.="<tr><td>S35</td><td>".$sql_row1['a_s35']."</td></tr>";}
			if($sql_row1['a_s36']>0){ $sizes_table.="<tr><td>S36</td><td>".$sql_row1['a_s36']."</td></tr>";}
			if($sql_row1['a_s37']>0){ $sizes_table.="<tr><td>S37</td><td>".$sql_row1['a_s37']."</td></tr>";}
			if($sql_row1['a_s38']>0){ $sizes_table.="<tr><td>S38</td><td>".$sql_row1['a_s38']."</td></tr>";}
			if($sql_row1['a_s39']>0){ $sizes_table.="<tr><td>S39</td><td>".$sql_row1['a_s39']."</td></tr>";}
			if($sql_row1['a_s40']>0){ $sizes_table.="<tr><td>S40</td><td>".$sql_row1['a_s40']."</td></tr>";}
			if($sql_row1['a_s41']>0){ $sizes_table.="<tr><td>S41</td><td>".$sql_row1['a_s41']."</td></tr>";}
			if($sql_row1['a_s42']>0){ $sizes_table.="<tr><td>S42</td><td>".$sql_row1['a_s42']."</td></tr>";}
			if($sql_row1['a_s43']>0){ $sizes_table.="<tr><td>S43</td><td>".$sql_row1['a_s43']."</td></tr>";}
			if($sql_row1['a_s44']>0){ $sizes_table.="<tr><td>S44</td><td>".$sql_row1['a_s44']."</td></tr>";}
			if($sql_row1['a_s45']>0){ $sizes_table.="<tr><td>S45</td><td>".$sql_row1['a_s45']."</td></tr>";}
			if($sql_row1['a_s46']>0){ $sizes_table.="<tr><td>S46</td><td>".$sql_row1['a_s46']."</td></tr>";}
			if($sql_row1['a_s47']>0){ $sizes_table.="<tr><td>S47</td><td>".$sql_row1['a_s47']."</td></tr>";}
			if($sql_row1['a_s48']>0){ $sizes_table.="<tr><td>S48</td><td>".$sql_row1['a_s48']."</td></tr>";}
			if($sql_row1['a_s49']>0){ $sizes_table.="<tr><td>S49</td><td>".$sql_row1['a_s49']."</td></tr>";}
			if($sql_row1['a_s50']>0){ $sizes_table.="<tr><td>S50</td><td>".$sql_row1['a_s50']."</td></tr>";}
			$sizes_table.="<tr><td>Total QTY</td><td>".($sql_row1['a_xs']+$sql_row1['a_s']+$sql_row1['a_m']+$sql_row1['a_l']+$sql_row1['a_xl']+$sql_row1['a_xxl']+$sql_row1['a_xxxl']+$sql_row1['a_s01']+$sql_row1['a_s02']+$sql_row1['a_s03']+$sql_row1['a_s04']+$sql_row1['a_s05']+$sql_row1['a_s06']+$sql_row1['a_s07']+$sql_row1['a_s08']+$sql_row1['a_s09']+$sql_row1['a_s10']+$sql_row1['a_s11']+$sql_row1['a_s12']+$sql_row1['a_s13']+$sql_row1['a_s14']+$sql_row1['a_s15']+$sql_row1['a_s16']+$sql_row1['a_s17']+$sql_row1['a_s18']+$sql_row1['a_s19']+$sql_row1['a_s20']+$sql_row1['a_s21']+$sql_row1['a_s22']+$sql_row1['a_s23']+$sql_row1['a_s24']+$sql_row1['a_s25']+$sql_row1['a_s26']+$sql_row1['a_s27']+$sql_row1['a_s28']+$sql_row1['a_s29']+$sql_row1['a_s30']+$sql_row1['a_s31']+$sql_row1['a_s32']+$sql_row1['a_s33']+$sql_row1['a_s34']+$sql_row1['a_s35']+$sql_row1['a_s36']+$sql_row1['a_s37']+$sql_row1['a_s38']+$sql_row1['a_s39']+$sql_row1['a_s40']+$sql_row1['a_s41']+$sql_row1['a_s42']+$sql_row1['a_s43']+$sql_row1['a_s44']+$sql_row1['a_s45']+$sql_row1['a_s46']+$sql_row1['a_s47']+$sql_row1['a_s48']+$sql_row1['a_s49']+$sql_row1['a_s50'])."</td>";
			$sizes_table.="</table>";

			$mns_status=$sql_row1['a_xs']+$sql_row1['a_s']+$sql_row1['a_m']+$sql_row1['a_l']+$sql_row1['a_xl']+$sql_row1['a_xxl']+$sql_row1['a_xxxl'];
			
			$plan_module=$sql_row1['plan_module'];
		}

		echo "</table></div></div>";

		//echo $sizes_table;

		//NEW Implementation for Docket generation from RMS

		echo "<div class='row'>
		<div class='col-md-8'><h2>Re-Cut Docket Print</h2>";

		if($plan_module=="TOP")
		{
			$type=1; //for Samplese
		}
		else
		{
			$type=2; // For normal recut
		}

		$path="getFullURLLevel($_GET['r'],'Book3_print_recut.php',0,'N')";
		if(substr($style_ref,0,1)!="P" or substr($style_ref,0,1)!="K" or substr($style_ref,0,1)!="L" or substr($style_ref,0,1)!="O" )
		{
			if($mns_status>0)
			{
				$path="getFullURLLevel($_GET['r'],'Book3_print_recut.php',0,'N')";  // For M&S Men Briefs
			}
			else
			{
				$path="getFullURLLevel($_GET['r'],'Book3_print_recut1.php',0,'N')"; // FOR M&S Ladies Briefs
			}
			
		}

		else
		{
			if(substr($style_ref,0,1)=="Y")
			{
				if($mns_status>0)
				{
					$path="getFullURLLevel($_GET['r'],'Book3_print_recut.php',0,'N')";  // For M&S Men Briefs
				}
				else
				{
					$path="getFullURLLevel($_GET['r'],'Book3_print_recut1.php',0,'N')"; // FOR M&S Ladies Briefs
				}
			}
			
		}
		
		echo "<form name=\"ins\" method=\"post\" action='".getFullURL($_GET['r'],'fab_pop_allocate_v5.php','R')."'>"; //new version
		echo "<input type=\"hidden\" value=\"2\" name=\"process_cat\">"; //this is to identify recut or normal processing of docket (1 for normal 2 for recut)
		echo "<table class='table table-bordered'><tr><th>Category -- Docket</th><th>Material Req.</th><th>Control</th><th>Print Status</th><th>Roll Details</th></tr>";
		//$sql1="SELECT recut_v2.a_plies,recut_v2.mk_ref,recut_v2.plan_lot_ref,recut_v2.cat_ref,recut_v2.print_status,recut_v2.doc_no,cat_stat_log.category,cat_stat_log.compo_no from recut_v2 left join cat_stat_log on recut_v2.cat_ref=cat_stat_log.tid  where recut_v2.order_tid=\"$order_id_ref\" and recut_v2.acutno=$cut_no_ref"; //OLD
		$sql1="SELECT order_cat_recut_doc_mk_mix.mk_ref,order_cat_recut_doc_mk_mix.material_req,order_cat_recut_doc_mk_mix.plan_lot_ref,order_cat_recut_doc_mk_mix.cat_ref,order_cat_recut_doc_mk_mix.print_status,order_cat_recut_doc_mk_mix.doc_no,order_cat_recut_doc_mk_mix.category,order_cat_recut_doc_mk_mix.a_plies from $bai_pro3.order_cat_recut_doc_mk_mix where order_cat_recut_doc_mk_mix.order_tid=\"$order_id_ref\" and order_cat_recut_doc_mk_mix.acutno=$cut_no_ref";
		//echo $sql1;

		//mysql_query($sql1,$link) or exit("Sql Error: $sql1".mysql_error());
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error: $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result1);
		$enable_allocate_button=0;
		$docket_num=array();
		$total=0;$allc_doc=0;
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			//echo $sql_row1['cat_ref']."<br/>";
			//echo $sql_row1['doc_no']."<br/>";
			//echo $sql_row1['category']."<br/>";
			echo "<tr><td>".$sql_row1['category']."--".$sql_row1['doc_no']."</td>";
			echo "<td>".($sql_row1['material_req'])."</td>";
			$docket_num[]=$sql_row1['doc_no'];
			$mk_ref=$sql_row1['mk_ref'];
			
			$sql2="select * from $bai_pro3.maker_stat_log where tid=$mk_ref";
			//mysql_query($sql2,$link) or exit("Sql Error".mysql_error());
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error: $sql2".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$mklength=$sql_row2['mklength'];
			}
			
			$material_req=$mklength*$sql_row1['a_plies'];
			$extra=0;
			//if(substr($style_ref,0,1)=="M") { $extra=round(($material_req*0.01),2); }
			{ $extra=round(($material_req*0.01),2); }
			//echo "<td>".($material_req+$extra)."</td>";
			$temp_tot=($material_req);
			$total+=$temp_tot;
			$temp_tot=0;
			//For new implementation
			
			$doc_cat=$sql_row1['category'];
			$doc_com=$sql_row1['compo_no'];
			$doc_mer=($sql_row1['material_req']+$extra);
			$cat_ref=$sql_row1['cat_ref'];
			
			
			//echo "<td><a href=\"$path?order_tid=$order_id_ref&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."\" onclick=\"Popup1=window.open('$path?order_tid=$order_id_ref&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";

			if(strlen($sql_row1['plan_lot_ref'])>0)
			{
				echo "<td><a href=\"$path?order_tid=$order_id_ref&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&type=$type\" onclick=\"Popup1=window.open('$path?order_tid=$order_id_ref&cat_ref=".$sql_row1['cat_ref']."&doc_id=".$sql_row1['doc_no']."&type=$type','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\">Print</a></td>";
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
				
				$sql1x="select ref1,lot_no from $bai_rm_pj1.fabric_status where item in (select compo_no from cat_stat_log where tid=\"".$sql_row1['cat_ref']."\")";
				$sql_result1x=mysqli_query($link, $sql1x) or exit("Sql Error: $sql1x".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1x=mysqli_fetch_array($sql_result1x))
				{
					echo "<input type=\"checkbox\" value=\"".$sql_row1x['lot_no'].">".$sql_row1x['ref1']."\" name=\"".$sql_row1['doc_no']."[]\">".$sql_row1x['lot_no']."<br/>";
					
				}
				echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\" onkeypress=\"return numbersOnly(event)\"/><br/>";
				echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\" onkeypress=\"return numbersOnly(event)\"/><br/>";
				echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\" onkeypress=\"return numbersOnly(event)\"/><br/>";
				echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\" onkeypress=\"return numbersOnly(event)\"/><br/>";
				echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\" onkeypress=\"return numbersOnly(event)\"/><br/>";
				echo "<input type=\"text\" value=\"\" name=\"manual".$sql_row1['doc_no']."[]\" size=\"12\" onkeypress=\"return numbersOnly(event)\"/><br/>";		
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
			
			
		if($sql_row1['print_status']>0)
		{
			$img_path = getFullURLLevel($_GET['r'],'common/images/correct.png',2,'R');
			echo "<td><img src='".$img_path."'></td>";
			echo "<td>";
			
			include_once('../'.getFullURL($_GET['r'],'fab_detail_track_include.php','R'));
			getDetails("R",$sql_row1['doc_no']);
			echo "</td>";
		}
		else
		{
			echo "<td></td>";
			echo "<td></td>";
		}

		echo "</tr>";
			
		}
		echo "<tr><td colspan=1><center>Total Required Material</center></td><td>$total</td><td></td><td></td><td></td></tr>";
		echo "</table>";
		if($enable_allocate_button==1)
		{
			echo "<input type=\"submit\" name=\"allocate\" value=\"Allocate\" onclick=\"button_disable()\" class='btn btn-success'>";
			echo '<div id="process_message"><h2><font color="red">Please wait while updating data!!!</font><br/><font color="blue">After update, this window will close automatically!</font></h2></div>';
		}
		echo "</form>";
		//NEW Implementation for Docket generation from RMS

		$sql1="SELECT * from $bai_pro3.plan_dashboard where doc_no=$doc_no";
		//mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error: $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result1);
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$fabric_status=$sql_row1['fabric_status'];
		}

		$sql111="select ROUND(SUM(allocated_qty),2) AS alloc,count(distinct doc_no) as doc_count from $bai_rm_pj1.fabric_cad_allocation where doc_no in (".implode(",",$docket_num).")";
		//echo $sql111."<br>";
		$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error--1: $sql111".mysqli_error($GLOBALS["___mysqli_ston"]));
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
				$allc_doc=$sql_row111['doc_count'];
			}
		?>

		</div></div>

		<div class="row">

			

		<form name="input" method="post" action="?r=<?php echo $_GET['r']; ?>" onsubmit=" return validate_but();">
			
			<div class="col-md-3">

			Fabric Issue Status: <select name="issue_status" id="issue_status" class="form-control">

			<?php
				if($fabric_status!="5")
				{
					echo '<option value="-1">Stock Out</option>';
				}
			?>
			<option value="5" <?php if($fabric_status=="5") { echo " selected"; }?>>Issued To Module</option>
			</select></td><br>
			<td>
			<input type="checkbox" name="validate" id="validate" onclick="check_validate()"/><td>
			<input type="hidden" value="<?php echo round($total,2); ?>" name="tot_req" id="tot_req"/>
			<input type="hidden" value="<?php echo $alloc_qty; ?>" name="alloc_qty" id="alloc_qty"/>
			<input type="hidden" value="<?php echo $style; ?>" name="style" id="style"/>
			<input type="hidden" value="<?php echo $schedule; ?>" name="schedule" id="schedule"/>
			<input type="hidden" value="<?php echo $allc_doc; ?>" name="alloc_doc" id="alloc_doc"/>
			<input type="hidden" value="<?php echo sizeof($docket_num); ?>" name="doc_tot" id="doc_tot"/>
			<td>
			<div id="dvremark" style="display: none">
			<center>Remark:</center>
			<textarea id="remarks" rows="4" cols="50" name="remarks" placeholder="Please fill the remarks">
			
			</textarea>	

			</div>
			</td><td>
				<?php
					if($pop_restriction==0)
					{
						echo '<input type="submit" name="submit" id="submit" value="Update" disabled="disabled" class="btn btn-success">';
					}
					else
					{
						echo "<font color=red>It's too early to issue to module.</font>";
					}
					echo "<input type=\"hidden\" name=\"group_docs\" value=".implode(",",$docket_num).">";
				?>
			</td></tr>
			</table>
		</form>

		<script>
			document.getElementById("msg").style.display="none";		
		</script>

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
				//echo $reason."<br>";
				//echo $group_docs."<br>";
				//echo sizeof($group_docs)."<br>";
				//echo "Alloc_docketd--".$alloc_docket."--total allocted--".$doc_tot."--issue_status--".$issue_status."--total_docket--".sizeof($group_docs)."--reasno---".$reason."--style--".$style."--scheudle--".$schedule."<br>";
				$doc_num=explode(",",$group_docs);
				for($i=0;$i<sizeof($doc_num);$i++)
				{
					//echo $doc_num[$i]."<br>";
					$doc_no_loc="R".$doc_num[$i];
					//echo $doc_no_loc."<br>";
					$sql111="select * from $bai_rm_pj1.fabric_cad_allocation where doc_no='".$doc_num[$i]."' and status=1";
					//echo $sql111."<br>";
					$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error--1: $sql111".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($sql_result111)>0)
					{
						//$sql2="update recut_v2 set fabric_status='5' where doc_no='".$doc_num[$i]."'";
						//echo $sql2."<br>";	
						//mysql_query($sql2,$link) or exit("Sql Error----5".mysql_error());
						while($row2=mysqli_fetch_array($sql_result111))
						{
							$code=$row2['roll_id'];
							$tran_pin=$row2['tran_pin'];
							$sql1="select ref1,qty_rec,qty_issued,qty_ret,partial_appr_qty from $bai_rm_pj1.store_in where roll_status in (0,2) and tid=\"$code\"";
							//echo $sql1."<br>";
							$sql_result=mysqli_query($link, $sql1) or exit("Sql Error--1: $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row=mysqli_fetch_array($sql_result))
							{
								$qty_rec=$sql_row['qty_rec']-$sql_row['partial_appr_qty'];
								$qty_issued=$sql_row['qty_issued'];
								$qty_ret=$sql_row['qty_ret'];
							}
							$qty_iss=$row2['allocated_qty'];
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
							
							if((($qty_rec-($qty_iss+$qty_issued))+$qty_ret)>=0 && $qty_iss > 0)
							{
								
								$sql22="update $bai_rm_pj1.store_in set qty_issued=".($qty_issued+$qty_iss).", status=$status, allotment_status=$status where tid=\"$code\"";
								//echo $sql22."<br>";
								mysqli_query($link, $sql22) or exit("Sql Error----3: $sql22".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								$sql211="select * from $bai_rm_pj1.store_out where tran_tid='".$code."' and qty_issued='".$qty_iss."' and Style='".$style."' and Schedule='".$schedule."' and cutno='".$doc_no_loc."' and date='".date("Y-m-d")."' and updated_by='".$username."' and remarks='".$reason."' and log_stamp='".date("Y-m-d H:i:s")."'";
								//echo $sql211."<br>"; 
								$sql_result211=mysqli_query($link, $sql211) or exit("Sql Error--211: $sql211".mysqli_error($GLOBALS["___mysqli_ston"]));
								$sql_num_check=mysqli_num_rows($sql_result211);
								//echo "no of rows=".$sql_num_check."<br/>";
								if($sql_num_check==0)
								{
									$sql23="insert into $bai_rm_pj1.store_out (tran_tid,qty_issued,Style,Schedule,cutno,date,updated_by,remarks,log_stamp) values ('".$code."', '".$qty_iss."','".$style."','".$schedule."','".$doc_no_loc."','".date("Y-m-d")."','".$username."','".$reason."','".date("Y-m-d H:i:s")."')";
									//echo $sql23."<br>";
									mysqli_query($link, $sql23) or exit("Sql Error----4: $sql23".mysqli_error($GLOBALS["___mysqli_ston"]));
								}
								$sql24="update $bai_rm_pj1.fabric_cad_allocation set status=2 where tran_pin=\"$tran_pin\"";
								//echo $sql24."<br>";
								mysqli_query($link, $sql24) or exit("Sql Error----3: $sql24".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								
								
							}
						
						}
					}	
				
				}
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
						
						//if($issue_status==5 && $alloc_docket==$doc_tot)
						if($issue_status==5)
						{
										
							for($i=0;$i<sizeof($doc_num);$i++)
							{
								$sql2="update $bai_pro3.recut_v2 set fabric_status='5' where doc_no='".$doc_num[$i]."'";
								//echo $sql2."<br>";	
								mysqli_query($link, $sql2) or exit("Sql Error----5: $sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
						}
					
					//}

			echo "<script type=\"text/javascript\"> window.close(); </script>";
			}
		?>

		<?php

			if(isset($_POST['allocate']))
			{

				//echo "test";
				$doc=$_POST['doc'];
				
				for($i=0;$i<sizeof($doc);$i++)
				{
					$temp='lot'.$doc[$i];
					$lot=$_POST[$temp];		
					echo $lot[$i].">".$doc[$i].">".sizeof($lot[$i])."<br/>";
				}
				
			}

		?>
	</div>
	</div>
</div>