@extends('admin.layouts.app')

@section('title', 'Gerenciar Mangás')

@section('header', 'Gerenciar Mangás')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <div class="flex flex-col space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Lista de Mangás
                </h3>
                <a href="{{ route('admin.mangas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus mr-2"></i> Adicionar Mangá
                </a>
            </div>
            
            <!-- Search and Filter Form -->
            <form method="GET" action="{{ route('admin.mangas.index') }}" class="space-y-4 sm:space-y-0 sm:flex sm:space-x-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <label for="search" class="sr-only">Pesquisar</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md" placeholder="Pesquisar por título, autor...">
                    </div>
                </div>
                
                <!-- Status Filter -->
                <div class="w-full sm:w-48">
                    <label for="status" class="sr-only">Status</label>
                    <select id="status" name="status" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" {{ request('status', 'all') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Genre Filter -->
                <div class="w-full sm:w-48">
                    <label for="genre" class="sr-only">Gênero</label>
                    <select id="genre" name="genre" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="all">Todos os Gêneros</option>
                        @foreach($allGenres as $genre)
                            <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>{{ $genre }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Submit Button -->
                <div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-filter mr-2"></i> Filtrar
                    </button>
                    @if(request()->hasAny(['search', 'status', 'genre']) && request('status') !== 'all' || request('genre') !== 'all')
                        <a href="{{ route('admin.mangas.index') }}" class="ml-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Limpar
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
    
    <div class="bg-white overflow-hidden">
        @if($mangas->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Capa
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Título
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Autor
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($mangas as $manga)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex-shrink-0 h-16 w-12">
                                        <img class="h-16 w-12 object-cover rounded" src="{{ $manga->cover_url ?? 'https://via.placeholder.com/100x150?text=Sem+Capa' }}" alt="{{ $manga->title }}">
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $manga->title }}</div>
                                    @if($manga->english_title)
                                        <div class="text-sm text-gray-500">{{ $manga->english_title }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $manga->author }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('manga.show', $manga->id) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.mangas.edit', $manga->id) }}" class="text-blue-600 hover:text-blue-900" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.mangas.destroy', $manga->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este mangá? Esta ação não pode ser desfeita.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $mangas->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum mangá encontrado</h3>
                <p class="mt-1 text-sm text-gray-500">Comece adicionando um novo mangá.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.mangas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-plus -ml-1 mr-2 h-5 w-5"></i>
                        Novo Mangá
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
