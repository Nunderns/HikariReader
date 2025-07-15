@props([
    'title' => null,
    'headerAction' => null,
    'footer' => null,
    'padding' => 'p-6',
    'headerPadding' => 'px-6 py-4',
    'footerPadding' => 'px-6 py-3',
    'class' => '',
])

<div {{ $attributes->merge(['class' => "bg-white rounded-lg shadow overflow-hidden {$class}"]) }}>
    @if($title || $headerAction)
        <div class="border-b border-gray-200 {{ $headerPadding }}">
            <div class="flex items-center justify-between">
                @if($title)
                    <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
                @endif
                
                @if($headerAction)
                    <div class="flex-shrink-0">
                        {{ $headerAction }}
                    </div>
                @endif
            </div>
        </div>
    @endif
    
    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
    
    @if($footer)
        <div class="bg-gray-50 border-t border-gray-200 {{ $footerPadding }}">
            {{ $footer }}
        </div>
    @endif
</div>
