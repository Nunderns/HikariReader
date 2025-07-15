@props([
    'type' => 'info',
    'dismissible' => true,
    'class' => ''
])

@php
    $colors = [
        'success' => 'bg-green-50 border-green-400 text-green-700',
        'error' => 'bg-red-50 border-red-400 text-red-700',
        'warning' => 'bg-yellow-50 border-yellow-400 text-yellow-700',
        'info' => 'bg-blue-50 border-blue-400 text-blue-700',
    ][$type];
    
    $icons = [
        'success' => 'check-circle',
        'error' => 'exclamation-circle',
        'warning' => 'exclamation-triangle',
        'info' => 'information-circle',
    ][$type];
@endphp

<div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" {{ $attributes->merge(['class' => "border-l-4 p-4 {$colors} {$class}"]) }}>
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-{{ $icons }} h-5 w-5"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm">
                {{ $slot }}
            </p>
        </div>
        @if($dismissible)
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button @click="show = false" type="button" class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $type === 'success' ? 'text-green-500 hover:bg-green-100 focus:ring-offset-green-50 focus:ring-green-600' : ($type === 'error' ? 'text-red-500 hover:bg-red-100 focus:ring-offset-red-50 focus:ring-red-600' : ($type === 'warning' ? 'text-yellow-500 hover:bg-yellow-100 focus:ring-offset-yellow-50 focus:ring-yellow-600' : 'text-blue-500 hover:bg-blue-100 focus:ring-offset-blue-50 focus:ring-blue-600')) }}">
                        <span class="sr-only">Fechar</span>
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
