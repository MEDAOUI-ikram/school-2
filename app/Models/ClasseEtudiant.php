<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasseEtudiant extends Model
{
    use HasFactory;

    protected $table = 'classe_etudiants';

    protected $fillable = [
        'classe_id',
        'etudiant_id', 
        'nom_groupe'
    ];

    // Relations
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}