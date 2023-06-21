<?php  
	session_start();
	session_destroy();
	header('Location:isMW.php');
?>