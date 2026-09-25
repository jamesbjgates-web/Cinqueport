<?php
$recipient = "hello@cinqueport.net";
if ($_SERVER["REQUEST_METHOD"] !== "POST") { http_response_code(405); exit("Method not allowed."); }
function clean($v){ return trim(str_replace(["\r","\n"]," ",$v ?? "")); }
$name=clean($_POST["name"]??"");
$company=clean($_POST["company"]??"");
$email=filter_var($_POST["email"]??"",FILTER_VALIDATE_EMAIL);
$telephone=clean($_POST["telephone"]??"");
$interest=clean($_POST["interest"]??"");
$message=trim($_POST["message"]??"");
$urgent=isset($_POST["urgent"])?"Yes":"No";
$deadline=clean($_POST["deadline"]??"");
if(!$name||!$email||!$message){ http_response_code(400); exit("Please complete your name, email address and message."); }
$subject="Cinque Port website enquiry - ".$interest;
$body="Name: $name\nCompany: $company\nEmail: $email\nTelephone: $telephone\nNature of enquiry: $interest\nUrgent/deadline: $urgent\nDeadline: $deadline\n\nWhat needs to be established:\n$message\n";
$headers="From: hello@cinqueport.net\r\nReply-To: ".$email."\r\n";
if(mail($recipient,$subject,$body,$headers)){ header("Location: thank-you.html"); exit; }
http_response_code(500);
echo "Your enquiry could not be sent. Please email hello@cinqueport.net.";
?>