<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HikariReader</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white shadow-lg transform transition-transform duration-300 min-h-screen flex flex-col overflow-y-auto custom-scrollbar fixed top-0 left-0 h-full z-30">
            <div class="p-4 space-y-4">
                <div class="flex items-center justify-between mb-6">
                    <img src="{{ asset('images/logo.png') }}" alt="HikariReader" class="w-32">
                    <button id="closeSidebar" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <nav class="space-y-4">
                    <!-- Main Navigation -->
                    <div class="space-y-2">
                        <h3 class="text-gray-600 text-sm font-medium px-2">Seguindo</h3>
                        <a href="{{ route('updates') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Atualizações
                        </a>
                        <a href="{{ route('library.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                            Biblioteca
                        </a>
                        <a href="{{ route('bookmarks') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                            Marcadores
                        </a>
                        <a href="{{ route('groups.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Meus grupos
                        </a>
                        <a href="{{ route('history') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Histórico
                        </a>
                    </div>

                    <!-- Titles -->
                    <div class="space-y-2">
                        <h3 class="text-gray-600 text-sm font-medium px-2">Títulos</h3>
                        <a href="{{ route('advanced.search') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Pesquisa avançada
                        </a>
                        <a href="{{ route('recent.additions') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Adicionado Recentemente
                        </a>
                        <a href="{{ route('latest.updates') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Últimas atualizações
                        </a>
                        <a href="{{ route('random') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Aleatório
                        </a>
                    </div>

                    <!-- Community -->
                    <div class="space-y-2">
                        <h3 class="text-gray-600 text-sm font-medium px-2">Comunidade</h3>
                        <a href="{{ route('forum') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Fórum
                        </a>
                        <a href="{{ route('groups.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Grupos
                        </a>
                        <a href="{{ route('users') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Usuários
                        </a>
                    </div>

                    <!-- HikariReader -->
                    <div class="space-y-2">
                        <h3 class="text-gray-600 text-sm font-medium px-2">HikariReader</h3>
                        <a href="{{ route('about') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Sobre
                        </a>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header id="mainHeader" class="bg-white shadow-lg transition-all duration-300 ml-64">
                <div class="flex justify-between items-center px-6 py-4">
                    <!-- Mobile Menu Button -->
                    <button id="mobileMenuButton" style="display:none" class="lg:hidden text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Search Bar -->
                    <div class="flex-1 max-w-2xl">
                        <div class="relative">
                            <input type="text" placeholder="Pesquisar mangás..." 
                                   class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="relative">
                        <button id="settingsButton" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span class="sr-only">Configurações</span>
                        </button>
                        <div id="settingsMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg">
                            <div class="flex-1 overflow-y-auto p-4 custom-scrollbar">
                                <h3 class="text-gray-700 font-medium mb-4">Configurações</h3>
                                <div class="space-y-2">
                                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Temas</a>
                                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Interface de Linguagem</a>
                                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Idioma dos Capítulos</a>
                                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Filtro de Conteúdo</a>
                                    <div class="border-t border-gray-200 my-2"></div>
                                    
                                    @auth
                                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Perfil</a>
                                        <div class="border-t border-gray-200 my-2"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">
                                                Sair
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Logar</a>
                                        <a href="{{ route('register') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Registrar</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main id="mainContent" class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 transition-all duration-300 ml-64">
                <div class="container mx-auto px-6 py-8">
                    <!-- Main Content Will Go Here -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const closeSidebarButton = document.getElementById('closeSidebar');
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const mainContent = document.getElementById('mainContent');
            const header = document.getElementById('mainHeader');

            // Fecha a sidebar
            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.add('transform');
                // Remove ml-64 e adiciona ml-0
                if (mainContent) {
                    mainContent.classList.remove('ml-64');
                    mainContent.classList.add('ml-0');
                }
                if (header) {
                    header.classList.remove('ml-64');
                    header.classList.add('ml-0');
                }
                mobileMenuButton.style.display = 'inline-flex';
            }

            // Abre a sidebar
            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('transform');
                if (window.innerWidth >= 1024) {
                    if (mainContent) {
                        mainContent.classList.remove('ml-0');
                        mainContent.classList.add('ml-64');
                    }
                    if (header) {
                        header.classList.remove('ml-0');
                        header.classList.add('ml-64');
                    }
                }
                mobileMenuButton.style.display = 'none';
            }

            // Inicialização
            function initializeSidebar() {
                if (window.innerWidth >= 1024) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            }
            initializeSidebar();
            window.addEventListener('resize', initializeSidebar);

            // Botão para abrir sidebar
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', openSidebar);
            }
            // Botão para fechar sidebar
            if (closeSidebarButton) {
                closeSidebarButton.addEventListener('click', closeSidebar);
            }
            // Fecha sidebar ao clicar fora (apenas mobile)
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 1024 && sidebar && !sidebar.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                    if (!sidebar.classList.contains('-translate-x-full')) {
                        closeSidebar();
                    }
                }
            });
        }); 

        const settingsMenu = document.getElementById('settingsMenu');

        if (settingsButton && settingsMenu) {
            settingsMenu.classList.add('hidden');
            
            settingsButton.addEventListener('click', () => {
                settingsMenu.classList.toggle('hidden');
            });

            // Close settings menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!settingsMenu.contains(e.target) && !settingsButton.contains(e.target)) {
                    settingsMenu.classList.add('hidden');
                }
            });
        }

        // Smooth scrolling for anchor links only (links starting with #)
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#') {  // Only prevent default for anchor links
                    e.preventDefault();
                    const target = document.querySelector(href);
                    
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
    </script>
</body>
</html>
