@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-8">Atualizações Recentes</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recentUpdates as $update)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4">
                        <h2 class="text-lg font-semibold mb-2">
                            <a href="{{ route('manga.show', $update->manga->slug) }}" class="hover:text-blue-600">
                                {{ $update->title }}
                            </a>
                        </h2>
                        <p class="text-gray-600 text-sm mb-2">
                            {{ $update->manga->title }}
                        </p>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <span>Por {{ $update->user->name }}</span>
                            <span>•</span>
                            <span>{{ $update->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $recentUpdates->links() }}
        </div>
    </div>
@endsection
