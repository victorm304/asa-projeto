<?php
session_start();

if ($_SESSION["autenticado"] == 1) {
    header("Location: " . $_SESSION['usuario']);
    exit();
}

if (isset($_POST['login']) and isset($_POST['senha']))
{
	$login=$_POST['login'];
	$senha=$_POST['senha'];
}
else
	die('Erro na passagem de par&acirc;metros');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$bd = new mysqli("192.168.102.100", "usuario", "senha", "banco");
if ($bd->connect_errno)
{
	die("Falha ao conectar ao MySQL: (" . $bd->connect_errno . ") " . $bd->connect_error);
}

$result = $bd->query("SELECT * from Usuarios where email='$login' and senha='$senha'");
if ($bd->errno)
{
	die("Erro na execucao do SQL: $sql ($bd->errno) $bd->error");
}

if ($line = $result->fetch_assoc()) {
    $_SESSION["autenticado"] = 1;
    $_SESSION['user'] = $line['email'];
    $_SESSION['usuario'] = $line['tipo'];
    $_SESSION['userid'] = $line['id'];
    $_SESSION['login'] = $line['login'];
    header("Location: " . $_SESSION['usuario']);
    exit();
} else {
    $_SESSION["autenticado"] = 0;
    header("Location: index.php");
    exit();
}
?>
