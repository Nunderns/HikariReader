@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-800 mb-6">Meu Perfil</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-lg font-medium text-gray-700">Informações Pessoais</h2>
                        <div class="mt-4 space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nome</p>
                                <p class="mt-1 text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="mt-1 text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Membro desde</p>
                                <p class="mt-1 text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="text-lg font-medium text-gray-700">Estatísticas</h2>
                        <div class="mt-4 space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-500">Mangás na biblioteca</p>
                                <p class="mt-1 text-2xl font-bold text-indigo-600">0</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-500">Capítulos lidos</p>
                                <p class="mt-1 text-2xl font-bold text-indigo-600">0</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h2 class="text-lg font-medium text-gray-700 mb-4">Ações</h2>
                    <div class="flex space-x-4">
                        <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                            Editar Perfil
                        </a>
                        <a href="{{ route('password.change') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition">
                            Alterar Senha
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
