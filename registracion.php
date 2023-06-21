<?php 
//session_start();
include("conexion.php");
include("funciones.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$documento = mysqli_real_escape_string($conexion,(strip_tags($_POST["documento"],ENT_QUOTES)));
//$documento = htmlentities($_POST["documento"]);
$email = mysqli_real_escape_string($conexion,(strip_tags($_POST["email"],ENT_QUOTES)));
//$email = htmlentities($_POST["email"]);

$salida = estaconectado();//Verifica si hay conexion con el servidor 192.168.0.5, asi puedo usar las funciones
if(!$salida){
	echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">PROBLEMAS DE CONEXIÓN</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Intente nuevamente o más tarde</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));
}
else{
//Busco si existe el afiliado y no esta de baja en el CTA CTE
$existe = existeAfiliado($documento);
if($existe){
	$resultArray = titularCargas($documento);
	$data = datosTitular($resultArray); //Obtengo datos titular
	$emailAfiliado = $data['email2']; 
	$nombreAfiliado = $data['nombre'];
	$apellidoAfiliado = $data['apellido'];

//Busco al afiliado si existe en la base de AFILIADOS
//$query = mysqli_query($conexion, "SELECT * FROM afiliados WHERE documento LIKE '$documento'");
//$cantidad = mysqli_num_rows($query);

//if($cantidad>0){
	//$data = mysqli_fetch_array($query);
	/*$data = mysqli_fetch_assoc($query);
	$emailAfiliado = $data['email']; 
	$nombreAfiliado = $data['nombre'];
	$apellidoAfiliado = $data['apellido'];*/

	//BUSCO SI EXISTE EN USUARIOS
	//$documentoIngresado = mysqli_query($conexion, "SELECT * FROM usuarios WHERE documento='$documento'")->fetch_assoc()['documento'];
	$query1 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE documento='$documento'");
	$salida1 = mysqli_num_rows($query1); //$salida1 = $query1->num_rows; OTRA FORMA

	if($salida1>0){//EXISTE EN LA TABLA USUARIOS - SE REGISTRO CON EXITO EN ALGÚN MOMENTO
		$data1 = mysqli_fetch_assoc($query1);//Obtengo sus datos
		$activoAfiliado = $data1['activo'];
		$fechacodigo = $data1['fechacodigo'];
		$emailAfiliado = $data1['email'];

		if($activoAfiliado==1){ //Esta registrado y activo. Solo se fija en el documento ingresado, sin importar el email que ponga.
			try{
				$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'REGISTRACION', '1', '$email')");
				echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">CUENTA YA ACTIVADA</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Ya se encuentra registrado y activado<br>Puede iniciar sesi&oacuten</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reg1
			}catch (Exception $e) {
				echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">CUENTA YA ACTIVADA</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Ya se encuentra registrado y activado<br>Puede iniciar sesi&oacuten</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reg1
			}
		}
		else{//Solo esta registrado
			/*$diferenciafechas = diferenciafechas($fechacodigo);
			if($diferenciafechas<48){ //Codigo no caduco. Nunca activo la cuenta
				try{
					$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta) VALUES('$documento', 'REGISTRACION', '2')");
					echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">CUENTA YA REGISTRADA</span><br><span style="color:black; font-size: 21px; font-family: Georgia, cursive;">Debe activarla con el código enviado al<br>email con el cual se registro<br>Puede ser que ingrese como Spam</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reg2
				}catch (Exception $e) {
					echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">CUENTA YA REGISTRADA</span><br><span style="color:black; font-size: 21px; font-family: Georgia, cursive;">Debe activarla con el código enviado al<br>email con el cual se registro<br>Puede ser que ingrese como Spam</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reg2
					}
			}
			else{ *///Caduco el codigo de activación - Se actualiza en la tabla usuarios
				$salida = actualizarcuenta($documento, $emailAfiliado, $nombreAfiliado, $apellidoAfiliado, $email);
			//}
		}
	}
	else{//NO EXISTE EN USUARIOS - NUNCA SE REGISTRO
		if($emailAfiliado == ""){
		//echo json_encode(array('mensaje' => "No tenemos EMAIL cargado ".'<br>'." en su perfil de afiliado".'<br>'."Actualice sus datos", 'salida' => '1'));
			try{
				$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'REGISTRACION', '3', '$email')");
				echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE EMAIL</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No tiene email cargado en Mutual<br>Debe actualizar sus datos</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));
				//reg3 PROBADO
			}catch (Exception $e) {
				echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE EMAIL</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No tiene email cargado en Mutual<br>Debe actualizar sus datos</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));
				//reg3 PROBADO
			}
		}
		else{//Tiene email cargado en el cta cte
			if($emailAfiliado != $email){ //NO COINCIDE EL EMAIL DEL AFILIADO(DEL CTA CTE) CON EL QUE SE INGRESO
				//echo json_encode(array('mensaje' => "ERROR DE EMAIL".'<br>'."No coincide con el que tenemos".'<br>'."registrado en su perfil", 'salida' => '1'));
				try{
					$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'REGISTRACION', '4', '$email')");
					echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE EMAIL</span><br><span style="color:black; font-size: 21px; font-family: Georgia, cursive;">No coincide con el email registrado en Mutual</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); 
					//reg4 PROBADO
				}catch (Exception $e) {
					echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE EMAIL</span><br><span style="color:black; font-size: 21px; font-family: Georgia, cursive;">No coincide con el email registrado en Mutual</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); 
					//reg4 PROBADO
				}	
			}
			else{//COINCIDE EL EMAIL DEL AFILIADO CON EL QUE SE INGRESO
				$salida = registrarcuenta($documento, $emailAfiliado, $nombreAfiliado, $apellidoAfiliado);
			}
		}
	}
}
else{
	try{
		$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'REGISTRACION', '8', '$email')");
		echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">AFILIADO INEXISTENTE<br>O DADO DE BAJA</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); 
		//reg8 PROBADO
	}catch (Exception $e) {
		echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">AFILIADO INEXISTENTE<br>O DADO DE BAJA</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));
		//reg8 PROBADO
	}
}
}

function registrarcuenta($documento, $email, $nombreAfiliado, $apellidoAfiliado){
	include("conexion.php");
 	$codigo = rand(10000,100000); //genero código//$codigo = md5($codigo);
 	$fechaactual = obtenerfecha();

 	$insert = mysqli_query($conexion,"INSERT INTO usuarios(documento, email, clave, codigo, fechacodigo) VALUES('$documento', '$email', '', '$codigo', '$fechaactual')");

 	if($insert){
 		//PARA EL ENVIO DE MAILS
		$mail = new PHPMailer(true);
		try {
			//$to = ["mutualpolicialneuquen@gmail.com", "sistemas@mppneuquen.com.ar"];
			$to = [$email];
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
			$mensaje = generarmensaje($apellidoAfiliado, $nombreAfiliado, $email, $codigo);
			$mail->Body = $mensaje;
			$mail->send();

 			//echo json_encode(array('mensaje' => "Su código de activación".'<br>'." fue enviado a su email".'<br>'."Puede ser que llegue como Spam", 'salida' => '0'));
 			$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'REGISTRACION', '5', '$email')");
 			echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 28px; font-family: Georgia, cursive;">CÓDIGO DE ACTIVACIÓN ENVIADO</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Revise su email<br>Puede ser que ingrese como Spam<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '0')); //reg5 PROBADO

		}catch (Exception $e) {//Se genero el codigo de activacion e inserto en la tabla de usuarios pero no se pudo enviar al email (Campo codigo y fecha_codigo se completan en usuarios, activo sigue en 0)
			try{
				$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'REGISTRACION', '6', '$email')");
				echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE ENVIO</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No se pudo enviar el código a su email<br>Intente nuevamente o más tarde<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reg6 PROBADO
			}catch(Exception $e){
				echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE ENVIO</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No se pudo enviar el código a su email<br>Intente nuevamente o más tarde<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reg6 PROBADO
			}
		}
	}
	else{//No se inserto la cuenta, no se registro (Problemas con la base de datos)
		try{
			$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'REGISTRACION', '7', '$email')");
			echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR AL REGISTRARSE</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No se pudo registrar su cuenta<br>Intente nuevamente o más tarde<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reg7 PROBADO
		}catch(Exception $e){
			echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR AL REGISTRARSE</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No se pudo registrar su cuenta<br>Intente nuevamente o más tarde<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reg7 PROBADO
		}
	}
}

//Se utiliza cuando el código de activación caduco
function actualizarcuenta($documento, $emailAfiliado, $nombreAfiliado, $apellidoAfiliado, $email){
	include("conexion.php");
	if($emailAfiliado != $email){ //NO COINCIDE EL EMAIL DEL AFILIADO(DEL CTA CTE) CON EL QUE SE INGRESO
				try{
					$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'REGISTRACION', '4', '$email')");
					echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE EMAIL</span><br><span style="color:black; font-size: 21px; font-family: Georgia, cursive;">No coincide con el email registrado en Mutual</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); 
					//reg4 PROBADO
				}catch (Exception $e) {
					echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE EMAIL</span><br><span style="color:black; font-size: 21px; font-family: Georgia, cursive;">No coincide con el email registrado en Mutual</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); 
					//reg4 PROBADO
				}	
	}
	else{

	 	$codigo = rand(10000,100000); //genero código//$codigo = md5($codigo);
	 	$fechaactual = obtenerfecha();

	 	//Solo tengo que actualizar los campos codigo y fecha
	 	$sentencia ="UPDATE usuarios SET codigo='$codigo', fechacodigo='$fechaactual' WHERE documento='$documento'";
	  	$actualizar = mysqli_query($conexion, $sentencia);
	  	if($actualizar){
			$mail = new PHPMailer(true);
			try {
				//$to = ["mutualpolicialneuquen@gmail.com", "sistemas@mppneuquen.com.ar"];
				$to = [$email];
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
				$mensaje = generarmensaje($apellidoAfiliado, $nombreAfiliado, $email, $codigo);
				$mail->Body = $mensaje;
				$mail->send();

				$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'REGISTRACION', '5', '$email')");
				echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 28px; font-family: Georgia, cursive;">CÓDIGO DE ACTIVACIÓN ENVIADO</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Revise su email<br>Puede ser que ingrese como Spam<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '0')); //reg5 PROBADO
			}catch (Exception $e) {
				try{
					$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'REGISTRACION', '6', '$email')");
					echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE ENVIO</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No se pudo enviar el código a su email<br>Intente nuevamente o más tarde<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reg6 PROBADO
				}catch (Exception $e) {
					echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR DE ENVIO</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No se pudo enviar el código a su email<br>Intente nuevamente o más tarde<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reg6 PROBADO
				}
			}
		}
		else{//No se pudo generar nuevo codigo y actualizarlo en la tabla usuarios
			try{
				$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'REGISTRACION', '7', '$email')");
				echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR AL REGISTRARSE</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No se pudo registrar su cuenta<br>Intente nuevamente o más tarde<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reg7 PROBADO
			}catch (Exception $e) {
				echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">ERROR AL REGISTRARSE</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">No se pudo registrar su cuenta<br>Intente nuevamente o más tarde<br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //reg7 PROBADO
			}
		}
	}
}

function generarmensaje($apellidoAfiliado, $nombreAfiliado, $email, $codigo){
 	$mensaje = '
		<div id="email" style="background: #003366; width: 800px; margin-left: auto; margin-right: auto;">
		<br>
		<img src="https://tramitesonline.mppneuquen.com.ar/imagenes/logoRecuperacion2.jpg" style="margin-left: auto;margin-right: auto;display: block;">	
		
		<p style="color:white; text-align: center; font-size: 20px; font-family: Georgia, cursive;">Bienvenido '.$apellidoAfiliado." ".$nombreAfiliado.'</p>
		
		<p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Su c&oacute;digo de activaci&oacute;n es:</p>
		
		<p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">'.$codigo.'</p>

		<p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Tiene 48hs para usarlo, si no caducar&aacute; y deber&aacute; registrarse nuevamente</p>

		<p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Puede ingresarlo en el siguiente enlace:<br><a href="http://mutualweb.mppneuquen.com.ar:8081/mutualweb/activar.php" style="color:#85C1E9; text-decoration: none; font-size: 22px; target="_blank"">ACTIVAR</a></p>

		<h3 style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive;">Ante cualquier consulta escribanos a nuestro contacto</h3>
    	<p style="text-align: center";><a style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive; text-decoration: none;" href="soporte@mppneuquen.com.ar" target="_blank">soporte@mppneuquen.com.ar</a></p>
    	<br>
    	<p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Por favor, no responder este email.</p><br>
		</div>';

	return $mensaje;
 }

?>

