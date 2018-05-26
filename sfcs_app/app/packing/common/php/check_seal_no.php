<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');        ?>
<?php
    $count = 0;
    if(isset($_GET['sno']))
    {
        $sno = $_GET['sno'];
        $query = "select * from $bai_pack.upload where sealno = '$sno'";
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