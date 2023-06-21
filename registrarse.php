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
        <button class="btn btn-responsive btninter" type="submit" id="botonRegistrar">REGISTRARME</button></div>
        
        <button class="btn btn-responsive btninter" id="botonVolver">VOLVER</button>
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

  #botonVolver,#botonRegistrar{
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

  #botonVolver:hover,#botonRegistrar:hover {
  background: white;
  /*color: #003366 !important;*/
  color: #2b4a83 !important;
  }
  #imagen{
    height: 25%;
    width: 25%;
    margin-top:3%;
  }
  #documento::placeholder, #email::placeholder {
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
  #documento, #email{
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
