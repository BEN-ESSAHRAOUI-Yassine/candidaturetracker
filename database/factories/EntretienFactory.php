<?php

namespace Database\Factories;

use App\Models\Entretien;
use App\Models\Candidature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Entretien>
 */
class EntretienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'candidature_id' => Candidature::factory(),

            'type' => fake()->randomElement([
                'telephone',
                'technique',
                'rh',
                'final'
            ]),

            'date_entretien' => fake()->dateTimeBetween(
                'now',
                '+1 month'
            ),

            'notes_preparation' => fake()->paragraph(),

            'resultat' => fake()->randomElement([
                'pending',
                'positive',
                'negative'
            ])
        ];

    }

    public function pending(): static
    {
        return $this->state(fn () => [
            'resultat' => 'pending'
        ]);
    }

    public function positive(): static
    {
        return $this->state(fn () => [
            'resultat' => 'positive'
        ]);
    }

    public function negative(): static
    {
        return $this->state(fn () => [
            'resultat' => 'negative'
        ]);
    }
}
