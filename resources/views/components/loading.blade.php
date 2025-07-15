@props([
    'size' => 'md',
    'color' => 'indigo',
    'text' => null
])

@php
    $sizes = [
        'xs' => 'h-4 w-4 border-2',
        'sm' => 'h-6 w-6 border-2',
        'md' => 'h-8 w-8 border-2',
        'lg' => 'h-12 w-12 border-4',
        'xl' => 'h-16 w-16 border-4',
    ][$size];
    
    $colors = [
        'gray' => 'border-gray-200 border-t-gray-600',
        'red' => 'border-red-200 border-t-red-600',
        'yellow' => 'border-yellow-200 border-t-yellow-600',
        'green' => 'border-green-200 border-t-green-600',
        'blue' => 'border-blue-200 border-t-blue-600',
        'indigo' => 'border-indigo-200 border-t-indigo-600',
        'purple' => 'border-purple-200 border-t-purple-600',
        'pink' => 'border-pink-200 border-t-pink-600',
    ][$color];
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center space-y-2']) }}>
    <div class="animate-spin rounded-full {{ $sizes }} {{ $colors }}"></div>
    @if($text)
        <p class="text-sm text-gray-600">{{ $text }}</p>
    @endif
</div>
