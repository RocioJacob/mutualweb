<?php 
//BASE DE USUARIOS: Donde estan los usuarios registrados para acceder al sistema web
//BASE DE AFILIADOS: Donde tenemos los datos de todos los afiliados titulares
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

$salida = estaconectado();//Verifica si hay conexion con el servidor 192.168.0.5, asi puedo usar las funciones
if(!$salida){
  echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">PROBLEMAS DE CONEXIÓN</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Intente nuevamente o más tarde</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));
}
else{
//Busco el email ingresado en la tabla usuarios
$query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email='$email'");
$emailIngresado = $query->num_rows;

if($emailIngresado===0){//No se encuentra en la tabla usuarios. Puede o no ser el que tiene el afiliado registrado en la mutual.
  //echo json_encode(array('mensaje' => "El email ingresado".'<br>'."NO esta registrado", 'salida' => '1'));
    $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('0', 'ACTIVACION', '9', '$email')");
    echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE EMAIL</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No se encuentra registrado<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));//act1 PROBADO

}
else{//Se encuentra en la tabla usuarios
  //$data = mysqli_fetch_array($query);
  $data = mysqli_fetch_assoc($query);
  $emailAfiliado = $data['email']; //Obtengo el email
  $codigoAfiliado = $data['codigo'];
  $activadoAfiliado = $data['activo'];
  $documentoAfilado = $data['documento'];
  $fechacodigo = $data['fechacodigo'];

  //Busco los datos del afiliado en AFILIADOS que no tengo en USUARIOS
  /*$query = mysqli_query($conexion, "SELECT * FROM afiliados WHERE documento LIKE '$documentoAfilado'");
  $data = mysqli_fetch_assoc($query);
  $nombreAfiliado = $data['nombre'];
  $apellidoAfiliado = $data['apellido'];*/

  $resultArray = titularCargas($documentoAfilado);
  $data = datosTitular($resultArray); //Obtengo datos titular
  $nombreAfiliado = $data['nombre'];
  $apellidoAfiliado = $data['apellido'];

  if($activadoAfiliado==1){ //Afiliado esta activado
    
    $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documentoAfilado', 'ACTIVACION', '10', '$email')");

    echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">CUENTA YA ACTIVADA</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Ya se encuentra registrado y activado<br>Puede iniciar sesi&oacuten</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));//act2
  }

  else{//La cuenta no esta activada-Verifico si los codigos coinciden
    if($codigo!=$codigoAfiliado){//Los codigos NO coinciden
      
      $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documentoAfilado', 'ACTIVACION', '11', '$email')");

      echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE CÓDIGO</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No coincide con el enviado a su email<br>Intente nuevamente con el código correcto</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));//act3 PROBADO
    }
    else{//Los codigos coinciden-Verifico si caduco o no
        $diferenciafechas = diferenciafechas($fechacodigo);
        if($diferenciafechas > 48){ //Caduco el codigo
          
          $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documentoAfilado', 'ACTIVACION', '12', '$email')");

          echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">CÓDIGO CADUCADO</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">El código ingresado ya no es válido<br>Deberá registrarse nuevamente<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));//act4 PROBADO
        }
        else{
            $salida = activarcuenta($documentoAfilado, $emailAfiliado, $clave, $nombreAfiliado, $apellidoAfiliado);
        }
    }
  }
}
}

function activarcuenta($documento, $emailAfiliado, $claveAfiliado, $nombreAfiliado, $apellidoAfiliado){
  include("conexion.php");

  $sentencia ="UPDATE usuarios SET activo='1', clave='$claveAfiliado', codigo=null, fechacodigo=null WHERE documento='$documento'";
  $actualizar = mysqli_query($conexion, $sentencia);

  if($actualizar){
    //insertar en tramites_dos el registro
    //(id, tramite, fecha, documento)

    //echo json_encode(array('mensaje' => "ESTADO ACTUALIZADO CON EXITO", 'salida' => '1'));

    //PARA EL ENVIO DE MAILS
    $mail = new PHPMailer(true);
    try {
      //$to = ["mutualpolicialneuquen@gmail.com", "sistemas@mppneuquen.com.ar", $emailAfiliado];
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
      $mail->Subject = 'Activacion de su cuenta';
      $mensaje = generarmensaje($apellidoAfiliado, $nombreAfiliado, $emailAfiliado);
      $mail->Body = $mensaje;
      $mail->send();

      $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'ACTIVACION', '13', '$emailAfiliado')");

      echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 28px; font-family: Georgia, cursive;">CUENTA ACTIVADA</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Ya puede iniciar sesión<br>Se envio comprobante a su email<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '0')); //act5 PROBADO

    }catch (Exception $e) { //Problemas para enviar mail (activo pasa a 1, y codigo y fecha codigo a null)

      $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'ACTIVACION', '14', '$emailAfiliado')");
      echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 28px; font-family: Georgia, cursive;">CUENTA ACTIVADA</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Ya puede iniciar sesión<br>No se pudo enviar el comprobante a su email<br>Igualmente su cuenta esta activada<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '0')); //act6 PROBADO
    }
  }
  else{ //Problemas con la base de datos
    $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'ACTIVACION', '15', '$emailAfiliado')");
    echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE ACTIVACIÓN</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Intente nuevamente o más tarde<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //act7 PROBADO
  }
}

function generarmensaje($apellidoAfiliado, $nombreAfiliado, $email){
  $mensaje = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title></head><body>
    <div id="email" style="background: #003366; width: 820px; margin-left: auto; margin-right: auto;">
    <br>
    <img src="https://tramitesonline.mppneuquen.com.ar/imagenes/logoRecuperacion2.jpg" style="margin-left: auto;margin-right: auto;display: block;">
    <p style="color:white; text-align: center; font-size: 20px; font-family: Georgia, cursive;">ACTIVACI&Oacute;N DE CUENTA</p>
    
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Bienvenido '.$apellidoAfiliado." ".$nombreAfiliado.'</p>
    
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Su cuenta ha sido activada</p>

    <p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Puede ingresar al sistema en el siguiente enlace:<br><a href="http://mutualweb.mppneuquen.com.ar:8081/mutualweb/" style="text-decoration:none; font-size: 22px; color:#85C1E9; target="_blank"">INGRESAR</a></p>

    <h3 style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive;">Ante cualquier consulta escribanos a nuestro contacto</h3>
    <p style="text-align: center";><a style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive; text-decoration: none;" href="soporte@mppneuquen.com.ar" target="_blank">soporte@mppneuquen.com.ar</a></p>
    <br>
      <p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Por favor, no responder este email.</p><br>
    </div></body></html>';

  return $mensaje;
}

?>


