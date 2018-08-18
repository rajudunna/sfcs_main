<!--
Core Module: Here AQL team will be update Garments Approve or Rejected status.

Description: Here AQL team will be update Garments Approve or Rejected status.

-->
<?php
// include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
// include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
//include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
//include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
//$view_access=user_acl("SFCS_0140",$username,1,$group_id_sfcs);
//include("security1.php");
?>
<html>
<head>
<title>FCA Status Update </title>




<style>
body
{
	font-family: Trebuchet MS;
}
</style>

<script type="text/javascript" language="javascript">
    window.onload = function () {
        noBack();
    }
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>

 <script language="JavaScript">

        var version = navigator.appVersion;

        function showKeyCode(e) {
            var keycode = (window.event) ? event.keyCode : e.keyCode;

            if ((version.indexOf('MSIE') != -1)) {
                if (keycode == 116) {
                    event.keyCode = 0;
                    event.returnValue = false;
                    return false;
                }
            }
            else {
                if (keycode == 116) {
                    return false;
                }
            }
        }

    </script>
	
<script type='text/javascript'>
function firstbox()
{
	var ajax_url ="pending.php?color="+document.test.style.value;Ajaxify(ajax_url);

}
</script>	
</head>
<?php 
// echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/master/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; 
//$url=getFullURLLevel($_GET['r'],'pending_ajax.php',0,'R');?>
<body onpageshow="if (event.persisted) noBack();" onkeydown="return showKeyCode(event)" onload="javascript:  show_content(schedule, '<?= $_POST['color']  ?>');">


<!--<div id="page_heading"><span style="float: left"><h3>FCA Pending List</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>-->
<div class="panel panel-primary">
<div class="panel-heading">FCA Pending List</div>
<div class="panel-body">
<form name="test" method="post" action="<?php $_GET['r']; ?>">

<div class='col-md-3'>
  <label>Schedule No:</label>
  <input type="text" class='form-control integer' size=5  id="schedule" name='schedule'
  onblur="javascript:  show_content(schedule);" value="" required>
</div>
<div class='col-md-4'>
  <span id='show_content'></span>
</div>
<div class='col-md-1'>
	<label><br/></label>
	<input type="submit" name="filter" value="Show" class="btn btn-primary" id='btn' style='display: none'>
</div> 
</form>
<br>

<?php $url=getFullURL($_GET['r'],'pending_ajax.php','R') ?>
<script type='text/javascript'>
function show_content(schedule, colors)
{
	var get_schedule_id=$(schedule).val();
	if(get_schedule_id != '') {
		$.post('<?= $url ?>',{get_id:get_schedule_id, color: colors},function(result)
		{
			$("#show_content").html(result);
			$('#btn').show();
		});
	}
}
</script>



<?php

if(isset($_POST['schedule']) or isset($_POST['filter']) or isset($_GET['schedule']))
{
    if(isset($_POST['schedule'])){
		$schedule=$_POST['schedule'];
		$color= $_POST['color'];
	}
	if(isset($_GET['schedule'])){
		$schedule=$_GET['schedule'];
		$color = $_GET['color'];
	}

// echo " <br/> schedule=".$schedule;

//echo " <br/>color=".$color;
if($color=="0")
{
	$sql="SELECT order_style_no,order_del_no,order_col_des,fca_audit_pending,fca_fail FROM $bai_pro3.disp_mix WHERE order_del_no=$schedule and (fca_fail>=0 OR fca_audit_pending>=0) group by order_col_des";
}
else
{
	$sql="SELECT order_style_no,order_del_no,order_col_des,fca_audit_pending,fca_fail FROM $bai_pro3.disp_mix_2 WHERE order_del_no=$schedule and order_col_des=\"$color\" and (fca_fail>=0 OR fca_audit_pending>=0) group by order_col_des";
}
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$no_of_rows = mysqli_num_rows($sql_result);
if($no_of_rows > 0) {
	echo "<table id=\"table1\" cellspacing=\"0\" class=\"table table-bordered\">";
	echo "<tr><th>Style</th><th>Schedule</th><th>Color</th><th>Audit Pending</th><th>Re-Check Pending</th><th>Controls</th><th>Controls</th><th>Controls</th></tr>";
    $url1=getFullURL($_GET['r'],'recheck.php','N');
    $url2=getFullURL($_GET['r'],'approve.php','N');
    $url3=getFullURL($_GET['r'],'rejects_v2.php','N');
    $url4=getFullURL($_GET['r'],'approve_all.php','N');

 	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style=$sql_row['order_style_no'];
		$schedule=$sql_row['order_del_no'];
		$color_val=$sql_row['order_col_des'];
		$audit_pending=$sql_row['fca_audit_pending'];
		$recheck=$sql_row['fca_fail'];
		
		echo "<tr><td>$style</td><td>$schedule</td><td>$color_val</td><td>$audit_pending</td>";
		

		if($recheck<0)
		{
			if($color=='0')
			{
			echo "<td><a href=\"$url1&style=$style&schedule=$schedule&color=0\">$recheck</a></td>";
			}
			else
			{
			echo "<td><a href=\"$url1&style=$style&schedule=$schedule&color=$color\">$recheck</a></td>";
			}
		}
		else
		{
			echo "<td>$recheck</td>";
		}
			

		
		if(($audit_pending+$recheck)>0)
		{
			if($color=='0')
			{
			echo "<td><a class=\"btn btn-info btn-xs\"  href=\"$url2&style=$style&schedule=$schedule&audit_pending=$audit_pending&color=0\">Update Approved</a></td>";
			echo "<td><a class=\"btn btn-info btn-xs\"  href=\"$url3&style=$style&schedule=$schedule&audit_pending=$audit_pending&color=0\">Update Rejected</a></td>";
			echo "<td><a class=\"btn btn-info btn-xs\" href=\"$url4&style=$style&schedule=$schedule&audit_pending=$audit_pending&recheck=$recheck&color=0\">Approve All</a></td>";
			}
			else
			{
			echo "<td><a class=\"btn btn-info btn-xs\"  href=\"$url2&style=$style&schedule=$schedule&color=$color&audit_pending=$audit_pending\">Update Approved</a></td>";
			echo "<td><a class=\"btn btn-info btn-xs\"  href=\"$url3&style=$style&schedule=$schedule&color=$color&audit_pending=$audit_pending\">Update Rejected</a></td>";
			echo "<td><a class=\"btn btn-info btn-xs\"  href=\"$url4&style=$style&schedule=$schedule&color=$color&audit_pending=$audit_pending&recheck=$recheck\">Approve All</a></td>";
			}
		}
		else
		{
			echo "<td>Update Approved</td>";
			echo "<td>Update Rejected</td>";
			echo "<td>Approve All</td>";
		}
		

		echo "</tr>";
	}
	echo "</table>";
}else{ ?>
	<div class="alert alert-warning">
  		<strong>Info!</strong> No Data Found.
	</div>
	<!-- echo "<div style='color: red'><strong>Info!</strong> No data found</div>"; -->
<?php } 

}

?>
<script language="javascript" type="text/javascript">
//<![CDATA[
	setFilterGrid("table1");
//]]>
</script>
</div></div></body>
</html>