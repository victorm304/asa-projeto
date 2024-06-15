<?php
session_start();

if (isset($_POST['novasenha']))
{
	$pass = $_POST['novasenha'];
	
}
else
	die('Erro na passagem de par&acirc;metros');
  	

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$bd = new mysqli("192.168.102.100", "usuario", "senha", "banco");
if ($bd->connect_errno)
{
	die("Falha ao conectar ao MySQL: (" . $bd->connect_errno . ") " . $bd->connect_error);
}
else
$bd->query("UPDATE Usuarios SET senha='$pass' WHERE id=" . $_SESSION['userid']);

if ($_SESSION["login"] == 0) {
    
    header("Location: " . $_SESSION['usuario']);
} 
else {
    $bd->query("UPDATE Usuarios SET login=0 WHERE id=" . $_SESSION['userid']);
    header("Location: sair.php");
}
?> 
