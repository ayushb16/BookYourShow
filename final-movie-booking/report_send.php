<?php
	session_start();
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require 'C:\xampp\composer\vendor\autoload.php';
	include "connect.php";

	$mail = new PHPMailer(TRUE);

	if(isset($_POST['submit'])){

		$username = $_SESSION["user"];
		$subject = $_POST['subject'];
		$body = $_POST['message'];

		//Get email address from Database
		$sql = "SELECT `Email` FROM `registration` WHERE `Username`='$username';";

		$resultSet = $mysqli->query($sql);
		$row = $resultSet->fetch_array();

		//Only 1 row will be returned
		$email = $row['Email'];
		$resultSet->free();
		$mysqli->close();

		//Send mail
		/* Open the try/catch block. */
		try {
		/* Use SMTP. */
		$mail->isSMTP();
		/* Google (Gmail) SMTP server. */
		$mail->Host = 'smtp.gmail.com';

		/* SMTP port. */
		$mail->Port = 587;
		$mail->Username = 'youremail@gmail.com';//SMTP username

		/* Google account password for SMTP */
		$mail->Password = 'yourpassword';
		/* Set authentication. */
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls';

   		/* Set the mail sender. */
   		$mail->setFrom($email, $username);//User email address is restricted by Google Mail restriction and sets it to SMTP email
   		$mail->AddReplyTo($email, $username);//Will add user email to reply to

   		/* Add a recipient. */
   		$mail->addAddress('youremail@gmail.com', 'BookYourShowSupport');

   		/* Set the subject. */
   		$mail->Subject = $subject;

   		/* Set the mail message body. */
   		$mail->Body = $body;

   		/* Finally send the mail. */
   		$mail->send();

//***********************************************************************************************************************************************//
   		//Send an automatic reply to user saying message received
   		$mail->ClearAllRecipients();//clear all before sending auto reply
		$mail->IsHTML(true);
		$mail->setFrom('youremail@gmail.com', "BookYourShowSupport");
   		$mail->AddReplyTo("no-reply.bookyourshow@gmail.com");

   		/* Add a recipient. */
   		$mail->addAddress($email, $username);

   		/* Set the subject. */
   		$mail->Subject = "BookYourShowSupport: Email received!";

   		/* Set the mail message body. */
   		$mail->Body = "<html>
   						<body>
   						Dear valued customer, we have received your email and we'll be replying to you shortly.<br/>
   					    Kindly note that this is an automated message.<br/> Thank you and have a nice day!
   					   </body>
   					   </html>";
   		$mail->send();
   		$mail->ClearAllRecipients();//For next
   		//Redirect
   		header("Location:report.php");
}
catch (Exception $e)
{
   /* PHPMailer exception. */
   echo $e->errorMessage();
}
catch (\Exception $e)
{
   // PHP exception 
   echo $e->getMessage();
}

}
?>