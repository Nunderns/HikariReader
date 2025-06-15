@extends('layouts.auth')

@section('title', 'Entrar')

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

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" name="email" type="email" required class="auth-input" placeholder="Email">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
            <input id="password" name="password" type="password" required class="auth-input" placeholder="Senha">
        </div>

        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                    Lembrar de mim
                </label>
            </div>

            <div class="text-sm">
                <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    Esqueceu sua senha?
                </a>
            </div>
        </div>

        <div>
            <button type="submit" class="auth-button w-full">
                Entrar
            </button>
        </div>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Não tem uma conta? <a href="{{ route('register') }}" class="auth-link">Criar conta</a>
            </p>
        </div>
    </form>
</div>
@endsection
