import serial
import numpy as np
# import keyboard
from time import sleep
import time
import os
clear = lambda: os.system('cls')

opcao = 0

matriz = []
sensor1 = []

# sensor1 = np.around(sensor1, 2)

class Comunicacao():

    def SerialInit(self, NomePorta, Velocidade, TimeRX, TimeTX):

        try:
            self.PortaCom = serial.Serial(NomePorta, Velocidade, 8, serial.PARITY_NONE, serial.STOPBITS_ONE, TimeRX,
                                          False, False, False, TimeTX)
            self.PortaCom.reset_input_buffer()
            self.PortaCom.reset_output_buffer()

        except Exception:
            print("Erro na porta " + NomePorta + "!")



    def WriteSerial(self, DadosTx):

        try:
            self.PortaCom.flushOutput()
            # TamPac = DadosTx[3]
            # for i in range(TamPac):
            DadoTxByte = bytearray(DadosTx)

            self.PortaCom.write(DadoTxByte)
            # print(DadoTxByte)

        except Exception:
            print("Erro Escrita")

    def Leitura_Serial(self, tipo):
        data = self.PortaCom.readline()

        # decode_data = str(data[0:len(data)].decode("utf-8"))
        if "OCORREU ACIDENTE" in str(data) and tipo == 'interrupcao':
            print(data)
            return True
        elif "REINICIAR ENVIO" in str(data) and tipo == 'reiniciar':
            print(data)
            return True
        else:
            return False



def lerArquivo(nome):
    file = open(nome, 'r')
    for line in file:
        temp = line.rstrip('\n').split(", ")
        matriz.append(temp)

PortaCom = Comunicacao()
PortaCom.SerialInit('COM4', 115200, 1, 1)

def iniciarTeste(numeroTeste):
    iniciar = True

    print('\n')
    print('Precione a Ctrl-c a qualquer momento para interromper o envio de dados')
    print('\n')
    while True:
        try:

            if (iniciar):
                for i in sensor1:
                    print(i)
                    PortaCom.WriteSerial(np.array(i))
                    time.sleep(3)
                    if (PortaCom.Leitura_Serial('interrupcao')):
                        iniciar = False
                        break
            if (PortaCom.Leitura_Serial('reiniciar')):
                iniciar = True
        except KeyboardInterrupt:
            print('\nFim do Teste {}\n'.format(numeroTeste))
            sleep(2)
            clear()
            break

while opcao != 4:
    print('\n MENU:\n')
    print('[1] Teste 1 Movimento normal')
    print('[2] Teste 2 Monitoramento Involutário')
    print('[3] Teste 3 Acidente')
    print('[4] Sair')
    opcao = int(input('Escolha a opção de teste: '))

    if opcao == 1:
        lerArquivo("semMovimento.txt")
        sensor1 = np.array(matriz, dtype=np.float32)
        iniciarTeste(1)
    elif opcao == 2:
        lerArquivo("movimentoInvolutario.txt")
        sensor1 = np.array(matriz, dtype=np.float32)
        iniciarTeste(2)
    elif opcao == 3:
        lerArquivo("acidente.txt")
        sensor1 = np.array(matriz, dtype=np.float32)
        iniciarTeste(3)
    elif opcao == 4:
        print("Encerrando...")
    else:
        print('Opção inválida. Tente de novo')
    sleep(2)
