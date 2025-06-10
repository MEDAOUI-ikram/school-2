@extends('layouts.etudiant')

@section('title', 'Mon Emploi du Temps - Étudiant')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f8fafc 0%, #e1f5fe 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .section {
        max-width: 1000px;
        margin: 20px auto;
        background-color: #ffffff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 10px 25px rgba(33, 150, 243, 0.1);
        border: 1px solid #e3f2fd;
    }

    .section h2 {
        font-size: 28px;
        font-weight: 700;
        color: #1565c0;
        margin: 0 0 32px 0;
        padding-bottom: 16px;
        border-bottom: 2px solid #e3f2fd;
        display: flex;
        align-items: center;
    }

    .section h2:before {
        content: "📅";
        margin-right: 12px;
        font-size: 32px;
    }

    .schedule-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.1);
    }

    .schedule-table th {
        background: linear-gradient(135deg, #2196f3 0%, #64b5f6 100%);
        color: white;
        padding: 15px;
        text-align: center;
        font-weight: 600;
    }

    .schedule-table td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #e3f2fd;
        color: #1565c0;
    }

    .schedule-table tr:hover {
        background-color: #f8fafc;
    }

    .info-display {
        text-align: center;
        padding: 48px 24px;
        background-color: #f8fafc;
        border-radius: 12px;
        border: 2px dashed #bbdefb;
    }

    .info-display p {
        font-size: 18px;
        color: #64b5f6;
        margin: 0;
        font-weight: 500;
    }
</style>

<div class="section">
    <h2>Mon Emploi du Temps</h2>

    @if($monEmploiDuTemps->isEmpty())
        <div class="info-display">
            <p>Aucun cours programmé pour le moment.</p>
        </div>
    @else
        <table class="schedule-table">
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Heure de début</th>
                    <th>Heure de fin</th>
                    <th>Matière</th>
                    <th>Enseignant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monEmploiDuTemps as $cours)
                    <tr>
                        <td>{{ $cours->jour ?? 'N/A' }}</td>
                        <td>{{ $cours->heure_debut ?? 'N/A' }}</td>
                        <td>{{ $cours->heure_fin ?? 'N/A' }}</td>
                        <td>{{ $cours->matiere->nom ?? 'N/A' }}</td>
                        <td>{{ $cours->enseignant->nom ?? 'N/A' }} {{ $cours->enseignant->prenom ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
