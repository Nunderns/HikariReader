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
<body class="bg-gray-50 font-sans text-gray-900">
    <!-- Sidebar -->
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-indigo-700 text-white">
                <div class="flex items-center justify-center h-16 px-4 bg-indigo-800">
                    <span class="text-xl font-bold">HikariReader</span>
                </div>
                <nav class="flex-1 px-2 py-4 space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600' }}">
                        <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                        Dashboard
                    </a>
                    
                    <!-- Mangás -->
                    <a href="{{ route('admin.mangas.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.mangas.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600' }}">
                        <i class="fas fa-book mr-3 w-5 text-center"></i>
                        Mangás
                    </a>
                    
                    <!-- Capítulos -->
                    <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600">
                        <i class="fas fa-list-ol mr-3 w-5 text-center"></i>
                        Capítulos
                    </a>
                    
                    <!-- Usuários -->
                    <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600">
                        <i class="fas fa-users mr-3 w-5 text-center"></i>
                        Usuários
                    </a>
                    
                    <!-- Comentários -->
                    <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-indigo-100 hover:bg-indigo-600">
                        <i class="fas fa-comments mr-3 w-5 text-center"></i>
                        Comentários
                        <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">3</span>
                    </a>
                    
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
                        <div class="flex-shrink-0">
                            <img class="w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" alt="{{ auth()->user()->name }}">
                        </div>
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
                            <!-- Botão de notificações -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 relative">
                                    <i class="far fa-bell text-xl"></i>
                                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400"></span>
                                </button>
                                
                                <!-- Dropdown de notificações -->
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-200 focus:outline-none z-50" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95">
                                    <div class="px-4 py-3">
                                        <p class="text-sm font-medium text-gray-900">Notificações</p>
                                        <p class="mt-1 text-sm text-gray-500">Você tem 3 notificações não lidas</p>
                                    </div>
                                    <div class="py-1">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-user-plus text-green-500"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900">Novo usuário registrado</p>
                                                    <p class="text-xs text-gray-500">Há 5 minutos</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-book text-blue-500"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900">Novo mangá adicionado</p>
                                                    <p class="text-xs text-gray-500">Há 1 hora</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-comment text-yellow-500"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900">Novo comentário</p>
                                                    <p class="text-xs text-gray-500">Há 3 horas</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="px-4 py-2">
                                        <a href="#" class="block text-center text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                            Ver todas as notificações
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu do usuário -->
                            <div class="relative ml-3" x-data="{ open: false }">
                                <div>
                                    <button @click="open = !open" type="button" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Abrir menu do usuário</span>
                                        <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" alt="{{ auth()->user()->name }}">
                                        <span class="ml-2 text-sm font-medium text-gray-700 hidden md:inline-block">{{ auth()->user()->name }}</span>
                                        <i class="fas fa-chevron-down ml-1 text-gray-400 text-xs"></i>
                                    </button>
                                </div>

                                <!-- Menu suspenso do usuário -->
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        <i class="far fa-user mr-2"></i> Meu Perfil
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        <i class="fas fa-cog mr-2"></i> Configurações
                                    </a>
                                    <div class="border-t border-gray-100 my-1"></div>
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
