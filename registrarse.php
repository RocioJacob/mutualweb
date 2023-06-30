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
  
    <p id="titulo" >REGISTRO</p>
    <form method="POST" id="formulario">
      
      <div class="input-group mx-auto">
        <input type="text" id="documento" name="documento" class="form-control" placeholder="Numero documento"  autocomplete="off" maxlength="8">
      </div>

      <div class="input-group mx-auto">
        <input type="text" id="email" name="email" class="form-control" placeholder="EMAIL" autocomplete="off" maxlength="40">
      </div>

      <div class="text-center"> 
        <div id="cajaDeBotones">
        <button class="btn btn-responsive btninter" type="submit" id="botonRegistrar">REGISTRARME</button>
        
        <button class="btn btn-responsive btninter" id="botonVolver">VOLVER</button></div>
        <!--button class="btn btn-danger btn-responsive btninter right" type="submit" id="botonResetear">BORRAR</button-->
      </div>

      <div id="loader" style="display:none"></div>
    </form>

    <!--p style="margin:5px">
      <a href="index.php">Volver</a>
    </p-->
    <div class="container col-md-6">
      <p id="subtitulo"><span style="color:red;">DEBE TENER UN EMAIL CARGADO EN LA MUTUAL</span><br>El email ingresado deberá ser el mismo que nos proporcionó. Se le enviará un código, con una validez de 48hs que tendrá que ingresarlo en la opción <a href="activar.php">código de activación</a> que se encuentra en el inicio de sesión.</p>
    </div>
    <br>

</div>
</body>
</html>


<script type="text/javascript">

//Funcion para borrar los campos del formulario
 /* $('#botonResetear').click(function(evento){
        evento.preventDefault();
        $("#formulario")[0].reset();
  });*/

  $('#botonIngresoCodigo').click(function(evento){
        evento.preventDefault();
         window.location.replace("activar.php");
  });

  $('#botonVolver').click(function(evento){
        evento.preventDefault();
         window.location.replace("isMW.php");
  });

  function mensajeError($mensaje){
    swal.fire({
      title: $mensaje, 
      icon: 'error',
      width:'650px',
      allowOutsideClick: false,
    });
  }

  function mensajeExito($mensaje){
    Swal.fire({
      icon: 'success',
      width:'650px',
      title: $mensaje, 
      allowOutsideClick: false,
    }).then(function(){
        //window.location='index.php';
        window.location.replace("isMW.php");
    });
    //$('#formulario')[0].reset(); //reseteo el formulario
  }

  $('#botonRegistrar').click(function(evento){
    evento.preventDefault();
    if(validarFormulario()){
      var datos=$('#formulario').serialize();
      $.ajax({
          url: 'registracion.php',
          type:'POST',
          data: datos,
          beforeSend: function() {
            $("input").prop('disabled', true); //Bloqueo el formulario
            $('#botonRegistrar').attr("disabled", true); //Bloqueo el boton
            $('#botonIngresoCodigo').attr("disabled", true);//Bloqueo el boton
            $("#loader").show();
          },
          success: function(data){
            $("#loader").css('display','none');
            console.log(data);
            var jsonData = JSON.parse(data);
            if(jsonData.salida == 0){
              return mensajeExito(jsonData.mensaje);
            }
            else{
              $("input").prop('disabled', false); //Desbloqueo el formulario
              $('#botonRegistrar').attr("disabled", false); //Desbloqueo el boton
              $('#botonIngresoCodigo').attr("disabled", false);//Desbloqueo el boton
              return mensajeError(jsonData.mensaje);
            }
          }
      });
      return false;
    }
  });

  function validarFormulario(){
    if($("#documento").val() == ""){
      return mensajeError("El campo DOCUMENTO no puede estar vacío");
      $("#documento").focus();
      return false;
    }
    if($("#email").val() == ""){
      return mensajeError("El campo EMAIL no puede estar vacío");
      $("#email").focus();
      return false;
    }
    else{
        if(!$("#email").val().includes('@')){
          return mensajeError("Error en el formato de EMAIL ingresado");
          $("#email").focus(); 
          return false;
        }
    }
    return true;
  }
</script>

