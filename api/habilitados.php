<?php

$documento = $_GET['afiliado'];
if(!is_numeric($documento)){
    echo '<div class="container"><h3 id="alerta">ENTRADA NO VÁLIDA</h3></div>';
    /*echo '{"error":"ENTRADA NO VÁLIDA"}';*/
}
else{
  if(strpos($documento, '.') !== false){
            echo '<div class="container;"><h3 id="alerta">ENTRADA NO VÁLIDA</h3></div>';
  }
  else{
  $resultArray = habilitados($documento);
  if(!hayconexion($resultArray)){
    echo '<div class="container"><h3 id="alerta">PROBLEMAS DE CONEXIÓN CON LA BASE DE DATOS</h3></div>';
  }
  else{
    if(existeafiliado($documento)){
      echo $resultArray;
    }
    else{
      echo '<div class="container"><h3 id="alerta">NO EXISTE AFILIADO</h3></div>';
    }
  }
}
}


function habilitados($documento){  
   $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => '10.8.0.1/mutpol/rest/habilitados',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array('dni:'.$documento, 'Content-Type: application/json'),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}


function hayconexion($response){
  if(empty($response)){ //Si esta vacia
    return false;
  }
  else{
    return true;
  }
}

//Existe afiliado  titular o carga
function existeafiliado($documento){
  $resultArray = habilitados($documento);
  $arrayafiliado = json_decode($resultArray, true);//Paso a json para ver si esta vacio
  if (array_key_exists('message', $arrayafiliado)){ //No existe afiliado
    return false;
  }
  else{
        return true; //existe
  }
}