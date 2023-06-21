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
include("conexion.php");
include('head.php');
include('navegacion.php');
?>
<body>
  <div class="container">
    <div id="saludo"><?php echo $nombre?></div>
    <hr/>
  
    <h2 id="titulo">MI HISTORIAL</h2>
    <hr/>

<!-- Para computadora -->
    <!--div class="d-none d-sm-none d-md-block"-->
      <div class="container" id="containerMenu">
      <div class="container text-center h-100 d-flex justify-content-center align-items-center">

      <?php
        $query="SELECT * FROM tramites_uno WHERE documento='$documento' ORDER BY id ASC";
        $result=$conexion->query($query);
      
      if($result->num_rows > 0){ //si se obtuvieron resultados ?>
        
        <table class="table table-bordered">
          <thread>
          <tr class="p-3 mb-2 bg-secondary text-white">
          <td id="fila">ID</td>
          <td id="fila">TRAMITE</td>
          <td id="fila">FECHA</td>
          <td id="fila">DELEGACION</td>
          <td id="fila">ESTADO</td>
          </tr>
          </thread>

      <?php  while($row = $result->fetch_assoc()){ 
              $mensaje = $row['tramite'];  
              $id = $row['id'];
              ?>
                <tr>
                <td id="fila1"><?php echo $row['id']?></td>
                <td id="fila1"><?php echo $row['tramite']?></td>
                <td id="fila1"><?php echo $row['fecha']?></td>
                <td id="fila1"><?php echo $row['delegacion']?></td>
                <td id="fila1"><?php echo $row['estado']?></td>
                </tr>
                <th colspan="5" scope="rowgroup" style="font-size: 15px; text-align: left;font-family: 'italic'; border-color: #3A73A8; font-weight: normal;"><?php echo "COMENTARIO: ".$row['comentario']?></th>    
      <?php  } ?>
          
        </table>
<?php } ?>

      </div>
      <br/>
    </div>
    <!--/div--><!-- Para computadora -->
</div>
</body>
</html>



<script type="text/javascript">

function ver(mensaje) { 
  mensajeError(mensaje);
}

function mensajeError($mensaje){
    swal.fire({
      title: $mensaje, 
      icon: 'error',
      width:'650px',
      allowOutsideClick: false,
    });
}

function verdatos(){
  console.log("HOLAAAA");
  var elms = document.getElementsByClassName("datos");

  Array.from(elms).forEach((x) => {
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  })
}

function mandarId(id){
  alert(id);
 }

</script>