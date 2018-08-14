<?php
    include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');

    $fields = $_GET['fields'];
    $values = $_GET['values'];
    $query = $_GET['query'];
    $search = $_GET['search'];
    $href_attr = $_GET['href_attr'];
    $limit = $_GET['limit']; //limit per page
    //choosing records per page
    if(($_GET['length']!='')){
        $limit = $_GET['length'];
    }
    $start = $_GET['start']; //by lib
    $total = $_GET['total']; //total records
    $AND_COUNT = 0;

    //design the appendable query part
    $append = ' where 1 ';
    foreach($values as $key=>$value){
        $append.= " AND ".$key."='$value' ";
    }
    if($search['value']!=''){
        foreach($fields as $field=>$dup){
            if($AND_COUNT == 0){
                $append.= " AND (".$field." LIKE '%".$search['value']."%'";
            }else{
                $append.= " OR ".$field." LIKE '%".$search['value']."%'";
            }
            $AND_COUNT++;
        }
        $append.=')';
    }
    $query_count = $query.$append;
    $query = $query.$append." limit $limit offset $start";

    // echo $query;
    // die();
    //THE BELOW VARIABLES ARE ALL FOR DATATABLES
    $data = [];
    $data['array'] = 1;
    $data['recordsTotal'] = $total;
    $data['recordsFiltered'] = $total;
    $i = 0;
    //echo $query.'<br/>'.$query_count;
    $query_result = mysqli_query($link_ui, $query) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($query_result) == 0){
            $data['data'][0][] = '';
            foreach($fields as $field=>$dup)
                $data['data'][0][] ='';
            $data['data'][0][] = '';
    }else{
        while($row = mysqli_fetch_array($query_result)){
            $button_append = "<span class='append_something'><input type='hidden' value='".$row[$href_attr]."'></span>";
            $data['data'][$i][] = $start+$i+1;
            foreach($fields as $field=>$dup)
                $data['data'][$i][] =$row[$dup];
            // $data['data'][$i][] = $row['lot_no'];
            // $data['data'][$i][] = $row['batch_no'];
            // $data['data'][$i][] = $row['qty'];
            // $data['data'][$i][] = $row['product_group'];
            $data['data'][$i][] = $button_append;
            $i++;
        }
    }
    //getting count of total filtered records only if search is performed
    if($search['value']!=''){
        $query_result = mysqli_query($link_ui, $query_count) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
        $data['recordsFiltered'] = mysqli_num_rows($query_result);
    }
    echo json_encode($data);

?>