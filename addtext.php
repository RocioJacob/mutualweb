<?php
include("conexion.php");
include('funciones.php');

$imagen = './imagenes/credencial3.png';
$nombre = "pepito";
$codigoqr = "pepita";
$salida = agregartexto($imagen, $nombre);
$imagen2 = './qrcodes/originalrand.png';
//echo $salida;
?>

<img src="<?php echo $imagen2;?>" alt="Imagen del primer artículo" width="25%">

<?php

function agregartexto($imagen, $nombre){
	header('Content-type: image/png');
	$image = imagecreatefrompng($imagen);
	// Asignar el color para el texto
	$color = imagecolorallocate($image, 255, 255, 0);
	// Asignar la ruta de la fuente
	$font_path = __DIR__.'\arial.ttf';

	$text = $nombre; // Texto 1

	/// imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
	imagettftext($image, 50, 0, 100, 200, $color, $font_path, $text); // Colocar el texto 1 en la imagen
	//imagepng($image); // Enviar el contenido al navegador
	//imagedestroy($image); // Limpiar la memoria
	//$salida = imagepng($image);
	imagepng($image, './qrcodes/originalrand.png');
	//imagedestroy( $image );
	return './qrcodes/originalrand.png';
}


?> 