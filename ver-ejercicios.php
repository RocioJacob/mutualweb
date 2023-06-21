<?php  
session_start();
if (!isset($_SESSION['documento'])) {
  header('Location: isMW.php');
}
else{
  $documento = $_SESSION['documento'];
}
?>

  <!DOCTYPE html>
  <html lang="es">
  <?php 
  include('head.php');
  include('navegacion.php');
  include("conexion.php");
  include ('estiloMW.php');
  ?>
  <body>
    <div class="container">
      <hr/>
      <h2 id="titulo">EJERCICIOS ECONÓMICOS</h2> 
      <hr/>
      <?php
      listarBalances();
      ?>
  </div>
  </body>
  </html>


<script type="text/javascript">

  $('#boton-balance').click(function(evento){
        evento.preventDefault();
        window.open("http://192.168.0.14/mutualWeb/balances/"."2020"."pdf","_blank")
         //window.location.replace("index.php");
  });
</script>

<?php
//Lista todas las facturas disponibles del interno ingresado
function listarBalances(){
  include("conexion.php");
  $query = mysqli_query($conexion, "SELECT * FROM balances WHERE publicar LIKE '0' ORDER BY id ASC");
  $cantidad = mysqli_num_rows($query); //Obtengo cantidad de facturas

    while ($data = mysqli_fetch_array($query)) { 
      $anio = $data['anio'];            
      mostrarBalance($anio);
    }
}

function mostrarBalance($anio){
  //include("ocultar-ruta.php");
    //$codigo = rand(100000,10000000); //genero código
    $ruta1='./balances';
    if (is_dir($ruta1)){ //Indica si el nombre de archivo es un directorio
        $archivo = $ruta1.'/'.$anio.'.pdf';
        escribirhtml($anio, $archivo);
    }
}

function escribirhtml($anio, $archivo){
  echo "<!DOCTYPE html>";
  echo "<html>";
  echo "<head>";
  echo "<title>Facturas</title> <meta charset = \"utf-8\"/> </head>";
  echo "<body>";
  echo "<div class=\”d-none d-sm-none d-md-block\”>"; 
  echo "<div class=\”row align-items-start\”>";
  echo "<h5>".$anio."</h5>"."<div class=\”col\”><a id='boton-balance' href='$archivo' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align=center>Descargar</a></div>";
  echo "<div class=\”col\”></div>";
  echo "</div>";
  echo "</div>";
  echo "</body>";
  echo "</html>";
  echo "<br>";
}

function obtenerTitular($resultArray){
    $array = [];
    foreach($resultArray as $key=>$data){
      if(!is_array($data)){
        $array[$key] = $data;
      }
    }
    return $array;
}
?>