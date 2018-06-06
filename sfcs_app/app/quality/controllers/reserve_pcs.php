<!-- <script>jQuery.noConflict(); </script> -->

<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
 $view_access=user_acl("SFCS_0137",$username,1,$group_id_sfcs); 
/*$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);

$author_id_db=array("kirang","baiadmn","lakmalka","deepthik","pavanik","ramaraop","sarojinig","baiquality","kirang","kirang","kirang");
if(in_array($username,$author_id_db))
{
	
}
else
{
	header("Location:../restricted.php");
}
*/
?>



<style>
body
{
	/* font-family:calibri;
	font-size:12px; */
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: #29759c;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table td.new
{
	background-color: BLUE;
	color: WHITE;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

}
</style>

<style rel="stylesheet" type="text/css">
#div-1a {
 position:absolute;
 top:50px;
 right:0;
 width:auto;
float:right;
}
</style>

<!-- <script type="text/javascript" src="../jquery.min.js"></script> -->

<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
/* @import "../TableFilter_EN/filtergrid.css"; */

/*====================================================
	- General html elements
=====================================================*/
body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	/* font-family:Arial, Helvetica, sans-serif; font-size:88%;  */
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	border:1px solid #ccc;
}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; border:1px solid #ccc; white-space: nowrap;}
.mytable td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space: nowrap;}

</style>

<!-- <script language="javascript" type="text/javascript" src="../TableFilter_EN/actb.js"></script>External script -->
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>

<script>

function enable_button()
{
	var checkedStatus = document.getElementById("enable").checked;
	
	if(checkedStatus===true)
	{
		document.getElementById("add").disabled=false;
	}
	else
	{
		document.getElementById("add").disabled=true;
		
	}
}

</script>

<title>Reserve for Destroy Panels</title>

<div class="panel panel-primary">
	<div class="panel-heading"><b>Reserve for Destroy Panels</b></div>
	<div class="panel-body">

		<!-- <div id="page_heading"><span style="float: left"><h3>Reserve for Destroy Panels</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div> -->

		<?php
		if(isset($_POST['confirm'])){
			
			$chk=$_POST['chk'];
			$qty=$_POST['qty'];
			$style=$_POST['style'];
			$schedule=$_POST['schedule'];
			$color=$_POST['color'];
			$size=$_POST['size'];
			
			for($i=2;$i<sizeof($qty)+2;$i++){
				if($qty[$i]>0 and $chk[$i]==1){
					$sql="insert into $bai_pro3.bai_qms_db(qms_style,qms_schedule,qms_color,log_user,log_date,qms_size,qms_qty,qms_tran_type) values('".$style[$i]."','".$schedule[$i]."','".$color[$i]."','".$username."','".date("Y-m-d")."','".$size[$i]."','".$qty[$i]."',13)";
					//echo $sql."<br/>";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		}

		?>

		<?php
		$export_excel="";
		echo '<form name="update" method="post" action="?r='.$_GET['r'].'">';
		echo '<input type="checkbox" name="enable" id="enable" onclick="enable_button()">Enable&nbsp;&nbsp;<input type="submit" class="btn btn-success" name="confirm" value="update destroy" id="add" disabled="true" onclick="enable_button()">';

		$table="<br><div class=table-responsive><table class='table table-bordered' id=\"table1\">";
		$table.="<thead>";
		$table.="<tr>";
		$table.='<th>SNo&nbsp;<input type="checkbox" name="selectall" id="selectall"/></th>';
		$table.="<th>Style</th>";
		$table.="<th>Schedule</th>";
		$table.="<th>Color</th>";
		$table.="<th>Size</th>";
		$table.="<th>Reserved</th>";
		$table.="<th>Destroy Quantity</th>";
		$table.="</tr>";
		$table.="</thead><tbody>";
		echo $table;

		//Export to Excel
		$export_table="<table>";
		$export_table.="<thead>";
		$export_table.="<tr>";
		$export_table.='<th>SNo</th>';
		$export_table.="<th>Style</th>";
		$export_table.="<th>Schedule</th>";
		$export_table.="<th>Color</th>";
		$export_table.="<th>Size</th>";
		$export_table.="<th>Reserve to Destroy Quantity</th>";
		$export_table.="<th>Destroyed</th>";
		$export_table.="</tr>";
		$export_table.="</thead><tbody>";
		//Export to Excel


		$x=2;

		$sql="select (resrv_dest-panel_destroyed) as available,qms_schedule,qms_size,qms_style,qms_color from $bai_pro3.bai_qms_day_report where (resrv_dest-panel_destroyed)>0 order by qms_schedule,qms_color,qms_size";
		 //echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$table="<tr class=\"foo\" id=\"rowchk$x\">";
			$table.="<td><input type=\"checkbox\" name=\"chk[$x]\" id=\"chk[$x]\" value='1' onclick=\"selectind($x)\"/>".($x-1)."</td>";
			$table.="<td>".$sql_row['qms_style']."</td>";
			$table.="<td>".$sql_row['qms_schedule']."</td>";
			$table.="<td>".$sql_row['qms_color']."</td>";
			$table.="<td>".$sql_row['qms_size']."</td>";
			$table.="<td>".$sql_row['available']."</td>";
			$table.="<td><input type=\"text\" name=\"qty[$x]\" value=\"".$sql_row['available']."\" onchange='if(this.value<0 || this.value>".$sql_row['available'].") { this.value=0; alert(\"Please enter correct value\"); }'>
		<input type=\"hidden\" name=\"style[$x]\" value=\"".$sql_row['qms_style']."\">
		<input type=\"hidden\" name=\"schedule[$x]\" value=\"".$sql_row['qms_schedule']."\">
		<input type=\"hidden\" name=\"color[$x]\" value=\"".$sql_row['qms_color']."\">
		<input type=\"hidden\" name=\"size[$x]\" value=\"".$sql_row['qms_size']."\">
		</td>";
			$table.="</tr>";
			echo $table;
			
			//Export Excel
			
			$export_table.="<tr>";
			$export_table.="<td>".($x-1)."</td>";
			$export_table.="<td>".$sql_row['qms_style']."</td>";
			$export_table.="<td>".$sql_row['qms_schedule']."</td>";
			$export_table.="<td>".$sql_row['qms_color']."</td>";
			$export_table.="<td>".$sql_row['qms_size']."</td>";
			$export_table.="<td>".$sql_row['available']."</td>";
			$export_table.="<td></td>";
			$export_table.="</tr>";
			
			//Export Excel
			
			$x++;
		}
		$table='</tbody></table>';
		$export_table.='</div></tbody></table>';
		echo $table;

		echo '</form>';
		?>

		<div id="div-1a" style='margin-right:24px;'>
		<form  name="input" action="<?= getFullURLLevel($_GET['r'],'export_excel.php',0,'R'); ?>" method="post">
		<input type="hidden" name="table" value="<?php echo $export_table; ?>">
		<input type="hidden" name="file_name" value="Reserved_Destroyed_Panels">
		<input type="submit" name="submit" class='btn btn-primary' value="Export to Excel">
		</form>
		</div>

		<script language="javascript" type="text/javascript">
		//<![CDATA[
			var table6_Props = 	{
									rows_counter: true,
									btn_reset: true,
									loader: true,
									sort_select: true,
									btn: true,
									btn_text: "  >  ",
									loader_text: "Filtering data...",
									display_all_text: "All"
								};
			setFilterGrid( "table1",table6_Props );
		//]]>
		</script>



		<script>


		$("#table1 thead tr th:first input:checkbox").click(function() {
			var checkedStatus = document.getElementById("selectall").checked;

			td = document.getElementsByTagName('tr');
			for (var  i = 0; i < td.length; i++) {
			
			if(td[i].className == "foo")
			{
					
					if(td[i].style.display=="block" || td[i].style.display=="")
					{
						document.getElementById('chk['+i+']').checked=checkedStatus;
						if(checkedStatus==true)
						{
							document.getElementById('rowchk'+i).style.background="#00FF22";
						}
						else
						{
							document.getElementById('rowchk'+i).style.background="white";
						}
					}
			
			}
				
			}

		});

		function selectind(x)
		{
			var checkedStatus = document.getElementById('chk['+x+']').checked;
			if(checkedStatus==true)
			{
				document.getElementById('rowchk'+x).style.background="#00FF22";
			}
			else
			{
				document.getElementById('rowchk'+x).style.background="white";
			}
		}


		function autofill()
		{
			var val=document.getElementById("autofillval").value;
			var td = document.getElementsByTagName('tr');
			
			for (var  i = 0; i < td.length; i++) {
			if(td[i].className == "foo")
			{
					if(td[i].style.display=="block" || td[i].style.display=="")
					{
						if(document.getElementById('chk['+i+']').checked==true)
						{
							document.getElementById('val['+i+']').value=val;
						}
					}
			}
				
			}
		}

		</script>
</div>
</div>