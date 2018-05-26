<?php
include('dbconf.php');
    if(isset($_GET['search']) && $_GET['search']!=''){
        $query = "SELECT * FROM tbl_menu_list WHERE link_status=1 AND link_visibility=1 AND page_id<>'' AND parent_id<>0 and link_description like '%".$_GET['search']."%' order by menu_pid desc limit 0,10";
        $qry = mysqli_query($link, $query) or exit($query."<br/>Error 1");
        $ar = [];
        $i=0;
        while($row = mysqli_fetch_assoc($qry)) {
            $ar[$i]['link_description'] = $row['link_description'];
            $ar[$i]['link_location'] = "?r=".base64_encode($row['link_location']);
            $i++;
        }
        echo json_encode($ar);
    }
?>