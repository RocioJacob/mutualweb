<?php 
include("conexion.php");
include("funciones.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//$emailIngresado = mb_strtoupper($_POST['email']); //Obtengo el email ingresado en el formulario
$emailIngresado = $_POST['email'];

$salida = estaconectado();//Verifica si hay conexion con el servidor 192.168.0.5, asi puedo usar las funciones
if(!$salida){
  echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">PROBLEMAS DE CONEXIÓN</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Intente nuevamente o más tarde</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));
}
else{
$query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email = '$emailIngresado'");
$cantidad = mysqli_num_rows($query);

if($cantidad > 0){ //la cuenta esta en la tabla USUARIOS. Ya esta registrada
	$data = mysqli_fetch_array($query);
	$activo = $data['activo'];
	$documento = $data['documento'];
	
	if($activo == 0){//No esta activado

    $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'RECUPERACION', '16', '$emailIngresado')");
    echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">CUENTA NO ACTIVADA</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Tiene que activar su cuenta<br></span><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //rec1 PROBADA
	}
	else{//Existe y esta activada. genero codigo y lo mando al email
		$codigo = rand(10000,100000);//$hash = md5(rand(0,1000));
    $resultArray = titularCargas($documento);
    $data = datosTitular($resultArray); //Obtengo datos titular
    $nombreAfiliado = $data['nombre'];
    $apellidoAfiliado = $data['apellido'];
    $fecha_actual = obtenerfecha();
    
    $sentencia ="UPDATE usuarios SET codigo_recupero='$codigo', fecha_codigo_recupero='$fecha_actual' WHERE documento='$documento'";
  	$actualizar = mysqli_query($conexion, $sentencia);
  			
    if($actualizar){//Se genero el código de recuperacion y actualizó la tabla. Hay que enviarlo al email
      $salida = enviarmail($documento, $apellidoAfiliado, $nombreAfiliado, $emailIngresado, $codigo);
    }
		else{//No se actualizo la tabla usuarios con el código de recuperación
        $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'RECUPERACIÓN', '18', '$emailIngresado')");
        echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE RECUPERACION</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No se pudo generar código de<br>recuperación de su cuenta<br>Intente nuevamente o más tarde<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //rec3 PROBADO
		}
	}
}
else{
  $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('0', 'RECUPERACION', '17', '$emailIngresado')");
  echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">CUENTA NO REGISTRADA</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">La cuenta con el email ingresado<br>NO esta registrada<br></span><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //rec2 PROBADA
}
}

function enviarmail($documento, $apellidoAfiliado, $nombreAfiliado, $emailAfiliado, $codigo){
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
      $mail->Password = 'eamhrrgvwikmhvfk'; //Contraseña de aplicacion                          
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      $mail->setFrom('mutualpolicialneuquen@gmail.com', 'Mutual Policial');
      foreach($to as $emails) {
            $mail->addAddress($emails);
      } 
      $mail->isHTML(true);
      $mail->CharSet = "UTF-8";
      $mail->Subject = 'Recuperación de contraseña';
      $mensaje = generarmensaje($apellidoAfiliado, $nombreAfiliado, $codigo);
      $mail->Body = $mensaje;
      $mail->send();

      $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'RECUPERACION', '19', '$emailAfiliado')");

      echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 26px; font-family: Georgia, cursive;">CÓDIGO DE RECUPERACIÓN ENVIADO</span><br><span style="color:black; font-size: 21px; font-family: Georgia, cursive;">Revise su email para reestablecer su contraseña<br>Puede ser que ingrese como Spam<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '0')); //rec4

    }catch (Exception $e) {

      $insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('123456', 'RECUPERACION', '20', '$emailAfiliado')");

      echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE ENVIO</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No se pudo enviar el código de recuperación<br>Intente nuevamente o más tarde<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //rec5
    }
}

function generarmensaje($apellidoAfiliado, $nombreAfiliado, $codigo){
 	
	$mensaje = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title></head><body>
		<div id="email" style="background: #003366; width: 800px; margin-left: auto; margin-right: auto;">
		<br>
		<img src="https://tramitesonline.mppneuquen.com.ar/imagenes/logoRecuperacion2.jpg" style="margin-left: auto;margin-right: auto;display: block;">
		
    <p style="color:#0072BC; text-align: center; font-size: 22px; font-family: Georgia, cursive;">REESTABLECER CONTRASEÑA</p>
		
    <p style="color:white; text-align: center; font-size: 20px; font-family: Georgia, cursive;">Bienvenido '.$apellidoAfiliado." ".$nombreAfiliado.'</p>
		
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Su c&oacute;digo para reestablecer su contraseña es: '.$codigo.'</p>
		
    <p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Puede ingresarlo en el siguiente enlace<br><a href="http://mutualweb.mppneuquen.com.ar:8081/mutualweb/reestablecer.php" style="color:#85C1E9; text-decoration: none; font-size: 22px; target="_blank"">REESTABLECER</a></p>

   <h3 style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive;">Ante cualquier consulta escribanos a nuestro contacto</h3>
    <p style="text-align: center";><a style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive; text-decoration: none;" href="soporte@mppneuquen.com.ar" target="_blank">soporte@mppneuquen.com.ar</a></p>
    <br>
      <p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Por favor, no responder este email.</p><br>
    </div></body></html>';

	return $mensaje;
 }

?>
