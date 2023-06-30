<?php  
session_start();
if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 10)) {
    session_unset(); 
    session_destroy();
    echo "session destroyed"; 
}
//$_SESSION['start'] = time();

//session_start();
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
<head><title>Datos personales</title></head>
<body>
  <div class="container">
    <div id="saludo"><?php echo $nombre?></div>
    <hr/>
    <h2 id="titulo">DATOS PERSONALES</h2>
    <hr/>
    <br>

  <!-- Para computadora -->
  <div class="d-none d-sm-none d-md-block"> 
      <?php 
        $resultArray = titularCargas($documento);
        if(!hayConexion($resultArray)){
            echo "PROBLEMAS DE CONEXIÓN CON LA BASE DE DATOS";
        }
        else{
          $arrayTitular = datosTitular($resultArray);
          $arrayCarga = datosCargas($resultArray);
      ?>

    <h4 id="titulo">TITULAR</h4>
    <div class="container table-responsive" id="textoizq">
      <div class="row">
        <div class="col"><h6>CODIGO: <a ><?php echo $arrayTitular['codigo'].'<br>';?></a></h6></div>
        <div class="col"><h6>APELLIDO: <a ><?php echo $arrayTitular['apellido'].'<br>';?></a></h6></div>
        <!--div class="col"></div-->
      </div>

      <div class="row">
        <div class="col"><h6>NOMBRE: <a ><?php echo $arrayTitular['nombre'].'<br>';?></a></h6></div>
        <div class="col"><h6>DOCUMENTO: <a ><?php echo $arrayTitular['documento'].'<br>';?></a></h6></div>
      </div>

      <div class="row">
        <div class="col"><h6>LEGAJO: <a><?php echo $arrayTitular['legajo'].'<br>';?></a></h6></div>
        <div class="col"><h6>NACIMIENTO: <a><?php echo $arrayTitular['nacimiento'].'<br>';?></a></h6></div>
      </div>

      <div class="row">
        <div class="col"><h6>CUIL: <a><?php echo $arrayTitular['cuil'].'<br>';?></a></h6></div>
        <div class="col"><h6>DIRECCION: <a><?php echo $arrayTitular['direccion'].'<br>';?></a></h6></div>
      </div>

      <div class="row">
        <div class="col"><h6>LOCALIDAD: <a ><?php echo $arrayTitular['localidad'].'<br>';?></a></h6></div>
        <div class="col"><h6>PROVINCIA: <a ><?php echo $arrayTitular['provincia'].'<br>';?></a></h6></div>
      </div>

      <div class="row">
        <div class="col"><h6>TELEFONO: <a ><?php echo $arrayTitular['telefono'].'<br>';?></a></h6></div>
                <div class="col"><h6>SSM: <a>
        <?php if($arrayTitular['ssm']=='1'){
                echo "SI".'<br>';
              }
              else{
                echo "NO".'<br>';
              }
        ?>
        </a></h6>
        </div>
      </div>

      <div class="row">
        <div class="col"><h6>FECHA DE ALTA: <a ><?php echo $arrayTitular['alta'].'<br>';?></a></h6></div>
        <div class="col"><h6>HABILITADO: <a >
          <?php if($arrayTitular['habilitado']=='1'){
            echo "SI".'<br>';
          }
          else{
            echo "NO".'<br>';
          }
        ?>
          </a></h6></div>
      </div>

      <div class="row">
        <div class="col"><h6>EMAIL REGISTRO: <a ><?php echo $arrayTitular['email2'].'<br>';?></a></h6></div>
        <div class="col"><h6>CELULAR REGISTRO: <a ><?php echo $arrayTitular['celular'].'<br>';?></a></h6></div>
      </div>

      <div class="col"></div>
      <div class="col"></div>
    </div>

<?php echo '<br>'; ?>


    <h4 id="titulo">CARGAS</h4><br>
    <table class="table table-bordered table-responsive" id="textoizq">
      <tr>
        <td id="fila">Código</td>
        <td id="fila">Carga</td>
        <td id="fila">Parentesco</td>
        <td id="fila">Apellido</td>
        <td id="fila">Nombre</td>
        <td id="fila">Documento</td>
        <td id="fila">Nacimiento</td>
        <td id="fila">Fecha alta</td>
        <td id="fila">Fecha baja</td>

      <?php 
      $longitud = count($arrayCarga);
      $i=0;
       while ( $i < $longitud) {
        ?>
        <tr>
          <td id="detalle"> <?php echo $arrayCarga[$i]['codigo']; ?> </td>
          <td id="detalle"> <?php echo $arrayCarga[$i]['carga']; ?> </td>
          <td id="detalle"> <?php echo $arrayCarga[$i]['parentesco']; ?> </td>
          <td id="detalle"> <?php echo $arrayCarga[$i]['apellido']; ?> </td>
          <td id="detalle"> <?php echo $arrayCarga[$i]['nombre']; ?> </td>
          <td id="detalle"> <?php echo $arrayCarga[$i]['documento']; ?> </td>
          <td id="detalle"> <?php echo $arrayCarga[$i]['nacimiento']; ?> </td>
          <td id="detalle"> <?php echo $arrayCarga[$i]['alta']; ?> </td>
          <td id="detalle"> <?php echo $arrayCarga[$i]['baja']; ?> </td>
        </tr>
        <?php
         $i=$i+1;
       }
      ?>
        </tr>
    </table>
    <?php echo '<br>'; echo '<br>'; } ?>
  </div> <!-- Para computadora -->
  

  <!--Para celular-->
    <div class="d-block d-sm-block d-md-none">
        <?php 
        $resultArray = titularCargas($documento);
        if(!hayConexion($resultArray)){
            echo "PROBLEMAS DE CONEXIÓN CON LA BASE DE DATOS";
        }
      else{
          $arrayTitular = datosTitular($resultArray);
          $arrayCarga = datosCargas($resultArray);
        ?>
        <hr>
        <h4 id="titulo">TITULAR</h4><br>
        <hr>
        <div class="container" id="textoizq">
        
          <div class="row">
            <div class="col"><h6>CODIGO<br> <a><?php echo $arrayTitular['codigo'].'<br>';?></a></h6></div>
            <div class="col"><h6>APELLIDO<br> <a><?php echo $arrayTitular['apellido'].'<br>';?></a></h6></div>
          </div>
          <br>

          <div class="row">
            <div class="col"><h6>NOMBRE<br> <a ><?php echo $arrayTitular['nombre'].'<br>';?></a></h6></div>
            <div class="col"><h6>DOCUMENTO<br> <a><?php echo $arrayTitular['documento'].'<br>';?></a></h6></div>
          </div>
          <br>

          <div class="row">
            <div class="col"><h6>LEGAJO<br> <a><?php echo $arrayTitular['legajo'].'<br>';?></a></h6></div>
            <div class="col"><h6>NACIMIENTO<br> <a><?php echo $arrayTitular['nacimiento'].'<br>';?></a></h6></div>
          </div>
          <br>

          <div class="row">
            <div class="col"><h6>CUIL<br> <a ><?php echo $arrayTitular['cuil'].'<br>';?></a></h6></div>
            <div class="col"><h6>DIRECCION<br> <a><?php echo $arrayTitular['direccion'].'<br>';?></a></h6></div>
          </div>
          <br>

          <div class="row">
            <div class="col"><h6>LOCALIDAD<br> <a><?php echo $arrayTitular['localidad'].'<br>';?></a></h6></div>
            <div class="col"><h6>PROVINCIA<br> <a><?php echo $arrayTitular['provincia'].'<br>';?></a></h6></div>
          </div>
          <br>

          <div class="row">
            <div class="col"><h6>TELEFONO<br> <a><?php echo $arrayTitular['telefono'].'<br>';?></a></h6></div>
            <div class="col"><h6>SSM<br> <a>
              <?php if($arrayTitular['ssm']=='1'){
                      echo "SI".'<br>';
                    }
                    else{
                      echo "NO".'<br>';
                    }
              ?>
            </a></h6>
            </div>
          </div>
          <br>

          <div class="row">
            <div class="col"><h6>FECHA DE ALTA<br> <a><?php echo $arrayTitular['alta'].'<br>';?></a></h6></div>
            <div class="col"><h6>HABILITADO<br> <a>
              <?php if($arrayTitular['habilitado']=='1'){
                echo "SI".'<br>';
              }
              else{
                echo "NO".'<br>';
              }
            ?>
            </a></h6></div>
          </div>
          <br>

          <div class="row">
            <div class="col"><h6>EMAIL REGISTRO<br> <a><?php echo $arrayTitular['email2'].'<br>';?></a></h6></div>
            <div class="col"><h6>CELULAR REGISTRO<br> <a><?php echo $arrayTitular['celular'].'<br>';?></a></h6></div>
          </div>
          <br>
    
        </div>
      <?php echo '<br>';echo '<br>';?>

        <h4 id="titulo">CARGAS</h4>
        <table class="table table-bordered table-responsive" id="tablaCarga">
          <!--tr>
            <td id="fila">Codigo</td>
            <td id="fila">Carga</td>
            <td id="fila">Parentesco</td>
            <td id="fila">Apellido</td>
            <td id="fila">Nombre</td>
            <td id="fila">Documento</td>
            <td id="fila">Nacimiento</td>
            <td id="fila">Fecha alta</td>
            <td id="fila">Fecha baja</td-->

            <?php 
            $longitud = count($arrayCarga);
            $i=0;
            while ( $i < $longitud) {
            ?>
              <!--tr>
                <td id="detalle"> <?php //echo $arrayCarga[$i]['codigo']; ?> </td>
                <td id="detalle"> <?php //echo $arrayCarga[$i]['carga']; ?> </td>
                <td id="detalle"> <?php //echo $arrayCarga[$i]['parentesco']; ?> </td>
                <td id="detalle"> <?php //echo $arrayCarga[$i]['apellido']; ?> </td>
                <td id="detalle"> <?php //echo $arrayCarga[$i]['nombre']; ?> </td>
                <td id="detalle"> <?php //echo $arrayCarga[$i]['documento']; ?> </td>
                <td id="detalle"> <?php //echo $arrayCarga[$i]['nacimiento']; ?> </td>
                <td id="detalle"> <?php //echo $arrayCarga[$i]['alta']; ?> </td>
                <td id="detalle"> <?php //echo $arrayCarga[$i]['baja']; ?> </td>
              </tr-->

            <tr>
              <td id="fila">Codigo</td>
              <td id="fila">Carga</td>
              <td id="fila">Parentesco</td>
            </tr>
            <tr>
              <td id="detalle"> <?php echo $arrayCarga[$i]['codigo']; ?> </td>
              <td id="detalle"> <?php echo $arrayCarga[$i]['carga']; ?> </td>
              <td id="detalle"> <?php echo $arrayCarga[$i]['parentesco']; ?> </td>
            </tr>

            <tr>
              <td id="fila">Apellido</td>
              <td id="fila">Nombre</td>
              <td id="fila">Documento</td>
            </tr>
            <tr>
                <td id="detalle"> <?php echo $arrayCarga[$i]['apellido']; ?> </td>
                <td id="detalle"> <?php echo $arrayCarga[$i]['nombre']; ?> </td>
                <td id="detalle"> <?php echo $arrayCarga[$i]['documento']; ?> </td>
            </tr>

            <tr>
              <td id="fila">Nacimiento</td>
              <td id="fila">Fecha alta</td>
              <td id="fila">Fecha baja</td>
            </tr>
            <tr>
                <td id="detalle"> <?php echo $arrayCarga[$i]['nacimiento']; ?> </td>
                <td id="detalle"> <?php echo $arrayCarga[$i]['alta']; ?> </td>
                <td id="detalle"> <?php echo $arrayCarga[$i]['baja']; ?> </td>
            </tr>

            <tr>
              <td id="fila1"></td>
              <td id="fila1"></td>
              <td id="fila1"></td>
            </tr>

            <tr style="border:none;">
              <td id="fila1"></td>
              <td id="fila1"></td>
              <td id="fila1"></td>
            </tr>

            <tr style="border:none;">
              <td id="fila1"></td>
              <td id="fila1"></td>
              <td id="fila1"></td>
            </tr>


              <?php
              $i=$i+1;
            }
            ?>
          </tr>
        </table>
        <?php echo '<br>'; echo '<br>';   }?>
    </div><!--Para celular -->

  </div>
</body>
</html>


