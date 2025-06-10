<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_classe',    // Nom correct de la colonne
        'annee',         // Colonne obligatoire
        'enseignant_id',
        'niveau_id'
    ];

    // Accessor pour compatibilité avec le code existant
    public function getNomAttribute()
    {
        return $this->nom_classe;
    }

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }
}