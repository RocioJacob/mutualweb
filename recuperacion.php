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

  #botonVolver,#botonRecuperar{
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

  #botonVolver:hover,#botonRecuperar:hover {
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
