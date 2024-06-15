<?php
if (isset($_POST['novodom']))
{
	$domain = $_POST['novodom'];
	
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
$bd->query("INSERT INTO dominios (dominio) VALUES ('{$domain}')");
header("Location: admgeral.php");
?> 
