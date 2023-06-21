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
include ('estiloMW.php');
?>
<body>
  <div class="container">
    <hr/>
    <h2 id="titulo">EJERCICIOS ECONÓMICOS</h2> 
    <hr/>

<!-- Para computadora -->
<div class="container">
  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
    <div class="col1">2020</div>
    <div class="col"><a id="boton-balance" href='balances/2020.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
  </div>
  <br>

  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
    <div class="col1">2019</div>
    <div class="col"><a href='balances/2019.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
  </div>
  <br>

  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
    <div class="col1">2018</div>
    <div class="col"><a href='balances/2018.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
  </div>
  <br>

  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
    <div class="col1">2017</div>
    <div class="col"><a href='balances/2017.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
  </div>
  <br>

  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
      <div class="col1">2016</div>
      <div class="col"><a href='balances/2016.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
  </div>
  <br>

  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
      <div class="col1">2015</div>
      <div class="col"><a href='balances/2015.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
  </div>
  <br>

  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
      <div class="col1">2014</div>
      <div class="col"><a href='balances/2014.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
  </div>
  <br>
</div>

  </div>
</body>
</html>

<style type="text/css">

.col1{
  color: #3A73A8; 
  font-family: 'Verdana';
  font-weight: bold;
}
</style>


<script type="text/javascript">

  $('#boton-balance').click(function(evento){
        evento.preventDefault();
        //window.open("http://192.168.0.14/mutualWeb/balances/"."2020"."pdf","_blank")
        //window.location.replace("index.php");
  });
</script>
