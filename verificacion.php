<!DOCTYPE html>
<html>
  <head>
  <?php 
  include('head.php');
  include('estiloIS.php');
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


