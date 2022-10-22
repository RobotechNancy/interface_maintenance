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
            exec("C:\laragon\www\interface_maintenance\public\output.exe ".$request->id, $output, $retval);
            $response[$i] = ["id" => $custom_i, "data" => $output[0], "status" => $retval];
            if($retval != 0)
                $log->state = $retval;
        }
        $log->response = json_encode($response);

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

}
