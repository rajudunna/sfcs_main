<script src="<?= getFullURLLevel($_GET['r'],'common/js/jquery-2.1.3.min.js',3,'R'); ?>"></script>
<script src="<?= getFullURLLevel($_GET['r'],'common/js/sweetalert-dev.js',3,'R'); ?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/sweetalert.css',3,'R'); ?>">
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
    $conn=$link;
    $url=getFullURL($_GET['r'],'create_team.php','N');
    $plant_code = $_SESSION['plantCode'];
    $username = $_SESSION['userName'];

    $row_id=$_POST['row_id'];
    $packing_team=$_POST['packing_team'];
    $team_leader=$_POST['team_leader'];
    $status=$_POST['status'];
        if(strlen(trim($packing_team)) > 0 && strlen(trim($team_leader)) > 0) {
       
            if($row_id > 0){
            $query1="select * from $pms.packing_team_master where packing_team='$packing_team' and plant_code='$plant_code'";
            $sql_result1=mysqli_query($conn, $query1);
            $count = mysqli_num_rows($sql_result1);
            if($count == 2){
                echo"<script>setTimeout(function () { 
                    swal({
                    title: 'Packing Team Already Existed!',
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
                $sql = "update $pms.packing_team_master set packing_team='$packing_team',team_leader='$team_leader',status='$status',updated_user= '".$username."',updated_at=NOW() where id=$row_id and plant_code='$plant_code'";
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
            $query="select * from $pms.packing_team_master where packing_team='$packing_team' and plant_code='$plant_code'";
            $sql_result=mysqli_query($conn, $query);
            if(mysqli_num_rows($sql_result)>0){
                echo"<script>setTimeout(function () { 
                    swal({
                    title: 'Packing Team Already Existed!',
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
                $sql = "INSERT INTO $pms.packing_team_master (packing_team,team_leader,status,plant_code,created_user,updated_user,updated_at) VALUES ('$packing_team','$team_leader','$status','$plant_code','$username','".$username."',NOW())";
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