<?php

namespace Database\Factories;

use App\Models\Candidature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Candidature>
 */
class CandidatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'entreprise' => fake()->company(),
            'poste' => fake()->jobTitle(),
            'offre_url' => fake()->url(),
            'statut' => fake()->randomElement([
                'to_review',
                'interview_scheduled',
                'offer_received'
            ]),
            'priorite' => fake()->randomElement([
                'high',
                'medium',
                'low'
            ]),
            'notes' => fake()->paragraph(),
            'date_candidature' => now()
        ];
    }
}