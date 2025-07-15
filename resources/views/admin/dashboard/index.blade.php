@extends('admin.layouts.app')

@section('title', 'Painel de Controle')

@section('header', 'Visão Geral')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total de Mangás -->
    <x-card class="hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                <i class="fas fa-book text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm font-medium">Total de Mangás</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_mangas']) }}</p>
            </div>
        </div>
    </x-card>

    <!-- Total de Usuários -->
    <x-card class="hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm font-medium">Total de Usuários</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_users']) }}</p>
            </div>
        </div>
    </x-card>

    <!-- Mangás por Status -->
    <x-card class="hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-chart-pie text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm font-medium">Mangás por Status</h3>
                <div class="flex flex-wrap gap-2 mt-1">
                    @foreach($stats['mangas_by_status'] as $status => $count)
                        @php
                            $statusColors = [
                                'ongoing' => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'hiatus' => 'bg-yellow-100 text-yellow-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ][$status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="text-xs px-2 py-1 rounded-full {{ $statusColors }}">
                            {{ $count }} {{ ucfirst($status) }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </x-card>

    <!-- Ações Rápidas -->
    <x-card class="hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-bolt text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm font-medium">Ações Rápidas</h3>
                <div class="flex flex-wrap gap-2 mt-2">
                    <a href="{{ route('admin.mangas.create') }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-plus mr-1"></i> Novo Mangá
                    </a>
                    <a href="#" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-user-plus mr-1"></i> Novo Usuário
                    </a>
                </div>
            </div>
        </div>
    </x-card>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Últimos Mangás Adicionados -->
    <x-card title="Últimos Mangás Adicionados" class="h-full flex flex-col">
        <div class="divide-y divide-gray-200">
            @forelse($stats['recent_mangas'] as $manga)
                <div class="px-6 py-4 hover:bg-gray-50">
                    <div class="flex items-center">
                        <img class="h-10 w-10 rounded object-cover" src="{{ $manga->cover_url ?? 'https://via.placeholder.com/100x150?text=Sem+Capa' }}" alt="{{ $manga->title }}">
                        <div class="ml-4">
                            <a href="{{ route('manga.show', $manga->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                {{ $manga->title }}
                            </a>
                            <div class="text-sm text-gray-500">
                                {{ $manga->author }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-4 text-sm text-gray-500">
                    Nenhum mangá cadastrado ainda.
                </div>
            @endforelse
        </div>
        <x-slot name="footer">
            <div class="text-right">
                <a href="{{ route('admin.mangas.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                    Ver todos os mangás <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </x-slot>
    </x-card>

    <!-- Últimos Usuários Registrados -->
    <x-card title="Últimos Usuários Registrados" class="h-full flex flex-col">
        <div class="divide-y divide-gray-200">
            @forelse($stats['recent_users'] as $user)
                <div class="px-6 py-4 hover:bg-gray-50">
                    <div class="flex items-center">
                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="{{ $user->name }}">
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $user->name }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $user->email }}
                            </div>
                        </div>
                        <div class="ml-auto">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $user->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-4 text-sm text-gray-500">
                    Nenhum usuário registrado ainda.
                </div>
            @endforelse
        </div>
        <x-slot name="footer">
            <div class="text-right">
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                    Ver todos os usuários <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </x-slot>
    </x-card>
</div>

<!-- Gráfico de Mangás por Status (opcional) -->
<x-card title="Distribuição de Mangás por Status" class="mb-8">
    <div class="h-64 flex items-center justify-center">
        <div class="text-center text-gray-500">
            <i class="fas fa-chart-pie text-4xl mb-2"></i>
            <p>Gráfico de distribuição de mangás por status</p>
            <p class="text-sm">(Implementação do gráfico pode ser adicionada aqui)</p>
        </div>
    </div>
    
    <x-slot name="footer">
        <div class="text-sm text-gray-500">
            Dados atualizados em {{ now()->format('d/m/Y H:i') }}
        </div>
    </x-slot>
</x-card>

@push('scripts')
<script>
    // Aqui você pode adicionar JavaScript para gráficos usando Chart.js, por exemplo
    document.addEventListener('DOMContentLoaded', function() {
        // Código para inicializar gráficos irá aqui
        console.log('Dashboard carregado');
    });
</script>
@endpush
@endsection
