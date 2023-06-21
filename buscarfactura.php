<?php
include("conexion.php");

$mes = mb_strtoupper(mysqli_real_escape_string($conexion,(strip_tags($_POST["mes"],ENT_QUOTES))));
$anio = mysqli_real_escape_string($conexion,(strip_tags($_POST["anio"],ENT_QUOTES)));

//$salida = $mes." - ".$anio;

//echo json_encode(array('mensaje' => $salida, 'salida' => '1'));

$ruta='./facturas/32754564/';
$lista = '';
if ($carpeta=opendir($ruta)){
    while (($file = readdir($carpeta)) !== false){
        if (is_dir($ruta.$file) && $file != '.' && $file != '..' ){  
        	if($file == $anio) {  
	            //$lista .= '<li>'.$file.'</li>';
	            //echo "AÑO ".$file;
	            listar($ruta.$file, $mes, $anio);
	            //echo "<br>";
	        }
	       /* else{
	        	echo '<h3 class="text-primary">'."NO SE ENCONTRARON COINCIDENCIAS CON SUS CRITERIOS DE BUSQUEDA.".'<h3>';
	        }*/
        }
    }
}

function listar($directorio, $mesIngresado, $periodo){
  if (is_dir($directorio)){
    if ($dh = opendir($directorio)){
  
      /*echo "<table class='table table-bordered order-table'>
        <thead>
          <tr>
            <th>FECHA</th>
            <th>ARCHIVO</th>
          </tr>
        </thead>"; */

        echo"";

      	while (($file = readdir($dh)) !== false){
       		 $ext = pathinfo($file, PATHINFO_EXTENSION);
        	//if($file != '.' && $file != '..' && substr($file,-4) == ".pdf") {

       		    $name = pathinfo($file, PATHINFO_FILENAME);
            	$mes = substr($name, 0, 2);
            	$anio = substr($name, 3,6);
            	$nombreMes = mes($mes);

          	if($file != '.' && $file != '..' && $ext == "pdf" && $periodo == $anio && $mesIngresado == '') {
            //echo $file . "<br>";
            	echo "<tr>
              	<td>".$nombreMes." ".$anio."</td>
              	<td>"."**********"."</td>
              	<td><a href='$directorio' target='_blank'><img src='./imagenes/pdf1.jpg' height='50' width='50' align='right'>Descargar</a></td>
            	</tr>";
          	}
          	if($file != '.' && $file != '..' && $ext == "pdf" && $periodo == $anio && $mesIngresado == $nombreMes) {
          		
          		echo "<tr>
              	<td>".$nombreMes." ".$anio."</td>
              	<td>"."**********"."</td>
              	<td><a href='$directorio' target='_blank'><img src='./imagenes/pdf1.jpg' height='50' width='50' align='right'>Descargar</a></td>
            	</tr>";
          	}
      	}
     	echo "</table>";
      	closedir($dh);
    }
  }
}



function mes($mes){
  $salida="";
  if($mes == '01'){
    $salida = "ENERO";
  }
  elseif ($mes == '02') {
    $salida = "FEBRERO";
  }
  elseif ($mes == '03') {
    $salida = "MARZO";
  }
  elseif ($mes == '04') {
    $salida = "ABRIL";
  }
  elseif ($mes == '05') {
    $salida = "MAYO";
  }
  elseif ($mes == '06') {
    $salida = "JUNIO";
  }
  elseif ($mes == '07') {
    $salida = "JULIO";
  }
  elseif ($mes == '08') {
    $salida = "AGOSTO";
  }
  elseif ($mes == '09') {
    $salida = "SEPTIEMBRE";
  }
  elseif ($mes == '10') {
    $salida = "OCTUBRE";
  }
  elseif ($mes == '11') {
    $salida = "NOVIEMBRE";
  }
  else{
    $salida = "DICIEMBRE";
  }
  return $salida;
}

	/*$tabla = "";
	$tabla.= '<table class="table table-bordered table-striped">
		<thread>
		<tr class="p-3 mb-2 bg-secondary text-white">
			<td>Id</td>
			<td>Usuario</td>
			<td>Apellido</td>
			<td>Nombre</td>
			<td>Email</td>
			<td>Rol</td>
			<td>Habilitado</td>
		</tr>
		</thread>';
	$tabla.='</table>';
	echo $tabla;
   	echo "<br>";*/
?>