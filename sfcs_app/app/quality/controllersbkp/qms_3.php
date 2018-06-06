<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
?>

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',3,'R'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/style.css',1,'R'); ?>">

<!---<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0;
 width:auto;
float:right;

</style>--->



<!---<style type="text/css" media="screen">
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
</style>--->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>

<!---<div id="page_heading"><span style="float"><h3>Rejection Deleted Log</h3></span><span style="float: right">&nbsp;</span></div>--->
<br/>
<?php 
$sql="select * from $bai_pro3.bai_qms_db_deleted";
$result=mysqli_query($link, $sql) or die("Sql error--1".$sql.mysqli_errno($GLOBALS["___mysqli_ston"]));
echo "<div class='panel panel-primary'>";
echo "<div class='panel-heading'>";echo"Rejection Deleted Log";echo "</div>";
echo "<div class='panel-body'>";
echo "<div class='table-responsive'>";
$msg="<table border='1px' class=\"table table-bordered\" id=\"table1\"><tr><th>Style</th><th>Schedule No</th><th>Color</th><th>Date</th><th>Size</th><th>Quantity</th></tr>";
while($row=mysqli_fetch_array($result))
	{
		$tid=$row["qms_tid"];
		$msg.="<tr><td>".$row["qms_style"]."</td><td>".$row["qms_schedule"]."</td><td>".$row["qms_color"]."</td><td>".$row["log_date"]."</td><td>".$row["qms_size"]."</td><td>".$row["qms_qty"]."</td></tr>";	
	}
	$msg.="</table>";
echo $msg;
echo "</div>";
echo "</div>";
echo "</div>";
?>
<script language="javascript" type="text/javascript">
//<![CDATA[
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table1",table6_Props );
//]]>
</script>
