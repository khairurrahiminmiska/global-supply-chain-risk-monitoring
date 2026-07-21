<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PortImportService;

class PortController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([

            'csv' => 'required|file|mimes:csv,txt'

        ]);

        $path = $request->file('csv')->getRealPath();

        app(PortImportService::class)->import($path);

        return back()->with('success','World Port Dataset berhasil diimport.');
    }
}