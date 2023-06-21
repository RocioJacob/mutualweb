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
include("estiloMW.php");
?>
<body>
  <div class="container">
    <hr/>
    <h2 id="titulo">DATOS PERSONALES</h2>
    <hr/>
    <!-- Para computadora -->
    <div class="d-none d-sm-none d-md-block"> 


        <div class="col-md-3 col-lg-3 " align="center"> 
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
        </div>

    
      <!--div class=" col-md-9 col-lg-9" align="right"-->
        <h4 id="titulo">TITULAR</h4>
      

      <?php 
//27979745
//26175694
//38810090
$documento = '26175694';

$curl = curl_init();
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
//$resultArray = json_decode($response);
$resultArray = json_decode($response, true);


foreach($resultArray as $key=>$data){
    if(!is_array($data)){ //Muestra datos titular
      if(($key!='carga')&&($key!='parentesco')&&($key!='carga')&&($key!='baja')){//No mostramos carga, parentesco y carga
        if($key=='ssm'){
            if($data==true){//Si el ssm es 1 muestra SI
              //echo strtoupper($key).": SI".'<br>';
              $array = array('ssm' => 'SI');
              ?>
               <p style = "font-family: 'Georgia', cursive; color:#003366;"> 
                <?php echo strtoupper($key).": ";//.$data.'<br>';?>
              <span style="color: black;"><?php echo "SI";?></span></p>
            <?php
            }
            else{
              //echo strtoupper($key).": NO".'<br>';
              $array = array('ssm' => 'NO');
            ?>
              <p style = "font-family: 'Georgia', cursive; color:#003366;"> 
                <?php echo strtoupper($key).": ";?>
              <span style="color: black;"><?php echo "NO";?></span></p>
            <?php
            }
        }
        else{
              //echo strtoupper($key).": ".$data.'<br>';
            ?>
              <a style = "font-family: 'Georgia', cursive; color:#003366;"> 
                <?php echo strtoupper($key).": ";?>
              <span style="color: black;"><?php echo $data.'<br>';?></span></a>
            <?php
        }
      }
    }
    else{ //Muestra las cargas

    ?>
      <h4 id="titulo">CARGAS</h4>
      <table class="table table-hover table-bordered;">
        <tr>
          <td style="background-color: #3A73A8; color: white; font-weight: 200"><strong>Codigo</strong></td>
          <td style="background-color: #3A73A8; color: white; font-weight: 200"><strong>Carga</strong></td>
          <td style="background-color: #3A73A8; color: white; font-weight: 200"><strong>Parentesco</strong></td>
          <td style="background-color: #3A73A8; color: white; font-weight: 200"><strong>Apellido</strong></td>
          <td style="background-color: #3A73A8; color: white; font-weight: 200"><strong>Nombre</strong></td>
          <td style="background-color: #3A73A8; color: white; font-weight: 200"><strong>Documento</strong></td>
          <td style="background-color: #3A73A8; color: white; font-weight: 200"><strong>Nacimiento</strong></td>
          <td style="background-color: #3A73A8; color: white; font-weight: 200"><strong>Fecha alta</strong></td>
          <td style="background-color: #3A73A8; color: white; font-weight: 200"><strong>Fecha baja</strong></td>
        </tr>
      <?php
        //echo '<br>';
        //echo "CANTIDAD DE CARGAS: ".count($data).'<br>';
        foreach($data as $numero){
      ?>
        <tr>
        <?php
          foreach($numero as $clave=>$elemento){
            if((!is_array($elemento))/*&&($elemento!='')*/){//Si no es un array(cargas en cargas)
              if(($clave!='legajo')&&($clave!='cuil')&&($clave!='direccion')&&($clave!='localidad')&&($clave!='provincia')&&($clave!='telefono')&&($clave!='email')&&($clave!='ssm')){//No mostramos localidad de la carga
                //echo $clave.": ".$elemento.'<br>';
        ?>
              <td>
              <h6 style = "font-family: 'Georgia', cursive; color:#003366; font-size: 14px;"> <?php echo $elemento;?></h6>
              </td>
        <?php
              }
            }
          } 
        ?>
          </tr>
        <?php  
        }
    }
}
?>
</table>
<?php
echo '<br>';
echo '<br>';
?>
    </div>
  </div>
</body>
</html>



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
            url: "imagen_ajax.php",        // Url to which the request is send
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


