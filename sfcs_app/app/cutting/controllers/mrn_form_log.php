
<?php 
//include("security1.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R')); 
var_dump(haspermission($_GET['r']));
//$view_access=user_acl("SFCS_0073",$username,1,$group_id_sfcs);
//$duplicate_print_users=user_acl("SFCS_0073",$username,7,$group_id_sfcs);
//$duplicate_print_users=array("santhoshbo","kishorek","sarojiniv","chirikis","kirang");
?>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R');?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',3,'R');?>" type="text/css" media="all" />

<style>
.label-small {
 vertical-align: super;
 font-size: small;
}
</style>

<meta http-equiv="cache-control" content="no-cache">
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "<?= getFullURLLevel($_GET['r'],'common/css/filtergrid.css',3,'R');?>";

/*====================================================
	- General html elements
=====================================================*/
body{
	/* margin:15px; padding:15px; border:1px solid #666;
	font-family:Trebuchet MS, sans-serif; font-size:88%; */
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	border:1px solid #ccc;
	overflow:scroll;
}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; }

</style>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R');?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R');?>"></script>

<Link rel='alternate' media='print' href=null>

<Script Language=JavaScript>

	function setPrintPage(prnThis){

		prnDoc = document.getElementsByTagName('link');
		prnDoc[0].setAttribute('href', prnThis);
		window.print();
	}

</Script>

<script language="javascript" type="text/javascript">
<!--
	function popitup(url) {
		newwindow=window.open(url,'name');
		if (window.focus) {newwindow.focus()}
		return false;
	}

//-->
</script>

<script language="javascript" type="text/javascript">

	function popitupnew(url) {
		newwindow=window.open(url,'name','height=500,width=1200,resizable=yes,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
		if (window.focus) {newwindow.focus()}
		return false;
	}

</script>

<script language="javascript" type="text/javascript">

	function popituprem(url) {
		newwindow=window.open(url,'name','height=400,width=600,resizable=yes,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
		if (window.focus) {newwindow.focus()}
		return false;
	}

</script>

<body onload="dodisable();">
	<div class="panel panel-primary">
	<div class="panel-heading"><b>Additional Material Requisition Log</b></div>
	<div class="panel-body">

			<?php 
			include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/menu_include.php',1,'R'));?>
			<?php //list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);?>

			<div class="panel panel-primary panel-body">
				<div class="col-md-12">
					<?php
                        $row_count = 0;
						// include("dbconf.php"); 	
						$link1 = getFullURL($_GET['r'],'mrn_form_log.php','N');
						// var_dump($link1);
						// die();
						if(isset($_GET['date']))
						{
							echo "<div class='row'>";
							$date=$_GET['date'];
							echo '<div ><span style="float: left"><h3>Additional Material Requisition Log : '.date("M-Y",strtotime($date)).'</h3></span></div>';
							//echo '<h2><a name="tbl1" id="tbl1"></a>Additional Material Requisition Log : '.date("M-Y",strtotime($date)).'</h2>';
							echo "</div>";
							echo "<div class='row'>";
							echo "<strong>Filter:</strong>";
							//echo '<a href="mrn_form_log.php?date='.date("Y-m-d",strtotime("-1 year", strtotime($date))).'"> Last Year</a>  |  ';
							//echo '<a href="mrn_form_log.php?date='.date("Y-m-d",strtotime("+1 year", strtotime($date))).'"> Next Year</a>  |  ';
							echo '&nbsp;<a href="'.$link1.'&status_filter='.$_GET['status_filter'].'&date='.date("Y-m-d",strtotime("-1 month", strtotime($date))).'"><button class="btn btn-sm btn-primary"> Last Month</button></a>  |  ';
							echo '&nbsp;<a href="'.$link1.'&status_filter='.$_GET['status_filter'].'&date='.date("Y-m-d",strtotime("+1 month", strtotime($date))).'"> <button class="btn btn-sm btn-primary"> Next Month</button></a>  |  ';
							
						}
						else
						{
							echo "<div class='row'>";
							$date=date("Y-m-d");
							echo '<div><span style="float: left"><h3>Additional Material Requisition Log : '.date("M-Y",strtotime($date)).'</h3></span></div>';
							//echo '<h2><a name="tbl1" id="tbl1"></a>Additional Material Requisition Log : '.date("M-Y",strtotime($date)).'</h2>';
							echo "</div>";
							echo "<div class='row'>";
							echo "<strong>Filter:</strong>";
							echo '&nbsp;<a href="'.$link1.'&date='.date("Y-m-d",strtotime("-1 month")).'"> <button class="btn btn-sm btn-primary">Last Month</button></a>  |  ';
							//echo '<a href="mrn_form_log.php?date='.date("Y-m-d",strtotime("-1 year")).'"> Last Year</a>  |  ';
							
						}

						$reasonsdb_array=array("ALL","1-Requested","2-Approved","3-Rejected","4-Informed/On Progress","5-RM Approved","6-Canceled","7-Doc Printed ","8-Doc Issued","9-Doc Closed");
						//$sql="select * from bai_rm_pj2.mrn_track where year(req_date)=year(\"$date\") and status=1 group by rand_track_id";
						$total=0;
						$sql="select status,count(rand_track_id) as count from $bai_rm_pj2.mrn_track where month(req_date)=month(\"$date\") and year(req_date)=year(\"$date\") group by status";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						echo "<br><b>Status wise Pending List:";
						echo "</div><br>";
						
						echo "<div class='panel panel-primary panel-body'>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							
							echo "".$reasonsdb_array[$sql_row['status']].":&nbsp;<a href='$link1&date=$date&status_filter=".$sql_row['status']."'><span class='btn btn-sm btn-danger'> ".$sql_row['count']."</span></a>";
							$total+=$sql_row['count'];
						}
						echo "&nbsp; &nbsp; Show All: <a href='$link1&date=$date&status_filter=0'><span class='btn btn-md btn-danger'>".$total."</span></a></b>";

						echo "</div>";

						echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing report...</font></h1></center></div>";
							
							ob_end_flush();
							flush();
							usleep(10);

						if(isset($_GET['status_filter']))
						{

						echo "<b>Current Filtered Log:</b>&nbsp;<span class='label label-success label-small'>".$reasonsdb_array[$_GET['status_filter']]."</span><br/>";
						echo '<div style=\"overflow:scroll;\">
						<br><div class="table-responsive"><table id="table1" class="mytable">';

						/*
						Lvels
						1- Approval/Reject
						2- Update
						3- Issuing

						1-Request; 2-Approved; 3-Rejected; 4-Informed/On Progress; 5-Sourcing Updated; 6-Canceled; 7-Doc Printed, 8-Doc Issued, 9-Doc Closed
						*/
						
						echo "<tr class='tblheading' id='heading_table'><th>Date</th>	<th>Style</th>	<th>Schedule</th><th>CutNo</th>	<th>Color</th>	<th>Product</th><th>M3 Item Code</th><th>M3 Item Description</th><th>Reason</th><th>Remarks</th><th>Remarks Popup</th><th>Updated Remarks</th><th>Requested Qty</th><th>UOM</th><th>Approved Qty</th><th>Issued Qty</th> <th>Status</th><th>Req. From</th><th>App Date</th><th>App. by</th><th>Updated Date</th><th>Updated by</th><th>Issued Date</th><th>Issued by</th><th>Section</th><th>Request Ref.</th><th>Control</th><th>Cost $</th></tr>";


						if($_GET['status_filter']>=0)
						{
							

						if($_GET['status_filter']==0)
						{
							$sql="select * from $bai_rm_pj2.mrn_track where month(req_date)=month(\"$date\") and year(req_date)=year(\"$date\") order by status,req_date desc";
						}
						else
						{
							

						$sql="select * from $bai_rm_pj2.mrn_track where month(req_date)=month(\"$date\") and year(req_date)=year(\"$date\") and status=".$_GET['status_filter']." order by status,req_date desc";

						}
						//echo $sql;
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row=mysqli_fetch_array($sql_result))
						{
                            $row_count++;
							$tid=$sql_row['rand_track_id'];
							$ref_tid=$sql_row['tid'];
							$colors=$sql_row['color'];
							$explode_col=explode("^",$colors);
							echo "<tr>";
							echo "<td>".$sql_row['req_date']."</td>";
							echo "<td>".$sql_row['style']."</td>";
							echo "<td>".$sql_row['schedule']."</td>";	
							if(sizeof($explode_col) > 1)
							{
								echo "<td>".$explode_col[1]."</td>";
							}
							else
							{
								echo "<td></td>";
							}
							echo "<td>".$explode_col[0]."</td>";
							echo "<td>".$sql_row['product']."</td>";
							echo "<td>".$sql_row['item_code']."</td>";
							echo "<td>".$sql_row['item_desc']."</td>";
							echo "<td>".$reason_code_db[array_search($sql_row['reason_code'],$reason_id_db)]."</td>";
							echo "<td>".$sql_row['remarks']."</td>";
							//Add the new column as other remarks as a popup to display the all the remarks in each level.
							$link_remarks=getFullURL($_GET['r'],'remarks_log.php','N');
							echo "<td><a class='btn btn-info btn-xs' href=\"$link_remarks&ref_tid=$ref_tid\" onclick=\"return popituprem('$link_remarks&ref_tid=$ref_tid')\">Remarks</a></td>";
								$sql_ref_tid="select * from $bai_rm_pj2.remarks_log where tid=\"$ref_tid\" and level=\"updated\"";
								$sql_result_ref_tid=mysqli_query($link, $sql_ref_tid) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								$row1=mysqli_num_rows($sql_result_ref_tid);
								$rem='';
								if($row1>0)
								{
									while($sql_row_ref=mysqli_fetch_array($sql_result_ref_tid))
									{
										if($sql_row_ref['remarks']=='0' || $sql_row_ref['remarks']=='')
										{
											$rem.="No Remarks";
										}
										else
										{
											$rem.=$sql_row_ref['remarks'];
										}	
									//$rem.=$sql_row_ref['remarks']."-".$sql_row_ref['level']." $ ";
									}

								}
								else
								{
									$rem.="No Remarks";
								}

							echo "<td>".$rem."</td>";
							echo "<td>".$sql_row['req_qty']."</td>";
							echo "<td>".$sql_row['uom']."</td>";
							echo "<td>".$sql_row['avail_qty']."</td>";
							echo "<td>".$sql_row['issued_qty']."</td>";
							$product=$sql_row['product'];
							$reason_code=$sql_row['reason_code'];
							
							switch($sql_row['status'])
							{
								case 1:
								{
									echo "<td>Applied</td>";
									break;
								}
								case 2:
								{
									echo "<td>Approved</td>";
									break;
								}
								case 3:
								{
									echo "<td>Rejected</td>";
									break;
								}
								case 4:
								{
									echo "<td>On Process</td>";
									break;
								}
								case 5:
								{
									echo "<td>Update</td>";
									break;
								}
								case 6:
								{
									echo "<td>Canceled</td>";
									break;
								}
								case 7:
								{
									echo "<td>Print</td>";
									break;
								}
								case 8:
								{
									echo "<td>Issue</td>";
									break;
								}
								case 9:
								{
									echo "<td>Closed</td>";
									break;
								}
							}
							
							echo "<td>".$sql_row['req_user']."</td>";
							if($sql_row['app_date']=='0000-00-00 00:00:00')
							{
								$app_date="";
							}
							else
							{
								$app_date=$sql_row['app_date'];
							}
							echo "<td>".$app_date."</td>";
							echo "<td>".$sql_row['app_by']."</td>";
							if($sql_row['updated_date']=='0000-00-00 00:00:00')
							{
								$updated_date="";
							}
							else
							{
								$updated_date=$sql_row['updated_date'];
							}
							echo "<td>".$updated_date."</td>";
							echo "<td>".$sql_row['updated_by']."</td>";
							if($sql_row['issued_date']=='0000-00-00 00:00:00')
							{
								$issued_date="";
							}
							else
							{
								$issued_date=$sql_row['issued_date'];
							}
							echo "<td>".$issued_date."</td>";
							echo "<td>".$sql_row['issued_by']."</td>";
							echo "<td>".$sql_row['section']."</td>";
							echo "<td>".$tid."</td>";

							$link2 = getFullURL($_GET['r'],'update_form.php','N');
							$link3 = getFullURL($_GET['r'],'mrn_print.php','N');

							switch($sql_row['status'])
							{
								// Add the pop up for Controls App/rej, update, allocate and issue.
								case 1:
								{
									//echo "<td><a href=\"update_form.php?ref=$tid&level=1&product=$product&reason_code=$reason_code&ref_tid=$ref_tid\">App./Rej.</a></td>";
									
									echo "<td><a href='$link2&ref=$tid&level=1&product=$product&reason_code=$reason_code&ref_tid=$ref_tid' onclick=\"return popitupnew('$link2&ref=$tid&level=1&product=$product&reason_code=$reason_code&ref_tid=$ref_tid')\"><button class='btn btn-success btn-xs'>App./Rej.</button></a></td>";
									break;
								}
								case 2:
								{
									echo "<td><a href=\"$link2&ref=$tid&level=2&product=$product&reason_code=$reason_code&ref_tid=$ref_tid\" onclick=\"return popitupnew('$link2&ref=$tid&level=2&product=$product&reason_code=$reason_code&ref_tid=$ref_tid')\"><button class='btn btn-success btn-xs'>Update</button></a></td>";
									//echo "<td><a href=\"update_form.php?ref=$tid&level=2&product=$product&reason_code=$reason_code&ref_tid=$ref_tid\">Update</a></td>";
									break;
								}
								case 4:
								{
										echo "<td><a href=\"$link2&ref=$tid&level=2&product=$product&reason_code=$reason_code&ref_tid=$ref_tid\" onclick=\"return popitupnew('$link2&ref=$tid&level=2&product=$product&reason_code=$reason_code&ref_tid=$ref_tid')\"><button class='btn btn-success btn-xs'>Update</button></a></td>";
								//	echo "<td><a href=\"update_form.php?ref=$tid&level=2&product=$product&reason_code=$reason_code&ref_tid=$ref_tid\">Update</a></td>";
									break;
								}
								case 5:
								{
									echo "<td><a href=\"$link2&ref=$tid&level=3&product=$product&reason_code=$reason_code&ref_tid=$ref_tid\" onclick=\"return popitupnew('$link2&ref=$tid&level=3&product=$product&reason_code=$reason_code&ref_tid=$ref_tid')\"><button class='btn btn-success btn-xs'>Allocate</button></a></td>";
									//echo "<td><a href=\"update_form.php?ref=$tid&level=3&product=$product&reason_code=$reason_code&ref_tid=$ref_tid\">Allocate</a></td>";
									break;
								}
								case 7:
								{
									echo "<td><a href=\"$link3&tid=$ref_tid&print_status=0\" onclick=\"return popitup('$link3&tid=$ref_tid&print_status=0')\"><button class='btn btn-success btn-xs'>Print</button></a></td>";
									break;
								}
								case 8:
								{
									echo "<td><a href=\"$link2&ref=$tid&level=8&product=$product&reason_code=$reason_code&ref_tid=$ref_tid\" onclick=\"return popitupnew('$link2&ref=$tid&level=8&product=$product&reason_code=$reason_code&ref_tid=$ref_tid')\"><button class='btn btn-success btn-xs'>Issue</button></a></td>";
								//	echo "<td><a href=\"update_form.php?ref=$tid&level=8&product=$product&reason_code=$reason_code&ref_tid=$ref_tid\">Issue</a></td>";
									break;
								}
								case 9:
								{
									//echo "<td>Closed</td>";
									if(in_array($username,$duplicate_print_users))
									{
										echo "<td><a href=\"$link3&tid=$ref_tid&print_status=1\" onclick=\"return popitup('$link3&tid=$ref_tid&print_status=1')\"><button class='btn btn-success btn-xs'>Closed</button></a></td>";
									}
									else
									{
										echo "<td>Closed</td>";
									}
									break;
								}
								default:
								{
									echo "<td>N/A</td>";
								}
							}
								echo "<td>".($sql_row['req_qty']*$sql_row['unit_cost'])."</td>";
								echo "</tr>";
						}
						echo "</table>";
						 if($row_count == 0){
                            echo "<div><font color='red' size='5'>No Data Found</font></div>";
                          }
						}
						else
						{
							echo "Please select the filter type.";
						}
						}
                        
                    
                       
						?>

				</div>
			</div>
			<script language="javascript" type="text/javascript">
				//<![CDATA[
				var MyTableFilter = {  exact_match: false,
				col_5: "select",
				col_26: "select" ,
				display_all_text: " [ALL] "}
					setFilterGrid("table1",MyTableFilter);
				//]]>
			</script>

			<script>
				document.getElementById("msg").style.display = "none";		
			</script>
		</div>
	</div>
</div>
</div>
</body>


