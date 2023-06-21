<!DOCTYPE html>
<html>
<head>
<?php 
include('head.php');
include ('estiloMW.php');
?>
</head>

<body>
<div class="container">
  
  <div class="container" align="center">
    <img id="imagen" src="imagenes/logo-mppn.png">
  </div>

  <p id="titulo" >REESTABLECER CONTRASEÑA</p>
    <form method="POST" id="formulario">

      <div class="input-group mx-auto">
        <input type="text" id="email" name="email" class="form-control" placeholder="EMAIL" autocomplete="off" maxlength="40">
      </div>
      <div class="input-group mx-auto">
        <input type="text" id="codigo" name="codigo" class="form-control" placeholder="CÓDIGO DE RECUPERACIÓN"  autocomplete="off" maxlength="6">
      </div>
      <div class="input-group mx-auto">
        <input id="clave" name="clave" class="form-control .text-primary" type="password" placeholder="NUEVA CONTRASEÑA" autocomplete="off" maxlength="20">
      </div>
      <div class="input-group mx-auto">
        <input id="confirmacion" name="confirmacion" class="form-control .text-primary" type="password" placeholder="REPETIR CONTRASEÑA" autocomplete="off" maxlength="20">
      </div>
      <div class="text-center"> 
        <div id="cajaDeBotones"><button class="btn btn-responsive btninter" type="submit" id="botonReestablecer" >REESTABLECER</button></div>
        <br>
        <button class="btn btn-responsive btninter" id="botonVolver" >VOLVER</button>
      </div>
      <div id="loader" style="display:none"></div>
    </form>
    <!--p style="margin:5px">
      <a href="index.php">Volver</a>
    </p-->
    <div class="container col-md-6">
      <p id="subtitulo">Ingrese su email, el código de recuperación que se le envio al mismo y la nueva contraseña elegida para poder acceder al sistema.<br>Por consultas sobre el sistema escribir a <span style="color:#2874A6 ">soporte@mppneuquen.com.ar</span></p>
    </div>
    
    <br>
  </div>
</body>
</html>


<script type="text/javascript">

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

  $('#botonReestablecer').click(function(evento){
    evento.preventDefault();
    if(validarFormulario()){
      var datos=$('#formulario').serialize();
      $.ajax({
          url: 'setear.php',
          type:'POST',
          data: datos,
          beforeSend: function() {
            $("input").prop('disabled', true); //Bloqueo el formulario
            $('#botonReestablecer').attr("disabled", true); //Bloqueo el boton
            //$("#loader").show();
            $("#loader").css('display','block');
          },
          success: function(data){
            console.log(data);
           $("#loader").css('display','none');
           console.log(data);
            var jsonData = JSON.parse(data);
            if(jsonData.salida == 0){
              return mensajeExito(jsonData.mensaje);
            }
            else{
              $("input").prop('disabled', false); //Desbloqueo el formulario
              $('#botonReestablecer').attr("disabled", false); //Desbloqueo el boton
              return mensajeError(jsonData.mensaje);
            }
          }
      });
      return false;
    }
  });

  function validarFormulario(){
    if($("#email").val() == ""){
      return mensajeError("EMAIL no puede estar vacío");
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
    if($("#codigo").val() == ""){
      return mensajeError("CODIGO DE SEGURIDAD no puede estar vacío");
      $("#codigo").focus();
      return false;
    }
    if($("#clave").val() == ""){
      return mensajeError("CONTRASEÑA no puede estar vacío");
      $("#clave").focus();
      return false;
    }
    if($("#confirmacion").val() == ""){
      return mensajeError("Falto completar un campo");
      $("#confirmacion").focus();
      return false;
    }
    else{
      if($("#clave").val() != $("#confirmacion").val()){
        return mensajeError("Las contraseñas NO coinciden");
        $("#confirmacion").focus();
        return false;
      }
    }
    return true;
  }

</script>

