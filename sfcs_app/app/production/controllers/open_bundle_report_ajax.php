<?php 
    include('../../../common/config/config_ajax.php');
    include('../../../common/config/functions.php');

 
if(isset($_GET['style_ref'])){
    $select_value='<select class="form-control" name="schedule" id="schedule"><option value="">Select schedule</option>';

     $sql_options_style="SELECT DISTINCT(schedule) FROM brandix_bts.`bundle_creation_data` where style='".$_GET['style_ref']."'";
    $options_res=mysqli_query($link,$sql_options_style);
    while( $row_options = mysqli_fetch_assoc( $options_res ) )
    {
        $select_value .='<option value="'.$row_options['schedule'].'">'.$row_options['schedule'].'</option>';
    }
    $select_value .='</select>';
    echo $select_value;
}
?>