<?php

require 'vendor/autoload.php';

function send_mail($correo,$destinatario)
{

//Create a new PHPMailer instance
$mail = new  PHPMailer\PHPMailer\PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Config UTF-8
$mail->CharSet = "utf-8";

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "tu correo gmail";

//Password to use for SMTP authentication
$mail->Password = "tu contraseña";

//Set who the message is to be sent from
$mail->setFrom('comunidadperutec@gmail.com', 'Luis Claudio');#remitente

//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');

//Set who the message is to be sent to
$mail->addAddress($correo, $destinatario);#destinatario

//Set the subject line
$mail->Subject = 'Correo de Prueba'; #asunto

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);

ob_start();
include'contents.php';
$html =  ob_get_clean();

$mail->msgHTML($html);

//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');
$mail->addAttachment('images/php.png');

//send the message, check for errors
if (!$mail->send()) {
echo "Mailer Error: " . $mail->ErrorInfo;
} 
else 
{
echo "Correo Enviado";

}


}



$conexion = new PDO("mysql:host=localhost;dbname=demo","root","",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Envio de Correos
$query     =  "SELECT * FROM user";
$statement = $conexion->prepare($query);
$statement->execute();
$result    =  $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $key => $value) {
    
send_mail($value['correo'], $value['nombres'].' '.$value['apellidos']);

}