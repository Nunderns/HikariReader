@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Cabeçalho e Filtros -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Biblioteca</h1>
        
        <!-- Filtros de Status -->
        <div class="flex flex-wrap gap-2 mt-4">
            <a href="{{ request()->fullUrlWithQuery(['status' => 'all', 'page' => 1]) }}" 
               class="px-3 py-1 rounded-full text-sm font-medium {{ request('status', 'all') === 'all' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                Todos ({{ $statusCounts['all'] ?? 0 }})
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'reading', 'page' => 1]) }}" 
               class="px-3 py-1 rounded-full text-sm font-medium {{ request('status') === 'reading' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                Lendo ({{ $statusCounts['reading'] ?? 0 }})
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'plan_to_read', 'page' => 1]) }}" 
               class="px-3 py-1 rounded-full text-sm font-medium {{ request('status') === 'plan_to_read' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                Planejo Ler ({{ $statusCounts['plan_to_read'] ?? 0 }})
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'completed', 'page' => 1]) }}" 
               class="px-3 py-1 rounded-full text-sm font-medium {{ request('status') === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                Concluído ({{ $statusCounts['completed'] ?? 0 }})
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'on_hold', 'page' => 1]) }}" 
               class="px-3 py-1 rounded-full text-sm font-medium {{ request('status') === 'on_hold' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                Em Pausa ({{ $statusCounts['on_hold'] ?? 0 }})
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'dropped', 'page' => 1]) }}" 
               class="px-3 py-1 rounded-full text-sm font-medium {{ request('status') === 'dropped' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                Dropado ({{ $statusCounts['dropped'] ?? 0 }})
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'rereading', 'page' => 1]) }}" 
               class="px-3 py-1 rounded-full text-sm font-medium {{ request('status') === 'rereading' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                Relendo ({{ $statusCounts['rereading'] ?? 0 }})
            </a>
        </div>
    </div>

    <!-- Contador e Controles de Visualização -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div class="text-lg font-semibold text-gray-700">{{ $totalMangas }} {{ $totalMangas === 1 ? 'Obra' : 'Obras' }}</div>
        
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-600">Visualização:</span>
            <div class="flex bg-gray-100 p-1 rounded-md">
                <button type="button" id="detailedViewBtn" class="p-2 rounded-md {{ session('library_view', 'detailed') === 'detailed' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700' }}" title="Lista detalhada">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                </button>
                <button type="button" id="cardViewBtn" class="p-2 rounded-md {{ session('library_view') === 'card' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700' }}" title="Cartões">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </button>
                <button type="button" id="compactViewBtn" class="p-2 rounded-md {{ session('library_view') === 'compact' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700' }}" title="Grade compacta">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Modos de Exibição -->
    <div id="cardView" class="space-y-4">
        <!-- Visualização em Cards (padrão) -->
        @foreach($mangas as $manga)
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex items-start">
                <img src="{{ $manga->cover_url }}" alt="{{ $manga->title }}" class="w-24 h-32 object-cover rounded">
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-bold">{{ $manga->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $manga->author }}</p>
                    
                    <div class="mt-2 flex items-center">
                        <span class="text-yellow-500">☆ {{ $manga->rating }}</span>
                        <span class="ml-3 text-sm text-gray-500">🍀 {{ $manga->views }}k</span>
                        <span class="ml-3 text-sm text-gray-500">💤 {{ $manga->chapters ?? 'N/A' }}</span>
                        <span class="ml-3 text-sm text-gray-500">🔍 {{ $manga->comments }}</span>
                    </div>
                    
                    <div class="mt-2">
                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                            {{ $manga->status === 'ongoing' ? 'Ongoing' : 'Completed' }}
                        </span>
                    </div>
                    
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach($manga->genres as $genre)
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ $genre }}</span>
                        @endforeach
                    </div>
                    
                    <p class="mt-3 text-sm text-gray-700 line-clamp-2">{{ $manga->description }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div id="compactView" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Visualização Compacta -->
        @foreach($mangas as $manga)
        <div class="bg-white rounded-lg shadow-md p-4">
            <img src="{{ $manga->cover_url }}" alt="{{ $manga->title }}" class="w-full h-48 object-cover rounded">
            <h3 class="mt-2 text-md font-bold truncate">{{ $manga->title }}</h3>
            <div class="flex items-center mt-1">
                <span class="text-yellow-500 text-sm">☆ {{ $manga->rating }}</span>
                <span class="ml-2 text-xs text-gray-500">🍀 {{ $manga->views }}k</span>
            </div>
            <div class="mt-2">
                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                    {{ $manga->status === 'ongoing' ? 'Ongoing' : 'Completed' }}
                </span>
            </div>
        </div>
        @endforeach
    </div>

    <div id="detailedView" class="hidden space-y-2">
        <!-- Visualização Detalhada em Lista -->
        @foreach($mangas as $manga)
        <div class="bg-white rounded-lg shadow-sm p-3">
            <div class="flex items-center">
                <input type="checkbox" class="mr-3 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <div class="flex-1 min-w-0">
                    <h3 class="text-md font-bold text-gray-900 truncate">{{ $manga->title }}</h3>
                    <p class="text-sm text-gray-500 truncate">{{ $manga->author }}</p>
                </div>
                <div class="ml-4 flex items-center">
                    <span class="text-yellow-500 text-sm">☆ {{ $manga->rating }}</span>
                    <span class="ml-3 text-xs text-gray-500">🍀 {{ $manga->views }}k</span>
                    <span class="ml-3 text-xs text-gray-500">💤 {{ $manga->chapters ?? 'N/A' }}</span>
                    <span class="ml-3 text-xs text-gray-500">🔍 {{ $manga->comments }}</span>
                </div>
            </div>
            <div class="mt-2 flex flex-wrap gap-1">
                @foreach($manga->genres as $genre)
                    <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-800">{{ $genre }}</span>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginação -->
    <div class="mt-6">
        {{ $mangas->appends(request()->query())->links() }}
    </div>
</div>

@push('scripts')
<script>
    // Função para atualizar a visualização
    function updateViewMode(mode) {
        // Esconder todas as visualizações
        document.querySelectorAll('[id$="View"]').forEach(el => el.classList.add('hidden'));
        
        // Mostrar a visualização selecionada
        document.getElementById(mode + 'View').classList.remove('hidden');
        
        // Atualizar classes dos botões
        document.querySelectorAll('[id$="ViewBtn"]').forEach(btn => {
            btn.classList.remove('bg-white', 'shadow-sm', 'text-blue-600');
            btn.classList.add('text-gray-500', 'hover:text-gray-700');
        });
        
        const activeBtn = document.getElementById(mode + 'ViewBtn');
        if (activeBtn) {
            activeBtn.classList.remove('text-gray-500', 'hover:text-gray-700');
            activeBtn.classList.add('bg-white', 'shadow-sm', 'text-blue-600');
        }
        
        // Salvar preferência
        localStorage.setItem('libraryViewMode', mode);
        
        // Enviar preferência para o servidor via AJAX
        fetch('{{ route("library.update-view-mode") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ view_mode: mode })
        });
    }
    
    // Configurar eventos dos botões de visualização
    document.getElementById('cardViewBtn').addEventListener('click', () => updateViewMode('card'));
    document.getElementById('compactViewBtn').addEventListener('click', () => updateViewMode('compact'));
    document.getElementById('detailedViewBtn').addEventListener('click', () => updateViewMode('detailed'));
    
    // Inicializar visualização salva
    document.addEventListener('DOMContentLoaded', function() {
        const savedViewMode = localStorage.getItem('libraryViewMode') || '{{ session("library_view", "detailed") }}';
        updateViewMode(savedViewMode);
    });
    
    // Função para atualizar status de leitura
    function updateReadStatus(mangaId, status) {
        fetch('{{ route("library.update-status", "") }}/' + mangaId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Erro ao atualizar status: ' + (data.message || 'Tente novamente.'));
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao atualizar status. Verifique sua conexão e tente novamente.');
        });
    }
</script>
@endpush
@endsection