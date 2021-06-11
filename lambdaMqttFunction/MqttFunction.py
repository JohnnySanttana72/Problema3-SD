import json
import boto3
import datetime
import dateutil.tz
import time
from botocore.exceptions import ClientError
from boto3.dynamodb.conditions import Key
from decimal import Decimal
# timestamp2 = datetime.datetime.utcnow().strftime('%Y-%m-%dT%H:%M:%S.%f')

# eastern = dateutil.tz.gettz('America/Sao_Paulo')
# datetime.datetime.now(tz=eastern)

client = boto3.client('iot-data')

# Obtem o recurso de serviço.
dynamoRes = boto3.resource('dynamodb', region_name='us-east-1')

# recupera uma tabela existente.
tabela = dynamoRes.Table('monitoramento_db')

class DecimalEncoder(json.JSONEncoder):
    def default(self, obj):
        if isinstance(obj, Decimal):
            return float(obj)
        return json.JSONEncoder.default(self, obj)


def lambda_handler(event, context):
     
    statusCode = 200
    resposta = None
     
    if event['httpMethod'] == 'GET':
        if 'estado' in str(event['path']):
            #   resposta = json.dumps({"estado": 'Aqui Estado' })
            resposta = json.dumps({"estado": estadoPlaca() })
        elif 'recuperar-tempo' in str(event['path']):
            
            resposta = json.dumps(recuperarTempo(),cls=DecimalEncoder)
    elif event['httpMethod'] == 'POST':
         tempo = event['queryStringParameters']['tempo']
         
         resposta = json.dumps({"configuracao-tempo": salvarTempo(tempo) })
    else:
        statusCode = 400
    
    
    return {
        "statusCode": statusCode,
        "headers": {'Content-Type': 'application/json', 'Access-Control-Allow-Origin': '*'},
        "body": resposta
    }
    
    # status_LED = event['status_Led']
    # TODO implement
    # temp = 72
    
   
    
def estadoPlaca():
    
    response_publish = client.publish(
        topic = '$aws/things/NodeMCU/shadow/update/accepted',
        qos = 0,
        payload = json.dumps({"state": {"desired": { "estado": "verificar estado"}}})
    )
    
    time.sleep(3)
    
    response_shadow = client.get_thing_shadow(
        thingName='NodeMCU',
    )
    
    
    streamingBody = response_shadow["payload"]
    jsonState = json.loads(streamingBody.read())
    
    # timestamp_atual = int(datetime.datetime.now(tz=eastern).timestamp())
    
    print(jsonState)
    
    # print(timestamp_atual)
    
    try:
        estado = jsonState['state']['reported']['estado']
        print(jsonState['state']['reported']['estado'])
    except KeyError:
        estado = 'DESCONECTADO'
        print('DESCONECTADO')
        
    resposta  =  client.update_thing_shadow ( 
        thingName = 'NodeMCU' , 
        payload = json.dumps({"state": {"reported": { "estado": None }}})
    )
    
    return estado;

def salvarTempo(tempo):
    
    scan = tabela.scan(
        ProjectionExpression='#k',
        ExpressionAttributeNames={
            '#k': 'id'
        }
    )
    
    with tabela.batch_writer() as batch:
        for each in scan['Items']:
            batch.delete_item(Key=each)
    
    tabela.put_item(
            Item={
                'id': 1,
                'tempo': tempo,
            })
    
    return 'Tempo para a notificação salvo'
    
    
def recuperarTempo():
    
    try:
        response = tabela.get_item(
            Key={
                'id' : 1,
            }
        )
        response = tabela.get_item(Key={'id': 1})
    except ClientError as e:
        print(e.response['Error']['Message'])
    else:
        return response['Item']
    
    

    