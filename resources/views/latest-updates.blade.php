@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="lg:w-3/4">
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h1 class="text-2xl font-bold text-white mb-6">Últimas Atualizações</h1>
                
                <!-- Latest Chapters List -->
                <div class="space-y-4">
                    @forelse($chapters as $chapter)
                        <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <!-- Manga Cover -->
                            <div class="flex-shrink-0 w-16 h-20 overflow-hidden rounded-md">
                                <img src="{{ $chapter->manga->cover_url ?? asset('images/default-cover.jpg') }}" 
                                     alt="{{ $chapter->manga->title }}"
                                     class="w-full h-full object-cover">
                            </div>
                            
                            <!-- Chapter Info -->
                            <div class="ml-4 flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-white truncate">
                                    <a href="{{ route('manga.show', $chapter->manga) }}" class="text-white hover:text-indigo-300">
                                        {{ $chapter->manga->title }}
                                    </a>
                                </h3>
                                <div class="flex items-center text-sm text-gray-300">
                                    <a href="{{ route('chapter.show', [$chapter->manga, $chapter]) }}" 
                                       class="font-medium text-indigo-300 hover:text-indigo-100">
                                        Capítulo {{ $chapter->chapter_number }}
                                        @if($chapter->title)
                                            : {{ $chapter->title }}
                                        @endif
                                    </a>
                                    <span class="mx-2 text-gray-400">•</span>
                                    <span class="text-gray-300">{{ $chapter->created_at->diffForHumans() }}</span>
                                    <span class="mx-2 text-gray-400">•</span>
                                    <span class="text-gray-300">{{ $chapter->manga->chapters_count }} capítulos</span>
                                </div>
                                
                                <!-- Tags -->
                                <div class="mt-1 flex flex-wrap gap-1">
                                    @foreach($chapter->manga->tags->take(3) as $tag)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Read Button -->
                            <div class="ml-4">
                                <a href="{{ route('chapter.show', [$chapter->manga, $chapter]) }}" 
                                   class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Ler
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">Nenhum capítulo encontrado.</p>
                        </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                @if($chapters->hasPages())
                    <div class="mt-6">
                        {{ $chapters->links() }}
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:w-1/4">
            <!-- Recently Updated Mangas -->
            <div class="bg-white bg-opacity-10 rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-semibold text-white mb-4">Mangás Recentes</h2>
                <div class="space-y-4">
                    @foreach($mangas as $manga)
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-16 overflow-hidden rounded">
                                <img src="{{ $manga->cover_url ?? asset('images/default-cover.jpg') }}" 
                                     alt="{{ $manga->title }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('manga.show', $manga) }}" class="hover:text-indigo-600">
                                        {{ Str::limit($manga->title, 25) }}
                                    </a>
                                </h3>
                                <p class="text-xs text-gray-500">
                                    {{ $manga->chapters_count }} capítulos
                                </p>
                                @if($manga->latestChapter)
                                    <p class="text-xs text-gray-500">
                                        Cap. {{ $manga->latestChapter->chapter_number }}
                                        <span class="text-xs text-gray-400">
                                            • {{ $manga->latestChapter->created_at->diffForHumans() }}
                                        </span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Popular Tags -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Tags Populares</h2>
                <div class="flex flex-wrap gap-2">
                    @php
                        $popularTags = \App\Models\Tag::withCount('mangas')
                            ->orderBy('mangas_count', 'desc')
                            ->take(15)
                            ->get();
                    @endphp
                    
                    @foreach($popularTags as $tag)
                        <a href="{{ route('tag.show', $tag->slug) }}" 
                           class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200">
                            {{ $tag->name }}
                            <span class="ml-1 text-gray-500 text-xs">({{ $tag->mangas_count }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
