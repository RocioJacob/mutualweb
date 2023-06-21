<?php  
session_start();
if (!isset($_SESSION['documento'])) {
  header('Location: isMW.php');
}
else{
  $documento = $_SESSION['documento'];
  $nombre = $_SESSION['nombre'];
  include('funciones.php');
  if(!estaconectado()){
    return vistaconexion();
  }
  //$nombre = sesionafiliado($documento);
}
?>

  <!DOCTYPE html>
  <html lang="es">
  <?php 
  include('head.php');
  include('navegacion.php');
  include("conexion.php");
  include ('estiloMW.php');
  ?>
  <body>
    <div class="container">
      <div id="saludo"><?php echo $nombre?></div>
      <hr/>
        <h2 id="titulo">RECIBOS CUOTA SOCIAL</h2> 
      <hr/>
      <?php
      //Tengo que usar la api ya que tengo que obtener el numero interno/codigo
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://192.168.0.5/mutpol/rest/titular_cargas',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'dni:'.$documento
        ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      if(empty($response)){//Comprueba si un array esta vacio
         echo "PROBLEMAS DE CONEXIÓN CON LA BASE DE DATOS";
      }
      else{
        $resultArray = json_decode($response, true);
        $arrayTitular = obtenerTitular($resultArray);
        $codigo = $arrayTitular['codigo'];
        $interno = str_pad($codigo, 6, "0", STR_PAD_LEFT); //relleno con ceros a la izquierda
        listarFacturas($interno); 
      }
    ?>
  </div>
  </body>
  </html>

<!--<style type="text/css">
body{
    /*background-color: #8faed6;*/
}
#botonMenu{
  float:right;
  margin-right: 5px;
  background-color: #148F77;
  color: white;
  border: 2px solid;
  border-radius: 10px;   comentado se paso el css a estiloOpcionesDelMenuPPAL.php
}
.container{
  background-color: #fff;
  height: auto;
}
a:link, a:visited, a:active {
    text-decoration:none;
}
</style>-->

<?php
//Lista todas las facturas disponibles del interno ingresado
function listarFacturas($interno){
  include("conexion.php");
  $query = mysqli_query($conexion, "SELECT * FROM facturas WHERE publicar LIKE '0' ORDER BY id DESC");
  $cantidad = mysqli_num_rows($query); //Obtengo cantidad de facturas

    while ($data = mysqli_fetch_array($query)) {
      $numero_mes = $data['mes']; 
      $mes = nombreMes($numero_mes);  
      $anio = $data['anio'];             
      mostrarFactura($mes,$anio,$interno);
    }
}

function mostrarFactura($mes, $anio, $interno){
    $ruta1='./facturas/'.$anio.'/'.$mes.'/'.$interno; //Facturas/2021/ABRIL/000001
    if (is_dir($ruta1)){ //Indica si el nombre de archivo es un directorio
        $listado1 = scandir($ruta1); //Enumera los ficheros y directorios ubicados en la ruta $ruta1
        $codigo = $listado1[2]; //Obtengo el nombre de la carpeta igual al nro de factura
        $ruta2= $ruta1.'/'.$codigo; //Obtengo la ruta donde se encuentra la factura

        if (is_dir($ruta2)){ //Indica si el nombre de archivo es un directorio
          if ($dh = opendir($ruta2)){ //Abre un gestor de directorio
            while (($file = readdir($dh)) !== false){ //readdir — Lee una entrada desde un gestor de directorio
                $ext = pathinfo($file, PATHINFO_EXTENSION); //Obtengo la extension del archivo
                if (is_dir($ruta2) && $file != '.' && $file != '..' && $ext =="pdf"){ 
                  $archivo = $ruta2.'/'.$file;
                  escribirhtml($mes, $anio, $archivo);
                }
            }
            closedir($dh);
          }
        }
    }
}

function escribirhtml($mes, $anio, $archivo){
  echo "<!DOCTYPE html>";
  echo "<html>";
  echo "<head>";
  echo "<title>Facturas</title> <meta charset = \"utf-8\"/> </head>";
  echo "<body>";
  echo "<div class=\”d-none d-sm-none d-md-block style='text-align:center;'\”>";
  echo "<div class=\”row align-items-start\”>";
  echo "<br>";
  echo "<h5 style='text-align:center;'>".$mes." ".$anio."</h5>";
  echo "<div class=\”col\”><a href='$archivo' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align=center>Descargar</a></div>";
  echo "<div class=\”col\”></div>";
  echo "</div>";
  echo "</div>";
  echo "</body>";
  echo "</html>";
  echo "<br>";
}

function nombreMes($mes){
  $salida="";
  if($mes == '1'){
    $salida = "ENERO";
  }
  elseif ($mes == '2') {
    $salida = "FEBRERO";
  }
  elseif ($mes == '3') {
    $salida = "MARZO";
  }
  elseif ($mes == '4') {
    $salida = "ABRIL";
  }
  elseif ($mes == '5') {
    $salida = "MAYO";
  }
  elseif ($mes == '6') {
    $salida = "JUNIO";
  }
  elseif ($mes == '7') {
    $salida = "JULIO";
  }
  elseif ($mes == '8') {
    $salida = "AGOSTO";
  }
  elseif ($mes == '9') {
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

?>