

<?php


// Contact subject
                $subject ='Test1';
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers

 
// Compose a simple HTML email message
$message = '<html><body>';
$message .= '<h1 style="color:#f40;">hai  </h1>';
$message .= '<p style="color:#080;font-size:18px;">How are you </p>';
$message .= '</body></html>';
// From
//$header=”from: $name <$mail_from>”;
// Enter your email address
$to ='mounisri38@gmail.com,mounikapentakota30@gmail.com';
// var_dump($to);
// var_dump($subject);
// var_dump($message);
// var_dump($headers);
// die();
if(mail($to,$subject,$message,$headers))
{
    echo "mail sent successfully";
}
else
{
    echo "mail failed";
}


?>