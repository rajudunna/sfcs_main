<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	      ?>

<html>
<head>

</head>
<body>
<div id="page_heading"><span style="float: left"><h3>Upload Distraction Data</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>

<form action="?r=<?= $_GET['r'] ?>" method="post" enctype="multipart/form-data">
 <!-- Ticket #372506 /add the please wait option -->
Import File : <input type="file" name="file" size='20'><input type='submit' name='submit' value='submit' onclick="document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';"/>
 
</form>
<span id="msg" style="display:none;"><h4>Please Wait.. While Uploading The Data..<h4></span>
<?php
if(isset($_POST["submit"]))
 {
 	
	$username_list=explode('\\',$_SERVER['REMOTE_USER']);
	$username=strtolower($username_list[1]);
	
	$i=0;	
    $fname = $_FILES["file"]["name"];
	$chk_ext1 = explode(".",$fname);
	if ($_FILES["file"]["error"] > 0)
	{
		echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	}
	else
	{
		echo "Upload: " . $_FILES["file"]["name"] . "<br />";
		//echo "Type: " . $_FILES["file"]["type"] . "<br />";
		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
		//echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
		//unlink($fname);
		if (file_exists($_FILES["file"]["name"]))
		{
			echo $_FILES["file"]["name"] . " already exists. ";
		}
		else
		{
			$new_filename=$chk_ext1[0]."_".date("Y_m_d_H_i_s").".".$chk_ext1[1];
			$path=$new_filename;
			move_uploaded_file($_FILES["file"]["tmp_name"],$path);
			//echo "Stored in: " . $_FILES["file"]["name"];
		}
	}
    
     $chk_ext = explode(".",$new_filename);
	// echo "File name =".$fname;
      
     if(strtolower($chk_ext[1]) == "csv")
      {      
         //$filename = $_FILES['file']['tmp_name'];
         $handle = fopen($new_filename, "r");		      
         while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
         {
             
			 $i=$i+1;
			 if($i==1)
			 {
			 	if($data[0] == "Tid" && $data[1] == "Style" && $data[2] == "Schedule" && $data[3] == "Color" && $data[4] == "Size" && $data[5] == "Good Garemnts Qty" && $data[6] == "Destroyed Qty" && $data[7] == "Available Qty" && $data[8] == "Destroy Qty" && $data[9] == "Panel/Garment Form")
				{
					
				}
				else
				{
					goto ends;	
				}
			 }
			 if($i > 1)
			 {
			 	 if($data[0] != "" && $data[8] > 0)
				 {
				 	 $sql1="select * from $bai_pro3.bai_qms_db where qms_tid=\"".$data[0]."\"";
					 $result1=mysqli_query($link, $sql1);
					 $rows=mysqli_num_rows($result1);
					 if($rows > 0)
					 {
					 	$sql11="select qms_style,qms_schedule,qms_color,qms_size from $bai_pro3.bai_qms_db where qms_tid=\"".$data[0]."\"";
						$table="bai_qms_db";
					 }
					 else
					 {
					 	$sql11="select qms_style,qms_schedule,qms_color,qms_size from $bai_pro3.bai_qms_db_archive where qms_tid=\"".$data[0]."\"";
						$table="bai_qms_db_archive";
					 }
					 //echo $sql11."<br>";
					 $result11=mysqli_query($link, $sql11);
					 while($row11=mysqli_fetch_array($result11))
					 {
						$styles=$row11["qms_style"];
						$schedules=$row11["qms_schedule"];
						$colors=$row11["qms_color"];
						$size=$row11["qms_size"];
					 }
					 
					 $sql31="select sum(qms_qty) as gg from $bai_pro3.$table where qms_style=\"".$styles."\" and qms_schedule=\"".$schedules."\" and qms_color=\"".$colors."\" and qms_size=\"".$size."\" and qms_tran_type=\"5\"";
					 //echo $sql31."<br>";
					 $result31=mysqli_query($link, $sql31);
					 while($row31=mysqli_fetch_array($result31))
				 	 {
				 		$good_garments=round($row31["gg"],0);
					 }
					
					 $sql32="select sum(qms_qty) as destroyed from $bai_pro3.$table where qms_style=\"".$styles."\" and qms_schedule=\"".$schedules."\" and qms_color=\"".$colors."\" and qms_size=\"".$size."\" and qms_tran_type=\"7\" and (remarks=\"g\" or remarks=\"G\")";
					 //echo $sql32."<br>";
					 $result32=mysqli_query($link, $sql32);
					 while($row32=mysqli_fetch_array($result32))
					 {
						$destroyed_garments=round($row32["destroyed"],0);
					 }
					 
					 
					 $diff=$good_garments-$destroyed_garments;
					 
					 //echo $good_garments."-".$destroyed_garments."=".$diff."<br><hr>";
						
					 if($diff >= $data[8])
					 {
						 $sql = "INSERT into $bai_pro3.bai_qms_db(qms_style,qms_schedule,qms_color,log_user,log_date,qms_size,qms_qty,qms_tran_type,remarks) values('$styles','$schedules','$colors','$username','".date("Y-m-d")."','".$data[4]."','".$data[8]."','7','".$data[9]."')";
						 //echo $sql."<br>";
		            	 mysqli_query($link, $sql) or die("Error 1 =".mysqli_error($GLOBALS["___mysqli_ston"]));
					 }
					 else
					 {
					 	$error_sch[]=$data[2];
					 }
					 
				//	 echo $good_garments."-".$destroyed_garments."=".$diff."<br><hr>";
				 }
				 else
				 {
				 	goto end;
				 }
			 }		 	
         }     
         fclose($handle);
         end:echo "<br>Data Successfully Imported.<br>";
      }
      else
      {
          echo "Invalid File";
      }  
	  
	  if(sizeof($error_sch) > 0)
	  {
		  	echo "<h3 style=\"color:red;font-family:century gothic;\">Error :</h3>Please Check the Distroy Qty and Available Qty for below Schedules.<br>";
		  
		  for($i=0;$i<sizeof($error_sch);$i++)
		  {
		  	echo $error_sch[$i]."<br>";
		  }  
	  }
	  else
	  {
	  		echo "<h3 style=\"color:red;font-family:century gothic;\">No Errors</h3><br>";
	  }
	  ends:echo "<br>Column Names Are Modified.<br>";
}
?>
 
</body>
</html>