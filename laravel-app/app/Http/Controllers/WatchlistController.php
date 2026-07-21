<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Watchlist;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function index()
    {
        $watchlists = auth()->user()->watchlists()
            ->with('country')
            ->latest()
            ->paginate(12);

        return view('watchlist.index', compact('watchlists'));
    }

    public function store(Request $request, Country $country)
    {
        $exists = Watchlist::where('user_id', auth()->id())
            ->where('country_id', $country->id)
            ->exists();

        if ($exists) {
            return back()->with('info', 'Negara sudah ada di watchlist.');
        }

        Watchlist::create([
            'user_id' => auth()->id(),
            'country_id' => $country->id,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Negara ditambahkan ke watchlist.']);
        }

        return back()->with('success', 'Negara ditambahkan ke watchlist.');
    }

    public function destroy(Request $request, Watchlist $watchlist)
    {
        abort_if($watchlist->user_id !== auth()->id(), 403);

        $watchlist->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Negara dihapus dari watchlist.']);
        }

        return back()->with('success', 'Negara dihapus dari watchlist.');
    }
}
