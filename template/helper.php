<?php
/*
    purpose : function for get file path to include at body(internal purpose).
    input : path of the file.
    output : path and extention of the file.
    logic : check with extention type if it is php simpily send file path and type of file,else send entair file url.
    ** By chandu **
    created at : 02-03-2018.
    updated at : 09-03-2018.
*/
function getFILE($li){
	// echo $li;
    $li = base64_decode($li);
     //echo $li;
        $path = trim($li);
    if($li != ''){
        if(file_exists($_SERVER["DOCUMENT_ROOT"].$path)){
            $type = pathinfo($path);
            if($type['extension'] == 'php' || $type['extension'] == 'htm' || $type['extension'] == 'html')
                return ['path'=>$path,'type'=>$type['extension']];
            else
                return ['path'=>$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$li,'type'=>$type['extension']];
        }elseif(explode(':',$li)[0] == 'http'){
            return ['path'=>$li,'type'=>''];
        }else{
            return false;
        }
    }else{
        return false;
    }
   
}

/*
    purpose : function for get url.
    input : file path.
    output : encripted url and encripted hash value.
    logic : construct the entair url and hash.
    ** By chandu **
    created at : 02-03-2018.
    updated at : 10-03-2018.
*/
function getURL($filePath){
    if($filePath){
        $filePath = rtrim($filePath,"/");
        $path = $filePath;
        return ['status'=>true,'url'=>$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/".$_SERVER['PHP_SELF']."?r=".base64_encode("/".$path),'r'=>base64_encode("/".$path)];
    }else{
        return ['status'=>false];
    }
}

/*
    purpose : function to get file path.
    input : r value.
    output : file name with full path.
    ** By chandu **
    created at : 07-03-2018.
    updated at : 10-03-2018.
*/
function getBASE($li){
    $li = base64_decode($li);
    $b = explode('/',$li);
    unset($b[count($b)-1]);
    // $b=array_filter($b);
    $base = implode('/',$b);
    return ['path'=>$li,'base'=>$base];
}

/*
    purpose : function to get full url.
    input : r value,type and filename.
    for type N and R(N-normal and R-raw).
    output : full url.
    ** By chandu **
    created at : 10-03-2018.
    updated at : 12-03-2018.
*/
function getFullURL($r,$filename,$type){
    $base = getBASE($r)['base'];
    $filename = rtrim($filename,"/");
    $file = $base."/".$filename;
    if($type == 'N')
        return getURL($file)['url'];
    else
        return rtrim($file,'/');
}

/*
    purpose : function to get full url.
    input : r value,filename,type(varchar) and level(int).
    for type N and R(N-normal and R-raw).
    output : full url.
    ** By chandu **
    created at : 12-03-2018.
    updated at : 12-03-2018.
*/
function getFullURLLevel($r,$filename,$level,$type){
    $base = getBASE($r)['base'];
   
    $con_base = explode('/',$base);
    for($i=0;$i<$level;$i++){
        array_pop($con_base);
    }
    $base = implode('/',$con_base);
    $filename = rtrim($filename,"/");
    $file = $base."/".$filename;
    if($type == 'N'){
        return getURL($file)['url'];
    }
    else{
        return rtrim($file,'/');
    }
}

?>