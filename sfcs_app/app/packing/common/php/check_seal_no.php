<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');        ?>
<?php
    $plant_code = $_SESSION['plantCode'];
    $username = $_SESSION['userName'];
    $count = 0;
    if(isset($_GET['sno']))
    {
        $sno = $_GET['sno'];
        $query = "select * from $pts.upload where sealno = '$sno' AND plant_code='$plant_code'";
        $result = mysqli_query($link,$query);
        while($row = mysqli_fetch_array($result)){
           $count++;
        }
    }

    if($count > 0){
        echo 'exist'; 
    }else{
        echo 'no'; 
    }


?>