<?php
$file_formats = array("jpg", "png", "gif", "bmp"); // Set File format
$filepath = "uploads/";

if ($_POST['submitbtn']=="Submit") {
  $name = $_FILES['file']['name'];
  $size = $_FILES['file']['size'];

   if (strlen($name)) {
      $extension = substr($name, strrpos($name, '.')+1);
      if (in_array($extension, $file_formats)) { 
          if ($size < (2048 * 1024)) {
             $imagename = md5(uniqid().time()).".".$extension;
             $tmp = $_FILES['file']['tmp_name'];
             if (move_uploaded_file($tmp, $filepath . $imagename)) {
		 echo '<img class="preview" alt="" src="'.$filepath.'/'. 
			$imagename .'" />';
	     } else {
		 echo "Could not move the file.";
	     }
	  } else {
		echo "Your image size is bigger than 2MB.";
	  }
       } else {
	       echo "Invalid file format.";
       }
  } else {
       echo "Please select image..!";
  }
exit();
}

?>