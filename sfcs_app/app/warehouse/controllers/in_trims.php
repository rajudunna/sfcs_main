<meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=7; IE=6; IE=5; IE=EDGE" />

<?php 
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$url = '/sfcs_app/app/warehouse/controllers/in_trims.php';
$out_trims_scanner = '/sfcs_app/app/warehouse/controllers/out_trims_scanner.php';
?>
<script>
function focus_box()
{
	document.input.cartonid.focus();
}
function check_docket(e){
	var d = document.getElementById('cartonid').value;
	var m = document.getElementById('cartonid2').value;
	if(m=='' && d ==''){
		sweetAlert('Please Enter Location ','','warning');
		e.preventDefault();
		return false;
	}
	return true;
}
</script>

<style>
body
{
	width:auto;
	font-family:arial;
	display:inline-block;
	border:1px solid blue;
}
.equal{
		width : 80px;
		text-align:center;
		margin-top:60pt;
		margin-left:20%;
		display:block;
	}
   
    button{
		text-align:right
		display:block;
    }
    .panel-primary{
        margin : 2px 250px 2px 250px;
        padding : 20px 5px 20px 5px;
        /* border:1px solid blue; */
		text-align:center;
		display:block;
    }
    .panel-heading {
        font-weight:bold;
        text-align:left;
    }
    .label-success{
        background-color:#5cb85c;
        color:white;
		width:25%;
		border-radius:5px;
		margin-left:-120%;
		display:block;
	}
	.label-success1{
        background-color:#5cb85c;
        color:white;
		text-align:left;
		width:15%;
        border-radius:5px;
		display:block;
        padding : 4px 10px 4px 10px;
    }
    .btn-success {
        background-color:green;
        color:white;
        margin-top:-30pt;
        border-radius:5px;
        margin-right:-410px;
        margin-bottom:20px;
        padding : 4px 10px 4px 10px;
    }
    .btn-danger {
        background-color:#d9534f;
        color:white;
        border-radius:5px;
        margin-top:-15pt;
        margin-right:-410px;
        margin-bottom:20px;
        padding : 4px 10px 4px 10px;
    }
    .label-danger {
        background-color:#d9534f;
        color:white;
        border-radius:5px;
		margin-top:-10pt;
    }
    #location1 {
		margin-top:-7.5%;
		width:105%;
	}
	#location {
		margin-left:35%;
		margin-top:-13.5%;
		width:35%;
    }
    #cartonid{
        /* margin-top:-50pt; */
		margin-left:-120%;
		margin-top:-25%;
        padding-top:-11%;
		padding-right:7%;
		display:block;
    }
    #cartonid2{
        margin-top:15%;
        margin-left:-120%;
        /* margin-left:-420pt; */
		padding:5px;
		display:block;
    }
    #label2{
        margin-top:-10px;
        margin-left:-190%;
    }
    #check_in{
        margin-top:-18%;
        margin-left:-10%;
        background-color:#337ab7;
        padding:8px;
        color:white;
		border-radius:8px;
		display:block;
    }
    h2{
        margin-left:-450px;
	}
	a{
		text-decoration:none;
	}
    #status {
        font-size:14pt;
        margin-left:10%;
	}
	.label1{
		margin-left:-58%;
		display:block;
	}
	.text-left{
		display:block;
	}
	.loc{
        margin-left:100%;
	}
    /* h3{
        margin-top:-20px;
    } */
</style>

<body onload="focus_box()">
<div class='panel panel-primary'>
	<div class='panel-heading'>
		Online Barcode Scanning
	</div>
	<div class='panel-body'>
		<div class='text-left'><span class="label label-success">In</span></div>
		<?php

		if(isset($_GET['location']))
		{
			$location=$_GET['location'];
			
			$sql="select * from $bai_rm_pj1.location_db where location_id=\"$location\" and sno>0 and status=1";
			$sql_result=mysqli_query($link, $sql);	
			if(mysqli_num_rows($sql_result)>0)
			{
				echo "<div class='loc'><h2><label class='label1'>Location  : </label>&nbsp;&nbsp;<span class='label label-success1' id='location'>$location</span></h2></div>";
			}
			else
			{
				echo "<div class='loc'><h2><label class='label1'>Location  : </label>&nbsp;&nbsp;<span class='label label-danger'>Scan Valid Location !</span></h2></div>";
				$location="";
			}
			
			
		}
		else
		{
			echo "<div class='loc'><h2><label>Location  : </label>&nbsp;&nbsp;<span class='label label-danger'>Scan Location !</span></h2></div>";
			$location="";
		}

           
			echo "<br><div class='pull-right '>
            <div><h4>
                <a href=$url>
                    <button class='equal btn btn-success'>In</button></a><Br/>
                <a href=$out_trims_scanner>
                    <button class='equal btn btn-danger'>T-Out</button></a> </h4>
            </div>
         </div>";
    
		?>

		<form name="input" method="post" action="?r=<?= $url ?>" enctype="multipart/form data" id="form">
		<div class="row">
		<div class="form-group col-md-3">
		<input type="text" name="cartonid" id="cartonid" class="form-control"  oninput="document.input.submit();"  value="">
		</div>
		</div>
		<div class="row">
		<div class="form-group col-md-3">
		<!-- <label id="label2">Manual Entry: </label> -->
		<input type="text" class="form-control" size="19" value="" id='cartonid2' name="cartonid2" placeholder="Manual Entry">
		</div>
		<input type="submit" id="check_in" name="check2" value="Check In" onclick='return check_docket(event)' class="btn btn-primary">
		<input type="hidden" name="location" value="<?php echo $location; ?>">
		<input type="hidden" name="check" value="check">
		</div>
		</form>
		
		<?php

		//Normal Process
		if(isset($_POST['cartonid']) or isset($_POST['check']))
		{
			
			$code=$_POST['cartonid'];
			$location=$_POST['location'];
			if(is_numeric(substr($code,0,1)))
			{
				$sql="select * from $bai_rm_pj1.location_db where location_id=\"$location\" and sno>0";
				//echo "<br/>".$sql."<br/>";
				$sql_result=mysqli_query($link, $sql);
				if(mysqli_num_rows($sql_result)>0)
				{
					$code=ltrim($code,"0");
					$sql1="update $bai_rm_pj1.store_in set ref1=\"$location\", status=0, allotment_status=0 where tid=\"$code\"";
					//echo "<br/>".$sql1."<br/>";
					$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_affected_rows($link)>0)
					{
						echo "<div id='location1'>Status: <span class='label label-success'>Success!</span> $code</div>";
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"in_trims.php?location=$location\"; }</script>";
					}else{
						$sql1="select * from $bai_rm_pj1.store_in_deleted where tid=\"$code\" ";
						$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result1)>0)
						{
						echo "<div id='location1'>Status  : $code-<span class='label label-warning'>Label Deleted</span> </div>";

						}
						else
						{
							$sql2="select * from $bai_rm_pj1.store_in where tid=\"$code\" ";
							$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							if(mysqli_num_rows($sql_result2)>0)
							{
								echo "<div id='location1'>Status  : $code-<span class='label label-info'>Label Already Scanned</span> </div>";
							}
							else
							{

							echo "<div id='location1'>Status  :$code- <span class='label label-warning'>Label Not Found</span> </div>";

							}
						}
						// echo "<h2>Status: <span class='label label-warning'>Failed (or) already updated</span> $code</h2>";
						//echo "<button id='back' onclick='back()' class='btn btn-warning'><< Go back</button>";
						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"in_trims.php?location=$location&code=$code\"; }</script>";
						
					}
					
				}
				else
				{
					echo "<div id='location'>Status: <span class='label label-danger'>Scan Location!</span></div>";
				}
			}
			else
			{
				
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"in_trims.php?location=$code\"; }</script>";
			}
		}

		//Manual Lable Entry
		if(isset($_POST['check2']))
		{
			// echo "<hr/>";
			$code=$_POST['cartonid2'];
			$location=$_POST['location'];
			
			if(is_numeric(substr($code,0,1)))
			{
				$sql="select * from $bai_rm_pj1.location_db where location_id=\"$location\" and sno>0";
				$sql_result=mysqli_query($link, $sql);
				if(mysqli_num_rows($sql_result)>0)
				{
					$code=ltrim($code,"0");
					$sql1="update $bai_rm_pj1.store_in set ref1=\"$location\", status=0, allotment_status=0 where tid=\"$code\"";
					$sql_result1=mysqli_query($link, $sql1);
					if(mysqli_affected_rows($link)>0)
					{
						echo "<div id='status'>Status  : <span class='label label-success'>Success!</span> $code</div>";
						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"in_trims.php?location=$location\"; }</script>";
					}
					else
					{
						$sql1="select * from $bai_rm_pj1.store_in_deleted where tid=\"$code\" ";
						$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result1)>0)
						{
						echo "<h3>Status  : $code-<span class='label label-warning'>Label Deleted</span> </h3>";

						}
						else
						{
							$sql2="select * from $bai_rm_pj1.store_in where tid=\"$code\" ";
							$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							if(mysqli_num_rows($sql_result2)>0)
							{
								echo "<h3>Status  : $code-<span class='label label-info'>Label Already Scanned</span> </h3>";
							}
							else
							{

							echo "<h3>Status  :$code- <span class='label label-warning'>Label Not Found</span> </h3>";

							}
						}
						// echo "<h2>Status  : <span class='label label-warning'>Failed (or) already updated</span> $code</h2>";
						// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"".getFullURL($_GET['r'],'return.php','N')."&location=$location&code=$code\"; }</script>";
						echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"in_trims.php?location=$location&code=$code\"; }</script>";
					}
					
				}
				else
				{
					echo "<h2>Status  : <span class='label label-danger'>Scan Location!</span></h2>";
				}
			}
			else
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = 'in_trims.php?location=".$code."'; }</script>";
			}
		}
		?>
	</div>
</div>
</body>
