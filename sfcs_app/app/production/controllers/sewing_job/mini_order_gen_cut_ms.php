<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
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
<body> 
<div class="panel panel-primary">
<div class="panel-heading">Sewing Job Generation</div>
<div class="panel-body">
<!--<div id="page_heading"><span style="float"><h3>Sewing Job Generation</h3></span><span style="float: right"><b></b>&nbsp;</span></div> -->
<?php 
set_time_limit(30000000); 
// include("dbconf.php"); 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
$input_job_no=0; 
$check=0; 
$mini_order_ref=$_GET["id"]; 
$packing_mode=$_GET["mode"]; 
    $style_ori=$_GET['style'];
    $schedule_ori=$_GET['schedule'];
echo "<h2>Multi Color & Single Size Carton Method</h2>";
$sql="select * from $brandix_bts.tbl_min_ord_ref where id=$mini_order_ref"; 
//echo $sql."<br>"; 
$result=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($row=mysqli_fetch_array($result)) 
{ 
    $carton_qty=$row['carton_quantity']; 
    $schedule_id=$row['ref_crt_schedule']; 
    $style_id=$row['ref_product_style']; 
    $max_bundle_qnty=$row['max_bundle_qnty']; 
    $mix_bund_per_size=$row['miximum_bundles_per_size']; 
    $mini_order_qnty=$row['mini_order_qnty']; 
    $carton_method=$row['carton_method']; 
} 
$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link); 
$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link); 
$carton_id = echo_title("$brandix_bts.tbl_carton_ref","id","ref_order_num",$schedule_id,$link); 

$id=$carton_id; 
// echo "<div class=\"table-responsive\"><table class='table table-striped table-bordered'>"; 
// echo "<thead><tr><td>Carton ratio qty - colour</td><td>Cut Number</td><td>Size</td><td>Input Job Limit</td><td>Input Job Number</td></tr></thead>";

$sql12="SELECT cut_num FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$mini_order_ref." AND mini_order_num > 0 group BY cut_num order by cut_num*1"; 
// echo $sql12."<br>"; 
$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($row12=mysqli_fetch_array($result12)) 
{ 
    $input_job_no1=$input_job_no; 
    $sql13="SELECT size FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$mini_order_ref." AND mini_order_num > 0 and cut_num=".$row12["cut_num"]." group BY size order by size*1"; 
    //echo $sql1."<br>"; 
    $result13=mysqli_query($link, $sql13) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($row13=mysqli_fetch_array($result13)) 
    { 
        $input_job_no=$input_job_no+1;     
        $input_job_no1=$input_job_no; 
        //echo $input_job_no1."-".$input_job_no."<br>"; 
        $sql1="SELECT cut_num,color,size,sum(quantity) as quantity,docket_number FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$mini_order_ref." AND mini_order_num > 0 and size=".$row13["size"]." and cut_num=".$row12["cut_num"]." group by cut_num*1,size*1,color ORDER BY cut_num*1,size*1,color"; 
        //echo $sql1."<br>"; 
        $result1=mysqli_query($link, $sql1) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($row1=mysqli_fetch_array($result1)) 
        { 
            $input_job_quantiy=0; 
             
            $size_color_qty=$row1["quantity"]; 
            $docket_number=$row1["docket_number"]; 
            $color_code=$row1["color"]; 
             
            $size_code_ref=echo_title("$brandix_bts.tbl_orders_size_ref","LOWER(size_name)","id",$row1["size"],$link); 
            $size_code=echo_title("$bai_pro3.bai_orders_db_confirm","LOWER(title_size_".$size_code_ref.")","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link); 
            $destination=echo_title("$bai_pro3.bai_orders_db","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link); 
            

            $carton_ratio_qty=echo_title("$brandix_bts.tbl_carton_size_ref","quantity","parent_id=\"$id\" and color=\"".$row1["color"]."\" and ref_size_name",$row1["size"],$link); 
            
            $max_bundle_qnty1=$max_bundle_qnty*$carton_ratio_qty; 
            // echo "<br>Car=".$carton_ratio_qty."-".$max_bundle_qnty."-".$max_bundle_qnty1."</br>"; 
            if($size_color_qty>$max_bundle_qnty1) 
            { 
                do 
                {                      
                    $input_job_no=$input_job_no1+$check; 
                    $size_color_qty=$size_color_qty-$max_bundle_qnty1; 
                    // echo "<tr><td>".$carton_ratio_qty."-".$row1["color"]."</td><td>".$row1["cut_num"]."</td><td>".$row1["size"]."</td><td>".$max_bundle_qnty1."</td><td>".$input_job_no."</td></tr>"; 
                    $check=$check+1; 
                    $input_job_no=$input_job_no1+$check;     
                    $rand=$schedule.date("ymdH").$input_job_no; 
                    $sql1="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_code."\",\"".$max_bundle_qnty1."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$packing_mode."\",\"".$size_code_ref."\")";
                    // echo $sql1."<br>"; 
                    mysqli_query($link, $sql1) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                     
                }while($size_color_qty>$max_bundle_qnty1); 
                if($size_color_qty > 0) 
                {                         
                    // echo $input_job_no."=".$input_job_no1."+".$check."<br>"; 
                    $input_job_no=$input_job_no1+$check+1; 
                    // echo "<tr><td>".$carton_ratio_qty."-".$row1["color"]."</td><td>".$row1["cut_num"]."</td><td>".$row1["size"]."</td><td>".$size_color_qty."</td><td>".$input_job_no."</td></tr>"; 
                    $check=0; 
                    $rand=$schedule.date("ymdH").$input_job_no; 
                    $sql1="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_code."\",\"".$size_color_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$packing_mode."\",\"".$size_code_ref."\")"; 
                    // echo $sql1."<br>"; 
                    mysqli_query($link, $sql1) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                }                 
            } 
            else 
            { 
                // echo "<tr><td>".$carton_ratio_qty."-".$row1["color"]."</td><td>".$row1["cut_num"]."</td><td>".$row1["size"]."</td><td>".$size_color_qty."</td><td>".$input_job_no."</td></tr>"; 
                $rand=$schedule.date("ymdH").$input_job_no; 
                $sql1="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_code."\",\"".$size_color_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$packing_mode."\",\"".$size_code_ref."\")"; 
                // echo $sql1."<br>"; 
                mysqli_query($link, $sql1) or exit("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            } 
        } 
    } 
} 

$i=0; 
$sql1="select distinct input_job_no as input_job_no FROM $bai_pro3.pac_stat_log_input_job WHERE doc_no IN (SELECT doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid LIKE \"%".$schedule."%\") order by input_job_no*1,input_job_no_random"; 
// echo $sql1."<br>"; 
$result1=mysqli_query($link, $sql1) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$btn_url = getFullURLLevel($_GET['r'],'sewing_job_create.php',0,'N'); 
while($row1=mysqli_fetch_array($result1)) 
{ 
    $i=$i+1; 
    // echo $row1["input_job_no"]." = ".$i."<br>"; 
    $sql2="update $bai_pro3.pac_stat_log_input_job set input_job_no=".$i.",input_job_no_random=CONCAT(input_job_no_random,".$i.") where input_job_no=".$row1["input_job_no"]." and doc_no in (SELECT doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid LIKE \"%".$schedule."%\")"; 
    // echo $sql2."<br>"; 
    mysqli_query($link, $sql2) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
} 
// echo '<h1><font color="green">Input Jobs Created Successfully!!</font></h1><br><br>
// <a href="sewing_job_create.php">Click Here to Back</a>';
// echo "<br><br><div class='alert alert-success'>Data Saved Successfully</div>";
echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
// echo '<a href='.$btn_url.' class="btn disable-btn btn-primary">Click Here to Back</a>';
echo "<script>
			setTimeout(redirect(),5000);
			function redirect(){
		        location.href = '".$btn_url."&style=$style_ori&schedule=$schedule_ori';
			}</script>";
// echo "</table></div>";
?> 
</div></div>
</body>