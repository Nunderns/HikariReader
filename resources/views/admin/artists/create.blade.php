@extends('admin.layouts.app')

@section('title', 'Adicionar Artista')

@section('header')
<h1 class="text-lg text-black-500">Adicionar Novo Artista</h1>
@endsection

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <form action="{{ route('admin.artists.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Nome do Artista -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome do Artista</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md">
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descrição -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                    <div class="mt-1">
                        <textarea name="description" id="description" rows="3" 
                                  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md">{{ old('description') }}</textarea>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Uma breve descrição sobre o artista (opcional)</p>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Links do Artista -->
                <div class="space-y-4">
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Website</label>
                        <div class="mt-1">
                            <input type="url" name="website" id="website" value="{{ old('website') }}" 
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md"
                                   placeholder="https://exemplo.com">
                        </div>
                        @error('website')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="twitter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Twitter</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">@</span>
                            </div>
                            <input type="text" name="twitter" id="twitter" value="{{ old('twitter') }}" 
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 sm:text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md"
                                   placeholder="nomeusuario">
                        </div>
                        @error('twitter')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="pixiv" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pixiv ID</label>
                        <div class="mt-1">
                            <input type="text" name="pixiv" id="pixiv" value="{{ old('pixiv') }}" 
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md"
                                   placeholder="1234567">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Apenas o ID do perfil do Pixiv (opcional)</p>
                        @error('pixiv')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Outros Links -->
                <div id="other-links-container">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Outros Links</label>
                        <button type="button" onclick="addLinkField()" class="text-xs text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                            <i class="fas fa-plus mr-1"></i> Adicionar Link
                        </button>
                    </div>
                    
                    <div id="link-fields">
                        <!-- Link fields will be added here dynamically -->
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.artists.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-save mr-2"></i> Salvar Artista
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Template for dynamic link fields -->
<template id="link-template">
    <div class="link-field mb-3 p-3 border border-gray-200 dark:border-gray-700 rounded-md">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-5">
                <input type="text" name="other_links[][name]" 
                       class="link-name shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md" 
                       placeholder="Nome do site" required>
            </div>
            <div class="md:col-span-6">
                <input type="url" name="other_links[][url]" 
                       class="link-url shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md" 
                       placeholder="https://exemplo.com" required>
            </div>
            <div class="md:col-span-1 flex items-center justify-end">
                <button type="button" onclick="removeLinkField(this)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
    // Adiciona um novo campo de link
    function addLinkField() {
        const container = document.getElementById('link-fields');
        const template = document.getElementById('link-template');
        const clone = template.content.cloneNode(true);
        container.appendChild(clone);
    }
    
    // Remove um campo de link
    function removeLinkField(button) {
        const field = button.closest('.link-field');
        if (field) {
            field.remove();
        }
    }
    
    // Adiciona um campo vazio ao carregar a página se não houver campos
    document.addEventListener('DOMContentLoaded', function() {
        const linkFields = document.querySelectorAll('.link-field');
        if (linkFields.length === 0) {
            addLinkField();
        }
    });
</script>
@endpush
