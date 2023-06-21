<?php  
/*session_start();
if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 10)) {
    session_unset(); 
    session_destroy();
    echo "session destroyed"; 
}
$_SESSION['start'] = time();*/


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

<body>
  <div class="container">
    <div id="saludo"><?php echo $nombre?></div> 
    <hr/>
    <p id="titulo">MENU</p> 
    <hr/>
<!-- Para computadora -->
    <!--div class="d-none d-sm-none d-md-block"--> 
    <div class="container" >
      <div id="containerMenu">
        <a href="datos-personales.php"><img id="img-menu" src="imagenes/datos-personales.gif"></a>
        <a href="cuenta-corriente.php"><img id="img-menu" src="imagenes/cuenta-corriente.gif"></a>
        <a href="tramites.php"><img id="img-menu" src="imagenes/tramites.gif"></a>
        <a href="facturas.php"><img id="img-menu" src="imagenes/recibos.gif"></a>
        
        <!--button type="button" class="btn boton" onclick="window.location='datos-personales.php'">DATOS PERSONALES</button>
        <button type="button" class="btn boton" onclick="window.location='cuenta-corriente.php'">CUENTA CORRIENTE</button>
        <button type="button" class="btn boton" onclick="window.location='tramites.php'">TRAMITES</button-->
      </div>
      <br/>
      <div id="containerMenu">
        <!--a href="ver-ejercicios.php">
          <img id="img-menu" src="imagenes/ejercicios-economicos.gif" width="225" height="225" HSPACE="10" VSPACE="10">
        </a-->
        <a href="contactos.php"><img id="img-menu" src="imagenes/contactos.gif"></a>
        <a href="cuenta.php"><img id="img-menu" src="imagenes/mi-cuenta.gif"></a>
        <a href="notificaciones.php"><img id="img-menu" src="imagenes/notificaciones.gif"></a>
        <a href="credencial.php"><img id="img-menu" src="imagenes/credencial2.gif"></a>
        <!--button type="button" class="btn boton" onclick="window.location='ver-facturas.php'">FACTURAS</button>
        <button type="button" class="btn boton" onclick="window.location='cuenta.php'">MI CUENTA</button>
        <button type="button" class="btn boton" onclick="window.location='mensajes.php'">MENSAJES</button-->
      </div>
    <!--/div-->
    </div>
    <br>
    <br>

  <!-- Para celular -->
    <!--div class="d-block d-sm-block d-md-none">

        <div class="container text-center h-100 d-flex justify-content-center align-items-center">
          <a href="datos-personales.php">
            <img id="img-menu" src="imagenes/datos-personales.gif" width="200" height="200" HSPACE="10" VSPACE="10">
          </a>
          <a href="cuenta-corriente.php">
            <img id="img-menu" src="imagenes/cuenta-corriente.gif" width="200" height="200" HSPACE="10" VSPACE="10">
          </a>
        </div>
        <br/>

        <div class="container text-center h-100 d-flex justify-content-center align-items-center">
            <a href="tramites.php">
              <img id="img-menu" src="imagenes/tramites.gif" width="200" height="200" HSPACE="10" VSPACE="10">
            </a>
            <a href="facturas.php">
              <img id="img-menu" src="imagenes/recibos.gif" width="200" height="200" HSPACE="10" VSPACE="10">
            </a>
        </div>
        <br/>

        <div class="container text-center h-100 d-flex justify-content-center align-items-center">
            <a href="contactos.php">
              <img id="img-menu" src="imagenes/contactos.gif" width="200" height="200" HSPACE="10" VSPACE="10">
            </a>
            <a href="cuenta.php">
              <img id="img-menu" src="imagenes/mi-cuenta.gif" width="200" height="200" HSPACE="10" VSPACE="10">
            </a>
        </div>
        <br/>

        <div class="container text-center h-100 d-flex justify-content-center align-items-center">
            <a href="notificaciones.php">
              <img id="img-menu" src="imagenes/notificaciones.gif" width="200" height="200" HSPACE="10" VSPACE="10">
            </a>
            <a href="credencial.php">
              <img id="img-menu" src="imagenes/credencial2.gif" width="200" height="200" HSPACE="10" VSPACE="10">
            </a>
        </div>
        <br/>

    </div>

  </div-->
</body>
</html>

