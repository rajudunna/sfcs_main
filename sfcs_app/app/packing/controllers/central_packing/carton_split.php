<?php 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    $has_permission=haspermission($_GET['r']);
?>

<title>Sewing Job Split</title>
<?php
    include(getFullURLLevel($_GET['r'],'common/config/header_scripts.php',2,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/menu_content.php',2,'R'));
?>

<div class="panel panel-primary"><div class="panel-heading">Pack Jobs Split</div><div class="panel-body">
<?php
    // if($username=="hasithada" or $username=="" or $username=="sfcsproject1" or $username=="chathurikap")
    // if(in_array($update,$has_permission))
    // {
        ?>
        <form name="input" method="post" action="?r=<?= $_GET['r'] ?>">
            <div class="row">
                <div class="col-md-4">       
                <?php
                    echo '<label>Enter Schedule No : </label>
                    <input type="text" class="integer form-control" required name="schedule" value="">
                </div><br/>
                    <div clas="col-md-4"><input type="submit" name="submit" value="Split" class="btn btn-success"></div>
            </div>
        </form><br/>'; 
    // }else{
        // echo "<br><div class='alert alert-danger'>You are Not Authorized to Split Sewing Jobs</div>";
    // }

if(isset($_POST['submit']))
{
    $schedule=$_POST['schedule'];
	
	echo "<button class='btn btn-success btn-sm'></button>FULL&nbsp;&nbsp;";
	echo "<button class='btn btn-warning btn-sm'></button>PARTIAL&nbsp;&nbsp;";
	echo "<button class='btn btn-danger btn-sm'></button>SCAN COMPLETED";
	
    $sql="SELECT DISTINCT pack_method FROM bai_pro3.`pac_stat_log` WHERE schedule='$schedule' order by pack_method";
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
    $rowcount=mysqli_num_rows($sql_result);
	if($rowcount>0)
	{
		while($row=mysqli_fetch_array($sql_result))
		{
			$packmethod[]=$row['pack_method'];
		}
		for($i=0;$i<sizeof($packmethod);$i++)
		{
			echo "<div class='panel panel-primary'>";
			echo "<div class='panel-heading'>".$operation[$packmethod[$i]]."</div>";
			echo "<div class='panel-body'>";
			$getcartonnos="select carton_no,carton_mode,style,pac_seq_no,pack_method,status from pac_stat_log where schedule='$schedule' and pack_method='$packmethod[$i]'";
			$sql_result=mysqli_query($link, $getcartonnos) or exit("Error while getting details".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$style=$sql_row['style'];
				$carton_no=$sql_row['carton_no'];
				$carton_mode=$sql_row['carton_mode'];
				if($carton_mode=='F')
				{
					$cartmode='FULL';
				}
				else
				{
					$cartmode='PARTIAL';
				}
				$seq_no=$sql_row['pac_seq_no'];
				$pack_method=$sql_row['pack_method'];
				$status=$sql_row['status'];
				$split_jobs = getFullURL($_GET['r'],'split_jobs.php','N');
				if($carton_mode=='F')
				{
					if($status!='DONE')
					{
						echo "<a href='$split_jobs&schedule=$schedule&style=$style&seq_no=$seq_no&packmethod=$pack_method&cartonno=$carton_no' class='btn btn-success'>Carton:".$carton_no."</a>"."";
					}
					else
					{
						echo "<a class='btn btn-danger'>Carton:".$carton_no."-".$cartmode."</a>"."";
					}
				}
				else
				{
					if($status!='DONE')
					{
						echo "<a href='$split_jobs&schedule=$schedule&style=$style&seq_no=$seq_no&packmethod=$pack_method&cartonno=$carton_no' class='btn btn-warning'>Carton:".$carton_no."</a>"."";
					}
					else
					{
						echo "<a class='btn btn-danger'>Carton:".$carton_no."-".$cartmode."</a>"."";
					}
				}
			}
			echo "</div>";
			echo "</div>";
			echo "</br>";
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