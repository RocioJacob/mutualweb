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
<head><title>Cuenta corriente</title></head>
<body>
  <div class="container">
    <div id="saludo"><?php echo $nombre?></div>
    <hr/>
    <a href="deuda.php" class="btn" id="botonMenu" title="DEUDA">DEUDA</a>
    <h2 id="titulo">CUENTA CORRIENTE</h2>
    <hr/>
    <p><img title="GENERADO" src="./imagenes/mas1.jpg" width="25" height="25"> GENERADO <img title="DESCONTADO"src="./imagenes/menos1.jpg" width="25" height="25"> DESCONTADO</p>


<!-- Para computadora -->
    <!--div class="d-none d-sm-none d-md-block"--> 
    <?php 
    echo '<br>';
          $resultArray = cuentacorriente($documento);
          $arraycuentacorriente = json_decode($resultArray, true);//Paso a json para ver si esta vacio
          if (!array_key_exists('message', $arraycuentacorriente)) {
            $arraycuentacorriente = datoscuentacorriente($resultArray);
          }
        ?>
        <div class="table-responsive">
        <table class="table table-bordered">
          <tr>
          <td id="fila">Operacion</td>
          <td id="fila">Fecha</td>
          <td id="fila">Concepto</td>
          <td id="fila">Debe</td>
          <td id="fila">Haber</td>
          <td id="fila">Saldo</td>
          <td id="fila">Detalle</td>
          <td id="fila">Imputacion</td>
          <td id="fila"></td>

        <?php
    if (!array_key_exists('message', $arraycuentacorriente)){
          $longitud = count($arraycuentacorriente);
          $i=0;
          while ($i < $longitud) {
          ?>
          <tr>
            <td id="detalle"> <?php echo $arraycuentacorriente[$i]['operacion'];?></td>
            <td id="detalle"> <?php echo $arraycuentacorriente[$i]['fecha'];?></td>
            <td id="detalle"> <?php echo $arraycuentacorriente[$i]['concepto'];?></td>
            <td id="detalle"> <?php echo $arraycuentacorriente[$i]['debe'];?></td>
            <?php if($arraycuentacorriente[$i]['haber']!='0.00'){?> 
              <td id="detalle1"> <?php echo $arraycuentacorriente[$i]['haber'];?></td>
            <?php }else{?>
              <td id="detalle"> <?php echo $arraycuentacorriente[$i]['haber'];?></td>
            <?php }?>
            <td id="detalle2"> <?php echo $arraycuentacorriente[$i]['saldo'];?></td>
            <td id="detalle"> <?php echo $arraycuentacorriente[$i]['detalle'];?></td>
            <td id="detalle"> <?php echo $arraycuentacorriente[$i]['imputacion']; ?> </td>
            <td id="detalle"> <?php if($arraycuentacorriente[$i]['debe']!='0.00'){?> <img title="GENERADO" src="./imagenes/mas1.jpg" width="25" height="25"></td><?php }
            else{ ?><img title="DESCONTADO" src="./imagenes/menos1.jpg" width="25" height="25"></td><?php
            }
            ?>
          </tr>
          <?php
            $i=$i+1;
          }
      }
        ?>
        </tr>
        </table>
        </div>

      <?php  echo '<br>';?>
      
    <!--/div--><!--Para computadora-->

    


  </div>
</body>
</html>

