<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Arr;

class LogController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $command_name = $custom_i = "";
        $response = [];
        $output = $retval = null;
        $count = 0;

        switch ($request->id) {
            case 1:
                $command_name = "Test connectivité";
                $count = 1;
                break;

            case 2:
                $command_name = "Avancer robot";
                $count = 1;
                break;

            case 3:
                $command_name = "Position robot";
                $count = 100;
                break;

            case 4:
                $command_name ="Tourne à droite";
                $count = 1;
                break;

            case 5:
                $command_name ="Avance à gauche";
                $count = 1;
                break;

            case 6:
                $command_name ="Recule à gauche";
                $count = 1;
                break;

            case 7:
                $command_name ="Avance";
                $count = 1;
                break;

            case 8:
                $command_name ="Recule";
                $count = 1;
                break;

            case 9:
                $command_name ="Avance à droite";
                $count = 1;
                break;

            case 10:
                $command_name ="Recule à droite";
                $count = 1;
                break; 

            case 11:
                $command_name ="Tourne à gauche";
                $count = 1;
                break;
                

            default:
                $command_name = "Commande invalide";
                $count = 0;
                break;
            
        }

        $log = new Log;
        $log->command_name = $command_name;
        $log->state = 0;

        for($i = 0; $i < $count; $i++){
            if($i < 10)
                $custom_i = "0".strval($i);
            else
                $custom_i = strval($i);

            $execfile = env('CUSTOM_EXECFILE');
            exec($execfile." ".$request->id, $output, $retval);
            if(!empty($output))
                $response[$i] = ["id" => $custom_i, "data" => $output[0], "status" => $retval];

            if($retval != 0)
                $log->state = $retval;
        }
        $log->response = json_encode($response);

        if($log->state == 1)
            return response()->json(["file" => $execfile, "exception" => "Fichier non trouvé", "message" => "Le fichier exécutable n'a pas été trouvé", "line" => 57], 404);

        $log->saveOrFail();

            return response()->json(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clear()
    {
        Log::truncate();
        return response()->json(200);
    }

    public function export()
    {
        $logfile = env('CUSTOM_LOGFILE');
        $logs = Log::orderBy('id', 'desc')->get();
        $current_content = "";
        file_put_contents($logfile, "");

        foreach ($logs as $log) {
            $custom_log = "[Le ".$log->created_at->format("d/m/Y")." à ".$log->created_at->format("H:i:s")."]\r\r\t-> Commande : ".$log->command_name."\r\t-> Retour : ".$log->state;
            $custom_log .= "\r\t-> Réponse : \r";

            $datas = json_decode($log->response);

            foreach ($datas as $data) {

                $custom_log .= "\r\t\t-> ID : ".$data->{"id"};
                $custom_log .= "\r\t\t-> Data : ".$data->{"data"};
                $custom_log .= "\r\t\t-> Retour : ".$data->{"status"}."\r";
            }

            $current_content = file_get_contents($logfile);
            file_put_contents($logfile, $current_content.$custom_log."\r\r");
        }
        return response()->json(["file" => $logfile], 200);
    }

}
