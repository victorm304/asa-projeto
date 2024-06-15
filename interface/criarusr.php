<?php
session_start();

if (isset($_POST['novousr']))
{
	$usr = $_POST['novousr'];
	$pass = bin2hex(openssl_random_pseudo_bytes(3));	
	$search = "@";
	$pos = strpos($_SESSION['user'], $search);
	$dominio = substr($_SESSION['user'], $pos);
	$newusr = $usr . $dominio;
	
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
$bd->query("INSERT INTO Usuarios (email,senha,tipo,login) VALUES ('{$newusr}', '{$pass}', 'comum.php', '1')");
header("Location: admdom.php");
?> 


