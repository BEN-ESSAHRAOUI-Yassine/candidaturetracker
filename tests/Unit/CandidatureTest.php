<?php

use App\Models\Candidature;

test('returns correct statut label for each status', function () {
    $candidature = new Candidature;

    $candidature->statut = 'to_review';
    expect($candidature->statut_label)->toBe('En attente');

    $candidature->statut = 'interview_scheduled';
    expect($candidature->statut_label)->toBe('Entretien planifié');

    $candidature->statut = 'offer_received';
    expect($candidature->statut_label)->toBe('Offre reçue');

    $candidature->statut = 'rejected';
    expect($candidature->statut_label)->toBe('Refusé');

    $candidature->statut = 'abandoned';
    expect($candidature->statut_label)->toBe('Abandonné');

    $candidature->statut = 'unknown';
    expect($candidature->statut_label)->toBe('Inconnu');
});

test('returns correct priorite label for each priority', function () {
    $candidature = new Candidature;

    $candidature->priorite = 'high';
    expect($candidature->priorite_label)->toBe('Haute');

    $candidature->priorite = 'medium';
    expect($candidature->priorite_label)->toBe('Moyenne');

    $candidature->priorite = 'low';
    expect($candidature->priorite_label)->toBe('Faible');

    $candidature->priorite = 'unknown';
    expect($candidature->priorite_label)->toBe('Inconnue');
});
