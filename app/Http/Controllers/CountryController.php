<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Services\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected $countryService;

    /**
     * Dependency Injection
     */
    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    /**
     * Menampilkan daftar negara
     */
    public function index()
    {
        $countries = Country::orderBy('name')->get();

        return view('countries.index', compact('countries'));
    }

    /**
     * Sinkronisasi data dari API
     */
    public function sync()
    {
        $this->countryService->syncCountries();

        return redirect()
            ->route('countries.index')
            ->with('success', 'Data negara berhasil diperbarui dari API.');
    }
}