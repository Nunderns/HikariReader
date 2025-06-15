@extends('layouts.auth')

@section('title', 'Recuperar senha')

@section('content')
<div class="auth-form">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Esqueceu sua senha?</h1>
        <p class="text-gray-600">Digite seu email para receber um link de recuperação</p>
    </div>

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

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" name="email" type="email" required class="auth-input" placeholder="Email">
        </div>

        <div class="mt-6">
            <button type="submit" class="auth-button w-full">
                Enviar link de recuperação
            </button>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                « Voltar para login
            </a>
        </div>
    </form>
</div>
@endsection
