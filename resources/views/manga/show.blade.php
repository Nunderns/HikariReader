@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    @if($manga['is_adult'] || $manga['is_suggestive'])
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
        <p class="font-bold">Aviso de Conteúdo</p>
        <p>Este mangá contém conteúdo {{ $manga['is_adult'] ? 'para adultos' : 'sugestivo' }}. Por favor, verifique sua idade antes de continuar.</p>
    </div>
    @endif
    
    <!-- Header with Manga Title and Cover -->
    <div class="flex flex-col md:flex-row gap-8 mb-8">
        <!-- Cover Image -->
        <div class="w-full md:w-1/4 lg:w-1/5 relative">
            <img src="{{ $manga['cover_url'] }}" 
                 alt="{{ $manga['title'] }}" 
                 class="w-full rounded-lg shadow-lg transition-transform duration-300 hover:scale-105">
            
            <!-- Status Badge -->
            <div class="absolute top-2 right-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">
                {{ $manga['status'] }}
            </div>
            
            <!-- Adult/Suggestive Badge -->
            @if($manga['is_adult'])
            <div class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">
                18+
            </div>
            @elseif($manga['is_suggestive'])
            <div class="absolute top-2 left-2 bg-pink-600 text-white text-xs font-bold px-2 py-1 rounded">
                Sugestivo
            </div>
            @endif
        </div>
        
        <!-- Manga Info -->
        <div class="w-full md:w-3/4 lg:w-4/5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $manga['title'] }}</h1>
                    @if(!empty($manga['english_title']))
                    <h2 class="text-xl text-gray-600 dark:text-gray-300">{{ $manga['english_title'] }}</h2>
                    @endif
                </div>
                <div class="mt-2 md:mt-0">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                        </svg>
                        Favoritar
                    </button>
                </div>
            </div>
            
            <!-- Rating and Stats -->
            <div class="flex flex-wrap items-center gap-6 mb-6">
                <!-- Rating -->
                <div class="flex items-center bg-white dark:bg-gray-800 p-3 rounded-lg shadow">
                    <div class="text-4xl font-bold text-yellow-500 mr-3">
                        {{ number_format($manga['rating'] ?? 0, 1) }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($manga['rating'] / 2))
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @elseif($i == ceil($manga['rating'] / 2) && $manga['rating'] % 2 >= 0.5)
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <defs>
                                            <linearGradient id="half-star" x1="0" x2="50%" y1="0" y2="0">
                                                <stop offset="50%" stop-color="#F59E0B" />
                                                <stop offset="50%" stop-color="#D1D5DB" />
                                            </linearGradient>
                                        </defs>
                                        <path fill="url(#half-star)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endif
                            @endfor
                            <span class="ml-2">{{ number_format($manga['rating'] ?? 0, 1) }}</span>
                        </div>
                        <div class="text-gray-500 dark:text-gray-400">
                            ({{ number_format($manga['ratings_count'] ?? 0) }} avaliações)
                        </div>
                    </div>
                </div>
                
                <!-- Views -->
                <div class="flex items-center bg-white dark:bg-gray-800 p-3 rounded-lg shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Visualizações</div>
                        <div class="font-semibold">{{ number_format($manga['view_count']) }}</div>
                    </div>
                </div>
                
                <!-- Chapters -->
                <div class="flex items-center bg-white dark:bg-gray-800 p-3 rounded-lg shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.478 3 6.253v13C4.168 18.497 5.754 18 7.5 18s3.332.497 4.5 1.253m0-13C13.168 5.478 14.754 5 16.5 5c1.747 0 3.332.478 4.5 1.253v13C19.832 18.497 18.247 18 16.5 18c-1.746 0-3.332.497-4.5 1.253" />
                    </svg>
                    <div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Capítulos</div>
                        <div class="font-semibold">{{ count($manga['chapters'] ?? []) }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Rating Distribution -->
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
                <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Distribuição de Avaliações</h3>
                <div class="space-y-2">
                    @for($i = 10; $i >= 1; $i--)
                        @php
                            $count = $manga['rating_distribution'][$i] ?? 0;
                            $percentage = isset($manga['ratings_count']) && $manga['ratings_count'] > 0 
                                ? ($count / $manga['ratings_count']) * 100 
                                : 0;
                        @endphp
                        <div class="flex items-center">
                            <span class="w-8 text-right pr-2">{{ $i }}</span>
                            <div class="w-48 h-4 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="ml-2 text-sm text-gray-600">({{ $count }})</span>
                        </div>
                    @endfor
                </div>
            </div>
            
            <!-- Genres & Themes -->
            @if(!empty($manga['genres']) || !empty($manga['themes']))
            <div class="mb-6">
                @if(!empty($manga['genres']))
                <div class="mb-3">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Gêneros</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($manga['genres'] as $genre)
                            <a href="#" class="px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm rounded-full transition-colors duration-200">
                                {{ $genre }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if(!empty($manga['themes']))
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Temas</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($manga['themes'] as $theme)
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">
                                {{ $theme }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endif
            
            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 mb-6">
                <button class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                    </svg>
                    Ler Agora
                </button>
                <button class="flex-1 md:flex-none bg-white hover:bg-gray-100 text-gray-800 font-medium py-2 px-4 border border-gray-300 rounded-lg flex items-center justify-center transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    Avaliar
                </button>
                <button class="md:hidden flex-1 bg-white hover:bg-gray-100 text-gray-800 font-medium py-2 px-4 border border-gray-300 rounded-lg flex items-center justify-center transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                    </svg>
                    Notificar
                </button>
            </div>
        </div>
    </div>
    
    <!-- Manga Tabs -->
    <div class="sticky top-0 z-10 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 mb-6">
        <nav class="flex overflow-x-auto" x-data="{ activeTab: 'overview' }">
            <button 
                @click="activeTab = 'overview'" 
                :class="{ 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'overview' }"
                class="px-4 py-3 text-sm font-medium whitespace-nowrap focus:outline-none text-gray-700 dark:text-gray-200"
            >
                Visão Geral
            </button>
            <button 
                @click="activeTab = 'chapters'" 
                :class="{ 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'chapters' }"
                class="px-4 py-3 text-sm font-medium whitespace-nowrap focus:outline-none text-gray-700 dark:text-gray-200"
            >
                Capítulos ({{ count($manga['chapters'] ?? []) }})
            </button>
            <button 
                @click="activeTab = 'reviews'" 
                :class="{ 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'reviews' }"
                class="px-4 py-3 text-sm font-medium whitespace-nowrap focus:outline-none text-gray-700 dark:text-gray-200"
            >
                Avaliações ({{ $manga['ratings_count'] ?? 0 }})
            </button>
            <button 
                @click="activeTab = 'recommendations'" 
                :class="{ 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'recommendations' }"
                class="px-4 py-3 text-sm font-medium whitespace-nowrap focus:outline-none text-gray-700 dark:text-gray-200"
            >
                Recomendações
            </button>
        </nav>
    </div>
    
    <!-- Tab Content -->
    <div class="mb-8" x-data="{ activeTab: 'overview' }">
        <!-- Overview Tab -->
        <div x-show="activeTab === 'overview'">
            <!-- Synopsis -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Sinopse</h3>
                <div class="prose max-w-none text-gray-700 dark:text-gray-300">
                    <p class="leading-relaxed">{{ $manga['description'] ?? 'Nenhuma descrição disponível.' }}</p>
                </div>
            </div>
            
            <!-- Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Informações</h3>
                    <div class="space-y-3">
                        <div class="flex border-b border-gray-100 dark:border-gray-700 pb-2">
                            <span class="w-32 text-gray-500 dark:text-gray-400">Tipo:</span>
                            <span class="font-medium">Mangá</span>
                        </div>
                        <div class="flex border-b border-gray-100 dark:border-gray-700 pb-2">
                            <span class="w-32 text-gray-500 dark:text-gray-400">Status:</span>
                            <span class="font-medium">{{ $manga['status'] }}</span>
                        </div>
                        @if($manga['published_date'])
                        <div class="flex border-b border-gray-100 dark:border-gray-700 pb-2">
                            <span class="w-32 text-gray-500 dark:text-gray-400">Publicação:</span>
                            <span class="font-medium">{{ $manga['published_date'] }}</span>
                        </div>
                        @endif
                        @if(!empty($manga['author']))
                        <div class="flex border-b border-gray-100 dark:border-gray-700 pb-2">
                            <span class="w-32 text-gray-500 dark:text-gray-400">Autor:</span>
                            <a href="#" class="text-blue-600 hover:underline">{{ $manga['author'] }}</a>
                        </div>
                        @endif
                        @if(!empty($manga['artist']) && $manga['artist'] !== $manga['author'])
                        <div class="flex border-b border-gray-100 dark:border-gray-700 pb-2">
                            <span class="w-32 text-gray-500 dark:text-gray-400">Artista:</span>
                            <a href="#" class="text-blue-600 hover:underline">{{ $manga['artist'] }}</a>
                        </div>
                        @endif
                        @if(!empty($manga['serialization']))
                        <div class="flex border-b border-gray-100 dark:border-gray-700 pb-2">
                            <span class="w-32 text-gray-500 dark:text-gray-400">Serialização:</span>
                            <span class="font-medium">{{ $manga['serialization'] }}</span>
                        </div>
                        @endif
                        @if(!empty($manga['demographic']))
                        <div class="flex">
                            <span class="w-32 text-gray-500 dark:text-gray-400">Demografia:</span>
                            <span class="font-medium">{{ $manga['demographic'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Alternative Titles -->
                @if(!empty($manga['alternative_titles']))
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Títulos Alternativos</h3>
                    <div class="space-y-3">
                        @foreach($manga['alternative_titles'] as $type => $title)
                            <div class="flex border-b border-gray-100 dark:border-gray-700 pb-2">
                                <span class="w-24 text-gray-500 dark:text-gray-400 capitalize">{{ $type }}:</span>
                                <span class="font-medium">{{ $title }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Related Content -->
            <div class="mt-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Conteúdo Relacionado</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <!-- Placeholder for related content -->
                    @for($i = 0; $i < 6; $i++)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow duration-200">
                        <div class="aspect-w-2 aspect-h-3">
                            <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 animate-pulse"></div>
                        </div>
                        <div class="p-2">
                            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-3/4 mb-2 animate-pulse"></div>
                            <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-1/2 animate-pulse"></div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
        
        <!-- Chapters Tab -->
        <div x-show="activeTab === 'chapters'" x-cloak>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Capítulos</h3>
                    <div class="flex items-center space-x-2">
                        <button class="p-1 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" />
                            </svg>
                        </button>
                        <button class="p-1 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($manga['chapters'] as $chapter)
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 text-sm font-medium text-gray-900 dark:text-white">
                                    Cap. {{ $chapter['number'] }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $chapter['title'] ?? 'Sem título' }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $chapter['date'] }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                                    Ler
                                </a>
                                <button class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                        Nenhum capítulo disponível no momento.
                    </div>
                    @endforelse
                </div>
                
                @if(count($manga['chapters']) > 10)
                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 text-right sm:px-6">
                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Carregar mais capítulos
                    </button>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Reviews Tab -->
        <div x-show="activeTab === 'reviews'" x-cloak>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Avaliações</h3>
                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Escrever Avaliação
                    </button>
                </div>
                
                <!-- Review Summary -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row items-center md:items-start">
                        <div class="text-center md:text-left mb-6 md:mb-0 md:mr-12">
                            <div class="text-5xl font-bold text-gray-900 dark:text-white mb-2">{{ number_format($manga['rating'], 1) }}</div>
                            <div class="flex justify-center md:justify-start mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($manga['rating']))
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @elseif($i - 0.5 <= $manga['rating'])
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <defs>
                                                <linearGradient id="half-star" x1="0" x2="100%" y1="0" y2="0">
                                                    <stop offset="50%" stop-color="currentColor" />
                                                    <stop offset="50%" stop-color="#D1D5DB" />
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#half-star)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $manga['rating_count'] }} avaliações</p>
                        </div>
                        
                        <!-- Rating Distribution -->
                        <div class="flex-1 w-full">
                            @for($i = 5; $i >= 1; $i--)
                                <div class="flex items-center mb-1">
                                    <span class="w-8 text-sm font-medium text-gray-500 dark:text-gray-400">{{ $i }}</span>
                                    <svg class="w-4 h-4 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mr-2">
                                        @php
                                            $totalRatings = array_sum($manga['rating_distribution'] ?? []);
                                            $percentage = ($totalRatings > 0 && isset($manga['rating_distribution'][$i])) 
                                                ? ($manga['rating_distribution'][$i] / $totalRatings) * 100 
                                                : 0;
                                        @endphp
                                        <div class="bg-yellow-400 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="text-xs w-10 text-gray-500 dark:text-gray-400">{{ $manga['rating_distribution'][$i] ?? 0 }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                
                <!-- Reviews List -->
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($manga['reviews'] ?? [] as $review)
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-gray-600 dark:text-gray-300 font-semibold">
                                {{ substr($review['user']['name'] ?? 'U', 0, 2) }}
                            </div>
                            <div class="ml-3">
                                <h4 class="font-medium text-gray-900 dark:text-white">{{ $review['user']['name'] ?? 'Usuário' }}</h4>
                                <div class="flex items-center">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= ($review['rating'] ?? 0) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-300 ml-2">{{ $review['date'] ?? 'Agora mesmo' }}</span>
                                </div>
                            </div>
                        </div>
                        @if(!empty($review['title']))
                        <h5 class="font-medium text-gray-900 dark:text-white mb-2">{{ $review['title'] }}</h5>
                        @endif
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            {{ $review['content'] ?? 'Sem conteúdo' }}
                        </p>
                        <div class="flex items-center mt-3 text-sm">
                            <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex items-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                                {{ $review['likes'] ?? 0 }}
                            </button>
                            <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Responder
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                        Nenhuma avaliação encontrada. Seja o primeiro a avaliar!
                    </div>
                    @endforelse
                    
                    @if(count($manga['reviews'] ?? []) > 5)
                    <div class="p-6 text-center">
                        <button class="px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                            Carregar mais avaliações
                        </button>
                    </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recommendations Tab -->
        <div x-show="activeTab === 'recommendations'" x-cloak>
            @if(isset($manga['recommended_manga']) && $manga['recommended_manga']->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    @foreach($manga['recommended_manga'] as $recommended)
                    <a href="{{ route('manga.show', $recommended->id) }}" class="block bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow duration-200">
                        <div class="aspect-w-2 aspect-h-3 relative">
                            <img 
                                src="{{ $recommended->cover_url ?? 'https://via.placeholder.com/300x450?text=No+Cover' }}" 
                                alt="{{ $recommended->title }}" 
                                class="w-full h-64 object-cover"
                                onerror="this.src='https://via.placeholder.com/300x450?text=No+Cover'"
                            >
                            @if($recommended->rating > 0)
                            <div class="absolute top-2 right-2 bg-yellow-500 text-white text-xs px-2 py-1 rounded flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                {{ number_format($recommended->rating, 1) }}
                            </div>
                            @endif
                        </div>
                        <div class="p-3">
                            <h4 class="font-medium text-sm text-gray-900 dark:text-white line-clamp-2 mb-1">
                                {{ $recommended->title }}
                            </h4>
                            @if(!empty($recommended->genres) && is_array($recommended->genres))
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                    {{ implode(', ', array_slice($recommended->genres, 0, 2)) }}
                                </p>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
                
                <div class="mt-6 text-center">
                    <a href="{{ route('advanced.search') }}" class="inline-block px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        Ver mais recomendações
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Nenhuma recomendação disponível</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Não encontramos recomendações para este mangá no momento.</p>
                    <div class="mt-6">
                        <a href="{{ route('advanced.search') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Buscar Mangás
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 mt-12">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex justify-center md:justify-start space-x-6">
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Facebook</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Twitter</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Instagram</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75-4.365-9.75-9.75-9.75zm0 18.75a8.25 8.25 0 01-8.25-8.25v-.5a8.25 8.25 0 0116.5 0v.5a8.25 8.25 0 01-8.25 8.25z" clip-rule="evenodd" />
                        <path d="M12 13.25a4.75 4.75 0 01-4.75 4.75v-.5a4.75 4.75 0 0119.5 0v.5a4.75 4.75 0 01-4.75-4.75zm0-11.25a3.5 3.5 0 00-3.5 3.5v-.5a3.5 3.5 0 007 0v.5a3.5 3.5 0 00-3.5-3.5z" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Discord</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M20.222 0c1.406 0 2.54 1.137 2.607 2.475V24l-2.677-2.273-1.47-1.338-1.604-1.398.67 2.205H3.71c-1.402 0-2.54-1.038-2.54-2.475V2.48C1.17 1.142 2.31.003 3.715.003h16.5L20.222 0zm-1.09 6.558v.955h3.014v10.64h-2.59v-1.11h-4.173v-1.112h4.172v-1.112h-4.172v-1.112h4.172v-1.112h-4.172V9.91h4.172V8.78h-4.172V7.66h4.172v-.888l.005-.214zM14.91 6.56v11.765l-2.258-1.866V8.426L14.91 6.56zm-9.35 3.118v8.187H3.17V9.678h2.388zm.034-3.118v2.23h4.598v2.074H5.152v2.23h4.598v2.07H5.151v2.232h4.6v2.074H3.17V3.48h2.39v2.18h.014z" />
                    </svg>
                </a>
            </div>
            <div class="mt-8 md:mt-0 text-center md:text-right">
                <p class="text-base text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} HikariReader. Todos os direitos reservados.
                </p>
                <p class="text-sm text-gray-400 mt-1">
                    Este site não hospeda nenhum arquivo. Todo o conteúdo é fornecido por fontes de terceiros.
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Back to top button -->
<button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" x-show="window.scrollY > 300" class="fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 z-50">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
    <span class="sr-only">Voltar ao topo</span>
</button>

@push('scripts')
<script>
    // Back to top button visibility
    document.addEventListener('alpine:init', () => {
        Alpine.store('app', {
            scrollY: window.scrollY
        });
    });
    
    window.addEventListener('scroll', () => {
        Alpine.store('app').scrollY = window.scrollY;
    });
</script>
@endpush
@endsection
