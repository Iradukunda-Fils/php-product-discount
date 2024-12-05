<?php


$title = "Kigali Universe Grand Opening";
$receiverMail = "j.nyagahene@gmail.com";
$receiverName = "Joanna";

    ini_set('display_errors', 0);
    ini_set('error_reporting', E_ALL);

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
    date_default_timezone_set('Etc/UTC');

    require "PHPMailer/PHPMailerAutoload.php";

//Create a new PHPMailer instance
    $mail = new PHPMailer();

//Tell PHPMailer to use SMTP
    $mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
    $mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';

//Set the hostname of the mail server
    $mail->Host = 'business72.web-hosting.com';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 465;

//Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'ssl';

//Whether to use SMTP authentication
    $mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "info@thefinancialboutiqueltd.com";

//Password to use for SMTP authentication
    $mail->Password = "F4.w1u=gmFG}";

//Set who the message is to be sent from
    $mail->setFrom('info@thefinancialboutiqueltd.com', 'TFB');

//Set an alternative reply-to address
    $mail->addReplyTo('info@thefinancialboutiqueltd.com', 'TFB');

//Set who the message is to be sent to
    $mail->addAddress("$receiverMail", "$receiverName");

//Set the subject line
    $mail->Subject = $title;

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
    $mail->msgHTML(file_get_contents('PHPMailer/contents.html'), dirname(__FILE__));

//Replace the plain text body with one created manually
    $mail->Body = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Your QR CODE</title>
    <style>
        /* Reset CSS */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f2f2f2; /* Set document background to gray */
        }

        img {
            border: none;
            display: block;
        }

        /* Container Styles */
        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .content {

        }

        /* Logo Styles */
        .logo {
            margin-bottom: 20px;
            margin-top: 20px;
        }

        /* Title Styles */
        .title {
            font-size: 24px;
            text-align: center;
            color: #ffffff;
            background-color: #dbb546;
            padding: 30px;
        }

        .qr{
            align-content: center !important;
            align-items: center;

        }

        /* Body Styles */
        .body-content {
            font-size: 16px;
            line-height: 1.6;
            background-color: #ffffff;
            padding: 20px;
        }

        /* Footer Styles */
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
    <link href='https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap' rel='stylesheet'>
</head>
<body>
<!--<div class='container'>-->
<!--    <div class='logo'>-->
<!--        <img src='https://tarama.ai/assets/img/logo-dark.png' alt='Tarama' height='35'>-->
<!--    </div>-->
<!--</div>-->

<div class='container'>
    <div class='title'>
        KIGALI UNIVERSE GRAND OPENING
    </div>
</div>
<div class='container'>
    <div class='body-content'>
        <p>Dear Joanna,</p>
        <p>This is you invitation to KIGALI UNIVERSE GRAND OPENING</p>
        <div class='qr'>
            <center>
            <img src='https://tarama.ai/catalog/qr/Tarama82d58bd04d71f644da1600390858bb54.png' width='250'>
            </center>
        </div>
        <p>Kindly keep it confidential, it's one time use and you will be required to show it at the entrance</p>
    </div>
    <div class='footer'>
        &copy; 2024 TFB. All Rights Reserved.
    </div>
</div>
</body>
</html>

";


    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {

    }
