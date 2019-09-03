<?php
include('dbconf.php');

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
    $b=array_filter($b);
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

/*
    purpose : function to Give Permission to the user at menu level.
    output : array of menu row ids.
    ** By chandu **
    created at : 14-06-2018.
    updated at : 15-06-2018.
*/

function hasmenupermission()
{
    $user = getrbac_user()['uname'];
    GLOBAL $link_ui;
    $query = "SELECT rbac_role_menu.menu_pid FROM rbac_role_menu LEFT JOIN rbac_users ON rbac_role_menu.roll_id=rbac_users.role_id WHERE rbac_users.user_name='".$user."'";
    
    $res = mysqli_query($link_ui, $query) or exit($sql."<br/>Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $result = [];
    while($rm = mysqli_fetch_array($res)){
        $result[] = $rm['menu_pid'];
    }
    return $result;
}

/*
    purpose : function to Give Permission to the user at screen view.
    output : array of menu row ids.
    ** By chandu **
    created at : 18-06-2018.
    updated at : 19-06-2018.
*/

function hasviewpermission($r)
{
    $user = getrbac_user()['uname'];
    GLOBAL $link_ui;
    $r = base64_decode($r);
    $r = "/".trim($r, "/");

    $query = "SELECT * FROM rbac_role_menu LEFT JOIN tbl_menu_list ON rbac_role_menu.menu_pid=tbl_menu_list.menu_pid LEFT JOIN rbac_users ON rbac_role_menu.roll_id = rbac_users.role_id WHERE rbac_users.user_name='".$user."' AND tbl_menu_list.link_location='".$r."'";

    $res = mysqli_query($link_ui, $query) or exit($sql."<br/>Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $result = false;
    if(mysqli_num_rows($res)==0){
        $p=explode('/',$r);
        unset($p[count($p)-1]);
        $ir = implode('/',$p);
        $query = "SELECT * FROM rbac_role_menu LEFT JOIN tbl_menu_list ON rbac_role_menu.menu_pid=tbl_menu_list.menu_pid LEFT JOIN rbac_users ON rbac_role_menu.roll_id = rbac_users.role_id WHERE rbac_users.user_name='".$user."' AND tbl_menu_list.link_location like '%".$ir."%' ";

        $res = mysqli_query($link_ui, $query) or exit($sql."<br/>Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($res)>0){
            $result = true;
        }
    }else{
        $result = true;
    }
    return $result; 
}

/*
    purpose : function to Give Permission to the user page level.
    input : r value
    output : array of permission names.
    ** By chandu **
    created at : 14-06-2018.
    updated at : 17-06-2018.
*/
function haspermission($r){
    $user = getrbac_user()['uname'];
    GLOBAL $link_ui;
    $r = base64_decode($r);
    $r = "/".trim($r, "/");

    $query = "SELECT rbac_role_menu_per.permission_id,rbac_permission.permission_name FROM rbac_role_menu_per LEFT JOIN rbac_role_menu ON rbac_role_menu_per.role_menu_id=rbac_role_menu.role_menu_id LEFT JOIN tbl_menu_list ON rbac_role_menu.menu_pid=tbl_menu_list.menu_pid LEFT JOIN rbac_users ON rbac_role_menu.roll_id = rbac_users.role_id LEFT JOIN rbac_permission ON rbac_role_menu_per.permission_id=rbac_permission.permission_id WHERE rbac_permission.status='active' and rbac_users.user_name='".$user."' AND tbl_menu_list.link_location='".$r."'";

    $res = mysqli_query($link_ui, $query) or exit($sql."<br/>Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $result = [];
    while($rm = mysqli_fetch_array($res)){
        $result[] = $rm['permission_id'];
    }
    if(count($result)==0){
        $p=explode('/',$r);
        unset($p[count($p)-1]);
        $ir = implode('/',$p);
        $query = "SELECT rbac_role_menu_per.permission_id,rbac_permission.permission_name FROM rbac_role_menu_per LEFT JOIN rbac_role_menu ON rbac_role_menu_per.role_menu_id=rbac_role_menu.role_menu_id LEFT JOIN tbl_menu_list ON rbac_role_menu.menu_pid=tbl_menu_list.menu_pid LEFT JOIN rbac_users ON rbac_role_menu.roll_id = rbac_users.role_id LEFT JOIN rbac_permission ON rbac_role_menu_per.permission_id=rbac_permission.permission_id WHERE rbac_permission.status='active' and rbac_users.user_name='".$user."' AND tbl_menu_list.link_location like '%".$ir."%' group by rbac_role_menu_per.permission_id";

        $res = mysqli_query($link_ui, $query) or exit($sql."<br/>Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($rm = mysqli_fetch_array($res)){
            $result[] = $rm['permission_id'];
        }
    }
    return $result;  
}

/*
    purpose : function to Give login user name.
    output : String.
    ** By chandu **
    created at : 18-06-2018.
    updated at : 20-06-2018.
*/
function getrbac_user(){
    $username_list=explode('\\',$_SERVER['REMOTE_USER']);
    $user['uname']=strtolower($username_list[1]);
     // $user['uname'] = 'sfcsproject1';
    GLOBAL $link_ui;
    if($link_ui){
    $query = "SELECT rbac_roles.role_name,rbac_roles.role_id FROM rbac_users LEFT JOIN rbac_roles ON rbac_users.role_id = rbac_roles.role_id WHERE rbac_users.user_name='".$user['uname']."'";
    $res = mysqli_query($link_ui, $query) or exit($sql."<br/>Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $roles = mysqli_fetch_array($res);
    $user['role'] = $roles['role_name'];
    $user['role_id'] = $roles['role_id'];
    }else{
        $user['role'] = '';
        $user['role_id'] = '';
    }
    return $user;
}


/*
    purpose : function to Give Configuration data.
    output : String/array.
    ** By chandu **
    created at : 23-06-2018.
    updated at : 26-06-2018.
*/
function get_config_values($config_id){
    $conf = new confr("configuration/API/saved_fields/fields.json");
    if($config_id=='getmysqldb'){
        return $conf->getDBConfig();
    }else{
        return $conf->get($config_id);
    }
}


?>