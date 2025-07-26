@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Resultados da Pesquisa</h1>
        
        <!-- Search and Filter Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
            <form id="search-form" action="{{ route('manga.search') }}" method="GET" class="space-y-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input 
                                type="text" 
                                name="q" 
                                id="search" 
                                value="{{ request('q') }}" 
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500" 
                                placeholder="Pesquisar por título, autor, gênero..."
                                autocomplete="off"
                                autofocus>
                        </div>
                    </div>
                    
                    <!-- Search Button -->
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <i class="fas fa-search mr-2"></i> Pesquisar
                    </button>
                </div>
                
                <!-- Filters Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <!-- Genre Filter -->
                    <div>
                        <label for="genre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gênero</label>
                        <select id="genre" 
                                name="genre" 
                                class="filter-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Todos os Gêneros</option>
                            @foreach($allGenres as $genre)
                                <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>{{ $genre }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select id="status" 
                                name="status" 
                                class="filter-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" {{ request('status', 'all') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Sort By -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ordenar por</label>
                        <select id="sort" 
                                name="sort" 
                                class="filter-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @foreach($sortOptions as $value => $label)
                                <option value="{{ $value }}" {{ request('sort', 'latest') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                @if(request()->hasAny(['q', 'status', 'genre', 'sort']))
                    <div class="flex justify-end">
                        <a href="{{ route('manga.search') }}" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                            <i class="fas fa-times mr-1"></i> Limpar Filtros
                        </a>
                    </div>
                @endif
            </form>
        </div>
        
        <!-- Results -->
        <div class="search-results">
            @include('partials.manga-grid', ['mangas' => $mangas])
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="searchLoading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-indigo-500"></div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search');
    const statusSelect = document.getElementById('status');
    const genreSelect = document.getElementById('genre');
    const sortSelect = document.getElementById('sort');
    const resultsContainer = document.querySelector('.search-results');
    const loadingIndicator = document.getElementById('searchLoading');
    
    if (!searchForm) return;
    
    // Show loading state
    function showLoading() {
        if (loadingIndicator) {
            loadingIndicator.classList.remove('opacity-0', 'pointer-events-none');
            loadingIndicator.classList.add('opacity-100');
        }
    }
    
    // Hide loading state
    function hideLoading() {
        if (loadingIndicator) {
            loadingIndicator.classList.remove('opacity-100');
            loadingIndicator.classList.add('opacity-0', 'pointer-events-none');
        }
    }
    
    // Update URL without page reload
    function updateURL(params) {
        const url = new URL(window.location);
        url.search = new URLSearchParams(params).toString();
        window.history.pushState({}, '', url);
    }
    
    // Handle form submission
    function handleSearch(event) {
        if (event) event.preventDefault();
        
        const formData = new FormData(searchForm);
        const params = new URLSearchParams();
        
        // Only include non-empty values
        for (let [key, value] of formData.entries()) {
            if (value && value !== 'all' && value !== '') {
                params.append(key, value);
            }
        }
        
        // Update URL
        updateURL(params);
        
        // Show loading state
        showLoading();
        
        // Make AJAX request
        fetch(`{{ route('manga.search') }}?${params.toString()}&ajax=1`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            if (resultsContainer && data.html) {
                resultsContainer.innerHTML = data.html;
                // Re-bind pagination links
                bindPaginationLinks();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (resultsContainer) {
                resultsContainer.innerHTML = `
                    <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow">
                        <i class="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Ocorreu um erro</h3>
                        <p class="text-gray-500 dark:text-gray-400">Não foi possível carregar os resultados. Tente novamente.</p>
                        <button onclick="window.location.reload()" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Recarregar Página
                        </button>
                    </div>
                `;
            }
        })
        .finally(() => {
            hideLoading();
        });
    }
    
    // Bind click events to pagination links
    function bindPaginationLinks() {
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                window.location.href = url.toString();
            });
        });
    }
    
    // Initial bind of pagination links
    bindPaginationLinks();
    
    // Event listeners
    searchForm.addEventListener('submit', handleSearch);
    
    // Add debounced input event for search
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            handleSearch();
        }, 500);
    });
    
    // Add change events for filters
    statusSelect.addEventListener('change', handleSearch);
    genreSelect.addEventListener('change', handleSearch);
    sortSelect.addEventListener('change', handleSearch);
    
    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // Update form values from URL
        searchInput.value = urlParams.get('q') || '';
        statusSelect.value = urlParams.get('status') || 'all';
        genreSelect.value = urlParams.get('genre') || '';
        sortSelect.value = urlParams.get('sort') || 'latest';
        
        // Trigger search
        handleSearch();
    });
});
</script>
@endpush
@endsection
