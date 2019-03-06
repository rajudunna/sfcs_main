<html>
	<head>
		<title>Bundle Check List</title>
		<script>
			function printDiv(divName) {
				var printContents = document.getElementById(divName).innerHTML;
				var originalContents = document.body.innerHTML;
				document.body.innerHTML = printContents;
				window.print();
				document.body.innerHTML = originalContents;
			}
		</script>
		<?php
			include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
			include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');

			$style = $_GET['style'];
			$schedule = $_GET['schedule'];
			$doc_no = $_GET['doc_no'];
			// echo $style.$schedule.$doc_no;
			$sql12="SELECT order_div FROM $bai_pro3.`bai_orders_db_confirm` WHERE order_del_no='$schedule' limit 1";
			// echo $sql12;
			$sql_result12=mysqli_query($link, $sql12) or exit("Error while fetching details for the selected style and schedule");
			while($m1=mysqli_fetch_array($sql_result12))
			{
				$order_div = $m1['order_div'];
			}
			$sql123="SELECT bundle_loc FROM $bai_pro3.`act_cut_status` WHERE doc_no='$doc_no' limit 1";
			// echo $sql123;
			$sql_result123=mysqli_query($link, $sql123) or exit("Error while fetching details for the selected style and schedule");
			while($m13=mysqli_fetch_array($sql_result123))
			{
				$bundle_loc = $m13['bundle_loc'];
			}
			$sql1="SELECT DISTINCT input_job_no_random, input_job_no FROM $bai_pro3.`pac_stat_log_input_job` WHERE doc_no='$doc_no' order by input_job_no_random*1";
			// echo $sql1;
			$sql_result1=mysqli_query($link, $sql1) or exit("Error while fetching details for the selected style and schedule");
			while($m=mysqli_fetch_array($sql_result1))
			{
				$input_job_no_random_array[$m['input_job_no']] = $m['input_job_no_random'];
			}
		?>
	</head>
	<body>
		<br><center><button onclick="printDiv('printsection')">Print</button></center><br>
		<div id="printsection">
			<style id="test_check123_6065_Styles">
				table
					{mso-displayed-decimal-separator:"\.";
					mso-displayed-thousand-separator:"\,";}
				.xl9018757
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
					border-top:none;
					border-right:.5pt solid windowtext;
					border-bottom:none;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl156065
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
				.xl9418757
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
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
					white-space:nowrap;}
				.xl636065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
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
					vertical-align:middle;
					border-top:none;
					border-right:.5pt solid windowtext;
					border-bottom:.5pt solid windowtext;
					border-left:.5pt solid windowtext;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl646065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
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
					vertical-align:middle;
					border-top:none;
					border-right:.5pt solid windowtext;
					border-bottom:.5pt solid windowtext;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl656065
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
					vertical-align:center;
					border-top:none;
					border-right:.5pt solid windowtext;
					border-bottom:.5pt solid windowtext;
					border-left:.5pt solid windowtext;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl666065
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
					vertical-align:center;
					border-top:none;
					border-right:.5pt solid windowtext;
					border-bottom:.5pt solid windowtext;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl676065
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
					border-top:none;
					border-right:.5pt solid windowtext;
					border-bottom:.5pt solid windowtext;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl686065
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
					vertical-align:center;
					border-top:.5pt solid windowtext;
					border-right:none;
					border-bottom:.5pt solid windowtext;
					border-left:.5pt solid windowtext;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl696065
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
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl706065
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
					border-right:.5pt solid black;
					border-bottom:.5pt solid windowtext;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl716065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
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
					border-top:.5pt solid windowtext;
					border-right:none;
					border-bottom:.5pt solid windowtext;
					border-left:.5pt solid windowtext;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl726065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
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
					border-top:.5pt solid windowtext;
					border-right:none;
					border-bottom:.5pt solid windowtext;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl736065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
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
					border-top:.5pt solid windowtext;
					border-right:.5pt solid black;
					border-bottom:.5pt solid windowtext;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl746065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
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
					vertical-align:middle;
					border-top:.5pt solid windowtext;
					border-right:none;
					border-bottom:.5pt solid windowtext;
					border-left:.5pt solid windowtext;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl756065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
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
					vertical-align:middle;
					border-top:.5pt solid windowtext;
					border-right:none;
					border-bottom:.5pt solid windowtext;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl766065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
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
					vertical-align:middle;
					border-top:.5pt solid windowtext;
					border-right:.5pt solid black;
					border-bottom:.5pt solid windowtext;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl776065
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
					border-left:.5pt solid black;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl786065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
					mso-ignore:padding;
					color:black;
					font-size:11.0pt;
					font-weight:700;
					font-style:normal;
					text-decoration:none;
					font-family:Calibri, sans-serif;
					mso-font-charset:0;
					mso-number-format:General;
					text-align:left;
					vertical-align:top;
					border-top:.5pt solid windowtext;
					border-right:none;
					border-bottom:.5pt solid windowtext;
					border-left:.5pt solid windowtext;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl796065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
					mso-ignore:padding;
					color:black;
					font-size:11.0pt;
					font-weight:700;
					font-style:normal;
					text-decoration:none;
					font-family:Calibri, sans-serif;
					mso-font-charset:0;
					mso-number-format:General;
					text-align:left;
					vertical-align:top;
					border-top:.5pt solid windowtext;
					border-right:.5pt solid black;
					border-bottom:.5pt solid windowtext;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl806065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
					mso-ignore:padding;
					color:black;
					font-size:11.0pt;
					font-weight:700;
					font-style:normal;
					text-decoration:none;
					font-family:Calibri, sans-serif;
					mso-font-charset:0;
					mso-number-format:General;
					text-align:general;
					vertical-align:top;
					border-top:.5pt solid windowtext;
					border-right:none;
					border-bottom:.5pt solid windowtext;
					border-left:.5pt solid windowtext;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl816065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
					mso-ignore:padding;
					color:black;
					font-size:11.0pt;
					font-weight:700;
					font-style:normal;
					text-decoration:none;
					font-family:Calibri, sans-serif;
					mso-font-charset:0;
					mso-number-format:General;
					text-align:general;
					vertical-align:top;
					border-top:.5pt solid windowtext;
					border-right:.5pt solid black;
					border-bottom:.5pt solid windowtext;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl826065
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
					border-top:none;
					border-right:none;
					border-bottom:.5pt solid windowtext;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl836065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
					mso-ignore:padding;
					color:black;
					font-size:20.0pt;
					font-weight:700;
					font-style:normal;
					text-decoration:none;
					font-family:Calibri, sans-serif;
					mso-font-charset:0;
					mso-number-format:General;
					text-align:center;
					vertical-align:middle;
					border-top:.5pt solid windowtext;
					border-right:none;
					border-bottom:none;
					border-left:.5pt solid windowtext;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl846065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
					mso-ignore:padding;
					color:black;
					font-size:20.0pt;
					font-weight:700;
					font-style:normal;
					text-decoration:none;
					font-family:Calibri, sans-serif;
					mso-font-charset:0;
					mso-number-format:General;
					text-align:center;
					vertical-align:middle;
					border-top:.5pt solid windowtext;
					border-right:none;
					border-bottom:none;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl856065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
					mso-ignore:padding;
					color:black;
					font-size:20.0pt;
					font-weight:700;
					font-style:normal;
					text-decoration:none;
					font-family:Calibri, sans-serif;
					mso-font-charset:0;
					mso-number-format:General;
					text-align:center;
					vertical-align:middle;
					border-top:.5pt solid windowtext;
					border-right:.5pt solid black;
					border-bottom:none;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl866065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
					mso-ignore:padding;
					color:black;
					font-size:20.0pt;
					font-weight:700;
					font-style:normal;
					text-decoration:none;
					font-family:Calibri, sans-serif;
					mso-font-charset:0;
					mso-number-format:General;
					text-align:center;
					vertical-align:middle;
					border-top:none;
					border-right:none;
					border-bottom:.5pt solid windowtext;
					border-left:.5pt solid windowtext;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl876065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
					mso-ignore:padding;
					color:black;
					font-size:20.0pt;
					font-weight:700;
					font-style:normal;
					text-decoration:none;
					font-family:Calibri, sans-serif;
					mso-font-charset:0;
					mso-number-format:General;
					text-align:center;
					vertical-align:middle;
					border-top:none;
					border-right:none;
					border-bottom:.5pt solid windowtext;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl886065
					{padding-top:1px;
					padding-right:1px;
					padding-left:1px;
					mso-ignore:padding;
					color:black;
					font-size:20.0pt;
					font-weight:700;
					font-style:normal;
					text-decoration:none;
					font-family:Calibri, sans-serif;
					mso-font-charset:0;
					mso-number-format:General;
					text-align:center;
					vertical-align:middle;
					border-top:none;
					border-right:.5pt solid black;
					border-bottom:.5pt solid windowtext;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl896065
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
					border-bottom:none;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl906065
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
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
				.xl916065
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
					border-top:none;
					border-right:.5pt solid windowtext;
					border-bottom:none;
					border-left:none;
					mso-background-source:auto;
					mso-pattern:auto;
					white-space:nowrap;}
			</style>
			<div id="test_check123_6065" align=center>
				<table border=0 cellpadding=0 cellspacing=0 width=896 style='border-collapse:collapse;table-layout:fixed;width:672pt'>
				 	<col width=64 span=14 style='width:48pt'>
					<tr height=20 style='mso-height-source:userset;height:15.0pt'>
						<td colspan=14 rowspan=2 height=40 class=xl836065 width=896 style='border-right:.5pt solid black;border-bottom:.5pt solid black;height:30.0pt;width:672pt'>Bundle Check List&nbsp;</td>
					</tr>
				 	<tr height=20 style='mso-height-source:userset;height:15.0pt'></tr>
					<tr height=20 style='height:15.0pt'></tr>

					<!-- Header Start -->
					<tr height=20 style='height:15.0pt'>
						<td colspan=2 height=20 class=xl786065 style='border-right:.5pt solid black;height:15.0pt'>Style</td>
						<td colspan=2 class=xl776065 style='border-right:.5pt solid black;border-left:none'><?php echo $style; ?></td>
						<td rowspan=3 class=xl9018757>&nbsp;</td>
						<td colspan=2 class=xl806065 style='border-right:.5pt solid black;border-left:none'>User name</td>
						<td colspan=7 class=xl776065 style='border-right:.5pt solid black;border-left:none'><?php echo $username; ?></td>
					</tr>
					<tr height=20 style='height:15.0pt'>
						<td colspan=2 height=20 class=xl786065 style='border-right:.5pt solid black;height:15.0pt'>Schedule</td>
						<td colspan=2 class=xl776065 style='border-right:.5pt solid black;border-left:none'><?php echo $schedule; ?></td>
						<td colspan=2 class=xl806065 style='border-right:.5pt solid black;border-left:none'>Date</td>
						<td colspan=7 class=xl776065 style='border-right:.5pt solid black;border-left:none'><?php echo date("Y-m-d H:i:s"); ?></td>
					</tr>
					<tr height=20 style='height:15.0pt'>
						<td colspan=2 height=20 class=xl786065 style='border-right:.5pt solid black;height:15.0pt'>Docket Number</td>
						<td colspan=2 class=xl776065 style='border-right:.5pt solid black;border-left:none'><?php echo $doc_no; ?></td>
						<td colspan=2 class=xl806065 style='border-right:.5pt solid black;border-left:none'>Product Category</td>
						<td colspan=7 class=xl776065 style='border-right:.5pt solid black;border-left:none'><?php echo $order_div; ?></td>
					</tr>
					<!-- Header End -->

					<!-- Loop for Sewing Jobs in Docket -->
					<?php
						foreach ($input_job_no_random_array as $key => $value)
						{
							$display_sewing_job = get_sewing_job_prefix_inp('prefix','brandix_bts.tbl_sewing_job_prefix',$key,$value,$link);
							$total_bundle_qty = 0;	$total_bundles = 0;
							$location='';
							if($bundle_loc=='')
							{
								$sql1234="SELECT input_module FROM $bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref='$value' limit 1";
								// echo $sql1;
								$sql_result1234=mysqli_query($link, $sql1234) or exit("Error while fetching details for the selected style and schedule");
								while($m134=mysqli_fetch_array($sql_result1234))
								{
									$input_module = $m134['input_module'];
								}

								if($input_module != "")
								{
									$location="L-".$input_module;
								}
								else
								{
									$location='-';
								}	
							}
							else
							{
								$location=$bundle_loc;
							}
							echo "
								<tr height=20 style='height:15.0pt'></tr>
								<tr height=20 style='height:15.0pt' bgcolor='#BFBFBF'>
									<td colspan=14 height=20 class=xl9418757 style='height:15.0pt'>Sewing Job No: ".$value." ($display_sewing_job)</td>
								</tr>
								<tr height=20 style='height:15.0pt'>
									<td height=20 class=xl636065 style='height:15.0pt'>Sno</td>
									<td colspan=4 class=xl746065 style='border-right:.5pt solid black;border-left:none'>Color</td>
									<td class=xl646065>Size</td>
									<td class=xl646065>Bundles<br>Total<br>Quantity</td>
									<td class=xl646065>Bundles<br>Count</td>
									<td class=xl646065>Bundle<br>Location</td>
									<td colspan=7 class=xl746065 style='border-right:.5pt solid black;border-left:none'>Bundle Numbers - Bundle Quantity</td>
								</tr>";
								$sql123="SELECT order_col_des,size_code, SUM(carton_act_qty) AS qty, COUNT(*) AS bundle_count,GROUP_CONCAT(tid, '-', carton_act_qty) AS bundle_nos 
									FROM bai_pro3.`packing_summary_input` WHERE input_job_no_random='".$value."' and doc_no = '".$doc_no."' GROUP BY order_col_des,size_code;";
								// echo $sql123;
								$sql_result123=mysqli_query($link, $sql123) or exit("Error while fetching details for the selected style and schedule");
								$sno = 1;
								while($n=mysqli_fetch_array($sql_result123))
								{
									$counter = 1;
									$val = explode(',', $n['bundle_nos']);
									$rooo = ceil(count($val)/6);
									echo "
									<tr height=20 style='height:15.0pt'>
										<td height=20 rowspan=$rooo class=xl656065 style='height:15.0pt'>".$sno."</td>
										<td colspan=4 rowspan=$rooo class=xl686065 style='text-align:left; border-right:.5pt solid black;border-left:none'>".$n['order_col_des']."</td>
										<td class=xl666065 rowspan=$rooo>".$n['size_code']."</td>
										<td class=xl666065 rowspan=$rooo >".$n['qty']."</td>
										<td class=xl666065 rowspan=$rooo >".$n['bundle_count']."</td>
										<td class=xl666065 rowspan=$rooo >".$location."</td>";
										for ($i=0; $i < count($val); $i+=6)
										{
											$temp = "";
											if ($counter > 1)
											{
												echo "<tr height=20 style='height:15.0pt'>";
											}
												for($m=$i;$m<$i+6;$m++)
												{
													if ($val[$m] != '' || $val[$m] != null) 
													{
														$temp.= $val[$m].', ';
													}
												}
												$display = substr($temp, 0, -2);
												echo "<td colspan=7 class=xl686065 style='border-right:.5pt solid black;border-left:none'>$display</td>";
											if ($counter > 1)
											{
												echo "</tr>";
											}
											$counter++;
										}
									echo "</tr>";
									$sno++;
									$total_bundle_qty = $total_bundle_qty+$n['qty'];
									$total_bundles = $total_bundles+$n['bundle_count'];
								}								

								echo "
								<tr height=20 style='height:15.0pt'>
									<td colspan=6 height=20 class=xl716065 style='border-right:.5pt solid black;height:15.0pt'>Total Quantity</td>
									<td class=xl676065>".$total_bundle_qty."</td>
									<td class=xl676065>".$total_bundles."</td>
									<td colspan=8 class=xl686065 style='border-right:.5pt solid black;border-left:none'></td>
								</tr>
							";
						}
							
					?>


					<tr height=0 style='display:none'>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>