
#!/usr/bin/php
<?php
// Preencha com os dados do seu container
$host = "192.168.102.100";
$user = "containerNN";
$senha ="senhadocontainer";
$bd = "BDNN";

$conectar = new mysqli($host, $user, $senha, $bd);

$sql = "SELECT domain FROM domains";

$result = $conectar->query($sql);

if ($result->num_rows > 0) {
    echo "domain\n";
    while ($row = $result->fetch_assoc()) {
        echo $row["domain"] . "\n";
    }
}

$conectar->close();
?>
