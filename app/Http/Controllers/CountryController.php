<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Services\CountryService;
use App\Services\CountryImportService;
use Illuminate\Http\Request;
use App\Services\ExchangeRateService;
use App\Services\NewsService;
use App\Services\WorldBankService;
use App\Services\WeatherService;
use App\Services\RiskScoringService;

class CountryController extends Controller
{
    protected $countryService;

    /**
     * Constructor
     */
    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
        set_time_limit(0);
    }

    /**
     * Menampilkan daftar negara
     */
    public function index(Request $request)
{
    $countries = Country::query()

        ->when($request->search,function($query) use($request){

            $query->where('name','like','%'.$request->search.'%')
                  ->orWhere('code','like','%'.$request->search.'%')
                  ->orWhere('region','like','%'.$request->search.'%');

        })

        ->orderBy('name')

        ->paginate(10);

    return view('countries.index',compact('countries'));
}

    /**
     * Sinkronisasi data negara
     */
    public function sync(Request $request)
    {
        $this->countryService->syncCountries();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data negara berhasil diperbarui.']);
        }

        return redirect()
            ->route('countries.index')
            ->with('success', 'Data negara berhasil diperbarui.');
    }

    public function import(Request $request, CountryImportService $service)
    {
        $request->validate([
            'csv' => 'required|file|mimes:csv,txt'
        ]);

        $path = $request->file('csv')->getRealPath();
        $imported = $service->import($path);

        return redirect()
            ->route('countries.index')
            ->with('success', "{$imported} negara berhasil diimport.");
    }

    /**
     * Detail negara
     */
    public function show(Country $country)
{
    $exchangeRate = $country->exchangeRates()
        ->latest('retrieved_at')
        ->first();

    $news = $country->news()
        ->latest('published_at')
        ->take(10)
        ->get();

    $weather = $country->weather;

    $risk = $country->riskScore;

    $watchlist = auth()->user()->watchlists()
        ->where('country_id', $country->id)
        ->first();

    return view(
        'countries.show',
        compact(
            'country',
            'exchangeRate',
            'news',
            'weather',
            'risk',
            'watchlist'
        )
    );
}


    public function syncExchangeRate(Request $request, Country $country, ExchangeRateService $service)
{
    $service->sync($country);

    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Exchange Rate berhasil diperbarui.']);
    }

    return redirect()
        ->route('countries.show', $country)
        ->with('success', 'Exchange Rate berhasil diperbarui.');
}
    
public function syncNews(
    Request $request,
    Country $country,
    NewsService $service
)
{
    $category = $request->category ?? 'economy';

    $service->sync($country, $category);

    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'News berhasil diperbarui.']);
    }

    return redirect()
        ->route('countries.show', $country)
        ->with('success', 'News berhasil diperbarui.');
}

        public function syncWeather(
    Request $request,
    Country $country,
    WeatherService $service
)
{
    $service->sync($country);

    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Weather berhasil diperbarui.']);
    }

    return redirect()
        ->route('countries.show',$country)
        ->with('success','Weather berhasil diperbarui.');
}
    
    public function syncEconomy(
    Request $request,
    Country $country,
    WorldBankService $service
)
{
    $service->sync($country);

    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Data ekonomi berhasil diperbarui.']);
    }

    return back()->with(
        'success',
        'Data ekonomi berhasil diperbarui.'
    );
}
     
    public function calculateRisk(
    Request $request,
    Country $country,
    RiskScoringService $service
)
{
    $service->calculate($country);

    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Risk Score berhasil dihitung.']);
    }

    return redirect()
        ->route('countries.show',$country)
        ->with(
            'success',
            'Risk Score berhasil dihitung.'
        );
}

}