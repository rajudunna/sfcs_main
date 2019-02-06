<?php
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/mo_filling.php',4,'R'));       
?>  

<script> 

    function firstbox() 
    { 
        window.location.href ="<?= getFullURLLevel($_GET['r'],'mix_jobs_delete.php',0,'N'); ?>&style="+document.test.style.value 
    } 

    </script> 

<div class="panel panel-primary"> 
    <div class="panel-heading">Schedule Clubbing Delete (Schedule Level)</div> 
    <div class="panel-body"> 
    <form name="test" method="post" action="<?php getFullURLLevel($_GET['r'],'mix_jobs_delete.php',0,'R') ?>"> 

    <?php 
        $style=$_GET['style'];

        if(isset($_POST['submit'])) 
        { 
            $style=$_POST['style']; 
            $schedule=$_POST['schedule'];
        } 
        echo "<div class='row'><div class='col-md-3'>"; 
        echo "Select Style: <select class=\"form-control\" name=\"style\" onchange=\"firstbox();\" required>"; 
        $sql="select distinct order_style_no from $bai_pro3.bai_orders_db_confirm where $order_joins_in order by order_style_no";     
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error style"); 
        echo "<option value=''>Please Select</option>"; 
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

        echo "</select></div>"; 


        echo"<div class='col-md-3'>"; 
        echo "Select Schedule: <select name=\"schedule\" class=\"form-control\" required>"; 

        $sql="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and $order_joins_in order by order_date";     
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error schedule"); 
        echo "<option value=''>Please Select</option>"; 
        while($sql_row=mysqli_fetch_array($sql_result)) 
        { 
            if (strlen($sql_row['order_del_no']) > 6)
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
        } 
        echo "</select></div>"; 
       
        echo"<div class='col-md-3'>"; 
            echo "<br/><input type=\"submit\"  class='btn btn-danger' value=\"Clear\" name=\"clear\"  id=\"clear\"/>"; 
    ?> 
    </form> 
</div> 

<?php 

if(isset($_POST['clear'])) 
{ 
    $style=$_POST['style'];  
    $schedule=$_POST['schedule'];  
    // 1812321254
    $color=echo_title('bai_pro3.bai_orders_db_confirm', 'order_col_des', 'order_del_no',$schedule, $link);
    $order_tid_current=echo_title('bai_pro3.bai_orders_db_confirm', 'order_tid',"order_style_no = '$style' AND order_del_no",$schedule, $link);
    $order_joins="J".$schedule;  
    if($order_tid_current == ''){
        echo "<script>swal('Error In deleting the Clubbing','','error');</script>";
        exit();
    } 
    // echo "Style = $style, Schedule = $schedule, Color = $color <br>"; 
    // die(); 
    $docket_t_cmp=array(); 
    $docket_tmp_cut=array(); 
    $docket_tmp_plan=array(); 
    $docket_tmp=array(); 
    $docket_t_c=array(); 
    $docket_t=array(); 
    $status=0;$rows1=0;$rows=0; 
    $cut_status=0;$plan_status=0;
    $sql88="select doc_no,act_cut_status,plan_module from plandoc_stat_log where order_tid = '$order_tid_current' ";  
    $result88=mysqli_query($link, $sql88) or die("Error=81");  
    //echo $sql88."<br>";  
    if(mysqli_num_rows($result88)>0)  
    { 
        while($row881=mysqli_fetch_array($result88))  
        {  
            $docket_tmp[]=$row881['doc_no']; 
			if($row881['act_cut_status']=='DONE')
			{
				$cut_status=1;
			}				
            if($row881['plan_module']<>'')
			{
				$plan_status=1;
			}             
        }  
        $docket_t=implode(",", $docket_tmp);  
        $sql882="select doc_no from plandoc_stat_log where org_doc_no in (".$docket_t.")";  
        //echo $sql882."<br>"; 
        $result882=mysqli_query($link, $sql882) or die("Error=82");  
        if(mysqli_num_rows($result882)>0) 
        { 
            while($row882=mysqli_fetch_array($result882))  
            {  
                $docket_t_cmp[]=$row882['doc_no'];  
            } 
            $docket_t_c=implode(",", $docket_t_cmp);  
            $sql8831="select * from brandix_bts.tbl_cut_master where doc_num in (".$docket_t_c.")";  
            //echo $sql8831."<br>"; 
            $result8831=mysqli_query($link, $sql8831) or die("Error=83");  
            $rows1=mysqli_num_rows($result8831); 
             
            $sql883="SELECT * FROM $bai_pro3.pac_stat_log_input_job WHERE doc_no IN (".$docket_t_c.");";  
            //echo $sql883."<br>"; 
            $result883=mysqli_query($link, $sql883) or die("Error=84");  
            $rows=mysqli_num_rows($result883); 
            if($rows>0) 
            { 
                $status=1; 
            } 
            else 
            { 
                $status=0; 
            } 
        } 
        else 
        {             
            $status=0; 
        } 
    } 
	
    //echo "Ststtua---".$status."----Rows1--".$rows1."----Rows--".$rows."<br>"; 
    if($cut_status==0 && $plan_status==0)
	{
		if($status==0) 
		{     
			$order_tids=array(); 
			$sql4533="select * from $bai_pro3.bai_orders_db_confirm where order_joins='$order_joins'"; 
			//echo $sql4533."<br>"; 
			$sql_result4533=mysqli_query($link, $sql4533) or exit("Sql Error112"); 
			while($sql_row4533=mysqli_fetch_array($sql_result4533)) 
			{ 
				$order_tids[]=$sql_row4533["order_tid"]; 
				$order_del_no[]=$sql_row4533["order_del_no"]; 
				$order_col_des[]=$sql_row4533["order_col_des"]; 
			}

			//Deleting from cps_log,bcd,moq
			$category="'cutting','Send PF','Receive PF'";
			$op_codes_query = "SELECT group_concat(operation_code) as op_codes from $brandix_bts.tbl_orders_ops_ref 
							where category IN ($category) ";
			$op_codes_result = mysqli_query($link,$op_codes_query);
			$row = mysqli_fetch_array($op_codes_result);
			$op_codes = $row['op_codes'];
			
			if (count($docket_t_cmp) > 0)
			{
				$docs = implode(',',$docket_t_cmp);
				$bundle_ids_query  = "SELECT id from $bai_pro3.cps_log where doc_no IN ($docs) ";
				$bundle_ids_result = mysqli_query($link,$bundle_ids_query);
				while($row = mysqli_fetch_array($bundle_ids_result))
				{
					$bundle_ids[] = $row['id'];
				}
				$bundle_ids = implode(',',$bundle_ids);
				mysqli_begin_transaction($link);
				$delete_cps_query = "DELETE from $bai_pro3.cps_log where doc_no IN ($docs)";
				$delete_bcd_query = "DELETE from $brandix_bts.bundle_creation_data where docket_number IN ($docs)";
				$delete_moq_query = "DELETE from $bai_pro3.mo_operation_quantites where ref_no in ($bundle_ids) 
									and op_code in ($op_codes)";

				// echo $delete_cps_query.'<br/>';
				// echo $delete_bcd_query.'<br/>';
				// echo $delete_moq_query.'<br/>';

				$delete_cps_result = mysqli_query($link,$delete_cps_query);
				$delete_bcd_result = mysqli_query($link,$delete_bcd_query);
				$delete_moq_result = mysqli_query($link,$delete_moq_query);
				if($delete_cps_result && $delete_bcd_result && $delete_moq_result)
					mysqli_commit($link);
				else	
					mysqli_rollback($link);
			}					
			//Deleting logic ends
			 
			$sql4531="DELETE from $bai_pro3.bai_orders_db where order_tid in ('".implode("','",$order_tids)."')"; 
			// echo $sql4531."<br>"; 
			$sql_result4531=mysqli_query($link, $sql4531) or exit("Sql Error113"); 
			 
			$sql4551="INSERT IGNORE INTO bai_pro3.bai_orders_db SELECT * FROM bai_pro3.bai_orders_db_club WHERE order_tid IN  ('".implode("','",$order_tids)."')"; 
			// echo $sql4551."<br>"; 
			$sql_result4551=mysqli_query($link, $sql4551) or exit("Sql Error114"); 
			
			$sql45312="UPDATE $bai_pro3.bai_orders_db set order_joins=0,order_no="" where order_tid in ('".implode("','",$order_tids)."')"; 
			// echo $sql4531."<br>"; 
			$sql_result4531=mysqli_query($link, $sql45312) or exit("Sql Error113"); 
			
			$sql4536="DELETE from $bai_pro3.bai_orders_db_confirm where order_tid in ('".implode("','",$order_tids)."')"; 
			// echo $sql4536."<br>"; 
			$sql_result4536=mysqli_query($link, $sql4536) or exit("Sql Error115"); 
			 
			$sql45271="DELETE from $bai_pro3.plandoc_stat_log where order_tid='".$order_tid_current."'"; 
			// echo $sql4527."<br>";  
			$sql_result45271=mysqli_query($link, $sql45271) or exit("Sql Error116"); 
			 
			$sql452981="DELETE from $bai_pro3.plandoc_stat_log where order_tid in ('".implode("','",$order_tids)."')"; 
			// echo $sql4527."<br>";  
			$sql_result45298=mysqli_query($link, $sql452981) or exit("Sql Error117"); 
			 
			$sql4527="DELETE from $bai_pro3.allocate_stat_log where order_tid='".$order_tid_current."'";  
			// echo $sql4527."<br>";  
			$sql_result4527=mysqli_query($link, $sql4527) or exit("Sql Error118"); 
			 
			$sql45298="DELETE from $bai_pro3.allocate_stat_log where order_tid in ('".implode("','",$order_tids)."')"; 
			// echo $sql4527."<br>";  
			$sql_result45298=mysqli_query($link, $sql45298) or exit("Sql Error119"); 
					 
			$sql4528="DELETE from $bai_pro3.cuttable_stat_log where order_tid='".$order_tid_current."'";  
			// echo $sql4528."<br>"; 
			$sql_result4528=mysqli_query($link, $sql4528) or exit("Sql Error120"); 
			 
			$sql4528123="DELETE from $bai_pro3.cuttable_stat_log where order_tid in ('".implode("','",$order_tids)."')"; 
			// echo $sql4528123."<br>"; 
			$sql_result4528=mysqli_query($link, $sql4528123) or exit("Sql Error121"); 

			$sql4529="DELETE from $bai_pro3.maker_stat_log where order_tid='".$order_tid_current."'";  
			// echo $sql4529."<br>"; 
			$sql_result4529=mysqli_query($link, $sql4529) or exit("Sql Error122"); 

			$sql4529123="DELETE from $bai_pro3.maker_stat_log where order_tid in ('".implode("','",$order_tids)."')"; 
			// echo $sql4529123."<br>"; 
			$sql_result4529=mysqli_query($link, $sql4529123) or exit("Sql Error123"); 
			 
			$sql45229="DELETE from $bai_pro3.cat_stat_log where order_tid='".$order_tid_current."'";  
			// echo $sql4529."<br>"; 
			$sql_result45229=mysqli_query($link, $sql45229) or exit("Sql Error124"); 

			$sql452291="UPDATE $bai_pro3.cat_stat_log set category='', purwidth='', gmtway='', lastup='0000-00-00 00:00:00', strip_match='', binding_consumption='', gusset_sep='', patt_ver='', clubbing='' where order_tid in ('".implode("','",$order_tids)."')"; 
			// echo $sql4529."<br>"; 
			$sql_result452291=mysqli_query($link, $sql452291) or exit("Sql Error125"); 
				 
			if($status==0 && $rows1>0) 
			{ 
				$sql102="DELETE from $brandix_bts.tbl_cut_size_master where parent_id in (select id from $brandix_bts.tbl_cut_master where doc_num in (".$docket_t_c."))"; 
				// echo $sql102."<br>"; 
				mysqli_query($link, $sql102) or die("Error=1211");  
					  
				$sql103="DELETE from $brandix_bts.tbl_cut_master where doc_num in (".$docket_t_c.")";  
				// echo $sql103."<br>"; 
				mysqli_query($link, $sql103) or die("Error=1212");  
				  
				$sql101="DELETE from $brandix_bts.tbl_orders_sizes_master where order_col_des='$color' and parent_id in (select id from $brandix_bts.tbl_orders_master where product_schedule  in ('".implode("','",$order_del_no)."'))"; 
				mysqli_query($link, $sql101) or die("Error while deleting in tbl_orders_sizes_master");  
				// echo $sql101."<br>"; 
			}     
			$sql451="DELETE from $bai_pro3.bai_orders_db where order_del_no='".$schedule."' and order_col_des=\"".$color."\" "; 
			// echo $sql451."<br>"; 
			$sql_result451=mysqli_query($link, $sql451) or exit("Sql Error126"); 
			
			$sql45132="DELETE from $bai_pro3.bai_orders_db_club where order_tid in ('".implode("','",$order_tids)."')"; 
			// echo $sql451."<br>"; 
			$sql_result45132=mysqli_query($link, $sql45132) or exit("Sql Error125"); 
			
			$sql4521="DELETE from $bai_pro3.bai_orders_db_club_confirm where order_tid in ('".implode("','",$order_tids)."')";
			// echo $sql451."<br>"; 
			$sql_result451=mysqli_query($link, $sql4521) or exit("Sql Error127"); 
			
			$sql45212="DELETE from $bai_pro3.sp_sample_order_db where order_tid in ('".implode("','",$order_tids)."') and remarks='SAMPLE'";
			// echo $sql451."<br>"; 
			mysqli_query($link, $sql45212) or exit("Sql Error127");
						 
			$sql452="DELETE from $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."' and order_col_des=\"".$color."\" "; 
			// echo $sql452."<br>"; 
			$sql_result452=mysqli_query($link, $sql452) or exit("Sql Error128"); 
			 
			echo "<script type=\"text/javascript\">  
					sweetAlert('Successfully Removed the Clubbed Schedule','','success');
					setTimeout(openUrl, 1500);
					function openUrl(){
						 window.location.href = '".getFullURLLevel($_GET['r'],'mix_jobs_delete.php',0,'N')."';
					}
				</script>";
		} 
		else 
		{ 
			echo '<br><br><br><br><div class="alert alert-danger"><strong>Sewing Jobs are Prepared, Delete the Sewing Jobs and Try Again.</strong></div>';
			echo "<script>
					setTimeout(openUrl, 1500);
					function openUrl(){
						 window.location.href = '".getFullURLLevel($_GET['r'],'mix_jobs_delete.php',0,'N')."';
					}
				</script>";
		}
	}
	else
	{
		echo '<br><br><br><br><div class="alert alert-danger"><strong>Cutting Operation (or) Cut Job Planning are Performed, Please Reverse and Try Again.</strong></div>';
			echo "<script>
					setTimeout(openUrl, 1500);
					function openUrl(){
						 window.location.href = '".getFullURLLevel($_GET['r'],'mix_jobs_delete.php',0,'N')."';
					}
				</script>";
	}	
} 
?>