<?php
    session_start();
    // My modifications to mailer script from:
    // http://blog.teamtreehouse.com/create-ajax-contact-form
    // Added input sanitizing to prevent injection
    var_dump($_POST);

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
        $telephone = strip_tags(trim($_POST["tel"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        // $cont_subject = trim($_POST["subject"]);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($telephone)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address. 
        // $recipient = "contact@markups.io";
        $recipient = $_SESSION['email_website'];

        // Set the email subject.
        $subject = "New contact from $name";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        // $email_content .= "Subject: $cont_subject\n";
        $email_content .= "Message:\n$message\n";
         $email_content .= "Téléphone:\n$telephone\n";

        // Build the email headers.   $bcc = 'email.notifications@1pub.net,1pubagency@gmail.com,info@akila.blog';

        // sender_mail($name_sender, $email_sender, $sujet, $message, $destination, $cc, $bcc);
        
        // $email_headers = "From: $name <$email>";
        // $email_headers = "From: Akila Web Factory <info@akila.blog> ";
        
        $email_headers = "From: $recipient" . "\r\n" . "BCC:email.notifications@1pub.net,1pubagency@gmail.com,info@akila.blog";

        // Send the email.
        if (mail('info@akila.blog', $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Merci d'avoir répondu. Votre message a été envoyé..";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
