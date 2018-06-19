<title>Surplus Destruction Process(In Detailed)</title>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	      ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header.php',1,'R') );  ?>

<?php
	$table_filter = getFullURLLevel($_GET['r'],'common/js/tablefilter_en/table_filter.js',3,'R');
	$user_manual  = getFullURL($_GET['r'],'Surplus_User_Manual.docx','R');
	$img_url =  getFullURLLevel($_GET['r'],'common/photos/',1,'R');
?>
<script language="javascript" type="text/javascript" src="<?php echo $table_filter ?>"></script>

<style>
	th,td{color : #000;}
	th{ text-align : center;}
</style>
<SCRIPT language="JavaScript" type="text/javascript">
 
var newwindow = ''
function popitup(url,comm) {
if (newwindow.location && !newwindow.closed) {
    newwindow.location.href = url;	
	newwindow.document.write("<html><head><title>Zoom Image</title></head><body><p><strong>Comment:"+comm+'</strong><br/><div style="overflow:auto; width:100%; height:100%;" id="mydiv"/>'+"<img src="<?= $img_url ?>/url+' style="width:100%; height:100%;"></div></p></body></html>');
    newwindow.focus(); }
else {
	
    newwindow=window.open(url,'urltoopen','width=800,height=600,resizable=1,scrollbars=1');
	newwindow.document.title = "Surplus Destruction Process(In Detailed)";
    newwindow.focus();
	}
}

function tidy() {
if (newwindow.location && !newwindow.closed) {
   newwindow.close(); }
}
// Based on JavaScript provided by Peter Curtis at www.pcurtis.com -->
</SCRIPT>

<body onUnload="tidy()">

<div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Surplus Destruction Files View(Style Level/In Detailed)</b>
		<span style="float: right" class='btn btn-info btn-xs'><b><a href="<?php echo $user_manual; ?>">info ?</a></b>&nbsp;</span>
	</div>
	<div class='panel-body'>
<?php 

$qms_des_note_no_ref=$_GET["dest"];

$sql="SELECT mer_month_year,date(qms_des_date) as qms_date,mer_remarks FROM $bai_pro3.bai_qms_destroy_log where qms_des_note_no=\"".$qms_des_note_no_ref."\"";
$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$mer_ref=$sql_row["mer_month_year"];
	$res_dat=$sql_row["qms_date"];
	$mer_remarks=$sql_row["mer_remarks"];
}

?>			 
<div class='col-sm-12' style='max-height:600px;overflow-x:scroll;overflow-y:scroll'>
<table class='table table-bordered'>
<tr class='danger'><th rowspan=3>Date</th><th colspan=5>Brand Inventory Destruction Report (Destroy Note # <?php echo $qms_des_note_no_ref; ?>)</th></tr>
<tr class='success'><th colspan=2>Cut To Ship Month</th><th><?php echo $mer_ref; ?></th><th>Destroyed Date</th><th><?php echo $res_dat;  ?></th></tr>
<tr class='info'><th>S.No</th><th>Style</th><th>Prior to Destruction</th><th>While Destruction</th><th>After Destruction</th></tr>
<?php

$x=1;
 
   $sql2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from $bai_pack.upload_dest_summary where dest=\"".$qms_des_note_no_ref."\"");
   while($row2=mysqli_fetch_array($sql2))
   {
		echo "<tr>";
		
		$tid=$row2["tid"];
		$date=$row2["date"];
		
		$style=$row2['style'];
  			 
		echo "<td>".$date."</td>";	 
		echo "<td>".$x."</td>";		 
		echo "<td>".$style."</td>";	
   	    
		echo "<td><A HREF=\"javascript:popitup('".$path_style_level."/".$row2['name']."')\"><img src=\"".$path_style_level."/thumb_".$row2['name']."\" height=150 width=150 alt=\"Click Here to Zoom\"></A> </a></td>";

        $pho1=$row2['name1'];
   
        echo "<td><A HREF=\"javascript:popitup('".$path_style_level."/".$row2['name1']."')\"><img src=\"".$path_style_level."/thumb_".$row2['name1']."\" height=150 width=150 alt=\"Click Here to Zoom\"></A> </a></td>";

        $pho2=$row2['name2'];
   
        echo "<td><A HREF=\"javascript:popitup('".$path_style_level."/".$row2['name2']."')\"><img src=\"".$path_style_level."/thumb_".$row2['name2']."\" height=150 width=150 alt=\"Click Here to Zoom\"></A> </a></td>";
		
		echo "</tr>";
		$x++;
	}
	


?>

</table>				
</div>

<script language="javascript" type="text/javascript">
	var table3Filters = {
	    sort_select: true,
		alternate_rows: true,
		loader_text: "Filtering data...",
		loader: true,
		rows_counter: true,
		display_all_text: "Display all"
		//col_width: ["15px","135px","80px","70px","80px","135px","150px","90px","40px",null];
	}
	setFilterGrid("table_3",table3Filters);
</script> 
</body>
</html>