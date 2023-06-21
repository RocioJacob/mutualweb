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
include ('estiloMW.php');
?>
<head><title>Credencial</title></head>
<body>
  <div class="container">
    <div id="saludo"><?php echo $nombre?></div> 
    <hr/>
    
    <a id="titulo">CREDENCIAL DIGITAL</a>
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
              <div style="font-family: 'Georgia' cursive; font-size: 30px; color: #3A73A8; text-align: center;">TITULAR</div>
              <?php //creo un nro aleatorio para que me muestre la imagen actualizada
              //Si muestra mal la imagen del qr es por la barra del final de la etiqueta img que no esta
                //echo "<p style='text-align:center;'>
                  //<img class='img-fluid' src='$credencial?x=<?=md5(time())?/>'>
                  //<br></p>";
                //echo '<br>';
                mostrarcredencialtitular($documento);
        
            if(tienecargasdealta($documento)){ ?>
              <div style="font-family: 'Georgia' cursive; font-size: 30px; color: #3A73A8; text-align: center;">CARGAS</div>
              <?php
              credencialescargas($documento);//Muestro las credenciales de las cargas
            }
            //imprimir();
          }
          else{
            crearcredencial($documento);//creo la credencial del titular
            crearcredencialcarga($documento);//Creo las credenciales de las cargas
            $credencial = './credenciales/'.$documento.'.png';
            ?>
            <div style="font-family: 'Georgia' cursive; font-size: 25px; color: #3A73A8; text-align: center;">TITULAR</div>
            <?php
            mostrarcredencialtitular($documento);
            if(tienecargasdealta($documento)){ ?>
              <div style="font-family: 'Georgia' cursive; font-size: 25px; color: #3A73A8; text-align: center;">CARGAS</div>
              <?php
              credencialescargas($documento);//Muestro las credenciales de las cargas
            }
            //imprimir();
          }
        }?>
    </div>

  </div>
</body>
</html>



<script type="text/javascript">
  function descargarCredencial($documento){
    var ruta = './credenciales/'+$documento+'.png';
    var enlace = document.createElement('a');
    enlace.href = ruta;
    enlace.download = "Credencial "+$documento;
    document.body.appendChild(enlace);
    enlace.click();
    //Borrar el elemento
    enlace.parentNode.removeChild(enlace);
  }
</script>