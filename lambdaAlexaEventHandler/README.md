# Monitoramento contínuo (Código com a Lógica para a Skill criada na plataforma Alexa Developer Console)

Protótipo de um Sistema de monitoramento de acidententes que comtém Interfaces de interação Web e por meio de Voz utilizando a AVS(Alexa Voice Service). 

## Começando

Para executar esse projeto em sua máquina basta clonar esse repositório usando o git-bash ou Github desktop ou simplismente baixando todo o projeto. 


### Pré-requisitos

Alguns requitos são importantes para executar esse projeto em sua máquina:

#### Conta AWS

* É necessário ter uma conta AWS para se ter acesso ao serviço Lambda.

#### Skill

* Crie a Skill na [Alexa Developer Console](https://developer.amazon.com/alexa/console/ask);

* Crie um gatilho que é uma palavra-chave para o acionamento das funcionalidades da Skill;

* Crie as Intents(EstadoIntent, ConfiguracaoIntent e DefinirTempoIntent):
	- EstadoIntent: verifica o estado atual da NodeMcu (conectado ou desconectado);
	- ConfiguracaoIntent: solicita permição para configurar um intervalo de tempo para notificar a desconexão do dispositinvo NodeMcu;
	- DefinirTempoIntent: que definirá de fato o intervalo de tempo para a notificação é necessário ao se criar a sentença criar um **slot** chamado **tempo** do tipo **Number** seguindo o exemplo abaixo:
		```
		{tempo} minuto
		```
#### Código Lambda para Skill

* Vá na AWS e crie uma função Lambda copie o código [AlexaEventHandler.py](https://github.com/JohnnySanttana72/Problema3-SD/tree/main/lambdaAlexaEventHandler) copie o seu conteúdo e cole na função lâmbda que foi criada;

* Defina um tempo para a execução do lambda de **30 segundos** para que seja possível a execução por completo do código;

* Vincule a Skill Alexa a função lâmbda criando um gatilho(trigger) **Kit Alexa Skills** e pegue o link da Skill que está na plataforma da Alexa developer na opção **Endpoint** e vincule ao gatilho, ao ser feito isso salve o gatilho e realize o deploy da função Lamda;

* O mesmo deve ser feito na plataforma da Alexa developer na opção **Endpoint**, mas agora com o link ARN da função Lambda, insira esse link no campo **Default Region**.

## Executar

* Na Alexa Developer console abra a Skill e vá na opção teste que está no cabeçalho da página no campo **Skill testing is enabled in:** selecione a opção **Developer**, pronto basta digitar ou habilitar o microfone de seu dispositivo para testar as Intents;

## Autores

* **Patrícia Carmona** - [carmonapat](https://github.com/carmonapat)
* **Johnny da Silva** - *Initial work* - [JohnnySanttana72](https://github.com/JohnnySanttana72)
* **Rafael Brito** - [rafabrito](https://github.com/rafabrito)

Veja a lista de [contribuidores](https://github.com/JohnnySanttana72/automacao-resencial/graphs/contributors) que participaram deste projeto.


