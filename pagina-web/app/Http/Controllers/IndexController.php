<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;
use App\Models\Log;
use App\Models\DadosLog;
use App\Models\Contato;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\ContatoEmail;
use Illuminate\Support\Facades\Notification;

class IndexController extends Controller
{
    public function index()
    {
        $dadosLog = DadosLog::where('logs_id', 1)->get();
        $contato = User::first();
        return view('index', ['dadosLog' => $dadosLog, 'contato' =>  $contato]);
    }

    public function publishMqtt(Request $request){
        
        $msg = null;

        
        $msg['state']['desired']['reset'] = $request->dado;
    

        $json = json_encode($msg);
        
        $inicio = microtime(true);

        $mqtt = MQTT::connection();
        $mqtt->publish('$aws/things/NodeMCU/shadow/update/accepted', $json);

        if($mqtt == true) {

            $result = [];

            set_time_limit(8);

            $mqtt = MQTT::connection();

            $mqtt->subscribe('$aws/things/NodeMCU/shadow/update', function (string $topic, string $message) use ($mqtt, &$result) {
                $result['topic'] = $topic;
                $result['message'] = $message;

                $mqtt->interrupt();
            });

            $mqtt->loop(true);

            $total = microtime(true) - $inicio;
            
            $message = json_decode($result['message']);

            return response()->json(['message' => 'publicado', 'tempo_de_execucao_ms' => $total], 200);
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

        set_time_limit(8);
        $mqtt->subscribe($topic, function (string $topic, string $message) use ($mqtt, &$result) {
            $result['topic'] = $topic;
            $result['message'] = $message;

            $mqtt->interrupt();
        }, 1);
        $mqtt->loop(true);

        $total = microtime(true) - $inicio;

        $message = json_decode($result['message']);

        if(isset($message->state->report->acidente)) {
            return response()->json(['resultado' => $result, 'tempo_de_execucao_ms' => $total], 200);
        }
        return response()->json(['resultado' => $result], 200);
    }


    public function logPlaca(Request $request) {
        $dataLog = DadosLog::first();

        if($dataLog !== null) {
            if(Carbon::parse($dataLog->created_at)->format('d/m/Y') !== Carbon::now()->format('d/m/Y')) {
                $dataLog = DadosLog::where('created_at', '<', Carbon::now()->subDay())->delete();
            }
        }
        
        if($request->type == 'estado') {
            $estado = $request->dado;

            $dadosLog = new DadosLog();
            $dadosLog->estado = $estado;
            $dadosLog->logs_id = 1;
            $dadosLog->save();

        } else if ($request->type == 'acidente') {
            $contato = User::first();

            Notification::send($contato, new ContatoEmail($request));

            $acidente = $request->dado;
            $state = $request->estado;
            $estado = null;

            if($state == 'Online') {
                $estado = 'CONECTADO';
            } else {
                $estado = 'DESCONECTADO';
            }

            $dadosLog = new DadosLog();
            $dadosLog->estado = $estado;
            $dadosLog->acidente = $acidente;
            $dadosLog->logs_id = 1;
            $dadosLog->save();
        }
    

        $log = DadosLog::where('logs_id', 1)->get();

        return response()->json(["log" => $log], 200);
    }

    public function contatoAtualizar(Request $request) {
        $contato = User::first();

        if($contato !== null) {
            $contato->name = $request->dado[0]['value'];
            $contato->email = $request->dado[1]['value'];
            $contato->save();
        } else {
            $contato = new User();
            $contato->name = $request->dado[0]['value'];
            $contato->email = $request->dado[1]['value'];
            $contato->save();
        }
        
        return response()->json(["contato" => $contato], 200);
    }
}