<?php 
//session_start();
include("conexion.php");
include("funciones.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$codigo = mysqli_real_escape_string($conexion,(strip_tags($_POST["codigo"],ENT_QUOTES)));
$email = mysqli_real_escape_string($conexion,(strip_tags($_POST["email"],ENT_QUOTES)));
$clave = mysqli_real_escape_string($conexion,(strip_tags($_POST["clave"],ENT_QUOTES)));
$clave = password_hash($clave, PASSWORD_DEFAULT);
//Busco el email ingresado en la tabla usuarios
$query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email='$email'");
$emailIngresado = $query->num_rows;


$salida = estaconectado();//Verifica si hay conexion con el servidor 192.168.0.5, asi puedo usar las funciones
if(!$salida){
  echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">PROBLEMAS DE CONEXIÓN</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Intente nuevamente o más tarde</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));
}
else{

  if($emailIngresado===0){//No se encuentra en la tabla usuarios
      $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('0', 'REESTABLECER', '26', '$email')");
      echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE EMAIL</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No se encuentra registrado<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));//reest1 PROBADO
  }
  else{//Se encuentra en la tabla usuarios- ESTA REGISTRADO
    //$data = mysqli_fetch_array($query);
    $data = mysqli_fetch_assoc($query);
    $activadoAfiliado = $data['activo'];
    $documentoAfiliado = $data['documento'];
    $emailAfiliado = $data['email']; //Obtengo el email
    $codigo_recupero = $data['codigo_recupero']; //Obtengo codigo recupero
    $fecha_codigo_recupero = $data['fecha_codigo_recupero']; //Obtengo fecha codigo recupero

    $resultArray = titularCargas($documentoAfiliado);
    $data = datosTitular($resultArray); //Obtengo datos titular
    $nombreAfiliado = $data['nombre'];
    $apellidoAfiliado = $data['apellido'];

    if($activadoAfiliado==0){ //Verifico si NO esta activado
      //echo json_encode(array('mensaje' => "CUENTA NO ACTIVADA", 'salida' => '1'));
      $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documentoAfiliado', 'REESTABLECER', '27', '$email')");

      echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">CUENTA NO ACTIVADA</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Tiene que activar su cuenta<br></span><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reest2 PROBADO
    }
    else{
      if($codigo_recupero!=null){

        //La cuenta esta activada-Verifico si los codigos coinciden
        if($codigo!=$codigo_recupero){//Los codigos NO coinciden

          $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documentoAfiliado', 'REESTABLECER', '28', '$email')");

          echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE CÓDIGO</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No coincide con el enviado a su email<br>Intente nuevamente con el código correcto</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reest3 PROBADO
        }
        else{//Los codigos coinciden
            $diferenciafechas = diferenciafechas($fecha_codigo_recupero);
            if($diferenciafechas > 48){ //Caduco el codigo

              $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documentoAfiliado', 'REESTABLECER', '29', '$email')");

              echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">CÓDIGO CADUCADO</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">El código ingresado ya no es válido<br>Deberá recuperar la contraseña nuevamente<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reest4
            }
            else{
                activarcuenta($documentoAfiliado, $emailAfiliado, $clave, $nombreAfiliado, $apellidoAfiliado);
            }
        }
      }
      else{ //Esta registrado y activado pero nunca genero el código de recuperación
        
        $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documentoAfiliado', 'REESTABLECER', '31', '$emailAfiliado')");

        echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE CÓDIGO</span><br><span style="color:black; font-size: 20px; font-family: Georgia, cursive;">No tiene código de recuperación generado<br>Debe hacerlo en la sección del inicio<br><span style="color:red; font-size: 20px; font-family: Georgia, cursive;">¿Has olvidado tu contraseña?</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));//reest6 PROBADO
      }
    }
  }
}

function activarcuenta($documentoAfiliado, $emailAfiliado, $claveAfiliado, $nombreAfiliado, $apellidoAfiliado){
  include("conexion.php");
  //Actualizo la nueva clave ingresada
  $sentencia ="UPDATE usuarios SET clave='$claveAfiliado', codigo_recupero=null, fecha_codigo_recupero=null WHERE documento='$documentoAfiliado'";
  $actualizar = mysqli_query($conexion, $sentencia);
  if($actualizar){
    $salida = enviarmail($apellidoAfiliado, $nombreAfiliado, $emailAfiliado);
    if($salida){
      
      $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documentoAfiliado', 'REESTABLECER', '32', '$emailAfiliado')");

      echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 28px; font-family: Georgia, cursive;">CONTRASEÑA REESTABLECIDA</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Ya puede iniciar sesión con su nueva contraseña<br>Se envio comprobante a su email<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '0'));  //reest7 PROBADO
    }
    else{
      $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documentoAfiliado', 'REESTABLECER', '33', '$emailAfiliado')");
      
      echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 28px; font-family: Georgia, cursive;">CONTRASEÑA REESTABLECIDA</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Ya puede iniciar sesión con su nueva contraseña<br>No se pudo enviar el comprobante a su email<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '0')); //reest8 PROBADO
    }
  }
  else{//No se pudo actualizar la nuev clave elegida en la tabla usuarios
    $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documentoAfiliado', 'REESTABLECER', '30', '$emailAfiliado')");
    
    echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR AL REESTABLECER CONTRASEÑA</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Intente nuevamente o más tarde<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));//reest5 PROBADO
  }
}

function enviarmail($apellidoAfiliado, $nombreAfiliado, $emailAfiliado){
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
      $mail->Password = 'eamhrrgvwikmhvfk'; //Contraseña de aplicacion                          
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      $mail->setFrom('mutualpolicialneuquen@gmail.com', 'Mutual Policial');
      foreach($to as $emails) {
            $mail->addAddress($emails);
      } 
      $mail->isHTML(true);
      $mail->CharSet = "UTF-8";
      $mail->Subject = 'Activación de cuenta';
      $mensaje = generarmensaje($apellidoAfiliado, $nombreAfiliado, $emailAfiliado);
      $mail->Body = $mensaje;
      $mail->send();
      return true;
      //echo json_encode(array('mensaje' => "CUENTA REESTABLECIDA".'<br>'."Se envio comprobante a su email", 'salida' => '0'));

    }catch (Exception $e) {
      return false;
      //echo json_encode(array('mensaje' => "Error al enviar comprobante a su email".'<br>'."{$mail->ErrorInfo}".'<br>'."Igualmente su cuenta fue reestablecida", 'salida' => '1'));
    }
}

function generarmensaje($apellidoAfiliado, $nombreAfiliado, $email){
  $mensaje = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title></head><body>
    <div id="email" style="background: #003366; width: 820px; margin-left: auto; margin-right: auto;">
    <br>
    <img src="https://tramitesonline.mppneuquen.com.ar/imagenes/logoRecuperacion2.jpg" style="margin-left: auto;margin-right: auto;display: block;">
    
    <p style="color:#0072BC; text-align: center; font-size: 20px; font-family: Georgia, cursive;">CONTRASEÑA REESTABLECIDA</p>
    
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Bienvenido '.$apellidoAfiliado." ".$nombreAfiliado.'</p>
    
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Su contraseña ha sido reestablecida</p>
    
    <p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Ya puede ingresar al sistema en el siguiente enlace:<br><a href="http://mutualweb.mppneuquen.com.ar:8081/mutualweb/" style="text-decoration:none; font-size: 22px; color:#85C1E9; target="_blank"">INGRESAR</a></p>
    
    <h3 style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive;">Ante cualquier consulta escribanos a nuestro contacto</h3>
      <p style="text-align: center";><a style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive; text-decoration: none;" href="soporte@mppneuquen.com.ar" target="_blank">soporte@mppneuquen.com.ar</a></p>
      <br>
      <p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Por favor, no responder este email.</p><br>
    </div></body></html>';
  return $mensaje;
}
?>


