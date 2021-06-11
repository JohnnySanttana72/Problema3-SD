import boto3
import json
import random
import urllib3



# ------- Skill specific business logic -------

SKILL_NAME = "Monitoramento"
url_api = 'https://g84sc7hsu1.execute-api.us-east-1.amazonaws.com/monitoramento'

# Make sure you use question marks or periods.

def lambda_handler(event, context):
    """
    Route the incoming request based on type (LaunchRequest, IntentRequest, etc).
    The JSON body of the request is provided in the event parameter.
    """
    print("event.session.application.applicationId=" +
          event['session']['application']['applicationId'])
    print("event:" + json.dumps(event))

    if event['session']['new']:
        on_session_started({'requestId': event['request']['requestId']},
                           event['session'])

    if event['request']['type'] == "LaunchRequest":
        return on_launch(event['request'], event['session'])
    elif event['request']['type'] == "IntentRequest":
        return on_intent(event['request'], event['session'])
    elif event['request']['type'] == "SessionEndedRequest":
        return on_session_ended(event['request'], event['session'])


def on_session_started(session_started_request, session):
    """Called when the session starts."""
    print("on_session_started requestId=" +
          session_started_request['requestId'] + ", sessionId=" +
          session['sessionId'])


def on_launch(launch_request, session):
    """Called when the user launches the skill without specifying what they want."""
    print("on_launch requestId=" + launch_request['requestId'] +
          ", sessionId=" + session['sessionId'])
    # Dispatch to your skill's launch
    return get_welcome_response()


def on_intent(intent_request, session):
    """Called when the user specifies an intent for this skill."""
    print("on_intent requestId=" + intent_request['requestId'] +
          ", sessionId=" + session['sessionId'])

    intent = intent_request['intent']
    intent_name = intent_request['intent']['name']

   
    # Dispatch to your skill's intent handlers
    print("***********************intent section***************************")
    print(intent_name)
    if intent_name == "EstadoIntent":
        return handle_estado_request(intent, session)
    elif intent_name == "ConfiguracaoIntent":
        return handle_configuracao_request(intent, session)
    elif intent_name == "DefinirTempoIntent":
        return handle_definirTempoIntent_request(intent, session)
    elif intent_name == "AMAZON.HelpIntent":
        return handle_get_help_request(intent, session)
    elif intent_name == "AMAZON.StopIntent":
        return handle_finish_session_request(intent, session)
    elif intent_name == "AMAZON.CancelIntent":
        return handle_finish_session_request(intent, session)
    else:
        raise ValueError("Invalid intent")


def on_session_ended(session_ended_request, session):
    """
    Called when the user ends the session.
    Is not called when the skill returns should_end_session=true
    """
    print("on_session_ended requestId=" + session_ended_request['requestId'] +
          ", sessionId=" + session['sessionId'])
    # add cleanup logic here

# --------------- Functions that control the skill's behavior -------------


def get_welcome_response():
    """Se quiséssemos inicializar a sessão para ter alguns atributos, poderíamos adicioná-los aqui."""
    intro = ("Estou pronta, pode falar!") 
    should_end_session = False

    speech_output = intro 
    reprompt_text = intro
    attributes = {"speech_output": speech_output,
                  "reprompt_text": speech_output
                  }

    return build_response(attributes, build_speechlet_response(
        SKILL_NAME, speech_output, reprompt_text, should_end_session))



def handle_estado_request(intent, session):
    attributes = {}
    should_end_session = False
    user_gave_up = intent['name']
    # speech_output = ("Tudo bem, irei verificar!")
    reprompt_text = "Você não quer saber quem você realmente é, basta perguntar {}".format(SKILL_NAME)
    
    http = urllib3.PoolManager()
    
    speech_output=("Tudo bem, irei verificar......")
    
    # resposta = random.choice(status_device)
    resposta = http.request('GET', url_api + '/estado')
    json_dados = json.loads(resposta.data.decode('utf-8'))

    
    estado = json_dados['estado']
    
    speech_output += ("certo, deixa eu ver, o estado atual da placa é "+ estado)
    
    print(speech_output)
    
    return build_response(
            {},
            build_speechlet_response(
                SKILL_NAME, speech_output, reprompt_text, should_end_session
            ))
 
            
def handle_configuracao_request(intent, session):
    attributes = {}
    should_end_session = False
    user_gave_up = intent['name']
    reprompt_text = "Você não quer saber quem você realmente é, basta perguntar {}".format(SKILL_NAME)
    
    
    speech_output=("Qual o intervalo em minutos que você deseja definir para a notificação?")
    
    print(speech_output)
    
    return build_response(
            {},
            build_speechlet_response(
                SKILL_NAME, speech_output, reprompt_text, should_end_session
            ))
            

def handle_definirTempoIntent_request(intent, session):
    attributes = {}
    should_end_session = False
    user_gave_up = intent['name']
    reprompt_text = "Você não quer saber quem você realmente é, basta perguntar {}".format(SKILL_NAME)
    
    tempo=intent['slots']['tempo']['value']
    
    http = urllib3.PoolManager()
    
    # resposta = random.choice(status_device)
    resposta = http.request('POST', url_api + '/configurar-tempo?tempo=' + tempo)
    json_dados = json.loads(resposta.data.decode('utf-8'))
    
    speech_output=("Pronto, o tempo de notificação definido é de " + tempo + " minutos")
    
    print(speech_output)
    
    return build_response(
            {},
            build_speechlet_response(
                SKILL_NAME, speech_output, reprompt_text, should_end_session
            ))

def handle_get_help_request(intent, session):
    attributes = {}
    speech_output = "O nome da sua skill é!".format(SKILL_NAME)
    reprompt_text = "what can I help you with?"
    should_end_session = False
    return build_response(
        attributes,
        build_speechlet_response(SKILL_NAME, speech_output, reprompt_text, should_end_session)
    )


def handle_finish_session_request(intent, session):
    """End the session with a message if the user wants to quit the app."""
    #attributes = session['attributes']
    attributes=""
    reprompt_text = None
    speech_output = "Thanks for using {}. Have a Great Day.".format(SKILL_NAME)
    should_end_session = True
    return build_response(
        attributes,
        build_speechlet_response_without_card(speech_output, reprompt_text, should_end_session)
    )



# --------------- Helpers that build all of the responses -----------------

def build_speechlet_response(title, output, reprompt_text, should_end_session):
    return {
        'outputSpeech': {
            'type': 'PlainText',
            'text': output
        },
        'card': {
            'type': 'Simple',
            'title': title,
            'content': output
        },
        'reprompt': {
            'outputSpeech': {
                'type': 'PlainText',
                'text': reprompt_text
            }
        },
        'shouldEndSession': should_end_session
    }


def build_speechlet_response_without_card(output, reprompt_text, should_end_session):
    return {
        'outputSpeech': {
            'type': 'PlainText',
            'text': output
        },
        'reprompt': {
            'outputSpeech': {
                'type': 'PlainText',
                'text': reprompt_text
            }
        },
        'shouldEndSession': should_end_session
    }


def build_response(attributes, speechlet_response):
    return {
        'version': '1.0',
        'sessionAttributes': attributes,
        'response': speechlet_response
    }
