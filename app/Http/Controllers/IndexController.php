<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;
//use Salman\Mqtt\MqttClass\Mqtt;
use App\Models\Month;
use App\Models\ConsumptionMonth;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function publishMqtt(Request $request){
        
        $msg = null;

        if($request->type == 'acionamento') {
            $msg['state']['desired']['status_LED'] = $request->dado;
            
        } else if($request->type == 'hora_agendada') {

            if(!isset($request->dado[0]['value'])) {
                return response()->json(['error'=>'invalid-fields']);
            }

            $aux = explode(":", $request->dado[0]['value']);

            $msg['state']['desired']['time'] = array([ 
                    'status_LED' => $request->dado[1]['value'], 
                    'hour' => $aux[0],
                    'minute' => $aux[1],
            ]);
        
        } else if($request->type == 'temporizador') {

            $msg['state']['desired']['timer']['status_LED'] = $request->dado;
        }

        $json = json_encode($msg);
        
        $inicio = microtime(true);

        $mqtt = MQTT::connection();
        $mqtt->publish('$aws/things/NodeMCU/shadow/update/accepted', $json);

        if($mqtt == true) {

            $result = [];

            set_time_limit(5);

            $mqtt = MQTT::connection();

            $mqtt->subscribe('$aws/things/NodeMCU/shadow/update', function (string $topic, string $message) use ($mqtt, &$result) {
                $result['topic'] = $topic;
                $result['message'] = $message;

                $mqtt->interrupt();
            });

            $mqtt->loop(true);

            $total = microtime(true) - $inicio;
            
            $message = json_decode($result['message']);

            return response()->json(['message' => 'publicado', 'resultado' => $result, 'tempo_de_execucao_ms' => $total], 200);
        } else {
            return response()->json('Falha na publicação', 200);
        }
    }

    public function republishMqtt(Request $request){

        $msg = null;

        if($request->type == 'acionamento') {
            $msg['state']['desired']['status_LED'] = $request->dado;
            
        } else if($request->type == 'hora_agendada') {

            $aux = explode(":", $request->dado[0]['value']);

            $msg['state']['desired']['time'] = array([ 
                    'status_LED' => $request->dado[1]['value'], 
                    'hour' => $aux[0],
                    'minute' => $aux[1],
            ]);
        
        } else if($request->type == 'temporizador') {

            $msg['state']['desired']['timer']['status_LED'] = $request->dado;
        }
       
        
        $json = json_encode($msg);
        
        $mqtt = MQTT::connection();
        $mqtt->publish('$aws/things/NodeMCU/shadow/update', $json);

        if($mqtt == true) {
            return response()->json(['message' => 'Publicação para atualizar Shadow Device'], 200);
        } else {
            return response()->json('Falha na publicação', 200);
        }
        
    }

    public function subscribeMqtt(Request $request){

        $topic = $request->topic;

        $inicio = microtime(true);
        
        $mqtt = MQTT::connection();
        $mqtt->publish('$aws/things/NodeMCU/shadow/get', '');
        $result = [];

        set_time_limit(5);
        $mqtt->subscribe($topic, function (string $topic, string $message) use ($mqtt, &$result) {
            $result['topic'] = $topic;
            $result['message'] = $message;

            $mqtt->interrupt();
        }, 1);
        $mqtt->loop(true);

        $total = microtime(true) - $inicio;

        $message = json_decode($result['message']);

        if(isset($message->state->report->tempo_consumo)) {
            return response()->json(['resultado' => $result, 'tempo_de_execucao_ms' => $total], 200);
        }
        return response()->json(['resultado' => $result], 200);
    }


    public function calConsumo(Request $request) {

        Carbon::setUTF8(true);

        $tempo_consumo = $request->tempo_consumo;

        $horas = $tempo_consumo / 3600;
        $consumo = (10.0 * ($horas * 30)) / 1000;

        $valor = ($consumo * 0.30); 

        $date = Carbon::now();

        $mes = ucfirst($date->formatLocalized('%B'));

        $month = Month::where('nome', $mes)->first();

        if($month !== null) {
            $consumption = ConsumptionMonth::where('id', $month->consumption_months_id)->first();
    
            
            if($consumption !== null) {

                $consumption->consumo +=  $consumo;
                $consumption->valor += $valor;
                $consumption->save();

                return response()->json(["mes" => $month->id, "consumo_dados" => $consumption], 200);

            } else if($consumption == null) {
                $consumption = new ConsumptionMonth();
                $consumption->consumo = $consumo;
                $consumption->valor = $valor;
                $consumption->save();

                $month->consumption_months_id = $consumption->id;
                $month->save();
                return response()->json(["mes" => $month->id, "consumo_dados" => $consumption], 200);
            }
        }
    }
}