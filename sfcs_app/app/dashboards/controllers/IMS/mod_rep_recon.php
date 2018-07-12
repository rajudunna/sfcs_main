<?php
       $module_ref_recon=$module;      
        $toggle=0; 
        $sql_recon="select distinct rand_track,ims_size,ims_schedule,ims_style,ims_color,ims_remarks,input_job_rand_no_ref from $bai_pro3.ims_log where ims_mod_no=$module_ref_recon and ims_doc_no in (select doc_no from bai_pro3.plandoc_stat_log) order by tid";         
        $sql_result_recon=mysqli_query($link, $sql_recon) or exit("Sql Error2.1".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row_recon=mysqli_fetch_array($sql_result_recon)) 
        { 
            $rand_track_recon=$sql_row_recon['rand_track'];
            $ims_size_recon=$sql_row_recon['ims_size'];
            $ims_size2_recon=substr($ims_size_recon,2);
            $title_size_recon='title_size_'.$size_code;
            $input_job_rand_no_ref_recon=$sql_row_recon['input_job_rand_no_ref'];
            $ims_style_recon=$sql_row_recon['ims_style'];
            $ims_schedule_recon=$sql_row_recon['ims_schedule'];
            $ims_color_recon=$sql_row_recon['ims_color'];
            $ims_remarks_recon=$sql_row_recon['ims_remarks']; 
             
            $sql12_recon="select * from $bai_pro3.ims_log where ims_mod_no=$module_ref_recon and rand_track=$rand_track_recon and ims_status<>\"DONE\" and ims_remarks='$ims_remarks_recon' and ims_size='$ims_size_recon'  order by ims_schedule, ims_size DESC";            
            //echo $sql12."<br/>";
           // mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            $sql_result12_recon=mysqli_query($link, $sql12_recon) or exit("Sql Error2.3".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row12_recon=mysqli_fetch_array($sql_result12_recon)) 
            { 
                $flag++;
                $ims_doc_no_recon=$sql_row12_recon['ims_doc_no']; 
				$ims_size_recon=$sql_row12_recon['ims_size'];
				$ims_size2_recon=substr($ims_size_recon,2);
                $inputjobno_recon=$sql_row12_recon['input_job_no_ref'];
                $pac_tid_recon=$sql_row12_recon['pac_tid'];

				
                $sql22_recon="select * from $bai_pro3.plandoc_stat_log where doc_no=$ims_doc_no_recon and a_plies>0"; 
                //mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                $sql_result22_recon=mysqli_query($link, $sql22_recon) or exit("Sql Error2.4".mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                while($sql_row22_recon=mysqli_fetch_array($sql_result22_recon)) 
                { 
                    $order_tid_recon=$sql_row22_recon['order_tid']; 
                } 
     
                 $size_value_recon=ims_sizes($order_tid_recon,$ims_schedule_recon,$ims_style_recon,$ims_color_recon,$ims_size2_recon,$link);

    $rejected_recon=0;
                 $sql33_recon="select COALESCE(SUM(IF(qms_tran_type=3,qms_qty,0)),0) AS rejected from $bai_pro3.bai_qms_db where qms_schedule=".$ims_schedule_recon." and qms_color=\"".$ims_color_recon."\" and input_job_no=\"".$input_job_rand_no_ref_recon."\" and qms_style=\"".$ims_style_recon."\" and qms_remarks=\"".$sql_row_recon['ims_remarks']."\" and qms_size=\"".strtoupper($size_value_recon)."\" and operation_id='130' and bundle_no=\"".$sql_row12_recon['pac_tid']."\"";  
                 //echo $sql33;  
                  $sql_result33_recon=mysqli_query($link, $sql33_recon) or exit("Sql Error888".mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($sql_row33_recon=mysqli_fetch_array($sql_result33_recon))
                  {
                    
                    $rejected_recon=$sql_row33_recon['rejected']; 
                  }      
                     
                if(($sql_row12_recon['ims_qty']-($sql_row12_recon['ims_pro_qty']+$rejected_recon))==0)
				{
					$update_ims_recon="update $bai_pro3.ims_log set ims_status=\"DONE\" where tid='".$sql_row12_recon['tid']."'";
					//echo $update_ims_recon."<br>";
					 $update_ims_recon=mysqli_query($link, $update_ims_recon) or exit("Sql error update ims".mysqli_error($GLOBALS["___mysqli_ston"]));
				}     
             }
        } 
?>