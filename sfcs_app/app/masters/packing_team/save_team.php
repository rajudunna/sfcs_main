<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
    $conn=$link;
    $url=getFullURL($_GET['r'],'create_team.php','N');

    $row_id=$_POST['row_id'];
    $packing_team=$_POST['packing_team'];
    $team_leader=$_POST['team_leader'];
    $status=$_POST['status'];
    if($packing_team!='' || $team_leader!=''|| $status!='') {
       
        if($row_id > 0){
            $query1="select * from $brandix_bts.packing_team_master where packing_team='$packing_team'";
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
                $sql = "update $brandix_bts.packing_team_master set packing_team='$packing_team',team_leader='$team_leader',status='$status' where id=$row_id";
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
            $query="select * from $brandix_bts.packing_team_master where packing_team='$packing_team'";
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
                $sql = "INSERT INTO $brandix_bts.packing_team_master (packing_team,team_leader,status) VALUES ('$packing_team','$team_leader','$status')";
                if (mysqli_query($conn, $sql)) {
                    $url=getFullURL($_GET['r'],'create_team.php','N');
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
            title: 'Please Fill All Fields',
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