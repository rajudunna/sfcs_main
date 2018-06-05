<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));        ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header.php',1,'R') );  ?>

<?php 
    $table_filter = getFullURLLevel($_GET['r'],'common/js/TableFilter/tablefilter.js',3,'R');
    $view_access = user_acl("SFCS_0033",$username,1,$group_id_sfcs); 
    $image_path = getFullURLLevel($_GET['r'],'common/images',1,'R').'/'; 
?>


<!-- <title>HTML Table Filter Generator v1.6</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<!-- <style type="text/css" media="screen">
th,td{
    color : #000;
}
</style> -->

<style>
th,td{ color : #000;}
th {
    white-space:nowrap;
}
</style>

<script language="javascript" type="text/javascript" src="<?= $table_filter ?>" ></script>


<SCRIPT language="JavaScript" type="text/javascript">
var newwindow = '';
function popitup(url,comm) {
   // alert(url);
   // alert(comm);

if (newwindow.location && !newwindow.closed){
    newwindow.location.href = escape(url);
	newwindow.document.write("<html><head><title>Zoom Image</title></head><body><p><strong>Comment:"+comm+'</strong><br/><div style="overflow:auto; width:100%; height:100%;" id="mydiv"/>'+"<img src="+escape(url)+escape(comm)+' style="width:100%; height:100%;"></div></p></body></html>');
    newwindow.focus(); 
}else{
    newwindow=window.open(escape(url),'urltoopen','width=800,height=600,resizable=1');
	newwindow.document.write("<html><head><title>Zoom Image</title></head><body><p><strong>Comment:"+comm+'</strong><br/><div style="overflow:auto; width:100%; height:100%;" id="mydiv"/>'+"<img src="+escape(url)+escape(comm)+' style="width:100%; height:100%;"></div></p></body></html>');
    newwindow.focus();
	}
}

function tidy() {
if (newwindow.location && !newwindow.closed) {
   newwindow.close(); }
}
</SCRIPT>


<?php include('../'.getFullURLLevel($_GET['r'],'head.php',0,'R') );  ?>

<body onUnload="tidy()">

<div class="col-md-12 table-responsive" style='max-height:600px;overflow:auto;'>
<table class='table table-bordered' id='table_3'>
<tr style="color: #fff;
    background-color: #337ab7;
    border: 1px solid #ddd;">
    <th>SNo</th>
    <th>Photo Report Date</th>
    <th>Empty Container</th>
    <th>Half Container</th>
    <th>Full Container</th>
    <th>Closed Container</th>
    <th>Sealed Container</th>
    <th>Seal #</th></th>
    <th>Vehicle No</th>
    <th>Seal No</th>
    <th>Carton</th>
</tr>

<?php

//Variable $con is coming from the header.php 
$x=1;
$sql1=mysqli_query($link,"select distinct sealno from $bai_pack.upload order by dat desc");

while($rows=mysqli_fetch_array($sql1))
{
   $sql2=mysqli_query($link,"select * from $bai_pack.upload where sealno='".$rows['sealno']."' order by dat desc");
   while($row2=mysqli_fetch_array($sql2))
   {
		 echo "<tr>";
  		 echo "<td>$x</td>";
		 
		 echo "<td style='text-align:center;'>".$row2['dat']."</td>";
		 
         $pho=str_replace(" ", '%20', $row2['name']);    
         
		 echo "<td><A HREF=\"javascript:popitup('$image_path','$pho')\"><img src=\"$image_path".$row2['name']."\" height=150 width=150 alt=\"Click Here to Zoom\"></A> </a></td>";

         $pho1=str_replace(" ", '%20', $row2['name1']);
   
        echo "<td><A HREF=\"javascript:popitup('$image_path','$pho1')\"><img src=\"$image_path".$row2['name1']."\" height=150 width=150 alt=\"Click Here to Zoom\"></A> </a></td>";

         $pho2=str_replace(" ", '%20', $row2['name2']);
   
        echo "<td><A HREF=\"javascript:popitup('$image_path','$pho2')\"><img src=\"$image_path".$row2['name2']."\" height=150 width=150 alt=\"Click Here to Zoom\"></A> </a></td>";

        $pho3=str_replace(" ", '%20', $row2['name3']);
   
        echo "<td><A HREF=\"javascript:popitup('$image_path','$pho3')\"><img src=\"$image_path".$row2['name3']."\" height=150 width=150 alt=\"Click Here to Zoom\"></A> </a></td>";
		
		$pho4=str_replace(" ", '%20', $row2['name4']);
   
        echo "<td><A HREF=\"javascript:popitup('$image_path','$pho4')\"><img src=\"$image_path".$row2['name4']."\" height=150 width=150 alt=\"Click Here to Zoom\"></A> </a></td>";
		
		$pho5=str_replace(" ", '%20', $row2['name5']);
   
        echo "<td><A HREF=\"javascript:popitup('$image_path','$pho5')\"><img src=\"$image_path".$row2['name5']."\" height=150 width=150 alt=\"Click Here to Zoom\"></A> </a></td>";
		
   		 echo "<td>".$row2['vecno']."</td>";
     
  		 echo "<td>".$rows['sealno']."</td>";
   
  		 echo "<td>".$row2['carton']."</td>";   
   
  		echo "</tr>";
	}	
$x++;	
}

?>

<?php

$x=1;
$sql1=mysqli_query($link, "select distinct sealno from $bai_pack.uploads order by dat");
while($rows=mysqli_fetch_array($sql1))
{
   echo "<tr>";
   echo "<td>$x</td>";
   $sql2=mysqli_query($link, "select distinct dat from $bai_pack.uploads where sealno='".$rows['sealno']."'");
   while($row2=mysqli_fetch_array($sql2))
   {
		echo "<td>".$row2['dat']."</td>";
   }
   $sql=mysqli_query($link, "select distinct name from $bai_pack.uploads where sealno='".$rows['sealno']."' order by container");
   while($row=mysqli_fetch_array($sql))
   {
	 $pho=$row['name'];
	 echo "<td><a href=\"javascript:popitup('images/$pho')\"><img src=\"images/thumb_".$row['name']."\" height=150 width=150 alt=\"Click Here to Zoom\"></A></td>";
   }
   
   $sql2=mysqli_query($link, "select distinct vecno from $bai_pack.uploads where sealno='".$rows['sealno']."'");
   while($row2=mysqli_fetch_array($sql2))
   {
		echo "<td>".$row2['vecno']."</td>";
   }
   echo "<td>".$rows['sealno']."</td>";
   $sql2=mysqli_query($link, "select distinct carton from $bai_pack.uploads where sealno='".$rows['sealno']."'");
   while($row2=mysqli_fetch_array($sql2))
   {
		echo "<td>".$row2['carton']."</td>";
   }
   
   echo "</tr>";
$x++;	
}
?>

</table>				
</div>
</div>
</div>

<script language="javascript" type="text/javascript">
	var table3Filters = {
	    col_1: "select",
  
	}
	//setFilterGrid("table_3",table3Filters);
</script> 
</body>
</div>
</div>
</div>