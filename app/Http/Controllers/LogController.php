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
        $command_name = $response = "";
        $output = $retval = null;

        switch ($request->id) {
            case 1:
                $command_name = "Test connectivité";
                break;

            case 2:
                $command_name = "Avancer robot";
                break;

            case 3:
                $command_name = "Position robot";
                break;

            default:
                $command_name = "Commande invalide";
                break;
        }

        exec("C:\laragon\www\interface_maintenance\public\output.exe ".$request->id, $output, $retval);

        $task = new Log;
        $task->command_name = $command_name;
        $task->response = $output[0];
        $task->state = $retval;
        $task->saveOrFail();

        return response()->json(array('command_name' => $command_name, 'response' => $response), 200);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
