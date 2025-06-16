@extends('layouts.auth')

@section('title', 'Criar conta')

@section('content')
<div class="auth-form">
    @if(session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">Error!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
            <input id="name" name="name" type="text" required class="auth-input" placeholder="Nome">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" name="email" type="email" required class="auth-input" placeholder="Email">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
            <input id="password" name="password" type="password" required class="auth-input" placeholder="Senha">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Senha</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="auth-input" placeholder="Confirmar Senha">
        </div>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Já tem uma conta? <a href="{{ route('login') }}" class="auth-link">Entrar</a>
            </p>
        </div>

        <div class="mt-6">
            <button type="submit" class="auth-button w-full">
                Criar conta
            </button>
        </div>
    </form>
</div>
@endsection
