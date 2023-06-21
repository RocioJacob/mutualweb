<?php 

include("conexion.php");
include("funciones.php");
include ('estiloMW.php');


//$documento = mysqli_real_escape_string($conexion,(strip_tags($_POST["documento"],ENT_QUOTES)));
$documento = htmlentities($_POST["documento"]);
$insert = mysqli_query($conexion,"INSERT INTO log(documento, tipo, idAlerta, email) VALUES('$documento', 'REGISTRACION', '3', 'sistemas')");

$salida = existeAfiliado($documento);
if($salida){
  $salida2 = tieneemail($documento);
  if($salida2){
    echo json_encode(array('mensaje' => "El afiliado".'<br>'."tiene cargado su email", 'salida' => '1'));
  }
  else{
    echo json_encode(array('mensaje' => "El afiliado".'<br>'."NO tiene cargado un email", 'salida' => '0'));
  }
}
else{
  echo json_encode(array('mensaje' => "El afiliado titular NO existe", 'salida' => '0'));
}

?>
