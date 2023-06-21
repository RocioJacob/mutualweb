<?php
include('phpqrcode/qrlib.php');

//Devuelve datos del titular y sus cargas en un array (Si no tiene cargas, esta vacio el array cargas)
function titularCargas($documento){  
    $curl = curl_init();
    curl_setopt_array($curl, array(
      //CURLOPT_URL => 'http://10.8.0.1/mutpol/rest/titular_cargas',
      CURLOPT_URL => 'http://192.168.0.5/mutpol/rest/titular_cargas',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array('dni:'.$documento),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

  return $response;
}

function cuentacorriente($documento){   
      $curl = curl_init();
      $fecha = '01/09/2021';
      curl_setopt_array($curl, array(
      //CURLOPT_URL => 'http://10.8.0.1/mutpol/rest/cuenta_corriente',
      CURLOPT_URL => 'http://192.168.0.5/mutpol/rest/cuenta_corriente',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array('dni:'.$documento, 'fecha:'.$fecha,'Content-Type: application/json'),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
  return $response;
}

function deuda($documento, $periodo){
    //$periodo = 1;
    $curl = curl_init();
    curl_setopt_array($curl, array(
      //CURLOPT_URL => 'http://10.8.0.1/mutpol/rest/deuda',
      CURLOPT_URL => 'http://192.168.0.5/mutpol/rest/deuda',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array('dni:'.$documento,'periodo:'.$periodo,'Content-Type: application/json'),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
  return $response;
}

function debitos($documento){
  $curl = curl_init();

  curl_setopt_array($curl, array(
    //CURLOPT_URL => 'http://10.8.0.1:80/mutpol/rest/debitos',
    CURLOPT_URL => 'http://192.168.0.5/mutpol/rest/debitos',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array('dni:'.$documento,'Content-Type: application/json'),
  ));

  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}

function hayConexion($response){
  if(empty($response)){ //Si esta vacia
    return false;
  }
  else{
    return true;
  }
}

//Verifica si hay conexion con la VPN
function estaconectado(){
  //$salida = testServidorWeb("http://10.8.0.1");
  $salida = testServidorWeb("http://192.168.0.5");
  if($salida){
    return true;
  }
  else{
    return false;
  }
}

function conectadobase(){
  $host = "localhost";
  $user = "root";
  $password = "MPPNpolicial2022*";
  $database = "mutualweb";

  //La función devuelve una conexión almacenada en la variable $conexion, o FALSE en caso de error
  $conexion = mysqli_connect($host, $user, $password, $database);
  if($conexion){
    return true;
  }
  else{
    return false;
  }
}

function testServidorWeb($servidor) {
    $a = @get_headers($servidor);
     
    if (is_array($a)) {
        return true;
    } else {
        return false;
    }
}

function vistaconexion(){
  //session_destroy();
  include('head.php');
  include('navegacion.php');

  echo '<div class="container"><hr/>
        <h3 style="color: #0072BC;text-align:center;">PROBLEMAS DE CONEXIÓN CON EL SERVIDOR</h3>
        <h5 style="color: black;text-align:center;">Cierre sesión e intente nuevamente mas tarde</h5>
        </div>';
}

//Existe afiliado TITULAR y no esta de baja
function existeAfiliado($documento){
  $resultArray = titularCargas($documento);
  $arrayafiliado = json_decode($resultArray, true);//Paso a json para ver si esta vacio
  if (array_key_exists('message', $arrayafiliado)){ //No existe afiliado
    return false;
  }
  else{ //Existe el afiliado-ver si esta o no de baja
      $arrayTitular = datosTitular($resultArray);
      $fechaBaja = $arrayTitular['baja'];
      if($fechaBaja!=""){//existe y esta de baja
        return false;
      }
      else{
        return true; //existe
    }
  }
}

//Verifica si afiliado TITULAR esta habilitado
function estaHabilitado($documento){
  $resultArray = titularCargas($documento);
  $arrayTitular = datosTitular($resultArray);
  $habilitado = $arrayTitular['habilitado'];
    if($habilitado){
        return true;
    }
    else{
      return false;
    }
}

function datosTitular($response){
  $resultArray = json_decode($response, true);
  $arrayTitular = obtenerTitular($resultArray);
  return $arrayTitular;
}

function datosCargas($response){
  $resultArray = json_decode($response, true);
  $arrayCargas = obtenerCargas($resultArray);
  return $arrayCargas;
}

function datoscuentacorriente($response){
  $resultArray = json_decode($response, true);
  $arrayTitular = obtenerCuenta($resultArray);
  return $arrayTitular;
}

function datosdeuda($response){
  $resultArray = json_decode($response, true);
  return $resultArray;
}

function obtenerCargas($resultArray){
  $array = [];
  $i = 0;
  foreach($resultArray as $key=>$data){
    if(is_array($data)){
      foreach($data as $numero){
        foreach($numero as $clave=>$elemento){
          if(!is_array($elemento)){
            $array[$i][$clave] = $elemento;
          }
        }
        $i = $i+1;
      }
    }
  }
  return $array;
}

function obtenerCuenta($resultArray){
  $array = [];
  $i = 0;
  foreach($resultArray as $key=>$data){
    foreach($data as $clave=>$elemento){
      $array[$i][$clave] = $elemento;
    }
    $i = $i+1;
  }
  return $array;
}

function obtenerTitular($resultArray){
  $array = [];
  foreach($resultArray as $key=>$data){
    if(!is_array($data)){
      $array[$key] = $data;
    }
  }
  return $array;
}

function obtenerfecha(){
  date_default_timezone_set('America/Argentina/Buenos_Aires');
  $hoy=date("Y-m-d H:i:s",time());
  return $hoy;
}

function diferenciafechas($fechacodigo){
  $fechaactual = obtenerfecha(); //Obtengo fecha actual
  $day1 = strtotime($fechacodigo);
  $day2 = strtotime($fechaactual);
  $diffHours = ($day2 - $day1) / 3600; //Comparo la diferencia entre fechas
  return $diffHours;
}


//Para webservice si un afiliado titular o carga existe y esta o no habilitado(moroso y/o con fecha de baja)

//Existe afiliado  titular o carga
function existe($documento){
  $resultArray = habilitado($documento);
  $arrayafiliado = json_decode($resultArray, true);//Paso a json para ver si esta vacio
  if (array_key_exists('message', $arrayafiliado)){ //No existe afiliado
    return false;
  }
  else{
        return true; //existe
  }
}

function habilitado($documento){  
   $curl = curl_init();
  curl_setopt_array($curl, array(
    //CURLOPT_URL => '10.8.0.1/mutpol/rest/habilitados',
    CURLOPT_URL => '192.168.0.5/mutpol/rest/habilitados',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array('dni:'.$documento, 'Content-Type: application/json'),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}

function datosAfiliado($response){
  $resultArray = json_decode($response, true);
  $array = [];
  foreach($resultArray as $key=>$data){
    if(!is_array($data)){
      $array[$key] = $data;
    }
  }
  return $array;
}

//devuelve los datos del afiliado (documento, nombre, apellido, fecha de baja y si esta habilitado)
function habilitados($documento){
  $resultArray = habilitado($documento);
  $arrayAfiliado = datosAfiliado($resultArray);
  return $arrayAfiliado;
}

function tienecargas($documento){
  $resultArray = titularCargas($documento);
  $arrayCarga = datosCargas($resultArray);
  $longitud = count($arrayCarga);
  if($longitud!=0){
    return true;
  }
  else{
    return false;
  }
}

//Devuelve true o false si un titular tiene cargas sin fecha de baja
function tienecargasdealta($documento){
  $resultArray = titularCargas($documento);
  $arrayCarga = datosCargas($resultArray);
  $longitud = count($arrayCarga);
  $salida = false;
  $i=0;
  while ( $i < $longitud) {
    if($arrayCarga[$i]['baja']==""){
      $salida = true;
    }
    $i=$i+1;
  }
  return $salida;
}

//Devuelve datos de las cargas HABILITADAS del titular en un array de array
function cargastitular($documento){
  $resultArray = titularCargas($documento);
  $arrayCarga = datosCargas($resultArray);
  $longitud = count($arrayCarga);
  $i=0;
  $j=0;
  $salida = [];
  $datos = [];
  while ( $i < $longitud) {
    if(estahabilitadoafiliado($arrayCarga[$i]['documento'])){
        $datos[0] = $arrayCarga[$i]['documento'];
        $datos[1] = $arrayCarga[$i]['nombre'];
        $datos[2] = $arrayCarga[$i]['apellido'];
        $salida[$j] = $datos;
        $j=$j+1;
    }
    $i=$i+1;
  }
  return $salida;
}

//PARA VERFICAR SI UN AFILIADO ESTA O NO HABILITADO Y SI TIENE O NO FECHA DE BAJA

//Devuelve true si un afiliado(titular o carga) esta habilitado
function estahabilitadoafiliado($documento){
  $salida = habilitados($documento);
  if($salida['habilitado']){
    return true;
  }
  else{
    return false;
  }
}

//Devuelve true si un afiliado(titular o carga) esta de baja
function estabajaafiliado($documento){
  $salida = habilitados($documento);
  if($salida['baja']!=""){
    return true;
  }
  else{
    return false;
  }
}

function sesionafiliado($documento){
  $resultArray = habilitado($documento);
  $arrayAfiliado = datosAfiliado($resultArray);
  $nombre = $arrayAfiliado['nombre'];
  $apellido = $arrayAfiliado['apellido'];
  return $apellido." ".$nombre;
}

function generarqr($documento){
  $content = "http://mutualweb.mppneuquen.com.ar:8081/mutualWeb/afiliado.php?afiliado=".$documento;
  $path = './qrcodes/';
  $nombre = $path.$documento.".png";//Guarda el qr en la carpeta qrcodes con nombre el dni.png
  if (file_exists($nombre)) {
    $salida = "<img src='$nombre' style='border: 2px solid black'/>";
  }
  else{//Si no existe el qr, lo genero
    QRcode::png($content,$nombre,"H",3,2);
    crearborde($nombre, $documento);
    $salida = "<img src='$nombre' style='border: 2px solid black'/>";
  }
  //return $salida;
}

function tieneqr($documento){
  if(file_exists('./qrcodes/'.$documento.'.png')){
    return true;
  }
  else{
    return false;
  }
}

//Devuelve true si un afiliado (Titular o carga) tiene la credencial creada
function tienecredencial($documento){
  if(file_exists('./credenciales/'.$documento.'.png')){
    return true;
  }
  else{
    return false;
  }
}

function crearborde($imagen, $documento){
    $border=3; // Change the value to adjust width
    $im=imagecreatefrompng($imagen);
    $width=ImageSx($im);
    $height=ImageSy($im);
    $img_adj_width=$width+(2*$border);
    $img_adj_height=$height+(2*$border);
    $newimage=imagecreatetruecolor($img_adj_width,$img_adj_height);
    $border_color = imagecolorallocate($newimage, 0, 0, 0);
    imagefilledrectangle($newimage,0,0,$img_adj_width,$img_adj_height,$border_color);
    imageCopyResized($newimage,$im,$border,$border,0,0,$width,$height,$width,$height);
    imagepng($newimage, './qrcodes/'.$documento.'.png');
    imagedestroy($newimage);
}


function crearcredencial($documento){
  $salida  = habilitados($documento);//Obtengo datos del afiliado
  $apellido = $salida['apellido'];
  $nombre = $salida['nombre'];

  if(tieneqr($documento)){
    $codigoqr = './qrcodes/'.$documento.'.png';
  } 
  else{
    generarqr($documento);
    $codigoqr = './qrcodes/'.$documento.'.png';
  }

  //header('Content-type: image/png');
  $image = imagecreatefrompng('./imagenes/credencial5.png');
  $image2 = imagecreatefrompng($codigoqr);
  // Asignar el color para el texto
  $color = imagecolorallocate($image, 255, 255, 255);
  // Asignar la ruta de la fuente
  //$font_path = __DIR__.'\arial.ttf';
  //$font_path = __DIR__.'\verdana.ttf';
  $font_path = '/var/www/html/mutualweb/verdana.ttf'; //AGREGADO
  //$font_path = '\verdana.ttf';
  //$font_file = 'Arial.ttf'; // This is the path to your font file.
  /// imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )

  imagettftext($image, 13, 0, 35, 330, $color, $font_path, $apellido); // Colocar el texto 1 en la imagen
  imagettftext($image, 13, 0, 35, 355, $color, $font_path, $nombre); // Colocar el texto 2
  imagettftext($image, 13, 0, 35, 380, $color, $font_path, $documento);
  imagecopymerge($image, $image2, 385, 218, 0, 0, 165, 165, 100);
  //imagecopymerge($image, $image2, POSICION ANCHO, POSICION ALTURA, 0, 0, ancho foto qr, largo foto qr, 100);
  imagepng($image, './credenciales/'.$documento.'.png');
  //imagepng($image);
  imagedestroy($image); // Limpiar la memoria
  //header ("Location: http://192.168.0.14/mutualWeb/credencial.php");
}

//Crea las credenciales de sus cargas
function crearcredencialcarga($documento){
  $array = cargastitular($documento);
  $longitud = count($array);
   $i=0;
    while($i<$longitud){
        $j=0;
        $documentocarga = $array[$i][$j];
        $nombrecarga = $array[$i][$j+1];
        $apellidocarga = $array[$i][$j+2];

        if(!estabajaafiliado($documentocarga)){//Carga NO esta de baja
          if(!tienecredencial($documentocarga)){ //Si NO tiene credencial creada la creo
            crearcredencial($documentocarga);
          }
        }
        $i=$i+1;
    }
}

//Muestra las credenciales de sus cargas
function credencialescargas($documento){
  $array = cargastitular($documento);//Obtengo las cargas del titular
  $longitud = count($array);
   $i=0;
    while($i<$longitud){
        $j=0;
        $documentocarga = $array[$i][$j];
        $nombrecarga = $array[$i][$j+1];
        $apellidocarga = $array[$i][$j+2];

        if(!estabajaafiliado($documentocarga)){//Carga NO esta de baja

            $credencial = './credenciales/'.$documentocarga.'.png'; 
            echo "<p style='text-align:center;'>
            <img class='img-fluid' src='$credencial?x=<?=md5(time())?/>'>
            <br></p>";
            //echo '<br>';

            ?>
            <div style="text-align: center"><button type="button" class="btn btninter" onclick="descargarCredencial(<?php echo $documentocarga ?>);">DESCARGAR</button></div>
              <br/><br/>
            <?php
        }
        //echo "HOLA";
        $i=$i+1;
    }
}

function mostrarcredencialtitular($documento){
  $credencial = './credenciales/'.$documento.'.png'; 
            echo "<p style='text-align:center;'>
            <img class='img-fluid' src='$credencial?x=<?=md5(time())?/>'>
            <br></p>";
            //echo '<br>';

            ?>
            <div style="text-align: center"><button type="button" class="btn btninter" onclick="descargarCredencial(<?php echo $documento ?>);">DESCARGAR</button></div>
              <br/><br/>
            <?php
}

function imprimir(){
  //$imprimir = '<div class="imprimir" style="text-align:center;"><input type="button" name="imprimir" value="Imprimir" onclick="window.print();" id="btnimprimir" style="color: #3A73A8; border-radius:10%; text-align: center;"></div>';
  $imprimir2 = '<div style="text-align:center;"><button class="btn btn-responsive btninter" type="button" style="height:50px; width:120px;border: 2px solid; border-radius: 20px; font-size: 17px; font-family: Georgia, cursive; background-color:#3A73A8; color:white;" onclick="window.print();">Imprimir</button></div>';
  echo $imprimir2;
  echo '<br/>';
}


function tramitesUno($id){
  include("conexion.php");
  $sql = mysqli_query($conexion, "SELECT * FROM tramites_uno WHERE id='$id'");
  $data = mysqli_fetch_assoc($sql);
  return $data;
}

function tramitesDos($id){
  include("conexion.php");
  $sql = mysqli_query($conexion, "SELECT * FROM tramites_dos WHERE id='$id'");
  $data = mysqli_fetch_assoc($sql);
  return $data;
}     

function tieneemail($documento){
  $resultArray = titularCargas($documento);
  $arrayTitular = datosTitular($resultArray);

  if($arrayTitular['email2']!=''){
    return true;
  }
  else{
    return false;
  }
}      
?>
