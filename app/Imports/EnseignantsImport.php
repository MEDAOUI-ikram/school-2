<?php

namespace App\Imports;

use App\Models\Enseignant;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;

class EnseignantsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
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

        return new Enseignant([
            'nom' => $row['nom'],
            'courriel' => $row['courriel'],
            'specialite' => $row['specialite'] ?? null,
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
            'courriel' => 'required|email|unique:enseignants,courriel',
            'specialite' => 'nullable|string|max:255',
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
