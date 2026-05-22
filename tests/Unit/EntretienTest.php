<?php

use App\Models\Entretien;

test('returns correct type label for each type', function () {
    $entretien = new Entretien;

    $entretien->type = 'telephone';
    expect($entretien->type_label)->toBe('Téléphone');

    $entretien->type = 'technique';
    expect($entretien->type_label)->toBe('Technique');

    $entretien->type = 'rh';
    expect($entretien->type_label)->toBe('RH');

    $entretien->type = 'final';
    expect($entretien->type_label)->toBe('Final');

    $entretien->type = 'unknown';
    expect($entretien->type_label)->toBe('Inconnu');
});

test('returns correct resultat label for each result', function () {
    $entretien = new Entretien;

    $entretien->resultat = 'pending';
    expect($entretien->resultat_label)->toBe('En attente');

    $entretien->resultat = 'positive';
    expect($entretien->resultat_label)->toBe('Positif');

    $entretien->resultat = 'negative';
    expect($entretien->resultat_label)->toBe('Négatif');

    $entretien->resultat = 'unknown';
    expect($entretien->resultat_label)->toBe('Inconnu');
});
