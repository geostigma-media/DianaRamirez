<?php
header( 'Access-Control-Allow-Origin: *' );
require_once( 'PHPMailer/PHPMailerAutoload.php' );
if ( $_POST ) {
  $nombre = $_REQUEST[ 'nombre' ];
  $correo = $_REQUEST[ 'correo' ];
  $telefo = $_REQUEST[ 'telefono' ];
	$mensaje = $_REQUEST[ 'mensaje' ];
  $mensaje = "<h2 style='color:#cd0816'>Hay un nuevo cliente interesado</h2>";
  $mensaje .= "<div style='margin: 20px 30px; font-size: 15px; color:#333;'>";
  $mensaje .= "<p> Nombre: ".$_REQUEST[ 'nombre' ]."</p>";
  $mensaje .= "<p> Telefono: ".$_REQUEST[ 'telefono' ]."</p>";
  $mensaje .= "<p> Mensaje: ".$_REQUEST[ 'mensaje' ]."</p>";
  $mensaje .= "</div>";
  $mensaje .= "<hr><br>";
  $mail = new PHPMailer( true );
  $mail->CharSet = "UTF-8";

  $mail->IsSMTP();
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPAuth = true;
  $mail->Username = "noreply@geostigmamedia.com";
  $mail->Password = "3n14c1976*";
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  $fromName = $clave;
  $to = 'dyegovallejob@gmail.com';
  $subject = 'dcrsalazar - nuevo cliente: ' . $correo;
  $message = $clave;
  $mail->From = $correo;
  $mail->FromName = $nombre;
  $mail->addAddress( $to, "dcrsalazar" );
  $mail->Subject = $subject;
  $mail->MsgHTML( $mensaje );
  $mail->send();


  $fechaS = date( 'Y-m-d H:m:s' );
  $para = $_REQUEST[ 'correo' ];
  $asunto = '[dcrsalazar] - ' . $_SERVER[ 'HTTP_HOST' ];
	$mensaje = "
	<html>
		<head>
		<title>:.. dcrsalazar ..:</title>
		<style>
		.linkpag{
				text-decoration:none;
				color:#39F;
		}
		</style>
		</head>
		<body>    
		<b>" . $_REQUEST[ 'nombre' ] . "</b>,<br>
		<h3><strong>Gracias por escribirnos!</strong></h3>
		<br>
		En breve responderemos tu solicitud.
		<br>
		<br> 
		<b>NOTA:</b> Por favor, no responder a este correo automatico.
		</body> 
	</html>";
  $mail = new PHPMailer( true );
  $mail->CharSet = "UTF-8";
  $mail->IsSMTP();
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPAuth = true;
  $mail->Username = "noreply@geostigmamedia.com";
  $mail->Password = "3n14c1976*";
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;
  //$from = "gerencia@lectorami.com";
  $from = "dyegovallejob@gmail.com";
  $fromName = "dcrsalazar";
  $subject = "dcrsalazar";
  $message = $mensaje;
  $mail->From = $from;
  $mail->FromName = $fromName;
  $mail->addAddress( $para, $nombre );
  $mail->Subject = $subject;
  $mail->MsgHTML( $mensaje );
  $mail->send();

}