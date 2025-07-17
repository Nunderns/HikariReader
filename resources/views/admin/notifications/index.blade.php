@extends('admin.layouts.app')

@section('title', 'Notificações')

@section('header', 'Minhas Notificações')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Notificações
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Suas notificações mais recentes
                </p>
            </div>
            <div>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-check-double mr-1"></i> Marcar todas como lidas
                        </button>
                    </form>
                @endif
                
                @if(auth()->user()->notifications->count() > 0)
                    <form action="{{ route('notifications.destroy-all') }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Tem certeza que deseja remover todas as notificações?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="fas fa-trash-alt mr-1"></i> Limpar todas
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    
    <div class="divide-y divide-gray-200">
        @forelse($notifications as $notification)
            <div class="px-4 py-4 sm:px-6 hover:bg-gray-50 {{ $notification->read() ? 'bg-white' : 'bg-blue-50' }}">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @switch($notification->type)
                            @case('manga_added')
                                <div class="p-2 rounded-full bg-indigo-100 text-indigo-600">
                                    <i class="fas fa-book"></i>
                                </div>
                                @break
                            @case('user_registered')
                                <div class="p-2 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                @break
                            @default
                                <div class="p-2 rounded-full bg-gray-100 text-gray-600">
                                    <i class="fas fa-bell"></i>
                                </div>
                        @endswitch
                    </div>
                    <div class="ml-4 flex-1 min-w-0">
                        <div class="flex justify-between">
                            <a href="{{ $notification->data['url'] ?? '#' }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600 truncate">
                                {{ $notification->data['title'] ?? 'Nova notificação' }}
                            </a>
                            <div class="ml-2 flex-shrink-0 flex">
                                <span class="text-xs text-gray-500">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                                @if(!$notification->read())
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        Nova
                                    </span>
                                @endif
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $notification->data['message'] ?? 'Novo evento no sistema' }}
                        </p>
                        @if(isset($notification->data['data']))
                            <div class="mt-2 text-xs text-gray-500 bg-gray-50 p-2 rounded">
                                <pre class="whitespace-pre-wrap">{{ json_encode($notification->data['data'], JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        @endif
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-500 focus:outline-none" onclick="return confirm('Tem certeza que deseja remover esta notificação?')">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="px-4 py-12 text-center">
                <i class="far fa-bell-slash text-4xl text-gray-400 mb-3"></i>
                <p class="text-gray-500">Nenhuma notificação encontrada.</p>
            </div>
        @endforelse
    </div>
    
    @if($notifications->hasPages())
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Marcar notificação como lida ao clicar
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            const notificationId = this.closest('[data-notification-id]')?.dataset.notificationId;
            if (notificationId) {
                markAsRead(notificationId);
            }
        });
    });
    
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ _method: 'PATCH' })
        });
    }
</script>
@endpush
@endsection
