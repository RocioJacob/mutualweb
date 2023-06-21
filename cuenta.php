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
include ('estiloMW.php');
?>
<head><title>Mi cuenta</title></head>
<body>
  <div class="container">
     <div id="saludo"><?php echo $nombre?></div>
    <hr/>
    <a id="titulo">MI CUENTA</a>
    <hr/>


<!-- Para computadora -->
    <div class="d-none d-sm-none d-md-block">
      <div class="container" id="containerMenu>
        <div class="container text-center h-100 d-flex justify-content-center align-items-center">
          <button type="button" class="btn boton" onclick="window.location='cambiar-clave.php'">CAMBIAR CONTRASEÑA</button>
          <button type="button" class="btn boton" onclick="window.location='historiales.php'">HISTORIAL DE TRÁMITES</button>
          <button type="button" class="btn boton" onclick="window.location='actualizaciones.php'">ACTUALIZACIONES</button>
        </div>
        </div>
      </div>
    </div>

<!-- Para celular -->
    <div class="d-block d-sm-block d-md-none">

      <div class="container" id="containerMenu">
        
        <div class="container text-center h-100 d-flex justify-content-center align-items-center">
          <button type="button" class="btn botonchico" onclick="window.location='cambiar-clave.php'">CAMBIAR CONTRASEÑA</button>
        </div>
        <br/>

         <div class="container text-center h-100 d-flex justify-content-center align-items-center">
          <button type="button" class="btn botonchico" onclick="window.location='historial.php'">HISTORIAL</button>
        </div>
        <br/>

        <div class="container text-center h-100 d-flex justify-content-center align-items-center">
          <button type="button" class="btn botonchico" onclick="window.location='actualizaciones.php'">ACTUALIZACIONES</button>
        </div>
        <br/>

      </div>
      <br/>
     </div>
  </div>
</body>
</html>



<style type="text/css">

body{
    /*background-color: #8faed6;*/
}
+
.container{
    /*background-color: #fff;*/
}

/*
.boton {
  /*color: #318aac !important;
  /*font-weight: 100;*/
  /*padding: 0.5em 1.2em;*/
  /*background: rgba(0,0,0,0);
  border: 2px solid;
  border-color: #2874A6;
  transition: all 1s ease;
  /*position: relative;

  position: relative;
  padding: 40px 1px; /*arriba-abajo, izq-der
  margin: 0px 10px 10px 0px;
  float: center;
  border-radius: 15px; /*redondeo de las esquinas
  /*font-family: 'Georgia', cursive;
  font-family: 'Georgia', cursive;
  font-size: 18px; /*tamaño letra
  color: white; /*color letra*/
  /*text-decoration: none;  */
 /* width: 195px !important; /*tamaño botones
  width: 250px !important;
  /*height: 300px;
  text-align: center; /*alineacion de texto
  background: #0072BC;
  /*background: #2874A6;
}
.boton:hover {
  background: white;
  color: #0072BC !important;
}
*/
.botonchico {
  border: 2px solid;
  border-color: #2874A6;
  transition: all 1s ease;

  position: relative;
  padding: 40px 1px; /*arriba-abajo, izq-der*/
  margin: 0px 10px 10px 0px;
  float: center;
  border-radius: 15px; /*redondeo de las esquinas*/
  /*font-family: 'Georgia', cursive;*/
  font-family: 'Georgia', cursive;
  font-size: 13px; /*tamaño letra*/
  color: white; /*color letra*/
  /*text-decoration: none;  */
 /* width: 195px !important; /*tamaño botones*/
  width: 250px !important;
  /*height: 300px;*/
  text-align: center; /*alineacion de texto*/
  background: #0072BC;
  /*background: #2874A6;*/
}
.botonchico:hover {
  background: white;
  color: #0072BC !important;
}
</style>