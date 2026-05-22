<?php

use App\Models\User;
use App\Models\Candidature;
use App\Models\Entretien;

test('store entretien requires required fields', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);

    $response = $this
        ->actingAs($user)
        ->post(route('entretiens.store', $candidature), []);

    $response->assertSessionHasErrors(['type', 'date_entretien', 'resultat']);
});

test('store entretien requires valid type', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);

    $response = $this
        ->actingAs($user)
        ->post(route('entretiens.store', $candidature), [
            'type' => 'invalid-type',
            'date_entretien' => now()->addDay()->format('Y-m-d H:i:s'),
            'resultat' => 'pending',
        ]);

    $response->assertSessionHasErrors(['type']);
});

test('store entretien requires valid resultat', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);

    $response = $this
        ->actingAs($user)
        ->post(route('entretiens.store', $candidature), [
            'type' => 'technique',
            'date_entretien' => now()->addDay()->format('Y-m-d H:i:s'),
            'resultat' => 'invalid-result',
        ]);

    $response->assertSessionHasErrors(['resultat']);
});

test('user can store an entretien', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);

    $response = $this
        ->actingAs($user)
        ->post(route('entretiens.store', $candidature), [
            'type' => 'technique',
            'date_entretien' => now()->addDay()->format('Y-m-d H:i:s'),
            'notes_preparation' => 'Prepare algo questions',
            'resultat' => 'pending',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('candidatures.show', $candidature));

    $this->assertDatabaseHas('entretiens', [
        'candidature_id' => $candidature->id,
        'type' => 'technique',
    ]);
});

test('user cannot store an entretien on another users candidature', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user1->id]);

    $response = $this
        ->actingAs($user2)
        ->post(route('entretiens.store', $candidature), [
            'type' => 'technique',
            'date_entretien' => now()->addDay()->format('Y-m-d H:i:s'),
            'resultat' => 'pending',
        ]);

    $response->assertForbidden();
});

test('entretien edit page is displayed', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);
    $entretien = Entretien::factory()->create(['candidature_id' => $candidature->id]);

    $response = $this
        ->actingAs($user)
        ->get(route('entretiens.edit', $entretien));

    $response->assertOk();
});

test('user can update an entretien', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);
    $entretien = Entretien::factory()->create([
        'candidature_id' => $candidature->id,
        'resultat' => 'pending',
    ]);

    $response = $this
        ->actingAs($user)
        ->put(route('entretiens.update', $entretien), [
            'type' => 'final',
            'date_entretien' => now()->addWeek()->format('Y-m-d H:i:s'),
            'notes_preparation' => 'Updated notes',
            'resultat' => 'positive',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('candidatures.show', $candidature));

    expect($entretien->fresh()->resultat)->toBe('positive');
});

test('user cannot update another users entretien', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user1->id]);
    $entretien = Entretien::factory()->create([
        'candidature_id' => $candidature->id,
        'resultat' => 'pending',
    ]);

    $response = $this
        ->actingAs($user2)
        ->put(route('entretiens.update', $entretien), [
            'type' => 'final',
            'date_entretien' => now()->addWeek()->format('Y-m-d H:i:s'),
            'resultat' => 'positive',
        ]);

    $response->assertForbidden();
    expect($entretien->fresh()->resultat)->toBe('pending');
});

test('user can delete an entretien', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);
    $entretien = Entretien::factory()->create(['candidature_id' => $candidature->id]);

    $response = $this
        ->actingAs($user)
        ->delete(route('entretiens.destroy', $entretien));

    $response->assertRedirect(route('candidatures.show', $candidature));
    expect(Entretien::find($entretien->id))->toBeNull();
});

test('user cannot delete another users entretien', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user1->id]);
    $entretien = Entretien::factory()->create(['candidature_id' => $candidature->id]);

    $response = $this
        ->actingAs($user2)
        ->delete(route('entretiens.destroy', $entretien));

    $response->assertForbidden();
    expect(Entretien::find($entretien->id))->not->toBeNull();
});
