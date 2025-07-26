<section class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
            @if(request('search'))
                Resultados para "{{ request('search') }}"
            @else
                Resultados da Busca
            @endif
        </h2>
        <span class="text-sm text-gray-500 dark:text-gray-400">
            {{ $mangas->total() }} {{ $mangas->total() === 1 ? 'resultado' : 'resultados' }} encontrados
        </span>
    </div>
    
    @if($mangas->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach($mangas as $manga)
                <a href="{{ route('manga.show', $manga->id) }}" class="block group">
                    <div class="relative overflow-hidden rounded-lg aspect-[2/3] mb-2 shadow-md">
                        <img 
                            src="{{ $manga->cover_url }}" 
                            alt="{{ $manga->title }}" 
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                            loading="lazy"
                            onerror="this.src='{{ asset('images/default-cover.jpg') }}'"
                        >
                        @if($manga->is_adult)
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">+18</span>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-3">
                            <div class="text-white text-sm">
                                <div class="flex items-center mb-1">
                                    <i class="fas fa-star text-yellow-400 mr-1 text-xs"></i>
                                    <span class="font-medium">{{ number_format($manga->rating, 1) }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $manga->views_count }} visualizações</span>
                                </div>
                                <div class="flex flex-wrap gap-1 mt-2">
                                    @if($manga->genres && is_array($manga->genres))
                                        @foreach(array_slice($manga->genres, 0, 2) as $genre)
                                            <span class="text-xs bg-indigo-600/90 text-white px-2 py-0.5 rounded-full">{{ $genre }}</span>
                                        @endforeach
                                        @if(count($manga->genres) > 2)
                                            <span class="text-xs bg-gray-700/90 text-white px-2 py-0.5 rounded-full">+{{ count($manga->genres) - 2 }}</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-2 bg-gradient-to-t from-black/80 to-transparent">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-medium text-white">
                                    {{ $manga->chapters_count }} {{ $manga->chapters_count === 1 ? 'Capítulo' : 'Capítulos' }}
                                </span>
                                @if($manga->status === 'ongoing')
                                    <span class="text-xs bg-green-500 text-white px-1.5 py-0.5 rounded">Ativo</span>
                                @elseif($manga->status === 'completed')
                                    <span class="text-xs bg-blue-500 text-white px-1.5 py-0.5 rounded">Completo</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <h3 class="font-medium text-sm text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 line-clamp-2 leading-tight">
                        {{ $manga->title }}
                    </h3>
                </a>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($mangas->hasPages())
            <div class="mt-8">
                {{ $mangas->withQueryString()->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900/50 mb-4">
                <i class="fas fa-search text-2xl text-indigo-600 dark:text-indigo-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Nenhum resultado encontrado</h3>
            <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">
                Não encontramos nenhum mangá com os critérios de busca atuais. Tente ajustar os filtros ou a palavra-chave.
            </p>
            @if(request()->hasAny(['search', 'status', 'genre', 'sort']))
                <div class="mt-4">
                    <a href="{{ route('manga.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-undo-alt mr-2"></i> Limpar Filtros
                    </a>
                </div>
            @endif
        </div>
    @endif
</section>
