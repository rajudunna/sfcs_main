<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	      ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header.php',1,'R') );  ?>

<?php
$user_manual  = getFullURL($_GET['r'],'Surplus_User_Manual.docx','R');
$path_style_level = $_SERVER['DOCUMENT_ROOT'].$path_style_level;
echo $path_style_level;

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
if($ratio1>$ratio2) 
{
$thumb_w=$new_w;
$thumb_h=$old_y/$ratio1;
}
else 
{
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
<title>Surplus Destruction Process(In Detailed)</title>

<style>
th,td{ color : #000;}
</style>

<div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Surplus Destruction Files Upload(Style Level/In Detailed)</b>
		<span style="float: right" class='btn btn-info btn-xs'><b><a href="<?php echo $user_manual; ?>">info ?</a></b>&nbsp;</span>
	</div>
	<div class='panel-body'>
		<?php

		$qms_des_note_no_ref=$_GET["dest"];

		echo "<h4 style='color : #000'> Destroy Note # ".$qms_des_note_no_ref."</h4>";

		$sql="SELECT qms_des_note_no,mer_month_year,qms_log_user,date(qms_des_date) as qms_date 
			FROM $bai_pro3.bai_qms_destroy_log ORDER BY qms_des_note_no=\"".$qms_des_note_no_ref."\"";
		//echo $sql;
		$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{	
			$qms_des_note_no=$sql_row["qms_des_note_no"];
			$mer_month_year=$sql_row["mer_month_year"];
			$qms_des_date=$sql_row["qms_date"];
			$qms_log_user=$sql_row["qms_log_user"];
		}

		$sql2="select * from $bai_pack.upload_dest_summary where dest=\"".$qms_des_note_no_ref."\"";
		$sql_result_2=mysqli_query($link, $sql2) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
		$count=mysqli_num_rows($sql_result_2);

		$sql1="SELECT COUNT(DISTINCT remarks) AS ctn,sum(qms_qty) as qty FROM $bai_pro3.bai_qms_db WHERE location_id=\"DESTROYED-DEST#".$qms_des_note_no_ref."\"";
		//echo $sql1."<br>";
		$sql_result1=mysqli_query($link, $sql1) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$carton_count=$sql_row1["ctn"];
			$carton_qty=$sql_row1["qty"];
		}

		?>
		<div class='col-sm-6'>
			<font color="red">Note: Upload Files of JPEG, JPG and PNG formats with a Maximum size of 10MB</font><br><br>
		<form method="post" enctype="multipart/form-data">
			<table class='table'>
			<tr>
				<th>Prior to Destruction</th>
				<td><input type="hidden" name="MAX_FILE_SIZE" value="20000000">
					<input class='btn btn-info btn-xs ' name="userfile" type="file" accept="image/*" required id="userfile">
				</td>
			</tr>
			<tr>
				<th>While Destruction</th>
				<td>
					<input type="hidden" name="MAX_FILE_SIZE1" value="20000000">
					<input class='btn btn-info btn-xs' name="userfile1" type="file" accept="image/*" required id="userfile1">
				</td>
			</tr>
			<tr>
				<th>After Destruction</th>
				<td>
					<input type="hidden" name="MAX_FILE_SIZE2" value="20000000">
					<input class='btn btn-info btn-xs ' name="userfile2" type="file" accept="image/*" required id="userfile2">
				</td>
			</tr>
			<tr>
				<th>Style Code</th>
				<td>
					<select name="style" required>
					<option value="">Select</option>
					<?php

					$sql="select distinct style_id as style_id from $bai_pro2.movex_styles where style_id > 0 order by style_id";
					$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
					// echo "<option value=''>Select</option>";
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						echo "<option value=".$sql_row["style_id"].">".$sql_row["style_id"]."</option>";
					}

					?>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input class='btn btn-success' name="upload" type="submit" class="box" id="upload" value="Upload"></td>
			</tr>
		</table>
	</form>
	</div>
</div>

<?php
if(isset($_POST['upload']))
{
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

	$style=$_POST["style"];

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
		// if it is not empty
		if($image)
		{
			// get the original name of the file from the clients machine
			$filename = stripslashes($_FILES['userfile']['name']);
			$filename1 = stripslashes($_FILES['userfile1']['name']);
			$filename2 = stripslashes($_FILES['userfile2']['name']);
			// get the extension of the file in a lower case format
			$extension = getExtension($filename);
			$extension = strtolower($extension);

			$extension1 = getExtension($filename1);
			$extension1 = strtolower($extension1);

			$extension2 = getExtension($filename2);
			$extension2 = strtolower($extension2);

			// if it is not a known extension, we will suppose it is an error, print an error message
			//and will not upload the file, otherwise we continue
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "JPG") && ($extension != "JPEG") && ($extension != "PNG") && ($extension1 != "jpg") && ($extension1 != "jpeg") && ($extension1 != "png") && ($extension1 != "JPG") && ($extension1 != "JPEG") && ($extension1 != "PNG") && ($extension2 != "jpg") && ($extension2 != "jpeg") && ($extension2 != "png") && ($extension2 != "JPG") && ($extension2 != "JPEG") && ($extension2 != "PNG"))
			{
				echo '<h1>Unknown extension!</h1>';
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
				$newname="".$path_style_level."/".$qms_des_note_no_ref."_".$count."_0.".$extension;
				$copied = copy($_FILES['userfile']['tmp_name'], $newname);

				$newname1="".$path_style_level."/".$qms_des_note_no_ref."_".$count."_1.".$extension1;
				$copied1 = copy($_FILES['userfile1']['tmp_name'], $newname1);

				$newname2="".$path_style_level."/".$qms_des_note_no_ref."_".$count."_2.".$extension2;
				$copied2 = copy($_FILES['userfile2']['tmp_name'], $newname2);

				//we verify if the image has been uploaded, and print error instead
				if (!$copied)
				{
					echo '<h2>Copy to images folder unsuccessfull!</h2>';
					$errors=1;
				}
				else
				{
					// the new thumbnail image will be placed in images/thumbs/ folder
					$thumb_name=''.$path_style_level.'/thumb_'.$qms_des_note_no_ref."_".$count."_0.".$extension;
					// call the function that will create the thumbnail. The function will get as parameters
					//the image name, the thumbnail name and the width and height desired for the thumbnail
					$thumb=make_thumb($newname,$thumb_name,WIDTH,HEIGHT);

					$thumb_name1=''.$path_style_level.'/thumb_'.$qms_des_note_no_ref."_".$count."_1.".$extension1;
					$thumb=make_thumb($newname1,$thumb_name1,WIDTH,HEIGHT);

					$thumb_name2=''.$path_style_level.'/thumb_'.$qms_des_note_no_ref."_".$count."_2.".$extension2;
					$thumb=make_thumb($newname2,$thumb_name2,WIDTH,HEIGHT);
				}
			}
		}

		$query = "INSERT INTO $bai_pack.upload_dest_summary (name,size,type,name1,size1,type1,name2,size2,type2,dest,style,upload_by,date) VALUES ('".$qms_des_note_no_ref."_".$count."_0.".$extension."','$fileSize','$fileType','".$qms_des_note_no_ref."_".$count."_1.".$extension1."','$fileSize1','$fileType1','".$qms_des_note_no_ref."_".$count."_2.".$extension2."','$fileSize2','$fileType2','".$_GET["dest"]."',\"".$style."\",\"".$username."\",\"".date("Y-m-d H:i:s")."\")";
		//echo $query;
	}
	else
	{
		$query = "INSERT INTO $bai_pack.upload_dest_summary (name,size,type,name1,size1,type1,name2,size2,type2,dest,style,upload_by,date) VALUES ('".$qms_des_note_no_ref."_".$count."_0.".$extension."','$fileSize','$fileType','".$qms_des_note_no_ref."_".$count."_1.".$extension1."','$fileSize1','$fileType1','".$qms_des_note_no_ref."_".$count."_2.".$extension2."','$fileSize2','$fileType2','".$_GET["dest"]."',\"".$style."\",\"".$username."\",\"".date("Y-m-d H:i:s")."\")";
		//echo $query;
	}

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
		// echo "<br>File uploaded Successfully<br>";
		echo '<div class="alert alert-success">
			  <strong>Success!</strong> Files Uploaded Successfully
			</div>';
			// die();
		$url = $_GET['r'];
		// echo $url;
		echo "<script language=\"javascript\"> 
				setTimeout(\"CloseWindow()\",5000); 
				function CloseWindow()
				{ 
					window.close(); 
				} </script>";
	}
}
?>	
