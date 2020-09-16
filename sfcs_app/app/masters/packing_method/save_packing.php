<script src="<?= getFullURLLevel($_GET['r'],'common/js/jquery-2.1.3.min.js',3,'R'); ?>"></script>
<script src="<?= getFullURLLevel($_GET['r'],'common/js/sweetalert-dev.js',3,'R'); ?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/sweetalert.css',3,'R'); ?>">
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
    $conn=$link;
    $url=getFullURL($_GET['r'],'create_packing.php','N');

    $row_id=$_POST['row_id'];
    $packing_method_code=$_POST['packing_method_code'];
    $smv=$_POST['smv'];
    $status=$_POST['status'];
    $packing_description=$_POST['packing_description'];
    $plant_code = $_SESSION['plantCode'];
    $username = $_SESSION['userName'];
    
    if(strlen(trim($packing_method_code)) > 0 && strlen(trim($smv)) > 0 && strlen(trim($packing_description)) > 0) {
       
        if($row_id > 0){
            $query1="select * from $mdm.packing_method_master where packing_method_code='$packing_method_code'";
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
                $sql = "update $mdm.packing_method_master set packing_method_code='$packing_method_code',packing_description='$packing_description',smv='$smv',status='$status',updated_user= '".$username."',updated_at=NOW() where id=$row_id";
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
            $query="select * from $mdm.packing_method_master where packing_method_code='$packing_method_code'";
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
                $sql = "INSERT INTO $mdm.packing_method_master (packing_method_code,packing_description,smv,status,created_user,updated_user,updated_at) VALUES ('$packing_method_code','$packing_description','$smv','$status','".$username."','".$username."',NOW())";
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
             echo"<script>setTimeout(function () { 
                    swal({
                    title: 'Please Fill The Values!',
                    text: 'Message!',
                    type: 'warning',
                    confirmButtonText: 'OK'
                    },
                    function(isConfirm){
                    if (isConfirm) {
                        window.location.href = \"$url\";
                    }
                    }); }, 100);</script>";
    }
    
?>