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
include("conexion.php");
include('head.php');
include('navegacion.php');
include("estiloMW.php");
?>
<head> <title>Actualizaciones</title></head>
<body>
  <div class="container">
    <div id="saludo"><?php echo $nombre?></div>
    <hr/>
    <h2 id="titulo">SOLICITUDES DE ACTUALIZACIONES</h2>
    <hr/>

      <div class="container" id="containerMenu">
      <div class="table-responsive">

      <?php
        $query="SELECT * FROM tramites_dos WHERE documento='$documento' ORDER BY id ASC";
        $result=$conexion->query($query);
      
      if($result->num_rows > 0){ //si se obtuvieron resultados ?>
        
        <table class="table table-bordered">
          <thread>
          <tr class="p-3 mb-2 bg-secondary text-white">
          <td id="fila">ID DE TRAMITE</td>
          <td id="fila">TRAMITE</td>
          <td id="fila">FECHA</td>
          <td id="fila">MAS</td>
          </tr>
          </thread>

      <?php  while($row = $result->fetch_assoc()){ 
              $mensaje = $row['tramite'];  
              //$id = $row['id'];
              ?>
                
                <tr>
                <td id="fila1"><?php echo $row['id']?></td>
                <td id="fila1"><?php echo $row['tramite']?></td>
                <td id="fila1"><?php echo $row['fecha']?></td>
                <td><a href=detalles-actualizaciones.php?id=<?php echo $row['id']?> class="btn" id="botonver">Ver</a></td>
                </td>
                </tr> 

                
      <?php  } ?>
          
        </table>
<?php } ?>

      </div>
      <br/>
    </div>


<script type="text/javascript">
$(document).on('click', '.ver', function(){
  var id = $(this).data('id');
  window.location.href = 'http://192.168.0.14/mutualWeb/menu.php';
  //console.log(id);
})

</script>


    

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