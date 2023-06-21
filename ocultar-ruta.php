<?php  
if (!isset($_SESSION['documento'])) {
  header('Location: isMW.php');
}
else{
  $documento = $_SESSION['documento'];
  $nombre = "2020.pdf"; 
  $filename = "./balances/2020.pdf"; 

}
?>