<?php

function email_attachment($to_email, $email, $subject,$our_email_name, $our_email, $file_location, $default_filetype='application/zip'){
	$email = '<font face="arial">' . $email . '</font>';
	$fileatt = $file_location;
	// if(function_exists(mime_content_type)){
	// 	$fileatttype = mime_content_type($file_location);
	// }else{
	// 	$fileatttype = $default_filetype;;
	// }
	$fileatttype = $default_filetype;;
	$fileattname =basename($file_location);
	//prepare attachment
	$file = fopen( $fileatt, 'rb' );
	$data = fread( $file, filesize( $fileatt ) );
	fclose( $file );
	$data = chunk_split( base64_encode( $data ) );
	//create mime boundary
	$semi_rand = md5( time() );
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
	//create email  section
	$message = "This is a multi-part message in MIME format.\n\n" .
	"--{$mime_boundary}\n" .
	"Content-type: text/html; charset=us-ascii\n" .
	"Content-Transfer-Encoding: 7bit\n\n" .
	$email . "\n\n";
	 //create attachment section
	$message .= "--{$mime_boundary}\n" .
	 "Content-Type: {$fileatttype};\n" .
	 " name=\"{$fileattname}\"\n" .
	 "Content-Disposition: attachment;\n" .
	 " filename=\"{$fileattname}\"\n" .
	 "Content-Transfer-Encoding: base64\n\n" .
	 $data . "\n\n" .
	 "--{$mime_boundary}--\n";
	 //headers
	$exp=explode('@', $our_email);
	$domain = $exp[1];
	$headers = "From: $our_email_name<$our_email>" . "\n";
	$headers .= "Reply-To: $our_email"."\n";
	$headers .= "Return-Path: $our_email" . "\n";	// these two to set reply address
	$headers .= "Message-ID: <".time()."@" . $domain . ">"."\n";
	$headers .= "X-Mailer: Edmonds Commerce Email Attachment Function"."\n";		  // These two to help avoid spam-filters
	$headers .= "Date: ".date("r")."\n";
	$headers .= "MIME-Version: 1.0\n" .
					"Content-Type: multipart/mixed;\n" .
					" boundary=\"{$mime_boundary}\"";
	mail($to_email,$subject,$message, $headers, '-f ' . $our_email) or die ('<h3 style="color: red;">Mail Failed</h3>');
}


?>