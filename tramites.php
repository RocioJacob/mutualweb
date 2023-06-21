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
<header>
  <title>Trámites</title>
</header>
<body>
  <br>
<div class="container">
  <div id="saludo" > HOLA <?php echo $nombre?></div>
   <!-- <hr/>
    <a href="menu.php" class="btn" id="botonMenu" title="MENU">Menu</a>
    <h2 style = "font-family: 'Georgia', cursive;">TRAMITES</h2>
    <hr/>-->

    
    <!-- Si no esta habilitado ver que tramites puede hacer -->
<?php 
if (!estahabilitadoafiliado($documento)){ ?> 
    <div class="d-none d-sm-none d-md-block">
      <div id="advertencia">NO PUEDE GESTIONAR NINGÚN TIPO DE TRÁMITE YA QUE NO ESTA HABILITADO EN MUTUAL</div> 
      <br>
      <div class="container" id="containerMenu">
      <br/>
      <div class="">
        <!--<button class="btn boton" id="" type="submit">ASISTENCIAL</button>
        <button class="btn boton" id="" type="submit">REINTEGRO</button>
        <button class="btn boton" id="" type="submit">SUBSIDIO<br>SOLIDARIO<br>MUTUAL</button>
        <button class="btn boton" id="" type="submit">SUBSIDIO<br>POR<br>CASAMIENTO</button>
        <button class="btn boton" id="" type="submit">SUBSIDIO<br>POR<br>FALLECIMIENTO</button>
      </div>
       <br/>
      <div class="container text-center h-100 d-flex justify-content-center align-items-center">
        <button class="btn boton" id="" type="submit">SUBSIDIO<br>POR<br>NACIMIENTO</button>
        <button class="btn boton" id="" type="submit">EDUCACION-BECAS</button>
        <button class="btn boton" id="" type="submit">TURISMO</button>-->
        <button class="btn boton" id="botonAcceder9" type="submit">CONSULTA GENERAL</button>
        <button class="btn boton" id="botonAcceder10" type="submit">SOLICITAR TURNO</button>
      <!--</div>
      <br/>
      <div class="container text-center h-100 d-flex justify-content-center align-items-center">
        <button class="btn boton" id="" type="submit">ALTA CARGA</button>
        <button class="btn boton1" id="" type="submit">REEMPADRONAMIENTO</button>
        <button class="btn boton" id="" type="submit">BAJA CARGA</button>
        <button class="btn boton" id="" type="submit">BAJA TITULAR</button>-->
        <button class="btn boton" id="botonAcceder15" type="submit">ACTUALIZAR DATOS</button>
      </div>
      
    </div>
    </div>
<?php }
else{ ?>

<!-- Para computadora -->
  <div class="d-none d-sm-none d-md-block">
      <div id="subtitulo">SELECCIONE EL TRÁMITE QUE DESEA GESTIONAR Y COMPLETE EL FORMULARIO
      </div> 
      <br>
    <div class="container" id="containerMenu">
      
      <div class="">

        <button class="boton" id="botonAcceder15" type="submit">ACTUALIZAR DATOS</button>
        <button class="boton" id="botonAcceder11" type="submit">ALTA CARGA</button>
        <button class="boton" id="botonAcceder1" type="submit">ASISTENCIAL</button>
        <button class="boton" id="botonAcceder13" type="submit">BAJA CARGA</button>
        <button class="boton" id="botonAcceder14" type="submit">BAJA TITULAR</button>
        <button class="boton" id="botonAcceder9" type="submit">CONSULTA GENERAL</button>
        <button class="boton" id="botonAcceder7" type="submit">EDUCACION-BECAS</button>
        <button class="boton" id="botonAcceder12" type="submit">REEMPADRONAMIENTO</button>
        <button class="boton" id="botonAcceder2" type="submit">REINTEGRO</button>
        <button class="boton" id="botonAcceder10" type="submit">SOLICITAR TURNO</button>
        
        <button class="boton" id="botonAcceder4" type="submit">SUBSIDIO POR CASAMIENTO</button>
        <button class="boton" id="botonAcceder5" type="submit">SUBSIDIO POR FALLECIMIENTO</button>
     
        <button class="boton" id="botonAcceder6" type="submit">SUBSIDIO POR NACIMIENTO</button>
        <button class="boton" id="botonAcceder3" type="submit">SUBSIDIO SOLIDARIO MUTUAL</button>
        <button class="boton" id="botonAcceder8" type="submit">TURISMO</button>
        
      </div>
      
      
    </div>
  </div><!--Para computadora-->
<?php } ?>


<!--
  <div class="d-block d-sm-block d-md-none">
    <div style="font-family: 'Verdana' cursive; font-size: 22px; color: #0072BC"; align="center">SELECCIONE EL TRÁMITE QUE DESEA GESTIONAR Y COMPLETE EL FORMULARIO</div> 
    
    <div class="container" id="containerMenu">
      
      <div class="">
        <button class="boton" id="botonAcceder21" type="submit">ASISTENCIAL</button>
        <button class="boton" id="botonAcceder22" type="submit">REINTEGRO</button>
      </div>
      

      <div class="">
        <button class="boton" id="botonAcceder23" type="submit">SUBSIDIO<br>SOLIDARIO<br>MUTUAL</button>
        <button class="boton" id="botonAcceder24" type="submit">SUBSIDIO<br>POR<br>CASAMIENTO</button>
      </div>
      

      <div class="">
        <button class="boton" id="botonAcceder25" type="submit">SUBSIDIO<br>POR<br>FALLECIMIENTO</button>
        <button class="boton" id="botonAcceder26" type="submit">SUBSIDIO<br>POR<br>NACIMIENTO</button>
      </div>
      

      <div class="">
        <button class="boton" id="botonAcceder27" type="submit">EDUCACION-BECAS</button>
        <button class="boton" id="botonAcceder28" type="submit">TURISMO</button>
      </div>
      

      <div class="">
        <button class="boton" id="botonAcceder29" type="submit">CONSULTA GENERAL</button>
        <button class="boton" id="botonAcceder30" type="submit">SOLICITAR TURNO</button>
      </div>
      

      <div class="">
        <button class="boton" id="botonAcceder31" type="submit">ALTA CARGA</button>
        <button class="boton" id="botonAcceder32" type="submit">REEMPADRONAMIENTO</button>
      </div>
      

      <div class="">
        <button class="boton" id="botonAcceder33" type="submit">BAJA CARGA</button>
        <button class="boton" id="botonAcceder34" type="submit">BAJA TITULAR</button>
      </div>
      

      <div class="">                                                                  cambio de clase a boton
        <button class="boton" id="botonAcceder35" type="submit">ACTUALIZAR<br>DATOS</button>
      </div>
      
    </div>
  </div>  Para celular -->
</div>
</body>
<!--<footer >RECUERDE QUE UN ADMINISTRADOR DE NUESTRA INSTITUCION SE COMUNICARA CON USTED A LA BREVEDAD UNA VEZ INICIADO El TRAMITE</footer>-->
</html>





<script type="text/javascript">
  $(document).ready(function() {
    $('#botonAcceder1').on('click', function() {
      var tramite = "ASISTENCIAL"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder2').on('click', function() {
      var tramite = "REINTEGRO"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder3').on('click', function() {
      var tramite = "SUBSIDIO SOLIDARIO MUTUAL"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder4').on('click', function() {
      var tramite = "SUBSIDIO POR CASAMIENTO"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder5').on('click', function() {
      var tramite = "SUBSIDIO POR FALLECIMIENTO"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder6').on('click', function() {
      var tramite = "SUBSIDIO POR NACIMIENTO"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder7').on('click', function() {
      var tramite = "EDUCACION-BECAS"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder8').on('click', function() {
      var tramite = "TURISMO"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder9').on('click', function() {
      var tramite = "CONSULTA GENERAL"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder10').on('click', function() {
      var tramite = "SOLICITUD DE TURNO"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder11').on('click', function() {
      var tramite = "ALTA CARGA"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder12').on('click', function() {
      var tramite = "REEMPADRONAMIENTO"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder13').on('click', function() {
      var tramite = "BAJA CARGA"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder14').on('click', function() {
      var tramite = "BAJA TITULAR"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder15').on('click', function() {
      var tramite = "ACTUALIZACION DE DATOS"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    
    $('#botonAcceder21').on('click', function() {
      var tramite = "ASISTENCIAL"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder22').on('click', function() {
      var tramite = "REINTEGRO"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder23').on('click', function() {
      var tramite = "SUBSIDIO SOLIDARIO MUTUAL"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder24').on('click', function() {
      var tramite = "SUBSIDIO POR CASAMIENTO"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder25').on('click', function() {
      var tramite = "SUBSIDIO POR FALLECIMIENTO"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder26').on('click', function() {
      var tramite = "SUBSIDIO POR NACIMIENTO"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder27').on('click', function() {
      var tramite = "EDUCACION-BECAS"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder28').on('click', function() {
      var tramite = "TURISMO"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder29').on('click', function() {
      var tramite = "CONSULTA GENERAL"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder30').on('click', function() {
      var tramite = "SOLICITUD DE TURNO"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder11').on('click', function() {
      var tramite = "ALTA CARGA"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder32').on('click', function() {
      var tramite = "REEMPADRONAMIENTO"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder33').on('click', function() {
      var tramite = "BAJA CARGA"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder34').on('click', function() {
      var tramite = "BAJA TITULAR"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

    $('#botonAcceder35').on('click', function() {
      var tramite = "ACTUALIZACION DE DATOS"; 
      var dataString = 'tramite='+tramite;
      window.location='formulario.php?tramite='+tramite;
      return false;
    });

  });
</script>



<style type="text/css">
/*
body{
  background-image: url("imagenes/fondo5.jpg");
  background-color: #EFEFEF;
}

/*.container{
    /* height: 100%; 
}
#saludo{
  font-family: 'Georgia' cursive;
  font-size: 120%;
  color: #0F4C75;
  text-align: left;
}*/
#advertencia{
  font-family: bold;
  font-size: 130%;
  color: #1B262C;
  text-align: center;
}
/*#containerMenu{
  height: 100%;
  width: 100%;
  /*display: flex;
  flex-direction: column;*/       /*arreglar para flex*/

/*}/*
.boton{/*el boton es responsive y con un tamaño independiente al texto para que todos tengan un tamaño fijo
  font-size: 110%;
  color: #EFEFEF;
  border-color: #BBE1FA;
  background-color: #0F4C75;
  height: 10vh;
  width: 30%;
  margin-bottom: 3%;
  margin-right: 2%;
  border-radius: 2vh;   /*uso vh para que el radio se base en la altura y se modifique cuando cambia el tamaño de los botones*/
  /*

}
.boton:hover{
  color: #0F4C75;
  background-color: #EFEFEF;
  transform: scale(1.1);
}*/

              /* COMENTE PORQUE NO LO ENTIENDO \_('_')_/   */
/*#botonMenu{
  float:right;
  margin-right: 5px;
  background-color: #148F77;
  color: white;
  border: 2px solid;
  border-radius: 10px;
}

.boton{
  /*color: #318aac !important;
  font-size: 100%;
  /*font-weight: 100;*/
  /*padding: 0.5em 1.2em;*/
  /*background: rgba(0,0,0,0);
  border: 2% solid;
  border-color: #0072BC;
  transition: all 1s ease;
  position: relative;
  padding: 2% 6%;                      /*arriba-abajo, izq-der
  margin: 0% 2% 1% 0%;
  float: left;
  border-radius: 25px;                   /*redondeo de las esquinas
  font-family: 'Georgia', cursive;
  font-size: 100%;                       /*tamaño letra
  color: #EFEFEF;                           /*color letra
  /*text-decoration: none;  
  width: 25%; /*!important; */                 /*tamaño botones
  height: 20%;/* !important; 
  text-align: center;                    /*alineacion de texto
  background: #0072BC;
  /*background: #003366;*/
  /*background: #2874A6;
}
.boton:hover {
  background: #EFEFEF;
  color: #0072BC; /*!important;*/
  /*filter: blur(5px);
  -webkit-transform:scale(1.1);transform:scale(1.1); /*Acercamiento
  /*transform: rotateY(180deg);*/
  /*transform: rotateY(360deg) scale(1.1);
}

.boton1{
  /*color: #318aac !important;
  /*font-size: 20px;*/
  /*font-weight: 100;*/
  /*padding: 0.5em 1.2em;*/
  /*background: rgba(0,0,0,0);
  border: 2px solid;
  border-color: #0072BC;
  transition: all 1s ease;
  position: relative;
  padding: 25px 1px;                   /*arriba-abajo, izq-der
  margin: 0px 20px 10px 0px;
  float: left;
  border-radius: 15px;                /*redondeo de las esquinas
  font-family: 'Georgia', cursive;
  font-size: 14px;                    /*tamaño letra
  color: #EFEFEF;                       /*color letra
  /*text-decoration: none;  
  width: 180px; /*!important;  */          /*tamaño botones
  height: 120px; /*!important;
  text-align: center;                 /*alineacion de texto
  background: #0072BC;
  /*background: #003366;
  /*background: #2874A6;
}
.boton1:hover {
  background: #EFEFEF;
  color: #0072BC !important;
  /*filter: blur(5px);
  -webkit-transform:scale(1.1);transform:scale(1.1); /*Acercamiento
  /*transform: rotateY(180deg);*/
  /*transform: rotateY(360deg) scale(1.1);
}*/

</style>
