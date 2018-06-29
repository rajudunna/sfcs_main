<?php


$referer =  $_SERVER["HTTP_REFERER"];

$sql_types = $_POST['sql_type'];

function checkFiles(){
    $status = true;
    foreach($_FILES['sql_file']['error'] as $key => $error){
        if ($error != UPLOAD_ERR_OK || $_FILES['sql_file']['type'][$key] != "application/octet-stream") {
            $status = false;
            break;
        }
    }
    return $status;
}

if(checkFiles()){
    $finalArray = [];
    foreach($_FILES['sql_file']['name'] as $key => $name){
        $sourcePath = $_FILES["sql_file"]['tmp_name'][$key];
        $extension = end((explode(".", $_FILES["sql_file"]['name'][$key])));
    
        $fileName = md5($_POST['sql_title'][$key].$_POST['sql_description'][$key].time());
        $destinationPath =  "sql_files/".$fileName.".".$extension;
        //echo $destinationPath;
        move_uploaded_file($sourcePath, $destinationPath);

        $finalArray[$sql_types[$key]][] = [
            "sql_file" => $destinationPath,
            "sql_title" => $_POST['sql_title'][$key],
            "sql_description" => $_POST['sql_description'][$key],
        ];
        
    }

    $string = file_get_contents("saved_fields/fields.json");
    $fields  = json_decode($string, true);

    if(array_key_exists("database", $fields)){
        $fields["database"] = $finalArray;
    }
    
    $finalString = json_encode($fields,JSON_PRETTY_PRINT);
    file_put_contents("saved_fields/fields.json",$finalString);
    header("Location: $referer&dbstatus=1");
}else{
    header("Location: $referer&dbstatus=0");
}



