<?php

use App\Models\User;
use App\Models\Candidature;
use App\Models\Entretien;

test('dashboard page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('dashboard'));

    $response->assertOk();
});

test('dashboard displays candidature statistics', function () {
    $user = User::factory()->create();
    Candidature::factory()->count(2)->create([
        'user_id' => $user->id,
        'statut' => 'to_review',
    ]);
    Candidature::factory()->create([
        'user_id' => $user->id,
        'statut' => 'offer_received',
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route('dashboard'));

    $response->assertOk();
    $response->assertSee('2');
});

test('dashboard shows upcoming interviews', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);
    Entretien::factory()->create([
        'candidature_id' => $candidature->id,
        'date_entretien' => now()->addDay(),
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route('dashboard'));

    $response->assertOk();
});
