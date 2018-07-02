<?php
session_start();

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

        $finalArray[] = [
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
    $_SESSION["dbstatus"] = 1;
    header('Location: index.php');

}else{
    $_SESSION["dbstatus"] = 0;
    header('Location: index.php?dbstatus=0');
}



