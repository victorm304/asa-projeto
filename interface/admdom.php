<?php
session_start();

if (!($_SESSION["autenticado"]))
        header("Location: index.php");

echo "Bem vindo Administrador de Dominio";
echo "<br>Usuario: " . $_SESSION['user']; 
?>
<HTML>
<BODY>
<br>
<TR><TD COLSPAN="4" ALIGN="CENTER">
<button type="button" onclick="window.location.href='sair.php'">SAIR</button>
</TD></TR>
<hr>
<b>Dominios Configurados</b>
<?php

$search = "@";
$pos = strpos($_SESSION['user'], $search);
$dominio = substr($_SESSION['user'], $pos+strlen($search));

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$bd = new mysqli("192.168.102.100", "usuario", "senha", "banco");

if ($bd->connect_errno)
{
        die("Falha ao conectar ao MySQL: (" . $bd->connect_errno . ") " . $bd->connect_error);
}

$result = $bd->query("SELECT * FROM Usuarios WHERE email LIKE '%$dominio' AND tipo='comum.php'");

echo("
    <TABLE BORDER=1>
    <TR><TH>ID</TH><TH>Usuarios</TH><TH>Editar</TH></TR>
");

while($line = $result->fetch_assoc()) {
    echo "<TR>";
    echo "<TD>" . $line['id'] . "</TD>";
    echo "<TD>" . $line['email'] . "</TD>";
    echo "<TD><button type='button' onclick=\"if (confirm('Tem certeza que deseja excluir?')) { window.location.href='rmvusr.php?id=" . $line['id'] . "'; }\">Remover</button></TD>";
    echo "</TR>"; 
}

echo "</TABLE>";
 
?>
<form method="post" action="criarusr.php">
<hr>
<b>Criar Usuarios</b>
<br>
    <label for="user id">Novo Usuario:</label>
<br>
    <input type="text" name="novousr" id="user id"> 
<br>
<input type="submit" value="enviar">
</form>
<form method="post" action="trocasenha.php">
<hr>
<b>Trocar Senha</b>
<br>
    <label for="pass id">Nova Senha:</label>
<br>
    <input type="text" name="novasenha" id="pass id">
<br>
<input type="submit" value="enviar">
</form>
</BODY>
</HTML>

