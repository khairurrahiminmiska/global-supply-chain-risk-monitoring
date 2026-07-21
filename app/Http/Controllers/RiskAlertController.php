<?php

namespace App\Http\Controllers;

use App\Models\RiskAlert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiskAlertController extends Controller
{
    public function index(Request $request): View
    {
        $query = RiskAlert::with('country')
            ->latest('triggered_at');

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            }

            if ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        $alerts = $query
            ->paginate(10)
            ->withQueryString();

        $totalAlerts = RiskAlert::count();

        $unreadAlerts = RiskAlert::where('is_read', false)->count();

        $highAlerts = RiskAlert::where('level', 'HIGH')->count();

        $warningAlerts = RiskAlert::where('level', 'WARNING')->count();

        return view('risk-alerts.index', compact(
            'alerts',
            'totalAlerts',
            'unreadAlerts',
            'highAlerts',
            'warningAlerts'
        ));
    }

    public function markAsRead(RiskAlert $riskAlert): RedirectResponse
    {
        $riskAlert->update([
            'is_read' => true,
        ]);

        return back()->with(
            'success',
            'Risk alert marked as read.'
        );
    }

    public function markAllAsRead(): RedirectResponse
    {
        RiskAlert::where('is_read', false)
            ->update([
                'is_read' => true,
            ]);

        return back()->with(
            'success',
            'All risk alerts marked as read.'
        );
    }
}
