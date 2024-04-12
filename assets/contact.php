<?php

// Only process POST reqeusts.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get the form fields and remove whitespace.
	$name = strip_tags(trim($_POST["name"]));
	$name = str_replace(array("\r", "\n"), array(" ", " "), $name);
	$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
	$messageKlant = trim($_POST["message"]);

	// $headers = array(
	// 	'From' => "$email"
	// );

	
	// mail($to, $subject, $message, $headers);

	// Check that data was sent to the mailer.
	if (empty($name) OR empty($messageKlant) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// Set a 400 (bad request) response code and exit.
		http_response_code(400);
		echo "Please complete the form and try again.";
		exit;
	}

	// Set the recipient email address.
	// FIXME: Update this to your desired email address.
	$recipient = "support@rubydevelopment.nl";
	$recipientNoreply = "noreply@rubydevelopment.nl";

	// Set the email subject.
	$subject = "New contact from $name";

	// Build the email content.
	$email_content = "New Email from \n$name\n";

	// Build the email headers.
	$email_headers = "$message";
	$email_contact = "Client Email: $email";

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Begin Company Email Template
	ob_start();
   	include("email-template-bedrijf.html");
   	$message = ob_get_contents();
   	ob_end_clean();
	// End Company Email Template

	// User Email Template
	ob_start();
   	include("email-template-user.html");
	//    include("email-template-bedrijf.html");
   	$messageUser = ob_get_contents();
   	ob_end_clean();

	$subjectUser = "[NOREPLY] Thank you for reaching out!";

	// mail($email, $subjectUser, $userTemplate, $headers, "-f $recipient");

	// $message .= '<h1 style="color:#f40;">Hi Jane!</h1>';
	// $message .= '<p style="color:#080;font-size:18px;">Will you marry me?</p>';
	// $message .= '</body></html>';
	
	// mail($to, $subject, $message, $headers);
	// if(mail($recipient, $subject, $message, $headers)) {
	if (mail($recipient, $subject, $message, $headers, "-f $email")) {
		if(mail($email, $subjectUser, $messageUser, $headers, "-f $recipientNoreply")) {
			// Set a 200 (okay) response code.
			http_response_code(200);
			echo "Thank You! Your message has been sent.";
		} else {
			// Set a 500 (internal server error) response code.
			http_response_code(500);
			echo "Oops! Something went wrong and we couldn't send your message.";
			}
		}
	} else {
		// Not a POST request, set a 403 (forbidden) response code.
	http_response_code(403);
	echo "There was a problem with your submission, please try again.";
}

?>




