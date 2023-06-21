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
include("estiloMW");
?>
<body>
  <div class="container">
    <div id="saludo"><?php echo $nombre?></div> 
    <hr/>
    <h2 id="titulo">CREDENCIAL DIGITAL</h2>
    <hr/>

<!-- Para computadora -->
    <!--div class="d-none d-sm-none d-md-block"-->
    <div class="table-responsive"> 
      <?php
      $resultArray = habilitados($documento);

        if(!hayConexion($resultArray)){
            echo "PROBLEMAS DE CONEXIÓN CON LA BASE DE DATOS";
        }
        else{
          echo '<br/>';
          if(tienecredencial($documento)){
            crearcredencialcarga($documento);//Creo las credenciales de las cargas faltantes
            $credencial = './credenciales/'.$documento.'.png';
            ?>
              <div id="titulo">TITULAR</div>
              <?php //creo un nro aleatorio para que me muestre la imagen actualizada
                echo "<p style='text-align:center;'>
                  <img class='img-fluid' src='$credencial?x=<?=md5(time())?>'>
                  <br></p>";
                echo '<br>';
            if(tienecargasdealta($documento)){ ?>
              <div id="titulo">CARGAS</div>
              <?php
              credencialescargas($documento);//Muestro las credenciales de las cargas
            }
            imprimir();
          }

          else{
            crearcredencial($documento);//creo la credencial del titular
            crearcredencialcarga($documento);//Creo las credenciales de las cargas
            $credencial = './credenciales/'.$documento.'.png';
            ?>
            <div id="titulo">TITULAR</div>
            <?php
              echo "<p style='text-align:center;'>
                <img class='img-fluid' src='$credencial?x=<?=md5(time())?>'>
                <br></p>";
              echo '<br>';
            if(tienecargasdealta($documento)){ ?>
              <div id="titulo">CARGAS</div>
              <?php
              credencialescargas($documento);//Muestro las credenciales de las cargas
            }
            imprimir();
          }
        }?>
    </div>

  </div>
</body>
</html>
