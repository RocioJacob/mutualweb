<?php  
session_start();
if (!isset($_SESSION['documento'])) {
  header('Location: isMW.php');
}
else{
  $documento = $_SESSION['documento'];
  include('funciones.php');
  $nombre = sesionafiliado($documento);
}
?>

  <!DOCTYPE html>
  <html lang="es">
  <?php 
  include('head.php');
  include('navegacion.php');
  include("conexion.php");
  ?>
  <body>
    <div class="container">
      <div id="saludo"><?php echo $nombre?></div>
      <hr/>
      <h2 id="titulo">NOTIFICACIONES</h2> 
      <hr/>
      
      <div class="table-responsive"> 
      <?php
        $tabla = "";
        $query="SELECT * FROM mensajes ORDER BY id DESC";
        $result=$conexion->query($query);
        if($result->num_rows > 0){ //si se obtuvieron resultados

          $tabla.= '<table class="table table-hover table-bordered">
          <thread>
          <tr class="p-3 mb-2 bg-secondary text-white">
          <td id="fila">FECHA</td>
          <td id="fila">MENSAJE</td>
          </tr>
          </thread>';

              while($row = $result->fetch_assoc()){
                $fechaHora = $row['fecha_generacion'];
                $fechaComoEntero = strtotime($fechaHora);
                $fecha = date("d-m-Y", $fechaComoEntero);
                $tabla.='<tr id="datos">
                <td>'.$fecha.'</td>
                <td>'.$row['mensaje'].'</td>
                </tr>';
              }
          $tabla.='</table>';
          echo $tabla;
          echo '<br>';
        } 
      ?>
    </div>
  </div>
  </body>
  </html>

