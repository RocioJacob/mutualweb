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
include("estiloMW.php");
?>
<head><title>Cambiar clave</title></head>
<body>
  <div class="container">
    <!--hr/>
    <a href="menu.php" class="btn" id="botonMenu">Menu</a>
    <h3 style = "font-family: 'Georgia', cursive;">CAMBIAR MI CONTRASEÑA</h3>
    <hr/-->
     <div id="saludo"><?php echo $nombre?></div>
    

<!-- Para computadora -->
    <div class="d-none d-sm-none d-md-block">
    
      <form method="POST" id="formulario">

        <div class="text-center"> 
          <hr>
          <p id="titulo">CAMBIAR MI CONTRASEÑA<button class="btn btn-responsive btninter" type="button" id="botonVolver"  onclick="window.location='cuenta.php'">VOLVER</button></p>
          <hr>
        </div>
    
        <div class="input-group mx-auto">
          <input id="clave" name="clave" class="form-control .text-primary" type="password" placeholder="NUEVA CONTRASEÑA" autocomplete="off" maxlength="20">
        </div>
      
        <div class="input-group mx-auto">
          <input id="confirmacion" name="confirmacion" class="form-control .text-primary" type="password" placeholder="REPETIR CONTRASEÑA" autocomplete="off" maxlength="20">
        </div>

        <div class="text-center"> 
          <button class="btn btn-responsive btninter" type="submit" id="botonCambiar" >CAMBIAR</button>
          
        </div>

        <div id="loader" style="display:none"></div>
      </form>
      <br>
      <br>
    </div>



    <!-- Para celular -->
    <div class="d-block d-sm-block d-md-none">
      <br/>
      <form method="POST" id="formulario">
         
        <div class="text-center"> 
          <hr>
          <p id="titulochico" >CAMBIAR MI CONTRASEÑA</p>
          <hr>
        </div>

        <div class="input-groupchico mx-auto">
          <input id="clave" name="clave" class="form-control .text-primary" type="password" placeholder="NUEVA CONTRASEÑA" autocomplete="off" maxlength="20">
        </div>

        <div class="input-groupchico mx-auto">
          <input id="confirmacion" name="confirmacion" class="form-control .text-primary" type="password" placeholder="REPETIR CONTRASEÑA" autocomplete="off" maxlength="20">
        </div>

        <div class="text-center"> 
          <button class="btn btn-responsive btninter" type="submit" id="botonCambiar" style="margin:5px">CAMBIAR</button>
          <br>
          <button class="btn btn-responsive btninter" type="button" id="botonVolver" style="margin:5px" onclick="window.location='cuenta.php'">VOLVER</button>
        </div>

      </form>
    </div>
</body>
</html>

<script type="text/javascript">

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
        window.location.replace("salir.php");
    });
  }

  $('#botonCambiar').click(function(evento){
    evento.preventDefault();
    if(validarFormulario()){
      var datos=$('#formulario').serialize();
      $.ajax({
          url: 'actualizacion.php',
          type:'POST',
          data: datos,
          beforeSend: function() {
            $("input").prop('disabled', true); //Bloqueo el formulario
            $('#botonCambiar').attr("disabled", true); //Bloqueo el boton
            //$("#loader").show();
            $("#loader").css('display','block');
          },
          success: function(data){
            //console.log(data);
           $("#loader").css('display','none');
            var jsonData = JSON.parse(data);
            if(jsonData.salida == 0){
              return mensajeExito(jsonData.mensaje);
            }
            else{
              $("input").prop('disabled', false); //Desbloqueo el formulario
              $('#botonCambiar').attr("disabled", false); //Desbloqueo el boton
              return mensajeError(jsonData.mensaje);
            }
          }
      });
      return false;
    }
  });

  function validarFormulario(){
    
    if($("#clave").val() == ""){
      return mensajeError("Debe ingresar su nueva CONTRASEÑA");
      $("#clave").focus();
      return false;
    }
    if($("#confirmacion").val() == ""){
      return mensajeError("Debe confirmar la CONTRASEÑA");
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

