@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center">
        <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15l-3-3m0 0l3-3m-3 3h6" />
        </svg>
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Sua Biblioteca Pessoal</h2>
        <p class="mt-2 text-lg text-gray-600">Faça login para acessar sua biblioteca pessoal e gerenciar sua coleção de mangás.</p>
        
        <div class="mt-8 flex justify-center space-x-4">
            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Entrar
            </a>
            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Criar Conta
            </a>
        </div>
        
        <div class="mt-12">
            <h3 class="text-lg font-medium text-gray-900">O que você pode fazer com sua biblioteca?</h3>
            <div class="mt-6 grid grid-cols-1 gap-8 sm:grid-cols-3">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-medium text-gray-900">Adicione mangás</h4>
                        <p class="mt-2 text-base text-gray-500">Mantenha um registro dos mangás que você está lendo ou planeja ler.</p>
                    </div>
                </div>
                
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-medium text-gray-900">Acompanhe seu progresso</h4>
                        <p class="mt-2 text-base text-gray-500">Marque os capítulos que você já leu e acompanhe seu progresso.</p>
                    </div>
                </div>
                
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-medium text-gray-900">Favoritos</h4>
                        <p class="mt-2 text-base text-gray-500">Marque seus mangás favoritos para encontrá-los facilmente.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
