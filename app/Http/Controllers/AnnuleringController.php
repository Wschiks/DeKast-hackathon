<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnuleringController extends Controller
{
    public function store(Request $request)
    {
        $sporter = Auth::user();

        $sporter->update([
            'geannuleerd' => true,
            'annuleringsdatum' => now(),
            'einddatum_toegang' => now(),
        ]);

        return response()->json([
            'success' => true,
        ]);
    }
}
