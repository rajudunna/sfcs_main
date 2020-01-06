<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
?>
<?php
session_start();
 
	if($_GET['style'])
	{
		$style=$_GET['style'];
	}
	else
	{
		$style=	$_POST['style'];
	}
	if($_GET['color'])
	{
		$color=$_GET['color'];
	}
	else
	{
		$color=	$_POST['color'];
	}
	if($_GET['schedule'])
	{
		$schedule=$_GET['schedule'];
	}else
	{
		$schedule=	$_POST['schedule'];
    }
    
	
	$_SESSION['style']=$style;
	$_SESSION['schedule']=$schedule;
    $_SESSION['color']=$color;
    
?>
<script>
function validate_qty(ele)
{
	var k= 10;
	var exist_qty = $('#temp'+ele.id).val();
	console.log('entered = '+exist_qty);
	if(Number(ele.value) < Number(exist_qty) ){
		swal(" error","","warning");
		ele.value = exist_qty;
	}
	
}



function firstbox()
{
	window.location.href ="index.php?r=<?php echo $_GET['r'] ?>"+"&style="+document.test.style.value;
}

function secondbox()
{
		window.location.href ="index.php?r=<?php echo $_GET['r'] ?>"+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value
}

	function check_style()
	{

		var style=document.getElementById('style').value;
		if(style=='')
		{
			sweetAlert('Please Select Style First','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}
	function check_style_sch()
	{
		var style=document.getElementById('style').value;
		var sch=document.getElementById('schedule').value;
	
		if(style=='')
		{
			sweetAlert('Please Select Style First','','warning');
			return false;
		}
		else if(sch=='')
		{
			sweetAlert('Please Select schedule','','warning');
			return false;
		
		}
		else
		{
			return true;
		}
	}
	function check_style_sch_col()
	{
		var style=document.getElementById('style').value;
		var sch=document.getElementById('schedule').value;
		var col=document.getElementById('color').value;

	
		if(style=='' && sch=='' && col=='')
		{
			sweetAlert('Please Select Style Schedule and Color','','warning');
			return false;
		}
		else if(sch=='' && col=='')
		{

			sweetAlert('Please Select schedule and Color','','warning');
			return false;
		
		}
		else if(col=='')
		{
			sweetAlert('Please Select Color','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}

</script>

<div class="panel panel-primary">
<div class="panel-heading">EMB Report</div>
<div class"panel-body">
<form name="test" action="index.php?r=<?php echo $_GET['r']; ?>" method="post">
<div class="form-group">
<?php
// include("dbconf.php");
echo "<div class=\"col-sm-12\"><div class=\"row\"><div class=\"col-sm-3\">
	  <label for='style'>Select Style:</label> 
	  <select class =\"form-control\" name=\"style\" id=\"style\"  onchange=\"firstbox();\" >";
    
$sql="select distinct order_style_no from $bai_pro3.bai_orders_db where $order_joins_not_in";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value='' selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
{
	echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
}

}

echo "</select>";
echo "</div>"

?>

<?php

echo "<div class=\"col-sm-3\">
      <label for='schedule'>Select Schedule:</label> 
      <select class=\"form-control\" name=\"schedule\" id=\"schedule\"onclick=\"return check_style();\"  onchange=\"secondbox();\" >";
$sql_result='';
if($style){
$sql="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and $order_joins_not_in";	

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
}
echo "<option value='' selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
{
	echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
}

}


echo "</select>";
echo "</div>";
?>

<?php

echo "<div class='col-sm-3'>
	  <label for='color'>Select Color:</label> 
	  <select class = \"form-control\" name=\"color\" id=\"color\" onclick=\"return check_style_sch();\" >";
$sql_result='';
if($schedule){
$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and $order_joins_not_in";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
}
echo "<option value='' selected>NIL</option>";
	
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
{
	echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
}

}


echo "</select>";
echo "</div>";
echo "<div class=\"col-sm-1\">
   <label for='submit'><br/></label>
   <button type=\"submit\" onclick=\"return check_style_sch_col();\"  class=\" form-control btn btn-success\" name=\"submit\">Show</button></div>";	
   echo "</div></div>";
   ?>
    <?php 
      $sql11="select order_tid from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des='$color'";
       // echo $sql;
     $sql_result=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
     $sql_num_check=mysqli_num_rows($sql_result);
     while($sql_row12=mysqli_fetch_array($sql_result))
     {
       $order_tid=$sql_row12['order_tid'];
    
     }

 ?>

<?php 
     $sql13="SELECT doc_no,acutno as cutno FROM bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\"";
    //  echo $sql13;
     $sql_result=mysqli_query($link, $sql13) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
     $sql_num_check=mysqli_num_rows($sql_result);
     while($sql_row12=mysqli_fetch_array($sql_result))
     {
       $doc_no=$sql_row12['doc_no'];
       $acutno=$sql_row12['cutno'];
     }

 ?>
<?php
   $sql33="SELECT GROUP_CONCAT(DISTINCT size ) AS size, doc_no,barcode,quantity  FROM bai_pro3.emb_bundles WHERE doc_no='$doc_no' ";
//    echo $sql33;
   $sql_result=mysqli_query($link, $sql33) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
   $sql_num_check=mysqli_num_rows($sql_result);
   while($sql_row2=mysqli_fetch_array($sql_result))
{
    $doc_no=$sql_row2['doc_no'];
    $size=$sql_row2['size'];
    $barcode=$sql_row2['barcode'];
    $quantity=$sql_row2['quantity'];
}

?>
                         
   <div class='panel-body' style="overflow: scroll;height: 616px;">
   <table class="table table-bordered">
   <thead>
      <tr>
        <th>Ratio</th>

         <?php
         $sql111="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des='$color'";
         $sql_result=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        $sql_num_check=mysqli_num_rows($sql_result);
        while($sql_row12=mysqli_fetch_array($sql_result))
    {
        for($j=1;$j<=50;$j++)
        {
             $sno = str_pad($j,2,"0",STR_PAD_LEFT);
             if($sql_row12['title_size_s'.$sno]!='')
           {
             echo "<th>".$sql_row12['title_size_s'.$sno]."</th>";
           } 
        }
    }
        ?>
        <th>Piles</th>
        <th>Total</th>
        <th>Remarks</th>
        <!-- <th>bundle_number</th>
        <th>size_title</th>
        <th>original_qty</th> -->
      </tr>
    </thead>       
 
<?php
     $sql2="SELECT doc_no,ratio, a_plies as piles,acutno as cutno FROM bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" ";
    //  echo $sql2;
     $sql_result=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
     $sql_num_check=mysqli_num_rows($sql_result);
     echo "<tbody>";
     $url5 = getFullURLLevel($_GET['r'],'barcode_new.php',0,'R');
     while($sql_row=mysqli_fetch_array($sql_result))
     {
       echo "<td>".$sql_row['ratio']."</td>";
       echo "<td>".$sql_row['size']."</td>";       
       echo "<td>".$sql_row['piles']."</td>";
       echo "<td>".$sql_row['ratio']*$sql_row['piles']."</td>";  
       echo "<td>".$sqlrow['remarks']."</td>";
       echo "<td><a class='btn btn-primary btn-sm' href='$url5?doc_no=".$sql_row['doc_no']."&order_tid=".$order_tid."&style=".$style."&schedule=".$schedule."&color=".$color."&cutno=".$acutno."&size=".$size."&barcode=".$barcode."&quantity=".$quantity."' onclick=\"return popitup2('$url5?doc_no=".$sql_row['doc_no']."&order_tid=".$order_tid."&style=".$style."&schedule=".$schedule."&color=".$color."&cutno=".$acutno."&size=".$size."&barcode=".$barcode."&quantity=".$quantity."')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print</a></td></tr>";
       //echo '<td>'.$sql_row["bundle_number"].'</td><td><button class="btn btn-sm btn-primary">Print</button></td></tr>';
       
     }
     echo"</tbody></table>";
    
?>