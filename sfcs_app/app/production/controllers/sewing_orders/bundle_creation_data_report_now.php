<html> 
<head> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" /> 
        <!-- Latest compiled and minified CSS --> 
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script> 
    <script type="text/javascript" src="js/datetimepicker_css.js"></script> 
    <link rel="stylesheet" type="text/css" href="js/style.css"> 
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 

 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<script type="text/javascript" src="js/jquery.min.js"></script> 
<script type="text/javascript" src="js/datetimepicker_css.js"></script> 
 --> 
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script> 
<script type="text/javascript" src="js/datetimepicker_css.js"></script> 
<link rel="stylesheet" href="cssjs/bootstrap.min.css"> 
<link rel="stylesheet" href="cssjs/select2.min.css"> 
<link rel="stylesheet" href="cssjs/font-awesome.min.css"> 
<script type="text/javascript" src="cssjs/jquery.min.js"></script> 
<script type="text/javascript" src="cssjs/select2.min.js"></script> 
<script src="cssjs/bootstrap.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="js/style.css"> 
    <link rel="stylesheet" type="text/css" href="table.css"> 
<style type="text/css"> 
#div-1a { 
 position:absolute; 
 top:65px; 
 right:0; 
 width:auto;  
float:right; 
table { 
    float:left; 
    width:50%; 
} 
} 
.tableroot{ 
  width : 40%; 
  margin-left : 50px; 
  border-radius : 5px; 
  text-align : center; 
} 
th{ 
   background : orange; 
  } 
a{ 
  text-decoration : none; 
} 
td{ 
  border : 0px; 
} 
td{ 
  border-bottom : 2px solid black; 
  border-right : 1px solid black; 
} 
b{ 
  font-family : serif; 
  font-size : 14px; 
} 
</style> 
<style type="text/css" media="screen"> 
/*==================================================== 
  - HTML Table Filter stylesheet 
=====================================================*/ 
@import "TableFilter_EN/filtergrid.css"; 

/*==================================================== 
  - General html elements 
=====================================================*/ 
body{  
  /* margin:15px; padding:15px; border:1px solid #666; */ 
  font-family:Arial, Helvetica, sans-serif; font-size:88%;  
} 
h2{ margin-top: 50px; } 
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; } 
pre{ font-size:13px;  padding:5px; background-color:#f4f4f4; solid #ccc;  } 
.mytable{ 
  width:100%; font-size:12px; 
  } 
div.tools{ margin:5px; } 
div.tools input{ background-color:#f4f4f4; outset #f4f4f4; margin:2px; } 
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; solid #ccc; white-space: nowrap;} 
td{ padding:2px; white-space: nowrap;} 
</style> 
<script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script><!-- External script --> 
<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script> 
<script> 
    var url1 = '<?= getFullUrl($_GET['r'],'bundle_creation_data_report_now.php','N'); ?>';

  function selectstyle(){ 
    var ajax_url =url1+"&style="+document.form1.style.value;Ajaxify(ajax_url);
 
  } 
  function selectschedule(){ 
    var ajax_url =url1+"&style="+document.form1.style.value+"&schedule="+document.form1.schedule.value ;
    Ajaxify(ajax_url);

  } 
</script> 
<?php 
if(isset($_POST['color'])){ 
    $style=$_POST['style']; 
    $schedule=$_POST['schedule']; 
    $color = $_POST['color']; 
} 
else if(isset($_GET['style'])){ 
    $style=$_GET['style']; 
    if(isset($_GET['schedule'])) 
    { 
      $schedule = $_GET['schedule']; 
    } 
}  

?> 

</head> 
<body> 
  <?php  
  // include("dbconf_new.php"); 
include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
$has_permission=haspermission($_GET['r']);
  //$link  = mysqli_connect('localhost','root','','ff'); 
   
  ?> 

  <div id="page_heading" style="width : auto;height : 60px;line-height : 4px;border-radius : 5px"><span style="float: left"><h3>Print Bundle Labels</h3></span><span style="float: right"><b>?</b>&nbsp;</span> 
  </div> 
    <br><br> 

  <form name="form1" action="#" method="POST">  
  <?php  
  echo '<div class="container">'; 
  echo '<div class="form-group col-sm-2">'; 
  $style_query = 'SELECT DISTINCT(style) FROM $brandix_bts.bundle_creation_data'; 
  $styles = mysqli_query($link,$style_query); 
  echo '<label for="style"><b>Select Style </b></label> <select class="form-control" name="style" id="style" onchange="selectstyle()">'; 
  echo '<option>Please Select</option>'; 
  if($styles){ 
    while($row = mysqli_fetch_array($styles)){ 
      if(str_replace(" ","",$row['style'])==str_replace(" ","",$style)){ 
               echo "<option value=\"".$row['style']."\" selected>".$row['style']."</option>"; 
          }else{ 
               echo '<option>'.$row['style'].'</option>'; 
            } 
        } 
    } 
    echo '</select>'; 
    echo '</div>'; 
    echo '<div class="form-group col-sm-2">'; 
    echo '<label><b>Select Schedule </b></label> <select class="form-control" name="schedule" id="schedule" onchange="selectschedule()">'; 
    echo '<option>Please Select</option>'; 
    $schedule_query = 'select DISTINCT(schedule) from $brandix_bts.bundle_creation_data where style = "'.$style.'"'; 
    $schedules = mysqli_query($link,$schedule_query) or exit("getting schedules error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    if($schedules){ 
        while($row = mysqli_fetch_array($schedules)){ 
          if(str_replace(" ","",$row['schedule'])==str_replace(" ","",$schedule)){ 
                 echo "<option value=\"".$row['schedule']."\" selected>".$row['schedule']."</option>"; 
              }else{ 
                     echo '<option>'.$row['schedule'].'</option>'; 
                } 
           } 
        } 
     
     echo '</select>'; 
     echo '</div>'; 
     echo '<div class="form-group col-sm-2">'; 
     echo '<label for="color"><b>Select Color </b></label> <select class="form-control" name="color" id="color">'; 
     echo '<option>Please Select</option>'; 
     $color_query = 'select DISTINCT(color) from $brandix_bts.bundle_creation_data where style = "'.$style.'" and schedule="'.$schedule.'"'; 
     $colors = mysqli_query($link,$color_query) or exit("getting schedules error".mysqli_error($GLOBALS["___mysqli_ston"])); 
     if($colors){ 
        while($row = mysqli_fetch_array($colors)){ 
          if(str_replace(" ","",$row['color'])==str_replace(" ","",$color)){ 
                 echo "<option value=\"".$row['color']."\" selected>".$row['color']."</option>"; 
              }else{ 
                     echo '<option>'.$row['color'].'</option>'; 
                } 
           } 
        } 
     
    echo '</select>'; 
    echo '</div>'; 
    echo '</div>'; 
    echo '<div class="container">'; 
    echo '<div class="form-group col-sm-1">'; 
    echo '<label><p></p></label><input class="btn btn-warning btn-xs form-control" type="submit" id="submit" name="submit" value="submit">';  
    echo '</div>'; 
    ?> 

    </form> 



<?php 
if(isset($_POST['submit'])) 
{ 
  $count=0; 
  $style_code=$_POST['style']; 
  $shcedule_code=$_POST['schedule']; 
  $color=$_POST['color']; 
    echo '<br><br><hr>'; 
    echo '<div class="container col-sm-6">'; 
    echo '<table border="1" border="1px" class="table table-bordered">'; 
    echo "<tr><th colspan=2 >Cut.No</th><th>Print</th></tr>"; 
    $query1 = 'select DISTINCT(cut_number) from $brandix_bts.bundle_creation_data where color="'.$_POST['color'].'" and style="'.$_POST['style'].'" and schedule = "'.$_POST['schedule'].'" group by cut_number order by cut_number'; 
    // echo "".$query1; 
    $result1 = mysqli_query($link,$query1)or exit('Error getting $brandix_bts.bundle_creation_data'); 
    if($result1){ 
       $i = 0;   
       while($row1 = mysqli_fetch_array($result1)){ 
            // $query2 = 'select DISTINCT(operation_sequence) from $brandix_bts.bundle_creation_data where style="'.$style_code.'" and  
            //            schedule = "'.$shcedule_code.'" and cut_number ='.$row1['cut_number'].' and color = "'.$color.'"'; 
            $query2 = 'SELECT operation_sequence,GROUP_CONCAT(RTRIM(op_name) ORDER BY op_id) as operation_name FROM (SELECT a.style AS style,a.schedule AS SCHEDULE,a.color AS color,a.operation_id AS op_id,b.operation_code AS op_code,b.operation_name AS op_name,a.operation_sequence AS operation_sequence FROM $brandix_bts.bundle_creation_data AS a,tbl_orders_ops_ref AS b WHERE a.operation_id=b.operation_code AND a.style="'.$style_code.'" AND a.schedule="'.$shcedule_code.'" AND a.color="'.$color.'" AND cut_number='.$row1['cut_number'].' GROUP BY a.style,a.schedule,a.color,a.operation_sequence,a.operation_id,a.cut_number ORDER BY a.style,a.schedule,a.color,a.operation_sequence,a.operation_id) AS t';

            //echo "Qry2 : ".$query2."</br>"; 

            $result2 = mysqli_query($link,$query2)or exit('Error getting $brandix_bts.bundle_creation_data'); 
            if($result2){ 
                while($row2 = mysqli_fetch_array($result2)){ 
                    //echo'<td>'.++$count.'</td>'; 
                    // if($i==0){ 
                    //     echo"<tr style='background : #eeeeee;'> 
                    //          <td  colspan=2><b>".$row1['cut_number']."</b></td> 
                    //          <td colspan=3><b>All Sequences</b></td> 
                    //          <td><a target='_blank' href='$brandix_bts.bundle_creation_data_print.php?cut_number=".$row1['cut_number']. 
                    //              "&style=".$style_code."&schedule=".$shcedule_code."&color=".$color."&all=1'>  
                    //               <b>Print All </b></a> 
                    //          </td></tr><td colspan=2></td>"; 
                    //     $i++; 
                    // }else{ echo '<tr><td colspan=2></td>'; } 
                  echo $row2['op_name']; 
                  echo '<td  colspan=2><b>'.$row1['cut_number'].'</b></td>'; 
                    // echo '<td  colspan=3>Sequence '.$row2['operation_sequence'].'-('.$row2['operation_name'].')</td>'; 
                    //Check condition to change it to Already-Printed if wanted 
                    echo "<td><a target='_blank' href='$brandix_bts.bundle_creation_data_print.php?cut_number=".$row1['cut_number']. 
                         "&style=".$_POST['style']."&schedule=".$_POST['schedule']."&color=".$_POST['color']."'> Print </a></td>"; 
                    echo '</tr>'; 
                } 
            } else { 
                     echo '<tr><td colspan=4>NO Sequnces FOUND</td></tr>'; 
            }  
            $i=0;   
        } 
    } 
    else{ 
      echo '<tbody><tr><td colspan=4>NO DATA FOUND</td></tr></tbody>'; 
    } 
    echo '</table>'; 
    echo '</div>'; 

} 
?> 

<?php 

if(($_GET['status'])==1){ 
  echo '<h3>Problem in priniting please try again</h3>'; 
} 

?> 

</body> 
</html>