<?php 
//include("conexion.php");
include('funciones.php'); 
include('head.php');
include('navegacion.php');
include('/usr/share/phpqrcode/qrlib.php');
include('/var/www/phpqrcode/qrlib.php');
if(class_exists('QRcode'))
{
    QRcode::png('PHP QR Code :)');

}else{

    echo 'class is not loaded properly';
}



/*
$salida = existeAfiliado('30965451');
if($salida){
    echo "EXISTE AFILIADO";
  }
  else{
    echo "NO EXISTE AFILIADO";
  }

echo '<br/>';
$salida1 = conectadobase();
if($salida1){
    echo "Hay conexion";
  }
  else{
    echo "NO hay conexion";
  }
*/

echo '<br/>';

/*$salida = testServidorWeb("http://10.8.0.1");
  if($salida){
    echo "Hay conexion";
  }
  else{
    echo "NO hay conexion";
  }*/


/*function testServidorWeb($servidor) {
    $a = @get_headers($servidor);
     
    if (is_array($a)) {
        return true;
    } else {
        return false;
    }
}*/
echo '<br/>';
//$documento = '33275201';
//$codigoqr = './qrcodes/'.$documento.'.png';
//crearborde($codigoqr, $documento);

/*
$border=5; // Change the value to adjust width
$im=imagecreatefrompng($codigoqr);
$width=ImageSx($im);
$height=ImageSy($im);
$img_adj_width=$width+(2*$border);
$img_adj_height=$height+(2*$border);
$newimage=imagecreatetruecolor($img_adj_width,$img_adj_height);
$border_color = imagecolorallocate($newimage, 0, 0, 0);
imagefilledrectangle($newimage,0,0,$img_adj_width,$img_adj_height,$border_color);
imageCopyResized($newimage,$im,$border,$border,0,0,$width,$height,$width,$height);
imagepng($newimage, './qrcodes/'."QR".$documento.'.png');
//imagepng($image);
imagedestroy($newimage); // Limpiar la memoria*/









 //$documentocarga = '33275201';
 //$credencial = './credenciales/'.$documentocarga.'.png';
            //echo "<p style='text-align:center;'><img class='img-fluid' src='$credencial'><br></p>";
            //echo '<br>';
            //echo '<br>';


 //$salida = estabajaafiliado('32577145');
 //32577145 DE BAJA
 //30965451 
 /*if($salida){
  echo "ESTA DE BAJA";
}
else{
  echo "NO ESTA DE BAJA";
}
echo '<br>';*/

//funciona
//crede('30965451');
/*
$salida = crede('30965451');
if($salida){
  echo "HAY CREDENCIAL";
}
else{
  echo "NO HAY CREDENCIAL";
}
*/
//echo "<p style='text-align:center;'><img src='$salida'><br></p>";


//Devuelve el qr
/*
function obtenerqr($documento){
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
  return $codigoqr;
}


function crede($documento){
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
  $font_path = __DIR__.'\arial.ttf';
  
  imagettftext($image, 13, 0, 35, 350, $color, $font_path, $apellido); // Colocar el texto 1 en la imagen
  imagettftext($image, 13, 0, 35, 370, $color, $font_path, $nombre); // Colocar el texto 2
  imagettftext($image, 13, 0, 35, 390, $color, $font_path, $documento);
  imagecopymerge($image, $image2, 410, 240, 0, 0, 156, 156, 100);
  if(imagepng($image, './credenciales/'.$documento.'.png')){
    imagedestroy($image); // Limpiar la memoria
    return true;
  }
  else{
    return false;
  }
  //imagepng($image);
  //imagedestroy($image); // Limpiar la memoria
  //header ("Location: http://192.168.0.14/mutualWeb/credencial.php");
}
*/
/*$salida = crearcrede('30965451');
if($salida){
  echo "HOLA";
}
else{
  echo "CHAU";
}
*/

/*function crearcrede($documento){
  $salida  = habilitados($documento);//Obtengo datos del afiliado
  $apellido = $salida['apellido'];
  $nombre = $salida['nombre'];

  header('Content-type: image/png');
  $image = imagecreatefrompng('./imagenes/credencial5.png');
  // Asignar el color para el texto
  $color = imagecolorallocate($image, 255, 255, 255);
  // Asignar la ruta de la fuente
  $font_path = __DIR__.'\arial.ttf';
  $font_file = 'Arial.ttf'; // This is the path to your font file.
  /// imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
  imagettftext($image, 13, 0, 35, 350, $color, $font_path, $apellido); // Colocar el texto 1 en la imagen
  imagettftext($image, 13, 0, 35, 370, $color, $font_path, $nombre); // Colocar el texto 2
  imagettftext($image, 13, 0, 35, 390, $color, $font_path, $documento);
  imagecopymerge($image, $codigoqr, 410, 240, 0, 0, 156, 156, 100);
  imagepng($image, './credenciales/'.$documento.'.png');
  //imagepng($image);
  imagedestroy($image); // Limpiar la memoria
  //header ("Location: http://192.168.0.14/mutualWeb/credencial.php");
}*/

/*
$baja = estabajaafiliado('32577145');
if($baja){
  echo "ESTA DE BAJA";
}else{
  echo "NO ESTA DE BAJA";
}


echo '<br>';
echo '<br>';
$doc = '30965451';*/

/*
if(file_exists('./qrcodes/'.$doc.'.png')){
  echo "EXISTE ARCHIVO";
}
else{
  echo "NO EXISTE";
}
echo '<br>';
echo '<br>';

$salida = crearcredencial('32645707');*/
?>
</div>
</body>
</html>

<?php
//$salida = crearcredencial('32645707');




/*
$origen = imagecreatefrompng('./imagenes/credencial5.png');
$destino = imagecreatefrompng('./qrcodes/30965451.png');
$contenedor = imagecreatetruecolor(imagesx($destino), imagesy($destino));
 
//ver el tamaño de la original
// Copiar
imagecopy($contenedor, $destino, 0, 0, 0, 0, imagesx($destino), imagesy($destino));
imagecopy($contenedor, $origen, 0, 0, 0, 0, imagesx($origen), imagesy($origen));
header('Content-Type: image/png');
imagejpeg($contenedor);
*/
/*
echo '<br/>';
$documento = '34117302';
$nombre = 'ARACELI ANDREA CELESTE';
$apellido = 'BARAHONA PARADA';
echo '<br/>';echo '<br/>';echo '<br/>';
*/

?>
<!--canvas id="ejemplo1" width="600" height="400">
  <img src="./imagenes/Credencial-virtual2.jpg" style="border-radius:5%;">
  <div class="centrado10" style="position: absolute; top: 68%; left: 3%; color: white; font-family: Times; font-size: 18px; font-weight: normal;">RUBIO GARCES</div>
  <div class="centrado11" style="position: absolute; top: 75%; left: 3%; color: white; font-family: Times; font-size: 18px; font-weight: normal;">PATRICIO HERNAN</div>
  <div class="centrado12" style="position: absolute;top: 83%;left: 3%;color: white;font-family:Times;font-size: 18px;font-weight: normal;">32754564</div>
   
</canvas-->



<!--div id="canvas_container">
<canvas id="ejemplo1" width="600" height="500">
</canvas>
</div>
<button onclick="generarcredencial()">MOSTRAR CREDENCIAL</button-->


<script type="text/javascript">
  /**
function generarcredencial(){
      var micanvas = document.getElementById("ejemplo1");
      var ctx = micanvas.getContext("2d");

      var miimagen = new Image();
      var miimagen2 = new Image();
      var texto1 = 'ARACELI ANDREA CELESTE';
      var texto2 = 'BARAHONA PARADA';
      var doc = '32775663';
      miimagen.src = "./imagenes/credencial5.jpg";
      miimagen2.src = "./qrcodes/30965451.png";

      miimagen.onload = function(){
        ctx.fillStyle="white";
        ctx.drawImage(miimagen,0,0);
        ctx.drawImage(miimagen2,410,235);
        ctx.font="18px Times";
        ctx.fillText(texto1,28,335);
        ctx.fillText(texto2,28,360);
        ctx.fillText(doc,28,385);
      }
}
**/
</script>

<?php
  //$tamanio = count($array);
  //echo $tamanio;

  /*$i=0;
  while ($i< $tamanio){
    echo $array[$i]." ";
    $i=$i+1;
  }*/

/*include('phpqrcode/qrlib.php');
$content = "http://areimilla.cl";
QRcode::png($content,"hola.png",QR_ECLEVEL_L,10,2);
echo "<img src='hola.png'/>";*/

//$salida = generarqr('30965451');
//echo $salida;

/*
header('Content-type: image/png');
$image = imagecreatefrompng('./imagenes/credencial3.png');
// Asignar el color para el texto
$color = imagecolorallocate($image, 255, 255, 0);

// Asignar la ruta de la fuente
$font_path = __DIR__.'\arial.ttf';
$text = "TEXTO DINAMICO EN IMAGEN"; // Texto 1
$text2 = "OTRA LINEA DE TEXTO CON PHP"; // Texto 2

/// imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
imagettftext($image, 80, 0, 100, 200, $color, $font_path, $text); // Colocar el texto 1 en la imagen
imagettftext($image, 80, 0, 100, 1000, $color, $font_path, $text2); // Colocar el texto 2
imagepng($image); // Enviar el contenido al navegador
imagedestroy($image); // Limpiar la memoria
*/

/*
$salida = existeAfiliado('29154195');
if($salida){//true
	echo "Existe afiliado y No esta de baja";
}
else{
	echo "No existe afiliado";
}
*/

/*$salida2 = estaHabilitado('23529404');
if($salida2){//true
	echo "Esta habilitado";
}
else{
	echo "No esta habilitado";
}*/

/*$fechaprueba=null;
$salida3 = diferenciafechas($fechaprueba);
echo $salida3;*/


/*$documento = '32334100';
$resultArray = titularCargas($documento);
$arrayTitular = datosTitular($resultArray);
$apellido = $arrayTitular['apellido'];
$nombre = $arrayTitular['nombre'];
$nombrecompleto = $apellido." ".$nombre;
$salida = generarmensaje($nombrecompleto, $documento);
echo $salida;*/

/*function diferenciafechas($fechacodigo){
  $fechaactual = obtenerfecha(); //Obtengo fecha actual
  $day1 = strtotime($fechacodigo);
  $day2 = strtotime($fechaactual);
  $diffHours = ($day2 - $day1) / 3600; //Comparo la diferencia entre fechas
  return $diffHours;
}

function obtenerfecha(){
  date_default_timezone_set('America/Argentina/Buenos_Aires');
  $hoy=date("Y-m-d H:i:s",time());
  return $hoy;
}*/

/*
function generarmensaje($nombrecompleto, $documentoAfiliado){
  $mensaje = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title></head><body>
    <div class="contenedor">
    <div class="credencial">
      <img src="https://tramitesonline.mppneuquen.com.ar/imagenes/credencial3.jpg">
      <div class="centrado">'.$nombrecompleto.'</div>
      <div class="centrado2">'.$documentoAfiliado.'</div>
      <img class="centrado3" src="imagenes/qr1.jpg">
    </div></div></body></html>';
  return $mensaje;
}
*/
?>

<style>

#canvas_container{
  border-radius: 10px;
}
.contenedor{
  text-align: center;
}
.credencial{
    position: relative;
    display: inline-block;
    /*width: 820px; 
    margin-left: auto; 
    margin-right: auto;*/
    background: white;
}
.centrado{
    position: absolute;
    top: 65%;
    left: 5%;
    color: white;
    font-family: 'times';
    font-size: 16px;
    font-weight: normal;
}
.centrado2{
    position: absolute;
    top: 75%;
    left: 5%;
    color: white;
    font-family: 'times';
    font-size: 16px;
    font-weight: normal;
}

.centrado3{
    position: absolute;
    top: 50%;
    left: 71%;
    height: 40%;
}


.caja{
  position: relative;
  display: inline-block;
}
.texto1{
  position: absolute;
  top: 10px;
  left: 10px;
  font-size: 20px;
}

.texto1{
  position: absolute;
  top: 50px;
  left: 10px;
  font-size: 20px;
}

</style>
