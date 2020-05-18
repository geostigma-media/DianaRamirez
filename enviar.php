<?php
    header('Access-Control-Allow-Origin: *');
    require_once('PHPMailer/PHPMailerAutoload.php');
   
    if($_POST) {
    	$mail = new PHPMailer(true);
    	$mail->CharSet = "UTF-8";
		
		$mail->IsSMTP();
		$mail->Host = "smtp.gmail.com";
		$mail->SMTPAuth = true; 
		$mail->Username = "noreply@geostigmamedia.com";
		$mail->Password = "3n14c1976*";
		$mail->SMTPSecure = 'tls';                                  
		$mail->Port       = 587;    

	    $nombre = $_POST["nombre"];
	    $correo = $_POST["correo"];
		$mail->addReplyTo($correo, $nombre);
	   	$mail->From = $correo;
		$mail->FromName = $nombre;
	    $address = "dcrsalazar@gmail.com";
	   
	    $mail->addAddress($address, "dcrsalazar");

	
    	$mail->Subject = "Formulario desde la pagína";
	    
		
	    $mensaje = "<div style='color:#333'>";
	    $mensaje .= "<h2 style='color:#666'>Datos de contacto</h2>";
	    foreach ($_POST as $key => $value) 
	    {
			if($key == "servicios") 
			{
	    		$servicios = $value;
	    		$mensaje .= "<h3>Servicios solicitados</h3>";
	    		$mensaje .= "<ul>";
	    		foreach ($servicios as $servicio) {
	    			$mensaje .= "<li>$servicio</li>";
	    		}
	    		$mensaje .= "</ul>";
	    	}
	    	else {
	    		$mensaje .= "<strong>" . mb_convert_case($key, MB_CASE_TITLE, "UTF-8") . ":</strong> " . $value . "<br>";
	    	}
	
	    }
	    $mensaje .= "</div>";


	    $mail->MsgHTML($mensaje);

	    if(!$mail->send()) {
	        echo "no se envio el msj";

	    } else {
			echo "msj enviado satisfactoriamente";	       
	    }

    }

    ?>