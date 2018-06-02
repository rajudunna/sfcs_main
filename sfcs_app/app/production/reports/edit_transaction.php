<?php
//2017-07-11/As per lilantha's mail, removing '0' option in selecting schedule number. user need to select a schedule for each entry.
if(isset($_GET['tid']))
{
	$tid=$_GET['tid']; 
}
?>
<style>
body{
	font-family:arial;
}
</style>

<script>
function box(x)
{
	var url="pop_view3.php?dep_id="+document.getElementById("dep").value+"&row_id="+x;
	newwindow=window.open(url,'Reasons','width=700,height=500,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
	if (window.focus) {newwindow.focus()}
	return false;
	
}

function GetValueFromChild(tmp)
{
	var result=tmp.split("$"); 
    document.getElementById("reason_code").value = result[1];
}
 
 
		function GetSelectedItem(name_attr) 
		{			
			var x=Array(name_attr,"1","2");			
			var i = 0;
			var j = 0;
			
			var chosen1 = 0;	
			var chosen2 = 0;
			var chosen3 = 0;	
			var chosen4 = 0;
			
			if(name_attr=="s1" || name_attr=="r1" || name_attr=="ex1" || name_attr=="nop1") 
			{ 
				var len1 = document.f1.s1.length; 
				var len2 = document.f1.r1.length; 
				var time = document.f1.ex1.value; 
				var nop = document.f1.nop1.value; 
				var dtime = document.f1.l1.value; 
				//alert(nop);
				for (i = 0; i < len1; i++) 
				{
					 if (document.f1.s1[i].selected) 
					 {
					 	 chosen1 = parseInt(chosen1) + parseInt(document.f1.s1[i].value); 
						 chosen3 = chosen3 + document.f1.s1[i].value;
						 chosen5 = document.f1.s1[i].value;
						 chosen5split=chosen5.split(":");
						 //alert(document.f1.s1[i].value+"-"+chosen5+"-"+chosen5split[0]+"-"+chosen5split[1]); 
					 } 
				} 
				
				for (j = 0; j < len2; j++) 
				{ 
					if (document.f1.r1[j].selected) 
					{ 
						chosen2 = parseInt(chosen2) + parseInt(document.f1.r1[j].value); 
						chosen4 = chosen4 + document.f1.r1[j].value; 
						chosen6 = document.f1.r1[j].value;
						chosen6split=chosen6.split(":");
						//alert("a "+document.f1.r1[j].value+"-"+chosen6+"-"+chosen6split[0]+"-"+chosen6split[1]); 
					} 
				} 
				
				dif=chosen4-chosen3;
				dif1=(((chosen6split[0]-chosen5split[0])*60)+(chosen6split[1]-chosen5split[1])-time)*nop;
				document.f1.l1.value=dif1;
				//alert(dif1);
				//alert(dif);
				/*var total=parseInt(chosen2)-parseInt(chosen1);
				//alert(total);
				//alert("d="+dtime); 
				if(parseFloat(chosen4) > parseFloat(chosen3)) 
				{ 
					diff=parseInt(dif*100); 
					divs=parseInt(diff/100); 
					mins=diff-(divs*100); 
					totalhours=parseInt(((60*divs)+mins)/60); 
					if(diff > 60) 
					{ 
						if(mins > 30)
						{
							loss=40;
						}
						else
						{
							loss=0;
						} 
						document.f1.l1.value=((60*divs)+mins-time-loss)*nop;
						//alert("c1="+document.f1.l1.value+"div ="+divs+"-"+mins+"-"+time+"-"+loss+"-"+nop);  
					} 
					else 
					{ 
						document.f1.l1.value=(mins-time)*nop;
						//alert("c2="+document.f1.l1.value); 
					} 
					
					mins=0; 
				} 
				else if(parseFloat(chosen4) < parseFloat(chosen3)) 
				{ 
					diff=parseInt(dif*100); 
					divs=parseInt(diff/100);
					mins=diff-(divs*100);
					totalhours=parseInt(((60*divs)+mins)/60); 
					if(diff > 60) 
					{ 
						document.f1.l1.value=((60*divs)+mins-time)*nop; 
					} 
					else 
					{ 
						document.f1.l1.value=(mins-time)*nop; 
					} 
					mins=0; 
					document.getElementById("r1").selectedIndex = document.getElementById("r1").getAttribute("default"); 
					document.f1.l1.value=0; 
				} 
				else 
				{ 
					alert("Please check the Selected Timings."); 
				} */
			} 
		}
</script>		

<?php 
    include("..".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
 ?>
<?php 

//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=$username_list[1];
?>

<div class="panel panel-primary">
<div class="panel-heading">DownTime Edit Panel</div>
<div class="panel-body">
<div class="row">
<div class="col-md-2"></div>
<div class="col-md-7">
<form name="f1" action="index.php?r=<?php echo $_GET['r']; ?>" method="post">

<table class="table table-bordered">
<?php 
//echo $_GET['r'];
$mins=array("00","05","10","15","20","25","30","35","40","45","50","55");
if(isset($_GET['tid']))
{
	$tid=$_GET['tid']; 

$sql="select * from $bai_pro.down_log where tid=".$tid;
$result = mysqli_query($link, $sql) or exit("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($result))
{
	
	echo"<tr>";

	echo "<input type=\"hidden\" class='form-control' name=\"tid\" value=\"".$row["tid"]."\" />";
	
	echo "<th>Date</th>";
	
	echo "<td><input type=\"text\" data-toggle='datepicker' class='form-control' name=\"date\" value=".$row["date"]." /></td>";
	
	echo "</tr>";
	echo "<tr>";
	echo "<th>Section</th>";
	
	echo "<td>";
	echo "<select name=\"sec\" class='form-control'>";
	$sql="SELECT sec_id as secid FROM $bai_pro3.sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
	$result17=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($result17))
	{
		$sql_sec=$sql_row["secid"];
		
		if($sql_row["secid"]==$row["section"])
		{
			echo "<option value=\"".$sql_row["secid"]."\" selected='selected'>".$sql_row["secid"]."</option>";
		}
		else
		{
			echo "<option value=\"".$sql_row["secid"]."\" >".$sql_row["secid"]."</option>";
		}
		
	}
/*
	$sql_secs=explode(",",$sql_sec);

	for($ib=0;$ib<sizeof($sql_secs);$ib++)
	{
		if($sql_mods[$ib]==$row["section"])
		{
			$status="selected='selected'";
		}
		else
		{
			$status="";
		}
		echo "<option value=\"".$row["section"]."\" $status>".$row["section"]."</option>";
	}	
	
*/
	
	
		
		
	echo "</select></td>";
	
	echo "</tr>";
	
	echo "<tr>";
	
	echo "<th>Shift</th>";
	
	$shift=array("A","B");
	
	echo "<td>";
	echo "<select name=\"shift\" class='form-control'>";
	for($i=0;$i<sizeof($shift);$i++)
	{
		if($shift[$i]==$row["shift"])
		{
			$status="selected='selected'";
		}
		else
		{
			$status="";
		}
		echo "<option value=\"$shift[$i]\" $status>".$shift[$i]."</option>";
	}
	echo "</select></td>";
	
	echo "</tr>";
	
	echo "<tr>";
	
	echo "<th>Module</th>";
	
	echo "<td>";
	echo "<select name=\"module\" class='form-control'>";
	$sql="SELECT GROUP_CONCAT(sec_mods) as mods FROM $bai_pro3.sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
	//echo $sql;
	$result7=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($result7))
	{
		$sql_mod=$sql_row["mods"];
	}

	$sql_mods=explode(",",$sql_mod);

	for($ia=0;$ia<sizeof($sql_mods);$ia++)
	{
		if($sql_mods[$ia]==$row["mod_no"])
		{
			$status="selected='selected'";
		}
		else
		{
			$status="";
		}
		echo "<option value=\"".$sql_mods[$ia]."\" $status>".$sql_mods[$ia]."</option>";
	}
	/*for($i=1;$i<=73;$i++)
	{
		if($i==$row["mod_no"])
		{
			$status="selected='selected'";
		}
		else
		{
			$status="";
		}
		echo "<option value=\"$i\" $status>".$i."</option>";
	}
	
	if($row["mod_no"]=="92")
	{
		$status1="selected='selected'";
	}
	else
	{
		$status1="";
	}
	
	echo "<option value=\"92\" $status1>92</option>";*/
	
	echo "</select></td>";
	
	echo "</tr>";
	
	echo "<tr>";
	
	
	echo "<th>Buyer</th>";
	
	$sql_buyer="SELECT distinct buyer_id FROM $bai_pro2.movex_styles where buyer_id!=''";
	//echo $sql_buyer;
	$result_buyer=mysqli_query($link, $sql_buyer) or die($sql_buyer."Error in buyer 1 ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row_buyer=mysqli_fetch_array($result_buyer))
	{
		$buyer_id[]=$row_buyer["buyer_id"];
		
	}
	
	echo "<td>";
	echo "<select name=\"buyer\" class='form-control'>";
	for($i=0;$i<sizeof($buyer_id);$i++)
	{
		if($buyer_id[$i]==$row["customer"])
		{	
			echo "<option value=\"$buyer_id[$i]\" selected='selected'>".$buyer_id[$i]."</option>";
		}
		else
		{	
			echo "<option value=\"$buyer_id[$i]\">".$buyer_id[$i]."</option>";
		}
		
	}
	echo "</select></td>";
	
	echo "</tr>";
	
	echo "<tr>";
	
	
	echo "<th>Style</th>";
	
	
	//$sql1="select distinct(style) from pro_style";
	
	//26-04-2017 changed the source for fetching styles
	$sql1="select distinct(style_id) as style from $bai_pro2.movex_styles order by style_id";
	
	//echo $sql1;
	$result2=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result2))
	{
		$styles[]=$row1["style"];
		//echo $row1["style"];
	}
	//echo "style= ".sizeof($styles);
	echo "<td>";
	echo "<select name=\"style\" class='form-control'>";
	for($i=0;$i<=sizeof($styles);$i++)
	{
		if($styles[$i]==$row["style"])
		{
			$status="selected='selected'";
			$style_id=$row["style"];
		}
		else
		{
			$status="";
		}
		echo "<option value=\"$styles[$i]\" $status>".$styles[$i]."</option>";
	}
	echo "</select></td>";
	
	echo "</tr>";
	
	echo "<tr>";
	
	echo "<th>Schedule</th>";
	
	$sql2="select distinct(order_del_no) as schedule from $bai_pro3.bai_orders_db";
	//echo $sql2;
	$result3=mysqli_query($link11, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row2=mysqli_fetch_array($result3))
	{
		$schedule[]=$row2["schedule"];
		//echo $row1["style"];
	}
	
	echo "<td>";
	echo "<select name=\"schedule\" class='form-control'>";
	//echo "<option value='0' $status>0</option>";
	for($i=0;$i<=sizeof($schedule);$i++)
	{
		if($schedule[$i]==$row["schedule"])
		{
			$status="selected='selected'";
			//$style_id=$row["style"];
		}
		else
		{
			$status="";
		}
		echo "<option value=\"$schedule[$i]\" $status>".$schedule[$i]."</option>";
	}
	echo "</select></td>";
	
	echo "</tr>";
	
	echo "<tr>";
	
	echo "<th>NOP</th>";
	
	echo "<td><input type=\"text\" class='form-control' name=\"nop1\" size=\"5\" id=\"nop1\" onkeyup=\"GetSelectedItem('nop1');\" value=\"16\"></td>";
	
	echo "</tr>";
	
	echo "<th>Plan Eff</th>";
	
	echo "<td><input type=\"text\" class='form-control' name=\"eff\" size=\"5\" id=\"eff\" value=\"".$row["plan_eff"]."\"></td>";
	
	echo "</tr>";
	
	echo "<tr>";
	
	echo "<th>Start Time</th>";
	
	echo "<td><div><p>";


	echo "<SELECT name=\"s1\" class='form-control' id=\"s1\" onchange=\"GetSelectedItem('s1');\">

			<option value=\"0\" name=\"s1\"></option>";


	for($l=6;$l<=22;$l++)
	{
		for($k=0;$k<sizeof($mins);$k++)
		{
			if($l<13)
			{
				if($l==12)
				{
					if($row["start_time"]==$l.":".$mins[$k])
					{
						echo "<option value=\"".$l.":".$mins[$k]."\" name=\"s1\" selected>".$l.":".$mins[$k]." PM</option>";
					}
					else
					{
						echo "<option value=\"".$l.":".$mins[$k]."\" name=\"s1\">".$l.":".$mins[$k]." PM</option>";
					}
					
				}
				else
				{
					if($row["start_time"]==$l.":".$mins[$k])
					{
						echo "<option value=\"".$l.":".$mins[$k]."\" name=\"s1\" selected>".$l.":".$mins[$k]." AM</option>";
					}
					else
					{
						echo "<option value=\"".$l.":".$mins[$k]."\" name=\"s1\">".$l.":".$mins[$k]." AM</option>";
					}
				}	
			}
			else
			{
				$r=$l-12;
				if($row["start_time"]==$l.":".$mins[$k])
				{
					echo "<option value=\"".$l.":".$mins[$k]."\" name=\"s1\" selected>".$l.":".$mins[$k]." PM</option>";
				}
				else
				{
					echo "<option value=\"".$l.":".$mins[$k]."\" name=\"s1\">".$l.":".$mins[$k]." PM</option>";
				}
			}
		}
		
	}
	echo "</SELECT></p></div></td>";
	
	echo "</tr>";
	
	echo "<tr>";
	
	echo "<th>End Time</th>";
	
	echo "<td><div><p>";


	echo "<SELECT name=\"e1\" class='form-control' id=\"r1\" onchange=\"GetSelectedItem('r1');\">

			<option value=\"0\" name=\"r1\"></option>";


	for($l=6;$l<=22;$l++)
	{
		for($k=0;$k<sizeof($mins);$k++)
		{
			if($l<13)
			{
				if($l==12)
				{
					if($row["end_time"]==$l.":".$mins[$k])
					{
						echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r1\" selected>".$l.":".$mins[$k]." PM</option>";
					}
					else
					{
						echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r1\">".$l.":".$mins[$k]." PM</option>";
					}
				}
				else
				{
					if($row["end_time"]==$l.":".$mins[$k])
					{
						echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r1\" selected>".$l.":".$mins[$k]." AM</option>";
					}
					else
					{
						echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r1\">".$l.":".$mins[$k]." AM</option>";
					}
				}	
			}
			else
			{
				$r=$l-12;
				if($row["end_time"]==$l.".".$mins[$k])
				{
					echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r1\" selected>".$l.":".$mins[$k]." PM</option>";
				}
				else
				{
					echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r1\">".$l.":".$mins[$k]." PM</option>";
				}
			}
		}
		
	}
	echo "</SELECT></p></div></td>";
	
	echo "</tr>";
	
	echo "<tr>";
	
	echo "<th>Downtime</th>";
	
	echo "<td><input type=\"text\" class='form-control' name=\"l1\" value=\"".$row["dtime"]."\" size=\"3\" /></td>";
	
	echo "</tr>";
	
	echo "<th>Exception Time</th>";
	
	echo "<td><input type=\"text\" class='form-control' name=\"ex1\" onkeyup=\"GetSelectedItem('ex1');\" value=\"0\" size=\"3\" /></td>";
	
	echo "</tr>";
	
	$sql4="select * from $bai_pro.down_deps";
	$result4=mysqli_query($link, $sql4) or die("Error4 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row4=mysqli_fetch_array($result4))
	{
		$dep_id[]=$row4["dep_id"];
		$dep_name[]=$row4["dep_name"];
	}
	
	echo "<tr>";
	
	echo "<th>Department Name</th>";
	
	echo "<td>";	
	
	echo "<select name=\"dep\" class='form-control'>";
	for($i=0;$i<=sizeof($dep_id);$i++)
	{
		if($dep_id[$i]==$row["department"])
		{
			$status="selected='selected'";
			//$style_id=$row["style"];
		}
		else
		{
			$status="";
		}
		echo "<option value=\"$dep_id[$i]\" $status>".$dep_name[$i]."</option>";
	}
	echo "</select></td>";
	
	echo "</tr>";
	
	echo "<tr>";
	// add the popup window for the edit transation against the department wise.
	echo "<th>Reason</th><td><input type=\"text\" class='form-control' name=\"reason_code\" id=\"reason_code\" value=\"".$row['reason_code']."\" readonly=readonly size=3><span onclick=\"box(0)\">Select</sapn></td>";
	
	echo "</tr>";
	
	echo "<tr>";
	
	echo "<th>Remarks</th><td><input type=\"text\" class='form-control' name=\"remarks\" value=\"".$row["remarks"]."\" /></td>";
	
	echo "</tr>"; 
	
	$source=array("Internal","External");
	
	echo "<tr>";
	
	echo "<th>Source</th>";
	
	echo "<td>";
	echo "<select name=\"source\" class='form-control'>";
	for($i=0;$i<=sizeof($source);$i++)
	{
		if($i==$row["source"])
		{
			$status="selected='selected'";
		}
		else
		{
			$status="";
		}
		echo "<option value=\"".$i."\" $status>".$source[$i]."</option>";
	}
	echo "</select></td>";
	
	echo "</tr>"; 
	
	echo "<tr>";
	
	echo "<th></th><td><center><input type=\"submit\" class='btn btn-success' name=\"submit\" value=\"submit\" onclick=\"document.getElementById('submit').style.display='none';document.getElementById('cancel').style.display='none';document.getElementById('msg').style.display='';\"/>";
	?>
	&nbsp;&nbsp;<button class='btn btn-danger' name='cancel' onClick=document.getElementById('cancel').style.display='none';document.getElementById('submit').style.display='none';document.getElementById('msg').style.display='';location.href='down_time_log_V2.php';>Cancel</button>
	<span id="msg" style="display:none;">Please Wait..</span>
</center>
		</td>
	</tr> 
<?php	
}


?>

</table>

</form>
</div>
</div>
</div>
</div>
<?php
}
?>
<?php

if(isset($_POST["submit"]))
{
	$tids=$_POST["tid"];
	$date=$_POST["date"];
	$section=$_POST["sec"];
	$shift=$_POST["shift"];
	$module=$_POST["module"];
	$style=$_POST["style"];
	$schedule_no=$_POST["schedule"];
	$dtime=$_POST["l1"];
	$dep_no=$_POST["dep"];
	$remarks=$_POST["remarks"];	
	$sources=$_POST["source"];
	$plan_eff=$_POST["eff"];
	$nop1=$_POST['nop1'];
	$s1=$_POST['s1'];
	$r1=$_POST['e1'];
	$reason_code=$_POST['reason_code'];
	$buyer=$_POST['buyer'];
	
	
	$update="update $bai_pro.down_log set 
	mod_no=\"".$module."\",date=\"".$date."\",department=\"".$dep_no."\",remarks=\"".$remarks."\",
	style=\"".$style."\",dtime=\"".$dtime."\",shift=\"".$shift."\",section=\"".$section."\",
	customer=\"".$buyer."\",schedule=\"".$schedule_no."\",source=\"".$sources."\",plan_eff=\"".$plan_eff."\",
	nop='$nop',start_time='$s1',end_time='$r1',reason_code='$reason_code',flag=0 where tid=\"".$tids."\" ";
	
	//echo "<br/>".$update;

	
	if(!mysqli_query($link, $update))
	{
	 	die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else
	{
		$sql_edit="insert into $bai_pro.down_log_changes(tid_ref,username,operation) value(".$tids.",'".$username."','edit')";
		mysqli_query($link, $sql_edit) or exit($sql_edit."<br/>Sql Error Edit".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//echo $tids."---".$date."---".$section."---".$shift."---".$module."---".$style."---".$schedule_no."---".$dtime."---".$dep_name."---".$remarks."---".$sources."---".$buyer;
		echo "<h2>Successfully Updated</h2>";
		echo "<script>var answer =sweetAlert('Successfully Updated','Updated','warning');
				if (answer){
					//window.location = \"".$dns_adr3."/projects/Alpha/anu/down_time/down_time_log.php\";
					
					window.close();
				}
				else{
					sweetAlert('Sorry not Updated','Updated','warning');
				}
			</script>";
	}
	//echo $tids."---".$date."---".$section."---".$shift."---".$module."---".$style."---".$schedule_no."---".$dtime."---".$dep_name."---".$remarks."---".$sources."---".$buyer;
	
}

?>




</div>
</div>
