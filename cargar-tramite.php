<?php  
session_start();
if (!isset($_SESSION['documento'])) {
  header('Location: isMW.php');
}
else{
  $documento = $_SESSION['documento'];
}

include("conexion.php");
include('funciones.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$tramite = mysqli_real_escape_string($conexion,(strip_tags($_POST["tramite"],ENT_QUOTES)));

$resultArray = titularCargas($documento);
$data = datosTitular($resultArray); //Obtengo datos titular
$nombreAfiliado = $data['nombre'];
$apellidoAfiliado = $data['apellido'];
$emailAfiliado = $data['email2'];

//empty-Determina si una variable está vacía
//isset-determina si una variable ha sido declarada y su valor no es NULO
if($tramite=="ACTUALIZACION DE DATOS"){

   $apellido = mb_strtoupper(mysqli_real_escape_string($conexion,(strip_tags($_POST["apellido"],ENT_QUOTES))));
   $nombre = mb_strtoupper(mysqli_real_escape_string($conexion,(strip_tags($_POST["nombre"],ENT_QUOTES))));
   
   if(!$_POST["cuil"]){
    $cuil=0;
    }
    else{
      $cuil = mysqli_real_escape_string($conexion,(strip_tags($_POST["cuil"],ENT_QUOTES)));
    }

    if(!$_POST["fechanacimiento"]){
    $fechaNacimiento='0000-00-00';
    }
    else{
      $fechaNacimiento = mysqli_real_escape_string($conexion,(strip_tags($_POST["fechanacimiento"],ENT_QUOTES)));
    }

    if(!$_POST["legajo"]){
    $legajo='0';
    }
    else{
      $legajo = mysqli_real_escape_string($conexion,(strip_tags($_POST["legajo"],ENT_QUOTES)));
    }
   
   $localidad = mysqli_real_escape_string($conexion,(strip_tags($_POST["localidad"],ENT_QUOTES)));
   $domicilio = mb_strtoupper(mysqli_real_escape_string($conexion,(strip_tags($_POST["domicilio"],ENT_QUOTES))));
   $celular = mb_strtoupper(mysqli_real_escape_string($conexion,(strip_tags($_POST["celular"],ENT_QUOTES))));
   $comentario = mb_strtoupper(mysqli_real_escape_string($conexion,(strip_tags($_POST["comentario"],ENT_QUOTES))));

   //echo $apellido." - ".$nombre." - ".$cuil." - ".$fechaNacimiento." - ".$localidad." - ".$domicilio." - ".$legajo." - ".$comentario;

   $insert = mysqli_query($conexion,"INSERT INTO tramites_dos(documento, apellido, nombre, cuil, fecha_nacimiento, localidad, domicilio, legajo, celular, comentario) VALUES('$documento', '$apellido', '$nombre', '$cuil', '$fechaNacimiento', '$localidad', '$domicilio', '$legajo', '$celular', '$comentario')");

    //MANDO EMAIL AL AFILIADO
    if($insert){
      //Obtengo el id_tramite que le va a tocar a este tramite
        $consulta = "SELECT COUNT(*) total FROM tramites_dos";
        $result = mysqli_query($conexion, $consulta);
        $fila  = mysqli_fetch_assoc($result);
        $id_tramite = $fila['total'];

        $salida1 = enviarmaildelegacion($id_tramite, $documento, $tramite, "NEUQUEN CAPITAL"); //Devuelve V o F
        if($salida1){//SE MANDO MAIL A LA SEDE CENTRAL - afiliaciones, info, sistemas y AFILIADO
          //echo json_encode(array('mensaje' => "Trámite generado con éxito"."<br />"."Revise su email", 'salida' => '0'));
          echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 28px; font-family: Georgia, cursive;">TRÁMITE GENERADO CON EXITO</span><br><span style="color:black; font-size: 20px; font-family: Georgia, cursive;">Se envio comprobante a su email<br>Puede verlo en el menú en MI CUENTA<br>Puede ser que ingrese como Spam</span></p>', 'salida' => '0')); //tramite1
        }
        else{//No se pudo enviar mail al afiliado
          echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 28px; font-family: Georgia, cursive;">TRÁMITE GENERADO CON EXITO</span><br><span style="color:black; font-size: 20px; font-family: Georgia, cursive;">No se pudo enviar comprobante a su email<br>Puede verlo en el menú en MI CUENTA</span></p>', 'salida' => '0')); //tramite2
        }
    }else{ //insert
        echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 28px; font-family: Georgia, cursive;">ERROR AL GENERAR EL TRÁMITE</span><br><span style="color:black; font-size: 20px; font-family: Georgia, cursive;">Intente hacerlo nuevamente o mas tarde</span></p>', 'salida' => '1')); //tramite3

        //echo json_encode(array('mensaje' => "Error en la insercion de datos ".mysqli_error($conexion), 'salida' => '1'));
      }
}
else{ //Demas tramites
  $delegacion = mysqli_real_escape_string($conexion,(strip_tags($_POST["delegacion"],ENT_QUOTES)));
  $comentario = mb_strtoupper(mysqli_real_escape_string($conexion,(strip_tags(mb_strtoupper($_POST["comentario"]),ENT_QUOTES))));

  $insert = mysqli_query($conexion,"INSERT INTO tramites_uno(documento, tramite, delegacion, comentario) VALUES('$documento', '$tramite', '$delegacion', '$comentario')");

  if($insert){
    //Obtengo el id_tramite que le va a tocar a este tramite
    $sql3 = "SELECT COUNT(*) total FROM tramites_uno";
    $result = mysqli_query($conexion, $sql3);
    $fila  = mysqli_fetch_assoc($result);
    $id_tramite = $fila['total'];

    $salida = enviarmaildelegacion($id_tramite, $documento, $tramite, $delegacion); //Devuelve V o F
      if($salida){
        echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 28px; font-family: Georgia, cursive;">TRÁMITE GENERADO CON EXITO</span><br><span style="color:black; font-size: 20px; font-family: Georgia, cursive;">Se envio comprobante a su email<br>Puede verlo en el menú en MI CUENTA<br>Puede ser que ingrese como Spam</span></p>', 'salida' => '0')); //tramite1
      }
      else{
        echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 28px; font-family: Georgia, cursive;">TRÁMITE GENERADO CON EXITO</span><br><span style="color:black; font-size: 20px; font-family: Georgia, cursive;">No se pudo enviar comprobante a su email<br>Puede verlo en el menú en MI CUENTA</span></p>', 'salida' => '0')); //tramite2
      }
  }else{ //insert
    echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 28px; font-family: Georgia, cursive;">ERROR AL GENERAR EL TRÁMITE</span><br><span style="color:black; font-size: 20px; font-family: Georgia, cursive;">Intente hacerlo nuevamente o mas tarde</span></p>', 'salida' => '1')); //tramite3
  }
}
 

//busco al usuario para poder obtener su email
/*$sql2 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE documento='$documento'");
$usuario = $sql2->num_rows;
$data1 = mysqli_fetch_assoc($sql2);
$emailUsuario= $data1['email'];*/
/*
$resultArray = titularCargas($documento);
$data = datosTitular($resultArray); //Obtengo datos titular
$nombreAfiliado = $data['nombre'];
$apellidoAfiliado = $data['apellido'];
$emailAfiliado = $data['email2'];

*/

//para enviar a la delegacion y afiliado
function enviarmaildelegacion($id_tramite, $documento, $tramite, $delegacion){
  $resultArray = titularCargas($documento);
  $data = datosTitular($resultArray); //Obtengo datos titular
  $nombreAfiliado = $data['nombre'];
  $apellidoAfiliado = $data['apellido'];
  $emailAfiliado = $data['email2'];
  $mail = new PHPMailer(true);

    try {
      if($tramite == "ACTUALIZACION DE DATOS"){
        $to = emailsActualizacion($emailAfiliado);
      }
      else{
        $to = emails($tramite, $delegacion, $emailAfiliado);
      }
      
      //to = [$emailAfiliado]; //Irian los emails donde llega actualizacion de datos y la del afiliado
      //Para enviar mail desde localhost
      $mail->SMTPOptions = array(
      'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
      )
      );
      $mail->SMTPDebug = 0;                   
      $mail->isSMTP();                                            
      $mail->Host = 'smtp.gmail.com';                    
      $mail->SMTPAuth = true;                                   
      $mail->Username = 'mutualpolicialneuquen@gmail.com';                   
      //$mail->Password = 'Mutual123456';
      $mail->Password = 'eamhrrgvwikmhvfk'; //Contraseña de aplicacion                          
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      $mail->setFrom('mutualpolicialneuquen@gmail.com', 'Mutual Policial');
      foreach($to as $emails) {
            $mail->addAddress($emails);
      } 
      $mail->isHTML(true);
      $mail->CharSet = "UTF-8";
      $mail->Subject = 'Solicitud de trámite';
      $mensaje = generarmensajedelegacion($documento, $apellidoAfiliado, $nombreAfiliado, $id_tramite, $tramite);
      $mail->Body = $mensaje;

      if(($tramite!="ASISTENCIAL")&&($tramite!="REINTEGRO")&&($tramite!="SUBSIDIO SOLIDARIO MUTUAL")&&($tramite!="EDUCACION-BECAS")&&($tramite!="TURISMO")&&($tramite!="CONSULTA GENERAL")&&($tramite!="SOLICITUD DE TURNO")){

         $cantidad = count(array_filter($_FILES['archivo']['name']));
          if($cantidad>0){
            $fsize = 0; 
            for ($i = 0; $i <= $cantidad - 1; $i++) { 
              $mail->AddAttachment($_FILES['archivo']['tmp_name'][$i], $_FILES['archivo']['name'][$i]);
            }
          }
      }


      $mail->send();
      return true;
    }catch (Exception $e) {
      return false;
    }
}

function generarmensajedelegacion($documento, $apellidoAfiliado, $nombreAfiliado, $id_tramite, $tramite){
  
  if($tramite=='ACTUALIZACION DE DATOS'){
      $datatramite = tramitesDos($id_tramite);
      $tramite = $datatramite['tramite'];
      $apellido = $datatramite['apellido'];
      $nombre = $datatramite['nombre'];
      $cuil = $datatramite['cuil'];
      $fechaNacimiento = $datatramite['fecha_nacimiento'];
      $localidad = $datatramite['localidad'];
      $domicilio = $datatramite['domicilio'];
      $legajo = $datatramite['legajo'];
      $celular = $datatramite['celular'];
      $comentario = $datatramite['comentario'];
      $fecha = $datatramite['fecha'];

    $mensaje = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title></head><body>
    <div id="email" style="background: #003366; width: 820px; margin-left: auto; margin-right: auto;">
    <br>
    <img src="https://tramitesonline.mppneuquen.com.ar/imagenes/logoRecuperacion2.jpg" style="margin-left: auto;margin-right: auto;display: block;">
    <p style="color:white; text-align: center; font-size: 20px; font-family: Georgia, cursive;">Solicitud de ACTUALIZACI&Oacute;N DE DATOS</p>
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Documento: '.$documento.'</p>
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Id de tramite: '.$id_tramite.'</p>
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Apellido: '.$apellidoAfiliado.'</p>
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Nombre: '.$nombreAfiliado.'</p>
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Fecha y hora: '.$fecha.'</p>
    <p style="color:red; text-align: center; font-size: 18px; font-family: Georgia, cursive; text-decoration-line: underline;">DATOS A ACTUALIZAR</p>';

    if($apellido!=''){
      $mensaje = $mensaje.'<p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Apellido: '.$apellido.'</p>';
    }
    
    if($nombre!=''){
    $mensaje = $mensaje. '<p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Nombre: '.$nombre.'</p>';
    }

    if($cuil!='0'){
    $mensaje = $mensaje. '<p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Cuil: '.$cuil.'</p>';
    }

    if($fechaNacimiento!='0000-00-00'){
    $mensaje = $mensaje. '<p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Fecha de nacimiento: '.$fechaNacimiento.'</p>';
    }

    if($localidad!=''){
    $mensaje = $mensaje. '<p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Localidad: '.$localidad.'</p>';
    }

    if($domicilio!=''){
    $mensaje = $mensaje. '<p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Domicilio: '.$domicilio.'</p>';
    }

    if($legajo!='0'){
    $mensaje = $mensaje. '<p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Legajo: '.$legajo.'</p>';
    }

    if($celular!=''){
    $mensaje = $mensaje. '<p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Celular: '.$celular.'</p>';
    }

    $mensaje = $mensaje. '<p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Comentario: '.$comentario.'</p>';

    $mensaje = $mensaje. '<p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Puede ingresar al sistema en el siguiente enlace:<br><a href="http://mutualweb.mppneuquen.com.ar:8081/mutualweb/" style="text-decoration:none; font-size: 22px; color:#85C1E9; target="_blank"">INGRESAR</a></p>';

    $mensaje = $mensaje. '<h3 style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive;">Ante cualquier consulta escribanos a nuestro contacto</h3>
      <p style="text-align: center";><a style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive; text-decoration: none;" href="soporte@mppneuquen.com.ar" target="_blank">soporte@mppneuquen.com.ar</a></p>
      <br>
      <p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Por favor, no responder este email.</p><br>
    </div></body></html>';
  }
  else{
      $datatramite = tramitesUno($id_tramite);
      $delegacion = $datatramite['delegacion'];
      $comentario = $datatramite['comentario'];
      $fecha = $datatramite['fecha'];

      $mensaje = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title></head><body>
      <div id="email" style="background: #003366; width: 820px; margin-left: auto; margin-right: auto;">
      <br>
      <img src="https://tramitesonline.mppneuquen.com.ar/imagenes/logoRecuperacion2.jpg" style="margin-left: auto;margin-right: auto;display: block;">
      <p style="color:white; text-align: center; font-size: 20px; font-family: Georgia, cursive;">Solicitud de TR&Aacute;MITES VARIOS</p>
      <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Tramite: '.$tramite.'</p>
      <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Id de tramite: '.$id_tramite.'</p>
      <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Documento: '.$documento.'</p>
      <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Apellido: '.$apellidoAfiliado.'</p>
      <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Nombre: '.$nombreAfiliado.'</p>
      <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Fecha y hora: '.$fecha.'</p>
      <p style="color:red; text-align: center; font-size: 18px; font-family: Georgia, cursive; text-decoration-line: underline;">DATOS ENVIADOS</p>
      <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Delegacion: '.$delegacion.'</p>
      <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Delegacion: '.$comentario.'</p>
      <p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Puede ingresar al sistema en el siguiente enlace:<br><a href="http://mutualweb.mppneuquen.com.ar:8081/mutualweb/" style="text-decoration:none; font-size: 22px; color:#85C1E9; target="_blank"">INGRESAR</a></p>
      
      <h3 style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive;">Ante cualquier consulta escribanos a nuestro contacto</h3>
      
      <p style="text-align: center";><a style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive; text-decoration: none;" href="soporte@mppneuquen.com.ar" target="_blank">soporte@mppneuquen.com.ar</a></p>
      <br>
      
      <p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Por favor, no responder este email.</p><br>
    </div></body></html>';
  }

  return $mensaje;
}


function emailsActualizacion($emailAfiliado){
  //$to = ["sistemas@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "afiliaciones@mppneuquen.com.ar", "info@mppneuquen.com.ar", "$emailAfiliado"];
  $to = ["mutualpolicialneuquen@gmail.com"];
  return $to;
}

//Funcion para obtner los emails a donde enviar el tramite
function emails($tramite, $delegacion, $emailAfiliado){
  //$to = ["sistemas@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com"];
  $to = ["mutualpolicialneuquen@gmail.com"];
  /*
  if($tramite === "CONSULTA"){
    $to = ["info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
  }
  elseif($tramite === "TURISMO"){
    $to = ["turismo@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
  }
  elseif($tramite === "EDUCACION-BECAS"){
    $to = ["educacion@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
  }
  elseif($delegacion === "NEUQUEN CAPITAL"){          
    $to = ["mesadeentrada@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
  }
  else{ //DELEGACIONES
    if($delegacion === "ALUMINE"){
      $to = ["alumine@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
    }
    elseif($delegacion === "CENTENARIO"){
      $to = ["centenario@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
    }
    elseif($delegacion === "CHOS MALAL"){
      $to = ["chosmalal@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
    }
    elseif($delegacion === "CUTRAL CO"){
      $to = ["cutralcosum@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
    }
    elseif($delegacion === "EL CHOLAR"){
      $to = ["elcholar@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
    }
    elseif($delegacion === "JUNIN DE LOS ANDES"){
      $to = ["junin@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
    }
    elseif($delegacion === "LAS GRUTAS"){
      $to = ["lasgrutas@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
    }
    elseif($delegacion === "LAS LAJAS"){
      $to = ["laslajas@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
    }
    elseif($delegacion === "LONCOPUE"){
      $to = ["loncopue@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
    }
    elseif($delegacion === "PICUN LEUFU"){
      $to = ["picunleufu@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
    }
    elseif($delegacion === "PLOTTIER"){
      $to = ["plottier@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
    }
    elseif($delegacion === "SAN MARTIN DE LOS ANDES"){
      $to = ["sanmartin@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
    }
    elseif($delegacion === "VILLA LA ANGOSTURA"){
          $to = ["vla@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
    }
    else{ //($delegacion === "ZAPALA")
      $to = ["zapala@mppneuquen.com.ar", "info@mppneuquen.com.ar", "mutualpolicialneuquen@gmail.com", "$emailAfiliado"];
    }
  }*/
  return $to;
 }



//NO SE USA

//para enviar mail al afiliado
function enviarmail($id_tramite, $documento){
  $datatramite = tramitesDos($id_tramite);
  $tramite = $datatramite['tramite'];

  $resultArray = titularCargas($documento);
  $data = datosTitular($resultArray); //Obtengo datos titular
  $nombreAfiliado = $data['nombre'];
  $apellidoAfiliado = $data['apellido'];
  $emailAfiliado = $data['email2'];

  $mail = new PHPMailer(true);
    try {
      $to = [$emailAfiliado];
      //Para enviar mail desde localhost
      $mail->SMTPOptions = array(
      'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
      )
      );
      $mail->SMTPDebug = 0;                   
      $mail->isSMTP();                                            
      $mail->Host = 'smtp.gmail.com';                    
      $mail->SMTPAuth = true;                                   
      $mail->Username = 'mutualpolicialneuquen@gmail.com';                   
      //$mail->Password = 'Mutual123456';
      $mail->Password = 'pxlmpkszpvzzkztb'; //Contraseña de aplicacion                          
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      $mail->setFrom('mutualpolicialneuquen@gmail.com', 'Mutual Policial');
      foreach($to as $emails) {
            $mail->addAddress($emails);
      } 
      $mail->isHTML(true);
      $mail->CharSet = "UTF-8";
      $mail->Subject = 'Solicitud de trámite';
      $mensaje = generarmensajetramite($apellidoAfiliado, $nombreAfiliado, $tramite, $id_tramite);
      $mail->Body = $mensaje;
      $mail->send();
      return true;
    }catch (Exception $e) {
      return false;
    }
}

function generarmensajetramite($apellidoAfiliado, $nombreAfiliado, $tramite, $id_tramite){
  $fecha = obtenerfecha();
  $mensaje = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title></head><body>
    <div id="email" style="background: #003366; width: 820px; margin-left: auto; margin-right: auto;">
    <br>
    <img src="https://tramitesonline.mppneuquen.com.ar/imagenes/logoRecuperacion2.jpg" style="margin-left: auto;margin-right: auto;display: block;">
    <p style="color:white; text-align: center; font-size: 20px; font-family: Georgia, cursive;">SOLICITUD DE TR&Aacute;MITE</p>
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Bienvenido '.$apellidoAfiliado." ".$nombreAfiliado.'</p>
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Inicio de tramite: '.$tramite.'</p>
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Id de tramite: '.$id_tramite.'</p>
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Fecha y hora: '.$fecha.'</p>

    <p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Puede ingresar al sistema en el siguiente enlace:<br><a href="http://mutualweb.mppneuquen.com.ar:8081/mutualweb/" style="text-decoration:none; font-size: 22px; color:#85C1E9; target="_blank"">INGRESAR</a></p>

    <h4 style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive;">Ante cualquier consulta escribir a <a href="soporte@mppneuquen.com.ar" style="color: white; text-decoration: none;">soporte@mppneuquen.com.ar</a></h4>
    <br>
    </div></body></html>';
  return $mensaje;
}
?>






		