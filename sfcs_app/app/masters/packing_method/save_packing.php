<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
    $conn=$link;
    $url=getFullURL($_GET['r'],'create_packing.php','N');

    $row_id=$_POST['row_id'];
    $packing_method_code=$_POST['packing_method_code'];
    $smv=$_POST['smv'];
    $status=$_POST['status'];
    $packing_description=$_POST['packing_description'];
    if($packing_method_code!='' || $smv!=''|| $status!=''|| $packing_description!='') {
       
        if($row_id > 0){
            $query1="select * from $brandix_bts.packing_method_master where packing_method_code='$packing_method_code'";
            // echo $query1;
            $sql_result1=mysqli_query($conn, $query1);
            $count = mysqli_num_rows($sql_result1);
            
            if($count == 2){
                echo"<script>setTimeout(function () { 
                    swal({
                    title: 'Packing Method Already Existed!',
                    text: 'Message!',
                    type: 'warning',
                    confirmButtonText: 'OK'
                    },
                    function(isConfirm){
                    if (isConfirm) {
                        window.location.href = \"$url\";
                    }
                    }); }, 100);</script>";
            } else {
                $sql = "update $brandix_bts.packing_method_master set packing_method_code='$packing_method_code',packing_description='$packing_description',smv='$smv',status='$status' where id=$row_id";
                if (mysqli_query($conn, $sql)) {
                    echo"<script>setTimeout(function () { 
                        swal({
                        title: 'Record updated successfully',
                        text: 'Message!',
                        type: 'success',
                        confirmButtonText: 'OK'
                        },
                        function(isConfirm){
                        if (isConfirm) {
                            window.location.href = \"$url\";
                        }
                        }); }, 100);</script>";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        } else {
            $query="select * from $brandix_bts.packing_method_master where packing_method_code='$packing_method_code'";
            $sql_result=mysqli_query($conn, $query);
            if(mysqli_num_rows($sql_result)>0){
                echo"<script>setTimeout(function () { 
                    swal({
                    title: 'Packing Method Already Existed!',
                    text: 'Message!',
                    type: 'warning',
                    confirmButtonText: 'OK'
                    },
                    function(isConfirm){
                    if (isConfirm) {
                        window.location.href = \"$url\";
                    }
                    }); }, 100);</script>";
            } else {
                $sql = "INSERT INTO $brandix_bts.packing_method_master (packing_method_code,packing_description,smv,status) VALUES ('$packing_method_code','$packing_description','$smv','$status')";
                if (mysqli_query($conn, $sql)) {
                    $url=getFullURL($_GET['r'],'create_packing.php','N');
                    echo"<script>setTimeout(function () { 
                            swal({
                            title: 'New record created successfully',
                            text: 'Message!',
                            type: 'success',
                            confirmButtonText: 'OK'
                            },
                            function(isConfirm){
                            if (isConfirm) {
                                window.location.href = \"$url\";
                            }
                        }); }, 100);</script>";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } 
        }

        
    } else {

    }
    
?>