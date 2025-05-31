<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_classe',
        'annee',
        'niveau_id',
    ];

    /**
     * Obtenir le niveau de cette classe.
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    /**
     * Obtenir les étudiants de cette classe.
     */
    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class, 'classe_etudiant')
                    ->withPivot('nom_groupe', 'date_inscription')
                    ->withTimestamps();
    }

    /**
     * Obtenir les enseignants de cette classe avec leurs matières.
     */
    public function enseignants()
    {
        return $this->belongsToMany(Enseignant::class, 'classe_enseignant_matiere')
                    ->withPivot('matiere_id')
                    ->withTimestamps();
    }

    /**
     * Obtenir les matières enseignées dans cette classe.
     */
    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'classe_enseignant_matiere')
                    ->withPivot('enseignant_id')
                    ->withTimestamps();
    }

    /**
     * Obtenir l'emploi du temps de cette classe.
     */
    public function emploiDuTemps()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    /**
     * Obtenir les assignations enseignant-matière pour cette classe.
     */
    public function assignations()
    {
        return $this->hasMany(ClasseEnseignantMatiere::class);
    }
}
