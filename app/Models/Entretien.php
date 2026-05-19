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
}