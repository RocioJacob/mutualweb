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
include("estiloMW.php");
?>
<head><title>Deuda</title></head>
<body>
  <div class="container">
    <div id="saludo"><?php echo $nombre?></div>
    <hr/>
      <a href="cuenta-corriente.php" class="btn" id="botonMenu" title="CUENTA CORRIENTE">Cta Corriente</a>
      <h2 id="titulo">DEUDA</h2>
    <hr/>

<!-- Para computadora -->
    <!--div class="d-none d-sm-none d-md-block"--> 
    <?php
    echo '<br>';
      //$fecha = '15/01/2021';
      $resultArray1 = deuda($documento, 1);
      $resultArray2 = deuda($documento, 0);
      $resultArray3 = debitos($documento);
       
       if((!hayConexion($resultArray1)) or (!hayConexion($resultArray2)) or (!hayConexion($resultArray3))){
            echo "PROBLEMAS DE CONEXIÓN CON LA BASE DE DATOS";
        }
        else{
          //echo "HAY CONEXIÓN CON LA BASE DE DATOS";
          $arraydeuda1 = datosdeuda($resultArray1);
          $arraydeuda2 = datosdeuda($resultArray2);
          $arraydebitos = datosdeuda($resultArray3);
          
          //Devuelve solo deuda de cuota y consumo
          if (!array_key_exists('message', $arraydeuda1)) { //TIENE DEUDA
            $arraycuenta = obtenerDeuda($arraydeuda1['deuda']);
            $deudacuotatotal = $arraydeuda1['cuota'];
            $deudaconsumototal = $arraydeuda1['consumo'];
          }
          
          //Devuelve solo deuda de cuota y consumo vencida
          if (!array_key_exists('message', $arraydeuda2)) {
            $deudacuotavencida = $arraydeuda2['cuota'];
            $deudaconsumovencida = $arraydeuda2['consumo'];
          }
 
          //ULTIMOS DEBITOS
          //$arraydebitos = json_decode($resultArray3, true);//Paso a json para ver si esta vacio
          if (!array_key_exists('message', $arraydebitos)) {
            $arraydebitos = datosdebitos($resultArray3);
          }

        ?>
        <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
            <td id="fila">Operacion</td>
            <td id="fila">Periodo</td>
            <td id="fila">Vencimiento</td>
            <td id="fila">Cuota</td>
            <td id="fila">Concepto</td>
            <td id="fila">Saldo</td>

            <?php
      if (!array_key_exists('message', $arraydeuda1)) { 
            
            $longitud = count($arraycuenta);
            $i=0;
            while ($i < $longitud){ ?>
                <tr>
                  <td id="detalle"> <?php echo $arraycuenta[$i]['operacion'];?></td>
                  <td id="detalle"> <?php echo $arraycuenta[$i]['periodo'];?></td>
                  <td id="detalle"> <?php echo $arraycuenta[$i]['vencimiento'];?></td>
                  <td id="detalle"> <?php echo $arraycuenta[$i]['cuota']."/".$arraycuenta[$i]['cantidad'];?></td>
                  <td id="detalle1"> <?php echo $arraycuenta[$i]['concepto'];?></td>
                  <td id="detalle"> <?php echo "$".number_format($arraycuenta[$i]['saldo'], 2);?></td>
                </tr>
                <?php $i=$i+1;
              } ?>

              <tr>
                <td id="detalle2"></td>
                <td id="detalle2"></td>
                <td id="detalle2"></td>
                <td id="detalle2"></td>
                <td id="detalle2"><?php echo "DEUDA TOTAL VENCIDA CUOTA SOCIAL"?></td>
                <td id="detalle2"><?php echo "$".number_format($deudacuotavencida, 2);?></td>
              </tr>
              <tr>
                <td id="detalle2"></td>
                <td id="detalle2"></td>
                <td id="detalle2"></td>
                <td id="detalle2"></td>
                <td id="detalle2"><?php echo "DEUDA TOTAL VENCIDA CONSUMOS"?></td>
                <td id="detalle2"><?php echo "$".number_format($deudaconsumovencida, 2);?></td>
              </tr>

              <?php if(($deudacuotavencida!=$deudacuotatotal) && 
              ($deudaconsumovencida!=$deudaconsumototal)) {?>
                <tr>
                  <td id="detalle2"></td>
                  <td id="detalle2"></td>
                  <td id="detalle2"></td>
                  <td id="detalle2"></td>
                  <td id="detalle2"><?php echo "DEUDA TOTAL CUOTA SOCIAL"?></td>
                  <td id="detalle2"><?php echo "$".number_format($deudacuotatotal, 2);?></td>
                </tr>
                <tr>
                  <td id="detalle2"></td>
                  <td id="detalle2"></td>
                  <td id="detalle2"></td>
                  <td id="detalle2"></td>
                  <td id="detalle2"><?php echo "DEUDA TOTAL CONSUMOS"?></td>
                  <td id="detalle2"><?php echo "$".number_format($deudaconsumototal, 2);?></td>
                </tr>
              <?php } 
      }?>
          </table>
        </div>
          <?php 
      echo '<br>'; echo '<br>';
      //echo count($arraydebitos);
      ?>

      <div class="table-responsive">
      <table class="table table-bordered">
        <tr>
          <td id="fila">Periodo</td>
          <td id="fila">Destino</td>
          <td id="fila">Monto Informado</td>
          <td id="fila">Monto Cobrado</td>
          <td id="fila">Estado</td>

          <?php
          if (!array_key_exists('message', $arraydebitos)) {  
              $longitud = count($arraydebitos);
          }?>
            <h5 id="titulo">HISTORIAL DE MONTOS INFORMADOS</h5> <br>
          <?php
          if (!array_key_exists('message', $arraydebitos)){ 
            $i=0;
            while ($i < $longitud){ ?>
              <tr>
                <td id="detalle"> <?php echo $arraydebitos[$i]['periodo'];?></td>
                <td id="detalle"> <?php echo $arraydebitos[$i]['destino'];?></td>
                <td id="detalle"> <?php echo "$".number_format($arraydebitos[$i]['informado'], 2);?></td>
                <td id="detalle"> <?php echo "$".number_format($arraydebitos[$i]['cobrado'], 2);?></td>
                <td id="detalle"> <?php echo $arraydebitos[$i]['estado'];?></td>
              </tr>
              <?php
                $i=$i+1;
            }
          }?>
        </tr>
      </table>
    </div>

  <?php
   } 
    echo '<br>';?>
    <!--/div--><!-- Para computadora-->


  </div>
</body>
</html>

<?php
function obtenerDeuda($resultArray){
  $array = [];
  $i = 0;
  foreach($resultArray as $key=>$data){
    foreach($data as $clave=>$elemento){
      $array[$i][$clave] = $elemento;
    }
    $i = $i+1;
  }
  return $array;
}

function datosdebitos($response){
  $resultArray = json_decode($response, true);
  $arrayTitular = obtenerDeuda($resultArray);
  return $arrayTitular;
}
?>


<script type="text/javascript">
  

</script>