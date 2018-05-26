<?php 
// include("dbconf.php");   
// include("header_scripts.php");  
// include("menu_content.php"); 
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/user_acl_v1.php"); 
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/app/production/common/config/dbconf.php");
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/common/config/user_acl_v1.php");
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/common/config/group_def.php");
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/app/production/common/config/header_scripts.php");
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/app/production/common/config/menu_content.php"); 
    include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/header_scripts.php',2,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/menu_content.php',2,'R')); 
$view_access=user_acl("SFCS_0117",$username,1,$group_id_sfcs); 
?> 



<body> 
<div class="panel panel-primary">
<div class="panel-heading">Sewing Job Split</div>
<div class="panel-body">
<!-- <div id="page_heading"><span style="float"><h3>Input Jobs Split</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>  -->

<?php 

//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2); 
/*$username_list=explode('\\',$_SERVER['REMOTE_USER']); 
$username=strtolower($username_list[1]); 
$sql="select * from menu_index where list_id=97"; 
$result=mysql_query($sql,$link) or mysql_error("Error=".mysql_error()); 
while($row=mysql_fetch_array($result)) 
{ 
    $users=$row["auth_members"]; 
} 

$username_access=explode(",",$users); 

if(in_array($username,$username_access)) 
{*/ 
$username_list=explode('\\',$_SERVER['REMOTE_USER']); 
$username=strtolower($username_list[1]); 
$tid=$_POST['tid']; 
$qty=$_POST['qty']; 

$sql="SELECT * FROM $bai_pro3.pac_stat_log_input_job where tid='$tid'"; 
$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"])); 

if($row=mysqli_fetch_array($result))
{ 
    $doc_no=$row['doc_no']; 
    $size_code=$row['size_code']; 
    $carton_act_qty=$row['carton_act_qty']; 
    $status=$row['status']; 
    $doc_no_ref=$row['doc_no_ref']; 
    $input_job_no=$row['input_job_no']; 
    $input_job_no_random=$row['input_job_no_random']; 
    $destination=$row['destination']; 
    $packing_mode=$row['packing_mode']; 
    $old_size=$row['old_size']; 

    $url_s = getFullURLLevel($_GET['r'],'split_jobs.php',0,'N');

    $sqlx="SELECT order_del_no FROM $bai_pro3.packing_summary_input where tid='$tid'"; 
    $resultx=mysqli_query($link, $sqlx) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"])); 
    if($rowx=mysqli_fetch_array($resultx)){ 
        $schedule=$rowx['order_del_no']; 
    }

    $query_check = "SELECT COUNT(id) FROM $brandix_bts.`bundle_creation_data` WHERE input_job_no_random_ref='$input_job_no_random'";
    $res_query_check=mysqli_query($link,$query_check);
    while($result = mysqli_fetch_array($res_query_check))
    {
        $count = $result['cnt'];
    }
    // echo 'count='.$count;
    if ($count=='') {
        // echo "Null, u can split";
        if ($qty == 0) {
            // echo '  <div class="alert alert-danger">
            //     <strong>Warning!</strong><br>Splitting Quantity cannot be 0.
            // </div>';
            // echo "<a href='$url_s&sch=$schedule&job=$input_job_no' class='btn btn-primary'>Click here to back</a>";
            echo "<script>sweetAlert('Splitting Quantity cannot be zero','','warning')</script>"; 
        } else if ($carton_act_qty == $qty) {
            echo "<script>sweetAlert('Cannot Split Same Quantity as Original Sewing Job Quantity','','warning')</script>"; 
            // echo '  <div class="alert alert-danger">
            //     <strong>Warning!</strong><br>Cannot Split Same Quantity as Original Sewing Job Quantity.
            // </div>';
            // echo "<a href='$url_s&sch=$schedule&job=$input_job_no' class='btn btn-primary'>Click here to back</a>"; 
        } else {
            //echo $doc_no.' '.$tid; 
            $nqty=$carton_act_qty-$qty; 
            //echo $nqty; 
             
            if($nqty>0)
            { 
                //echo $nqty; 
                $ninput_job_no=$input_job_no.'A'; 
                $ninput_job_no_random=$input_job_no_random.'A'; 
                // echo 'New Qty: '.$qty.'<br>';
                // echo 'Old input job_no: '.$input_job_no.'<br>';
                // echo 'New input job_no: '.$ninput_job_no.'<br>';
                // echo 'Old input job rand no: '.$input_job_no_random.'<br>';
                // echo 'New input job rand no: '.$ninput_job_no_random.'<br>';
                
                $sql1="INSERT into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,status,doc_no_ref,input_job_no,input_job_no_random,destination,packing_mode,old_size) VALUES ('$doc_no','$size_code','$qty','$status','".$doc_no_ref."','".$ninput_job_no."','".$ninput_job_no_random."','$destination','$packing_mode','$old_size')";
                // echo $sql1;
                mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                $sql2="UPDATE $bai_pro3.pac_stat_log_input_job SET carton_act_qty='$nqty' WHERE tid='$tid'"; 
                mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                // echo '  <div class="alert alert-info">
                //     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                //     <strong>Info!</strong><br>Successfully Splitted your job.
                //   </div>'; 
                echo "<script>sweetAlert('Success','Successfully Splitted your job.','success');</script>"; 
              //  echo "<a href='$url_s&sch=$schedule&job=$input_job_no' class='btn btn-primary'>Click here to back</a>";     
            }
        }
    } else {
        // echo "Not null, some value in bundle_creation_data, u cant split";
        // echo '  <div class="alert alert-danger">
        //         <strong>Warning!</strong><br>For Sewing Job $input_job_no, Scanning is Performed.<br>So, you cannot split the Sewing Job Anymore.
        //     </div>';
        echo "<script>sweetAlert('Warning','For Sewing Job $input_job_no, Scanning is Performed.So, you cannot split the Sewing Job Anymore.','success');</script>";     
       // echo "<a href='$url_s&sch=$schedule&job=$input_job_no' class='btn btn-primary'>Click here to back</a>";
    }
   
    echo "<script> 
            setTimeout('Redirect()',1000); 
            function Redirect() {  
                location.href = '$url_s&sch=$schedule&job=$input_job_no'; 
            }
        </script>";


   

    

             
} 


//echo $schedule.' '.$job_no; 
?> 
</div></div>
</body> 