<!DOCTYPE html>
<html>
  <head>
  <?php 
  include('head.php');
  ?>
  </head>
<body>

<div class="container"
>
  <div class="container" align="center">
    <img id="imagen" src="imagenes/logo-mppn.png">
  </div>
  
  <p id="titulo">ACTIVAR CUENTA</p>
    <form method="POST" id="formulario">

      <div class="input-group mx-auto">
        <input type="text" id="email" name="email" class="form-control" placeholder="EMAIL" autocomplete="off" maxlength="40">
      </div>
      <div class="input-group mx-auto">
        <input type="text" id="codigo" name="codigo" class="form-control" placeholder="CÓDIGO DE ACTIVACIÓN"  autocomplete="off" maxlength="6">
      </div>
      <div class="input-group mx-auto">
        <input id="clave" name="clave" class="form-control .text-primary" type="password" placeholder="Contraseña" autocomplete="off" maxlength="20">
      </div>
      <div class="input-group mx-auto">
        <input id="confirmacion" name="confirmacion" class="form-control .text-primary" type="password" placeholder="Repetir contraseña"  autocomplete="off" maxlength="20">
      </div>
      <div class="text-center"> 
       <div id="cajaDeBotones"> <button class="btn btn-responsive btninter" type="submit" id="botonActivar" >ACTIVAR</button></div>
        <button class="btn btn-responsive btninter" id="botonVolver" >VOLVER</button>
      </div>
      <div id="loader" style="display:none"></div>
    </form>
    <!--p style="margin:5px">
      <a href="index.php">Volver</a>
    </p-->
    <div class="container col-md-6">
     <p id="subtitulo">Ingrese su email, el código de activación que se le envió al mismo y la contraseña elegida para poder acceder al sistema<br>Por consultas sobre el sistema escribir a <span >soporte@mppneuquen.com.ar</span></p>
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

  $('#botonActivar').click(function(evento){
    evento.preventDefault();
    if(validarFormulario()){
      var datos=$('#formulario').serialize();
      $.ajax({
          url: 'activacion.php',
          type:'POST',
          data: datos,
          beforeSend: function() {
            $("input").prop('disabled', true); //Bloqueo el formulario
            $('#botonActivar').attr("disabled", true); //Bloqueo el boton
            //$("#loader").show();
            $("#loader").css('display','block');
          },
          success: function(data){
            //console.log(data);
           $("#loader").css('display','none');
            //console.log(data);
            var jsonData = JSON.parse(data);
            if(jsonData.salida == 0){
              return mensajeExito(jsonData.mensaje);
            }
            else{
              $("input").prop('disabled', false); //Desbloqueo el formulario
              $('#botonActivar').attr("disabled", false); //Desbloqueo el boton
              return mensajeError(jsonData.mensaje);
              //setTimeout(mensajeError(jsonData.mensaje), 5000);
            }
          }
      });
      return false;
    }
  });

  function validarFormulario(){
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
    if($("#codigo").val() == ""){
      return mensajeError("El campo CODIGO DE ACTIVACIÒN no puede estar vacío");
      $("#codigo").focus();
      return false;
    }
    if($("#clave").val() == ""){
      return mensajeError("El campo CONTRASEÑA no puede estar vacío");
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

  #botonVolver,#botonActivar{
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

  #botonVolver:hover,#botonActivar:hover {
  background: white;
  /*color: #003366 !important;*/
  color: #2b4a83 !important;
  }
  #imagen{
    height: 25%;
    width: 25%;
    margin-top:3%;
  }
  #email::placeholder, #codigo::placeholder, #clave::placeholder, #confirmacion::placeholder {
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
  #email, #codigo, #clave, #confirmacion {
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
