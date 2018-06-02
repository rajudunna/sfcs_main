
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	      ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header.php',1,'R') );  ?>
<?php $user_manual  = getFullURL($_GET['r'],'Surplus_User_Manual.docx','R'); ?>
<?php

$view_access  = user_acl("SFCS_0031",$username,1,$group_id_sfcs);
$table_filter = getFullURLLevel($_GET['r'],'common/js/tablefilter_en/table_filter.js',3,'R');


//CR#1341 // kirang // 2015-06-05 // Surplus Destruction Process in SFCS - To view Surplus AOD details, Destruction process photos and certificate.
?>
<style>
th,td{color : #000;}
th {
	white-space: nowrap;
}
</style>

<title>Surplus AOD & Destruction Details</title>

<script language="javascript" type="text/javascript" src="<?php echo $table_filter ?>"></script>
<script language="JavaScript" type="text/javascript">
var newwindow = ''
function popitup(url,comm) {
if (newwindow.location && !newwindow.closed) {
	//alert("http://bai-test-sfcs:8080/projects/beta/packing/photos/"+url+"-"+comm);
    newwindow.location.href = url;
	newwindow.document.title = "Surplus Destruction Photos";
	newwindow.document.write("<html><head><title>Zoom Image</title></head><body><p><strong>Comment:"+comm+'</strong><br/><div style="overflow:auto; width:100%; height:100%;" id="mydiv"/>'+"<img src=http:///bai-test-sfcs:8080/projects/beta/packing/photos/"+url+' style="width:100%; height:100%;"></div></p></body></html>');
    newwindow.focus(); }
else {
    newwindow=window.open(url,'urltoopen','width=800,height=600,resizable=1,scrollbars=yes');
	newwindow.document.title = "Surplus Destruction Photos";
	}
}

function tidy() {
if (newwindow.location && !newwindow.closed) {
   newwindow.close(); }
}
// Based on JavaScript provided by Peter Curtis at www.pcurtis.com -->
</script>

<!-- <tr class='danger'>
				<th rowspan=2>Destroy Note #</th><th rowspan=2>MER Ref. Month</th>
				<th rowspan=2>Reported Date</th>
				<th rowspan=2>Log User</th>
				<th colspan=4>Prior To Destruction<br></th>
				<th colspan=2>While Destruction</th>
				<th>After Destruction</th>
				<th rowspan=2>Destruction Certificate</th>
				<th rowspan=2>Mail Copy</th>
				<th rowspan=2>Carton Count</th>
				<th colspan=3>Upload Destruction Photos</th>
			</tr>
			<tr  class='success'>
				<th>Stacked Cartons</th><th>While Loading</th><th>Carton Weighing</th><th>At Security</th><th>Opened BOX</th>
				<th>On Shredder</th><th>Collecting Dust</th><th>Brief Details</th><th colspan=2>Style Level</th>
			</tr> -->

<div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Surplus Destruction Files View</b>
		<span style="float: right" class='btn btn-info btn-xs'><b><a href="<?php echo $user_manual; ?>">info ?</a></b>&nbsp;</span>
	</div>
	<div class='panel-body'>
		<div class='col-sm-12' style='overflow-y:scroll;max-height : 600px;'>
		<table class='table table-bordered table-responsive' id="table_3" cellspacing="0" class="mytable1">
		<thead>
			<tr class='danger'>
				<th rowspan=2>Destroy Note #</th><th rowspan=2>MER Ref. Month</th>
				<th rowspan=2>Reported Date</th>
				<th rowspan=2>Log User</th>
				<th colspan=4>Prior To Destruction<br></th>
				<th colspan=2>While Destruction</th>
				<th>After Destruction</th>
				<th rowspan=2>Destruction Certificate</th>
				<th rowspan=2>Mail Copy</th>
				<th rowspan=2>Carton Count</th>
				<th colspan=3>Upload Destruction Photos</th>
			</tr>
			<tr  class='success'>
				<th>Stacked Cartons</th><th>While Loading</th><th>Carton Weighing</th><th>At Security</th><th>Opened BOX</th>
				<th>On Shredder</th><th>Collecting Dust</th><th>Brief Details</th><th colspan=2>Style Level</th>
			</tr>
		</thead>

		<?php
		$x=1; 
		$sql="SELECT * FROM $bai_pro3.bai_qms_destroy_log order by qms_des_note_no";
		echo $sql;
		$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
		$url = getFullURLLevel($_GET['r'],'surplus_aod.php',0,'R');
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			echo "<tr>";
			echo "<td><a class='btn btn-xs btn-info' href=\"javascript:popitup("."'$url?desnote=".$sql_row["qms_des_note_no"]."'".")\">".$sql_row["qms_des_note_no"]."</a></td>";
			echo "<td>".$sql_row["mer_month_year"]."</td>";
			//echo "<td>".$sql_row["mer_month_year"]."</td>";
			echo "<td>".$sql_row["qms_des_date"]."</td>";
			echo "<td>".$sql_row["qms_log_user"]."</td>";
			//echo "<td><a href=\"../photos/index_v2.php?dest=".$sql_row["qms_des_note_no"]."\" onclick=\"return popitup("."'../photos/index_v2.php?dest=".$sql_row["qms_des_note_no"]."'".")\">".$sql_row["qms_des_note_no"]."</a></td>";
					
			$sql1="SELECT COUNT(DISTINCT remarks) AS ctn,sum(qms_qty) as qty FROM $bai_pro3.bai_qms_db WHERE location_id=\"DESTROYED-DEST#".$sql_row["qms_des_note_no"]."\"";
			//echo $sql1."<br>";
			$sql_result1=mysqli_query($link, $sql1) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$carton_count=$sql_row1["ctn"];
				$carton_qty=$sql_row1["qty"];
			}
					
			$sql2="select * from $bai_pack.upload_dest where dest=\"".$sql_row["qms_des_note_no"]."\"";
			// echo $sql2;
			$sql_result2=mysqli_query($link, $sql2) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result2) > 0)
			{
				while($row2=mysqli_fetch_array($sql_result2))
				{  			 
					$pho=$row2['name'];
					
					echo "<td><A href=\"javascript:popitup('".$path_destrcution."/$pho')\"><img src=\"".$path_destrcution."/thumb_".$row2['name']."\" height=100 width=100 alt=\"Click Here to Zoom\"></A> </a></td>";

					$pho1=$row2['name1'];
			
					echo "<td><A href=\"javascript:popitup('".$path_destrcution."/$pho1')\"><img src=\"".$path_destrcution."/thumb_".$row2['name1']."\" height=100 width=100 alt=\"Click Here to Zoom\"></A> </a></td>";

					$pho2=$row2['name2'];
			
					echo "<td><A href=\"javascript:popitup('".$path_destrcution."/$pho2')\"><img src=\"".$path_destrcution."/thumb_".$row2['name2']."\" height=100 width=100 alt=\"Click Here to Zoom\"></A> </a></td>";

					$pho3=$row2['name3'];
			
					echo "<td><A href=\"javascript:popitup('".$path_destrcution."/$pho3')\"><img src=\"".$path_destrcution."/thumb_".$row2['name3']."\" height=100 width=100 alt=\"Click Here to Zoom\"></A> </a></td>";
					
					$pho4=$row2['name4'];
			
					echo "<td><A href=\"javascript:popitup('".$path_destrcution."/$pho4')\"><img src=\"".$path_destrcution."/thumb_".$row2['name4']."\" height=100 width=100 alt=\"Click Here to Zoom\"></A> </a></td>";
					
					$pho5=$row2['name5'];
			
					echo "<td><A href=\"javascript:popitup('".$path_destrcution."/$pho5')\"><img src=\"".$path_destrcution."/thumb_".$row2['name5']."\" height=100 width=100 alt=\"Click Here to Zoom\"></A> </a></td>";
					
					$pho6=$row2['name6'];
			
					echo "<td><A href=\"javascript:popitup('".$path_destrcution."/$pho6')\"><img src=\"".$path_destrcution."/thumb_".$row2['name6']."\" height=100 width=100 alt=\"Click Here to Zoom\"></A> </a></td>";
					
					$pho7=$row2['dc_cerf'];
			
					echo "<td><A class='btn btn-danger btn-xs' href=\"javascript:popitup('".$path_destrcution."/".$pho7."')\">Destruction Certificate</A></td>";
					
					$pho8=$row2['mail_copy'];  
					echo "<td><A classlass='btn btn-danger btn-xs' href=\"javascript:popitup('".$path_destrcution."/".$pho8."')\">Mail Copy</A></td>";	
				}
			}else{
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
			}
				
		echo "<td>".$carton_count."</td>";
		$url1 = getFullURLLevel($_GET['r'],'index_v2.php',0,'N');
		$url2 = getFullURLLevel($_GET['r'],'index_v3.php',0,'N');
		$url3 = getFullURLLevel($_GET['r'],'main_v3.php',0,'N');
		echo "<td><a class='btn btn-primary btn-xs' href=\"$url1&dest=".$sql_row["qms_des_note_no"]."\">Upload</a></td>";
		echo "<td><a class='btn btn-primary btn-xs' href=\"javascript:popitup('$url2&dest=".$sql_row["qms_des_note_no"]."')\">Upload</a></td>";
		echo "<td><a class='btn btn-success btn-xs' href=\"$url3&dest=".$sql_row["qms_des_note_no"]."\">View</a></td>";
		echo "</tr>";
		}
		$x++;	
	?>
		</table>				
	</div>
</div>
</div>
</div>

<script language="javascript" type="text/javascript">
	var table3Filters = {
        status_bar: true,
	    sort_select: true,
		alternate_rows: false,
		loader_text: "Filtering data...",
		loader: true,
		rows_counter: true,
		display_all_text: "Display all",
		btn_reset : true,
		rows_always_visible: [1,2],
		
	};
	setFilterGrid("table_3",table3Filters);
</script> 


<script>
$('#flt0_table_3').on('keyup',function(){
	//alert();
	var val = $('#flt0_table_3').val();
	if(isNaN(val)){
		sweetAlert('Please enter only numbers','','warning');
		$('#flt0_table_3').val('');
	}	
});

$('#flt2_table_3').on('keypress',function(e){
	//alert();
	var val = $('#flt2_table_3').val();
	var k = e.which;
	if( (k > 64 && k < 91) || (k > 96 && k < 123)  ){
		sweetAlert('Alphabets not allowed','','warning');
		$('#flt2_table_3').val('');
	}
});

</script>
