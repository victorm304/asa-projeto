<?php
if (isset($_GET['id']))
{
	$domain = $_GET['id'];
	
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
$bd->query("DELETE FROM dominios WHERE id =" . $domain);
header("Location: admgeral.php");
?> 

