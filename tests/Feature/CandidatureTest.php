<?php

use App\Models\User;
use App\Models\Candidature;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('candidature index page is displayed', function () {
    $user = User::factory()->create();
    Candidature::factory()->count(3)->create(['user_id' => $user->id]);

    $response = $this
        ->actingAs($user)
        ->get(route('candidatures.index'));

    $response->assertOk();
});

test('candidature index can be filtered by statut', function () {
    $user = User::factory()->create();
    Candidature::factory()->create(['user_id' => $user->id, 'statut' => 'to_review']);
    Candidature::factory()->create(['user_id' => $user->id, 'statut' => 'offer_received']);

    $response = $this
        ->actingAs($user)
        ->get(route('candidatures.index', ['statut' => 'to_review']));

    $response->assertOk();
});

test('candidature index can be filtered by priorite', function () {
    $user = User::factory()->create();
    Candidature::factory()->create(['user_id' => $user->id, 'priorite' => 'high']);
    Candidature::factory()->create(['user_id' => $user->id, 'priorite' => 'low']);

    $response = $this
        ->actingAs($user)
        ->get(route('candidatures.index', ['priorite' => 'high']));

    $response->assertOk();
});

test('candidature create page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('candidatures.create'));

    $response->assertOk();
});

test('store candidature requires required fields', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post(route('candidatures.store'), []);

    $response->assertSessionHasErrors(['entreprise', 'poste', 'statut', 'priorite', 'date_candidature']);
});

test('store candidature requires valid url for offre_url', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post(route('candidatures.store'), [
            'entreprise' => 'Test Corp',
            'poste' => 'Dev',
            'statut' => 'to_review',
            'priorite' => 'medium',
            'date_candidature' => now()->format('Y-m-d'),
            'offre_url' => 'not-a-url',
        ]);

    $response->assertSessionHasErrors(['offre_url']);
});

test('user can store a candidature', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post(route('candidatures.store'), [
            'entreprise' => 'Test Corp',
            'poste' => 'Developer',
            'offre_url' => 'https://example.com/offre',
            'statut' => 'to_review',
            'priorite' => 'high',
            'notes' => 'Some notes',
            'date_candidature' => now()->format('Y-m-d'),
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('candidatures.index'));

    $this->assertDatabaseHas('candidatures', [
        'user_id' => $user->id,
        'entreprise' => 'Test Corp',
        'poste' => 'Developer',
    ]);
});

test('user can store a candidature with a document', function () {
    Storage::fake('public');
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post(route('candidatures.store'), [
            'entreprise' => 'Test Corp',
            'poste' => 'Developer',
            'statut' => 'to_review',
            'priorite' => 'high',
            'date_candidature' => now()->format('Y-m-d'),
            'document' => UploadedFile::fake()->create('cv.pdf', 1024),
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('candidatures.index'));

    $this->assertDatabaseHas('documents', [
        'nom_fichier' => 'cv.pdf',
    ]);
});

test('user can view their candidature', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);

    $response = $this
        ->actingAs($user)
        ->get(route('candidatures.show', $candidature));

    $response->assertOk();
});

test('user cannot view another users candidature', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user1->id]);

    $response = $this
        ->actingAs($user2)
        ->get(route('candidatures.show', $candidature));

    $response->assertForbidden();
});

test('candidature edit page is displayed', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);

    $response = $this
        ->actingAs($user)
        ->get(route('candidatures.edit', $candidature));

    $response->assertOk();
});

test('user cannot edit another users candidature', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user1->id]);

    $response = $this
        ->actingAs($user2)
        ->get(route('candidatures.edit', $candidature));

    $response->assertForbidden();
});

test('user can update a candidature', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create([
        'user_id' => $user->id,
        'entreprise' => 'Old Corp',
    ]);

    $response = $this
        ->actingAs($user)
        ->put(route('candidatures.update', $candidature), [
            'entreprise' => 'New Corp',
            'poste' => 'Senior Dev',
            'statut' => 'interview_scheduled',
            'priorite' => 'low',
            'date_candidature' => now()->format('Y-m-d'),
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('candidatures.show', $candidature));

    expect($candidature->fresh()->entreprise)->toBe('New Corp');
});

test('user cannot update another users candidature', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $candidature = Candidature::factory()->create([
        'user_id' => $user1->id,
        'entreprise' => 'Original',
    ]);

    $response = $this
        ->actingAs($user2)
        ->put(route('candidatures.update', $candidature), [
            'entreprise' => 'Hacked',
            'poste' => 'Hacker',
            'statut' => 'to_review',
            'priorite' => 'high',
            'date_candidature' => now()->format('Y-m-d'),
        ]);

    $response->assertForbidden();
    expect($candidature->fresh()->entreprise)->toBe('Original');
});

test('user can archive a candidature', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);

    $response = $this
        ->actingAs($user)
        ->delete(route('candidatures.destroy', $candidature));

    $response->assertRedirect(route('candidatures.index'));
    expect($candidature->fresh()->trashed())->toBeTrue();
});

test('user cannot archive another users candidature', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user1->id]);

    $response = $this
        ->actingAs($user2)
        ->delete(route('candidatures.destroy', $candidature));

    $response->assertForbidden();
    expect($candidature->fresh()->trashed())->toBeFalse();
});

test('archives page displays trashed candidatures', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);
    $candidature->delete();

    $response = $this
        ->actingAs($user)
        ->get(route('candidatures.archives'));

    $response->assertOk();
});

test('user can restore a candidature', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);
    $candidature->delete();

    $response = $this
        ->actingAs($user)
        ->patch(route('candidatures.restore', $candidature->id));

    $response->assertRedirect(route('candidatures.archives'));
    expect($candidature->fresh()->trashed())->toBeFalse();
});

test('user cannot restore another users candidature', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user1->id]);
    $candidature->delete();

    $response = $this
        ->actingAs($user2)
        ->patch(route('candidatures.restore', $candidature->id));

    $response->assertForbidden();
});

test('user can force delete a candidature', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);
    $candidature->delete();

    $response = $this
        ->actingAs($user)
        ->delete(route('candidatures.force-destroy', $candidature->id));

    $response->assertRedirect(route('candidatures.archives'));
    expect(Candidature::withTrashed()->find($candidature->id))->toBeNull();
});

test('user cannot force delete another users candidature', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user1->id]);
    $candidature->delete();

    $response = $this
        ->actingAs($user2)
        ->delete(route('candidatures.force-destroy', $candidature->id));

    $response->assertForbidden();
});
