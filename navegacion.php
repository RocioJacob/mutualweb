<!--cambie el codigo del header para que coincida en los dos sistemas-->
<?php 	
	include("estiloMW.php");
 ?>
<header>
<nav class="navbar navbar-expand-lg navbar-dark" id="barra">  <!-- -->
	<a class="navbar-brand text-white"><img src="imagenes/logo-mppn.png" id="logonav"></a> <!-- pase caracteristicas al codigo css por id -->
	<dl id="leyenda">
		<dt id="leyenda">MUTUAL DEL PERSONAL DE</dt>
		<dt id="leyenda">LA POLICIA DEL NEUQUEN</dt>
		<!--<dd id="leyenda">REDES SOCIALES</dd> -->
	</dl>
	
	<div class="collapse navbar-collapse" id="menu">
	<ul class="navbar-nav mr-auto">	</ul>
	</div>

    <ul class="nav navbar-nav navbar-right">
    	<!--<li><div style="font-family: 'Georgia' cursive; font-size: 15px; color: #3A73A8; text-align: right; margin-right: 20px;"><?php echo $usuario?></div></li>  cambio de lugar del echo del nombre de usuario -->
       <li><div><a href="salir.php" class="btn" id="botonMenu" title="MENU">CERRAR SESION</a></</li>
       <li><a  href="menu.php" class="btn" id="botonMenu" title="MENU">VOLVER AL MENU</a></div></li>
    </ul>
</nav>
</header>
    
    <?php 
	if(!estaconectado()) {
		$nombre = $_SESSION['nombre'];
	?>
	<div class="container">
    <div style="font-family: 'Georgia' cursive; font-size: 15px; color: #3A73A8; text-align: right;"><?php echo $nombre?></div> 
    </div>
	<?php } ?>


