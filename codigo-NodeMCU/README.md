# Monitoramento contínuo (Código a ser embarcado no NodeMCU ESP8266)

Protótipo de um Sistema de monitoramento de acidententes que comtém Interfaces de interação Web e por meio de Voz utilizando a AVS(Alexa Voice Service). 

## Começando

Para executar esse projeto em sua máquina basta clonar esse repositório usando o git-bash ou Github desktop ou simplismente baixando todo o projeto. 


### Pré-requisitos

Alguns requitos são importantes para executar esse projeto em sua máquina:


#### Bibliotecas

As bibliotecas usadas estão em [libraries](https://github.com/JohnnySanttana72/Problema3-SD/tree/main/codigo-NodeMCU/libraries).

#### Conta AWS

* É necessário ter uma conta AWS para se ter acesso ao serviço AWS Iot core para a criação de uma "Coisa" na plataforma e ser possível utilizar o protocolo MQTT e também gerar os certificados que permitem a comunicação usando autenticação TLS.

#### Configurar credências da rede Wifi
* Renomear o arquivo [wifi_credential_example.txt](https://github.com/JohnnySanttana72/Problema3-SD/blob/main/codigo-NodeMCU/wifi/data) para **wifi_credential.txt**;
* Inserir as credenciais no arquivo:
	```
	rede_wifi
	senha_da_rede_wifi
	```

#### Codificar Certificados

* Para executar o protótipo é preciso codificar os certificados gerados na Aws no arquivo [certificates_example.h](https://github.com/JohnnySanttana72/Problema3-SD/tree/main/codigo-NodeMCU/wifi) que deverá ser renomeado **certificates.h**.

* Formato do **certificates.h**

```
// Amazon root CA certificado.
const String AWS_CERT_CA =\
//-----BEGIN CERTIFICATE-----
"MIIDQTChkiG9w0CAimfz5m/jAo5gAwIBBgkqBAkPmljZbyjQsAgITBmy4vB4iANF" \
"ADA5MGQW1hem5sGQW1hemDVVUzEMQxBBDVhMQsYDVQQQGEwJQDExBBbWF6" \
"XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
//-----END CERTIFICATE-----

// A chave privada do dispositivo.
const String AWS_KEY_PRIVATE =\
//-----BEGIN RSA PRIVATE KEY-----
"MIIEpQIQEAphsi45x87olzmdBqAOrHfZCADpJvguBAAKCZQDmHuAsjyoXwRxu9Xw" \
"Ywi735aadERdTgZL84y5cgvgoBsi+tKbmi2Atu9XzQb956B7kf51X0goBGNO4oeA" \
"XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
//-----END RSA PRIVATE KEY-----

// O certificao para o dispositivo
const String AWS_CERT_CRT = 
//-----BEGIN CERTIFICATE-----
"MIIDwWH8yD0aOIBAgIUPCdJZxYDQYJKoZIhvcVfWTCCAkGgA65JHHAIAQEPMYwNL" \
"BQAwAdlYiBTZX2aWN1hFtYXpJ1UECcyBPTTFLMem9uIFEkGwxCQWvbi5lPUjb20g" \
"XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
//-----END CERTIFICATE-----
```

## Executar

* Conectar o placa NodeMCU na porta USB;

* Compilar e carregar o código-executável na placa usando a IDE Arduino;

## Autores

* **Patrícia Carmona** - [carmonapat](https://github.com/carmonapat)
* **Johnny da Silva** - *Initial work* - [JohnnySanttana72](https://github.com/JohnnySanttana72)
* **Rafael Brito** - [rafabrito](https://github.com/rafabrito)

Veja a lista de [contribuidores](https://github.com/JohnnySanttana72/Problema3-SD/graphs/contributors) que participaram deste projeto.


