<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Services\CountryService;
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
    public function sync()
    {
        $this->countryService->syncCountries();

        return redirect()
            ->route('countries.index')
            ->with('success', 'Data negara berhasil diperbarui.');
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

    return view(
        'countries.show',
        compact(
            'country',
            'exchangeRate',
            'news',
            'weather',
            'risk'
        )
    );
}


    public function syncExchangeRate(Country $country, ExchangeRateService $service)
{
    $service->sync($country);

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

    return redirect()
        ->route('countries.show', $country)
        ->with('success', 'News berhasil diperbarui.');
}

        public function syncWeather(
    Country $country,
    WeatherService $service
)
{
    $service->sync($country);

    return redirect()
        ->route('countries.show',$country)
        ->with('success','Weather berhasil diperbarui.');
}
    
    public function syncEconomy(
    Country $country,
    WorldBankService $service
)
{
    $service->sync($country);

    return back()->with(
        'success',
        'Data ekonomi berhasil diperbarui.'
    );
}
     
    public function calculateRisk(
    Country $country,
    RiskScoringService $service
)
{
    $service->calculate($country);

    return redirect()
        ->route('countries.show',$country)
        ->with(
            'success',
            'Risk Score berhasil dihitung.'
        );
}

}