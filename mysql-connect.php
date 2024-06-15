<?php
// Preencha com os dados do seu container
$host = "192.168.102.100";
$user = "containerNN";
$senha = "senhadocontainer";
$bd = "BDNN";


$conn = new mysqli($host, $user, $senha, $bd);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


$sql = "SELECT domain FROM domains";


$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Domain: " . $row["domain"] . "<br>";
    }
} else {
    echo "Nenhum domínio encontrado.";
}


$conn->close();
?>

