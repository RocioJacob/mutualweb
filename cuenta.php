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
          <button type="button" class="btn boton" onclick="window.location='cambiar-clave.php'">Cambiar contaseña</button>
        </div>
        <br/>

         <div class="container text-center h-100 d-flex justify-content-center align-items-center">
          <button type="button" class="btn boton" onclick="window.location='historial.php'">Historial</button>
        </div>
        <br/>

        <div class="container text-center h-100 d-flex justify-content-center align-items-center">
          <button type="button" class="btn boton" onclick="window.location='actualizaciones.php'">Actualizar</button>
        </div>
        <br/>

      </div>
      <br/>
     </div>
  </div>
</body>
</html>



