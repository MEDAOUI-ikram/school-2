<?php

namespace App\Imports;

use App\Models\Etudiant;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;

class EtudiantsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use Importable, SkipsErrors;

    private $rowCount = 0;

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $this->rowCount++;

        return new Etudiant([
            'nom' => $row['nom'],
            'courriel' => $row['courriel'],
            'niveau' => $row['niveau'],
            'mot_de_passe' => Hash::make($row['mot_de_passe'] ?? 'password123'),
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'courriel' => 'required|email|unique:etudiants,courriel',
            'niveau' => 'required|string|in:Primaire,Collège,Lycée',
            'mot_de_passe' => 'nullable|string|min:6',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'nom.required' => 'Le nom est obligatoire',
            'courriel.required' => 'L\'email est obligatoire',
            'courriel.email' => 'L\'email doit être valide',
            'courriel.unique' => 'Cet email existe déjà',
            'niveau.required' => 'Le niveau est obligatoire',
            'niveau.in' => 'Le niveau doit être Primaire, Collège ou Lycée',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 6 caractères',
        ];
    }

    /**
     * @return int
     */
    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
