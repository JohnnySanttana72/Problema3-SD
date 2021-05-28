import json
import boto3
import datetime
import dateutil.tz
import time
# timestamp2 = datetime.datetime.utcnow().strftime('%Y-%m-%dT%H:%M:%S.%f')

# eastern = dateutil.tz.gettz('America/Sao_Paulo')
# datetime.datetime.now(tz=eastern)

client = boto3.client('iot-data')


def lambda_handler(event, context):
     
    statusCode = 200
     
    if event['httpMethod'] == 'GET':
        resposta = estadoPlaca()
    else:
        statusCode = 400
    
    
    return {
        "statusCode": statusCode,
        "headers": {'Content-Type': 'application/json', 'Access-Control-Allow-Origin': '*'},
        "body": json.dumps({"estado": resposta })
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
