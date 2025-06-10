@extends('layouts.enseignant')

@section('title', 'Mes Étudiants')

@section('content')
<section class="content-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 class="section-title">
            <i class="fas fa-user-graduate section-icon"></i>
            Liste des Étudiants
        </h3>
        <div style="display: flex; gap: 1rem;">
            <form method="GET" action="{{ route('enseignant.etudiants') }}">
                <select name="classe" class="form-input" style="width: auto;" onchange="this.form.submit()">
                    <option value="">Toutes les classes</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ request('classe') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom_classe }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>Nom Complet</th>
                <th>Classe</th>
                <!-- <th>Email</th>
                <th>Moyenne</th> -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($etudiants as $etudiant)
            <tr>
                <td>{{ $etudiant['nom'] }}</td>
                <td>{{ $etudiant['classe'] }}</td>
                <td>{{ $etudiant['email'] }}</td>
                <td>{{ number_format($etudiant['moyenne'], 2) }}/20</td>
                <td>
                    <button class="btn" style="padding: 0.5rem; margin-right: 0.5rem;" onclick="showAddNoteModal({{ $etudiant['id'] }}, '{{ $etudiant['nom'] }}')">
                        <i class="fas fa-plus"></i> Note
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>

<!-- Modal pour ajouter une note -->
<div id="addNoteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
    <div style="display: flex; align-items: center; justify-content: center; height: 100%;">
        <div style="background: white; border-radius: 12px; padding: 2rem; max-width: 500px; width: 90%;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.25rem; font-weight: 600; color: #1e293b;">Ajouter une Note</h3>
                <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; color: #6b7280; cursor: pointer;">&times;</button>
            </div>
            <form action="{{ route('enseignant.ajouter-note') }}" method="POST">
                @csrf
                <input type="hidden" id="etudiant_id" name="etudiant_id">
                <div class="form-group">
                    <label class="form-label">Étudiant</label>
                    <input type="text" id="etudiant_nom" class="form-input" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Matière</label>
                    <select name="matiere_id" class="form-input" required>
                        <option value="">Sélectionner une matière</option>
                        @foreach($matieres ?? [] as $matiere)
                            <option value="{{ $matiere->id }}">{{ $matiere->nom_matiere }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Type d'évaluation</label>
                    <select name="type_evaluation" class="form-input" required>
                        <option value="">Sélectionner le type</option>
                        <option value="Contrôle">Contrôle</option>
                        <option value="Devoir">Devoir</option>
                        <option value="Examen">Examen</option>
                        <option value="Participation">Participation</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Note (/20)</label>
                    <input type="number" name="note" class="form-input" min="0" max="20" step="0.25" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Coefficient</label>
                    <input type="number" name="coefficient" class="form-input" min="0.1" max="10" step="0.1" value="1">
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i>
                        Enregistrer
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showAddNoteModal(etudiantId, etudiantNom) {
    document.getElementById('etudiant_id').value = etudiantId;
    document.getElementById('etudiant_nom').value = etudiantNom;
    document.getElementById('addNoteModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('addNoteModal').style.display = 'none';
}

// Fermer le modal en cliquant à l'extérieur
window.onclick = function(event) {
    const modal = document.getElementById('addNoteModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>
@endpush
