<?php
session_start();

if (!($_SESSION["autenticado"]))
        header("Location: index.php");

echo "Bem vindo Administrador Geral";
echo "<br>Usuario: " . $_SESSION['user'] 
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

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$bd = new mysqli("192.168.102.100", "usuario", "senha", "banco");

if ($bd->connect_errno)
{
        die("Falha ao conectar ao MySQL: (" . $bd->connect_errno . ") " . $bd->connect_error);
}

$result = $bd->query("SELECT * FROM dominios ORDER BY id ASC");

echo("
    <TABLE BORDER=1>
    <TR><TH>ID</TH><TH>Dominio</TH><TH>Editar</TH></TR>
");

while($line = $result->fetch_assoc()) {
    echo "<TR>";
    echo "<TD>" . $line['id'] . "</TD>";
    echo "<TD>" . $line['dominio'] . "</TD>";
    echo "<TD><button type='button' onclick=\"if (confirm('Tem certeza que deseja excluir?')) { window.location.href='rmvdom.php?id=" . $line['id'] . "'; }\">Remover</button></TD>";
    echo "</TR>"; 
}

echo "</TABLE>";
 
?>
<form method="post" action="criardom.php">
<hr>
<b>Criar Dominios</b>
<br>
    <label for="dom id">Novo dominio:</label>
<br>
    <input type="text" name="novodom" id="dom id"> 
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

