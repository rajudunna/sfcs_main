<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $names = $_POST["name"];
    $urls = $_POST["url"];
    $instances = [];
    $check = true;
    foreach ($names as $key => $value) {
        if (!filter_var($urls[$key], FILTER_VALIDATE_URL)) { 
            $check = false;
            break;
        }
        $tmp = [
            "name"=>$value,
            "url"=>$urls[$key]
        ];
        $instances[] = $tmp;
    }
    if($check){
        $finalString = json_encode($instances,JSON_PRETTY_PRINT);
        file_put_contents("saved_fields/instances.json", $finalString);
        $_SESSION["instancesStatus"] = 1;
        header('Location: index.php');
    }else{
        $_SESSION["instancesStatus"] = 0;
        header('Location: index.php');
    }
}else{
    echo "invalid request method";
}