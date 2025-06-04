<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Interface Étudiant')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Variables */
        :root {
          --primary: #4f46e5;
          --primary-hover: #4338ca;
          --secondary: #f3f4f6;
          --accent: #8b5cf6;
          --text: #1f2937;
          --text-light: #6b7280;
          --background: #ffffff;
          --sidebar-bg: #f9fafb;
          --sidebar-active: #ede9fe;
          --border: #e5e7eb;
          --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
          --radius: 0.5rem;
        }

        /* Reset & Base Styles */
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }

        body {
          font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
          color: var(--text);
          background-color: var(--secondary);
          line-height: 1.5;
        }

        /* Layout */
        .container {
          display: flex;
          flex-direction: column;
          min-height: 100vh;
        }

        /* Header Styles */
        .header {
          background-color: var(--background);
          padding: 1.5rem;
          border-bottom: 1px solid var(--border);
          box-shadow: var(--shadow);
        }

        .student-info {
          max-width: 1200px;
          margin: 0 auto;
          padding: 0 1rem;
        }

        .student-info h1 {
          font-size: 1.5rem;
          font-weight: 700;
          color: var(--primary);
          margin-bottom: 0.75rem;
        }

        .student-info p {
          margin-bottom: 0.5rem;
          color: var(--text-light);
        }

        .student-info strong {
          color: var(--text);
          font-weight: 600;
        }

        /* Navigation */
        .navigation {
          display: flex;
          flex-wrap: wrap;
          background-color: var(--sidebar-bg);
          padding: 1rem;
          gap: 0.5rem;
          border-bottom: 1px solid var(--border);
        }

        @media (min-width: 768px) {
          .container {
            flex-direction: row;
          }

          .navigation {
            flex-direction: column;
            width: 250px;
            height: 100vh;
            position: sticky;
            top: 0;
            padding: 2rem 1rem;
            border-right: 1px solid var(--border);
            border-bottom: none;
          }

          .header,
          .content-area {
            width: calc(100% - 250px);
            margin-left: 250px;
          }
        }

        .nav-btn {
          display: flex;
          align-items: center;
          padding: 0.75rem 1rem;
          border-radius: var(--radius);
          color: var(--text);
          text-decoration: none;
          font-weight: 500;
          transition: all 0.2s ease;
        }

        .nav-btn:hover {
          background-color: var(--secondary);
          color: var(--primary);
        }

        .nav-btn.active {
          background-color: var(--sidebar-active);
          color: var(--primary);
          font-weight: 600;
        }

        /* Content Area */
        .content-area {
          flex: 1;
          padding: 2rem;
          background-color: var(--background);
        }

        @media (min-width: 768px) {
          .content-area {
            padding: 2rem;
            min-height: calc(100vh - 80px);
          }
        }

        /* Cards */
        .card {
          background-color: var(--background);
          border-radius: var(--radius);
          box-shadow: var(--shadow);
          padding: 1.5rem;
          margin-bottom: 1.5rem;
        }

        .card-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 1rem;
        }

        .card-title {
          font-size: 1.25rem;
          font-weight: 600;
          color: var(--text);
        }

        /* Tables */
        .table-container {
          overflow-x: auto;
        }

        table {
          width: 100%;
          border-collapse: collapse;
        }

        th,
        td {
          padding: 0.75rem 1rem;
          text-align: left;
          border-bottom: 1px solid var(--border);
        }

        th {
          font-weight: 600;
          color: var(--text-light);
          background-color: var(--secondary);
        }

        tr:hover {
          background-color: var(--secondary);
        }

        /* Forms */
        .form-group {
          margin-bottom: 1.5rem;
        }

        label {
          display: block;
          margin-bottom: 0.5rem;
          font-weight: 500;
        }

        input,
        select,
        textarea {
          width: 100%;
          padding: 0.75rem;
          border: 1px solid var(--border);
          border-radius: var(--radius);
          background-color: var(--background);
          color: var(--text);
          font-size: 1rem;
        }

        input:focus,
        select:focus,
        textarea:focus {
          outline: none;
          border-color: var(--primary);
          box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        /* Buttons */
        .btn {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          padding: 0.5rem 1rem;
          border-radius: var(--radius);
          font-weight: 500;
          text-decoration: none;
          cursor: pointer;
          transition: all 0.2s ease;
        }

        .btn-primary {
          background-color: var(--primary);
          color: white;
          border: none;
        }

        .btn-primary:hover {
          background-color: var(--primary-hover);
        }

        .btn-secondary {
          background-color: var(--secondary);
          color: var(--text);
          border: 1px solid var(--border);
        }

        .btn-secondary:hover {
          background-color: #e5e7eb;
        }

        /* Utilities */
        .mb-4 {
          margin-bottom: 1rem;
        }

        .mb-8 {
          margin-bottom: 2rem;
        }

        .text-center {
          text-align: center;
        }

        .flex {
          display: flex;
        }

        .flex-col {
          flex-direction: column;
        }

        .items-center {
          align-items: center;
        }

        .justify-between {
          justify-content: space-between;
        }

        .gap-2 {
          gap: 0.5rem;
        }

        .gap-4 {
          gap: 1rem;
        }

        /* Alert Messages */
        .alert {
          padding: 1rem;
          border-radius: var(--radius);
          margin-bottom: 1rem;
        }

        .alert-success {
          background-color: #ecfdf5;
          color: #065f46;
          border: 1px solid #a7f3d0;
        }

        .alert-error {
          background-color: #fef2f2;
          color: #b91c1c;
          border: 1px solid #fecaca;
        }

        /* Stats Cards */
        .stats-grid {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
          gap: 1rem;
          margin-bottom: 2rem;
        }

        .stat-card {
          background-color: var(--background);
          border-radius: var(--radius);
          box-shadow: var(--shadow);
          padding: 1.5rem;
        }

        .stat-title {
          font-size: 0.875rem;
          color: var(--text-light);
          margin-bottom: 0.5rem;
        }

        .stat-value {
          font-size: 1.5rem;
          font-weight: 700;
          color: var(--text);
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
          .navigation {
            overflow-x: auto;
            white-space: nowrap;
            justify-content: flex-start;
          }

          .nav-btn {
            flex-shrink: 0;
          }

          .header {
            position: sticky;
            top: 0;
            z-index: 10;
          }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navigation -->
        <div class="navigation">
            <a href="{{ route('etudiant.dashboard') }}" class="nav-btn {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}">
                Tableau de Bord
            </a>
            <a href="{{ route('etudiant.classes') }}" class="nav-btn {{ request()->routeIs('etudiant.classes') ? 'active' : '' }}">
                Mes Classes
            </a>
            <a href="{{ route('etudiant.matieres') }}" class="nav-btn {{ request()->routeIs('etudiant.matieres') ? 'active' : '' }}">
                Mes Matières
            </a>
            <a href="{{ route('etudiant.infos') }}" class="nav-btn {{ request()->routeIs('etudiant.infos') ? 'active' : '' }}">
                Infos Personnelles
            </a>
        </div>

        <div>
            <!-- En-tête avec informations étudiant -->
            <div class="header">
                <div class="student-info">
                    <h1>Interface Étudiant</h1>
                    <p><strong>Nom:</strong> {{ Auth::user()->nom }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Niveau:</strong> {{ Auth::user()->etudiant->niveau ?? 'Non défini' }}</p>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="content-area">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
</html>