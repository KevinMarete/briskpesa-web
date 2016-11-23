<?php
	require 'mailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;

	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$from = $_POST['email'];
	$message = $_POST['message'];
	$to = 'info@mobiworld.co.ke';
	$sender = 'no-reply@mobiworld.co.ke';

	$mail->isSMTP();                                      
	$mail->Host = gethostbyname('smtp.zoho.com');
	$mail->SMTPAuth = true;                              
	$mail->Username = $sender;                 
	$mail->Password = 'mob1w0rld2o16';                           
	$mail->SMTPSecure = 'tls';                           
	$mail->Port = 587;                                    

	$mail->setFrom($sender, $name);
	$mail->addAddress($to);
	$mail->addReplyTo($sender);

	$mail->isHTML(true); 

	$mail->Subject = 'Briskpesa Enquiry - '.ucwords($name);
	$mail->Body = 'Name: '.$name.'<br/>Email: '.$from.'<br/>Phone: '.$phone.'<br/>Message: '.$message;

	if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	    echo 'Message has been sent';
	}
?>
