<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidature extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'entreprise',
        'poste',
        'offre_url',
        'statut',
        'priorite',
        'notes',
        'date_candidature'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entretiens()
    {
        return $this->hasMany(Entretien::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function getStatutLabelAttribute(): string
    {
        return match ($this->statut) {
            'to_review' => 'En attente',
            'interview_scheduled' => 'Entretien planifié',
            'offer_received' => 'Offre reçue',
            'rejected' => 'Refusé',
            'abandoned' => 'Abandonné',
            default => 'Inconnu'
        };
    }

    public function getPrioriteLabelAttribute(): string
    {
        return match ($this->priorite) {
            'high' => 'Haute',
            'medium' => 'Moyenne',
            'low' => 'Faible',
            default => 'Inconnue'
        };
    }
}