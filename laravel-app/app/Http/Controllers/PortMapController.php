<?php

namespace App\Http\Controllers;

use App\Models\Port;

class PortMapController extends Controller
{

    public function index()
    {

        $ports = Port::all();

        return view('ports.map', compact('ports'));

    }

}