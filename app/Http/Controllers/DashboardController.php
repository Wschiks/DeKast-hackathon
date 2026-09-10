<?php

namespace App\Http\Controllers;

use App\Models\Sporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $sporter = Auth::user();
        $sporter->load('abonnement');

        return view('dashboard', [
            'sporter' => $sporter,
            'bezoeken' => static::bezoeken($sporter),
        ]);
    }

    public static function bezoeken(Sporter $sporter): array
    {
        $limiet = $sporter->abonnement->max_bezoeken_per_week;

        if ($limiet === null) {
            return [
                'onbeperkt' => true,
                'aantal' => $sporter->toegangspogingen()->where('toegestaan', true)->count(),
            ];
        }

        $aantal = $sporter->toegangspogingen()
            ->where('toegestaan', true)
            ->whereBetween('tijdstip', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        return [
            'onbeperkt' => false,
            'aantal' => $aantal,
            'limiet' => $limiet,
        ];
    }
}
