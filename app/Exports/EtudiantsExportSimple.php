<?php

namespace App\Exports;

use App\Models\Etudiant;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EtudiantsExportSimple implements FromArray, WithHeadings
{
    /**
     * @return array
     */
    public function array(): array
    {
        $etudiants = Etudiant::with('classes')->orderBy('nom')->get();

        $data = [];
        foreach ($etudiants as $etudiant) {
            $data[] = [
                $etudiant->id,
                $etudiant->nom,
                $etudiant->courriel,
                $etudiant->niveau,
                $etudiant->classes->count(),
                $etudiant->created_at->format('d/m/Y H:i'),
                $etudiant->updated_at->format('d/m/Y H:i'),
            ];
        }

        return $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nom',
            'Email',
            'Niveau',
            'Nombre de Classes',
            'Date de Création',
            'Dernière Modification',
        ];
    }
}
