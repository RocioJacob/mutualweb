/*
$contador = 0;
$archivos = glob("$directorio/*");
glob("$directorio/{*.pdf}", GLOB_BRACE);

foreach ($archivos as $archivo) {   
     echo "nombre: <strong> $archivo </strong></br>" ;
}
*/

/*
$thefolder = $directorio;
if ($handler = opendir($thefolder)) {
    while (false !== ($file = readdir($handler))) {
            echo "$file<br>";
    }
    closedir($handler);
}
*/
/*
if ($handler = opendir($thefolder)) {
  echo "<ul>";
    while (false !== ($file = readdir($handler))) {
            echo "<li>$file</li>";
    }
    echo "</ul>";
    closedir($handler);
}
*/


//echo "Contador: ". count(glob("./facturas/$documento/{*.pdf}",GLOB_BRACE));

/*if( file_exists("./facturas/$documento") == true )
        echo "<p>El directorio existe</p>";
    else
        echo "<p>El directorio no existe</p>";*/




        
function listar_s_directorio($directorio)
{ 
   // validamos que sea un directorio
   if (is_dir($directorio)) 
   { 
      // abrimos el directorio para poder leerlo
      if ($dr = opendir($directorio)) 
      { 
         // leemos el directorio
         while (($file = readdir($dr)) !== false) 
         {  
            // validamos que los datos devueltos sean un directorio y no archivo
            if (is_dir($directorio . $file) && $file!="." && $file!="..")
            { 
               //de ser un directorio lo imprimimos en pantalla
               echo "<br>: $directorio$file"; 
            } 
         } 
         // al finalizar cerramos el directorio
         closedir($dr); 
      } 
   }
   else
   { 
     echo "<br>No es directorio valida"; 
   }
}

function listar_directorios_ruta($ruta){
   // abrir un directorio y listarlo recursivo
   if (is_dir($ruta)) {
      if ($dh = opendir($ruta)) {
         while (($file = readdir($dh)) !== false) {
            //esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio
            //mostraría tanto archivos como directorios
            //echo "<br>Nombre de archivo: $file : Es un: " . filetype($ruta . $file);
            if (is_dir($ruta . $file) && $file!="." && $file!=".."){
               //solo si el archivo es un directorio, distinto que "." y ".."
               echo "<br>Directorio: $ruta$file";
               listar_directorios_ruta($ruta . $file . "/");
            }
         }
      closedir($dh);
      }
   }else
      echo "<br>No es ruta valida";
}



//ESTA FUNCIONANDO

<?php
include("conexion.php");
$usuario = mysqli_query($conexion, "SELECT * FROM afiliados WHERE documento='32754564'");
$usuario = mysqli_fetch_assoc($usuario);

$query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE documento = '32754564'");
$cantidad = mysqli_num_rows($query);
$data = mysqli_fetch_array($query);
$documento = $data['documento'];

$directorio = "./facturas/$documento";

$ruta='./facturas/32754564/';
$lista = '';
if ($carpeta=opendir($ruta)){
    while (($file = readdir($carpeta)) !== false){
        if (is_dir($ruta.$file) && $file != '.' && $file != '..'){        
            //$lista .= '<li>'.$file.'</li>';
            echo "AÑO ".$file;
            listar($ruta.$file);
            echo "<br>";
        }
    }
}
//echo $lista;

function listar($directorio){
  if (is_dir($directorio)){
    if ($dh = opendir($directorio)){
  
      echo "<table class='table table-bordered order-table'>
        <thead>
          <tr>
            <th>FECHA</th>
            <th>ARCHIVO</th>
          </tr>
        </thead>";

      while (($file = readdir($dh)) !== false){
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        //if($file != '.' && $file != '..' && substr($file,-4) == ".pdf") {
          if($file != '.' && $file != '..' && $ext == "pdf") {
            //echo $file . "<br>";
            $name = pathinfo($file, PATHINFO_FILENAME);
            $mes = substr($name, 0, 2);
            $anio = substr($name, 3,6);
            $nombreMes = mes($mes);

            echo "<tr>
              <td>".$nombreMes." ".$anio."</td>
              <td><a href='$directorio' target='_blank'><img src='./imagenes/pdf1.jpg' height='50' width='50'>Descargar</a></td>
            </tr>";
            /*echo "<td align='center'>".$nombreMes." ".$anio."</td>";
            echo "<td align='center'><a href='./facturas/$documento/$file' target='_blank'><img src='./imagenes/pdf1.jpg' height='50' width='50'>Descargar</a></td>"."<br>";*/
          }
      }
      echo "</table>";
      closedir($dh);
    }
  }
}


function mes($mes){
  $salida="";
  if($mes == '01'){
    $salida = "ENERO";
  }
  elseif ($mes == '02') {
    $salida = "FEBRERO";
  }
  elseif ($mes == '03') {
    $salida = "MARZO";
  }
  elseif ($mes == '04') {
    $salida = "ABRIL";
  }
  elseif ($mes == '05') {
    $salida = "MAYO";
  }
  elseif ($mes == '06') {
    $salida = "JUNIO";
  }
  elseif ($mes == '07') {
    $salida = "JULIO";
  }
  elseif ($mes == '08') {
    $salida = "AGOSTO";
  }
  elseif ($mes == '09') {
    $salida = "SEPTIEMBRE";
  }
  elseif ($mes == '10') {
    $salida = "OCTUBRE";
  }
  elseif ($mes == '11') {
    $salida = "NOVIEMBRE";
  }
  else{
    $salida = "DICIEMBRE";
  }
  return $salida;
}

?>





<h6>CODIGO: <a style="color: black;"><?php echo $arrayTitular['codigo'].'<br>';?></a></h6>
  <h6>APELLIDO: <a style="color: black;"><?php echo $arrayTitular['apellido'].'<br>';?></a></h6>
  <h6>NOMBRE: <a style="color: black;"><?php echo $arrayTitular['nombre'].'<br>';?></a></h6>
  <h6>DOCUMENTO: <a style="color: black;"><?php echo $arrayTitular['documento'].'<br>';?></a></h6>
  <h6>LEGAJO: <a style="color: black;"><?php echo $arrayTitular['legajo'].'<br>';?></a></h6>
  <h6>NACIMIENTO: <a style="color: black;"><?php echo $arrayTitular['nacimiento'].'<br>';?></a></h6>
  <h6>CUIL: <a style="color: black;"><?php echo $arrayTitular['cuil'].'<br>';?></a></h6>
  <h6>DIRECCION: <a style="color: black;"><?php echo $arrayTitular['direccion'].'<br>';?></a></h6>
  <h6>LOCALIDAD: <a style="color: black;"><?php echo $arrayTitular['localidad'].'<br>';?></a></h6>
  <h6>PROVINCIA: <a style="color: black;"><?php echo $arrayTitular['provincia'].'<br>';?></a></h6>
  <h6>TELEFONO: <a style="color: black;"><?php echo $arrayTitular['telefono'].'<br>';?></a></h6>
  <h6>EMAIL: <a style="color: black;"><?php echo $arrayTitular['email'].'<br>';?></a></h6>
  <h6>FECHA DE ALTA: <a style="color: black;"><?php echo $arrayTitular['alta'].'<br>';?></a></h6>
  <h6>SSM: <a style="color: black;">
    <?php if($arrayTitular['ssm']=='1'){
      echo "SI".'<br>';
    }
    else{
      echo "NO".'<br>';
    }
    ?>
  </a></h6>
  <h6>HABILITADO: <a style="color: black;">
    <?php if($arrayTitular['habilitado']=='1'){
      echo "SI".'<br>';
    }
    else{
      echo "NO".'<br>';
    }
    ?>
  </a></h6>


  $day1 = "2006-04-12 12:30:00";
$day1 = strtotime($day1);
echo $day1;
echo "\n";
$day2 = "2006-04-13 14:35:05";
echo "\n";
$day2 = strtotime($day2);
echo $day2;
$diffHours = round(($day2 - $day1) / 3600);
echo "\n";
echo $diffHours;



date_default_timezone_set('America/Argentina/Buenos_Aires');
$hoy=date("Y-m-d H:i:s",time());
echo $hoy;
echo "\n";

$fecha_actual = date("d-m-Y");
echo $fecha_actual;
echo "\n";


$datetime1 = new DateTime('2009-10-11');
$datetime2 = new DateTime('2009-10-13');
$interval = $datetime1->diff($datetime2);
echo $interval->format('%R%a días');
echo "\n";

$datetime1 = new DateTime('2009-10-11 24:00:00');
$datetime2 = new DateTime('2009-10-15 12:00:00');
$interval = $datetime1->diff($datetime2);
echo $interval->format('%Y-%m-%d %H:%i:%s');
echo "\n";

$d1 = new DateTime("2018-12-30 00:00:00");
$d2 = new DateTime("2019-01-01 01:23:45");
$interval = $d1->diff($d2);
$diffInSeconds = $interval->s; //45
$diffInMinutes = $interval->i; //23
$diffInHours   = $interval->h; //8
$diffInDays    = $interval->d; //21
$diffInMonths  = $interval->m; //4
$diffInYears   = $interval->y; //1

echo $diffInSeconds." ".$diffInMinutes." ".$diffInHours." ".$diffInDays." ".$diffInMonths." ".$diffInYears;
echo "\n";
echo "\n";



















/*
$codigo = mysqli_real_escape_string($conexion,(strip_tags($_POST["codigo"],ENT_QUOTES)));
$email = mysqli_real_escape_string($conexion,(strip_tags($_POST["email"],ENT_QUOTES)));
$clave = mysqli_real_escape_string($conexion,(strip_tags($_POST["clave"],ENT_QUOTES)));
$clave = password_hash($clave, PASSWORD_DEFAULT);

//Busco el email ingresado en la tabla usuarios
$query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email='$email'");
$emailIngresado = $query->num_rows;

if($emailIngresado===0){//No se encuentra en la tabla usuarios
  echo json_encode(array('mensaje' => "El email ".'<br>'.$email.'<br>'." NO esta registrado", 'salida' => '1'));
}
else{//Se encuentra en la tabla usuarios
  //$data = mysqli_fetch_array($query);
  $data = mysqli_fetch_assoc($query);
  $emailAfiliado = $data['email']; //Obtengo el email
  $codigoAfiliado = $data['codigo'];
  $activadoAfiliado = $data['activo'];
  $documentoAfilado = $data['documento'];
  $fechacodigo = $data['fechacodigo'];

  //Busco los datos del afiliado en AFILIADOS que no tengo en USUARIOS
  $query = mysqli_query($conexion, "SELECT * FROM afiliados WHERE documento LIKE '$documentoAfilado'");
  $data = mysqli_fetch_assoc($query);
  $nombreAfiliado = $data['nombre'];
  $apellidoAfiliado = $data['apellido'];

  if($activadoAfiliado==1){ //Verifico si ya esta activado
    echo json_encode(array('mensaje' => "La cuenta con email".'<br>'.$email.'<br>'."ya esta activada", 'salida' => '1'));
  }
  else{//La cuenta no esta activada-Verifico si los codigos coinciden
    if($codigo!=$codigoAfiliado){//Los codigos NO coinciden
      echo json_encode(array('mensaje' => "El código ingresado".'<br>'."NO coincide con el enviado a".'<br>'.$emailAfiliado, 'salida' => '1'));
    }
    else{//Los codigos coinciden
      $diferenciafechas = diferenciafechas($fechacodigo);
      if($diferenciafechas>=0.5){
        echo json_encode(array('mensaje' => "El código ingresado".'<br>'."ya No es válido".'<br>'."Deberá generar uno nuevo", 'salida' => '1'));
      }
      else{
        $salida = activarcuenta($documentoAfilado, $emailAfiliado, $clave, $nombreAfiliado, $apellidoAfiliado);
      }
    }

  }
}

function activarcuenta($documento, $emailAfiliado, $claveAfiliado, $nombreAfiliado, $apellidoAfiliado){
  include("conexion.php");

  $sentencia ="UPDATE usuarios SET activo='1', clave='$claveAfiliado', codigo=null WHERE documento='$documento'";
  $actualizar = mysqli_query($conexion, $sentencia);

  if($actualizar){
    //echo json_encode(array('mensaje' => "ESTADO ACTUALIZADO CON EXITO", 'salida' => '1'));

    //PARA EL ENVIO DE MAILS
    $mail = new PHPMailer(true);
    try {
      //$to = ["mutualpolicialneuquen@gmail.com", "sistemas@mppneuquen.com.ar", $emailAfiliado];
      $to = [$emailAfiliado];
      //Para enviar mail desde localhost
      $mail->SMTPOptions = array(
      'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
      )
      );
      $mail->SMTPDebug = 0;                   
      $mail->isSMTP();                                            
      $mail->Host = 'smtp.gmail.com';                    
      $mail->SMTPAuth = true;                                   
      $mail->Username = 'mutualpolicialneuquen@gmail.com';                   
      //$mail->Password = 'Mutual123456';
      $mail->Password = 'pxlmpkszpvzzkztb'; //Contraseña de aplicacion                          
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      $mail->setFrom('mutualpolicialneuquen@gmail.com', 'Mutual Policial');

      foreach($to as $emails) {
            $mail->addAddress($emails);
      } 
      $mail->isHTML(true); 
      $mail->Subject = 'Activacion de cuenta';
      $mensaje = generarmensaje($apellidoAfiliado, $nombreAfiliado, $emailAfiliado);
      $mail->Body = $mensaje;
      $mail->send();

      echo json_encode(array('mensaje' => "CUENTA ACTIVADA".'<br>'."Se envio comprobante a su email", 'salida' => '0'));

    }catch (Exception $e) {
      echo json_encode(array('mensaje' => "Error al enviar comprobante a su email".'<br>'."{$mail->ErrorInfo}".'<br>'."Igualmente su cuenta esta activada", 'salida' => '1'));
    }


  }
  else{
    echo json_encode(array('mensaje' => "Error al activar su cuenta", 'salida' => '1'));
  }
}


function generarmensaje($apellidoAfiliado, $nombreAfiliado, $email){
  
  $mensaje = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title></head><body>
    <div id="email" style="background: #003366; width: 820px; margin-left: auto; margin-right: auto;">
    <br>
    <img src="https://tramitesonline.mppneuquen.com.ar/imagenes/logoRecuperacion2.jpg" style="margin-left: auto;margin-right: auto;display: block;">
    <p style="color:white; text-align: center; font-size: 20px; font-family: Georgia, cursive;">ACTIVACI&Oacute;N DE CUENTA</p>
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Bienvenido '.$apellidoAfiliado." ".$nombreAfiliado.'</p>
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Su cuenta ha sido activada. Ya puede ingresar al sistema<br>Ante cualquier consulta escribir a<br>soporte@mppneuquen.com.ar</p>
    <h4 style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive;"> http://localhost/mutualWeb</h4><br>
    </div></body></html>';
  return $mensaje;
}


function obtenerfecha(){
  date_default_timezone_set('America/Argentina/Buenos_Aires');
  $hoy=date("Y-m-d H:i:s",time());
  return $hoy;
}

function diferenciafechas($fechacodigo){
  $fechaactual = obtenerfecha(); //Obtengo fecha actual
  $day1 = strtotime($fechacodigo);
  $day2 = strtotime($fechaactual);
  $diffHours = ($day2 - $day1) / 3600; //Comparo la diferencia entre fechas
  return $diffHours;
}
?>





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


    <h6 style="color:white; text-align: center; font-size: 18px; font-weight: normal; font-family: Georgia, cursive;">Puede ingresarlo en el siguiente enlace <br /><a href="http://localhost/mutualWeb/reestablecer.php">http://localhost/mutualWeb/reestablecer.php</a></h6>









//MENU.PHP
<style type="text/css">
body{
    /*background-color: #8faed6;*/
}

#containerMenu{
 /*min-height: 100vh;*/
  justify-content: center;
  }

.container{
    /*background-color: red;*/
}

.boton3 {
  /*color: #318aac !important;*/
  /*font-weight: 100;*/
  /*padding: 0.5em 1.2em;*/
  /*background: rgba(0,0,0,0);*/
  border: 2px solid;
  border-color: #0072BC;
  transition: all 1s ease;
  /*position: relative;*/

  position: relative;
  padding: 40px 1px; /*arriba-abajo, izq-der*/
  margin: 0px 10px 10px 0px;
  float: center;
  border-radius: 15px; /*redondeo de las esquinas*/
  /*font-family: 'Georgia', cursive;*/
  font-family: 'Georgia', cursive;
  font-size: 20px; /*tamaño letra*/
  color: white; /*color letra*/
  /*text-decoration: none;  */
 /* width: 195px !important; /*tamaño botones*/
  width: 250px !important;
  /*height: 300px;*/
  text-align: center; /*alineacion de texto*/
  /*background: #0072BC;*/
  background: #003366;
}
.boton3:hover {
  background: white;
  color: #0072BC !important;
}

.boton1 {
  /*color: #318aac !important;*/
  /*font-weight: 100;*/
  /*padding: 0.5em 1.2em;*/
  /*background: rgba(0,0,0,0);*/
  border: 2px solid;
  border-color: #1B4F72;
  transition: all 1s ease;
  /*position: relative;*/

  position: relative;
  padding: 40px 1px; /*arriba-abajo, izq-der*/
  margin: 0px 10px 10px 0px;
  float: center;
  border-radius: 15px; /*redondeo de las esquinas*/
  /*font-family: 'Georgia', cursive;*/
  font-family: 'Georgia', cursive;
  font-size: 20px; /*tamaño letra*/
  color: white; /*color letra*/
  /*text-decoration: none;  */
 /* width: 195px !important; /*tamaño botones*/
  width: 250px !important;
  /*height: 300px;*/
  text-align: center; /*alineacion de texto*/
  /*background: #0072BC;*/
  background: #1B4F72;
}
.boton1:hover {
  background: white;
  color: #0072BC !important;
}

.boton2 {
  /*color: #318aac !important;*/
  /*font-weight: 100;*/
  /*padding: 0.5em 1.2em;*/
  /*background: rgba(0,0,0,0);*/
  border: 2px solid;
  border-color: #2874A6;
  transition: all 1s ease;
  /*position: relative;*/

  position: relative;
  padding: 40px 1px; /*arriba-abajo, izq-der*/
  margin: 0px 10px 10px 0px;
  float: center;
  border-radius: 15px; /*redondeo de las esquinas*/
  /*font-family: 'Georgia', cursive;*/
  font-family: 'Georgia', cursive;
  font-size: 20px; /*tamaño letra*/
  color: white; /*color letra*/
  /*text-decoration: none;  */
 /* width: 195px !important; /*tamaño botones*/
  width: 250px !important;
  /*height: 300px;*/
  text-align: center; /*alineacion de texto*/
  background: #0072BC;
  /*background: #2874A6;*/
}
.boton2:hover {
  background: white;
  color: #0072BC !important;
}

.boton4 {
  /*color: #318aac !important;*/
  /*font-weight: 100;*/
  /*padding: 0.5em 1.2em;*/
  /*background: rgba(0,0,0,0);*/
  border: 2px solid;
  border-color: #5DADE2;
  transition: all 1s ease;
  /*position: relative;*/

  position: relative;
  padding: 40px 1px; /*arriba-abajo, izq-der*/
  margin: 0px 10px 10px 0px;
  float: center;
  border-radius: 15px; /*redondeo de las esquinas*/
  /*font-family: 'Georgia', cursive;*/
  font-family: 'Georgia', cursive;
  font-size: 20px; /*tamaño letra*/
  color: white; /*color letra*/
  /*text-decoration: none;  */
 /* width: 195px !important; /*tamaño botones*/
  width: 250px !important;
  /*height: 300px;*/
  text-align: center; /*alineacion de texto*/
  /*background: #0072BC;*/
  background: #5DADE2;
}
.boton4:hover {
  background: white;
  color: #0072BC !important;
}

.boton5 {
  /*color: #318aac !important;*/
  /*font-weight: 100;*/
  /*padding: 0.5em 1.2em;*/
  /*background: rgba(0,0,0,0);*/
  border: 2px solid;
  border-color: #154360;
  transition: all 1s ease;
  /*position: relative;*/

  position: relative;
  padding: 40px 1px; /*arriba-abajo, izq-der*/
  margin: 0px 10px 10px 0px;
  float: center;
  border-radius: 15px; /*redondeo de las esquinas*/
  /*font-family: 'Georgia', cursive;*/
  font-family: 'Georgia', cursive;
  font-size: 20px; /*tamaño letra*/
  color: white; /*color letra*/
  /*text-decoration: none;  */
 /* width: 195px !important; /*tamaño botones*/
  width: 250px !important;
  /*height: 300px;*/
  text-align: center; /*alineacion de texto*/
  /*background: #0072BC;*/
  background: #154360;
}
.boton5:hover {
  background: white;
  color: #0072BC !important;
}

.boton6 {
  /*color: #318aac !important;*/
  /*font-weight: 100;*/
  /*padding: 0.5em 1.2em;*/
  /*background: rgba(0,0,0,0);*/
  border: 2px solid;
  border-color: #3498DB;
  transition: all 1s ease;
  /*position: relative;*/

  position: relative;
  padding: 40px 1px; /*arriba-abajo, izq-der*/
  margin: 0px 10px 10px 0px;
  float: center;
  border-radius: 15px; /*redondeo de las esquinas*/
  /*font-family: 'Georgia', cursive;*/
  font-family: 'Georgia', cursive;
  font-size: 20px; /*tamaño letra*/
  color: white; /*color letra*/
  /*text-decoration: none;  */
 /* width: 195px !important; /*tamaño botones*/
  width: 250px !important;
  /*height: 300px;*/
  text-align: center; /*alineacion de texto*/
  /*background: #0072BC;*/
  background: #3498DB;
}
.boton6:hover {
  background: white;
  color: #0072BC !important;
}
</style>




/*  session_start();
  if (!isset($_SESSION['documento'])) {
    header('Location: index.php');
  }elseif(isset($_SESSION['documento'])){
    include 'conexion.php';
    $documento = $_SESSION['documento'];
  }else{
    echo "Error en el sistema";
  }*/


        <!--div class="col-md-3 col-lg-3 " align="center"> 
        <div id="load_img">
          <img class="img-responsive" src="<?php echo $row['logo'];?>" alt="Logo">
        </div>
        <br>        
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <input class='filestyle' data-buttonText="Logo" type="file" name="imagefile" id="imagefile" onchange="upload_image();">
            </div>
          </div>
        </div>
      </div-->

      <!--div class=" col-md-9 col-lg-9" align="right"-->


      <script>
  function upload_image(){
        
    var inputFileImage = document.getElementById("imagefile");
    var file = inputFileImage.files[0];
    if( (typeof file === "object") && (file !== null) )
    {
      $("#load_img").text('Cargando...'); 
      var data = new FormData();
      data.append('imagefile',file);
          
        $.ajax({
          url: "imagen_ajax.php",    // Url to which the request is send
          type: "POST",             // Type of request to be send, called as method
          data: data,         // Data sent to server, a set of key/value pairs (i.e. form fields and values)
          contentType: false,       // The content type used when sending data to the server.
          cache: false,             // To unable request pages to be cached
          processData:false,        // To send DOMDocument or non processed data file it is set to false
          success: function(data)   // A function to be called if request succeeds
          {
            $("#load_img").html(data);
              
          }
        }); 
    }
        
        
  }
</script>


/*

                  echo "<tr>
                        <td>".$mes." ".$anio."</td>
                        <td>"."**********"."</td>
                        <td><a href='$archivo' target='_blank'><img src='./imagenes/pdf1.jpg' height='50' width='50' align='right'>Descargar</a></td>
                      </tr>";
                  echo '<br>';
/*
$ruta2=$ruta1.'/'.$codigo; //Accedo a la carpeta con la factura
$listado2 = scandir($ruta2);
print_r($listado2);
/*
$carpeta=opendir($ruta);
if ($carpeta=opendir($ruta)){
  echo "ingreso";
}
else{
  echo "error";
}
//$ruta='./facturas/.'$anio'./.'$mes'./';

/*
$lista = '';
if ($carpeta=opendir($ruta)){
    while (($file = readdir($carpeta)) !== false){
        if (is_dir($ruta.$file) && $file != '.' && $file != '..' ){  
          if($file == $anio) {  
              //$lista .= '<li>'.$file.'</li>';
              //echo "AÑO ".$file;
              listar($ruta.$file, $mes, $anio);
              //echo "<br>";
          }
        }
    }
}
*/
/*
function listar($directorio, $mesIngresado, $periodo){
  if (is_dir($directorio)){
    if ($dh = opendir($directorio)){

        echo"";

        while (($file = readdir($dh)) !== false){
           $ext = pathinfo($file, PATHINFO_EXTENSION);
          //if($file != '.' && $file != '..' && substr($file,-4) == ".pdf") {

              $name = pathinfo($file, PATHINFO_FILENAME);
              $mes = substr($name, 0, 2);
              $anio = substr($name, 3,6);
              $nombreMes = mes($mes);

            if($file != '.' && $file != '..' && $ext == "pdf" && $periodo == $anio && $mesIngresado == '') {
            //echo $file . "<br>";
              echo "<tr>
                <td>".$nombreMes." ".$anio."</td>
                <td>"."**********"."</td>
                <td><a href='$directorio' target='_blank'><img src='./imagenes/pdf1.jpg' height='50' width='50' align='right'>Descargar</a></td>
              </tr>";
            }
            if($file != '.' && $file != '..' && $ext == "pdf" && $periodo == $anio && $mesIngresado == $nombreMes) {
              
              echo "<tr>
                <td>".$nombreMes." ".$anio."</td>
                <td>"."**********"."</td>
                <td><a href='$directorio' target='_blank'><img src='./imagenes/pdf1.jpg' height='50' width='50' align='right'>Descargar</a></td>
              </tr>";
            }
        }
      echo "</table>";
        closedir($dh);
    }
  }
}

*/

  /*$tabla = "";
  $tabla.= '<table class="table table-bordered table-striped">
    <thread>
    <tr class="p-3 mb-2 bg-secondary text-white">
      <td>Id</td>
      <td>Usuario</td>
      <td>Apellido</td>
      <td>Nombre</td>
      <td>Email</td>
      <td>Rol</td>
      <td>Habilitado</td>
    </tr>
    </thread>';
  $tabla.='</table>';
  echo $tabla;
    echo "<br>";*/


    /*$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://10.8.0.1/mutpol/rest/titular_cargas',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'dni:'.$documento
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        if(empty($response)){
          echo "PROBLEMAS DE CONEXIÓN CON LA BASE DE DATOS";
        }
        else{
          //$resultArray = json_decode($response);
          $resultArray = json_decode($response, true);
          $arrayTitular = obtenerTitular($resultArray);
          $arrayCarga = obtenerCargas($resultArray);*/



          <?php
/*function obtenerTitular($resultArray){
  $array = [];
  foreach($resultArray as $key=>$data){
    if(!is_array($data)){
      $array[$key] = $data;
    }
  }
  return $array;
}*/

/*function obtenerCargas($resultArray){
  $array = [];
  $i = 0;
  foreach($resultArray as $key=>$data){
    if(is_array($data)){
      foreach($data as $numero){
        foreach($numero as $clave=>$elemento){
          if(!is_array($elemento)){
            $array[$i][$clave] = $elemento;
          }
        }
        $i = $i+1;
      }
    }
  }
  return $array;
}*/
?>



//$documento = '12321692';
        $fecha = '15/01/2021';
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://10.8.0.1/mutpol/rest/cuenta_corriente',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS =>'{
          "city": ""
        }',
        CURLOPT_HTTPHEADER => array(
          'dni:'.$documento,
          'fecha:'.$fecha,
          'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);
      if(empty($response)){
          echo "PROBLEMAS DE CONEXIÓN CON LA BASE DE DATOS";
      }
      else{
        $resultArray = json_decode($response, true);
        $arrayCuenta = obtenerCuenta($resultArray);
        //echo $arrayCuenta[0]['operacion'];




        //$documento = '12321692';
        $fecha = '15/01/2021';
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://10.8.0.1/mutpol/rest/deuda',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS =>'{
          "city": ""
        }',
        CURLOPT_HTTPHEADER => array(
          'dni:'.$documento,
          'fecha:'.$fecha,
          'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);
      if(empty($response)){//Comprueba si un array esta vacio
          echo "PROBLEMAS DE CONEXIÓN CON LA BASE DE DATOS";
      }
      else{
        $resultArray = json_decode($response, true);
        if (array_key_exists('message', $resultArray)){//No tiene deuda, por eso devuelve error
          //echo "NO TIENE DEUDA";
          echo "";
        }
        else{
            $arrayCuenta = obtenerCuenta($resultArray);




<?php  
/*  session_start();
  if (!isset($_SESSION['documento'])) {
    header('Location: index.php');
  }elseif(isset($_SESSION['documento'])){
    include 'conexion.php';
    $documento = $_SESSION['documento'];
  }else{
    echo "Error en el sistema";
  }*/
?>






<!-- Para celular -->
<div class="d-block d-sm-block d-md-none">
    <br/>
    <a href="menu.php" class="btn" id="botonMenu">Menu</a>
  <?php if($tramite==="ACTUALIZACION DE DATOS"){
          $tramite1 = "ACTUALIZACIÓN DE DATOS";?>
          <div style = "font-family: 'Georgia', cursive; font-size: 30px;color:black">TRAMITE: <span style="color: #0072BC;"><?php echo $tramite1?></span></div>
          <br>
  <?php }else {?>
            <div style = "font-family: 'Georgia', cursive; font-size: 30px;color:black">TRAMITE: <span style="color: #0072BC;"><?php echo $tramite?></span></div>
            <br>
  <?php } ?>


  <form method="POST" id="formulario" enctype="multipart/form-data">
    <div class="form-row">

      <input type="text" class="form-control" id="tramite" name="tramite" hidden="hidden" value="<?php echo $tramite;?>" readonly>
      </div>

      <?php 
        condiciones($tramite); 
        if($tramite === "ACTUALIZACION DE DATOS"){
          actualizacion($documento);
        }

       
     
        if(($tramite === "EDUCACION-BECAS") or ($tramite === "TURISMO") or ($tramite === "CONSULTA GENERAL")) {?>
          
          <div class="form-group col-md-4">
            <label style="color:#003366">Delegacion gestion del tramite *</label>
            <select id="delegacion" name="delegacion" class="form-control">
                <option value="NEUQUEN CAPITAL">SEDE CENTRAL - NEUQUEN CAPITAL</option>
           </select>
          </div>

  <?php }
        
        if(($tramite === "ASISTENCIAL") or ($tramite === "REINTEGRO") or ($tramite === "SUBSIDIO SOLIDARIO MUTUAL") or ($tramite === "SUBSIDIO POR NACIMIENTO") or ($tramite === "SUBSIDIO POR CASAMIENTO") or ($tramite === "SUBSIDIO POR FALLECIMIENTO") or ($tramite === "ALTA CARGA") or ($tramite === "REEMPADRONAMIENTO") or ($tramite === "BAJA CARGA") or ($tramite === "BAJA TITULAR") or ($tramite === "SOLICITUD DE TURNO")) {?>
          
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

  <?php } ?>

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


  
      <button class="btn" type="submit" id="botonEnviarchico">Enviar</button>
      <button class="btn" type="button" id="botonVolverchico" onclick="window.location='tramites.php'">Volver</button>
 </div><!-- <div class="form-row"> -->
  <div id="loader" style="display:none"></div>
  </form>
  <br/>

  </div><!-- Para celular -->





<?php if($tramite === "ACTUALIZACION DE DATOS"){ ?>
        <div class="form-group col-md-12">
          <div class="caja">REQUISITOS PARA SOLICITAR ACTUALIZAR DATOS<br />1. Estar habilitado en la Mutual.<br /> La nuevos datos serán corroborados y si todo esta bien, serán confirmados por el área de afiliaciones.<br /> Complete solo los datos que desea actualizar. Puede adjuntar archivos que notifiquen el cambio.<br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.</div>
        </div>
<?php }?>

<?php if($tramite === "ASISTENCIAL"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR ASISTENCIAL<br />1. Estar habilitado en la Mutual.<br />2. Tener sus datos actualizados.
            </div>
          </div>
<?php } ?>


<?php if($tramite === "REINTEGRO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR REINTEGRO<br />1. Estar habilitado en la Mutual.<br />2. Tener sus datos actualizados.
            </div>
          </div>
<?php } ?>

<?php if($tramite === "SUBSIDIO SOLIDARIO MUTUAL"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA ADHERIRSE AL SUBSIDIO SOLIDARIO MUTUAL<br />1. Estar habilitado en la Mutual.<br />2. Tener sus datos actualizados.<br /> Para mas información ingresar a este link: <a href="https://mppneuquen.com.ar/subsidio-solidario" target="_blank">SSM</a></div>
          </div>
<?php } ?>

        
<?php if($tramite === "SUBSIDIO POR CASAMIENTO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR SUBSIDIO POR CASAMIENTO<br />1. Estar habilitado en la Mutual.<br />2. Tener actualizado el SSM.<br />3. Fotocopia del acta de matrimonio<br />4. Fotocopia del dni del titular.<br />5. Constancia de C.B.U (Banco o Homebanking).<br />6. Tener sus datos actualizados.<br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.</div>
          </div>
<?php } ?>


<?php if($tramite === "SUBSIDIO POR FALLECIMIENTO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR SUBSIDIO POR FALLECIMIENTO<br />1. Estar habilitado en la Mutual.<br />2. Tener actualizado el SSM.<br />3. Fotocopia del acta de defunción<br />4. Constancia de C.B.U (Banco o Homebanking).<br />5. Tener sus datos actualizados.<br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.</div>
          </div>
<?php } ?>

        
<?php if($tramite === "SUBSIDIO POR NACIMIENTO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR SUBSIDIO POR NACIMIENTO<br />1. Estar habilitado en la Mutual.<br />2. Tener actualizado el SSM.<br />3. Fotocopia de la partida de nacimiento.<br />4. Fotocopia del dni del titular.<br />5. Constancia de C.B.U (Banco o Homebanking).<br />6. Tener sus datos actualizados.<br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.</div>
          </div>
<?php } ?>


<?php if($tramite === "EDUCACION-BECAS"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">1. Para realizar una consulta relacionada con educación, deberá ingresarla en el campo comentario.<br />Para mas información ingresar al siguiente link: <a href="https://mppneuquen.com.ar/becas" target="_blank">EDUCACIÓN</a></div>
          </div>
<?php } ?>


<?php if($tramite === "TURISMO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">* Para realizar una consulta relacionada con turismo, deberá ingresarla en el campo Comentario.<br />Para mas información ingresar al siguiente link: <a href="https://mppneuquen.com.ar/turismo/" target="_blank">TURISMO</a></div>
          </div>
<?php } ?>


<?php if($tramite === "CONSULTA GENERAL"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">* Para realizar una consulta general, deberá ingresarla en el campo comentario y a la brevedad le contestarán<br /></div>
          </div>
<?php } ?>

        
<?php if($tramite === "SOLICITUD DE TURNO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">* Debe seleccionar la delegación donde desea asistir personalmente, en el campo Delegación que gestionara el trámite.<br />*Si desea reunirse con algún representante de la institución, deberá aclararlo en el campo comentario.<br />*Una vez iniciado el tramite, se comunicarán vía email o telefónicamente para confirmarlo.</div>
          </div>
<?php } ?>


<?php if($tramite === "ALTA CARGA"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA ASOCIAR A UNA CARGA DE FAMILIA<br />1. Fotocopia del DNI del titular<br />2. Fotocopia del DNI de la carga o acta de nacimiento.<br />3. Fotocopia del acta de matrimonio o declaración jurada de concubinato.<br />4. Certificación de la carga extendido por el ISSN.<br />5. Primero las cargas deben ser dadas de alta en la obra social (ISSN), solo después podrá incorporarlas en su mutual.<br />Gestione un trámite por cada carga. No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp</div>
          </div>
<?php } ?>


<?php if($tramite === "REEMPADRONAMIENTO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA REEMPADRONARSE<br />1. Fotocopia del DNI del titular<br />2. Fotocopia del DNI de las cargas o acta de nacimiento de los hijos.<br />3. Fotocopia del acta de matrimonio o declaración jurada de concubinato.<br />4. Certificación de la carga extendido por el ISSN.<br />5. Fotocopia del primer recibo de sueldo como pensionado/a o retirado.<br />6. Constancia de C.B.U (Banco o Homebanking) Y CUIL.<br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.</div>
          </div>
<?php } ?>


<?php if($tramite === "BAJA CARGA"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR LA BAJA DE UNA CARGA<br />1. No tener deuda en Mutual.<br />2. Si es baja del titular, no es necesario gestionar las bajas de sus cargas, alcanza solo con la del titular.<br />La documentacion faltante, será requerida vía mail o WhatsApp.</div>
          </div>
<?php } ?>


<?php if($tramite === "BAJA TITULAR"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR LA BAJA DE AFILIACIÓN<br />1. No tener deuda en Mutual.<br />2. No es necesario gestionar las bajas de sus cargas, estas se dan de baja automáticamente.<br/>La documentacion faltante, será requerida vía mail o WhatsApp.</div>
          </div>
<?php } ?>

        <div class="form-group col-md-12">
        <label>
          <input type="checkbox" name="terminos" id="terminos"> ACEPTO TÉRMINOS Y CONDICIONES</label><br>
        </div>








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
          <h4 style = "font-family: 'Verdana', cursive; color:#003366;">DATOS ACTUALES</h4>
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

      <?php 
      } //else
      ?>


      <div class="container"><br><br></div>

        <div class="container">
          <h4 style = "font-family: 'Verdana', cursive; color:#003366;">DATOS A ACTUALIZAR</h4>
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
          <input class="form-control" id="cuil" name="cuil" placeholder="" autocomplete="off" maxlength="6">
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

        <div class="form-group col-md-12">
            <label style="color:#003366">Adjuntar archivos</label><br>
            <input multiple="true" name="archivo[]" id="file" type="file"><br>
            <label style="color:#003366">Hasta 3 archivos - 5MB tamaño total - Formatos aceptados: PDF, PNG, JPG y JPEG.
            <br>Puede adjuntar seleccionando todos los archivos de una sola vez o presionando la tecla CTRL y seleccionando cada uno de ellos a la vez.</label><br>
        </div>










<div class="container">
<!-- Para celular -->
  <div class="d-block d-sm-block d-md-none">
  <br/>
    <a href="menu.php" class="btn" id="botonMenu">Menu</a>
    <?php 
    if($tramite==="ACTUALIZACION DE DATOS"){
      $tramite1 = "ACTUALIZACIÓN DE DATOS";
    ?>
      <div style = "font-family: 'Georgia', cursive; font-size: 30px;color:black">TRAMITE: <span style="color: #0072BC;"><?php echo $tramite1?></span></div>
      <br>
    <?php 
    }else{
    ?>
      <div style = "font-family: 'Georgia', cursive; font-size: 30px;color:black">TRAMITE: <span style="color: #0072BC;"><?php echo $tramite?></span></div>
      <br>
    <?php 
    } 
    ?>

  <form method="POST" id="formulariochico" enctype="multipart/form-data">
    <div class="form-row">

      <input type="text" class="form-control" id="tramite" name="tramite" hidden="hidden" value="<?php echo $tramite;?>" readonly>

      <?php 
      //condiciones($tramite);
      if($tramite === "ACTUALIZACION DE DATOS"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR ACTUALIZAR DATOS<br />1. Estar habilitado en la Mutual.<br /> La nuevos datos serán corroborados y si todo esta bien, serán confirmados por el área de afiliaciones.<br /> Complete solo los datos que desea actualizar. Puede adjuntar archivos que notifiquen el cambio.<br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.</div>
          </div>
  <?php } ?>


  <?php if($tramite === "ASISTENCIAL"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR ASISTENCIAL<br />1. Estar habilitado en la Mutual.<br />2. Tener sus datos actualizados.
            </div>
          </div>
   <?php } ?>


  <?php if($tramite === "REINTEGRO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR REINTEGRO<br />1. Estar habilitado en la Mutual.<br />2. Tener sus datos actualizados.
            </div>
          </div>
  <?php } ?>

  
  <?php if($tramite === "SUBSIDIO SOLIDARIO MUTUAL"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA ADHERIRSE AL SUBSIDIO SOLIDARIO MUTUAL<br />1. Estar habilitado en la Mutual.<br />2. Tener sus datos actualizados.<br /> Para mas información ingresar a este link: <a href="https://mppneuquen.com.ar/subsidio-solidario" target="_blank">SSM</a></div>
          </div>
  <?php } ?>

        
  <?php if($tramite === "SUBSIDIO POR CASAMIENTO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR SUBSIDIO POR CASAMIENTO<br />1. Estar habilitado en la Mutual.<br />2. Tener actualizado el SSM.<br />3. Fotocopia del acta de matrimonio<br />4. Fotocopia del dni del titular.<br />5. Constancia de C.B.U (Banco o Homebanking).<br />6. Tener sus datos actualizados.<br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.</div>
          </div>
  <?php } ?>


  <?php if($tramite === "SUBSIDIO POR FALLECIMIENTO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR SUBSIDIO POR FALLECIMIENTO<br />1. Estar habilitado en la Mutual.<br />2. Tener actualizado el SSM.<br />3. Fotocopia del acta de defunción<br />4. Constancia de C.B.U (Banco o Homebanking).<br />5. Tener sus datos actualizados.<br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.</div>
          </div>
  <?php } ?>

        
  <?php if($tramite === "SUBSIDIO POR NACIMIENTO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR SUBSIDIO POR NACIMIENTO<br />1. Estar habilitado en la Mutual.<br />2. Tener actualizado el SSM.<br />3. Fotocopia de la partida de nacimiento.<br />4. Fotocopia del dni del titular.<br />5. Constancia de C.B.U (Banco o Homebanking).<br />6. Tener sus datos actualizados.<br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.</div>
          </div>
  <?php } ?>


  <?php if($tramite === "EDUCACION-BECAS"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">1. Para realizar una consulta relacionada con educación, deberá ingresarla en el campo comentario.<br />Para mas información ingresar al siguiente link: <a href="https://mppneuquen.com.ar/becas" target="_blank">EDUCACIÓN</a></div>
          </div>
  <?php } ?>


  <?php if($tramite === "TURISMO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">* Para realizar una consulta relacionada con turismo, deberá ingresarla en el campo Comentario.<br />Para mas información ingresar al siguiente link: <a href="https://mppneuquen.com.ar/turismo/" target="_blank">TURISMO</a></div>
          </div>
  <?php } ?>


  <?php if($tramite === "CONSULTA GENERAL"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">* Para realizar una consulta general, deberá ingresarla en el campo comentario y a la brevedad le contestarán<br /></div>
          </div>
  <?php } ?>

        
  <?php if($tramite === "SOLICITUD DE TURNO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">* Debe seleccionar la delegación donde desea asistir personalmente, en el campo Delegación que gestionara el trámite.<br />*Si desea reunirse con algún representante de la institución, deberá aclararlo en el campo comentario.<br />*Una vez iniciado el tramite, se comunicarán vía email o telefónicamente para confirmarlo.</div>
          </div>
  <?php } ?>


  <?php if($tramite === "ALTA CARGA"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA ASOCIAR A UNA CARGA DE FAMILIA<br />1. Fotocopia del DNI del titular<br />2. Fotocopia del DNI de la carga o acta de nacimiento.<br />3. Fotocopia del acta de matrimonio o declaración jurada de concubinato.<br />4. Certificación de la carga extendido por el ISSN.<br />5. Primero las cargas deben ser dadas de alta en la obra social (ISSN), solo después podrá incorporarlas en su mutual.<br />Gestione un trámite por cada carga. No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp</div>
          </div>
  <?php } ?>


  <?php if($tramite === "REEMPADRONAMIENTO"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA REEMPADRONARSE<br />1. Fotocopia del DNI del titular<br />2. Fotocopia del DNI de las cargas o acta de nacimiento de los hijos.<br />3. Fotocopia del acta de matrimonio o declaración jurada de concubinato.<br />4. Certificación de la carga extendido por el ISSN.<br />5. Fotocopia del primer recibo de sueldo como pensionado/a o retirado.<br />6. Constancia de C.B.U (Banco o Homebanking) Y CUIL.<br />No es necesario adjuntar toda la documentación. La faltante será requerida via email o WhatsApp.</div>
          </div>
  <?php } ?>


  <?php if($tramite === "BAJA CARGA"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR LA BAJA DE UNA CARGA<br />1. No tener deuda en Mutual.<br />2. Si es baja del titular, no es necesario gestionar las bajas de sus cargas, alcanza solo con la del titular.<br />La documentacion faltante, será requerida vía mail o WhatsApp.</div>
          </div>
  <?php } ?>


  <?php if($tramite === "BAJA TITULAR"){ ?>
          <div class="form-group col-md-12">
            <div class="caja">REQUISITOS PARA SOLICITAR LA BAJA DE AFILIACIÓN<br />1. No tener deuda en Mutual.<br />2. No es necesario gestionar las bajas de sus cargas, estas se dan de baja automáticamente.<br/>La documentacion faltante, será requerida vía mail o WhatsApp.</div>
          </div>
  <?php } ?>

    <div class="form-group col-md-12">
    <label>
      <input type="checkbox" name="terminos" id="terminos"> ACEPTO TÉRMINOS Y CONDICIONES
    </label><br>
    </div>

    <?php 
      //if($tramite === "ACTUALIZACION DE DATOS"){
        //actualizacion($documento); 
      //}
      if(($tramite === "EDUCACION-BECAS") or ($tramite === "TURISMO") or ($tramite === "CONSULTA GENERAL")){
      ?>   
        <div class="form-group col-md-4">
            <label style="color:#003366">Delegacion gestion del tramite *</label>
            <select id="delegacionchico" name="delegacionchico" class="form-control">
              <option value="NEUQUEN CAPITAL">SEDE CENTRAL - NEUQUEN CAPITAL</option>
            </select>
        </div>
      <?php 
      }
        
      if(($tramite === "ASISTENCIAL") or ($tramite === "REINTEGRO") or ($tramite === "SUBSIDIO SOLIDARIO MUTUAL") or ($tramite === "SUBSIDIO POR NACIMIENTO") or ($tramite === "SUBSIDIO POR CASAMIENTO") or ($tramite === "SUBSIDIO POR FALLECIMIENTO") or ($tramite === "ALTA CARGA") or ($tramite === "REEMPADRONAMIENTO") or ($tramite === "BAJA CARGA") or ($tramite === "BAJA TITULAR") or ($tramite === "SOLICITUD DE TURNO")) {
      ?>
          
        <div class="form-group col-md-4">
          <label style="color:#003366">Delegacion que gestionará el tramite *</label>
            <select id="delegacionchico" name="delegacionchico" class="form-control" style="border-color: #2874A6">
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
          <textarea class="form-control" id="comentariochico" name="comentariochico" rows="3" placeholder="Maximo 150 caracteres" style="text-transform:uppercase" maxlength="150"></textarea>
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
      </div>
        <button class="btn" type="submit" id="botonEnviarchico">Enviar</button>
        <button class="btn" type="button" id="botonVolverchico" onclick="window.location='tramites.php'">Volver</button>

      <div id="loader" style="display:none"></div>
      </form>
    <br/>
    <p style="color:#003366">* Datos obligatorios</p>

  </div><!-- Para celular -->
</div>



























function actualizacion($documento){
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

  <?php } //else?>

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
            <input class="form-control" id="cuil" name="cuil" placeholder="" autocomplete="off" maxlength="6">
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

              <div class="form-group col-md-12">
                <label style="color:#003366">Adjuntar archivos</label><br>
                <input multiple="true" name="archivo[]" id="file" type="file"><br>
                <label style="color:#003366">Hasta 3 archivos - 5MB tamaño total - Formatos aceptados: PDF, PNG, JPG y JPEG.
                <br>Puede adjuntar seleccionando todos los archivos de una sola vez o presionando la tecla CTRL y seleccionando cada uno de ellos a la vez.</label><br>
              </div>

  <?php 
}






<!-- Para celular -->
    <div class="d-block d-sm-block d-md-none">
      <div class="container" id="containerMenu">
      <div class="container text-center h-100 d-flex justify-content-center align-items-center">
        <?php
        $query="SELECT * FROM tramites_uno WHERE documento='$documento' ORDER BY id ASC";
        $result=$conexion->query($query);
      if($result->num_rows > 0){ //si se obtuvieron resultados
      ?>
          <table class="table table-bordered">

          <?php  while($row = $result->fetch_assoc()){ 
                  $mensaje = $row['tramite'];  ?>

                    <thread>
                    <tr class="p-3 mb-2 bg-secondary text-white">
                    <td id="fila">ID</td>
                    <td id="fila">TRAMITE</td>
                    <td id="fila">FECHA</td>
                    </tr>
                    </thread>  
                    
                    <tr>
                    <td><?php echo $row['id']?></td>
                    <td><?php echo $row['tramite']?></td>
                    <td><?php echo $row['fecha']?></td>
                    </tr>

                    <thread>
                    <tr class="p-3 mb-2 bg-secondary text-white">
                    <td id="fila">DELEGACION</td>
                    <td id="fila">ESTADO</td>
                    <td id="fila">MAS</td>
                    </tr>
                    </thread>  
                    
                    <tr>
                    <td><?php echo $row['delegacion']?></td>
                    <td><?php echo $row['estado']?></td>
                    <td><?php echo "";?></td>
                    </tr>

                    <tr>
                    <td id="fila1"></td>
                    <td id="fila1"></td>
                    <td id="fila1"></td>
                    </tr>

                    <tr>
                    <td id="fila1"></td>
                    <td id="fila1"></td>
                    <td id="fila1"></td>
                    </tr>

                    <tr>
                    <td id="fila1"></td>
                    <td id="fila1"></td>
                    <td id="fila1"></td>
                    </tr>

          <?php  } ?>
          
          </table>
<?php } ?>

    </div>
    <br/>
    </div>
    </div>






    <!-- Para celular -->
  <div class="d-block d-sm-block d-md-none">
      <?php
    echo '<br>';
      //$fecha = '15/01/2021';
      $resultArray1 = deuda($documento, 1);
      $resultArray2 = deuda($documento, 0);
      $resultArray3 = debitos($documento);
       
      if((!hayConexion($resultArray1)) or (!hayConexion($resultArray2)) or (!hayConexion($resultArray3))){
            echo "PROBLEMAS DE CONEXIÓN CON LA BASE DE DATOS";
      }
      else{
          $arraydeuda1 = datosdeuda($resultArray1);
          $arraydeuda2 = datosdeuda($resultArray2);
          $arraydebitos = datosdeuda($resultArray3);
          
          //Devuelve solo deuda de cuota y consumo
          if (!array_key_exists('message', $arraydeuda1)) { //TIENE DEUDA
            $arraycuenta = obtenerDeuda($arraydeuda1['deuda']);
            $deudacuotatotal = $arraydeuda1['cuota'];
            $deudaconsumototal = $arraydeuda1['consumo'];
          }
          
          //Devuelve solo deuda de cuota y consumo vencida
          if (!array_key_exists('message', $arraydeuda2)) {
            $deudacuotavencida = $arraydeuda2['cuota'];
            $deudaconsumovencida = $arraydeuda2['consumo'];
          }
 
          //ULTIMOS DEBITOS
          //$arraydebitos = json_decode($resultArray3, true);//Paso a json para ver si esta vacio
          if (!array_key_exists('message', $arraydebitos)) {
            $arraydebitos = datosdebitos($resultArray3);
          }

          ?>

          <table class="table table-bordered">           

          <?php
          if (!array_key_exists('message', $arraydeuda1)) { 
              $longitud = count($arraycuenta);
              $i=0;
              
              while ($i < $longitud){ ?>
                <tr>
                  <td id="fila">Operacion</td>
                  <td id="fila">Periodo</td>
                  <td id="fila">Vencimiento</td>
                </tr>
                <tr>
                  <td id="detalle"> <?php echo $arraycuenta[$i]['operacion'];?></td>
                  <td id="detalle"> <?php echo $arraycuenta[$i]['periodo'];?></td>
                  <td id="detalle"> <?php echo $arraycuenta[$i]['vencimiento'];?></td>
                </tr>
                
                <tr>
                  <td id="fila">Cuota</td>
                  <td id="fila">Concepto</td>
                  <td id="fila">Saldo</td>
                </tr>
                <tr>
                  <td id="detalle"> <?php echo $arraycuenta[$i]['cuota']."/".$arraycuenta[$i]['cantidad'];?></td>
                  <td id="detalle1"> <?php echo $arraycuenta[$i]['concepto'];?></td>
                  <td id="detalle"> <?php echo "$".number_format($arraycuenta[$i]['saldo'], 2);?></td>
                </tr>
                
                <tr>
                  <td id="fila1"></td>
                  <td id="fila1"></td>
                  <td id="fila1"></td>
                </tr>

                <tr>
                  <td id="fila1"></td>
                  <td id="fila1"></td>
                  <td id="fila1"></td>
                </tr>

                <tr>
                  <td id="fila1"></td>
                  <td id="fila1"></td>
                  <td id="fila1"></td>
                </tr>

                <?php
                $i=$i+1;
              }
              ?>
              <tr>
              <td id="detalle2"></td>
              <td id="detalle2"><?php echo "DEUDA VENCIDA CUOTA SOCIAL"?></td>
              <td id="detalle2"><?php echo "$".number_format($deudacuotavencida, 2);?></td>
              </tr>
              <tr>
              <td id="detalle2"></td>
              <td id="detalle2"><?php echo "DEUDA VENCIDA CONSUMOS"?></td>
              <td id="detalle2"><?php echo "$".number_format($deudaconsumovencida, 2);?></td>
              </tr>
    <?php } ?>

          </table>
          <?php echo '<br>'; echo '<br>';?> 

    <table class="table table-bordered">
        <tr>
          <td id="filachico">Periodo</td>
          <td id="filachico">Destino</td>
          <td id="filachico">Monto Informado</td>
          <td id="filachico">Monto Cobrado</td>
          <td id="filachico">Estado</td>

          <?php
            if (!array_key_exists('message', $arraydebitos)) {  
                $longitud = count($arraydebitos);
            }?>
            <h5 style = "font-family: 'verdana', cursive; color:#003366; text-align: center;">HISTORIAL DE MONTOS INFORMADOS</h5>
          <?php
            if (!array_key_exists('message', $arraydebitos)) { 
              $i=0;
              while ($i < $longitud){ ?>
                <tr>
                  <td id="detallechico"> <?php echo $arraydebitos[$i]['periodo'];?></td>
                  <td id="detallechico"> <?php echo $arraydebitos[$i]['destino'];?></td>
                  <td id="detallechico"> <?php echo "$".number_format($arraydebitos[$i]['informado'], 2);?></td>
                  <td id="detallechico"> <?php echo "$".number_format($arraydebitos[$i]['cobrado'], 2);?></td>
                  <td id="detallechico"> <?php echo $arraydebitos[$i]['estado'];?></td>
                </tr>
                <?php
                  $i=$i+1;
              }
            }?>
        </tr>
    </table>
    <?php } //else?>

  </div><!-- Para celular -->





  <!-- Para celular -->
    <div class="d-block d-sm-block d-md-none">
         <?php 
          echo '<br>';
          $resultArray = cuentacorriente($documento);
          $arraycuentacorriente = json_decode($resultArray, true);//Paso a json para ver si esta vacio
          if (!array_key_exists('message', $arraycuentacorriente)) {
            $arraycuentacorriente = datoscuentacorriente($resultArray);
          }
        ?>

        <table class="table table-bordered">

        <?php
        if (!array_key_exists('message', $arraycuentacorriente)){
          $longitud = count($arraycuentacorriente);
          $i=0;
          while ($i < $longitud) {
          ?>

          <tr>
            <td id="fila">Operacion</td>
            <td id="fila">Fecha</td>
            <td id="fila">Concepto</td>
          <tr>
          <tr>
            <td id="detalle"> <?php echo $arraycuentacorriente[$i]['operacion'];?></td>
            <td id="detalle"> <?php echo $arraycuentacorriente[$i]['fecha'];?></td>
            <td id="detalle"> <?php echo $arraycuentacorriente[$i]['concepto'];?></td>
          </tr>

          <tr>
            <td id="fila">Debe</td>
            <td id="fila">Haber</td>
            <td id="fila">Saldo</td>
          </tr>
          <tr>
            <td id="detalle"> <?php echo $arraycuentacorriente[$i]['debe'];?></td>
            <?php if($arraycuentacorriente[$i]['haber']!='0.00'){?> 
              <td id="detalle1"> <?php echo $arraycuentacorriente[$i]['haber'];?></td>
            <?php }else{?>
              <td id="detalle"> <?php echo $arraycuentacorriente[$i]['haber'];?></td>
            <?php }?>
            <td id="detalle2"> <?php echo $arraycuentacorriente[$i]['saldo'];?></td>
          </tr>

          <tr>
            <td id="fila">Detalle</td>
            <td id="fila">Imputacion</td>
            <td id="fila"></td>
          </tr>
          <tr>
          <td id="detalle"> <?php echo $arraycuentacorriente[$i]['detalle'];?></td>
            <td id="detalle"> <?php echo $arraycuentacorriente[$i]['imputacion']; ?> </td>
            <td id="detalle"> <?php if($arraycuentacorriente[$i]['debe']!='0.00'){?> <img title="GENERADO" src="./imagenes/mas1.jpg" width="25" height="25"></td><?php }
            else{ ?><img title="DESCONTADO" src="./imagenes/menos1.jpg" width="25" height="25"></td><?php
            }
            ?>
          </tr>

          <tr>
              <td id="fila1"></td>
              <td id="fila1"></td>
              <td id="fila1"></td>
            </tr>

            <tr>
              <td id="fila1"></td>
              <td id="fila1"></td>
              <td id="fila1"></td>
            </tr>

            <tr>
              <td id="fila1"></td>
              <td id="fila1"></td>
              <td id="fila1"></td>
            </tr>
          <?php
            $i=$i+1;
          }
      }
        ?>
    </div><!-- Para celular -->








    <!-- CREDENCIALES -->

    function credenciales3($apellido, $nombre, $documento){
  mostrarcredencial3($apellido, $nombre, $documento);
  credencialescargas3($documento);
}
function mostrarcredencial3($apellido, $nombre, $documento){
  $codigoqr = generarqr($documento);
  $salida = generarmensaje3($apellido, $nombre, $documento, $codigoqr);
  echo $salida;
  echo '<br/>';echo '<br/>';

}
function generarmensaje3($apellido, $nombre, $documentoAfiliado, $codigoqr){
  $mensaje = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title></head><body>
            <div class="contenedor">
            <div class="credencial">
              <img src="./imagenes/Credencial-virtual2.jpg" style="border-radius:5%; width:95%;">
              <div style="position: absolute; top: 68%; left: 5%; color: white; font-family: Times; font-size: 12px; font-weight: normal;">'.$apellido.'</div>
              <div style="position: absolute; top: 75%; left: 5%; color: white; font-family: Times; font-size: 12px; font-weight: normal;">'.$nombre.'</div>
              <div style="position: absolute;top: 83%;left: 5%;color: white;font-family:Times;font-size: 12px;font-weight: normal;">'.$documentoAfiliado.'</div>
              <div style="position: absolute;top: 40%;left: 55%;height: 40%;">'.$codigoqr.'</div>
            </div></div></body></html>';
  return $mensaje;
}

function credencialescargas3($documento){
  $array = cargastitular($documento);
  $longitud = count($array);
   $i=0;
    while($i<$longitud){
        $j=0;
        $documentocarga = $array[$i][$j];
        $nombrecarga = $array[$i][$j+1];
        $apellidocarga = $array[$i][$j+2];
        mostrarcredencial3($apellidocarga, $nombrecarga, $documentocarga);
        $i=$i+1;
    }
}




function generarmensaje($nombrecompleto, $documentoAfiliado, $codigoqr){
  $mensaje = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title></head><body>
            <div class="contenedor">
            <div class="credencial">
              <img src="./imagenes/credencial3.jpg">
              <div class="centrado1" style="position: absolute; top: 70%; left: 4%; color: white; font-family: Times; font-size: 17px; font-weight: normal;">'.$nombrecompleto.'</div>
              <div class="centrado2" style="position: absolute;top: 80%;left: 4%;color: white;font-family:Times;font-size: 17px;font-weight: normal;">'.$documentoAfiliado.'</div>
              <div class="centrado3" style="position: absolute;top: 48%;left: 68%;height: 40%;">'.$codigoqr.'</div>
            </div></div></body></html>';
  return $mensaje;
}

function mostrarcredencial($nombrecompleto, $documento){
  $codigoqr = generarqr($documento);
  $salida = generarmensaje($nombrecompleto, $documento, $codigoqr);
  //$imprimir = '<div class="imprimir"><input type="button" name="imprimir" value="Imprimir" onclick="window.print();" id="btnimprimir"></div>';
  //echo $salida.'<br/>'.$imprimir;
  echo $salida;
  echo '<br/>';echo '<br/>';

}

/*function credencialescargas($documento){
  $array = cargastitular($documento);
  $longitud = count($array);
   $i=0;
    while($i<$longitud){
        $j=0;
        $documentocarga = $array[$i][$j];
        $nombrecompleto = $array[$i][$j+2]." ".$array[$i][$j+1];
        mostrarcredencial($nombrecompleto, $documentocarga);
        $i=$i+1;
    }
}*/

function credenciales($nombrecompleto, $documento){
  mostrarcredencial($nombrecompleto, $documento);
  credencialescargas($documento);
}

function credenciales2($apellido, $nombre, $documento){
  mostrarcredencial2($apellido, $nombre, $documento);
  //credencialescargas2($documento);
}
function mostrarcredencial2($apellido, $nombre, $documento){
  $codigoqr = generarqr($documento);
  $salida = generarmensaje2($apellido, $nombre, $documento, $codigoqr);
  echo $salida;
  echo '<br/>';echo '<br/>';

}
function generarmensaje2($apellido, $nombre, $documentoAfiliado, $codigoqr){
  $mensaje = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title></head><body>
            <div class="contenedor">
            <div class="credencial">
              <img src="./imagenes/Credencial-virtual2.jpg" style="border-radius:5%;">
              <div class="centrado10" style="position: absolute; top: 83%; left: 31%; color: white; font-family: Times; font-size: 18px; font-weight: normal;">'.$apellido.'</div>

              <div class="centrado11" style="position: absolute; top: 87%; left: 31%; color: white; font-family: Times; font-size: 18px; font-weight: normal;">'.$nombre.'</div>

              <div class="centrado12" style="position: absolute;top: 91%;left:31%;color: white;font-family:Times;font-size: 18px;font-weight: normal;">'.$documentoAfiliado.'</div>

              <div class="centrado13" style="position: absolute;top: 70%;left: 57%;height: 40%;">'.$codigoqr.'</div>
            </div></div></body></html>';
  return $mensaje;
}

function credencialescargas2($documento){
  $array = cargastitular($documento);
  $longitud = count($array);
   $i=0;
    while($i<$longitud){
        $j=0;
        $documentocarga = $array[$i][$j];
        $nombrecarga = $array[$i][$j+1];
        $apellidocarga = $array[$i][$j+2];
        mostrarcredencial2($apellidocarga, $nombrecarga, $documentocarga);
        $i=$i+1;
    }
}



//FACTURAS


<!DOCTYPE html>
<html lang="es">
<?php 
include('head.php');
include('navegacion.php');
?>
<body>
  <div class="container">
    <hr/>
    <a href="menu.php" class="btn" id="botonMenu">Menu</a>
    <h2 style = "font-family: 'Georgia', cursive;">FACTURAS</h2> 
    <hr/>

<!-- Para computadora -->
  <div class="d-none d-sm-none d-md-block"> 



    <form class="form-inline" method="POST" id="formulario">

      <div class="form-group" style = "font-family: 'Georgia', cursive;">
        <select id="mes" name="mes" class="form-control">
            <option value="">Seleccione un mes</option>
            <option value="ENERO">ENERO</option>
            <option value="FEBRERO">FEBRERO</option>
            <option value="MARZO">MARZO</option>
            <option value="ABRIL">ABRIL</option>
            <option value="MAYO">MAYO</option>
            <option value="JUNIO">JUNIO</option>
            <option value="JULIO">JULIO</option>
            <option value="AGOSTO">AGOSTO</option>
            <option value="SEPTIEMBRE">SEPTIEMBRE</option>
            <option value="OCTUBRE">OCTUBRE</option>
            <option value="NOVIEMBRE">NOVIEMBRE</option>
            <option value="DICIEMBRE">DICIEMBRE</option>
           </select>
      </div>

      <div class="form-group mx-sm-3" style = "font-family: 'Georgia', cursive;">
        <select id="anio" name="anio" class="form-control">
            <option value="">Seleccione un año</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
        </select>
      </div>

      <button class="btn mx-sm-2" type="submit" id="botonBuscar" style = "font-family: 'Georgia', cursive;">Buscar</button>
    </form>

    <br>
    <br>
    <section id="tabla_resultado">
    </section>
  </div>
  </div>
</body>
</html>


<style type="text/css">

body{
    /*background-color: #8faed6;*/
}

#botonMenu{
  float:right;
  margin-right: 5px;
  background-color: #148F77;
  color: white;
  border: 2px solid;
  border-radius: 10px;
}

#botonBuscar{
  border: 2px solid;
  border-radius: 10px;
  background: #003366;
  color: white;
}

#botonBuscar:hover {
  background: white;
  color: #003366 !important;
  }

#containerMenu{
  min-height: 100vh;
  justify-content: center;
  }

.container{
  background-color: #fff;
  height: auto;
}
</style>


<script type="text/javascript">

  /*$('#botonBuscar').click(function(evento){
    evento.preventDefault();
    //console.log($("#mes").val()+" - "+$("#anio").val());
    if(validarFormulario()){
      var datos=$('#formulario').serialize();
      $.ajax({
          url: 'buscarfactura.php',
          type:'POST',
          data: datos,
          dataType : 'html',
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
  });*/

  $('#botonBuscar').click(function(evento){
    evento.preventDefault();
    var datos=$('#formulario').serialize();

    $.ajax({
        url : 'buscarfactura.php',
        type : 'POST',
        data: datos,
        dataType : 'html',
    }).done(function(resultado){
        $("#tabla_resultado").html(resultado);
      })
  });

 



  function validarFormulario(){
    /*if($("#mes").val() == ""){
      return mensajeError("DEBE SELECCIONAR UN MES");
      $("#documento").focus();
      return false;
    }*/

    if($("#anio").val() == ""){
      return mensajeError("DEBE SELECCIONAR UN AÑO");
      $("#clave").focus();
      return false;
    }

    return true;
  }

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

</script>



//Facturas II

<?php  
/*  session_start();
  if (!isset($_SESSION['documento'])) {
    header('Location: index.php');
  }elseif(isset($_SESSION['documento'])){
    include 'conexion.php';
    $documento = $_SESSION['documento'];
  }else{
    echo "Error en el sistema";
  }*/
?>


<!DOCTYPE html>
<html lang="es">
<?php 
include('head.php');
include('navegacion.php');
?>
<body>
  <div class="container">
    <hr/>
    <a href="menu.php" class="btn" id="botonMenu">Menu</a>
    <h2 style = "font-family: 'Georgia', cursive;">FACTURAS</h2> 
    <hr/>

<!-- Para computadora -->
  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
    <div class="col">ENERO 2021</div>
    <div class="col"><a href='facturas\ENERO 2021\001336\FACC0003100003843/FACC0003100003843.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
    <div class="col"></div>
    <div class="col"></div>
  </div>
  <br>
  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
    <div class="col">FEBRERO 2021</div>
    <div class="col"><a href='facturas\FEBRERO 2021\001336\FACC0003900000899/FACC0003900000899.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
    <div class="col"></div>
    <div class="col"></div>
  </div>
  <br>
  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
    <div class="col">MARZO 2021</div>
    <div class="col"><a href='facturas\MARZO 2021\001336\FACC0003900007669\FACC0003900007669.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
    <div class="col"></div>
    <div class="col"></div>
  </div>
  <br>
  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
    <div class="col">ABRIL 2021</div>
    <div class="col"><a href='facturas\ABRIL 2021\001336\FACC0003900014470\FACC0003900014470.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
    <div class="col"></div>
    <div class="col"></div>
  </div>
  <br>
  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
    <div class="col">MAYO 2021</div>
    <div class="col"><a href='facturas\MAYO 2021\001336\FACC0003900021317\FACC0003900021317.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
    <div class="col"></div>
    <div class="col"></div>
  </div>
  <br>
  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
    <div class="col">JUNIO 2021</div>
    <div class="col"><a href='facturas\JUNIO 2021\001336\FACC0003900028178\FACC0003900028178.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
    <div class="col"></div>
    <div class="col"></div>
  </div>
  <br>
  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
    <div class="col">JULIO 2021</div>
    <div class="col"><a href='facturas\JULIO 2021\001336\FACC0003900035060\FACC0003900035060.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
    <div class="col"></div>
    <div class="col"></div>
  </div>
  <br>
  <div class="d-none d-sm-none d-md-block"> 
    <div class="row align-items-start">
    <div class="col">AGOSTO 2021</div>
    <div class="col"><a href='facturas\AGOSTO 2021\001336\FACC0003900041932\FACC0003900041932.pdf' target='_blank'><img src='./imagenes/pdf.png' height='50' width='50' align="center">Descargar</a></div>
    <div class="col"></div>
    <div class="col"></div>
  </div>

  </div>

  </div>
</body>
</html>


<style type="text/css">

body{
    /*background-color: #8faed6;*/
}

#botonMenu{
  float:right;
  margin-right: 5px;
  background-color: #148F77;
  color: white;
  border: 2px solid;
  border-radius: 10px;
}

.container{
  background-color: #fff;
  height: auto;
}
</style>

function generarmensaje($apellidoAfiliado, $nombreAfiliado, $email, $codigo){
  
  $mensaje = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title></head><body>
    <div id="email" style="background: #003366; width: 800px; margin-left: auto; margin-right: auto;">
    <br>
    <img src="https://tramitesonline.mppneuquen.com.ar/imagenes/logoRecuperacion2.jpg" style="margin-left: auto;margin-right: auto;display: block;">
    <p style="color:#0072BC; text-align: center; font-size: 22px; font-family: Georgia, cursive;">ACTIVAR CUENTA</p>
    
    <p style="color:white; text-align: center; font-size: 20px; font-family: Georgia, cursive;">Bienvenido '.$apellidoAfiliado." ".$nombreAfiliado.'</p>
    
    <p style="color:white; text-align: center; font-size: 18px; font-family: Georgia, cursive;">Su c&oacute;digo de activaci&oacute;n es:</p>
    
    <p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">'.$codigo.'</p>

    <p style="color:white; text-align: center; font-weight: normal;font-size: 18px; font-family: Georgia, cursive;">Puede ingresarlo en el siguiente enlace<br><a href="http://localhost/mutualWeb/activar.php" style="text-decoration:none; color:#0072BC; target="_blank"">http://localhost/mutualWeb/activar.php</a></p>
    <br>

    <h3 style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive;">Ante cualquier consulta escribanos a nuestros contactos</h3>
      <p style="text-align: center";><a style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive; text-decoration: none;" href="soporte@mppneuquen.com.ar" target="_blank">soporte@mppneuquen.com.ar</a></p>
      <h3 style="color:white; text-align: center; font-weight: normal; font-family: Georgia, cursive;"><img src="https://tramitesonline.mppneuquen.com.ar/imagenes/whatsapps2.png" width="40" height="40" style="margin-left: auto; vertical-align: middle;"> +549299XXXXXXX</h3>

      <br>
    </div></body></html>';

  return $mensaje;
 }