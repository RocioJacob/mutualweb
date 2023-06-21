<?php 
session_start();
 //Si existe una sesion iniciada redirigo a menu
if (isset($_SESSION['documento'])) {
  header('Location: menu.php');
}
?>
<!DOCTYPE html>
<html>
  <head>
  <?php 
  include('head.php');
  ?>
  <head><title>Inicio de sesión</title></head>
  </head>
<body>

<div class="container">
  <div class="container" align="center">
    <img id="imagen" src="imagenes/logo-mppn.png">
  </div>

    <!--p id="titulo">INICIAR SESIÒN</p-->
    <p id="titulo" >INICIAR SESIÓN</p>
    <form method="POST" id="formulario">
      
      <div class="input-group mx-auto">
        <input type="text" id="documento" name="documento" class="form-control" placeholder="Numero Documento"  autocomplete="off" maxlength="8">
      </div>

      <div class="input-group mx-auto">
          <input id="clave" name="clave" class="form-control .text-primary" type="password" placeholder="Contraseña"  autocomplete="off" maxlength="20">
      </div>

      <div class="text-center"> 
        <button type="submit" id="botonIngresar" >INGRESAR</button>
      </div>

    </form>
    <p style="margin:5px">
      <a href="registrarse.php">Registrarme</a><br>
      <a href="activar.php">Código de activación</a><br>
      <a href="recuperacion.php">¿Has olvidado tu contraseña?</a><br>
      <a href="verificacion.php">¿Tengo email cargado en la mutual?</a>
      <!--a href="recuperacion.php">Ingresar código de activación</a-->
    </p>

  <div class="container col-md-12">
    <p id="subtitulo">Si tiene un código para activar su cuenta, deberá ingresarlo en la opción código de activación</span></p>
  </div>
  <br>

</div>
</body>
</html>

<script type="text/javascript">

  function mensajeError($mensaje){
    swal.fire({
      title: $mensaje, 
      icon: 'error',
      width:'600px',
      allowOutsideClick: false,
    });
  }

  function mensajeExito($mensaje){
    Swal.fire({
      //icon: 'success',
      title: $mensaje, 
      width:'650px',
      allowOutsideClick: false,
    }).then(function(){
        window.location.replace("menu.php");
    });
    
  }

  $('#botonIngresar').click(function(evento){
    evento.preventDefault();
    if(validarFormulario()){
      var datos=$('#formulario').serialize();
      $.ajax({
          url: 'login.php',
          type:'POST',
          data: datos,
          success: function(data){
            //console.log(data);
            var jsonData = JSON.parse(data);
            if(jsonData.salida == 1){ //Datos incorrectos
              return mensajeError(jsonData.mensaje);
            }
            else{
              return mensajeExito(jsonData.mensaje);
              //window.location.replace("menu.php");
            }
          }
      });
      return false;
    }
  });

  function validarFormulario(){
    if($("#documento").val() == ""){
      //return mensajeError("Debe ingresar DOCUMENTO");
      return mensajeError("Datos incompletos");
      $("#documento").focus();
      return false;
    }
    if($("#clave").val() == ""){
      //return mensajeError("Debe ingresar CONTRASEÑA");
      return mensajeError("Datos incompletos");
      $("#clave").focus();
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

  #botonIngresar{
    height: 40px; 
    width: 150px; 
    border: 2px solid;
    border-radius: 25px;
    font-size: 15px;
    /*background: #003366;*/
    background-color: #2b4a83;
    color: white;
    /*font-family: 'Georgia', cursive;*/
  }

  #botonIngresar:hover {
  background: white;
  /*color: #003366 !important;*/
  color: #2b4a83 !important;
  }
  #imagen{
    height: 25%;
    width: 25%;
    margin-top:3%;
  }
  #documento::placeholder, #clave::placeholder {
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
  #documento, #clave{
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
