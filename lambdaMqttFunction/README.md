# Monitoramento contínuo (Código com a Lógica o Lambda que será o Back-end)

Protótipo de um Sistema de monitoramento de acidententes que comtém Interfaces de interação Web e por meio de Voz utilizando a AVS(Alexa Voice Service). 

## Começando

Para executar esse projeto em sua máquina basta clonar esse repositório usando o git-bash ou Github desktop ou simplismente baixando todo o projeto. 


### Pré-requisitos

Alguns requitos são importantes para executar esse projeto em sua máquina:

#### Conta AWS

* É necessário ter uma conta AWS para se ter acesso ao serviço Lambda.

#### Código Lambda

* Vá na AWS e crie uma função Lambda copie o código [MqttFunction.py](https://github.com/JohnnySanttana72/Problema3-SD/tree/main/lambdaAlexaEventHandler) copie o seu conteúdo e cole na função lâmbda que foi criada;

* Defina um tempo para a execução do lambda de **30 segundos** para que seja possível a execução por completo do código;

* No Serviço IAM dê permição a sua função Lambda para publicar mensagens usando o serviço Aws Iot core que usa o protocolo MQTT do seguinte modo:

	- Clique em **Adicionar política em linha** selecione a aba JSON e copie lá o seguinte código:
		```
		{
		   "Version": "2016-6-25",
		   "Statement": [
		    {
		        "Effect": "Allow",
		        "Action": [
		            "iot:*"
		        ],
		        "Resource": [
		            "*"
		        ]
		    }
		   ]
		}
		```
	- Clique em revisar Política, dê um nome para a sua política e por fim salve essa política;

* É necessário Também anexar a função lâmbda no AWS IAM as permições para o uso do DynamoDB e da API Gateway que será criada:

	- Marque a permissão para o uso do DynamoDB: AmazonDynamoDBFullAccess;
	- Marque a permissão para o uso da APIGateway: AmazonAPIGatewayInvokeFullAccess.

#### Criar Banco no DynamoDB

* Por meio do serviço DynamoDB crie um banco com o nome **monitoramento_db** e nomeie a chave primária como **id** e defina como número;

#### Criar APIGateway

* Por meio do serviço APIGateway crie uma API Rest e vincule a função Lambda que será usada como back-end definas as seguintes URIs para os tipos de requisição criados (POST, GET) em Solicitação de integração marque a opção Usar a integração de proxy:
	- estado: esse recurso será criado como **/estado** e o tipo de método é o **GET**;
	- configurar-tempo: esse recurso será criado como **/configurar-tempo** e o tipo de método é o **POST**, é necessário a criação de parametros, nomeie esse parâmetro como tempo ele será enviado no link da requisição POST;
	- recuperar-tempo: esse recurso será criado como **/recuperar-tempo** e o tipo de método é o **GET**;

* Implante esta API que foi criada.

## Executar

* Para ter acesso ao Lambda back-end basta utilizar o link da API precedida das URIs criadas que são referentes a cada operação que o lâmbda realiza.

## Autores

* **Patrícia Carmona** - [carmonapat](https://github.com/carmonapat)
* **Johnny da Silva** - *Initial work* - [JohnnySanttana72](https://github.com/JohnnySanttana72)
* **Rafael Brito** - [rafabrito](https://github.com/rafabrito)

Veja a lista de [contribuidores](https://github.com/JohnnySanttana72/automacao-resencial/graphs/contributors) que participaram deste projeto.


