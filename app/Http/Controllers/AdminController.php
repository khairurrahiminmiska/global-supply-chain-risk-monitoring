<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Port;
use App\Models\Article;
use App\Models\Country;
use App\Models\News;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'ports' => Port::count(),
            'articles' => Article::count(),
            'countries' => Country::count(),
            'news' => News::count(),
        ];

        $latestUsers = User::latest()->take(5)->get();

        return view('admin.index', compact('stats', 'latestUsers'));
    }

    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function userDestroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    public function ports()
    {
        $ports = Port::with('country')->latest()->paginate(15);
        return view('admin.ports', compact('ports'));
    }

    public function portDestroy(Port $port)
    {
        $port->delete();

        return redirect()->route('admin.ports')->with('success', 'Port deleted successfully.');
    }
}
