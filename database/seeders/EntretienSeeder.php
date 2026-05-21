<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\candidature;
use App\Models\entretien;

class EntretienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidatures = Candidature::all();

        foreach ($candidatures as $candidature) {

            $entretiens = Entretien::factory(
                rand(1, 3)
            )->make();

            $candidature
                ->entretiens()
                ->saveMany($entretiens);
        }
    }
}
