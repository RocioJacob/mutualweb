<?php  
session_start();
if (!isset($_SESSION['documento'])) {
  header('Location: isMW.php');
}
else{
  $documento = $_SESSION['documento'];
  $nombre = $_SESSION['nombre'];
  include('funciones.php');
  //$nombre = sesionafiliado($documento);
  if(!estaconectado()){
    return vistaconexion();
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<?php
include("conexion.php");
include('head.php');
include('navegacion.php');
include("estiloMW.php");
?>
<head><title>Detalles</title></head>
<body>
  <div class="container">
    
    <div id="saludo"><?php echo $nombre?></div>
    
    <hr/>
    <a href="historiales.php" class="btn" id="botonVolver" title="VOLVER">Volver</a>
    <h2 id="titulo">DETALLES</h2>
    <hr/>
    <br>
    
    
    <?php
        $id = mysqli_real_escape_string($conexion,(strip_tags($_GET["id"],ENT_QUOTES)));
        $tramite = mysqli_query($conexion, "SELECT * FROM tramites_uno WHERE id='$id'");
        $tramite = mysqli_fetch_assoc($tramite);
        mysqli_close($conexion);
    ?>

      <div class="table-responsive">
      <table class="table">
        
        <tr>
          <th style="border-top:1px solid white;"><div style="color: #3A73A8;">ID TRAMITE</div></th>
          <td style="border-top:1px solid white;"><?php echo $tramite['id']; ?></td>
        </tr>

        <tr>
          <th><div style="color: #3A73A8;">FECHA DE SOLICITUD</div></th>
          <?php 
            date_default_timezone_set('UTC'); //AGREGADO
            $fecha = date("d-m-Y", strtotime($tramite['fecha']));
          ?>
          <td><?php echo $fecha; ?></td>
        </tr>


        <tr>
          <th style="color: #3A73A8;">TRAMITE</th>
          <td><?php echo $tramite['tramite']; ?></td>
        </tr>

        <tr>
          <th style="color: #3A73A8;">DELEGACIÓN</th>
          <td><?php echo $tramite['delegacion']; ?></td>
        </tr>

        <tr>
          <th style="color: #3A73A8;">COMENTARIO</th>
          <td><?php echo $tramite['comentario']; ?></td>
        </tr>
      </table>
      </div>
        <br>



  </div>
</body>
</html>

