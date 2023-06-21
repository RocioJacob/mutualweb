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
    
    <div id="saludo"><?php echo $nombre?><a href="cuenta.php" class="btn" id="botonVolver" title="VOLVER">Volver</a></div>
    <br>
    <hr/>
    
    <h2 id="titulo">DETALLES DE LA ACTUALIZACIÓN</h2>
    <hr/>
    <br>
    
    
    <?php
        $id = mysqli_real_escape_string($conexion,(strip_tags($_GET["id"],ENT_QUOTES)));
        $tramite = mysqli_query($conexion, "SELECT * FROM tramites_dos WHERE id='$id'");
        $tramite = mysqli_fetch_assoc($tramite);
        mysqli_close($conexion);
    ?>

      <div class="table-responsive" id="textoizq">
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

        <div id="titulo">Datos enviados</div>

        <?php if ($tramite['nombre']!=''){ ?>
          <tr>
            <th style="color: #3A73A8;">NOMBRE</th>
            <td><?php echo $tramite['nombre']; ?></td>
          </tr>
        <?php } ?>

        <?php if ($tramite['apellido']!=''){ ?>
          <tr>
            <th style="color: #3A73A8;">APELLIDO</th>
            <td><?php echo $tramite['apellido']; ?></td>
          </tr>
        <?php } ?>   

        <?php if ($tramite['cuil']!='0'){ ?>
          <tr>
            <th style="color: #3A73A8;">CUIL</th>
            <td><?php echo $tramite['cuil']; ?></td>
          </tr>
        <?php } ?>    

        <?php if ($tramite['fecha_nacimiento']!='0000-00-00'){ ?>
          <tr>
            <th style="color: #3A73A8;">FECHA DE NACIMIENTO</th>
            <?php $fecha = date("d-m-Y", strtotime($tramite['fecha_nacimiento']));?>
            <td><?php echo $fecha; ?></td>
          </tr>
        <?php } ?>  

        <?php if ($tramite['localidad']!=''){ ?>
          <tr>
            <th style="color: #3A73A8;">LOCALIDAD</th>
            <td><?php echo $tramite['localidad']; ?></td>
          </tr>
        <?php } ?>  

        <?php if ($tramite['domicilio']!=''){ ?>
          <tr>
            <th style="color: #3A73A8;">DOMICILIO</th>
            <td><?php echo $tramite['domicilio']; ?></td>
          </tr>
        <?php } ?>  

        <?php if ($tramite['legajo']!='0'){ ?>
          <tr>
            <th style="color: #3A73A8;">LEGAJO</th>
            <td><?php echo $tramite['legajo']; ?></td>
          </tr>
        <?php } ?> 

        <?php if ($tramite['celular']!=''){ ?>
          <tr>
            <th style="color: #3A73A8;">CELULAR</th>
            <td><?php echo $tramite['celular']; ?></td>
          </tr>
        <?php } ?>

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


