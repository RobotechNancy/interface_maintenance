<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RelaisController extends Controller
{
    /**
     * Check the state of the emergency relay.
     *
     * @return true if relay status is ON
     * @return false if relay status is OFF
     */
    public function relaisStatus(bool $test = false) : mixed
    {
        $id_service_web = config("app.id_service_web");
        
        if($test == true)
        {
            return $id_service_web["Relais arrêt d'urgence"];
        }

        $execfile = env('CUSTOM_EXECFILE');
        $trame = "Relais,Test";

        exec($execfile." ".$trame, $output, $retval);

        if($retval == 0)
            return true;

        return false;
    }
}
