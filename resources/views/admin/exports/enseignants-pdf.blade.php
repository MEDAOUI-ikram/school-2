<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des Enseignants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Liste des Enseignants</h1>
        <p>Généré le {{ date('d/m/Y à H:i') }}</p>
        <p>Total : {{ $enseignants->count() }} enseignants</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Spécialité</th>
                <th>Matières</th>
                <th>Classes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enseignants as $enseignant)
                <tr>
                    <td>{{ $enseignant->nom }}</td>
                    <td>{{ $enseignant->courriel }}</td>
                    <td>{{ $enseignant->specialite ?? 'Non définie' }}</td>
                    <td>{{ $enseignant->matieres->count() }}</td>
                    <td>{{ $enseignant->classes->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Document généré automatiquement par le système de gestion scolaire</p>
    </div>
</body>
</html>
