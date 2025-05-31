<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_niveau',
    ];

    /**
     * Obtenir les classes de ce niveau.
     */
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }

    /**
     * Obtenir les matières enseignées à ce niveau.
     */
    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }

    /**
     * Obtenir les étudiants de ce niveau.
     */
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'niveau', 'nom_niveau');
    }
}
