<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel Administrativo') - {{ config('app.name', 'HikariReader') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/admin.js'])
    @stack('styles')
    
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100">
    <!-- Sidebar -->
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-indigo-700 dark:bg-gray-800 text-white dark:text-gray-200">
                <div class="flex items-center justify-center h-16 px-4 bg-indigo-800 dark:bg-gray-900">
                    <span class="text-xl font-bold text-white">HikariReader</span>
                </div>
                <nav class="mt-8 flex-1 px-2 space-y-1">
                    <!-- Dashboard -->
                    <div class="mb-4">
                        <h3 class="px-4 text-xs font-semibold text-indigo-200 dark:text-indigo-300 uppercase tracking-wider">Principal</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800 dark:bg-gray-700 text-white' : 'text-indigo-100 dark:text-gray-200 hover:bg-indigo-700 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-tachometer-alt mr-3 w-5 text-center text-indigo-300 dark:text-indigo-400"></i>
                                Dashboard
                                <span class="ml-auto px-2 py-0.5 text-xs rounded-full bg-indigo-600 text-indigo-100">New</span>
                            </a>
                        </div>
                    </div>

                    <!-- Conteúdo -->
                    <div class="mb-4">
                        <h3 class="px-4 text-xs font-semibold text-indigo-200 dark:text-indigo-300 uppercase tracking-wider">Conteúdo</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('admin.mangas.index') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.mangas.*') ? 'bg-indigo-800 dark:bg-gray-700 text-white' : 'text-indigo-100 dark:text-gray-200 hover:bg-indigo-700 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-book mr-3 w-5 text-center text-indigo-300 dark:text-indigo-400"></i>
                                Mangás
                                <span class="ml-auto px-2 py-0.5 text-xs rounded-full bg-green-500 text-white">{{ $counts['mangas'] ?? 0 }}</span>
                            </a>
                            
                            <a href="#" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-colors text-indigo-100 dark:text-gray-200 hover:bg-indigo-700 dark:hover:bg-gray-700">
                                <i class="fas fa-list-ol mr-3 w-5 text-center text-indigo-300 dark:text-indigo-400"></i>
                                Capítulos
                                <span class="ml-auto px-2 py-0.5 text-xs rounded-full bg-blue-500 dark:bg-blue-600 text-white">{{ $counts['chapters'] ?? 0 }}</span>
                            </a>
                            
                            <a href="{{ route('admin.genres.index') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.genres.*') ? 'bg-indigo-800 dark:bg-gray-700 text-white' : 'text-indigo-100 dark:text-gray-200 hover:bg-indigo-700 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-tags mr-3 w-5 text-center text-indigo-300 dark:text-indigo-400"></i>
                                Gêneros
                                <span class="ml-auto px-2 py-0.5 text-xs rounded-full bg-purple-500 dark:bg-purple-600 text-white">{{ $counts['genres'] ?? 0 }}</span>
                            </a>
                            
                            <a href="{{ route('admin.authors.index') }}" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.authors.*') ? 'bg-indigo-800 dark:bg-gray-700 text-white' : 'text-indigo-100 dark:text-gray-200 hover:bg-indigo-700 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-users mr-3 w-5 text-center text-indigo-300 dark:text-indigo-400"></i>
                                Autores/Artistas
                                <span class="ml-auto px-2 py-0.5 text-xs rounded-full bg-pink-500 dark:bg-pink-600 text-white">{{ $counts['authors'] ?? 0 }}</span>
                            </a>
                            
                            <a href="#" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-colors text-indigo-100 dark:text-gray-200 hover:bg-indigo-700 dark:hover:bg-gray-700">
                                <i class="fas fa-user-edit mr-3 w-5 text-center text-indigo-300 dark:text-indigo-400"></i>
                                Autores
                            </a>
                        </div>
                    </div>

                    <!-- Comunidade -->
                    <div class="mb-4">
                        <h3 class="px-4 text-xs font-semibold text-indigo-200 dark:text-indigo-300 uppercase tracking-wider">Comunidade</h3>
                        <div class="mt-2 space-y-1">
                            <a href="#" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-colors text-indigo-100 dark:text-gray-200 hover:bg-indigo-700 dark:hover:bg-gray-700">
                                <i class="fas fa-users mr-3 w-5 text-center text-indigo-300 dark:text-indigo-400"></i>
                                Usuários
                                <span class="ml-auto px-2 py-0.5 text-xs rounded-full bg-purple-500 dark:bg-purple-600 text-white">{{ $counts['users'] ?? 0 }}</span>
                            </a>
                            
                            <a href="#" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-colors text-indigo-100 dark:text-gray-200 hover:bg-indigo-700 dark:hover:bg-gray-700">
                                <i class="fas fa-comments mr-3 w-5 text-center text-indigo-300 dark:text-indigo-400"></i>
                                Comentários
                                <span class="ml-auto px-2 py-0.5 text-xs rounded-full bg-red-500 dark:bg-red-600 text-white">3</span>
                            </a>
                            
                            <a href="#" class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-colors text-indigo-100 dark:text-gray-200 hover:bg-indigo-700 dark:hover:bg-gray-700">
                                <i class="fas fa-flag mr-3 w-5 text-center text-indigo-300 dark:text-indigo-400"></i>
                                Denúncias
                                <span class="ml-auto px-2 py-0.5 text-xs rounded-full bg-yellow-500 dark:bg-yellow-600 text-white">5</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Configurações -->
                    <div x-data="{ open: {{ request()->routeIs('admin.settings.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600">
                            <div class="flex items-center">
                                <i class="fas fa-cog mr-3 w-5 text-center"></i>
                                Configurações
                            </div>
                            <svg :class="{'rotate-90': open}" class="w-4 h-4 transition-transform duration-200 transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        <div x-show="open" class="mt-1 space-y-1 pl-4">
                            <a href="#" class="block px-4 py-2 text-sm text-indigo-100 hover:bg-indigo-600 rounded-md">
                                Geral
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-indigo-100 hover:bg-indigo-600 rounded-md">
                                Tema
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-indigo-100 hover:bg-indigo-600 rounded-md">
                                SEO
                            </a>
                        </div>
                    </div>
                </nav>
                <div class="p-4 border-t border-indigo-800">
                    <div class="flex items-center">
                        <img class="w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" alt="{{ auth()->user()->name }}">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                            <a href="{{ route('profile.show') }}" class="text-xs font-medium text-indigo-200 hover:text-white">Ver perfil</a>
                        </div>
                    </div>
                    <div class="mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-2 py-1 text-sm font-medium text-left text-indigo-200 rounded-md hover:bg-indigo-600 hover:text-white">
                                <i class="fas fa-sign-out-alt mr-2"></i> Sair
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <!-- Botão do menu móvel -->
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 hover:text-gray-600 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <div class="flex-1 flex justify-between">
                        <div class="flex items-center">
                            <!-- Barra de busca (opcional) -->
                            <div class="hidden md:block ml-4">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Pesquisar...">
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Notification Dropdown -->
                            <div class="relative ml-3" x-data="{ open: false }" @keydown.escape="open = false" @notifications-updated.window="open = false">
                                <button 
                                    @click="open = !open" 
                                    class="p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 relative"
                                    aria-expanded="false"
                                    aria-haspopup="true"
                                >
                                    <span class="sr-only">Ver notificações</span>
                                    <i class="far fa-bell text-xl"></i>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <span class="absolute top-0 right-0 block h-3 w-3 rounded-full bg-red-500 notification-count">
                                            {{ auth()->user()->unreadNotifications->count() > 9 ? '9+' : auth()->user()->unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </button>

                                <!-- Dropdown panel, show/hide based on dropdown state -->
                                <div 
                                    x-show="open" 
                                    @click.away="open = false" 
                                    class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 divide-y divide-gray-200"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    style="display: none;"
                                >
                                    <div class="px-4 py-3 flex items-center justify-between border-b border-gray-200">
                                        <p class="text-sm font-medium text-gray-900">Notificações</p>
                                        @if(auth()->user()->unreadNotifications->count() > 0)
                                            <button 
                                                @click="markAllNotificationsAsRead(); open = false;" 
                                                class="text-xs text-indigo-600 hover:text-indigo-900 focus:outline-none"
                                            >
                                                Marcar todas como lidas
                                            </button>
                                        @endif
                                    </div>
                                    
                                    <div class="max-h-96 overflow-y-auto notifications-list">
                                        @forelse(auth()->user()->unreadNotifications->take(10) as $notification)
                                            <a 
                                                href="{{ $notification->data['url'] ?? '#' }}" 
                                                class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100 bg-blue-50"
                                                data-notification-id="{{ $notification->id }}"
                                                @click="markNotificationAsRead('{{ $notification->id }}'); open = false;"
                                            >
                                                <x-notification-item :notification="$notification" />
                                            </a>
                                        @empty
                                            <div class="px-4 py-6 text-center text-sm text-gray-500">
                                                <i class="far fa-bell-slash text-2xl text-gray-300 mb-2"></i>
                                                <p>Nenhuma notificação nova</p>
                                            </div>
                                        @endforelse
                                        
                                        @if(auth()->user()->readNotifications->count() > 0 && auth()->user()->unreadNotifications->count() < 10)
                                            <div class="px-4 py-2 text-xs font-medium text-gray-500 border-t border-gray-100 bg-gray-50">
                                                Notificações anteriores
                                            </div>
                                            @foreach(auth()->user()->readNotifications->take(10 - auth()->user()->unreadNotifications->count()) as $notification)
                                                <a 
                                                    href="{{ $notification->data['url'] ?? '#' }}" 
                                                    class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100"
                                                    data-notification-id="{{ $notification->id }}"
                                                    @click="open = false"
                                                >
                                                    <x-notification-item :notification="$notification" />
                                                </a>
                                            @endforeach
                                        @endif
                                    </div>
                                    
                                    <div class="px-4 py-2 bg-gray-50 text-center border-t border-gray-200">
                                        <a 
                                            href="{{ route('admin.notifications.index') }}" 
                                            class="text-sm font-medium text-indigo-600 hover:text-indigo-900 inline-flex items-center"
                                            @click="open = false"
                                        >
                                            Ver todas as notificações
                                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- User Dropdown -->
                            <div class="relative ml-3" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Abrir menu do usuário</span>
                                    <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" alt="{{ auth()->user()->name }}">
                                </button>
                                
                                <div x-show="open" @click.away="open = false" class="absolute right-0 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu" style="display: none;">
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        <i class="fas fa-user mr-2"></i> Perfil
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        <i class="fas fa-cog mr-2"></i> Configurações
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Sair
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1 class="ml-4 text-lg font-semibold text-gray-900 hidden md:block">@yield('header')</h1>
                </div>
            </header>

            <!-- Global Alerts Container -->
            <div id="global-alerts" class="px-4 sm:px-6 lg:px-8 py-2 space-y-2">
                @if(session('success'))
                    <x-alert type="success" class="mb-4">
                        {{ session('success') }}
                    </x-alert>
                @endif
                
                @if(session('error'))
                    <x-alert type="error" class="mb-4">
                        {{ session('error') }}
                    </x-alert>
                @endif
                
                @if(session('warning'))
                    <x-alert type="warning" class="mb-4">
                        {{ session('warning') }}
                    </x-alert>
                @endif
                
                @if(session('info'))
                    <x-alert type="info" class="mb-4">
                        {{ session('info') }}
                    </x-alert>
                @endif
                
                @if($errors->any())
                    <x-alert type="error" class="mb-4">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert>
                @endif
            </div>

            <!-- Loading Overlay -->
            <div id="global-loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                <x-loading size="xl" color="indigo" text="Processando..." />
            </div>

            <!-- Breadcrumb -->
            <div class="bg-white border-b border-gray-200 px-4 py-3 sm:px-6 lg:px-8">
                @php
                    $breadcrumbs = [
                        ['label' => 'Painel', 'url' => route('admin.dashboard')],
                    ];
                    
                    // Adiciona itens adicionais ao breadcrumb baseado na rota atual
                    if (request()->routeIs('admin.mangas.*')) {
                        $breadcrumbs[] = ['label' => 'Mangás', 'url' => route('admin.mangas.index')];
                        
                        if (request()->routeIs('admin.mangas.create')) {
                            $breadcrumbs[] = ['label' => 'Adicionar Novo'];
                        } elseif (request()->routeIs('admin.mangas.edit')) {
                            $breadcrumbs[] = ['label' => 'Editar'];
                        }
                    }
                @endphp
                <x-breadcrumb :items="$breadcrumbs" />
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-50">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile sidebar -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="md:hidden fixed inset-0 z-20 bg-gray-900 bg-opacity-50" style="display: none;"></div>
    <div x-show="sidebarOpen" class="md:hidden fixed inset-y-0 left-0 z-30 w-64 bg-indigo-700 text-white transform transition-transform duration-300 ease-in-out" style="display: none;">
        <div class="flex items-center justify-between h-16 px-4 bg-indigo-800">
            <span class="text-xl font-bold">HikariReader</span>
            <button @click="sidebarOpen = false" class="text-gray-300 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <nav class="px-2 py-4 space-y-1">
            <a href="{{ route('admin.mangas.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.mangas.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600' }}">
                <i class="fas fa-book mr-3"></i>
                Mangás
            </a>
            <!-- Adicione mais itens do menu conforme necessário -->
        </nav>
    </div>

    @stack('scripts')
    
    <!-- Notification Scripts -->
    @auth
        <script>
            window.Laravel = {!! json_encode([
                'user' => [
                    'id' => auth()->id(),
                    'name' => auth()->user()->name,
                    'is_admin' => auth()->user()->is_admin,
                ],
                'pusher' => [
                    'key' => config('broadcasting.connections.pusher.key'),
                    'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                ],
            ]) !!};
        </script>
        @vite(['resources/js/admin/notifications.js'])
    @endauth
    
    <!-- Notification Sound -->
    <script src="{{ asset('js/notification-sound.js') }}"></script>
    
    <!-- Admin JS -->
    @vite('resources/js/admin.js')
    
    <script>
        // Configurações globais
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'baseUrl' => url('/'),
            'user' => [
                'id' => auth()->id(),
                'name' => auth()->user() ? auth()->user()->name : null,
                'email' => auth()->user() ? auth()->user()->email : null,
                'isAdmin' => auth()->user() ? auth()->user()->is_admin : false,
            ]
        ]) !!};
        
        // Inicialização do Alpine.js
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                open: window.innerWidth >= 768,
                toggle() {
                    this.open = !this.open;
                }
            });
            
            // Adicione outros stores globais do Alpine.js aqui
        });
    </script>
    
    <!-- Scripts personalizados da página -->
    @stack('page-scripts')
</body>
</html>
