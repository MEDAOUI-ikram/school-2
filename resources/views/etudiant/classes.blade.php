@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des classes</h1>

        @foreach($classes as $classe)
            <div>
                <strong>{{ $classe['nomClasse'] }}</strong> - Année : {{ $classe['annee'] }} - Étudiants : {{ $classe['nbEtudiants'] }}
            </div>
        @endforeach
    </div>
@endsection
