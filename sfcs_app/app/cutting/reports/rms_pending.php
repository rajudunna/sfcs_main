<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
  
error_reporting(0);

include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$view_access=user_acl("SFCS_0235",$username,1,$group_id_sfcs); 
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
$table_filter = getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R');
?>

<title>RMS Requisition status</title>
<script language="javascript" type="text/javascript" src="<?= $table_filter?>"></script>
<script language="javascript" type="text/javascript">
	var MyTableFilter = {  
		exact_match: false,
		col_0: "select",
		col_1: "select", 
		col_2: "select" 
	}
	setFilterGrid( "table1", MyTableFilter );
</script>

<script>
	document.getElementById("msg").style.display="none";		
</script>
<script type="text/javascript">
	

	function verify_date(){
		var from_date = $('#sdate').val();
		var to_date =  $('#edate').val();
		if(to_date < from_date){
			sweetAlert('End Date must not be less than Start Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}
</script>

<style>

th,td{
	color : #000;
}

#page_heading{
    width: 100%;
    height: 25px;
    color: WHITE;
    background-color: #29759c;
    z-index: -999;
    font-family:Arial;
    font-size:15px;  
	margin-bottom: 10px;
}

#page_heading h3{
	vertical-align: middle;
	margin-left: 15px;
	margin-bottom: 0;	
	padding: 0px;
 }

#page_heading img{
    margin-top: 2px;
    margin-right: 15px;
}
</style>

<div class='panel panel-primary'>
	<div class="panel-heading">
		<b>RMS Requisition Report</b>
	</div>
	<div class="panel-body">
		<form method="post" name="input" action="?r=<?php echo $_GET['r'] ?>">
			<div class="col-sm-3 form-group">
				<label for='sdate'>Start Date  </label>
				<input class="form-control" type="text" data-toggle="datepicker" id="sdate" name="sdate" size=8 value="<?php  if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"/>
			</div>
			<div class="col-sm-3 form-group">
				<label for='edate'>End Date </label>
				<input class="form-control" type="text" data-toggle="datepicker" id="edate" onchange="return verify_date();" name="edate" size=8 value="<?php  if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>"/>
			</div>
			<div class="col-sm-1">
				<br>
				<input class="btn btn-success" type="submit" name="show" value="Show" id="show" 
				onclick="return verify_date();"/>
			</div>	
		</form>
		<hr>
		


<?php
if(isset($_POST['show']))
{
	$row_count = 0;
	$s_date=$_POST['sdate'];
	$e_date=$_POST['edate'];
	$order_tid=array();
	$jobs=array();
	$docket=array();
	$tot_doc=array();
	//echo $host."<br>";
	$sql1="select distinct order_tid,count(doc_no) as cuts,group_concat(doc_no order by doc_no) as docket,group_concat(pcutno order by pcutno) as cut_doc from $bai_pro3.order_cat_doc_mk_mix where category in ('Body','Front') and date between '".$s_date."' and '".$e_date."' group by order_tid";
	//echo $sql1."<br>";
	$result1=mysqli_query($link, $sql1) or exit("Sql Error--1x==".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	// echo $sql1."<br>";
	if(mysqli_num_rows($result1)>0)
	{
	echo "<div class='col-sm-12' style='max-height : 600px;overflow-y : scroll;overflow-x:scroll;'>
			<table id='table1' class='table table-bordered table-responsive'>
			<tr class='danger'>
				<th>Style </th>
				<th>Schedule No</th>
				<th>Color</th>
				<th>Total Jobs</th>
				<th>Jobs Requested</th>
				<th>Jobs Request Pending</th>
				<th>Jobs Cut Completed</th>
			</tr>";
		
	while($row1=mysqli_fetch_array($result1))
	{
		$row_count++;
		$order_tid[]=$row1['order_tid'];
		$tot_doc[]	=$row1['cuts'];
		$docket[]	=$row1['docket'];
		$jobs[]		=$row1['cut_doc'];
	}
	for($ii=0;$ii<sizeof($order_tid);$ii++)
	{	
		//echo $order_tid[$ii]."<br>";
		$rms_req=array();$cut_com=array();$in_rms=array();$pcutno_c=array();$rms_pen_cut=array();$pcutno_r=array();
		$rms_pen=array();
		$cut_com1='';$rms_req1='';
		$rms_pen1='';$val1='';$val2='';$val3='';
		$sql11="select * from $bai_pro3.bai_orders_db where order_tid='$order_tid[$ii]'";
		$result11=mysqli_query($link, $sql11) or exit("Sql Error--11".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row11=mysqli_fetch_array($result11))
		{
			$color_code=$row11['color_code'];
			$style=$row11['order_style_no'];
			$schedule=$row11['order_del_no'];
			$color=$row11['order_col_des'];
		}
		
		echo "<tr><td>".$style."</td><td>".$schedule."</td><td>".$color."</td><td>".$tot_doc[$ii]."</td>";
		$sql="select group_concat(pcutno order by pcutno) as pcutno,group_concat(doc_no order by doc_no) as doc_no,act_cut_status from $bai_pro3.order_cat_doc_mk_mix where doc_no in(".$docket[$ii].") group by act_cut_status";
		//echo $sql."<br>";
		$result=mysqli_query($link, $sql) or exit("Sql Error1--2".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(1<mysqli_num_rows($result))
		{
			while($row=mysqli_fetch_array($result))
			{
				if($row["act_cut_status"]=='DONE')
				{
					$cut_com=explode(",",$row["doc_no"]);
					$pcutno_c=explode(",",$row["pcutno"]);
				}
				else
				{
					$rms_req=explode(",",$row["doc_no"]);
					$pcutno_r=explode(",",$row["pcutno"]);
				}
			}
		}
		else
		{
			while($row=mysqli_fetch_array($result))
			{
				if($row["act_cut_status"]=='DONE')
				{
					$cut_com=explode(",",$row["doc_no"]);
					$pcutno_c=explode(",",$row["pcutno"]);
					$val2='Not Available';
				}
				else
				{
					$rms_req=explode(",",$row["doc_no"]);
					$pcutno_r=explode(",",$row["pcutno"]);
					$val3='Not Available';
				}				
				
			}
		}
		if(0<sizeof($rms_req))
		{
			$sql2="select doc_ref from $bai_pro3.fabric_priorities where doc_ref in (".implode(",",$rms_req).")";
			$result2=mysqli_query($link, $sql2) or exit("Sql Error2--2".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(0<mysqli_num_rows($result2))
			{
				while($row2=mysqli_fetch_array($result2))
				{
					$in_rms[]=$row2["doc_ref"];
				}
				
			}
			else
			{
				$val1='Not Available';
				$sql222="select group_concat(pcutno order by pcutno) as pcutno,group_concat(doc_no order by doc_no) as doc_no from $bai_pro3.order_cat_doc_mk_mix where doc_no in (".implode(",",$rms_req).")";
				$result222=mysqli_query($link, $sql222) or exit("Sql Error3--2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row222=mysqli_fetch_array($result222))
				{
					$rms_pen=explode(",",$row222["pcutno"]);
					$rms_pen_cut=explode(",",$row222["pcutno"]);
				}
			}			
		}
		else
		{
			$val2='Not Available';
		}
		$check=0;
		$check1=0;
		if($val2=='')
		{
			if($val1=='')
			{
				for($i=0;$i<sizeof($rms_req);$i++)
				{
					if(in_array($rms_req[$i],$in_rms))
					{
						$check++;
						if($check==10)
						{
							$rms_req1.=chr($color_code).leading_zeros($pcutno_r[$i],3).",<br>";
							$check=0;
						}
						else
						{
							$rms_req1.=chr($color_code).leading_zeros($pcutno_r[$i],3).",";
						}
					}
					else
					{
						$check1++;
						if($check1==10)
						{
							$rms_pen1.=chr($color_code).leading_zeros($pcutno_r[$i],3).",<br>";
							$check1=0;
						}
						else
						{
							$rms_pen1.=chr($color_code).leading_zeros($pcutno_r[$i],3).",";
						}
					}
				
				}
				echo "<td>".substr($rms_req1,0,-1)."</td><td>".substr($rms_pen1,0,-1)."</td>";
			}
			else
			{
				for($i=0;$i<sizeof($rms_pen);$i++)
				{
					//$rms_pen1.=chr($color_code).leading_zeros($rms_pen_cut[$i],3).",";
						$check1++;
						if($check1==10)
						{
							$rms_pen1.=chr($color_code).leading_zeros($rms_pen_cut[$i],3).",<br>";
							$check1=0;
						}
						else
						{
							$rms_pen1.=chr($color_code).leading_zeros($rms_pen_cut[$i],3).",";
						}
				}
				echo "<td></td><td>".substr($rms_pen1,0,-1)."</td>";
			
			}	
		}
		else	
		{
			echo "<td></td><td></td>";
		}
		$check2=0;
		if($val3=='')
		{
			for($i=0;$i<sizeof($cut_com);$i++)
			{
				$check2++;
				if($check2==10)
				{
					$cut_com1.=chr($color_code).leading_zeros($pcutno_c[$i],3).",<br>";
					$check2=0;
				}
				else
				{
					$cut_com1.=chr($color_code).leading_zeros($pcutno_c[$i],3).",";
				}
			}
			echo "<td>".substr($cut_com1,0,-1)."</td></tr>";
		}
		else
		{
			echo "<td></td></tr>";
		}
		
		Unset($rms_req);
		unset($cut_com);
		unset($in_rms);
		unset($pcutno_c);
		unset($rms_pen_cut);
		unset($pcutno_r);
		unset($rms_pen);	
	
	}
	
		echo "</table>
	</div>";	
	}
	else
	{
		echo "<h4 style='color:red'>No Data Found</h4>";
	}
}
?>


</div><!-- panel body -->
</div><!--  panel -->
</div>
