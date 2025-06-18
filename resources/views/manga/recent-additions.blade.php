@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="lg:w-3/4">
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Mangás Adicionados Recentemente</h1>
                
                <!-- Manga Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($mangas as $manga)
                        <div class="group relative">
                            <div class="aspect-[2/3] w-full overflow-hidden rounded-lg bg-gray-200">
                                <a href="{{ route('manga.show', $manga) }}" class="block h-full">
                                    <img src="{{ $manga->cover_url ?? asset('images/default-cover.jpg') }}" 
                                         alt="{{ $manga->title }}"
                                         class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                                </a>
                                @if($manga->chapters_count > 0)
                                    <div class="absolute bottom-2 left-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                        {{ $manga->chapters_count }} capítulos
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="absolute bottom-0 left-0 right-0 p-2">
                                        <h3 class="text-sm font-medium text-white line-clamp-2">
                                            {{ $manga->title }}
                                        </h3>
                                        @if($manga->latestChapter)
                                            <p class="text-xs text-gray-200 mt-1">
                                                Cap. {{ $manga->latestChapter->chapter_number }}
                                                <span class="text-xs text-gray-300">
                                                    • {{ $manga->latestChapter->created_at->diffForHumans() }}
                                                </span>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500">Nenhum mangá encontrado.</p>
                        </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                @if($mangas->hasPages())
                    <div class="mt-8">
                        {{ $mangas->links() }}
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:w-1/4">
            <!-- Latest Chapters -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Últimos Capítulos</h2>
                <div class="space-y-3">
                    @foreach($latestChapters as $chapter)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-16 overflow-hidden rounded">
                                <img src="{{ $chapter->manga->cover_url ?? asset('images/default-cover.jpg') }}" 
                                     alt="{{ $chapter->manga->title }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="ml-3 flex-1 min-w-0">
                                <h3 class="text-sm font-medium text-gray-900 truncate">
                                    <a href="{{ route('manga.show', $chapter->manga) }}" class="hover:text-indigo-600">
                                        {{ $chapter->manga->title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-gray-600">
                                    <a href="{{ route('chapter.show', [$chapter->manga, $chapter]) }}" class="hover:text-indigo-600">
                                        Cap. {{ $chapter->chapter_number }}
                                        @if($chapter->title)
                                            : {{ Str::limit($chapter->title, 30) }}
                                        @endif
                                    </a>
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $chapter->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Popular Tags -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Tags Populares</h2>
                <div class="flex flex-wrap gap-2">
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
