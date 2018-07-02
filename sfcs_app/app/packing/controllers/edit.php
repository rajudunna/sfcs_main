<?php
	include("../".getFullURL($_GET['r'], "header.php", 'R'));
	include("../".getFullURL($_GET['r'], "head.php", 'R')); 
	$permission = haspermission($_GET['r']);
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
		}
		else {
		$thumb_h=$new_h;
		$thumb_w=$old_x/$ratio2;
		}

		// we create a new image with the new dimmensions
		$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);

		// resize the big image to the new created one
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);

		// output the created image to the file. Now we will have the thumbnail into the file named by $filename
		if(!strcmp("png",$ext))
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
<?php 
	if(!in_array($edit,$permission))
	{
		header("location:maintenance.php");
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title></title>
		<meta name="" content="">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<style type="text/css" media="screen">
			/*====================================================
				- HTML Table Filter stylesheet
			=====================================================*/
			//@import "TableFilter_EN/filtergrid.css";

			/*====================================================
				- General html elements
			=====================================================*/
			body
			{ 
				margin:15px; padding:15px; border:0px solid #666;
				font-family:Trebuchet MS, Helvetica, sans-serif; font-size:88%; 
			}
			h2
			{ 
				margin-top: 50px;
			}
			caption
			{
				margin:10px 0 0 5px; padding:10px; text-align:left;
			}
			pre
			{
				font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;
			}
			.mytable1
			{
				font-size:12px;
			}
			th
			{
				background-color:#29759C; color:#FFF; padding:2px; border:1px solid #ccc;
			}
			td
			{
				padding:3px; border-bottom:0px solid #ccc; border-right:0px solid #ccc;
			}
		</style>
	</head>
	<body>
		<form method="post" enctype="multipart/form-data">
			<table width="350" border="0" cellpadding="1" cellspacing="1" class="box" style="background-color: #EEEEEE;">
				<tr>
					<th>Container</th>
					<td>
						<select name="con">
						<option value="1">Empty</option>
						<option value="2">Half</option>
						<option value="3">Full</option>
						<option value="4">Closed</option>
						<option value="5">Sealed</option>
						<option value="6">Seal #</option>
						</select>
					</td>
				</tr>
				<tr>
				</tr>
				<tr>
				</tr>
				<tr>
				</tr>
				<tr>
					<th>Seal No</th>
					<td>
						<input type="text" name="sno"/>
					</td>
				</tr>
				<tr>
				</tr>
				<tr>
					<th>Photo</th>
					<td width="246">
						<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
						<input name="userfile" type="file" id="userfile">
					</td>
				</tr>

				<tr>
				<td></td>
				<td width="80">
				<?php
					if(in_array($edit,$permission))
					{
						echo '<input name="upload" type="submit" class="box" id="upload" value="Upload"></td>';
					}
					else
					{
						echo "You are not authorized to edit";	
					}
				?>
				</tr>
			</table>
		</form>
	</body>
</html>


<?php
	//include"main.php";
	//include("main.php");

	if(isset($_POST['upload']))
	{
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
		$con=$_POST['con'];
		$sno=$_POST['sno'];

		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);

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
			if ($image)
			{
				// get the original name of the file from the clients machine
				$filename = stripslashes($_FILES['userfile']['name']);
				// get the extension of the file in a lower case format
				$extension = getExtension($filename);
				$extension = strtolower($extension);
				// if it is not a known extension, we will suppose it is an error, print an error message
				//and will not upload the file, otherwise we continue
				if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png"))
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
					$newname="images/".$fileName;
					$copied = copy($_FILES['userfile']['tmp_name'], $newname);

					//we verify if the image has been uploaded, and print error instead
					if (!$copied)
					{
						echo '<h1>Copy unsuccessfull!</h1>';
						$errors=1;
					}
					else
					{
						// the new thumbnail image will be placed in images/thumbs/ folder
						$thumb_name='images/thumb_'.$fileName;
						// call the function that will create the thumbnail. The function will get as parameters
						//the image name, the thumbnail name and the width and height desired for the thumbnail
						$thumb=make_thumb($newname,$thumb_name,WIDTH,HEIGHT);
					}
				}
			}
			if($con == 1)
			{
				$query = "update upload set name='$fileName',size='$fileSize',type='$fileType' where sealno='$sno'";
				mysqli_query($GLOBALS["___mysqli_ston"], $query) or die('Error, query failed');
			}

			else if($con == 2)
			{
				$query = "update upload set name1='$fileName',size1='$fileSize',type1='$fileType' where sealno='$sno'";
				mysqli_query($GLOBALS["___mysqli_ston"], $query) or die('Error, query failed');
			}

			else if($con == 3)
			{
				$query = "update upload set name2='$fileName',size2='$fileSize',type2='$fileType' where sealno='$sno'";
				mysqli_query($GLOBALS["___mysqli_ston"], $query) or die('Error, query failed');
			}

			else if($con == 4)
			{
				$query = "update upload set name3='$fileName',size3='$fileSize',type3='$fileType' where sealno='$sno'";
				mysqli_query($GLOBALS["___mysqli_ston"], $query) or die('Error, query failed');
			}

			else if($con == 5)
			{
				$query = "update upload set name4='$fileName',size4='$fileSize',type4='$fileType' where sealno='$sno'";
				mysqli_query($GLOBALS["___mysqli_ston"], $query) or die('Error, query failed');
			}

			else if($con == 6)
			{
				$query = "update upload set name5='$fileName',size5='$fileSize',type5='$fileType' where sealno='$sno'";
				mysqli_query($GLOBALS["___mysqli_ston"], $query) or die('Error, query failed');
			}
			//echo $query;
			mysqli_query($GLOBALS["___mysqli_ston"], $query) or die('Error, query failed');
		}
		else
		{
			//$query = "INSERT INTO upload(name,size,type,content,name1,size1,type1,content1,name2,size2,type2,content2,name3,size3,type3,content3,container,vecno,sealno,dat,carton,user)"."VALUES ('$fileName','$fileSize','$fileType','$content','$fileName1','$fileSize1','$fileType1','$content1','$fileName2','$fileSize2','$fileType2','$content2','$fileName3','$fileSize3','$fileType3','$content3','$con','$vno','$sno','$date','$cno','$user')";
			//Please mention the clear details
		}
		echo "<br>File uploaded Successfully<br>";
	}
?>	
