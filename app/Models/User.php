<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
public function classe()
{
    return $this->belongsTo(Classe::class, 'classe_id');
}

    /**
     * Vérifier si l'utilisateur est étudiant
     */
    public function isEtudiant()
    {
        return $this->role === 'etudiant';
    }

    /**
     * Vérifier si l'utilisateur est enseignant
     */
    public function isEnseignant()
    {
        return $this->role === 'enseignant';
    }

    /**
     * Obtenir tous les rôles disponibles
     */
    public static function getRoles()
    {
        return [
            'admin' => 'Administrateur',
            'etudiant' => 'Étudiant',
            'enseignant' => 'Enseignant',
        ];
    }
}

