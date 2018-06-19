<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	      ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header.php',1,'R') );  ?>

<?php

$user_manual  = getFullURL($_GET['r'],'Surplus_User_Manual.docx','R');
$path_destrcution = $_SERVER['DOCUMENT_ROOT'].'/'.$path_destrcution;
//define a maxim size for the uploaded images
define ("MAX_SIZE","10000000");
// define the width and height for the thumbnail
// note that theese dimmensions are considered the maximum dimmension and are not fixed,
// because we have to keep the image ratio intact or it will be deformed
define ("WIDTH","150");
define ("HEIGHT","100");

// this is the function that will create the thumbnail image from the uploaded image
// the resize will be done considering the width and height defined, but without deforming the image
function make_thumb($img_name,$filename,$new_w,$new_h)
{
	//get image extension.
	$ext=getExtension($img_name);
	//creates the new image using the appropriate function from gd library
	if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext) || !strcmp("JPG",$ext) || !strcmp("JPEG",$ext))
		$src_img=imagecreatefromjpeg($img_name);

	if(!strcmp("png",$ext) || !strcmp("PNG",$ext))
		$src_img=imagecreatefrompng($img_name);

	//gets the dimmensions of the image
	$old_x=imageSX($src_img);
	$old_y=imageSY($src_img);

	// next we will calculate the new dimmensions for the thumbnail image
	// the next steps will be taken:
	// 1. calculate the ratio by dividing the old dimmensions with the new ones
	// 2. if the ratio for the width is higher, the width will remain the one define in WIDTH variable
	// and the height will be calculated so the image ratio will not change
	// 3. otherwise we will use the height ratio for the image
	// as a result, only one of the dimmensions will be from the fixed ones
	$ratio1=$old_x/$new_w;
	$ratio2=$old_y/$new_h;
	if($ratio1>$ratio2) {
		$thumb_w=$new_w;
		$thumb_h=$old_y/$ratio1;
	}else {
		$thumb_h=$new_h;
		$thumb_w=$old_x/$ratio2;
	}

	// we create a new image with the new dimmensions
	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);

	// resize the big image to the new created one
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);

	// output the created image to the file. Now we will have the thumbnail into the file named by $filename
	if(!strcmp("png",$ext) || !strcmp("PNG",$ext))
	imagepng($dst_img,$filename);
	else
	imagejpeg($dst_img,$filename);

	//destroys source and destination images.
	imagedestroy($dst_img);
	imagedestroy($src_img);
}

// This function reads the extension of the file.
// It is used to determine if the file is an image by checking the extension.
function getExtension($str) 
{
	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}

?>

<title>Surplus Destruction Photos Upload</title>

<style>
tr,td{color : #000;}
</style>



<div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Surplus Destruction Files Upload</b>
		<span style="float: right" class='btn btn-info btn-xs'><b><a href="<?php echo $user_manual; ?>">info ?</a></b>&nbsp;</span>
	</div>
	<div class='panel-body'>
		<?php
		$qms_des_note_no_ref=$_GET["dest"];

		echo "<h4 style='color : #000'> Destroy Note # ".$qms_des_note_no_ref."</h4>";

		$sql="SELECT qms_des_note_no,mer_month_year,qms_log_user,date(qms_des_date) as qms_date FROM $bai_pro3.bai_qms_destroy_log ORDER BY qms_des_note_no=\"".$qms_des_note_no_ref."\"";
		//echo $sql;
		$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{	
			$qms_des_note_no=$sql_row["qms_des_note_no"];
			$mer_month_year=$sql_row["mer_month_year"];
			$qms_des_date=$sql_row["qms_date"];
			$qms_log_user=$sql_row["qms_log_user"];
		}

		$sql1="SELECT COUNT(DISTINCT remarks) AS ctn,sum(qms_qty) as qty FROM $bai_pro3.bai_qms_db WHERE location_id=\"DESTROYED-DEST#".$qms_des_note_no_ref."\"";
		//echo $sql1."<br>";
		$sql_result1=mysqli_query($link, $sql1) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$carton_count=$sql_row1["ctn"];
			$carton_qty=$sql_row1["qty"];
		}
		?>
		<div class='row'>
			<div class='col-sm-8'>
				
				<form method="post" enctype="multipart/form-data">
					<table class='table'>
						<tr>
							<th>Date</th>
							<td><?php echo $qms_des_date; ?><input type="hidden" name="date" id="demo1" value="<?php echo $qms_des_date; ?>"/></td><td></td>
						</tr>
						<tr>
							<th>No of Cartons</th>
							<td><?php echo $carton_count; ?><input type="hidden" name="vno" value="<?php echo $carton_count; ?>"/></td><td></td>
						</tr>
						<tr>
							<th>Mail Copy</th>
							<td><input type="hidden" name="MAX_FILE_SIZE_MC" value="20000000">		
								<input class='btn btn-info btn-xs' name="userfile_mc" required type="file" id="userfile_mc"></td>
							<td></td>
						</tr>
						<tr>
							<th>Destruction Certificate</th>
							<td><input type="hidden" name="MAX_FILE_SIZE_DC" value="20000000">
							<input class='btn btn-info btn-xs' name="userfile_dc" required type="file" id="userfile_dc"></td>
							<td></td>
						</tr>
						<tr>
							<th>Stacked Cartons</th>
							<td><input type="hidden" name="MAX_FILE_SIZE" value="20000000">
							<input class='btn btn-info btn-xs' accept="image/*" name="userfile" required type="file" id="userfile"></td>
							<td></td>
						</tr>
						<tr>
							<th>While Loading</th>
							<td><input type="hidden" name="MAX_FILE_SIZE1" value="20000000">
							<input class='btn btn-info btn-xs' accept="image/*" name="userfile1" required type="file" id="userfile1"></td>
							<td></td>
						</tr>
						<tr>
							<th>Carton Weighing</th>
							<td><input type="hidden" name="MAX_FILE_SIZE2" value="20000000">
							<input class='btn btn-info btn-xs' accept="image/*" name="userfile2" required type="file" id="userfile2"></td>
							<td></td>
						</tr>
						<tr>
							<th>At Security</th>
							<td><input type="hidden" name="MAX_FILE_SIZE3" value="20000000">
							<input class='btn btn-info btn-xs' accept="image/*" name="userfile3" required type="file" id="userfile3"></td>
							<td></td>
						</tr>
						<tr>
							<th>Opened Box</th>
							<td><input type="hidden" name="MAX_FILE_SIZE4" value="20000000">
							<input class='btn btn-info btn-xs' accept="image/*" name="userfile4" required type="file" id="userfile4"></td>
							<td></td>
						</tr>
						<tr>
							<th>On Shredder</th>
							<td><input type="hidden" name="MAX_FILE_SIZE5" value="20000000">
							<input class='btn btn-info btn-xs' accept="image/*" name="userfile5" required type="file" id="userfile5"></td>
							<td></td>
						</tr>
						<tr>
							<th>Collecting Dust</th>
							<td><input type="hidden" name="MAX_FILE_SIZE6" value="20000000">
								<input class='btn btn-info btn-xs' accept="image/*" name="userfile6" required type="file" id="userfile6"></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td><center><input class='btn btn-success' name="upload" type="submit" class="box" id="upload" value="Upload"></center></td>
							<td></td>
						</tr>
					<table>
				</form>
			</div>
		</div>

<?php

if(isset($_POST['upload']))
{

	//echo "upload";

	$fileName = $_FILES['userfile']['name'];
	$tmpName  = $_FILES['userfile']['tmp_name'];
	$fileSize = $_FILES['userfile']['size'];
	$fileType = $_FILES['userfile']['type'];

	//echo "<br>Name=".$fileName."<br>";

	$fileName1 = $_FILES['userfile1']['name'];
	$tmpName1  = $_FILES['userfile1']['tmp_name'];
	$fileSize1 = $_FILES['userfile1']['size'];
	$fileType1 = $_FILES['userfile1']['type'];

	$fileName2 = $_FILES['userfile2']['name'];
	$tmpName2  = $_FILES['userfile2']['tmp_name'];
	$fileSize2 = $_FILES['userfile2']['size'];
	$fileType2 = $_FILES['userfile2']['type'];

	$fileName3 = $_FILES['userfile3']['name'];
	$tmpName3  = $_FILES['userfile3']['tmp_name'];
	$fileSize3 = $_FILES['userfile3']['size'];
	$fileType3 = $_FILES['userfile3']['type'];

	$fileName4 = $_FILES['userfile4']['name'];
	$tmpName4  = $_FILES['userfile4']['tmp_name'];
	$fileSize4 = $_FILES['userfile4']['size'];
	$fileType4 = $_FILES['userfile4']['type'];

	$fileName5 = $_FILES['userfile5']['name'];
	$tmpName5  = $_FILES['userfile5']['tmp_name'];
	$fileSize5 = $_FILES['userfile5']['size'];
	$fileType5 = $_FILES['userfile5']['type'];

	$fileName6 = $_FILES['userfile6']['name'];
	$tmpName6  = $_FILES['userfile6']['tmp_name'];
	$fileSize6 = $_FILES['userfile6']['size'];
	$fileType6 = $_FILES['userfile6']['type'];

	$fileName7 = $_FILES['userfile_dc']['name'];
	$tmpName7  = $_FILES['userfile_dc']['tmp_name'];
	$fileSize7 = $_FILES['userfile_dc']['size'];
	$fileType7 = $_FILES['userfile_dc']['type'];

	$fileName8 = $_FILES['userfile_mc']['name'];
	$tmpName8  = $_FILES['userfile_mc']['tmp_name'];
	$fileSize8 = $_FILES['userfile_mc']['size'];
	$fileType8 = $_FILES['userfile_mc']['type'];

	if(strlen($tmpName) > 0 && strlen($tmpName1) > 0 && strlen($tmpName2) > 0 && strlen($tmpName3) > 0 && strlen($tmpName4) > 0 && strlen($tmpName5) > 0 && strlen($tmpName6) > 0 && strlen($tmpName7) > 0 && strlen($tmpName8) > 0)
	{		
	$fp      = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	$content = addslashes($content);
	fclose($fp);
	
	$fp1      = fopen($tmpName1, 'r');
	$content1 = fread($fp1, filesize($tmpName1));
	$content1 = addslashes($content1);
	fclose($fp1);

	$fp2      = fopen($tmpName2, 'r');
	$content2 = fread($fp2, filesize($tmpName2));
	$content2 = addslashes($content2);
	fclose($fp2);

	$fp3      = fopen($tmpName3, 'r');
	$content3 = fread($fp3, filesize($tmpName3));
	$content3 = addslashes($content3);
	fclose($fp3);

	$fp4      = fopen($tmpName4, 'r');
	$content4 = fread($fp4, filesize($tmpName4));
	$content4 = addslashes($content4);
	fclose($fp4);

	$fp5      = fopen($tmpName5, 'r');
	$content5 = fread($fp5, filesize($tmpName5));
	$content5 = addslashes($content5);
	fclose($fp5);

	$fp6      = fopen($tmpName6, 'r');
	$content6 = fread($fp6, filesize($tmpName6));
	$content6 = addslashes($content6);
	fclose($fp6);
	
	$fp7      = fopen($tmpName7, 'r');
	$content7 = fread($fp7, filesize($tmpName7));
	$content7 = addslashes($content7);
	fclose($fp7);

	$fp8      = fopen($tmpName8, 'r');
	$content8 = fread($fp8, filesize($tmpName8));
	$content8 = addslashes($content8);
	fclose($fp8);

	if(!get_magic_quotes_gpc())
	{
		$fileName = addslashes($fileName);
	}

    //echo $query;
	if(strlen($_FILES['userfile']['name'])>0)
	{
		// This variable is used as a flag. The value is initialized with 0 (meaning no error found)
		//and it will be changed to 1 if an errro occures. If the error occures the file will not be uploaded.
		$errors=0;
		// checks if the form has been submitted

		//reads the name of the file the user submitted for uploading
		$image=$_FILES['userfile']['name'];
		$image=$_FILES['userfile1']['name'];
		$image=$_FILES['userfile2']['name'];
		$image=$_FILES['userfile3']['name'];
		$image=$_FILES['userfile4']['name'];
		$image=$_FILES['userfile5']['name'];
		$image=$_FILES['userfile6']['name'];
		$document=$_FILES['userfile_dc']['name'];
		$mail=$_FILES['userfile_mc']['name'];
		// if it is not empty
		//if($image && $image1 && $image2 && $image3 && $image4 && $image5 && $image6 && $document && $mail)
		{
			// get the original name of the file from the clients machine
			$filename  = stripslashes($_FILES['userfile']['name']);
			$filename1 = stripslashes($_FILES['userfile1']['name']);
			$filename2 = stripslashes($_FILES['userfile2']['name']);
			$filename3 = stripslashes($_FILES['userfile3']['name']);
			$filename4 = stripslashes($_FILES['userfile4']['name']);
			$filename5 = stripslashes($_FILES['userfile5']['name']);
			$filename6 = stripslashes($_FILES['userfile6']['name']);
			$filename7 = stripslashes($_FILES['userfile_dc']['name']);
			$filename8 = stripslashes($_FILES['userfile_mc']['name']);

			//get the extension of the file in a lower case format
			$extension = getExtension($filename);
			$extension = strtolower($extension);

			$extension1 = getExtension($filename1);
			$extension1 = strtolower($extension1);

			$extension2 = getExtension($filename2);
			$extension2= strtolower($extension2);

			$extension3 = getExtension($filename3);
			$extension3 = strtolower($extension3);

			$extension4 = getExtension($filename4);
			$extension4 = strtolower($extension4);

			$extension5 = getExtension($filename5);
			$extension5 = strtolower($extension5);

			$extension6 = getExtension($filename6);
			$extension6 = strtolower($extension6);
			
			$extension_dc = getExtension($fileName7);

			$extension_mc = getExtension($fileName8);
			
			//echo $extension."-".$extension1."-".$extension2."-".$extension3."-".$extension4."-".$extension5."-".$extension6."-".$extension_dc."-".$extension_mc."<br>";

			// if it is not a known extension, we will suppose it is an error, print an error message
			//and will not upload the file, otherwise we continue
			
			if(strtolower($extension)!="jpg" && strtolower($extension)!="jpeg" && strtolower($extension)!="png" && strtolower($extension1)!="jpg" && strtolower($extension1)!="jpeg" && strtolower($extension1)!="png" && strtolower($extension2)!="jpg" && strtolower($extension2)!="jpeg" && strtolower($extension2)!="png" && strtolower($extension3)!="jpg" && strtolower($extension3)!="jpeg" && strtolower($extension3)!="png" && strtolower($extension4)!="jpg" && strtolower($extension4)!="jpeg" && strtolower($extension4)!="png" && strtolower($extension5)!="jpg" && strtolower($extension5)!="jpeg" && strtolower($extension5)!="png" && strtolower($extension6)!="jpg" && strtolower($extension6)!="jpeg" && strtolower($extension6)!="png" && strtolower($extension_mc)!="msg")
			{
				echo '<h1>Unknown extension File is Trying To Upload!</h1>';
				$errors=1;
			}
			else
			{
				// get the size of the image in bytes
				// $_FILES[\'image\'][\'tmp_name\'] is the temporary filename of the file in which the uploaded file was stored on the server
				$size=getimagesize($_FILES['userfile']['tmp_name']);
				$sizekb=filesize($_FILES['userfile']['tmp_name']);

				//compare the size with the maxim size we defined and print error if bigger
				if ($sizekb > MAX_SIZE*1024)
				{
					echo '<h1>You have exceeded the size limit!</h1>';
					$errors=1;
				}

				//we will give an unique name, for example the time in unix time format
				$image_name=time().'.'.$extension;
				//the new name will be containing the full path where will be stored (images folder)
				$newname="".$path_destrcution."/".$qms_des_note_no_ref."_0.".$extension;
				$copied = copy($_FILES['userfile']['tmp_name'], $newname);

				$newname1="".$path_destrcution."/".$qms_des_note_no_ref."_1.".$extension1;
				$copied1 = copy($_FILES['userfile1']['tmp_name'], $newname1);

				$newname2="".$path_destrcution."/".$qms_des_note_no_ref."_2.".$extension2;
				$copied2 = copy($_FILES['userfile2']['tmp_name'], $newname2);

				$newname3="".$path_destrcution."/".$qms_des_note_no_ref."_3.".$extension3;
				$copied3 = copy($_FILES['userfile3']['tmp_name'], $newname3);

				$newname4="".$path_destrcution."/".$qms_des_note_no_ref."_4.".$extension4;
				$copied4 = copy($_FILES['userfile4']['tmp_name'], $newname4);

				$newname5="".$path_destrcution."/".$qms_des_note_no_ref."_5.".$extension5;
				$copied5 = copy($_FILES['userfile5']['tmp_name'], $newname5);

				$newname6="".$path_destrcution."/".$qms_des_note_no_ref."_6.".$extension6;
				$copied6 = copy($_FILES['userfile6']['tmp_name'], $newname6);

				$newname7="".$path_destrcution."/".$qms_des_note_no_ref."_7.".$extension_dc;
				$copied7 = copy($_FILES['userfile_dc']['tmp_name'], $newname7);

				$newname8="".$path_destrcution."/".$qms_des_note_no_ref."_8.".$extension_mc;
				$copied8 = copy($_FILES['userfile_mc']['tmp_name'], $newname8);

				//we verify if the image has been uploaded, and print error instead
				if (!$copied && !$copied1 && !$copied2 && !$copied3 && !$copied4 && !$copied5 && !$copied6 && !$copied7 && !$copied8)
				{
					echo '<h1>Copy Unsuccessful!</h1>';
					$errors=1;
				}
				else
				{
					// the new thumbnail image will be placed in images/thumbs/ folder
					$thumb_name=''.$path_destrcution.'/thumb_'.$qms_des_note_no_ref."_0.".$extension;
					// call the function that will create the thumbnail. The function will get as parameters
					//the image name, the thumbnail name and the width and height desired for the thumbnail
					$thumb=make_thumb($newname,$thumb_name,WIDTH,HEIGHT);

					$thumb_name1=''.$path_destrcution.'/thumb_'.$qms_des_note_no_ref."_1.".$extension1;
					$thumb=make_thumb($newname1,$thumb_name1,WIDTH,HEIGHT);

					$thumb_name2=''.$path_destrcution.'/thumb_'.$qms_des_note_no_ref."_2.".$extension2;
					$thumb=make_thumb($newname2,$thumb_name2,WIDTH,HEIGHT);

					$thumb_name3=''.$path_destrcution.'/thumb_'.$qms_des_note_no_ref."_3.".$extension3;
					$thumb=make_thumb($newname3,$thumb_name3,WIDTH,HEIGHT);

					$thumb_name4=''.$path_destrcution.'/thumb_'.$qms_des_note_no_ref."_4.".$extension4;
					$thumb=make_thumb($newname4,$thumb_name4,WIDTH,HEIGHT);

					$thumb_name5=''.$path_destrcution.'/thumb_'.$qms_des_note_no_ref."_5.".$extension5;
					$thumb=make_thumb($newname5,$thumb_name5,WIDTH,HEIGHT);

					$thumb_name6=''.$path_destrcution.'/thumb_'.$qms_des_note_no_ref."_6.".$extension6;
					$thumb=make_thumb($newname6,$thumb_name6,WIDTH,HEIGHT);

					/*$thumb_name7='destruction_photos/thumb_'.$qms_des_note_no_ref."_7.".$extension_dc;
					$thumb=make_thumb($newname7,$thumb_name7,WIDTH,HEIGHT);*/
					
					$query="INSERT IGNORE INTO $bai_pack.upload_dest(dest) values('".$_GET["dest"]."')";
					$query1 = "update $bai_pack.upload_dest set  name='".$qms_des_note_no_ref."_0.".$extension."', size='".$fileSize."', type='".$fileType."', name1='".$qms_des_note_no_ref."_1.".$extension1."', size1='$fileSize1', type1='$fileType1', name2='".$qms_des_note_no_ref."_2.".$extension2."', size2='$fileSize2', type2='$fileType2', name3='".$qms_des_note_no_ref."_3.".$extension3."', size3='$fileSize3', type3='$fileType3', name4='".$qms_des_note_no_ref."_4.".$extension4."', size4='$fileSize4', type4='$fileType4', name5='".$qms_des_note_no_ref."_5.".$extension5."', size5='$fileSize5', type5='$fileType5', name6='".$qms_des_note_no_ref."_6.".$extension6."',size6='$fileSize6',type6='$fileType6',dc_cerf='".$qms_des_note_no_ref."_7.".$extension_dc."',dc_cerf_type='$fileType7',dc_cerf_size='$fileSize7',upload_by=\"".$username."\",mail_copy='".$qms_des_note_no_ref."_8.".$extension_mc."',mail_copy_type='".$fileType8."',mail_copy_size='".$fileSize8."',date=\"".date("Y-m-d H:i:s")."\" where dest='".$_GET["dest"]."'";
					//echo $query."<br>".$query1;

					$jump_url = getFullURL($_GET['r'],'main_v2.php','N');
					if(!mysqli_query($link, $query))
					{
						// echo "Error Uploading Files = ".mysqli_error($GLOBALS["___mysqli_ston"]);
						echo '<div class="alert alert-danger">
							  <strong>Warning!</strong> Error Uploading Files
							</div>';
							// die();
					}
					else
					{
						mysqli_query($link, $query1);
						// echo "<br>File uploaded Successfully<br>";
						echo '<div class="alert alert-success">
							  <strong>Success!</strong> Files Uploaded Successfully
							</div>';
						echo "<script type=\"text/javascript\"> 
								setTimeout(\"Redirect()\",5000); 
								function Redirect(){  
									location.href = \"$jump_url \"; 
								}
							  </script>";
					}
				}
			} 				
		}
		/*else
		{
			echo "<h2>Please Select All Relevant Files</h2>";
		}*/
		
	}
	}
	else
	{
		echo "<h2>Please Select All Relevant Files</h2>";
	}
}
?>	

	</div><!-- panel body -->
</div><!-- panel  -->
</div>
<div>