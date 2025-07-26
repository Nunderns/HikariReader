@extends('admin.layouts.app')

@section('title', 'Confirmar Exclusão de Gênero')

@section('header')
<h1 class="text-lg text-gray-900 dark:text-white">Confirmar Exclusão de Gênero</h1>
@endsection

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="bg-red-50 dark:bg-red-900 dark:bg-opacity-20 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                        Atenção: Você está prestes a excluir o gênero "{{ $genre->name }}"
                    </h3>
                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                        <p>
                            Esta ação não pode ser desfeita. O gênero será removido permanentemente do sistema.
                            @if($mangaCount > 0)
                                <br>
                                <strong>Este gênero está associado a {{ $mangaCount }} {{ Str::plural('mangá', $mangaCount) }}. A remoção irá desassociá-lo desses itens.</strong>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <form action="{{ route('admin.genres.destroy', $genre) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-trash mr-2"></i> Sim, excluir permanentemente
                </button>
            </form>

            <a href="{{ route('admin.genres.index') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600">
                Cancelar
            </a>
        </div>
    </div>
</div>
@endsection
