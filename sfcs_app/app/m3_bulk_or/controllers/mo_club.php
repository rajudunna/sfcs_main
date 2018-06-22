<?php 
// include("dbconf.php"); 
// include("m3_bulk_or_proc.php"); 
echo $_SERVER['DOCUMENT_ROOT'];
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/m3_bulk_or_proc.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
// include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/m3_bulk_or_proc.php');

function error_check(){
    throw new Exception(mysqli_error($GLOBALS["___mysqli_ston"]));
}
$table_m3="m3_bulk_ops_rep_db.m3_sfcs_tran_log_v2"; 
// $table_ops="m3_bulk_ops_rep_db.m3_operation_master"; 
$table_order="bai_pro3.bai_orders_db_confirm_mo"; 
// echo $table_m3;
// die();

//$sql="select * from $table_m3 where club_status='0' and m3_op_des in ('LAY','CUT','SIN')"; 
//$sql="select * from $table_m3 where club_status='0' and m3_op_des='SOT' and sfcs_tid in (1945387,1945488,1945648)"; 
// $sql_result=mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"])); 
// echo mysqli_num_rows($sql_result);
// var_dump($sql_result);
// die();
try {
    $sql="select sfcs_tid,sfcs_qty,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_op_des,sfcs_reason,sfcs_tid_ref,sfcs_job_no  from $table_m3 where $table_m3.club_status='0' and sfcs_style='I00816AA' GROUP BY sfcs_tid order by  sfcs_schedule limit 100";
    // echo $sql;
    $sql_result= $link->query($sql) or error_check();
    $link->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        $m3_tid=$sql_row['sfcs_tid']; 
        $m3_qty=$sql_row['sfcs_qty']; 
        $m3_style=$sql_row['sfcs_style']; 
        $m3_schedule=$sql_row['sfcs_schedule']; 
        $m3_color=$sql_row['sfcs_color']; 
        $sfcs_size=$sql_row['sfcs_size']; 
        $m3_ops=$sql_row['m3_op_des']; 
        $m3_reason=$sql_row['sfcs_reason']; 
        $m3_sfcs_tid=$sql_row['sfcs_tid_ref']; 
        $m3_job_no=$sql_row['sfcs_job_no']; 
        if(strlen($sql_row['sfcs_job_no'])>0) 
        { 
            $sfcs_job_no=$sql_row['sfcs_job_no']; 
        } 
        else 
        { 
            $sfcs_job_no=know_sfcs_job_no($sql_row['sfcs_doc_no']); 
        } 
        if($m3_qty>0) 
        {     
            // Filling other than Rejections 
            if($m3_reason=='' || $m3_reason=='GX') 
            {     
                $sql1="select * fro $table_order where order_style_no='".$m3_style."' and order_del_no='".$m3_schedule."' and order_col_des='".$m3_color."' and sfcs_size='".$sfcs_size."' and sfcs_ops='".$m3_ops."' order by order_no*1"; 
                $sql_result1 = $link->query($sql1) or error_check();
                
                $rows=mysqli_num_rows($sql_result1); 
                // echo $rows.'<br>';
                // die();
                if($rows==1) 
                { 
                    while($sql_row1=mysqli_fetch_array($sql_result1)) 
                    { 
                        $sql3="update $table_m3 set sfcs_job_no='".$sfcs_job_no."',club_status='1',m3_mo_no='".$sql_row1['mo_number']."',sfcs_status='16',m3_op_code='".$sql_row1['m_ops']."',m3_size='".$sql_row1['m_size']."' where sfcs_tid='".$m3_tid."'"; 
                        $sql_result3= $link->query($sql3) or error_check(); 
                        $sql31="update $table_order set fill_qty=fill_qty+$m3_qty where id='".$sql_row1['id']."'"; 
                        $sql_result31= $link->query($sql31) or error_check();
                        // echo $sql_result3.'<br>';echo $sql_result31.'<br>';     
                    }     
                } 
                else if($rows>1)
                { 
                    $i=1;$status=0;$m_split=1;$fill_qty=0;$to_be_fill=0;$prev_qty=0;$order_qty=0; 
                    while($sql_row1=mysqli_fetch_array($sql_result1)) 
                    {     
                        // echo 'in'.'<br>';
                        $operation_st=2; 
                        $prev_qty=0; 
                        $id=$sql_row1['id']; 
                        $m3_ops_code=$sql_row1['m_ops']; 
                        $m3_mo=$sql_row1['mo_number']; 
                        $m3_size=$sql_row1['m_size']; 
                        $sfcs_size=$sql_row1['sfcs_size']; 
                        $order_qty=$sql_row1['mo_qty']; 
                        $last_mo=$sql_row1['order_no']; 
                        $sql122="select * from $table_order where order_style_no='".$m3_style."' and order_del_no='".$m3_schedule."' and order_col_des='".$m3_color."' and sfcs_size='".$sfcs_size."' and sfcs_ops='".$m3_ops."' and order_no >'".$last_mo."'"; 
                        $sql_result32= $link->query($sql122) or error_check(); 
                        //Last Mo without validation 
                        if(mysqli_num_rows($sql_result32)==0) 
                        { 
                            $sql12="select * from $table_order where order_style_no='".$m3_style."' and order_del_no='".$m3_schedule."' and order_col_des='".$m3_color."' and sfcs_size='".$sfcs_size."' and m_ops < ".$sql_row1['m_ops']." and mo_number='".$m3_mo."' order by m_ops limit 1"; 
                            $sql_result32= $link->query($sql12) or error_check(); 
                            if(mysqli_num_rows($sql_result32)>0) 
                            { 
                                while($sql_row12=mysqli_fetch_array($sql_result32)) 
                                { 
                                    $prev_qty=$sql_row12['fill_qty']+$sql_row12['rej_pcs']; 
                                } 
                                $fill_tmp_qty=$sql_row1['fill_qty']+$sql_row1['rej_pcs']; 
                                $to_be_fill=$prev_qty-$fill_tmp_qty; 
                            } 
                            else 
                            { 
                                $prev_qty=0; 
                                $operation_st='1'; 
                                $fill_tmp_qty=$sql_row1['fill_qty']+$sql_row1['rej_pcs']; 
                                $to_be_fill=$m3_qty; 
                            }     
                            $upto_fill=$sql_row1['fill_qty']+$sql_row1['rej_pcs']; 
                            if($to_be_fill>0 && $m3_qty>0) 
                            { 
                                do 
                                { 
                                    
                                    if(($to_be_fill>=$m3_qty) && ($m_split==1) && (($prev_qty>=$upto_fill) || ($operation_st=='1'))) 
                                    { 
                                        $sql3="update $table_m3 set sfcs_job_no='".$sfcs_job_no."',sfcs_qty='".$m3_qty."',club_status='1',m3_mo_no='".$sql_row1['mo_number']."',sfcs_status='16',m3_op_code='".$sql_row1['m_ops']."',m3_size='".$sql_row1['m_size']."' where sfcs_tid='".$m3_tid."'"; 
                                        // echo $sql3."<br>"; 
                                        $sql_result3= $link->query($sql3) or error_check();                         
                                        $sql31="update $table_order set fill_qty=fill_qty+$m3_qty where id='".$id."'"; 
                                        $sql_result31= $link->query($sql31) or error_check();             
                                        $upto_fill=$upto_fill+$m3_qty; 
                                        $m3_qty=0; 
                                        $status=1; 
                                    } 
                                    else 
                                    {                                     
                                        if(($to_be_fill>=$m3_qty) && (($prev_qty>=$upto_fill) || ($operation_st=='1'))) 
                                        { 
                                            $m_split=0; 
                                            $tid_code=$m3_sfcs_tid; 
                                            $sql4="INSERT INTO $table_m3 (`sfcs_date`, `sfcs_style`, `sfcs_schedule`, `sfcs_color`, `sfcs_size`, `m3_size`, `sfcs_doc_no`, `sfcs_qty`, `sfcs_reason`, `sfcs_remarks`, `sfcs_log_user`, `sfcs_log_time`, `sfcs_status`, `m3_mo_no`, `m3_op_code`, `sfcs_job_no`, `sfcs_mod_no`, `sfcs_shift`, `m3_op_des`, `sfcs_tid_ref`, `club_status`)  
                                            select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,'".$m3_size."',sfcs_doc_no,'".$m3_qty."',sfcs_reason,sfcs_remarks,sfcs_log_user,sfcs_log_time,'16','".$m3_mo."','".$m3_ops_code."','".$sfcs_job_no."',sfcs_mod_no,sfcs_shift,m3_op_des,'".$tid_code."','1' from $table_m3 where sfcs_tid='".$m3_tid."'"; 
                                            $sql_result4= $link->query($sql4) or error_check(); 
                                            $sql31="update $table_order set fill_qty=fill_qty+$m3_qty where id='".$id."'"; 
                                            $sql_result31= $link->query($sql31) or error_check();             
                                            $upto_fill=$upto_fill+$m3_qty; 
                                            $m3_qty=0;    $status=0;                 
                                            $i++; 
                                        } 
                                        else if(($prev_qty>=$upto_fill) || ($operation_st=='1')) 
                                        {                             
                                            if(($prev_qty>=($upto_fill+$m3_qty) || ($operation_st=='1')) && ($to_be_fill>=$m3_qty)) 
                                            { 
                                                $tid_code=$m3_sfcs_tid; 
                                                $sql4="INSERT INTO $table_m3 (`sfcs_date`, `sfcs_style`, `sfcs_schedule`, `sfcs_color`, `sfcs_size`, `m3_size`, `sfcs_doc_no`, `sfcs_qty`, `sfcs_reason`, `sfcs_remarks`, `sfcs_log_user`, `sfcs_log_time`, `sfcs_status`, `m3_mo_no`, `m3_op_code`, `sfcs_job_no`, `sfcs_mod_no`, `sfcs_shift`, `m3_op_des`, `sfcs_tid_ref`, `club_status`)  
                                                select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,'".$m3_size."',sfcs_doc_no,'".$m3_qty."',sfcs_reason,sfcs_remarks,sfcs_log_user,sfcs_log_time,'16','".$m3_mo."','".$m3_ops_code."','".$sfcs_job_no."',sfcs_mod_no,sfcs_shift,m3_op_des,'".$tid_code."','1' from $table_m3 where sfcs_tid='".$m3_tid."'"; 
                                                $sql_result4= $link->query($sql4) or error_check(); 
                                                $sql31="update $table_order set fill_qty=fill_qty+$m3_qty where id='".$id."'"; 
                                                $sql_result31= $link->query($sql31) or error_check();            
                                                $to_be_fill=$to_be_fill+$m3_qty; 
                                                $upto_fill=$upto_fill+$m3_qty; 
                                                $status=0;$m3_qty=0;                 
                                                $i++; 
                                            } 
                                            else  
                                            { 
                                                $tid_code=$m3_sfcs_tid; 
                                                $sql4="INSERT INTO $table_m3 (`sfcs_date`, `sfcs_style`, `sfcs_schedule`, `sfcs_color`, `sfcs_size`, `m3_size`, `sfcs_doc_no`, `sfcs_qty`, `sfcs_reason`, `sfcs_remarks`, `sfcs_log_user`, `sfcs_log_time`, `sfcs_status`, `m3_mo_no`, `m3_op_code`, `sfcs_job_no`, `sfcs_mod_no`, `sfcs_shift`, `m3_op_des`, `sfcs_tid_ref`, `club_status`)  
                                                select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,'".$m3_size."',sfcs_doc_no,'".$to_be_fill."',sfcs_reason,sfcs_remarks,sfcs_log_user,sfcs_log_time,'16','".$m3_mo."','".$m3_ops_code."','".$sfcs_job_no."',sfcs_mod_no,sfcs_shift,m3_op_des,'".$tid_code."','1' from $table_m3 where sfcs_tid='".$m3_tid."'"; 
                                                $sql_result4= $link->query($sql4) or error_check(); 
                                                $sql31="update $table_order set fill_qty=fill_qty+$to_be_fill where id='".$id."'"; 
                                                $sql_result31= $link->query($sql31) or error_check();             
                                                $m3_qty=$m3_qty-$to_be_fill; 
                                                $upto_fill=$upto_fill+$to_be_fill; 
                                                $status=0;                     
                                                $i++;$to_be_fill=0; 
                                            } 
                                                
                                        } 
                                                                
                                    } 
                                } 
                                while((    $m3_qty>0 && $to_be_fill>0) && (($prev_qty>=$upto_fill) || ($operation_st=='1'))); 
                            } 
                            $fill_tmp_qty=0; 
                            $to_be_fill=0; 
                            $order_qty=0; 
                        } 
                        //MO order wise Filling 
                        else 
                        { 
                            $sql12="select * from $table_order where order_style_no='".$m3_style."' and order_del_no='".$m3_schedule."' and order_col_des='".$m3_color."' and sfcs_size='".$sfcs_size."' and m_ops < ".$sql_row1['m_ops']." and mo_number='".$m3_mo."' order by m_ops limit 1"; 
                            $sql_result32=  $link->query($sql12) or error_check(); 
                            if(mysqli_num_rows($sql_result32)>0) 
                            { 
                                while($sql_row12=mysqli_fetch_array($sql_result32)) 
                                { 
                                    $prev_qty=$sql_row12['fill_qty']+$sql_row12['rej_pcs']; 
                                } 
                                $fill_tmp_qty=$sql_row1['fill_qty']+$sql_row1['rej_pcs']; 
                                $to_be_fill=$prev_qty-$fill_tmp_qty; 
                            } 
                            else 
                            { 
                                $prev_qty=0; 
                                $operation_st='1'; 
                                $fill_tmp_qty=$sql_row1['fill_qty']+$sql_row1['rej_pcs']; 
                                $to_be_fill=$order_qty-$fill_tmp_qty; 
                            }     
                            $upto_fill=$sql_row1['fill_qty']+$sql_row1['rej_pcs']; 
                            if($to_be_fill>0 && $m3_qty>0) 
                            { 
                                do  
                                { 
                                    if(($to_be_fill>=$m3_qty) && ($m_split==1) && (($prev_qty>=$upto_fill) || ($operation_st=='1'))) 
                                    { 
                                        $sql3="update $table_m3 set sfcs_job_no='".$sfcs_job_no."',sfcs_qty='".$m3_qty."',club_status='1',m3_mo_no='".$sql_row1['mo_number']."',sfcs_status='16',m3_op_code='".$sql_row1['m_ops']."',m3_size='".$sql_row1['m_size']."' where sfcs_tid='".$m3_tid."'"; 
                                        $sql_result3= $link->query($sql3) or error_check();                         
                                        $sql31="update $table_order set fill_qty=fill_qty+$m3_qty where id='".$id."'"; 
                                        $sql_result31= $link->query($sql31) or error_check();             
                                        $upto_fill=$upto_fill+$m3_qty; 
                                        $m3_qty=0; 
                                        $status=1; 
                                    } 
                                    else 
                                    {                                         
                                        if(($to_be_fill>=$m3_qty) && (($prev_qty>=$upto_fill) || ($operation_st=='1'))) 
                                        { 
                                            $m_split=0; 
                                            $tid_code=$m3_sfcs_tid; 
                                            $sql4="INSERT INTO $table_m3 (`sfcs_date`, `sfcs_style`, `sfcs_schedule`, `sfcs_color`, `sfcs_size`, `m3_size`, `sfcs_doc_no`, `sfcs_qty`, `sfcs_reason`, `sfcs_remarks`, `sfcs_log_user`, `sfcs_log_time`, `sfcs_status`, `m3_mo_no`, `m3_op_code`, `sfcs_job_no`, `sfcs_mod_no`, `sfcs_shift`, `m3_op_des`, `sfcs_tid_ref`, `club_status`)  
                                            select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,'".$m3_size."',sfcs_doc_no,'".$m3_qty."',sfcs_reason,sfcs_remarks,sfcs_log_user,sfcs_log_time,'16','".$m3_mo."','".$m3_ops_code."','".$sfcs_job_no."',sfcs_mod_no,sfcs_shift,m3_op_des,'".$tid_code."','1' from $table_m3 where sfcs_tid='".$m3_tid."'"; 
                                            $sql_result4= $link->query($sql4) or error_check(); 
                                            $sql31="update $table_order set fill_qty=fill_qty+$m3_qty where id='".$id."'"; 
                                            $sql_result31= $link->query($sql31) or error_check();            
                                            $upto_fill=$upto_fill+$m3_qty; 
                                            $m3_qty=0;    $status=0;                 
                                            $i++; 
                                        } 
                                        else if(($prev_qty>=$upto_fill) || ($operation_st=='1')) 
                                        {                             
                                            if(($prev_qty>=($upto_fill+$m3_qty) || ($operation_st=='1')) && ($to_be_fill>=$m3_qty)) 
                                            { 
                                                $tid_code=$m3_sfcs_tid; 
                                                $sql4="INSERT INTO $table_m3 (`sfcs_date`, `sfcs_style`, `sfcs_schedule`, `sfcs_color`, `sfcs_size`, `m3_size`, `sfcs_doc_no`, `sfcs_qty`, `sfcs_reason`, `sfcs_remarks`, `sfcs_log_user`, `sfcs_log_time`, `sfcs_status`, `m3_mo_no`, `m3_op_code`, `sfcs_job_no`, `sfcs_mod_no`, `sfcs_shift`, `m3_op_des`, `sfcs_tid_ref`, `club_status`)  
                                                select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,'".$m3_size."',sfcs_doc_no,'".$m3_qty."',sfcs_reason,sfcs_remarks,sfcs_log_user,sfcs_log_time,'16','".$m3_mo."','".$m3_ops_code."','".$sfcs_job_no."',sfcs_mod_no,sfcs_shift,m3_op_des,'".$tid_code."','1' from $table_m3 where sfcs_tid='".$m3_tid."'"; 
                                                $sql_result4= $link->query($sql4) or error_check(); 
                                                $sql31="update $table_order set fill_qty=fill_qty+$m3_qty where id='".$id."'"; 
                                                $sql_result31= $link->query($sql31) or error_check();             
                                                $to_be_fill=$to_be_fill+$m3_qty; 
                                                $upto_fill=$upto_fill+$m3_qty; 
                                                $status=0;$m3_qty=0;                 
                                                $i++; 
                                            } 
                                            else  
                                            { 
                                                $tid_code=$m3_sfcs_tid; 
                                                $sql4="INSERT INTO $table_m3 (`sfcs_date`, `sfcs_style`, `sfcs_schedule`, `sfcs_color`, `sfcs_size`, `m3_size`, `sfcs_doc_no`, `sfcs_qty`, `sfcs_reason`, `sfcs_remarks`, `sfcs_log_user`, `sfcs_log_time`, `sfcs_status`, `m3_mo_no`, `m3_op_code`, `sfcs_job_no`, `sfcs_mod_no`, `sfcs_shift`, `m3_op_des`, `sfcs_tid_ref`, `club_status`)  
                                                select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,'".$m3_size."',sfcs_doc_no,'".$to_be_fill."',sfcs_reason,sfcs_remarks,sfcs_log_user,sfcs_log_time,'16','".$m3_mo."','".$m3_ops_code."','".$sfcs_job_no."',sfcs_mod_no,sfcs_shift,m3_op_des,'".$tid_code."','1' from $table_m3 where sfcs_tid='".$m3_tid."'"; 
                                                $sql_result4=  $link->query($sql4) or error_check(); 
                                                $sql31="update $table_order set fill_qty=fill_qty+$to_be_fill where id='".$id."'"; 
                                                $sql_result31= $link->query($sql31) or error_check();             
                                                $m3_qty=$m3_qty-$to_be_fill; 
                                                $upto_fill=$upto_fill+$to_be_fill; 
                                                $status=0;                     
                                                $i++;$to_be_fill=0; 
                                            
                                            } 
                                        } 
                                    } 
                                } 
                                while((    $m3_qty>0 && $to_be_fill>0) && (($prev_qty>=$upto_fill) || ($operation_st=='1'))); 
                            } 
                            $fill_tmp_qty=0; 
                            $to_be_fill=0; 
                            $order_qty=0; 
                        } 
                    } 
                    if($status==0 && $m3_qty==0) 
                    { 
                        // echo 'con1'.'<br>';
                        $sql31="update $table_m3 set club_status='2' where sfcs_tid='".$m3_tid."'"; 
                        $sql_result31= $link->query($sql31) or error_check();
                    } 
                    else if($status==0 && $m3_qty>0) 
                    { 
                        // echo 'con2'.'<br>';

                        $sql31="update $table_m3 set old_sfcs_qty=sfcs_qty,sfcs_qty='".$m3_qty."' where sfcs_tid='".$m3_tid."'"; 
                        // echo $sql31.'<br>';

                        $sql_result31= $link->query($sql31) or error_check();
                        // echo $sql_result31.'<br>';

                    } 
                } 
            } 
            //Fillig rejections by auto 
            else 
            { 
                // echo 'con3'.'<br>';
                
                $sql1="select * from $table_order where order_style_no='".$m3_style."' and order_del_no='".$m3_schedule."' and order_col_des='".$m3_color."' and sfcs_size='".$sfcs_size."' and sfcs_ops='".$m3_ops."' order by order_no*1"; 
                $sql_result1= $link->query($sql1) or error_check();
                $rows=mysqli_num_rows($sql_result1); 
                if($rows==1) 
                { 
                    while($sql_row1=mysqli_fetch_array($sql_result1)) 
                    { 
                        $sql3="update $table_m3 set sfcs_job_no='".$sfcs_job_no."',club_status='1',m3_mo_no='".$sql_row1['mo_number']."',sfcs_status='16',m3_op_code='".$sql_row1['m_ops']."',m3_size='".$sql_row1['m_size']."' where sfcs_tid='".$m3_tid."'"; 
                        $sql_result3= $link->query($sql3) or error_check();
                        $sql31="update $table_order set rej_pcs=rej_pcs+$m3_qty where id='".$sql_row1['id']."'"; 
                        $sql_result31= $link->query($sql31) or error_check();
                    }     
                } 
                else 
                { 
                    $i=1;$status=0;$m_split=1;$fill_qty=0;$to_be_fill=0;$prev_qty=0;$order_qty=0; 
                    while($sql_row1=mysqli_fetch_array($sql_result1)) 
                    {     
                        $operation_st=2; 
                        $prev_qty=0; 
                        $id=$sql_row1['id']; 
                        $m3_ops_code=$sql_row1['m_ops']; 
                        $m3_mo=$sql_row1['mo_number']; 
                        $m3_size=$sql_row1['m_size']; 
                        $order_qty=$sql_row1['mo_qty']; 
                        $sql12="select * from $table_order where order_style_no='".$m3_style."' and order_del_no='".$m3_schedule."' and order_col_des='".$m3_color."' and sfcs_size='".$sfcs_size."' and m_ops < ".$sql_row1['m_ops']." and mo_number='".$m3_mo."' order by m_ops limit 1"; 
                        $sql_result32= $link->query($sql12) or error_check();
                        if(mysqli_num_rows($sql_result32)>0) 
                        { 
                            while($sql_row12=mysqli_fetch_array($sql_result32)) 
                            { 
                                $prev_qty=$sql_row12['fill_qty']+$sql_row12['rej_pcs']; 
                            } 
                            $fill_tmp_qty=$sql_row1['fill_qty']+$sql_row1['rej_pcs']; 
                            $to_be_fill=$prev_qty-$fill_tmp_qty; 
                        } 
                        else 
                        { 
                            $prev_qty=0; 
                            $operation_st='1'; 
                            $fill_tmp_qty=$sql_row1['fill_qty']+$sql_row1['rej_pcs']; 
                            $to_be_fill=$order_qty-$fill_tmp_qty; 
                        }     
                        $upto_fill=$sql_row1['fill_qty']+$sql_row1['rej_pcs']; 
                        if($to_be_fill>0 && $m3_qty>0) 
                        { 
                            do 
                            {                             
                                if(($to_be_fill>=$m3_qty) && ($m_split==1) && (($prev_qty>=$upto_fill) || ($operation_st=='1'))) 
                                { 
                                    $sql3="update $table_m3 set sfcs_job_no='".$sfcs_job_no."',sfcs_qty='".$m3_qty."',club_status='1',m3_mo_no='".$sql_row1['mo_number']."',sfcs_status='16',m3_op_code='".$sql_row1['m_ops']."',m3_size='".$sql_row1['m_size']."' where sfcs_tid='".$m3_tid."'"; 
                                    $sql_result3= $link->query($sql3) or error_check();                    
                                    $sql31="update $table_order set rej_pcs=rej_pcs+$m3_qty where id='".$id."'"; 
                                    $sql_result31=  $link->query($sql31) or error_check();           
                                    $upto_fill=$upto_fill+$m3_qty; 
                                    $m3_qty=0; 
                                    $status=1; 
                                } 
                                else 
                                {     
                                    
                                    if(($to_be_fill>=$m3_qty) && (($prev_qty>=$upto_fill) || ($operation_st=='1'))) 
                                    { 
                                        $m_split=0; 
                                        $tid_code=$m3_sfcs_tid; 
                                        $sql4="INSERT INTO $table_m3 (`sfcs_date`, `sfcs_style`, `sfcs_schedule`, `sfcs_color`, `sfcs_size`, `m3_size`, `sfcs_doc_no`, `sfcs_qty`, `sfcs_reason`, `sfcs_remarks`, `sfcs_log_user`, `sfcs_log_time`, `sfcs_status`, `m3_mo_no`, `m3_op_code`, `sfcs_job_no`, `sfcs_mod_no`, `sfcs_shift`, `m3_op_des`, `sfcs_tid_ref`, `club_status`)  
                                        select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,'".$m3_size."',sfcs_doc_no,'".$m3_qty."',sfcs_reason,sfcs_remarks,sfcs_log_user,sfcs_log_time,'16','".$m3_mo."','".$m3_ops_code."','".$sfcs_job_no."',sfcs_mod_no,sfcs_shift,m3_op_des,'".$tid_code."','1' from $table_m3 where sfcs_tid='".$m3_tid."'"; 
                                        $sql_result4= $link->query($sql4) or error_check(); 
                                        $sql31="update $table_order set rej_pcs=rej_pcs+$m3_qty where id='".$id."'"; 
                                        $sql_result31= $link->query($sql31) or error_check();            
                                        $upto_fill=$upto_fill+$m3_qty; 
                                        $m3_qty=0;    $status=0;                 
                                        $i++; 
                                    } 
                                    else if(($prev_qty>=$upto_fill) || ($operation_st=='1')) 
                                    {                             
                                        if(($prev_qty>=($upto_fill+$m3_qty) || ($operation_st=='1')) && ($to_be_fill>=$m3_qty)) 
                                        { 
                                            $tid_code=$m3_sfcs_tid; 
                                            $sql4="INSERT INTO $table_m3 (`sfcs_date`, `sfcs_style`, `sfcs_schedule`, `sfcs_color`, `sfcs_size`, `m3_size`, `sfcs_doc_no`, `sfcs_qty`, `sfcs_reason`, `sfcs_remarks`, `sfcs_log_user`, `sfcs_log_time`, `sfcs_status`, `m3_mo_no`, `m3_op_code`, `sfcs_job_no`, `sfcs_mod_no`, `sfcs_shift`, `m3_op_des`, `sfcs_tid_ref`, `club_status`)  
                                            select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,'".$m3_size."',sfcs_doc_no,'".$m3_qty."',sfcs_reason,sfcs_remarks,sfcs_log_user,sfcs_log_time,'16','".$m3_mo."','".$m3_ops_code."','".$sfcs_job_no."',sfcs_mod_no,sfcs_shift,m3_op_des,'".$tid_code."','1' from $table_m3 where sfcs_tid='".$m3_tid."'"; 
                                            $sql_result4= $link->query($sql4) or error_check(); 
                                            $sql31="update $table_order set rej_pcs=rej_pcs+$m3_qty where id='".$id."'"; 
                                            $sql_result31= $link->query($sql31) or error_check();             
                                            $to_be_fill=$to_be_fill+$m3_qty; 
                                            $upto_fill=$upto_fill+$m3_qty; 
                                            $status=0;$m3_qty=0;                 
                                            $i++; 
                                        } 
                                        else  
                                        { 
                                            $tid_code=$m3_sfcs_tid; 
                                            $sql4="INSERT INTO $table_m3 (`sfcs_date`, `sfcs_style`, `sfcs_schedule`, `sfcs_color`, `sfcs_size`, `m3_size`, `sfcs_doc_no`, `sfcs_qty`, `sfcs_reason`, `sfcs_remarks`, `sfcs_log_user`, `sfcs_log_time`, `sfcs_status`, `m3_mo_no`, `m3_op_code`, `sfcs_job_no`, `sfcs_mod_no`, `sfcs_shift`, `m3_op_des`, `sfcs_tid_ref`, `club_status`)  
                                            select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,'".$m3_size."',sfcs_doc_no,'".$to_be_fill."',sfcs_reason,sfcs_remarks,sfcs_log_user,sfcs_log_time,'16','".$m3_mo."','".$m3_ops_code."','".$sfcs_job_no."',sfcs_mod_no,sfcs_shift,m3_op_des,'".$tid_code."','1' from $table_m3 where sfcs_tid='".$m3_tid."'"; 
                                            $sql_result4= $link->query($sql4) or error_check(); 
                                            $sql31="update $table_order set rej_pcs=rej_pcs+$to_be_fill where id='".$id."'"; 
                                            $sql_result31= $link->query($sql31) or error_check();             
                                            $m3_qty=$m3_qty-$to_be_fill; 
                                            $upto_fill=$upto_fill+$to_be_fill; 
                                            $status=0;                     
                                            $i++;$to_be_fill=0; 
                                        } 
                                            
                                    } 
                                } 
                            } 
                            while((    $m3_qty>0 && $to_be_fill>0) && (($prev_qty>=$upto_fill) || ($operation_st=='1'))); 
                        } 
                        $fill_tmp_qty=0; 
                        $to_be_fill=0; 
                        $order_qty=0; 
                    } 
                    if($status==0 && $m3_qty==0) 
                    { 
                        $sql31="update $table_m3 set club_status='2' where sfcs_tid='".$m3_tid."'"; 
                        $sql_result31= $link->query($sql31) or error_check();
                    } 
                    else if($status==0 && $m3_qty>0) 
                    { 
                        $sql31="update $table_m3 set old_sfcs_qty=sfcs_qty,sfcs_qty='".$m3_qty."' where sfcs_tid='".$m3_tid."'"; 
                        $sql_result31= $link->query($sql1) or error_check();
                    } 
                } 
            } 
        } 
        // Filling Reversal other than Rejections as LIFO 
        else 
        { 
            if($m3_reason=='' || $m3_reason== 'GX' ) 
            {     
                $sql="select * from $table_order where order_style_no='".$m3_style."' and order_del_no='".$m3_schedule."' and order_col_des='".$m3_color."' and sfcs_size='".$sfcs_size."' and sfcs_ops='".$m3_ops."' and (fill_qty+rej_pcs)<>0 order by order_no*1 desc"; 
                // echo $sql.'<br>';
                $sql_result= $link->query($sql) or error_check();
                $rows=mysqli_num_rows($sql_result); 
                // echo $rows.'<br>';

                if($rows==1) 
                { 
                    while($sql_row1=mysqli_fetch_array($sql_result)) 
                    { 
                        $sql3="update $table_m3 set sfcs_job_no='".$sfcs_job_no."',club_status='1',m3_mo_no='".$sql_row1['mo_number']."',sfcs_status='16',m3_op_code='".$sql_row1['m_ops']."',m3_size='".$sql_row1['m_size']."' where sfcs_tid='".$m3_tid."'"; 
                        $sql_result3= $link->query($sql3) or error_check();
                        $sql31="update $table_order set fill_qty=fill_qty+$m3_qty where id='".$sql_row1['id']."'"; 
                        $sql_result31= $link->query($sql31) or error_check();
                    }     
                } 
                else 
                { 
                    $nex_qty=0;$i=1;$status=0;$m_split=1;$fill_qty=0;$to_be_fill=0;$prev_qty=0;$order_qty=0;$upto_fill=0; 
                    while($sql_row1=mysqli_fetch_array($sql_result)) 
                    {                         
                        $id=$sql_row1['id']; 
                        $m3_ops_code=$sql_row1['m_ops']; 
                        $m3_mo=$sql_row1['mo_number']; 
                        $m3_size=$sql_row1['m_size']; 
                        $sfcs_size=$sql_row1['sfcs_size']; 
                        $order_qty=$sql_row1['mo_qty']; 
                        $last_mo=$sql_row1['order_no']; 
                        $upto_fill=$sql_row1['fill_qty']+$sql_row1['rej_pcs']; 
                        $sql12="select * from $table_order where order_style_no='".$m3_style."' and order_del_no='".$m3_schedule."' and order_col_des='".$m3_color."' and sfcs_size='".$sfcs_size."' and m_ops > ".$sql_row1['m_ops']." and mo_number='".$m3_mo."' order by m_ops*1 limit 1"; 
                        $sql_result32= $link->query($sql12) or error_check();
                        if(mysqli_num_rows($sql_result32)>0) 
                        { 
                            while($sql_row12=mysqli_fetch_array($sql_result32)) 
                            { 
                                $nex_qty=$sql_row12['fill_qty']+$sql_row12['rej_pcs']; 
                            } 
                        } 
                        else 
                        { 
                            $nex_qty=0; 
                        }     
                        if($m3_qty<0 && $upto_fill>0) 
                        { 
                            do 
                            { 
                                if(($upto_fill+$m3_qty)>=$nex_qty) 
                                { 
                                    // echo "((".$upto_fill."+".$m3_qty.")>=".$nex_qty."<br>"; 
                                    // echo "--------11--------<br>"; 
                                    $sql3="update $table_m3 set sfcs_job_no='".$sfcs_job_no."',sfcs_qty='".$m3_qty."',club_status='1',m3_mo_no='".$sql_row1['mo_number']."',sfcs_status='16',m3_op_code='".$sql_row1['m_ops']."',m3_size='".$sql_row1['m_size']."' where sfcs_tid='".$m3_tid."'"; 
                                    // echo $sql3."<br>"; 
                                    $sql_result3= $link->query($sql3) or error_check();                    
                                    $sql31="update $table_order set fill_qty=fill_qty+$m3_qty where id='".$id."'"; 
                                    // echo $sql31."<br>"; 
                                    $sql_result31= $link->query($sql31) or error_check();      
                                    $upto_fill=$upto_fill+$m3_qty; 
                                    $m3_qty=0; 
                                    $status=0; 
                                } 
                                else 
                                { 
                                    // echo "--------22--------<br>"; 
                                    $fil_qty=$nex_qty-$upto_fill; 
                                    if($fil_qty<0) 
                                    { 
                                        $tid_code=$m3_sfcs_tid; 
                                        $sql4="INSERT INTO $table_m3 (`sfcs_date`, `sfcs_style`, `sfcs_schedule`, `sfcs_color`, `sfcs_size`, `m3_size`, `sfcs_doc_no`, `sfcs_qty`, `sfcs_reason`, `sfcs_remarks`, `sfcs_log_user`, `sfcs_log_time`, `sfcs_status`, `m3_mo_no`, `m3_op_code`, `sfcs_job_no`, `sfcs_mod_no`, `sfcs_shift`, `m3_op_des`, `sfcs_tid_ref`, `club_status`)  
                                        select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,'".$m3_size."',sfcs_doc_no,'".$fil_qty."',sfcs_reason,sfcs_remarks,sfcs_log_user,sfcs_log_time,'16','".$m3_mo."','".$m3_ops_code."','".$sfcs_job_no."',sfcs_mod_no,sfcs_shift,m3_op_des,'".$tid_code."','1' from $table_m3 where sfcs_tid='".$m3_tid."'"; 
                                        // echo $sql4."<br>"; 
                                        // echo "----------------<br>"; 
                                        $sql_result3= $link->query($sql4) or error_check();                         
                                        $sql31="update $table_order set fill_qty=fill_qty+$fil_qty where id='".$id."'"; 
                                        // echo $sql31."<br>"; 
                                        // echo "----------------<br>"; 
                                        $sql_result31= $link->query($sql31) or error_check();            
                                        $upto_fill=$upto_fill+$fil_qty; 
                                        $m3_qty=$m3_qty-($fil_qty); 
                                        $status=0; 
                                    } 
                                    
                                } 
                            } 
                            while($m3_qty<0 && ($upto_fill<>$nex_qty)); 
                        } 
                        $fil_qty=0; 
                        $to_be_fill=0; 
                        $order_qty=0; 
                        $fil_qty=0; 
                        $upto_fill=0; 
                    } 
                    if($status==0 && $m3_qty==0) 
                    { 
                        $sql31="update $table_m3 set club_status='2' where sfcs_tid='".$m3_tid."'"; 
                        $sql_result31= $link->query($sql31) or error_check();
                    } 
                    else if($status==0 && $m3_qty<0) 
                    { 
                        $sql31="update $table_m3 set old_sfcs_qty=sfcs_qty,sfcs_qty='".$m3_qty."' where sfcs_tid='".$m3_tid."'"; 
                        $sql_result31= $link->query($sql31) or error_check();
                    } 
                } 
            } 
            // Filling Reversal Rejections as LIFO 
            else 
            {         
                $sql="select * from $table_order where order_style_no='".$m3_style."' and order_del_no='".$m3_schedule."' and order_col_des='".$m3_color."' and sfcs_size='".$sfcs_size."' and sfcs_ops='".$m3_ops."' and (fill_qty+rej_pcs)<>0 order by order_no*1 desc"; 
                // echo $sql."<br>"; 
                $sql_result= $link->query($sql) or error_check();
                $rows=mysqli_num_rows($sql_result); 
                
                if($rows==1) 
                { 
                    while($sql_row1=mysqli_fetch_array($sql_result)) 
                    { 
                        $sql3="update $table_m3 set sfcs_job_no='".$sfcs_job_no."',club_status='1',m3_mo_no='".$sql_row1['mo_number']."',sfcs_status='16',m3_op_code='".$sql_row1['m_ops']."',m3_size='".$sql_row1['m_size']."' where sfcs_tid='".$m3_tid."'"; 
                        $sql_result3= $link->query($sql3) or error_check();
                        $sql31="update $table_order set fill_qty=fill_qty+$m3_qty where id='".$sql_row1['id']."'"; 
                        $sql_result31= $link->query($sql31) or error_check();
                    }     
                } 
                else 
                { 
                    $nex_qty=0;$i=1;$status=0;$m_split=1;$fill_qty=0;$to_be_fill=0;$prev_qty=0;$order_qty=0;$upto_fill=0; 
                    while($sql_row1=mysqli_fetch_array($sql_result)) 
                    {                         
                        $id=$sql_row1['id']; 
                        $m3_ops_code=$sql_row1['m_ops']; 
                        $m3_mo=$sql_row1['mo_number']; 
                        $m3_size=$sql_row1['m_size']; 
                        $sfcs_size=$sql_row1['sfcs_size']; 
                        $order_qty=$sql_row1['mo_qty']; 
                        $last_mo=$sql_row1['order_no']; 
                        $upto_fill=$sql_row1['fill_qty']+$sql_row1['rej_pcs']; 
                        $sql12="select * from $table_order where order_style_no='".$m3_style."' and order_del_no='".$m3_schedule."' and order_col_des='".$m3_color."' and sfcs_size='".$sfcs_size."' and m_ops > ".$sql_row1['m_ops']." and mo_number='".$m3_mo."' order by m_ops*1 limit 1"; 
                        $sql_result32= $link->query($sql12) or error_check();
                        if(mysqli_num_rows($sql_result32)>0) 
                        { 
                            while($sql_row12=mysqli_fetch_array($sql_result32)) 
                            { 
                                $nex_qty=$sql_row12['fill_qty']+$sql_row12['rej_pcs']; 
                            } 
                        } 
                        else 
                        { 
                            $sql12="select * from $table_order where order_style_no='".$m3_style."' and order_del_no='".$m3_schedule."' and order_col_des='".$m3_color."' and sfcs_size='".$sfcs_size."' and m_ops < ".$sql_row1['m_ops']." and mo_number='".$m3_mo."' order by m_ops limit 1"; 
                            $sql_result32= $link->query($sql12) or error_check();
                            while($sql_row12=mysqli_fetch_array($sql_result32)) 
                            { 
                                $nex_qty=$sql_row12['fill_qty']+$sql_row12['rej_pcs']; 
                            } 
                        }     
                        if($m3_qty<0 && $upto_fill>0) 
                        { 
                            do 
                            { 
                                if((($upto_fill+$m3_qty)>=$nex_qty) && $upto_fill>0) 
                                { 
                                    // echo "((".$upto_fill."+".$m3_qty.")>=".$nex_qty."<br>"; 
                                    // echo "--------11--------<br>"; 
                                    $sql3="update $table_m3 set sfcs_job_no='".$sfcs_job_no."',sfcs_qty='".$m3_qty."',club_status='1',m3_mo_no='".$sql_row1['mo_number']."',sfcs_status='16',m3_op_code='".$sql_row1['m_ops']."',m3_size='".$sql_row1['m_size']."' where sfcs_tid='".$m3_tid."'"; 
                                    // echo $sql3."<br>"; 
                                    $sql_result3= $link->query($sql3) or error_check();                   
                                    $sql31="update $table_order set fill_qty=fill_qty+$m3_qty where id='".$id."'"; 
                                    // echo $sql31."<br>"; 
                                    $sql_result31= $link->query($sql31) or error_check();      
                                    $upto_fill=$upto_fill+$m3_qty; 
                                    $m3_qty=0; 
                                    $status=0; 
                                } 
                                else 
                                { 
                                    // echo "--------22--------<br>"; 
                                    $fil_qty=$nex_qty-$upto_fill; 
                                    if($fil_qty<0 && $upto_fill>0) 
                                    { 
                                        $tid_code=$m3_sfcs_tid; 
                                        $sql4="INSERT INTO $table_m3 (`sfcs_date`, `sfcs_style`, `sfcs_schedule`, `sfcs_color`, `sfcs_size`, `m3_size`, `sfcs_doc_no`, `sfcs_qty`, `sfcs_reason`, `sfcs_remarks`, `sfcs_log_user`, `sfcs_log_time`, `sfcs_status`, `m3_mo_no`, `m3_op_code`, `sfcs_job_no`, `sfcs_mod_no`, `sfcs_shift`, `m3_op_des`, `sfcs_tid_ref`, `club_status`)  
                                        select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,'".$m3_size."',sfcs_doc_no,'".$fil_qty."',sfcs_reason,sfcs_remarks,sfcs_log_user,sfcs_log_time,'16','".$m3_mo."','".$m3_ops_code."','".$sfcs_job_no."',sfcs_mod_no,sfcs_shift,m3_op_des,'".$tid_code."','1' from $table_m3 where sfcs_tid='".$m3_tid."'"; 
                                    
                                        // echo $sql4."<br>"; 
                                        // echo "----------------<br>"; 
                                        $sql_result3= $link->query($sql4) or error_check();                         
                                        $sql31="update $table_order set fill_qty=fill_qty+$fil_qty where id='".$id."'"; 
                                        // echo $sql31."<br>"; 
                                        // echo "----------------<br>"; 
                                        $sql_result31= $link->query($sql31) or error_check();             
                                        $upto_fill=$upto_fill+$fil_qty; 
                                        $m3_qty=$m3_qty-($fil_qty); 
                                        $status=0; 
                                    } 
                                    
                                } 
                                                        
                            } 
                            while($m3_qty<0 && ($upto_fill<>$nex_qty)); 
                        } 
                        $fil_qty=0; 
                        $to_be_fill=0; 
                        $order_qty=0; 
                        $fil_qty=0; 
                        $upto_fill=0; 
                    } 
                    
                    if($status==0 && $m3_qty==0) 
                    { 
                        // echo 'Reversalcon1'.'<br>';
                        $sql31="update $table_m3 set club_status='2' where sfcs_tid='".$m3_tid."'"; 
                        $sql_result31= $link->query($sql31) or error_check();
                    } 
                    else if($status==0 && $m3_qty<0) 
                    { 
                        // echo 'Reversalcon2'.'<br>';

                        $sql31="update $table_m3 set old_sfcs_qty=sfcs_qty,sfcs_qty='".$m3_qty."' where sfcs_tid='".$m3_tid."'"; 
                        $sql_result31= $link->query($sql31) or error_check();
                    } 
                } 
            }     
        } 

    }
    $link->commit();
    $flag = true;
} catch (Exception $e) {
    $link->rollback();
    // An exception has been thrown
    // We must rollback the transaction
    // $link->rollback();
    // var_dump($e);
    echo 'Message: ' .$e->getMessage();
} 
$roll = $link->rollback();
// echo $roll.'<br>';
if($flag){
    echo "<h2>Quantity splitted for Clubbed MO.</h2>"; 
}
?> 