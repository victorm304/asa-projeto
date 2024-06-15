#!/usr/bin/env python3
# Para conseguir executar este script, crie o diretório projeto-asa em /var, em seguida dentro de projeto-asa crie o diretorio "scripts" e o diretório "dominios"
# Depois, coloque os arquivos main.py, exeroot.c, mysql-connect.sh, reloadservices.sh dentro do diretório scripts
# Compile o arquivo exeroot.c, e depois dê o comando chmod a+s no arquivo binário gerado
# Agora basta dar aos demais arquivos a permissão de execução com chmod, e então basta executar o main.py, atente-se que o script vai buscar os domínios na coluna domain da tabela domains

import subprocess
import os

# Aqui obtemos o endereço Ipv4 do container
def check_ipv4_address():
    saida = subprocess.check_output("hostname -I | awk '{print $1}'", shell=True)
    ip = saida.decode('utf-8').strip()

    if ip.startswith('192.168.'):
        return ip

    else:
        print('Erro ao obter endereço Ipv4.')
        raise SystemExit

# Atualizar o arquivo httpd.conf.projeto
def atualizar_httpdconf(domains_array):
    os.chdir('/var/projeto-asa')
    ipv4 = check_ipv4_address()

    with open('httpd.conf.projeto', 'w') as arquivo:
        header = """<Directory /var/projeto-asa/dominios>
    AllowOverride All
    Require all granted
</Directory>"""
        arquivo.write(header)

    if domains_array[1:] != 0:
        with open('httpd.conf.projeto', 'a') as arquivo:
            for domain_name in domains_array[1:]:
                body = """\n\n<VirtualHost {0}:80>
        ServerName www.{1}
        ServerAlias {1}
        DocumentRoot "/var/projeto-asa/dominios/{1}/www"
        ErrorLog "/var/projeto-asa/dominios/{1}/logs/error.log"
        CustomLog "/var/projeto-asa/dominios/{1}/logs/access.log" common
    </VirtualHost>""".format(ipv4, domain_name)

                arquivo.write(body)

# Consulta o banco de dados
def mysql_check():
    comando = "/var/projeto-asa/scripts/mysql-connect.php" # Os scripts devem estar em /var/projeto-asa/scripts
    processo = subprocess.Popen(comando, shell=True, stdout=subprocess.PIPE)
    saida, _ = processo.communicate()

    return saida.decode('utf-8')

# Atualiza a estrutura de arquivo dos domínios
def update_virtualdomains(domains_array):
    os.chdir('/var/projeto-asa/dominios')
    for i in os.listdir():
        if i not in domains_array[1:]:
            try:
                os.removedirs(i)
            except NotADirectoryError:
                os.remove(i)
            except OSError:
                os.system('rm -rf {0}'.format(i))

    for i in domains_array[1:]:
        os.chdir('/var/projeto-asa/dominios')
        # Verificia se o diretório existe
        if i not in os.listdir():
            # Cria os arquivos do domínio
            os.makedirs('{0}'.format(i))
            os.makedirs('{0}/www'.format(i))
            os.makedirs('{0}/logs'.format(i))

            os.chdir('{0}/logs'.format(i))
            with open('error.log', 'w') as arquivo:
                pass
            with open('access.log', 'w') as arquivo:
                pass

            os.chdir('../www')
            with open('index.html','w') as arquivo:
                arquivo.write("O dominio {0} esta no ar!".format(i))

# Chama um script que reinicia o apache e o bind
def apache_reload():
    caminho_script = '/var/projeto-asa/scripts/reloadservices.sh'
    processo = subprocess.Popen([caminho_script], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    stdout, stderr = processo.communicate()

    if processo.returncode == 0:
        print(stdout.decode('utf-8'))

    else:
        print(stderr.decode('utf-8'))

def main():
    dominios = mysql_check().splitlines()
    atualizar_httpdconf(domains_array=dominios)
    update_virtualdomains(domains_array=dominios)
    apache_reload()

if __name__ == "__main__":
    main()