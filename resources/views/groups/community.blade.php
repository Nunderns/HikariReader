@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8">Grupos da Comunidade</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($groups as $group)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="{{ $group->avatar_url ?? asset('images/default-avatar.png') }}" 
                                 alt="{{ $group->name }}" 
                                 class="w-12 h-12 rounded-full">
                            <h2 class="text-lg font-semibold">
                                <a href="{{ route('groups.show', $group->slug) }}" class="hover:text-blue-600">
                                    {{ $group->name }}
                                </a>
                            </h2>
                        </div>
                        <p class="text-gray-600 mb-4">
                            {{ Str::limit($group->description, 100) }}
                        </p>
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <span>{{ $group->users->count() }} membros</span>
                            <span>•</span>
                            <span>{{ $group->mangas->count() }} mangás</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $groups->links() }}
        </div>
    </div>
@endsection
