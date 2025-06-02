<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasseEnseignantMatiere extends Model
{
    use HasFactory;

    protected $table = 'classe_enseignant_matiere';

    protected $fillable = [
        'classe_id',
        'enseignant_id',
        'matiere_id',
    ];

    /**
     * Obtenir la classe associée.
     */
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    /**
     * Obtenir l'enseignant associé.
     */
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    /**
     * Obtenir la matière associée.
     */
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}
