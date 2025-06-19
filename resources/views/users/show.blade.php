@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Detalhes do Usuário</h1>
        <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-800">
            &larr; Voltar para a lista
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row gap-6">
                <div class="flex-shrink-0">
                    <div class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center text-4xl font-bold text-gray-600">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                    
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Cadastrado em</p>
                            <p class="text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Última atualização</p>
                            <p class="text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tipo de conta</p>
                            <p class="text-gray-900">
                                @if($user->is_admin)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Administrador
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Usuário
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @can('update', $user)
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 flex justify-end">
            <a href="#" class="text-blue-600 hover:text-blue-800 mr-4">Editar</a>
            <form action="#" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800" 
                        onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                    Excluir
                </button>
            </form>
        </div>
        @endcan
    </div>
</div>
@endsection
