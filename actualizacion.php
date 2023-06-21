<?php
session_start();
if (!isset($_SESSION['documento'])) {
  header('Location: isMW.php');
}
else{
  $documento = $_SESSION['documento'];
}

include("conexion.php");
include("funciones.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

/* EN EL SERVIDOR
require '/var/www/html/mutualweb/PHPMailer/src/Exception.php';
require '/var/www/html/mutualweb/PHPMailer/src/PHPMailer.php';
require '/var/www/html/mutualweb/PHPMailer/src/SMTP.php';
*/

$clave = mysqli_real_escape_string($conexion,(strip_tags($_POST["clave"],ENT_QUOTES)));
$clave = password_hash($clave, PASSWORD_DEFAULT);

//busco al usuario
$query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE documento='$documento'");
$usuario = $query->num_rows;

$salida = estaconectado();//Verifica si hay conexion con el servidor 192.168.0.5, asi puedo usar las funciones
if(!$salida){
  echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">PROBLEMAS DE CONEXIÓN</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Intente nuevamente o más tarde</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));
}
else{
$resultArray = titularCargas($documento);
$data = datosTitular($resultArray); //Obtengo datos titular
$nombreAfiliado = $data['nombre'];
$apellidoAfiliado = $data['apellido'];

	//Obtengo email del usuario
	$data1 = mysqli_fetch_assoc($query);
	$emailUsuario= $data1['email'];

	//Actualizo clave del usuario
	$sql ="UPDATE usuarios SET clave='$clave' WHERE documento='$documento'";
  $actualizar = mysqli_query($conexion, $sql);

  if($actualizar){
    enviarmail($documento, $apellidoAfiliado, $nombreAfiliado, $emailUsuario);
  }
  else{ //No se actualizo la tabla usuarios de la base de datos

    $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'ACTUALIZACION', '25', '$emailUsuario')");

  	echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE ACTUALIZACIÓN</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No se pudo actualizar su contraseña<br>Intente nuevamente o mas tarde</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));//actualizacion3
  }
}


function enviarmail($documento, $apellidoAfiliado, $nombreAfiliado, $emailAfiliado){
  include("conexion.php");
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
      $mail->Subject = 'Actualización de contraseña';
      $mensaje = generarmensaje($apellidoAfiliado, $nombreAfiliado);
      $mail->Body = $mensaje;
      $mail->send();
      //return true;

      $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'ACTUALIZACION', '23', '$emailAfiliado')");
      echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 28px; font-family: Georgia, cursive;">CONTRASEÑA ACTUALIZADA</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Se envió comprobante a su email<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '0')); //actual1 PROBADO
    
    }catch (Exception $e) {
    	//return false;

      $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'ACTUALIZACION', '24', '$emailAfiliado')");
      echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 28px; font-family: Georgia, cursive;">CONTRASEÑA ACTUALIZADA</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No se pudo enviar comprobante a su email<br>Igualmente se actualizó su contraseña<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '0'));//actual2
    }
}

function generarmensaje($apellidoAfiliado, $nombreAfiliado){
  $fecha = obtenerfecha();
  $mensaje = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title></head><body>
    <div id="email" style="background: #003366; width: 820px; margin-left: auto; margin-right: auto;">
    <br>
    <img src="https://tramitesonline.mppneuquen.com.ar/imagenes/logoRecuperacion2.jpg" style="margin-left: auto;margin-right: auto;display: block;">
    
    <p style="color:white; text-align: center; font-size: 20px; font-family: Georgia, cursive;">ACTUALIZACI&Oacute;N DE CONTRASEÑA</p>
    
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Bienvenido '.$apellidoAfiliado." ".$nombreAfiliado.'</p>
    
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Su contraseña ha sido actualizada</p>
    
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Fecha y hora: '.$fecha.'</p>
    
    <p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Puede ingresar al sistema en el siguiente enlace:<br><a href="http://mutualweb.mppneuquen.com.ar:8081/mutualweb/" style="text-decoration:none; font-size: 22px; color:#85C1E9; target="_blank"">INGRESAR</a></p>

   <h3 style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive;">Ante cualquier consulta escribanos a nuestro contacto</h3>
      <p style="text-align: center";><a style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive; text-decoration: none;" href="soporte@mppneuquen.com.ar" target="_blank">soporte@mppneuquen.com.ar</a></p>
      <br>
      <p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Por favor, no responder este email.</p><br>
    </div></body></html>';
  return $mensaje;
}

?>