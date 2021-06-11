/************************************************************
  Parte do código-fonte foi extraído e adaptado dos seguintes sites:
  1 - Comunicação Mqtt aws iot: https://nerdyelectronics.com/iot/how-to-connect-nodemcu-to-aws-iot-core/;
  2 - Definição dos certificados: https://savjee.be/2019/07/connect-esp32-to-aws-iot-with-arduino-code/;
  3 - Configuração NTP: https://www.fernandok.com/2018/12/nao-perca-tempo-use-ntp.html.


  Alunos: Johnny da Silva, Patrícia Carmona, Rafael Brito
  Disciplina: TEC499 
  Turma:TP02             

***********************************************************/
#include <ESP8266WiFi.h>
#include <PubSubClient.h>
#include <NTPClient.h>
#include <WiFiUdp.h>
//#include <FirebaseArduino.h>
#include <ArduinoJson.h> 
#include <FS.h>
#include <string.h>
#include "certificates.h"
extern "C" {
  #include "libb64/cdecode.h"
  #include "user_interface.h"
}

void callback(char* topic, byte* payload, unsigned int length); 

const char* ssid; //variável para a rede Wifi
const char* password; //variável para a senha da rede Wifi
const char* endpoint_aws = "a3b300y0i6kc5u-ats.iot.us-east-1.amazonaws.com"; // AWS Endpoint

long lastMsg = 0; // variável que armazena o tempo em milisegundos da última mensagem
long lastMsg2 = 0;
char msg[256];  //buffer para conter a mensagem a ser publicada
DynamicJsonDocument doc(1024); // cria um documento do formato json ArduiJson 6.17.3

int timeZone = -3; // configuração do fuso horário de brasília

//int timerValue = 1;
int hour; // variável que armazena a hora recuperada do servidor NTP
int minute; // variável que armazena o minuto recuperado do servidor NTP

//Socket UDP que a biblioteca utiliza para recuperar dados sobre o horário
WiFiUDP ntpUDP;

//Objeto responsável por recuperar dados sobre horário
NTPClient ntpClient(
    ntpUDP,                 //socket udp
    "0.br.pool.ntp.org",    //URL do servidor NTP
    timeZone*3600,          //Deslocamento do horário em relacão ao GMT 0
    60000);

//Objeto que cria o cliente MQTT
WiFiClientSecure espClient;

int status_LED = LOW; // variável que é usada para alterar o valor da LED para acender/apagar
int status_aux_LED = LOW; // variável auxiliar que é usada para alterar o valor da LED em hora marcada

bool responder = false;
bool responder2 = false;
int a = 1000;

unsigned char inputBuffer[16];

union {float f; unsigned char b[4];} tempo; // valor do tempo ao ser recebido na Serial
union {float f; unsigned char b[4];} acelerometro; // valor do acelerometro ao ser recebido na Serial
union {float f; unsigned char b[4];} giroscopio; // // valor do giroscopio ao ser recebido na Serial


//Função que recebe os dados da publicação
void callback(char* topic, byte* payload, unsigned int length) 
{
  StaticJsonDocument<256> docs; // variável que é usada para decodificar a mensagem Json ArduiJson 6.17.3
  deserializeJson(docs, payload, length); // decodifica a mensagem Json ArduiJson 6.17.3
 
  Serial.print("Message arrived [");
  Serial.print(topic);
  Serial.print("] ");
  
  String msg = docs["state"]["desired"]["estado"]; // variável que recebe o Json decodificado do status da LED para o acionamento remoto
  String reset_serial = docs["state"]["desired"]["reset"]; // variável que recebe o Json decodificado do status da LED para o acionamento remoto

  //condição que permite devolver o estado da placa
  if (msg != NULL){
    if (msg.equals("verificar estado")){
      responder = true;
    }
  }

  //condição para reiniciar o envio de dados pela Serial
  if(reset_serial != NULL) {
    if(reset_serial.equals("reiniciar")) {
      Serial.println("REINICIAR ENVIO");
      Serial.flush();
      responder = false;
      responder2 = false;
    }
  }
}
//Conectando a um número de porta MQTT 8883 conforme padrão
PubSubClient client_pubsub(endpoint_aws, 8883, callback, espClient); 

//Função que configura as credênciais da rede Wifi
void config_wifi(String path) 
{
  String ssid_wifi = "";
  String password_wifi = "";
  int count = 0;
  
  File file = SPIFFS.open(path, "r");// Abre arquivo que contém as credênciais da rede Wifi
  
  if (!file) {
    Serial.println("Erro ao abrir arquivo!");
  }
  
  while (file.available()) {
    if (count == 0)
      ssid_wifi = file.readStringUntil('\n'); //na primeira linha está o SSID
    else
      password_wifi = file.readStringUntil('\n'); //na segunda linha está a senha
    count++;
  }
  file.close(); // fecha arquivo
  
  ssid_wifi.trim(); //remove \n do final da string lida do arquivo
  password_wifi.trim();//remove \n do final da string lida do arquivo
  
  ssid = ssid_wifi.c_str(); //conversão de string para const char
  password = password_wifi.c_str(); //conversão de string para const char

  Serial.println(ssid);
  Serial.println(password);
}

void setupNTP()
{
    //Inicializa o client NTP
    ntpClient.begin();
    
    //Espera pelo primeiro update online
    Serial.println("Esperando pela primeira atualização");
    while(!ntpClient.update())
    {
        ntpClient.forceUpdate();
    }

    // É usado para setar no espClient o tempo do servidor NTP para validar o certificado X509 e estabelecer conexão com o servidor aws
    espClient.setX509Time(ntpClient.getEpochTime());
}

//função que decodifica o base64 do certificado 
int b64decode(String b64Text, uint8_t* output) 
{
  base64_decodestate s;
  base64_init_decodestate(&s);
  int cnt = base64_decode_block(b64Text.c_str(), b64Text.length(), (char*)output, &s);
  return cnt;
}

// função para confurar os certificados
void config_certify() 
{
  
  uint8_t binaryCert[AWS_CERT_CRT.length() * 3 / 4];//converte o tamanho do certificado pra um número binário sem sinal 
  int len = b64decode(AWS_CERT_CRT, binaryCert); //decodifica na base 64 o certificado 
  espClient.setCertificate(binaryCert, len); //atribui o certificado Root ao cliente MQTT
  
  uint8_t binaryPrivate[AWS_KEY_PRIVATE.length() * 3 / 4];//converte o tamanho do certificado pra um número binário sem sinal 
  len = b64decode(AWS_KEY_PRIVATE, binaryPrivate); //decodifica na base 64 o certificado 
  espClient.setPrivateKey(binaryPrivate, len); //atribui a chave privada ao cliente MQTT

  uint8_t binaryCA[AWS_CERT_CA.length() * 3 / 4];
  len = b64decode(AWS_CERT_CA, binaryCA); //atribui o certificado ao cliente MQTT
  espClient.setCACert(binaryCA, len);
}

// função que inicializa as configurações para a conexão da rede Wifi, conexão MQTT
void setup()
{
  Serial.begin(115200); // Inicializa a serial
 
  Serial.println();   // Pula uma linha na janela da serial

  espClient.setBufferSizes(512, 512); // seta o valor máximo do buffer para o cliente MQTT

  config_wifi("/wifi_credential.txt"); // configuração a rede wifi
  
  pinMode(LED_BUILTIN, OUTPUT); // define o pino da LED como pino de saída              
  //digitalWrite(2, LOW); // atribui o status da LED como ligado
  
  WiFi.begin(ssid, password); //Passa os parâmetros para a função que vai fazer a conexão com a rede sem fio
  delay(1000); // Intervalo de 1000 milisegundos
  Serial.print("Conectando à rede Wifi"); // Escreve um texto na serial
  
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(500); // Intervalo de 500 milisegundos
    Serial.print("."); //Escreve o caractere na serial
  }
  
  Serial.println();
  Serial.println("WiFi conectado");
  Serial.print("Endereço IP: "); // Escreve na janela da serial
  Serial.println(WiFi.localIP()); // Escreve na  o IP recebido dentro da rede sem fio (recebido de forma automática)
  
  delay(1000); // Intervalo de 1000 milisegundos

  config_certify();// configura os certificados

  setupNTP();// inicia o servidor NTP para a recuperar o horário atual(horário de Brasília) 
}

// função para reconectar ao broker MQTT
void reconnect() 
{
  // Loop até estarmos reconectados
  while (!client_pubsub.connected()) // Enquanto falhar a conexão
  {
    Serial.print("Tentando conexão MQTT AWS IoT...");
    // Tentativa de conexão
    if (client_pubsub.connect("ESPthing")) 
    {
      Serial.println("Conectado");
      // Depois de conectado, publique uma aviso ...
      client_pubsub.publish("outTopic", "hello world");
      // ... e reinscrever
      client_pubsub.subscribe("$aws/things/NodeMCU/shadow/update/accepted");
    } 
    else
    {
      Serial.print("falhou, rc=");
      Serial.print(client_pubsub.state());
      Serial.println(" tente novamente em 5 segundos");
  
      char buf[256]; // cria buffer para armazenar a mensagem que será enviada no formato Json
      espClient.getLastSSLError(buf, 256);
      Serial.print("Erro de SSL de WiFiClientSecure: ");
      Serial.println(buf);
  
      // Aguarde 5 segundos antes de tentar novamente
      delay(5000);
    }
  }
}

void loop() {
  if(responder2){
    digitalWrite(LED_BUILTIN, HIGH);   // turn the LED on (HIGH is the voltage level)
    delay(a);                       // wait for a second
    digitalWrite(LED_BUILTIN, LOW);    // turn the LED off by making the voltage LOW
    delay(a);
  }
  if (!client_pubsub.connected()) // Se não houver a conexão
  {
    digitalWrite(status_LED, LOW);
    a = 500;
    responder2 = true;
    reconnect(); // tenta reconectar
  }
  responder2 = false;
  client_pubsub.loop(); //chama novamente a função loop 
  
  if(responder) {

    delay(2000);
  
    responder = false;
    doc.clear();
    
    doc["state"]["reported"]["estado"] = "CONECTADO";
  
    //doc.printTo(msg, sizeof(msg)); // serializa a mensagem Json 5.13.5
    serializeJson(doc, msg); // serializa a mensagem Json 6.17.3
    Serial.println(msg);
  
    // publicar mensagens no tópico "$aws/things/NodeMCU/shadow/update"
    client_pubsub.publish("$aws/things/NodeMCU/shadow/update", msg);
  }
  
  long now = millis();
  if (now-lastMsg > 1000) // se o tempo da mensagem atual menos o tempo da ultima mensagem ultrapassar os 5 segundos
  {
    lastMsg = now;// recupera o tempo atual em milissegundos
    
    hour = ntpClient.getHours(); // recupera a hora atual
    minute = ntpClient.getMinutes(); // recupera o minuto atual
    
    String horas = (String)hour+":"+(String)minute;// formata o horário atual
    Serial.print("Horas: ");
    Serial.println(horas);

    // Condição que verifica se tem algo na Serial
    if (Serial.available()) {
      doc.clear(); // apaga o doc do json
      if (Serial.available() > 0) {
        responder2 = false;
        Serial.readBytesUntil('\n', inputBuffer, 16);
        
        for (int i = 0; i < 4; i++) {
            tempo.b[i] = inputBuffer[i];
            acelerometro.b[i] = inputBuffer[4 + i];
            giroscopio.b[i] = inputBuffer[8 + i];
        }

        // Condição que valida a ocorrência do acidente
        if(acelerometro.f > 9.7 && giroscopio.f > 0.01) {
          Serial.println("OCORREU ACIDENTE"); // Interrompe o envio de dados pela serial
          Serial.flush();

          a = 2000;
          responder2 = true;
            
          long now2 = millis();
          if (now2-lastMsg2 > 2000) {

            lastMsg2 = now2;

            doc["state"]["reported"]["acidente"] = "Horário do Acidente: " + horas + ", Tempo decorrido: " + (String)tempo.f;
            serializeJson(doc, msg);
            client_pubsub.publish("$aws/things/NodeMCU/shadow/update", msg);
          }
        }
      }
    }
  }
}  
