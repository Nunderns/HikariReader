@props(['notification'])

<div class="flex items-start px-4 py-3 hover:bg-gray-50">
    <div class="flex-shrink-0">
        @php
            $type = str_replace('App\\Notifications\\', '', $notification->type);
            $type = strtolower($type);
        @endphp
        
        @if(str_contains($type, 'manganotification'))
            @if(isset($notification->data['type']) && str_contains($notification->data['type'], 'created'))
                <div class="p-2 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-plus-circle"></i>
                </div>
            @else
                <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-edit"></i>
                </div>
            @endif
        @else
            <div class="p-2 rounded-full bg-gray-100 text-gray-600">
                <i class="fas fa-bell"></i>
            </div>
        @endif
    </div>
    <div class="ml-3 flex-1 min-w-0">
        <div class="flex justify-between">
            <p class="text-sm font-medium text-gray-900 truncate">
                {{ $notification->data['title'] ?? 'Nova notificação' }}
            </p>
            <span class="text-xs text-gray-400 ml-2 whitespace-nowrap">
                {{ $notification->created_at->diffForHumans() }}
            </span>
        </div>
        <p class="text-sm text-gray-500">
            {{ $notification->data['message'] ?? 'Novo evento no sistema' }}
        </p>
        
        @if(isset($notification->data['data']['title']))
            <div class="mt-1 text-xs text-gray-600 bg-gray-50 p-2 rounded">
                {{ $notification->data['data']['title'] }}
            </div>
        @endif
    </div>
    @if(!$notification->read())
        <div class="ml-2">
            <span class="h-2 w-2 rounded-full bg-blue-500 block"></span>
        </div>
    @endif
</div>
