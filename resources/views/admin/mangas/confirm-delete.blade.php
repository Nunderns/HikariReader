@extends('admin.layouts.app')

@section('title', 'Confirmar Exclusão')

@section('header', 'Confirmar Exclusão')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-4 py-5 sm:p-6">
        <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Excluir Mangá
                </h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">
                        Tem certeza de que deseja excluir o mangá <span class="font-semibold">{{ $manga->title }}</span>? Esta ação não pode ser desfeita.
                        Todos os capítulos e imagens associados também serão removidos permanentemente.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <a href="{{ route('admin.mangas.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
            Cancelar
        </a>
        <form action="{{ route('admin.mangas.destroy', $manga->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Sim, excluir mangá
            </button>
        </form>
    </div>
</div>

<div class="mt-8 bg-white shadow rounded-lg overflow-hidden">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Detalhes do Mangá
        </h3>
    </div>
    <div class="px-4 py-5 sm:p-6">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Cover Image -->
            <div class="w-full md:w-1/4">
                <img src="{{ $manga->cover_url ?? 'https://via.placeholder.com/200x300?text=Sem+Imagem' }}" 
                     alt="{{ $manga->title }}" 
                     class="w-full rounded-lg shadow">
            </div>
            
            <!-- Manga Details -->
            <div class="flex-1">
                <div class="mb-4">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $manga->title }}</h2>
                    @if($manga->english_title)
                        <p class="text-lg text-gray-600">{{ $manga->english_title }}</p>
                    @endif
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Autor</p>
                        <p class="text-sm text-gray-900">{{ $manga->author }}</p>
                    </div>
                    
                    @if($manga->artist)
                    <div>
                        <p class="text-sm font-medium text-gray-500">Artista</p>
                        <p class="text-sm text-gray-900">{{ $manga->artist }}</p>
                    </div>
                    @endif
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status</p>
                        @php
                            $statusClasses = [
                                'ongoing' => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'hiatus' => 'bg-yellow-100 text-yellow-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                'not_yet_published' => 'bg-gray-100 text-gray-800',
                            ][$manga->status] ?? 'bg-gray-100 text-gray-800';
                            
                            $statusText = [
                                'ongoing' => 'Em andamento',
                                'completed' => 'Completo',
                                'hiatus' => 'Em hiato',
                                'cancelled' => 'Cancelado',
                                'not_yet_published' => 'Não publicado',
                            ][$manga->status] ?? 'Desconhecido';
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses }}">
                            {{ $statusText }}
                        </span>
                    </div>
                    
                    @if($manga->published_date)
                    <div>
                        <p class="text-sm font-medium text-gray-500">Publicação</p>
                        <p class="text-sm text-gray-900">{{ $manga->published_date->format('d/m/Y') }}</p>
                    </div>
                    @endif
                    
                    @if($manga->demographic)
                    <div>
                        <p class="text-sm font-medium text-gray-500">Demografia</p>
                        <p class="text-sm text-gray-900">{{ $manga->demographic }}</p>
                    </div>
                    @endif
                    
                    @if($manga->serialization)
                    <div>
                        <p class="text-sm font-medium text-gray-500">Serialização</p>
                        <p class="text-sm text-gray-900">{{ $manga->serialization }}</p>
                    </div>
                    @endif
                    
                    @php
                        $genres = json_decode($manga->genres, true);
                    @endphp
                    @if(!empty($genres) && is_array($genres))
                    <div class="col-span-1 sm:col-span-2">
                        <p class="text-sm font-medium text-gray-500">Gêneros</p>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach($genres as $genre)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $genre }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                
                @if($manga->is_adult || $manga->is_suggestive)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-sm font-medium text-gray-500">Classificação</p>
                    <div class="mt-1">
                        @if($manga->is_adult)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mr-2">
                                +18 Conteúdo Adulto
                            </span>
                        @endif
                        @if($manga->is_suggestive)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                Conteúdo Sugestivo
                            </span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Description -->
        @if($manga->description)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Sinopse</h3>
            <div class="prose max-w-none text-gray-700">
                {!! nl2br(e($manga->description)) !!}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Chapters Summary -->
<div class="mt-8 bg-white shadow rounded-lg overflow-hidden">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Capítulos que serão excluídos
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            {{ $manga->chapters_count ?? 0 }} capítulos serão removidos permanentemente.
        </p>
    </div>
    
    @if($manga->chapters_count > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Capítulo
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Título
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Páginas
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Data
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($manga->chapters()->orderBy('number', 'desc')->take(5)->get() as $chapter)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $chapter->number }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $chapter->title ?? 'Sem título' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $chapter->pages ?? 0 }} páginas
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $chapter->created_at->format('d/m/Y') }}
                    </td>
                </tr>
                @endforeach
                
                @if($manga->chapters_count > 5)
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                        E mais {{ $manga->chapters_count - 5 }} capítulos...
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    @else
    <div class="px-6 py-4 text-center text-sm text-gray-500">
        Nenhum capítulo encontrado para este mangá.
    </div>
    @endif
</div>

<!-- Final Confirmation -->
<div class="mt-8 bg-white shadow rounded-lg overflow-hidden">
    <div class="px-4 py-5 sm:p-6">
        <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Confirmação Final
                </h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">
                        Você está prestes a excluir permanentemente este mangá e todo o seu conteúdo associado. 
                        Esta ação não pode ser desfeita. Tem certeza de que deseja continuar?
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <a href="{{ route('admin.mangas.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
            Cancelar
        </a>
        <form action="{{ route('admin.mangas.destroy', $manga->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Sim, excluir permanentemente
            </button>
        </form>
    </div>
</div>
@endsection
