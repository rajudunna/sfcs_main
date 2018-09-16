<?php 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    $has_permission=haspermission($_GET['r']);

	if (isset($_GET['style']))
	{
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
	}
	if(isset($_POST['submit']))
	{
		$style = $_POST['style'];
		$schedule = $_POST['schedule'];
	}
?>
    <script type="text/javascript">
        var url1 = '<?= getFullURL($_GET['r'],'carton_split.php','N'); ?>';
        function firstbox()
        {
            window.location.href =url1+"&style="+document.mini_order_report.style.value
        }
    </script>

<div class="panel panel-primary"><div class="panel-heading">Carton Split</div><div class="panel-body">
<?php
    echo "<div class='col-md-12'>
        <form action='?r=".$_GET['r']."' method=\"post\" class='form-inline' name='mini_order_report' id='mini_order_report'>
            <label>Style: </label>";
                echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" required>";
                $sql="select style from $bai_pro3.pac_stat group by style order by style";
                $sql_result=mysqli_query($link, $sql) or exit("error while getting style");
                echo "<option value=''>Please Select</option>";
                while($sql_row=mysqli_fetch_array($sql_result))
                {
                    if(trim($sql_row['style'])==trim($style))
                    {
                       	$selected='selected';
                    }
                    else
                    {
                        $selected='';
                    }
                    echo "<option value=\"".$sql_row['style']."\" $selected>".$sql_row['style']."</option>";
                }
                echo "</select>
                &nbsp;
            <label>Schedule:</label>";
                echo "<select class='form-control' name=\"schedule\" id=\"schedule\"  required>";
                $sql="select schedule from $bai_pro3.pac_stat where style='".$style."' group by schedule order by schedule*1";
                $sql_result=mysqli_query($link, $sql) or exit("Error while getting schedule");
                echo "<option value=''>Please Select</option>";
                while($sql_row=mysqli_fetch_array($sql_result))
                {
                	if($sql_row['schedule']==$schedule)
                    {
                       	$selected='selected';
                    }
                    else
                    {
                        $selected='';
                    }
                    echo "<option value=\"".$sql_row['schedule']."\" $selected>".$sql_row['schedule']."</option>";
                }
                echo "</select>&nbsp;&nbsp;

            <input type=\"submit\" name=\"submit\" value=\"Submit\" class=\"btn btn-success\"><br><br>";

if(isset($_POST['submit']) || ($_GET['style'] && $_GET['schedule']))
{
    // $sql="SELECT DISTINCT pack_method FROM $bai_pro3.`pac_stat_log` WHERE schedule='$schedule' order by pack_method";
    $sql="SELECT seq_no,pack_description,pack_method FROM $bai_pro3.pac_stat LEFT JOIN $bai_pro3.tbl_pack_ref ON tbl_pack_ref.schedule=pac_stat.schedule LEFT JOIN $bai_pro3.tbl_pack_size_ref ON tbl_pack_ref.id=tbl_pack_size_ref.parent_id AND pac_stat.pac_seq_no=tbl_pack_size_ref.seq_no where pac_stat.schedule='$schedule'	GROUP BY seq_no ORDER BY seq_no*1";
    // echo $sql;
    $sql_result=mysqli_query($link, $sql) or exit("error while getting pack method fo selected schedule");
    $rowcount=mysqli_num_rows($sql_result);
	if($rowcount>0)
	{
		echo "<a class='btn btn-success btn-sm'></a>Full Carton&nbsp;&nbsp;";
		echo "<a class='btn btn-warning btn-sm'></a>Partial Carton&nbsp;&nbsp;";
		echo "<a class='btn btn-danger btn-sm'></a>Carton Scan Completed";

		while($row=mysqli_fetch_array($sql_result))
		{
			$seq_no[]=$row['seq_no'];
			$pack_description[]=$row['pack_description'];
			$pack_method[]=$row['pack_method'];
		}
		// var_dump($seq_no);
		$split_jobs = getFullURL($_GET['r'],'split_jobs.php','N');
		for($i=0;$i<sizeof($seq_no);$i++)
		{
			echo "<div class='panel panel-primary'>
					<div class='panel-heading'>".$operation[$pack_method[$i]]."---".$pack_description[$i]."</div>
					<div class='panel-body'>";
						$getcartonnos="SELECT * from $bai_pro3.packing_summary where order_del_no='$schedule' and seq_no='".$seq_no[$i]."' group by carton_no order by carton_no*1";
						$sql_result=mysqli_query($link, $getcartonnos) or exit("Error while getting carton details");
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							$carton_no=$sql_row['carton_no'];
							$carton_mode=$sql_row['carton_mode'];

							if($carton_mode=='F')
							{
								$cartmode='Full';
							}
							else
							{
								$cartmode='Partial';
							}

							$status1=$sql_row['status'];

							if($status!='DONE')
							{
								if($carton_mode=='F')
								{
									echo "<a href='$split_jobs&schedule=$schedule&style=$style&seq_no=$seq_no[$i]&packmethod=$pack_method[$i]&cartonno=$carton_no' class='btn btn-success'>Carton:".$carton_no."</a>"."";
								}
								else
								{
									echo "<a href='$split_jobs&schedule=$schedule&style=$style&seq_no=$seq_no[$i]&packmethod=$pack_method[$i]&cartonno=$carton_no' class='btn btn-warning'>Carton:".$carton_no."</a>"."";
								}
							}
							else
							{
								echo "<a class='btn btn-danger'>Carton:".$carton_no."-".$cartmode."</a>"."";
							}
						}
					echo "</div>
				</div>
			</br>";
		}
	}
	else
	{
		echo '<div class="alert alert-danger">
			  <strong>Warning!</strong> No Cartons Available for this Schedule Number.
			  </div>';
	}
}
?>
</div>
</div>