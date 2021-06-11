# Monitoramento contínuo (Código em Python que envia pela Seria os dados para a NodeMCU ESP8266)

Protótipo de um Sistema de monitoramento de acidententes que comtém Interfaces de interação Web e por meio de Voz utilizando a AVS(Alexa Voice Service). 

## Começando

Para executar esse projeto em sua máquina basta clonar esse repositório usando o git-bash ou Github desktop ou simplismente baixando todo o projeto. 

### Pré-requisitos

Alguns requitos são importantes para executar esse projeto em sua máquina:

#### Porta Serial e velocidade o envio de dados

* Por se tratar de um programa que foi criado e executado no Sistema Operacional Windows a porta defida para a comunicação foi a porta **COM4** a velocidade do envio tem que ser compatível com a velocidade definida no código da placa NodeMcu que é de **115200**;

* Algumas bibliotecas foram utilizadas como **pyserial**, **numpy** que podem ser instalasas usando o comando pip:

	```
	pip install nomeBiblioteca
	```
* Também foram usada as bibliotecas **time** e **os** que por padrão já vem instaladas.


## Executar

* Conectar o placa NodeMCU na porta USB;

* Abra o Terminal no windows e execute o seguinte comando para executar o programa que envia dados pela serial:
	```
	python mpu6050_simulador.py
	```

## Autores

* **Patrícia Carmona** - [carmonapat](https://github.com/carmonapat)
* **Johnny da Silva** - *Initial work* - [JohnnySanttana72](https://github.com/JohnnySanttana72)
* **Rafael Brito** - [rafabrito](https://github.com/rafabrito)

Veja a lista de [contribuidores](https://github.com/JohnnySanttana72/Problema3-SD/graphs/contributors) que participaram deste projeto.


