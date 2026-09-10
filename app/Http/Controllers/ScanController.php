<?php

namespace App\Http\Controllers;

use App\Models\Toegangspoging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    public function store(Request $request)
    {
        $sporter = Auth::user();
        $sporter->load('abonnement');

        $toegestaan = true;
        $foutmelding = null;

        if ($sporter->geannuleerd) {
            $toegestaan = false;
            $foutmelding = 'Abonnement is opgezegd.';
        } elseif ($sporter->abonnement->max_bezoeken_per_week !== null) {
            $weekBezoeken = $sporter->toegangspogingen()
                ->where('toegestaan', true)
                ->whereBetween('tijdstip', [now()->startOfWeek(), now()->endOfWeek()])
                ->count();

            if ($weekBezoeken >= $sporter->abonnement->max_bezoeken_per_week) {
                $toegestaan = false;
                $foutmelding = 'Je hebt geen toegang. Maximum bezoeken gehaald.';
            }
        }

        Toegangspoging::create([
            'sporter_id' => $sporter->id,
            'tijdstip' => now(),
            'toegestaan' => $toegestaan,
            'foutmelding' => $foutmelding,
        ]);

        return response()->json([
            'toegestaan' => $toegestaan,
            'foutmelding' => $foutmelding,
            'bezoeken' => DashboardController::bezoeken($sporter),
        ]);
    }
}
