<?php
include("conexion.php");
include("funciones.php");
include("estiloMW.php");

$documento = $_POST['busqueda'];

if(!is_numeric($documento)){
     echo '<div class="container"><hr/>
        <h3 id="alerta">ENTRADA NO VÁLIDA</h3><hr/>
        </div>';
}
else{
        if(strpos($documento, '.') !== false){
            echo '<div class="container;"><hr/>
        <h3 id="alerta">ENTRADA NO VÁLIDA</h3><hr/>
        </div>';
        }
        else{

            if (existeAfiliado($documento)){
                    $resultArray = titularCargas($documentoAfilado);
                    $data = datosTitular($resultArray); //Obtengo datos titular
                    $nombreAfiliado = $data['nombre'];
                    $apellidoAfiliado = $data['apellido'];
                    $habilitado = $data['habilitado'];
                    $nombre = $nombreAfiliado." ".$apellidoAfiliado;

                    echo '<div class="container" style="text-align:center;"><hr/>
                    <table class="tabla">
                        <div style="font-family: Georgia, cursive; text-decoration: underline; font-size:25px;">Información del afiliado</div>
                        <p>Número documento<br/>'.$documento.'</p>
                        <p>Apellido y Nombre<br/>'.$nombre.'</p>
                        <h5 id="mensaje">HABILITADO EN MUTUAL POLICIAL</h5>
                    </table>
                    </div>'; 
            }
            else{
                	//echo json_encode(array('mensaje' => "El afiliado NO se encuentra en los registros de los habilitados", 'salida' => '1'));
                    echo '<div class="container" style="text-align:center;"><hr/>
                        <h3 id="alerta">EL AFILIADO NO FIGURA EN EL REGISTRO DE HABILITADOS</h3><hr/>
                        <h6 id="alerta2">PARA CONSULTAS COMUNICARSE VIA WHATSAPPS AL (299)4046203 - EMAIL: mesadeentrada@mppneuquen.com.ar</h6>
                        </div>';
            }
        }
}
?>
</div>
</div>



