import serial
import numpy as np
import keyboard
from time import sleep

opcao = 0
possibilidade1 = np.array([[-0.0088705, 9.357309341, 2.323247433,
                   -0.008248, -0.043591999, -0.004061]])

# possibilidade1 = '-0.0088705, 9.357309341, 2.323247433,-0.008248, -0.043591999, -0.004061 | -0.0088705, 9.357309341, 2.323247433,-0.008248, -0.043591999, -0.004061 '
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
            TamPac = DadosTx[3]
            for i in range(TamPac):
                DadoTxByte = bytes((DadosTx[i],))

                self.PortaCom.write(DadoTxByte)
                print(DadoTxByte)

        except Exception:
            print("Erro Escrita")

    def Leitura_Serial(self, DadosRx):

        LeituraSerial = [0] * 200

        for i in range(200):

            if (self.PortaCom.in_waiting > 0):
                LeituraSerial[i] = self.PortaCom.read()
                LeituraSerial[i] = self.ByteToInt(LeituraSerial[i])
                print(LeituraSerial[i])

            else:
                break


# DadosTx = '[1,2,3,4,5,6,7,8,9,10]'.encode('utf-8')
# DadosRx = [0] * 100
# PortaCom = Comunicacao()
# PortaCom.SerialInit('COM4', 115200, 1, 1)
# PortaCom.WriteSerial(DadosTx)

# for i in np.nditer(possibilidade1):
#   print(i)

while opcao != 5:
    print('\n MENU:')
    print('[1] Teste 1 Movimento normal')
    print('[2] Teste 2 Acidente com Queda e Deslizamento')
    print('[3] Teste 3 Acidente Projeção da Pessoa')
    print('[4] Teste 3 Acidente Choque e Parada Estantânea')
    print('[5] Sair')
    opcao = int(input('Escolha a opção de teste: '))

    if opcao == 1:
        while True:
            if keyboard.is_pressed('q'):
                print("\nFim da execução do Teste 1")
                break
    elif opcao == 2:
        while True:
            if keyboard.is_pressed('q'):
                print("\nFim da execução do Teste 2")
                break
    elif opcao == 3:
        while True:
            if keyboard.is_pressed('q'):
                print("\nFim da execução do Teste 3")
                break
    elif opcao == 4:
        while True:
            if keyboard.is_pressed('q'):
                print("\nFim da execução do Teste 4")
                break
    elif opcao == 5:
        print("Encerrando...")
    else:
        print('Opção inválida. Tente de novo')
    sleep(2)


# ser = serial.Serial()
# ser.baudrate = 115200
# ser.port = 'COM4'
# ser.open()
# values = "Ola Mundo".encode('utf-8')
# # values = bytearray([4, 9, 62, 144, 56, 30, 147, 3, 210, 89, 111, 78, 184, 151, 17, 129])
# ser.write(values)
#
# total = 0
#
# while total < len(values):
#     print
#     ord(ser.read(1))
#     total = total + 1
#
# ser.close()