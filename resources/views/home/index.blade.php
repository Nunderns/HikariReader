@extends('layouts.app')

@section('content')
    <!-- Featured Mangas -->
    <section class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Destaque da Semana</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Featured Manga Cards -->
            @forelse($featuredMangas as $manga)
                <a href="{{ route('manga.show', $manga->id) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <img src="{{ $manga->thumbnail_url }}" alt="{{ $manga->title }}" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">{{ $manga->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $manga->description }}</p>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <span>{{ $manga->chapters_count }} Capítulos</span>
                            <span>•</span>
                            <span>{{ $manga->views_count }} Visualizações</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-600">Nenhum mangá em destaque no momento</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Popular Mangas -->
    <section class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Mangás Populares</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Popular Manga Cards -->
            @forelse($popularMangas as $manga)
                <a href="{{ route('manga.show', $manga->id) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <img src="{{ $manga->thumbnail_url }}" alt="{{ $manga->title }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">{{ $manga->title }}</h3>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <span>{{ $manga->chapters_count }} Capítulos</span>
                            <span>•</span>
                            <span>{{ $manga->views_count }} Visualizações</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-600">Nenhum mangá popular no momento</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Recent Chapters -->
    <section class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Capítulos Recentes</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Recent Chapter Cards -->
            @forelse($recentChapters as $chapter)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">{{ $chapter->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ $chapter->manga->title }}</p>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <span>{{ $chapter->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-600">Nenhum capítulo recente no momento</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Recent Mangas -->
    <section class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Mangás Recentes</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Recent Manga Cards -->
            @forelse($recentMangas as $manga)
                <a href="{{ route('manga.show', $manga->id) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <img src="{{ $manga->thumbnail_url }}" alt="{{ $manga->title }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">{{ $manga->title }}</h3>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <span>{{ $manga->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-600">Nenhum mangá recente no momento</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
