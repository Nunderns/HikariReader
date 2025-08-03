@extends('admin.layouts.app')

@section('title', 'Editar Autor/Artista: ' . $author->name)

@section('header')
    <h1 class="text-lg text-black-500">Editar Autor/Artista: {{ $author->name }}</h1>
    <a href="{{ route('admin.authors.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-600 disabled:opacity-25 transition">
        <i class="fas fa-arrow-left mr-2"></i> Voltar
    </a>
@endsection

@section('content')
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
        <form action="{{ route('admin.authors.update', $author) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nome -->
                <div class="col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nome <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', $author->name) }}" 
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        autofocus
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Biografia -->
                <div class="col-span-2">
                    <label for="biography" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Biografia
                    </label>
                    <textarea 
                        name="biography" 
                        id="biography" 
                        rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    >{{ old('biography', $author->biography) }}</textarea>
                    @error('biography')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tipo
                    </label>
                    <div class="flex space-x-4">
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="is_writer" 
                                id="is_writer" 
                                value="1"
                                {{ old('is_writer', $author->is_writer) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600"
                            >
                            <label for="is_writer" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Escritor
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="is_artist" 
                                id="is_artist" 
                                value="1"
                                {{ old('is_artist', $author->is_artist) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600"
                            >
                            <label for="is_artist" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Artista
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Twitter -->
                <div class="col-span-2">
                    <label for="twitter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Twitter
                    </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                            @
                        </span>
                        <input 
                            type="text" 
                            name="twitter" 
                            id="twitter" 
                            value="{{ old('twitter', $author->twitter) }}"
                            placeholder="nomeusuario"
                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        >
                    </div>
                    @error('twitter')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Twitter -->
                <div>
                    <label for="twitter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Twitter
                    </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                            @
                        </span>
                        <input 
                            type="text" 
                            name="twitter" 
                            id="twitter" 
                            value="{{ old('twitter', $author->twitter) }}"
                            placeholder="nomeusuario"
                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        >
                    </div>
                    @error('twitter')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-between items-center">
                <div>
                    <button type="button" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            onclick="if(confirm('Tem certeza que deseja excluir este autor/artista?')) { document.getElementById('delete-form').submit(); }"
                    >
                        <i class="fas fa-trash mr-2"></i> Excluir
                    </button>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.authors.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-save mr-2"></i> Salvar Alterações
                    </button>
                </div>
            </div>
        </form>

        <form id="delete-form" action="{{ route('admin.authors.destroy', $author) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
