@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 py-3">
        <!-- Header with Search -->
        <div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl border border-white/20 mb-4">
            <div class="p-4">
                <!-- Search Bar -->
                <div class="relative mb-4">
                    <form id="search-form" class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               id="search-input"
                               name="q"
                               class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                               placeholder="Buscar mangás..."
                               autocomplete="off"
                               value="{{ request('q', '') }}">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 space-x-2">
                            <button type="button" 
                                    id="clear-search" 
                                    class="hidden text-gray-400 hover:text-gray-600 transition-colors"
                                    aria-label="Limpar busca">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <button type="button" 
                                    id="toggle-filters" 
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors"
                                    aria-expanded="false"
                                    aria-controls="filters-panel">
                                <span class="mr-1">Filtros</span>
                                <svg class="h-4 w-4 transition-transform duration-200 transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Search suggestions dropdown -->
                    <div id="search-suggestions" class="hidden absolute z-10 mt-1 w-full bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
                        <div class="py-1">
                            <!-- Suggestions will be populated by JavaScript -->
                        </div>
                    </div>
                </div>

                <!-- Quick Filters -->
                <div class="filter-group flex flex-wrap gap-2 mb-3">
                    <button type="button" data-filter="popular" class="quick-filter-btn inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 hover:bg-blue-200 transition-colors" data-active="true">
                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                        Populares
                    </button>
                    <button type="button" data-filter="new" class="quick-filter-btn inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Novos
                    </button>
                    <button type="button" data-filter="completed" class="quick-filter-btn inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                        <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                        Completos
                    </button>
                    <button type="button" data-filter="translated" class="quick-filter-btn inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                        <span class="w-2 h-2 bg-orange-500 rounded-full mr-2"></span>
                        Traduzidos
                    </button>
                </div>

                <!-- Advanced Filters Toggle -->
                <button id="toggle-filters" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                    </svg>
                    Filtros Avançados
                    <svg id="filter-arrow" class="h-4 w-4 ml-1 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>

            <!-- Advanced Filters Panel -->
            <div id="filters-panel" class="hidden bg-white/50 backdrop-blur-sm rounded-xl p-4 mb-4 border border-gray-100 shadow-sm transition-all duration-300 overflow-hidden" aria-labelledby="filters-heading">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Gêneros -->
                    <div class="relative group" x-data="{ open: false }">
                        <button 
                            type="button" 
                            @click="open = !open"
                            :aria-expanded="open ? 'true' : 'false'"
                            class="w-full flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            <span>Gêneros</span>
                            <svg 
                                :class="{'rotate-180': open}" 
                                class="h-4 w-4 text-gray-500 transform transition-transform" 
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 shadow-sm">
                            <svg class="h-3.5 w-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Aplicar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl border border-white/20">
            <!-- Results Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 border-b border-gray-100">
                <div class="flex items-center space-x-3 mb-2 sm:mb-0">
                    <h2 class="text-lg font-semibold text-gray-900">Resultados</h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        1.247
                    </span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-xs text-gray-500">Ordenar:</span>
                        <select class="text-xs border border-gray-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            <option>Mais recente</option>
                            <option>Mais antigo</option>
                            <option>Mais popular</option>
                            <option>Melhor avaliado</option>
                        </select>
                    </div>
                    <div class="flex items-center space-x-1 border border-gray-300 rounded-lg p-1">
                        <button class="p-1 rounded text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors" title="Grade">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </button>
                        <button class="p-1 rounded text-blue-600 bg-blue-100 transition-colors" title="Lista">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Results Grid -->
            <div class="p-4">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 gap-3">
                    @for($i = 1; $i <= 16; $i++)
                    <div class="manga-card group relative bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-200">
                        <div class="relative aspect-[2/3] bg-gradient-to-br from-gray-100 to-gray-200">
                            <img src="https://via.placeholder.com/200x300" alt="Manga Cover" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                            
                            <!-- Status Badges -->
                            @if($i % 3 === 0)
                            <div class="absolute top-2 right-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-sm">
                                NOVO
                            </div>
                            @endif
                            @if($i % 4 === 0)
                            <div class="absolute top-2 left-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-sm">
                                18+
                            </div>
                            @endif
                            
                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="absolute bottom-0 left-0 right-0 p-3">
                                    <div class="flex flex-wrap gap-1 mb-2">
                                        <span class="inline-block px-2 py-0.5 bg-white/20 backdrop-blur-sm text-white text-[10px] rounded-full">Ação</span>
                                        <span class="inline-block px-2 py-0.5 bg-white/20 backdrop-blur-sm text-white text-[10px] rounded-full">Aventura</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-1">
                                            <svg class="h-3 w-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="text-white text-[10px] font-medium">{{ number_format(rand(35, 50)/10, 1) }}</span>
                                        </div>
                                        <button type="button" class="favorite-btn p-1.5 bg-white/20 backdrop-blur-sm rounded-full hover:bg-white/30 transition-colors" data-manga-id="{{ $i }}">
                                            <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <a href="#" class="block p-3">
                            <h3 class="text-xs font-semibold text-gray-900 mb-1 line-clamp-2 leading-tight">Título do Mangá Muito Longo {{ $i }}</h3>
                            <div class="flex items-center justify-between text-[11px] text-gray-500">
                                <span>Cap. {{ rand(1, 200) }}</span>
                                <span class="flex items-center">
                                    <svg class="h-3 w-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ rand(50, 500) }}
                                </span>
                            </div>
                        </a>
                    </div>
                    @endfor
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex items-center justify-between">
                    <div class="hidden sm:block">
                        <p class="text-sm text-gray-700">
                            Mostrando <span class="font-medium">1-16</span> de <span class="font-medium">1,247</span> resultados
                        </p>
                    </div>
                    <div class="flex-1 sm:flex-none">
                        <nav class="flex items-center justify-center space-x-1">
                            <button class="p-2 rounded-lg hover:bg-gray-100 disabled:opacity-50 transition-colors" disabled>
                                <svg class="h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <button class="px-3 py-1.5 text-sm font-medium rounded-lg bg-blue-100 text-blue-700">1</button>
                            <button class="px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">2</button>
                            <button class="px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">3</button>
                            <span class="px-2 text-gray-500">...</span>
                            <button class="px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">78</button>
                            <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                <svg class="h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </nav>
                    </div>
                    <div class="hidden sm:block">
                        <select class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            <option>16 por página</option>
                            <option>24 por página</option>
                            <option>32 por página</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle advanced filters panel
        function setupAdvancedFilters() {
            const toggleBtn = document.getElementById('toggle-filters');
            const filtersPanel = document.getElementById('advanced-filters');
            const filterArrow = document.getElementById('filter-arrow');
            
            if (toggleBtn && filtersPanel && filterArrow) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isHidden = filtersPanel.classList.toggle('hidden');
                    filterArrow.classList.toggle('rotate-180', !isHidden);
                    
                    // Save state to localStorage
                    localStorage.setItem('advancedFiltersVisible', !isHidden);
                });
                
                // Restore saved state
                const savedState = localStorage.getItem('advancedFiltersVisible') === 'true';
                if (savedState) {
                    filtersPanel.classList.remove('hidden');
                    filterArrow.classList.add('rotate-180');
                }
            }
        }


        // Handle search input interactions
        function setupSearchInput() {
            const searchInput = document.getElementById('search');
            if (!searchInput) return;
            
            const searchContainer = searchInput.parentElement;
            
            searchInput.addEventListener('focus', () => {
                searchContainer.classList.add('ring-2', 'ring-blue-500/20');
            });
            
            searchInput.addEventListener('blur', () => {
                searchContainer.classList.remove('ring-2', 'ring-blue-500/20');
            });
            
            // Debounce search function
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    // Perform search here
                    console.log('Searching for:', this.value);
                }, 500);
            });
        }

        // Handle quick filter buttons
        function setupQuickFilters() {
            const filterButtons = document.querySelectorAll('.quick-filter-btn');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active state from all buttons in the same group
                    const filterGroup = this.closest('.filter-group');
                    if (filterGroup) {
                        filterGroup.querySelectorAll('.quick-filter-btn').forEach(btn => {
                            btn.classList.remove('bg-blue-100', 'text-blue-700');
                            btn.classList.add('bg-gray-100', 'text-gray-700');
                        });
                    }
                    
                    // Toggle active state on clicked button
                    this.classList.toggle('active');
                    if (this.classList.contains('active')) {
                        this.classList.remove('bg-gray-100', 'text-gray-700');
                        this.classList.add('bg-blue-100', 'text-blue-700');
                    } else {
                        this.classList.remove('bg-blue-100', 'text-blue-700');
                        this.classList.add('bg-gray-100', 'text-gray-700');
                    }
                    
                    // Trigger filter update
                    updateFilters();
                });
            });
        }

        // Handle filter updates
        function updateFilters() {
            const activeFilters = {};
            
            // Get all active filter values
            document.querySelectorAll('input[type="checkbox"]:checked, input[type="radio"]:checked, select').forEach(input => {
                const name = input.getAttribute('name');
                const value = input.value;
                
                if (name) {
                    if (input.type === 'checkbox') {
                        if (!activeFilters[name]) activeFilters[name] = [];
                        activeFilters[name].push(value);
                    } else {
                        activeFilters[name] = value;
                    }
                }
            });
            
            console.log('Active filters:', activeFilters);
            // Here you would typically make an AJAX call to update results
            // updateResults(activeFilters);
        }


        // Initialize animations for manga cards
        function initCardAnimations() {
            const cards = document.querySelectorAll('.manga-card');
            if (!window.IntersectionObserver) {
                // Fallback for browsers that don't support IntersectionObserver
                cards.forEach(card => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                });
                return;
            }
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = `opacity 0.6s ease ${index * 0.05}s, transform 0.6s ease ${index * 0.05}s`;
                observer.observe(card);
            });
        }

        // Initialize all functions
        function init() {
            setupAdvancedFilters();
            setupSearchInput();
            setupQuickFilters();
            initCardAnimations();
            
            // Add any other initialization code here
            document.querySelectorAll('select, input[type="checkbox"], input[type="radio"]')
                .forEach(el => el.addEventListener('change', updateFilters));
        }

        // Start the application
        init();
    });

    // Utility function to debounce function calls
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Animation classes */
    .manga-card {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    
    .manga-card.visible {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Loading state */
    .loading {
        position: relative;
        overflow: hidden;
    }
    
    .loading::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        transform: translateX(-100%);
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
        animation: shimmer 1.5s infinite;
    }
    
    @keyframes shimmer {
        100% {
            transform: translateX(100%);
        }
    }
</style>
@endpush

@endsection

