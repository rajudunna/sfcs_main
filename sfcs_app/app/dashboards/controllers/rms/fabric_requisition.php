<!--
Changes Log:

2014-07-09/ Dharanid /service request #159184 / Add the balasubramanyams,lakshmik,ramalingeswararaoa user names at $users array
2014-09-06 / dharnid/ service request #800666 : baisec1 user access to kanakalakshmi(baicutsec1).

2014-12-22 / RameshK / Service Request# 354829 / Changed the logic for calculating the difference between two times.
-->

<?php
// include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
// include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
// $view_access=user_acl("SFCS_0208",$username,1,$group_id_sfcs);
// $users=user_acl("SFCS_0208",$username,43,$group_id_sfcs);
include($_SERVER['DOCUMENT_ROOT'].'template/helper.php');
$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/fabric_requisition.php");
$has_permission=haspermission($url_r);
// echo "Authp : ".var_dump($has_permission);
// die();

?>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	// $username="sfcsproject1";
	// $users=array("sfcsproject1","rameshk","kirang","duminduw","rajanaa","chandrasekhard","prabathsa","baiadmn","naleenn","priyankat","balasubramanyams","lakshmik","ramalingeswararaoa","baicutsec1","tharangam");
	//$mods=array();

	if((in_array($authorized,$has_permission)))
	{
		//echo "Names Exit";
	}
	else
	{	
		// echo $_GET['r'];
		header("Location:sfcs_app/app/dashboards/controllers/rms/restrict.php?group_docs=".$_GET['group_docs']);
		// header($_GET['r'],'restrict.php','N');
	}

	if(isset($_POST['sdat'])) 
	{ 
		//echo $_POST['doc'];
		$doc_no=$_POST['doc'];
		$group_docs=$_POST["group_docs"];
		$section=$_POST["secs"];
		$module=$_POST["mods"];
		$sql2x="select * from $bai_pro3.fabric_priorities where doc_ref=\"".$doc_no."\"";
		$result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rows2=mysqli_num_rows($result2x);	
	} 
	else
	{
		$doc_no=$_GET["doc_no"];
		$group_docs=$_GET["group_docs"];
		$section=$_GET["section"];
		$module=$_GET["module"];
		$sql2x="select * from $bai_pro3.fabric_priorities where doc_ref=\"".$doc_no."\"";
		$result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rows2=mysqli_num_rows($result2x);	
	}	

//echo $doc_no;
?>

  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
  <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'TableFilter_EN/filtergrid.css',0,'R'); ?>">
<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/


/*====================================================
	- General html elements
=====================================================*/
body{ 
	margin:15px; padding:15px; border:0px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}
a {
	margin:0px; padding:0px;
}
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>

<script>

function pad(number, length) {
   
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }
   
    return str;

}

function GetSelectedItem()
{
	var dat=document.getElementById("sdat").value;
	var mins=document.getElementById("mins").value;
	var currentTime = new Date();
	var date=currentTime.getDate();
	var month=currentTime.getUTCMonth()+1;
	var yer=currentTime.getFullYear();
	//var hours=currentTime.getHours();
	//var hours=currentTime.getHours()+3; //3 hours lead time
	var hours=currentTime.getHours()+1; //1 hours lead time
	var mints=currentTime.getMinutes();
	var datsplit=dat.split("-");
	var timsplit=mins.split(":");
	
	var dat_new=(parseInt(parseInt(datsplit[0])+''+(datsplit[1])+''+(datsplit[2])));
	var cur_new=(parseInt(yer+''+pad(month,2)+''+pad(date,2)));
	if(mints < 10)
	{
		mints="0"+mints;
	}
	//alert(timsplit[0]+"-"+hours+"&"+timsplit[1]+"-"+mints);
	
	//3 Hours Lead Time
	//alert(month+"-"+datsplit[1]);
	
	if(datsplit[0] >= yer){
		if(datsplit[1] >= month){
			if(datsplit[2] >= date){
				if(dat_new>cur_new)
				{
					
				}
				else
				{
					if(parseFloat(timsplit[0]+"."+timsplit[1]) >= parseFloat(hours+"."+mints))
					{
						//alert("Ok");
						//alert(timsplit[0]+"."+timsplit[1]+"-"+hours+"."+mints);
					}
					else{
						//alert("Hours Not ok");
						//alert(timsplit[0]+"."+timsplit[1]+"-"+hours+"."+mints);
						// alert("");
						sweetAlert("Info!", "Enter Correct Date And Time.", "warning");
						document.getElementById("sdat").value=yer+"-"+month+"-"+date;
						document.getElementById("mins").value="";
						document.apply['submit'].disabled =true;
						document.apply['check'].checked=false;
					}	
				}
								
			}
			else{
				//alert("Date Not ok");
				if(datsplit[1]!=month)
				{
					
				}
				else
				{
					// alert("Enter Correct Date And Time2");
					sweetAlert("Info!", "Enter Correct Date And Time.", "warning");
					document.getElementById("sdat").value=yer+"-"+month+"-"+date;
					document.getElementById("mins").value="";
					document.apply['submit'].disabled =true;
					document.apply['check'].checked=false;
				}				
			}			
		}
		else{
			//Add condition if it is new year
			if(datsplit[0]>yer)
			{
				
			}
			else
			{
				//month not ok
				// alert("Enter Correct Date And Time3");
				sweetAlert("Info!", "Enter Correct Date And Time.", "warning");
				document.getElementById("sdat").value=yer+"-"+month+"-"+date;
				document.getElementById("mins").value="";
				document.apply['submit'].disabled =true;
				document.apply['check'].checked=false;
			}	
		}		
	}
	else{
		//alert("Year Not Ok");
		sweetAlert("Info!", "Enter Correct Date And Time.", "warning");
		// alert("Enter Correct Date And Time4");
		document.getElementById("sdat").value=yer+"-"+month+"-"+date;
		document.getElementById("mins").value="";
		document.apply['submit'].disabled =true;
		document.apply['check'].checked=false;
	}	
	
}

</script>

<body>
<div class="panel panel-primary">
<div class="panel-heading">Fabric Requisition Form</div>
<div class="panel-body">
<hr>
<!--<?php echo "Docket No = ".$doc_no; ?>-->

<table class="table table-bordered">

<tr><th>Style</th><th>Schedule</th><th>Color</th><th>Docket No</th><th>Job No</th></tr>
<?php
//echo date("Y")."-".date("m")."-".date("d")." ".(date("H")+3).":".date("i").":".date("s");
	$doc_nos_splitx=explode(",",$doc_no);
		
	for($i=0;$i<sizeof($doc_nos_splitx);$i++)
	{
		echo "<tr>";
		$sql11x="select order_tid,acutno from $bai_pro3.plandoc_stat_log where doc_no=\"".$doc_nos_splitx[$i]."\"";
		$sql_result11x=mysqli_query($link, $sql11x) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row11x=mysqli_fetch_array($sql_result11x))
		{
			$order_tidx=$row11x["order_tid"];
			$cut_nosx=$row11x["acutno"];
		}

		$sql21x="select order_style_no,order_del_no,order_col_des,order_div,color_code from $bai_pro3.bai_orders_db where order_tid=\"".$order_tidx."\"";
		$sql_result21x=mysqli_query($link, $sql21x) or die("Error2 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row21x=mysqli_fetch_array($sql_result21x))
		{
			$stylex=$row21x["order_style_no"];
			$schedulex=$row21x["order_del_no"];
			$colorx=$row21x["order_col_des"];
			$buyerx=$row21x["order_div"];
			$color_codex=$row21x["color_code"];
		}

		echo "<td>".$stylex."</td>";
		echo "<td>".$schedulex."</td>";
		echo "<td>".$colorx."</td>";
		echo "<td>".$doc_nos_splitx[$i]."</td>";
		echo "<td>".chr($color_codex)."00".$cut_nosx."</td>";
		echo "</tr>";
	}

?>
</table><br/><br/>

<form action="#" method="POST" name="apply">
	<table class="table table-bordered">
		<tr>

			<td style="display:none"><input type="hidden" id="doc" name="doc" value="<?php echo $doc_no; ?>" ></td>
			<td style="display:none"><input type="hidden" id="$group_docs" name="group_docs" value="<?php echo $group_docs; ?>" ></td>

		<?php
			if($rows2 > 0)
			{
				echo "<h2>Fabric Already Requested For This Docket</h2>";
			}	
			else
			{	
		?>
		     
			 
			<th>Date</th>
			<td>
				<input data-toggle="datepicker" readonly="true" type="text" id="sdat" name="sdat" onchange="GetSelectedItem();" size=8 value="<?php  if(isset($_POST['sdat'])) { echo $_POST['sdat']; } else { echo date("Y-m-d"); } ?>"/>
			
				<?php 
					// echo "<a href="."\"javascript:NewCssCal('sdat','yyyymmdd','dropdown')\" onclick=\"document.apply['submit'].disabled =true;document.apply['check'].checked=false;\">";
					// echo "<img src='images/cal.gif' width='16' height='16' alt='Pick a date'></a>";
				?>
			</td>

			<th>Time</th>
			<td>
				<?php

					$hours=date("H");

					$mints=date("i");
					$hours=6;
					$mints=0;

					$mins=array("00","05","10","15","20","25","30","35","40","45","50","55");

					echo "<SELECT name=\"mins\" id=\"mins\" onchange=\"GetSelectedItem();\">

					<option value=\"0:00\" name=\"0.00\">Select Time</option>";
					$selected="";
					for($l=$hours;$l<=21;$l++)
					{
						
						for($k=0;$k<sizeof($mins);$k++)
						{
							if($l==date("H") and $mins[$k]>=date("i"))
							{
								$selected="selected";
							}
							
							if($l<13)
							{
								if($l==$hours)
								{
									if($mints <= $mins[$k])
									{	
										//echo $mins[$k];
										if($l==12)
										{
											echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$l."\" $selected>".$l.":".$mins[$k]." P.M</option>";
										}
										else
										{
											echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$l."\" $selected>".$l.":".$mins[$k]." A.M</option>";
										}
									}
								}
								else
								{
									if($l==12)
									{
										echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$l."\" $selected>".$l.":".$mins[$k]." P.M</option>";
									}
									else
									{
										echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$l."\" $selected>".$l.":".$mins[$k]." A.M</option>";
									}
								}
								
							}
							else
							{
								if($l==$hours)
								{
									if($mints <= $mins[$k])
									{
										$r=$l-12;
										echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$l."\" $selected>".$r.":".$mins[$k]." P.M</option>";
									}
								}
								else
								{
									$r=$l-12;
									echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$l."\" $selected>".$r.":".$mins[$k]." P.M</option>";
								}
							} 
							$selected="";
						}	
					}

					echo "<option value=\"22:00\" name=\"r22\">10:00 P.M</option>";
					echo "</SELECT> <strong>Lead time for RM supply is 1 Hour</strong>";

				?>
			</td>
	
			<td style="display:none"><input type="hidden" id="name" name="name" value="<?php echo $username; ?>" ></td>	
			<td style="display:none"><input type="hidden" id="name" name="secs" value="<?php echo $section; ?>" ></td>	
			<td style="display:none"><input type="hidden" id="name" name="mods" value="<?php echo $module; ?>" ></td>
			
		<?php
					
				if(date("H:i:s") <= "21:00:00")
				{
					echo "<td><input type=\"checkbox\" onClick=\" document.apply['submit'].disabled =(document.apply['submit'].disabled)? false : true; GetSelectedItem();\" name=\"check\"><input type=\"submit\" id=\"submit\" name=\"submit\" value=\"Submit\" class=\"btn btn-primary\" style=\"float: right;\" disabled></td>	";
				}
				else
				{
					echo "<td><H2>After 9'o Clock You Can't Raise The Fabric Request. If Any Concern Please Concant RM Warehouse Manager.</H2></td>";
				}	
			}
		
		?>	
	  
		</tr>
	</table>
</form>
<br/><br/>

<?php
error_reporting(0);
if(isset($_POST["submit"]))
{
	$log_time=date("Y")."-".date("m")."-".date("d")." ".date("H").":".date("i").":".date("s");
	$req_time=$_POST["sdat"]." ".$_POST["mins"].":00";
	$doc_nos=$_POST["doc"];
	$group_docs=$_POST["group_docs"];
	$secs=$_POST["secs"];
	$mods=$_POST["mods"];
	
	//Date: 2013-10-09
	//Old Logic
	//Validation for Requested time and log time 
	/*$log_time_explode=explode(" ",$log_time);
	$req_time_explode=explode(" ",$req_time);
	
	$log_time_explode_explode=explode(":",$log_time_explode[1]);
	$req_time_explode_explode=explode(":",$req_time_explode[1]);
	$log_req_diff=$req_time_explode_explode[0]-$log_time_explode_explode[0];*/
	
	//Calculated time difference between two times
	$date1 = $log_time;
	$date2 = $req_time; 
	//echo strtotime($date2) ."\n";
	$diff = strtotime($date2) - strtotime($date1);
	//echo $diff ."\n";
	$diff_in_hrs = $diff/3600;
	//print_r(round($diff_in_hrs,0));
	$log_req_diff=round($diff_in_hrs,0);
	
	$doc_nos_split=explode(",",$group_docs);
	$host_name=str_replace(".brandixlk.org","",gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$note=date("Y-m-d H:i:s")."_".$username."_".$host_name."<br/>";
	
	//for($i=0;$i<sizeof($doc_nos_split);$i++)
	for($i=0;$i<1;$i++)
	{
		$sql1="select * from $bai_pro3.fabric_priorities where doc_ref=\"".$doc_nos_split[$i]."\"";
		$result=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rows=mysqli_num_rows($result);
		//Date: 2013-10-09
		//Time difference is grater than or equel to 3
		//Then only system will accept the fabric request
		//if($log_req_diff >= 3)
		if($log_req_diff >= 1)
		{
			if($rows==0)
			{
				$sql="insert into $bai_pro3.fabric_priorities(doc_ref,doc_ref_club,req_time,log_time,log_user,section,module) values(\"".$doc_nos_split[$i]."\",\"".$doc_nos."\",\"".$req_time."\",\"".$log_time."\",\"".$username."\",\"".$secs."\",\"".$mods."\")";
				//echo "<br>".$sql."<br>";
				$note.=$sql."<br>";
				if(!mysqli_query($link, $sql))
				{
					die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				} 
				else
				{
					echo "<h2 style=\"color:red;\">Request Sent Successfully...</h2>";
				}
				
				//Date:2013-08-27
				//Track the requested user details and system details.
				$myFile = "log/".date("Y_m_d")."_fabric_request_track.html";
				$fh = fopen($myFile, 'a');
				$stringData = $note;
				fwrite($fh, $stringData);
			}
			else
			{
				echo "<h2 style=\"color:red;\">Fabric Already Requested For ".$doc_nos_split[$i]." Docket</h2>";
			}
		}
		
	}	
}

echo "<h2>Already Requested Cut Jobs </h2>";
echo "<div class='table-responsive'><table class=\"table table-bordered\" id=\"table1\" border=0 cellpadding=0 cellspacing=0>";
echo "<tr><th>Section</th><th>Module</th><th>Date</th><th>Time</th><th>Requested By</th><th>Style</th><th>Schedule</th><th>Color</th><th>Docket No</th><th>Job No</th><th>Fabric Status</th></tr>";
$sql2="select * from $bai_pro3.fabric_priorities where (log_user=\"".$username."\"  or section=$section) and issued_time=\"0000-00-00 00:00:00\" order by section,req_time,module";
$result2=mysqli_query($link, $sql2) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row2=mysqli_fetch_array($result2))
{
	$log=$row2["req_time"];
	$log_split=explode(" ",$log);
	
	$sql11="select order_tid,acutno,rm_date from $bai_pro3.plandoc_stat_log where doc_no=\"".$row2["doc_ref"]."\"";
	$sql_result11=mysqli_query($link, $sql11) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row11=mysqli_fetch_array($sql_result11))
	{
		$order_tid=$row11["order_tid"];
		$cut_nos=$row11["acutno"];
		$rm_date=$row11["rm_date"];
	}
	
	echo "<tr>";
	echo "<td>".$row2["section"]."</td>";
	echo "<td>".$row2["module"]."</td>";	
	echo "<td>".$log_split[0]."</td>";
	echo "<td>".$log_split[1]."</td>";
	echo "<td>".strtoupper($row2["log_user"])."</td>";	
	
	$sql21="select order_style_no,order_del_no,order_col_des,order_div,color_code from $bai_pro3.bai_orders_db where order_tid=\"".$order_tid."\"";
	$sql_result21=mysqli_query($link, $sql21) or die("Error2 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row21=mysqli_fetch_array($sql_result21))
	{
		$style=$row21["order_style_no"];
		$schedule=$row21["order_del_no"];
		$color=$row21["order_col_des"];
		$buyer=$row21["order_div"];
		$color_code=$row21["color_code"];
	}
	
	echo "<td>".$style."</td>";
	echo "<td>".$schedule."</td>";
	echo "<td>".$color."</td>";
	
	echo "<td>".$row2["doc_ref"]."</td>";
	echo "<td>".chr($color_code)."00".$cut_nos."</td>";
	
	$issued_time=$row2["issued_time"];
	
	if($issued_time=="0000-00-00 00:00:00")
	{
		echo "<td>Not Issued</td>";
	}
	else
	{
		echo "<td>Issued</td>";
	}
	echo "</tr>";
	
}
echo "</table></div>";

?>
</div>
</div>
</body>
