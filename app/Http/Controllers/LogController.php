<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $command_name = $custom_i = $response = "";
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
            $log->response = $log->response . "                     [".$custom_i."] | " . $output[0] . " | " . $retval . '\r';
            //$log->response[$i] = "[".$custom_i."] | " . $output[0] . " | " . $retval;
            if($retval != 0)
                $log->state = $retval;
        }

        $log->saveOrFail();

        return response()->json(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function process(int $id, int $count, Log $log)
    {
        for($i = 0; $i < $count; $i++){
            exec("C:\laragon\www\interface_maintenance\public\output.exe ".$id, $output, $retval);
            $log->response = $output[0];
            $log->state = $retval;
            $log->saveOrFail();
        }

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
