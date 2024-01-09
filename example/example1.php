<?php
include "./graph_Token.php";
include "./graph_MailSend.php";

$token = new graph_GetToken();
$token->client_secret = 'redacted';
$token->client_id = 'redacted';
$token->tenant_id = 'redacted';


// HTML Example

$recipients = array(
    "user1@example.com",
    "user2@example.com"
);

$htmlContent = file_get_contents("test.html");
$email = new graph_sendMail();
$email->token = $token->fetch("token");
$email->sender = "user@example.com";
$email->subject = "My HTML Message";
$email->bodytype = "html";
$email->body = $htmlContent;
$email->recipients = $recipients;

echo $email->send();




// Plaintext Example 

$recipients1 = array(
    "user3@example.com"
);

$email1 = new graph_sendMail();
$email1->token = $token->fetch("token");
$email1->sender = "user@example.com";
$email1->subject = "My Plaintext Message";
$email1->bodytype = "text";
$email1->body = "Boom shacka lacka!";
$email1->recipients = $recipients1;

echo $email1->send();

?>
