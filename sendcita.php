<?php
$m=''; //for error messages
$id_event=''; //id event created 
$link_event; 
if(isset($_POST['date_start'])){
    
    date_default_timezone_set('America/Guayaquil');
    include_once 'google-api-php-client-2.2.4/vendor/autoload.php';
    header('Access-Control-Allow-Origin: *');
    require_once('PHPMailer/PHPMailerAutoload.php');
    //configurar variable de entorno / set enviroment variable
    putenv('GOOGLE_APPLICATION_CREDENTIALS=credenciales.json');

    $client = new Google_Client();
    $client->useApplicationDefaultCredentials();
    $client->setScopes(['https://www.googleapis.com/auth/calendar']);

    //define id calendario
    $id_calendar='ldv54nvhi83uk09v5s4g01r0jo@group.calendar.google.com';
    $datetime_start = new DateTime($_POST['date_start']);
    $datetime_end = new DateTime($_POST['date_start']);
    
    //aumentamos una hora a la hora inicial/ add 1 hour to start date
    $time_end = $datetime_end->add(new DateInterval('PT1H'));
    
    //datetime must be format RFC3339
    $time_start =$datetime_start->format(\DateTime::RFC3339);
    $time_end=$time_end->format(\DateTime::RFC3339);

    $nombre=(isset($_POST['nombre']));
    try{
        //instanciamos el servicio
    	 $calendarService = new Google_Service_Calendar($client);
        //parámetros para buscar eventos en el rango de las fechas del nuevo evento
        //params to search events in the given dates
        $optParams = array(
            'orderBy' => 'startTime',
            'maxResults' => 20,
            'singleEvents' => TRUE,
            'timeMin' => $time_start,
            'timeMax' => $time_end,
        );

        //obtener eventos 
        $events=$calendarService->events->listEvents($id_calendar,$optParams);
        
        //obtener número de eventos / get how many events exists in the given dates
        $cont_events=count($events->getItems());
     
        //crear evento si no hay eventos / create event only if there is no event in the given dates
        if($cont_events == 0){
          $event = new Google_Service_Calendar_Event();
          $event->setSummary('Cita con el paciente '.$nombre);
          $event->setDescription('Revisión , Tratamiento');

          //fecha inicio
          $start = new Google_Service_Calendar_EventDateTime();
          $start->setDateTime($time_start);
          $event->setStart($start);

          //fecha fin
          $end = new Google_Service_Calendar_EventDateTime();
          $end->setDateTime($time_end);
          $event->setEnd($end);
          $createdEvent = $calendarService->events->insert($id_calendar, $event);
          $id_event= $createdEvent->getId();
          $link_event= $createdEvent->gethtmlLink();
        }else{
          header("Location: https://www.youtube.com/watch?v=XZdAyB530wc");
          return;
        }
      }catch(Google_Service_Exception $gs){
      $m = json_decode($gs->getMessage());
      $m= $m->error->message;
    }catch(Exception $e){
      $m = $e->getMessage();  
    }
}

if(isset($_POST['date_start'])){
  if($id_event!=''){
     //email
    if ($_POST) {
      $nombre = $_POST['nombre'];
      $correo = $_POST['correo'];
      $telefono = $_POST['telefono'];
      $fecha_cita = $_POST['date_start'];
      $mensaje = "<h2 style='color:#cd0816'>Su cita se agendo con exito</h2>
            Fecha Envio: " . $fecha_cita . "<br><br>
            <br>
            <b> Nombre: " . $_REQUEST[ 'nombre' ] . "</b>,<br>
            <b> Telefono:" . $_REQUEST[ 'telefono' ] . "</b>,<br>
            <h3>¡Agendo una cita !</h3>
            <a href='".$link_event."'>Ver calendario</a>  
            <br>
            <br>  
            <b>NOTA:</b> Por favor, no responder a este correo automatico.";
      $mensaje .= "<div style='margin: 20px 30px; font-size: 15px; color:#333;'>";
  
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
      //$to = 'alex.geostigma@gmail.com';
      $subject = 'dcrsalazar - nuevo registro: '. $correo;
      $message = $clave;
      $mail->From = $correo;
      $mail->FromName = $nombre;
      $mail->addAddress($to, "dcrsalazar");
      $mail->Subject = $subject;
      $mail->MsgHTML( $mensaje );
      $mail->send();
      $fechaS = date( 'Y-m-d H:m:s' );
      $para = $_REQUEST[ 'correo' ];           
      $asunto = '[AMI] - ' . $_SERVER[ 'HTTP_HOST' ];
      $mensaje = "
      <html>
            <head>
            <title>:.. AMI ..:</title>
            <style>
            .linkpag{
                text-decoration:none;
                color:#39F;
            }
            </style>
            </head>
            <body>    
            <b>" . $_REQUEST[ 'nombre' ] . "</b>,<br>
            <h3>¡Su cita se agendo con exito!</h3>
            <h4>Nos pondremos en contacto contingo para validar la información!</h4>
            <br>
            <p> En la fecha y hora: ". $fecha_cita . "</p>
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
      $from = "dyegovallejob@gmail.com";
      //$from = "alex.geostigma@gmail.com";
      $fromName = "dcrsalazar";
      $subject = "La cita se agendo con exito - dcrsalazar";
      $message = $mensaje;
      $mail->From = $from;
      $mail->FromName = $fromName;
      $mail->addAddress( $para, $nombre );
      $mail->Subject = $subject;
      $mail->MsgHTML( $mensaje );
      $mail->send();
    }
  }
} 