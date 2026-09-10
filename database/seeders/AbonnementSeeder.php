<?php

namespace Database\Seeders;

use App\Models\Abonnement;
use Illuminate\Database\Seeder;

class AbonnementSeeder extends Seeder
{
    public function run(): void
    {
        Abonnement::create([
            'type_naam' => '1x per week',
            'max_bezoeken_per_week' => 1,
        ]);

        Abonnement::create([
            'type_naam' => '2x per week',
            'max_bezoeken_per_week' => 2,
        ]);

        Abonnement::create([
            'type_naam' => 'onbeperkt',
            'max_bezoeken_per_week' => null,
        ]);
    }
}
