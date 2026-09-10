<?php

namespace Database\Seeders;

use App\Models\Abonnement;
use App\Models\Sporter;
use Illuminate\Database\Seeder;

class SporterSeeder extends Seeder
{
    public function run(): void
    {
        $eenPerWeek = Abonnement::where('type_naam', '1x per week')->first();
        $tweePerWeek = Abonnement::where('type_naam', '2x per week')->first();
        $onbeperkt = Abonnement::where('type_naam', 'onbeperkt')->first();

        Sporter::create([
            'naam' => 'Jan Jansen',
            'email' => 'jan.jansen@example.com',
            'barcode' => '0001',
            'abonnement_id' => $eenPerWeek->id,
            'geannuleerd' => false,
        ]);

        Sporter::create([
            'naam' => 'Sanne de Vries',
            'email' => 'sanne.devries@example.com',
            'barcode' => '0002',
            'abonnement_id' => $tweePerWeek->id,
            'geannuleerd' => false,
        ]);

        Sporter::create([
            'naam' => 'Pieter Bakker',
            'email' => 'pieter.bakker@example.com',
            'barcode' => '0003',
            'abonnement_id' => $onbeperkt->id,
            'geannuleerd' => false,
        ]);

        // Test case: opgezegd, maar nog toegang tot einddatum (US-02)
        Sporter::create([
            'naam' => 'Lotte Visser',
            'email' => 'lotte.visser@example.com',
            'barcode' => '0004',
            'abonnement_id' => $tweePerWeek->id,
            'geannuleerd' => true,
            'annuleringsdatum' => now()->subDays(5),
            'einddatum_toegang' => now()->addDays(25),
        ]);

        // Test case: opgezegd en toegang al verlopen
        Sporter::create([
            'naam' => 'Mark Smit',
            'email' => 'mark.smit@example.com',
            'barcode' => '0005',
            'abonnement_id' => $eenPerWeek->id,
            'geannuleerd' => true,
            'annuleringsdatum' => now()->subDays(40),
            'einddatum_toegang' => now()->subDays(10),
        ]);

        Sporter::create([
            'naam' => 'Eva de Boer',
            'email' => 'eva.deboer@example.com',
            'barcode' => '0006',
            'abonnement_id' => $onbeperkt->id,
            'geannuleerd' => false,
        ]);
    }
}
