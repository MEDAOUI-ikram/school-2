<?php

// Modèle ClasseEtudiant
// app/Models/ClasseEtudiant.php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasseEtudiant extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     */
    protected $table = 'classe_etudiants';

    /**
     * Les attributs qui sont assignables en masse.
     */
    protected $fillable = [
        'classe_id',
        'etudiant_id',
        'nom_groupe',
    ];

    /**
     * Les attributs qui doivent être cachés pour les tableaux.
     */
    protected $hidden = [];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relations
     */

    /**
     * Obtenir la classe associée à cette inscription.
     */
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    /**
     * Obtenir l'étudiant associé à cette inscription.
     */
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    /**
     * Scopes
     */

    /**
     * Filtrer par groupe.
     */
    public function scopeParGroupe($query, $nomGroupe)
    {
        return $query->where('nom_groupe', $nomGroupe);
    }

    /**
     * Filtrer par classe.
     */
    public function scopeParClasse($query, $classeId)
    {
        return $query->where('classe_id', $classeId);
    }

    /**
     * Filtrer par étudiant.
     */
    public function scopeParEtudiant($query, $etudiantId)
    {
        return $query->where('etudiant_id', $etudiantId);
    }

    /**
     * Méthodes personnalisées
     */

    /**
     * Obtenir tous les étudiants du même groupe dans la même classe.
     */
    public function camaradesDeGroupe()
    {
        return self::where('classe_id', $this->classe_id)
                   ->where('nom_groupe', $this->nom_groupe)
                   ->where('id', '!=', $this->id)
                   ->with('etudiant')
                   ->get()
                   ->pluck('etudiant');
    }

    /**
     * Vérifier si l'étudiant est dans un groupe spécifique.
     */
    public function estDansGroupe($nomGroupe)
    {
        return $this->nom_groupe === $nomGroupe;
    }

    /**
     * Obtenir le nombre d'étudiants dans le même groupe.
     */
    public function nombreEtudiantsDansGroupe()
    {
        return self::where('classe_id', $this->classe_id)
                   ->where('nom_groupe', $this->nom_groupe)
                   ->count();
    }

    /**
     * Obtenir l'emploi du temps de la classe pour cet étudiant.
     */
    public function emploiDuTemps()
    {
        return $this->classe->emploiDuTemps();
    }

    /**
     * Obtenir les matières de la classe pour cet étudiant.
     */
    public function matieres()
    {
        return $this->classe->matieres();
    }

    /**
     * Obtenir les enseignants de la classe pour cet étudiant.
     */
    public function enseignants()
    {
        return $this->classe->enseignants();
    }
}
