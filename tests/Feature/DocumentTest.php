<?php

use App\Models\User;
use App\Models\Candidature;
use App\Models\Document;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

test('user can download a document', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);
    $file = UploadedFile::fake()->create('cv.pdf', 1024);
    $path = $file->store('documents', 'public');
    $document = Document::factory()->create([
        'candidature_id' => $candidature->id,
        'nom_fichier' => 'cv.pdf',
        'chemin_stockage' => $path,
        'type_mime' => 'application/pdf',
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route('documents.download', $document));

    $response->assertOk();
});

test('user cannot download another users document', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user1->id]);
    $file = UploadedFile::fake()->create('cv.pdf', 1024);
    $path = $file->store('documents', 'public');
    $document = Document::factory()->create([
        'candidature_id' => $candidature->id,
        'nom_fichier' => 'cv.pdf',
        'chemin_stockage' => $path,
        'type_mime' => 'application/pdf',
    ]);

    $response = $this
        ->actingAs($user2)
        ->get(route('documents.download', $document));

    $response->assertForbidden();
});

test('user can delete a document', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user->id]);
    $file = UploadedFile::fake()->create('cv.pdf', 1024);
    $path = $file->store('documents', 'public');
    $document = Document::factory()->create([
        'candidature_id' => $candidature->id,
        'nom_fichier' => 'cv.pdf',
        'chemin_stockage' => $path,
        'type_mime' => 'application/pdf',
    ]);

    $response = $this
        ->actingAs($user)
        ->delete(route('documents.destroy', $document));

    $response->assertRedirect();
    Storage::disk('public')->assertMissing($path);
    expect(Document::find($document->id))->toBeNull();
});

test('user cannot delete another users document', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $candidature = Candidature::factory()->create(['user_id' => $user1->id]);
    $file = UploadedFile::fake()->create('cv.pdf', 1024);
    $path = $file->store('documents', 'public');
    $document = Document::factory()->create([
        'candidature_id' => $candidature->id,
        'nom_fichier' => 'cv.pdf',
        'chemin_stockage' => $path,
        'type_mime' => 'application/pdf',
    ]);

    $response = $this
        ->actingAs($user2)
        ->delete(route('documents.destroy', $document));

    $response->assertForbidden();
    Storage::disk('public')->assertExists($path);
    expect(Document::find($document->id))->not->toBeNull();
});
