<!DOCTYPE html>
<html>
<head>
<?php 
include('head.php');
include ('estiloMW.php');
?>
</head>
<body>
<div class="container" id="contenedor">
  <div class="container" align="center">
    <img id="imagen" src="imagenes/logo.ico">
  </div>
  <p id="titulo">FORMULARIO DE REGISTRO</p>
    <form method="POST" id="formulario">
      <div class="input-group">
        <input type="text" id="documento" name="documento" class="form-control" placeholder="Numero documento" style="text-transform:uppercase; border-color: #2874A6" autocomplete="off" maxlength="8">
      </div>
      <br>

      <div class="input-group">
        <input type="text" id="email" name="email" class="form-control" placeholder="Email" style="text-transform:uppercase; border-color: #2874A6" autocomplete="off" maxlength="40">
      </div>
      <br>

      <div class="input-group">
        <input id="clave" name="clave" class="form-control .text-primary" type="password" placeholder="Contraseña" style="text-transform:uppercase; border-color: #2874A6" autocomplete="off" maxlength="20">
          
        <div class="input-group-append"> <span class="input-group-text">
          <input ID="verClave" type="checkbox"/></span> 
        </div>
          <!--div style="margin-top:15px; color: #2874A6">
          <input style="margin-left:10px;" type="checkbox" id="mostrar_contrasena" title="clic para mostrar contraseña"> Mostrar</div-->
      </div>
      <br>

      <div class="input-group">
        <input id="confirmacion" name="confirmacion" class="form-control .text-primary" type="password" placeholder="Repetir contraseña" style="text-transform:uppercase; border-color: #2874A6" autocomplete="off" maxlength="20">

        <div class="input-group-append"><span class="input-group-text"><input ID="verConfirmacion" type="checkbox"/></span> 
        </div>
      </div>
      <br>

      <div class="text-center"> 
      <button class="btn btn-primary btn-responsive btninter" type="submit" id="botonRegistrar">REGISTRARSE</button>
      <button class="btn btn-danger btn-responsive btninter right" type="submit" id="botonResetear">BORRAR</button>
      </div>
    </form>
    <br>
    <p>
      <a href="isMW.php">Login</a>
    </p>
</div>
</body>
</html>



<script type="text/javascript">

$(document).ready(function () {
  //CheckBox mostrar contraseña
  $('#verClave').click(function () {
    $('#clave').attr('type', $(this).is(':checked') ? 'text' : 'password');
  });
});

$(document).ready(function () {
  //CheckBox mostrar contraseña
  $('#verConfirmacion').click(function () {
    $('#confirmacion').attr('type', $(this).is(':checked') ? 'text' : 'password');
  });
});


$('#mostrar_contrasena').click(function () {
    if ($('#mostrar_contrasena').is(':checked')) {
      $('#clave').attr('type', 'text');
    } else {
      $('#clave').attr('type', 'password');
    }
});


  //Funcion para borrar los campos del formulario
    $('#botonResetear').click(function(evento){
        evento.preventDefault();
        $("#formulario")[0].reset();
  });

  function mensajeError($mensaje){
    swal.fire({
      title: $mensaje, 
      icon: 'error',
      allowOutsideClick: false,
    });
  }

  function mensajeExito($mensaje){
    Swal.fire({
      icon: 'success',
      title: $mensaje, 
      allowOutsideClick: false,
    });
    $('#formulario')[0].reset(); //reseteo el formulario
  }

  $('#botonRegistrar').click(function(evento){
    evento.preventDefault();
    if(validarFormulario()){
      var datos=$('#formulario').serialize();
      $.ajax({
          url: 'registracion.php',
          type:'POST',
          data: datos,
          success: function(data){
            var jsonData = JSON.parse(data);
            if(jsonData.salida == 0){
              return mensajeError(jsonData.mensaje);
            }
            else{
              return mensajeExito(jsonData.mensaje);
            }
          }
      });
      return false;
    }
  });


  function validarFormulario(){
    if($("#documento").val() == ""){
      return mensajeError("El campo DOCUMENTO no puede estar vacío.");
      $("#documento").focus();
      return false;
    }

    if($("#email").val() == ""){
      return mensajeError("El campo EMAIL no puede estar vacío.");
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

    if($("#clave").val() == ""){
      return mensajeError("El campo CONTRASEÑA no puede estar vacío.");
      $("#clave").focus();
      return false;
    }

    if($("#confirmacion").val() == ""){
      return mensajeError("El campo REPETIR CONTRASEÑA no puede estar vacío.");
      $("#confirmacion").focus();
      return false;
    }
    else{
      if($("#clave").val() != $("#confirmacion").val()){
        return mensajeError("Las contraseñas ingresadas no coinciden.");
        $("#confirmacion").focus();
        return false;
      }
    }

    return true;
  }
</script>

<style type="text/css">

.input-group-text{
  border: solid 1px #2874A6;

}


#contenedor{
  width: 520px;
  height: 670px;
  margin: 50px auto;
  background-color: white;
  /*border: 1px solid #1E90FF;*/
  /*border-radius:8px;*/
  /*padding: 0px 9px 0px 9px;*/
}

#botonRegistrar, #botonResetear{
  height:40px; 
  width:120px; 
}

</style>
