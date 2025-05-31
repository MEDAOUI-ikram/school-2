<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $table = 'etudiants';

    protected $fillable = [
        'nom',
        'courriel',
        'mot_de_passe',
        'niveau',
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    /**
     * Obtenir les classes de cet étudiant.
     */
    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_etudiant')
                    ->withPivot('nom_groupe', 'date_inscription')
                    ->withTimestamps();
    }

    /**
     * Obtenir le niveau de cet étudiant.
     */
    public function niveauModel()
    {
        return $this->belongsTo(Niveau::class, 'niveau', 'nom_niveau');
    }

    /**
     * Obtenir les matières que suit cet étudiant (via ses classes).
     */
    public function matieres()
    {
        return $this->hasManyThrough(
            Matiere::class,
            Classe::class,
            'id', // Clé étrangère sur la table classes
            'id', // Clé étrangère sur la table matieres
            'id', // Clé locale sur la table etudiants
            'id'  // Clé locale sur la table classes
        )->distinct();
    }
}
