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

      <p id="titulo" >RECUPERAR CONTRASEÑA</p>    
        <form method="POST" id="formulario">
          <div class="input-group mx-auto">
            <input type="text" id="email" name="email" class="form-control" placeholder="EMAIL"  autocomplete="off" maxlength="40">
          </div>
          <div class="input-group mx-auto">
          <img id="loading-image" src="imagenes/enviando.gif" style="display:none; width: 170px; height: 170px; margin-left: auto; margin-right: auto;"/>
          </div>
          <br>
          <div id="cajaDeBotones" class="text-center">
            <button class="btn btn-responsive btninter" type="submit" id="botonRecuperar">ENVIAR</button>
            
          <button class="btn btn-responsive btninter" id="botonVolver" >VOLVER</button></div>
        </form>
        <br>
        <p style="margin:5px">
        <!--a href="isMW.php">Volver</a><br-->
          <a href="reestablecer.php">Reestablecer contraseña</a>
        <!--a href="isMW.php" style="text-decoration: none;">Login</a-->
        </p>
        <div class="container col-md-6">
          <p id="subtitulo">Ingrese email con el que se registro y se le enviará un código y un enlace para reestablecer su contraseña. Loego puede ir a la opción <a href="reestablecer.php">Reestablecer contraseña</a> que se encuentra arriba e ingresar el código</p>
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
      title: $mensaje,
      width:'650px', 
      allowOutsideClick: false,
    }).then(function(){
        //window.location='index.php';
        window.location.replace("isMW.php");
    });
    //$('#formulario')[0].reset(); //reseteo el formulario
    //window.location.replace("index.php");
  }

  $('#botonRecuperar').click(function(evento){
    evento.preventDefault();
    //console.log($('#documento').val());
    if(validarFormulario()){
      var datos=$('#formulario').serialize();
      $.ajax({
          url: 'recuperar.php',
          type:'POST',
          data: datos,
          beforeSend: function() {
            $('#botonRecuperar').attr("disabled", true);
            //$("#loading-image").css('display','block');
            $("#loader").show();
           },
          success: function(data){
            //console.log(data);
            //$("#loading-image").css('display','none');
            $("#loader").css('display','none');
            var jsonData = JSON.parse(data);
            if(jsonData.salida == 1){
              $('#botonRecuperar').attr("disabled", false);
              return mensajeError(jsonData.mensaje);
            }
            else{
              $('#botonRecuperar').attr("disabled", false);
              return mensajeExito(jsonData.mensaje);
            }
          }
      });
      return false;
    }
  });


  function validarFormulario(){
    
    if($("#documento").val() == ""){
      return mensajeError("DOCUMENTO no puede estar vacío");
      $("#documento").focus();
      return false;
    }

    if($("#email").val() == ""){
      return mensajeError("EMAIL no puede estar vacío");
      $("#email").focus();
      return false;
    }
    else{
        if(!$("#email").val().includes('@')){
          return mensajeError("El campo EMAIL debe tener @");
          $("#email").focus(); 
          return false;
        }
    }

    return true;
  }
</script>
