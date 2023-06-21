<?php
include('head.php');
include('navegador.php');
include('funciones.php');
include("estiloMW.php");



$documento = $_GET['afiliado'];
if(!is_numeric($documento)){
     echo '<div class="container"><hr/>
        <h3 id="alerta">ENTRADA NO VÁLIDA</h3>
        </div>';
}
else{
	if(strpos($documento, '.') !== false){
            echo '<div class="container;"><hr/>
        <h3 id="alerta">ENTRADA NO VÁLIDA</h3>
        </div>';
	}
	else{
	$resultArray = habilitado($documento);
	if(!hayConexion($resultArray)){
		echo '<div class="container"><hr/>
        <h3 id="alerta">PROBLEMAS DE CONEXIÓN CON LA BASE DE DATOS</h3>
        </div>';
	}
	else{
		if(existe($documento)){
			$salida = habilitados($documento);
			$nombre = $salida['apellido']." ".$salida['nombre'];
			$habilitado = $salida['habilitado'];
			if($habilitado){
				echo '<div class="container" style="text-align:center;"><br/>
                    <table class="tabla">
                    <img src="imagenes/logo.jpg" height="100px"><br/><br/>
                        <p>Apellido y Nombre<br/>'.$nombre.'</p>
                        <p>Número documento<br/>'.$salida['documento'].'</p>
                        <h5 id="mensaje">HABILITADO EN MUTUAL POLICIAL</h5>
                    </table>
                    </div>';
			}
			else{
				echo '<div class="container" style="text-align:center;"><br/>
                    <table class="tabla">
                    <img src="imagenes/logo.jpg" height="100px"><br/><br/>
                        <p>Apellido y Nombre<br/>'.$nombre.'</p>
                        <p>Número documento<br/>'.$salida['documento'].'</p>
                        <h5 id="mensaje">NO HABILITADO EN MUTUAL POLICIAL</h5>
                    </table>
                    </div>';
			}


		}
		else{
			echo '<div class="container"><hr/>
        <h3 id="alerta">NO EXISTE AFILIADO</h3>
        </div>';
		}
	}
}
}

?>
