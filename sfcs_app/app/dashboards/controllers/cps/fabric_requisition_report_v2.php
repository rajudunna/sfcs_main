
<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
/* @import "TableFilter_EN/filtergrid.css"; */

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
<?php 
// echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/common/css 	/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
?>
<!-- <script src="../../../../../template/helperjs.js"></script> -->
<link rel="stylesheet" href="../../../../../assets/css/datepicker.css" />
<!-- <script src="../../../../../assets/js/datepicker.js"></script> -->
<script src="../../../../common/js/jquery.min.js"></script>
<script src="../../../../common/js/TableFilter_EN/actb.js"></script>
<script src="../../../../common/js/TableFilter_EN/tablefilter.js"></script>


<script src="../../../../common/js/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../../../common/css/page_style.css" />
<link rel="stylesheet" href="../../../../common/css/bootstrap.min.css">
<?php

$mins=array("00","05","10","15","20","25","30","35","40","45","50","55");


?>
<body>
<div class="panel panel-primary">
<div class="panel-heading">Fabric Requisition Details</div>
<div class="panel-body">
<form action="fabric_requisition_report_v2.php" method="post" name="form1">
<div class="row">
    <div class="col-md-2">
        <label>Start Date</label>
        <input  type='date' data-toggle="datepicker" class="form-control" id='sdat' name="sdat" value="<?php  if(isset($_POST['sdat'])) { echo $_POST['sdat']; } else { echo date("Y-m-d"); } ?>" size=8 />
    </div>
    <div class="col-md-2"><br/>
        <select name="stime" id="stime" class="form-control"><?php
                for($l=00;$l<=23;$l++)
                {
                    for($k=0;$k<sizeof($mins);$k++)
                    {
                        if($l<13)
                        {
                            if($l==12)
                            {
                                echo "<option value='".$l.":".$mins[$k]."'>".$l.":".$mins[$k]." P.M</option>";
                            }
                            else
                            {
                                echo "<option value='".$l.":".$mins[$k]."'>".$l.":".$mins[$k]." A.M</option>";
                            }	
                        }
                        else
                        {
                            $r=$l-12;
                            echo "<option value='".$l.":".$mins[$k]."'>".$r.":".$mins[$k]." P.M</option>";
                        }
                    }				
                }
        ?></select>
    </div>
    <div class="col-md-2">
        <label>End Date</label>
        <input type='date' data-toggle="datepicker" id="edat" name="edat" class="form-control" value="<?php  if(isset($_POST['edat'])) { echo $_POST['edat']; } else { echo date("Y-m-d"); } ?>" size=8 />
    </div>
    <div class="col-md-2"><br/>
        <select name="etime" id="etime" class="form-control"><?php
                for($l=0;$l<=23;$l++)
                {
                    for($k=0;$k<sizeof($mins);$k++)
                    {
                        if($l<13)
                        {
                            if($l==12)
                            {
                                echo "<option value='".$l.":".$mins[$k]."'>".$l.":".$mins[$k]." P.M</option>";
                            }
                            else
                            {
                                echo "<option value='".$l.":".$mins[$k]."'>".$l.":".$mins[$k]." A.M</option>";
                            }	
                        }
                        else
                        {
                            $r=$l-12;
                            echo "<option value='".$l.":".$mins[$k]."'>".$r.":".$mins[$k]." P.M</option>";
                        }
                    }				
                }
        ?></select>
    </div>
    <div class="col-md-2"><br/>
		<select name="cat" id='selection' class="form-control"><option value="" >Please Select</option><option value="1" <?php echo $_POST['cat']== '1' ? 'selected' : '' ?>>Pending</option><option value="2" <?php echo $_POST['cat']== '2' ? 'selected' : '' ?>>Completed</option></select>
		
    </div>
    <div class="col-md-2"><br/>
        <input type="submit" id="submit" name="submit" class="btn btn-success" value="Submit"/ disabled>
    </div>
</div>

</form>

<?php


//echo "<br/><br/>";
if(isset($_POST["submit"]))
{


$sdate=$_POST["sdat"];
$edate=$_POST["edat"];
$stime=$_POST["stime"];
$etime=$_POST["etime"];
$cat=$_POST["cat"];
if($cat!=''){
	if($cat==1)
	{
		$sql2="select * from bai_pro3.fabric_priorities where req_time between '$sdate $stime:00' and '$edate $etime:00'  and issued_time='0000-00-00 00:00:00' order by req_time";
	}
	if($cat==2)
	{
		$sql2="select * from bai_pro3.fabric_priorities where issued_time between '$sdate 06:00:00' and '$edate 23:00:00'  and issued_time!='0000-00-00 00:00:00'  order by issued_time";
	}
	// echo $sql2;
	echo "<hr/>";

	echo "<div style='max-height:600px;overflow-x:scroll;overflow-y:scroll'><table id='example1' name='example1' class='table table-bordered'>";
	echo "<tr><th>Section</th><th>Module</th><th>Lay Req. Date</th><th>Lay Req. Time</th><th>Style</th><th>Schedule</th><th>Color</th><th>Docket No</th><th>Job No</th><th>Qty</th><th>Fabric Status</th><th>Requested By</th><th>Requested at</th><th>Issued at</th></tr>";
	$result2=mysqli_query($link,$sql2) or die("Error = ".mysqli_error());
	if(mysqli_num_rows($result2) > 0) {
		while($row2=mysqli_fetch_array($result2))
		{
			$log=$row2["req_time"];
			$log_split=explode(" ",$log);
			//$sec_count=$row2["sec"];
			
			echo "<tr>";
			echo "<td>".$row2["section"]."</td>";
			echo "<td>".$row2["module"]."</td>";
			echo "<td>".$log_split[0]."</td>";
			echo "<td>".$log_split[1]."</td>";
			
				
			
			$sql11="select * from bai_pro3.plandoc_stat_log where doc_no='".$row2["doc_ref"]."'";
			$sql_result11=mysqli_query($link,$sql11) or die("Error1 = ".mysqli_error());
			while($row11=mysqli_fetch_array($sql_result11))
			{
				$order_tid=$row11["order_tid"];
				$cut_nos=$row11["acutno"];
				$total_cut_qty=($row11["a_s01"]+$row11["a_s02"]+$row11["a_s03"]+$row11["a_s04"]+$row11["a_s05"]+$row11["a_s06"]+$row11["a_s07"]+$row11["a_s08"]+$row11["a_s09"]+$row11["a_s11"]+$row11["a_s12"]+$row11["a_s13"]+$row11["a_s14"]+$row11["a_s15"]+$row11["a_s16"]+$row11["a_s17"]+$row11["a_s18"]+$row11["a_s19"]+$row11["a_s21"]+$row11["a_s22"]+$row11["a_s23"]+$row11["a_s24"]+$row11["a_s25"]+$row11["a_s26"]+$row11["a_s27"]+$row11["a_s28"]+$row11["a_s29"]+$row11["a_s31"]+$row11["a_s32"]+$row11["a_s33"]+$row11["a_s34"]+$row11["a_s35"]+$row11["a_s36"]+$row11["a_s37"]+$row11["a_s38"]+$row11["a_s39"]+$row11["a_s41"]+$row11["a_s42"]+$row11["a_s43"]+$row11["a_s44"]+$row11["a_s45"]+$row11["a_s46"]+$row11["a_s47"]+$row11["a_s48"]+$row11["a_s49"]+$row11["a_s50"])*($row11["p_plies"]);
			}
			
			$sql21="select order_style_no,order_del_no,order_col_des,order_div,color_code from bai_pro3.bai_orders_db where order_tid='".$order_tid."'";
			$sql_result21=mysqli_query($link,$sql21) or die("Error2 = ".mysqli_error());
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
			if($cut_nos > 9)
			{
				echo "<td>".chr($color_code)."0".$cut_nos."</td>";	
			}
			else
			{
				echo "<td>".chr($color_code)."00".$cut_nos."</td>";	
			}
			
			echo "<td>".$total_cut_qty."</td>";
			
			$issued_time=$row2["issued_time"];
			
			if($issued_time=="0000-00-00 00:00:00")
			{
				echo "<td>Not Issued</td>";
			}
			else
			{
				echo "<td>Issued</td>";
			}
			echo "<td>".strtoupper($row2["log_user"])."</td>";
			echo "<td>".$row2["log_time"]."</td>";
			echo "<td>".$row2["issued_time"]."</td>";
			echo "</tr>";
			
		}
	}
	else{
		echo "<tr><td colspan='14' style='text-align:center;font-weight:bold;color:red;'>No Data Found!</td></tr>";
	}


	$sql2x="select * from bai_pro3.fabric_priorities_backup where req_time between '$sdate $stime:00' and '$edate $etime:00' and issued_time='0000-00-00 00:00:00' order by req_time";

	if($cat==2)
	{
		$sql2x="select * from bai_pro3.fabric_priorities_backup where issued_time between '$sdate 06:00:00' and '$edate 23:00:00' and issued_time!='0000-00-00 00:00:00' order by issued_time";
	}


	//echo $sql2;

	$result2x=mysqli_query($link,$sql2x) or die("Error = ".mysqli_error());
	while($row2x=mysqli_fetch_array($result2x))
	{
		$log1=$row2x["req_time"];
		$log_split1=explode(" ",$log1);
		//$sec_count=$row2["sec"];
		
		echo "<tr>";
		echo "<td>".$row2x["section"]."</td>";
		echo "<td>".$row2x["module"]."</td>";
		echo "<td>".$log_split1[0]."</td>";
		echo "<td>".$log_split1[1]."</td>";
		
			
		
		$sql11x="select * from bai_pro3.plandoc_stat_log where doc_no='".$row2x["doc_ref"]."'";
		$sql_result11x=mysqli_query($link,$sql11x) or die("Error1 = ".mysqli_error());
		while($row11x=mysqli_fetch_array($sql_result11x))
		{
			$order_tid1=$row11x["order_tid"];
			$cut_nos1=$row11x["acutno"];
			$total_cut_qty1=($row11x["a_s01"]+$row11x["a_s02"]+$row11x["a_s03"]+$row11x["a_s04"]+$row11x["a_s05"]+$row11x["a_s06"]+$row11x["a_s07"]+$row11x["a_s08"]+$row11x["a_s09"]+$row11x["a_s11"]+$row11x["a_s12"]+$row11x["a_s13"]+$row11x["a_s14"]+$row11x["a_s15"]+$row11x["a_s16"]+$row11x["a_s17"]+$row11x["a_s18"]+$row11x["a_s19"]+$row11x["a_s21"]+$row11x["a_s22"]+$row11x["a_s23"]+$row11x["a_s24"]+$row11x["a_s25"]+$row11x["a_s26"]+$row11x["a_s27"]+$row11x["a_s28"]+$row11x["a_s29"]+$row11x["a_s31"]+$row11x["a_s32"]+$row11x["a_s33"]+$row11x["a_s34"]+$row11x["a_s35"]+$row11x["a_s36"]+$row11x["a_s37"]+$row11x["a_s38"]+$row11x["a_s39"]+$row11x["a_s41"]+$row11x["a_s42"]+$row11x["a_s43"]+$row11x["a_s44"]+$row11x["a_s45"]+$row11x["a_s46"]+$row11x["a_s47"]+$row11x["a_s48"]+$row11x["a_s49"]+$row11x["a_s50"])*($row11x["p_plies"]);
		}
		
		$sql21x="select order_style_no,order_del_no,order_col_des,order_div,color_code from bai_pro3.bai_orders_db where order_tid='".$order_tid1."'";
		$sql_result21x=mysqli_query($link,$sql21x) or die("Error2 = ".mysqli_error());
		while($row21x=mysqli_fetch_array($sql_result21x))
		{
			$style1=$row21x["order_style_no"];
			$schedule1=$row21x["order_del_no"];
			$color1=$row21x["order_col_des"];
			$buyer1=$row21x["order_div"];
			$color_code1=$row21x["color_code"];
		}
		
		echo "<td>".$style1."</td>";
		echo "<td>".$schedule1."</td>";
		echo "<td>".$color1."</td>";
		
		echo "<td>".$row2x["doc_ref"]."</td>";
		if($cut_nos1 > 9)
		{
			echo "<td>".chr($color_code1)."0".$cut_nos1."</td>";	
		}
		else
		{
			echo "<td>".chr($color_code1)."00".$cut_nos1."</td>";	
		}
		
		echo "<td>".$total_cut_qty1."</td>";
		
		$issued_time1=$row2x["issued_time"];
		
		if($issued_time1=="0000-00-00 00:00:00")
		{
			echo "<td>Not Issued</td>";
		}
		else
		{
			echo "<td>Issued</td>";
		}
		echo "<td>".strtoupper($row2x["log_user"])."</td>";
		echo "<td>".$row2x["log_time"]."</td>";
		echo "<td>".$row2x["issued_time"]."</td>";
		echo "</tr>";
		
	}
	echo "</table></div>";
	}
}
else {

}
?>
<script language="javascript" type="text/javascript">
$('#edat,#sdat').on('change',function(){
	var val1 = $('#sdat').val();
	var val2 = $('#edat').val();
	if(val1 > val2){
		sweetAlert('Start Date Should be less than End Date','','warning');
		return false;
	}
	else
	{
	    return true;
	}
});
$('#selection,#edat,#sdat,#stime,#etime').on('input',function(){
	
	if($('#selection').val() !=''){
		document.getElementById("submit").disabled=false;
	}
	
});
	
</script> 
<script language="javascript" type="text/javascript">
	//<![CDATA[
		$('#reset_example1').addClass('btn btn-warning');
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							// btn_reset_text: "Clear",
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "example1",table6_Props );
	$(document).ready(function(){
		$('#reset_example1').addClass('btn btn-warning btn-xs');
	});
	//]]>
</script>
</body>
</div>
</div>
<style>
#stime{
	margin-top:2pt;
}
#stime{
	margin-top:2pt;
}
#reset_example1{
	width : 50px;
	color : #ec971f;
	margin-top : 10px;
	margin-left : 0px;
	margin-bottom:15pt;
}
</style>