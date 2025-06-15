@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Atualizações Recentes</h1>
                <p class="text-gray-600 mt-2">Confira as últimas atualizações dos seus mangás favoritos</p>
            </div>
            <div class="text-sm text-gray-500">
                {{ $recentUpdates->total() }} atualizações no total
            </div>
        </div>
        
        @if($recentUpdates->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <ul class="divide-y divide-gray-200">
                    @foreach($recentUpdates as $update)
                        <li class="hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-blue-600 truncate">
                                            <a href="{{ route('manga.show', $update->manga->slug) }}">
                                                {{ $update->manga->title }}
                                            </a>
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            {{ $update->title }}
                                        </p>
                                    </div>
                                    <div class="ml-4 flex-shrink-0 flex">
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500">
                                                {{ $update->created_at->diffForHumans() }}
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                Por {{ $update->user->name }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-4">
                {{ $recentUpdates->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma atualização recente</h3>
                <p class="mt-1 text-sm text-gray-500">Parece que não há atualizações disponíveis no momento.</p>
            </div>
        @endif
    </div>
@endsection
