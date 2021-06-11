# Monitoramento contínuo (Página Web)

Protótipo de um Sistema de monitoramento de acidententes que comtém Interfaces de interação Web e por meio de Voz utilizando a AVS(Alexa Voice Service). 

## Começando

Para executar esse projeto em sua máquina basta clonar esse repositório usando o git-bash ou Github desktop ou simplismente baixando todo o projeto. 

### Pré-requisites

#### XAMPP

* Instalar o [XAMPP](https://www.apachefriends.org/pt_br/index.html) - Contém o Apache, MySql e o PHP que são importantes para executar a aplicação localmente.

#### Composer

* Instalar [Composer](https://getcomposer.org/) - É um gerenciador de dependências e bibliotecas para o PHP e para o Laravel que é um Framework PHP.

#### Dependências do Laravel

* Quando esse projeto é clonado em sua máquina as dependências do projeto não estão instaladas então é necessário executar um comando no diretório do projeto para baixar as dependências.

	```
	composer update
	```

#### Configurar arquivo .env

* Renomear o arquivo **.env-example** para **.env**;
* Executar o seguinte comando no diretório do projeto para criar a chave única para a aplicação:
	```
	php artisan key:generate
	```
* Configurar o Banco de dados:
	```
	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=nome_do_banco
	DB_USERNAME=usuário_do_banco
	DB_PASSWORD=senha_se_houver_se_não_houver_pode_deixar_vazio
	```

* Configurar dados do Email que énviará a notificação de acidente:
	```
	MAIL_DRIVER=smtp
	MAIL_HOST=smtp.googlemail.com
	MAIL_PORT=465
	MAIL_USERNAME=nomedoemail@gmail.com
	MAIL_PASSWORD=senhadoemail
	MAIL_ENCRYPTION=ssl
	```
	- É necessário também ativar no email Gmail na parte de segurança o acesso da aplicação use os recurso de envio do Gmail.

#### Configurar o cliente MQTT

* Coloque os certificados na pasta [certificates](https://github.com/JohnnySanttana72/Problema3-SD/tree/main/certificates) ou em outra pasta qualquer, o caminho absoluto será pego usando a função do PHP **base_path()**, só é necessário indicar a pasta onde está o certificado;

* Vá até o arquivo [mqtt-cliente.php](https://github.com/JohnnySanttana72/Problema3-SD/blob/main/config/mqtt-client.php) e altere os seguintes campos:

	```
	'host' => env('MQTT_HOST', 'AWS-end-point.us-east-1.amazonaws.com'),
	.
	.
	.
	'tls' => [
	.
	.
	.
		'ca_file' => env('MQTT_TLS_CA_FILE', base_path().'/certificates/AmazonRootCA1.pem'),
		'ca_path' => env('MQTT_TLS_CA_PATH', base_path().'/certificates'),
		'client_certificate_file' => env('MQTT_TLS_CLIENT_CERT_FILE',  base_path().'/certificates/certificate.pem.crt'),
		'client_certificate_key_file' => env('MQTT_TLS_CLIENT_CERT_KEY_FILE', base_path().'/certificates/private.pem.key'),
	],
	```

## Executar

* Iniciar o XAMPP e executar o MySql;
* Executar o comando no diretório do projeto para iniciar o servidor:
	```
	php artisan serve
	```
* Abrir o navegador e digitar:
	```
	localhost:8000
	```

## Autores

* **Patrícia Carmona** - [carmonapat](https://github.com/carmonapat)
* **Johnny da Silva** - *Initial work* - [JohnnySanttana72](https://github.com/JohnnySanttana72)
* **Rafael Brito** - [rafabrito](https://github.com/rafabrito)

Veja a lista de [contribuidores](https://github.com/JohnnySanttana72/Problema3-SD/graphs/contributors) que participaram deste projeto.


