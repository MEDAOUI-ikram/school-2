<?php

namespace App\Exports;

use App\Models\Enseignant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EnseignantsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Enseignant::with(['matieres', 'classes'])->orderBy('nom')->get();
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
            'Spécialité',
            'Nombre de Matières',
            'Nombre de Classes',
            'Date de Création',
            'Dernière Modification',
        ];
    }

    /**
     * @param mixed $enseignant
     * @return array
     */
    public function map($enseignant): array
    {
        return [
            $enseignant->id,
            $enseignant->nom,
            $enseignant->courriel,
            $enseignant->specialite ?? 'Non définie',
            $enseignant->matieres->count(),
            $enseignant->classes->count(),
            $enseignant->created_at->format('d/m/Y H:i'),
            $enseignant->updated_at->format('d/m/Y H:i'),
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style pour la ligne d'en-tête
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE2E2E2'],
                ],
            ],
        ];
    }
}
