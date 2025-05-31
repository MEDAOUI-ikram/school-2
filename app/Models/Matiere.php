<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_matiere',
        'coefficient',
        'enseignant_id',
        'niveau_id',
        'description',
    ];

    /**
     * Obtenir l'enseignant qui enseigne cette matière.
     */
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    /**
     * Obtenir le niveau auquel cette matière est enseignée.
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    /**
     * Obtenir les classes où cette matière est enseignée.
     */
    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_enseignant_matiere', 'matiere_id', 'classe_id')
                    ->withPivot('enseignant_id');
    }

    /**
     * Obtenir les emplois du temps pour cette matière.
     */
    public function emploiDuTemps()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }
}
