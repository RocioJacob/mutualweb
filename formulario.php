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
include ('estiloMW.php');
$tramite = $_GET["tramite"];
?>
<head><title>Formulario</title></head>
<body>
<div class="container">

<!-- Para computadora -->
<!--div class="d-none d-sm-none d-md-block"-->
<div id="saludo"><?php echo $nombre?> <button class="btn" type="button" id="botonVolver" onclick="window.location='tramites.php'">Volver</button></div>
<br/>

    <?php 
    if($tramite==="ACTUALIZACION DE DATOS"){
        $tramite1 = "ACTUALIZACIÓN DE DATOS";
    ?>
        <div><span id="nomTramite"><?php echo $tramite1?></span></div>
        <br>
    <?php 
    }else {
    ?>
          <div><span id="nomTramite"><?php echo $tramite?></span></div>
          <br>
    <?php 
    } ?>

  <form method="POST" id="formulario" enctype="multipart/form-data">
  <div class="form-row">

    <input type="text" class="form-control" id="tramite" name="tramite" hidden="hidden" value="<?php echo $tramite;?>" readonly>

    <?php 
      //condiciones($tramite);

      if($tramite === "ACTUALIZACION DE DATOS"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR ACTUALIZAR DATOS
              <br />1. Estar habilitado en la Mutual.
              <br /> La nuevos datos serán corroborados y si todo esta bien, serán confirmados por el área de afiliaciones.
              <br /> Complete solo los datos que desea actualizar. Puede adjuntar archivos que notifiquen el cambio.
              <br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.</div>
          </div>
  <?php } ?>

  <?php if($tramite === "ASISTENCIAL"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR ASISTENCIAL
              <br />1. Estar habilitado en la Mutual.
              <br />2. Tener sus datos actualizados.
            </div>
          </div>
   <?php } ?>

  <?php if($tramite === "REINTEGRO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR REINTEGRO
              <br />1. Estar habilitado en la Mutual.
              <br />2. Tener sus datos actualizados.
            </div>
          </div>
  <?php } ?>

  <?php if($tramite === "SUBSIDIO SOLIDARIO MUTUAL"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA ADHERIRSE AL SUBSIDIO SOLIDARIO MUTUAL
              <br />1. Estar habilitado en la Mutual.
              <br />2. Tener sus datos actualizados.
              <br /> Para mas información ingresar a este link: <a href="https://mppneuquen.com.ar/subsidio-solidario" target="_blank">SSM</a></div>
          </div>
  <?php } ?>
        
  <?php if($tramite === "SUBSIDIO POR CASAMIENTO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR SUBSIDIO POR CASAMIENTO
              <br />1. Estar habilitado en la Mutual.
              <br />2. Tener actualizado el SSM.
              <br />3. Fotocopia del acta de matrimonio
              <br />4. Fotocopia del dni del titular.
              <br />5. Constancia de C.B.U (Banco o Homebanking).
              <br />6. Tener sus datos actualizados.
              <br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.</div>
          </div>
  <?php } ?>

  <?php if($tramite === "SUBSIDIO POR FALLECIMIENTO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR SUBSIDIO POR FALLECIMIENTO
              <br />1. Estar habilitado en la Mutual.
              <br />2. Tener actualizado el SSM.
              <br />3. Fotocopia del acta de defunción
              <br />4. Constancia de C.B.U (Banco o Homebanking).
              <br />5. Tener sus datos actualizados.
              <br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.</div>
          </div>
  <?php } ?>
   
  <?php if($tramite === "SUBSIDIO POR NACIMIENTO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR SUBSIDIO POR NACIMIENTO
              <br />1. Estar habilitado en la Mutual.
              <br />2. Tener actualizado el SSM.
              <br />3. Fotocopia de la partida de nacimiento.
              <br />4. Fotocopia del dni del titular.
              <br />5. Constancia de C.B.U (Banco o Homebanking).
              <br />6. Tener sus datos actualizados.
              <br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.</div>
          </div>
  <?php } ?>

  <?php if($tramite === "EDUCACION-BECAS"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">1. Para realizar una consulta relacionada con educación, deberá ingresarla en el campo comentario.
              <br />Para mas información ingresar al siguiente link: 
              <a href="https://mppneuquen.com.ar/becas" target="_blank">EDUCACIÓN</a></div>
          </div>
  <?php } ?>

  <?php if($tramite === "TURISMO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">* Para realizar una consulta relacionada con turismo, deberá ingresarla en el campo Comentario.
              <br />Para mas información ingresar al siguiente link: 
              <a href="https://mppneuquen.com.ar/turismo/" target="_blank">TURISMO</a></div>
          </div>
  <?php } ?>

  <?php if($tramite === "CONSULTA GENERAL"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">* Para realizar una consulta general, deberá ingresarla en el campo comentario y a la brevedad le contestarán
              <br />
            </div>
          </div>
  <?php } ?>
       
  <?php if($tramite === "SOLICITUD DE TURNO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">* Debe seleccionar la delegación donde desea asistir personalmente, en el campo Delegación que gestionara el trámite.
              <br />*Si desea reunirse con algún representante de la institución, deberá aclararlo en el campo comentario.
              <br />*Una vez iniciado el tramite, se comunicarán vía email o telefónicamente para confirmarlo.
            </div>
          </div>
  <?php } ?>

  <?php if($tramite === "ALTA CARGA"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA ASOCIAR A UNA CARGA DE FAMILIA
              <br />1. Fotocopia del DNI del titular
              <br />2. Fotocopia del DNI de la carga o acta de nacimiento.
              <br />3. Fotocopia del acta de matrimonio o declaración jurada de concubinato.
              <br />4. Certificación de la carga extendido por el ISSN.
              <br />5. Primero las cargas deben ser dadas de alta en la obra social (ISSN), solo después podrá incorporarlas en su mutual.
              <br />Gestione un trámite por cada carga. No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp
            </div>
          </div>
  <?php } ?>

  <?php if($tramite === "REEMPADRONAMIENTO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA REEMPADRONARSE
              <br />1. Fotocopia del DNI del titular
              <br />2. Fotocopia del DNI de las cargas o acta de nacimiento de los hijos.
              <br />3. Fotocopia del acta de matrimonio o declaración jurada de concubinato.
              <br />4. Certificación de la carga extendido por el ISSN.
              <br />5. Fotocopia del primer recibo de sueldo como pensionado/a o retirado.
              <br />6. Constancia de C.B.U (Banco o Homebanking) Y CUIL.
              <br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.
            </div>
          </div>
  <?php } ?>

  <?php if($tramite === "BAJA CARGA"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR LA BAJA DE UNA CARGA
              <br />1. No tener deuda en Mutual.
              <br />2. Si es baja del titular, no es necesario gestionar las bajas de sus cargas, alcanza solo con la del titular.
              <br />La documentacion faltante, será requerida vía mail o WhatsApp.
            </div>
          </div>
  <?php } ?>

  <?php if($tramite === "BAJA TITULAR"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR LA BAJA DE AFILIACIÓN
              <br />1. No tener deuda en Mutual.
              <br />2. No es necesario gestionar las bajas de sus cargas, estas se dan de baja automáticamente.
              <br/>La documentacion faltante, será requerida vía mail o WhatsApp.
            </div>
          </div>
  <?php } ?>

    <div class="form-group col-md-12">
      <label>
        <input type="checkbox" name="terminos" id="terminos"> ACEPTO TÉRMINOS Y CONDICIONES
      </label>
      <br>
    </div>
    
      <?php 
      if($tramite === "ACTUALIZACION DE DATOS"){
        $resultArray = titularCargas($documento);
        
          if(!hayConexion($resultArray)){
              echo "PROBLEMAS DE CONEXIÓN CON LA BASE DE DATOS";
          }
          else{
              //echo "NO HAY PROBLEMAS DE CONEXIÓN CON LA BASE DE DATOS";
              $arrayTitular = datosTitular($resultArray);
              $arrayCarga = datosCargas($resultArray);
          ?>
              <div class="container">
                <div style = "font-family: 'Verdana', cursive; font-size: 22px;color:#003366">DATOS ACTUALES</div>
                <hr color="#003366"/>
        
                <div class="row">
                  <div class="col"><h6>APELLIDO: <a style="color: black;"><?php echo $arrayTitular['apellido'].'<br>';?></a></h6></div>
                  <div class="col"><h6>NOMBRE: <a style="color: black;"><?php echo $arrayTitular['nombre'].'<br>';?></a></h6></div>
                </div>

                <div class="row">
                  <div class="col"><h6>DOCUMENTO: <a style="color: black;"><?php echo $arrayTitular['documento'].'<br>';?></a></h6></div>
                  <div class="col"><h6>LEGAJO: <a style="color: black;"><?php echo $arrayTitular['legajo'].'<br>';?></a></h6></div>
                </div>

                <div class="row">
                  <div class="col"><h6>FECHA NACIMIENTO: <a style="color: black;"><?php echo $arrayTitular['nacimiento'].'<br>';?></a></h6></div>
                  <div class="col"><h6>CUIL: <a style="color: black;"><?php echo $arrayTitular['cuil'].'<br>';?></a></h6></div>
                </div>

                <div class="row">
                  <div class="col"><h6>LOCALIDAD: <a style="color: black;"><?php echo $arrayTitular['localidad'].'<br>';?></a></h6></div>
                  <div class="col"><h6>DIRECCION: <a style="color: black;"><?php echo $arrayTitular['direccion'].'<br>';?></a></h6></div>
                </div>

                <div class="row">
                  <div class="col"><h6>EMAIL REGISTRO: <a style="color: black;"><?php echo $arrayTitular['email2'].'<br>';?></a></h6></div>
                  <div class="col"><h6>CELULAR REGISTRO: <a style="color: black;"><?php echo $arrayTitular['celular'].'<br>';?></a></h6></div>
                </div>
              </div>

      <?php } //else ?>

        <div class="container"><br><br></div>

          <div class="container">
            <div style = "font-family: 'Verdana', cursive; font-size: 22px;color:#003366">DATOS A ACTUALIZAR <span style="color:red; font-size: 15px;"><?php echo " (Complete solo lo que desea actualizar)"?></span></div>
            <hr color="#003366"/>
          </div>

          <div class="form-group col-md-4">
            <label style="color:#003366">Apellido</label>
            <input class="form-control" id="apellido" name="apellido" placeholder="" maxlength="30" autocomplete="off" style="text-transform:uppercase;">
          </div>

          <div class="form-group col-md-4">
            <label style="color:#003366">Nombre</label>
            <input class="form-control" id="nombre" name="nombre" placeholder="" maxlength="30" autocomplete="off" style="text-transform:uppercase;">
          </div>

          <div class="form-group col-md-4">
            <label style="color:#003366">Cuil</label>
            <input class="form-control" id="cuil" name="cuil" placeholder="" autocomplete="off" maxlength="11">
          </div>

          <div class="form-group col-md-4">
            <label style="color:#003366">Fecha nacimiento</label>
            <input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento" placeholder="" autocomplete="off">
          </div>
          
          <div class="form-group col-md-4">
              <label style="color:#003366">Localidad</label>
                <select id="localidad" name="localidad" class="form-control">
                  <option value="">SELECCIONE UNA LOCALIDAD</option>
                  <option value="ALLEN">ALLEN</option>
                  <option value="ALUMINE">ALUMINE</option>
                  <option value="ANDACOLLO">ANDACOLLO</option>
                  <option value="AÑELO">AÑELO</option>
                  <option value="BAJADA DEL AGRIO">BAJADA DEL AGRIO</option>
                  <option value="BARRANCAS">BARRANCAS</option>
                  <option value="BUTA RANQUIL">BUTA RANQUIL</option>
                  <option value="CAVIAHUE">CAVIAHUE</option>
                  <option value="CENTENARIO">CENTENARIO</option>
                  <option value="COPAHUE">COPAHUE</option>
                  <option value="CHOS MALAL">CHOS MALAL</option>
                  <option value="CINCO SALTOS">CINCO SALTOS</option>
                  <option value="CIPOLLETTI">CIPOLLETTI</option>
                  <option value="COLLON CURA">COLLON CURA</option>
                  <option value="CUTRAL CO">CUTRAL CO</option>
                  <option value="EL CHOCON">EL CHOCON</option>
                  <option value="EL CHOLAR">EL CHOLAR</option>
                  <option value="EL HUECU">EL HUECU</option>
                  <option value="FDEZ ORO">FDEZ ORO</option>
                  <option value="GRAL ROCA">GRAL ROCA</option>
                  <option value="JUNIN DE LOS ANDES">JUNIN DE LOS ANDES</option>
                  <option value="LAS GRUTAS">LAS GRUTAS</option>
                  <option value="LAS LAJAS">LAS LAJAS</option>
                  <option value="LAS OVEJAS">LAS OVEJAS</option>
                  <option value="LONCOPUE">LONCOPUE</option>
                  <option value="MARIANO MORENO">MARIANO MORENO</option>
                  <option value="NEUQUEN CAPITAL">NEUQUEN CAPITAL</option>
                  <option value="OTROS">OTROS</option>
                  <option value="PICUN LEUFU">PICUN LEUFU</option>
                  <option value="PIEDRA DEL AGUILA">PIEDRA DEL AGUILA</option>
                  <option value="PLAZA HUINCUL">PLAZA HUINCUL</option>
                  <option value="PLOTTIER">PLOTTIER</option>
                  <option value="RINCON DE LOS SAUCES">RINCON DE LOS SAUCES</option>
                  <option value="SAN MARTIN DE LOS ANDES">SAN MARTIN DE LOS ANDES</option>
                  <option value="SAN PATRICIO DEL CHAÑAR">SAN PATRICIO DEL CHAÑAR</option>
                  <option value="SENILLOSA">SENILLOSA</option>
                  <option value="VILLA LA ANGOSTURA">VILLA LA ANGOSTURA</option>
                  <option value="VILLA PEHUENIA">VILLA PEHUENIA</option>
                  <option value="VILLA TRAFUL">VILLA TRAFUL</option>
                  <option value="VISTA ALEGRE">VISTA ALEGRE</option>
                  <option value="ZAPALA">ZAPALA</option>
                </select>
              </div>

              <div class="form-group col-md-4">
                <label style="color:#003366">Direccion</label>
                <input class="form-control" id="domicilio" name="domicilio" placeholder="" maxlength="60" autocomplete="off" style="text-transform:uppercase;">
              </div>

              <div class="form-group col-md-4">
                <label style="color:#003366">Legajo</label>
                <input class="form-control" id="legajo" name="legajo" placeholder="" autocomplete="off" maxlength="6">
              </div>

              <div class="form-group col-md-4">
                <label style="color:#003366">Celular</label>
                <input class="form-control" id="celular" name="celular" placeholder="" autocomplete="off" maxlength="20">
              </div>

              <div class="form-group col-md-12">
                <label style="coorl:#003366">Adjuntar archivos</label><br>
                <input multiple="true" name="archivo[]" id="file" type="file"><br>
                <label style="color:#003366">Hasta 3 archivos - 5MB tamaño total - Formatos aceptados: PDF, PNG, JPG y JPEG.
                <br>Puede adjuntar seleccionando todos los archivos de una sola vez o presionando la tecla CTRL y seleccionando cada uno de ellos a la vez.</label><br>
              </div>

  <?php  } //if($tramite === "ACTUALIZACION DE DATOS") 
     
        if(($tramite === "EDUCACION-BECAS") or ($tramite === "TURISMO") or ($tramite === "CONSULTA GENERAL")){
    ?>   
          <div class="form-group col-md-4">
              <label style="color:#003366">Delegacion gestion del tramite *</label>
              <select id="delegacion" name="delegacion" class="form-control">
                <option value="NEUQUEN CAPITAL">SEDE CENTRAL - NEUQUEN CAPITAL</option>
              </select>
          </div>
        <?php 
        }
        
        if(($tramite === "ASISTENCIAL") or ($tramite === "REINTEGRO") or ($tramite === "SUBSIDIO SOLIDARIO MUTUAL") or ($tramite === "SUBSIDIO POR NACIMIENTO") or ($tramite === "SUBSIDIO POR CASAMIENTO") or ($tramite === "SUBSIDIO POR FALLECIMIENTO") or ($tramite === "ALTA CARGA") or ($tramite === "REEMPADRONAMIENTO") or ($tramite === "BAJA CARGA") or ($tramite === "BAJA TITULAR") or ($tramite === "SOLICITUD DE TURNO")) {
        ?>
          
            <div class="form-group col-md-4">
              <label style="color:#003366">Delegacion que gestionará el tramite *</label>
                <select id="delegacion" name="delegacion" class="form-control" style="border-color: #2874A6">
                  <option value="">SELECCIONE DELEGACION CERCANA</option>
                  <option value="ALUMINE">ALUMINE</option>
                  <option value="CENTENARIO">CENTENARIO</option>
                  <option value="CHOS MALAL">CHOS MALAL</option>
                  <option value="CUTRAL CO">CUTRAL CO</option>
                  <option value="EL CHOLAR">EL CHOLAR</option>
                  <option value="JUNIN DE LOS ANDES">JUNIN DE LOS ANDES</option>
                  <option value="LAS GRUTAS">LAS GRUTAS</option>
                  <option value="LAS LAJAS">LAS LAJAS</option>
                  <option value="LONCOPUE">LONCOPUE</option>
                  <option value="PICUN LEUFU">PICUN LEUFU</option>
                  <option value="NEUQUEN CAPITAL">SEDE CENTRAL - NEUQUEN CAPITAL</option>
                  <option value="PLOTTIER">PLOTTIER</option>
                  <option value="SAN MARTIN DE LOS ANDES">SAN MARTIN DE LOS ANDES</option>
                  <option value="VILLA LA ANGOSTURA">VILLA LA ANGOSTURA</option>
                  <option value="ZAPALA">ZAPALA</option>
                </select>
            </div>

        <?php 
        } 
        ?>

        <div class="form-group col-md-12">
            <label style="color:#003366">Comentario*</label>
            <textarea class="form-control" id="comentario" name="comentario" rows="3" placeholder="Maximo 150 caracteres" style="text-transform:uppercase" maxlength="150"></textarea>
        </div>

      <?php 
        if(($tramite === "ALTA CARGA") or ($tramite === "REEMPADRONAMIENTO") or ($tramite === "BAJA CARGA") or ($tramite === "BAJA TITULAR") or ($tramite === "SUBSIDIO POR CASAMIENTO") or ($tramite === "SUBSIDIO POR FALLECIMIENTO") or ($tramite === "SUBSIDIO POR NACIMIENTO")){ ?>
          
          <div class="form-group col-md-12">
            <label style="color:#003366">Adjuntar archivos</label><br>
            <input multiple="true" name="archivo[]" id="file" type="file"><br>
            <label style="color:#003366">Hasta 3 archivos - 5MB tamaño total - Formatos aceptados: PDF, PNG, JPG y JPEG.
            <br>Puede adjuntar seleccionando todos los archivos de una sola vez o presionando la tecla CTRL y seleccionando cada uno de ellos a la vez.</label><br>
          </div>

  <?php } ?> 

      <!--div class="form-group col-md-4">
        <label style="color:#003366">Captcha *</label>
        <div id="captcha" class="g-recaptcha" data-sitekey="6Le7vq4ZAAAAAG0r8_wWLWUWnriiquOyerzUkIdL"></div>
      </div-->

      </div>
        <button class="btn" type="submit" id="botonEnviar">Enviar</button>
       

      <div id="loader" style="display:none"></div>
    </form>
    
    <p style="color:#003366">     * Datos obligatorios</p>
  
  <!--/div--><!-- Para computadora -->
</div>

</body>
<footer id="pieDePaginaTramites">RECUERDE QUE UN ADMINISTRADOR DE NUESTRA INSTITUCION SE COMUNICARA CON USTED A LA BREVEDAD UNA VEZ INICIADO El TRAMITE</footer>
</html>

<script type="text/javascript">

$('#botonEnviar').click(function(evento){
    evento.preventDefault();
    var tramite = document.getElementById("tramite").value;//Obtengo el tramite y lo envio para validar
    if(validarFormulario(tramite)){
      var datos = new FormData($('#formulario')[0]);
      $.ajax({
        url: 'cargar-tramite.php',
        type:'POST',
        data: datos,
        processData: false,
        contentType: false,
        beforeSend: function() {
              //$("#loading-image").show();
            $("input, select, textarea").prop('disabled', true);
            $('#botonEnviar').attr("disabled", true);
            $("#loader").css('display','block');
           },
        success: function(data){
          console.log(data);
         $("#loader").css('display','none');
         var jsonData = JSON.parse(data);
          if(jsonData.salida == 0){
            return mensajeExito(jsonData.mensaje);
          }
          else{
            $("input, select, textarea").prop('disabled', false);
            $('#botonEnviar').attr("disabled", false); //Desbloqueo el boton
            return mensajeError(jsonData.mensaje);
          }
        }
      });
      return false;
    }
  });


function validarFormulario(tramite){

  if($("input[type='checkbox']").is(':checked') === false){
    return mensajeError("DEBE ACEPTAR LOS TERMINOS Y CONDICIONES");
    return false;
  }
    
  if($("#delegacion").val() == ""){
    return mensajeError("Ingrese la DELEGACIÓN que gestionará su trámite");
    $("#delegacion").focus();
    return false;
  }

  if($("#comentario").val() == ""){
    return mensajeError("Debe ingresar un COMENTARIO");
    $("#comentario").focus();
    return false;
  }

  return true;
};

function mensajeExito($mensaje){
  Swal.fire({
    icon: 'success',
    width:'650px',
    title: $mensaje, 
    allowOutsideClick: false,
  }).then(function(){
      window.location.replace("menu.php");
  });
}

function mensajeError($mensaje){
  swal.fire({
    title: $mensaje, 
    icon: 'error',
    width:'650px',
    allowOutsideClick: false,
  });
}

</script>


