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

        foreach ($logs as $log) {
            file_put_contents($logfile, $log);
        }
        return response()->json(["file" => $logfile], 200);
    }

}
