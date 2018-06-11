<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));        ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header.php',1,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], 'head.php',0, 'R'));?>
<script type="text/javascript" src="../../../common/js/jquery.min.js" ></script>
<script type="text/javascript" src="../../../common/js/table2CSV.js" ></script>

<?php 
	$view_access=user_acl("SFCS_0114",$username,1,$group_id_sfcs);
	//echo $image_path;
?>

<?php
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

<script type="text/javascript">
function verify_date(){
	var vno = $('#vno').val();
	
}
jQuery(document).ready(function($){
	$('#vno').keypress(function (e) {
		var regex = new RegExp("^[0-9a-zA-Z\ ]+$");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if (regex.test(str)) {
			return true;
		}
		e.preventDefault();
		return false;
	});
	
	
});
jQuery(document).ready(function($){
	$('#sno').keypress(function (e) {
		var regex = new RegExp("^[0-9a-zA-Z\ ]+$");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if (regex.test(str)) {
			return true;
		}
		e.preventDefault();
		return false;
	});
});
jQuery(document).ready(function($){
	$('#cno').keypress(function (e) {
		var regex = new RegExp("^[0-9]+$");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if (regex.test(str)) {
			return true;
		}
		e.preventDefault();
		return false;
	});
});
jQuery(document).ready(function($){
	$('#user').keypress(function (e) {
		var regex = new RegExp("^[a-zA-Z\ ]+$");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if (regex.test(str)) {
			return true;
		}
		e.preventDefault();
		return false;
	});
});
</script>

<script type="text/javascript">


function checkfun(){
var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";
var val = document.getElementById('user');
for (var i = 0; i < document.input2.user.value.length; i++) {
    if (iChars.indexOf(document.input2.user.value.charAt(i)) != -1) {
       sweetAlert('Please Enter Valid Username','','warning')
       val.value='';
        return false;
    }

}
}
</script>

<style type="text/css" media="screen">
.right{
	text-align : right;
	font-weight : bold;
	color : #000;
}
</style>
<hr>
<div class="panel panel-primary">
	<div class='panel-heading'>
			Export Details Shipment Loading Photos
	</div>
	<div class='panel-body'>
		<form method="post" name="input2" enctype="multipart/form-data" action="index.php?r=<?= $_GET['r']; ?>">
			<div class="col-sm-5">	
				<div class="row">
					<div class='col-sm-6 right'>Date : </div>
					<div class='col-sm-6'><input type="text" data-toggle='datepicker' class='form-control' required name="date" id="demo1" value="<?php  echo date("Y-m-d");  ?>"/></div>
				</div><br>
				<div class="row">
					<div class='col-sm-6 right'>Vehicle No : </div>
					<div class='col-sm-6'><input class='form-control' type="text" name="vno" id="vno" required></div>
				</div><br>
				<div class="row">
					<div class='col-sm-6 right'>Seal No : </div>
					<div class='col-sm-6'><input class='form-control' type="text" id="sno" name="sno" required></div>
				</div><br>
				<div class="row">
					<div class='col-sm-6 right'>Carton : </div>
					<div class='col-sm-6'><input class='form-control' type="text" id="cno" name="cno" required></div>
				</div><br>

				<div class="row">
					<div class='col-sm-6 right'>Uploaded By : </div>
					<div class='col-sm-6'><input class='form-control' type="text" id="user" name="user" required></div>
				</div><br>
			</div>

			<div class='col-sm-5'>	
				<div class="row">
					<div class='col-sm-6 right'>Empty Container : </div>
					<div class='col-sm-6'>
						<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
						<input required  class='form-control btn btn-primary' onchange='verify_image(this)' name="userfile" type="file"  accept="image/*" id="userfile">
					</div>
				</div><br>
				<div class="row">
					<div class='col-sm-6 right'>Half Container : </div>
					<div class='col-sm-6'>
						<input type="hidden" name="MAX_FILE_SIZE1" value="2000000">
						<input required  class='form-control btn btn-primary' onchange='verify_image(this)' name="userfile1" type="file" accept="image/*" id="userfile1">
					</div>
				</div><br>
				<div class="row">
					<div class='col-sm-6 right'>Full Container : </div>
					<div class='col-sm-6'>
						<input type="hidden" name="MAX_FILE_SIZE2" value="2000000">
						<input required  class='form-control btn btn-primary' onchange='verify_image(this)' name="userfile2"  type="file" accept="image/*" id="userfile2">
					</div>
				</div><br>
				<div class="row">
					<div class='col-sm-6 right'>Closed Container : </div>
					<div class='col-sm-6'>
						<input type="hidden" name="MAX_FILE_SIZE3" value="2000000">
						<input required  class='form-control btn btn-primary' onchange='verify_image(this)' name="userfile3" type="file" accept="image/*" id="userfile3">
					</div>
				</div><br>
				<div class="row">
					<div class='col-sm-6 right'>Sealed Container : </div>
					<div class='col-sm-6'>
						<input type="hidden" name="MAX_FILE_SIZE4" value="2000000">
						<input required  class='form-control btn btn-primary' onchange='verify_image(this)' name="userfile4" type="file"  accept="image/*" id="userfile4">
					</div>
				</div><br>
				<div class="row">
					<div class='col-sm-6 right'>Seal # : </div>
					<div class='col-sm-6'>
						<input type="hidden" name="MAX_FILE_SIZE5" value="2000000">
						<input required class='form-control btn btn-primary' onchange='verify_image(this)' name="userfile5" type="file" accept="image/*"  id="userfile5">
					</div>
				</div><br>
			</div>
			<div class="row">	
				<div class="col-sm-12">
					<div class='col-sm-offset-2 col-sm-6'>
						<input class='btn btn-success' name="upload" type="submit" class="box" id="upload" onclick="return checkfun()" value="Upload">
					</div>
				</div>
			</div>
		</form>
	</div>	
</div>	

<?php $url = getFullURLLevel($_GET['r'],'common/php/check_seal_no.php',1,'R'); ?>
<script>
	function verify_image(t){
		var id = t.id;
		id = '#'+id;
		console.log(id);
		var fileExtension = ['jpeg', 'jpg'];
		if ($.inArray($(id).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
			sweetAlert("Only formats are allowed : "+fileExtension.join(', '),'','warning');
			$(id).val('');
		}
	}	
	$('#sno').on('change',function(){
		var url = "<?php echo $url ?>";
		var sno = $(this).val();
		$.ajax({
			type:"POST",
			url:url+"?sno="+sno,
			success:function(response){
				//console.log(response.trim().length);
				var sno = response.trim();
				if(sno == 'exist'){
					sweetAlert('The Seal Number was Already Taken','Please try with another','warning');
					$('#sno').val('');
				}
			}
		})
	})
</script>

<?php

	if(isset($_POST['upload']))
	{
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
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

		$vno=$_POST['vno'];
		$sno=$_POST['sno'];
	
		$cno=$_POST['cno'];
		$date=$_POST['date'];
		$user=$_POST['user'];

		
		// echo $con;
		if (!$tmpName || !$tmpName1 || !$tmpName2 || !$tmpName3 || !$tmpName4 || !$tmpName5) {
			// echo "Please Upload All Images <br>";
			echo "<script>sweetAlert('Please Upload All Images','','info') </script>";

		} else {
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

			if(!get_magic_quotes_gpc()){
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

					// get the extension of the file in a lower case format
					$extension = getExtension($filename);
					$extension = strtolower($extension);
					// if it is not a known extension, we will suppose it is an error, print an error message
					//and will not upload the file, otherwise we continue
					if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "JPG") && ($extension != "JPEG") && ($extension != "PNG"))
					{
						echo '<h1>Unknown extension!</h1>';
						$errors=1;
					}
					else
					{
					// get the size of the image in bytes
					// $_FILES[\'image\'][\'tmp_name\'] is the temporary filename of the file in which the uploaded file was stored on the server
					$size = getimagesize($_FILES['userfile']['tmp_name']);
					$sizekb =filesize($_FILES['userfile']['tmp_name']);

					//compare the size with the maxim size we defined and print error if bigger
					if ($sizekb > MAX_SIZE*1024)
					{
					//echo '<h1>You have exceeded the size limit!</h1>';
						echo "<script>sweetAlert('File Size Exceeded','Choose low size files','error')</script>";
						$errors=1;
					}

					//we will give an unique name, for example the time in unix time format
					$image_name=time().'.'.$extension;
					//the new name will be containing the full path where will be stored (images folder)
					//$image_path = $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'images',0,'R').'/';

					$append = date('h').date('i').date('s').date('d').date('m').date('y');
					$newname = $append.'1'.$fileName;
					$copied = copy($_FILES['userfile']['tmp_name'], $newname);
				
					$newname1= $append.'2'.$fileName1;
					$copied1 = copy($_FILES['userfile1']['tmp_name'], $newname1);
				
					$newname2= $append.'3'.$fileName2;
					$copied2 = copy($_FILES['userfile2']['tmp_name'], $newname2);
				
					$newname3= $append.'4'.$fileName3;
					$copied3 = copy($_FILES['userfile3']['tmp_name'], $newname3);

					$newname4= $append.'5'.$fileName4;
					$copied4 = copy($_FILES['userfile4']['tmp_name'], $newname4);

					$newname5= $append.'6'.$fileName5;
					$copied5 = copy($_FILES['userfile5']['tmp_name'], $newname5);

					

					//we verify if the image has been uploaded, and print error instead
					if (!$copied)
					{
					echo '<h1>Copy unsuccessfull!</h1>';
					$errors=1;
					}
					else
					{
					// the new thumbnail image will be placed in images/thumbs/ folder
					//$thumb_name=$_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'images',0,'R').'/'.$newname;
					
					// call the function that will create the thumbnail. The function will get as parameters
					//the image name, the thumbnail name and the width and height desired for the thumbnail
					$thumb_name= trim($image_path.$newname);
					$thumb=make_thumb($newname,$thumb_name,WIDTH,HEIGHT);

					$thumb_name1= trim($image_path.$newname1);
					$thumb=make_thumb($newname1,$thumb_name1,WIDTH,HEIGHT);

					$thumb_name2= trim($image_path.$newname2);
					$thumb=make_thumb($newname2,$thumb_name2,WIDTH,HEIGHT);

					$thumb_name3= trim($image_path.$newname3);
					$thumb=make_thumb($newname3,$thumb_name3,WIDTH,HEIGHT);

					$thumb_name4= trim($image_path.$newname4);
					$thumb=make_thumb($newname4,$thumb_name4,WIDTH,HEIGHT);

					$thumb_name5= trim($image_path.$newname5);
					$thumb=make_thumb($newname5,$thumb_name5,WIDTH,HEIGHT);
					}} 
				}

				$query = "INSERT INTO $bai_pack.upload(name,size,type,name1,size1,type1,name2,size2,type2,name3,size3,type3,name4,size4,type4,name5,size5,type5,container,vecno,sealno,dat,carton,user) VALUES ('$newname','$fileSize','$fileType','$newname1','$fileSize1','$fileType1','$newname2','$fileSize2','$fileType2','$newname3','$fileSize3','$fileType3','$newname4','$fileSize4','$fileType4','$newname5','$fileSize5','$fileType5','1','$vno','$sno','$date','$cno','$user')";
				//echo $query;
			}	
			else
			{
				$query = "INSERT INTO $bai_pack.upload(name,size,type,name1,size1,type1,name2,size2,type2,name3,size3,type3,name4,size4,type4,name5,size5,type5,container,vecno,sealno,dat,carton,user) VALUES ('$fileName','$fileSize','$fileType','$fileName1','$fileSize1','$fileType1','$fileName2','$fileSize2','$fileType2','$fileName3','$fileSize3','$fileType3','$fileName4','$fileSize4','$fileType4','$fileName5','$fileSize5','$fileType5','1','$vno','$sno','$date','$cno','$user')";
			
			}
			// echo $query;
			if(!mysqli_query($link, $query))
			{
				echo "Error = ".mysqli_error($GLOBALS["___mysqli_ston"]);
			}

			else
			{
				echo "<script>sweetAlert('Updated Successfully','','success')</script>";
				//echo "<br><b style='color:#00FF0f'>File uploaded Successfully</b><br>";
			}
		}
	}

?>	
</div>


<?php /*
$target_path = "uploads/"; $target_path = $target_path . basename($_FILES['uploadedfile']['name']); 
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) { 
	echo "The file " . basename($_FILES['uploadedfile']['name']) . " has been uploaded"; 
}else { 
	echo "There was an error uploading the file, please try again"; 
} 
*/
?>

