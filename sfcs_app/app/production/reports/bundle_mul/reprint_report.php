<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="../../../../common/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../../../common/js/datetimepicker_css.js"></script> 
<link rel="stylesheet" type="text/css" href="../../../../../common/js/style.css">
<link rel="stylesheet" type="text/css" href="../../../../../common/js/table.css">
<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0;
 width:auto;
float:right;
table {
    float:left;
    width:33%;
}
</style>
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px;  padding:5px; background-color:#f4f4f4; solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; solid #ccc; white-space: nowrap;}
td{ padding:2px; white-space: nowrap;}
</style>
<script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script>



<script language="javascript" type="text/javascript">


function check_val()
{
	//alert('dfsds');
	var sdate=document.getElementById('demo1').value;
	var edate=document.getElementById('demo2').value;
	//alert(edate);
	//alert(c_block);
	//alert(schedule);
	if(sdate >edate)
	{
		alert('Please select the values');
		return false;
	}
		
}

</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="panel panel-primary">	
<div class="panel-heading"><b style='font-size:18px'>Day wise Re-print Report</b></div>

<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
//include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");

//$view_access=user_acl("SFCS_0250",$username,1,$group_id_sfcs); 

error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


//echo $style.$schedule.$color;
?>

<!-- <form name="mini_order_report" action="?r=<?php //echo $_GET['r'];?>" method="post" > -->
<form name="mini_order_report" action="?r=<?php echo $_GET['r'];?>" method="post" onsubmit=" return check_val();">
<br>
<table><tr>
<!-- <td>
Start Date: <input id="demo1" onclick="javascript:NewCssCal('demo1','yyyymmdd','dropdown')" type="text" name="sdate" size="8" value="<?php //if(isset($_REQUEST['sdate'])) { echo $_REQUEST['sdate']; } else { echo date("Y-m-d"); } ?>"> End Date: <input id="demo2" onclick="javascript:NewCssCal('demo2','yyyymmdd','dropdown')" type="text" size="8" name="edate" value="<?php //if(isset($_REQUEST['edate'])) { echo $_REQUEST['edate']; } else { echo date("Y-m-d"); } ?>"></td> -->
                 <td> <div class="col-md-5">
						 <b style='font-size:12px;'>Start Date:</b> <input id="demo1" class="form-control" onclick="javascript:NewCssCal('demo1','yyyymmdd','dropdown')" type="text" data-toggle='datepicker' size="8" name="sdate" value=<?php if(isset($_REQUEST['sdate'])) { echo $_REQUEST['sdate']; } else { echo date("Y-m-d"); } ?>>
					</div>
					<div class="col-md-5">
						 <b style='font-size:12px;padding-left: 55px;'>End Date:</b>   <input id="demo2" class="form-control" onclick="javascript:NewCssCal('demo2','yyyymmdd','dropdown')" type="text" data-toggle='datepicker' size="8" name="edate" value=<?php if(isset($_REQUEST['edate'])) { echo $_REQUEST['edate']; } else { echo date("Y-m-d"); } ?>>
					</div></td>
<td style='padding-left:38px;'><input type="checkbox" name="check_list[]" value="1"><b style='font-size:12px;'>Module</b> <input type="checkbox" name="check_list[]" value="2"><b style='font-size:12px;'>Employee</b> <input type="checkbox" name="check_list[]" value="3"><b style='font-size:12px;'>Shift</b></td> 
<td>


 <?php
	//echo "<input type=\"submit\" value=\"submit\" name=\"submit\">";
	echo "<input type=\"submit\" name=\"submit\" value=\"submit\"  class=\"btn btn-success\">";	
?>
</td></tr><table>

</form>

</div>
<?php
//$hours=array('6-7AM','7-8AM','8-9AM','9-10AM','10-11AM','11-12AM','12-13PM','13-14PM','14-15PM','15-16PM','16-17PM','17-18PM','18-19PM','19-20PM','20-21PM','21-22PM','22-23PM');
if(isset($_POST['submit']))
{
	$check_box=$_POST['check_list'];
	$filter='';
	$filter_n='';
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	//echo sizeof($check_box)."<br>";
	//echo $_POST['sdate']."--".$_POST['edate']."--".$check_box[0]."--".$check_box[1]."--".$check_box[2]."<br>";
	if(empty($check_box)) {
		
	}else{
		if(sizeof($check_box)>0)
		{
			for($i=0;$i < sizeof($check_box);$i++)
			{
				//echo $check_box[$i]."<br>";
				if($check_box[$i]==1)
				{
					$filter.="module_id,";
				}
				else if($check_box[$i]==2)
				{
					$filter.="emp_id,";
				}
				else if($check_box[$i]==3)
				{
					$filter.="shift,";
				}
			}
		}
		else
		{
			
			//$filter.=",";
		}
		if(sizeof($check_box)>0)
		{
			$filter_n=",".substr($filter, 0, -1);  
		}
		else
		{
			$filter_n='';
		}
	}
	
	
//echo $filter."<br>";
	$sql="SELECT date(date_time) as date_time,$filter bundle_id,user_name,remark from $brandix_bts.re_print_table where date(date_time)
BETWEEN '$sdate' AND '$edate' GROUP BY date_time $filter_n ORDER BY date_time";
//echo $sql."<br>";
	//$sets=explode(",",$filter_n);
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowcount=mysqli_num_rows($sql_result);
	if($rowcount > 0){
		echo "<br>";
		echo "<br>";
		echo "<div class='table-responsive'>";
		echo "<table id=\"info\" class='table table-bordered'>";
		echo "<th>Date</th>";
		if(empty($check_box)) {
		
		}else{
			if(sizeof($check_box)>0)
			{
				for($i=0;$i < sizeof($check_box);$i++)
				{
					//echo $check_box[$i]."<br>";
					if($check_box[$i]==1)
					{
						echo "<th>Module</th>";
					}
					else if($check_box[$i]==2)
					{
						echo "<th>Employee</th>";
					}
					else if($check_box[$i]==3)
					{
						echo "<th>Shift</th>";
					}
					
				}
			}
		}
		
		
		//echo "<th>Shift</th>";
		//for($i=0;$i<sizeof($hours);$i++)
		//{
		//	echo "<th>".$hours[$i]."</th>";
		//}
		echo "<th>Bundle Number</th>";
		echo "<th>Username</th>";
		echo "<th>Remark</th></tr>";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$date=$sql_row['date_time'];
			echo "<tr>";
			echo "<td>".$date."</td>";
			if(empty($check_box)) {
		
			}else{
				for($i=0;$i < sizeof($check_box);$i++)
				{
					//echo $check_box[$i]."<br>";
					if($check_box[$i]==1)
					{
						echo "<td>".$sql_row['module_id']."</td>";
					}
					else if($check_box[$i]==2)
					{
						echo "<td>".$sql_row['emp_id']."</td>";
					}
					else if($check_box[$i]==3)
					{
						echo "<td>".$sql_row['shift']."</td>";
					}
					
				}
			}
			
			echo "<td>".$sql_row['bundle_id']."</td>";
			echo "<td>".$sql_row['user_name']."</td>";
			echo "<td>".$sql_row['remark']."</td>";
			
			echo "</tr>";
		}
	echo "</table></div>";
	echo "<br>";
	}else{
		echo "<script>sweetAlert('No Data Found Between the Selected Dates','','warning');</script>";
	}
	

}

?> 
<style>

.table {
    margin-left: 25px;
    /* margin-right: 17px; */
    width: 95%;
    max-width: 100%;
    margin-bottom: 20px;
}
body
		{
			font-size:14px;
		}

</style>