@extends('layouts.enseignant')

@section('title', 'Emploi  Temps')

@section('content')
<section class="content-section">
    <h3 class="section-title">
        <i class="fas fa-calendar-alt section-icon"></i>
        Mon Emploi du Temps
    </h3>
    
    <div style="display: grid; grid-template-columns: auto repeat(6, 1fr); gap: 1px; background: #e5e7eb; border-radius: 8px; overflow: hidden;">
        <!-- En-têtes -->
        <div style="background: #374151; color: white; padding: 1rem; font-weight: 600; text-align: center;">Horaire</div>
        <div style="background: #374151; color: white; padding: 1rem; font-weight: 600; text-align: center;">Lundi</div>
        <div style="background: #374151; color: white; padding: 1rem; font-weight: 600; text-align: center;">Mardi</div>
        <div style="background: #374151; color: white; padding: 1rem; font-weight: 600; text-align: center;">Mercredi</div>
        <div style="background: #374151; color: white; padding: 1rem; font-weight: 600; text-align: center;">Jeudi</div>
        <div style="background: #374151; color: white; padding: 1rem; font-weight: 600; text-align: center;">Vendredi</div>
        <div style="background: #374151; color: white; padding: 1rem; font-weight: 600; text-align: center;">Samedi</div>
        
        @php
            $heures = ['08:00-10:00', '10:00-12:00', '14:00-16:00', '16:00-18:00'];
            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        @endphp
        
        @foreach($heures as $heure)
            <div style="background: #f3f4f6; padding: 1rem; font-weight: 500; text-align: center;">{{ $heure }}</div>
            @foreach($jours as $jour)
                <div style="background: white; padding: 0.5rem; min-height: 80px; position: relative;">
                    @if(isset($emploi[$jour]))
                        @foreach($emploi[$jour] as $cours)
                            @if(str_contains($cours['heure'], explode('-', $heure)[0]))
                                <div style="background: #3b82f6; color: white; padding: 0.5rem; border-radius: 4px; font-size: 0.875rem; margin-bottom: 0.25rem;">
                                    <strong>{{ $cours['classe'] }}</strong><br>
                                    {{ $cours['matiere'] }}<br>
                                    <small>{{ $cours['salle'] }}</small>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            @endforeach
        @endforeach
    </div>
</section>
@endsection
