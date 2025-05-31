<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    protected $table = 'enseignants';

    protected $fillable = [
        'nom',
        'courriel',
        'mot_de_passe',
        'specialite',
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    /**
     * Obtenir les matières enseignées par cet enseignant.
     */
    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }

    /**
     * Obtenir les classes de cet enseignant avec les matières qu'il y enseigne.
     */
    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_enseignant_matiere')
                    ->withPivot('matiere_id')
                    ->withTimestamps();
    }

    /**
     * Obtenir l'emploi du temps de cet enseignant.
     */
    public function emploiDuTemps()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    /**
     * Obtenir les assignations de cet enseignant (classe + matière).
     */
    public function assignations()
    {
        return $this->hasMany(ClasseEnseignantMatiere::class);
    }

    /**
     * Obtenir toutes les matières que cet enseignant peut enseigner (basé sur sa spécialité).
     */
    public function matieresCompatibles()
    {
        return $this->hasMany(Matiere::class)->where('nom_matiere', 'like', '%' . $this->specialite . '%');
    }
}
