<!DOCTYPE html>
<html>
  <head>
  <?php 
  include('head.php');

  ?>
  </head>
<body>

<div class="container">
  
  <div class="container" align="center">
    <img id="imagen" src="imagenes/logo-mppn.png">
  </div>

    <!--p id="titulo">INICIAR SESIÒN</p-->
    <p id="titulo" >VERIFICACIÓN DE EMAIL</p>
    <form method="POST" id="formulario">
      
      <div class="input-group mx-auto">
        <input type="text" id="documento" name="documento" class="form-control" placeholder="Numero Documento" autocomplete="off" maxlength="8">
      </div>
      <br>
      <div class="text-center"> 
        <div id="cajaDeBotones">
          <button type="submit" class="btn btn-responsive btninter" id="botonVerificar">VERIFICAR</button>
          <button class="btn btn-responsive btninter" id="botonVolver" >VOLVER</button>
        </div>
      </div>
    </form>
    <br>

  <div class="container col-md-12">
   
    <p ><span style="font-weight: bold;">IMPORTANTE: </span>Para poder utilizar el sistema web de la mutual, deberá previamente darnos su dirección de email y celular para que los carguemos en su perfil de afiliado titular. Una vez que ya esten cargados, va a poder registrarse y usar el sistema.<br>Puede brindarnos su email y celular completando el formulario que se encuentra en el siguiente enlace: <span><a href="https://tramitesonline.mppneuquen.com.ar/formulario.php?tramite=ACTUALIZACION" target="_blank" >ACTUALIZACIÓN DE DATOS</a>
    </span><br> o acercarse a su delegación e informar estos datos requeridos.<br>Puede verificar si ya tenemos cargado su email y celular ingresando su documento y luego pulsar en VERIFICAR</span></p>
  </div>
  <br>

</div>

</body>
</html>

<script type="text/javascript">

  function mensajeError($mensaje){
    swal.fire({
      //title: $mensaje, 
      title: '<div style="font-size:24px;">$mensaje</div>'.replace('$mensaje',$mensaje),
      icon: 'error',
      allowOutsideClick: false,
    });
  }

  function mensajeExito($mensaje){
    Swal.fire({
      icon: 'success',
      title: $mensaje, 
      allowOutsideClick: false,
    })
  };


  $('#botonVolver').click(function(evento){
        evento.preventDefault();
         window.location.replace("isMW.php");
  });

  /*function mensajeExito($mensaje){
    Swal.fire({
      icon: 'success',
      title: $mensaje, 
      allowOutsideClick: false,
    });
    $('#formulario')[0].reset(); //reseteo el formulario
  }*/

  $('#botonVerificar').click(function(evento){
    evento.preventDefault();
    if(validarFormulario()){
      var datos=$('#formulario').serialize();
      $.ajax({
          url: 'verificar.php',
          type:'POST',
          data: datos,
          success: function(data){
            console.log(data);
            var jsonData = JSON.parse(data);
            if(jsonData.salida == 0){ //Datos incorrectos
              return mensajeError(jsonData.mensaje);
            }
            else{
              return mensajeExito(jsonData.mensaje);
              //window.location.replace("index.php");
            }
          }
      });
      return false;
    }
  });

  function validarFormulario(){
    if($("#documento").val() == ""){
      return mensajeError("Ingrese su DOCUMENTO");
      //return mensajeError("Datos incompletos");
      $("#documento").focus();
      return false;
    }
    return true;
  }

</script>



<style type="text/css">              /*ESTILO*/


.input-group { 
  width: 30%;
}

@media (max-width: 767px) {
   .input-group { 
    width: 60%;
}
 }

a{
  color: #BBE1FA;
  font-weight: bold;
  font-size: 18px;
  /*font-family: 'Georgia', cursive;*/
}
a:hover{
  cursor: pointer;
  color: white;
}
p{
  color: ##2b4a83;
  text-align: center;
  /*font-size: 16px;*/
  /*text-transform: uppercase;*/
}

#contenedor{
    width: 750px;
    height: 550px;
    margin: 50px auto;
    background-color: white;
  }

  #botonVolver,#botonVerificar{
    height: 40px; 
    width: 150px; 
    border: 2px solid;
    border-radius: 25px;
    font-size: 15px;
    /*background: #003366;*/
    background-color: #2b4a83;
    color: white;
    margin-bottom: 2%;
    /*font-family: 'Georgia', cursive;*/
  }

  #botonVolver:hover,#botonVerificar:hover {
  background: white;
  /*color: #003366 !important;*/
  color: #2b4a83 !important;
  }
  #imagen{
    height: 25%;
    width: 25%;
    margin-top:3%;
  }
  #documento::placeholder {
    /*color: #3391FF;*/
    /*color: #2874A6;*/
    text-align: center;
    padding-top: 30px;
    font-size: 2vw;
    /*font-family: 'Georgia', cursive;*/
  }

  #titulo{
    color: #003366;
    color: white;
    text-align: center; /*alineacion*/
    font-size: 2vw;  /*tamaño letra*/
    font-weight: 500; /*grosor letra*/
    /*font-family: 'Georgia', cursive;*/
  }
  body{
      /*background: url(imagenes/fondo.jpg) no-repeat center center fixed;*/
      /*background-size: cover;*/
      /*color: white;*/
      background-image: url("imagenes/fondoBarra.png");
      width: 100%;
  }
  #documento{
    text-transform:uppercase; 
    border-color: #2874A6; 
    border-radius: 25px; 
    text-align: center; 
    margin: 5px;
  }

 
  #subtitulo{
  color: black;
  /*color: #148F77;*/
  text-align: center; /*alineacion*/
  font-size: 16px;  /*tamaño letra*/
  font-weight: 300; /*grosor letra*/
  /*font-family: 'Georgia', cursive;*/
}

</style>
