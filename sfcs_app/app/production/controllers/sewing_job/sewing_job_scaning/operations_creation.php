<title>Add New Operation</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
    <!-- <link rel="stylesheet" href="cssjs/bootstrap.min.css"> -->
    <!-- <script src="js/jquery-3.2.1.min.js"></script> -->
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <script type="text/javascript">
        function validateQty(event) 
        {
            event = (event) ? event : window.event;
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>
    <script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'Alpha/anu/incentives/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'Alpha/anu/incentives/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>

  <!--<link rel="stylesheet" href="cssjs/bootstrap.min.css">
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>-->
<body>
<!--Added   (1)Delete button for every operation 
            (2)semi-garment form
    by Theja on 07-02-2018
-->     
<?php 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/rest_api_calls.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
    $has_permission=haspermission($_GET['r']);
    $qry_short_codes = "SELECT * from $brandix_bts.ops_short_cuts";
    $result_oper = $link->query($qry_short_codes);
    //$qry_work_center_id = "SELECT * from $brandix_bts.parent_work_center_id";
    //$result_work_center_id = $link->query($qry_work_center_id);
    $url=$api_hostname.":".$api_port_no."/m3api-rest/execute/PDS010MI/Select?CONO=".$company_no."&FFAC=".$facility_code."&TFAC=".$facility_code."&PLTP=1";
   //$url = str_replace(' ', '%20', $url);
    //echo "Api :".$url."<br>";
    $result = $obj->getCurlAuthRequest($url);
    $decoded = json_decode($result,true);
     // var_dump($decoded);
    
    $vals = (conctruct_array($decoded['MIRecord']));
    
?>
<div class="container">
    <?php 
        if(in_array($authorized,$has_permission))
        { ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                     Add Bundle Operation
                </div>
                <div class="panel-body">
                    <div class="alert alert-danger" style="display:none;">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Info! </strong><span class="sql_message"></span>
                    </div>
                    <div class="form-group">
                        <form name="test" action="index.php?r=<?php echo $_GET['r']; ?>" method="POST" id='form_submt'>
                            <div class="row">
                                <div class="col-sm-3">
                                    <b>Operation Name<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b><input type="text" class="form-control" id="opn" name="opn" required>
                                </div> 
                                <div class="col-sm-3">
                                    <b>Operation code<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b><input type="number" onkeypress="return validateQty(event);" class="form-control" id="opc" name="opc" required>
                                </div>

                                <div class="col-sm-3">
                                    <b>M3 Operation Type</b><span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='orange'>*</font><input type="text" class="form-control" id="m_optype" name="m_optype" pattern="[a-zA-Z0-9._\s]+" title="This field can contain only alpha numeric characters..">
                                </div>
                                <div class='col-sm-3'>
                                     <div class="dropdown">
                                        <b>Type</b>
                                        <select class="form-control" id="sel" name="sel" required>
                                            <option value='Panel' selected>Panel</option>
                                            <option value='SGarment' >Semi Garment</option>
                                            <option value='Garment' >Garment</option>
                                        </select>   
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                     <div class="dropdown">
                                        <b>Report To ERP<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b>
                                        <select class="form-control" id="sel1" name="sel1" required>
                                        <option value="">Please Select</option><option value='yes' selected>Yes</option><option value='No' >No</option></select>    
                                    </div>
                                </div>
                                <div class="col-sm-2" hidden="true">
                                    <b>Sewing Order Code</b><input type="text" class="form-control" id="sw_cod" name="sw_cod">
                                </div><br/>
                                <div class = "col-sm-3">
                                <b>Short Key Code<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></b>            
                                    <select id="short_key_code" style="width:100%;" name="short_key_code" class="form-control" required>
                                    <option value=''>Select Short Code</option>
                                    <?php                       
                                        if ($result_oper->num_rows > 0) {
                                            while($row = $result_oper->fetch_assoc()) {
                                            $row_value = $row['short_key_code'];
                                                echo "<option value='".$row['short_key_code']."'>".strtoupper($row_value)."</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No Data Found..</option>";
                                        }
                                    ?>
                                </select>

                                </div>
                                <div class = "col-sm-3">
                                <b>Parent Work Center Id<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='orange'>*</font></span></b>            
                                    <select id="parent_work_center_id" style="width:100%;" name="parent_work_center_id" class="form-control">
                                    <option value=''>Select Parent Work Center Id</option>
                                    <?php   
                                    if($vals>0){
                                     foreach ($vals as $value) 
                                            {
                                                //echo "Oper Desc: ".$value['OPDS']."MO No:".$value['MFNO']."Work Station Id :".$value['PLG1']."SMV :".$value['PITI']."Operation :".$value['OPNO']."</br>";
                                                
                                                //getting values from api call
                                                $PLGR=$value['PLGR'];
                                                $PLNM=$value['PLNM'];
                                        echo "<option value='". $PLGR."'>".$PLGR."-".$PLNM."</option>";

                                            }
                                        }else{
                                            echo "<option value=''>No Data Found..</option>"; 
                                        }
                                        // if ($result_work_center_id->num_rows > 0) {
                                        //     while($row = $result_work_center_id->fetch_assoc()) {
                                        //     $row_value = $row['work_center_id_name'];
                                        //         echo "<option value='".$row['work_center_id_name']."'>".strtoupper($row_value)."</option>";
                                        //     }
                                        // } else {
                                        //     echo "<option value=''>No Data Found..</option>";
                                        // }
                                    ?>
                                </select>
                                </div>
                                <div class="col-sm-3">
                                    <b>Work Center</b><input type="text" class="form-control" id="work_center_id" name="work_center_id">
                                </div>
                                <div class="col-sm-3">
                                    <b>Category</b> <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span>
                                    <select class="form-control"id='category' name='category' title="It's Mandatory field" required>
                                    <option value="">Please Select</option>
                                    <option value='cutting'>Cutting</option>
                                    <option value='Send PF'>Embellishment Send</option>
                                    <option value='Receive PF'>Embellishment Received</option>
                                    <option value='sewing'>Sewing</option>
                                    <option value='packing'>Packing</option>
                                    </select>
                                </div></div>
                                <div class='row'>
                                    <div class="col-sm-2">
                                        <button type="submit"  class="btn btn-primary" style="margin-top:18px;">Save</button>
                                    </div>
                                    <div class="col-sm-2"></div><div class="col-sm-2"></div><div class="col-sm-2"></div>
                                    <div class="col-sm-4" pull-right>
                                    </br>
                                        <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='orange'>* :</font></span> Fields are mandatory when report to ERP is "Yes". 
                                    </div>
                                </div>
                        </form>
                    </div>  
                </div>
            </div>  <?php   
        }
    ?>
</div>
<?php
    $operation_name = "";
    $default_operation = "";
    $operation_code = "";
    $sw_cod="";
    $work_center="";
    $category="";
    $parent_work_center_id="";
    $m_operation_type="";

    if(isset($_POST["opn"])){
        $operation_name= $_POST["opn"];
    }
    if(isset($_POST["sel1"])){
        $default_operation= $_POST["sel1"];
    }
    if(isset($_POST["opc"])){
        $operation_code= $_POST["opc"];
    }
    if(isset($_POST["sel"])){
        $type = $_POST["sel"];
    }
    if(isset($_POST["sw_cod"])){
        $sw_cod = $_POST["sw_cod"];
    }
    if(isset($_POST["short_key_code"])){
        $short_key_code = $_POST["short_key_code"];
    }
    if(isset($_POST["work_center_id"])){
        $work_center_id = $_POST["work_center_id"];
    }
    if(isset($_POST["category"])){
        $category = $_POST["category"];
    }
    if(isset($_POST["parent_work_center_id"])){
        $parent_work_center_id = trim($_POST["parent_work_center_id"],' ');
    }
    if(isset($_POST["m_optype"])){
        $m_operation_type = trim($_POST["m_optype"],' ');
    }
    
    /* $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "brandix";
    // $conn = new mysqli($servername, $username, $password, $dbname);
    $conn = mysql_connect($servername, $username, $password);
    mysql_select_db($dbname,$conn);
    if (!$conn) {
        die("Connection failed: " . mysql_error());
    } */


    if($operation_name!="" && $operation_code!="" && $short_key_code != "" && $m_operation_type != "")
    { 
        //echo "Yes..its going";exit;
        $checking_qry = "select count(*)as cnt from $brandix_bts.tbl_orders_ops_ref where operation_code = $operation_code";
        $res_checking_qry = mysqli_query($link,$checking_qry);
        while($res_res_checking_qry = mysqli_fetch_array($res_checking_qry))
        {
            $cnt = $res_res_checking_qry['cnt'];
        }
        $work_center = "select count(*)as cnt from $brandix_bts.tbl_orders_ops_ref where work_center_id = $work_center_id";
        $work_center_qry = mysqli_query($link,$work_center);
        while($res_work_center_qry = mysqli_fetch_array($work_center_qry))
        {
            $cnt_work = $res_work_center_qry['cnt'];
        }
        $operation_name_query = "select count(*)as cnt_ops_name from $brandix_bts.tbl_orders_ops_ref where operation_name = '$operation_name'";
        $operation_name_query_result = mysqli_query($link,$operation_name_query);
        while($operation_name_query_result1 = mysqli_fetch_array($operation_name_query_result))
        {
            $cnt_opsname = $operation_name_query_result1['cnt_ops_name'];
           
        }
        $short_key_code_check_qry = "select count(*) as cnt from $brandix_bts.tbl_orders_ops_ref where short_cut_code = '$short_key_code'";
        $res_short_key_code_check_qry = mysqli_query($link,$short_key_code_check_qry);
        while($res_res_res_short_key_code_check_qry = mysqli_fetch_array($res_short_key_code_check_qry))
        {
            $cnt_short = $res_res_res_short_key_code_check_qry['cnt'];
        }
        $m_optype_check_qry = "select count(*) as cnt from $brandix_bts.tbl_orders_ops_ref where m3_operation_type = '$m_operation_type'";
        $m_optype_check_qry_result = mysqli_query($link,$m_optype_check_qry);
        while($m_optype_check_qry_rows = mysqli_fetch_array($m_optype_check_qry_result))
        {
            $cnt_moptyp = $m_optype_check_qry_rows['cnt'];
        }
        $work_center_qry = 1; 
        if(strtolower($default_operation)=='yes' && $parent_work_center_id == '')
        {
            $work_center_qry = 0;
        }
        $m_operation_type_check = 1; 
        if(strtolower($default_operation)=='yes' && $m_operation_type == '')
        {
            $m_operation_type_check = 0;
        }
        if($cnt_opsname == 0 && $cnt == 0 && $cnt_short == 0 && $cnt_work == 0 && $cnt_moptyp == 0 && $m_operation_type_check == 1  && $work_center_qry == 1)
        {
            $qry_insert = "INSERT INTO $brandix_bts.tbl_orders_ops_ref ( operation_name, default_operation,operation_code, type, operation_description,short_cut_code,work_center_id,category,parent_work_center_id,m3_operation_type)VALUES('$operation_name','$default_operation','$operation_code', '$type', '$sw_cod','$short_key_code','$work_center_id','$category','$parent_work_center_id','$m_operation_type')";
            $res_do_num = mysqli_query($link,$qry_insert);
            echo "<script>sweetAlert('Saved Successfully','','success')</script>";
        }
        else if($cnt != 0)
        {
            $sql_message = 'Operation Code Already in use. Please give other.';
            echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
        }
        else if($cnt_opsname != 0)
        {
            $sql_message = 'Operation Name Already in use. Please give other.';
            echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
        }
        else if($cnt_work != 0)
        {
            
            $sql_message = 'Work Center Already in use. Please give other.';
            echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
        }
        else if($cnt_short != 0)
        {
            $sql_message = 'Short Cut Key Code Already in use. Please give other.';
            echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
        }
        else if($cnt_moptyp != 0)
        {
            $sql_message = 'M3 Operation Type Already in use. Please give other.';
            echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
        }
        else if($cnt_short != 0 && $cnt != 0)
        {
            $sql_message = 'Short Key Code and Operation Code Already in use. Please give other.';
            echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
        }
        else if($cnt_work != 0 && $cnt != 0)
        {
            $sql_message = 'Work Center and Operation Code Already in use. Please give other.';
            echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
        }
        else if($cnt_work != 0 && $cnt_moptyp != 0)
        {
            $sql_message = 'Work Center and M3 Operation Type Already in use. Please give other.';
            echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
        }
        else if($cnt_moptyp != 0 && $cnt_short != 0)
        {
            $sql_message = 'M3 Operation Type and Short Key Code Already in use. Please give other.';
            echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
        }
        else if($work_center_qry == 0)
        {
            $sql_message = 'You should give work center id for Report to ERP Yes Operations';

        }
        else if($m_operation_type_check == 0)
        {
            $sql_message = 'M3 Operation Type is mandatory when report to ERP is YES.';
            echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
        }
    }
    
    $query_select = "select * from $brandix_bts.tbl_orders_ops_ref";
    $res_do_num=mysqli_query($link,$query_select);
    echo "<div class='container'><div class='panel panel-primary'><div class='panel-heading'>Operations List</div><div class='panel-body'>";
    echo "<div class='table-responsive'><table class='table table-bordered' id='table_one'>";
    echo "<thead><tr><th style='text-align:  center;'>S.No</th><th style='text-align:  center;'>Operation Name</th><th style='text-align:  center;'>Report To ERP</th><th style='text-align:  center;'>Operation Code</th><th style='text-align:  center;'>M3 Operation Type</th><th style='text-align:  center;'>Form</th><th>Short Key Code</th><th style='text-align:  center;'>Work Center</th><th style='text-align:  center;'>Category</th><th style='text-align:  center;'>Parent Work Center Id</th><th style='text-align:  center;'>Action</th></tr></thead><tbody>";
    $i=1;
    while($res_result = mysqli_fetch_array($res_do_num))
    {
        //var_dump($res_result);
        //checking the operation scanned or not
        $ops_code = $res_result['operation_code'];
        $query_check = "select count(*)as cnt from $brandix_bts.default_operation_workflow where operation_code = $ops_code";
        $res_query_check=mysqli_query($link,$query_check);
        while($result = mysqli_fetch_array($res_query_check))
        {
            $count = $result['cnt'];
        }
        if($count == 0)
        {
            $flag = 1;
        }
        else
        {
            $flag = 0;
        }
        echo "<tr>
            <td>".$i++."</td>
            <td>".$res_result['operation_name']."</td>
            <td>".$res_result['default_operation']."</td>
            <td>".$res_result['operation_code']."</td>
            <td>".$res_result['m3_operation_type']."</td>
            <td>".$res_result['type']."</td>
            <td>".strtoupper($res_result['short_cut_code'])."</td>
            <td>".$res_result['work_center_id']."</td>
            <td>".$res_result['category']."</td>
            <td>".$res_result['parent_work_center_id']."</td>";
            if($flag == 1)
            {
                $eurl = getFullURLLevel($_GET['r'],'operations_master_edit.php',0,'N');
                $url_delete = getFullURLLevel($_GET['r'],'operations_master_delete.php',0,'N').'&del_id='.$res_result['id'];
                if(in_array($edit,$has_permission)){ echo "<td><a href='$eurl&id=".$res_result['id']."' class='btn btn-info'>Edit</a>"; } 
                if(in_array($delete,$has_permission)){ 
                    echo "<a href='$url_delete' class='btn btn-danger confirm-submit' id='del$i' >Delete</a></td>";
                }
            }
            else
            {
                echo "<td></td>";
            }
        echo "</tr>";
    }
    echo "</tbody></table></div></div></div></div>";

    function conctruct_array($req){
        $return_ar = [];
        foreach($req as $ar1){
            $temp = [];
            foreach($ar1['NameValue'] as $ar2){
                $temp[$ar2['Name']] = $ar2['Value'];
            }
            $return_ar[] = $temp;
        }
        return $return_ar;
    }
?>
</body>
</div>
<script language="javascript" type="text/javascript">
//<![CDATA[ 
    var table2_Props =  {                   
                    display_all_text: " [ Show all ] ",
                    btn_reset: true,
                    bnt_reset_text: "Clear all ",
                    rows_counter: true,
                    rows_counter_text: "Total Rows: ",
                    alternate_rows: true,
                    sort_select: true,
                    loader: true
                };
    setFilterGrid( "table_one",table2_Props );
//]]>       
</script>
<script>
 function deleting_confirm(id){
    var url = "<?php echo getFullURLLevel($_GET['r'],'operations_creation.php',0,'N');?>&del_id="+id;
     console.log("working");
     sweetAlert({
         title: "Are you sure?",
         text: "You will not be able to recover this imaginary file!",
         icon: "warning",
         buttons: [
           'No, cancel it!',
           'Yes, I am sure!'
         ],
         dangerMode: true,
       }).then(function(isConfirm) {
         if (isConfirm) {
           sweetAlert({
             title: 'Shortlisted!',
             text: 'Candidates are successfully shortlisted!',
             icon: 'success',
           })
           window.location.href=url;
           //.then(function() {
             // form.submit();
           // });
         // } else {
           // sweetAlert("Cancelled", "Your imaginary file is safe :)", "error");
         // }
       }
    });
 }
 </script>