<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Candidature;

class CandidatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Nicolas Test',
            'email' => 'test@test.com'
        ]);

        Candidature::factory(10)->create([
            'user_id' => $user->id
        ]);
    }
}
