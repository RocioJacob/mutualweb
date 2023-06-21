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
//include("conexion.php");
include('head.php');
include('navegacion.php');
include ('estiloMW.php');
?>
<head><title>Contacto MPPN</title></head>
<body>
  <div class="container">
    <div id="saludo"><?php echo $nombre?></div>
    <hr/>
    <div><h2 id="titulo"><img src="imagenes/iconos de redes sociales/whatsapp.ico" id="iconos">     NUMEROS DE CONTACTO<img src="imagenes/iconos de redes sociales/telegram.ico"id="iconos"></h2></div>
    
    <hr/>
    
<!-- Para computadora -->
    <!--div class="d-none d-sm-none d-md-block"-->
      <div class="container">
        <p>LINEA DE CONSULTAS GENERALES 299 621-8064 </p>
        <p>SUPERVISION 299 476-5773</p>
        <p>ASISTENCIALES 299 406-3130</p>
        <p>AFILIACIONES 299 404-6203</p>
        <p>TURISMO 299 476-6777</p>
        <p>MESA DE ENTRADA 299 476-5767</p>
        <br/>
        
      </div>
    <hr/>
      <div><a id="titulo"><img id="red" src="imagenes/iconos de redes sociales/internet.png">REDES SOCIALES<img id="red" src="imagenes/iconos de redes sociales/internet.png"></a></div>
      
    <hr/>
    <div>
      <a href="https://twitter.com/mutualpolnqn1"><img id="red" src="imagenes/iconos de redes sociales/TWITTER.ico">TWITTER</a><br>
      <a href="https://www.facebook.com/mutualpolicial.neuquen"><img id="red" src="imagenes/iconos de redes sociales/facebook.ico">FACEBOOK</a><br>
      <a href="https://mppneuquen.com.ar/"><img id="red" src="imagenes/iconos de redes sociales/web.ico">PAGINA WEB</a>
    </div>
    <!--/div-->

    <!-- Para celular -->
  <!--div class="d-block d-sm-block d-md-none">
    <div class="container">
      <img src="./imagenes/contactos4.jpg">
      <br/>
    </div>
  </div-->
      
      <!--div class="row align-items-start">
        <div class="col" style="font-family: 'Georgia', cursive; font-size: 20px;color: #0072BC">AFILIACIONES</div><br>
        <div class="col"><img src='./imagenes/logo whatsapps1.jpg' height='50' width='50' align="center"> 2994046203</a></div>
        <div class="col"></div>
        <div class="col"></div>
      </div>
      <br>

      <div class="row align-items-start">
        <div class="col" style="font-family: 'Georgia', cursive; font-size: 20px;color: #0072BC">TURISMO</div><br>
        <div class="col"><img src='./imagenes/logo whatsapps1.jpg' height='50' width='50' align="center"> 2994766777</a></div>
        <div class="col"></div>
        <div class="col"></div>
      </div>
      <br>

      <div class="row align-items-start">
        <div class="col" style="font-family: 'Georgia', cursive; font-size: 20px;color: #0072BC">ASISTENCIALES</div><br>
        <div class="col"><img src='./imagenes/logo whatsapps1.jpg' height='50' width='50' align="center"> 2994063130</a></div>
        <div class="col"></div>
        <div class="col"></div>
      </div>
      <br-->
  </div>
  <br>
  <br>
</body>
</html>


