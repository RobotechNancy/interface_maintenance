<?php

namespace App\Http\Controllers;

error_reporting(E_ALL);

use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Arr;

class LogController extends Controller
{

    public function get_logtable_size(){

        $nb_logs = Log::get()->count();

        return $nb_logs;
    }

    public function relais(){
        $execfile = env('CUSTOM_EXECFILE');
        $trame = "Relais,Test";

        exec($execfile." ".$trame, $output, $retval);

        if($retval == 0)
            return true;

        return false;
    }

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
        $count = 1;
        $trame = "";

        switch ($request->id) {
            case 1:
                $command_name = "Test odométrie";
                $trame = "TestComm,Odo";
                break;

            case 2:
                $command_name = "Test base roulante";
                $trame = "TestComm,BR";
                break;

            case 3:
                $command_name = "Test xbee";
                $trame = "TestComm,XB";
                $count = 100;
                break;

            case 4:
                $command_name = "Tourne à droite";
                $trame = "BR,".$request->distance.",".$request->vitesse.",RotD";
                break;

            case 5:
                $command_name = "Avance à gauche";
                $trame = "BR,".$request->distance.",".$request->vitesse.",AvG";
                break;

            case 6:
                $command_name = "Recule à gauche";
                $trame = "BR,".$request->distance.",".$request->vitesse.",ReG";
                break;

            case 7:
                $command_name = "Avance";
                $trame = "BR,".$request->distance.",".$request->vitesse.",Av";
                break;

            case 8:
                $command_name = "Recule";
                $trame = "BR,".$request->distance.",".$request->vitesse.",Re";
                break;

            case 9:
                $command_name = "Avance à droite";
                $trame = "BR,".$request->distance.",".$request->vitesse.",AvD";
                break;

            case 10:
                $command_name = "Recule à droite";
                $trame = "BR,".$request->distance.",".$request->vitesse.",ReD";
                break;

            case 11:
                $command_name = "Tourne à gauche";
                $trame = "BR,".$request->distance.",".$request->vitesse.",RotG";
                break;

            case 12:
                $command_name = "Allumage général";
                $trame = "Relais,ON";
                break;

            case 13:
                $command_name = "Coupure générale";
                $trame = "Relais,OFF";
                break;

            default:
                $command_name = "Commande n°". $request->id ." invalide";
                break;

        }

        $log = new Log;
        $log->command_name = $command_name;
        $log->state = 0;

        for($i = 0; $i < $count; $i++){

            $custom_i = ($i < 10) ? "0".strval($i) : strval($i);

            $execfile = env('CUSTOM_EXECFILE');
            $execoutput = env('CUSTOM_EXEC_OUTPUT');

            exec($execfile." ".$trame." > ".$execoutput, $output, $retval);

            $handle = fopen($execoutput, "r");

            $contents = fread($handle, filesize($execoutput));
            $content_table = explode("\n",$contents);

            fclose($handle);

            if (FALSE !== $handle)
            {
                $response[$i] = ["id" => $custom_i, "data" => "", "status" => $retval, "status_description" => $content_table[0], "trame_can_env" => "", "trame_can_rec" => "", "trame_php" => ""];

                $trame_php_array = explode(",", $trame);

                if(count($trame_php_array) == 2){

                    $trame_php = json_encode(["commande" => $trame_php_array[0], "arg" => $trame_php_array[1]], JSON_UNESCAPED_SLASHES);

                }else if(count($trame_php_array) == 4){

                    $trame_php = json_encode(["commande" => $trame_php_array[0],
                                              "distance" => $trame_php_array[1],
                                              "vitesse" => $trame_php_array[2],
                                              "direction" => $trame_php_array[3]], JSON_UNESCAPED_SLASHES);
                }else{
                    $trame_php = "Trame corrompue ou incorrecte";
                }

                $response[$i]["trame_php"] = $trame_php;

                if(count($content_table) >= 2) {
                    $response[$i]["status_description"] = $content_table[count($content_table)-2];

                    $trame_can_env_array = explode(" : ",$content_table[0]);
                    array_splice($trame_can_env_array, 0, 2);

                    for($j = 0; $j < count($trame_can_env_array); $j++){
                        $trame_can_env_decoupe = explode(" ",$trame_can_env_array[$j]);
                        $trame_can_env_array[$j] = $trame_can_env_decoupe[0];

                        if($j == 6){
                            $trame_can_env_array[$j] = str_replace("[", "", $trame_can_env_array[$j]);
                            $trame_can_env_array[$j] = str_replace("]", "", $trame_can_env_array[$j]);
                        }
                    }

                    $response[$i]["trame_can_env"] = json_encode(["addr" => "COUOUC",
                                                                  "emetteur" => "COUCOU",
                                                                  "code_fct" => $trame_can_env_array[2],
                                                                  "id_msg" => $trame_can_env_array[3],
                                                                  "is_rep" => $trame_can_env_array[4],
                                                                  "id_rep" => $trame_can_env_array[5],
                                                                  "data" => $trame_can_env_array[6]
                                                                ]);


                    if(count($content_table) > 4){

                        $trame_can_rec_array = explode(" : ",$content_table[2]);
                        array_splice($trame_can_rec_array, 0, 2);

                        for($j = 0; $j < count($trame_can_rec_array); $j++){
                            $trame_can_rec_decoupe = explode(" ",$trame_can_rec_array[$j]);
                            $trame_can_rec_array[$j] = $trame_can_rec_decoupe[0];

                            if($j == 5){
                                $trame_can_rec_array[$j] = str_replace("[", "", $trame_can_rec_array[$j]);
                                $trame_can_rec_array[$j] = str_replace("]", "", $trame_can_rec_array[$j]);
                            }
                        }

                        $response[$i]["trame_can_rec"] = json_encode(["addr" => $trame_can_rec_array[0],
                                                                    "emetteur" => $trame_can_rec_array[1],
                                                                    "code_fct" => $trame_can_rec_array[2],
                                                                    "is_rep" => $trame_can_rec_array[3],
                                                                    "id_rep" => $trame_can_rec_array[4],
                                                                    "data" => $trame_can_rec_array[5]
                                                                    ], JSON_UNESCAPED_SLASHES);
                    }
                }

                if($retval != 0) $log->state = $retval;
            }
            else
            {
                $response[$i] = ["id" => $custom_i, "data" => "", "status" => 255, "status_description" => "Impossible d'accéder au fichier de logs", "trame_can_env" => "", "trame_can_rec" => "", "trame_php" => $trame];
                $log->state = 255;
            }
        }

        $log->response = json_encode($response, );

        if($log->state == 1)
            return response()->json(["file" => $execfile, "exception" => "Fichier non trouvé", "message" => "Le fichier exécutable n'a pas été trouvé", "line" => 57], 404);

        $log->saveOrFail();
        return response()->json(["status" => 200, "rep" => json_decode($log->response)]);
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

            $datas = json_decode($log->response, true);

            foreach ($datas as $data) {

                if(isset($data["trame_can_env"]) && !empty($data["trame_can_env"])){
                    $trame_can_env = json_decode($data["trame_can_env"], true);
                    $trame_can_env_str = $trame_can_env["addr"].",".$trame_can_env["emetteur"].",".$trame_can_env["code_fct"].",".$trame_can_env["id_msg"].",".$trame_can_env["is_rep"].",".$trame_can_env["id_rep"].",".$trame_can_env["data"];
                }

                if(isset($data["trame_can_rec"]) && !empty($data["trame_can_rec"])){
                    $trame_can_rec = json_decode($data["trame_can_rec"], true);
                    $trame_can_rec_str = $trame_can_rec["addr"].",".$trame_can_rec["emetteur"].",".$trame_can_rec["code_fct"].",".$trame_can_rec["is_rep"].",".$trame_can_rec["id_rep"].",".$trame_can_rec["data"];
                }

                $trame_php_env = json_decode($data["trame_php"], true);
                $trame_php_env_str = (isset($trame_php_env["arg"])) ? $trame_php_env["commande"].",".$trame_php_env["arg"] : $trame_php_env["commande"].",".$trame_php_env["distance"].",".$trame_php_env["vitesse"].",".$trame_php_env["direction"];

                $icon_state_data = $data["status"] != 0 ? "🟥" : "🟩";

                $custom_log .= "\r\t\t🔷 ID : ".$data["id"];
                $custom_log .= "\r\t\t💠 Data : ".$data["data"];
                $custom_log .= "\r\t\t".$icon_state_data." Retour : ".$data["status"]."\r";

                if(isset($trame_can_env_str))
                $custom_log .= "\r\t\t🔷 Trame CAN envoyée : ".$trame_can_env_str;

                if(isset($trame_can_rec_str))
                $custom_log .= "\r\t\t🔷 Trame CAN reçue : ".$trame_can_rec_str;
                
                $custom_log .= "\r\t\t🔷 Trame PHP envoyée : ".$trame_php_env_str;
            }

            $current_content = file_get_contents($logfile);
            file_put_contents($logfile, $current_content.$custom_log."\r\r");
        }
        return response()->json(["file" => $logfile], 200);
    }

}
