@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Gerenciamento de Usuários</h1>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="p-4 border-b border-gray-200">
            <form action="{{ route('users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-grow">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Buscar usuários..." 
                               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <select name="sort" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="name" {{ request('sort', 'name') === 'name' ? 'selected' : '' }}>Nome</option>
                        <option value="email" {{ request('sort') === 'email' ? 'selected' : '' }}>E-mail</option>
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Data de Criação</option>
                    </select>
                    <select name="order" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="asc" {{ request('order', 'asc') === 'asc' ? 'selected' : '' }}>Crescente</option>
                        <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>Decrescente</option>
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Aplicar
                    </button>
                    <a href="{{ route('users.index') }}" class="text-gray-600 hover:text-gray-800 ml-2">
                        Limpar
                    </a>
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('users.index', array_merge(request()->except('page'), ['sort' => 'name', 'order' => request('sort') === 'name' && request('order', 'asc') === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center">
                                Nome
                                @if(request('sort') === 'name' || (!request('sort') && !request('order')))
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('users.index', array_merge(request()->except('page'), ['sort' => 'email', 'order' => request('sort') === 'email' && request('order') === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center">
                                E-mail
                                @if(request('sort') === 'email')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('users.index', array_merge(request()->except('page'), ['sort' => 'created_at', 'order' => request('sort') === 'created_at' && request('order') === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center">
                                Data de Criação
                                @if(request('sort') === 'created_at')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-600 font-medium">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:text-blue-900 mr-4">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                Nenhum usuário encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $users->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
