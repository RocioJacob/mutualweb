<?php
session_start(); 
include("conexion.php");
include('funciones.php');
$documentoIngresado = mb_strtoupper($_POST['documento']);
$passwordIngresado = $_POST['clave'];

//$query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE documento='$documentoIngresado'"); 
//Devuelve False en caso de error
//if(!$query){ //Solo funciona si hay conexion con la BD pero no con la tabla
//echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; font-family: Georgia, cursive;">PROBLEMAS DE CONEXIÓN</span><br><span style="color:black; font-size: 22px; font-family: Georgia, cursive;">Intente nuevamente o más tarde</span><br><span style="color:black; font-size: 18px; font-family: Georgia, cursive;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));
//}

$query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE documento='$documentoIngresado'"); 
$cantidad = mysqli_num_rows($query);

if($cantidad>0){//Existe 
	$data = mysqli_fetch_array($query);
	$documento = $data['documento'];
	$clave = $data['clave'];
	$email = $data['email'];
	$nombre = sesionafiliado($documentoIngresado);

	if(password_verify($passwordIngresado, $clave)) {
		$_SESSION['active'] = true; //activo la sesion
		$_SESSION['documento'] = $documento; 
		$_SESSION['nombre'] = $nombre; 

		$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'INGRESO', '21', '$email')"); //Devuelve False en caso de error

		//echo json_encode(array('mensaje' => 'LA CONTRASEÑA ES VALIDA', 'salida' => '0'));
		echo json_encode(array('mensaje' => '<p><img src="imagenes/logoMutual.jpg"><br><span style="color:#0072BC; font-size: 32px;">Bienvenido al sistema web<br>de la Mutual Policial</span><br><span style="color:black; font-size: 22px;">Ya puede comenzar a utilizarlo</span><br><span style="color:black; font-size: 16px;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '0'));//ing21 PROBADO
	}
	else{//Existe el afiliado titular con documento ingresado pero no con la contraseña ingresada
		$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'INGRESO', '22', '$email')");//Devuelve False en caso de error

		//echo json_encode(array('mensaje' => 'Datos incorrectos', 'salida' => '0'));
		echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px; >DATOS INCORRECTOS</span><br><span style="color:black; font-size: 22px; ">Verifique los datos ingresados</span><br><span style="color:black; font-size: 18px; ">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1'));//ing22 PROBADO
	}
}
else{//No existe el afiliado titular con documento ingresado
	$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta) VALUES('$documentoIngresado', 'INGRESO', '22')"); //Devuelve False en caso de error

	//echo json_encode(array('mensaje' => 'Datos incorrectos', 'salida' => '1'));
	echo json_encode(array('mensaje' => '<p><span style="color:#0072BC; font-size: 32px;">DATOS INCORRECTOS</span><br><span style="color:black; font-size: 22px; ">Verifique los datos ingresados</span><br><span style="color:black; font-size: 18px;">Consultas a soporte@mppneuquen.com.ar</span></p>', 'salida' => '1')); //ing22 PROBADO
}
?>
