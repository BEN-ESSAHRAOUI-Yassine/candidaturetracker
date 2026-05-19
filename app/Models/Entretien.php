<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entretien extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidature_id',
        'type',
        'date_entretien',
        'notes_preparation',
        'resultat'
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'telephone' => 'Téléphone',
            'technique' => 'Technique',
            'rh' => 'RH',
            'final' => 'Final',
            default => 'Inconnu'
        };
    }

    public function getResultatLabelAttribute(): string
    {
        return match ($this->resultat) {
            'pending' => 'En attente',
            'positive' => 'Positif',
            'negative' => 'Négatif',
            default => 'Inconnu'
        };
    }
}