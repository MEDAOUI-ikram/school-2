<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_matiere',   // Nom correct de la colonne
        'coefficient',
        'niveau_id',
        'description',
        'enseignant_id'
    ];

    // Accessor pour compatibilité
    public function getNomAttribute()
    {
        return $this->nom_matiere;
    }
}