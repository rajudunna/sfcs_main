<?php
set_time_limit(200000);
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
?>
<div class="panel panel-primary">
<div class="panel-heading"><strong>Module Wise RMS Summary</strong></div>
<?php
$module=$_GET['module'];
$section=$_GET['section'];
$date=date("Y-m-d H:i:s");

        $sql2x="SELECT * FROM $bai_pro3.plan_dash_doc_summ WHERE module=$module AND act_cut_status<>'DONE' GROUP BY doc_no order by priority";
       // echo $sql2x;
		$result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
        $rows2=mysqli_num_rows($result2x);	
        echo"<div class='panel-body'>";
        echo "<table class='table table-bordered'>
        <tr style='background-color: #337ab7;
            border-color: #337ab7;color:white;'><th colspan='6'>Cut Loading Plan For Module- $module<th colspan='6'>Date:$date</th></tr>
        <tr><th>Priority</th><th>Style</th><th>Schedule</th><th>Cut No</th><th>Color</th><th>Size</th><th>Qty</th><th>Total Cut Qty</th><th>Docket#</th><th>Pro.Module#</th><th>Layer Length</th><th>Plies</th></tr>";
    while($row21x=mysqli_fetch_array($result2x))
	{
            $doc_no=$row21x["doc_no"];
            $module1=$row21x["module"];
            $priority=$row21x["priority"];
            $total=$row21x["total"];
            $mk_ref=$row21x["mk_ref"];
            $all_sizes = [];
            foreach($sizes_array as $key => $value){
                $size_title = ims_sizes($row21x["order_tid"], $row21x["order_del_no"], $row21x["order_style_no"], $row21x["order_col_des"], $value, $link);
                $all_sizes[$size_title] = $row21x[$value];
            }

           $sizes=(array_filter($all_sizes));
            $a_plies=$row21x["a_plies"];
           

		
        $doc_nos_splitx=explode(",",$doc_no);
        for($i=0;$i<sizeof($doc_nos_splitx);$i++)
	   {

        echo "<tr>";
		$sql11x="select order_tid,acutno from $bai_pro3.plandoc_stat_log where doc_no=\"".$doc_nos_splitx[$i]."\"";
		$sql_result11x=mysqli_query($link, $sql11x) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row11x=mysqli_fetch_array($sql_result11x))
		{
			$order_tidx=$row11x["order_tid"];
			$cut_nosx=$row11x["acutno"];
		}

		$sql21x="select order_style_no,order_del_no,order_col_des,order_div,color_code from $bai_pro3.bai_orders_db where order_tid=\"".$order_tidx."\"";
		$sql_result21x=mysqli_query($link, $sql21x) or die("Error2 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row21x=mysqli_fetch_array($sql_result21x))
		{
			$stylex=$row21x["order_style_no"];
			$schedulex=$row21x["order_del_no"];
			$colorx=$row21x["order_col_des"];
			$buyerx=$row21x["order_div"];
			$color_codex=$row21x["color_code"];
        }
      
        $marker="select mklength from $bai_pro3.maker_stat_log where tid=\"".$mk_ref."\"";
        //echo  $marker;
		$marker_result=mysqli_query($link, $marker) or die("Error2 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($marker_result_row=mysqli_fetch_array($marker_result))
		{
			$mklength=$marker_result_row["mklength"];
			
        }
        
        






        echo "<td>".$priority."</td>";
		echo "<td>".$stylex."</td>";
        echo "<td>".$schedulex."</td>";
        echo "<td>".chr($color_codex)."00".$cut_nosx."</td>";
        echo "<td>".$colorx."</td><td><table class='table table-bordered'>";
        foreach($sizes as $key => $value){
            echo "<tr><td>$key</td></tr>";
        }
        echo '</td></table><td><table class="table table-bordered">';
        foreach($sizes as $key => $value){
            echo "<tr><td>$value</td></tr>";
        }

        echo "</table></td><td>".$total."</td>";
        echo "<td> Doc#: ".$doc_nos_splitx[$i]."</td>";
        echo "<td>Mod#: ".$module1."</td>";
        echo "<td>".$mklength."</td>";
        echo "<td>".$a_plies."</td>";
        
		
		echo "</tr>";
       
    }
}
 echo"</table>";
?>



</div>
</div>




