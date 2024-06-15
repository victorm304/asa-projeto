#!/bin/bash
# Uma alternativa em bash
# Preencha com os dados do seu container
host="192.168.102.100"
user="containerNN"
senha="senhadocontainer"
bd="BDNN"

mysql -h $host -u $user -p$senha $bd << EOF

SELECT domain FROM domains;

EOF
