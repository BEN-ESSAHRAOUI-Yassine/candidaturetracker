<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /** @use HasFactory<\Database\Factories\DocumentFactory> */
    use HasFactory;

    protected $fillable = [
        'candidature_id',
        'nom_fichier',
        'chemin_stockage',
        'type_mime'
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }
}
