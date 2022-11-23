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
        $trame = "";

        switch ($request->id) {
            case 1:
                $command_name = "Test connectivité";
                $count = 1;
                $trame = "Test|1";
                break;

            case 2:
                $command_name = "Avancer robot";
                $count = 1;
                $trame = "Test|2";
                break;

            case 3:
                $command_name = "Position robot";
                $trame = "Test|3";
                $count = 100;
                break;

            case 4:
                $command_name ="Tourne à droite";
                $count = 1;
                $trame = "BR|1";
                break;

            case 5:
                $command_name ="Avance à gauche";
                $count = 1;
                $trame = "BR|2";
                break;

            case 6:
                $command_name ="Recule à gauche";
                $count = 1;
                $trame = "BR|3";
                break;

            case 7:
                $command_name ="Avance";
                $count = 1;
                $trame = "BR|4";
                break;

            case 8:
                $command_name ="Recule";
                $count = 1;
                $trame = "BR|5";
                break;

            case 9:
                $command_name ="Avance à droite";
                $count = 1;
                $trame = "BR|6";
                break;

            case 10:
                $command_name ="Recule à droite";
                $count = 1;
                $trame = "BR|7";
                break;

            case 11:
                $command_name ="Tourne à gauche";
                $count = 1;
                $trame = "BR|8";
                break;
            case 12:
                $command_name ="Allumage général";
                $count = 1;
                $trame = "Relay|ON";
                break;
            case 13:
                $command_name ="Coupure générale";
                $count = 1;
                $trame = "Relay|OFF";
                break;

            default:
                $command_name = "Commande n°". $request->id ." invalide";
                $count = 1;
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
            //exec($execfile." ".$trame, $output, $retval); // For testing purpose
            if(!empty($output))
                $response[$i] = ["id" => $custom_i, "data" => $output[0], "status" => $retval];

            if($retval != 0)
                $log->state = $retval; // À peut-être modifier à un moment
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

            $icon_state_log = $log->state != 0 ? "🔴" : "🟢";

            $custom_log = "[Le ".$log->created_at->format("d/m/Y")." à ".$log->created_at->format("H:i:s")."]\r\r\t🔵 Commande : ".$log->command_name."\r\t".$icon_state_log." Retour : ".$log->state;
            $custom_log .= "\r\t🔵 Réponse : \r";

            $datas = json_decode($log->response);

            foreach ($datas as $data) {

                $icon_state_data = $data->{"status"} != 0 ? "🟥" : "🟩";

                $custom_log .= "\r\t\t🔷 ID : ".$data->{"id"};
                $custom_log .= "\r\t\t💠 Data : ".$data->{"data"};
                $custom_log .= "\r\t\t".$icon_state_data." Retour : ".$data->{"status"}."\r";
            }

            $current_content = file_get_contents($logfile);
            file_put_contents($logfile, $current_content.$custom_log."\r\r");
        }
        return response()->json(["file" => $logfile], 200);
    }

}
